<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up to BudWeb</title>
    <link rel="stylesheet" type="text/css" href="../Asset/signup.css">
    <link rel="icon" type="image/jpg" href="../Components/budweb-high-resolution-logo.png">

</head>
<body>
<div class="container">
    <form class="form" id="signup" method="post" action="../databasehandler/signupconnection.php">
        <div class="form_title">
            <h1>Sign up for BudWeb</h1>
            <p>Create a free account or  <a href="../LoginSignup/login.php" class="form_login_link">log in</a> </p>
        </div>
        
        <!-- Name input -->
        <div class="input_group">
            <h3>Name</h3>
            <input type="text" name="name" class="user_input" placeholder = "Name" required>
        </div>
        <!-- Username input -->
        <div class="input_group">
            <h3>Username</h3>
            <input type="text" name="username" class="user_input" placeholder = "Username" required>
        </div>
        <!-- Email input -->
        <div class="input_group">
            <h3>Email</h3>
            <input type="text" name="email" class="user_input" placeholder = "Email" required>
        </div>
        <!-- Password input -->
        <div class="input_group">
            <h3>Password</h3>
            <input type="password" name="password" class="user_input" placeholder = "Password" required>
        </div>
        <!-- Retype Password -->
        <div class="input_group">
            <h3>Retype Password</h3>
            <input type="password" name="retypepassword" class="user_input" placeholder = "Retype Password" required>
            <?php
        session_start();
        if (isset($_SESSION['signup_error'])) {
            echo '<div class="error_message">' . $_SESSION['signup_error'] . '</div>';
            unset($_SESSION['signup_error']);
        }
        ?>
        </div>
        <!-- Sign up Button -->
        <button class="signup_button" type="submit">Sign Up</button>
    </form>
</div>
</body>
</html>