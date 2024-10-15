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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <link rel="stylesheet" href="productstyle.css">
</head>

<body>

    <!-- NavBar -->
    <nav>
        <div class="nav-container">
            <div class="navlogo">
                <a href="index.php">
                    <img src="images/GearUp_icon.png" alt="">
                    GearUp
                </a>
            </div>

            <form class="search" action="product.php" method="get">
                <!--SEARCHBAR-->
                <i class="fa-solid fa-magnifying-glass"></i>
                <input type="text" placeholder="Search product name" id="searchbar" name="query">
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

    <!-- Running Products -->
    <div class="product-page">
        <h2>Running Products</h2>
        <div class="product-grid">
            <?php
            $sql = "SELECT product_id, prod_name, prod_description, prod_price, product_image FROM product WHERE category_id = '111'";
            $result = $connector->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<div class='product-card'>";
                    echo "<a href='product_detail.php?product_id=" . htmlspecialchars($row["product_id"], ENT_QUOTES, 'UTF-8') . "'>";
                    echo "<img src='data:image/jpeg;base64," . base64_encode($row["product_image"]) . "' alt='" . htmlspecialchars($row["prod_name"], ENT_QUOTES, 'UTF-8') . "'>";
                    echo "</a>";
                    echo "<div class='product-card-content'>";
                    echo "<h3>" . htmlspecialchars($row["prod_name"], ENT_QUOTES, 'UTF-8') . "</h3>";
                    echo "</div>";
                    echo "<div class='product-card-footer'>";
                    echo "<p class='product-price' style='font-weight: bold; color: #ff6600;'>RM " . htmlspecialchars($row["prod_price"], ENT_QUOTES, 'UTF-8') . "</p>";
                    echo "</div>";
                    echo "</div>";
                }
            } else {
                echo "<p>No products found.</p>";
            }
            
            
            ?>
        </div>
    </div>

    <!-- Footer -->
    <footer>
        <div class="footer-content">
            <h3>About Us</h3>
            <p>The main goal of Gear Up Sport is to create a comprehensive e-commerce platform that caters to sports enthusiasts and outdoor adventurers by providing an intuitive and engaging shopping experience. The website focuses on offering high-quality sports gear across four primary categories: Running, Outdoor, Football, and Fitness & Training, ensuring that each category addresses the specific needs of athletes and fitness enthusiasts.
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
<?php
// Close database connection
$connector->close();
?>
