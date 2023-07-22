<?php
session_start();
require_once '../../functions/MY_model.php';

// Fungsi untuk membuat data rekam medis baru dalam tabel
function createRekamMedis($pasien_id, $dokter_id, $ruang_id, $keluhan, $diagnosa, $tanggal, $created_by)
{
    // Koneksi ke database (pastikan variabel $conn sudah ada dan berfungsi dengan baik)
    global $conn;

    // Query untuk menyisipkan data baru ke dalam tabel rekam_medis
    $query = "INSERT INTO rekam_medis (pasien_id, dokter_id, ruang_id, keluhan, diagnosa, tanggal, created_at, created_by)
              VALUES ('$pasien_id', '$dokter_id', '$ruang_id', '$keluhan', '$diagnosa', '$tanggal', NOW(), '$created_by')";

    // Eksekusi query menggunakan mysqli_query()
    $result = mysqli_query($conn, $query);

    // Mengembalikan nilai boolean berdasarkan hasil eksekusi query
    return $result;
}

// Fungsi untuk menyimpan data obat dalam rekam medis
function saveRmObat($rm_id, $obat_id)
{
    // Koneksi ke database (pastikan variabel $conn sudah ada dan berfungsi dengan baik)
    global $conn;

    // Query untuk menyisipkan data obat dalam tabel rm_obat
    $query = "INSERT INTO rm_obat (obat_id, rm_id) VALUES ('$obat_id', '$rm_id')";

    // Eksekusi query menggunakan mysqli_query()
    $result = mysqli_query($conn, $query);

    // Mengembalikan nilai boolean berdasarkan hasil eksekusi query
    return $result;
}

// Cek apakah ada data yang dikirim melalui metode POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data dari form
    $pasien_id = $_POST['pasien_id'];
    $dokter_id = $_POST['dokter_id'];
    $ruang_id = $_POST['ruang_id'];
    $keluhan = $_POST['keluhan'];
    $diagnosa = $_POST['diagnosa'];
    $tanggal = $_POST['tanggal'];
    $obat_id = $_POST['obat_id'];
    $created_by = $_SESSION['user']['id'];

    // Panggil fungsi untuk membuat data rekam medis baru
    $isCreated = createRekamMedis($pasien_id, $dokter_id, $ruang_id, $keluhan, $diagnosa, $tanggal, $created_by);

    if ($isCreated) {
        // Jika data rekam medis berhasil disimpan, ambil id rekam medis yang baru saja disimpan
        $rm_id = mysqli_insert_id($conn);

        // Loop melalui array obat_id untuk menyimpan data obat dalam rekam medis
        foreach ($obat_id as $obat) {
            $isSaved = saveRmObat($rm_id, $obat);
            if (!$isSaved) {
                // Jika terjadi error saat menyimpan data obat, tampilkan pesan error
                echo mysqli_error($conn);
                exit; // Keluar dari skrip agar tidak mengalami redirect ganda
            }
        }

        // Jika semua data obat berhasil disimpan, arahkan kembali ke halaman daftar rekam medis
        echo '<script>document.location.href="../../../?page=rekam-medis";</script>';
    } else {
        // Jika gagal, tampilkan pesan error
        echo mysqli_error($conn);
    }
}
?>
