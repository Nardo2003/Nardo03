<?php
session_start();
require_once '../../functions/MY_model.php';

// Fungsi untuk menghapus data ruang dari tabel
function deleteRuang($id)
{
    // Koneksi ke database (pastikan variabel $conn sudah ada dan berfungsi dengan baik)
    global $conn;

    // Query untuk menghapus data dari tabel ruang berdasarkan id
    $query = "DELETE FROM ruang WHERE id = '$id'";

    // Eksekusi query menggunakan mysqli_query()
    $result = mysqli_query($conn, $query);

    // Mengembalikan nilai boolean berdasarkan hasil eksekusi query
    return $result;
}

// Cek apakah ada data yang dikirim melalui metode GET
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    // Ambil id dari parameter GET
    $id = $_GET['id'];

    // Panggil fungsi untuk menghapus data ruang
    $isDeleted = deleteRuang($id);

    // Cek hasil operasi penghapusan data
    if ($isDeleted) {
        // Jika berhasil, arahkan kembali ke halaman daftar ruang
        echo '<script>document.location.href="../../../?page=ruang";</script>';
    } else {
        // Jika gagal, tampilkan pesan error
        echo mysqli_error($conn);
    }
}
?>
