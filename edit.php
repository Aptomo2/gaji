<?php
    // Koneksi ke database
    $conn = mysqli_connect("localhost", "root", "", "db_gaji");

    // Mengambil NIP karyawan yang akan diedit dari URL
    $nip = $_GET['nip'];

    // Query untuk mengambil data karyawan berdasarkan NIP
    $query = "SELECT * FROM db_karyawan WHERE nip = '$nip'";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);

    // Menutup koneksi database
    mysqli_close($conn);
?>

<!DOCTYPE html>
<html>

<head>
    <title>Ubah Data Karyawan</title>
    
    <link rel="stylesheet" type="text/css" href="style_tambah.css">
</head>

<body>
    <h1>Ubah Data Karyawan</h1>

    <form action="edit_process.php" method="POST">
        <label for="nip">NIP:</label>
        <input type="number" name="nip" value="<?php echo $row['nip']; ?>">
        <br>
        <label for="nama">Nama:</label>
        <input type="text" name="nama" id="nama" value="<?php echo $row['nama']; ?>" required>
        <br>
        <label for="jabatan">Jabatan:</label>
        <select name="jabatan" id="jabatan" required>
            <option value="Manager" <?php if ($row['jabatan'] == 'manager')
                echo 'selected'; ?>>Manager</option>
            <option value="Supervisor" <?php if ($row['jabatan'] == 'supervisor')
                echo 'selected'; ?>>Supervisor</option>
            <option value="Staff" <?php if ($row['jabatan'] == 'staff')
                echo 'selected'; ?>>Staff</option>
        </select>
        <br>
        <label for="gaji_pokok">Gaji Pokok:</label>
        <input type="number" name="gaji_pokok" id="gaji_pokok" value="<?php echo $row['gaji_pokok']; ?>" required>
        <br>
        <label for="tgl_gaji">Tanggal:</label>
        <input type="date" name="tgl_gaji" id="tgl_gaji" value="<?php echo $row['tgl_gaji']; ?>" required>
        <br>
        <input type="submit" value="Simpan">
        <input type="batal" value="Batal" onClick="document.location.href='index.php?page=karyawan';">
    </form>

</body>

</html>