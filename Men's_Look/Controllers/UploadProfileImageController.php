<?php
session_start();
include_once "../DBConfig.php";

$response = ["Status" => "Error", "Message" => "Something went wrong"];

if (!isset($_SESSION['user']['id'])) {
  echo json_encode(["Status" => "Error", "Message" => "Not logged in"]);
  exit();
}

$userId = $_SESSION['user']['id'];
$uploadDir = "../uploads/profile/";

if (!file_exists($uploadDir)) {
  mkdir($uploadDir, 0777, true);
}

if (!empty($_FILES['profile_image']['name'])) {
  $fileName = time() . "_" . basename($_FILES["profile_image"]["name"]);
  $targetFile = $uploadDir . $fileName;
  $fileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

  $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];
  if (in_array($fileType, $allowedTypes)) {
    if (move_uploaded_file($_FILES["profile_image"]["tmp_name"], $targetFile)) {
      $conn = mysqli_connect("localhost", "root", "", "menslookdb");
      $sql = "UPDATE users SET profile_image='$fileName' WHERE id='$userId'";
      if (mysqli_query($conn, $sql)) {
        $_SESSION['user']['profile_image'] = $fileName;
        $response = ["Status" => "Ok", "Message" => "Profile picture updated successfully"];
      }
    }
  } else {
    $response = ["Status" => "Error", "Message" => "Invalid image type"];
  }
}

echo json_encode($response);
