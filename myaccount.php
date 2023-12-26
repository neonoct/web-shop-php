<?php
include 'db.php';
session_start(); // Start the session

// Check if the user is logged in and has the role attribute in the session
if (!isset($_SESSION['role'])) {
    //alert the user that he is not authorized to see this page because he is not a registered user
    // i would use header("Location: login.php"); but in this case
    //before alerting the user it is redirecting to login.php and not showing the alert
    //so i found this code with window.location.href='login.php' and it is working 
    echo "<script>alert('You are not authorized to see this page. Please login as a registered user.'); window.location.href='login.php';</script>";
    exit();

} 

function displayAccountInfo(){
    $conn = connectToDb(); //connect to the database
    //take the info from the session
    $role = $_SESSION['role'];
    $firstname = $_SESSION['firstname'];

    $lastname = $_SESSION['lastname'];
    if ($role == 1) {
        echo "<p>Welcome Admin ",$firstname,' ',$lastname,"</p>";
        // link to admin page
        echo "<a href='admin.php'>Admin Page</a>";
    } else if ($role == 2) {
        echo "<p>Welcome Customer ",$firstname,' ',$lastname,"</p>";
        // display the customer's info
        $email = $_SESSION['email'];
        $address = $_SESSION['address'];
        echo "<p>Email: ",$email,"</p>";
        echo "<p>Address: ",$address,"</p>";

    } 

    //display the orders of the customer,display the order id,date from orders table and the products from ordersproducts table and  the total price from payments table
    $customerID = $_SESSION['user_id'];
    $sql = "SELECT * FROM orders WHERE customerId = $customerID";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        echo "<table><tr><th>Order ID</th><th>Date</th><th>Products</th><th>Total Price</th></tr>";
        while($row = $result->fetch_assoc()) {
            $orderID = $row["orderId"];
            $date = $row["date"];
            $sql = "SELECT * FROM ordersproducts WHERE orderId = $orderID";
            $result2 = $conn->query($sql);
            $products = "";
            $totalPrice = 0;
            while($row2 = $result2->fetch_assoc()) {
                $productID = $row2["productId"];
                $quantity = $row2["quantity"];
                $sql = "SELECT * FROM products WHERE productID = $productID";
                $result3 = $conn->query($sql);
                while($row3 = $result3->fetch_assoc()) {
                    $productName = $row3["productName"];
                    $productPrice = $row3["productPrice"];
                    $totalPrice += $productPrice * $quantity;
                    $products .= $productName . " x" . $quantity . " ";
                }
            }
            $sql = "SELECT * FROM payments WHERE orderId = $orderID";
            $result2 = $conn->query($sql);
            while($row2 = $result2->fetch_assoc()) {
                $amount = $row2["amount"];
            }
            echo "<tr><td>$orderID</td><td>$date</td><td>$products</td><td>$amount</td></tr>";
        }
        echo "</table>";
    } else {
        echo "0 results";
    }

    //add a link to logout
    echo "<form action='process.php' method='POST'><input type='hidden' name='form_type' value='form10'><button type='submit'>Logout</button></form>";
    
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
