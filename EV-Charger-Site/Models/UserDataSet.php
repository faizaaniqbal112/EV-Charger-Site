<?php
require_once('Database.php');
require_once('UserData.php');
/*
 * This class contains methods which will be called
 * do to various things related to the charge point table in the database
*/
class UserDataSet
{
    protected $_dbHandle, $_dbInstance;

    public function __construct()
    {
        $this->_dbInstance = Database::getInstance();
        $this->_dbHandle = $this->_dbInstance->getdbConnection();
    }

    //gets all the users from the user table
    public function fetchAllUsers()
    {
        $sqlQuery = 'SELECT * FROM users';

        $statement = $this->_dbHandle->prepare($sqlQuery); // prepare a PDO statement
        $statement->execute(); // execute the PDO statement

        $dataSet = [];
        while ($row = $statement->fetch()) {
            $dataSet[] = new UserData($row);
        }
        return $dataSet;
    }

    //authenicates the user login by comparing username and input
    //to what is in the DB
    public function authenticateUser($usernameInput, $passwordInput){
       $sqlQuery = 'SELECT * FROM users WHERE username = ?';
       $statement = $this->_dbHandle->prepare($sqlQuery);

       $statement->bindParam(1, $usernameInput);
      //$statement->bindParam(2,$passwordInput);

       $statement->execute();

        $dataSet = [];
        while($row = $statement->fetch()){
            $dataSet[] = new UserData($row);
        }


        if(!empty($dataSet)){
            if ($usernameInput == $dataSet[0]->getUsername()) {
             if (password_verify($passwordInput, $dataSet[0]->getPassword())) {
                 return true;
             }
             else {
                 return false;
            }
            }
            else {
                return false;
            }
        }
        else{
            return false;
        }
    }

    //checks if the user already exists
    private function userExists($username){
        $sqlQuery = 'SELECT * FROM users WHERE username = ?';
        $statement = $this->_dbHandle->prepare($sqlQuery);
        $statement->bindParam(1,$username);
        $statement->execute();

        $dataSet = [];
        while($row = $statement->fetch()){
            $dataSet[] = new UserData($row);
        }
        if(!empty($dataSet)){
            return true;
        }
        else{
            return false;
        }
    }

    //registers a new user
    public function registerUser($username, $fullname, $password, $profilePic){

        if($this->userExists($username)){
            return true;
        }
        else{
            $sqlQuery = 'INSERT INTO users(username, fullname, password, profile_pic) VALUES(?,?,?,?)';
            $statement = $this->_dbHandle->prepare($sqlQuery);
            $bcyrptOptions = array('cost' => 14);
            $encyrptedPass = password_hash($password, PASSWORD_BCRYPT, $bcyrptOptions);
            $statement->bindParam(1,$username);
            $statement->bindParam(2,$fullname);
            $statement->bindParam(3,$encyrptedPass);
            $statement->bindParam(4,$profilePic);

            $statement->execute();
            return false;
        }
    }
}