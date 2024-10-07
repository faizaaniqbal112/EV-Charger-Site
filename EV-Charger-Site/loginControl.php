<?php
//log in check
session_start();
$view->display = true;
$view->incorrect = false;
require_once('Models/User.php'); // allows use of user object


/*
 * If signInBtn is pressed the performs the code nested
 * in the IF statement
 * */
if (isset($_POST['signInBtn'])){
    //$_POST gets the input from user and stores in the variable
    $username = $_POST['username'];
    $password = $_POST['password'];

    $user = new User($username, $password);
    $authentic = $user->authenticateUser(); //calls method to check user login details



    //creates session and changes true to false in variable so logged in user can use sit
    //if true
    if($authentic){
        $view->display = false;
        $view->incorrect = false;
        $_SESSION['username'] = $username;
        $_SESSION['password'] = $password;

    }
    else{
        $view->incorrect = true;
        $view->incorrectMsg = "Incorrect username/password";
    }
}
else{
    //checks if session already exists so user can maintain state
    if(isset($_SESSION['username']) && isset($_SESSION['password'])){
        $view->display = false;
    }
}

/*
 * If signOutBtn is pressed the performs the code nested
 * in the IF statement
 * unsets session changes display to true so logged out
 * user can't use the sites functions
 * */
if (isset($_POST['signOutBtn'])){
    unset($_SESSION['username']);
    unset($_SESSION['password']);
    $view->display = true;
    header('Location: index.php');
}