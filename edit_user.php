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
  <?php
  $title = "Edit User";
   require 'partials/bars/_nav.php'; ?>
    
<div class="bg-light" style="margin: 20px; padding: 10px;">
    <form action="update_user.php" method="post" class="mx-auto p-4 border rounded" style="width: 90%; max-width: 800px;">
        <div class="m-3">
            <label for="id" class="form-label">ID</label>
            <input type="hidden" name="id" value="<?php echo $user['id'];?>">
        </div>
        <div class="m-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" name="name" value="<?php echo $user['name'];?>" class="form-control">
        </div>
        <div class="m-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" name="email" value="<?php echo $user['email'];?>" class="form-control">
        </div>
        <div class="m-3">
            <label for="role" class="form-label">Role</label>
            <select name="role" class="form-select">
                <option value="admin" <?php echo ($user['role']=="admin" ? "selected" : "");?>>admin</option>
                <option value="user" <?php echo ($user['role']=="user" ? "selected" : "");?>>user</option>
            </select>
        </div>
        <div class="text-center m-3">
            <button type="submit" name="btn" value="set" class="btn btn-primary">Save</button>
        </div>
    </form>
</div>

<br>

<div class="text-center">
    <a href="user_manage.php" class="btn btn-secondary">Back to manage user</a>
</div>
<br>


    <?php require 'partials/bars/footer.php'; ?>
  </body>
</html>