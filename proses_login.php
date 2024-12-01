<?php
session_start();
include('koneksi.php'); // Koneksi ke database

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Query untuk mengambil pengguna berdasarkan username
    $sql = "SELECT * FROM users WHERE username = '$username' LIMIT 1";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc(); // Ambil data pengguna dari database

        // Verifikasi password
        if (password_verify($password, $user['password'])) {
            // Set session untuk pengguna yang berhasil login
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role']; // Set role (admin/member)

            // Debug: Pastikan peran yang benar diterima
            echo "Anda login sebagai: " . $_SESSION['role'];

            // Arahkan pengguna ke halaman sesuai dengan perannya
            if ($user['role'] == 'admin') {
                header('Location: admin.php');
                exit;
            } elseif ($user['role'] == 'member') {
                header('Location: index.php');
                exit;
            } else {
                echo "Peran tidak valid!";
            }
        } else {
            echo "Password salah!";
        }
    } else {
        echo "Username tidak ditemukan!";
    }
}
?>
