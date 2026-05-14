<?php
include_once "../DBOperations/DBConfig.php";

class AdminProfileController extends DBConfig {

  // ✅ Get Admin Profile
  public function getProfile() {
    $res = $this->Con->query("SELECT * FROM admin WHERE id = 1");
    $admin = $res->fetch_assoc();
    echo json_encode(["Status" => "OK", "Result" => $admin]);
  }

  // ✅ Update Profile Info
  public function updateProfile($data) {
    $photo = null;

    if (!empty($data['base64Photo']) && strpos($data['base64Photo'], 'data:image') === 0) {
      $imageData = explode(',', $data['base64Photo'])[1];
      $decoded = base64_decode($imageData);
      $filename = "admin_" . time() . ".png";
      file_put_contents("../Content/Photo/" . $filename, $decoded);
      $photo = $filename;
    }

    if ($photo) {
      $stmt = $this->Con->prepare("UPDATE admin SET name=?, email=?, phone=?, photo=? WHERE id=1");
      $stmt->bind_param("ssss", $data['name'], $data['email'], $data['phone'], $photo);
    } else {
      $stmt = $this->Con->prepare("UPDATE admin SET name=?, email=?, phone=? WHERE id=1");
      $stmt->bind_param("sss", $data['name'], $data['email'], $data['phone']);
    }

    if ($stmt->execute()) echo json_encode(["Status" => "OK", "Result" => "Profile updated successfully!"]);
    else echo json_encode(["Status" => "Error", "Result" => $this->Con->error]);
  }

  // ✅ Change Password
  public function changePassword($data) {
    $stmt = $this->Con->prepare("SELECT password FROM admin WHERE id=1");
    $stmt->execute();
    $result = $stmt->get_result()->fetch_assoc();

    if (!password_verify($data['currentPassword'], $result['password'])) {
      echo json_encode(["Status" => "Error", "Result" => "❌ Current password incorrect."]);
      return;
    }

    $newPassword = password_hash($data['newPassword'], PASSWORD_BCRYPT);
    $update = $this->Con->prepare("UPDATE admin SET password=? WHERE id=1");
    $update->bind_param("s", $newPassword);
    $update->execute();

    echo json_encode(["Status" => "OK", "Result" => "✅ Password changed successfully!"]);
  }
}

$admin = new AdminProfileController();
$method = $_SERVER["REQUEST_METHOD"];

switch($method) {
  case "GET": $admin->getProfile(); break;
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
