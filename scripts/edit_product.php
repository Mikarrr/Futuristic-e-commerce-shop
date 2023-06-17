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
    <title>Panel CRUD - Edit product</title>
</head>


<body>
    <div class="cursor"></div>
    <header class="header nav-links">
        <div class="header__sign-in animate__animated animate__fadeInLeft">
            <a href="./logout.php" class="header__sign-in animate__animated animate__fadeInLeft">Logout</a>
            <a href="./admin_dashboard.php" class="header__sign-in animate__animated animate__fadeInLeft">My account</a>
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
                    <a href="./pages/admin_pages/shoppingCarthtml.php"><i
                            class="fas fa-shopping-cart cart-icon"></i></a>
                </li>
            </ul>
        </nav>
    </header>


    <div class="edit_panel animate__animated animate__fadeInUp">
        <?php

        //Utworzenie połączenia z bazą
        require_once "connect.php";

        // Pobranie ID produktu do edycji
        $productId = $_GET['id'];

        // Pobranie danych produktu
        $selectSql = "SELECT * FROM Products WHERE id = $productId";
        $result = $conn->query($selectSql);

        if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();

      // Aktualizacja danych produktu
      if ($_SERVER["REQUEST_METHOD"] == "POST") {

        $name = $_POST['name'];
        $price = $_POST['price'];
        $image = $_POST['image'];

        $updateSql = "UPDATE Products SET name = '$name', price = '$price', image = '$image' WHERE id = $productId";
        if ($conn->query($updateSql) === TRUE) {
          echo "Product data has been updated.";
        } else {
          echo "Error while updating product data: " . $conn->error;
        }
      }

      // Formularz edycji produktu
      echo "<h2>Edit product</h2>";
      echo "<form method='post' action=''>
              <div class=form-group>
              <label for='name'>Name:</label>
              <input type='text' id='text' name='name' value='".$row['name']."' required><br><br>
              </div>
              <div class=form-group>
              <label for='price'>Price:</label>
              <input type='text' id='firstName' name='price' value='".$row['price']."' required><br><br>
              </div>
              <div class=form-group>
              <label for='image'>Image:</label>
              <input type='file' id='iamge' name='image' value='".$row['image']."' required><br><br>
              </div>
              <div class=form-group>
              <br><br>
              </div>
              <button type='submit'>Update product details </button>

            </form>";
    } else {
      echo "The product with the specified ID could not be found.";
    }

    $conn->close();
    ?>

        <br>
        <a class="back_to_list" href="./admin_dashboard.php">Back to the list of Products</a>
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
