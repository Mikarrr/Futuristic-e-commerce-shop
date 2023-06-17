<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" type="text/css" href="../styles/register_login_style.css" />
    <link rel="stylesheet" type="text/css" href="../styles/style.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400,700&display=swap" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.1.0/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css" />
    <title>FUTURISTIC - login</title>
</head>

<body>
    <div class="cursor"></div>
    <header class="header nav-links">
        <a href="../pages/indexhtml.php" class="header__sign-in animate__animated animate__fadeInLeft">Back</a>
        <h1 class="header__logo animate__animated animate__fadeInUp">
            FUTURISTIC
        </h1>
        <input type="checkbox" id="menu-toggle" class="menu-toggle" />
        <nav class="header__navigation animate__animated animate__fadeInRight">
            <label for="menu-toggle" class="menu-icon">
                <span></span>
                <span></span>
                <span></span>
            </label>
            <ul class="nav-links">
                <li><a href="./indexhtml.php">Home</a></li>
                <li><a href="./productshtml.php">Products</a></li>
                <li><a href="./abouthtml.php">About</a></li>
                <li><a href="./contacthtml.php">Contact</a></li>
                <li>
                    <a href="./shoppingCarthtml.php"><i class="fas fa-shopping-cart cart-icon"></i></a>
                </li>
            </ul>
        </nav>
    </header>

    <div class="containerLogin animate__animated animate__fadeInUp">

        <?php
            session_start();
            if (isset($_SESSION["error"])) {
              echo '<div class="error">' . $_SESSION["error"] . '</div>';
              unset($_SESSION["error"]);
            }
            if (isset($_SESSION["success"])) {
              echo '<div class="success">' . $_SESSION["success"] . '</div>';
              unset($_SESSION["success"]);
            }
          ?>
        <form method="POST" action="../scripts/login.php">
            <h2>Login</h2>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required />
            </div>

            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required />
            </div>
            <br>
            <button type="submit">Sign in</button>
            <div class="login">
                <a href="./registerhtml.php">Don't have an account? Sign up.</a>
            </div>
        </form>
    </div>

    <footer class="animate__animated animate__fadeInUp">
        <div class="footer-container">
            <div class="privacy-policy">
                <a href="#">Privacy policy</a>
            </div>
            <div class="social-media">
                <a href="#"><i class="fab fa-facebook"></i></a>
                <a href="#"><i class="fab fa-twitter"></i></a>
                <a href="#"><i class="fab fa-instagram"></i></a>
            </div>
            <div class="returns-delivery">
                <a href="#">Deliveries & Returns</a>
            </div>
            <p>Created by FUTURISTIC &copy; 2023</p>
        </div>
    </footer>

    <script src=" ../scripts/cursor.js"></script>
</body>

</html>
</body>

</html>
