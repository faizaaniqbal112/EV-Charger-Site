<?php
//creates a object for the search data so the information
//from the DB can be displayed for user to see
class searchData
{
    protected $_profile_pic, $_username, $_city, $_postcode, $_address, $_cost;

    public function __construct($dbRow)
    {
        $this->_profile_pic = $dbRow['profile_pic'];
        $this->_username = $dbRow['username'];
        $this->_city = $dbRow['city'];
        $this->_postcode = $dbRow['postcode'];
        $this->_address = $dbRow['address'];
        $this->_cost = $dbRow['cost'];

    }

    public function getProfilePic()
    {
        return $this->_profile_pic;
    }

    public function getUsername()
    {
        return $this->_username;
    }

    public function getCity()
    {
        return $this->_city;
    }

    public function getPostcode()
    {
        return $this->_postcode;
    }


    public function getAddress()
    {
        return $this->_address;
    }

    public function getCost()
    {
        return $this->_cost;
    }

}
