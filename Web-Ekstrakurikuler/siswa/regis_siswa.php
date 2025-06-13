<?php
include '../koneksi.php';
$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $nis            = $conn->real_escape_string($_POST['nis']);
  $nama_siswa     = $conn->real_escape_string($_POST['nama_siswa']);
  $kelas          = $conn->real_escape_string($_POST['kelas']);
  $jenis_kelamin  = $conn->real_escape_string($_POST['jenis_kelamin']);
  $tanggal_lahir  = $conn->real_escape_string($_POST['tanggal_lahir']);
  $alamat         = $conn->real_escape_string($_POST['alamat']);
  $no_telp        = $conn->real_escape_string($_POST['no_telp']);
  $email          = $conn->real_escape_string($_POST['email']);

  if (!preg_match('/^\d{1,11}$/', $nis)) {
    $error = "NIS hanya boleh angka dan maksimal 11 digit!";
  } elseif (!preg_match('/^[a-zA-Z\s]+$/', $nama_siswa)) {
    $error = "Nama hanya boleh huruf dan spasi!";
  } else {
    $check = $conn->query("SELECT * FROM siswa WHERE nis = '$nis'");
    if ($check->num_rows > 0) {
      $error = "NIS sudah terdaftar!";
    } else {
      $query = "INSERT INTO siswa(nis,nama_siswa,kelas,jenis_kelamin,tanggal_lahir,alamat,no_telp,email)
                VALUES('$nis','$nama_siswa','$kelas','$jenis_kelamin','$tanggal_lahir','$alamat','$no_telp','$email')";
      if ($conn->query($query)) {
        $success = "Pendaftaran berhasil! Silakan login.";
      } else {
        $error = "Pendaftaran gagal: " . $conn->error;
      }
    }
  }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <title>Registrasi Siswa</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet" />
  <style>
    body {
      font-family: 'Poppins', sans-serif;
    }
    @keyframes fadeIn {
      from {opacity: 0; transform: translateY(20px);}
      to   {opacity: 1; transform: translateY(0);}
    }
    .animate-fadeIn {
      animation: fadeIn 1s ease-out forwards;
    }
  </style>
</head>
<body class="relative min-h-screen bg-cover bg-center px-4 py-10 text-[#2c3e50] animate-fadeIn" style="background-image: url('/Web-Ekstrakurikuler/smklogo.png');">
  <div class="absolute inset-0 bg-[rgba(0,50,0,0.5)] backdrop-blur-sm -z-10"></div>

  <h1 class="text-3xl sm:text-4xl text-green-400 font-bold text-center mb-6">Form Registrasi Akun Siswa</h1>

  <div class="text-center mb-4">
    <a href="/Web-Ekstrakurikuler/index.php" class="text-green-300 font-bold hover:underline mr-4">← Beranda</a>
    <a href="login_siswa.php" class="text-green-300 font-bold hover:underline">Login</a>
  </div>

  <?php if ($error): ?>
    <p class="text-red-600 text-center font-semibold mb-4"><?= $error; ?></p>
  <?php endif; ?>
  <?php if ($success): ?>
    <p class="text-green-400 text-center font-semibold mb-4"><?= $success; ?></p>
  <?php endif; ?>

  <form method="post" class="bg-white rounded-xl shadow-lg max-w-xl mx-auto w-full p-6 sm:p-10 space-y-4">
    <div>
      <label for="nis" class="block font-semibold text-gray-700 mb-1">NIS</label>
      <input type="text" name="nis" id="nis" required class="w-full px-4 py-2 border rounded focus:ring-green-500" />
    </div>
    <div>
      <label for="nama_siswa" class="block font-semibold text-gray-700 mb-1">Nama Lengkap</label>
      <input type="text" name="nama_siswa" id="nama_siswa" required class="w-full px-4 py-2 border rounded focus:ring-green-500" />
    </div>
    <div>
      <label for="kelas" class="block font-semibold text-gray-700 mb-1">Kelas</label>
      <select name="kelas" id="kelas" required class="w-full px-4 py-2 border rounded focus:ring-green-500">
        <option value="">Pilih kelas kamu</option>
        <option>X RPL 1</option><option>X RPL 2</option>
        <option>X TKJ 1</option><option>X TKJ 2</option>
        <option>X KA 1</option><option>X KA 2</option><option>X KA 3</option><option>X KA 4</option><option>X KA 5</option>
      </select>
    </div>
    <div>
      <label for="jenis_kelamin" class="block font-semibold text-gray-700 mb-1">Jenis Kelamin</label>
      <select name="jenis_kelamin" id="jenis_kelamin" required class="w-full px-4 py-2 border rounded focus:ring-green-500">
        <option value="">Pilih jenis kelamin</option>
        <option value="L">Laki-laki</option>
        <option value="P">Perempuan</option>
      </select>
    </div>
    <div>
      <label for="tanggal_lahir" class="block font-semibold text-gray-700 mb-1">Tanggal Lahir</label>
      <input type="date" name="tanggal_lahir" id="tanggal_lahir" required class="w-full px-4 py-2 border rounded focus:ring-green-500" />
    </div>
    <div>
      <label for="alamat" class="block font-semibold text-gray-700 mb-1">Alamat</label>
      <textarea name="alamat" id="alamat" rows="3" required class="w-full px-4 py-2 border rounded focus:ring-green-500"></textarea>
    </div>
    <div>
      <label for="no_telp" class="block font-semibold text-gray-700 mb-1">No. HP</label>
      <input type="text" name="no_telp" id="no_telp" required class="w-full px-4 py-2 border rounded focus:ring-green-500" />
    </div>
    <div>
      <label for="email" class="block font-semibold text-gray-700 mb-1">Email</label>
      <input type="email" name="email" id="email" required class="w-full px-4 py-2 border rounded focus:ring-green-500" />
    </div>
    <button type="submit" class="w-full bg-green-700 hover:bg-green-800 text-white font-bold py-3 rounded transition">Daftar</button>
  </form>

  <footer class="text-green-300 text-sm text-center mt-10 animate-fadeIn">
    <hr class="border-green-300 mb-3 w-2/3 mx-auto opacity-40" />
    <p>&copy; <?= date('Y'); ?> RAFADITYA SYAHPUTRA. All rights reserved.</p>
  </footer>

  <script>
    document.querySelector("form").addEventListener("submit", function(e) {
      const nis = document.getElementById("nis").value.trim();
      const nama = document.getElementById("nama_siswa").value.trim();
      let error = "";

      if (!/^\d{1,11}$/.test(nis)) {
        error = "NIS hanya boleh angka dan maksimal 11 digit!";
      } else if (!/^[A-Za-z\\s]+$/.test(nama)) {
        error = "Nama hanya boleh huruf dan spasi!";
      }

      if (error) {
        e.preventDefault();
        alert(error);
      }
    });
  </script>
</body>
</html>
