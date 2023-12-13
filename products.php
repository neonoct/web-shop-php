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
                            echo '<p class="description" >' . $row["description"] . '</p>';
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
        <!-- Place jQuery script before your custom script -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <!-- Include your custom script -->
        <script>
            $(document).ready(function(){
                // Function to fetch products
                function fetchProducts(searchQuery, categoryId) {
                    $.ajax({
                        url: 'fetch_products.php', // the PHP file to handle the request
                        type: 'GET',
                        data: {
                            search: searchQuery,
                            category: categoryId
                        },
                        success: function(data) {
                            // Replace the content of the product-container with the new data
                            $('.product-container').html(data);
                        }
                    });
                }
                
                // Event listener for the search bar
                $('input[name="search"]').on('input', function() {
                    var searchQuery = $(this).val();
                    var categoryId = $('#categories').val();
                    fetchProducts(searchQuery, categoryId);
                });

                // Event listener for the category selector
                $('#categories').on('change', function() {
                    var categoryId = $(this).val();
                    var searchQuery = $('input[name="search"]').val();
                    fetchProducts(searchQuery, categoryId);
                });
            });
        </script>
</body>
</html>
