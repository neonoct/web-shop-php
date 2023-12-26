<?php
include 'db.php';
session_start(); 

if (!isset($_SESSION['role'])) {
    echo "<script>alert('You are not authorized to see this page. Please login as a registered user.'); window.location.href='login.php';</script>";
    exit();
} 

function displayAccountInfo(){
    $conn = connectToDb(); 
    $role = $_SESSION['role'];
    $firstname = htmlspecialchars($_SESSION['firstname']);
    $lastname = htmlspecialchars($_SESSION['lastname']);
    
    if ($role == 1) {
        echo "<p>Welcome Admin {$firstname} {$lastname}</p>";
        echo "<a href='admin.php'>Admin Page</a>";
    } else if ($role == 2) {
        $email = htmlspecialchars($_SESSION['email']);
        $address = htmlspecialchars($_SESSION['address']);
        echo "<p>Welcome Customer {$firstname} {$lastname}</p>";
        echo "<p>Email: {$email}</p>";
        echo "<p>Address: {$address}</p>";
    } 

    $customerID = $_SESSION['user_id'];
    $stmt = $conn->prepare("SELECT * FROM orders WHERE customerId = ?");
    $stmt->bind_param("i", $customerID);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "<table><tr><th>Order ID</th><th>Date</th><th>Products</th><th>Total Price</th></tr>";
        while($row = $result->fetch_assoc()) {
            $orderID = $row["orderId"];
            $date = htmlspecialchars($row["date"]);
            $stmt2 = $conn->prepare("SELECT * FROM ordersproducts WHERE orderId = ?");
            $stmt2->bind_param("i", $orderID);
            $stmt2->execute();
            $result2 = $stmt2->get_result();
            $products = "";
            $totalPrice = 0;
            while($row2 = $result2->fetch_assoc()) {
                $productId = $row2["productId"];
                $quantity = $row2["quantity"];
                $stmt3 = $conn->prepare("SELECT * FROM products WHERE productId = ?");
                $stmt3->bind_param("i", $productId);
                $stmt3->execute();
                $result3 = $stmt3->get_result();
                while($row3 = $result3->fetch_assoc()) {
                    $productName = htmlspecialchars($row3["productName"]);
                    $productPrice = $row3["productPrice"];
                    $totalPrice += $productPrice * $quantity;
                    $products .= $productName . " x" . $quantity . " ";
                }
            }
            $stmt2 = $conn->prepare("SELECT * FROM payments WHERE orderId = ?");
            $stmt2->bind_param("i", $orderID);
            $stmt2->execute();
            $result2 = $stmt2->get_result();
            while($row2 = $result2->fetch_assoc()) {
                $amount = $row2["amount"];
            }

            echo "<tr><td>{$orderID}</td><td>{$date}</td><td>{$products}</td><td>{$amount}</td></tr>";
        }
        echo "</table>";
    } else {
        echo "0 results";
    }

    echo "<form action='process.php' method='POST'><input type='hidden' name='form_type' value='form10'><button type='submit'>Logout</button></form>";
    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Webshop Home</title>
    <link rel="stylesheet" href="myaccount.css">
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
        // display the account info
        displayAccountInfo();
        ?>
        
    </main>

    <footer>
        <p>Contact Us: contact@frk-tech.com</p>
    </footer>
</body>
</html>