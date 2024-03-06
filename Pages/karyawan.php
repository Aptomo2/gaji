<div class="pages">
    <?php
    // Koneksi ke database
    $conn = mysqli_connect("localhost", "root", "", "db_gaji");

    // Mengambil data dari form pencarian
    $search = isset($_GET['search']) ? $_GET['search'] : '';

    // Query untuk mengambil data karyawan berdasarkan pencarian nama atau NIP
    $query = "SELECT * FROM db_karyawan WHERE nama LIKE '%$search%' OR nip LIKE '%$search%'";

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
        <title>Data Karyawan</title>

        <!-- Menambahkan icon library -->
        <link rel="stylesheet"
            href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

        <!-- menghubungkan dengan file css -->
        <link rel="stylesheet" type="text/css" href="style1.css">
    </head>

    <body>
        <h1>Daftar Karyawan</h1>

        <form action="index.php" method="GET" class="l">
            <input type="text" name="search" id="search" value="<?php echo $search; ?>">
            <button class="btn"><i class="fa fa-search"></i>&nbsp;Cari</button>
        </form>

        <div style="overflow-x:auto;">
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
                    <th>Aksi</th>
                </tr>

                <?php
                while ($row = mysqli_fetch_assoc($result)) {

                    $bonus = hitungBonus($row['jabatan'], $row['gaji_pokok']);
                    $pph = hitungPPH($row['gaji_pokok'], $bonus);
                    $gaji_bersih = $row['gaji_pokok'] + $bonus - $pph;

                    echo "<tr>";
                    echo "<td style='text-align: center;'>" . $row['nip'] . "</td>";
                    echo "<td>" . $row['nama'] . "</td>";
                    echo "<td style='text-align: center;'>" . $row['jabatan'] . "</td>";
                    echo "<td>" . 'Rp. ', number_format($row['gaji_pokok'], 0, ',', '.') . "</td>";
                    echo "<td>" . 'Rp. ', number_format($bonus, 0, ',', '.') . "</td>";
                    echo "<td>" . 'Rp. ', number_format($pph, 0, ',', '.') . "</td>";
                    echo "<td>" . 'Rp. ', number_format($gaji_bersih, 0, ',', '.') . "</td>";
                    echo "<td style='text-align: center;'>" . $row['tgl_gaji'] . "</td>";
                    echo "<td style='text-align: center;'>
                        <a href='edit.php?nip=" . $row['nip'] . "'class='ebtn'><i class='fa fa-edit'></i></a>
                        <a href='delete.php?nip=" . $row['nip'] . "' onclick='return confirm(\"Apakah Anda yakin ingin menghapus data ini?\")'class='dbtn'><i class='fa fa-trash'></i></a>
                        <a href='print_nip.php?id=" . $row['nip'] . "'class='pbtn'><i class='fa fa-print'></i></a>
                      </td>";

                    echo "</tr>";
                }
                ?>

            </table>
        </div>

        <form action="add.php">
            <button class="lbtn"><i class="fa fa-plus"></i>&nbsp;Tambah Data</button>
        </form>

        <form action="print_all.php">
            <button class="rbtn"><i class="fa fa-print"></i>&nbsp;Cetak Semua</button>
        </form>

        <form action="print_bln.php" method="POST" class="r">
            <label>Bulan:</label>
            <input type="number" name="bulan" min="1" max="12" required>
            <label>Tahun:</label>
            <input type="number" name="tahun" required>
            <button class="btn1"><i class="fa fa-print"></i>&nbsp;Laporan Bulanan</button>
        </form>

    </body>

    </html>
</div>