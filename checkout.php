<?php
session_start();
include('connector.php');

$user = [];
$cart = [];
$totalItemsCount = 0;
$totalPriceValue = 0;

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];

    // Fetch user data
    $sql = "SELECT * FROM user WHERE user_id = '$user_id'";
    $result = mysqli_query($connector, $sql);

    if ($result) {
        if (mysqli_num_rows($result) > 0) {
            $user = mysqli_fetch_assoc($result);
        } else {
            echo "No data found for this user.";
        }
    } else {
        echo "Error querying user data: " . mysqli_error($connector);
    }

    // Fetch cart items for the user
    $sql = "SELECT c.cart_id, c.user_id, c.product_id, c.quantity, p.prod_name, p.prod_price, p.product_image 
            FROM cart c 
            JOIN product p ON c.product_id = p.product_id 
            WHERE c.user_id = '$user_id'";
    $result = mysqli_query($connector, $sql);

    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $cart[] = $row;
            $totalItemsCount += $row['quantity'];
            $totalPriceValue += $row['prod_price'] * $row['quantity'];
        }
    } else {
        echo "Error querying cart data: " . mysqli_error($connector);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout | Online Store</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Lexend:wght@100..900&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/7171c8ef3e.js" crossorigin="anonymous"></script>
    <style>
        /* CSS styles here */
        body {
            font-family: Helvetica Neue, Helvetica, Arial, sans-serif;
            font-size: 14px;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9; /* light gray background */
        }

        main {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 2em;
        }

        .checkout-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            width: 80%;
            margin: 0 auto;
            background-color: #fff; /* white background */
            margin-top: 6%;
            padding: 20px;
            border: 1px solid #ddd; /* light gray border */
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); /* subtle shadow */
        }

        .checkout-summary {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 1em;
            border-bottom: 1px solid #ddd; /* light gray border */
        }

        .checkout-summary h2 {
            font-size: 18px;
            margin-bottom: 10px;
            color: #333; /* dark gray text */
        }

        .checkout-summary p {
            font-size: 14px;
            color: #666; /* medium gray text */
        }

        .checkout-items {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 1em;
        }

        .checkout-item {
            display: flex;
            flex-direction: row;
            align-items: center;
            padding: 1em;
            border-bottom: 1px solid #ddd; /* light gray border */
            justify-content: spaceBetween;
            width: 100%;
        }

        .checkout-item:last-child {
            border-bottom: none;
        }

        .checkout-item img {
            width: 50px;
            height: 50px;
            margin-right: 10px;
        }

        .checkout-item .product-info {
            flex-grow: 1;
        }

        .checkout-item .product-info h2 {
            font-size: 16px;
            margin-bottom: 10px;
            color: #333; /* dark gray text */
        }

        .checkout-item .product-info p {
            font-size: 14px;
            color: #666; /* medium gray text */
        }

        .payment-methods {
            display: flex;
            flex-direction: column;
            align-items: start;
            padding: 1em;
        }

        .payment-methods h2 {
            font-size: 18px;
            margin-bottom: 10px;
            color: #333; /* dark gray text */
        }

        .payment-methods label {
            margin-right: 10px;
        }

        .payment-methods input[type="radio"] {
            margin-right: 10px;
        }

        .place-order-button {
            background-color: #FF6D00; /* rgb(255, 109, 0) */
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 10px;
            cursor: pointer;
        }

        .place-order-button:hover {
            background-color: #FFA07A; /* rgb(255, 170, 0) */
        }

        .success-message {
        background-image: url('images/checkoutbg.avif'); 
        background-size: 100vw 100vh; 
        background-position: center;
        background-repeat: no-repeat;
        height: 100vh; 
        width: 100vw; 
        display: flex;
        justify-content: center;
        align-items: center;
        text-align: center;
        }

        .success-message.show {
        opacity: 1;
        animation: fadeIn 0.5s ease-in-out; 
        }

        @keyframes fadeIn {
        0% {
            opacity: 0;
        }
        100% {
            opacity: 1;
        }
        }
        
        .success-message h2 {
            font-size: 4em;
            margin-bottom: 10px;
            color: #fff;
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

    <main>
        <div class="checkout-container">
            <h1>Checkout</h1>
            <div class="checkout-summary">
                <h2>Cart Summary</h2>
                <p style="font-weight: bold; font-size: 16px; color: #ff6600;" id="total-items"><?= $totalItemsCount ?> items</p>
                <p style="font-weight: bold; font-size: 24px; color: #ff6600;" id="total-price">RM<?= number_format($totalPriceValue, 2) ?></p>
            </div>
            <div class="checkout-items" id="checkout-items">
                <?php foreach ($cart as $cartItem): ?>
                    <div class="checkout-item" data-id="<?= $cartItem['cart_id'] ?>">
                        <?php
                            $imageData = base64_encode($cartItem['product_image']);
                            $src = 'data:image/jpeg;base64,' . $imageData;
                        ?>
                        <img src="<?= $src ?>" alt="<?= $cartItem['prod_name'] ?>">
                        <div class="product-info">
                            <h2><?= $cartItem['prod_name'] ?></h2>
                            <p>RM<?= number_format($cartItem['prod_price'], 2) ?></p>
                        </div>
                        <p>Quantity: <?= $cartItem['quantity'] ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
            <div class="payment-methods">
                <h2>Payment Methods</h2>
                <label><input type="radio" name="payment-method" value="credit-card"> Credit Card</label>
                <label><input type="radio" name="payment-method" value="paypal"> PayPal</label>
                <label><input type="radio" name="payment-method" value="bank-transfer"> Bank Transfer</label>
            </div>
            <button class="place-order-button">Place Order</button>
            </div>
    </main>
    <script>
        document.querySelector('.place-order-button').addEventListener('click', () => {
            // Handle payment logic (e.g. send request to payment gateway)
            // For demo purposes, we'll just simulate a successful payment
            setTimeout(() => {
                // Display success message
                const successMessage = document.createElement('div');
                successMessage.innerHTML = '<h2>Your Order has been placed! <br> Thank you for shopping with us!</h2>';
                successMessage.className = 'success-message';
                document.body.appendChild(successMessage);
                successMessage.classList.add('show');

                // Remove the checkout form
                document.querySelector('.checkout-container').style.display = 'none';
            }, 1000); // simulate a 1-second delay for demo purposes
        });
    </script>
    </script>
</body>
</html>
