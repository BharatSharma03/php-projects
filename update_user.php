<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>User Management</title>
    <link href="partials/css/user_manage.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  </head>
  <body>
    <div class="container">
      <nav>
        <a href="edit_user.php">Back</a>
      </nav>
    </div>

    <form action="" method="post">
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

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $role = $_POST['role'];

    $stmt = $conn->prepare("UPDATE user SET name=?, email=?, role=? WHERE id=?");
    $stmt->bind_param("sssi", $name, $email, $role, $id);

    if ($stmt->execute()) {
        echo "<div class='alert alert-success mt-3'>Update successful!</div>";
        if (headers_sent()) {
            echo "<script>window.location.href='user_manage.php';</script>";
        } else {
            header("Location: user_manage.php");
            exit();
        }
    } else {
        echo "<div class='alert alert-danger mt-3'>Update failed!</div>";
    }

    $stmt->close();
}
$conn->close();
?>

    </form>

    <?php require 'partials/bars/footer.php'; ?>
  </body>
</html>
