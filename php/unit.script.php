<?php
session_start();
include '../cors/cors.php';
include '../db/db.php';
$method = $_SERVER["REQUEST_METHOD"];
$service = $_SERVER["HTTP_SERVICE"];

// if (!isset($_SESSION['username'])) {
//     echo json_encode(['success' => false, 'message' => 'Unauthorised']);

// } else {
if ($method === 'POST' && $service === 'addUnit') {

    $form_data = json_decode(file_get_contents(filename: "php://input"), true);
    $unitname = $form_data['unitname'] ?? '';
    $unit = $form_data['unit'] ?? '';

    if (!empty(trim($unitname)) || !empty(trim($unit))) {


        try {

            $stmt = $pdo->prepare("INSERT INTO units (unitname, unit) VALUES( :unitname, :unit)");

            $stmt->bindParam(':unitname', $unitname);
            $stmt->bindParam(':unit', $unit);

            if ($stmt->execute()) {
                echo json_encode(['success' => true, 'message' => 'Unit inserted successfully']);
                return;
            } else {
                echo json_encode(['success' => false, 'message' => 'Unit insertion failed, something happened']);
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
} else if ($method === 'GET' && $service === 'fetchUnits') {
    try {
        $stmt = $pdo->prepare("SELECT * FROM units");

        if ($stmt->execute()) {

            $units = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if (!empty($units)) {
                echo json_encode(['success' => true, 'units' => $units]);
                return;
            } else {
                echo json_encode(['success' => true, 'units' => $units]);
                return;
            }
        }

    } catch (PDOException $e) {
        echo 'Something happened ' . $e->getMessage();
        return;
    }


} else if ($method === 'DELETE' && $service === 'deleteUnit') {
    $form_data = json_decode(file_get_contents(filename: "php://input"), true);
    $id = $form_data['id'];

    try {
        $stmt = $pdo->prepare("DELETE FROM units WHERE id = :id");

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

} else if ($method === 'PUT' && $service === 'editUnit') {

    $form_data = json_decode(file_get_contents(filename: "php://input"), true);
    $unitname = $form_data['unitname'] ?? '';
    $unit = $form_data['unit'] ?? '';
    $id = $form_data['id'];

    $id = (int) $id;

    try {
        $stmt = $pdo->query("SELECT * FROM units WHERE id =$id  ");

        $unitdb = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!empty($unitdb)) {
            $sql = "UPDATE units SET unitname = :unitname, unit = :unit WHERE id = :id";
            $stmt = $pdo->prepare($sql);

            $stmt->bindParam(":unitname", $unitname, PDO::PARAM_STR);
            $stmt->bindParam(":unit", $unit, PDO::PARAM_STR);
            $stmt->bindParam(":id", $id, PDO::PARAM_INT);

            if ($stmt->execute()) {

                echo json_encode(['success' => true, 'message' => 'Updated']);
                return;
            } else {
                echo json_encode(['success' => false, 'message' => 'Something happened']);
                return;
            }

        } else {
            echo json_encode(['success' => false, 'message' => 'Unit does not exist']);
            return;
        }

    } catch (PDOException $e) {
        echo 'Something happened ' . $e->getMessage();
        return;
    }
}else{
    echo json_encode(['success' => false, 'message' => 'Method not allowed']);
    return;
}

// }


