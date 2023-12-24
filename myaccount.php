<?php
session_start(); // Start the session

// Check if the user is logged in and has the role attribute in the session
if (!isset($_SESSION['role'])) {
    //alert the user that he is not authorized to see this page because he is not a registered user
    // i would use header("Location: login.php"); but in this case
    //before alerting the user it is redirecting to login.php and not showing the alert
    //so i found this code with window.location.href='login.php' and it is working 
    echo "<script>alert('You are not authorized to see this page. Please login as a registered user.'); window.location.href='index.php';</script>";
    exit();

} 

// Rest of your page content goes here
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
            //if user is logged in echo welcome 'customer name'
            //if admin is logged in echo welcome 'admin name'
            //if user is not logged in echo 'please login to see your account'

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

            if ($role == 1) {
                echo "<p>Welcome Admin ",$_SESSION['adminname'],"</p>";
                // link to admin page
                echo "<a href='admin.php'>Admin Page</a>";
            } else if ($role == 2) {
                echo "<p>Welcome Customer ",$_SESSION['firstname'],"</p>";
            } 

            //add a link to logout
            echo "<a href='logout.php'>Logout</a>";
            

        ?>
        
    </main>

    <footer>
        <p>Contact Us: contact@frk-tech.com</p>
    </footer>
</body>
</html>
