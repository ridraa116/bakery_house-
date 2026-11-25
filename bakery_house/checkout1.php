<?php
session_start();
include 'konfigurasi/koneksi.php'; // Pastikan file koneksi sudah benar

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

// Ambil id produk dari URL
$product = null;
$hargaSatuan = 0;
if (isset($_GET['id_prod'])) {
    $id_prod = intval($_GET['id_prod']);
    $query = "SELECT * FROM products WHERE id_prod = $id_prod";
    $result = mysqli_query($conn, $query);
    if ($result && mysqli_num_rows($result) > 0) {
        $product = mysqli_fetch_assoc($result);
        $hargaSatuan = (int)$product['price'];
    }
} elseif (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $query = "SELECT * FROM products WHERE id = $id";
    $result = mysqli_query($conn, $query);
    if ($result && mysqli_num_rows($result) > 0) {
        $product = mysqli_fetch_assoc($result);
        $hargaSatuan = (int)$product['price'];
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
  <title>Checkout - TokoKu</title>
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
    .container:before {
      /* dekorasi pink di kiri atas dihapus */
    }
    h1 {
      margin-bottom: 28px;
      color: #ff69b4;
      font-weight: 700;
      letter-spacing: 1px;
      text-align: center;
      position: relative;
      z-index: 1;
    }
    .produk-info {
      display: flex;
      align-items: center;
      gap: 22px;
      margin-bottom: 24px;
      justify-content: center;
      position: relative;
      z-index: 1;
    }
    .produk-info img {
      width: 110px;
      height: 110px;
      object-fit: cover;
      border-radius: 18px;
      box-shadow: 0 2px 12px #ffb6e6;
      border: 2px solid #ff69b4;
      background: #fff;
    }
    .produk-info .nama {
      font-size: 22px;
      font-weight: bold;
      color: #ff69b4;
      margin-bottom: 6px;
      letter-spacing: 0.5px;
    }
    .produk-info .harga {
      color: #e75480;
      font-size: 18px;
      font-weight: 600;
    }
    form {
      position: relative;
      z-index: 1;
      margin-top: 10px;
    }
    label {
      display: block;
      margin-top: 18px;
      font-weight: 600;
      color: #e75480;
      letter-spacing: 0.2px;
    }
    input[type="text"],
    input[type="number"],
    input[type="file"],
    textarea,
    select {
      width: 100%;
      padding: 12px;
      margin-top: 7px;
      border: 1.5px solid #ffb6e6;
      border-radius: 10px;
      font-size: 15px;
      font-family: 'Montserrat', Arial, sans-serif;
      background: #fff6fa;
      color: #e75480;
      transition: border 0.2s;
    }
    input:focus, textarea:focus, select:focus {
      border-color: #ff69b4;
      outline: none;
    }
    .total-tagihan {
      font-size: 20px;
      font-weight: bold;
      margin-top: 24px;
      color: #ff69b4;
      text-align: right;
      background: #ffe0f0;
      padding: 10px 0 10px 0;
      border-radius: 8px;
      box-shadow: 0 1px 4px #ffe0f0;
    }
    .nomor-pembayaran {
      margin-top: 12px;
      color: #e75480;
      font-size: 15px;
      background: #fff6fa;
      padding: 12px;
      border-radius: 8px;
      border: 1px solid #ffb6e6;
    }
    .btn-submit {
      margin-top: 32px;
      background: linear-gradient(90deg, #ff69b4 60%, #e75480 100%);
      color: white;
      padding: 15px 0;
      width: 100%;
      font-size: 18px;
      font-weight: bold;
      border: none;
      border-radius: 12px;
      cursor: pointer;
      box-shadow: 0 2px 8px rgba(255, 105, 180, 0.08);
      transition: background 0.2s, transform 0.2s;
      letter-spacing: 0.5px;
    }
    .btn-submit:hover {
      background: linear-gradient(90deg, #e75480 60%, #ff69b4 100%);
      transform: scale(1.03);
    }
    @media (max-width: 700px) {
      .container {
        padding: 18px 6vw 18px 6vw;
      }
      .produk-info {
        flex-direction: column;
        gap: 10px;
      }
    }
  </style>
</head>
<body>
  <div class="container">
    <h1>Form Checkout</h1>
    <div class="produk-info">
      <img src="uploads/<?php echo htmlspecialchars($product['gambar']); ?>" alt="<?php echo htmlspecialchars($product['nama_prod']); ?>">
      <div>
        <div class="nama"> <?php echo htmlspecialchars($product['nama_prod']); ?> </div>
        <div class="harga">Harga Satuan: Rp <?php echo number_format($hargaSatuan,0,',','.'); ?></div>
      </div>
    </div>
    <form action="success.php" method="post" enctype="multipart/form-data">
      <input type="hidden" name="product_id" value="<?php echo $product['id_prod']; ?>">
      <label for="jumlah">Jumlah Pembelian:</label>
      <input type="number" id="jumlah" name="jumlah" min="1" value="1" required>
      <label for="metode">Metode Pembayaran:</label>
      <select id="metode" name="metode" required>
        <option value="">-- Pilih Metode --</option>
        <option value="Transfer Bank">Transfer Bank</option>
        <option value="COD">COD (Bayar di Tempat)</option>
        <option value="E-Wallet">E-Wallet (OVO, DANA, dll)</option>
      </select>
      <div class="nomor-pembayaran" id="nomorPembayaran" style="display:none;"></div>
     
      <label for="alamat">Alamat Lengkap:</label>
      <textarea id="alamat" name="alamat" rows="4" placeholder="Tulis alamat lengkap pengiriman" required></textarea>
      <label for="bukti">Upload Bukti Pembayaran:</label>
      <input type="file" id="bukti" name="bukti" accept="image/*" required>
      <div class="total-tagihan" id="totalTagihan">Total Tagihan: Rp <?php echo number_format($hargaSatuan,0,',','.'); ?></div>
      <button type="submit" class="btn-submit">Konfirmasi Pembelian</button>
    </form>
  </div>
  <script>
    const hargaSatuan = <?php echo $hargaSatuan; ?>;
    const jumlahInput = document.getElementById('jumlah');
    const totalTagihan = document.getElementById('totalTagihan');
    const metodeSelect = document.getElementById('metode');
    const nomorPembayaran = document.getElementById('nomorPembayaran');
    function updateTagihan() {
      const jumlah = parseInt(jumlahInput.value) || 1;
      const total = jumlah * hargaSatuan;
      totalTagihan.textContent = "Total Tagihan: Rp " + total.toLocaleString('id-ID');
    }
    function updateNomorPembayaran() {
      const metode = metodeSelect.value;
      let nomor = "";
      if (metode === "Transfer Bank") {
        nomor = "Silakan transfer ke: BRI 7767 0100 8963 500 a.n BakeryHouse";
      } else if (metode === "E-Wallet") {
        nomor = "Silakan bayar ke: OVO/DANA 08070654321";
      } else if (metode === "COD") {
        nomor = "Bayar langsung saat barang diterima (COD)";
      }
      if (metode) {
        nomorPembayaran.style.display = "block";
        nomorPembayaran.textContent = nomor;
      } else {
        nomorPembayaran.style.display = "none";
      }
    }
    jumlahInput.addEventListener("input", updateTagihan);
    metodeSelect.addEventListener("change", updateNomorPembayaran);
    updateTagihan();
  </script>
</body>
</html>
