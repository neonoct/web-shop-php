<?php
session_start();

if (isset($_POST['productID'])) {
    $productID = $_POST['productID'];

    if (isset($_POST['remove'])) {
        unset($_SESSION['cart'][$productID]);
    } elseif (isset($_POST['quantity'])) {
        $quantity = intval($_POST['quantity']);

        if (isset($_SESSION['cart'][$productID])) {
            if ($quantity > 0) {
                $_SESSION['cart'][$productID] = $quantity;
            }
        }
    }
}

header("Location: cart.php");
?>