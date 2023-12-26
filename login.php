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
                <li><a href="myaccount.php">My Account</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <h2>Welcome to Our Webshop!</h2>
        <form id="loginForm" class="login-form" method="POST">
            <input type="email" id="loginEmail" name="email" placeholder="Email" required>
            <input type="password" id="loginPassword" name="password" placeholder="Password" required>
            <button type="submit">Login</button>
        </form>
        <!-- if not registered yet send to register.php -->
        <p>Not registered yet? <a href="register.php">Register here</a>.</p>

        <script src="checkloginfields.js"></script>

        <?php
            session_start();
            //if already specified in the session then no need to check again           
            // Database configuration
            include 'db.php';
            $conn = connectToDb(); //connect to the database

            //check first if it the post is submitted from js
            if (!empty($_POST)) {
                // Retrieve form data
                $email = $_POST['email'];
                $password = $_POST['password'];
                // Check if the user exists in the database
                $sql = "SELECT user_id,first_name,last_name,address,role, password, active FROM users WHERE email = '" . $conn->real_escape_string($email) . "'";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    // User exists, now check if the password matches
                    $row = $result->fetch_assoc();
                    // if user is not active then do not login
                    if ($row['active'] == 0) {
                        echo "<p>User is not active.</p>";
                        exit();
                    }
                    if (password_verify($password, $row['password'])) {
                        // Password is correct, so start a new session
                        session_start();
                        // Store data in session variables
                        $_SESSION["loggedin"] = true;
                        $_SESSION["email"] = $email;
                        $_SESSION["role"] = $row['role'];
                        $_SESSION["firstname"] = $row['first_name'];
                        $_SESSION["lastname"] = $row['last_name'];
                        $_SESSION["address"] = $row['address'];
                        $_SESSION["active"] = $row['active'];
                        $_SESSION["user_id"] = $row['user_id'];
                        //check if it is a registered user or admin
                        if ($row['role'] == 1) {
                            // Redirect user to admin page
                            header("location: admin.php");
                        } else {
                            // Redirect user to myaccount page
                            header("location: myaccount.php");
                        }

                        exit();
                    } else {
                        // Password doesn't match
                        echo "<p>Invalid password.</p>";
                    }
                } else {
                    // User doesn't exist
                    echo "<p>Invalid email.</p>";
                }

            }else{
                exit();
            }

            $conn->close();
        ?>


    </main>

    <footer>
        <p>Contact Us: contact@frk-tech.com</p>
    </footer>
</body>
</html>

