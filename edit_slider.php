<?php
session_start();
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

$id = $_GET['id'];  // Assuming you're getting the ID from a POST request

$stmt = $conn->prepare("SELECT id, title, description, path FROM slider WHERE id = ?");
$stmt->bind_param("i", $id);  // Bind the user input ID parameter
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
} else {
    echo "<div class='alert alert-warning mt-3'>No data found</div>";
}


// Close the statement and the connection
$stmt->close();
$conn->close();
?>
 <?php
 $title = "Edit Slider";
  require 'partials/bars/_nav.php'; ?>
  <div class="bg-light" style="margin: 10px; padding: 10px;">
    <form action="update_slider.php" method="post" enctype="multipart/form-data" class="mx-auto p-4 border rounded" style="width: 90%; max-width: 800px;">
        <div class="m-3">
            <label for="id" class="form-label">ID</label>
            <input type="hidden" name="id" value="<?php echo $user['id'];?>">
        </div>
        <div class="m-3">
            <label for="title" class="form-label">Title</label>
            <input type="text" name="title" value="<?php echo $user['title'];?>" class="form-control">
        </div>
        <div class="m-3">
            <label for="description" class="form-label">Description</label>
            <input type="text" name="description" value="<?php echo $user['description'];?>" class="form-control">
        </div>
        <div class="m-3">
            <label for="path" class="form-label">Path</label>
            <input type="file" name="file" class="form-control">
            <p>Current Image: <img src="<?php echo $user['path']; ?>" alt="Current Slider Image" width="100"></p>
        </div>

        <div class="text-center m-3">
            <button type="submit" name="btn" value="set" class="btn btn-primary">Save</button>
        </div>
    </form>
</div>

<br>

<div class="text-center">
    <a href="slider.php" class="btn btn-secondary">Back to manage slider</a>
</div>
<br>

    <?php require 'partials/bars/footer.php'; ?>
 