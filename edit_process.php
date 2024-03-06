<script>
        function showNotif() {
            alert("Data karyawan berhasil diubah.");
            window.location.href = "index.php"; 
        }
        function showFail() {
            alert("Gagal mengubah data karyawan.");
        }
</script>

<?php
    // Koneksi ke database
    $conn = mysqli_connect("localhost", "root", "", "db_gaji");

    // Mengambil data dari form
    $nip = $_POST['nip'];
    $nama = $_POST['nama'];
    $jabatan = $_POST['jabatan'];
    $gaji_pokok = $_POST['gaji_pokok'];
    $tgl_gaji = $_POST['tgl_gaji'];

    // Query untuk mengupdate data karyawan di dalam database
    $query = "UPDATE db_karyawan SET nama = '$nama', jabatan = '$jabatan', gaji_pokok = '$gaji_pokok', tgl_gaji = '$tgl_gaji' WHERE nip = '$nip'";
    $result = mysqli_query($conn, $query);

    // Mengecek apakah data berhasil diubah atau tidak
    if ($result) {
        echo '<script>showNotif();</script>';
    } else {
        echo '<script>showFail();</script>';
    }

    // Menutup koneksi database
    mysqli_close($conn);


?>