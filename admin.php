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
        session_start();
        // display welcome admin if logged in
        if (!empty($_SESSION['role']) && $_SESSION['role'] == 1) {
            echo "<p>Welcome Admin ",$_SESSION['adminname'],"</p>";
        } else {
            echo "<p>Please login as admin to see this page</p>";
        }

        ?>

    </main>

    <footer>
        <p>Contact Us: contact@frk-tech.com</p>
    </footer>
</body>
</html>
