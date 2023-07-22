<?php
session_start();
require_once '../../functions/MY_model.php';

// Fungsi untuk membuat data pasien baru dalam tabel
function createPasien($nomor_identitas, $nama_pasien, $jenis_kelamin, $alamat, $telephone, $created_by)
{
    // Koneksi ke database (pastikan variabel $conn sudah ada dan berfungsi dengan baik)
    global $conn;

    // Query untuk menyisipkan data baru ke dalam tabel pasien
    $query = "INSERT INTO pasien (nomor_identitas, nama_pasien, jenis_kelamin, alamat, telephone, created_at, created_by)
              VALUES ('$nomor_identitas', '$nama_pasien', '$jenis_kelamin', '$alamat', '$telephone', NOW(), '$created_by')";

    // Eksekusi query menggunakan mysqli_query()
    $result = mysqli_query($conn, $query);

    // Mengembalikan nilai boolean berdasarkan hasil eksekusi query
    return $result;
}

// Cek apakah ada data yang dikirim melalui metode POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data dari form
    $nomor_identitas = $_POST['nomor_identitas'];
    $nama_pasien = $_POST['nama_pasien'];
    $jenis_kelamin = $_POST['jenis_kelamin'];
    $alamat = $_POST['alamat'];
    $telephone = $_POST['telephone'];
    $created_by = $_SESSION['user']['id'];

    // Panggil fungsi untuk membuat data pasien baru
    $isCreated = createPasien($nomor_identitas, $nama_pasien, $jenis_kelamin, $alamat, $telephone, $created_by);

    // Cek hasil operasi penyisipan data
    if ($isCreated) {
        // Jika berhasil, arahkan kembali ke halaman daftar pasien
        echo '<script>document.location.href="../../../?page=pasien";</script>';
    } else {
        // Jika gagal, tampilkan pesan error
        echo mysqli_error($conn);
    }
}
?>
