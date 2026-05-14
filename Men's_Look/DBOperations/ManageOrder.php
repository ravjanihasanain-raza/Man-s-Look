<?php
ini_set('display_errors', 0);
error_reporting(E_ALL);
include_once "DBConfig.php";

class ManageOrder extends DBConfig
{

  // 🧾 Place a new order
  public function placeOrder($data)
  {
    session_start();
    $user_id = $data->userId ?? '';
    $fullname = $data->fullname ?? '';
    $email    = $data->email ?? '';
    $phone    = $data->phone ?? '';
    $address  = $data->address ?? '';
    $payment  = $data->payment ?? '';
    $currDate = date("y-m-d H:i:s");
    $Query = "INSERT INTO `orders` (`order_id`, `user_id`, `fullname`, `email`, `phone`, `address`, `payment_method`, `order_date`) VALUES 
                                   (NULL, '$user_id', '$fullname', '$email', '$phone', '$address', '$payment', '$currDate');";
    mysqli_query($this->Con, $Query);
    $orderId = mysqli_insert_id($this->Con);

    $Query = "select * from cart as a join products as b on a.product_id = b.product_id where a.user_id = $user_id";
    $res = mysqli_query($this->Con, $Query);
    $err = "";
    while ($row = mysqli_fetch_array($res)) {
      $product_id  = $row["product_id"];
      $quantity  = $row["quantity"];
      $price  = $row["price"];
      $Query = "INSERT INTO `order_items` (`item_id`, `order_id`, `product_id`, `quantity`, `price`) VALUES 
                                          (NULL, '$orderId', '$product_id', '$quantity', '$price');";

      if (!mysqli_query($this->Con, $Query)) {
        $err = $err . mysqli_error($this->Con);
      }
    }

    $Query = "Delete from cart where user_id=$user_id";
    mysqli_query($this->Con, $Query);
    return ["Status" => "OK", "Result" => "Order Successfully Created $err"];
  }

  // 📋 Fetch user’s orders
  public function getOrders($user_id)
  {
    // Always sanitize input to prevent SQL injection
    $user_id = intval($user_id);

    // Run the query directly
    $query = "SELECT * FROM orders WHERE user_id = $user_id ORDER BY order_date DESC";
    $result = mysqli_query($this->Con, $query);

    $orders = [];

    if ($result && mysqli_num_rows($result) > 0) {
      while ($row = mysqli_fetch_assoc($result)) {
        $orders[] = $row;
      }
    }

    return [
      "Status" => "OK",
      "Result" => $orders
    ];
  }

  public function getAllOrders()
  {
    // Run the query directly
    $query = "SELECT * FROM orders ORDER BY order_date DESC";
    $result = mysqli_query($this->Con, $query);

    $orders = [];

    if ($result && mysqli_num_rows($result) > 0) {
      while ($row = mysqli_fetch_assoc($result)) {
        $orders[] = $row;
      }
    }

    return [
      "Status" => "OK",
      "Result" => $orders
    ];
  }



  // 📦 Get order details (items)
  public function getOrderDetails($order_id)
  {
    $stmt = $this->Con->prepare("SELECT oi.*, p.product_name, p.image_url 
      FROM order_items oi
      JOIN products p ON oi.product_id = p.product_id
      WHERE oi.order_id = ?");
    $stmt->bind_param("i", $order_id);
    $stmt->execute();
    $res = $stmt->get_result();
    $items = [];
    while ($row = $res->fetch_assoc()) $items[] = $row;
    return ["Status" => "OK", "Result" => $items];
  }
}
