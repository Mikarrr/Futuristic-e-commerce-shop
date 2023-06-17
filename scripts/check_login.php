<?php

// Sprawdzenie, czy użytkownik jest zalogowany
if (!isset($_SESSION['user_id'])) {
    // Użytkownik nie jest zalogowany, przekieruj go na stronę logowania
    header("Location: http://localhost/futuristic_shop_ecommerce/pages/loginhtml.php");
    exit();
}

?>
