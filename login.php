<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Webshop Home</title>
    <link rel="stylesheet" href="login.css">
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
            </ul>
        </nav>
    </header>

    <main>
        <h2>Welcome to Our Webshop!</h2>
        <form id="loginForm" class="login-form" method="POST">
            <!-- <input type="text" id="loginUsername" name="username" placeholder="Username" required> change this with email-->
            <input type="email" id="loginEmail" name="email" placeholder="Email" required>
            <input type="password" id="loginPassword" name="password" placeholder="Password" required>
            <button type="submit">Login</button>
        </form>
        <!-- if not registered yet send to register.php -->
        <p>Not registered yet? <a href="register.php">Register here</a>.</p>


    </main>

    <footer>
        <p>Contact Us: contact@yourwebshop.com</p>
    </footer>
</body>
</html>

