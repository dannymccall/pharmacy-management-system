<?php

include '../db/db.php';
function generateCode($length): string
{

    $characters = "0123456789"; // The set of characters to choose from
    $characterArray = str_split($characters); // Convert the string to an array
    $codePart = '';
    for ($i = 0; $i < $length; $i++) {
        // Generate a random number between 0 and the length of the array minus 1
        $randomIndex = random_int(0, count($characterArray) - 1);

        // Append the random character to the medicine ID
        $codePart .= $characterArray[$randomIndex];
    }
    return $codePart;
}

function generatePassword($length): string
{
    // Define character sets
    $lowercase = 'abcdefghijklmnopqrstuvwxyz';
    $uppercase = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $numbers = '0123456789';
    $specialChars = '!@#$%&?';

    // Ensure the password contains at least one of each type
    $password = '';
    $password .= $lowercase[rand(0, strlen($lowercase) - 1)];
    $password .= $uppercase[rand(0, strlen($uppercase) - 1)];
    $password .= $numbers[rand(0, strlen($numbers) - 1)];
    $password .= $specialChars[rand(0, strlen($specialChars) - 1)];

    // Combine all characters
    $allChars = $lowercase . $uppercase . $numbers . $specialChars;

    // Fill the remaining length with random characters
    for ($i = 4; $i < $length; $i++) {
        $password .= $allChars[rand(0, strlen($allChars) - 1)];
    }

    // Shuffle the password to ensure random order
    return str_shuffle($password);
}

function generateUsername($firstname, $lastname, $middlename): string
{

    $explode = str_split($firstname);
    $explodeMiddleName = str_split($middlename);
    $username = strtolower($explode[0]) . strtolower($explodeMiddleName[0]) . strtolower($lastname);

    return $username;
}

function updateMedicineData($newQuantity, $item_information, $pdo, $qtysold): bool
{
    $sql = "UPDATE medicines SET quantity = :newQuantity, qtysold = :qtysold WHERE medicinename = :medicinename";
    $stmt = $pdo->prepare($sql);

    $stmt->bindParam(':newQuantity', $newQuantity);
    $stmt->bindParam(':medicinename', $item_information);
    $stmt->bindParam(':qtysold', $qtysold);
    return $stmt->execute();
}

function fetchMedicineData($pdo, $item_information)
{
    $sql = "SELECT * FROM medicines WHERE medicinename = :item_information";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':item_information', $item_information, PDO::PARAM_STR);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function insertIntoActivity($pdo, $activity, $userId)
{
    try {

        $stmt = $pdo->prepare("INSERT INTO activitymanagement (activity, userId, date) VALUES(:activity, :userId, :date)");
        date_default_timezone_set('UTC');

        $date = date('Y-m-d');
        $stmt->bindParam(':activity', $activity, PDO::PARAM_STR);
        $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
        $stmt->bindParam(':date', $date, PDO::PARAM_STR);

        return $stmt->execute();
    } catch (PDOException $e) {
        // Handle error (e.g., log it or display a message)
        error_log("Database error: " . $e->getMessage());
        return [];
    }
}
function writeToFile($firstname, $middlename, $lastname, $username, $password)
{
    $directoryPath = "/var/pharmacy/";
    $filePath = $directoryPath . "user-details.txt";
    if (!is_dir($directoryPath)) {
        mkdir($directoryPath, 0777, true); // 0777 permissions allow full read/write access
    }

    $userData = [
        'Date Generated' => date("Y-m-d H:i:s"),
        "Full name" => $firstname . ' ' . $middlename . ' ' . $lastname,
        "Username" => $username,
        "Password" => $password
    ];
    $fileContents = '';
    foreach ($userData as $key => $value) {
        $fileContents .= "$key: $value" . PHP_EOL;
    }

    $fileContents .= str_repeat('-', 80) . PHP_EOL;
    file_put_contents($filePath, $fileContents, FILE_APPEND);


}

function fetchUser($pdo, $username)
{
    $stmt = $pdo->query("SELECT * FROM users WHERE username ='$username'  ");

    return $stmt->fetch(PDO::FETCH_ASSOC);

}


function generateReport($pdo, $startDate, $endDate, $filterBy, $table, $user)
{
    try {
        $sql = '';
        $stmt = null;

        if (!empty($filterBy) && !empty($startDate) && !empty($endDate) && !empty($user)) {
            // If filter, startDate, and endDate are provided
            $sql = "SELECT * FROM $table WHERE created_at BETWEEN :startDate AND :endDate AND paymentmode = :filterBy AND actiontaker = :user";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':startDate', $startDate, PDO::PARAM_STR);
            $stmt->bindParam(':endDate', $endDate, PDO::PARAM_STR);
            $stmt->bindParam(':filterBy', $filterBy, PDO::PARAM_STR);
            $stmt->bindParam(':user', $user, PDO::PARAM_STR);
        } elseif (!empty($startDate) && !empty($endDate) && !empty($user)) {
            // If only startDate and endDate are provided
            $sql = "SELECT * FROM $table WHERE created_at BETWEEN :startDate AND :endDate AND actiontaker = :user";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':startDate', $startDate, PDO::PARAM_STR);
            $stmt->bindParam(':endDate', $endDate, PDO::PARAM_STR);
            $stmt->bindParam(':user', $user, PDO::PARAM_STR);

        } elseif (!empty($startDate) && !empty($endDate)) {
            // If only startDate and endDate are provided
            $sql = "SELECT * FROM $table WHERE created_at BETWEEN :startDate AND :endDate";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':startDate', $startDate, PDO::PARAM_STR);
            $stmt->bindParam(':endDate', $endDate, PDO::PARAM_STR);
        } else if (!empty($filterBy)) {
            $sql = "SELECT * FROM $table WHERE paymentmode = :filterBy";
            $stmt = $pdo->prepare($sql);

            $stmt->bindParam(':filterBy', $filterBy, PDO::PARAM_STR);
        } else if (!empty($user)) {
            $sql = "SELECT * FROM $table WHERE actiontaker = :user";
            $stmt = $pdo->prepare($sql);

            $stmt->bindParam(':user', $user, PDO::PARAM_STR);
        } else {
            // If no filter, startDate, or endDate is provided
            $sql = "SELECT * FROM $table";
            $stmt = $pdo->prepare($sql);
        }

        // Execute and return the results
        $stmt->execute();

        (int) $userId = isset($_SESSION['id']) ? $_SESSION['id'] : null;
        insertIntoActivity($pdo, 'Report generation activity', $userId);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);

    } catch (PDOException $e) {
        // Handle error (e.g., log it or display a message)
        error_log("Database error: " . $e->getMessage());
        return [];
    }
}




function returnUserId()
{
     $userId = isset($_SESSION['id']) ? $_SESSION['id'] : null;
    return $userId;
}



function insertData($pdo, $table, $data)
{
    try {
        $columns = implode(", ", array_keys($data));
        $placeholders = ":" . implode(", :", array_keys($data));

        $sql = "INSERT INTO $table ($columns) VALUES ($placeholders)";

        $stmt = $pdo->prepare($sql);

        foreach ($data as $key => $value) {
            $stmt->bindValue(":$key", $value);

        }

        return $stmt->execute();

    } catch (PDOException $e) {
        error_log("Database error: " . $e->getMessage());
        return [];
    }
}


// Database connection setup
// function searchItem($pdo, $table, $keyword)
// {
//     // Get search term from the AJAX request
//     $searchTerm = $_GET['query'] ?? '';

//     if ($searchTerm) {
//         $stmt = $pdo->prepare("SELECT * FROM $table WHERE $keyword LIKE :searchTerm");
//         $term = '%' . $searchTerm . '%';
//         $stmt->bindParam(':searchTerm', $term, PDO::PARAM_STR);
//         $stmt->execute();

//         return $stmt->fetchAll(PDO::FETCH_ASSOC);
//     }
// }


function searchItem($pdo, $table, $keyword, $joinClause = '', $conditions = '')
{
    // Get search term from the AJAX request
    $searchTerm = $_GET['query'] ?? '';

    if ($searchTerm) {
        // Build the base SQL query with optional JOIN and conditions
        $sql = "SELECT * FROM $table";

        // Include the JOIN clause if provided
        if ($joinClause) {
            $sql .= " $joinClause";
        }

        // Add the WHERE clause
        $sql .= " WHERE $keyword LIKE :searchTerm";

        // Add any additional conditions if specified
        if ($conditions) {
            $sql .= " AND $conditions";
        }

        $stmt = $pdo->prepare($sql);
        $term = '%' . $searchTerm . '%';
        $stmt->bindParam(':searchTerm', $term, PDO::PARAM_STR);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    return [];
}


function writeDynamicToFile($directoryPath, $data)
{
    if (!is_dir($directoryPath)) {
        mkdir($directoryPath, 0777, true); // 0777 permissions allow full read/write access
    }

    // $data = [
    //     'Date Generated' => date("Y-m-d H:i:s"),
    //     "Profit" => $totalProfit,
    //     "quantity" => $item->quantity,
    //     "unit profit" => $medicineData['unitprofit']
    // ];
    $fileContents = '';
    foreach ($data as $key => $value) {
        $fileContents .= "$key: $value" . PHP_EOL;
    }

    $filePath = $directoryPath . "logs-details.txt";
    $fileContents .= str_repeat('-', 80) . PHP_EOL;
    file_put_contents($filePath, $fileContents, FILE_APPEND);
}

function fetchFromDatabaseWithCount($pdo, $table, $condition = '', $countOnly = false)
{
    // Adjust the SELECT clause based on whether countOnly is true or false
    $sql = $countOnly ? "SELECT COUNT(*) AS count FROM $table" : "SELECT * FROM $table";

    if ($condition) {
        $sql .= " $condition";
    }

    $stmt = $pdo->prepare($sql);
    $stmt->execute();

    // Return the count if countOnly is true; otherwise, return all results
    return $countOnly ? $stmt->fetch(PDO::FETCH_ASSOC)['count'] : $stmt->fetchAll(PDO::FETCH_ASSOC);
}


function fetchFromDatabase($pdo, $table, $columns = '*', $condition = '', $groupBy = '', $orderBy = '', $limit = '', $joinClause = '')
{
    $sql = "SELECT $columns FROM $table";

    if ($joinClause) {
        $sql .= " $joinClause";
    }
    if ($condition) {
        $sql .= " $condition";
    }

    if ($groupBy) {
        $sql .= " GROUP BY $groupBy";
    }

    if ($orderBy) {
        $sql .= " ORDER BY $orderBy";
    }

    if ($limit) {
        $sql .= " LIMIT $limit";
    }


    $stmt = $pdo->prepare($sql);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getExpirationAlert($products, $purchaseID)
{

    $currentDate = new DateTime();
    // Retrieve existing notifications from session or initialize as an empty array
    $notifications = isset($_SESSION['notifications']) ? $_SESSION['notifications'] : [];

    foreach ($products as $product) {
        $expDate = new DateTime($product['date']);
        $interval = $currentDate->diff($expDate);
        $daysUntilExpiration = (int) $interval->format('%r%a');

        // Prepare the notification message based on expiration time
        $notificationMessage = "";
        if ($daysUntilExpiration == 7) {
            $notificationMessage = "{$product['medicineName']} with batch NO:{$product['batchId']} and purchase no: {$purchaseID} will expire in 7 days on " . $expDate->format('Y-m-d');
        } elseif ($daysUntilExpiration == 3) {
            $notificationMessage = "{$product['medicineName']} batch NO:{$product['batchId']} and purchase NO: {$purchaseID} will expire in 3 days on " . $expDate->format('Y-m-d');
        } elseif ($daysUntilExpiration == 0) {
            $notificationMessage = "{$product['medicineName']} batch NO:{$product['batchId']} and purchase NO: {$purchaseID} expires today on " . $expDate->format('Y-m-d');
        }

        // Only add the notification if it doesn't already exist in the session
        if ($notificationMessage && !in_array($notificationMessage, $notifications)) {
            $notifications[] = $notificationMessage;
        }
    }

    $_SESSION['notifications'] = $notifications; // Update session with unique notifications
    return $notifications;
}


// function getExpirationAlert($products)
// {
//     $currentDate = new DateTime();
//     $notifications = [];

//     foreach ($products as $product) {
//         $expDate = new DateTime($product['date']);
//         $interval = $currentDate->diff($expDate);
//         $daysUntilExpiration = (int) $interval->format('%r%a');

//         // Generate notifications based on days until expiration
//         if ($daysUntilExpiration == 7) {
//             $notifications[] = "{$product['medicineName']} will expire in 7 days on " . $expDate->format('Y-m-d');
//         } elseif ($daysUntilExpiration == 3) {
//             $notifications[] = "{$product['medicineName']} will expire in 3 days on " . $expDate->format('Y-m-d');
//         } elseif ($daysUntilExpiration == 0) {
//             $notifications[] = "{$product['medicineName']} expires today on " . $expDate->format('Y-m-d');
//         } elseif ($daysUntilExpiration < 0) {
//             $notifications[] = "{$product['medicineName']} expired on " . $expDate->format('Y-m-d');
//         }
//     }

//     return $notifications; // Return all notifications after the loop
// }


// Usage example to get the count of items running low on stock
// $lowStockCount = fetchFromDatabase($pdo, 'items', 'WHERE quantity < 20', true);
// echo "Number of items running low on stock: " . $lowStockCount;
