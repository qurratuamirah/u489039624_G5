<?php

$connector = mysqli_connect('127.0.0.1', 'u489039624_G5' , 'webBIT21503', 'u489039624_G5');

if (!$connector){
die('Sambungan ke MYSQL gagal' . mysqli_connect_error());

}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Gear Up Sport</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lexend:wght@100..900&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/7171c8ef3e.js" crossorigin="anonymous"></script>

    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1" />
    <!-- Link Swiper's CSS for ADS-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

    <link rel="stylesheet" href="style.css">


    <!-- ADS styles -->
    <style>
        html,
        body {
            position: relative;
            height: 100%;
        }

        body {
            background: #eee;
            font-family: Helvetica Neue, Helvetica, Arial, sans-serif;
            font-size: 14px;
            color: #000;
            margin: 0;
            padding: 0;
        }

        .banner{
            height: 80vh;
        }

        .swiper {
            width: 100%;
            height: 100%;
        }

        .swiper-slide {
            text-align: center;
            font-size: 18px;
            background: #fff;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .swiper-slide img {
            display: block;
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
    </style>

    <title>Gear Up Sport</title>

</head>

<body>

    <!-- NavBar -->
    <nav>
        <div class="nav-container">
            <div class="navlogo">
                <a href="index.php">
                    <img src="GearUp_icon.png" alt="">
                    GearUp
                </a>
            </div>

            <form class="search" action="product.php" method="get"> <!--SEARCHBAR-->
                <i class="fa-solid fa-magnifying-glass"></i>
                <input type="text" placeholder="search product name" id="searchbar" name="query">
                <input type="submit" value="search" style="display: none;">
            </form>

            <!-- NavBar link -->
            <div class="navMenu">
                <a href="index.php" class="navLink">Home</a>
                <div class="dropdown">
                    <a href="product.php" class="navLink dropdownBtn">Shop</a>
                    <div class="dropdown-content">
                        <a href="trainingfitness.php" class="navLink">Training and Fitness</a>
                        <a href="running.php" class="navLink">Running</a>
                        <a href="football.php" class="navLink">Football</a>
                        <a href="outdoor.php" class="navLink">Outdoor</a>
                    </div>
                </div>
                <a href="account.php" class="navLink">Profile</a>
                <a href="cart.php"><i class="fa solid fa-cart-shopping"></i></a>
                <a href="login.php"><i class="fa solid fa-right-from-bracket"></i></a>
            </div>
        </div>
    </nav>
    </header>

    <!-- Swiper for ads -->
    <div class="banner">
        <div class="swiper mySwiper">
            <div class="swiper-wrapper">
                <div class="swiper-slide"><img src="https://mir-s3-cdn-cf.behance.net/project_modules/1400/15b90491922327.5e3f4f8bec325.png" alt="Slide 1"></div>
                <div class="swiper-slide"><img src="https://i.pinimg.com/originals/5e/3f/20/5e3f20bd72be7908fa865538bfd6b0e6.jpg" alt="Slide 2"></div>
                <div class="swiper-slide"><img src="https://www.sneakerbaas.nl/cdn/shop/collections/newbalancebanner.jpg?v=1712409908" alt="Slide 3"></div>
                <div class="swiper-slide"><img src="https://i.pinimg.com/originals/46/7d/89/467d89080009380ee74eedaf7daee8c5.jpg" alt="Slide 4"></div>
                <div class="swiper-slide"><img src="https://scontent.fkul3-2.fna.fbcdn.net/v/t39.30808-6/437891882_776693191224215_994516632056177713_n.png?stp=dst-png_s960x960&_nc_cat=100&ccb=1-7&_nc_sid=5f2048&_nc_ohc=pekVXYthqucQ7kNvgEtFWhK&_nc_ht=scontent.fkul3-2.fna&oh=00_AYDKztdY5zh0klu_vh6mSJED9IHQILaqbG1VVgVUQfv2Qw&oe=6679E51F" alt="Slide 5"></div>
            </div>
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
            <div class="swiper-pagination"></div>
        </div>
    </div>

    <!-- Features area -->
     <section class="features">
        <div class="container">
            <div class="features-item">
                <span class="icon"><i class="fa-solid fa-truck"></i></span>
                <p>Free Delivery</p>
            </div>
            <div class="features-item">
                <span class="icon"><i class="fa-solid fa-arrows-rotate"></i></span>
                <p>Return Policy</p>
            </div>
            <div class="features-item">
                <span class="icon"><i class="fa-solid fa-headset"></i></span>
                <p>24/7 Support</p>
            </div>
            <div class="features-item">
                <span class="icon"><i class="fa-solid fa-database"></i></span>
                <p>Secure Payment</p>
            </div>
        </div>
     </section>

    <!-- Category of shop -->
    <section class="category">
        <div class="container">
        
            <a href="outdoor.php">
                <div class="category-item">
                    <img src="images/camping1.jpg" alt="">
                    <p>Outdoor</p>
                </div>
            </a>

            <a href="trainingfitness.php">
                <div class="category-item">
                    <img src="https://img.huffingtonpost.es/files/image_720_480/uploads/2023/08/18/imagen-de-archivo-de-pesas-en-un-gimnasio.jpeg" alt="" style="object-position: 0 50% ;">
                    <p>Training and Fitness</p>
                </div>
            </a>

            <a href="running.php">
                <div class="category-item">
                    <img src="https://images.vs-static.com/zg60VVpnQi_qsOcprUUkMZqDapI=/1900x0/2_2_36651696b5/2_2_36651696b5.jpeg" alt="" style="object-position: 0 70%;">
                    <p>Running</p>
                </div>
            </a>

            <a href="football.php">
                <div class="category-item">
                    <img src="https://as1.ftcdn.net/v2/jpg/04/02/95/14/1000_F_402951428_I3JGp2lJXAirFwcT8o6k1D0AFjxU5X3E.jpg" alt="" style="object-position: 0 55%;">
                    <p>Football</p>
                </div>
            </a>
        </div>
    </section>

    <footer>
        <div class="footer-content">
            <h3>About Us</h3>
            <p>The main goal of Gear Up Sport is to create a comprehensive e-commerce platform that caters to sports enthusiasts and outdoor adventurers by providing an intuitive and engaging shopping experience. The website focuses on offering high-quality sports gear across four primary categories: Running, Outdoor, Football, and Fitness & Training, ensuring that each category addresses the specific needs of athletes and fitness enthusiasts.
            </p>
            <ul class="socials">
                <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                <li><a href="#"><i class="fa fa-youtube"></i></a></li>
                <li><a href="#"><i class="fa fa-google-plus"></i></a></li>
            </ul>
        </div>
    </footer>


    <!-- Swiper JS -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

    <!-- Initialize Swiper -->
    <script>
        var swiper = new Swiper(".mySwiper", {
            spaceBetween: 30,
            centeredSlides: true,
            autoplay: {
                delay: 2500,
                disableOnInteraction: false,
            },
            pagination: {
                el: ".swiper-pagination",
                clickable: true,
            },
            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev",
            },
        });
    </script>

    <script src="script.js"></script>
</body>

</html>