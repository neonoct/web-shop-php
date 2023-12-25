<?php
// Database configuration
include 'db.php';
$conn = connectToDb(); //connect to the database

//take the info from the post and make a new product
if (isset($_POST['add'])) {
    $productName = $_POST['productname'];
    $productPrice = $_POST['productprice'];
    $categoryID = $_POST['categoryid'];
    $description = $_POST['description'];
    $imageURL = $_POST['imageurl'];
    //set active to 0
    $sql = "INSERT INTO products (productName, productPrice, categoryId, description, imageURL,active) VALUES ('$productName', '$productPrice', '$categoryID', '$description', '$imageURL',1)";
    $result = $conn->query($sql);
    if ($result === TRUE) {
        echo "Record updated successfully";
    } else {
        echo "Error updating record: " . $conn->error;
    }
   
}
header("Location: admin.php");


?>