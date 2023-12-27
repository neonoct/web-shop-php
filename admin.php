<?php
########
#there arent any javascript checks for the admin page forms where admin adds new user or product 
#####
include 'db.php';
include "error.php";
session_start();


if (empty($_SESSION['role']) || $_SESSION['role'] != 1) {
    echo "<script>alert('You are not authorized to see this page. Please login.'); window.location.href='login.php';</script>";
    exit();
}

function manipulateUser() {
    try{
        $conn = connectToDb();


    // Prepared statement for selecting users
    $sql = "SELECT * FROM users WHERE active = 1";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->get_result();

    echo "<h3>Users</h3>";
    echo "<table>";
    echo "<tr><th>UserID</th><th>Firstname</th><th>Lastname</th><th>Email</th><th>Address</th><th>Role</th><th>Remove</th></tr>";

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            // Echo with htmlspecialchars
            echo "<tr><td>".htmlspecialchars($row["user_id"])."</td>";
            // Continue echoing other fields with htmlspecialchars...
            echo "<td>".htmlspecialchars($row["first_name"])."</td>";
            echo "<td>".htmlspecialchars($row["last_name"])."</td>";
            echo "<td>".htmlspecialchars($row["email"])."</td>";
            echo "<td>".htmlspecialchars($row["address"])."</td>";
            echo "<td>";
            echo "<form action='process.php' method='POST'>";
            echo "<input type='hidden' name='form_type' value='form3'>";
            echo "<select name='role'>";
            echo "<option value='user'".($row["role"] == 2 ? ' selected' : '').">User</option>";
            echo "<option value='admin'".($row["role"] == 1 ? ' selected' : '').">Admin</option>";
            echo "</select>";
            echo "<input type='hidden' name='userID' value='".htmlspecialchars($row["user_id"])."'>";
            echo "<input type='submit' value='Change Role'>";
            echo "</form>";
            echo "</td><td><form action='process.php' method='POST'><input type='hidden' name='form_type' value='form4'><button type='submit' name='remove' value='".htmlspecialchars($row["user_id"])."'>Remove</button></form></td></tr>";
            

        }
    }
    echo "</table>";

    echo "<form action='process.php' id='reg' method='POST'>"; 
    echo "<input type='hidden' name='form_type' value='form5'>";
    echo "<input type='text' id='firstname' name='firstname' placeholder='Firstname'>";
    echo "<input type='text' id='lastname' name='lastname' placeholder='Lastname'>";
    echo "<input type='text' id='email' name='email' placeholder='Email'>";
    echo "<input type='password' id='password' name='password' placeholder='Password'>";
    echo "<input type='password' id='confirmPassword' name='confirmpassword' placeholder='Password'>";
    echo "<input type='text' name='address' placeholder='Address'>";
    echo "<select name='role' class='role'>";
    echo "<option value='2'>User</option>";
    echo "<option value='1'>Admin</option>";
    echo "</select>";
    echo "<button type='submit' name='add' value='add'>Add User</button>";
    echo "</form>";
    echo '<p>*to add a user you need to fill at least the firstname, lastname, email, password(and confirmpassword), and role fields</p>';
    // ...

    $conn->close();
    }catch(Exception $e){
        echo $e->getMessage();
    }
    
}

function manipulateProduct() {
    $conn = connectToDb();

    // Prepared statement for selecting products
    $sql = "SELECT * FROM products WHERE active = 1";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->get_result();

    echo "<h3>Products</h3>";
    echo "<table>";
    echo "<tr><th>productId</th><th>Product Name</th><th>Description</th><th>Price</th><th>Category</th><th>ImageURL</th><th>Remove</th><th>Edit</th></tr>";
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            //if category is 1 then it is a laptop if 2 then it is a desktop if 3 then it is a accessory
            if($row["categoryId"]==1){
                $cat="Laptop";
            }
            else if($row["categoryId"]==2){
                $cat="Desktop";
            }
            else if($row["categoryId"]==3){
                $cat="Accessory";
            }
            echo "<tr><td>".htmlspecialchars($row["productId"])."</td>";
            echo "<td>".htmlspecialchars($row["productName"])."</td>";
            echo "<td>".htmlspecialchars($row["description"])."</td>";
            echo "<td>".htmlspecialchars($row["productPrice"])."</td>";
            echo "<td>".htmlspecialchars($cat)."</td>";
            echo "<td>".htmlspecialchars($row["imageUrl"])."</td>";
            echo "<td><form action='process.php' method='POST'><input type='hidden' name='form_type' value='form6'><button type='submit' name='remove' value='".htmlspecialchars($row["productId"])."'>Remove</button></form></td>";
            echo "<td><form id='edit-".htmlspecialchars($row["productId"])."' method='POST'><input type='hidden' name='form_type' value='form7'><button type='submit' name='edit' value='".htmlspecialchars($row["productId"])."'>Edit</button></form></td></tr>";
            if(isset($_POST['edit']) && $_POST['edit'] == $row["productId"]){
                echo "<form action='process.php' method='POST'>";
                echo "<input type='hidden' name='form_type' value='form8'>";
                echo "<tr><td><input type='hidden' name='productId' value='".htmlspecialchars($row["productId"])."'>".htmlspecialchars($row["productId"])."</td>";
                echo "<td><input type='text' name='productName' value='".htmlspecialchars($row["productName"])."'></td>";
                echo "<td><input type='text' id='description' name='description' value='".htmlspecialchars($row["description"])."'></td>";
                echo "<td><input type='text' name='productPrice' value='".htmlspecialchars($row["productPrice"])."'></td>";
                #echo "<td><input type='text' name='categoryId' value='".htmlspecialchars($row["categoryId"])."'></td>";
                // Add a select box for category
                echo "<td><select name='categoryId'>";
                echo "<option value='1'".($row["categoryId"] == 1 ? ' selected' : '').">Laptop</option>";
                echo "<option value='2'".($row["categoryId"] == 2 ? ' selected' : '').">Desktop</option>";
                echo "<option value='3'".($row["categoryId"] == 3 ? ' selected' : '').">Accessory</option>";
                echo "</select></td>";
                echo "<td><input type='text' name='imageUrl' value='".htmlspecialchars($row["imageUrl"])."'></td>";
                echo "<td><button type='submit' name='save' value='".htmlspecialchars($row["productId"])."'>Save</button></td></tr>";
                echo "</form>";
                
            }
        }
    }
    echo "</table>";
    
    //add a product
    echo "<form action='process.php' method='POST'>";
    echo "<input type='hidden' name='form_type' value='form9'>";
    echo "<input type='text' name='productname' placeholder='Product Name'>";
    echo "<input type='text' name='productprice' placeholder='Product Price'>";
    echo "<input type='text' name='description' placeholder='Description'>";
    echo "<input type='text' name='imageurl' placeholder='Image URL'>";
    echo "<select name='categoryId' class='role'>";
    echo "<option value='1'>Laptop</option>";
    echo "<option value='2'>Desktop</option>";
    echo "<option value='3'>Accessory</option>";
    echo "</select>";
    echo "<button type='submit' name='add' value='add'>Add Product</button>";
    echo "</form>";
    echo '<p>*to add a product you have to fill the productname, productprice, description, imageurl, and category fields</p>';
    $conn->close();
}

function manipulateData() {
    manipulateUser();
    manipulateProduct();
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Page</title>
    <link rel="stylesheet" href="admin.css">
</head>
<body>
    <header>
        <h1>FRK-Tech</h1>
        <nav>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="products.php">Products</a></li>
                <li><a href="login.php">Login</a></li>
                <li><a href="register.php">Register</a></li>
                <li><a href="cart.php">Cart</a></li>
                <li><a href="myaccount.php">My Account</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <h2>Admin Page</h2>
        <?php
        // display welcome admin
        echo "<p>Welcome Admin ".$_SESSION['firstname']." ".$_SESSION['lastname']."</p>";
        // logout button
        echo "<form action='process.php' method='POST'><input type='hidden' name='form_type' value='form10'><button type='submit'>Logout</button></form>";
        manipulateData(); 
        ?>
    </main>
    <footer>
        <p>Contact Us: contact@frk-tech.com</p>
    </footer>
</body>
</html>
