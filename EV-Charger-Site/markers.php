<?php
require_once("Models/chargePointDataSet.php");

$data = new chargePointDataSet(); //new object created
$chargePointData = $data->fetchAllChargePoints(); //calls method to get all chargePoint data from mySQl
$JSON = "";

//goes through each item in array and converts to JSON
foreach($chargePointData as $chargePoint){
    if($JSON == ""){
    $JSON = '[
    {
       "_id":' . $chargePoint->getChargePointId() . ', 
       "address":"' . $chargePoint->getAddress() .'",
       "city":"' . $chargePoint->getCity() . '",
       "postcode":"' . $chargePoint->getPostcode() . '",
       "lat":' . $chargePoint->getLat() . ',
       "lng":' . $chargePoint->getLng(). ',
       "owner_id":' . $chargePoint->getOwnerID() . ',
       "cost":' . $chargePoint->getCost() .
        '}';
    }
    else{
        $JSON .= '
        ,{
       "_id":' . $chargePoint->getChargePointId() . ', 
       "address":"' . $chargePoint->getAddress() .'",
       "city":"' . $chargePoint->getCity() . '",
       "postcode":"' . $chargePoint->getPostcode() . '",
       "lat":' . $chargePoint->getLat() . ',
       "lng":' . $chargePoint->getLng(). ',
       "owner_id":' . $chargePoint->getOwnerID() . ',
       "cost":' . $chargePoint->getCost() .
            '}';
    }
}
if($JSON != "") $JSON .= "]";

echo json_encode($JSON) == ""? : $JSON;