<?php
session_start();
include('connector.php');

$user_id = $_SESSION['user_id'] ?? null;
$cart = [];

if ($user_id) {
    // Fetch cart items for the user
    $sql = "SELECT c.cart_id, c.user_id, c.product_id, c.quantity, p.prod_name, p.prod_price, p.product_image 
            FROM cart c 
            JOIN product p ON c.product_id = p.product_id 
            WHERE c.user_id = ?";
    $stmt = $connector->prepare($sql);
    $stmt->bind_param('i', $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result) {
        $cart = $result->fetch_all(MYSQLI_ASSOC);
    }

    $stmt->close();
}

// Handle AJAX requests
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    $action = $_POST['action'];

    if ($action === 'delete' && isset($_POST['cart_id'])) {
        $cart_id = $_POST['cart_id'];
        $sql = "DELETE FROM cart WHERE cart_id = ? AND user_id = ?";
        $stmt = $connector->prepare($sql);
        $stmt->bind_param('ii', $cart_id, $user_id);

        if ($stmt->execute()) {
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'error', 'message' => $stmt->error]);
        }

        $stmt->close();
        exit;
    } elseif ($action === 'update' && isset($_POST['cart_id'], $_POST['quantity'])) {
        $cart_id = $_POST['cart_id'];
        $quantity = $_POST['quantity'];
        $sql = "UPDATE cart SET quantity = ? WHERE cart_id = ? AND user_id = ?";
        $stmt = $connector->prepare($sql);
        $stmt->bind_param('iii', $quantity, $cart_id, $user_id);

        if ($stmt->execute()) {
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'error', 'message' => $stmt->error]);
        }

        $stmt->close();
        exit;
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart | Online Store</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lexend:wght@100..900&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/7171c8ef3e.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <link rel="stylesheet" href="style.css">
    <style>
        /* CSS styles here */
        body {
          font-family: Helvetica Neue, Helvetica, Arial, sans-serif;
          font-size: 14px;
          margin: 0;
          padding: 0;
          background-color: #f9f9f9; /* light gray background */
        }

        header {
            color: #fff;
            padding: 1em;
            text-align: center;
        }

        header nav ul {
            list-style: none;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: space-between;
        }

        header nav li {
            margin-right: 20px;
        }

        header nav a {
            color: #fff;
            text-decoration: none;
        }

        header nav a.active {
            color: #ccc;
        }

        main {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 2em;
        }

        .cart-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            width: 80%;
            margin: 0 auto;
            margin-top: 6%;
            background-color: #fff; /* white background */
            padding: 20px;
            border: 1px solid #ddd; /* light gray border */
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); /* subtle shadow */
        }

        .cart-items {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 1em;
            border-bottom: 1px solid #ddd; /* light gray border */
        }

        .cart-item {
            display: flex;
            flex-direction: row;
            align-items: center;
            justify-content: spaceBetween;
            width: 100%;
            padding: 1em;
            border-bottom: 1px solid #ddd; /* light gray border */
        }

        .cart-item:last-child {
            border-bottom: none;
        }

        .cart-item img {
            width: 50px;
            height: 50px;
            margin-right: 10px;
        }

        .cart-item .product-info {
            flex-grow: 1;
        }

        .cart-item .product-info h2 {
            font-size: 16px;
            margin-bottom: 10px;
            color: #333; /* dark gray text */
        }

        .cart-item .product-info p {
            font-size: 14px;
            color: #666; /* medium gray text */
        }

        .cart-item .quantity {
            display: flex;
            flex-direction: row;
            align-items: center;
            margin-right: 10px;
        }

        .cart-item .quantity label {
            margin-right: 10px;
        }

        .cart-item .quantity input {
            width: 60px;
            height: 30px;
            padding: 10px;
            border: 1px solid #ddd; /* light gray border */
            border-radius: 10px;
        }

        .cart-item .buttons {
            display: flex;
            flex-direction: row;
            align-items: center;
        }

        .cart-item .buttons button {
            background-color: #FF6D00; /* rgb(255, 109, 0) */
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 10px;
            cursor: pointer;
        }

        .cart-item .buttons button:hover {
            background-color: #FFA07A; /* rgb(255, 170, 0) */
        }

        .cart-summary {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 1em;
            border: 1px solid #ddd; /* light gray border */
            border-radius: 10px;
            background-color: #fff; /* white background */
            margin-top: 24px;
        }

        .cart-summary h2 {
            font-size: 18px;
            margin-bottom: 10px;
            color: #333; /* dark gray text */
        }

        .cart-summary p {
            font-size: 14px;
            color: #666; /* medium gray text */
        }

        .cart-summary button {
            background-color: #FF6D00; /* rgb(255, 109, 0) */
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 10px;
            cursor: pointer;
            margin-top: 10px;
        }  

        .cart-summary button:hover {
          background-color: #FFA07A; /* rgb(255, 170, 0) */
        }
    </style>
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
</head>
<body>
    <main>
        <div class="cart-container">
            <h1>Shopping Cart</h1>
            <div id="cart-items-container" class="cart-items">
                <?php foreach ($cart as $item): ?>
                    <div class="cart-item" data-id="<?= $item['cart_id'] ?>">
                        <?php
                        $imageData = base64_encode($item['product_image']);
                        $src = 'data:image/jpeg;base64,' . $imageData;
                        ?>
                        <img src="<?= $src ?>" alt="<?= $item['prod_name'] ?>">
                        <div class="product-info">
                            <h2><?= $item['prod_name'] ?></h2>
                            <p class="price">RM<?= number_format($item['prod_price'], 2) ?></p>
                        </div>
                        <div class="quantity">
                            <label for="quantity">Quantity:</label>
                            <input type="number" value="<?= $item['quantity'] ?>" min="1" data-id="<?= $item['cart_id'] ?>">
                        </div>
                        <div class="buttons">
                            <button class="remove-from-cart" data-id="<?= $item['cart_id'] ?>">Remove</button>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <div class="cart-summary">
                <h2>Cart Summary</h2>
                <p id="total-items"><?= count($cart) ?> items</p>
                <p id="total-price">RM0.00</p>
                <button id="checkout-button">Proceed to Checkout</button>
            </div>
        </div>
    </main>
    <script>
        const cartItemsContainer = document.getElementById('cart-items-container');
        const totalItems = document.getElementById('total-items');
        const totalPrice = document.getElementById('total-price');
        const checkoutButton = document.getElementById('checkout-button');

        const calculateTotal = () => {
            let totalItemsCount = 0;
            let totalPriceValue = 0;

            document.querySelectorAll('.cart-item').forEach(item => {
                const quantity = parseInt(item.querySelector('.quantity input').value);
                const price = parseFloat(item.querySelector('.product-info .price').textContent.replace('RM', ''));

                totalItemsCount += quantity;
                totalPriceValue += price * quantity;
            });

            totalItems.textContent = `${totalItemsCount} items`;
            totalPrice.textContent = `RM${totalPriceValue.toFixed(2)}`;
        };

        // Initialize totals
        calculateTotal();

        // Remove from cart
        cartItemsContainer.addEventListener('click', event => {
            if (event.target.classList.contains('remove-from-cart')) {
                const cartId = event.target.dataset.id;

                fetch('cart.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: `action=delete&cart_id=${cartId}`
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        event.target.closest('.cart-item').remove();
                        calculateTotal();
                    } else {
                        console.error(data.message);
                    }
                })
                .catch(error => console.error('Error:', error));
            }
        });

        // Update quantity in cart
        cartItemsContainer.addEventListener('change', event => {
            if (event.target.type === 'number') {
                const cartId = event.target.dataset.id;
                const quantity = event.target.value;

                fetch('cart.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: `action=update&cart_id=${cartId}&quantity=${quantity}`
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        calculateTotal();
                    } else {
                        console.error(data.message);
                    }
                })
                .catch(error => console.error('Error:', error));
            }
        });

        // Checkout
        checkoutButton.addEventListener('click', () => {
            window.location.href = 'checkout.php';
        });
    </script>
</body>
</html>