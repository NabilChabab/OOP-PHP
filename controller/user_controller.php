<?php

require_once '../model/user_model.php';

class UserController
{
    private $userModel;

    public function __construct($db)
    {
        $this->userModel = new User($db);
    }

    public function show_controller(){
        return $this->userModel->showUsers();
    }
}
