<!DOCTYPE html>
<html>
<head>
	<title>Onaka</title>
	<link rel="stylesheet" type="text/css" href="assets/bootstrap.min.css">
</head>
<body>
	<div class="conteiner">
		<div class="col-md-12 row justify-content-center">
			<div class="col-md-6 mt-5">
				<div class="col-md-12 text-center">
					<h2>Onaka</h2>
				</div>
				<div class="col-md-12 mt-5">
					<form enctype="multipart/form-data" method="post" action="upload.php">

						<div class="mb-3">
						  <label class="form-label">Name</label>
						  <input type="text" name="nama" class="form-control" >
						</div>
						
						<div class="mb-3">
						  <label class="form-label">Category</label>
						  <input type="text" name="kategori" class="form-control" >
						</div>

						<div class="mb-3">
						  <label class="form-label">Price</label>
						  <input type="number" name="harga" class="form-control" >
						</div>

						<div class="mb-3">
 			 				<label for="textarea" class="form-label">Description</label>
  							<textarea class="form-control" name="deskripsi" id="textarea" rows="3"></textarea>
						</div>

						<div class="mb-3">
						  <label class="form-label">Image</label>
						  <input type="file" name="foto" class="form-control" >
						</div>

						<div class="mb-3 text-end">
							<button type="submit" class="btn btn-success">Send</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</body>
</html>