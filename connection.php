<?php
// connection to database
$host = "localhost";
$user = "root";
$pass = "";
$db = "whitelist_db";

$connection = mysqli_connect($host, $user, $pass, $db);
if (!$connection) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

// take data from the form
$username = $_POST['username'];
$telegram = $_POST['telegram'];
$wallet = $_POST['wallet'];
$password = $_POST['password'];
$hashed_password = password_hash($password, PASSWORD_DEFAULT);
$discord = $_POST['discord'];

// save data to database
$sql = "INSERT INTO user (username, telegram, wallet, password, discord)
        VALUES (?, ?, ?, ?, ?)";
$stmt = $connection->prepare($sql);
$stmt->bind_param("sssss", $username, $telegram, $wallet, $hashed_password, $discord);

if ($stmt->execute()) {
    header("Location: index.html?status=success");
    exit();
} else {
    header("Location: index.html?status=fail");
    exit();
}

$stmt->close();
$connection->close();
