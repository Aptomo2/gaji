<!DOCTYPE html>
<html>

<head>
    <title>Cetak Laporan Gaji</title>

    <!-- menghubungkan dengan file css -->
    <link rel="stylesheet" type="text/css" href="style1.css">
</head>

<body>
    <h1>Laporan Gaji Bulanan Karyawan</h1>
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
        // Fungsi untuk menghubungkan ke database
        function connectDB()
        {
            $conn = mysqli_connect("localhost", "root", "", "db_gaji");
            if (!$conn) {
                die("Koneksi database gagal: " . mysqli_connect_error());
            }
            return $conn;
        }

        // Fungsi untuk mendapatkan data karyawan berdasarkan bulan dan tahun
        function getKaryawanByBulanTahun($bulan, $tahun)
        {
            $conn = connectDB();
            $query = "SELECT * FROM db_karyawan WHERE MONTH(tgl_gaji) = '$bulan' AND YEAR(tgl_gaji) = '$tahun'";
            $result = mysqli_query($conn, $query);
            $karyawan = mysqli_fetch_all($result, MYSQLI_ASSOC);
            mysqli_close($conn);

            return $karyawan;
        }

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

        $total = 0;

        // Meng-handle form submit
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $bulan = $_POST['bulan'];
            $tahun = $_POST['tahun'];

            $karyawan = getKaryawanByBulanTahun($bulan, $tahun);

            // Cetak data karyawan
            foreach ($karyawan as $row) {
                $bonus = hitungBonus($row['jabatan'], $row['gaji_pokok']);
                $pph = hitungPPH($row['gaji_pokok'], $bonus);
                $gaji_bersih = $row['gaji_pokok'] + $bonus - $pph;
                $total += $gaji_bersih;

                echo "<tr>";
                echo "<td style='text-align: center;'>" . $row['nip'] . "</td>";
                echo "<td>" . $row['nama'] . "</td>";
                echo "<td style='text-align: center;'>" . $row['jabatan'] . "</td>";
                echo "<td>" . 'Rp. ', number_format($row['gaji_pokok'], 0, ',', '.') . "</td>";
                echo "<td>" . 'Rp. ', number_format($bonus, 0, ',', '.') . "</td>";
                echo "<td>" . 'Rp. ', number_format($pph, 0, ',', '.') . "</td>";
                echo "<td>" . 'Rp. ', number_format($gaji_bersih, 0, ',', '.') . "</td>";
                echo "<td style='text-align: center;'>" . $row['tgl_gaji'] . "</td>";
                echo "</tr>";
            }
        }
        ?>

        <tr>
            <td colspan="6" style="text-align: right;">Total Gaji :</td>
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