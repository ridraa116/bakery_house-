<?php
session_start();
include 'konfigurasi/koneksi.php';

// Ambil id produk dari URL
$product = null;
if (isset($_GET['id_prod'])) {
    $id_prod = intval($_GET['id_prod']);
    $query = "SELECT * FROM products WHERE id_prod = $id_prod";
    $result = mysqli_query($conn, $query);
    if ($result && mysqli_num_rows($result) > 0) {
        $product = mysqli_fetch_assoc($result);
    }
}
if (!$product) {
    echo '<div style="text-align:center;margin-top:40px;color:red;font-size:18px;">Produk tidak ditemukan.</div>';
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Detail Produk - TokoKu</title>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500;700&display=swap" rel="stylesheet">
  <style>
    body {
      font-family: 'Montserrat', Arial, sans-serif;
      background: linear-gradient(120deg, #ffb6e6 0%, #ff69b4 100%);
      margin: 0;
      padding: 0;
    }
    .container {
      max-width: 600px;
      margin: 50px auto;
      background: #fff0fa;
      padding: 40px 36px 32px 36px;
      border-radius: 22px;
      box-shadow: 0 8px 32px 0 rgba(255, 105, 180, 0.15);
      border: 2px solid #ffb6e6;
      position: relative;
      overflow: hidden;
    }
    .produk-detail {
      display: flex;
      flex-direction: row;
      align-items: flex-start;
      gap: 32px;
      justify-content: flex-start;
    }
    .produk-detail img {
      width: 260px;
      height: 260px;
      object-fit: cover;
      border-radius: 18px;
      box-shadow: 0 2px 12px #ffb6e6;
      border: 2px solid #ff69b4;
      background: #fff;
      flex-shrink: 0;
    }
    .produk-info {
      display: flex;
      flex-direction: column;
      align-items: flex-start;
      justify-content: flex-start;
      flex: 1;
    }
    .produk-info .nama {
      font-size: 26px;
      font-weight: bold;
      color: #ff69b4;
      margin-bottom: 8px;
      text-align: left;
      letter-spacing: 0.5px;
    }
    .produk-info .harga {
      color: #e75480;
      font-size: 22px;
      font-weight: 600;
      margin-bottom: 10px;
      text-align: left;
    }
    .produk-info .desc {
      color: #444;
      font-size: 16px;
      margin-bottom: 18px;
      text-align: left;
    }
    .produk-info .stok {
      color: #007bff;
      font-size: 15px;
      margin-bottom: 18px;
      text-align: left;
    }
    .produk-info .rate-terjual {
      display: flex;
      gap: 18px;
      align-items: center;
      justify-content: flex-start;
      margin-bottom: 18px;
    }
    .produk-info .btn {
      display: inline-block;
      margin: 8px 6px 0 0;
      padding: 12px 28px;
      background: linear-gradient(90deg, #ff69b4 60%, #e75480 100%);
      color: #fff;
      text-decoration: none;
      border-radius: 10px;
      font-size: 16px;
      font-weight: 500;
      box-shadow: 0 2px 8px rgba(255, 105, 180, 0.08);
      border: none;
      cursor: pointer;
      transition: background 0.2s, transform 0.2s;
      letter-spacing: 0.5px;
    }
    .produk-info .btn:hover {
      background: linear-gradient(90deg, #e75480 60%, #ff69b4 100%);
      transform: scale(1.04);
    }
  </style>
</head>
<body>
  <div class="container">
    <div class="produk-detail">
      <img src="uploads/<?php echo htmlspecialchars($product['gambar']); ?>" alt="<?php echo htmlspecialchars($product['nama_prod']); ?>">
      <div class="produk-info">
        <div class="nama"> <?php echo htmlspecialchars($product['nama_prod']); ?> </div>
        <div class="harga">Rp <?php echo number_format($product['price'],0,',','.'); ?></div>
        <div class="desc"> <?php echo nl2br(htmlspecialchars($product['deskripsi'])); ?> </div>

        <div class="rate-terjual">
          <span style="color:#ffc107;font-size:18px;">
            <?php
              $rate = isset($product['rate']) ? (float)$product['rate'] : 0;
              $stars = str_repeat('★', floor($rate));
              $stars .= str_repeat('☆', 5-floor($rate));
              echo $stars . " (" . number_format($rate,1) . ")";
            ?>
          </span>
          <span style="color:#555;font-size:15px;">Terjual: <?php echo isset($product['sold']) ? (int)$product['sold'] : 0; ?> pcs</span>
        </div>
        <a class="btn" href="checkout1.php?id_prod=<?php echo $product['id_prod']; ?>">Beli Sekarang</a>
        <a class="btn" href="dashboard.php">Kembali</a>
      </div>
    </div>
  </div>
</body>
</html>
