<?php
$view = new stdClass();
$view->enquire = true;
$view->pageTitle = 'Contact';
require_once('loginControl.php'); //check if user is logged in
require_once('contactControl.php');

/*
 * If session exist then performs the code nested
 * in the IF statement
 * */
if(isset($_SESSION['chargePointUsername'])){
    //$_POST gets the input from user and stores in the variable
    $view->email = $_SESSION['chargePointUsername'];
    $view->city = $_SESSION['city'];
    $view->address = $_SESSION['address'];
    $view->postcode = $_SESSION['postcode'];
    $view->cost = $_SESSION['cost'];
    require_once('contact.php');
}
require_once('Views/contact.phtml');