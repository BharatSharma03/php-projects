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

  <?php 
  $title = "Add Portfolio Item";
  require 'partials/bars/_nav.php'; ?>
    <div class="bg-light" style="margin-top:20px;">
    <form action="add_portfolio_item.php" method="post" enctype="multipart/form-data"  class="mx-auto p-4 border rounded" style="width: 90%; max-width: 800px;">
        
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
    </div>
    <br>

    
    
<div class="text-center">
    <a href="admin_dashboard.php" class="btn btn-secondary">Back to dashboard</a>
</div>
<br>

    <?php require 'partials/bars/footer.php';?>

