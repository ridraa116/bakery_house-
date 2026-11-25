<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Selamat Datang di BakeryHouse</title>
  <link rel="stylesheet" href="css/style2.css">
  <style>
    body {
      background: linear-gradient(120deg, #ffb6e6 0%, #ff69b4 100%);
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      margin: 0;
      padding: 0;
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
    }
    .container {
      background-color: #fff0fa;
      border-radius: 10px;
      box-shadow: 0 0 15px rgba(255, 105, 180, 0.18);
      padding: 32px 28px 28px 28px;
      max-width: 340px;
      text-align: center;
    }
    h2 {
      color: #ff69b4;
      font-weight: 700;
      margin-bottom: 24px;
      letter-spacing: 1px;
    }
    .btn-menu {
      display: block;
      width: 100%;
      margin: 16px 0;
      padding: 12px 0;
      background-color: #ff69b4;
      color: #fff;
      border: none;
      border-radius: 8px;
      font-size: 16px;
      font-weight: 600;
      cursor: pointer;
      text-decoration: none;
      box-shadow: 0 2px 8px rgba(255, 105, 180, 0.08);
      transition: background 0.2s, transform 0.2s;
    }
    .btn-menu:hover {
      background-color: #e75480;
      transform: scale(1.03);
    }
  </style>
</head>
<body>
  <div class="container">
    <img src="uploads/logo.jpg" alt="Logo TokoKu" style="width:90px;height:90px;object-fit:contain;margin-bottom:18px;">
    <h2>Selamat Datang di BakeryHouse</h2>
    <a href="register.php" class="btn-menu">Customers</a>
    <a href="regisseller.php" class="btn-menu">Seller</a>
  </div>
</body>
</html>