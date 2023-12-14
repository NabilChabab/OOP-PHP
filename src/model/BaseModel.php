<?php

namespace App\model;
// require_once "../config/Database.php";
require '../../vendor/autoload.php';
use App\config\Database;


class BaseModel {
    protected $connect;

    public function __construct($cnx) {
        $this->connect = $cnx;
    }

    public function insert($query) {
        $result = mysqli_query($this->connect, $query);
        return $result ? $result : false;
    }

    public function select($query) {
        $result = mysqli_query($this->connect, $query);
        return mysqli_num_rows($result) > 0 ? $result : false;
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
