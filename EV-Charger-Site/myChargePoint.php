<?php
//php for my charge point phtml
$view = new stdClass();
$view->search = false;
$view->pageTitle = 'Home';
require_once('loginControl.php'); //cehecks if user is logged in
require_once('Models/chargePointDataSet.php');
$myChargePoint = new chargePointDataSet();
$view->chargePointDataSet = $myChargePoint->getMyChargePoints($_SESSION['username']); //calls method to get chargepoint

/*
* If deleteBtn is pressed the performs the code nested
* in the IF statement
    * */
if(isset($_POST['deleteBtn'])){
    $myChargePoint->deleteChargePoint($_SESSION['username']); //calls method to delete charge point
}

require_once('Views/myChargePoints.phtml');
