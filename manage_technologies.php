<?php
$title="manage technologies";
 require 'partials/bars/_nav.php'; ?>
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
          echo "<div class='wrapper' style='margin:50px;'>
                <div class='table-responsive'>
                <table class='table table-bordered mt-3'>
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

          echo "</tbody></table></div></div>";
        } else {
          echo "<div class='alert alert-warning mt-3'>No data found</div>";
        }

        // Close the statement and the connection
        $stmt->close();
        $conn->close();
      ?>
    </form>
    <div class="text-center">
    <a href="admin_dashboard.php" class="btn btn-secondary">Back to admin dashboard</a>

</div>
<br> 

    <?php require 'partials/bars/footer.php'; ?>
  </body>
</html>
