<?php
$conn = mysqli_connect("localhost", "root", "", "db_gaji");

$query = "SELECT * FROM db_karyawan";
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

mysqli_close($conn);
?>

<!DOCTYPE html>
<html>

<head>
    <title>Cetak Laporan Gaji</title>
    
    <!-- menghubungkan dengan file css -->
    <link rel="stylesheet" type="text/css" href="style1.css">
</head>

<body>
    <h1>Laporan Gaji</h1>
    <h2>PT. Baroqah tbk.</h2>

    <table>
        <tr>
            <th>NIP</th>
            <th>Nama</th>
            <th>Jabatan</th>
            <th>Gaji Pokok</th>
            <th>Bonus</th>
            <th>PPH</th>
            <th>Gaji Bersih</th>
            <th>Tanggal</th>
        </tr>
        <?php
        $total = 0;
        while ($row = mysqli_fetch_assoc($result)) {

            $bonus = hitungBonus($row['jabatan'], $row['gaji_pokok']);
            $pph = hitungPPH($row['gaji_pokok'], $bonus);
            $gaji_bersih = $row['gaji_pokok'] + $bonus - $pph;
            $total += $gaji_bersih;

            echo "<tr>";
            echo "<td style='text-align: center;'>" . $row['nip'] . "</td>";
            echo "<td>" . $row['nama'] . "</td>";
            echo "<td style='text-align: center;'>" . $row['jabatan'] . "</td>";
            echo "<td>" .'Rp. ', number_format($row['gaji_pokok'], 0, ',', '.') . "</td>";
            echo "<td>" .'Rp. ', number_format($bonus, 0, ',', '.') . "</td>";
            echo "<td>" .'Rp. ', number_format($pph, 0, ',', '.') . "</td>";
            echo "<td>" .'Rp. ', number_format($gaji_bersih, 0, ',', '.') . "</td>";
            echo "<td style='text-align: center;'>" . $row['tgl_gaji'] . "</td>";
            echo "</tr>";
        }
        ?>

        <tr>
            <td colspan="6" style="text-align: right;">Total Gaji Semua Karyawan :</td>
            <td colspan="2">Rp.
                <?php
                echo number_format($total, 0, ',', '.');
                ?>
            </td>
        </tr>
    </table>

    <script>
        window.print();
    </script>
</body>

</html>