<?php //php for addChargePoint phtml
$view = new stdClass();
$view->error = false;
$view->pageTitle = 'Add Charge Point';
require_once('loginControl.php'); //check if user is logged in
require_once('Models/chargePointDataSet.php'); // allows chargePointDataSet object use


/*
 * If addBtn is pressed the peforms the code nested
 * in the IF statement
 * */
if(isset($_POST['addBtn'])) {
    //$_POST gets the input from user and stores in the variable
    $address = $_POST['address'];
    $city = $_POST['city'];
    $postcode = $_POST['postcode'];
    $lat = $_POST['lat'];
    $lng = $_POST['lng'];
    $cost = $_POST['cost'];

    $strAddress = isset($address) ? trim($address) : false; //trims whitespace so leaves whatever is left or empties variable
    $strCity = isset($city) ? trim($city) : false;
    $strPostcode = isset($postcode) ? trim($postcode) : false;
    $strLat = isset($lat) ? trim($lat) : false;
    $strLng = isset($lng) ? trim($lng) : false;
    $strCost = isset($cost) ? trim($cost) : false;



    if(!empty($strAddress) && !empty($strCity) && !empty($strPostcode)
        && !empty($strLat) && !empty($strLng) && !empty($strCost)){ //checks if input is valid
        $newChargePoint = new chargePointDataSet();
        //adds new charge point (display error message if doesn't work or go to home page if success)
        if($newChargePoint->addChargePoint($address,$city,$postcode,$lat,$lng,$cost)){
            $view->error = true;
            $view->errorMsg = "Error! This charge point already exists";
        }
        else
        {
            header("Location: index.php");
        }
    }
    else{
        $view->error = true;
        $view->errorMsg = "Error! Please input valid information";
    }
}
require_once('Views/addChargePoint.phtml');