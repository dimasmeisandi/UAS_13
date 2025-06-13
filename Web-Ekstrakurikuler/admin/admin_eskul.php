<?php
include '../koneksi.php';
session_start();

$role = $_SESSION['role'];

$query = "SELECT * FROM eskul";
$result = $conn->query($query);
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <title>Menu Admin Ekskul</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet" />
  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background-image: url('/WEb-Ekstrakurikuler/smklogo.png');
      background-size: cover;
      background-position: center;
      background-repeat: no-repeat;
    }
    body::before {
      content: '';
      position: fixed;
      inset: 0;
      background-color: rgba(0,50,0,0.5);
      z-index: -1;
      backdrop-filter: blur(4px) brightness(1);
    }
    @keyframes fadeIn { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); }}
    @keyframes slideIn { from { opacity: 0; transform: translateX(-50px); } to { opacity: 1; transform: translateX(0); }}
    .animate-fadeIn { animation: fadeIn 1s ease-out forwards; }
    .animate-slideIn { animation: slideIn 1.4s ease-out forwards; }
  </style>
</head>
<body class="relative min-h-screen p-6 sm:p-10 text-[#2c3e50] ">
  <h1 class=" w-full max-w-[1300px] mx-auto text-center text-[2.5em] text-white bg-[rgba(0,50,0,0.7)] py-6 px-4 rounded-lg shadow-md mb-10 animate-fadeIn font-bold">
    Data Ekstrakurikuler
  </h1>

  <div class="w-full max-w-[1300px] mx-auto px-4 sm:px-6 md:px-8 bg-white p-6 sm:p-10 rounded-xl shadow-xl mb-10 animate-slideIn">
    <h2 class="text-xl font-semibold mb-4">
      <?= in_array($role, ['admin']) ? 'Menu Admin' : 'Menu Pembina dan Pelatih'; ?>
    </h2>

    <div class="flex flex-wrap justify-center gap-2 font-semibold mb-4">
      <a href="/Web-Ekstrakurikuler/panel_admin.php" class="bg-green-700 text-white px-5 py-2 rounded-full shadow hover:bg-green-800 hover:scale-105 transition">Halaman Admin</a>
      <a href="admin_daftar.php" class="bg-green-700 text-white px-5 py-2 rounded-full shadow hover:bg-green-800 hover:scale-105 transition">Kelola Pendaftaran</a>
      <?php if ($role === 'admin'): ?>
        <a href="admin_kelola.php" class="bg-green-700 text-white px-5 py-2 rounded-full shadow hover:bg-green-800 hover:scale-105 transition">Kelola Admin</a>
      <?php endif; ?>
    </div>
  </div>

  <h3 class="text-xl text-[#90EE90] text-center mb-4 font-semibold animate-slideIn">Daftar Ekstrakurikuler</h3>
  <div class="w-full max-w-[1350px] mx-auto px-4 sm:px-6 md:px-8 overflow-x-auto animate-slideIn">
    <table class="w-full min-w-[700px] text-sm text-center bg-white shadow-md">
      <thead class="bg-green-700 text-white font-semibold">
        <tr>
          <th class="p-3">No</th>
          <th class="p-3">Nama Ekskul</th>
          <th class="p-3">Pembina</th>
          <th class="p-3">Jadwal</th>
          <th class="p-3">Kuota</th>
          <th class="p-3">Aksi</th>
        </tr>
      </thead>
      <tbody class="text-gray-800 font-normal divide-y">
        <?php $no = 1; if ($result->num_rows > 0): while ($row = $result->fetch_assoc()): ?>
        <tr class="hover:bg-green-50">
          <td class="p-3"><?= $no++; ?></td>
          <td class="p-3"><?= htmlspecialchars($row['nama_eskul']); ?></td>
          <td class="p-3"><?= htmlspecialchars($row['pembina']); ?></td>
          <td class="p-3"><?= htmlspecialchars($row['hari_kegiatan']) . ', ' . $row['jam_mulai'] . ' - ' . $row['jam_selesai']; ?></td>
          <td class="p-3"><?= $row['kuota']; ?></td>
          <td class="p-3">
            <a href="edit_ekskul.php?id=<?= $row['id_eskul']; ?>" class="text-green-800 font-bold hover:underline">Edit</a> |
            <a href="hapus_ekskul.php?id=<?= $row['id_eskul']; ?>" class="text-green-800 font-bold hover:underline" onclick="return confirm('Yakin ingin menghapus?')">Hapus</a>
          </td>
        </tr>
        <?php endwhile; else: ?>
        <tr><td colspan="6" class="p-4 text-gray-500">Belum ada data ekskul.</td></tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>

  <div class="text-center mt-8 animate-slideIn">
    <a href="tambah_ekskul.php" class="bg-green-700 text-white px-6 py-2 rounded-full font-semibold shadow hover:bg-green-800 hover:scale-105 transition inline-block">Tambah Ekskul Baru</a>
  </div>

  <footer class="text-white text-center text-sm mt-20 py-6 animate-fadeIn">
    <hr class="border-white mb-3 w-2/3 mx-auto opacity-40">
    <p>&copy; <?= date('Y'); ?> SMKN 404 NOTFOUND. Hak Cipta Dilindungi.</p>
  </footer>
</body>
</html>
