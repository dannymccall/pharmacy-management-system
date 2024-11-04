<?php
session_start();
include '../cors/cors.php';
include '../db/db.php';
$method = $_SERVER["REQUEST_METHOD"];
$service = $_SERVER["HTTP_SERVICE"];

// if (!isset($_SESSION['username'])) {
//     echo json_encode(['success' => false, 'message' => 'Unauthorised']);

// } else {
if ($method === 'POST' && $service === 'addExpense') {

    $form_data = json_decode(file_get_contents(filename: "php://input"), true);
    $expensedate = $form_data['expenseDate'] ?? '';
    $expensecategory = $form_data['expenseCategory'] ?? '';
    $purpose = $form_data['purpose'] ?? '';
    $total = $form_data['total'] ?? '';
    $description = $form_data['expenseDescription'] ?? '';

    if (!empty(trim($expensedate)) || !empty(trim($expensecategory)) || !empty(trim($purpose)) || !empty(trim($total)) || !empty(trim($description))) {
        try {

            $stmt = $pdo->prepare("INSERT INTO expenses (expensedate, expensecategory, purpose,total,description) VALUES( :expensedate, :expensecategory, :purpose, :total, :description)");

            $stmt->bindParam(':expensedate', $expensedate, PDO::PARAM_STR);
            $stmt->bindParam(':expensecategory', $expensecategory, PDO::PARAM_STR);
            $stmt->bindParam(':purpose', $purpose, PDO::PARAM_STR);
            $stmt->bindParam(':total', $total, PDO::PARAM_INT);
            $stmt->bindParam(':description', $description, PDO::PARAM_STR);

            if ($stmt->execute()) {
                echo json_encode(['success' => true, 'message' => 'Expense inserted successfully']);
                return;
            } else {
                echo json_encode(['success' => false, 'message' => 'Expense insertion failed, something happened']);
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
} else if ($method === 'GET' && 'fetchExpense') {
    $page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
    $items_per_page = 5;
    $offset = ($page - 1) * $items_per_page;

    $result = $pdo->query("SELECT COUNT(*) as count FROM expenses");
    $total_items = $result->fetch()['count'];


    $stmt = $pdo->prepare("SELECT * FROM expenses LIMIT $offset, $items_per_page");

    if ($stmt->execute()) {

        $expenses = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (!empty($expenses)) {
            echo json_encode([
                'success' => true,
                'expenses' => $expenses,
                'total_items' => $total_items,
                'items_per_page' => $items_per_page,
                'current_page' => $page
            ]);
            return;
        } else {
            echo json_encode(['success' => true, 'expenses' => []]);
            return;
        }
    }


} else if ($method === 'DELETE' && $service === 'deleteExpense') {
    $form_data = json_decode(file_get_contents(filename: "php://input"), true);
    $id = $form_data['id'];

    try {
        $stmt = $pdo->prepare("DELETE FROM expenses WHERE id = :id");

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

} else if ($method === 'PUT' && $service === 'editExpense') {

    $form_data = json_decode(file_get_contents(filename: "php://input"), true);
    $expensedate = $form_data['expensedate'] ?? '';
    $expensecategory = $form_data['expensecategory'] ?? '';
    $purpose = $form_data['purpose'] ?? '';
    $total = $form_data['total'] ?? '';
    $description = $form_data['description'] ?? '';

    $id = $form_data['id'];

    $id = (int) $id;

    try {
        $stmt = $pdo->query("SELECT * FROM expenses WHERE id =$id  ");

        $unitdb = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!empty($unitdb)) {
            $sql = "UPDATE expenses SET expensedate = :expensedate, expensecategory = :expensecategory, purpose = :purpose, total = :total, description = :description WHERE id = :id";
            $stmt = $pdo->prepare($sql);

            $stmt->bindParam(':expensedate', $expensedate, PDO::PARAM_STR);
            $stmt->bindParam(':expensecategory', $expensecategory, PDO::PARAM_STR);
            $stmt->bindParam(':purpose', $purpose, PDO::PARAM_STR);
            $stmt->bindParam(':total', $total, PDO::PARAM_INT);
            $stmt->bindParam(':description', $description, PDO::PARAM_STR);
            $stmt->bindParam(":id", $id, PDO::PARAM_INT);

            if ($stmt->execute()) {

                echo json_encode(['success' => true, 'message' => 'Updated']);
                return;
            } else {
                echo json_encode(['success' => false, 'message' => 'Something happened']);
                return;
            }

        } else {
            echo json_encode(['success' => false, 'message' => 'Expense does not exist']);
            return;
        }

    } catch (PDOException $e) {
        echo 'Something happened ' . $e->getMessage();
        return;
    }

} else if ($method === 'POST' && $service === 'addExpenseCategory') {
    $form_data = json_decode(file_get_contents(filename: "php://input"), true);
    $categoryname = $form_data['categoryname'] ?? '';


    if (!empty(trim($categoryname))) {
        try {

            $stmt = $pdo->prepare("INSERT INTO expensecategory (categoryname) VALUES( :categoryname)");

            $stmt->bindParam(':categoryname', $categoryname, PDO::PARAM_STR);
            if ($stmt->execute()) {
                echo json_encode(['success' => true, 'message' => 'Expense category inserted successfully']);
                return;
            } else {
                echo json_encode(['success' => false, 'message' => 'Expense category insertion failed, something happened']);
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
} else if ($method === 'GET' && $service === 'fetchExpenseCategories') {
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
