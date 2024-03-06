<?php
// Koneksi ke database
$conn = mysqli_connect("localhost", "root", "", "db_gaji");

// Mengambil tanggal gajian dari URL
$id = $_GET['id'];

// Query untuk mengambil data karyawan berdasarkan tanggal gajian
$query = "SELECT * FROM db_karyawan WHERE nip = '$id'";
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
    <title>Slip Gaji</title>
    <style>
        .center {
            margin-left: auto;
            margin-right: auto;
        }

        table {
            border-collapse: collapse;
            width: 50%;
        }

        th,
        td {
            border: 1px solid black;
            padding: 8px;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>

<body>
    <table class="center">
        <?php
        while ($row = mysqli_fetch_assoc($result)) {

            $nama = $row['nama'];
            $jabatan = $row['jabatan'];
            $tgl = $row['tgl_gaji'];
            $gaji_pokok = $row['gaji_pokok'];
            $bonus = hitungBonus($row['jabatan'], $row['gaji_pokok']);
            $pph = hitungPPH($row['gaji_pokok'], $bonus);
            $gaji_bersih = $row['gaji_pokok'] + $bonus - $pph;
        }
        ?>
        <tr>
            <td colspan="3" style="text-align: center;">
                <h2>PT. Barokah tbk.</h2>
                <h3>Slip Gaji Pegawai</h3>
            </td>
        </tr>
        <tr>
            <td colspan="3">
                Nama&emsp;:
                <?php echo $nama; ?><br>
                Jabatan &thinsp;:
                <?php echo $jabatan; ?><br>
                Tanggal :
                <?php echo $tgl; ?> <br>
            </td>
        </tr>
        <tr>
            <td>Gaji Pokok</td>
            <td>:</td>
            <td>Rp.
                <?php
                echo number_format($gaji_pokok, 0, ',', '.');
                ?>
            </td>
        </tr>
        <tr>
            <td>Bonus</td>
            <td>:</td>
            <td>Rp.
                <?php
                echo number_format($bonus, 0, ',', '.');
                ?>
            </td>
        </tr>
        <tr>
            <td>PPH</td>
            <td>:</td>
            <td>Rp.
                <?php
                echo number_format($pph, 0, ',', '.');
                ?>
            </td>
        </tr>
        <tr>
            <td>Gaji Bersih</td>
            <td>:</td>
            <td>Rp.
                <?php
                echo number_format($gaji_bersih, 0, ',', '.');
                ?>
            </td>
        </tr>
        <tr>
            <td colspan="3"> <br><br>HRD</td>
        </tr>
    </table>

    <script>
        window.print();
    </script>
</body>

</html>