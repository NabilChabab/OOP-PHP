<?php

session_start();



session_destroy();

setcookie('user_email', '', time() - 3600, '/');

header("location: login.php");
exit();
