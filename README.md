User Status App

I built this small PHP/MySQL project so you can:
add users by entering a name and age
view all users in a simple table
toggle each user status between Active and Inactive without reloading
delete a user if you need to

Files in this folder
index.php  main page with the form, table, toggle and delete functions
con.php    database connection settings (include this at the top of index.php)
README.md  this file, with setup and usage instructions

Prerequisites
XAMPP installed (Apache, MySQL, PHP)
a web browser

Setup

1. Database
   Open phpMyAdmin at [http://localhost/phpmyadmin](http://localhost/phpmyadmin)
   Create a new database named user\_status
   Run this SQL to create the table
   CREATE TABLE user\_data (
   id INT AUTO\_INCREMENT PRIMARY KEY,
   full\_name VARCHAR(50) NOT NULL,
   user\_age INT NOT NULL,
   status TINYINT DEFAULT 0,
   created\_at TIMESTAMP DEFAULT CURRENT\_TIMESTAMP
   )

2. Files
   Copy index.php and con.php into the XAMPP htdocs/user\_status folder
   In con.php make sure the MySQL credentials match your setup (default user root with no password)

3. Run
   Start Apache and MySQL in the XAMPP control panel
   Open your browser and go to [http://localhost/user\_status/](http://localhost/user_status/)

How to use
Type a name and an age then press Submit to add a user
Click the Toggle button next to a row to change its status instantly
Click Delete next to a row to remove that user

That is all
