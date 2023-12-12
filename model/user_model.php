<?php


require "../config/connect.php";
session_start();
class User extends Database
{
    private $db;

    public function __construct(Database $db)
    {
        $this->db = $db;
    }

    public function Adduser($data, $file){
        $name = $data["first_name"];
        $lname = $data["last_name"];
        $email = $data["email"];
        $password = $data["password"];
        $gender = $data["gender"];
        $cin = $data["cin"];
        $role = $data["role"];
        $file_name = $file['image']['name'];
        $file_temp = $file['image']['tmp_name'];
        $upload_image = "../assets/images/" . $file_name;
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);


        if (empty($name) || empty($email) || empty($gender) || empty($cin) || empty($file_name)) {
            $msg = 'Fill All Inputs!';
            return $msg;
        } else {
            $select = "SELECT * FROM `user` WHERE `email` = '$email'";
            $result = $this->db->select($select);
            if ($result !== false && mysqli_num_rows($result) > 0) {
                $msg = "User Alraedy exist!";
            } else {
                move_uploaded_file($file_temp, $upload_image);
                $query = "INSERT INTO `user`(`first_name`,`last_name`, `email`, `password`, `gender`, `profile`, `cin` , `role_id`) VALUES ('$name','$lname','$email','$hashedPassword','$gender','$upload_image','$cin','$role')";
                $result = $this->db->insert($query);
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

    public function Login($data){
        $email = $data["email"];
        $password = $data["password"];
        $remember_me = isset($_POST['rememberMe']);
    
        if (empty($email) || empty($password)) {
            $msg = 'Fill All Inputs!';
            return $msg;
        } else {
            $login = "SELECT * FROM `user` WHERE `email` = '$email'";
            $result = $this->db->select($login);
    
            if ($result !== false && mysqli_num_rows($result) > 0) {
                $row = $result->fetch_assoc();
    
                if (password_verify($password, $row['password'])) {
                    if ($row['role_id'] == 1) {
                        $_SESSION['admin_role'] = $row['role_id'];
                        if ($remember_me) {                    
                            setcookie('user_email', $email, time() + (24 * 3600), '/'); 
                        }
                        header('location:../view/home.php?welcomeadmin');
                        exit(); 
                    } elseif ($row['role_id'] == 2) {
                        $_SESSION['user_role'] = $row['role_id'];
                        if ($remember_me) {
                            setcookie('user_email', $email, time() + (24 * 3600), '/'); 
                        }
                        header('location:../view/home.php?welcomeuser');
                        exit(); 
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
    

    public function Showuser(){
        $query = "SELECT * FROM `user` ORDER BY `first_name` ASC";
        $result = $this->db->select($query);
        return $result;
    }

    public function Showuserlimit(){
        $query = "SELECT * FROM `user` ORDER BY `first_name` ASC LIMIT 4";
        $result = $this->db->select($query);
        return $result;
    }

    public function getUserbyId($id){
        $query = "SELECT * FROM `user` WHERE id = '$id'";
        $result = $this->db->select($query);
        return $result;
    }

    public function Updateuser($data, $file, $id){
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
            $result = $this->db->update($query);
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

    public function Deleteuser($id)
    {
        $query = "DELETE FROM `user` WHERE id = $id";
        $result = $this->db->delete($query);
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