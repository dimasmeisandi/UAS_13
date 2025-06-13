<?php
session_start();
include '../koneksi.php';

$error = '';

// Kalau sudah login, lempar ke panel
if (isset($_SESSION['id_siswa'])) {
   header("Location: /Web-Ekstrakurikuler/panel_siswa.php");
   exit;
}

// Proses login manual
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nis = $conn->real_escape_string($_POST['nis']);
    $nama_siswa = $conn->real_escape_string($_POST['nama_siswa']);

    if (!preg_match('/^\d{1,11}$/', $nis)) {
        $error = "NIS hanya boleh angka dan maksimal 11 digit!";
    } elseif (!preg_match('/^[a-zA-Z\s]+$/', $nama_siswa)) {
        $error = "Nama hanya boleh huruf dan spasi!";
    } else {
        $query = "SELECT * FROM siswa WHERE nis = '$nis'";
        $result = $conn->query($query);

        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            if (strtolower($row['nama_siswa']) === strtolower($nama_siswa)) {
                $_SESSION['id_siswa'] = $row['id_siswa'];
                $_SESSION['nama_siswa'] = $row['nama_siswa'];
                $_SESSION['nis'] = $row['nis'];

                header("Location: /Web-Ekstrakurikuler/panel_siswa.php");
                exit;
            } else {
                $error = "Nama tidak cocok dengan NIS!";
            }
        } else {
            $error = "NIS tidak ditemukan!";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Login Siswa</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet" />
  <style>
    body { font-family: 'Poppins', sans-serif; }
    @keyframes fadeIn { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
    .animate-fadeIn { animation: fadeIn 1s ease-out forwards; }
  </style>
</head>
<body class="relative flex flex-col items-center justify-center min-h-screen px-4 py-10 bg-cover bg-center text-[#2c3e50]" style="background-image: url('/Web-Ekstrakurikuler/smklogo.png');">
  <div class="absolute inset-0 bg-[rgba(0,50,0,0.5)] backdrop-blur-sm -z-10"></div>

  <h1 class="text-4xl font-semibold text-green-400 mb-6 animate-fadeIn text-center">Login Siswa</h1>

  <div class="text-center mb-4 animate-fadeIn">
    <a href="regis_siswa.php" class="text-green-300 font-bold hover:underline">Buat Akun</a>
  </div>

  <?php if ($error): ?>
    <p class="text-red-600 font-semibold text-sm mb-4 text-center animate-fadeIn"><?= $error; ?></p>
  <?php endif; ?>

  <form method="post" class="bg-white p-6 sm:p-8 rounded-xl shadow-lg w-full max-w-md animate-fadeIn">
    <div class="mb-4">
      <label for="nis" class="block text-gray-700 font-semibold mb-1">NIS</label>
      <input type="text" id="nis" name="nis" placeholder="Masukkan NIS kamu" required
        class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-green-500" />
    </div>
    <div class="mb-6">
      <label for="nama_siswa" class="block text-gray-700 font-semibold mb-1">Nama</label>
      <input type="text" id="nama_siswa" name="nama_siswa" placeholder="Masukkan nama kamu" required
        class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-green-500" />
    </div>
    <button type="submit" class="w-full bg-green-700 hover:bg-green-800 text-white font-bold py-2 rounded transition">Login</button>
  </form>

  <p class="mt-4 text-sm text-green-300 animate-fadeIn">
    <a href="/Web-Ekstrakurikuler/index.php" class="hover:underline font-bold">← Kembali</a>
  </p>

  <footer class="text-green-300 text-sm mt-10 text-center animate-fadeIn">
    <hr class="border-green-300 mb-2">
    <p>&copy; <?= date('Y'); ?> SMKN 404 NOTFOUND. Hak Cipta Dilindungi.</p>
  </footer>

  <script>
    document.querySelector("form").addEventListener("submit", function(e) {
      const nis = document.getElementById("nis").value.trim();
      const nama = document.getElementById("nama_siswa").value.trim();
      let error = "";

      if (!/^\d{1,11}$/.test(nis)) {
        error = "NIS hanya boleh angka dan maksimal 11 digit!";
      } else if (!/^[A-Za-z\s]+$/.test(nama)) {
        error = "Nama hanya boleh huruf dan spasi!";
      }

      if (error) {
        e.preventDefault();
        alert(error);
      }
    });
  </script>
</body>
</html>
