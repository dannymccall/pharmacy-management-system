<?php
session_start();
include '../cors/cors.php';
include '../db/db.php';
$method = $_SERVER["REQUEST_METHOD"];
$service = $_SERVER["HTTP_SERVICE"];

// if (!isset($_SESSION['username'])) {
//     echo json_encode(['success' => false, 'message' => 'Unauthorised']);

// } else {
if ($method === 'POST' && $service === 'addCategory') {

    $form_data = json_decode(file_get_contents(filename: "php://input"), true);
    $categoryname = $form_data['categoryname'] ?? '';
    $category = $form_data['category'] ?? '';

    if (!empty(trim($categoryname)) || !empty(trim($category))) {
        try {

            $stmt = $pdo->prepare("INSERT INTO categories (categoryname, category) VALUES( :categoryname, :category)");

            $stmt->bindParam(':categoryname', $categoryname);
            $stmt->bindParam(':category', $category);

            if ($stmt->execute()) {
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
    $form_data = json_decode(file_get_contents(filename: "php://input"), true);
    $id = $form_data['id'];

    try {
        $stmt = $pdo->prepare("DELETE FROM categories WHERE id = :id");

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

} else if ($method === 'PUT' && $service === 'editCategory') {

    $form_data = json_decode(file_get_contents(filename: "php://input"), true);
    $categoryname = $form_data['category'] ?? '';
    $category = $form_data['categoryname'] ?? '';
    $id = $form_data['id'];

    $id = (int) $id;

    try {
        $stmt = $pdo->query("SELECT * FROM categories WHERE id =$id  ");

        $unitdb = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!empty($unitdb)) {
            $sql = "UPDATE categories SET categoryname = :categoryname, category = :category WHERE id = :id";
            $stmt = $pdo->prepare($sql);

            $stmt->bindParam(":categoryname", $categoryname, PDO::PARAM_STR);
            $stmt->bindParam(":category", $category, PDO::PARAM_STR);
            $stmt->bindParam(":id", $id, PDO::PARAM_INT);

            if ($stmt->execute()) {

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
