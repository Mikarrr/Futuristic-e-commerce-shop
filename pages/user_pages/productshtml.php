<?php
session_start();
require_once "../../scripts/check_login.php";

function getConnection()
{
    // Utworzenie połączenia z bazą danych
    $conn = new mysqli("localhost", "root", "", "futuristic_database");

    // Sprawdzenie połączenia
    if ($conn->connect_error) {
        die("Nie udało się połączyć z bazą danych: " . $conn->connect_error);
    }

    return $conn;
}

function getProductById($productId)
{
    $conn = getConnection();

    $sql = "SELECT * FROM products WHERE id = $productId";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row;
    } else {
        return null;
    }

    $conn->close();
}

function getAllProducts()
{
    $conn = getConnection();

    $sql = "SELECT * FROM products";
    $result = $conn->query($sql);

    $products = array();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $products[] = $row;
        }
    }

    $conn->close();

    return $products;
}

function addToCart($productId, $quantity)
{
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = array();
    }

    $product = getProductById($productId);

    if ($product != null) {
        $product['quantity'] = $quantity;
        $_SESSION['cart'][] = $product;
        $_SESSION['added_to_cart'] = true;
    }
}

function removeFromCart($index)
{
    if (isset($_SESSION['cart'])) {
        if (isset($_SESSION['cart'][$index])) {
            unset($_SESSION['cart'][$index]);
            $_SESSION['cart'] = array_values($_SESSION['cart']);
        }
    }
}

function getCartItems()
{
    if (isset($_SESSION['cart'])) {
        return $_SESSION['cart'];
    } else {
        return array();
    }
}

function calculateTotal()
{
    $total = 0;

    foreach ($_SESSION['cart'] as $product) {
        $total += $product['quantity'] * $product['price'];
    }

    return $total;
}

if (isset($_POST['add_to_cart'])) {
    $productId = $_POST['product_id'];
    $quantity = $_POST['quantity'];
    addToCart($productId, $quantity);
    header('Location: productshtml.php');
    exit();
}

if (isset($_GET['remove_from_cart']) && isset($_GET['product_id'])) {
    $productId = $_GET['product_id'];
    removeFromCart($productId);
    header('Location: shoppingCarthtml.php');
    exit();
}

if (isset($_GET['clear_cart'])) {
    unset($_SESSION['cart']);
    header('Location: shoppingCarthtml.php');
    exit();
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" type="text/css" href="../../styles/products.css" />
    <link rel="stylesheet" type="text/css" href="../../styles/style.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400,700&display=swap" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.1.0/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css" />

    <title>FUTURISTIC - Shop furniture</title>
</head>

<body>
    <div class="container">
        <div class="cursor"></div>
        <header class="header nav-links">
            <div class="animate__animated animate__fadeInLeft">
                <a href="../../scripts/logout.php"
                    class="header__sign-in animate__animated animate__fadeInLeft">Logout</a>
                <a href="../../scripts/user_dashboard.php"
                    class="header__sign-in animate__animated animate__fadeInLeft">My account</a>
            </div>
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

        <div class="product_section animate__animated animate__fadeInUp">
            <?php $products = getAllProducts(); ?>
            <?php if (!empty($products)) : ?>
            <div class="massage">
                <?php if (isset($_SESSION['added_to_cart']) && $_SESSION['added_to_cart'] === true) : ?>
                <p class="added-to-cart-message">The product has been added to the shopping cart.</p>
                <?php unset($_SESSION['added_to_cart']); ?>
                <?php endif; ?>
            </div>
            <?php foreach ($products as $product) : ?>

            <div class="product">
                <form method="post" action="">
                    <img src="../../photos/<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>">
                    <p><?php echo $product['name']; ?> - <?php echo $product['price']; ?>$</p>
                    <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                    <label for="quantity_<?php echo $product['id']; ?>"></label>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Explicabo, amet ipsa ab assumenda magni
                        mollitia alias non sapiente nihil, earum quos et necessitatibus tempore optio, vitae expedita
                        odio
                        sequi quo!</p>

                    <input class="add_button" type="submit" name="add_to_cart" value="Add to Cart">
                    <input class="quantity_input" type="number" id="quantity_<?php echo $product['id']; ?>"
                        name="quantity" value="1" min="1">
                </form>
            </div>

            <?php endforeach; ?>

            <?php else : ?>
            <p>Brak dostępnych produktów.</p>
            <?php endif; ?>
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
    </div>

    <script src=" ../../scripts/cursor.js"></script>
</body>

</html>
