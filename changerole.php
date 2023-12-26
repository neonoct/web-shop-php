<?php
include 'db.php';


function changeUserRole() {
    $conn = connectToDb();
    if (isset($_POST['userID']) && isset($_POST['role'])) {
        $userID = $_POST['userID'];
        $role = $_POST['role'];
        if($role == 'admin'){
            $role = 1;
        }
        else{
            $role = 2;
        }

        $sql = "UPDATE users SET role = $role WHERE user_id = $userID";
        $result = $conn->query($sql);
        if ($result === TRUE) {
            echo "Record updated successfully";
        } else {
            echo "Error updating record: " . $conn->error;
        }

    }
    $conn->close();
}

changeUserRole();

header("Location: admin.php");
?>