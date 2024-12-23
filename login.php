<?php
session_start(); // Ensure session is started before any output

$host = "localhost";
$username = "root";
$password = "";
$db = "users";

$conn = new mysqli($host, $username, $password, $db);

// Check for connection error
if ($conn->connect_error) {
    die("<div class='alert alert-danger mt-3'>Connection failed: " . $conn->connect_error . "</div>");
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['btn']) && $_POST['btn'] === 'set') {
    $email = htmlspecialchars(trim($_POST['email']));
    $password = $_POST['password'];

    // Prepared statement to fetch the hashed password
    $stmt = $conn->prepare("SELECT password, role FROM user WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    // If a matching email is found
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($hashedPassword, $role);
        $stmt->fetch();

        // Verify password
        if (password_verify($password, $hashedPassword)) {
            // Store user session details
            $_SESSION['email'] = $email;
            $_SESSION['role'] = $role;
            $_SESSION['logged in'] = true;

            // Redirect based on user role
            if (strtolower($role) === "admin") { // Ensure case-insensitive comparison
                header("Location: admin_dashboard.php");
                exit();
            } else {
                header("Location: display.php");
                exit();
            }
        } else {
            echo "<div class='alert alert-danger mt-3'>Invalid email or password</div>";
        }
    } else {
        echo "<div class='alert alert-danger mt-3'>Invalid email or password</div>";
    }

    $stmt->close();
}

// Close the database connection
$conn->close();
?>


<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login</title>
    <link href="partials/css/login_footer.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <?php require 'partials/bars/_nav.php'; ?>

    <div class="container">
        <h1 class="text-center">Login to our website</h1>

        <!-- Form -->
        <form action="" method="post">
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Email address</label>
                <input type="email" name="email" class="form-control" id="exampleInputEmail1" required>
            </div>
            <div class="mb-3">
                <label for="exampleInputPassword1" class="form-label">Password</label>
                <input type="password" name="password" class="form-control" id="exampleInputPassword1" required>
            </div>
            <br><br>
            <button type="submit" class="btn btn-primary" name="btn" value="set">Login</button>
        </form>
    </div>

    <?php require 'partials/bars/footer.php'; ?>
</body>
</html>
