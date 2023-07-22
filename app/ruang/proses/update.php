<?php
session_start();
require_once '../../functions/MY_model.php';

// Fungsi untuk mengupdate data ruang dalam tabel
function updateRuang($id, $nama_ruang, $keterangan)
{
    // Koneksi ke database (pastikan variabel $conn sudah ada dan berfungsi dengan baik)
    global $conn;

    // Query untuk mengupdate data ruang berdasarkan id
    $query = "UPDATE ruang SET 
              nama_ruang = '$nama_ruang', 
              keterangan = '$keterangan' 
              WHERE id = '$id'";

    // Eksekusi query menggunakan mysqli_query()
    $result = mysqli_query($conn, $query);

    // Mengembalikan nilai boolean berdasarkan hasil eksekusi query
    return $result;
}

// Cek apakah ada data yang dikirim melalui metode POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data dari form
    $id = $_POST['id'];
    $nama_ruang = $_POST['nama_ruang'];
    $keterangan = $_POST['keterangan'];

    // Panggil fungsi untuk mengupdate data ruang
    $isUpdated = updateRuang($id, $nama_ruang, $keterangan);

    // Cek hasil operasi update data
    if ($isUpdated) {
        // Jika berhasil, arahkan kembali ke halaman daftar ruang
        echo '<script>document.location.href="../../../?page=ruang";</script>';
    } else {
        // Jika gagal, tampilkan pesan error
        echo mysqli_error($conn);
    }
}
?>
