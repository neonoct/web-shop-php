<?php
session_start();

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = array();
}

if (isset($_POST['productID'])) {
    if (!isset($_SESSION['role'])) {
        echo "<script type='text/javascript'>alert('You must be logged in to add products to the cart.'); window.location.href = 'login.php';</script>";
    } else {
        if (isset($_SESSION['cart'][$_POST['productID']])) {
            $_SESSION['cart'][$_POST['productID']]++;
        } else {
            $_SESSION['cart'][$_POST['productID']] = 1;
        }
    }
}
?>

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
        <section class="featured-products">
            <h3>Featured Products</h3>
            <!-- Product items will be added here -->
                    <!-- Search Bar -->
            <div class="search-container">
                <input type="text" placeholder="Search products..." name="search">
                <button type="submit">Search</button>
            </div>
                <!-- Category Selector -->
            <div class="category-container">
                <label for="categories">Choose a category:</label>
                <select name="categories" id="categories">
                    <option value="all">All Categories</option>
                    <option value="1">Laptop</option>
                    <option value="2">Desktop</option>
                    <option value="3">Accessories</option>
                    <!-- Add more categories as needed -->
                </select>
            </div>
            
            <div class="product-container" >
                <?php
                    // Database configuration
                    include 'db.php';
                    $conn = connectToDb(); //connect to the database

        

                    // SQL query to select all active products
                    $sql = "SELECT productID, productName, description, productPrice, imageUrl FROM products WHERE active = 1";
                    $result = $conn->query($sql);

                    // Check if there are results
                    if ($result->num_rows > 0) {
                        // Output data of each row
                        while($row = $result->fetch_assoc()) {
                            echo '<form method="post" action="products.php">';
                            echo '<div class="product-item">';
                            echo '<img src="' . $row["imageUrl"] . '" alt="' . $row["productName"] . '">';
                            echo '<h4>' . $row["productName"] . '</h4>';
                            echo '<p class="description" >' . $row["description"] . '</p>';
                            echo '<p class="price">Price: $' . $row["productPrice"] . '</p>';
                            echo '<input type="hidden" name="productID" value="' . $row["productID"] . '">';
                            echo '<button type="submit">Add to Cart</button>';
                            echo '</div>';
                            echo '</form>';
                        }
                    } else {
                        echo "0 results";
                    }

                    // Close connection
                    $conn->close();
                ?>

            </div>
            
        </section>
    </main>

    <footer>
        <p>Contact Us: contact@frk-tech.com</p>
    </footer>
        <!-- Place jQuery script before your custom script -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <!-- Include your custom script -->
        <script src="fetchproducts.js"></script>
</body>
</html>
