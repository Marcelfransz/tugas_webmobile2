<?php
session_start();
$conn = new mysqli('localhost', 'root', '', 'kapal_db');

// Periksa koneksi database
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ambil data dari form
    $username = $_POST['username'];
    $password = $_POST['password']; // Ambil password langsung tanpa hashing

    // Query untuk memeriksa username dan password
    $stmt = $conn->prepare("SELECT id FROM admin WHERE username = ? AND password = ?");
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $stmt->store_result();

    // Periksa apakah data ditemukan
    if ($stmt->num_rows > 0) {
        $_SESSION['admin'] = $username;
        header("Location: dashboard.php"); // Arahkan ke dashboard
    } else {
        echo "Username atau password salah.";
    }

    $stmt->close();
}

$conn->close();
?>
