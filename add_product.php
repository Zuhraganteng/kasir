<?php
session_start();
include('koneksi.php');

// Pastikan pengguna adalah admin
if ($_SESSION['role'] != 'admin') {
    header('Location: login.php');
    exit;
}

// Jika formulir disubmit, simpan produk ke database
if (isset($_POST['submit'])) {
    $product_name = $_POST['product_name'];
    $price = $_POST['price'];
    $quantity = $_POST['quantity'];

    // Query untuk menyimpan produk baru
    $sql = "INSERT INTO products (name, price, quantity) VALUES ('$product_name', '$price', '$quantity')";
    if ($conn->query($sql) === TRUE) {
        echo "Produk berhasil ditambahkan!";
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Produk</title>
</head>
<body>
    <header>
        <h1>Tambah Produk</h1>
        <nav>
            <ul>
                <li><a href="admin_dashboard.php">Dashboard</a></li>
                <li><a href="add_product.php">Tambah Produk</a></li>
                <li><a href="sales_report.php">Laporan Penjualan</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <form action="add_product.php" method="POST">
            <label for="product_name">Nama Produk:</label>
            <input type="text" id="product_name" name="product_name" required><br>

            <label for="price">Harga:</label>
            <input type="number" id="price" name="price" required><br>

            <label for="quantity">Jumlah:</label>
            <input type="number" id="quantity" name="quantity" required><br>

            <button type="submit" name="submit">Tambah Produk</button>
        </form>
    </main>
</body>
</html>
