<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
require_once "../DBOperations/ManageOrder.php";
header("Content-Type: application/json");

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['order_id'])) {
    $order_id = intval($_GET['order_id']);
    $order = new ManageOrder();
    $result = $order->getOrderDetails($order_id);
    echo json_encode($result);
    exit;
} else {
    echo json_encode(["Status" => "Fail", "Result" => "Invalid request"]);
    exit;
}
