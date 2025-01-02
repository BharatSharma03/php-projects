<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>User Management</title>
    <!-- <link href="partials/css/user_manage.css" rel="stylesheet"> -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" 
      integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  </head>
  <body>
  <?php require 'partials/bars/_nav.php'; ?>
    <div class="container">
      <nav>
        <a href="admin_dashboard.php">Back</a>
      </nav>
    </div>

    <form action="" method="post">
      <?php
        session_start();
        $host = "localhost";
        $username = "root";
        $password = "";
        $db = "users";

        // Establish database connection
        $conn = new mysqli($host, $username, $password, $db);

        if ($conn->connect_error) {
          die("<div class='alert alert-danger mt-3'>Connection failed: " . $conn->connect_error . "</div>");
        }
        if (!isset($_SESSION['logged in']) || $_SESSION['logged in'] !== true) {
          // If the user is not logged in, redirect to the login page
          header('Location: login.php');
          exit;
        }
        

        // Handle deletion
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_id'])) {
          $id = intval($_POST['delete_id']); // Sanitize input
          if ($id > 0) { // Ensure valid ID
            $sql = "DELETE FROM slider WHERE id = ?";
            $stmt = $conn->prepare($sql);
            if ($stmt) {
              $stmt->bind_param("i", $id); // Bind parameter
              if ($stmt->execute()) {
                echo "<div class='alert alert-success mt-3'>Record deleted successfully</div>";
                header("Location: slider.php");
                exit();
              } else {
                echo "<div class='alert alert-danger mt-3'>Error deleting record: " . $stmt->error . "</div>";
              }
              $stmt->close();
            } else {
              echo "<div class='alert alert-danger mt-3'>Error preparing statement: " . $conn->error . "</div>";
            }
          } else {
            echo "<div class='alert alert-warning mt-3'>Invalid ID provided.</div>";
          }
        }

        // Fetch data from the database
        $stmt = $conn->prepare("SELECT id, title, description, path FROM slider");
        $stmt->execute();
        $result = $stmt->get_result();
        $data = $result->fetch_all(MYSQLI_ASSOC);

        // Display data in a table
        if (count($data) > 0) {
          echo "<table class='table table-bordered mt-3'>
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Title</th>
                      <th>Description</th>
                      <th>Path</th>
                      <th>Actions</th>
                    </tr>
                  </thead>
                  <tbody>";

          foreach ($data as $row) {
            echo "<tr>
                    <td>" . htmlspecialchars($row['id']) . "</td>
                    <td>" . htmlspecialchars($row['title']) . "</td>
                    <td>" . htmlspecialchars($row['description']) . "</td>
                    <td>" . htmlspecialchars($row['path']) . "</td>
                    <td>
                      <a href='edit_slider.php?id=" . htmlspecialchars($row['id']) . "' class='btn btn-primary'>Edit</a>
                      <form action='' method='POST' style='display:inline; margin-left: 5px;'>
                        <input type='hidden' name='delete_id' value='" . htmlspecialchars($row['id']) . "'>
                        <button type='submit' class='btn btn-danger'>Delete</button>
                      </form>
                    </td>
                  </tr>";
          }

          echo "</tbody></table>";
        } else {
          echo "<div class='alert alert-warning mt-3'>No data found</div>";
        }

        // Close the statement and the connection
        $stmt->close();
        $conn->close();
      ?>
    </form>

    <?php require 'partials/bars/footer.php'; ?>
  </body>
</html>
