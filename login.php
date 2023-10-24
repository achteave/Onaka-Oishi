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

if (isset($_POST["submit"])) {
    $email = $_POST["email"];
    $password = $_POST["password"];

    // Check for user with the given email
    $checkEmail = "SELECT id, email, password FROM tb_user WHERE email = ?";
    $stmt = mysqli_prepare($conn, $checkEmail);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $captcha = $_POST["captcha"];
    $confirmcaptcha = $_POST["confirmcaptcha"];

    if ($captcha != $confirmcaptcha) {
        echo "<script> alert('Incorrect Captcha'); </script>";
    } else {
        if ($row = mysqli_fetch_assoc($result)) {
            // Verify the password
            if (password_verify($password, $row["password"])) {
                $_SESSION["id"] = $row["id"];
                
                if ($email === "admin123@gmail.com" && $password === "aaddmmiinn") {
                    // Admin user
                    header("Location: admin.php");
                } else {
                    // Regular user
                    header("Location: home.php");
                }
            } else {
                echo "<script> alert('Wrong Password'); </script>";
            }
        } else {
            echo "<script> alert('Email not found'); </script>";
        }
    }

}
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="utf-8">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="style.css" />
    <title>Login</title>
</head>
<style media="screen">
    *{
        user-select: none;
    }
    input.captcha{
        pointer-events: none;
        letter-spacing: 12px;
    }
</style>
<body>
    <div class="container">
        <div class="box form-box">
            <header>Login</header>
            <form action="" method="post">
                <div class="field input"> 
                    <label for="email">Email</label>
                    <input type="text" name="email" value="">
                </div>

                <div class="field input"> 
                    <label for="password">Password</label>
                    <input type="password" name="password" value="">
                </div>

                <div class="field input"> 
                    <input type="text" class="captcha" name="captcha" value="<?php echo substr(uniqid(), 5); ?>"> <br>
                    <input type="text" name="confirmcaptcha" placeholder="Captcha" value=""> <br>
                </div>
            
                <div class="field"> 
                    <button type="submit" class="btn" name="submit">Login Now</button>
                </div>
                

                <div class="links">
                    Don't have an account? <a href="registration.php">Sign Up</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>