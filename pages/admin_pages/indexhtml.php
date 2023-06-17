<?php
session_start();
require_once "../../scripts/check_login.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" type="text/css" href="../../styles/style.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400,700&display=swap" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.1.0/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css" />
    <title>FUTURISTIC - Shop furniture</title>
</head>

<body>
    <div class="container">

        <div class="cursor"></div>
        <header class="header nav-links">
            <div>
                <a href="../../scripts/logout.php"
                    class="header__sign-in animate__animated animate__fadeInLeft">Logout</a>
                <a href="../../scripts/admin_dashboard.php"
                    class="header__sign-in animate__animated animate__fadeInLeft">My account</a>
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

        <main>
            <section class="banner">
                <div class="banner__text animate__animated animate__fadeInLeft">
                    <h2 class="banner__title">FUTURISTIC IS COMING NOW...</h2>
                    <hr />
                    <p class="banner__description">
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                        Vestibulum et nisi vel urna ultricies pharetra. Donec sit amet dui
                        ut lectus placerat iaculis. Lorem ipsum dolor sit amet,
                        consectetur adipiscing elit.
                        <br /><br />
                        Vestibulum et nisi vel urna ultricies pharetra. Donec sit amet dui
                        ut lectus placerat iaculis. Lorem ipsum dolor sit amet,
                        consectetur adipiscing elit. Vestibulum et nisi vel urna ultricies
                        pharetra.
                    </p>
                    <a href="productshtml.php" class="banner__cta">Shop now <i class="fas fa-arrow-right"></i></a>
                </div>
                <div class="banner__image animate__animated animate__fadeInRight">
                </div>
            </section>

            <section class="content_info">
                <div class="content_info__image">
                </div>
                <div class="content_info__text">
                    <p>01</p>
                    <hr />
                    <p class="content_info__description">
                        Vestibulum et nisi vel urna ultricies pharetra. Donec sit amet dui
                        ut lectus placerat iaculis. Lorem ipsum dolor sit amet,
                        consectetur adipiscing elit.
                        <br /><br />
                        Vestibulum et nisi vel urna ultricies pharetra. Donec sit amet dui
                        ut lectus placerat iaculis. Lorem ipsum dolor sit amet,
                        consectetur adipiscing elit. Vestibulum et nisi vel urna ultricies
                        pharetra.
                    </p>
                    <p>02</p>
                    <hr />
                    <p class="content_info__description">
                        Vestibulum et nisi vel urna ultricies pharetra. Donec sit amet dui
                        ut lectus placerat iaculis. Lorem ipsum dolor sit amet,
                        consectetur adipiscing elit. Vestibulum et nisi vel urna ultricies
                        pharetra.
                        <br /><br />
                        Vestibulum et nisi vel urna ultricies pharetra. Donec sit amet dui
                        ut lectus placerat iaculis. Lorem ipsum dolor sit amet,
                        consectetur adipiscing elit. Vestibulum et nisi vel urna ultricies
                        pharetra.
                    </p>
                </div>
            </section>

            <section class="gallery">
                <h1>RECENT WORK</h1>
                <div class="slider">
                    <div class="slides">
                        <!-- Radio Button Start  -->
                        <input type="radio" name="radio-btn" id="radio1" />
                        <input type="radio" name="radio-btn" id="radio2" />
                        <input type="radio" name="radio-btn" id="radio3" />
                        <input type="radio" name="radio-btn" id="radio4" />
                        <!-- Radio Button Close  -->

                        <!-- Slide Image Start -->
                        <div class="slide first">
                            <img src="../../photos/product1.png" alt="" />
                        </div>
                        <div class="slide">
                            <img src="../../photos/product2.png" alt="" />
                        </div>
                        <div class="slide">
                            <img src="../../photos/product3.png" alt="" />
                        </div>
                        <div class="slide">
                            <img src="../../photos/product2.png" alt="" />
                        </div>
                        <!-- Slide Image Close -->

                        <!-- Automatic Navigation Start -->
                        <div class="navigation-auto">
                            <div class="auto-btn-1"></div>
                            <div class="auto-btn-2"></div>
                            <div class="auto-btn-3"></div>
                            <div class="auto-btn-4"></div>
                        </div>
                        <!-- Automatic Navigation Close -->
                    </div>

                    <!-- Mannual Navigation Start -->
                    <div class="navigation-mannual">
                        <label for="radio1" class="mannual-btn"></label>
                        <label for="radio2" class="mannual-btn"></label>
                        <label for="radio3" class="mannual-btn"></label>
                        <label for="radio4" class="mannual-btn"></label>
                    </div>
                    <!-- Mannual Navigation Close -->
                </div>
                <div class="text_slider">
                    <p>03</p>
                    <hr />
                    <p class="banner__description_vol2">
                        Vestibulum et nisi vel urna ultricies pharetra. Donec sit amet dui
                        ut lectus placerat iaculis. Lorem ipsum dolor sit amet,
                        consectetur adipiscing elit.
                        <br /><br />
                        Vestibulum et nisi vel urna ultricies pharetra. Donec sit amet dui
                        ut lectus placerat iaculis. Lorem ipsum dolor sit amet,
                        consectetur adipiscing elit. Vestibulum et nisi vel urna ultricies
                        pharetra.
                    </p>
                </div>
            </section>
        </main>

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
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.0/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.0/ScrollTrigger.min.js"></script>

    <script src="../../scripts/scroll.js"></script>
    <script src=" ../../scripts/slider.js"></script>
    <script src=" ../../scripts/cursor.js"></script>
</body>

</html>
