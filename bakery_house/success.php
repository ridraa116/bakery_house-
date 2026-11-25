<?php
session_start();
include 'konfigurasi/koneksi.php';

// Ambil data transaksi dari POST
$product = null;
$jumlah = isset($_POST['jumlah']) ? (int)$_POST['jumlah'] : 1;
$metode = isset($_POST['metode']) ? $_POST['metode'] : '-';
$nohp = isset($_POST['nohp']) ? $_POST['nohp'] : '-';
$alamat = isset($_POST['alamat']) ? $_POST['alamat'] : '-';
$total = 0;
$produk_nama = '-';
$produk_gambar = '';
$harga_satuan = 0;
if (isset($_POST['product_id'])) {
    $id_prod = intval($_POST['product_id']);
    $query = "SELECT * FROM products WHERE id_prod = $id_prod";
    $result = mysqli_query($conn, $query);
    if ($result && mysqli_num_rows($result) > 0) {
        $product = mysqli_fetch_assoc($result);
        $produk_nama = $product['nama_prod'];
        $produk_gambar = $product['gambar'];
        $harga_satuan = (int)$product['price'];
        $total = $harga_satuan * $jumlah;
        // Update kolom sold
        mysqli_query($conn, "UPDATE products SET sold = sold + $jumlah WHERE id_prod = $id_prod");

        // Simpan order ke tabel orders
        if (isset($_SESSION['username'])) {
            $username = $_SESSION['username'];
            $userQ = mysqli_query($conn, "SELECT id FROM customers WHERE username='$username'");
            $user = mysqli_fetch_assoc($userQ);
            $userId = $user ? $user['id'] : 0;
            // Buat nomor transaksi unik
            $no_transaksi = 'TRX' . date('YmdHis') . rand(100,999);
            // Simpan order
            $insert = mysqli_query($conn, "INSERT INTO orders (no_transaksi, id, nama_prod, price, gambar, jumlah, metode, alamat) VALUES ('{$no_transaksi}', {$userId}, '{$produk_nama}', {$harga_satuan}, '{$produk_gambar}', {$jumlah}, '{$metode}', '{$alamat}')");
            if (!$insert) {
                echo "<div style='color:red'>Gagal simpan order: " . mysqli_error($conn) . "</div>";
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Pesanan Diproses</title>
  <style>
    body {
      font-family: 'Montserrat', Arial, sans-serif;
      background: linear-gradient(120deg, #ffe0f7 0%, #ffb6e6 100%);
      margin: 0;
      padding: 0;
      min-height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
    }
    .container {
      background: #fff0fa;
      padding: 44px 36px 32px 36px;
      border-radius: 22px;
      box-shadow: 0 8px 32px 0 rgba(255,105,180,0.15);
      text-align: center;
      max-width: 420px;
      position: relative;
      overflow: hidden;
    }
    .container::before {
      content: '';
      position: absolute;
      top: -60px; left: -60px;
      width: 160px; height: 160px;
      background: radial-gradient(circle, #ffb6e6 60%, #fff0fa 100%);
      opacity: 0.22;
      border-radius: 50%;
      z-index: 0;
    }
    .container::after {
      content: '';
      position: absolute;
      bottom: -60px; right: -60px;
      width: 160px; height: 160px;
      background: radial-gradient(circle, #ff69b4 60%, #fff0fa 100%);
      opacity: 0.15;
      border-radius: 50%;
      z-index: 0;
    }
    h1 {
      color: #ff69b4;
      margin-bottom: 20px;
      font-weight: 800;
      letter-spacing: 1.5px;
      font-size: 2.1rem;
      position: relative;
      z-index: 1;
    }
    .produk-detail {
      display: flex;
      align-items: center;
      gap: 18px;
      margin: 18px 0 24px 0;
      justify-content: center;
      position: relative;
      z-index: 1;
    }
    .produk-detail img {
      width: 70px;
      height: 70px;
      object-fit: cover;
      border-radius: 14px;
      box-shadow: 0 2px 8px #ffd6f6;
      border: 2.5px solid #ffb6e6;
    }
    .produk-detail .nama {
      font-size: 18px;
      font-weight: bold;
      color: #e75480;
      margin-bottom: 4px;
      text-align: left;
    }
    .produk-detail .harga {
      color: #ff69b4;
      font-size: 15px;
      font-weight: 600;
      text-align: left;
    }
    .transaksi-detail {
      text-align: left;
      margin: 0 auto 18px auto;
      background: #fff;
      border-radius: 12px;
      padding: 18px 18px 10px 18px;
      font-size: 15px;
      color: #e75480;
      box-shadow: 0 1px 8px rgba(255,182,230,0.08);
      max-width: 340px;
      position: relative;
      z-index: 1;
    }
    .transaksi-detail b { color: #ff69b4; }
    .btn-kembali {
      display: inline-block;
      margin-top: 25px;
      background: linear-gradient(90deg,#ff69b4 60%,#e75480 100%);
      color: #fff;
      padding: 14px 32px;
      font-size: 17px;
      font-weight: 700;
      border: none;
      border-radius: 12px;
      text-decoration: none;
      box-shadow: 0 2px 8px rgba(255,105,180,0.10);
      transition: background 0.2s, transform 0.2s;
      cursor: pointer;
      position: relative;
      z-index: 1;
    }
    .btn-kembali:hover {
      background: linear-gradient(90deg,#e75480 60%,#ff69b4 100%);
      transform: scale(1.06);
    }
  </style>
</head>
<body>
  <div class="container">
    <h1>Terima kasih!</h1>
    <div class="produk-detail">
      <?php if ($produk_gambar) { ?>
        <img src="uploads/<?php echo htmlspecialchars($produk_gambar); ?>" alt="<?php echo htmlspecialchars($produk_nama); ?>">
      <?php } ?>
      <div style="text-align:left;">
        <div class="nama"><?php echo htmlspecialchars($produk_nama); ?></div>
        <div class="harga">Harga Satuan: Rp <?php echo number_format($harga_satuan,0,',','.'); ?></div>
      </div>
    </div>
    <div class="transaksi-detail">
      <div><b>Jumlah:</b> <?php echo $jumlah; ?></div>
      <div><b>Total:</b> Rp <?php echo number_format($total,0,',','.'); ?></div>
      <div><b>Metode Pembayaran:</b> <?php echo htmlspecialchars($metode); ?></div>
      <div><b>No. HP:</b> <?php echo htmlspecialchars($nohp); ?></div>
      <div><b>Alamat:</b> <?php echo nl2br(htmlspecialchars($alamat)); ?></div>
    </div>
    <p>Pesanan Anda sedang diproses. Kami akan segera mengirimkannya ke alamat yang Anda berikan.</p>
    <a href="dashboard.php" class="btn-kembali">Kembali ke Dashboard</a>
  </div>
</body>
</html>
