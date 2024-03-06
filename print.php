<?php
// Koneksi ke database
$conn = mysqli_connect("localhost", "root", "", "db_gaji");

// Mengambil tanggal gajian dari URL
$tanggal = $_GET['tanggal'];

// Query untuk mengambil data karyawan berdasarkan tanggal gajian
$query = "SELECT * FROM db_karyawan WHERE tgl_gaji = '$tanggal'";
$result = mysqli_query($conn, $query);

// Fungsi untuk menghitung bonus berdasarkan jabatan
function hitungBonus($jabatan, $gaji_pokok)
{
    if ($jabatan == 'Manager') {
        return $gaji_pokok * 0.5;
    } elseif ($jabatan == 'Supervisor') {
        return $gaji_pokok * 0.4;
    } elseif ($jabatan == 'Staff') {
        return $gaji_pokok * 0.3;
    } else {
        return 0;
    }
}

// Fungsi untuk menghitung PPH
function hitungPPH($gaji_pokok, $bonus)
{
    return ($gaji_pokok + $bonus) * 0.05;
}

// Menutup koneksi database
mysqli_close($conn);
?>

<!DOCTYPE html>
<html>

<head>
    <title>Cetak Laporan Gaji</title>
    <!-- menghubungkan dengan file css -->
	<link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>
    <h1 style="text-align: center;">Laporan Gaji</h1>
    <h2 style="text-align: center;">
        <?php echo $tanggal; ?>
    </h2>

    <table>
        <tr>
            <th>NIP</th>
            <th>Nama</th>
            <th>Jabatan</th>
            <th>Gaji Pokok</th>
            <th>Bonus</th>
            <th>PPH</th>
            <th>Gaji Total</th>
            <th>Tanggal</th>
        </tr>
        <?php
        while ($row = mysqli_fetch_assoc($result)) {

            $bonus = hitungBonus($row['jabatan'], $row['gaji_pokok']);
            $pph = hitungPPH($row['gaji_pokok'], $bonus);
            $gaji_bersih = $row['gaji_pokok'] + $bonus - $pph;

            echo "<tr>";
            echo "<td>" . $row['nip'] . "</td>";
            echo "<td>" . $row['nama'] . "</td>";
            echo "<td>" . $row['jabatan'] . "</td>";
            echo "<td>" . number_format($row['gaji_pokok'], 0, ',', '.') . "</td>";
            echo "<td>" . number_format($bonus, 0, ',', '.') . "</td>";
            echo "<td>" . number_format($pph, 0, ',', '.') . "</td>";
            echo "<td>" . number_format($gaji_bersih, 0, ',', '.') . "</td>";
            echo "<td>" . $row['tgl_gaji'] . "</td>";
            echo "</tr>";
        }
        ?>
    </table>

    <script>
        window.print();
    </script>
</body>

</html>