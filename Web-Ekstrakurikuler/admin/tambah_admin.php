<?php
include '../koneksi.php';
session_start();

// Hanya admin yang bisa mengakses
if (!isset($_SESSION['id_pengguna']) || $_SESSION['role'] !== 'admin') {
    header("Location: login_admin.php");
    exit();
}

// Proses tambah admin
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $role = $_POST['role'];

    // Validasi role
    $allowed_roles = ['admin', 'pembina', 'pelatih'];
    if (!in_array($role, $allowed_roles)) {
        $error = "Role tidak valid.";
    } elseif (empty($username) || empty($password)) {
        $error = "Username dan password tidak boleh kosong.";
    } else {
        // Cek apakah username sudah digunakan
        $stmt = $conn->prepare("SELECT id_pengguna FROM pengguna WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $error = "Username sudah digunakan.";
        } else {
            $hashed = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("INSERT INTO pengguna (username, password, role) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $username, $hashed, $role);
            if ($stmt->execute()) {
                $success = "Akun admin berhasil ditambahkan.";
            } else {
                $error = "Gagal menambahkan admin: " . $stmt->error;
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Form Tambah Akun</title>
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
<body class="bg-gradient-to-r from-gray-100 to-cyan-100 min-h-screen px-4 py-10 text-[#2c3e50] animate-fadeIn">

  <h1 class="text-center text-3xl sm:text-4xl font-semibold mb-8">Form Tambah Akun</h1>

  <div class="max-w-2xl mx-auto bg-white rounded-xl shadow-lg px-6 sm:px-10 py-8">
    <a href="admin_kelola.php" class="inline-block bg-green-700 text-white px-5 py-2 rounded-full hover:bg-green-800 transition mb-6">← Kembali</a>

    <?php if (isset($error)) echo "<div class='bg-red-100 text-red-700 font-semibold rounded-md p-4 mb-4'>$error</div>"; ?>
    <?php if (isset($success)) echo "<div class='bg-green-100 text-green-700 font-semibold rounded-md p-4 mb-4'>$success</div>"; ?>

    <form method="POST">
      <table class="w-full text-sm sm:text-base">
        <tr>
          <td class="py-2 pr-4 font-semibold w-[35%]"><label for="username">Username:</label></td>
          <td class="py-2"><input type="text" id="username" name="username" required class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500"/></td>
        </tr>
        <tr>
          <td class="py-2 pr-4 font-semibold"><label for="password">Password:</label></td>
          <td class="py-2"><input type="password" id="password" name="password" required class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500"/></td>
        </tr>
        <tr>
          <td class="py-2 pr-4 font-semibold"><label for="role">Role:</label></td>
          <td class="py-2">
            <select id="role" name="role" required class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500">
              <option value="">Pilih Role</option>
              <option value="admin">Admin</option>
              <option value="pembina">Pembina</option>
              <option value="pelatih">Pelatih</option>
            </select>
          </td>
        </tr>
        <tr>
          <td></td>
          <td class="pt-4"><input type="submit" value="Kirim" class="bg-green-700 text-white font-semibold px-6 py-2 rounded-full hover:bg-green-800 transition cursor-pointer"/></td>
        </tr>
      </table>
    </form>
  </div>

  <footer class="text-center text-sm text-gray-600 mt-52 pt-6">
    <hr class="w-2/3 mx-auto mb-3 border-gray-400 opacity-50" />
    <p>&copy; <?= date('Y'); ?> SMKN 404 NOTFOUND. Hak Cipta Dilindungi.</p>
  </footer>

</body>
</html>
