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

        // Fetch user data for editing
        if (isset($_GET['id'])) {
          $id = $_GET['id'];

          $stmt = $conn->prepare("SELECT id, name, email, role FROM user WHERE id = ?");
          $stmt->bind_param("i", $id);  // Bind the user ID parameter
          $stmt->execute();
          $result = $stmt->get_result();
          $user = $result->fetch_assoc();

          // Check if user data is found
          if (!$user) {
            echo "<div class='alert alert-warning mt-3'>No user found with the provided ID.</div>";
          }
        }

        // Update the user data
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
          $id = $_POST['id'];
          $title = $_POST['title'];
          $desciption = $_POST['description'];
          $path = $_POST['path'];

          $stmt = $conn->prepare("UPDATE slider SET title = ?, description = ?, path = ? WHERE id = ?");
          $stmt->bind_param("sssi", $title, $desciption, $path, $id);  // Bind parameters
          
          if ($stmt->execute()) {
            echo "<div class='alert alert-success mt-3'>Update successful!</div>";
            header("Location: slider.php");  // Redirect to user management page
            exit();
          } else {
            echo "<div class='alert alert-danger mt-3'>Update failed. Please try again.</div>";
          }
        }

        // Close the statement and the connection
        $stmt->close();
        $conn->close();
      ?>