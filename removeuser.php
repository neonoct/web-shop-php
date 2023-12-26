<?php
include 'db.php';
function removeUser() {
    $conn = connectToDb(); //connect to the database

    //take the info from the post and make the active 0
    if (isset($_POST['remove'])) {
        $userID = $_POST['remove'];
        //set active to 0
        $sql = "UPDATE users SET active = 0 WHERE user_id = $userID";
        $result = $conn->query($sql);
        if ($result === TRUE) {
            echo "Record updated successfully";
        } else {
            echo "Error updating record: " . $conn->error;
        }
       
    }
    $conn->close();
}

removeUser();
header("Location: admin.php");
?>