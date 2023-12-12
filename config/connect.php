<?php

require '../vendor/autoload.php';

class Database {
    private $host;
    private $username;
    private $password;
    private $db_name;
    protected $connect;
    public function __construct() {
        $dotenv = \Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
        $dotenv->load();
        $this->host = $_ENV['DB_SERVERNAME'];
        $this->username = $_ENV['DB_USERNAME'];
        $this->password = $_ENV['DB_PASSWORD'];
        $this->db_name = $_ENV['DB_NAME'];
        $this->connect();
    }

    private function connect() {
        $this->connect = mysqli_connect($this->host, $this->username, $this->password, $this->db_name);

        if (!$this->connect) {
            die("Connection failed: " . mysqli_connect_error());
        }
    }

    public function insert($query) {
        $result = mysqli_query($this->connect, $query);

        return $result ? $result : false;
    }

    public function select($query) {
        $result = mysqli_query($this->connect, $query);
    
        if ($result === false) {
            die('Error in SQL query: ' . mysqli_error($this->connect));
        }
    
        return $result;
    }

    public function update($query) {
        $result = mysqli_query($this->connect, $query);

        return $result ? $result : false;
    }

    public function delete($query) {
        $result = mysqli_query($this->connect, $query);

        return $result ? $result : false;
    }
}
?>
