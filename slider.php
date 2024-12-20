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

        $stmt = $conn->prepare("SELECT id, title, description, path  FROM slider");
        $stmt->execute();
        $result = $stmt->get_result();
        $data = $result->fetch_all(MYSQLI_ASSOC);

        if (count($data) > 0) {
          echo "<table class='table table-bordered mt-3'>
                  <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>description</th>
                    <th>path</th>
                    <th>Actions</th>
                  </tr>";

          // Loop through the data and display rows
          foreach ($data as $row) {
            echo "<tr>
                    <td>" . $row['id'] . "</td>
                    <td>" . $row['title'] . "</td>
                    <td>" . $row['description'] . "</td>
                    <td>" . $row['path'] . "</td>
                    <td><a href='edit_slider.php?id=" . $row['id'] . "' target='_parent' class='w3-bar-item w3-button'>Edit</a></td>
                  </tr>";
          }

          echo "</table>";

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
