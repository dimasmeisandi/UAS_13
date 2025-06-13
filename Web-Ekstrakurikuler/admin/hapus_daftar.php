<?php
include '../koneksi.php';
session_start();

if (!in_array($_SESSION['role'], ['admin', 'pembina', 'pelatih'])) {
    echo "Akses ditolak.";
    exit();
}

if (isset($_GET['id'])) {
    $id = $conn->real_escape_string($_GET['id']);

    $query = "DELETE FROM pendaftaran_eskul WHERE id_pendaftaran = '$id'";
    if ($conn->query($query)) {
        // Berhasil hapus, kembali ke admin_eskul.php
        header("Location: admin_daftar.php");
        exit;
    } else {
        echo "Gagal menghapus data: " . $conn->error;
    }
} else {
    echo "ID tidak ditemukan.";
}
?>
