<?php

include_once "../model/user_model.php";
$user = new User();


if($_SERVER['REQUEST_METHOD'] == 'POST' ){
   if(isset($_POST['submit'])){
    if (isset($_GET['id'])) {
        $id = base64_decode($_GET['id']);
        $update = $user->Updateuser($_POST, $_FILES, $id);
    } else {
        $add = $user->Adduser($_POST, $_FILES);
    }
   }
}

if (isset($_GET['id']) && isset($_GET['delete'])) {
    $id = base64_decode($_GET['id']);
    $delete = $user->Deleteuser($id);
}
?>