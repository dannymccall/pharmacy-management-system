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
(string) $invoiceNumber = 'INV';
if ($method === 'POST' && $service === 'addInvoice') {
    try {
        foreach ($form_data['products'] as $row) {
            // Check if all required fields are provided
            if (empty($row['unit']) || empty($row['quantity']) || empty($row['category']) || empty($row['unitPrice']) || empty($row['total']) || empty($row['item_information']) || empty($form_data['invoiceDate'])) {
                echo json_encode(['message' => 'Please All Fields are required']);
                return;
            } else {
                $sql = "SELECT * FROM medicines WHERE medicinename = :medicinename";
                $stmt = $pdo->prepare($sql);
                $item_information = $row['item_information'];
                $stmt->bindParam(':medicinename', $item_information);
                if ($stmt->execute()) {
                    $medicine = $stmt->fetchAll(PDO::FETCH_ASSOC);

                    $fetchedQuantity = null;
                    foreach ($medicine as $med) {
                        if ($med['quantity'] < $row['quantity']) {
                            echo json_encode(['success' => false, 'message' => 'The quantity requested exceeds our available stock. Please review and adjust your quantity before trying again.']);
                            return;
                        }

                        $availbleQuantity = $med['quantity'] - $row['quantity'];
                        $quantitySold = $med['qtysold'] + $row['quantity'];
                        $unitProfit = $row['unitPrice'] - $med['medicinecostunitprice'];
                        $totalProfit += $unitProfit * $row['quantity'];

                        $sql = "UPDATE medicines SET quantity = :quantity, qtysold = :quantitySold WHERE medicinename = :item_information";
                        $stmt = $pdo->prepare($sql);
                        $stmt->bindParam(':quantity', $availbleQuantity, PDO::PARAM_INT);
                        $stmt->bindParam(':quantitySold', $quantitySold, PDO::PARAM_INT);
                        $stmt->bindParam(':item_information', $item_information, PDO::PARAM_STR);

                        $stmt->execute();
                    }
                    // echo json_encode(['success' => true, $quantitySold, $totalProfit ]);
                }

                // Assuming you want to get the date from the first product
                if (isset($form_data["invoiceDate"])) {
                    $invoiceDate = date('Y-m-d', strtotime($form_data['invoiceDate']));
                }

                $subtotal += $row['total']; // Accumulate the subtotal
            }
        }

        (string) $generatedCode = generateCode(7);
        $invoiceNumber .= $generatedCode;

        (string) $username = '';
        if (isset($_SESSION['username']))
            $username = $_SESSION['username'];
        // Corrected SQL syntax
        $stmt = $pdo->prepare("INSERT INTO invoices (dateofsale, items,actiontaker, subtotal, totalprofit, invoicenumber) 
                VALUES (:invoiceDate, :items, :actiontaker, :subtotal, :totalprofit, :invoicenumber)");

        // Encode products as JSON
        $products = json_encode($form_data['products']);


        // Bind parameters
        $stmt->bindParam(':invoiceDate', $invoiceDate);
        $stmt->bindParam(':items', $products); // Use the purchased date
        $stmt->bindParam(':subtotal', $subtotal);
        $stmt->bindParam(':actiontaker', $username);
        $stmt->bindParam(':subtotal', $subtotal);
        $stmt->bindParam(':totalprofit', $totalProfit);
        $stmt->bindParam(':invoicenumber', $invoiceNumber);

        // Execute the statement and check for success
        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'Invoice added successfully', $form_data['invoiceDate']]);
            return;
        } else {
            echo json_encode(['success' => false, 'message' => 'Invoice adding. Please try again.']);
            return;
        }

    } catch (PDOException $e) {
        echo 'Something happened ' . $e->getMessage();
        return;
    }


} else if ($method === 'GET' && 'fetchInvoices') {

    $page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
    $items_per_page = 5;
    $offset = ($page - 1) * $items_per_page;

    $result = $pdo->query("SELECT COUNT(*) as count FROM invoices");
    $total_items = $result->fetch()['count'];


    $stmt = $pdo->prepare("SELECT * FROM invoices LIMIT $offset, $items_per_page");

    if ($stmt->execute()) {

        $invoices = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($invoices as &$invoice) {
            $invoiceItems = json_decode($invoice['items']);

            foreach ($invoiceItems as $item) {
                $item->oldQuantity = $item->quantity;
            }

            $invoice['items'] = json_encode($invoiceItems);
        }
        unset($invoice); // Breaks reference with the last element


        if (!empty($invoices)) {
            echo json_encode([
                'success' => true,
                'invoices' => $invoices,
                'total_items' => $total_items,
                'items_per_page' => $items_per_page,
                'current_page' => $page,


            ]);
            return;
        } else {
            echo json_encode(['success' => true, 'invoices' => []]);
            return;
        }
    }


} else if ($method === 'DELETE' && $service === 'deleteInvoice') {
    $form_data = json_decode(file_get_contents(filename: "php://input"), true);
    $id = $form_data['id'];

    try {
        $stmt = $pdo->prepare("DELETE FROM invoices WHERE id = :id");

        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        if ($stmt->execute()) {

            echo json_encode(['success' => true, 'message' => 'Done']);
            return;
        } else {
            echo json_encode(['success' => false, 'message' => 'Something happened']);
            return;
        }

    } catch (PDOException $e) {
        echo 'Something happened ' . $e->getMessage();
        return;
    }

} else if ($method === 'PUT' && $service === 'editInvoice') {

    $form_data = json_decode(file_get_contents(filename: "php://input"), true);

    $items = $form_data['items'] ?? '';
    $id = $form_data['id'] ?? '';
    $newSubTotal = $form_data['newSubTotal'];
    $items = json_decode($items);
    $totalProfit = 0;
    $id = (int) $id;


    try {
        foreach ($items as $item) {
            if (isset($item->oldQuantity)) {

                if ($item->quantity > $item->oldQuantity) {
                    $quantitySub = $item->quantity - $item->oldQuantity;

                    $sql = "SELECT * FROM medicines WHERE medicinename = :item_information";
                    $stmt = $pdo->prepare($sql);
                    $stmt->bindParam(':item_information', $item->item_information);
                    if ($stmt->execute()) {
                        $medicinedb = $stmt->fetchAll(PDO::FETCH_ASSOC);

                        $medicinename = '';
                        $quantity = 0;
                        $qtysold = 0;
                        foreach ($medicinedb as $value) {
                            $medicinename = $value['medicinename'];
                            $quantity = $value['quantity'];
                            $qtysold = $value['qtysold'] + $quantitySub;
                        }

                        $newQuantity = $quantity - $quantitySub;

                        $updateInvoice = updateInvoice($newQuantity, $medicinename, $pdo, $qtysold);

                    } else {
                        echo json_encode(['success' => false, 'medicine' => 'something happened']);
                        return;
                    }

                } else if ($item->quantity < $item->oldQuantity) {
                    $quantitySub = $item->oldQuantity - $item->quantity;
                    $sql = "SELECT * FROM medicines WHERE medicinename = :item_information";
                    $stmt = $pdo->prepare($sql);
                    $stmt->bindParam(':item_information', $item->item_information);
                    if ($stmt->execute()) {
                        $medicinedb = $stmt->fetchAll(PDO::FETCH_ASSOC);

                        $medicinename = '';
                        $quantity = 0;
                        $qtysold = 0;
                        foreach ($medicinedb as $value) {
                            $medicinename = $value['medicinename'];
                            $quantity = $value['quantity'];
                            $qtysold = $value['qtysold'] - $quantitySub;
                        }
                        $newQuantity = $quantity + $quantitySub;

                        $updateInvoice = updateInvoice($newQuantity, $medicinename, $pdo, $qtysold);
                    }
                } else if ($item->oldQuantity === $item->quantity) {
                    $sql = "SELECT * FROM medicines WHERE medicinename = :item_information";
                    $stmt = $pdo->prepare($sql);
                    $stmt->bindParam(':item_information', $item->item_information);
                    if ($stmt->execute()) {
                        $medicinedb = $stmt->fetchAll(PDO::FETCH_ASSOC);
                        $medicinename = '';
                        $quantity = 0;
                        $qtysold = 0;
                        foreach ($medicinedb as $value) {
                            $medicinename = $value['medicinename'];
                            $quantity = $value['quantity'];
                            $qtysold = $value['quantity'] - $item->quantity;
                        }
                        $newQuantity = $quantity + $item->quantity;

                        $updateInvoice = updateInvoice($newQuantity, $medicinename, $pdo, $qtysold);

                    }
                } 
            
            }else{
                $sql = "SELECT * FROM medicines WHERE medicinename = :item_information";
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':item_information', $item->item_information);
                if ($stmt->execute()) {
                    $medicinedb = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    $medicinename = '';
                    $quantity = 0;
                    $qtysold = 0;
                    foreach ($medicinedb as $value) {
                        $medicinename = $value['medicinename'];
                        $quantity = $value['quantity'];
                        $qtysold = $value['qtysold'] + $item->quantity;
                    }
                    $newQuantity = $quantity - $item->quantity;

                    $updateInvoice = updateInvoice($newQuantity, $medicinename, $pdo, $qtysold);
                }
            }
            $sql = "SELECT * FROM medicines WHERE medicinename = :item_information";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':item_information', $item->item_information);

            if ($stmt->execute()) {
                $medicinedb = $stmt->fetchAll(PDO::FETCH_ASSOC);
                $medicinename = '';
                $quantity = 0;
                $unitprofit = 0;
                foreach ($medicinedb as $value) {
                    $medicinename = $value['medicinename'];
                    $quantity = $value['quantity'];
                    $unitprofit = $value['unitprofit'];
                    $totalProfit += $unitprofit * $item->quantity;
                }


            }

        }
        $stmt = $pdo->query("SELECT * FROM invoices WHERE id = $id  ");

        $invoicedb = $stmt->fetch(PDO::FETCH_ASSOC);
        $items = json_encode($items);
        if (!empty($invoicedb)) {
            $sql = "UPDATE invoices SET  items = :products, subtotal = :newSubTotal, totalprofit = :totalprofit WHERE id = :id";

            $stmt = $pdo->prepare($sql);

            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->bindParam(':products', $items);
            $stmt->bindParam(':newSubTotal', $newSubTotal);
            $stmt->bindParam(':totalprofit', $totalprofit, PDO::PARAM_INT);

            if ($stmt->execute()) {

                echo json_encode(['success' => true, 'message' => 'Updated', 'data' => $form_data]);
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

}