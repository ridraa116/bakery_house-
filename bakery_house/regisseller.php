<?php
include 'konfigurasi/koneksi.php';
$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username_seller'] ?? '');
    $password = $_POST['password'] ?? '';
    if ($username && $password) {
        // Cek username sudah ada
        $cek = mysqli_query($conn, "SELECT * FROM seller WHERE username_seller='$username'");
        if (mysqli_num_rows($cek) > 0) {
            $message = 'Username sudah terdaftar!';
        } else {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $sql = "INSERT INTO seller (username_seller, password) VALUES ('$username', '$hash')";
            if (mysqli_query($conn, $sql)) {
                $message = 'Registrasi seller berhasil! Silakan login.';
            } else {
                $message = 'Registrasi gagal: ' . mysqli_error($conn);
            }
        }
    } else {
        $message = 'Semua field wajib diisi!';
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Registrasi Seller - TokoKu</title>
  <link rel="stylesheet" href="css/style2.css">
  <style>
    body {
      background: linear-gradient(120deg, #ffb6e6 0%, #ff69b4 100%);
    }
    .container {
      background-color: #fff0fa;
      box-shadow: 0 0 15px rgba(255, 105, 180, 0.18);
    }
    h2 {
      color: #ff69b4;
    }
    label {
      color: #e75480;
    }
    input[type="text"],
    input[type="email"],
    input[type="password"] {
      border: 1px solid #ffb6e6;
      background: #fff6fa;
    }
    input:focus {
      border-color: #ff69b4;
    }
    button {
      background-color: #ff69b4;
    }
    button:hover {
      background-color: #e75480;
    }
    p {
      color: #e75480;
    }
    a {
      color: #ff69b4;
    }
    a:hover {
      color: #e75480;
    }
  </style>
</head>
<body>
  <div class="container">
    <h2>Registrasi Seller</h2>
    <?php 
      if ($message) {
        $isSuccess = strpos($message, 'berhasil') !== false;
        $color = $isSuccess ? 'green' : 'red';
        echo '<div style="color:'.$color.';margin-bottom:12px;">'.$message.'</div>';
      }
    ?>
    <form method="POST" action="">
      <label>Username Seller:</label>
      <input type="text" name="username_seller" required>
      <label>Password:</label>
      <input type="password" name="password" required>
      <button type="submit">Daftar Seller</button>
    </form>
    <p class="text-center">Sudah punya akun seller? <a href="loginseller.php">Login di sini</a></p>
    
  </div>
</body>
</html>
