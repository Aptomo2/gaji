<!DOCTYPE html>
<html>
<head>
  <title>Laporan Gaji Karyawan</title>
  <style>
    table {
      border-collapse: collapse;
    }

    table, th, td {
      border: 1px solid black;
      padding: 5px;
    }
  </style>
</head>
<body>
  <h2>Laporan Gaji Karyawan</h2>

  <?php
  // Fungsi untuk menghubungkan ke database
  function connectDB() {
    $conn = mysqli_connect("localhost", "root", "", "db_gaji");
    if (!$conn) {
      die("Koneksi database gagal: " . mysqli_connect_error());
    }
    return $conn;
  }

  // Fungsi untuk mendapatkan semua data karyawan
  function getAllKaryawan() {
    $conn = connectDB();
    $query = "SELECT * FROM db_karyawan";
    $result = mysqli_query($conn, $query);
    $karyawan = mysqli_fetch_all($result, MYSQLI_ASSOC);
    mysqli_close($conn);

    return $karyawan;
  }

  // Meng-handle form submit
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $karyawan = getAllKaryawan();

    // Cetak data karyawan
    echo "<table>";
    echo "<tr>
            <th>NIP</th>
            <th>Nama</th>
            <th>Jabatan</th>
            <th>Gaji Pokok</th>
            <th>Tanggal</th>
          </tr>";

    $totalGaji = 0;

    foreach ($karyawan as $row) {
      echo "<tr>";
      echo "<td>" . $row['nip'] . "</td>";
      echo "<td>" . $row['nama'] . "</td>";
      echo "<td>" . $row['jabatan'] . "</td>";
      echo "<td>" . $row['gaji_pokok'] . "</td>";
      echo "<td>" . $row['tgl_gaji'] . "</td>";
      echo "</tr>";

      $totalGaji += $row['gaji_pokok'];
    }

    echo "</table>";

    // Cetak total gaji
    echo "<p>Total Gaji: " . $totalGaji . "</p>";
  }
  ?>

  <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
    <input type="submit" value="Cetak">
  </form>
</body>
</html>