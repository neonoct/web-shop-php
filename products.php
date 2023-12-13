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
            </ul>
        </nav>
    </header>
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
            <option value="electronics">Electronics</option>
            <option value="clothing">Clothing</option>
            <option value="accessories">Accessories</option>
            <!-- Add more categories as needed -->
        </select>
    </div>

    <main>
        <h2>Welcome to Our Webshop!</h2>
        <!-- Featured Products Section -->
        <section class="featured-products">
            <h3>Featured Products</h3>
            <!-- Product items will be added here -->
            
            <div class="product-container" >
                <?php
                    // Database configuration
                    $host     = "localhost";
                    $dbName   = "shopDb";
                    $username = "Webuser";
                    $password = "Lab2021";

                    // Create connection
                    $conn = new mysqli($host, $username, $password, $dbName);

                    // Check connection
                    if ($conn->connect_error) {
                        die("Connection failed: " . $conn->connect_error);
                    }

                    // SQL query to select all active products
                    $sql = "SELECT productID, productName, description, productPrice, imageUrl FROM products WHERE active = 1";
                    $result = $conn->query($sql);

                    // Check if there are results
                    if ($result->num_rows > 0) {
                        // Output data of each row
                        while($row = $result->fetch_assoc()) {
                            echo '<div class="product-item">';
                            echo '<img src="' . $row["imageUrl"] . '" alt="' . $row["productName"] . '">';
                            echo '<h4>' . $row["productName"] . '</h4>';
                            echo '<p>' . $row["description"] . '</p>';
                            echo '<p class="price">Price: $' . $row["productPrice"] . '</p>';
                            echo '<button>Add to Cart</button>';
                            echo '</div>';
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
        <p>Contact Us: contact@yourwebshop.com</p>
    </footer>
</body>
</html>
