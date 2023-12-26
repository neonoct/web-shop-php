<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    switch ($_POST['form_type']) {
        case 'form1':
            updateCart();
            break;
        case 'form2':
            updateCart();
            break;
        case 'form3':
            changeUserRole();
            break;
        case 'form4':
            removeUser();
            break;
        case 'form5':
            addUser();
            break;
        case 'form6':
            removeProduct();
            break;
        case 'form7':
            //show edit product page
            break;
        case 'form8':
            updateProduct();
            break;
        case 'form9':
            addProduct();
            break;
        case 'form10':
            logout();
            break;
        case 'form11':
            processPayment();
            break;

        
        // Add cases for other forms
    }
}


function updateCart() {
    session_start();
    if (isset($_POST['productID'])) {
        $productID = $_POST['productID'];

        if (isset($_POST['remove'])) {
            unset($_SESSION['cart'][$productID]);
        } elseif (isset($_POST['quantity'])) {
            $quantity = intval($_POST['quantity']);

            if (isset($_SESSION['cart'][$productID])) {
                if ($quantity > 0) {
                    $_SESSION['cart'][$productID] = $quantity;
                }
            }
        }
    }
    header("Location: cart.php");
}

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
    header("Location: admin.php");
}

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
    header("Location: admin.php");
}

function addUser() {
    $conn = connectToDb();

    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $address = $_POST['address'];
    $role = $_POST['role'];

    //hash the password
    $password = password_hash($password, PASSWORD_DEFAULT);
    
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
    header("Location: admin.php");
}

function removeProduct() {
    $conn = connectToDb(); //connect to the database

    //take the info from the post and make the active 0
    if (isset($_POST['remove'])) {
        $productID = $_POST['remove'];
        //set active to 0
        $sql = "UPDATE products SET active = 0 WHERE productId = $productID";
        $result = $conn->query($sql);
        if ($result === TRUE) {
            echo "Record updated successfully";
        } else {
            echo "Error updating record: " . $conn->error;
        }
       
    }
    $conn->close();
    header("Location: admin.php");
}

//maybe another function will be here

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
    header("Location: admin.php");
}

function addProduct() {
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
    $conn->close();
    header("Location: admin.php");
}

function logout() {
    session_start();
    session_destroy();
    header("Location: index.php");
    exit();
}

function processPayment() {
    $conn = connectToDb(); //connect to the database

    session_start();
    if (isset($_SESSION['cart']) && count($_SESSION['cart']) > 0) {
        // Process payment
        //save to database instead of payment

        $customerID = $_SESSION['user_id'];
        $sql = "INSERT INTO orders (customerId, date) VALUES ($customerID, NOW())";
        //if successful add to ordersproducts table(orderId,productId,quantity) and add to payments table(paymentId,orderId,amount)
        if ($conn->query($sql) === TRUE) {
            $last_id = $conn->insert_id;
            $totalPrice = $_SESSION['totalPrice'];
            foreach ($_SESSION['cart'] as $productID => $quantity) {
                $sql = "INSERT INTO ordersproducts (orderId, productId, quantity) VALUES ($last_id, $productID, $quantity)";
                $conn->query($sql);
            }
            $sql = "INSERT INTO payments (orderId, amount) VALUES ($last_id, $totalPrice)";
            $conn->query($sql);
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
            exit();
        }

        // Clear cart
        unset($_SESSION['cart']);
        echo "Your order has been placed.";
        // Redirect user to myaccount page with a link
        echo "You can view your order history here:";
        echo "<a href='myaccount.php'>My Account</a>";

    } else {
        echo "Your cart is empty.";
    }
    $conn->close();
}

?>
