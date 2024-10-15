<?php
include('connector.php');

if (isset($_POST['user_id'])) {
    $user_id = $_POST['user_id'];
    $user_name = $_POST['user_name'];
    $phone_num = $_POST['phone_num'];
    $password = $_POST['password'];

    $sql = "INSERT INTO user VALUES ('$user_id','$user_name','$phone_num','$password')";
    
    $result = mysqli_query($connector, $sql);

if ($result)
        echo "<script>alert('You have successfully signed up! Please login now.')</script>";
    else
        echo "<script>alert('Your registration is unsuccessful. Please try again. " . mysqli_error($connector) . "')')</script>";
    echo "<script>window.location='login.php'</script>";

mysqli_close($connector);
}?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lexend:wght@100..900&display=swap" rel="stylesheet">
<style>
    body {
    font-family: 'Lexend', sans-serif;
    background: url('images/bg.jpg') no-repeat center center fixed;
    background-size: cover;
    margin: 0;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
}

.register {
    display: fixed;
    justify-content: center;
    align-items: center;
    width: 100%;
    max-width: 400px;
    margin: auto;
}

.register-container {
    background-color: rgba(255, 255, 255, 0.9); /* Semi-transparent background */
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    width: 100%;
}

.register-content {
    text-align: center;
}

.register-form .header {
    font-size: 24px;
    font-weight: 700;
    margin-bottom: 20px;
    color: #333;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
}

.form-row {
    margin-bottom: 15px;
    text-align: left;
}

.label {
    margin-bottom: 5px;
    font-size: 14px;
    color: #555;
}

.textfield {
    width: 100%;
    padding: 10px;
    border: 1px solid #ddd;
    border-radius: 5px;
    font-size: 14px;
    color: #333;
    box-sizing: border-box;
}

.btn {
    width: 100%;
    padding: 10px;
    background-color: #ff6f61;
    border: none;
    border-radius: 5px;
    color: #fff;
    font-size: 16px;
    cursor: pointer;
    transition: background-color 0.3s;
    margin-top: 10px;
}

.btn:hover {
    background-color: #0056b3;
}

.link {
    color: #007bff;
    text-decoration: none;
    font-size: 14px;
}

.link:hover {
    text-decoration: underline;
}

@media (max-width: 480px) {
    .register-container {
        padding: 15px;
    }

    .register-form .header {
        font-size: 20px;
    }
}
</style>

</head>
<body>
    <div class="register">
        <div class="register-container">
            <div class="register-content">
                <div class="register-form">
                    <div class="header" style="font-size: 32px; margin-bottom: 24px;">Create a new account</div>
                    <form action="signup.php" method="post" class="register">
                        <div class="form-row">
                            <div class="label">User ID</div>
                            <input type="number" class="textfield" name="user_id" required>
                        </div>
                        <div class="form-row">
                            <div class="label">Name</div>
                            <input type="text" class="textfield" name="user_name" required>
                        </div>
                        <div class="form-row">
                            <div class="label">Phone Number</div>
                            <input type="number" class="textfield" name="phone_num" required>
                        </div>
                        <div class="form-row">
                            <div class="label">Password</div>
                            <input type="password" class="textfield" name="password" required>
                        </div>
                        <div class="form-row" style="align-items: center;">
                            <input class="btn" type="submit" value="Submit">
                        </div>
                        <div class="form-row" style="align-items: center; gap: 0px;">
                            Already have an account? <a class="link" href="login.php">Login now!</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>