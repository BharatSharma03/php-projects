<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete User</title>
</head>
<body>
    <form method="POST" action="">
        <label for="id">User ID to delete:</label>
        <input type="number" id="id" name="id" required>
        <button type="submit">Delete User</button>
    </form>

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

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Validate and sanitize the input
            $id = intval($_POST['id']); // Ensure the ID is an integer

            // Prepare the DELETE statement
            $sql = "DELETE FROM user WHERE id = ?";
            $stmt = $conn->prepare($sql);
            if ($stmt) {
                $stmt->bind_param("i", $id); // Bind the ID as an integer
                if ($stmt->execute()) {
                    echo "<div>Record deleted successfully</div>";
                    header("Location: user_manage.php");
                    exit();
                } else {
                    echo "<div>Error deleting record: " . $stmt->error . "</div>";
                }
                $stmt->close();
            } else {
                echo "<div>Error preparing statement: " . $conn->error . "</div>";
            }
        }

        $conn->close();
    ?>
</body>
</html>
