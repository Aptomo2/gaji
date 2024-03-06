<!DOCTYPE html>
<html>

<head>
    <title>Tambah Data Karyawan</title>

    <link rel="stylesheet" type="text/css" href="style_tambah.css">

    <script>
        function showNotification() {
            alert("NIP sudah ada dalam database.");
        }
        function showNotif() {
            alert("Data karyawan berhasil ditambahkan.");
        }
        function showFail() {
            alert("Gagal menambahkan data karyawan.");
        }
    </script>
</head>

<body>
    <h1>Tambah Data Karyawan</h1>

    <?php
    // Fungsi untuk menghubungkan ke database
    function connectDB()
    {
        $conn = mysqli_connect("localhost", "root", "", "db_gaji");
        if (!$conn) {
            die("Koneksi database gagal: " . mysqli_connect_error());
        }
        return $conn;
    }

    // Fungsi untuk mengecek apakah NIP sudah ada di database
    function checkNIP($nip)
    {
        $conn = connectDB();
        $query = "SELECT COUNT(*) AS total FROM db_karyawan WHERE nip = '$nip'";
        $result = mysqli_query($conn, $query);
        $row = mysqli_fetch_assoc($result);
        mysqli_close($conn);

        return $row['total'] > 0;
    }

    // Meng-handle form submit
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $nip = $_POST['nip'];
        $nama = $_POST['nama'];
        $jabatan = $_POST['jabatan'];
        $gaji_pokok = $_POST['gaji_pokok'];
        $tgl_gaji = $_POST['tgl_gaji'];

        if (checkNIP($nip)) {
            echo '<script>showNotification();</script>';
        } else {
            $result = addKaryawan($nip, $nama, $jabatan, $gaji_pokok, $tgl_gaji);
            if ($result) {
                echo '<script>showNotif();</script>';
            } else {
                echo '<script>showFail();</script>';
            }
        }
    }

    // Fungsi untuk menambahkan data karyawan ke database
    function addKaryawan($nip, $nama, $jabatan, $gaji_pokok, $tgl_gaji)
    {
        $conn = connectDB();
        $query = "INSERT INTO db_karyawan (nip, nama, jabatan, gaji_pokok, tgl_gaji) VALUES ('$nip', '$nama', '$jabatan', '$gaji_pokok', '$tgl_gaji')";
        $result = mysqli_query($conn, $query);
        mysqli_close($conn);

        return $result;
    }

    ?>

    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
        <label for="nip">NIP:</label>
        <input type="text" name="nip" id="nip" required>
        <br>

        <label for="nama">Nama:</label>
        <input type="text" name="nama" id="nama" required>
        <br>

        <label for="jabatan">Jabatan:</label>
        <select name="jabatan" id="jabatan" required>
            <option value="Manager">Manager</option>
            <option value="Supervisor">Supervisor</option>
            <option value="Staff">Staff</option>
        </select>
        <br>

        <label for="gaji_pokok">Gaji Pokok:</label>
        <input type="number" name="gaji_pokok" id="gaji_pokok" required>
        <br>

        <label for="tgl_gaji">Tanggal:</label>
        <input type="date" name="tgl_gaji" id="tgl_gaji" required>
        <br>

        <input type="submit" value="Simpan">
        <input type="batal" value="Batal" onClick="document.location.href='index.php';">
        <br>
    </form>

</body>

</html>