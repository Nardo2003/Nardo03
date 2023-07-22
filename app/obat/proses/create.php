<?php
session_start();
require_once '../../functions/MY_model.php';

// Fungsi untuk membuat data obat baru dalam tabel
function createObat($nama_obat, $keterangan, $created_by)
{
    // Koneksi ke database (pastikan variabel $conn sudah ada dan berfungsi dengan baik)
    global $conn;

    // Query untuk menyisipkan data baru ke dalam tabel obat
    $query = "INSERT INTO obat (nama_obat, keterangan, created_at, created_by)
              VALUES ('$nama_obat', '$keterangan', NOW(), '$created_by')";

    // Eksekusi query menggunakan mysqli_query()
    $result = mysqli_query($conn, $query);

    // Mengembalikan nilai boolean berdasarkan hasil eksekusi query
    return $result;
}

// Cek apakah ada data yang dikirim melalui metode POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data dari form
    $nama_obat = $_POST['nama_obat'];
    $keterangan = $_POST['keterangan'];
    $created_by = $_SESSION['user']['id'];

    // Panggil fungsi untuk membuat data obat baru
    $isCreated = createObat($nama_obat, $keterangan, $created_by);

    // Cek hasil operasi penyisipan data
    if ($isCreated) {
        // Jika berhasil, arahkan kembali ke halaman daftar obat
        echo '<script>document.location.href="../../../?page=obat";</script>';
    } else {
        // Jika gagal, tampilkan pesan error
        echo mysqli_error($conn);
    }
}
?>
