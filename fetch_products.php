<?php
// Database configuration
include 'db.php';

function fetchProducts() {
    $conn = connectToDb(); // Connect to the database

    $searchQuery = isset($_GET['search']) ? $_GET['search'] : '';
    $categoryId = isset($_GET['category']) ? $_GET['category'] : '';

    // Start the query with placeholders
    $sql = "SELECT productId, productName, description, productPrice, imageUrl FROM products WHERE active = 1";

    // Determine the type of query based on input
    if ($searchQuery !== '' && $categoryId !== '' && $categoryId !== 'all') {
        $sql .= " AND productName LIKE ? AND categoryID = ?";
        $stmt = $conn->prepare($sql);
        $searchTerm = "%$searchQuery%";
        $stmt->bind_param("si", $searchTerm, $categoryId);
    } elseif ($searchQuery !== '') {
        $sql .= " AND productName LIKE ?";
        $stmt = $conn->prepare($sql);
        $searchTerm = "%$searchQuery%";
        $stmt->bind_param("s", $searchTerm);
    } elseif ($categoryId !== '' && $categoryId !== 'all') {
        $sql .= " AND categoryID = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $categoryId);
    } else {
        $stmt = $conn->prepare($sql);
    }

    // Execute the query
    $stmt->execute();
    $result = $stmt->get_result();

    // Output the products
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            //needs correction to be able to add to cart
            echo '<form method="post" action="process.php">';
            echo '<input type="hidden" name="form_type" value="form12">';
            echo '<div class="product-item">';
            echo '<img src="' . htmlspecialchars($row["imageUrl"]) . '" alt="' . htmlspecialchars($row["productName"]) . '">';
            echo '<h4>' . htmlspecialchars($row["productName"]) . '</h4>';
            echo '<p class="description" >' . htmlspecialchars($row["description"]) . '</p>';
            echo '<p class="price">Price: $' . htmlspecialchars($row["productPrice"]) . '</p>';
            echo '<button type="submit">Add to Cart</button>';
            echo '</div>';
            echo '</form>';
        }
    } else {
        echo "<p>No products found.</p>";
    }

    $conn->close();
}

fetchProducts();
?>
