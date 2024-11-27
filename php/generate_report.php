<?php
include '../cors/cors.php';
include './util.script.php';

$method = $_SERVER["REQUEST_METHOD"];
$service = $_SERVER["HTTP_SERVICE"];

$form_data = json_decode(file_get_contents(filename: "php://input"), true);

$filterBy = $form_data['filterBy'] ?? null;
$startDate = $form_data['startDate'] ?? null;
$endDate = $form_data['endDate'] ?? null;
$user = $form_data['user'] ?? null;
if ($method === 'POST' && $service === 'salesReport') {


    try {
        $report = generateReport($pdo, $startDate, $endDate, $filterBy, 'invoices', $user);

        echo json_encode(['success' => true, 'report' => $report]);
    } catch (PDOException $e) {
        echo 'Something happened ' . $e->getMessage();
        return;
    }
} else if ($method === 'POST' && $service === 'purchaseReport') {
    try {
        $report = generateReport($pdo, $startDate, $endDate, $filterBy, 'purchases', $user);

        echo json_encode(['success' => true, 'report' => $report]);
    } catch (PDOException $e) {
        echo 'Something happened ' . $e->getMessage();
        return;
    }
} else if ($method === 'POST' && $service === 'expenseReport') {
    try {
        $report = generateReport($pdo, $startDate, $endDate, $filterBy, 'expenses', $user);

        echo json_encode(['success' => true, 'report' => $report]);
    } catch (PDOException $e) {
        echo 'Something happened ' . $e->getMessage();
        return;
    }
}