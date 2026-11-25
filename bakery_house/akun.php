<?php
session_start();
include '<konfigurasi/koneksi.php';

// Cek apakah user sudah login
if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];

    // Ambil data user dari database
    $query = "SELECT * FROM customers WHERE username = '$username'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        $data = mysqli_fetch_assoc($result);
    } else {
        echo "Data pengguna tidak ditemukan.";
        exit;
    }
} else {
    echo "Anda belum login. Silakan login terlebih dahulu.";
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Profil Pengguna</title>
    <link rel="stylesheet" href="css/style2.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Montserrat', Arial, sans-serif;
            background: linear-gradient(120deg, #ffe0f7 0%, #ffb6e6 100%);
            margin: 0;
            padding: 0;
            min-height: 100vh;
        }
        .profile-container {
            background: #fff0fa;
            max-width: 420px;
            margin: 60px auto 0 auto;
            border-radius: 28px;
            box-shadow: 0 8px 32px 0 rgba(255,105,180,0.18);
            padding: 44px 36px 32px 36px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }
        .profile-container::before {
            content: '';
            position: absolute;
            top: -60px; left: -60px;
            width: 160px; height: 160px;
            background: radial-gradient(circle, #ffb6e6 60%, #fff0fa 100%);
            opacity: 0.25;
            border-radius: 50%;
            z-index: 0;
        }
        .profile-container::after {
            content: '';
            position: absolute;
            bottom: -60px; right: -60px;
            width: 160px; height: 160px;
            background: radial-gradient(circle, #ff69b4 60%, #fff0fa 100%);
            opacity: 0.18;
            border-radius: 50%;
            z-index: 0;
        }
        .profile-img-empty {
            width: 110px;
            height: 110px;
            margin: 0 auto 18px auto;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            box-shadow: 0 2px 12px rgba(255,105,180,0.16);
            border: 5px solid #ffb6e6;
            background: #fff;
            position: relative;
            z-index: 1;
        }
        h2 {
            color: #ff69b4;
            margin-bottom: 30px;
            font-weight: 800;
            letter-spacing: 1.5px;
            font-size: 2.1rem;
            position: relative;
            z-index: 1;
        }
        table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0 10px;
            margin-bottom: 24px;
            position: relative;
            z-index: 1;
        }
        th, td {
            padding: 14px 12px;
            font-size: 17px;
        }
        th {
            background: linear-gradient(90deg, #ffb6e6 60%, #ffe0f7 100%);
            color: #fff;
            text-align: left;
            border-radius: 12px 0 0 12px;
            width: 40%;
            font-weight: 700;
            letter-spacing: 0.5px;
            box-shadow: 0 2px 8px rgba(255,182,230,0.10);
        }
        td {
            background: #fff;
            color: #e75480;
            border-radius: 0 12px 12px 0;
            font-weight: 600;
            box-shadow: 0 2px 8px rgba(255,182,230,0.06);
        }
        .profile-actions {
            margin-top: 18px;
            position: relative;
            z-index: 1;
        }
        .profile-actions a {
            display: inline-block;
            margin: 0 8px;
            padding: 12px 28px;
            background: linear-gradient(90deg, #ff69b4 60%, #e75480 100%);
            color: #fff;
            text-decoration: none;
            border-radius: 12px;
            font-size: 16px;
            font-weight: 700;
            box-shadow: 0 2px 12px rgba(255,105,180,0.10);
            border: none;
            cursor: pointer;
            transition: background 0.2s, transform 0.2s, box-shadow 0.2s;
        }
        .profile-actions a:hover {
            background: linear-gradient(90deg, #e75480 60%, #ff69b4 100%);
            transform: scale(1.07);
            box-shadow: 0 4px 18px rgba(255,105,180,0.18);
        }
        .profile-label {
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .profile-label .icon {
            font-size: 1.2em;
            color: #ff69b4;
        }
        @media (max-width: 600px) {
            .profile-container {
                padding: 18px 6vw 18px 6vw;
                max-width: 98vw;
            }
            h2 { font-size: 1.3rem; }
            th, td { font-size: 15px; padding: 10px 6px; }
        }
    </style>
</head>
<body>
    <div class="profile-container">
        <!-- Foto Profil Kosong SVG -->
        <div class="profile-img-empty">
            <svg width="100" height="100" viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg">
                <circle cx="50" cy="50" r="48" fill="#f6f8fa" stroke="#e0e0e0" stroke-width="4"/>
                <circle cx="50" cy="40" r="18" fill="#e0e0e0"/>
                <ellipse cx="50" cy="75" rx="26" ry="15" fill="#e0e0e0"/>
            </svg>
        </div>
        <h2>Profil Pengguna</h2>
        <table>
            <tr>
                <th>ID</th>
                <td><?php echo $data['id']; ?></td>
            </tr>
            <tr>
                <th>Username</th>
                <td><?php echo $data['username']; ?></td>
            </tr>
            <!-- Tambah kolom lain sesuai isi tabel users jika ingin -->
        </table>
        <div class="profile-actions">
            <a href="dashboard.php">Kembali ke Dashboard</a>
            <a href="logout.php">Logout</a>
        </div>
    </div>
</body>
</html>
