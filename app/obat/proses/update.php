<?php
session_start();
require_once '../../functions/MY_model.php';

// Fungsi untuk mengupdate data obat dalam tabel
function updateObat($id, $nama_obat, $keterangan)
{
    // Koneksi ke database (pastikan variabel $conn sudah ada dan berfungsi dengan baik)
    global $conn;

    // Query untuk mengupdate data obat berdasarkan id
    $query = "UPDATE obat SET 
              nama_obat = '$nama_obat', 
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
    $nama_obat = $_POST['nama_obat'];
    $keterangan = $_POST['keterangan'];

    // Panggil fungsi untuk mengupdate data obat
    $isUpdated = updateObat($id, $nama_obat, $keterangan);

    // Cek hasil operasi update data
    if ($isUpdated) {
        // Jika berhasil, arahkan kembali ke halaman daftar obat
        echo '<script>document.location.href="../../../?page=obat";</script>';
    } else {
        // Jika gagal, tampilkan pesan error
        echo mysqli_error($conn);
    }
}
?>
