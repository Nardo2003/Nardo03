<?php
session_start();
require_once '../../functions/MY_model.php';

// Fungsi untuk mengupdate data pasien dalam tabel
function updatePasien($id, $nama_pasien, $nomor_identitas, $alamat, $telephone, $jenis_kelamin)
{
    // Koneksi ke database (pastikan variabel $conn sudah ada dan berfungsi dengan baik)
    global $conn;

    // Query untuk mengupdate data pasien berdasarkan id
    $query = "UPDATE pasien SET 
              nama_pasien = '$nama_pasien', 
              nomor_identitas = '$nomor_identitas', 
              alamat = '$alamat', 
              telephone = '$telephone', 
              jenis_kelamin = '$jenis_kelamin' 
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
    $nama_pasien = $_POST['nama_pasien'];
    $nomor_identitas = $_POST['nomor_identitas'];
    $alamat = $_POST['alamat'];
    $telephone = $_POST['telephone'];
    $jenis_kelamin = $_POST['jenis_kelamin'];

    // Panggil fungsi untuk mengupdate data pasien
    $isUpdated = updatePasien($id, $nama_pasien, $nomor_identitas, $alamat, $telephone, $jenis_kelamin);

    // Cek hasil operasi update data
    if ($isUpdated) {
        // Jika berhasil, arahkan kembali ke halaman daftar pasien
        echo '<script>document.location.href="../../../?page=pasien";</script>';
    } else {
        // Jika gagal, tampilkan pesan error
        echo mysqli_error($conn);
    }
}
?>
