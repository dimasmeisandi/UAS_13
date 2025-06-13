<?php
include '../koneksi.php';
session_start();

if (!isset($_SESSION['id_pengguna']) || !isset($_SESSION['role'])) {
    echo "Akses ditolak.";
    exit();
}

$id_pengguna = $_SESSION['id_pengguna'];
$role = $_SESSION['role'];

if (!isset($_GET['id'])) {
    echo "ID ekskul tidak ditemukan.";
    exit();
}

$id_eskul = intval($_GET['id']);

// Cek apakah user berhak menghapus (admin bebas, pembina hanya miliknya)
if ($role === 'admin') {
    $query = "DELETE FROM eskul WHERE id_eskul = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id_eskul);
} elseif ($role === 'pembina') {
    $query = "DELETE FROM eskul WHERE id_eskul = ? AND id_pembina = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ii", $id_eskul, $id_pengguna);
} else {
    echo "Akses ditolak.";
    exit();
}

// Eksekusi dan beri respon
if ($stmt->execute()) {
    header("Location: admin_eskul.php");
    exit();
} else {
    echo "Gagal menghapus data: " . $conn->error;
}
?>
