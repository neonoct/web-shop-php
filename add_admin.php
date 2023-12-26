<?php
include 'db.php';

function addAdmin() {
    $conn = connectToDb();

    // Add an admin to the database
    $firstname = "admin3";
    $lastname = "admin";
    $email = "admin3@email.com";
    $password = "admin03.";
    $address = "";

    // Sanitize email before using in a query
    $email = mysqli_real_escape_string($conn, $email);

    // Prepared statement to check if the admin already exists
    $checkSql = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($checkSql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "<p>" . htmlspecialchars("Admin already exists.") . "</p>";
        exit();
    }

    $password = password_hash($password, PASSWORD_DEFAULT);

    // Prepared statement to insert admin data
    $sql = "INSERT INTO users (first_name, last_name, email, password, address, active, role) VALUES (?, ?, ?, ?, ?, 1, 1)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssss", $firstname, $lastname, $email, $password, $address);

    // Execute the query
    if ($stmt->execute()) {
        echo "<p>" . htmlspecialchars("Admin added to database.") . "</p>";
    } else {
        echo "<p>Error: " . htmlspecialchars($stmt->error) . "</p>";
    }

    // Close the prepared statement
    $stmt->close();
}

addAdmin();
?>
