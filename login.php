<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Webshop Home</title>
    <link rel="stylesheet" href="login.css">
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
            </ul>
        </nav>
    </header>

    <main>
        <h2>Welcome to Our Webshop!</h2>
        <form id="loginForm" class="login-form" method="POST">
            <!-- <input type="text" id="loginUsername" name="username" placeholder="Username" required> change this with email-->
            <input type="email" id="loginEmail" name="email" placeholder="Email" required>
            <input type="password" id="loginPassword" name="password" placeholder="Password" required>
            <button type="submit">Login</button>
        </form>
        <!-- if not registered yet send to register.php -->
        <p>Not registered yet? <a href="register.php">Register here</a>.</p>

        <script src="checkloginfields.js"></script>

        <?php

            // Database configuration
            $host     = "localhost";
            $dbName   = "shopDb";
            $username = "Webuser";
            $password = "Lab2021";

            // Create connection
            $conn = new mysqli($host, $username, $password, $dbName);
            //echo "<script>alert('viyyy0.');</script>";
            // Check connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            //check first if it the post is submitted from js
            if (!empty($_POST)) {
                // Retrieve form data
                $email = $_POST['email'];
                $password = $_POST['password'];

                // Check if the user exists in the database
                $sql = "SELECT email, password FROM logins WHERE email = '" . $conn->real_escape_string($email) . "'";
                // if email is not in database not a registered user
                // if email is in database and same email is in customers table then it is a registered user
                // if email is in database and same email is not in customers table but in admins table then it is an admin

                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    // User exists, now check if the password matches
                    $row = $result->fetch_assoc();
                    if (password_verify($password, $row['password'])) {
                        // Password matches, it is either a registered user or an admin
                        session_start();
                        $_SESSION['email'] = $email; // Store the email in the session as both admin and user have email
                        //check if it is a registered user or admin
                        $sql = "SELECT customerID, firstname, lastname, address FROM customers WHERE email = '" . $conn->real_escape_string($email) . "'";
                        $result = $conn->query($sql);
                        if ($result->num_rows > 0) {
                            // it is a registered user
                            //header("Location: products.php");
                            //fill the session with the customerID, firstname, lastname, address
                            $row = $result->fetch_assoc();
                            $_SESSION['customerID'] = $row['customerID'];
                            $_SESSION['firstname'] = $row['firstname'];
                            $_SESSION['lastname'] = $row['lastname'];
                            $_SESSION['address'] = $row['address'];
                            header("Location: myaccount.php");
                        } else {
                            // it is an admin
                            //header("Location: admin.php");
                            //check if it is really an admin by checking if it is in admins table
                            $sql = "SELECT email FROM admins WHERE email = '" . $conn->real_escape_string($email) . "'";
                            $result = $conn->query($sql);
                            if ($result->num_rows > 0) {
                                // it is an admin
                                //fill the session with the adminID,name
                                $sql = "SELECT adminID, name FROM admins WHERE email = '" . $conn->real_escape_string($email) . "'";
                                $result = $conn->query($sql);
                                $row = $result->fetch_assoc();
                                $_SESSION['adminID'] = $row['adminID'];
                                $_SESSION['name'] = $row['name'];
                                header("Location: admin.php");
                            } else {
                                // it is not an admin
                                echo "<p>Invalid admin email.</p>";
                            }
                        }
                        exit();
                    } else {
                        // Password doesn't match
                        echo "<p>Invalid password.</p>";
                    }
                } else {
                    // Password doesn't match with email
                    echo "<p>Invalid email.</p>";
                }

            }

            $conn->close();
        ?>


    </main>

    <footer>
        <p>Contact Us: contact@yourwebshop.com</p>
    </footer>
</body>
</html>

