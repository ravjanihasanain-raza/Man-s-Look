<?php
session_start();
include_once "../DBConfig.php";
$conn = new mysqli("localhost", "root", "", "menslookdb");

$userId = $_SESSION['user']['id'];
$current = $_POST['current_password'];
$new = $_POST['new_password'];
$confirm = $_POST['confirm_password'];

if ($new !== $confirm) {
  echo json_encode(["Status" => "Error", "Message" => "Passwords do not match"]);
  exit();
}

$res = $conn->query("SELECT password FROM users WHERE id='$userId'");
$row = $res->fetch_assoc();

if (!password_verify($current, $row['password'])) {
  echo json_encode(["Status" => "Error", "Message" => "Current password is incorrect"]);
  exit();
}

$hashed = password_hash($new, PASSWORD_BCRYPT);
if ($conn->query("UPDATE users SET password='$hashed' WHERE id='$userId'")) {
  echo json_encode(["Status" => "Ok", "Message" => "Password updated successfully"]);
} else {
  echo json_encode(["Status" => "Error", "Message" => "Failed to update password"]);
}
