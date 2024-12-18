<?php
session_start(); // Start session at the top
if(!isset($_SESSION['email'])){
header("Location: login.php");
}
$host = "localhost";
$username = "root";
$pass = "";
$db = "users";
$conn = new mysqli($host, $username, $pass, $db);

if ($conn->connect_error) {
    die("Some error: " . $conn->connect_error);
}





// $conn->close();

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Home</title>
  
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
  <?php require 'partials/_nav.php' ?>

  <div class="container">
    <h1 class="text-center">User Information</h1>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <!-- Form for logout -->
    <form action="" method="POST">
    
    <?php
        $sql = "SELECT name, email FROM user WHERE email='{$_SESSION['email']}'";
        $result = $conn->query($sql);
        
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            echo "User Information: 
            <table>
              <tr><td>" . $row['name'] . "</td></tr>
              <tr><td>" . $row['email'] . "</td></tr>
            </table>";
            echo "<div class='alert alert-success mt-3'>Redirecting...to login page in 5 sec</div>";
            header("Refresh: 5; URL=login.php");
            exit();
        }
        ?>
        <br>
        <!-- <button type="submit" name="btn" value="logout" class="btn btn-primary">Logout</button> -->
        </form>
  </div>
</body>
</html>
