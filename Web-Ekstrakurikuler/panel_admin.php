<?php
include 'koneksi.php';
session_start();

if (!isset($_SESSION['id_pengguna']) || !isset($_SESSION['username']) || !isset($_SESSION['role'])) {
    header("Location: admin/login_admin.php");
    exit();
}

$id_pengguna = $_SESSION['id_pengguna'];
$username = $_SESSION['username'];
$role = strtolower(trim($_SESSION['role']));

// query buat hitung jumlah siswa, eskul, dan pendaftaaran
$sql_total_siswa = "SELECT COUNT(*) AS total_siswa FROM siswa";
$sql_total_eskul = "SELECT COUNT(*) AS total_eskul FROM eskul";
$sql_pendaftaran_baru = "SELECT COUNT(*) AS pendaftaran_baru FROM pendaftaran_eskul WHERE YEAR(tanggal_daftar) = YEAR(CURRENT_DATE)";
$result_siswa = $conn->query($sql_total_siswa);
$result_eskul = $conn->query($sql_total_eskul);
$result_pendaftaran = $conn->query($sql_pendaftaran_baru);
// ambil query sebagai angka  
$total_siswa = $result_siswa->fetch_assoc()['total_siswa'];
$total_eskul = $result_eskul->fetch_assoc()['total_eskul'];
$pendaftaran_baru = $result_pendaftaran->fetch_assoc()['pendaftaran_baru'];

// mengambil 5 data pendaftar terbaru
$sql_pendaftaran_terbaru = "SELECT p.*, s.nama_siswa, e.nama_eskul 
FROM pendaftaran_eskul p
JOIN siswa s ON p.id_siswa = s.id_siswa
JOIN eskul e ON p.id_eskul = e.id_eskul
WHERE YEAR(p.tanggal_daftar) = YEAR(CURRENT_DATE)
ORDER BY p.tanggal_daftar DESC
LIMIT 5";
$pendaftaran_terbaru_result = $conn->query($sql_pendaftaran_terbaru);
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Halaman Admin</title>
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
<body class="min-h-screen p-6 sm:p-10">
  <div class="w-full max-w-[1300px] mx-auto px-4 sm:px-6 md:px-8">
    <h1 class="text-center text-[2.5em] text-white font-bold bg-[rgba(0,50,0,0.7)] py-6 px-4 rounded-lg shadow-md animate-fadeIn">
      <?= $role === 'admin' ? 'Halaman Admin' : 'Halaman Pembina dan Pelatih'; ?>
    </h1>

    <div class="bg-white mt-10 p-6 sm:p-10 rounded-xl shadow-xl animate-slideIn">
      <p class="text-lg mb-4">
        Selamat datang, <span class="text-green-700 font-semibold"><?= htmlspecialchars($username); ?></span>!
        <a href="admin/logout_admin.php" class="text-green-700 font-bold hover:underline ml-2">Logout</a>
      </p>

      <h2 class="text-2xl font-semibold mb-6"><?= $role === 'admin' ? 'Menu Admin' : 'Menu Pembina/Pelatih'; ?></h2>
      <div class="flex flex-wrap justify-center gap-3 font-semibold">
        <?php if ($role === 'admin'): ?>
          <a href="admin/admin_eskul.php" class="bg-green-700 text-white px-5 py-2 rounded-full shadow hover:bg-green-800 hover:scale-105 transition">Data Ekskul</a>
          <a href="admin/admin_daftar.php" class="bg-green-700 text-white px-5 py-2 rounded-full shadow hover:bg-green-800 hover:scale-105 transition">Kelola Pendaftaran</a>
          <a href="admin/admin_kelola.php" class="bg-green-700 text-white px-5 py-2 rounded-full shadow hover:bg-green-800 hover:scale-105 transition">Kelola Admin</a>
        <?php else: ?>
          <a href="admin/admin_eskul.php" class="bg-green-700 text-white px-5 py-2 rounded-full shadow hover:bg-green-800 hover:scale-105 transition">Data Ekskul</a>
          <a href="admin/admin_daftar.php" class="bg-green-700 text-white px-5 py-2 rounded-full shadow hover:bg-green-800 hover:scale-105 transition">Kelola Pendaftaran</a>
          
        <?php endif; ?>
      </div>
    </div>

    <?php if ($role === 'admin'): ?>
      <h3 class="text-xl text-[#90EE90] text-center mt-10 mb-4 font-semibold animate-slideIn">Statistik</h3>
      <div class="bg-white p-6 sm:p-10 rounded-xl shadow-xl animate-slideIn">
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 text-center text-lg font-semibold">
          <div class="bg-green-100 p-4 rounded shadow w-full"><?= $total_siswa; ?><div class="text-sm text-green-800">Total Siswa</div></div>
          <div class="bg-green-100 p-4 rounded shadow w-full"><?= $total_eskul; ?><div class="text-sm text-green-800">Total Ekskul</div></div>
          <div class="bg-green-100 p-4 rounded shadow w-full"><?= $pendaftaran_baru; ?><div class="text-sm text-green-800">Pendaftaran Baru</div></div>
        </div>
      </div>

      <h3 class="text-xl text-[#90EE90] text-center mt-10 mb-4 font-semibold animate-slideIn">Pendaftaran Terbaru</h3>
      <div class="w-full overflow-x-auto animate-slideIn">
        <table class="w-full min-w-[700px] text-sm text-center bg-white shadow-md ">
          <thead class="bg-green-700 text-white font-semibold">
            <tr>
              <th class="p-3">No</th>
              <th class="p-3">Nama Siswa</th>
              <th class="p-3">Ekskul</th>
              <th class="p-3">Tanggal</th>
              <th class="p-3">Status</th>
            </tr>
          </thead>
          <tbody class="divide-y text-gray-800 font-normal">
            <?php if ($pendaftaran_terbaru_result->num_rows > 0): $no = 1; while ($row = $pendaftaran_terbaru_result->fetch_assoc()): ?>
              <tr class="hover:bg-green-50">
                <td class="p-3"><?= $no++; ?></td>
                <td class="p-3"><?= htmlspecialchars($row['nama_siswa']); ?></td>
                <td class="p-3"><?= htmlspecialchars($row['nama_eskul']); ?></td>
                <td class="p-3"><?= htmlspecialchars($row['tanggal_daftar']); ?></td>
                <td class="p-3"><?= htmlspecialchars($row['status']); ?></td>
              </tr>
            <?php endwhile; else: ?>
              <tr><td colspan="5" class="p-4 text-gray-500">Belum ada pendaftaran terbaru.</td></tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    <?php endif; ?>

    <footer class="text-white text-center text-sm mt-20 py-6 animate-fadeIn">
      <hr class="border-white mb-3 w-full mx-auto opacity-40" />
      <p>&copy; <?= date('Y'); ?> SMKN 404 NOTFOUND. Hak Cipta Dilindungi.</p>
    </footer>
  </div>
</body>
</html>
