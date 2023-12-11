<?php

require_once "../config/connect.php";
class User {

    private $connect;

    public function __construct() {
        $this->connect = new Database();
    }

    public function showUsers(){
        $query = "SELECT * FROM `user`";
        $result = $this->connect->query($query);
        return $result->fetch_all(MYSQLI_ASSOC);
    }
}

?>