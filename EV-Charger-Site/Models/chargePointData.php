<?php
/*
 * This class creates a chargePoint object which will allow
 * data about the chargePoint to be returned
*/
class chargePointData
{
    protected $_charge_point_id, $_address, $_city, $_postcode, $_lat, $_lng,
    $_owner_ID , $cost;

    public function __construct($dbRow)
    {
        $this->_charge_point_id = $dbRow['charge_point_Id'];
        $this->_address = $dbRow['address'];
        $this->_city = $dbRow['city'];
        $this->_postcode = $dbRow['postcode'];
        $this->_lat = $dbRow['lat'];
        $this->_lng = $dbRow['lng'];
        $this->_owner_ID = $dbRow['owner_ID'];
        $this->_cost = $dbRow['cost'];
    }


    public function getChargePointId()
    {
        return $this->_charge_point_id;
    }

    public function getAddress()
    {
        return $this->_address;
    }

    public function getCity()
    {
        return $this->_city;
    }

    public function getPostcode()
    {
        return $this->_postcode;
    }

    public function getLat()
    {
        return $this->_lat;
    }

    public function getLng()
    {
        return $this->_lng;
    }

    public function getOwnerID()
    {
        return $this->_owner_ID;
    }

    public function getCost()
    {
        return $this->_cost;
    }
}