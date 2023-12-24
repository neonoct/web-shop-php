<!-- use add_admin.php instead of this -->
<!-- add an admin to db -->
<!-- role for admin = 1,for customer = 2 -->

<?php
//add an admin to db with hashed password
// Database configuration
$host     = "localhost";
$dbName   = "shopDb";
$username = "Webuser";
$password = "Lab2021";

// Create connection
$conn = new mysqli($host, $username, $password, $dbName);

// Check connectionn
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

//ad an admin to db

// First, attempt to insert into logins table
$adminname = "admin2";
$adminemail = "admin2@email.com";
$adminpassword = "admin2";
$adminpassword = password_hash($adminpassword, PASSWORD_DEFAULT);
$loginSql = "INSERT INTO logins (email, password, role) VALUES ('$adminemail', '$adminpassword',1)";

// Now, insert into admins table
$adminSql = "INSERT INTO admins (email,active,name) VALUES ('$adminname', 1, '$adminname')";
if ($conn->query($loginSql) === TRUE) {
    if ($conn->query($adminSql) === TRUE) {
        echo "<p>Admin added successfully.</p>";
    } else {
        echo "Error: " . $adminSql . "<br>" . $conn->error;
    }
} else {
    // Handle the error if insertion into logins fails
    echo "Error: " . $loginSql . "<br>" . $conn->error;
}



?>