<?php
include_once "../DBOperations/DBConfig.php";

class DashboardController extends DBConfig {
    public function getStats() {
        $stats = [];

        // ✅ Total Counts
        $tables = [
            "products" => "SELECT COUNT(*) AS cnt FROM products",
            "categories" => "SELECT COUNT(*) AS cnt FROM categories",
            "orders" => "SELECT COUNT(*) AS cnt FROM orders",
            "customers" => "SELECT COUNT(*) AS cnt FROM users",
            "blogs" => "SELECT COUNT(*) AS cnt FROM blogs"
        ];

        foreach ($tables as $key => $query) {
            $res = $this->Con->query($query);
            $stats[$key] = $res ? $res->fetch_assoc()['cnt'] : 0;
        }

        // ✅ Weekly Order Chart Data
        $stats['orderStats'] = [12, 19, 7, 15, 20, 13, 9];

        // ✅ Recent Data Lists
        $stats['recentOrders'] = $this->fetchData("SELECT fullname, DATE_FORMAT(order_date, '%d %b') as order_date FROM orders ORDER BY order_id DESC LIMIT 5");
        $stats['recentCustomers'] = $this->fetchData("SELECT name, email FROM users ORDER BY id DESC LIMIT 5");
        $stats['recentBlogs'] = $this->fetchData("SELECT Title, Category FROM blogs ORDER BY BlogId DESC LIMIT 5");

        echo json_encode($stats);
    }

    private function fetchData($query) {
        $res = $this->Con->query($query);
        $data = [];
        while ($row = $res->fetch_assoc()) {
            $data[] = $row;
        }
        return $data;
    }
}

$dashboard = new DashboardController();
$dashboard->getStats();
?>
