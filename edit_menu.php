<?php
require 'db.php';

// Check if the user is logged in
if (!isset($_SESSION["id"])) {
    header("Location: login.php");
    exit();
}

// Fetch user details
$user_id = $_SESSION["id"];
$user = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM tb_user WHERE id = $user_id"));

// Check if the user has admin role
if ($user['email'] !== 'admin123@gmail.com') {
    header("Location: index.php"); // Redirect regular users to index.php
    exit();
}

// Check if the "id" parameter is provided in the URL
if (isset($_GET['id'])) {
    $menu_id = $_GET['id'];

    // Query the database to retrieve the menu item details
    $sql = "SELECT * FROM menu_items WHERE id = $menu_id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $menu_item = $result->fetch_assoc();
    } else {
        // Redirect if the menu item with the provided ID doesn't exist
        header("Location: admin.php");
        exit();
    }
} else {
    // Redirect if the "id" parameter is missing
    header("Location: admin.php");
    exit();
}

// Handle form submission for updating the menu item
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $price = $_POST["price"];
    $description = $_POST["description"];

    // Update the menu item in the database
    $update_sql = "UPDATE menu_items SET name = ?, price = ?, description = ? WHERE id = ?";
    $stmt = $conn->prepare($update_sql);
    $stmt->bind_param("sssi", $name, $price, $description, $menu_id);

    if ($stmt->execute()) {
        // Redirect back to the admin page after successful update
        header("Location: admin.php");
        exit();
    } else {
        // Handle the case where the update fails
        echo "Error updating menu item: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Add your HTML head content here -->
</head>
<body>
    <!-- Add your HTML body content here -->
    <h1>Edit Menu Item</h1>
    <form method="POST" action="edit_menu.php?id=<?php echo $menu_id; ?>">
        <div>
            <label for="name">Name:</label>
            <input type="text" name="name" value="<?php echo $menu_item['name']; ?>" required>
        </div>
        <div>
            <label for="price">Price:</label>
            <input type="number" name="price" value="<?php echo $menu_item['price']; ?>" required>
        </div>
        <div>
            <label for="description">Description:</label>
            <textarea name="description" required><?php echo $menu_item['description']; ?></textarea>
        </div>
        <div>
            <button type="submit">Update Menu Item</button>
        </div>
    </form>
</body>
</html>

