<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>User Management</title>
    <link href="partials/css/user_manage.css" rel="stylesheet">
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

        // Fetch data from the database
        $stmt = $conn->prepare("SELECT id, title, description FROM portfolio");
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
                      <th>Technologies</th>
                      <th>Actions</th>
                    </tr>
                  </thead>
                  <tbody>";

          foreach ($data as $row) {
            echo "<tr>
                    <td>" . htmlspecialchars($row['id']) . "</td>
                    <td>" . htmlspecialchars($row['title']) . "</td>
                    <td>" . htmlspecialchars($row['description']) . "</td>";

            // Fetch technologies associated with the current portfolio item using portfolio_id
            $portfolio_id = $row['id'];

            // Prepare the SQL query with DISTINCT to avoid duplicates
            $stmt2 = $conn->prepare("SELECT DISTINCT t.name 
                                      FROM Technologies t
                                      INNER JOIN portfolio_technologies pt ON t.id = pt.technology_id
                                      WHERE pt.portfolio_id = ?");
            $stmt2->bind_param("i", $portfolio_id);
            $stmt2->execute();
            $result2 = $stmt2->get_result();

            // Store technologies in an array
            $technologies = [];
            while ($tech = $result2->fetch_assoc()) {
              $technologies[] = htmlspecialchars($tech['name']); // Escape for safety
            }

            // Display technologies in the table
            echo "<td>";
            foreach ($technologies as $technology) {
              echo $technology . "<br>"; // Display each technology on a new line
            }
            echo "</td>";

            // Close the second statement
            $stmt2->close();

            echo "<td>
                    <a href='edit_technology.php?id=" . htmlspecialchars($row['id']) . "' class='btn btn-primary'>Edit</a>
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
