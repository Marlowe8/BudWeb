<?php
session_start();
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "budwebusers";
$connect = mysqli_connect($host, $user, $pass, $dbname);

if (!$connect) {
    die("Connection Failed: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    $username = mysqli_real_escape_string($connect, $username);
    $password = mysqli_real_escape_string($connect, $password);

    // Check if the input is an email or username
    if (filter_var($username, FILTER_VALIDATE_EMAIL)) {
        $sql = "SELECT * FROM users WHERE email='$username'";
    } else {
        $sql = "SELECT * FROM users WHERE username='$username'";
    }

    $result = mysqli_query($connect, $sql);
    if (mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);
        if ($password === $user['password']) { //TODO: if (password_verify($password, $user['password'])) { this code unhash the hashed password. Use it when the password is hashed
            $_SESSION['user_id'] = $user['ID'];
            $_SESSION['username'] = $user['username'];
            header("location: ../Budgettracker/home.php"); // Ensure the path is correct
            exit();
        } else {
            $_SESSION["login_error"] = "Invalid Password";
            header("location: ../LoginSignup/login.php");
            exit();
        }
    } else {
        $_SESSION["login_error"] = "Account does not exist";
        header("location: ../LoginSignup/login.php");
        exit();
    }
}

mysqli_close($connect);
?>
