<?php
session_start();
include '../koneksi.php';

if (!isset($_SESSION['nama_siswa'])) {
    header("Location: login_siswa.php");
    exit;
}

$id_siswa = $_SESSION['id_siswa'];
$nama_siswa = $_SESSION['nama_siswa'];

$query = "SELECT p.id_pendaftaran, e.nama_eskul, p.tanggal_daftar, p.keterangan, p.status 
          FROM pendaftaran_eskul p
          JOIN eskul e ON p.id_eskul = e.id_eskul
          WHERE p.id_siswa = '$id_siswa'";
$result = $conn->query($query);
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Daftar Pendaftaran Ekskul</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet" />
  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background-image: url('/Web-Ekstrakurikuler/smklogo.png');
      background-size: cover;
      background-position: center;
      background-repeat: no-repeat;
      position: relative;
    }
    body::after {
      content: "";
      position: fixed;
      inset: 0;
      background: rgba(0, 50, 0, 0.5);
      backdrop-filter: blur(4px) brightness(1);
      z-index: -1;
    }
    @keyframes fadeIn { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); }}
    @keyframes slideIn { from { opacity: 0; transform: translateX(-40px); } to { opacity: 1; transform: translateX(0); }}
    .animate-fadeIn { animation: fadeIn 1s ease-out forwards; }
    .animate-slideIn { animation: slideIn 1.2s ease-out forwards; }
  </style>
</head>
<body class="min-h-screen text-[#2c3e50] p-6 sm:p-10">

  <h1 class="text-3xl text-white font-bold text-center bg-[rgba(0,50,0,0.7)] py-6 px-4 rounded-lg shadow-md animate-fadeIn">
    Daftar Pendaftaran Ekstrakurikuler
  </h1>

  <nav class="mt-4 text-center animate-slideIn">
    <a href="/Web-Ekstrakurikuler/panel_siswa.php" class="inline-block m-2 px-6 py-2 rounded-full bg-green-700 text-white font-semibold shadow hover:bg-green-800 transition hover:scale-105">Beranda Siswa</a>
    <a href="logout_siswa.php" class="inline-block m-2 px-6 py-2 rounded-full bg-green-700 text-white font-semibold shadow hover:bg-green-800 transition hover:scale-105">Logout</a>
  </nav>

  <main class="max-w-[1300px] mx-auto  mt-10 p-6 sm:p-10 animate-slideIn overflow-x-auto">
    <h2 class="text-xl text-[#90EE90] font-semibold text-center mb-6">Data Pendaftaran Anda</h2>

    <?php if ($result->num_rows > 0): ?>
      <table class="min-w-full text-sm text-center bg-white  ">
        <thead class="bg-green-700 rounded text-white font-semibold">
          <tr>
            <th class="p-3">ID</th>
            <th class="p-3">Nama</th>
            <th class="p-3">Ekskul</th>
            <th class="p-3">Tanggal</th>
            <th class="p-3">Alasan</th>
            <th class="p-3">Status</th>
          </tr>
        </thead>
        <tbody class="text-gray-800 divide-y">
          <?php while ($row = $result->fetch_assoc()): ?>
          <tr class="hover:bg-green-50">
            <td class="p-3"><?= htmlspecialchars($row['id_pendaftaran']); ?></td>
            <td class="p-3"><?= htmlspecialchars($nama_siswa); ?></td>
            <td class="p-3"><?= htmlspecialchars($row['nama_eskul']); ?></td>
            <td class="p-3"><?= htmlspecialchars($row['tanggal_daftar']); ?></td>
            <td class="p-3"><?= htmlspecialchars($row['keterangan']); ?></td>
            <td class="p-3"><?= htmlspecialchars($row['status']); ?></td>
          </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    <?php else: ?>
      <p class="text-center text-gray-600 mt-6">Anda belum mendaftar ekstrakurikuler.</p>
    <?php endif; ?>
  </main>

  <div class="text-center mt-20 animate-fadeIn">
    <a href="daftar.php" class="text-green-200 font-bold hover:underline">Kembali</a>
  </div>

  <footer class="text-white text-center text-sm mt-40 py-6 animate-fadeIn">
    <hr class="border-white mb-3 w-2/3 mx-auto opacity-40" />
    <p>&copy; <?= date('Y'); ?> SMKN 404 NOTFOUND. Hak Cipta Dilindungi.</p>
  </footer>
</body>
</html>
