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
    <link rel="stylesheet" href="cart.css">
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
        <h3>Cart</h3>
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
            echo "<div class='flex-container'>";
            if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
                foreach ($_SESSION['cart'] as $productID => $quantity) {
                    // Retrieve product details
                    $sql = "SELECT productid, productName, productPrice, description, imageUrl FROM products WHERE productid = '" . $conn->real_escape_string($productID) . "'";
                    $result = $conn->query($sql);
                    
                    if ($result->num_rows > 0) {
                        // Display product details
                        while($row = $result->fetch_assoc()) {
                            echo "<div>";
                            echo "<img src='" . $row['imageUrl'] . "' alt='" . $row['productName'] . "'>";
                            echo "<h4>" . $row['productName'] . "</h4>";
                            echo "<p>" . $row['description'] . "</p>";
                            echo "<p>Price: " . $row['productPrice'] . "</p>";
                            echo "<form method='post' action='update_cart.php' id='updateForm" . $productID . "'>";
                            echo "<input type='number' name='quantity' value='" . $quantity . "' onchange='document.getElementById(\"updateForm" . $productID . "\").submit();'>";
                            echo "<input type='hidden' name='productID' value='" . $productID . "'>";                           
                            echo "</form>";
                            echo "<form method='post' action='update_cart.php'>";
                            echo "<input type='hidden' name='productID' value='" . $productID . "'>";
                            echo "<input type='hidden' name='remove' value='1'>";
                            echo "<input type='submit' value='Remove'>";
                            echo "</form>";
                            echo "</div>";
                        }
                    } else {
                        echo "No products found.";
                    }
                    
                }
            } else {
                echo "Your cart is empty.";
            }
            echo "</div>";
            ?>

    </main>

    <footer>
        <p>Contact Us: contact@frk-tech.com</p>
    </footer>
</body>
</html>
