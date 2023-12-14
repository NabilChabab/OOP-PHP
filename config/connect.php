<?php

require '../vendor/autoload.php';
require_once "../model/base_model.php";

class Database extends BaseModel {
    private $host;
    private $username;
    private $password;
    private $db_name;

    public function __construct() {
        $dotenv = \Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
        $dotenv->load();
        $this->host = $_ENV['DB_SERVERNAME'];
        $this->username = $_ENV['DB_USERNAME'];
        $this->password = $_ENV['DB_PASSWORD'];
        $this->db_name = $_ENV['DB_NAME'];

        $cnx = mysqli_connect($this->host, $this->username, $this->password, $this->db_name);

        if (!$cnx) {
            die("Connection failed: " . mysqli_connect_error());
        }

        parent::__construct($cnx);
    }
}
?>
