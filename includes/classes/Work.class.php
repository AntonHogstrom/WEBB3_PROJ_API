<?php

class Work {
    private $db;
    private $id;
    private $company;
    private $startDate;
    private $endDate;
    private $title;

    //Constructor
    public function __construct() {
        //Database connection
        $this -> db = new mysqli(DBHOST, DBUSER, DBPASS, DBDATABASE);

        //Error handling if error with connection
        if($this -> db -> connect_error) {
            die("Connection failed: " . $this -> db -> connect_error);
        }
    }



    /* ADD WORK TO DATABASE */
    public function addWork($company, $startDate, $endDate, $title) : bool {
        $this -> company = strip_tags($company);
        $this -> startDate = strip_tags($startDate);
        $this -> endDate = strip_tags($endDate);
        $this -> title = strip_tags($title);

        $stmt = $this -> db -> prepare("INSERT INTO work (company, startDate, endDate, title)
        VALUES (?, ?, ?, ?)");
        $stmt -> bind_param("ssss", $this -> company, $this -> startDate, $this -> endDate, $this -> title);
        

        //Execute Statement
        if($stmt -> execute()) {
            return true;
        } else {
            return false;
        }

        //Close Statement / database connection
        $stmt -> close();
    }



    /* GET ALL WORKS IN DATABASE */
    public function getWorks() : array {
        $sql = "SELECT * FROM work ORDER BY startDate;";
        $result = $this -> db -> query($sql);

        //Query returns ASSOC-array
        return $result -> fetch_all(MYSQLI_ASSOC);
    }


    /* GET WORK BY ID */
    public function getWork($id) : array {
        $sql = "SELECT * FROM work WHERE work_id = '" . $id . "';";
        $result = $this -> db -> query($sql);

        //Query returns ASSOC-array
        return $result -> fetch_all(MYSQLI_ASSOC);
    }


    /* UPDATE WORK BY ID */

    public function updateWork($company, $startDate, $endDate, $title, $id) : bool {
        
        $this -> id = intval($id);
        $this -> work = strip_tags($company);
        $this -> startDate = strip_tags($startDate);
        $this -> endDate = strip_tags($endDate);
        $this -> title = strip_tags($title);

        $stmt = $this -> db -> prepare("UPDATE work SET company=?, startDate=?, endDate=?, title=? WHERE work_id=?;");
        $stmt -> bind_param("sssss", $this -> company, $this -> startDate, $this -> endDate, $this -> title, $this-> id);


        //Execute Statement
        if($stmt -> execute()) {
            return true;
        } else {
            return false;
        }

        //Close Statement / database connection
        $stmt -> close();
    }


    //DELETE WORK BY CODE
    public function deleteWork($id) : bool {
        $sql = "DELETE FROM work WHERE work_id = '" . $id . "';";
        $result = $this -> db -> query($sql);
        
        return $result;
    }
}