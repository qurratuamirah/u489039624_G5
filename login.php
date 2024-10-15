<?php
session_start();
include('connector.php');
if(isset($_POST['user_id'])) {
    $user_id = $_POST['user_id'];
    $password = $_POST['password'];
    $sql = "SELECT * FROM user";
    $result = mysqli_query($connector, $sql);
    $jumpa = FALSE;

    while($user = mysqli_fetch_array($result)) {
        if ($user["user_id"] == $user_id && $user["password"] == $password) {
            $jumpa = TRUE;
            break; 
        }
    }
    if ($jumpa == TRUE) {
        $_SESSION['user_id'] = $user_id;
        header("Location: index.php");
    } else {
        echo "<script>alert('Wrong email or password. Please try again.');
        window.location='login.php'</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lexend:wght@100..900&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Lexend', sans-serif;
            background: url('images/bg.jpg') no-repeat center center fixed;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .login {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 100%;
            max-width: 400px;
            margin: auto;
        }

        .login-container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            width: 150%;
        }

        .login-content {
            text-align: center;
        }

        .login-form .header {
            font-size: 24px;
            font-weight: 700;
            margin-bottom: 20px;
            color: #333;
        }

        .login-form .header img{
            height: 40px;
            width: auto;
        }

        .login-form .header span {
            color: #007bff;
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
            width: 90%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 14px;
            color: #333;
        }

        .btn {
            margin-left: 15%;
            width: 70%;
            padding: 10px;
            background-color: #ff6f61;
            border: none;
            border-radius: 5px;
            color: #fff;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s;
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
            .login-container {
                padding: 15px;
            }

            .login-form .header {
                font-size: 20px;
            }
        }
    </style>

</head>
<body>
    <div class="login">
        <div class="login-container">
            <div class="login-content">
                <div class="login-form">
                    <div class="header">
                        <img src="images/GearUp_icon.png" alt="Logo">
                        GEAR UP SPORT</div>
                    <form action="login.php" method="post" class="index" >
                        <div class="form-row">
                            <div class="label">User ID</div>
                            <input type="number" class="textfield" name="user_id">
                        </div>
                        <div class="form-row">
                            <div class="label">Password</div>
                            <input type="password" class="textfield" name="password">
                        </div>
                        <div class="form-row" style="align-items: center;">
                            <input class="btn" type="submit" value="Login">
                        </div>
                        <div class="form-row" style="align-items: center; gap: 0px">
                            Don't have any account yet? <a class="link" href="signup.php" ><br>Create one now!</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>