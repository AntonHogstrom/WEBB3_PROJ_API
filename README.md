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


_ Anton Högström _
