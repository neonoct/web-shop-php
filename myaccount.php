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
            session_start();
            if (!empty($_SESSION['role'])){
                $role = $_SESSION['role'];
            } else {
                $role = "guest";
            }

            if ($role == "admin") {
                echo "<p>Welcome Admin</p>";
            } else if ($role == "customer") {
                echo "<p>Welcome Customer</p>";
            } else {
                echo "<p>Please login to see your account</p>";
            }
            

        ?>
        
    </main>

    <footer>
        <p>Contact Us: contact@yourwebshop.com</p>
    </footer>
</body>
</html>
