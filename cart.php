<?php
session_start(); // Start the session

// Check if the user is logged in and has the role attribute in the session
if (!isset($_SESSION['role'])) {
    // same goes for here as in myaccount.php 
    echo "<script>alert('You are not authorized to see this page. Please login as a registered user.'); window.location.href='products.php';</script>";
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
        <!-- Featured Products Section -->
        <section class="featured-products">
            <h3>Cart</h3>
        </section>
    </main>

    <footer>
        <p>Contact Us: contact@frk-tech.com</p>
    </footer>
</body>
</html>
