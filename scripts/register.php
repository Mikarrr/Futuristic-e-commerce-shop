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
    header("Location: ../pages/registerhtml.php");
    exit();
  }

  // Haszowanie hasła
  $hashedPassword = password_hash($password, PASSWORD_ARGON2ID);

  // Wstawienie danych do bazy danych
  $sql = "INSERT INTO Users (email, firstName, lastName, password) VALUES ('$email', '$firstName', '$lastName', '$hashedPassword')";

  if($conn->query($sql) === TRUE){
    $_SESSION["success"] = "Registration completed successfully.";
    header("Location: ../pages/registerhtml.php");
    exit();
  } else {
    $errors[] = "Registration completed incorrectly: " . $conn->error;
    $_SESSION["errors"] = $errors;
    header("Location: ../pages/registerhtml.php");
    exit();
  }

  // Zamknięcie połączenia z bazą danych
  $conn->close();
}
?>
