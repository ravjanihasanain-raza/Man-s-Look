<?php
session_start();
include_once "../DBOperations/DBConfig.php";

class CartController extends DBConfig {

  // ✅ Add product to cart
  public function addToCart($userId, $productId, $quantity) {
    $check = $this->Con->prepare("SELECT * FROM cart WHERE user_id=? AND product_id=?");
    $check->bind_param("ii", $userId, $productId);
    $check->execute();
    $result = $check->get_result();

    if ($result->num_rows > 0) {
      $update = $this->Con->prepare("UPDATE cart SET quantity = quantity + ? WHERE user_id=? AND product_id=?");
      $update->bind_param("iii", $quantity, $userId, $productId);
      $update->execute();
    } else {
      $insert = $this->Con->prepare("INSERT INTO cart (user_id, product_id, quantity) VALUES (?, ?, ?)");
      $insert->bind_param("iii", $userId, $productId, $quantity);
      $insert->execute();
    }

    $countQuery = $this->Con->prepare("SELECT SUM(quantity) as total FROM cart WHERE user_id=?");
    $countQuery->bind_param("i", $userId);
    $countQuery->execute();
    $countRes = $countQuery->get_result()->fetch_assoc();

    return [
      "Status" => "Ok",
      "Message" => "Product added to your cart successfully!",
      "CartCount" => $countRes['total'] ?? 0
    ];
  }

  // ✅ Get all cart items
  public function getCart($userId) {
    $query = $this->Con->prepare("
      SELECT c.*, p.product_name, p.price, p.discount_price, p.image_url 
      FROM cart c
      JOIN products p ON c.product_id = p.product_id
      WHERE c.user_id=?
    ");
    $query->bind_param("i", $userId);
    $query->execute();
    $res = $query->get_result();
    $data = [];
    while ($row = $res->fetch_assoc()) {
      $data[] = $row;
    }
    return ["Status" => "Ok", "Result" => $data];
  }

  // ✅ Update quantity
  public function updateQuantity($userId, $productId, $quantity) {
    $update = $this->Con->prepare("UPDATE cart SET quantity=? WHERE user_id=? AND product_id=?");
    $update->bind_param("iii", $quantity, $userId, $productId);
    $update->execute();
    return ["Status" => "Ok", "Message" => "Quantity updated successfully."];
  }

  // ✅ Remove product
  public function removeFromCart($userId, $productId) {
    $delete = $this->Con->prepare("DELETE FROM cart WHERE user_id=? AND product_id=?");
    $delete->bind_param("ii", $userId, $productId);
    $delete->execute();
    return ["Status" => "Ok", "Message" => "Product removed from your cart."];
  }
}

$db = new CartController();

// ✅ Check if user logged in
if (!isset($_SESSION['UserID'])) {
  echo json_encode(["Status" => "Error", "Message" => "Please login to add products to cart."]);
  exit;
}

$userId = $_SESSION['UserID'];
$method = $_SERVER['REQUEST_METHOD'];

// ✅ Handle different HTTP methods
switch ($method) {
  case "POST":
    $productId = $_POST['product_id'] ?? 0;
    $quantity = $_POST['quantity'] ?? 1;
    $userId = $_POST['UserId'];
    echo json_encode($db->addToCart($userId, $productId, $quantity));
    break;

  case "GET":
    $UserId = $_REQUEST["UserId"];
    echo json_encode($db->getCart($userId));
    break;

  case "PUT":
    $data = json_decode(file_get_contents("php://input"), true);
    echo json_encode($db->updateQuantity($data['UserId'], $data['product_id'], $data['quantity']));
    break;

  case "DELETE":
    $id = $_GET['ID'] ?? 0;
    $UserId = $_REQUEST["UserId"];
    echo json_encode($db->removeFromCart($UserId, $id));
    break;

  default:
    echo json_encode(["Status" => "Error", "Message" => "Invalid request method."]);
}
?>
