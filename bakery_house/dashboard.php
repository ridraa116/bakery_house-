<?php
session_start();
include 'konfigurasi/koneksi.php';

if (!isset($_SESSION['username'])) {
    // Jika belum login, arahkan ke login.php
    header("Location: login.php");
    exit;
}

// Ambil 6 produk dengan penjualan terbanyak
$query = "SELECT * FROM products ORDER BY sold DESC LIMIT 6";
$result = mysqli_query($conn, $query);
?>



<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title> E-Commerce</title>
  <link rel="stylesheet" href="css/style.css"/>
  <link rel="stylesheet" href="css/style3.css"/>
  <style>
    body {
      font-family: 'Montserrat', Arial, sans-serif;
      background: linear-gradient(120deg, #ffb6e6 0%, #ff69b4 100%);
      margin: 0;
      padding: 0;
    }
    header {
      background: rgba(255,240,250,0.7);
      backdrop-filter: blur(10px);
      -webkit-backdrop-filter: blur(10px);
      box-shadow: 0 4px 24px 0 rgba(255, 105, 180, 0.10);
      border-radius: 0 0 18px 18px;
      position: sticky;
      top: 0;
      z-index: 100;
    }
    .nav {
      background: rgba(255,240,250,0.85);
      backdrop-filter: blur(12px);
      box-shadow: 0 4px 24px 0 rgba(255, 105, 180, 0.10);
      border-radius: 0 0 24px 24px;
      padding: 18px 32px 12px 32px;
      display: flex;
      align-items: center;
      justify-content: space-between;
      margin-bottom: 0;
      transition: background 0.3s;
    }
    .nav-link {
      text-decoration: none;
      color: #e75480;
      font-weight: 500;
      padding: 8px 18px;
      border-radius: 8px;
      transition: background 0.2s, color 0.2s;
      display: inline-block;
    }
    .nav-link:hover, .nav-link.active {
      background: #ff69b4;
      color: #fff;
      box-shadow: 0 2px 8px rgba(255, 105, 180, 0.10);
    }
    .logo {
      font-size: 2.1rem;
      font-weight: 800;
      color: #ff69b4;
      letter-spacing: 1px;
      margin-right: 30px;
      font-family: 'Montserrat', Arial, sans-serif;
    }
    .logo span {
      color: #e75480;
    }
    .btn-link {
      background: linear-gradient(90deg,#ff69b4 60%,#e75480 100%);
      color: #fff;
      text-decoration: none;
      border-radius: 8px;
      font-size: 15px;
      font-weight: 500;
      box-shadow: 0 2px 8px rgba(255, 105, 180, 0.08);
      border: none;
      cursor: pointer;
      padding: 10px 22px;
      margin-left: 10px;
      transition: background 0.2s, color 0.2s;
      display: inline-block;
    }
    .btn-link:hover {
      background: #e75480;
      color: #fff;
    }
  </style>
</head>
<body>
  <!-- Navbar -->
  <header>
    <div class="container nav">
      <h1 class="logo">Bakery<span>House</span></h1>
      <nav>
        <ul>
          <li><a href="dashboard.php" class="nav-link">Beranda</a></li>
          <li><a href="product.php" class="nav-link">Produk</a></li>
          <li><a href="order.php" class="nav-link">Orderan Saya</a></li>
        
          
        </ul>
      </nav>

      <!-- Search & Login -->
      <form id="searchForm" method="get" action="product.php" style="display:inline-block;margin-right:10px;">
        <input type="text" id="searchBar" name="q" placeholder="Cari produk..." style="padding:7px;width:200px;border:1px solid #ccc;border-radius:5px;">
        <button type="submit" style="padding:7px 14px;background:#0d6efd;color:white;border:none;border-radius:5px;cursor:pointer;">Cari</button>
      </form>
      <a href="akun.php" class="btn-link">AKUN</a>

      <!-- Cart Icon -->
   
    </div>
  </header>

  <!-- Produk -->
  <section class="produk">
    <h3 style="text-align:center; color:#333; letter-spacing:2px; margin-top:30px; font-family:'Montserrat', Arial, sans-serif;">Produk Unggulan</h3>
    <div class="container grid" id="produk-list" style="display:flex; flex-wrap:wrap; gap:30px; justify-content:center; margin:40px auto 60px auto; max-width:1200px;">
      <?php while ($row = mysqli_fetch_assoc($result)) { ?>
      <div class="produk-card" style="background:#fff; border-radius:18px; padding:25px 20px 20px 20px; width:290px; box-shadow:0 8px 32px 0 rgba(31,38,135,0.15); text-align:center; transition:transform 0.2s, box-shadow 0.2s; position:relative;">
        <img src="uploads/<?php echo htmlspecialchars($row['gambar']); ?>" height="200" style="width:100%; object-fit:cover; border-radius:12px; margin-bottom:18px; box-shadow:0 2px 10px rgba(0,0,0,0.07);">
        <h4 style="font-size:20px; color:#0d6efd; font-weight:700; margin:10px 0 8px;"><?php echo htmlspecialchars($row['nama_prod']); ?></h4>
        <p class="price" style="color:#ff5722; font-size:18px; font-weight:bold; margin-bottom:12px;">Rp <?php echo number_format($row['price'],0,',','.'); ?></p>
        <a href="detail.php?id_prod=<?php echo $row['id_prod']; ?>" class="btn-link" style="display:inline-block; margin:6px 4px; padding:10px 22px; background:linear-gradient(90deg,#0d6efd 60%,#00c6ff 100%); color:#fff; text-decoration:none; border-radius:8px; font-size:15px; font-weight:500; box-shadow:0 2px 8px rgba(13,110,253,0.08); border:none; cursor:pointer;">Detail Produk</a>
        <a href="checkout1.php?id_prod=<?php echo $row['id_prod']; ?>" class="btn-link" style="display:inline-block; margin:6px 4px; padding:10px 22px; background:linear-gradient(90deg,#0d6efd 60%,#00c6ff 100%); color:#fff; text-decoration:none; border-radius:8px; font-size:15px; font-weight:500; box-shadow:0 2px 8px rgba(13,110,253,0.08); border:none; cursor:pointer;">Checkout</a>
      </div>
      <?php } ?>
    </div>
  </section>

  <!-- Cart Popup -->
  <div id="cartPopup" class="popup hidden">
    <h3>🛒 Keranjang Belanja</h3>
    <div id="cartItems"></div>
    <p>Total: <span id="totalHarga">Rp 0</span></p>
    <button onclick="checkout()">Checkout</button>
    <button onclick="closeCart()">Tutup</button>
  </div>

  <!-- Login Popup -->
  <div id="loginPopup" class="popup hidden">
    <h3>👤 Login Pengguna</h3>
    <input type="text" id="usernameInput" placeholder="Nama Pengguna" />
    <button onclick="login()">Login</button>
    <button onclick="closeLogin()">Batal</button>
  </div>

  <footer>
    <div class="container">
      <p>&copy; 2025 BakeryHouse. All rights reserved.</p>
    </div>
  </footer>

  <script src="script.js"></script>
</body>
</html>

<?php

?>