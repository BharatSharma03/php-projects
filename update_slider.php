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

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form data
    $id = $_POST['id'];
    $title = htmlspecialchars(trim($_POST['title']));
    $description = htmlspecialchars(trim($_POST['description']));

    // Fetch current path from the database
    $stmt = $conn->prepare("SELECT path FROM slider WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $currentPath = $row['path'];  // Existing path in the database

    // Debugging - output current path
    echo "Current path: " . $currentPath;
    
    // Initialize $path with current path
    $path = $currentPath;

    // Check if file is being uploaded
    if (isset($_FILES['file']) && $_FILES['file']['error'] == 0) {
        echo "File upload detected.<br>";

        $directory = "partials/images_crousal/";  // Path to the images folder

        // Check if the directory exists, create it if not
        // if (!is_dir($directory)) {
        //     mkdir($directory, 0777, true); // Create directory if it doesn't exist
        // }

        $filename = basename($_FILES['file']['name']);
        // Add a timestamp to the filename to avoid conflicts
        $newFilename = time() . "_" . $filename;
        $newPath = $directory . $newFilename;  // Relative path

        // Check if the file is moved successfully
        if (move_uploaded_file($_FILES['file']['tmp_name'], $newPath)) {
            echo "File uploaded successfully: " . $newPath . "<br>";
            $path = $newPath;  // Update path with the new image path
        } else {
            echo "File upload failed.<br>";
        }
    }

    // Debugging - log the new path
    echo "New path: " . $path . "<br>";

    // Update the slider record in the database with the correct path
    $stmt = $conn->prepare("UPDATE slider SET title = ?, description = ?, path = ? WHERE id = ?");
    $stmt->bind_param("sssi", $title, $description, $path, $id);

    if ($stmt->execute()) {
        echo "<div class='alert alert-success mt-3'>Update successful!</div>";
        // Temporarily remove the redirect for debugging`
        header("Location: slider.php");  // Redirect after success
    } else {
        echo "<div class='alert alert-danger mt-3'>Update failed. Please try again.</div>";
    }
}

// Close the connection
$stmt->close();
$conn->close();
?>
