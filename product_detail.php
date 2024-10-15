<?php

$connector = mysqli_connect('127.0.0.1', 'u489039624_G5' , 'webBIT21503', 'u489039624_G5');

if (!$connector){
die('Sambungan ke MYSQL gagal' . mysqli_connect_error());

}


$product_id = $_GET['product_id'] ?? null;
$product = null;

if ($product_id) {
    $sql = "SELECT product_id, prod_name, prod_description, prod_price, product_image, stock_quantity FROM product WHERE product_id = ?";
    $stmt = $connector->prepare($sql);
    $stmt->bind_param('i', $product_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $product = $result->fetch_assoc();
    }

    $stmt->close();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'add_to_cart') {
    session_start();
    $user_id = $_SESSION['user_id'] ?? null;
    $product_id = $_POST['product_id'];
    $quantity = $_POST['quantity'];

    if ($user_id && $product_id && $quantity) {
        // Check if the product already exists in the cart
        $sql_check = "SELECT cart_id, quantity FROM cart WHERE user_id = ? AND product_id = ?";
        $stmt_check = $connector->prepare($sql_check);
        $stmt_check->bind_param('ii', $user_id, $product_id);
        $stmt_check->execute();
        $result_check = $stmt_check->get_result();
        
        if ($result_check->num_rows > 0) {
            // Update the existing cart item quantity
            $cart_item = $result_check->fetch_assoc();
            $new_quantity = $cart_item['quantity'] + $quantity;
            $cart_id = $cart_item['cart_id'];
            
            $sql_update = "UPDATE cart SET quantity = ? WHERE cart_id = ?";
            $stmt_update = $connector->prepare($sql_update);
            $stmt_update->bind_param('ii', $new_quantity, $cart_id);
            
            if ($stmt_update->execute()) {
                echo json_encode(['status' => 'success']);
            } else {
                echo json_encode(['status' => 'error', 'message' => $stmt_update->error]);
            }

            $stmt_update->close();
        } else {
            // Insert new cart item
            $sql_insert = "INSERT INTO cart (user_id, product_id, quantity) VALUES (?, ?, ?)";
            $stmt_insert = $connector->prepare($sql_insert);
            $stmt_insert->bind_param('iii', $user_id, $product_id, $quantity);

            if ($stmt_insert->execute()) {
                echo json_encode(['status' => 'success']);
            } else {
                echo json_encode(['status' => 'error', 'message' => $stmt_insert->error]);
            }

            $stmt_insert->close();
        }

        $stmt_check->close();
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Product Details - Gear Up Sport</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lexend:wght@100..900&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/7171c8ef3e.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="productstyle.css">
    <style>
        .product-page {
            padding: 50px 50px;
            padding-top: 130px;
            background: #fff;
        }

        .product-detail {
            display: flex;
            gap: 50px;
            align-items: flex-start;
        }

        .product-image {
            flex: 1;
        }

        .product-image img {
            width: 100%;
            max-width: 500px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .details {
            flex: 2;
        }

        .details h2 {
            font-size: 2.5em;
            margin-bottom: 20px;
        }

        .details .product-price {
            font-size: 2em;
            color: #ff6600;
            font-weight: 700;
            margin: 20px 0;
        }

        .details .product-description {
            font-size: 1.2em;
            margin: 10px 0;
        }

        .details .product-description ul {
            list-style-type: disc;
            margin-left: 20px;
        }

        .details .product-description li {
            margin-bottom: 10px;
        }

        .details .stock {
            margin: 20px 0;
            font-size: 1.1em;
            color: #555;
        }

        .product-button {
            display: inline-block;
            padding: 15px 30px;
            background-color: #ff6600;
            color: #fff;
            border: none;
            border-radius: 5px;
            font-size: 1.2em;
            font-weight: 700;
            cursor: pointer;
            text-align: center;
            transition: background-color 0.3s ease;
        }

        .product-button:hover {
            background-color: #e55d00;
        }

        .reviews {
            margin-top: 50px;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .reviews h3 {
            font-size: 2em;
            margin-bottom: 20px;
        }

        .reviews .review {
            border-top: 1px solid #e0e0e0;
            padding: 10px 0;
        }

        .reviews .review:first-child {
            border-top: none;
        }

        .reviews .review p {
            font-size: 1.1em;
            margin: 5px 0;
        }

        .reviews .review .reviewer {
            font-weight: bold;
        }

        .stars {
            color: #ffd700;
            font-size: 1.5em;
        }

        footer {
            background: black;
            height: auto;
            width: 100vw;
            font-family: "Open Sans";
            padding-top: 40px;
            color: white;
        }

        .footer-content {
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            text-align: center;
        }

        .footer-content h3 {
            font-size: 24px; /* Increased font size for better visibility */
            font-weight: 400;
            text-transform: capitalize;
            line-height: 3rem;
        }

        .footer-content p {
            max-width: 500px;
            margin: 10px auto;
            line-height: 28px;
            font-size: 16px; /* Adjusted font size for better readability */
        }

        .socials {
            list-style: none;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 1rem 0 3rem 0;
        }

        .socials li {
            margin: 0 10px;
        }

        .socials a {
            text-decoration: none;
            color: white;
        }

        .socials a i {
            font-size: 1.1rem;
            transition: color .4s ease;
        }

        .socials a:hover i {
            color: orange;
        }

        .size-select {
            margin: 20px 0;
            font-size: 1.1em;
        }

        .size-select label {
            margin-right: 10px;
        }

        .size-select select {
            padding: 10px;
            font-size: 1em;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .quantity-select {
            margin: 20px 0;
            font-size: 1.1em;
        }

        .quantity-select label {
            margin-right: 10px;
        }

        .quantity-select input {
            padding: 10px;
            font-size: 1em;
            width: 60px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
    </style>
</head>
<body>
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

    <div class="product-page">
        <div class="product-detail">
            <div class="product-image">
                <img src="data:image/jpeg;base64,<?php echo base64_encode($product['product_image']); ?>" alt="<?php echo htmlspecialchars($product['prod_name'], ENT_QUOTES, 'UTF-8'); ?>">
            </div>
            <div class="details">
                <h2><?php echo htmlspecialchars($product['prod_name'], ENT_QUOTES, 'UTF-8'); ?></h2>
                <p class="product-price">RM <?php echo htmlspecialchars($product['prod_price'], ENT_QUOTES, 'UTF-8'); ?></p>
                <div class="product-description">
                    <h3>Description</h3>
                    <p><?php echo nl2br(htmlspecialchars($product['prod_description'], ENT_QUOTES, 'UTF-8')); ?></p>
                </div>
                <p class="stock">Stock Quantity: <?php echo htmlspecialchars($product['stock_quantity'], ENT_QUOTES, 'UTF-8'); ?></p>


                <div class="quantity-select">
                    <label for="quantity">Quantity:</label>
                    <input type="number" id="quantity" name="quantity" value="1" min="1" max="<?php echo htmlspecialchars($product['stock_quantity'], ENT_QUOTES, 'UTF-8'); ?>">
                </div>

                <button id="add-to-cart-button" class="product-button">Add to Cart</button>
            </div>
        </div>

        <div class="reviews">
            <h3>Reviews</h3>
            <div class="review">
                <div class="stars">
                 ★★★★☆
                </div>
                <p class="reviewer">John Doe</p>
                <p>Great product! Highly recommend.</p>
            </div>
            <div class="review">
                <div class="stars">
                    ★★★☆☆
                </div>
                <p class="reviewer">Jane Smith</p>
                <p>Good quality, but a bit expensive.</p>
            </div>
        </div>
        </div>
    </div>

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

    <script>
        document.getElementById('add-to-cart-button').addEventListener('click', function() {
            const quantity = document.getElementById('quantity').value;
            const productId = <?= json_encode($product['product_id']) ?>;  // Ensure product ID is passed correctly

            fetch('product_detail.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: `action=add_to_cart&product_id=${productId}&quantity=${quantity}`
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    alert('Product added to cart successfully.');
                } else {
                    alert('Error adding product to cart: ' + data.message);
                }
            })
            .catch(error => console.error('Error:', error));
        });
    </script>
</body>
</html>