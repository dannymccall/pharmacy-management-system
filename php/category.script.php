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
    $form_data = json_decode(file_get_contents(filename: "php://input"), true);

if ($method === 'POST' && $service === 'addCategory') {

    $categoryname = $form_data['categoryname'] ?? '';


    if (!empty(trim($categoryname))) {
        try {

            $stmt = $pdo->prepare("INSERT INTO categories (categoryname) VALUES( :categoryname)");

            $stmt->bindParam(':categoryname', $categoryname);


            if ($stmt->execute()) {
                (int) $userId = returnUserId();
                $insertIntoActivity = insertIntoActivity($pdo, 'Category addition activity', $userId);

                if (!$insertIntoActivity) {
                    echo json_encode(['success' => false, 'message' => 'Something happened at activity insertion', $user]);
                    return;
                }
                echo json_encode(['success' => true, 'message' => 'Category inserted successfully']);
                return;
            } else {
                echo json_encode(['success' => false, 'message' => 'Category insertion failed, something happened']);
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
} else if ($method === 'GET' && 'fetchCategory') {
    $stmt = $pdo->prepare("SELECT * FROM categories");

    if ($stmt->execute()) {

        $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (!empty($categories)) {
            echo json_encode(['success' => true, 'categories' => $categories]);
            return;
        } else {
            echo json_encode(['success' => true, 'categories' => $categories]);
            return;
        }
    }


} else if ($method === 'DELETE' && $service === 'deleteCategory') {
    $id = $form_data['id'];

    try {
        $stmt = $pdo->prepare("DELETE FROM categories WHERE id = :id");

        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        if ($stmt->execute()) {

            (int) $userId = returnUserId();
            $insertIntoActivity = insertIntoActivity($pdo, 'Category deletion activity', $userId);

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

} else if ($method === 'PUT' && $service === 'editCategory') {

    $form_data = json_decode(file_get_contents(filename: "php://input"), true);
    $categoryname = $form_data['categoryname'] ?? '';
    $id = $form_data['id'];

    $id = (int) $id;

    try {
        $stmt = $pdo->query("SELECT * FROM categories WHERE id =$id  ");

        $unitdb = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!empty($unitdb)) {
            $sql = "UPDATE categories SET categoryname = :categoryname WHERE id = :id";
            $stmt = $pdo->prepare($sql);

            $stmt->bindParam(":categoryname", $categoryname, PDO::PARAM_STR);
            $stmt->bindParam(":id", $id, PDO::PARAM_INT);

            if ($stmt->execute()) {

                (int) $userId = returnUserId();
                $insertIntoActivity = insertIntoActivity($pdo, 'Category update activity', $userId);

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
            echo json_encode(['success' => false, 'message' => 'Category does not exist']);
            return;
        }

    } catch (PDOException $e) {
        echo 'Something happened ' . $e->getMessage();
        return;
    }

}
