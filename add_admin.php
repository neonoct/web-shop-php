<!-- add an admin to db -->


<?php
// Database configuration
$host     = "localhost";
$dbName   = "shopDb";
$username = "Webuser";
$password = "Lab2021";

// Create connection
$conn = new mysqli($host, $username, $password, $dbName);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Add an admin to the database
$adminname = "admin1";
$adminemail = "admin1@email.com";
$adminpassword = "admin01.";

//if it is already on the database, it will not be added
$checkSql = "SELECT * FROM admins WHERE email = '$adminemail'";
$result = $conn->query($checkSql);
if ($result->num_rows > 0) {
    echo "<p>Admin already exists.</p>";
    exit();
}

$adminpassword = password_hash($adminpassword, PASSWORD_DEFAULT);

// First, attempt to insert into logins table
$loginSql = "INSERT INTO logins (email, password) VALUES ('$adminemail', '$adminpassword')";

if ($conn->query($loginSql) === TRUE) {
    // Now, insert into admins table
    $adminSql = "INSERT INTO admins (name, active, email) VALUES ('$adminname', 1, '$adminemail')";
    if ($conn->query($adminSql) === TRUE) {
        echo "<p>Admin added successfully.</p>";
    } else {
        echo "Error: " . $adminSql . "<br>" . $conn->error;
    }
} else {
    echo "Error: " . $loginSql . "<br>" . $conn->error;
}
?>
