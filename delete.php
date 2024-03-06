<?php
    // Koneksi ke database
    $conn = mysqli_connect("localhost", "root", "", "db_gaji");

    // Mengambil NIP karyawan yang akan dihapus dari URL
    $nip = $_GET['nip'];

    // Query untuk menghapus data karyawan dari database
    $query = "DELETE FROM db_karyawan WHERE nip = '$nip'";
    mysqli_query($conn, $query);

    // Menutup koneksi database
    mysqli_close($conn);

    // Mengarahkan kembali ke halaman utama
    header("Location: index.php?page=karyawan");
    exit();
?>