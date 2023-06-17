<?php
session_start();

// Zakończenie sesji
session_unset();
session_destroy();

// Przekierowanie do strony logowania
header("Location: ../pages/loginhtml.php");
exit();
?>
