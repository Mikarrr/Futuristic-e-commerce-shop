<?php
session_start();

$required_fields = ["name", "price", "image"];


// Sanityzacja danych wejściowych
function sanitizeInput($input){
  $input = htmlentities(stripslashes(trim($input)));
  return $input;
}

if ($_SERVER["REQUEST_METHOD"] == "POST"){

  // Utworzenie połączenia z bazą danych
  require_once "connect.php";

  // Przechwycenie zmiennych z formularza
  $name = $_POST["name"];
  $price = $_POST["price"];
  $image =$_POST["image"];

  //Tablica błędów
  $errors = [];

  // Sprawdzenie, czy wszystkie wymagane pola zostały wypełnione
  foreach ($required_fields as $field) {
    if (empty($_POST[$field])) {
      $errors[] = "The <b>$field</b> field is required.";
    }
  }

  if (!empty($errors)){
    $_SESSION["errors"] = $errors;
    header("Location: add_product.php");
    exit();
  }

  // Wstawienie danych do bazy danych
  $sql = "INSERT INTO Products (name, price, image) VALUES ('$name', '$price', '$image')";

  if($conn->query($sql) === TRUE){
    $_SESSION["success"] = "Adding product completed successfully.";
    header("Location: add_product.php");
    exit();
  } else {
    $errors[] = "Adding product completed incorrectly: " . $conn->error;
    $_SESSION["errors"] = $errors;
    header("Location: add_product.php");
    exit();
  }

  // Zamknięcie połączenia z bazą danych
  $conn->close();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400,700&display=swap" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.1.0/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css" />
    <link rel="stylesheet" type="text/css" href="../styles/style.css" />
    <link rel="stylesheet" type="text/css" href="../styles/register_login_style.css" />

    <title>FUTURISTIC - Add product</title>
</head>


<body>
    <div class="cursor"></div>
    <header class="header nav-links">
        <a href="./admin_dashboard.php" class="header__sign-in animate__animated animate__fadeInLeft">Back</a>
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

    <div class="container animate__animated animate__fadeInUp">

        <?php


            if (isset($_SESSION["errors"]) && !empty($_SESSION["errors"])) {
              echo '<div class="errors">';
              foreach ($_SESSION["errors"] as $error) {
                echo '<p>' . $error . '</p>';
              }
              echo '</div>';

              // Usunięcie błędów po wyświetleniu
              unset($_SESSION["errors"]);
            } else if (isset($_SESSION["success"])) {
              echo '<div class="success">' . $_SESSION["success"] . '</div>';

              // Usunięcie komunikatu o sukcesie po wyświetleniu
              unset($_SESSION["success"]);
            }
          ?>

        <form method="POST" action="../scripts/add_product.php">
            <h2>Add new product</h2>
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" required />
            </div>

            <div class="form-group">
                <label for="price">Price:</label>
                <input type="text" id="price" name="price" required />
            </div>

            <div class="form-group">
                <label for="image">Image:</label>
                <input type="text" id="image" name="image" required />
            </div>
            <button type="submit">Add product</button>
            <br><br>
            <a class="back_to_list" href="./admin_dashboard.php">Back to the list of product</a>
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
    <script src=" ./cursor.js"></script>

</body>

</html>
</body>

</html>
