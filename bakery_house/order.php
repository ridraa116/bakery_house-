<?php
session_start();
include 'konfigurasi/koneksi.php';

if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit;
}

// Ambil id user dari tabel customers
$username = $_SESSION['username'];
$userQ = mysqli_query($conn, "SELECT id FROM customers WHERE username='$username'");
$user = mysqli_fetch_assoc($userQ);
$userId = $user ? $user['id'] : 0;

// Ambil orderan user
$query = "SELECT o.no_transaksi, o.nama_prod, o.price, o.gambar FROM orders o WHERE o.id = $userId ORDER BY o.no_transaksi DESC";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Orderan saya</title>
  <link rel="stylesheet" href="css/style2.css">
  <style>
    body {
      background: linear-gradient(120deg, #ffb6e6 0%, #ff69b4 100%);
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      margin: 0;
      padding: 0;
    }
    .container {
      background-color: #fff0fa;
      border-radius: 10px;
      box-shadow: 0 0 15px rgba(255, 105, 180, 0.18);
      padding: 32px 28px 28px 28px;
      max-width: 600px;
      margin: 40px auto;
    }
    h2 {
      color: #ff69b4;
      text-align: center;
      margin-bottom: 24px;
    }
    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 18px;
      background: #fff;
      border-radius: 8px;
      overflow: hidden;
    }
    th, td {
      padding: 12px 10px;
      text-align: center;
      border-bottom: 1px solid #ffe0f0;
    }
    th {
      background: #ffb6e6;
      color: #fff;
    }
    tr:last-child td {
      border-bottom: none;
    }
    img {
      width: 60px;
      height: 60px;
      object-fit: cover;
      border-radius: 8px;
    }
    .no-order {
      text-align: center;
      color: #e75480;
      margin: 30px 0 0 0;
      font-size: 18px;
    }
  </style>
</head>
<body>
  <div class="container">
    <h2>Orderan Saya</h2>
    <a href="dashboard.php" style="display:inline-block;margin-bottom:18px;background:linear-gradient(90deg,#ff69b4 60%,#e75480 100%);color:#fff;padding:12px 28px;font-size:16px;font-weight:600;border:none;border-radius:10px;cursor:pointer;box-shadow:0 2px 8px rgba(255,105,180,0.10);text-decoration:none;">Kembali ke Dashboard</a>
    <?php if (mysqli_num_rows($result) > 0) { ?>
    <table>
      <tr>
        <th>No. Transaksi</th>
        <th>Nama Produk</th>
        <th>Harga</th>
        <th>Gambar</th>
      </tr>
      <?php while ($row = mysqli_fetch_assoc($result)) { ?>
      <tr>
        <td><?php echo $row['no_transaksi']; ?></td>
        <td><?php echo htmlspecialchars($row['nama_prod']); ?></td>
        <td>Rp <?php echo number_format($row['price'],0,',','.'); ?></td>
        <td><img src="uploads/<?php echo htmlspecialchars($row['gambar']); ?>" alt=""></td>
      </tr>
      <?php } ?>
    </table>
    <?php } else { ?>
      <div class="no-order">Belum ada order.</div>
    <?php } ?>
  </div>
</body>
</html>
