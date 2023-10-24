<?php 
	include "db.php" ;
	$data = mysqli_query ($conn, "SELECT * FROM menu_items WHERE id = '$_GET[id]' ") ;
	$row = mysqli_fetch_array($data) ;

	$foto = $row['image_path'] ;
	if(file_exists('file/'.$foto))
	{
		unlink('file/'.$foto) ;
	}
	$query = "DELETE FROM menu_items WHERE id = '$_GET[id]' ";
	mysqli_query($conn, $query) or die ("SQL Error ".mysqli_error()) ;
	header('location:admin.php')
?>