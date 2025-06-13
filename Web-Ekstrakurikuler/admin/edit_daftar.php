<?php
include '../koneksi.php';
session_start();

if (!in_array($_SESSION['role'], ['admin', 'pembina', 'pelatih'])) {
    echo "Akses ditolak.";
    exit();
}


if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $idPendaftaran = (int)$_GET['id'];

    $sql = "SELECT p.*, s.nama_siswa, e.nama_eskul 
            FROM pendaftaran_eskul p
            JOIN siswa s ON p.id_siswa = s.id_siswa
            JOIN eskul e ON p.id_eskul = e.id_eskul
            WHERE p.id_pendaftaran = $idPendaftaran";
    
    $result = $conn->query($sql);
    $pendaftaran = $result->fetch_assoc();

    if (!$pendaftaran) {
        die("Data tidak ditemukan.");
    }
} else {
    die("ID tidak valid.");
}

// Update status
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $statusBaru = $conn->real_escape_string($_POST['status']);

    $update = "UPDATE pendaftaran_eskul SET status = '$statusBaru' WHERE id_pendaftaran = $idPendaftaran";
    if ($conn->query($update)) {
        $successMessage = "Status berhasil diperbarui.";
        // Refresh data
        $pendaftaran['status'] = $statusBaru;
    } else {
        $errorMessage = "Gagal memperbarui status: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <title>Edit Status Pendaftaran</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet" />
  <style>
    body { font-family: 'Poppins', sans-serif; }
    @keyframes fadeIn { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); }}
    .animate-fadeIn { animation: fadeIn 0.8s ease-out forwards; }
  </style>
</head>
<body class="bg-gradient-to-r from-gray-100 to-cyan-100 text-[#2c3e50] p-6 sm:p-10 animate-fadeIn min-h-screen">

  <h2 class="text-center text-2xl sm:text-3xl font-semibold text-[#2c3e50] mb-8">Edit Status Pendaftaran Ekskul</h2>

  <?php if (isset($errorMessage)): ?>
    <div class="text-center font-semibold text-red-600 mb-4"><?= htmlspecialchars($errorMessage); ?></div>
  <?php endif; ?>

  <?php if (isset($successMessage)): ?>
    <div class="text-center font-semibold text-green-600 mb-4"><?= htmlspecialchars($successMessage); ?></div>
  <?php endif; ?>

  <form method="POST" class="bg-white max-w-2xl mx-auto p-6 sm:p-8 rounded-xl shadow-md space-y-5 text-[1.05em]">
    <div>
      <label class="font-semibold block mb-1">Nama Siswa:</label>
      <p><?= htmlspecialchars($pendaftaran['nama_siswa']); ?></p>
    </div>

    <div>
      <label class="font-semibold block mb-1">Ekskul:</label>
      <p><?= htmlspecialchars($pendaftaran['nama_eskul']); ?></p>
    </div>

    <div>
      <label class="font-semibold block mb-1">Tanggal Daftar:</label>
      <p><?= htmlspecialchars($pendaftaran['tanggal_daftar']); ?></p>
    </div>

    <div>
      <label class="font-semibold block mb-1">Keterangan:</label>
      <textarea readonly class="w-full max-w-md bg-gray-100 border border-gray-300 rounded-md px-4 py-2 resize-none"><?= htmlspecialchars($pendaftaran['keterangan']); ?></textarea>
    </div>

    <div>
      <label for="status" class="font-semibold block mb-1">Status:</label>
      <select name="status" required
        class="w-full max-w-md px-4 py-2 rounded-md border border-gray-300 focus:outline-none focus:ring-2 focus:ring-green-500">
        <option value="tunda" <?= $pendaftaran['status'] === 'tunda' ? 'selected' : ''; ?>>Tunda</option>
        <option value="Diterima" <?= $pendaftaran['status'] === 'Diterima' ? 'selected' : ''; ?>>Diterima</option>
        <option value="Ditolak" <?= $pendaftaran['status'] === 'Ditolak' ? 'selected' : ''; ?>>Ditolak</option>
      </select>
    </div>

    <button type="submit"
      class="bg-green-700 text-white font-semibold py-3 px-6 rounded-md hover:bg-green-800 transition block w-full sm:w-auto">
      Update Status
    </button>
  </form>

  <div class="text-center mt-6">
    <a href="admin_daftar.php" class="text-green-700 hover:underline font-medium">← Kembali ke Daftar Pendaftaran</a>
  </div>

  <footer class="text-center text-sm text-[#2c3e50] mt-12 pt-6 border-t border-gray-300">
    <p>&copy; <?= date('Y'); ?> SMKN 404 NOTFOUND. Hak Cipta Dilindungi.</p>
  </footer>
</body>
</html>
