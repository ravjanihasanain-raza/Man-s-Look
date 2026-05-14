<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include_once "../DBOperations/DBConfig.php";

class AdminProfileController extends DBConfig {

  // ✅ Get Admin Profile
  public function getProfile() {
    $res = $this->Con->query("SELECT Adminid, UserName, FullName, phone, photo FROM adminmaster LIMIT 1");
    if (!$res || $res->num_rows == 0) {
      echo json_encode(["Status" => "Error", "Result" => "No admin found"]);
      return;
    }
    $admin = $res->fetch_assoc();
    echo json_encode(["Status" => "OK", "Result" => $admin]);
  }

  // ✅ Update Profile
  public function updateProfile($data) {
    $photo = null;

    // 🖼️ Handle base64 image upload
    if (!empty($data['base64Photo']) && strpos($data['base64Photo'], 'data:image') === 0) {
      $imageData = explode(',', $data['base64Photo'])[1];
      $decoded = base64_decode($imageData);
      $filename = "admin_" . time() . ".png";
      file_put_contents("../Content/Photo/" . $filename, $decoded);
      $photo = $filename;
    }

    // 🔄 Update query
    if ($photo) {
      $stmt = $this->Con->prepare("UPDATE adminmaster SET FullName=?, phone=?, photo=? WHERE Adminid=1");
      $stmt->bind_param("sss", $data['FullName'], $data['phone'], $photo);
    } else {
      $stmt = $this->Con->prepare("UPDATE adminmaster SET FullName=?, phone=? WHERE Adminid=1");
      $stmt->bind_param("ss", $data['FullName'], $data['phone']);
    }

    if ($stmt->execute()) {
      echo json_encode(["Status" => "OK", "Result" => "✅ Profile updated successfully!"]);
    } else {
      echo json_encode(["Status" => "Error", "Result" => $this->Con->error]);
    }
  }

  // ✅ Change Password
  public function changePassword($data) {
    $stmt = $this->Con->prepare("SELECT Password FROM adminmaster WHERE Adminid=1");
    $stmt->execute();
    $result = $stmt->get_result()->fetch_assoc();

    if (!$result) {
      echo json_encode(["Status" => "Error", "Result" => "Admin not found"]);
      return;
    }

    // Check current password (plain text version)
    if ($result['Password'] !== $data['currentPassword']) {
      echo json_encode(["Status" => "Error", "Result" => "❌ Current password incorrect."]);
      return;
    }

    // Update password
    $update = $this->Con->prepare("UPDATE adminmaster SET Password=? WHERE Adminid=1");
    $update->bind_param("s", $data['newPassword']);
    $update->execute();

    echo json_encode(["Status" => "OK", "Result" => "✅ Password changed successfully!"]);
  }
}

// ✅ Handle request method
$admin = new AdminProfileController();
$method = $_SERVER["REQUEST_METHOD"];

switch($method) {
  case "GET":
    $admin->getProfile();
    break;
  case "PUT":
    $data = json_decode(file_get_contents("php://input"), true);
    $admin->updateProfile($data);
    break;
  case "POST":
    $data = json_decode(file_get_contents("php://input"), true);
    $admin->changePassword($data);
    break;
}
?>
