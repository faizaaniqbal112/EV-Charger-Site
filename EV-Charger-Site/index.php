<?php
$view = new stdClass();
$view->search = false;
$view->pageTitle = 'Home';

require_once('loginControl.php'); //check if user is logged in
require_once('Models/MapGeoJS.php'); // allows mapGeoJS object use


$mapGeo = new MapGeoJS(); // creates new Geolocator object

$view->leafletLink = $mapGeo->getLeafletLink(); //gets the script JS leaflet link

$view->mapAndMarkers = $mapGeo->getLocationCode(); // calls function to get JS code

require_once('Views/index.phtml');