<?php
include '../cors/cors.php';
include './util.script.php';

$method = $_SERVER["REQUEST_METHOD"];
$service = $_SERVER["HTTP_SERVICE"];

$form_data = json_decode(file_get_contents(filename: "php://input"), true);

$filterBy = $form_data['filterBy'] ?? null;
$startDate = $form_data['startDate'] ?? null;
$endDate = $form_data['endDate'] ?? null;

if ($method === 'GET' && $service === 'searchInvoice') {

    try {
        $keyword = 'invoicenumber';
        $searchResults = searchItem($pdo, 'invoices', $keyword);

        if (!empty($searchResults)) {
            (int) $userId = returnUserId();
            $insertIntoActivity = insertIntoActivity($pdo, 'Invoice search activity', $userId);

            if (!$insertIntoActivity) {
                echo json_encode(['success' => false, 'message' => 'Something happened at activity insertion', $user]);
                return;
            }
            echo json_encode(['success' => true, 'searchResults' => $searchResults]);
            return;
        } else {
            echo json_encode(['success' => true, 'searchResults' => []]);
        }
    } catch (PDOException $e) {
        echo 'Something happened ' . $e->getMessage();
        return;
    }
} else if ($method === 'GET' && $service === 'searchMedicine') {
    try {
        $keyword = 'medicinename';
        $searchResults = searchItem($pdo, 'medicines', $keyword);

        if (!empty($searchResults)) {

            (int) $userId = returnUserId();
            $insertIntoActivity = insertIntoActivity($pdo, 'Medicine search activity', $userId);

            if (!$insertIntoActivity) {
                echo json_encode(['success' => false, 'message' => 'Something happened at activity insertion', $user]);
                return;
            }
            echo json_encode(['success' => true, 'searchResults' => $searchResults]);
            return;
        } else {
            echo json_encode(['success' => true, 'searchResults' => []]);
        }
    } catch (PDOException $e) {
        echo 'Something happened ' . $e->getMessage();
        return;
    }
} else if ($method === 'GET' && $service === 'searchUser') {
    try {

        $keyword = 'username';
        $joinClause = "JOIN users ON activitymanagement.userId = users.id";
        $searchResults = searchItem($pdo, 'activitymanagement', $keyword, $joinClause);

        if (!empty($searchResults)) {
            (int) $userId = returnUserId();
            $insertIntoActivity = insertIntoActivity($pdo, 'User search activity', $userId);

            if (!$insertIntoActivity) {
                echo json_encode(['success' => false, 'message' => 'Something happened at activity insertion', $user]);
                return;
            }
            echo json_encode(['success' => true, 'searchResults' => $searchResults]);
            return;
        } else {
            echo json_encode(['success' => true, 'searchResults' => []]);
        }
    } catch (PDOException $e) {
        echo 'Something happened ' . $e->getMessage();
        return;
    }
}