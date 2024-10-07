<?php
require_once('UserDataSet.php');

//User object which contains method relating to user
class User
{
    var $passwordInput = "", $usernameInput = "";

    public function __construct($usernameInput, $passwordInput)
    {
        $this->passwordInput = $passwordInput;
        $this->usernameInput = $usernameInput;
    }


    //validates user login
    function authenticateUser(){
        $UserDataSet = new UserDataSet();
        return $UserDataSet->authenticateUser($this->usernameInput, $this->passwordInput);
    }

    //register the new user
    function registerUser($fullname, $profilePic){
        $UserDataSet = new UserDataSet();
        $UserDataSet->registerUser($this->usernameInput, $fullname, $this->passwordInput, $profilePic);
    }
}