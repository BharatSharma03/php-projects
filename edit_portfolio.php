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

$id = $_GET['id'];  // Assuming you're getting the ID from the GET request

$stmt = $conn->prepare("SELECT id, title ,description FROM portfolio WHERE id = ?");
$stmt->bind_param("i", $id); // Bind the ID parameter
$stmt->execute();
$result = $stmt->get_result();


$stmt2 = $conn->prepare("SELECT portfolio_id  FROM portfolio_technologies WHERE id = ?");
$stmt2->bind_param("i", $id); // Bind the ID parameter
$stmt2->execute();
$result2 = $stmt2->get_result();

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
} else {
    echo "<div class='alert alert-warning mt-3'>No data found</div>";
}

$stmt->close();
$conn->close();
?>
<?php
$title="edit portfolio";
require 'partials/bars/_nav.php'; ?>
  <div class="wrapper" style="margin:20px 150px; padding:20px">
    <form action="update_portfolio.php" method="post" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="id" class="form-label">ID</label>
            <input type="hidden" name="id" value="<?php echo $user['id'];?>">
        </div>
        
        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input type="text" name="title" value="<?php echo $user['title'];?>" require class="form-control">
        </div>
        
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <input type="text" name="description" value="<?php echo $user['description'];?>" required class="form-control">
        </div>
        <div>
            <label for="technology" class="form-label">Technology</label>
            <select name="technology" value=" disabled selected" class="form-select">
                <option value="php">php</option>
                <option value="python">python</option>
                <option value="java">java</option>
            </select>
        </div>
        <br>

        <button type="submit" class="btn btn-primary">Save</button>
    </form>

    <br>
  </div>    
   

<div class="text-center">
    <a href="manage_portfolio.php" class="btn btn-secondary">Back to manage slider</a>
</div>
<br> 
    <?php require 'partials/bars/footer.php';?>
  </body>
</html>
