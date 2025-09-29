<?php
session_start();
$host = "localhost";
$user = "root";
$pass = "";
$db = "whitelist_db";

$connection = mysqli_connect($host, $user, $pass, $db);
if (!$connection) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

// get data from the form
$username = $_POST['username'];
$password = $_POST['password'];

// search user from database
$sql = "SELECT password FROM user WHERE username = ?";
$stmt = $connection->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    $stmt->bind_result($hashed_password);
    $stmt->fetch();
    // Verifikasi password
    if (password_verify($password, $hashed_password)) {
        $_SESSION['login'] = true;
        header("Location: home.html?login=success");
        exit();
    } else {
        header("Location: login.html?login=fail");
        exit();
    }
} else {
    header("Location: login.html?login=fail");
    exit();
}

$stmt->close();
$connection->close();
