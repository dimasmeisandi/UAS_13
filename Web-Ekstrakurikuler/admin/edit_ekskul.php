<?php
include '../koneksi.php';

if (isset($_GET['id'])) {
    $id = $conn->real_escape_string($_GET['id']);
    $query = "SELECT * FROM eskul WHERE id_eskul = '$id'";
    $result = $conn->query($query);

    if ($result->num_rows == 1) {
        $eskul = $result->fetch_assoc();
    } else {
        die("Eskul tidak ditemukan.");
    }
} else {
    die("ID tidak valid.");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama_eskul    = $conn->real_escape_string($_POST['nama_eskul']);
    $deskripsi     = $conn->real_escape_string($_POST['deskripsi']);
    $pembina       = $conn->real_escape_string($_POST['pembina']);
    $hari_kegiatan = $conn->real_escape_string($_POST['hari_kegiatan']);
    $jam_mulai     = $conn->real_escape_string($_POST['jam_mulai']);
    $jam_selesai   = $conn->real_escape_string($_POST['jam_selesai']);
    $lokasi        = $conn->real_escape_string($_POST['lokasi']);
    $kuota         = $conn->real_escape_string($_POST['kuota']);

    $update = "UPDATE eskul SET 
        nama_eskul='$nama_eskul',
        deskripsi='$deskripsi',
        pembina='$pembina',
        hari_kegiatan='$hari_kegiatan',
        jam_mulai='$jam_mulai',
        jam_selesai='$jam_selesai',
        lokasi='$lokasi',
        kuota='$kuota'
        WHERE id_eskul='$id'";

    if ($conn->query($update)) {
        $success = "Data ekstrakurikuler berhasil diperbarui.";
        $eskul = $conn->query("SELECT * FROM eskul WHERE id_eskul = '$id'")->fetch_assoc();
    } else {
        $error = "Gagal memperbarui data: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <title>Edit Ekstrakurikuler</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet" />
  <style>
    body { font-family: 'Poppins', sans-serif; }
    @keyframes fadeIn { from {opacity: 0; transform: translateY(20px);} to {opacity: 1; transform: translateY(0);} }
    .animate-fadeIn { animation: fadeIn 0.8s ease-out forwards; }
  </style>
</head>
<body class="bg-gradient-to-r from-gray-100 to-cyan-100 py-10 px-4 animate-fadeIn min-h-screen">
  <div class="max-w-[700px] mx-auto bg-white rounded-xl shadow-[0_4px_12px_rgba(0,0,0,0.2)] p-6 sm:p-8">
    <h2 class="text-2xl text-[#2c3e50] font-semibold text-center mb-6">Edit Data Ekstrakurikuler</h2>

    <?php if (isset($success)) echo "<p class='text-green-600 font-semibold mb-4'>$success</p>"; ?>
    <?php if (isset($error)) echo "<p class='text-red-600 font-semibold mb-4'>$error</p>"; ?>

    <form method="POST" class="space-y-4">
      <div>
        <label for="nama_eskul" class="block font-semibold">Nama Ekstrakurikuler:</label>
        <input type="text" name="nama_eskul" id="nama_eskul" required
          value="<?= htmlspecialchars($eskul['nama_eskul']); ?>"
          class="w-full mt-1 p-3 border border-gray-300 rounded-md" />
      </div>

      <div>
        <label for="deskripsi" class="block font-semibold">Deskripsi:</label>
        <textarea name="deskripsi" id="deskripsi" rows="3"
          class="w-full mt-1 p-3 border border-gray-300 rounded-md resize-y"><?= htmlspecialchars($eskul['deskripsi']); ?></textarea>
      </div>

      <div>
        <label for="pembina" class="block font-semibold">Pembina:</label>
        <input type="text" name="pembina" id="pembina" required
          value="<?= htmlspecialchars($eskul['pembina']); ?>"
          class="w-full mt-1 p-3 border border-gray-300 rounded-md" />
      </div>

      <div>
        <label for="hari_kegiatan" class="block font-semibold">Hari Kegiatan:</label>
        <input type="text" name="hari_kegiatan" id="hari_kegiatan" required
          value="<?= htmlspecialchars($eskul['hari_kegiatan']); ?>"
          class="w-full mt-1 p-3 border border-gray-300 rounded-md" />
      </div>

      <div class="flex flex-wrap gap-4">
        <div class="flex-1 min-w-[150px]">
          <label for="jam_mulai" class="block font-semibold">Jam Mulai:</label>
          <input type="time" name="jam_mulai" id="jam_mulai"
            value="<?= htmlspecialchars($eskul['jam_mulai']); ?>"
            class="w-full mt-1 p-3 border border-gray-300 rounded-md" />
        </div>
        <div class="flex-1 min-w-[150px]">
          <label for="jam_selesai" class="block font-semibold">Jam Selesai:</label>
          <input type="time" name="jam_selesai" id="jam_selesai"
            value="<?= htmlspecialchars($eskul['jam_selesai']); ?>"
            class="w-full mt-1 p-3 border border-gray-300 rounded-md" />
        </div>
      </div>

      <div>
        <label for="lokasi" class="block font-semibold">Lokasi:</label>
        <textarea name="lokasi" id="lokasi" rows="2"
          class="w-full mt-1 p-3 border border-gray-300 rounded-md resize-y"><?= htmlspecialchars($eskul['lokasi']); ?></textarea>
      </div>

      <div>
        <label for="kuota" class="block font-semibold">Kuota:</label>
        <input type="number" name="kuota" id="kuota" required
          value="<?= htmlspecialchars($eskul['kuota']); ?>"
          class="w-full mt-1 p-3 border border-gray-300 rounded-md" />
      </div>

      <button type="submit"
        class="mt-4 w-full bg-green-700 text-white font-bold py-3 px-6 rounded-md hover:bg-green-800 transition">
        Update
      </button>
    </form>

    <div class="mt-6 text-center">
      <a href="admin_eskul.php" class="text-green-700 hover:underline font-medium">← Kembali ke Daftar Ekskul</a>
    </div>
  </div>

  <footer class="text-center text-sm text-gray-600 mt-12 pt-6">
    <hr class="mb-3 w-2/3 mx-auto opacity-40" />
    <p>&copy; <?= date('Y'); ?> SMKN 404 NOT FOUND. Hak Cipta Dilindungi.</p>
  </footer>
</body>
</html>
