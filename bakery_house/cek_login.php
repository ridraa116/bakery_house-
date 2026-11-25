<?php
session_start();
include 'konfigurasi/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    $role = $_POST['role'] ?? '';

    if ($role === 'seller') {
        $query = "SELECT * FROM seller WHERE username_seller='$username'";
    } else {
        $query = "SELECT * FROM customers WHERE username='$username'";
    }
    $result = mysqli_query($conn, $query);
    $data = mysqli_fetch_assoc($result);

    if ($data && password_verify($password, $data['password'])) {
        if ($role === 'seller') {
            $_SESSION['username'] = $data['username_seller'];
            header("Location: dashseller.php");
        } else {
            $_SESSION['username'] = $data['username'];
            header("Location: dashboard.php");
        }
        exit;
    } else {
        echo "Login gagal: Username atau password salah.";
    }
}
?>
