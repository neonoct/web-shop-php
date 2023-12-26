<?php
include 'db.php';
include "error.php";

function displayProducts() {
    $conn = connectToDb(); // Connect to the database

    // Prepared statement for selecting products
    $sql = "SELECT productId, productName, description, productPrice, imageUrl FROM products WHERE active = 1";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if there are results
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo '<form method="post" action="process.php">';
            echo '<input type="hidden" name="form_type" value="form12">';
            echo '<div class="product-item">';
            echo '<img src="' . htmlspecialchars($row["imageUrl"]) . '" alt="' . htmlspecialchars($row["productName"]) . '">';
            echo '<h4>' . htmlspecialchars($row["productName"]) . '</h4>';
            echo '<p class="description">' . htmlspecialchars($row["description"]) . '</p>';
            echo '<p class="price">Price: $' . htmlspecialchars($row["productPrice"]) . '</p>';
            echo '<input type="hidden" name="productId" value="' . htmlspecialchars($row["productId"]) . '">';
            echo '<button type="submit">Add to Cart</button>';
            echo '</div>';
            echo '</form>';
        }
    } else {
        echo "0 results";
    }

    // Close connection
    $stmt->close();
    $conn->close();
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
                    <!-- Search Bar -->
            <div class="search-container">
                <input type="text" placeholder="Search products..." name="search">
                <button type="submit">Search</button> <!--this  button is not necessary but it better indicates that the search bar is a search bar-->
            </div>
                <!-- Category Selector -->
            <div class="category-container">
                <label for="categories">Choose a category:</label>
                <select name="categories" id="categories">
                    <option value="all">All Categories</option>
                    <option value="1">Laptop</option>
                    <option value="2">Desktop</option>
                    <option value="3">Accessories</option>
                </select>
            </div>
            
            <div class="product-container" >
                <?php
                displayProducts();
                ?>

            </div>
            
        </section>
    </main>

    <footer>
        <p>Contact Us: contact@frk-tech.com</p>
    </footer>
    <!-- Include jQuery library -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Include  custom script -->
    <script src="fetchproducts.js"></script>
</body>
</html>
