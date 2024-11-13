<?php
// Initialize the session
include './util.script.php';
session_start();
$method = $_SERVER["REQUEST_METHOD"];
$service = $_SERVER["HTTP_SERVICE"];

// Unset all of the session variables


if ($method === 'POST' && $service === 'logout') {

    (int) $userId = returnUserId();
    $insertIntoActivity = insertIntoActivity($pdo, 'Logout activity', $userId);

    if (!$insertIntoActivity) {
        echo json_encode(['success' => false, 'message' => 'Something happened at activity insertion', $user]);
        return;
    }

    $_SESSION = array();
    // Destroy the session.
    session_destroy();


    echo json_encode(['success' => true, 'message' => 'Logout successful']);
    return;
}

// Redirect to login page