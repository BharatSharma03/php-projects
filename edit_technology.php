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

$id = $_GET['id']; // Assuming you're getting the ID from the GET request

// Fetch portfolio details
$stmt = $conn->prepare("SELECT id, title, description FROM portfolio WHERE id = ?");
$stmt->bind_param("i", $id); // Bind the ID parameter
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
} else {
    echo "<div class='alert alert-warning mt-3'>No data found</div>";
    exit;
}

// Fetch associated technologies
$tech_stmt = $conn->prepare("
   SELECT t.id, t.name 
FROM portfolio_technologies pt
INNER JOIN technologies t ON pt.technology_id = t.id
WHERE pt.portfolio_id = ?

");
$tech_stmt->bind_param("i", $id);
$tech_stmt->execute();
$tech_result = $tech_stmt->get_result();
$technologies = [];

while ($row = $tech_result->fetch_assoc()) {
    $technologies[] = $row;
}

$tech_stmt->close();
$stmt->close();
$conn->close();
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
  <?php require 'partials/bars/_nav.php'; ?>
    <div class="container">
      <nav>
        <a href="manage_technologies.php" style="text-decoration:none;">Back</a>
      </nav>
    </div>
    
    <form action="update_technology.php" method="post" enctype="multipart/form-data">
        <div class="mb-3">
            <input type="hidden" name="id" value="<?php echo $user['id'];?>">
        </div>
        
        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input type="text" name="title" id= "title" value="<?php echo $user['title'];?>" require class="form-control">
        </div>
        
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <input type="text" name="description" id="description" value="<?php echo $user['description'];?>" required class="form-control">
        </div>
        
       

        <div class="mb-3">
            <label for="technologies" class="form-label">Technologies</label>
            
        <div>
            <select name="technology" id="technology" class="form-select">
                <option value="1">php</option>
                <option value="3">python</option>
                <option value="2">java</option>
            </select>
        </div>
        </div>

        <button type="submit" class="btn btn-primary">UPDATE TECHNOLOGY</button>
    </form>

    <?php require 'partials/bars/footer.php';?>
  </body>
</html>
