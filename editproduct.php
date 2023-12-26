<?php
// Database configuration
include 'db.php';
function updateProduct() {
    $conn = connectToDb(); //connect to the database
    //take the info from the post and then update the product
    if (isset($_POST['save'])) {
        $productID = $_POST['productId'];
        $productName = $_POST['productName'];
        $productPrice = $_POST['productPrice'];
        $categoryID = $_POST['categoryId'];
        $description = $_POST['description'];
        $imageURL = $_POST['imageUrl'];
        //set active to 0
        $sql = "UPDATE products SET productName = '$productName', productPrice = '$productPrice', categoryId = '$categoryID', description = '$description', imageURL = '$imageURL' WHERE productId = $productID";
        $result = $conn->query($sql);
        if ($result === TRUE) {
            echo "Record updated successfully";
        } else {
            echo "Error updating record: " . $conn->error;
        }
    }
    $conn->close();
}
updateProduct();
header("Location: admin.php");




?>