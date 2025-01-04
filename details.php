<?php
session_start();

// Database connection
$host = "localhost";
$username = "root";
$password = "";
$db = "users";
$conn = new mysqli($host, $username, $password, $db);

if ($conn->connect_error) {
    die("<div class='alert alert-danger mt-3'>Connection failed: " . $conn->connect_error . "</div>");
}

if (!isset($_SESSION['logged in']) || $_SESSION['logged in'] !== true) {
    // If the user is not logged in, redirect to the login page
    header('Location: login.php');
    exit;
}
$id=isset($_GET['id']) ? $_GET['id'] : die('ERROR: Record ID not found');

$sql= "SELECT id, description, title,original_image_path FROM portfolio WHERE id = $id";
$result = $conn -> query($sql);
if($result->num_rows > 0){
    $row= $result->fetch_assoc();
    $id=$row['id'];
    $description=$row['description'];
    $titles=$row['title'];
    $original_image_path=$row['original_image_path'];
}
else{
    echo "<div class='alert alert-warning mt-3'>No data found</div>";
}
?>

<?php 
$title = "Portfolio Details";
require 'partials/bars/_nav.php'?>
<div class="text-center" style="width: auto; padding: 10px; border-radius: 10px; ">
        <div class="card">
            <div class="card-body" style="width: auto; padding: 10px; border-radius: 10px; margin:40px auto ;">
                <h5 class="card-title" style="text-align: center; font-weight: bold;"><?php echo $titles; ?></h5>
                <p class="card-text" style="text-align: center; font-weight: bold;"><?php echo $description; ?></p>
                <img src="<?php echo $original_image_path; ?>" class="card-img-top"  alt="Portfolio Image">

            </div>
        </div>
    </div>
    <?php require 'partials/bars/footer.php'?>

