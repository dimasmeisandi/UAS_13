<?php
session_start();
include '../koneksi.php';

if (!isset($_SESSION['id_siswa'])) {
    header("Location: login_siswa.php");
    exit;
}

$id_siswa = $_SESSION['id_siswa'];
$nama_siswa = $_SESSION['nama_siswa'];
$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_pendaftaran = uniqid('id_');
    $id_eskul = $conn->real_escape_string($_POST['id_eskul']);
    $tanggal_daftar = $conn->real_escape_string($_POST['tanggal_daftar']);
    $status = 'tunda';
    $keterangan = $conn->real_escape_string($_POST['keterangan']);

    $cek_eskul = $conn->query("SELECT * FROM eskul WHERE id_eskul = '$id_eskul'");
    if ($cek_eskul->num_rows == 0) {
        $error = "Ekstrakurikuler tidak ditemukan!";
    } else {
        $insert_query = "INSERT INTO pendaftaran_eskul (id_pendaftaran, id_siswa, id_eskul, tanggal_daftar, status, keterangan)
                         VALUES ('$id_pendaftaran', '$id_siswa', '$id_eskul', '$tanggal_daftar', '$status', '$keterangan')";
        if ($conn->query($insert_query)) {
            $success = "Pendaftaran berhasil!";
        } else {
            $error = "Gagal mendaftar: " . $conn->error;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Form Pendaftaran Ekskul</title>
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
    .animate-fadeIn { animation: fadeIn 1s ease-out forwards; }
  </style>
</head>
<body class="min-h-screen flex flex-col items-center justify-start  p-6 sm:p-10">
  <h1 class="text-4xl  font-bold text-center text-white  py-6 px-4  mb-6 animate-fadeIn">
    Form Pendaftaran Ekstrakurikuler
  </h1>

  <p class="mb-4 text-[#90EE90] text-center animate-fadeIn">
    Mau ikut ekskul apa nih, <span class="font-semibold"><?= htmlspecialchars($nama_siswa); ?></span>?
  </p>

  <?php if ($error): ?>
    <p class="text-red-600 font-semibold text-center mb-3 animate-fadeIn"><?= $error; ?></p>
  <?php endif; ?>
  <?php if ($success): ?>
    <p class="text-green-600 font-semibold text-center mb-3 animate-fadeIn"><?= $success; ?></p>
  <?php endif; ?>

  <form method="post" action="" class="w-full max-w-xl bg-white p-6 sm:p-8 rounded-lg shadow-md animate-fadeIn">
    <div class="mb-4">
      <label for="id_eskul" class="block font-semibold mb-1">Pilih Ekstrakurikuler</label>
      <select id="id_eskul" name="id_eskul" required class="w-full px-3 py-2 border rounded">
        <option value="">Pilih Ekskul</option>
        <?php
        $eskul_result = $conn->query("SELECT id_eskul, nama_eskul FROM eskul");
        while ($eskul = $eskul_result->fetch_assoc()) {
            echo '<option value="' . $eskul['id_eskul'] . '">' . $eskul['nama_eskul'] . '</option>';
        }
        ?>
      </select>
    </div>

    <div class="mb-4">
      <label for="tanggal_daftar" class="block font-semibold mb-1">Tanggal Daftar</label>
      <input type="date" name="tanggal_daftar" required class="w-full px-3 py-2 border rounded">
    </div>

    <div class="mb-4">
      <label for="keterangan" class="block font-semibold mb-1">Alasan Mengikuti</label>
      <textarea name="keterangan" rows="3" required class="w-full px-3 py-2 border rounded"></textarea>
    </div>

    <input type="submit" value="Daftar" class="w-full bg-green-700 text-white font-semibold py-2 rounded hover:bg-green-800 transition">
  </form>

  <div class="text-center mt-6 animate-fadeIn">
    <a href="hasil_daftar.php" class="text-green-200 font-bold hover:underline">Lihat Status Pendaftaran</a><br>
    <a href="/Web-Ekstrakurikuler/panel_siswa.php" class="text-green-200  font-bold hover:underline mt-2 inline-block">Kembali</a>
  </div>

  <footer class="text-white text-center text-sm mt-12 py-6 animate-fadeIn">
    <hr class="border-white mb-3 w-2/3 mx-auto opacity-40" />
    <p>&copy; <?= date('Y'); ?> SMKN 404 NOTFOUND. Hak Cipta Dilindungi.</p>
  </footer>
</body>
</html>
