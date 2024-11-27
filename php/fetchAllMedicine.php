<?php 

include '../cors/cors.php';
include '../db/db.php';
include './util.script.php';
$method = $_SERVER["REQUEST_METHOD"];
$service = $_SERVER["HTTP_SERVICE"];
if($method === 'GET' && $service === 'fetchAllMedicine'){
   
        $stmt = $pdo->prepare("SELECT * FROM medicines");

        if ($stmt->execute()) {

            $medicines = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if (!empty($medicines)) {
                echo json_encode([
                    'success' => true,
                    'medicines' => $medicines,
                ]);
                return;
            } else {
                echo json_encode(['success' => true, 'medicines' => []]);
                return;
            }
}
}