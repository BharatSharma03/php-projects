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
        <a href="admin_dashboard.php">Back</a>
      </nav>
    </div>

    <?php
      session_start();
      $host = "localhost";
      $username = "root";
      $password = "";
      $db = "users";

      // Establish connection
      $conn = new mysqli($host, $username, $password, $db);
      if ($conn->connect_error) {
        die("<div class='alert alert-danger mt-3'>Connection failed: " . $conn->connect_error . "</div>");
      }

      // Handle deletion
      if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete_id'])) {
        $id = intval($_POST['delete_id']); // Sanitize input

        $sql = "DELETE FROM user WHERE id = ?";
        $stmt = $conn->prepare($sql);
        if ($stmt) {
          $stmt->bind_param("i", $id); // Bind the parameter
          if ($stmt->execute()) {
            echo "<div class='alert alert-success'>Record deleted successfully</div>";
            header("Location: user_manage.php");
            exit();
          } else {
            echo "<div class='alert alert-danger'>Error deleting record: " . $stmt->error . "</div>";
          }
          $stmt->close();
        } else {
          echo "<div class='alert alert-danger'>Error preparing statement: " . $conn->error . "</div>";
        }
      }

      // Fetch data from the database
      $stmt = $conn->prepare("SELECT id, name, email, role FROM user");
      $stmt->execute();
      $result = $stmt->get_result();
      $data = $result->fetch_all(MYSQLI_ASSOC);

      // Display data in a table
      if (count($data) > 0) {
        echo "<table class='table table-bordered mt-3'>
                <tr>
                  <th>ID</th>
                  <th>Name</th>
                  <th>Email</th>
                  <th>Role</th>
                  <th>Actions</th>
                </tr>";

        foreach ($data as $row) {
          echo "<tr>
                  <td>" . $row['id'] . "</td>
                  <td>" . $row['name'] . "</td>
                  <td>" . $row['email'] . "</td>
                  <td>" . $row['role'] . "</td>
                  <td>
                    <a href='edit_user.php?id=" . $row['id'] . "' target='_parent' class='btn btn-primary'>Edit</a>
                    <form action='' method='POST' style='display:inline;'>
                      <input type='hidden' name='delete_id' value='" . $row['id'] . "'>
                      <button type='submit' class='btn btn-danger'>Delete</button>
                    </form>
                  </td>
                </tr>";
        }

        echo "</table>";
      } else {
        echo "<div class='alert alert-warning mt-3'>No data found</div>";
      }

      $stmt->close();
      $conn->close();
    ?>
    
    <?php require 'partials/bars/footer.php'; ?>
  </body>
</html>
