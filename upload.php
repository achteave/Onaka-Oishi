<?php 
	include "db.php" ;
	$foto = $_FILES['foto']['name'];
	$file_tmp = $_FILES['foto']['tmp_name'] ;
	$nama = $_POST['nama'] ;
	$kategori = $_POST['kategori'];
	$harga = $_POST['harga'] ;
	$deskripsi = $_POST['deskripsi'] ;
	move_uploaded_file($file_tmp, 'file/'.$foto) ;
	$query = "INSERT INTO menu_items SET 
								    name = '$nama',
									category = '$kategori',
									price = '$harga',
									description = '$deskripsi',
									image_path = '$foto'
	";
	mysqli_query($conn, $query) 
	or die("SQL Error " .mysqli_error());
	header('location:admin.php');
?>