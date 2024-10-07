<?php
require_once("Models/chargePointDataSet.php");

session_start();

//get q parameter, text type in
$q = $_REQUEST["q"];
$hint = "";

$search = new chargePointDataSet();
$searchData = $search->findChargePoint($q); //calls function for finding charge points
//lookup all hints from array if $q is different from ""
if($q !== ""){
    $q = strtolower($q);
    $len = strlen($q);
    foreach($searchData as $chargePoint){
        //var_dump($chargePoint);
        $city = $chargePoint->getCity();
        if(stristr($q, substr($city, 0, $len))){
            if($hint === ""){
               // $hint = "[" . json_encode($chargePoint);
                $hint = '[
   {
       "_username":"' . $chargePoint->getUsername() . '", 
       "profile_pic":"' . $chargePoint->getProfilePic() .'",
       "city":"' . $chargePoint->getCity() . '",
       "address":"' . $chargePoint->getAddress() . '",
       "postcode":"' . $chargePoint->getPostcode() . '",
       "cost":' . $chargePoint->getCost().
   "}";
            }
            else{
                $hint .= ', {"_username":'  . json_encode($chargePoint->getUsername()) .
                ', "profile_pic":"' . $chargePoint->getProfilePic() .
                '","city":"' . $chargePoint->getCity() .
                '","address":"' . $chargePoint->getAddress() .
                '","postcode":"' . $chargePoint->getPostcode() .
                '","cost":' . $chargePoint->getCost() . "}";
            }
        }
    }
    if($hint != "") $hint .= "]";
}
// retrieve the token
$token="";
//checks if token is valid
if (isset($_SESSION["ajaxToken"])) {
    $token = $_SESSION["ajaxToken"];
}
    // check the token is valid
    if (!isset($_GET["token"]) || $_GET["token"] != $token) {
        $data = new stdClass();
        $data->error = "No data here";
        echo json_encode($data);}
    else {
        echo json_encode($hint) === "" ? "no suggestion" : $hint;
    }



