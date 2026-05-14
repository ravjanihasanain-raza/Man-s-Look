<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once "../DBOperations/ManageOrder.php";
header("Content-Type: application/json");

// Start session to access user_id
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Instantiate class
$order = new ManageOrder();

// 🧾 Handle POST (Place Order)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $raw = file_get_contents("php://input");
        
        $data = json_decode($raw);
        
        // Call your DB operation
        $result = $order->placeOrder($data);

        echo json_encode($result);
    } catch (Exception $exp) {
        echo json_encode([
            "Status" => "Fail",
            "Result" => $exp->getMessage()
        ]);
    }
    exit;
}


// 📋 Handle GET (Fetch User Orders)
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    
    $choice = $_REQUEST["Choice"];

    switch ($choice){
        case "UserOrder" : 
            $user_id = $_REQUEST['user_id'];
            $result = $order->getOrders($user_id);
            echo json_encode($result);
        break;
        case "AdminOrder" : 
            $result = $order->getAllOrders();
            echo json_encode($result);
        break;
    }

    exit;
}
?>
