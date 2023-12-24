<?php
        session_start();
        // display welcome admin if logged in        
        // If the user is not logged in or their role is not 1, redirect them.
        if (!empty($_SESSION['role']) && ($_SESSION['role'] == 1 || $_SESSION['role'] == 2)) {
            echo "<script>alert('You are already registered and logged. If you want to register another account logout first.'); window.location.href='myaccount.php';</script>";
             // i would use header("Location: login.php"); but in this case 
            //before alerting the user it is redirecting to login.php and not showing the alert
            //so i found this code with window.location.href='login.php' and it is working 
            exit();
        }
?>
        

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Webshop Home</title>
    <link rel="stylesheet" href="register.css">
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
        <form id="registrationForm" class="register-form" method="POST">
            <input type="text" id="firstname" name="firstname" placeholder="firstname" >
            <input type="text" id="lastname" name="lastname" placeholder="lastname" >
            <input type="text" id="email" name="email" placeholder="Email" ><!-- because i am checking with js,changed input type to text from email -->
            <input type="text" id="address" name="address" placeholder="Address" >
            <input type="password" id="password" name="password" placeholder="Password" >
            <input type="password" id="confirmPassword" name="confirmPassword" placeholder="Confirm Password" >
            <button type="submit">Register</button>
        </form>

        <script src="checkregisterfields.js"></script>
        
        <!-- now save to database if the checkfields.js is ok -->

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

            //check first if it the post is submitted from js
            if (!empty($_POST)) {
                // Retrieve form data
                $firstname = $_POST['firstname'];
                $lastname = $_POST['lastname'];
                $email = $_POST['email'];
                $address = $_POST['address'];
                $password = $_POST['password']; // Password should ideally be hashed before storing

                //check if email is already in database
                $sql = "SELECT email FROM users WHERE email = '$email'";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    echo "<script>alert('Email already in use.');</script>";
                    exit();
                }
            }else{
                exit();
            }

                //hash the password using salt
                $password = password_hash($password, PASSWORD_DEFAULT);
                
                

                // Insert data into database table users(user_id	first_name	last_name	email	password	address	active	role)
                $sql = "INSERT INTO users (first_name, last_name, email, password, address, active, role) VALUES ('$firstname', '$lastname', '$email', '$password', '$address', 1, 2)";
                //if the query is successful
                if ($conn->query($sql) === TRUE) {
                    echo "<p>Registration successful.</p>";
                } else {
                    echo "<p>Error: " . $sql . "<br>" . $conn->error . "</p>";
                }

            $conn->close();
            ?>
        <!-- if not registered yet send to register.php -->
        <p>Already registered? <a href="login.php">Login here</a>.</p>
    </main>

    <footer>
        <p>Contact Us: contact@frk-tech.com</p>
    </footer>
</body>
</html>
