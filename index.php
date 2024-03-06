<!DOCTYPE html>
<html>

<head>
	<title>PT. Baroqah tbk.</title>
	
	<!-- menghubungkan dengan file css -->
	<link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>
	<div class="content">
		<header>
			<h1 class="judul">PT. Baroqah tbk.</h1>
		</header>

		<div class="menu">
			<ul>
				<li><a href="index.php?page=home">Home</a></li>
				<li><a href="index.php?page=karyawan">Daftar Karyawan</a></li>
			</ul>
		</div>

		<div class="badan">
			<?php
			if (isset($_GET['page'])) {
				$page = $_GET['page'];

				switch ($page) {
					case 'home':
						include "pages/home.php";
						break;
					case 'karyawan':
						include "pages/karyawan.php";
						break;
				}
			} else {
				include "pages/karyawan.php";
			}
			?>
		</div>
	</div>
</body>

</html>