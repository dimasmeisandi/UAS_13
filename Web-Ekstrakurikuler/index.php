<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Beranda</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet" />
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    body {
      font-family: 'Poppins', sans-serif;
    }

    @keyframes slideDown {
      0% { opacity: 0; transform: translateY(-50px); }
      100% { opacity: 1; transform: translateY(0); }
    }

    /* dari kiri */
    @keyframes slideIn {
      0% { opacity: 0; transform: translateX(-50px); }
      100% { opacity: 1; transform: translateX(0); }
    }

    /* durasi animasi */
    .animate-slideDown {
      animation: slideDown 1s ease forwards;
    }

    .animate-slideIn {
      animation: slideIn 1s ease forwards;
    }
  </style>
</head>
<body class="relative min-h-screen text-slate-600 leading-relaxed p-2 z-[1]">
  <div class="fixed inset-0 bg-cover bg-center bg-no-repeat z-[-2]" style="background-image: url('smklogo.png');"></div>
  <div class="fixed inset-0 bg-[rgba(0,50,0,0.41)] z-[-1]"></div>

  <h1 class="text-center font-bold text-4xl md:text-5xl bg-green-900/70 text-white p-5 py-6 rounded-[10px] mb-8 animate-slideDown">
    Sistem Ekstrakurikuler SMKN 404 NOTFOUND
  </h1>

  <p class="flex justify-center flex-wrap gap-4 mb-10 animate-slideIn">
    <a href="siswa/login_siswa.php" class="text-white bg-green-700 hover:bg-green-800 px-6 py-3 rounded-full font-semibold shadow-md transition transform hover:scale-[1.05]">Login Siswa</a>
    <a href="admin/login_admin.php" class="text-white bg-green-700 hover:bg-green-800 px-6 py-3 rounded-full font-semibold shadow-md transition transform hover:scale-[1.05]">Login Admin</a>
  </p>

  <main class="max-w-[960px] mx-auto bg-white/90 p-10 rounded-2xl md animate-slideIn">
    <h3 class="text-green-800 text-xl font-bold mt-6">Hai, Warga SMKN 404 NOTFOUND!</h3>
    <p class="text-lg mt-3">Selamat datang di sistem pendaftaran ekstrakurikuler <b class="text-green-900">SMKN 404 NOTFOUND.</b></p>

    <h3 class="text-green-800 text-xl font-semibold mt-10">Kegunaan :</h3>
    <p class="text-justify text-lg mt-3">
      Website ini dirancang sebagai sistem informasi manajemen kegiatan ekstrakurikuler di lingkungan sekolah. Melalui platform ini, siswa dapat melihat daftar ekstrakurikuler yang tersedia dan presensi Ekskul yang telah didaftari, mengetahui detail seperti jadwal kegiatan, pembina, dan kuota, serta melakukan pendaftaran secara langsung secara online. Admin sekolah memiliki akses untuk mengelola data siswa, ekstrakurikuler, dan pendaftaran yang masuk. Dengan adanya sistem ini, proses administrasi kegiatan ekstrakurikuler menjadi lebih terstruktur, efisien, dan transparan, serta mendorong partisipasi aktif siswa dalam pengembangan bakat dan minat mereka di luar kegiatan akademik.
    </p>

    <footer class="mt-12 text-center">
      <hr class="my-6 border-black opacity-60" />
      <p>&copy; <?= date('Y'); ?>  SMKN 404 NOTFOUND. Hak Cipta Dilindungi.</p>

      <p class="font-semibold mt-4 text-green-600">Tentang Kami :</p>
      <div class="mt-3 flex justify-center items-center gap-5">
        <a href="https://instagram.com/" target="_blank" class="flex items-center text-gray-700 hover:text-green-700 transition">
          <img src="https://cdn-icons-png.flaticon.com/512/2111/2111463.png" alt="Instagram" class="w-6 h-6 mr-2"> @smkn404
        </a>
        <a href="https://github.com/" target="_blank" class="flex items-center text-gray-700 hover:text-green-700 transition">
          <img src="https://cdn-icons-png.flaticon.com/512/25/25231.png" alt="GitHub" class="w-6 h-6 mr-2"> @smk_404
        </a>
      </div>
    </footer>
  </main>
</body>
</html>
