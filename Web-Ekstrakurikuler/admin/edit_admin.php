<?php
include '../koneksi.php';
session_start();

// Cek login dan role
if (!isset($_SESSION['id_pengguna']) || $_SESSION['role'] !== 'admin') {
    header("Location: login_admin.php");
    exit();
}

// Cek ID pengguna dari URL
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "ID tidak ditemukan atau tidak valid!";
    exit();
}

$id = (int) $_GET['id'];

// Ambil data pengguna
$stmt = $conn->prepare("SELECT * FROM pengguna WHERE id_pengguna = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows !== 1) {
    echo "Data tidak ditemukan!";
    exit();
}

$row = $result->fetch_assoc();

// Tangani jika form disubmit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $role = $_POST['role'];

    // Validasi role
    $allowed_roles = ['admin', 'pembina', 'pelatih'];
    if (!in_array($role, $allowed_roles)) {
        echo "Role tidak valid!";
        exit();
    }

    if (!empty($password)) {
        $hashed = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("UPDATE pengguna SET username = ?, password = ?, role = ? WHERE id_pengguna = ?");
        $stmt->bind_param("sssi", $username, $hashed, $role, $id);
    } else {
        $stmt = $conn->prepare("UPDATE pengguna SET username = ?, role = ? WHERE id_pengguna = ?");
        $stmt->bind_param("ssi", $username, $role, $id);
    }

    if ($stmt->execute()) {
        echo "<script>alert('Data berhasil diupdate'); window.location='admin_kelola.php';</script>";
        exit();
    } else {
        echo "Gagal mengupdate data: " . $stmt->error;
    }
}
?>

<<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <title>Edit Admin</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet" />
  <style>
    body { font-family: 'Poppins', sans-serif; }
    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(20px); }
      to { opacity: 1; transform: translateY(0); }
    }
    .animate-fadeIn {
      animation: fadeIn 1s ease-out forwards;
    }
  </style>
</head>
<body class="bg-gray-100 py-10 px-4 min-h-screen animate-fadeIn">
  <div class="bg-white max-w-3xl mx-auto px-6 sm:px-10 py-10 rounded-2xl shadow-[0_10px_25px_rgba(0,0,0,0.15)]">
    <h2 class="text-3xl font-semibold text-center text-green-700 mb-8">Edit Akun Admin</h2>

    <form method="POST" class="space-y-6 text-base sm:text-lg">
      <div>
        <label for="username" class="block text-[1.2em] mb-2 font-medium">Username:</label>
        <input type="text" name="username" id="username" value="<?= htmlspecialchars($row['username']) ?>" required
          class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-green-500 transition" />
      </div>

      <div>
        <label for="password" class="block text-[1.2em] mb-2 font-medium">Password (biarkan kosong jika tidak ingin diubah):</label>
        <input type="password" name="password" id="password" placeholder="******"
          class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-green-500 transition" />
      </div>

      <div>
        <label for="role" class="block text-[1.2em] mb-2 font-medium">Role:</label>
        <select name="role" id="role" required
          class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-green-500 transition">
          <option value="admin" <?= $row['role'] === 'admin' ? 'selected' : '' ?>>Admin</option>
          <option value="pembina" <?= $row['role'] === 'pembina' ? 'selected' : '' ?>>Pembina</option>
          <option value="pelatih" <?= $row['role'] === 'pelatih' ? 'selected' : '' ?>>Pelatih</option>
        </select>
      </div>

      <button type="submit"
        class="w-full bg-green-700 text-white font-semibold py-4 rounded-lg hover:bg-green-800 transition text-[1.2em]">
        Simpan Perubahan
      </button>
    </form>
  </div>
</body>
</html>
