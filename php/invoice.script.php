<?php
session_start();
include '../cors/cors.php';
include '../db/db.php';
include './util.script.php';
$method = $_SERVER["REQUEST_METHOD"];
$service = $_SERVER["HTTP_SERVICE"];

// if (!isset($_SESSION['username'])) {
//     echo json_encode(['success' => false, 'message' => 'Unauthorised']);

// } else {
$subtotal = 0;
$form_data = json_decode(file_get_contents("php://input"), true);
$invoiceDate = null;
$availbleQuantity = 0;
$quantitySold = 0;
$totalProfit = 0;
(string) $invoiceNumber = 'INV' . generateCode(7);
$username = $_SESSION['username'] ?? '';
if ($method === 'POST' && $service === 'addInvoice') {

    try {
        $pdo->beginTransaction(); // Start a transaction
        foreach ($form_data['products'] as $row) {
            // Validate fields
            if (
                empty($row['unit']) || empty($row['quantity']) || empty($row['category']) || empty($row['unitPrice']) || empty($row['total']) || empty($row['item_information']) || empty($form_data['invoiceDate'])
                || empty($form_data['paymentMode']) || empty($form_data['amountPaid']) || empty($form_data['change'])
            ) {
                echo json_encode(['success' => false, 'message' => 'All fields are required']);
                return;
            }

            // Fetch medicine data
            $stmt = $pdo->prepare("SELECT * FROM medicines WHERE medicinename = :medicinename");
            $stmt->bindParam(':medicinename', $row['item_information']);
            $stmt->execute();
            $medicine = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$medicine) {
                echo json_encode(['success' => false, 'message' => 'This product is not available in stock.']);
                return;
            }
            if ($medicine['quantity'] < $row['quantity']) {
                echo json_encode(['success' => false, 'message' => 'Requested quantity exceeds available stock.']);
                return;
            }

            $availbleQuantity = $medicine['quantity'] - $row['quantity'];
            $quantitySold = $medicine['qtysold'] + $row['quantity'];
            $unitProfit = $row['unitPrice'] - $medicine['medicinecostunitprice'];
            $totalProfit += $unitProfit * $row['quantity'];

            // Update medicines table
            $updateStmt = $pdo->prepare("UPDATE medicines SET quantity = :quantity, qtysold = :quantitySold WHERE medicinename = :medicinename");
            $updateStmt->bindParam(':quantity', $availbleQuantity, PDO::PARAM_INT);
            $updateStmt->bindParam(':quantitySold', $quantitySold, PDO::PARAM_INT);
            $updateStmt->bindParam(':medicinename', $row['item_information'], PDO::PARAM_STR);
            $updateStmt->execute();

            $subtotal += $row['total'];
            $invoiceDate = $form_data["invoiceDate"] ? date('Y-m-d', strtotime($form_data['invoiceDate'])) : null;
        }

        $paymentMode = $form_data['paymentMode'];
        $form_data['invoicenumber'] = $invoiceNumber;
        $form_data['subtotal'] = $subtotal;
        // Insert invoice
        $products = json_encode($form_data['products']);
        $amountPaid = $form_data['amountPaid'];
        $change = $form_data['change'];
        $stmt = $pdo->prepare("INSERT INTO invoices (dateofsale, items, actiontaker, subtotal, totalprofit, invoicenumber, paymentmode, amountpaid, balance) 
                                   VALUES (:invoiceDate, :items, :actiontaker, :subtotal, :totalprofit, :invoicenumber, :paymentMode, :amountpaid, :balance)");
        $stmt->bindParam(':invoiceDate', $invoiceDate);
        $stmt->bindParam(':items', $products);
        $stmt->bindParam(':actiontaker', $username);
        $stmt->bindParam(':subtotal', $subtotal);
        $stmt->bindParam(':totalprofit', $totalProfit);
        $stmt->bindParam(':invoicenumber', $invoiceNumber);
        $stmt->bindParam(':paymentMode', $paymentMode);
        $stmt->bindParam(':amountpaid', $amountPaid);
        $stmt->bindParam(':balance', $change);

        if ($stmt->execute()) {
            $pdo->commit();

            (int) $userId = returnUserId();
            $insertIntoActivity = insertIntoActivity($pdo, 'New invoice activity', $userId);

            if (!$insertIntoActivity) {
                echo json_encode(['success' => false, 'message' => 'Something happened at activity insertion', $user]);
                return;
            }
            echo json_encode(['success' => true, 'message' => 'Invoice added successfully', 'data' => $form_data]);
            return;
        } else {
            throw new PDOException("Failed to add invoice");
        }
    } catch (PDOException $e) {
        $pdo->rollBack();
        echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
    }


} else if ($method === 'GET' && $service === 'fetchInvoices') {

    try {
        $page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
        $items_per_page = 10;
        $offset = ($page - 1) * $items_per_page;

        $result = $pdo->query("SELECT COUNT(*) as count FROM invoices");
        $total_items = $result->fetch()['count'];

        $stmt = $pdo->prepare("SELECT * FROM invoices ORDER BY DATE(dateofsale) DESC  LIMIT :offset, :items_per_page");
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->bindParam(':items_per_page', $items_per_page, PDO::PARAM_INT);
        $stmt->execute();

        $invoices = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($invoices as &$invoice) {
            $invoiceItems = json_decode($invoice['items']);
            foreach ($invoiceItems as $item) {
                $item->oldQuantity = $item->quantity;
            }
            $invoice['items'] = json_encode($invoiceItems);
        }
        unset($invoice);
        echo json_encode([
            'success' => true,
            'invoices' => $invoices,
            'total_items' => $total_items,
            'items_per_page' => $items_per_page,
            'current_page' => $page
        ]);
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Error fetching invoices: ' . $e->getMessage()]);
    }


} else if ($method === 'DELETE' && $service === 'deleteInvoice') {
    $form_data = json_decode(file_get_contents(filename: "php://input"), true);
    $id = $form_data['id'];

    try {
        $fetchStmt = $pdo->prepare("SELECT * FROM invoices WHERE id = :id");
        $fetchStmt->bindParam(':id', $id, PDO::PARAM_INT);
        $fetchStmt->execute();

        $fetchResult = $fetchStmt->fetch(PDO::FETCH_ASSOC);
        $fetchResultItems = json_decode($fetchResult['items']);

        foreach ($fetchResultItems as $item) {
            $quantity = $item->quantity;
            $medicineData = fetchMedicineData($pdo, $item->item_information);
            $medicineDataQuantity = $medicineData['quantity'] + $quantity;
            $medicineDataQuantitySold = $medicineData['qtysold'] - $quantity;

            $stmt = $pdo->prepare("UPDATE medicines SET quantity = :quantity, qtysold = :qtysold WHERE medicinename = :medicinename");
            $stmt->bindParam(':quantity', $medicineDataQuantity);
            $stmt->bindParam(':qtysold', $medicineDataQuantitySold);
            $stmt->bindParam(':medicinename', $item->item_information);

            $stmt->execute();
        }
        $stmt = $pdo->prepare("DELETE FROM invoices WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        if ($stmt->execute()) {
            (int) $userId = returnUserId();
            $insertIntoActivity = insertIntoActivity($pdo, 'Invoice deletion activity', $userId);

            if (!$insertIntoActivity) {
                echo json_encode(['success' => false, 'message' => 'Something happened at activity insertion', $user]);
                return;
            }
            echo json_encode(['success' => true, 'message' => 'Invoice deleted successfully']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to delete invoice']);
        }
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
    }

} else if ($method === 'PUT' && $service === 'editInvoice') {

    $form_data = json_decode(file_get_contents(filename: "php://input"), true);

    $items = $form_data['items'] ?? '';
    $id = $form_data['id'] ?? '';
    $newSubTotal = $form_data['newSubTotal'];
    $items = json_decode($items);
    $profitReCalculated = 0;
    $id = (int) $id;
    $itemToDelete = isset($form_data['itemToDelete']) ? $form_data['itemToDelete'] : '';


    try {
        foreach ($items as $item) {

            if (isset($item->oldQuantity)) {

                if ($item->quantity > $item->oldQuantity) {
                    $quantitySub = $item->quantity - $item->oldQuantity;

                    $medicineData = fetchMedicineData($pdo, $item->item_information);
                    if ($medicineData) {
                        $medicinename = $medicineData['medicinename'];
                        $quantity = $medicineData['quantity'];
                        $qtysold = $medicineData['qtysold'] + $quantitySub;

                        $newQuantity = $quantity - $quantitySub;

                        // $directoryPath = "/var/pharmacy/";
                        // $filePath = $directoryPath . "logs-details.txt";


                        //  var_dump($totalProfit, $medicineData->unitprofit, $item->quantity );
                        $updateInvoice = updateMedicineData($newQuantity, $medicinename, $pdo, $qtysold);

                    } else {
                        echo json_encode(['success' => false, 'medicine' => 'something happened']);
                        return;
                    }

                } else if ($item->quantity < $item->oldQuantity) {
                    $quantitySub = $item->oldQuantity - $item->quantity;
                    $medicineData = fetchMedicineData($pdo, $item->item_information);
                    if ($medicineData) {

                        $medicinename = $medicineData['medicinename'];
                        $quantity = $medicineData['quantity'];
                        $qtysold = $medicineData['qtysold'] - $quantitySub;

                        $newQuantity = $quantity + $quantitySub;

                        $updateMedicineData = updateMedicineData($newQuantity, $medicinename, $pdo, $qtysold);
                    }
                } else if ($item->oldQuantity === $item->quantity && $itemToDelete === $item->productId) {
                    $medicineData = fetchMedicineData($pdo, $item->item_information);

                    if ($medicineData) {

                        $medicinename = $medicineData['medicinename'];
                        $quantity = $medicineData['quantity'];
                        $qtysold = $medicineData['qtysold'] - $item->quantity;

                        $newQuantity = $quantity + $item->quantity;

                        $items = array_values(array_filter($items, function ($obj) use ($itemToDelete) {
                            return $obj->productId !== $itemToDelete;
                        }));

                        $updateMedicineData = updateMedicineData($newQuantity, $medicinename, $pdo, $qtysold);

                    }
                }

            } else {

                $medicineData = fetchMedicineData($pdo, $item->item_information);

                if ($medicineData) {

                    $medicinename = $medicineData['medicinename'];
                    $quantity = $medicineData['quantity'];
                    $qtysold = $medicineData['qtysold'] + $item->quantity;

                    $newQuantity = $quantity - $item->quantity;

                    $updateMedicineData = updateMedicineData($newQuantity, $medicinename, $pdo, $qtysold);
                }
            }
            $medicineData = fetchMedicineData($pdo, $item->item_information);

            if ($medicineData) {
                $medicinename = $medicineData['medicinename'];
                $quantity = $medicineData['quantity'];
                // $unitprofit = $medicineData['unitprofit'];
                $profitReCalculated += ($medicineData['unitprofit'] ?? 0) * $item->quantity;
            }

        }
        $stmt = $pdo->query("SELECT * FROM invoices WHERE id = $id  ");

        $invoicedb = $stmt->fetch(PDO::FETCH_ASSOC);
        $items = json_encode($items);
        if (!empty($invoicedb)) {
            $sql = "UPDATE invoices SET items = :products, subtotal = :newSubTotal, totalprofit = :totalprofit WHERE id = :id";

            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->bindParam(':products', $items);
            $stmt->bindParam(':newSubTotal', $newSubTotal);
            $stmt->bindParam(':totalprofit', $profitReCalculated);
            if ($stmt->execute()) {
                writeDynamicToFile("/var/pharmacy/", ['success' => true, 'message' => 'Updated', 'data' => $profitReCalculated]);
                (int) $userId = returnUserId();
                $insertIntoActivity = insertIntoActivity($pdo, 'Invoice update activity', $userId);

                if (!$insertIntoActivity) {
                    echo json_encode(['success' => false, 'message' => 'Something happened at activity insertion', $user]);
                    return;
                }
                echo json_encode(['success' => true, 'message' => 'Updated', 'data' => $totalProfit]);
                return;
            } else {
                echo json_encode(['success' => false, 'message' => 'Something happened']);
                return;
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Invoice does not exist']);
            return;
        }
    } catch (PDOException $e) {
        echo 'Something happened ' . $e->getMessage();
        return;
    }

} else if ($method === 'GET' && $service === 'getRecentSales') {

    $page = isset($_GET['page']) ? $_GET['page'] : 1;
    $items_per_page = 5;
    $offset = ($page - 1) * $items_per_page;
    date_default_timezone_set('UTC');

    $today = date('Y-m-d');
    $result = $pdo->query("SELECT COUNT(*) AS count FROM invoices WHERE DATE(created_at) = '$today'");

    $total_items = $result->fetch()['count'];

    $stmt = $pdo->prepare("SELECT * FROM invoices WHERE DATE(created_at) = '$today' ORDER BY DATE(created_at)  DESC  LIMIT :offset, :items_per_page");
    $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
    $stmt->bindParam(':items_per_page', $items_per_page, PDO::PARAM_INT);
    $stmt->execute();


    $todaySales = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode([
        'success' => true,
        'todaySales' => $todaySales,
        'total_items' => $total_items,
        'items_per_page' => $items_per_page,
        'current_page' => $page
    ]);
}
