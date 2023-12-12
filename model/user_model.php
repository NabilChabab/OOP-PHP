<?php


require "../config/connect.php";

class User {
    public $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function Adduser($data , $file){
        $name = $data["first_name"];
        $lname = $data["last_name"];
        $email = $data["email"];
        $gender = $data["gender"];
        $cin = $data["cin"];
        $file_name = $file['image']['name'];
        $file_temp = $file['image']['tmp_name'];
        $upload_image = "../assets/images/".$file_name;
        
        
        if(empty($name) || empty($email) || empty($gender)  || empty($cin) || empty($file_name)) {
            $msg = 'Fill All Inputs!';
            return $msg;
        }
        else {
            move_uploaded_file($file_temp , $upload_image);
            $query = "INSERT INTO `user`(`first_name`,`last_name`, `email`, `gender`, `profile`, `cin`) VALUES ('$name','$lname','$email','$gender','$upload_image','$cin')";
            $result = $this->db->insert($query);
            if($result) {
                $msg = 'User Added With Success';
                return $msg;
            }
            else{
                $msg = 'User Added With Error';
                return $msg;
            }
        }
    }

    public function Showuser(){
        $query = "SELECT * FROM `user`";
        $result = $this->db->select($query);
        return $result;
    }

    public function getUserbyId($id){
        $query = "SELECT * FROM `user` WHERE id = '$id'";
        $result = $this->db->select($query);
        return $result;
    }

    public function Updateuser($data , $file , $id){
        $name = $data["first_name"];
        $lname = $data["last_name"];
        $email = $data["email"];
        $gender = $data["gender"];
        $cin = $data["cin"];
        $file_name = $file['image']['name'];
        $file_temp = $file['image']['tmp_name'];
        $upload_image = "../assets/images/".$file_name;
        
        
        if(empty($name) || empty($email) || empty($gender)  || empty($cin)) {
            $msg = 'Fill All Inputs!';
            return $msg;
        }
        else {
            move_uploaded_file($file_temp , $upload_image);
            $query = "UPDATE `user` SET `first_name` = '$name',`last_name` = '$lname', `email` = '$email', `gender` = '$gender', `cin` = '$cin' WHERE id = $id";
            $result = $this->db->update($query);
            if($result) {
                $msg = 'User Updated With Success';
                header('location:../view/home.php');
                return $msg;
            }
            else{
                $msg = 'Fail!!';
                return $msg;
            }
        }
    }

    public function Deleteuser($id){
        $query = "DELETE FROM `user` WHERE id = $id";
        $result = $this->db->delete($query);
        if($result){
            $msg = "User Deleted Successfully!";
            return $msg;
        }
        else{
            $msg = "Fail!";
            return $msg;
        }
    }
}
?>