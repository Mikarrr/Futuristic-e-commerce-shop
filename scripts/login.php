<?php
session_start();


// Sprawdzenie, czy formularz został przesłany
if ($_SERVER["REQUEST_METHOD"] === "POST") {
  // Sprawdzenie, czy przesłane dane są poprawne
  if (isset($_POST["email"]) && isset($_POST["password"])) {
    $email = $_POST["email"];
    $password = $_POST["password"];

    // Utworzenie połączenia z bazą danych
    require_once "connect.php";

    // Zabezpieczenie danych logowania przed atakami typu SQL Injection
    $email = mysqli_real_escape_string($conn, $email);
    $password = mysqli_real_escape_string($conn, $password);

    // Pobranie danych użytkownika z bazy
    $query = "SELECT * FROM Users WHERE email='$email' LIMIT 1";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
      $row = mysqli_fetch_assoc($result);

      // Sprawdzenie poprawności hasła
      if (password_verify($password, $row["password"])) {
        // Logowanie powiodło się
        $_SESSION["user_id"] = $row["id"];
        $_SESSION["role"] = $row["role"];
        $_SESSION["firstName"] = $row["firstName"];
        $_SESSION["lastName"] = $row["lastName"];
        $_SESSION["email"] = $row["email"];

        switch ($row["role"]) {
          case "user":
            header("Location: ./user_dashboard.php");
            break;
          case "moderator":
            header("Location: ./mod_dashboard.php");
            break;
          case "administrator":
            header("Location: ./admin_dashboard.php");
            break;
          default:
            break;
        }

        exit();
      } else {
        // Niepoprawne hasło
        $_SESSION["error"] = "Niepoprawny email lub hasło";
        header("Location: ../pages/loginhtml.php");
        exit();
      }
    } else {
      // Brak użytkownika o podanym emailu
      $_SESSION["error"] = "Niepoprawny email";
      header("Location: ../pages/loginhtml.php");
      exit();
    }
  } else {
    // Brak wprowadzonych danych
    $_SESSION["error"] = "Proszę uzupełnić wszystkie pola";
    header("Location: ../pages/loginhtml.php");
    exit();
  }
}
?>
