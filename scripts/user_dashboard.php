<?php
session_start();

require_once "check_login.php";

// Dane użytkownika
$userId = $_SESSION["user_id"];
$deliveryAddress = $_SESSION["deliveryAddress"] ?? "";

$firstName = $_SESSION["firstName"];
$lastName = $_SESSION["lastName"];
$email = $_SESSION["email"];

// Utworzenie połączenia z bazą danych
require_once "connect.php";

// Pobranie zamówień klienta
$query = "SELECT * FROM orders WHERE user_id = $userId";
$result = $conn->query($query);

// Pobranie adresu dostawy użytkownika z bazy danych
$userQuery = "SELECT deliveryAddress FROM users WHERE id = $userId";
$userResult = $conn->query($userQuery);
if ($userResult && $userResult->num_rows > 0) {
    $userRow = $userResult->fetch_assoc();
    $deliveryAddress = $userRow["deliveryAddress"];
}

// Tablica przechowująca zamówione przedmioty
$orderedItems = [];

// Sprawdzenie, czy są jakieś zamówienia
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $productId = $row["product_id"];

        // Pobranie nazwy zamówionego przedmiotu z bazy danych
        $productQuery = "SELECT name FROM products WHERE id = $productId";
        $productResult = $conn->query($productQuery);
        if ($productResult && $productResult->num_rows > 0) {
            $productRow = $productResult->fetch_assoc();
            $orderedItems[] = $productRow["name"] . " quantity: " . $quantity = $row["quantity"];
        }
    }
}

// Zamknięcie połączenia z bazą danych
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" type="text/css" href="../styles/style.css" />
    <link rel="stylesheet" type="text/css" href="../styles/register_login_style.css" />
    <link rel="stylesheet" type="text/css" href="../styles/style_user_dashboard.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400,700&display=swap" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.1.0/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css" />
    <title>FUTURISTIC - My account</title>
</head>

<body>
    <div>
        <div class="cursor"></div>
        <header class="header">
            <ul class="nav-links">
                <li><a href="logout.php" class="header__sign-in animate__animated animate__fadeInLeft">Logout</a></li>
                <li><a href="user_dashboard.php" class="header__sign-in animate__animated animate__fadeInLeft">My
                        account</a></li>
            </ul>

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
                <ul class="nav-links justify">
                    <li><a href="../pages/user_pages/indexhtml.php">Home</a></li>
                    <li><a href="../pages/user_pages/productshtml.php">Products</a></li>
                    <li><a href="../pages/user_pages/abouthtml.php">About</a></li>
                    <li><a href="../pages/user_pages/contacthtml.php">Contact</a></li>
                    <li>
                        <a href="../pages/user_pages/shoppingCarthtml.php"><i
                                class="fas fa-shopping-cart cart-icon"></i></a>
                    </li>
                </ul>
            </nav>
        </header>

        <div class="my-account-panel animate__animated animate__fadeInUp">
            <h1>Hello, <?php echo $firstName . " " . $lastName; ?>!</h1>
            <div class="pannel-info">
                <h2>Login data:</h2>
                <p>Email: <?php echo $email; ?></p>
            </div>
            <div class="pannel-info">
                <h2>Delivery Address:</h2>
                <?php if (!empty($deliveryAddress)) { ?>
                <p><?php echo $deliveryAddress; ?></p>
                <form action="update_delivery_address.php" method="POST">
                    <input type="text" name="newDeliveryAddress" placeholder="New delivery address" />
                    <button type="submit">Update</button>
                </form>
                <?php } else { ?>
                <p>No delivery address provided</p>
                <form action="update_delivery_address.php" method="POST">
                    <input type="text" name="newDeliveryAddress" placeholder="Enter delivery address" />
                    <button type="submit">Add</button>
                </form>
                <?php } ?>
            </div>
            <div class="pannel-info">
                <h2>Items ordered:</h2>
                <ul>
                    <?php foreach ($orderedItems as $item) { ?>
                    <li><?php echo $item; ?></li>
                    <?php } ?>
                </ul>
            </div>
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
    <script src="./cursor.js"></script>
    < /body>

        < /html>
