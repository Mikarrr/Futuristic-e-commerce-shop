<?php
session_start();

require_once "check_login.php";

// Sprawdzenie, czy przesłano nowy adres dostawy
if (isset($_POST["newDeliveryAddress"])) {
    $newDeliveryAddress = $_POST["newDeliveryAddress"];

    // Utworzenie połączenia z bazą danych
    require_once "connect.php";

    // Pobranie ID użytkownika
    $userId = $_SESSION["user_id"];

    // Aktualizacja lub dodanie adresu dostawy użytkownika
    $updateQuery = "UPDATE users SET deliveryAddress = '$newDeliveryAddress' WHERE id = $userId";
    if ($conn->query($updateQuery) === TRUE) {
        // Przekierowanie użytkownika na stronę konta
        header("Location: user_dashboard.php");
        exit();
    } else {
        // Obsługa błędu aktualizacji bazy danych
        echo "Error updating delivery address: " . $conn->error;
    }

    // Zamknięcie połączenia z bazą danych
    $conn->close();
} else {
    // Przekierowanie użytkownika na stronę konta
    header("Location: user_dashboard.php");
    exit();
}
?>
