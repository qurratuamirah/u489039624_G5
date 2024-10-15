<?php
// Connect to the database
session_start();
include('connector.php');

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Assume username is passed as a parameter or stored in session
$user_id= $_SESSION['user_id']; // Replace this with dynamic value, e.g., from session or GET parameter

// Fetch user details
$query = "SELECT user_name, phone_num FROM user WHERE user_id = '$user_id'";
$result = mysqli_query($connector, $query);

if ($result && mysqli_num_rows($result) > 0) {
    $user = mysqli_fetch_assoc($result);
    $userName = htmlspecialchars($user['user_name']);
    $phoneNum = htmlspecialchars($user['phone_num']);
} else {
    $userName = 'Unknown';
    $phoneNum = 'N/A';
}

mysqli_close($connector);
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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <link rel="stylesheet" href="style.css">

    <style>
        html, body {
            position: relative;
            height: 100%;
        }
        body {
            background-image: url("images/bg.jpg");
            font-family: Helvetica Neue, Helvetica, Arial, sans-serif;
            font-size: 14px;
            color: #000;
            margin: 0;
            padding: 0;
        }
        .banner {
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
                <input type="text" placeholder="Seacrh product name" id="searchbar" name="query">
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

    <section class="profile">
        <div class="profile-container">
            <div class="profile-name">My Profile</div>
            <div class="profile-pic">
                <img src="https://cdn-icons-png.flaticon.com/512/3135/3135823.png" alt="">
            </div>

            <div class="profile-name" id="username"><?php echo $userName; ?></div>
            <div class="profile-detail">
                <div class="profile-number"><i class="fa-solid fa-phone"></i><?php echo $phoneNum; ?></div>
                <div class="profile-address"><i class="fa-solid fa-house-chimney"></i>34, Jalan PCH1, Perdana College Heights, 81200 Johor Bahru, Johor</div>
            </div>

            <a href="cart.php" id="myOrderBtn">My Order</a>
        </div>
    </section>

    <footer>
        <div class="footer-content">
            <h3>About Us</h3>
            <p>The main goal of Gear Up Sport is to create a comprehensive e-commerce platform that caters to sports enthusiasts and outdoor adventurers by providing an intuitive and engaging shopping experience. The website focuses on offering high-quality sports gear across four primary categories: Running, Outdoor, Football, and Fitness & Training, ensuring that each category addresses the specific needs of athletes and fitness enthusiasts.</p>
            <ul class="socials">
                <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                <li><a href="#"><i class="fa fa-youtube"></i></a></li>
                <li><a href="#"><i class="fa fa-google-plus"></i></a></li>
            </ul>
        </div>
    </footer>
</body>

</html>