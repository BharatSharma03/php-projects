<?php
session_start(); // Start session at the top
if (!isset($_SESSION['logged in']) || $_SESSION['logged in'] !== true) {
  // If the user is not logged in, redirect to the login page
  header('Location: login.php');
  exit;
}

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

<?php
$title = 'User Information';
 require 'partials/bars/_nav.php' ?>
<div class=" bg-light" style="width: auto; border-radius: 10px; padding:10px; margin:50px;">
    <h1 class="text-center" style="padding:20px;"><b>User Information</b></h1>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <!-- Form for logout -->
    <form action="" method="POST">
    
    <?php
        $sql = "SELECT name, email FROM user WHERE email='{$_SESSION['email']}'";
        $result = $conn->query($sql);
        
        if ($result->num_rows > 0) {
          $row = $result->fetch_assoc();
          echo "<div style='width: auto; padding: 10px; border-radius: 10px; margin:  auto;'>
                  <h3>User Information:</h3>
                  <table class='table table-bordered m-3'>
                      <tr><th>Username</th><th>Email</th></tr>
                      <tr><td>" . $row['name'] . "</td>
                      <td>" . $row['email'] . "</td></tr>
                  </table>
                </div>";
          echo "<br/>";
          echo "<div class='alert alert-success m-3'>Redirecting...to login page in 5 sec</div>";
          header("Refresh: 5; URL=login.php");
          exit();
      }
      
        ?>
        <br>
        <!-- <button type="submit" name="btn" value="logout" class="btn btn-primary">Logout</button> -->
        </form>
    </div>
<?php require 'partials/bars/footer.php'; ?>
