<?php
session_start();
if ($_SESSION['role'] != 'member') {
    header('Location: login.php'); // Hanya member yang bisa mengakses
    exit;
}

include('koneksi.php'); // Koneksi ke database

// Query untuk mendapatkan hasil penjualan
$sql = "SELECT item, jumlah, total FROM penjualan";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aplikasi Kasir</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <h1>Aplikasi Kasir</h1>
        <nav id="dynamicMenu">
            <ul>
                <li><a href="#" onclick="showProducts()">Produk</a></li>
                <li><a href="#" onclick="showHistory()">Riwayat</a></li>
                <li><a href="#" onclick="showCart()">Keranjang</a></li>
                <li><a href="#" onclick="showProfile()">Profil</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <h2>Dashboard Member</h2>
        <h3>Hasil Penjualan</h3>

        <div class="search-container">
            <input type="text" id="searchInput" placeholder="Cari barang...">
            <button onclick="search()">Cari</button>
        </div>

        <div id="productList">
            <!-- Daftar barang akan ditampilkan di sini -->
            <table border="1">
                <tr>
                    <th>Item</th>
                    <th>Jumlah</th>
                    <th>Total</th>
                </tr>
                <?php
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>" . $row['item'] . "</td>
                            <td>" . $row['jumlah'] . "</td>
                            <td>" . $row['total'] . "</td>
                        </tr>";
                }
                ?>
            </table>
        </div>

        <button onclick="checkout()">Checkout</button>
    </main>

    <footer>
        <button onclick="downloadReport()">Download Laporan Penjualan</button>
        &copy; 2024 Aplikasi Kasir
    </footer>

    <div class="overlay" id="popupOverlay">
        <div class="popup" id="transactionPopup">
            <h2>Rincian Transaksi</h2>
            <div id="transactionDetails">
                <!-- Rincian transaksi akan ditampilkan di sini -->
            </div>
            <button onclick="closePopup()">Selesai</button>
        </div>
    </div>

    <script src="index.js"></script>
</body>
</html>
