<?php
session_start();
// Cek login seller
if (!isset($_SESSION['username'])) {
    header("Location: loginseller.php");
    exit;
}
include 'konfigurasi/koneksi.php';

// Ambil semua produk
$produk = mysqli_query($conn, "SELECT * FROM products ORDER BY id_prod DESC");
// Proses tambah produk
$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['tambah_produk'])) {
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
// Proses edit produk
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_produk'])) {
    $id_prod = intval($_POST['id_prod']);
    $nama = trim($_POST['nama']);
    $harga = intval($_POST['harga']);
    $deskripsi = trim($_POST['deskripsi']);
    $gambar = $_POST['gambar_lama'];
    if (isset($_FILES['gambar']) && $_FILES['gambar']['tmp_name']) {
        $imgName = basename($_FILES['gambar']['name']);
        $target = 'uploads/' . $imgName;
        if (move_uploaded_file($_FILES['gambar']['tmp_name'], $target)) {
            $gambar = $imgName;
        }
    }
    $sql = "UPDATE products SET nama_prod='$nama', price=$harga, deskripsi='$deskripsi', gambar='$gambar' WHERE id_prod=$id_prod";
    if (mysqli_query($conn, $sql)) {
        $message = 'Produk berhasil diupdate!';
        header('Location: dashseller.php?msg=updated');
        exit;
    } else {
        $message = 'Gagal update produk.';
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Dashboard Seller</title>
  <link rel="stylesheet" href="css/style.css">
  <style>
    body {
      font-family: 'Montserrat', Arial, sans-serif;
      background: linear-gradient(120deg, #fcb7d4 0%, #fda085 100%);
      margin: 0;
      padding: 0;
    }
    header {
      background: rgba(255, 220, 243, 0.7);
      backdrop-filter: blur(10px);
      -webkit-backdrop-filter: blur(10px);
      box-shadow: 0 4px 24px 0 rgba(255, 105, 180, 0.10);
      border-radius: 0 0 18px 18px;
      position: sticky;
      top: 0;
      z-index: 100;
    }
    .container.nav {
      background: rgba(255, 240, 250, 0.85);
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
      background: linear-gradient(90deg,#ff69b4 60%,#fcb7d4 100%);
      color: #fff;
      text-decoration: none;
      border-radius: 8px;
      font-size: 15px;
      font-weight: 500;
      box-shadow: 0 2px 8px rgba(255, 105, 180, 0.10);
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
    .produk-card {
      background: #fff0fa;
      border-radius: 18px;
      padding: 20px;
      width: 290px;
      box-shadow: 0 8px 32px 0 rgba(255, 105, 180, 0.15);
      text-align: center;
      margin: 18px;
      display: inline-block;
      vertical-align: top;
      border: 2px solid #ffb6d5;
    }
    .produk-card img {
      width: 100%;
      height: 180px;
      object-fit: cover;
      border-radius: 12px;
      margin-bottom: 12px;
      border: 2px solid #ffb6d5;
    }
    .produk-card h4 {
      display: block;
      font-size: 20px;
      color: #e75480;
      font-weight: 700;
      margin: 10px 0 8px;
      text-align: center;
    }
    .produk-card .harga {
      display: block;
      color: #ff69b4;
      font-size: 18px;
      font-weight: bold;
      margin-bottom: 12px;
      text-align: center;
    }
    .btn {
      padding: 8px 18px;
      border-radius: 8px;
      background: #ff69b4;
      color: #fff;
      border: none;
      cursor: pointer;
      margin: 4px;
      font-weight: 600;
      box-shadow: 0 2px 8px rgba(255, 105, 180, 0.10);
      transition: background 0.2s;
    }
    .btn-edit {
      background: #fcb7d4;
      color: #e75480;
      border: 1.5px solid #ff69b4;
    }
    .btn-edit:hover {
      background: #ff69b4;
      color: #fff;
    }
    .btn:hover {
      background: #e75480;
      color: #fff;
    }
    .form-produk {
      background: #fff0fa;
      border-radius: 18px;
      box-shadow: 0 8px 32px 0 rgba(255, 105, 180, 0.10);
      padding: 28px;
      max-width: 400px;
      margin: 30px auto;
      border: 2px solid #ffb6d5;
    }
    .form-produk input, .form-produk textarea {
      width: 100%;
      padding: 10px;
      margin-bottom: 12px;
      border-radius: 7px;
      border: 1.5px solid #ffb6d5;
      background: #fff;
      font-family: 'Montserrat', Arial, sans-serif;
    }
    .form-produk label {
      font-weight: 600;
      color: #e75480;
    }
    .form-produk button {
      width: 100%;
      background: linear-gradient(90deg,#ff69b4 60%,#fcb7d4 100%);
      color: #fff;
      font-weight: 700;
      border: none;
      border-radius: 8px;
      padding: 10px 0;
      margin-top: 8px;
      box-shadow: 0 2px 8px rgba(255, 105, 180, 0.10);
      transition: background 0.2s;
    }
    .form-produk button:hover {
      background: #ff69b4;
      color: #fff;
    }
    .msg-success {
      color: #e75480;
      text-align: center;
      margin-bottom: 12px;
      font-weight: 600;
    }
    .msg-error {
      color: #ff1744;
      text-align: center;
      margin-bottom: 12px;
      font-weight: 600;
    }
    form[method="POST"] {
      background: #ffe3f1 !important;
      border-radius: 12px;
      box-shadow: 0 2px 8px rgba(255, 105, 180, 0.06);
      padding: 16px 12px;
      margin-bottom: 10px;
      border: 1.5px solid #ffb6d5;
    }
    form[method="POST"] label {
      color: #e75480;
    }
    form[method="POST"] input, form[method="POST"] textarea {
      border: 1.5px solid #ffb6d5;
      background: #fff;
    }
    form[method="POST"] button {
      background: linear-gradient(90deg,#ff69b4 60%,#fcb7d4 100%);
      color: #fff;
      font-weight: 700;
      border: none;
      border-radius: 8px;
      padding: 10px 0;
      margin-top: 8px;
      box-shadow: 0 2px 8px rgba(255, 105, 180, 0.10);
      transition: background 0.2s;
    }
    form[method="POST"] button:hover {
      background: #ff69b4;
      color: #fff;
    }
  </style>
</head>
<body>
  <header>
    <div class="container nav">
      <h1 class="logo">Bakery<span>House</span> Seller</h1>
      <div style="display:flex;align-items:center;gap:12px;">
        <a href="tambah.php" class="btn-link" style="background:linear-gradient(90deg,#0d6efd 60%,#00c6ff 100%);color:#fff;">+ Tambah Produk</a>
        <a href="logout.php" class="btn-link">Logout</a>
      </div>
    </div>
  </header>
  <div style="max-width:1200px;margin:30px auto;">
    <h3 style="text-align:center; color:#333; letter-spacing:2px; margin-top:30px; font-family:'Montserrat', Arial, sans-serif;">Daftar Produk</h3>
    <?php while($row = mysqli_fetch_assoc($produk)) { ?>
      <div class="produk-card">
        <img src="uploads/<?php echo htmlspecialchars($row['gambar']); ?>" alt="<?php echo htmlspecialchars($row['nama_prod']); ?>">
        <h4><?php echo htmlspecialchars($row['nama_prod']); ?></h4>
        <div class="harga">Rp <?php echo number_format($row['price'],0,',','.'); ?></div>
      
        <div style="font-size:13px;color:#888;min-height:40px;"><?php echo htmlspecialchars($row['deskripsi']); ?></div>
        <form method="POST" enctype="multipart/form-data" style="margin-top:10px;text-align:left; background:#f7faff; border-radius:12px; box-shadow:0 2px 8px rgba(13,110,253,0.06); padding:16px 12px; margin-bottom:10px;">
          <input type="hidden" name="edit_produk" value="1">
          <input type="hidden" name="id_prod" value="<?php echo $row['id_prod']; ?>">
          <input type="hidden" name="gambar_lama" value="<?php echo htmlspecialchars($row['gambar']); ?>">
          <label style="font-weight:600;">Nama:</label>
          <input type="text" name="nama" value="<?php echo htmlspecialchars($row['nama_prod']); ?>" required style="width:100%;padding:8px;margin-bottom:8px;border-radius:7px;border:1px solid #ccc;">
          <label style="font-weight:600;">Harga:</label>
          <input type="number" name="harga" value="<?php echo $row['price']; ?>" required style="width:100%;padding:8px;margin-bottom:8px;border-radius:7px;border:1px solid #ccc;">
          <label style="font-weight:600;">Stok:</label>
     
          <label style="font-weight:600;">Deskripsi:</label>
          <textarea name="deskripsi" required style="width:100%;padding:8px;margin-bottom:8px;border-radius:7px;border:1px solid #ccc;"><?php echo htmlspecialchars($row['deskripsi']); ?></textarea>
          <label style="font-weight:600;">Ganti Gambar (opsional):</label>
          <input type="file" name="gambar" accept="image/*" style="margin-bottom:8px;">
          <button type="submit" class="btn btn-edit" style="width:100%;margin-top:8px;">Edit Produk</button>
        </form>
      </div>
    <?php } ?>
  </div>
</body>
</html>
