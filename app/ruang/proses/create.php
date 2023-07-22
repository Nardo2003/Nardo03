<?php
session_start();
require_once '../../functions/MY_model.php';

// Fungsi untuk membuat data ruang baru dalam tabel
function createRuang($nama_ruang, $keterangan, $created_by)
{
    // Koneksi ke database (pastikan variabel $conn sudah ada dan berfungsi dengan baik)
    global $conn;

    // Query untuk menyisipkan data baru ke dalam tabel ruang
    $query = "INSERT INTO ruang (nama_ruang, keterangan, created_at, created_by)
              VALUES ('$nama_ruang', '$keterangan', NOW(), '$created_by')";

    // Eksekusi query menggunakan mysqli_query()
    $result = mysqli_query($conn, $query);

    // Mengembalikan nilai boolean berdasarkan hasil eksekusi query
    return $result;
}

// Cek apakah ada data yang dikirim melalui metode POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data dari form
    $nama_ruang = $_POST['nama_ruang'];
    $keterangan = $_POST['keterangan'];
    $created_by = $_SESSION['user']['id'];

    // Panggil fungsi untuk membuat data ruang baru
    $isCreated = createRuang($nama_ruang, $keterangan, $created_by);

    // Cek hasil operasi penyisipan data
    if ($isCreated) {
        // Jika berhasil, arahkan kembali ke halaman daftar ruang
        echo '<script>document.location.href="../../../?page=ruang";</script>';
    } else {
        // Jika gagal, tampilkan pesan error
        echo mysqli_error($conn);
    }
}
?>
