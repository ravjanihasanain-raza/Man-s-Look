<?php
class DBConfig {
    public $Con;
    public $conn;

    private $host = "localhost";
    private $user = "root";
    private $password = "";
    private $database = "menslookdb"; // change if needed

    public function __construct() {
        $this->Con = mysqli_connect($this->host, $this->user, $this->password, $this->database);
        $this->conn = $this->Con;

        if (!$this->Con) {
            die("Database connection failed: " . mysqli_connect_error());
        }
    }
}
?>
