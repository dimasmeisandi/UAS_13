<?php
session_start();
include '../koneksi.php'; 

$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    $sql = "SELECT * FROM pengguna WHERE username = '$username'";
    $result = $conn->query($sql); 

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            $_SESSION['id_pengguna'] = $row['id_pengguna'];
            $_SESSION['username'] = $row['username'];
            $_SESSION['role'] = $row['role'];

            header("Location: /Web-Ekstrakurikuler/panel_admin.php");
            exit();
        } else {
            $error = "Password salah!";
        }
    } else {
        $error = "Akun tidak ditemukan!";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Login Admin</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet" />
  <style>
    body { font-family: 'Poppins', sans-serif; }
    @keyframes fadeIn { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); }}
    .animate-fadeIn { animation: fadeIn 1s ease-out forwards; }
  </style>
</head>
<body class="relative flex flex-col items-center justify-center min-h-screen px-4 py-10 bg-cover bg-center text-[#2c3e50]" style="background-image: url('/Web-Ekstrakurikuler/smklogo.png');">
  <div class="absolute inset-0 bg-[rgba(0,50,0,0.5)] backdrop-blur-sm -z-10"></div>

  <h1 class="text-4xl font-semibold text-green-400 mb-6 animate-fadeIn text-center">Login Admin</h1>

  <?php if ($error): ?>
    <p class="text-red-600 font-semibold text-sm mb-4 text-center animate-fadeIn"><?= $error; ?></p>
  <?php endif; ?>

  <form method="post" action="" class="bg-white p-6 sm:p-8 rounded-xl shadow-lg w-full max-w-md animate-fadeIn">
    <div class="mb-4">
      <label for="username" class="block text-gray-700 font-semibold mb-1">Username</label>
      <input type="text" id="username" name="username" placeholder="Masukkan username" required
        class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-green-500" />
    </div>
    <div class="mb-6">
      <label for="password" class="block text-gray-700 font-semibold mb-1">Password</label>
      <input type="password" id="password" name="password" placeholder="Masukkan password" required
        class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-green-500" />
    </div>
    <button type="submit" class="w-full bg-green-700 hover:bg-green-800 text-white font-bold py-2 rounded transition">Login</button>
  </form>

  <p class="mt-4 text-sm text-green-300 animate-fadeIn">
    <a href="/Web-Ekstrakurikuler/index.php" class="hover:underline font-bold">← Kembali</a>
  </p>

  <footer class="text-green-300 text-sm mt-10 text-center animate-fadeIn">
    <hr class="border-green-300 mb-2">
    <p>&copy; <?= date('Y');?> SMKN 404 NOTFOUND. Hak Cipta Dilindungi.</p>
  </footer>
</body>
</html>
