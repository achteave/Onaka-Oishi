<?php
require 'db.php';
if (isset($_SESSION["id"])) {
  $id = $_SESSION["id"];
  // Menggunakan prepared statement untuk menghindari SQL Injection
  $query = "SELECT * FROM tb_user WHERE id = ?";
  $stmt = mysqli_prepare($conn, $query);
  mysqli_stmt_bind_param($stmt, "i", $id); // 'i' berarti integer
  mysqli_stmt_execute($stmt);
  $result = mysqli_stmt_get_result($stmt);
  $user = mysqli_fetch_assoc($result);
  mysqli_stmt_close($stmt);
}
else {
  header("Location: login.php");
}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Index</title>
  </head>
  <body>
    <h1>Welcome <?php echo $user["name"]; ?></h1>
    <a href="logout.php">Logout</a>
  </body>
</html>
