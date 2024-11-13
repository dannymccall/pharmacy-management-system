<?php

$method = $_SERVER["REQUEST_METHOD"];
$service = $_SERVER["HTTP_SERVICE"];
include '../db/db.php';
if ($method === 'GET' && $service === 'getRecentActivities') {

    $page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
    $items_per_page = 5;
    $offset = ($page - 1) * $items_per_page;

    date_default_timezone_set('UTC');
    $today = date('Y-m-d');

    // Get the total count of today's activities
    $result = $pdo->prepare("SELECT COUNT(*) AS count FROM activitymanagement a 
                            JOIN users u ON u.id = a.userId 
                            WHERE DATE(a.created_at) = :today");
    $result->bindParam(':today', $today);
    $result->execute();
    $total_items = $result->fetch()['count'];

    // Prepare the paginated query
    $stmt = $pdo->prepare("SELECT * FROM activitymanagement a 
                           JOIN users u ON u.id = a.userId 
                           WHERE DATE(a.created_at) = :today 
                           ORDER BY a.created_at DESC 
                           LIMIT :offset, :items_per_page");

    // Bind parameters
    $stmt->bindParam(':today', $today);
    $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
    $stmt->bindParam(':items_per_page', $items_per_page, PDO::PARAM_INT);
    $stmt->execute();

    $activities = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Output JSON response
    echo json_encode([
        'success' => true,
        'activities' => $activities,
        'total_items' => $total_items,
        'items_per_page' => $items_per_page,
        'current_page' => $page,
        'total' => $total_items
    ]);
}
