<?php
include 'db.php';
include "error.php";

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
        case 'form12':
            addToCart();
            break;

    }
}


function updateCart() {
    session_start();
    if (isset($_POST['productId'])) {
        $productId = filter_input(INPUT_POST, 'productId', FILTER_SANITIZE_NUMBER_INT);

        if (isset($_POST['remove'])) {
            unset($_SESSION['cart'][$productId]);
        } elseif (isset($_POST['quantity'])) {
            $quantity = filter_input(INPUT_POST, 'quantity', FILTER_SANITIZE_NUMBER_INT);

            if (isset($_SESSION['cart'][$productId]) && $quantity > 0) {
                $_SESSION['cart'][$productId] = $quantity;
            }
        }
    }
    header("Location: cart.php");
}

function changeUserRole() {
    $conn = connectToDb();
    if (isset($_POST['userID']) && isset($_POST['role'])) {
        $userID = intval($_POST['userID']);
        $role = ($_POST['role'] == 'admin') ? 1 : 2;

        $stmt = $conn->prepare("UPDATE users SET role = ? WHERE user_id = ?");
        $stmt->bind_param("ii", $role, $userID);
        $stmt->execute();
        $stmt->close();
    }
    $conn->close();
    header("Location: admin.php");
}

function removeUser() {
    $conn = connectToDb();
    if (isset($_POST['remove'])) {
        $userID = intval($_POST['remove']);

        $stmt = $conn->prepare("UPDATE users SET active = 0 WHERE user_id = ?");
        $stmt->bind_param("i", $userID);
        $stmt->execute();
        $stmt->close();
    }
    $conn->close();
    header("Location: admin.php");
}

function addUser() {
    $conn = connectToDb();
    if (isset($_POST['firstname']) && isset($_POST['lastname']) && isset($_POST['email'])  && isset($_POST['password'])  && isset($_POST['confirmpassword']) && ($_POST['password'] == $_POST['confirmpassword'])) {
        $firstname = filter_input(INPUT_POST, 'firstname', FILTER_UNSAFE_RAW);
        $lastname = filter_input(INPUT_POST, 'lastname', FILTER_UNSAFE_RAW);
        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
        $address = filter_input(INPUT_POST, 'address', FILTER_UNSAFE_RAW);
        $password = $_POST['password'];
        $role = $_POST['role'];

        $stmt = $conn->prepare("SELECT email FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            echo "<script>alert('Email already in use.');</script>";
            exit();
        }

        $passwordHash = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO users (first_name, last_name, email, password, address, active, role) VALUES (?, ?, ?, ?, ?, 1, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssssi", $firstname, $lastname, $email, $passwordHash, $address, $role);

        if ($stmt->execute()) {
            echo "<p>Registration successful.</p>";
        } else {
            echo "<p>Error: " . htmlspecialchars($conn->error) . "</p>";
        }

        $stmt->close();
    } else {
        exit();
    }

    $conn->close();
    header("Location: admin.php");
}

function removeProduct() {
    $conn = connectToDb();
    if (isset($_POST['remove'])) {
        $productID = intval($_POST['remove']);

        $stmt = $conn->prepare("UPDATE products SET active = 0 WHERE productId = ?");
        $stmt->bind_param("i", $productID);
        $stmt->execute();
        $stmt->close();
    }
    $conn->close();
    header("Location: admin.php");
}

function updateProduct() {
    $conn = connectToDb();
    if (isset($_POST['productId']) && isset($_POST['productName']) && isset($_POST['description']) && isset($_POST['productPrice']) && isset($_POST['imageUrl'])) {
        $productId = intval($_POST['productId']);
        $productName = filter_input(INPUT_POST, 'productName', FILTER_UNSAFE_RAW);
        $description = filter_input(INPUT_POST, 'description', FILTER_UNSAFE_RAW);
        $productPrice = filter_input(INPUT_POST, 'productPrice', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        $imageUrl = filter_input(INPUT_POST, 'imageUrl', FILTER_SANITIZE_URL);
        $categoryId = filter_input(INPUT_POST, 'categoryId', FILTER_SANITIZE_NUMBER_INT);

        $stmt = $conn->prepare("UPDATE products SET productName = ?, description = ?, productPrice = ?, imageUrl = ?, categoryId = ? WHERE productId = ?");
        $stmt->bind_param("ssdsii", $productName, $description, $productPrice, $imageUrl, $categoryId, $productId);
        $stmt->execute();
        $stmt->close();
    }
    $conn->close();
    header("Location: admin.php");
}

function addProduct() {
    $conn = connectToDb();
    if (isset($_POST['productname']) && isset($_POST['description']) && isset($_POST['productprice']) && isset($_POST['imageurl'])&& isset($_POST['categoryId'])) {
        $productName = filter_input(INPUT_POST, 'productname', FILTER_UNSAFE_RAW);
        $description = filter_input(INPUT_POST, 'description', FILTER_UNSAFE_RAW);
        $productPrice = filter_input(INPUT_POST, 'productprice', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        $imageUrl = filter_input(INPUT_POST, 'imageurl', FILTER_SANITIZE_URL);
        $categoryId = filter_input(INPUT_POST, 'categoryId', FILTER_SANITIZE_NUMBER_INT);

        $stmt = $conn->prepare("INSERT INTO products (productName, description, productPrice, imageUrl, categoryId, active) VALUES (?, ?, ?, ?, ?, 1)");
        $stmt->bind_param("ssdsi", $productName, $description, $productPrice, $imageUrl, $categoryId);
        $stmt->execute();
        $stmt->close();

    }else{
        log("New product not added");
    }

    $conn->close();
    header("Location: admin.php");
}

function logout() {
    session_start();
    session_destroy();
    header("Location: index.php");
}

function processPayment() {
    session_start();
    if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
        $conn = connectToDb();

        #$totalItems = 0;
        #$totalPrice = 0.0;
        $totalPrice = $_SESSION['totalPrice'];
        foreach ($_SESSION['cart'] as $productId => $quantity) {
            $sql = "SELECT productPrice FROM products WHERE productId = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $productId);
            $stmt->execute();
            $result = $stmt->get_result();
            $stmt->close();

        }

        $stmt=$conn->prepare("INSERT INTO orders (customerId,date) VALUES (?,NOW())");
        $stmt->bind_param("i", $_SESSION['user_id']);
        $stmt->execute();
        $stmt->close();

        $orderID = $conn->insert_id;

        foreach ($_SESSION['cart'] as $productId => $quantity) {

            $sql = "INSERT INTO ordersproducts (orderId, productId, quantity) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("iii", $orderID, $productId, $quantity);
            $stmt->execute();
            $stmt->close();
        }
        #INSERT INTO payments (orderId, amount)
        $sql = "INSERT INTO payments (orderId, amount) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("id", $orderID, $totalPrice);
        $stmt->execute();
        $stmt->close();

        $conn->close();
        unset($_SESSION['cart']);
        echo "Your order has been placed.";
        echo "You can view your order history here:";
        echo "<a href='myaccount.php'>My Account</a>";
        

    }else {
        echo "Your cart is empty.";
        echo "<a href='products.php'>Products</a>";
    }
}

function addToCart() {
    //if user is not logged in, redirect to login page
    session_start();
    if (!isset($_SESSION['user_id'])) {
        echo "<script>alert('You must be logged in to add products to the cart.'); window.location.href = 'login.php';</script>";
        exit();
    }

    
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = array();
    }

    if (isset($_POST['productId'])) {
        $productId = filter_input(INPUT_POST, 'productId', FILTER_SANITIZE_NUMBER_INT);

        if (isset($_SESSION['cart'][$productId])) {
            $_SESSION['cart'][$productId]++;
        } else {
            $_SESSION['cart'][$productId] = 1;
        }
    }
    header("Location: products.php");
}
