<?php
session_start();
if ($_SESSION['role'] !== 'admin') {
    header("Location: login.php"); // Jika bukan admin, redirect ke login
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $menu_name = $_POST['menu'];
    $price = $_POST['price'];

    // Koneksi ke database
    $conn = new mysqli("localhost", "root", "", "website_db");

    if ($conn->connect_error) {
        die("Koneksi gagal: " . $conn->connect_error);
    }

    // Menambahkan menu baru ke database
    $sql = "INSERT INTO menu (menu_name, price) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $menu_name, $price);

    if ($stmt->execute()) {
        echo "Menu berhasil ditambahkan!";
    } else {
        echo "Gagal menambahkan menu!";
    }

    $stmt->close();
    $conn->close();
}
?>
