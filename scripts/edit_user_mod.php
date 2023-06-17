<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" type="text/css" href="../styles/edit_user.css" />
    <link rel="stylesheet" type="text/css" href="../styles/style.css" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400,700&display=swap" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.1.0/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css" />
    <title>Panel CRUD - Edit User</title>
</head>


<body>
    <div class="cursor"></div>
    <header class="header nav-links">
        <div class="header__sign-in animate__animated animate__fadeInLeft">
            <a href="./logout.php" class="header__sign-in animate__animated animate__fadeInLeft">Logout</a>
            <a href="./mod_dashboard.php" class="header__sign-in animate__animated animate__fadeInLeft">My account</a>
        </div>
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
                <li><a href="../pages/admin_pages/indexhtml.php">Home</a></li>
                <li><a href="../pages/admin_pages/productshtml.php">Products</a></li>
                <li><a href="../pages/admin_pages/abouthtml.php">About</a></li>
                <li><a href="../pages/admin_pages/contacthtml.php">Contact</a></li>
                <li>
                    <a href="./shoppingCarthtml.php"><i class="fas fa-shopping-cart cart-icon"></i></a>
                </li>
            </ul>
        </nav>
    </header>


    <div class="edit_panel animate__animated animate__fadeInUp">
        <?php
        // Utworzenie połączenia z bazą
        require_once "connect.php";

        // Pobranie ID użytkownika do edycji
        $userId = $_GET['id'];

        // Pobranie danych użytkownika
        $selectSql = "SELECT * FROM Users WHERE id = $userId";
        $result = $conn->query($selectSql);

        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();

            // Aktualizacja danych użytkownika
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $email = $_POST['email'];
                $firstName = $_POST['firstName'];
                $lastName = $_POST['lastName'];
                $role = $_POST['role'];

                // Tablica błędów
                $errors = [];

                // Sprawdzenie, czy podany adres email istnieje już w bazie danych
                $emailExistsQuery = "SELECT * FROM Users WHERE email='$email' AND id != $userId";
                $emailExistsResult = $conn->query($emailExistsQuery);

                if ($emailExistsResult && $emailExistsResult->num_rows > 0) {
                    $errors[] = "The given email address already exists. Please use a different email address.";
                }

                if (empty($errors)) {
                    $updateSql = "UPDATE Users SET email = '$email', firstName = '$firstName', lastName = '$lastName', role = '$role' WHERE id = $userId";
                    if ($conn->query($updateSql) === TRUE) {
                        echo "User data has been updated.";
                    } else {
                        echo "Error while updating user data: " . $conn->error;
                    }
                } else {
                    // Przekazanie błędów do sesji
                    session_start();
                    $_SESSION["errors"] = $errors;
                    header("Location: ./edit_user.php?id=$userId"); // Przekierowanie z powrotem do formularza edycji
                    exit();
                }
            }

            session_start();

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

      // Formularz edycji użytkownika
      echo "<h2>Edit user</h2>";
      echo "<form method='post' action=''>
              <div class=form-group>
              <label for='email'>Email:</label>
              <input type='email' id='email' name='email' value='".$row['email']."' required><br><br>
              </div>
              <div class=form-group>
              <label for='firstName'>FirstName:</label>
              <input type='text' id='firstName' name='firstName' value='".$row['firstName']."' required><br><br>
              </div>
              <div class=form-group>
              <label for='lastName'>LastName:</label>
              <input type='text' id='lastName' name='lastName' value='".$row['lastName']."' required><br><br>
              </div>
              <div class=form-group>
              <label for='lastName'>Type:</label>
              <select class='rola' id='role' name='role' required>
                <option value='administrator' ".($row['role'] == 'administrator' ? 'selected' : '').">administrator</option>
                <option value='user' ".($row['role'] == 'user' ? 'selected' : '').">user</option>
                <option value='moderator' ".($row['role'] == 'moderator' ? 'selected' : '').">moderator</option>
              </select><br><br>
              </div>
              <button type='submit'>Update user details </button>

            </form>";
    } else {
      echo "The user with the specified ID could not be found.";
    }

    $conn->close();
    ?>

        <br>
        <a class="back_to_list" href="./mod_dashboard.php">Back to the list of users</a>
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
