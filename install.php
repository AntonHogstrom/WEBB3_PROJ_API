<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Database Installation</title>
</head>
<body>

<?php

//INSTALL DATABASE

//include config file for database connection
include("includes/config.php");

$db = new mysqli(DBHOST, DBUSER, DBPASS, DBDATABASE);

if($db -> connect_errno > 0) {
    die('Error connecting to database: [' . $db -> connect_error . ']');
}

//INSTALL COURSE TABLE
$sql = "DROP TABLE IF EXISTS course;
        CREATE TABLE course(
            course_id INT(16) AUTO_INCREMENT PRIMARY KEY,
            code VARCHAR(16) UNIQUE, 
            courseName VARCHAR(50),
            startDate DATE,
            endDate DATE,
            university VARCHAR(50) 
        );"
;

$sql .= "INSERT INTO course(code, courseName, startDate, endDate, university) VALUES ('DT173G', 'Webbutveckling III', '2021-08-12', '2021-10-12', 'MIUN');";


//INSTALL WORK TABLE
$sql .= "DROP TABLE IF EXISTS work;
        CREATE TABLE work(
            work_id INT(16) AUTO_INCREMENT PRIMARY KEY,
            company VARCHAR(50), 
            startDate DATE UNIQUE,
            endDate DATE,
            title VARCHAR(70) 
        );"
;

$sql .= "INSERT INTO work(company, startDate, endDate, title) VALUES ('Coca Cola Enterprises', '2015-06-15', '2015-09-15', 'Forklift Driver');";


//INSTALL WEBSITE TABLE
$sql .= "DROP TABLE IF EXISTS website;
        CREATE TABLE website(
            website_id INT(10) AUTO_INCREMENT PRIMARY KEY,
            title VARCHAR(50) UNIQUE,
            img VARCHAR (100),
            website_url VARCHAR(500),
            about VARCHAR(500),
            created DATE
        );"
;

$sql .= "INSERT INTO website(title, img, website_url, about, created) VALUES ('Devnoe', 'pepecode.jpg', 'https://www.devnoe.com/', 'My main website from where i also host sub-sites', '2020-10-13');";



//INSTALL USER TABLE
$sql .= "DROP TABLE IF EXISTS user;
        CREATE TABLE user(
            user_id INT(16) AUTO_INCREMENT PRIMARY KEY,
            username VARCHAR(70) UNIQUE,
            password VARCHAR(255),
            created TIMESTAMP
        );"
;

$sql .= "INSERT INTO user(username, password) VALUES ('MIUNadmin', '$2y$10$6U1fNboyVwZbIwN2RCdeYevkQjiq6tmlbIg/pcq7jx5tZ89.2ZCoy');";



// echo SQL-question
echo "<pre>$sql</pre>";

//Send SQL-question to database
if($db ->multi_query($sql)) {
    echo "<p>Tables are installed on <strong>" . DBHOST . "</strong></p>";
} else {
    echo "<p class='error'>Error installing tables</p>";
}
    
?>

</body>
</html>