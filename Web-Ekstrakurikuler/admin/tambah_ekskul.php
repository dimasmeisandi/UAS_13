<?php
include '../koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama_eskul   = $conn->real_escape_string($_POST['nama_eskul']);
    $deskripsi    = $conn->real_escape_string($_POST['deskripsi']);
    $pembina      = $conn->real_escape_string($_POST['pembina']);
    $hari_kegiatan = $conn->real_escape_string($_POST['hari_kegiatan']);
    $jam_mulai    = $conn->real_escape_string($_POST['jam_mulai']);
    $jam_selesai  = $conn->real_escape_string($_POST['jam_selesai']); 
    $lokasi       = $conn->real_escape_string($_POST['lokasi']);
    $kuota        = $conn->real_escape_string($_POST['kuota']);

    $check_query = "SELECT * FROM eskul WHERE nama_eskul = '$nama_eskul'";
    $check_result = $conn->query($check_query);

    if ($check_result->num_rows > 0) {
        $error = "Mohon maaf, ekskul tersebut sudah ada!";
    } else {
        $sql = "INSERT INTO eskul(nama_eskul, deskripsi, pembina, hari_kegiatan, jam_mulai, jam_selesai, lokasi, kuota) 
                VALUES ('$nama_eskul', '$deskripsi', '$pembina', '$hari_kegiatan', '$jam_mulai', '$jam_selesai', '$lokasi', '$kuota')";

        if ($conn->query($sql) === TRUE) {
            $success = "Ekskul berhasil ditambahkan.";
        } else {
            $error = "Terjadi kesalahan: " . $conn->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <title>Form Tambah Ekstrakurikuler</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet"/>
  <style>
    body {
      font-family: 'Poppins', sans-serif;
    }
    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(20px); }
      to   { opacity: 1; transform: translateY(0); }
    }
    .animate-fadeIn {
      animation: fadeIn 0.8s ease-out forwards;
    }
  </style>
</head>
<body class="min-h-screen bg-gradient-to-r from-gray-100 to-cyan-100 px-4 py-10 text-[#2c3e50] animate-fadeIn">

  <h1 class="text-center text-3xl sm:text-4xl font-semibold mb-8">Form Tambah Ekstrakurikuler</h1>

  <div class="max-w-2xl mx-auto bg-white rounded-xl shadow-lg px-6 sm:px-10 py-8">
    <a href="admin_eskul.php" class="inline-block bg-green-700 text-white px-5 py-2 rounded-full hover:bg-green-800 transition mb-6">← Kembali</a>

    <?php if (isset($error)) echo "<div class='bg-red-100 text-red-700 font-semibold rounded-md p-4 mb-4'>$error</div>"; ?>
    <?php if (isset($success)) echo "<div class='bg-green-100 text-green-700 font-semibold rounded-md p-4 mb-4'>$success</div>"; ?>

    <form method="POST" class="grid gap-5 text-sm sm:text-base">
      <div>
        <label for="nama_eskul" class="block font-semibold mb-1">Nama Ekstrakurikuler:</label>
        <input type="text" id="nama_eskul" name="nama_eskul" required
          class="w-full px-4 py-2 border border-gray-300 rounded-md" />
      </div>

      <div>
        <label for="deskripsi" class="block font-semibold mb-1">Deskripsi:</label>
        <textarea id="deskripsi" name="deskripsi" rows="3" required
          class="w-full px-4 py-2 border border-gray-300 rounded-md resize-y"></textarea>
      </div>

      <div>
        <label for="pembina" class="block font-semibold mb-1">Pembina:</label>
        <input type="text" id="pembina" name="pembina" required
          class="w-full px-4 py-2 border border-gray-300 rounded-md" />
      </div>

      <div>
        <label for="hari_kegiatan" class="block font-semibold mb-1">Hari Kegiatan:</label>
        <input type="text" id="hari_kegiatan" name="hari_kegiatan" required
          class="w-full px-4 py-2 border border-gray-300 rounded-md" />
      </div>

      <div class="flex flex-wrap gap-4">
        <div class="flex-1 min-w-[150px]">
          <label for="jam_mulai" class="block font-semibold mb-1">Jam Mulai:</label>
          <input type="time" id="jam_mulai" name="jam_mulai" required
            class="w-full px-4 py-2 border border-gray-300 rounded-md" />
        </div>
        <div class="flex-1 min-w-[150px]">
          <label for="jam_selesai" class="block font-semibold mb-1">Jam Selesai:</label>
          <input type="time" id="jam_selesai" name="jam_selesai" required
            class="w-full px-4 py-2 border border-gray-300 rounded-md" />
        </div>
      </div>

      <div>
        <label for="lokasi" class="block font-semibold mb-1">Lokasi Kegiatan:</label>
        <textarea id="lokasi" name="lokasi" rows="2" required
          class="w-full px-4 py-2 border border-gray-300 rounded-md resize-y"></textarea>
      </div>

      <div>
        <label for="kuota" class="block font-semibold mb-1">Kuota:</label>
        <input type="number" id="kuota" name="kuota" required
          class="w-full px-4 py-2 border border-gray-300 rounded-md" />
      </div>

      <div class="text-right">
        <input type="submit" value="Kirim"
          class="bg-green-700 text-white font-semibold px-6 py-2 rounded-full hover:bg-green-800 transition cursor-pointer" />
      </div>
    </form>
  </div>

  <footer class="text-center text-sm text-gray-600 mt-12 pt-6">
    <hr class="w-2/3 mx-auto mb-3 border-gray-400 opacity-50" />
    <p>&copy; <?= date('Y'); ?> SMKN 404 NOTFOUND. Hak Cipta Dilindungi.</p>
  </footer>

</body>
</html>
