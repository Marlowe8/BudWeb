<?php
session_start();
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "budwebusers";
$connect = mysqli_connect($host, $user, $pass, $dbname);
if(!$connect){
    die("connectection Failed: " . mysqli_connect_error());
}
if($_SERVER["REQUEST_METHOD"]=="POST"){
    $name = $_POST["name"];
    $username = $_POST["username"];
    $email =  $_POST["email"];
    $password = $_POST["password"];
    $matchpassword = $_POST["retypepassword"];

    $name = mysqli_real_escape_string($connect, $name);
    $username = mysqli_real_escape_string($connect, $username);
    $email = mysqli_real_escape_string($connect, $email);
    $password = mysqli_real_escape_string($connect, $password);
    $matchpassword = mysqli_real_escape_string($connect, $matchpassword);

    //matching password
    if($password !== $matchpassword){
        $_SESSION["signup_error"] =  "Password not match";
        header("location: ../LoginSignup/signup.php");
        exit();
    }
    // hashing password
    // $hashPassword = password_hash($password, PASSWORD_BCRYPT); //TODO Hashing Password
    $mysql = "INSERT INTO users (name, username, email, password) VALUES ('$name', '$username', '$email', '$password')";
    if(mysqli_query($connect,$mysql)){
        header("location: ../LoginSignup/login.php");
    }else{
        $_SESSION["signup_error"] = "Error: " . $mysql . "<br>" . mysqli_error($connect);
        header("location: ../LoginSignup/signup.php");
    }
}
mysqli_close($connect);
?>
