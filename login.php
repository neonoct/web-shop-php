<?php
#user passwords =Arkadas1.
#admin passwords =admin1=admin01., admin2=admin02.
include 'db.php';
include "error.php";
function login() {
    try {
        session_start();
    $conn = connectToDb(); // Connect to the database
    //get elementbyid= mesage and copy the mesage to it
    $messageString = "<script>document.getElementById('message').innerHTML = '";


    if (!empty($_POST)) {
        // Retrieve form data
        $email = $_POST['email'];
        $password = $_POST['password'];

        // Prepared statement for user verification
        $sql = "SELECT user_id, first_name, last_name, address, role, password, active FROM users WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            if ($row['active'] == 0) {
                #echo "<p>User is not active.</p>";
                #echo "<script>alert('User is not active.');</script>";
                $messageString .= "User is not active.";
                $messageString .= "';</script>";
                echo $messageString;
                exit();
            }
            if (password_verify($password, $row['password'])) {
                // Password is correct, so start a new session
                $_SESSION["loggedin"] = true;
                $_SESSION["email"] = $email;
                $_SESSION["role"] = $row['role'];
                $_SESSION["firstname"] = $row['first_name'];
                $_SESSION["lastname"] = $row['last_name'];
                $_SESSION["address"] = $row['address'];
                $_SESSION["active"] = $row['active'];
                $_SESSION["user_id"] = $row['user_id'];

                if ($row['role'] == 1) {
                    header("location: admin.php");
                } else {
                    header("location: myaccount.php");
                }
                exit();
            } else {
                #echo "<p>Invalid password.</p>"; 
                #echo "<script>alert('Invalid password.');</script>";
                $messageString .= "Invalid password.";
                $messageString .= "';</script>";
                echo $messageString;
            }
        } else {
            #echo "<p>Invalid email.</p>"; 
            #echo "<script>alert('Invalid email.');</script>";
            $messageString .= "Invalid email.";
            $messageString .= "';</script>";
            echo $messageString;
        }
    }else{
        exit();
    }

    $conn->close();
        
    } catch (Exception $e) {
        echo "<script>alert('Connection to database failed.');</script>";
        exit();
    }
    
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Webshop Home</title>
    <link rel="stylesheet" href="reset.css">
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
            <input type="text" id="loginEmail" name="email" placeholder="Email" >
            <input type="password" id="loginPassword" name="password" placeholder="Password" >
            <button type="submit">Login</button>
        </form>
        <!-- if not registered yet link to register.php -->
        <p>Not registered yet? <a href="register.php">Register here</a>.</p>
        <p id='message'></p>
       
    </main>
    
    
    <footer>
        <p>Contact Us: contact@frk-tech.com</p>
    </footer>
    <script src="checkloginfields.js"></script>
</body>
</html>
<?php login();?>