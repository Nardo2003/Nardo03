<?php
session_start();
require_once '../../functions/MY_model.php';

// Fungsi untuk mengupdate data dokter dalam tabel
function updateDokter($id, $nama_dokter, $alamat, $telephone, $spesialis)
{
    // Koneksi ke database (pastikan variabel $conn sudah ada dan berfungsi dengan baik)
    global $conn;

    // Query untuk mengupdate data dokter berdasarkan id
    $query = "UPDATE dokter SET 
              nama_dokter = '$nama_dokter', 
              alamat = '$alamat', 
              telephone = '$telephone', 
              spesialis = '$spesialis' 
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
    $nama_dokter = $_POST['nama_dokter'];
    $alamat = $_POST['alamat'];
    $telephone = $_POST['telephone'];
    $spesialis = $_POST['spesialis'];

    // Panggil fungsi untuk mengupdate data dokter
    $isUpdated = updateDokter($id, $nama_dokter, $alamat, $telephone, $spesialis);

    // Cek hasil operasi update data
    if ($isUpdated) {
        // Jika berhasil, arahkan kembali ke halaman daftar dokter
        echo '<script>document.location.href="../../../?page=dokter";</script>';
    } else {
        // Jika gagal, tampilkan pesan error
        echo mysqli_error($conn);
    }
}
?>
