<?php
include '../koneksi.php';
session_start();
if (!isset($_SESSION['id_pengguna']) || $_SESSION['role'] !== 'admin') {
    header("Location: login_admin.php");
    exit();
}
$sql_admin = "SELECT * FROM pengguna WHERE role IN ('admin', 'pembina', 'pelatih')";
$result = $conn->query($sql_admin);
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Kelola Admin</title>
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
    @keyframes fadeIn { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); }}
    @keyframes slideIn { from { opacity: 0; transform: translateX(-50px); } to { opacity: 1; transform: translateX(0); }}
    .animate-fadeIn { animation: fadeIn 1s ease-out forwards; }
    .animate-slideIn { animation: slideIn 1.2s ease-out forwards; }
  </style>
</head>
<body class="min-h-screen p-6 sm:p-10">
  <div class="w-full max-w-[1300px] mx-auto px-4 sm:px-6 md:px-8">
    <h1 class="text-center text-[2.5em] text-white font-bold bg-[rgba(0,50,0,0.7)] py-6 px-4 rounded-lg shadow-md mb-10 animate-fadeIn">
      Kelola Akun Admin
    </h1>

    <div class="bg-white p-6 sm:p-10 rounded-xl shadow-xl animate-slideIn mb-10">
      <h2 class="text-xl font-semibold mb-4">Menu Admin</h2>
      <div class="flex flex-wrap justify-center gap-3 font-semibold">
        <a href="/Web-Ekstrakurikuler/panel_admin.php" class="bg-green-700 text-white px-5 py-2 rounded-full shadow hover:bg-green-800 hover:scale-105 transition">Halaman Admin</a>
        <a href="admin_eskul.php" class="bg-green-700 text-white px-5 py-2 rounded-full shadow hover:bg-green-800 hover:scale-105 transition">Data Ekskul</a>
        <a href="admin_daftar.php" class="bg-green-700 text-white px-5 py-2 rounded-full shadow hover:bg-green-800 hover:scale-105 transition">Kelola Pendaftaran</a>
      </div>
    </div>

    <h3 class="text-xl text-[#90EE90] text-center font-semibold mb-4 animate-slideIn">Daftar Admin</h3>
    <div class="w-full overflow-x-auto animate-slideIn">
      <table class="w-full min-w-[700px] text-sm text-center bg-white shadow-md rounded-lg">
        <thead class="bg-green-700 text-white font-semibold">
          <tr>
            <th class="p-3">No</th>
            <th class="p-3">Username</th>
            <th class="p-3">Role</th>
            <th class="p-3">Aksi</th>
          </tr>
        </thead>
        <tbody class="text-gray-800 font-normal divide-y">
          <?php if ($result->num_rows > 0): $no = 1; while ($row = $result->fetch_assoc()): ?>
          <tr class="hover:bg-green-50">
            <td class="p-3"><?= $no++; ?></td>
            <td class="p-3"><?= htmlspecialchars($row['username']); ?></td>
            <td class="p-3 capitalize"><?= htmlspecialchars($row['role']); ?></td>
            <td class="p-3">
              <a href="edit_admin.php?id=<?= $row['id_pengguna']; ?>" class="text-green-800 font-bold hover:underline">Edit</a> |
              <a href="hapus_admin.php?id=<?= $row['id_pengguna']; ?>" class="text-green-800 font-bold hover:underline" onclick="return confirm('Yakin ingin menghapus akun ini?')">Hapus</a>
            </td>
          </tr>
          <?php endwhile; else: ?>
          <tr><td colspan="4" class="p-4 text-gray-500">Belum ada akun admin terdaftar.</td></tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>

    <div class="text-center mt-8 animate-slideIn">
      <a href="tambah_admin.php" class="bg-green-700 text-white px-6 py-2 rounded-full font-semibold shadow hover:bg-green-800 hover:scale-105 transition inline-block">Tambah Akun Baru</a>
    </div>

    <footer class="text-white text-center text-sm mt-20 py-6 animate-fadeIn">
      <hr class="border-white mb-3 w-full mx-auto opacity-40">
      <p>&copy; <?= date('Y'); ?> SMKN 404 NOTFOUND. Hak Cipta Dilindungi.</p>
    </footer>
  </div>
</body>
</html>
