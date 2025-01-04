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
 <?php 
 $title="Login";
 require 'partials/bars/_nav.php'; ?>

<div class=" bg-light" style="width:auto; padding: 10px; border-radius: 10px; margin:40px auto ;>">
        <h1 class="text-center" style="padding:30px;">Login to our website</h1>

        <!-- Form -->
        <form action="" method="post"  class="mx-auto p-3 border rounded" style="width:auto;">
            <div class="m-3">
                <label for="exampleInputEmail1" class="form-label">Email address</label>
                <input type="email" name="email" class="form-control" id="exampleInputEmail1" required>
            </div>
            <div class="m-3">
                <label for="exampleInputPassword1" class="form-label">Password</label>
                <input type="password" name="password" class="form-control" id="exampleInputPassword1" required>
            </div>
            <br>
            <div class="text-center">
            <button type="submit" class="btn btn-primary" name="btn" value="set">Login</button>
            </div><br>
            
        </form>
    </div>

    <?php require 'partials/bars/footer.php'; ?>
