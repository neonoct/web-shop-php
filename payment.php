<?php

include 'db.php';
function processPayment() {
    $conn = connectToDb(); //connect to the database

    session_start();
    if (isset($_SESSION['cart']) && count($_SESSION['cart']) > 0) {
        // Process payment
        //save to database instead of payment

        $customerID = $_SESSION['user_id'];
        $sql = "INSERT INTO orders (customerId, date) VALUES ($customerID, NOW())";
        //if successful add to ordersproducts table(orderId,productId,quantity) and add to payments table(paymentId,orderId,amount)
        if ($conn->query($sql) === TRUE) {
            $last_id = $conn->insert_id;
            $totalPrice = $_SESSION['totalPrice'];
            foreach ($_SESSION['cart'] as $productID => $quantity) {
                $sql = "INSERT INTO ordersproducts (orderId, productId, quantity) VALUES ($last_id, $productID, $quantity)";
                $conn->query($sql);
            }
            $sql = "INSERT INTO payments (orderId, amount) VALUES ($last_id, $totalPrice)";
            $conn->query($sql);
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
            exit();
        }

        // Clear cart
        unset($_SESSION['cart']);
        echo "Your order has been placed.";
        // Redirect user to myaccount page with a link
        echo "You can view your order history here:";
        echo "<a href='myaccount.php'>My Account</a>";

    } else {
        echo "Your cart is empty.";
    }
    $conn->close();
}

processPayment();

?>