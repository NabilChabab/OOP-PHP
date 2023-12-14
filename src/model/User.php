<?php

namespace App\model;

require '../../vendor/autoload.php';
// require_once "../config/connect.php";
// require_once "BaseModel.php";
use App\config\Database;
use App\model\BaseModel;



session_start();
class User extends BaseModel{

    public function __construct() {
        parent::__construct(Database::connect());
    }

    public function addUser($data, $file){
        $name = $data["first_name"];
        $lname = $data["last_name"];
        $email = $data["email"];
        $password = $data["password"];
        $gender = $data["gender"];
        $cin = $data["cin"];
        $role = $data["role"];
        $file_name = $file['image']['name'];
        $file_temp = $file['image']['tmp_name'];
        $upload_image = "../../assets/images/" . $file_name;
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);


        if (empty($name) || empty($email) || empty($gender) || empty($cin) || empty($file_name)) {
            $msg = 'Fill All Inputs!';
            return $msg;
        } else {
            $select = "SELECT * FROM `user` WHERE `email` = '$email'";
            $result = $this->select($select);
            if ($result !== false && mysqli_num_rows($result) > 0) {
                $msg = "User Alraedy exist!";
            } else {
                move_uploaded_file($file_temp, $upload_image);
                $query = "INSERT INTO `user`(`first_name`,`last_name`, `email`, `password`, `gender`, `profile`, `cin` , `role_id`) VALUES ('$name','$lname','$email','$hashedPassword','$gender','$upload_image','$cin','$role')";
                $result = $this->insert($query);
                if ($result) {
                    $msg = 'User Added With Success';
                    return $msg;
                } else {
                    $msg = 'User Added With Error';
                    return $msg;
                }
            }
        }
    }

    public function login($data){
        $email = $data["email"];
        $password = $data["password"];
        $remember_me = isset($_POST['rememberMe']);
    
        if (empty($email) || empty($password)) {
            $msg = 'Fill All Inputs!';
            return $msg;
        } else {
            $login = "SELECT * FROM `user` WHERE `email` = '$email'";
            $result = $this->select($login);
    
            if ($result !== false && mysqli_num_rows($result) > 0) {
                $row = $result->fetch_assoc();
    
                if (password_verify($password, $row['password'])) {
                    $_SESSION['user_image'] = $row['profile'];
                    if ($row['role_id'] == 1) {
                        $_SESSION['admin_role'] = $row['role_id'];
                        if ($remember_me) {                    
                            setcookie('user_email', $email, time() + (24 * 3600), '/');
                            setcookie('user_name', $row['first_name'], time() + (24 * 3600), '/');
                        }
                        return 'welcomeadmin';
                    } elseif ($row['role_id'] == 2) {
                        $_SESSION['user_role'] = $row['role_id'];
                        if ($remember_me) {
                            setcookie('user_email', $email, time() + (24 * 3600), '/'); 
                            setcookie('user_name', $row['first_name'], time() + (24 * 3600), '/');
                        }
                        return 'welcomeuser';
                    } 
                } else {
                    $msg = "Incorrect password!";
                }
            } else {
                $msg = "User does not exist!";
            }
    
            return $msg;
        }
    }
    

    public function showUser(){
        $query = "SELECT * FROM `user` ORDER BY `first_name` ASC";
        $result = $this->select($query);
        return $result;
    }

    public function showUserLimit(){
        $query = "SELECT * FROM `user` ORDER BY `first_name` ASC LIMIT 4";
        $result = $this->select($query);
        return $result;
    }

    public function getUserbyId($id){
        $query = "SELECT * FROM `user` WHERE id = '$id'";
        $result = $this->select($query);
        return $result;
    }

    public function updateUser($data, $file, $id){
        $name = $data["first_name"];
        $lname = $data["last_name"];
        $email = $data["email"];
        $gender = $data["gender"];
        $cin = $data["cin"];
        $file_name = $file['image']['name'];
        $file_temp = $file['image']['tmp_name'];
        $upload_image = "../assets/images/" . $file_name;


        if (empty($name) || empty($email) || empty($gender) || empty($cin)) {
            $msg = 'Fill All Inputs!';
            return $msg;
        } else {
            move_uploaded_file($file_temp, $upload_image);
            $query = "UPDATE `user` SET `first_name` = '$name',`last_name` = '$lname', `email` = '$email', `gender` = '$gender', `cin` = '$cin' WHERE id = $id";
            $result = $this->update($query);
            if ($result) {
                $msg = 'User Updated With Success';
                header('location:../view/home.php');
                return $msg;
            } else {
                $msg = 'Fail!!';
                return $msg;
            }
        }
    }

    public function deleteUser($id){
        $query = "DELETE FROM `user` WHERE id = $id";
        $result = $this->delete($query);
        if ($result) {
            $msg = "User Deleted Successfully!";
            return $msg;
        } else {
            $msg = "Fail!";
            return $msg;
        }
    }

    
}
?>