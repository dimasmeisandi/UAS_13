<?php
include '../koneksi.php';
session_start();
$role = $_SESSION['role'];

$status = isset($_GET['status']) ? $_GET['status'] : 'semua'; 
$sql = "SELECT p.*, s.nama_siswa, e.nama_eskul
        FROM pendaftaran_eskul p
        JOIN siswa s ON p.id_siswa = s.id_siswa
        JOIN eskul e ON p.id_eskul = e.id_eskul";
if ($status != 'semua') {
    $sql .= " WHERE p.status = '$status'";
}
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <title>Menu Admin Pendaftaran</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet" />
  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background-image: url('/Web-Ekstrakurikuler/smklogo.png');
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
<body class="min-h-screen p-6 sm:p-10 relative leading-relaxed">
  <div class="w-full max-w-[1500px] mx-auto px-4 sm:px-6 md:px-8">
    <h1 class="text-center text-[2.5em] text-white bg-[rgba(0,50,0,0.7)] py-6 px-4 rounded-lg shadow-md mb-10 font-bold animate-fadeIn">
      Data Pendaftaran Ekstrakurikuler
    </h1>

    <div class="bg-white p-6 sm:p-10 rounded-xl shadow-xl mb-10 animate-slideIn">
      <h2 class="text-xl font-semibold mb-4">
        <?= $role === 'admin' ? 'Menu Admin' : 'Menu Pembina dan Pelatih'; ?>
      </h2>
      <div class="flex flex-wrap justify-center gap-2 font-semibold">
        <a href="/Web-Ekstrakurikuler/panel_admin.php" class="bg-green-700 hover:bg-green-800 text-white px-5 py-2 rounded-full shadow transition hover:scale-105">Halaman Admin</a>
        <a href="admin_eskul.php" class="bg-green-700 hover:bg-green-800 text-white px-5 py-2 rounded-full shadow transition hover:scale-105">Data Ekskul</a>
        <?php if ($role === 'admin'): ?>
          <a href="admin_kelola.php" class="bg-green-700 hover:bg-green-800 text-white px-5 py-2 rounded-full shadow transition hover:scale-105">Kelola Admin</a>
        <?php endif; ?>
      </div>
    </div>

    <h3 class="text-xl text-[#90EE90] text-center mb-4 font-semibold animate-slideIn">Daftar Pendaftaran</h3>
    <div class="w-full overflow-x-auto animate-slideIn">
      <table class="w-full min-w-[850px] text-sm text-center bg-white shadow-md rounded-lg">
        <thead class="bg-green-700 text-white font-semibold">
          <tr>
            <th class="p-3">No</th>
            <th class="p-3">Nama Pendaftar</th>
            <th class="p-3">Ekskul</th>
            <th class="p-3">Tanggal</th>
            <th class="p-3">Status</th>
            <th class="p-3">Keterangan</th>
            <th class="p-3">Aksi</th>
          </tr>
        </thead>
        <tbody class="text-gray-800 font-normal divide-y">
          <?php if ($result->num_rows > 0): $no = 1; while ($row = $result->fetch_assoc()): ?>
            <tr class="hover:bg-green-50">
              <td class="p-3"><?= $no++; ?></td>
              <td class="p-3"><?= htmlspecialchars($row['nama_siswa']); ?></td>
              <td class="p-3"><?= htmlspecialchars($row['nama_eskul']); ?></td>
              <td class="p-3"><?= htmlspecialchars($row['tanggal_daftar']); ?></td>
              <td class="p-3"><?= htmlspecialchars($row['status']); ?></td>
              <td class="p-3"><?= htmlspecialchars($row['keterangan']); ?></td>
              <td class="p-3">
                <a href="edit_daftar.php?id=<?= $row['id_pendaftaran']; ?>" class="text-green-800 font-bold hover:underline">Edit</a> |
                <a href="hapus_daftar.php?id=<?= $row['id_pendaftaran']; ?>" class="text-green-800 font-bold hover:underline" onclick="return confirm('Yakin ingin menghapus?')">Hapus</a>
              </td>
            </tr>
          <?php endwhile; else: ?>
            <tr><td colspan="7" class="p-4 text-gray-500">Belum ada data pendaftar.</td></tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>

    <footer class="text-white text-center text-sm mt-28 py-6 animate-fadeIn">
      <hr class="border-white mb-3 w-full mx-auto opacity-40" />
      <p>&copy; <?= date('Y'); ?> SMKN 404 NOTFOUND. Hak Cipta Dilindungi.</p>
    </footer>
  </div>
</body>
</html>
