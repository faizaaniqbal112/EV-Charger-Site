<?php
//php for register phtml
$view = new stdClass();
$view->pageTitle = 'Register';
$view->error = false;

require_once('loginControl.php'); //check if user is logged in
require_once('Models/UserDataSet.php'); // allow use of UserDataSet object

/*
* If signUpBtn is pressed the performs the code nested
* in the IF statement
    * */
if(isset($_POST['signUpBtn'])) {
    //$_POST gets the input from user and stores in the variable
    $username = $_POST['username'];
    $fullname = $_POST['fullname'];
    $password = $_POST['password'];

    //creates the path for permanently saving profile pics so can be accessed on a later date
    $target_dir = "images/";
    $target_file = $target_dir . basename($_FILES["profilePic"]["name"]);
    $uploadOk = true;

    $strUsername = isset($username) ? trim($username) : false; //trims whitespace so leaves whatever is left or empties variable
    $strPassword = isset($password) ? trim($password) : false;
    $strFullname = isset($fullname) ? trim($fullname) : false;

    if(!empty($strUsername) && !empty($strPassword) && !empty($strFullname)){ //checks if input is valid

        $profilePic = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

        //checks if image is real
        $check = getimagesize($_FILES["profilePic"]["tmp_name"]);
        if($check !== false) {
            $uploadOk = true;
        } else {
            $uploadOk = false;
        }

        // check file format(Only image files allowed)
        if($profilePic != "jpg" && $profilePic != "png" && $profilePic != "jpeg") {
            $uploadOk = false;
        }

        if (move_uploaded_file($_FILES["profilePic"]["tmp_name"], $target_file)) {
            $uploadOk = true;
        } else {
            $uploadOk = false;
        }
        $newUser = new  UserDataSet();

        //if the profile picture upload has no error registers the user
        if ($uploadOk) {
            //get name for profile pic to store in DB
            $profilePicDb = $_FILES["profilePic"]['name'];
            //calls method of registering using if error, error message shows
            if($newUser->registerUser($username,$fullname,$password, $profilePicDb)){
            $view->error = true;
            $view->errorMsg = "Error! This user already exists";
        }
        else//success goes to home page
        {
            header("Location: index.php");
        }
    }
        else{// gives a null profile pic if no pic has been uploaded
            $profilePicDb = null;
            if($newUser->registerUser($username,$fullname,$password, $profilePicDb)){
                $view->error = true;
                $view->errorMsg = "Error! This user already exists";
            }

        }
    }
    else{//if user input is blank when btn is pressed
        $view->error = true;
        $view->errorMsg = "Error! Please input valid information";
    }
}
require_once('Views/register.phtml');