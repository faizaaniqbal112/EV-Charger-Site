<?php
/*
 * This class creates a user object which will allow
 * data about the user to be returned
*/
class UserData
{
    protected $_user_id, $_fullname, $_profile_pic, $_username,$_password;

    public function __construct($dbRow)
    {
        $this->_user_id = $dbRow['user_ID'];
        $this->_fullname = $dbRow['fullname'];
        $this->_username = $dbRow['username'];
        $this->_password = $dbRow['password'];
        $this->_profile_pic = $dbRow['profile_pic'];
    }

    public function getUserID()
    {
        return $this->_user_id;
    }

    public function getFullname()
    {
        return $this->_fullname;
    }

    public function getProfilePic()
    {
        return $this->_profile_pic;
    }

    public function getUsername()
    {
        return $this->_username;
    }

    public function getPassword()
    {
        return $this->_password;
    }
}