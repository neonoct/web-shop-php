<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Webshop Home</title>
    <link rel="stylesheet" href="register.css">
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
        <form id="registrationForm" class="register-form">
            <input type="text" id="firstname" name="firstname" placeholder="firstname" required>
            <input type="text" id="lastname" name="lastname" placeholder="lastname" required>
            <input type="email" id="email" name="email" placeholder="Email" required>
            <!-- address -->
            <input type="text" id="address" name="address" placeholder="Address" required>
            <input type="password" id="password" name="password" placeholder="Password" required>
            <input type="password" id="confirmPassword" name="confirmPassword" placeholder="Confirm Password" required>
            <button type="submit">Register</button>
        </form>
        

    </main>

    <footer>
        <p>Contact Us: contact@yourwebshop.com</p>
    </footer>
</body>
</html>

