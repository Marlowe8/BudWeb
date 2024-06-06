<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login to BudWeb</title>
    <link rel="stylesheet" type="text/css" href="../Asset/login.css">
    <link rel="icon" type="image/jpg" href="../Components/budweb-high-resolution-logo.png">
</head>
<body>
    <div class="container">
        <form class="form" id="login" method="post" action="../databasehandler/loginconnection.php">
            <img src="../Components/budweb-high-resolution-logo.png" alt="Logo" class="logo" width="200">
            <!-- Username or Email input -->
            <div class="input_group">
                <input type="text" name="username" class="user_input" autofocus placeholder="Username or email">
            </div>
            <!-- Password input -->
            <div class="input_group">
                <input type="password" name="password" class="user_input" placeholder="Password">
                <?php
                session_start();
                if (isset($_SESSION['login_error'])) {
                    echo '<div class="error_message">'.$_SESSION['login_error'].'</div>';
                    unset($_SESSION['login_error']);
                }
                ?>
            </div>
            <!-- Login Button -->
            <button class="login_button" type="submit">Login</button>
        </form>

        <div class="form_create_account">
            <a href="../LoginSignup/signup.php" class="form_create_account_link">Create a BudWeb account</a>
        </div>
    </div>
</body>
</html>
