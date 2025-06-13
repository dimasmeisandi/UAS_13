<?php
include 'koneksi.php';
session_start();

if (!isset($_SESSION['id_siswa'])) {
    header("Location: login_siswa.php");
    exit;
}

$id_siswa = $_SESSION['id_siswa'];
$nis = $_SESSION['nis'];
$nama_siswa = $_SESSION['nama_siswa'];

$query = "SELECT p.id_eskul, e.nama_eskul, p.hari_kegiatan, p.jam_mulai, p.jam_selesai
          FROM eskul p
          JOIN eskul e ON p.id_eskul = e.id_eskul";
$result = $conn->query($query);
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <title>Halaman Siswa</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet" />
  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background-image: url('smklogo.png');
      background-size: cover;
      background-position: center;
      background-repeat: no-repeat;
      color: #2c3e50;
    }
    body::after {
      content: "";
      position: fixed;
      inset: 0;
      background: rgba(0, 50, 0, 0.5);
      backdrop-filter: blur(4px) brightness(1);
      z-index: -1;
    }
    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(20px); }
      to   { opacity: 1; transform: translateY(0); }
    }
    @keyframes slideIn {
      from { opacity: 0; transform: translateX(-50px); }
      to   { opacity: 1; transform: translateX(0); }
    }
    .animate-fadeIn { animation: fadeIn 1s ease-out forwards; }
    .animate-slideIn { animation: slideIn 1.2s ease-out forwards; }
  </style>
</head>
<body class="min-h-screen p-8 relative">

  <h1 class="text-center text-[2.5em] text-white bg-[rgba(0,50,0,0.7)] py-6 px-4 rounded-lg shadow-md mb-10 animate-fadeIn font-bold">
    Halaman Siswa
  </h1>

  <div class="max-w-[1300px] mx-auto bg-white text-[#2c3e50] p-6 sm:p-10 rounded-xl shadow-xl mb-10 animate-slideIn">
    <p class="text-lg mb-4">
      Selamat datang, <span class="font-semibold text-green-700"><?= htmlspecialchars($nama_siswa); ?></span>!
      <a href="siswa/logout_siswa.php" class="text-green-600 font-bold hover:underline ml-2">Logout</a>
    </p>
    <h2 class="text-2xl font-semibold mb-4">Sekarang, Mau ngapain Nih?</h2>
    <div class="flex flex-wrap justify-center gap-2 font-semibold">
      <a href="siswa/daftar.php" class="bg-green-700 hover:bg-green-800 text-white px-5 py-2 rounded-full shadow transition hover:scale-105">Form Pendaftaran Ekskul</a>
      <a href="siswa/hasil_daftar.php" class="bg-green-700 hover:bg-green-800 text-white px-5 py-2 rounded-full shadow transition hover:scale-105">Hasil Pendaftaran</a>
    </div>
  </div>

  <h3 class="text-xl text-[#90EE90] text-center mb-4 font-semibold animate-slideIn">Jadwal Ekskul</h3>
  <div class="w-full overflow-x-auto animate-slideIn">
    <table class="w-[1300px] mx-auto min-w-[700px] text-sm text-center bg-white shadow-md  text-[#2c3e50]">
      <thead class="bg-green-700 text-white font-semibold">
        <tr>
          <th class="p-3">No</th>
          <th class="p-3">Ekstrakurikuler</th>
          <th class="p-3">Hari Kegiatan</th>
          <th class="p-3">Jam Mulai</th>
          <th class="p-3">Jam Selesai</th>
        </tr>
      </thead>
      <tbody class="divide-y divide-gray-200">
        <?php if ($result && $result->num_rows > 0): $no = 1; while ($row = $result->fetch_assoc()): ?>
          <tr class="hover:bg-green-50">
            <td class="p-3"><?= $no++; ?></td>
            <td class="p-3"><?= htmlspecialchars($row['nama_eskul']); ?></td>
            <td class="p-3"><?= htmlspecialchars($row['hari_kegiatan']); ?></td>
            <td class="p-3"><?= htmlspecialchars($row['jam_mulai']); ?></td>
            <td class="p-3"><?= htmlspecialchars($row['jam_selesai']); ?></td>
          </tr>
        <?php endwhile; else: ?>
          <tr><td colspan="5" class="p-4 text-center text-gray-500">Belum ada jadwal Ekskul terbaru.</td></tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>

  <footer class="text-white text-center text-sm mt-24 py-6 animate-fadeIn">
    <hr class="border-white mb-3 w-2/3 mx-auto opacity-40" />
    <p>&copy; <?= date('Y'); ?> SMKN 404 NOTFOUND. Hak Cipta Dilindungi.</p>
  </footer>
</body>
</html>
