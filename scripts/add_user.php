<?php
session_start();

$required_fields = ["firstName", "lastName", "email", "acceptTerms", "password"];

// Funkcja sprawdzająca złożoność hasła
function validatePassword($password){
  if (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[^\w\d\s])\S{8,}$/', $password)) {
    return false;
  }
  return true;
}

// Sanityzacja danych wejściowych
function sanitizeInput($input){
  $input = htmlentities(stripslashes(trim($input)));
  return $input;
}

if ($_SERVER["REQUEST_METHOD"] == "POST"){

  // Utworzenie połączenia z bazą danych
  require_once "connect.php";

  // Przechwycenie zmiennych z formularza
  $firstName = $_POST["firstName"];
  $lastName = $_POST["lastName"];
  $email = $_POST["email"];
  $confirmEmail = $_POST["confirmEmail"];
  $password = $_POST["password"];
  $confirmPassword = $_POST["confirmPassword"];
  $acceptTerms = isset($_POST["acceptTerms"]) ? $_POST["acceptTerms"] : false;

  //Tablica błędów
  $errors = [];

  // Sprawdzenie, czy użytkownik zaakceptował regulamin
  if(!$acceptTerms){
    $errors[] = "Please accept the terms and conditions";
  }

  // Sprawdzenie, czy adresy email są takie same
  if ($email != $confirmEmail){
    $errors[] = "Email addresses are different!";
  }

  // Sprawdzenie, czy hasła są takie same
  if ($password != $confirmPassword){
    $errors[] = "The passwords are different!";
  }

  // Sprawdzenie, czy hasło jest poprawne
  if(!validatePassword($password)){
    $errors[] = "The password must contain at least 8 characters, at least one capital letter, one number and one special character.";
  }

  // Sprawdzenie, czy podany adres email istnieje już w bazie danych
  $emailExistsQuery = "SELECT * FROM Users WHERE email='$email'";
  $emailExistsResult = $conn->query($emailExistsQuery);

  if ($emailExistsResult->num_rows > 0){
    $errors[] = "The given email address already exists. Please use a different email address.";
  }

  // Sanityzacja danych wejściowych
  foreach ($_POST as $key => $value){
    if ($key != "password" && $key != "confirmPassword"){
      $$key = sanitizeInput($_POST["$key"]);
    }
  }

  // Sprawdzenie, czy wszystkie wymagane pola zostały wypełnione
  foreach ($required_fields as $field) {
    if (empty($_POST[$field])) {
      $errors[] = "The <b>$field</b> field is required.";
    }
  }

  if (!empty($errors)){
    $_SESSION["errors"] = $errors;
    header("Location: add_user.php");
    exit();
  }

  // Haszowanie hasła
  $hashedPassword = password_hash($password, PASSWORD_ARGON2ID);

  // Wstawienie danych do bazy danych
  $sql = "INSERT INTO Users (email, firstName, lastName, password) VALUES ('$email', '$firstName', '$lastName', '$hashedPassword')";

  if($conn->query($sql) === TRUE){
    $_SESSION["success"] = "Adding user completed successfully.";
    header("Location: add_user.php");
    exit();
  } else {
    $errors[] = "Adding user completed incorrectly: " . $conn->error;
    $_SESSION["errors"] = $errors;
    header("Location: add_user.php");
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

    <title>FUTURISTIC - Add user</title>
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

        <form method="POST" action="../scripts/add_user.php">
            <h2>Add new user</h2>
            <div class="form-group">
                <label for="firstName">FirstName:</label>
                <input type="text" id="firstName" name="firstName" required />
            </div>

            <div class="form-group">
                <label for="lastName">LastName:</label>
                <input type="text" id="lastName" name="lastName" required />
            </div>

            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required />
            </div>

            <div class="form-group">
                <label for="confirmEmail">Repeat email:</label>
                <input type="email" id="confirmEmail" name="confirmEmail" required />
            </div>

            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required />
            </div>

            <div class="form-group">
                <label for="confirmPassword">Repeat password:</label>
                <input type="password" id="confirmPassword" name="confirmPassword" required />
            </div>

            <div class="form-group-checkForm">
                <label for="checkForm">Accept terms and conditions:</label>
                <label for="switchA1" class="switch-item">
                    <input type="checkbox" name="acceptTerms" id="acceptTerms" class="control" required />
                    <span class="label"></span>
                </label>
            </div>

            <button type="submit">Sign up</button>
            <br><br>
            <a class="back_to_list" href="./admin_dashboard.php">Back to the list of users</a>
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
