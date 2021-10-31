# Webbutveckling III Project API

## CRUD
- [x] Create
- [x] Read
- [x] Update
- [x] Delete

Functions are made in class-file with PHP with a Database connection though Config-file.
Database connection varies depending on if localhost or not.
Headers to approve of access-control

## Switch statement for METHOD

### Create
Gets data with file_get_contents.
Prepared statement and check if any value is empty.
Finally sends response to database


### Read
If id parameter is set, runs function to get specific row, otherwise function for all rows in the table.

### Update
Takes id parameter for specific row
Gets data with file_get_contents.
Prepared statement and check if any value is empty.
Finally sends response to database

### Delete
Takes id parameter for specific row
Sends request to database


---

Database tables can be installed through install file within API files. This should not be uploaded publicly
For installation of working environment, use "npm install" inside of project terminal.
Then use terminal command "gulp" to start the automation process.
A webserver will be needed to run (XAMPP for example)
Files should be downloaded to htdocs inside of xampp folder.
For custom database connection, edit inside of config.php


_ Anton Högström _
