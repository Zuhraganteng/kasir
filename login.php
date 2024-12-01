<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Koneksi ke database
    $conn = new mysqli("localhost", "root", "", "website_db");

    if ($conn->connect_error) {
        die("Koneksi gagal: " . $conn->connect_error);
    }

    // Query untuk mencari user berdasarkan username dan password
    $sql = "SELECT * FROM users WHERE username = ? AND password = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];  // Menyimpan peran pengguna

        // Redirect berdasarkan role
        if ($_SESSION['role'] == 'admin') {
            header("Location: admin.php");
        } else {
            header("Location: index.php");
        }
        exit;
    } else {
        
    }

    $stmt->close();
    $conn->close();
}
?>



?>


<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login Form</title>
  <link rel="stylesheet" href="login.css">
</head>
<body>
  <div class="login-container">
    <h2>Silakan login terlebih dahulu</h2>
    <form action="login.php" method="POST">
      <label for="username">Nama pengguna:</label>
      <input type="text" id="username" name="username" placeholder="Masukkan nama pengguna" required>

      <label for="password">Kata sandi:</label>
      <input type="password" id="password" name="password" placeholder="Masukkan kata sandi" required>

      <label>
        <input type="checkbox" name="remember"> Ingat saya
      </label>
      <button type="submit">Login</button>
      <p><a href="#">Lupa kata sandi Anda?</a></p>
      <p>Belum punya akun? <a href="#">Daftar sekarang</a>.</p>
    </form>
  </div>
</body>
</html>
