<?php
require_once('Database.php');
require_once('UserData.php');
require('chargePointData.php');
require_once('SearchData.php');
/*
 * This class contains methods which will be called
 * do to various things related to the charge point table in the database
*/

class chargePointDataSet
{
    protected $_dbHandle, $_dbInstance;

    public function __construct()
    {
        $this->_dbInstance = Database::getInstance();
        $this->_dbHandle = $this->_dbInstance->getdbConnection();
    }

    //checks if the charge point exists by checking the address
    private function chargePointExists($address){
        $sqlQuery = 'SELECT * FROM charge_points WHERE address = ?';
        $statement = $this->_dbHandle->prepare($sqlQuery);
        $statement->bindParam(1,$address);
        $statement->execute();

        $dataSet = [];
        while($row = $statement->fetch()){
            $dataSet[] = new chargePointData($row);
        }

        if(!empty($dataSet)){
            return true;
        }
        else{
            return false;
        }
    }

    //gets the owner ID
    private function getOwnerID(){
        $getOwnerIDQuery = 'SELECT * FROM users WHERE username = ? ';
        $statement =$this->_dbHandle->prepare($getOwnerIDQuery);
        $statement->bindParam(1,$_SESSION['username']);
        $statement->execute();

        $dataSet = [];
        while($row = $statement->fetch()){
            $dataSet[] = new UserData($row);
        }

        return $dataSet[0]->getUserID();

    }

    //adds charge point to charge point table in database
    public function addChargePoint($address, $city,$postcode,$lat,$lng,$cost){

        if($this->chargePointExists($address)){
            return true;
        }
        else
        {
            $owner_ID = $this->getOwnerID();
            $sqlQuery = 'INSERT into charge_points(address,city,postcode,lat,lng,owner_ID,cost) VALUES(?,?,?,?,?,?,?)';
            $statement = $this->_dbHandle->prepare($sqlQuery);

            $statement->bindParam(1,$address);
            $statement->bindParam(2,$city);
            $statement->bindParam(3,$postcode);
            $statement->bindParam(4,$lat);
            $statement->bindParam(5,$lng);
            $statement->bindParam(6,$owner_ID);
            $statement->bindParam(7,$cost);
            $statement->execute();
            return false;
        }

    }

    //finds the charge point via search takes city and compares it against DB
    //returns dataSet of results
    public function findChargePoint($city){
        $sqlQuery = 'SELECT profile_pic, username, user_ID, address, city,postcode,cost
                    FROM users
                    INNER JOIN charge_points ON user_ID=owner_ID where city LIKE ? "%" ORDER BY city ASC';
        $statement = $this->_dbHandle->prepare($sqlQuery);
        $statement->bindParam(1,$city);
        $statement->execute();

        $dataSet = [];
        while($row = $statement->fetch()){
            $dataSet[] = new SearchData($row);
        }
        return $dataSet;

    }

    //gets the charge points information from DB which are related to the user that is logged in
    public function getMyChargePoints($username){
        $sqlQuery = 'SELECT * FROM charge_points WHERE owner_ID = (SELECT user_ID FROM users WHERE username = ?)';
        $statement = $this->_dbHandle->prepare($sqlQuery);
        $statement->bindParam(1,$username);
        $statement->execute();

        $dataSet = [];
        while($row = $statement->fetch()){
            $dataSet[] = new chargePointData($row);
        }

        return $dataSet;
    }

    //gets the logged in user ID
    private function getUserID($username){
        $sqlQuery = 'SELECT * FROM users WHERE username = ?';
        $statement = $this->_dbHandle->prepare($sqlQuery);
        $statement->bindParam(1,$username);
        $statement->execute();

        $dataSet = [];
        while($row = $statement->fetch()){
            $dataSet[] = new UserData($row);
        }
        return $dataSet;

    }

    //deletes the charge point from the DB
    public function deleteChargePoint($username){
        $userDataSet = $this->getUserID($username);
        foreach ($userDataSet as $UserData) {
            $userID = $UserData->getUserID();
        }

        $sqlQuery = 'DELETE FROM charge_points WHERE owner_ID = ?';
        $statement = $this->_dbHandle->prepare($sqlQuery);
        $statement->bindParam(1,$userID);
        $statement->execute();
    }

    //gets all charge points from DB
    public function fetchAllChargePoints(){
        $sqlQuery = 'SELECT * FROM charge_points';
        $statement = $this->_dbHandle->prepare($sqlQuery);
        $statement->execute();

        $dataSet = [];
        while($row = $statement->fetch()){
            $dataSet[] = new chargePointData($row);
        }

        return $dataSet;
    }
}