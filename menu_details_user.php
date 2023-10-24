<?php

include('db.php'); // Include the db.php file to establish a database connection

// Check if the user is logged in
if (!isset($_SESSION["id"])) {
    header("Location: login.php");
    exit();
}

if (isset($_GET['id'])) {
    $menu_id = $_GET['id'];

    // Retrieve menu item details from the database
    $sql = "SELECT * FROM menu_items WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $menu_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $menu_item = $result->fetch_assoc();

    if (!$menu_item) {
        echo 'there is no data of this menu';
    }
}
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = array();
}

if (isset($_POST['add_to_cart'])) {
    $menu_item_id = $_POST['menu_item_id'];
    $menu_item_name = $_POST['menu_item_name'];
    $menu_item_price = $_POST['menu_item_price'];
    $quantity = 1;

    // Check if the cart exists in the session, if not, create an empty cart
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    // Check if the menu item is already in the cart, if so, update the quantity
    if (array_key_exists($menu_item_id, $_SESSION['cart'])) {
        $_SESSION['cart'][$menu_item_id]['quantity'] += $quantity;
    } else {
        // Add the menu item to the cart
        $_SESSION['cart'][$menu_item_id] = [
            'name' => $menu_item_name,
            'price' => $menu_item_price,
            'quantity' => $quantity,
        ];
    }

    header('Location: menu2.php');
    exit();
}

if (isset($_POST['remove_from_cart'])) {
    $menu_item_id = $_POST['menu_item_id'];
    if (array_key_exists($menu_item_id, $_SESSION['cart'])) {
        unset($_SESSION['cart'][$menu_item_id]);
    }

    header('Location: menu2.php');
    exit();
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Menu Item Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">   
   
    <!-- Mobile Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
 
     <!-- Site Metas -->
    <title>Oishi-io | Menu</title>  
    <meta name="keywords" content="">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Site Icons -->
    <link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon">
    <link rel="apple-touch-icon" href="images/apple-touch-icon.png">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css">    
	<!-- Site CSS -->
    <link rel="stylesheet" href="css/style.css">    
    <!-- Responsive CSS -->
    <link rel="stylesheet" href="css/responsive.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/custom.css">
</head>
<body>
	<!-- Start header -->
	<header class="top-navbar">
		<nav class="navbar navbar-expand-lg navbar-light bg-light">
			<div class="container">
				<a class="navbar-brand" href="index.html">
					<img src="images/logo.png" alt="" />
				</a>
				<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbars-rs-food" aria-controls="navbars-rs-food" aria-expanded="false" aria-label="Toggle navigation">
				  <span class="navbar-toggler-icon"></span>
				</button>
				<div class="collapse navbar-collapse" id="navbars-rs-food">
					<ul class="navbar-nav ml-auto">
						<li class="nav-item active"><a class="nav-link" href="index.php">Home</a></li>
						<li class="nav-item"><a class="nav-link" href="menu2.php">Menu</a></li>
						<li class="nav-item"><a class="nav-link" href="checkout.php">Cart</a></li>
           				 <li class="nav-item"><a class="nav-link" href="logout.php">Sign Out</a></li>
					</ul>
				</div>
			</div>
		</nav>
	</header>
	<!-- End header -->
	
	<!-- Start All Pages -->
	<div class="all-page-title page-breadcrumb">
		<div class="container text-center">
			<div class="row">
				<div class="col-lg-12">
					<h1>Special Menu</h1>
				</div>
			</div>
		</div>
	</div>
	<!-- End All Pages -->
	
	<!-- Start Menu -->
	<div class="menu-box">
		<div class="container">
			<div class="row">
				<div class="col-lg-12">
					<div class="heading-title text-center">
						<h2>Menu Details</h2>
					</div>
				</div>
			</div>
			<div>
			<section>
            <!-- Display menu item details -->
            <h1>Menu Item Details</h1>
			<h2><?php echo $menu_item['name']; ?></h2>
			<p><strong>Category:</strong> <?php echo $menu_item['category']; ?></p>
			<p><strong>Price:</strong> $<?php echo $menu_item['price']; ?></p>
			<p><strong>Description:</strong> <?php echo $menu_item['description']; ?></p>
			<img src="file/<?php echo $menu_item['image_path']; ?>" alt="Menu Item Image" style="max-width: 300px;"><br><br>

			<form method="POST" action="menu_details_user.php?id=<?php echo $menu_id; ?>">
				<input type="hidden" name="menu_item_id" value="<?php echo $menu_item['id']; ?>">
				<input type="submit" name="add_to_cart" value="Add to Cart" class="btn btn-secondary"><br><br>
			</form>
			<form method="POST" action="menu_details_user.php?id=<?php echo $menu_id; ?>">
				<input type="hidden" name="menu_item_id" value="<?php echo $menu_item['id']; ?>">
				<input type="submit" name="remove_from_cart" value="Remove from Cart" class="btn btn-secondary"><br><br>
			</form>

            <!-- Add a button to go back to the menu -->
            <a href="menu2.php" class="btn btn-primary">Back to Menu</a>
        </section>
		</div>
		<div class="table-responsive">
			<table>
				<tr>
					<th>Name</th>
					<th>Price</th>
					<th>Quantity</th>
					<th>Action</th>
				</tr>
				<?php
				foreach ($_SESSION['cart'] as $menu_item_id => $item) {
					echo '<tr>';
					echo '<td>' . $item['name'] . '</td>';
					echo '<td>' . '$' . $item['price'] . '</td>';
					echo '<td>' . $item['quantity'] . '</td>';
					echo '<td>
							<form method="POST" action="menu2.php">
								<input type="hidden" name="menu_item_id" value="' . $menu_item_id . '">
								<button type="submit" name="remove_from_cart">Remove</button>
							</form>
						</td>';
					echo '</tr>';
				}
				?>
			</table>
		</div>
	</div>
	<!-- End Menu -->
</body>
</html>
