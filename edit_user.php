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

$stmt = $conn->prepare("SELECT id, name, email, role FROM user WHERE id = ?");
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
    <div class="container">
      <nav>
        <a href="user_manage.php">Back</a>
      </nav>
    </div>

    <form action="update_user.php" method="post">
        <div class="mb-3">
            <label for="id" class="form-label">ID</label>
            <input type="hidden" name="id" value="<?php echo $user['id'];?>">
        </div>
        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" name="name" value="<?php echo $user['name'];?>">
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" name="email" value="<?php echo $user['email'];?>">
        </div>
        <div class="mb-3">
            <label for="role" class="form-label">Role</label>
            <select name="role">
              <option name="role" value="admin" <?php echo ($user['role']=="admin" ? "selcected" :"");?>>admin</option>
              <option  name="role" value="user" <?php echo ($user['role']=="user" ? "selcected" :"");?>>user</option>
            </select>
            <!-- <input type="text" name="role" value="?php echo $user['role'];?>"> -->
        </div>
        <button type="submit" name="btn" value="set" class="btn btn-primary">Save</button>
    </form>

    <?php require 'partials/bars/footer.php'; ?>
  </body>
</html>