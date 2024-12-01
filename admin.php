<?php
session_start();
include('koneksi.php');

// Pastikan pengguna adalah admin
if ($_SESSION['role'] != 'admin') {
    header('Location: login.php');
    exit;
}

// Ambil data penjualan untuk grafik
$sql = "SELECT DATE(tanggal) AS date, SUM(total) AS total_sales FROM penjualan GROUP BY DATE(tanggal)";
$result = $conn->query($sql);

$salesData = [
    'labels' => [],
    'values' => []
];

while ($row = $result->fetch_assoc()) {
    $salesData['labels'][] = $row['date'];
    $salesData['values'][] = $row['total_sales'];
}

// Ambil laporan penjualan harian untuk tabel
$sqlReport = "SELECT DATE(tanggal) AS date, SUM(total) AS total_sales FROM penjualan GROUP BY DATE(tanggal)";
$resultReport = $conn->query($sqlReport);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="admin.css"> <!-- Pastikan CSS disesuaikan -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> <!-- Chart.js -->
</head>
<body>
    <header>
        <h1>Admin Dashboard</h1>
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
        <h2>Grafik Penjualan</h2>
        <div id="salesChart">
            <canvas id="salesChartCanvas"></canvas>
        </div>

        <h3>Laporan Penjualan Harian</h3>
        <table border="1">
            <tr>
                <th>Tanggal</th>
                <th>Total Penjualan</th>
            </tr>
            <?php while ($row = $resultReport->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['date']; ?></td>
                    <td><?php echo $row['total_sales']; ?></td>
                </tr>
            <?php endwhile; ?>
        </table>
    </main>

    <script>
        // Ambil data penjualan untuk grafik
        var salesData = <?php echo json_encode($salesData); ?>;

        // Inisialisasi Chart.js untuk menampilkan grafik
        var ctx = document.getElementById('salesChartCanvas').getContext('2d');
        var salesChart = new Chart(ctx, {
            type: 'bar', // Jenis grafik
            data: {
                labels: salesData.labels,  // Label berdasarkan tanggal
                datasets: [{
                    label: 'Penjualan',
                    data: salesData.values,  // Data total penjualan
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
</body>
</html>
