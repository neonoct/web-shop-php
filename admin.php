<?php
        session_start();
        // display welcome admin if logged in        
        // If the user is not logged in or their role is not 1, redirect them.
        if (empty($_SESSION['role']) || $_SESSION['role'] != 1) {
            echo "<script>alert('You are not authorized to see this page. Please login.'); window.location.href='login.php';</script>"; // i would use header("Location: login.php"); but in this case 
            //before alerting the user it is redirecting to login.php and not showing the alert
            //so i found this code with window.location.href='login.php' and it is working 
            exit();
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
        include 'db.php';
        // display welcome admin
        echo "<p>Welcome Admin ",$_SESSION['firstname'],' ',$_SESSION['lastname'],"</p>";
        // logout button
        echo "<form action='logout.php' method='POST'><button type='submit'>Logout</button></form>";
        //make a table with all the users and their info so that the admin can remove or add that user
        // Database configuration
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
        //make a table with all the products and their info so that the admin can remove or add that product
        $sql = "SELECT * FROM products WHERE active = 1";
        $result = $conn->query($sql);
        echo "<h3>Products</h3>";
        echo "<table>";
        echo "<tr><th>ProductID</th><th>Product Name</th><th>Price</th><th>Category</th><th>Remove</th><th>Edit</th></tr>";
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<tr><td>".$row["productId"]."</td><td>".$row["productName"]."</td><td>".$row["productPrice"]."</td><td>".$row["categoryId"]."</td><td><form action='removeproduct.php' method='POST'><button type='submit' name='remove' value='".$row["productId"]."'>Remove</button></form></td><td><form action='editproduct.php' method='POST'><button type='submit' name='edit' value='".$row["productId"]."'>Edit</button></form></td></tr>";
            }
        }
        echo "</table>";


   
        ?>

    </main>

    <footer>
        <p>Contact Us: contact@frk-tech.com</p>
    </footer>

</body>
</html>
