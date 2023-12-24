<?php
session_start(); // Start the session

// Check if the user is logged in and has the role attribute in the session
if (!isset($_SESSION['role'])) {
    //alert the user that he is not authorized to see this page because he is not a registered user
    // i would use header("Location: login.php"); but in this case
    //before alerting the user it is redirecting to login.php and not showing the alert
    //so i found this code with window.location.href='login.php' and it is working 
    echo "<script>alert('You are not authorized to see this page. Please login as a registered user.'); window.location.href='login.php';</script>";
    exit();

} 

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Webshop Home</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <h1>FRK-Tech</h1>
        <nav>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="products.php">Products</a></li>
                <li><a href="login.php">Login</a></li>
                <li><a href="register.php">Register</a></li>
                <li><a href="cart.php">Cart</a></li>
                <li><a href="myaccount.php">My Account</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <h2>Welcome to Our Webshop!</h2>
        <h3>My account page</h3>
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
            $role = $_SESSION['role'];
            $firstname = $_SESSION['firstname'];

            $lastname = $_SESSION['lastname'];
            if ($role == 1) {
                echo "<p>Welcome Admin ",$firstname,' ',$lastname,"</p>";
                // link to admin page
                echo "<a href='admin.php'>Admin Page</a>";
            } else if ($role == 2) {
                echo "<p>Welcome Customer ",$firstname,' ',$lastname,"</p>";
                // display the customer's info
                $email = $_SESSION['email'];
                $address = $_SESSION['address'];
                echo "<p>Email: ",$email,"</p>";
                echo "<p>Address: ",$address,"</p>";

            } 

            //add a link to logout
            echo "<form action='logout.php' method='POST'><button type='submit'>Logout</button></form>";
            

        ?>
        
    </main>

    <footer>
        <p>Contact Us: contact@frk-tech.com</p>
    </footer>
</body>
</html>
