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
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit Portfolio</title>
    <link href="partials/css/user_manage.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  </head>
  <body>
    <div class="container">
      <nav>
        <a href="admin_dashboard.php" style="text-decoration:none;">Back</a>
      </nav>
    </div>
    
    <form action="add_portfolio_item.php" method="post" enctype="multipart/form-data">
        
        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input type="text" name="title"  required class="form-control">
        </div>
        
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <input type="text" name="description"  required class="form-control">
        </div>
        
        <div class="mb-3">
            <label for="original_image" class="form-label">Original Image</label>
            <input type="file" name="original_image" class="form-control">
            
        </div>
        
        <div class="mb-3">
            <label for="thumbnail_image" class="form-label">Thumbnail Image</label>
            <input type="file" name="thumbnail_image" class="form-control">
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
        <button type="submit" class="btn btn-primary">Add</button>
    </form>

    <?php require 'partials/bars/footer.php';?>
  </body>
</html>
