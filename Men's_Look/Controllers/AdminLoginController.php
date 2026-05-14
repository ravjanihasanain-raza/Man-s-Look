<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include_once "../DBOperations/DBConfig.php";

class AdminLoginController extends DBConfig {

  // ✅ Login Logic
  public function login($data) {
    $username = trim($data['username']);
    $password = trim($data['password']);

    $stmt = $this->Con->prepare("SELECT Adminid, UserName, Password, FullName, photo FROM adminmaster WHERE UserName=? LIMIT 1");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
      echo json_encode(["Status" => "Error", "Result" => "❌ Invalid username"]);
      return;
    }

    $admin = $result->fetch_assoc();

    if ($admin['Password'] !== $password) {
      echo json_encode(["Status" => "Error", "Result" => "❌ Incorrect password"]);
      return;
    }

    // ✅ Generate simple token (you can improve this with JWT later)
    $token = base64_encode($admin['Adminid'] . "|" . time());

    // ✅ Send admin details + token
    echo json_encode([
      "Status" => "OK",
      "Result" => [
        "token" => $token,
        "Adminid" => $admin['Adminid'],
        "FullName" => $admin['FullName'],
        "UserName" => $admin['UserName'],
        "photo" => $admin['photo']
      ]
    ]);
  }
}

$admin = new AdminLoginController();
$method = $_SERVER['REQUEST_METHOD'];

if ($method === "POST") {
  $data = json_decode(file_get_contents("php://input"), true);
  $admin->login($data);
}
?>
