<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include_once "../DBOperations/ManageUser.php";
$user = new ManageUser();


if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $action = $_POST["action"] ?? "";
    switch ($action) {

        // 🧾 Register new user
        case "register":
            $name = $_POST["name"] ?? '';
            $email = $_POST["email"] ?? '';
            $password = $_POST["password"] ?? '';
            $ContactNo = $_POST["ContactNo"] ?? '';
            echo json_encode($user->registerUser($name, $email, $password, $ContactNo));
        break;


        // 🔐 Login user
        case "login":
            $email = $_POST["email"] ?? '';
            $password = $_POST["password"] ?? '';

            $res = $user->loginUser($email, $password);

            if ($res["Status"] === "Ok" && isset($res["User"])) {
                $_SESSION["user"] = $res["User"];
                $_SESSION["UserID"] = $res["User"]["id"];
            }

            echo json_encode($res);
            break;


        // ✏️ Update profile details (name, email, mobile)
        case "updateProfile":
            $userId = $_POST["UserID"];
            $name = $_POST["name"] ?? '';
            $email = $_POST["email"] ?? '';
            $mobile = $_POST["mobile"] ?? '';

            $result = $user->updateUser($userId, $name, $email, $mobile);
            echo json_encode($result);
            break;


        // 🔒 Change password
        case "changePassword":
            $userId = $_POST["UserPassID"];
            $currentPassword = $_POST["current_password"] ?? '';
            $newPassword = $_POST["new_password"] ?? '';
            $confirmPassword = $_POST["confirm_password"] ?? '';

            if ($newPassword !== $confirmPassword) {
                echo json_encode(["Status" => "Error", "Message" => "New passwords do not match."]);
            }
            else
            {
                $result = $user->changePassword($userId, $currentPassword, $newPassword);
                echo json_encode($result);
            }
        break;


        // 🚪 Logout user
        case "logout":
            session_unset();
            session_destroy();
            echo json_encode(["Status" => "Ok", "Message" => "Logged out successfully."]);
            break;


        // 🧩 Invalid action
        default:
            echo json_encode(["Status" => "Error", "Message" => "Invalid action."]);
    }
} else if ($_SERVER["REQUEST_METHOD"] === "GET") {

    $Choice = $_REQUEST["Choice"] ?? "";

    switch ($Choice) {

        // 👤 Get user profile details
        case "Profile":
            $UserId = $_REQUEST["UserId"] ?? 0;
            echo json_encode($user->getUser($UserId));
            break;

        default:
            echo json_encode(["Status" => "Error", "Message" => "Invalid request."]);
    }
}
