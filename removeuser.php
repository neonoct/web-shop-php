<?php
include 'db.php';
$conn = connectToDb();

if (isset($_POST['remove'])) {
    $userID = $_POST['remove'];
    //set active to 0
    $sql = "UPDATE users SET active = 0 WHERE user_id = $userID";
    $result = $conn->query($sql);
    if ($conn->query($sql) === TRUE) {
        echo "Record updated successfully";
    } else {
        echo "Error updating record: " . $conn->error;
    }
   
}

header("Location: admin.php");
?>