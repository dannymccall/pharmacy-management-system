<?php
include '../cors/cors.php';
include '../db/db.php';
include './util.script.php';
$method = $_SERVER["REQUEST_METHOD"];
$service = $_SERVER["HTTP_SERVICE"];

// if (!isset($_SESSION['username'])) {
//     echo json_encode(['success' => false, 'message' => 'Unauthorised']);

// } else {
    $form_data = json_decode(file_get_contents(filename: "php://input"), true);

if ($method === 'POST' && $service === 'addMedicine') {


    $medicinename = $form_data['medicinename'] ?? '';
    $medicineunit = $form_data['medicineunit'] ?? '';
    $medicinecategory = $form_data['medicinecategory'] ?? '';
    $medicinecostunitprice = $form_data['medicinecostunitprice'] ?? '';
    $medicinesellingunitprice = $form_data['medicinesellingunitprice'] ?? '';
    $quantity = $form_data['quantity'];


    if (
        !empty(trim($medicinename)) || !empty(trim($medicinecategory)) || !empty(trim($medicineunit)) &&
        !empty(trim($medicinecostunitprice)) || !empty(trim($medicinesellingunitprice)) && !empty(trim($quantity))
    ) {
        try {


            $stmt = $pdo->prepare("INSERT INTO medicines (medicinename, medicinecategory, medicineunit, medicinecostunitprice, medicinesellingunitprice, medicineid, quantity, unitprofit, collectedquantity) 
            VALUES(:medicinename, :medicinecategory, :medicineunit, :medicinecostunitprice, :medicinesellingunitprice, :medicineid, :quantity, :profit, :collectedquantity)");

            $medicineid = 'MED'; // Base of the medicine ID

            (string) $code = generateCode(7);
            $medicineid .= $code;

            $profit = (float) ($medicinesellingunitprice - $medicinecostunitprice);

            $unitProfit = (int) $medicinesellingunitprice - (int) $medicinecostunitprice;
            $stmt->bindParam(':medicinename', $medicinename, PDO::PARAM_STR);
            $stmt->bindParam(':medicinecategory', $medicinecategory, PDO::PARAM_STR);
            $stmt->bindParam(':medicineunit', $medicineunit, PDO::PARAM_STR);
            $stmt->bindParam(':medicinecostunitprice', $medicinecostunitprice, PDO::PARAM_STR);
            $stmt->bindParam(':medicinesellingunitprice', $medicinesellingunitprice, PDO::PARAM_STR);
            $stmt->bindParam(':medicineid', $medicineid, PDO::PARAM_STR);
            $stmt->bindParam(':quantity', $quantity, PDO::PARAM_INT);
            $stmt->bindParam(':profit', $profit, PDO::PARAM_INT);
            $stmt->bindParam(':collectedquantity', $quantity, PDO::PARAM_INT);
            if ($stmt->execute()) {

                (int) $userId = returnUserId();
                $insertIntoActivity = insertIntoActivity($pdo, 'New product activity', $userId);

                if (!$insertIntoActivity) {
                    echo json_encode(['success' => false, 'message' => 'Something happened at activity insertion', $user]);
                    return;
                }
                echo json_encode(['success' => true, 'message' => 'Medicine inserted successfully']);
                return;
            } else {
                echo json_encode(['success' => false, 'message' => 'Medicine insertion failed, something happened']);
                return;
            }
        } catch (PDOException $e) {
            echo 'Something happened ' . $e->getMessage();
            return;
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'All fields required']);
        return;
    }
} else if ($method === 'GET' && 'fetchMedicine') {

    (int) $page = null;

    $page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
    $items_per_page = 5;
    $offset = ($page - 1) * $items_per_page;

        $result = $pdo->query("SELECT COUNT(*) as count FROM medicines");
        $total_items = $result->fetch()['count'];


        $stmt = $pdo->prepare("SELECT * FROM medicines LIMIT $offset, $items_per_page");

        if ($stmt->execute()) {

            $medicines = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if (!empty($medicines)) {
                echo json_encode([
                    'success' => true,
                    'medicines' => $medicines,
                    'total_items' => $total_items,
                    'items_per_page' => $items_per_page,
                    'current_page' => $page
                ]);
                return;
            } else {
                echo json_encode(['success' => true, 'medicines' => []]);
                return;
            }
        

    } else {
        $stmt = $pdo->prepare("SELECT * FROM medicines");
        if ($stmt->execute()) {

            $medicines = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if (!empty($medicines)) {
                echo json_encode([
                    'success' => true,
                    'medicines' => $medicines,
                ]);
                return;
            } else {
                echo json_encode(['success' => true, 'medicines' => []]);
                return;
            }
        }
    }



} else if ($method === 'DELETE' && $service === 'deleteMedicine') {
    $id = $form_data['id'];

    try {
        $stmt = $pdo->prepare("DELETE FROM medicines WHERE id = :id");

        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        if ($stmt->execute()) {

            (int) $userId = returnUserId();
            $insertIntoActivity = insertIntoActivity($pdo, 'Product deletion activity', $userId);

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

} else if ($method === 'PUT' && $service === 'editMedicine') {

    $medicinename = $form_data['medicinename'] ?? '';
    $medicineunit = $form_data['medicineunit'] ?? '';
    $medicinecategory = $form_data['medicinecategory'] ?? '';
    $medicinecostunitprice = $form_data['medicinecostunitprice'] ?? '';
    $medicinesellingunitprice = $form_data['medicinesellingunitprice'] ?? '';
    $quantity = $form_data['quantity'];
    $id = $form_data['id'];

    $id = (int) $id;

    try {
        $stmt = $pdo->query("SELECT * FROM medicines WHERE id =$id  ");

        $medicinedb = $stmt->fetch(PDO::FETCH_ASSOC);
        $collectedquantity = 0;
        $collectedquantitysub = 0;
        // foreach($medicinedb as $row)
        // if ($quantity > $medicinedb['collectedquantity'])
        //     $collectedquantitysub = $quantity - $medicinedb['collectedquantity'];
        // else
        //     $collectedquantitysub = $medicinedb['collectedquantity'] - $quantity;

        $collectedquantity = $medicinedb['collectedquantity'] + $quantity;
        $quantity += $medicinedb['quantity'];
        if (!empty($medicinedb)) {
            $sql = "UPDATE medicines SET  medicinename = :medicinename, medicinecategory = :medicinecategory, medicineunit = :medicineunit, medicinecostunitprice = :medicinecostunitprice, 
            medicinesellingunitprice = :medicinesellingunitprice, medicineid = :medicineid, quantity = :quantity, unitprofit = :profit, collectedquantity = :collectedquantity WHERE id = :id";

            $stmt = $pdo->prepare($sql);

            $profit = (float) ($medicinesellingunitprice - $medicinecostunitprice);

            $stmt->bindParam(':medicinename', $medicinename, PDO::PARAM_STR);
            $stmt->bindParam(':medicinecategory', $medicinecategory, PDO::PARAM_STR);
            $stmt->bindParam(':medicineunit', $medicineunit, PDO::PARAM_STR);
            $stmt->bindParam(':medicinecostunitprice', $medicinecostunitprice, PDO::PARAM_STR);
            $stmt->bindParam(':medicinesellingunitprice', $medicinesellingunitprice, PDO::PARAM_STR);
            $stmt->bindParam(':medicineid', $medicineid, PDO::PARAM_STR);
            $stmt->bindParam(':quantity', $quantity, PDO::PARAM_INT);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->bindParam(':profit', $profit);
            $stmt->bindParam(':collectedquantity', $collectedquantity, PDO::PARAM_INT);

            if ($stmt->execute()) {
                (int) $userId = returnUserId();
                $insertIntoActivity = insertIntoActivity($pdo, 'Product update activity', $userId);

                if (!$insertIntoActivity) {
                    echo json_encode(['success' => false, 'message' => 'Something happened at activity insertion', $user]);
                    return;
                }
                echo json_encode(['success' => true, 'message' => 'Updated',$form_data, $profit]);
                return;
            } else {
                echo json_encode(['success' => false, 'message' => 'Something happened']);
                return;
            }

        } else {
            echo json_encode(['success' => false, 'message' => 'Medicine does not exist']);
            return;
        }

    } catch (PDOException $e) {
        echo 'Something happened ' . $e->getMessage();
        return;
    }

}
