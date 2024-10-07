<?php
if(isset($_POST['enquireBtn'])){
    $_SESSION['chargePointUsername'] = $_POST['chargePointUsername'];
    $_SESSION['city'] = $_POST['city'];
    $_SESSION['address'] = $_POST['address'];
    $_SESSION['postcode'] = $_POST['postcode'];
    $_SESSION['cost'] = $_POST['cost'];

    var_dump($_SESSION['chargePointUsername']);
    require_once('contact.php');
}

if(isset($_POST['sendBtn'])){
    header('Location: index.php');
}
