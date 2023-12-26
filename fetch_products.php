<?php
// Database configuration
include 'db.php';

function fetchProducts() {
    $conn = connectToDb(); //connect to the database

    $searchQuery = isset($_GET['search']) ? $_GET['search'] : '';
    $categoryId = isset($_GET['category']) ? $_GET['category'] : '';

    // Start the query
    $sql = "SELECT productID, productName, description, productPrice, imageUrl FROM products WHERE active = 1";

    // Append to the query if there's a search term
    if ($searchQuery !== '') {
        $sql .= " AND productName LIKE '%" . $conn->real_escape_string($searchQuery) . "%'";
    }

    // Append to the query if there's a category selected
    if ($categoryId !== '' && $categoryId !== 'all') {
        $sql .= " AND categoryID = " . intval($categoryId);
    }

    $result = $conn->query($sql);

    // Output the products
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            // Your product HTML structure here
            echo '<div class="product-item">';
            echo '<img src="' . $row["imageUrl"] . '" alt="' . $row["productName"] . '">';
            echo '<h4>' . $row["productName"] . '</h4>';
            echo '<p class="description" >' . $row["description"] . '</p>';
            echo '<p class="price">Price: $' . $row["productPrice"] . '</p>';
            echo '<button>Add to Cart</button>';
            echo '</div>';
        }
    } else {
        echo "<p>No products found.</p>";
    }

    $conn->close();
}
fetchProducts();

?>
