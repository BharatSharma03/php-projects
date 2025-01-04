 <?php 
 $title = "Slider";
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
          echo "<div class='wrapper' style='margin:30px;'>
                <div class='table-responsive'>
                <table class='table table-bordered mt-3'>
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

          echo "</tbody></table></div></div>";
        } else {
          echo "<div class='alert alert-warning mt-3'>No data found</div>";
        }

        // Close the statement and the connection
        $stmt->close();
        $conn->close();
      ?>
    </form>
    <div class="text-center"><span>
      <a href="admin_dashboard.php" class="btn btn-primary">Back to Dashboard</a>
    </span></div><br>

    <?php require 'partials/bars/footer.php'; ?>
 