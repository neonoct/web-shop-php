<?php
include 'db.php';
include "error.php";
session_start();
     
// If the user is not logged in or their role is not 1, redirect them.
if (!empty($_SESSION['role']) && ($_SESSION['role'] == 1 || $_SESSION['role'] == 2)) {
    echo "<script>alert('You are already registered and logged. If you want to register another account logout first.'); window.location.href='myaccount.php';</script>";
    // i would use header("Location: login.php"); but in this case 
    //before alerting the user it is redirecting to login.php and not showing the alert
    //so i found this code with window.location.href='login.php' and it is working 
    exit();
}

function register() {
    $conn = connectToDb(); // Connect to the database

    if (!empty($_POST)) {
        // Retrieve and sanitize form data
        $firstname = filter_input(INPUT_POST, 'firstname', FILTER_UNSAFE_RAW);
        $lastname = filter_input(INPUT_POST, 'lastname', FILTER_UNSAFE_RAW);
        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
        $address = filter_input(INPUT_POST, 'address', FILTER_UNSAFE_RAW);
        $password = $_POST['password']; // Password will be hashed

        // Prepared statement for checking if the email already exists
        $stmt = $conn->prepare("SELECT email FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            echo "<script>alert('Email already in use.');</script>";
            exit();
        }


        // Hash the password
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);

        // Prepared statement for inserting data into the database
        $sql = "INSERT INTO users (first_name, last_name, email, password, address, active, role) VALUES (?, ?, ?, ?, ?, 1, 2)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssss", $firstname, $lastname, $email, $passwordHash, $address);

        if ($stmt->execute()) {
            echo "<p>Registration successful.</p>";
        } else {
            echo "<p>Error: " . htmlspecialchars($conn->error) . "</p>";
        }

        $stmt->close();
    }else{
        exit();
    }

    $conn->close();
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
        <script>
            // When the document is fully loaded, attach the validation to the form
            document.addEventListener('DOMContentLoaded', function() {
                checkregisterfields('registrationForm');
            });
        </script>
        
        <!-- now save to database if the checkfields.js is ok -->

        <?php register();?>
        <!-- if already registered link to login -->
        <p>Already registered? <a href="login.php">Login here</a>.</p>
    </main>

    <footer>
        <p>Contact Us: contact@frk-tech.com</p>
    </footer>
</body>
</html>
