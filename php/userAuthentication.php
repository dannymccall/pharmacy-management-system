<?php
session_start();
include '../cors/cors.php';
include './util.script.php';
include '../db/db.php';
$method = $_SERVER["REQUEST_METHOD"];
$service = $_SERVER["HTTP_SERVICE"];

$form_data = json_decode(file_get_contents(filename: "php://input"), true);

if ($method === 'POST' && $service === 'userLogin') {

    $user__name = $form_data['username'] ?? '';
    $user__password = $form_data['password'] ?? '';

    if (empty(trim($user__name)) || empty(trim($user__password))) {
        echo json_encode(['success' => false, 'message' => 'All fields required']);
        return;
    }

    try {
       
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username");

        $stmt->bindParam(':username', $user__name);


        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (empty($user)) {
            echo json_encode(['success' => false, 'message' => 'username or password does not match our records']);
            return;
        }

        if (password_verify($user__password, $user['password'])) {
            (int) $userId = $user['id'];
            $insertIntoActivity = insertIntoActivity($pdo, 'Login Activity', $userId);

            if (!$insertIntoActivity) {
                echo json_encode(['success' => false, 'message' => 'Something happened at activity insertion', $user]);
                return;
            }


            $lastChange = new DateTime($user['last_password_change']);
            $currentDate = new DateTime();
            $nextChange = clone $lastChange;
            $nextChange->modify('+1 month');
            $interval = $currentDate->diff($nextChange);

            $daysLeft = $interval->days * ($interval->invert ? -1 : 1);

            $purchases = fetchFromDatabaseWithCount($pdo, 'purchases');
            foreach ($purchases as $purchase) {
                $purchaseProduct = json_decode($purchase['products'], true);
                $purchaseID = $purchase['purchasenumber'];
                $notifications = getExpirationAlert($purchaseProduct, $purchaseID);
            }

            $_SESSION['username'] = $user['username'];
            $_SESSION['user_role'] = $user['role'];
            $_SESSION['firstname'] = $user['firstname'];
            $_SESSION['lastname'] = $user['lastname'];
            $_SESSION['password'] = $user['password'];
            $_SESSION['middlename'] = $user['middlename'];
            $_SESSION['id'] = $user['id'];
            echo json_encode(['success' => true, 'message' => 'Login successful', 'daysLeft' => $daysLeft]);
            return;
        }

        echo json_encode(['success' => false, 'message' => 'username or password does not match our records']);
        return;
    } catch (PDOException $e) {
        echo 'Something happened ' . $e->getMessage();
        return;
    }
} else if ($method === 'POST' && $service === 'addUser') {

    $firstname = $form_data['firstname'];
    $lastname = $form_data['lastname'];
    $middlename = $form_data['middlename'];
    $role = $form_data['role'];




    if (empty(trim($firstname)) && empty(trim($lastname)) && empty(trim($role)) && empty(trim($middlename))) {
        echo json_encode(['success' => false, 'message' => 'All fields required']);
        return;
    }

    try {

       
        $password = generatePassword(12);
        (string) $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        (string) $username = generateUsername($firstname, $lastname, $middlename);
        $pdo->beginTransaction();

        $condition = "WHERE username = '$username'";
        $fetchUser = fetchFromDatabaseWithCount($pdo, 'users', $condition);
        if(!empty($fetchUser)){
            echo json_encode(['success' => false, 'message' => 'User already exists', ]);
            return;
        }
        // $stmt = $pdo->query("SELECT * FROM users WHERE username = $username  ");
        // $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // if(!empty($user)){
        //     $username = generateUsername($firstname,  $middlename, $lastname);
        // }


        $sql = "INSERT INTO users (firstname, lastname, middlename, username, role, password) VALUES (:firstname, :lastname,:middlename,  :username, :role, :password)";

        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':firstname', $firstname, PDO::PARAM_STR);
        $stmt->bindParam(':lastname', $lastname, PDO::PARAM_STR);
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->bindParam(':password', $hashedPassword, PDO::PARAM_STR);
        $stmt->bindParam(':role', $role, PDO::PARAM_STR);
        $stmt->bindParam(':middlename', $middlename, PDO::PARAM_STR);

        if ($stmt->execute()) {
            $pdo->commit();

            // (int) $userId = isset($_SESSION['id']) ? $_SESSION['id'] : null;
            (int) $userId = returnUserId();
            $insertIntoActivity = insertIntoActivity($pdo, 'Add user activity', $userId);


            if (!$insertIntoActivity) {
                echo json_encode(['success' => false, 'message' => 'Something happened at activity insertion', $user]);
                return;
            }
            writeToFile($firstname, $middlename, $lastname, $username, $password);
            echo json_encode(['success' => true, 'message' => 'User add successfully']);
            return;
        }
    } catch (PDOException $e) {
        $pdo->rollBack();
        echo 'Something happened ' . $e->getMessage();
        return;
    }
} else if ($method === 'GET' && $service === 'fetchUsers') {

    $page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
    $items_per_page = 10;
    $offset = ($page - 1) * $items_per_page;

    $result = $pdo->query("SELECT COUNT(*) as count FROM users");
    $total_items = $result->fetch()['count'];


    $stmt = $pdo->prepare("SELECT * FROM users LIMIT $offset, $items_per_page");

    if ($stmt->execute()) {

        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (!empty($users)) {
            echo json_encode([
                'success' => true,
                'users' => $users,
                'total_items' => $total_items,
                'items_per_page' => $items_per_page,
                'current_page' => $page
            ]);
            return;
        }
        echo json_encode(['success' => true, 'users' => []]);
        return;
    }

} else if ($method === 'DELETE' && $service === 'deleteUser') {

    $id = $form_data['id'];

    try {
        $stmt = $pdo->prepare("DELETE FROM users WHERE id = :id");

        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        if ($stmt->execute()) {

            (int) $userId = returnUserId();
            $insertIntoActivity = insertIntoActivity($pdo, 'Delete user activity', $userId);

            if (!$insertIntoActivity) {
                echo json_encode(['success' => false, 'message' => 'Something happened at activity insertion', $user]);
                return;
            }

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
} else if ($method === 'PUT' && $service === 'updateUser') {
    $form_data = json_decode(file_get_contents(filename: "php://input"), true);
    $firstname = $form_data['firstname'] ?? '';
    $middlename = $form_data['middlename'] ?? '';
    $lastname = $form_data['lastname'] ?? '';
    $role = $form_data['role'];
    $id = $form_data['id'];

    (string) $username = generateUsername($firstname, $lastname, $middlename);

    $id = (int) $id;

    try {
        $stmt = $pdo->query("SELECT * FROM users WHERE id =$id  ");

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!empty($user)) {
            $sql = "UPDATE users SET firstname = :firstname, middlename = :middlename, lastname = :lastname, username = :username, role = :role WHERE id = :id";
            $stmt = $pdo->prepare($sql);

            $stmt->bindParam(":firstname", $firstname, PDO::PARAM_STR);
            $stmt->bindParam(":middlename", $middlename, PDO::PARAM_STR);
            $stmt->bindParam(":lastname", $lastname, PDO::PARAM_STR);
            $stmt->bindParam(":username", $username, PDO::PARAM_STR);
            $stmt->bindParam(":role", $role, PDO::PARAM_STR);
            $stmt->bindParam(":id", $id, PDO::PARAM_INT);

            if ($stmt->execute()) {
                (int) $userId = returnUserId();
                $insertIntoActivity = insertIntoActivity($pdo, 'User update activity', $userId);

                if (!$insertIntoActivity) {
                    echo json_encode(['success' => false, 'message' => 'Something happened at activity insertion', $user]);
                    return;
                }
                echo json_encode(['success' => true, 'message' => 'User updated']);
                return;
            } else {
                echo json_encode(['success' => false, 'message' => 'Something happened']);
                return;
            }

        } else {
            echo json_encode(['success' => false, 'message' => 'User does not exist']);
            return;
        }

    } catch (PDOException $e) {
        echo 'Something happened ' . $e->getMessage();
        return;
    }
} else if ($method === 'POST' && $service === 'changeAvarta') {
    $uploadDir = '../uploads/';
    if (!is_dir($uploadDir))
        mkdir($uploadDir, 007, true);

    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['image']['tmp_name'];
        $fileName = basename($_FILES['image']['name']);
        $fileSize = $_FILES['image']['size'];
        $fileType = mime_content_type($fileTmpPath);

        $username = isset($_SESSION['username']) ? $_SESSION['username'] : "";
        $allowedTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif'];
        if (in_array($fileType, $allowedTypes)) {
            $newFileName = uniqid() . '-' . $fileName;
            $destination = $uploadDir . $newFileName;

            if (move_uploaded_file($fileTmpPath, $destination)) {

                $sql = "UPDATE users set avarta = :avarta where username = :username";
                $stmt = $pdo->prepare($sql);

                $stmt->bindParam(':avarta', $newFileName);
                $stmt->bindParam(':username', $username);

                $stmt->execute();

                (int) $userId = returnUserId();
                $insertIntoActivity = insertIntoActivity($pdo, 'Profile picture upload activity', $userId);

                if (!$insertIntoActivity) {
                    echo json_encode(['success' => false, 'message' => 'Something happened at activity insertion', $user]);
                    return;
                }
                echo json_encode(['success' => true, 'message' => 'File uploaded successfully', 'filePath' => $destination]);
                return;
            } else {
                echo json_encode(['success' => false, 'message' => 'Error moving uploaded file.']);
                return;
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Invalid file type. Only JPG, PNG, JPEG and GIF allowed.']);
            return;
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'No file uploaded or upload error.']);
        return;
    }
} else if ($method === 'GET' && $service === 'fetchDetails') {
    (string) $username = isset($_GET['username']) ? $_GET['username'] : '';

    $user = fetchUser($pdo, $username);
    echo json_encode(['user' => $user]);
    return;
} else if ($method === 'PUT' && $service === 'changePassword') {
    $username = $form_data['username'];
    $oldPassword = $form_data['oldPassword'];
    $newPassword = $form_data['newPassword'];
    $confirmPassword = $form_data['confirmPassword'];
    if (!empty(trim($username)) || !empty(trim($oldPassword)) || !empty(trim($newPassword)) || !empty(trim($confirmPassword))) {
        $user = fetchUser($pdo, $username);

        $hashedPassword = $user['password'];

        try {
            if (password_verify($oldPassword, $hashedPassword)) {
                $passwordhashed = password_hash($newPassword, PASSWORD_DEFAULT);
                $sql = 'UPDATE users SET password = :hashPassword, last_password_change = NOW()  WHERE username = :username';

                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':hashPassword', $passwordhashed, PDO::PARAM_STR);
                $stmt->bindParam(':username', $username, PDO::PARAM_STR);
                if ($stmt->execute()) {

                    (int) $userId = returnUserId();
                    $insertIntoActivity = insertIntoActivity($pdo, 'Password change activity', $userId);

                    $_SESSION = array();
                    session_destroy();
                    echo json_encode(['success' => true, 'message' => 'Password successfully changed']);
                    return;
                }
            }
            if (!password_verify($oldPassword, $user['password'])) {
                echo json_encode(['success' => false, 'message' => "Old password isn't valid"]);
                return;
            }
            if ($newPassword !== $confirmPassword) {
                echo json_encode(['success' => true, 'message' => 'Passwords do not match']);
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
} else if ($method === 'POST' && $service === 'logout') {

    (int) $userId = returnUserId();
    $insertIntoActivity = insertIntoActivity($pdo, 'Logout activity', $userId);
    $_SESSION = array();
    // Destroy the session.
    session_destroy();

    echo json_encode(['success' => true, 'message' => 'Logout successful']);
    return;
} else if ($method === 'GET' && $service === 'getUserActivities') {

    (string) $username = isset($_GET['username']) ? $_GET['username'] : null;
    $today = date('Y-m-d');

    $userActivity = fetchFromDatabase(
        $pdo,
        'activitymanagement a',
        'a.userId, a.created_at, u.username, a.activity',
        "WHERE DATE(a.created_at) = '$today'",
        '',
        'created_at DESC', // Order by most recent sales
        '10',
        "JOIN users u ON a.userId = u.id"
        // Limit to 10 records
    );

    echo json_encode(['userActivity' => $userActivity]);

} else if ($method === 'POST' && $service === 'forgotPassword') {
    $user__name = $form_data['username'];

    if (empty(trim($user__name))) {
        echo json_encode(['success' => false, 'message' => 'Username cannot be empty']);
        return;
    }

    $sql = "SELECT * FROM users WHERE username = :username";
    $stmt = $pdo->prepare($sql);

    $stmt->bindParam(':username', $user__name);
    $stmt->execute();

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (empty($user)) {
        echo json_encode(['success' => false, 'message' => 'Username invalid']);
        return;
    }
    (int) $userId = $user['id'];
    $insertIntoActivity = insertIntoActivity($pdo, 'Password reset activity', $userId);

    if (!$insertIntoActivity) {
        echo json_encode(['success' => false, 'message' => 'Something happened at activity insertion', $user]);
        return;
    }

    (string) $newPassword = generatePassword(8);
    (string) $hashNewPassword = password_hash($newPassword, PASSWORD_DEFAULT);

    $sql = "UPDATE users SET password = :password WHERE username = :username";

    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':password', $hashNewPassword);
    $stmt->bindParam(':username', $user__name);
    
    
    $stmt->execute();
    echo json_encode(['success' => true, 'message' => 'Password reset successful', 'password' => $newPassword, $user__name]);
    return;

}

// Redirect to login page


