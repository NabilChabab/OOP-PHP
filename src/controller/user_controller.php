<?php

use App\model\User;

require '../../vendor/autoload.php';

$user = new User();


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['submit'])) {
        if (isset($_GET['id'])) {
            $id = base64_decode($_GET['id']);
            $update = $user->updateUser($_POST, $_FILES, $id);
        } else {
            $add = $user->addUser($_POST, $_FILES);
        }
    }
    elseif (isset($_POST['login'])) {
        $login = $user->login($_POST);
        if ($login === "User does not exist!" || $login === "Incorrect password!") {
            $msg = $login;
        } elseif ($login === "welcomeuser") {
            header('location: ../view/home.php?welcomeuser');
            exit();
        } elseif ($login === "welcomeadmin") {
            header('location: ../view/home.php?welcomeadmin');
            exit();
        }
    }
    
}

if (isset($_GET['id']) && isset($_GET['delete'])) {
    $id = base64_decode($_GET['id']);
    $delete = $user->deleteUser($id);
}
?>