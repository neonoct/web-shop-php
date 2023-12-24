<!-- add an admin to db -->
<!-- role for admin = 1,for customer = 2 -->


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
$firstname = "admin1";
$lastname = "admin";
$email = "admin1@email.com";
$password = "admin01.";
$address = "";

//if it is already on the database, it will not be added
$checkSql = "SELECT * FROM users WHERE email = '$email'";
$result = $conn->query($checkSql);
if ($result->num_rows > 0) {
    echo "<p>Admin already exists.</p>";
    exit();
}

$password = password_hash($password, PASSWORD_DEFAULT);


// Insert admin data into database table users(user_id	first_name	last_name	email	password	address	active	role) but just use the email and password active = 1, role = 1
$sql = "INSERT INTO users (first_name, last_name, email, password, address, active, role) VALUES ('$firstname', '$lastname', '$email', '$password', '$address', 1, 1)";

//if the query is successful
if ($conn->query($sql) === TRUE) {
    echo "<p>Admin added to database.</p>";
} else {
    echo "<p>Error: " . $sql . "<br>" . $conn->error . "</p>";
}
?>
