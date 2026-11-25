<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Login </title>
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
    <h2>Login</h2>
      <form action="cek_login.php" method="POST">
      <label>Username:</label>
      <input type="text" name="username" required>

      <label>Password:</label>
      <input type="password" name="password" required>

      <button type="submit">Login</button>
    </form>
    <p class="text-center">Belum punya akun? <a href="register.php">Daftar di sini</a></p>
   
  </div>
</body>

</html>


