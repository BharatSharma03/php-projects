<?php
session_start();

// Database connection
$host = "localhost";
$username = "root";
$password = "";
$db = "users";
$conn = new mysqli($host, $username, $password, $db);

if ($conn->connect_error) {
    die("<div class='alert alert-danger mt-3'>Connection failed: " . $conn->connect_error . "</div>");
}

if (!isset($_SESSION['logged in']) || $_SESSION['logged in'] !== true) {
    // If the user is not logged in, redirect to the login page
    header('Location: login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form data
    $id = $_POST['id'];
    $title = htmlspecialchars(trim($_POST['title']));
    $description = htmlspecialchars(trim($_POST['description']));

    // Fetch current paths from the database
    $stmt = $conn->prepare("SELECT original_image_path, thumbnail_image_path FROM portfolio WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    if (!$row) {
        echo "<div class='alert alert-danger mt-3'>Record not found</div>";
        exit;
    }

    $original_image_path = $row['original_image_path'];
    $thumbnail_image_path = $row['thumbnail_image_path'];

    // Handle original image upload
    if (isset($_FILES['original_image']) && $_FILES['original_image']['error'] === 0) {
        $directory = "partials/images_crousal/originals/";
        $filename = basename($_FILES['original_image']['name']);
        $newFilename = time() . "_original_" . $filename;
        $newPath = $directory . $newFilename;

        // Ensure directory exists
        if (!is_dir($directory)) {
            mkdir($directory, 0777, true);
        }

        if (move_uploaded_file($_FILES['original_image']['tmp_name'], $newPath)) {
            $original_image_path = $newPath;
        } else {
            echo "<div class='alert alert-warning mt-3'>Failed to upload original image.</div>";
        }
    }

    // Handle thumbnail image upload
    if (isset($_FILES['thumbnail_image']) && $_FILES['thumbnail_image']['error'] === 0) {
        $directory = "partials/images_crousal/thumbnails/";
        $filename = basename($_FILES['thumbnail_image']['name']);
        $newFilename = time() . "_thumbnail_" . $filename;
        $newPath = $directory . $newFilename;

        // Ensure directory exists
        if (!is_dir($directory)) {
            mkdir($directory, 0777, true);
        }

        if (move_uploaded_file($_FILES['thumbnail_image']['tmp_name'], $newPath)) {
            $thumbnail_image_path = $newPath;
        } else {
            echo "<div class='alert alert-warning mt-3'>Failed to upload thumbnail image.</div>";
        }
    }

    // Update the record in the database
    $stmt = $conn->prepare(
        "UPDATE portfolio SET title = ?, description = ?, original_image_path = ?, thumbnail_image_path = ? WHERE id = ?"
    );
    $stmt->bind_param("ssssi", $title, $description, $original_image_path, $thumbnail_image_path, $id);

    if ($stmt->execute()) {
        echo "<div class='alert alert-success mt-3'>Update successful!</div>";
        header("Location: manage_portfolio.php");
        exit;
    } else {
        echo "<div class='alert alert-danger mt-3'>Update failed. Error: " . $stmt->error . "</div>";
    }
}

$conn->close();
?>
