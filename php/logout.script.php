<?php
// Initialize the session
session_start();
$method = $_SERVER["REQUEST_METHOD"];
$service = $_SERVER["HTTP_SERVICE"];

// Unset all of the session variables


if ($method === 'POST' && $service === 'logout') {

    $_SESSION = array();
    // Destroy the session.
    session_destroy();

    echo json_encode(['success' => true, 'message' => 'Logout successful']);
    return;
}

// Redirect to login page