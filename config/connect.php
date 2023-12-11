<?php
require '../vendor/autoload.php';
$dotenv = \Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

class Database {
    private $host;
    private $username;
    private $password;
    private $db_name;
    private $connect;

    public function __construct() {
        $this->host = $_ENV['DB_SERVERNAME'];
        $this->username = $_ENV['DB_USERNAME'];
        $this->password = $_ENV['DB_PASSWORD'];
        $this->db_name = $_ENV['DB_NAME'];
    }

    public function connect() {
        $this->connect = new mysqli($this->host, $this->username, $this->password, $this->db_name);

        if ($this->connect->connect_error) {
            die("Connection failed: " . $this->connect->connect_error);
        }
        else{
            echo "success";
        }

        return $this->connect;
    }
}

$database = new Database();
$database->connect();