
<?php
include 'db.php';
function addUser() {
    $conn = connectToDb();

    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $address = $_POST['address'];
    $role = $_POST['role'];
    
    //if role is admin then 1 if user then 2
    if($role == 'admin'){
        $role = 1;
    }
    else{
        $role = 2;
    }

    $sql = "INSERT INTO users (first_name, last_name, email, password, address, role, active) VALUES ('$firstname', '$lastname', '$email', '$password', '$address', '$role', 1)";
    $result = $conn->query($sql);
    if ($result === TRUE) {
        echo "Record updated successfully";
    } else {
        echo "Error updating record: " . $conn->error;
    }

    $conn->close();
}

header("Location: admin.php");
exit();




?>