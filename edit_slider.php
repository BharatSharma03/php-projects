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

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>edit_user</title>
    <link href="partials/css/user_manage.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  </head>
  <body>
  <?php require 'partials/bars/_nav.php'; ?>
    <div class="container">
      <nav>
        <a href="slider.php">Back</a>
      </nav>
    </div>
    <form action="update_slider.php" method="post" enctype="multipart/form-data">
    <div class="mb-3">
        <label for="id" class="form-label">ID</label>
        <input type="hidden" name="id" value="<?php echo $user['id'];?>">
    </div>
    <div class="mb-3">
        <label for="title" class="form-label">Title</label>
        <input type="text" name="title" value="<?php echo $user['title'];?>">
    </div>
    <div class="mb-3">
        <label for="description" class="form-label">Description</label>
        <input type="text" name="description" value="<?php echo $user['description'];?>">
    </div>
    <div class="mb-3">
        <label for="path" class="form-label">Path</label>
        <input type="file" name="file" class="form-control">
        <p>Current Image: <img src="<?php echo $user['path']; ?>" alt="Current Slider Image" width="100"></p>
    </div>

    <button type="submit" name="btn" value="set" class="btn btn-primary">Save</button>
</form>


    <?php require 'partials/bars/footer.php'; ?>
  </body>
</html>
