<?php
session_start();
// Cek login seller
if (!isset($_SESSION['username'])) {
    header("Location: loginseller.php");
    exit;
}
include 'konfigurasi/koneksi.php';
$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = trim($_POST['nama']);
    $harga = intval($_POST['harga']);
    $deskripsi = trim($_POST['deskripsi']);
    $gambar = '';
    if (isset($_FILES['gambar']) && $_FILES['gambar']['tmp_name']) {
        $imgName = basename($_FILES['gambar']['name']);
        $target = 'uploads/' . $imgName;
        if (move_uploaded_file($_FILES['gambar']['tmp_name'], $target)) {
            $gambar = $imgName;
        }
    }
    if ($nama && $harga && $gambar) {
        $sql = "INSERT INTO products (nama_prod, price, deskripsi, gambar) VALUES ('$nama', $harga, '$deskripsi', '$gambar')";
        if (mysqli_query($conn, $sql)) {
            $message = 'Produk berhasil ditambahkan!';
            header('Location: dashseller.php?msg=success');
            exit;
        } else {
            $message = 'Gagal menambah produk.';
        }
    } else {
        $message = 'Semua field dan gambar wajib diisi!';
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Tambah Produk - TokoKu</title>
  <link rel="stylesheet" href="css/style.css">
  <style>
    body {
      font-family: 'Montserrat', Arial, sans-serif;
      background: linear-gradient(120deg, #ffdde1 0%, #fda085 100%);
      margin: 0;
      padding: 0;
    }
    header {
      background: rgba(255,192,203,0.7);
      backdrop-filter: blur(10px);
      -webkit-backdrop-filter: blur(10px);
      box-shadow: 0 4px 24px 0 rgba(255,105,180,0.10);
      border-radius: 0 0 18px 18px;
      position: sticky;
      top: 0;
      z-index: 100;
    }
    .container.nav {
      background: rgba(255,182,193,0.85);
      backdrop-filter: blur(12px);
      box-shadow: 0 4px 24px 0 rgba(255,105,180,0.10);
      border-radius: 0 0 24px 24px;
      padding: 18px 32px 12px 32px;
      display: flex;
      align-items: center;
      justify-content: space-between;
      margin-bottom: 0;
      transition: background 0.3s;
    }
    .logo {
      font-size: 2.1rem;
      font-weight: 800;
      color: #e75480;
      letter-spacing: 1px;
      margin-right: 30px;
      font-family: 'Montserrat', Arial, sans-serif;
    }
    .logo span {
      color: #ff69b4;
    }
    .btn-link {
      background: linear-gradient(90deg,#ff69b4 60%,#ffb6c1 100%);
      color: #fff;
      text-decoration: none;
      border-radius: 8px;
      font-size: 15px;
      font-weight: 500;
      box-shadow: 0 2px 8px rgba(255,105,180,0.08);
      border: none;
      cursor: pointer;
      padding: 10px 22px;
      margin-left: 10px;
      transition: background 0.2s, color 0.2s;
      display: inline-block;
    }
    .btn-link:hover {
      background: #ff69b4;
      color: #fff;
    }
    .form-produk {
      background: #fff0f6;
      border-radius: 18px;
      box-shadow: 0 8px 32px 0 rgba(255,182,193,0.10);
      padding: 28px;
      max-width: 400px;
      margin: 30px auto;
      border: 2px solid #ffb6c1;
    }
    .form-produk input, .form-produk textarea {
      width: 100%;
      padding: 10px;
      margin-bottom: 12px;
      border-radius: 7px;
      border: 1.5px solid #ffb6c1;
      background: #fff;
      font-family: 'Montserrat', Arial, sans-serif;
    }
    .form-produk label {
      font-weight: 600;
      color: #e75480;
    }
    .form-produk button {
      width: 100%;
      background: #ff69b4;
      color: #fff;
      font-weight: 700;
      border: none;
      border-radius: 8px;
      padding: 10px 0;
      margin-top: 8px;
      box-shadow: 0 2px 8px rgba(255,182,193,0.10);
      transition: background 0.2s;
    }
    .form-produk button:hover {
      background: #e75480;
    }
    .msg-success {
      color: #e75480;
      text-align: center;
      margin-bottom: 12px;
      font-weight: bold;
    }
    .msg-error {
      color: #ff1744;
      text-align: center;
      margin-bottom: 12px;
      font-weight: bold;
    }
  </style>
</head>
<body>
  <header>
    <div class="container nav">
      <h1 class="logo">Toko<span>Ku</span> Seller</h1>
      <a href="dashseller.php" class="btn-link">Kembali ke Dashboard</a>
    </div>
  </header>
  <div class="form-produk">
    <h3>Tambah Produk</h3>
    <?php if ($message) echo '<div class="'.(strpos($message,'berhasil')!==false?'msg-success':'msg-error').'">'.$message.'</div>'; ?>
    <form method="POST" enctype="multipart/form-data">
      <label>Nama Produk:</label>
      <input type="text" name="nama" required>
      <label>Harga:</label>
      <input type="number" name="harga" required>
      <label>Deskripsi:</label>
      <textarea name="deskripsi" required></textarea>
      <label>Gambar:</label>
      <input type="file" name="gambar" accept="image/*" required>
      <button type="submit" class="btn">Tambah Produk</button>
    </form>
  </div>
</body>
</html>
