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

// Check if the user is logged in
if (!isset($_SESSION['logged in']) || $_SESSION['logged in'] !== true) {
    header('Location: login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = htmlspecialchars(trim($_POST['title']));
    $description = htmlspecialchars(trim($_POST['description']));
    $technology = htmlspecialchars(trim($_POST['technology']));
    $original_image_path = "";
    $thumbnail_image_path = "";

    // Check if at least one technology is selected
    if (empty($technology)) {
        die("<div class='alert alert-danger mt-3'>Please select at least one technology.</div>");
    }

    // Handle original image upload
    if (isset($_FILES['original_image']) && $_FILES['original_image']['error'] === 0) {
        $directory = "partials/images_crousal/originals/";
        $filename = basename($_FILES['original_image']['name']);
        $newFilename = time() . "_original_" . $filename;
        $newPath = $directory . $newFilename;

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

        if (!is_dir($directory)) {
            mkdir($directory, 0777, true);
        }

        if (move_uploaded_file($_FILES['thumbnail_image']['tmp_name'], $newPath)) {
            $thumbnail_image_path = $newPath;
        } else {
            echo "<div class='alert alert-warning mt-3'>Failed to upload thumbnail image.</div>";
        }
    }

  // Insert data into portfolio table
$stmt = $conn->prepare("INSERT INTO portfolio (title, description, original_image_path, thumbnail_image_path) VALUES (?, ?, ?, ?)");
$stmt->bind_param("ssss", $title, $description, $original_image_path, $thumbnail_image_path);

if ($stmt->execute()) {
    $portfolio_id = $stmt->insert_id; // Get the last inserted portfolio ID

    // Check if the technology already exists
    $stmt2 = $conn->prepare("SELECT id, name FROM technologies WHERE name = ?");
    $stmt2->bind_param("s", $technology);
    $stmt2->execute();
    $result = $stmt2->get_result();  // Execute the query and get the result

    if ($result->num_rows > 0) {
        // Technology exists, get its ID
        echo "<div class='alert alert-success mt-3'>Technology exists, fetched ID!</div>";
        $row = $result->fetch_assoc();
        $technology_id = $row['id'];
        
        // Update the technology name if necessary (for example, update the name or other fields)
        $stmt3 = $conn->prepare("UPDATE technologies SET name = ? WHERE id = ?");
        $stmt3->bind_param("si", $technology, $technology_id); // Update the name
        if ($stmt3->execute()) {
            echo "<div class='alert alert-success mt-3'>Technology updated successfully!</div>";
        } else {
            echo "<div class='alert alert-danger mt-3'>Error updating technology: " . $conn->error . "</div>";
        }
        $stmt3->close();

    // Insert into pivot table to link portfolio and technology
    $stmt5 = $conn->prepare("INSERT INTO portfolio_technologies (portfolio_id, technology_id) VALUES (?, ?)");
    $stmt5->bind_param("ii", $portfolio_id, $technology_id);
    if ($stmt5->execute()) {
        echo "<div class='alert alert-success mt-3'>Pivot record added successfully!</div>";
    } else {
        echo "<div class='alert alert-danger mt-3'>Error inserting pivot record: " . $conn->error . "</div>";
    }
    $stmt5->close();

    echo "<div class='alert alert-success mt-3'>Portfolio added successfully!</div>";
    header('Location: portfolio.php');
    exit;
} else {
    echo "<div class='alert alert-danger mt-3'>Error adding portfolio: " . $conn->error . "</div>";
}
$stmt->close();

        // Insert into Portfolio_Technologies pivot table
        $stmt3 = $conn->prepare("INSERT INTO Portfolio_Technologies (portfolio_id, technology_id) VALUES (?, ?)");
        $stmt3->bind_param("ii", $portfolio_id, $technology_id);

        if ($stmt3->execute()) {
            echo "<div class='alert alert-success mt-3'>Portfolio added successfully!</div>";
            header('Location: portfolio.php');
            exit;
        } else {
            die("<div class='alert alert-danger mt-3'>Error linking portfolio and technology: " . $stmt3->error . "</div>");
        }
    } else {
        echo "<div class='alert alert-danger mt-3'>Error adding portfolio: " . $stmt->error . "</div>";
    }
}
    $stmt->close();
?>
