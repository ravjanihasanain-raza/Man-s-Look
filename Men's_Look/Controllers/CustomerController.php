<?php
include_once "../DBOperations/DBConfig.php";

class CustomerController extends DBConfig {

  // ✅ Get All Customers
  public function getAllCustomers() {
    $res = $this->Con->query("SELECT * FROM users ORDER BY id DESC");
    $data = [];
    while($row = $res->fetch_assoc()) $data[] = $row;
    echo json_encode(["Status" => "OK", "Result" => $data]);
  }

  // ✅ Get Single Customer
  public function getCustomer($id) {
    $stmt = $this->Con->prepare("SELECT * FROM users WHERE id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result()->fetch_assoc();
    echo json_encode(["Status" => "OK", "Result" => $result]);
  }

  // ✅ Update Status
  public function updateCustomer($data) {
    $stmt = $this->Con->prepare("UPDATE users SET status=? WHERE id=?");
    $stmt->bind_param("si", $data['status'], $data['id']);
    if($stmt->execute()) echo json_encode(["Status" => "OK", "Result" => "Status updated successfully!"]);
    else echo json_encode(["Status" => "Error", "Result" => $this->Con->error]);
  }

  // ✅ Delete Customer
  public function deleteCustomer($id) {
    $stmt = $this->Con->prepare("DELETE FROM users WHERE id=?");
    $stmt->bind_param("i", $id);
    if($stmt->execute()) echo json_encode(["Status" => "OK", "Result" => "Customer deleted successfully!"]);
    else echo json_encode(["Status" => "Error", "Result" => $this->Con->error]);
  }
}

$customer = new CustomerController();
$method = $_SERVER["REQUEST_METHOD"];

switch($method) {
  case "GET":
    if(isset($_GET["ID"])) $customer->getCustomer($_GET["ID"]);
    else $customer->getAllCustomers();
    break;

  case "PUT":
    $data = json_decode(file_get_contents("php://input"), true);
    $customer->updateCustomer($data);
    break;

  case "DELETE":
    $id = $_GET["ID"];
    $customer->deleteCustomer($id);
    break;
}
?>
