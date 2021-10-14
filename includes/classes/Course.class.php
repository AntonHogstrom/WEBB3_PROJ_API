<?php

class Course {
    private $db;
    private $id;
    private $code;
    private $courseName;
    private $startDate;
    private $endDate;
    private $university;

    //Constructor
    public function __construct() {
        //Database connection
        $this -> db = new mysqli(DBHOST, DBUSER, DBPASS, DBDATABASE);

        //Error handling if error with connection
        if($this -> db -> connect_error) {
            die("Connection failed: " . $this -> db -> connect_error);
        }
    }



    /* ADD COURSE TO DATABASE */
    public function addCourse($code, $courseName, $startDate, $endDate, $university) : bool {
        $this -> code = strip_tags($code);
        $this -> courseName = strip_tags($courseName);
        $this -> startDate = strip_tags($startDate);
        $this -> endDate = strip_tags($endDate);
        $this -> university = strip_tags($university);

        $stmt = $this -> db -> prepare("INSERT INTO course (code, courseName, startDate, endDate, university)
        VALUES (?, ?, ?, ?, ?)");
        $stmt -> bind_param("sssss", $this -> code, $this -> courseName, $this -> startDate, $this -> endDate, $this -> university);
        

        //Execute Statement
        if($stmt -> execute()) {
            return true;
        } else {
            return false;
        }

        //Close Statement / database connection
        $stmt -> close();
    }



    /* GET ALL COURSES IN DATABASE */
    public function getCourses() : array {
        $sql = "SELECT * FROM course ORDER BY startDate;";
        $result = $this -> db -> query($sql);

        //Query returns ASSOC-array
        return $result -> fetch_all(MYSQLI_ASSOC);
    }


    /* GET COURSE BY ID */
    public function getCourse($id) : array {
        $sql = "SELECT * FROM course WHERE course_id = '" . $id . "';";
        $result = $this -> db -> query($sql);

        //Query returns ASSOC-array
        return $result -> fetch_all(MYSQLI_ASSOC);
    }


    /* UPDATE COURSE BY ID */

    public function updateCourse($code, $courseName, $startDate, $endDate, $university, $id) : bool {
        
        $this -> id = intval($id);
        $this -> code = strip_tags($code);
        $this -> courseName = strip_tags($courseName);
        $this -> startDate = strip_tags($startDate);
        $this -> endDate = strip_tags($endDate);
        $this -> university = strip_tags($university);

        $stmt = $this -> db -> prepare("UPDATE course SET code=?, courseName=?, startDate=?, endDate=?, university=? WHERE course_id=?;");
        $stmt -> bind_param("ssssss", $this -> code, $this -> courseName, $this -> startDate, $this -> endDate, $this -> university, $this-> id);


        //Execute Statement
        if($stmt -> execute()) {
            return true;
        } else {
            return false;
        }

        //Close Statement / database connection
        $stmt -> close();
    }


    //DELETE COURSE BY CODE
    public function deleteCourse($id) : bool {
        $sql = "DELETE FROM course WHERE course_id = '" . $id . "';";
        $result = $this -> db -> query($sql);
        
        return $result;
    }
}