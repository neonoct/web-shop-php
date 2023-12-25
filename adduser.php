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

//take the info from the session

$firstname = $_POST['firstname'];
$lastname = $_POST['lastname'];
$email = $_POST['email'];
$password = $_POST['password'];
$address = $_POST['address'];
$role = $_POST['role'];
//if role is admin then 1 if user then 2
if($role == 'admin'){
    $role = 1;
}
else{
    $role = 2;
}

$sql = "INSERT INTO users (first_name, last_name, email, password, address, role, active) VALUES ('$firstname', '$lastname', '$email', '$password', '$address', '$role', 1)";
$result = $conn->query($sql);

$conn->close();

header("Location: admin.php");
exit();




?>