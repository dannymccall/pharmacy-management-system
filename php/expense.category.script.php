<?php
include '../cors/cors.php';
include '../db/db.php';
$method = $_SERVER["REQUEST_METHOD"];
$service = $_SERVER["HTTP_SERVICE"];

if ($method === 'GET' && $service === 'fetchExpenseCategories') {
    $stmt = $pdo->prepare("SELECT * FROM expensecategory");

    if ($stmt->execute()) {

        $expensecategories = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (!empty($expensecategories)) {
            echo json_encode(['success' => true, 'expensecategories' => $expensecategories]);
            return;
        } else {
            echo json_encode(['success' => true, 'expensecategories' => $expensecategories]);
            return;
        }
    }
}