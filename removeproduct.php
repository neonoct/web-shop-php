<?php

include 'db.php';
// Database configuration
$conn = connectToDb(); //connect to the database

//take the info from the post and make the active 0
if (isset($_POST['remove'])) {
    $productID = $_POST['remove'];
    //set active to 0
    $sql = "UPDATE products SET active = 0 WHERE productId = $productID";
    $result = $conn->query($sql);
    if ($conn->query($sql) === TRUE) {
        echo "Record updated successfully";
    } else {
        echo "Error updating record: " . $conn->error;
    }
   
}
header("Location: admin.php");

?>