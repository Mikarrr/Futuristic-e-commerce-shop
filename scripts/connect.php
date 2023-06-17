<?php
// Utworzenie połączenia z bazą danych
$conn = new mysqli("localhost", "root", "", "futuristic_database");

// Sprawdzenie połączenia
if($conn -> connect_error){
   die("Nie udało się połączyć z bazą danych: " . $conn ->connect_error);
}
?>