<?php
session_start();
include 'db.php';
include "error.php";
// Check if the user is logged in and has the role attribute in the session
if (!isset($_SESSION['role'])) {
    echo "<script>alert('You are not authorized to see this page. Please login as a registered user.'); window.location.href='products.php';</script>";
    exit();
}

function displayCart() {
    $conn = connectToDb();

    echo "<div class='flex-container'>";
    $totalItems = 0;
    $totalPrice = 0.0;
    if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
        foreach ($_SESSION['cart'] as $productId => $quantity) {
            // Prepared statement for retrieving product details
            $sql = "SELECT productId, productName, productPrice, description, imageUrl FROM products WHERE productId = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $productId);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<div>";
                    echo "<img src='" . htmlspecialchars($row['imageUrl']) . "' alt='" . htmlspecialchars($row['productName']) . "'>";
                    echo "<h4>" . htmlspecialchars($row['productName']) . "</h4>";
                    echo "<p>" . htmlspecialchars($row['description']) . "</p>";
                    echo "<p>Price: " . htmlspecialchars($row['productPrice']) . "</p>";
                    // Continue with the rest of your form
                    echo "<form method='post' action='process.php' id='updateForm" . $productId . "'>";
                    echo "<input type='hidden' name='form_type' value='form1'>";
                    echo "<input type='number' name='quantity' value='" . htmlspecialchars($quantity) . "' onchange='document.getElementById(\"updateForm" . htmlspecialchars($productId) . "\").submit();'>";
                    echo "<input type='hidden' name='productId' value='" . htmlspecialchars($productId) . "'>";
                    echo "</form>";
                    echo "<form method='post' action='process.php'>";
                    echo "<input type='hidden' name='productId' value='" . htmlspecialchars($productId) . "'>";
                    echo "<input type='hidden' name='form_type' value='form2'>";
                    echo "<input type='hidden' name='remove' value='1'>";
                    echo "<input type='submit' value='Remove'>";
                    echo "</form>";
                    echo "</div>";
                    $totalItems += $quantity;
                    $totalPrice += $row['productPrice'] * $quantity;
                }
            } else {
                echo "No products found.";
            }
        }
    } else {
        echo "Your cart is empty.";
    }
    echo "</div>";

    // Rest of your code...
    echo "<p>Total items: " . $totalItems . "</p>";
    echo "<p>Total: " . $totalPrice . "</p>";
    $_SESSION['totalPrice'] = $totalPrice;
    $_SESSION['totalItems'] = $totalItems;

    echo "<form  method='POST' action='process.php'>";
    echo "<input type='hidden' name='form_type' value='form11'>";
    echo "<input type='submit' value='Checkout'>";
    echo "</form>";

    $conn->close();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Cart</title>
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
        displayCart();
        ?>
    </main>

    <footer>
        <p>Contact Us: contact@frk-tech.com</p>
    </footer>
</body>
</html>