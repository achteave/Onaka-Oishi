<?php
require 'db.php';

if (isset($_POST["submit"])) {
  $Firstname = mysqli_real_escape_string($conn, $_POST["Firstname"]);
  $Lastname = mysqli_real_escape_string($conn, $_POST["Lastname"]);
  $name = mysqli_real_escape_string($conn, $_POST["name"]);
  $email = mysqli_real_escape_string($conn, $_POST["email"]);
  $password = password_hash($_POST["password"], PASSWORD_DEFAULT); // Hash the password
  $Gender = mysqli_real_escape_string($conn, $_POST["Gender"]);
  $birthdate = $_POST["birthdate"];

  // Check for duplicate email
  $checkEmail = "SELECT * FROM tb_user WHERE email = ?";
  $stmt = mysqli_prepare($conn, $checkEmail);
  mysqli_stmt_bind_param($stmt, "s", $email);
  mysqli_stmt_execute($stmt);
  $result = mysqli_stmt_get_result($stmt);

  if (mysqli_num_rows($result) > 0) {
    echo "<script> alert('Email Has Already Been Taken'); </script>";
  } else {
    // Insert user data into the database using prepared statements
    $insertQuery = "INSERT INTO tb_user (name, email, password, Firstname, Lastname, birthdate, gender) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $insertQuery);
    mysqli_stmt_bind_param($stmt, "sssssss", $name, $email, $password, $Firstname, $Lastname, $birthdate, $Gender);

    if (mysqli_stmt_execute($stmt)) {
      echo "<script> alert('Registration Successful'); </script>";
    } else {
      echo "Error: " . $insertQuery . "<br>" . mysqli_error($conn);
    }
  }
}
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="style.css" />
    <title>Registration</title>
  </head>
  <body>
    <div class="container">
      <div class="box form-box">
        <header>Register</header>
        <form action="" method="post">
          <div class="field input">
            <label for="Firstname">First Name</label>
            <input type="text" name="Firstname" value=""> <br>
          </div>

          <div class="field input"> 
            Last Name <input type="text" name="Lastname" value=""> <br> 
          </div>

          <div class="field input"> 
            Tanggal Lahir <input type="date" name="birthdate" value=""> <br>
          </div>
      
          <div class="field input"> 
            User Name <input type="text" name="name" value=""> <br>
          </div>

          <div class="field input"> 
            Email <input type="email" name="email" value=""> <br>
          </div>

          <div class="field input"> 
            Password <input type="password" name="password" value=""> <br>
          </div>

          <div class="field input"> 
            <label for="Gender">Gender:</label>
            <select class="gender" name="Gender" id="Gender">
            <option value="male">Laki-laki</option>
            <option value="female">Perempuan</option>
            </select>          
          </div>
      
          <div class="field"> 
              <button type="submit" class="btn" name="submit">Register</button>
          </div>

          <div class="links">
              Already have account? <a href="login.php">Log In</a>
          </div>

        </form>
      </div>
    </div>
</html>
