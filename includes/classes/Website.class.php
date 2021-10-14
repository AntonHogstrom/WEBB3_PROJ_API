<?php

class Website {
    private $db;
    private $id;
    private $title;
    private $website_url;
    private $about;
    private $created;

    //Constructor
    public function __construct() {
        //Database connection
        $this -> db = new mysqli(DBHOST, DBUSER, DBPASS, DBDATABASE);

        //Error handling if error with connection
        if($this -> db -> connect_error) {
            die("Connection failed: " . $this -> db -> connect_error);
        }
    }



    /* ADD website TO DATABASE */
    public function addWebsite($title, $website_url, $about, $created) : bool {
        $this -> title = strip_tags($title);
        $this -> website_url = strip_tags($website_url);
        $this -> about = strip_tags($about);
        $this -> created = strip_tags($created);

        $stmt = $this -> db -> prepare("INSERT INTO website (title, website_url, about, created)
        VALUES (?, ?, ?, ?)");
        $stmt -> bind_param("ssss", $this -> title, $this -> website_url, $this -> about, $this -> created);
        

        //Execute Statement
        if($stmt -> execute()) {
            return true;
        } else {
            return false;
        }

        //Close Statement / database connection
        $stmt -> close();
    }



    /* GET ALL Websites IN DATABASE */
    public function getWebsites() : array {
        $sql = "SELECT * FROM website ORDER BY created DESC;";
        $result = $this -> db -> query($sql);

        //Query returns ASSOC-array
        return $result -> fetch_all(MYSQLI_ASSOC);
    }


    /* GET Website BY ID */
    public function getWebsite($id) : array {
        $sql = "SELECT * FROM website WHERE website_id = '" . $id . "';";
        $result = $this -> db -> query($sql);

        //Query returns ASSOC-array
        return $result -> fetch_all(MYSQLI_ASSOC);
    }


    /* UPDATE Website BY ID */

    public function updateWebsite($title, $website_url, $about, $created, $id) : bool {
            
        $this -> id = intval($id);
        $this -> title = strip_tags($title);
        $this -> website_url = strip_tags($website_url);
        $this -> about = strip_tags($about);
        $this -> created = strip_tags($created);

        $stmt = $this -> db -> prepare("UPDATE website SET title=?, website_url=?, about=?, created=? WHERE website_id=?;");
        $stmt -> bind_param("sssss", $this -> title, $this -> website_url, $this -> about, $this -> created, $this-> id);


        //Execute Statement
        if($stmt -> execute()) {
            return true;
        } else {
            return false;
        }

        //Close Statement / database connection
        $stmt -> close();
    }


    //DELETE website BY website
    public function deleteWebsite($id) : bool {
        $sql = "DELETE FROM website WHERE website_id = '" . $id . "';";
        $result = $this -> db -> query($sql);
        
        return $result;
    }
}