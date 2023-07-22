<?php
session_start();
require_once '../../functions/MY_model.php';

// Fungsi untuk memasukkan data dokter baru ke dalam tabel
function insertNewDokter($nama_dokter, $alamat, $telephone, $spesialis, $created_by)
{
    // Koneksi ke database (pastikan variabel $conn sudah ada dan berfungsi dengan baik)
    global $conn;

    // Tanggal dan waktu saat ini
    $created_at = date('Y-m-d H:i:s');

    // Query untuk menyisipkan data ke tabel dokter (tanpa mengisi kolom id)
    $query = "INSERT INTO dokter (nama_dokter, alamat, telephone, spesialis, created_at, created_by) 
              VALUES ('$nama_dokter', '$alamat', '$telephone', '$spesialis', '$created_at', '$created_by')";

    // Eksekusi query menggunakan mysqli_query()
    $result = mysqli_query($conn, $query);

    // Mengembalikan nilai boolean berdasarkan hasil eksekusi query
    return $result;
}

// Cek apakah ada data yang dikirim melalui metode POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data dari form
    $nama_dokter = $_POST['nama_dokter'];
    $alamat = $_POST['alamat'];
    $telephone = $_POST['telephone'];
    $spesialis = $_POST['spesialis'];
    $created_by = $_SESSION['user']['id'];

    // Panggil fungsi untuk memasukkan data dokter baru
    $isInserted = insertNewDokter($nama_dokter, $alamat, $telephone, $spesialis, $created_by);

    // Cek hasil operasi penyisipan data
    if ($isInserted) {
        // Jika berhasil, arahkan ke halaman daftar dokter
        echo '<script>document.location.href="../../../?page=dokter";</script>';
    } else {
        // Jika gagal, tampilkan pesan error
        echo mysqli_error($conn);
    }
}
?>
