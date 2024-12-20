<?php
include '../cors/cors.php';
include '../db/db.php';
include './util.script.php';
session_start();
$method = $_SERVER["REQUEST_METHOD"];
$service = $_SERVER["HTTP_SERVICE"];

// if (!isset($_SESSION['username'])) {
//     echo json_encode(['success' => false, 'message' => 'Unauthorised']);

// } else {
$subtotal = 0;
$form_data = json_decode(file_get_contents("php://input"), true);
$purchasenumber = 'P' . generateCode(9);
$purchasedDate = null;

if ($method === 'POST' && $service === 'addPurchase') {
    try {
        foreach ($form_data['products'] as $row) {
            // Check if all required fields are provided
            if (empty($row['date']) || empty($row['quantity']) || empty($row['batchId']) || empty($row['unitPrice']) || empty($row['total']) || empty($row['medicineName']) || empty($form_data['paymentMode'])) {
                echo json_encode(['message' => 'Please All Fields are required']);
                return;
            } else {
                // Assuming you want to get the date from the first product
                if (empty($row["purchasedDate"])) {
                    $purchasedDate = date('Y-m-d', strtotime($form_data['purchasedDate']));
                }
                $subtotal += $row['total']; // Accumulate the subtotal
            }
        }

        // Corrected SQL syntax
        $stmt = $pdo->prepare("INSERT INTO purchases (products, date, subtotal, paymentmode, purchasenumber) VALUES (:products, :date, :subtotal, :paymentmode, :purchasenumber)");

        // Encode products as JSON
        $products = json_encode($form_data['products']);
        $paymentMode = $form_data['paymentMode'];
        // Bind parameters
        $stmt->bindParam(':products', $products);
        $stmt->bindParam(':date', $purchasedDate); // Use the purchased date
        $stmt->bindParam(':subtotal', $subtotal);
        $stmt->bindParam(':paymentmode', $paymentMode);
        $stmt->bindParam(':purchasenumber', $purchasenumber);

        // Execute the statement and check for success
        if ($stmt->execute()) {
             $userId = returnUserId();
            $insertIntoActivity = insertIntoActivity($pdo, 'New purchase activity', $userId);

            if (!$insertIntoActivity) {
                echo json_encode(['success' => false, 'message' => 'Something happened at activity insertion']);
                return;
            }
            echo json_encode(['success' => true, 'message' => 'Purchased successfully', $userId]);
            return;
        } else {
            echo json_encode(['success' => false, 'message' => 'Purchase failed. Please try again.']);
            return;
        }

    } catch (PDOException $e) {
        echo 'Something happened ' . $e->getMessage();
        return;
    }


} else if ($method === 'GET' && 'fetchPurchases') {

    $page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
    $items_per_page = 10;
    $offset = ($page - 1) * $items_per_page;

    $result = $pdo->query("SELECT COUNT(*) as count FROM purchases");
    $total_items = $result->fetch()['count'];


    $stmt = $pdo->prepare("SELECT * FROM purchases ORDER BY DATE(date) DESC LIMIT $offset, $items_per_page");

    if ($stmt->execute()) {

        $purchases = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (!empty($purchases)) {
            echo json_encode([
                'success' => true,
                'purchases' => $purchases,
                'total_items' => $total_items,
                'items_per_page' => $items_per_page,
                'current_page' => $page
            ]);
            return;
        } else {
            echo json_encode(['success' => true, 'purchases' => []]);
            return;
        }
    }


} else if ($method === 'DELETE' && $service === 'deletePurchase') {
    $id = $form_data['id'];

    try {
        $stmt = $pdo->prepare("DELETE FROM purchases WHERE id = :id");

        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        if ($stmt->execute()) {

            (int) $userId = returnUserId();
            $insertIntoActivity = insertIntoActivity($pdo, 'Purchase deletion activity', $userId);

            if (!$insertIntoActivity) {
                echo json_encode(['success' => false, 'message' => 'Something happened at activity insertion', $user]);
                return;
            }
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

} else if ($method === 'PUT' && $service === 'editPurchase') {


    $products = $form_data['products'] ?? '';
    $id = $form_data['id'] ?? '';
    $newSubTotal = $form_data['newSubTotal'];
    $id = (int) $id;

    try {
        $stmt = $pdo->query("SELECT * FROM purchases WHERE id = $id  ");

        $purchasedb = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!empty($purchasedb)) {
            $sql = "UPDATE purchases SET  products = :products, subtotal = :subNewTotal WHERE id = :id";

            $stmt = $pdo->prepare($sql);

            $subTotal = 0;

            foreach (json_decode($form_data['products']) as $product) {
                $subtotal += $product->total;
            }
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->bindParam(':products', $products);
            $stmt->bindParam(':subNewTotal', $subtotal, PDO::PARAM_INT);

            if ($stmt->execute()) {
                (int) $userId = returnUserId();
                $insertIntoActivity = insertIntoActivity($pdo, 'Purchase update activity', $userId);

                if (!$insertIntoActivity) {
                    echo json_encode(['success' => false, 'message' => 'Something happened at activity insertion', $user]);
                    return;
                }
                echo json_encode(['success' => true, 'message' => 'Updated']);
                return;
            } else {
                echo json_encode(['success' => false, 'message' => 'Something happened']);
                return;
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Purchase does not exist']);
            return;
        }
    } catch (PDOException $e) {
        echo 'Something happened ' . $e->getMessage();
        return;
    }

}
