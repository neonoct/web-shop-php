<?php
session_start(); // Start the session

// Check if the user is logged in and has the role attribute in the session
if (isset($_SESSION['role'])) {
    // Check if the user's role is 0
    if ($_SESSION['role'] == 0) {
        // Redirect to a different page if the user's role is 0
        //alert the user that he is not authorized to see this page because he is not a registered user
        echo "<script>alert('You are not authorized to see this page. Please login as a registered user.');</script>";
        header("Location: index.php");
        exit();
    }
} else {
    // Redirect to the login page if the user is not logged in
    //alert the user that he is not authorized to see this page because he is not logged in
    echo "<script>alert('You are not authorized to see this page. Please login.');</script>";
    header("Location: index.php");
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
