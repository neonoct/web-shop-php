<?php
        session_start();
        // display welcome admin if logged in        
        // If the user is not logged in or their role is not 1, redirect them.
        if (empty($_SESSION['role']) || $_SESSION['role'] != 1) {
            echo "<script>alert('You are not authorized to see this page. Please login.'); window.location.href='login.php';</script>"; // i would use header("Location: login.php"); but in this case 
            //before alerting the user it is redirecting to login.php and not showing the alert
            //so i found this code with window.location.href='login.php' and it is working 
            exit();
        }
        
        // The rest of your protected page content goes here
        ?>
        

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
        <h3>Admin Page</h3>
        <?php
        // display welcome admin
        echo "<p>Welcome Admin ",$_SESSION['adminname'],"</p>";

        ?>

    </main>

    <footer>
        <p>Contact Us: contact@frk-tech.com</p>
    </footer>
</body>
</html>
