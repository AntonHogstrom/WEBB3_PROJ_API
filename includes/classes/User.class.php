<?php

class User {
    private $db;
    private $id;
    private $username;
    private $password;

    //Constructor
    public function __construct() {
        //Database connection
        $this -> db = new mysqli(DBHOST, DBUSER, DBPASS, DBDATABASE);

        //Error handling if error with connection
        if($this -> db -> connect_error) {
            die("Connection failed: " . $this -> db -> connect_error);
        }
    }



    /* ADD USER TO DATABASE */
    public function addUser($username, $password) : bool {
        $this -> username = strip_tags($username);
        $this -> password = strip_tags($password);

        $stmt = $this -> db -> prepare("INSERT INTO user (username, password)
        VALUES (?, ?)");
        $stmt -> bind_param("ss", $this -> username, $this -> password);
        

        //Execute Statement
        if($stmt -> execute()) {
            return true;
        } else {
            return false;
        }

        //Close Statement / database connection
        $stmt -> close();
    }



    /* GET ALL USERS IN DATABASE */
    public function getUsers() : array {
        $sql = "SELECT * FROM user ORDER BY created DESC;";
        $result = $this -> db -> query($sql);

        //Query returns ASSOC-array
        return $result -> fetch_all(MYSQLI_ASSOC);
    }


    /* GET Website BY ID */
    public function getUser($id) : array {
        $sql = "SELECT * FROM user WHERE user_id = '" . $id . "';";
        $result = $this -> db -> query($sql);

        //Query returns ASSOC-array
        return $result -> fetch_all(MYSQLI_ASSOC);
    }


    /* UPDATE USER BY ID */

    public function updateUser($username, $password, $id) : bool {
            
        $this -> id = intval($id);
        $this -> username = strip_tags($username);
        $this -> password = strip_tags($password);

        $stmt = $this -> db -> prepare("UPDATE user SET username=?, password=? WHERE user_id=?;");
        $stmt -> bind_param("sss", $this -> username, $this -> password, $this-> id);


        //Execute Statement
        if($stmt -> execute()) {
            return true;
        } else {
            return false;
        }

        //Close Statement / database connection
        $stmt -> close();
    }


    //DELETE USER BY ID
    public function deleteUser($id) : bool {
        $sql = "DELETE FROM user WHERE user_id = '" . $id . "';";
        $result = $this -> db -> query($sql);
        
        return $result;
    }
}