<?php
        include 'db.php';
        session_start();
        // display welcome admin if logged in        
        // If the user is not logged in or their role is not 1, redirect them.
        if (empty($_SESSION['role']) || $_SESSION['role'] != 1) {
            echo "<script>alert('You are not authorized to see this page. Please login.'); window.location.href='login.php';</script>"; // i would use header("Location: login.php"); but in this case 
            //before alerting the user it is redirecting to login.php and not showing the alert
            //so i found this code with window.location.href='login.php' and it is working 
            exit();
        }
        
        
        //make a table with all the users and their info so that the admin can remove or add that user
        // Database configuration

        function manipulateUser(){
            $conn = connectToDb(); //connect to the database
            //take the info from the session
            $sql = "SELECT * FROM users WHERE active = 1";
            $result = $conn->query($sql);
            echo "<h3>Users</h3>";
            echo "<table>";
            echo "<tr><th>UserID</th><th>Firstname</th><th>Lastname</th><th>Email</th><th>Address</th><th>Role</th><th>Remove</th></tr>";
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<tr><td>".$row["user_id"]."</td><td>".$row["first_name"]."</td><td>".$row["last_name"]."</td><td>".$row["email"]."</td><td>".$row["address"]."</td><td>";
                    echo "<form action='changerole.php' method='POST'>";
                    echo "<select name='role'>";
                    echo "<option value='user'".($row["role"] == 2 ? ' selected' : '').">User</option>";
                    echo "<option value='admin'".($row["role"] == 1 ? ' selected' : '').">Admin</option>";
                    echo "</select>";
                    echo "<input type='hidden' name='userID' value='".$row["user_id"]."'>";
                    echo "<input type='submit' value='Change Role'>";
                    echo "</form>";
                    echo "</td><td><form action='removeuser.php' method='POST'><button type='submit' name='remove' value='".$row["user_id"]."'>Remove</button></form></td></tr>";
                }
            }
            echo "</table>";
            //add a user
            $adduserstring= "<form action='adduser.php' id='reg' method='POST'><input type='text' id='firstname' name='firstname' placeholder='Firstname'><input type='text' id='lastname' name='lastname' placeholder='Lastname'>";
            $adduserstring.="<input type='text' id='email' name='email' placeholder='Email'><input type='password' id='password' name='password' placeholder='Password'><input type='password' id='confirmPassword' name='confirmpassword' placeholder='Password'><input type='text' name='address' placeholder='Address'>";
            $adduserstring.="<select name='role' id='role'><option value='user'>User</option><option value='admin'>Admin</option></select>";
            $adduserstring.="<button type='submit' name='add' value='add'>Add User</button></form>";
        
            echo $adduserstring;
            
            $conn->close();


        }
        
        function manipulateProduct(){
            $conn = connectToDb(); //connect to the database
            //make a table with all the products and their info so that the admin can remove or add that product
            $sql = "SELECT * FROM products WHERE active = 1";
            $result = $conn->query($sql);
            echo "<h3>Products</h3>";
            echo "<table>";
            echo "<tr><th>ProductID</th><th>Product Name</th><th>Description</th><th>Price</th><th>Category</th><th>ImageURL</th><th>Remove</th><th>Edit</th></tr>";
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
                    else{
                        $cat="Unknown";
                    }
                    
                    $productstring ="<tr><td>".$row["productId"]."</td><td>".$row["productName"]."</td><td>".$row["description"]."</td><td>".$row["productPrice"]."</td><td>".$row["categoryId"]."(".$cat.")"."</td>";
                    $productstring .="<td>".$row["imageUrl"]."</td><td><form action='removeproduct.php' method='POST'><button type='submit' name='remove' value='".$row["productId"]."'>Remove</button>";
                    $productstring .="</form></td><td><form id='edit' method='POST'><button type='submit' name='edit' value='".$row["productId"]."'>Edit</button></form></td></tr>";
                    echo $productstring;
                    if(isset($_POST['edit']) && $_POST['edit'] == $row["productId"]){
                        $editproductstring= "<form action='editproduct.php' method='POST'>";
                        //alert imageurl
                        #$x=$row["imageUrl"];
                        #echo "<script>alert('Image URL is $x') </script>";
                        $editproductstring.=  "<tr><td><input type='hidden' name='productId' value='".$row["productId"]."'>".$row["productId"]."</td><td><input type='text' name='productName' value='".$row["productName"]."'></td>";
                        $editproductstring.= "<td><input type='text' id='description' name='description' value='".$row["description"]."'></td><td><input type='text' name='productPrice' value='".$row["productPrice"]."'></td>";
                        $editproductstring.="<td><input type='text' name='categoryId' value='".$row["categoryId"]."'></td><td><input type='text' name='imageUrl' value='".$row["imageUrl"]."'></td>";
                        $editproductstring.="<td><button type='submit' name='save' value='".$row["productId"]."'>Save</button></td></tr>";
                        $editproductstring.= "</form>";
                        echo $editproductstring;
                    }
                }
            }
            echo "</table>";
            //add a product
            $addproductstring= "<form action='addproduct.php' method='POST'><input type='text' name='productname' placeholder='Product Name'>";
            $addproductstring.="<input type='text' name='productprice' placeholder='Product Price'><input type='text' name='categoryid' placeholder='Category ID'>";
            //add description,imageurl
            $addproductstring.="<input type='text' name='description' placeholder='Description'><input type='text' name='imageurl' placeholder='Image URL'>";
            $addproductstring.="<button type='submit' name='add' value='add'>Add Product</button></form>";
            echo $addproductstring;
            $conn->close();

        }

        function manipulateData(){
            manipulateUser();
            manipulateProduct();
        }

        
        
        


   
        
?>
        
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Webshop Home</title>
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
        <h2>Welcome to Our Webshop!</h2>
        <h3>Admin Page</h3>
        <?php
        // display welcome admin
        echo "<p>Welcome Admin ",$_SESSION['firstname'],' ',$_SESSION['lastname'],"</p>";
        // logout button
        echo "<form action='logout.php' method='POST'><button type='submit'>Logout</button></form>";
        manipulateData();
        ?>


    </main>

    <footer>
        <p>Contact Us: contact@frk-tech.com</p>
    </footer>
</body>
</html>
