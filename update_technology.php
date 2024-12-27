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
    $technology_id = $_POST['technology']; // Assuming this is a single selected technology ID

    // Fetch current portfolio details
    $stmt = $conn->prepare("SELECT title, description FROM portfolio WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    // Prepare and execute the query to update the portfolio table
    $stmt2 = $conn->prepare("UPDATE portfolio SET title = ?, description = ? WHERE id = ?");
    $stmt2->bind_param("ssi", $title, $description, $id);

    if ($stmt2->execute()) {
        // Update successful, now update portfolio_technologies table
        $stmt3 = $conn->prepare("UPDATE portfolio_technologies SET technology_id = ? WHERE portfolio_id = ?");
        $stmt3->bind_param("ii", $technology_id, $id);

        if ($stmt3->execute()) {
            echo "<div class='alert alert-success mt-3'>Update successful!</div>";
            header("Location: manage_technologies.php");
            exit;
        } else {
            echo "<div class='alert alert-danger mt-3'>Technology update failed. Error: " . $stmt3->error . "</div>";
        }
    } else {
        echo "<div class='alert alert-danger mt-3'>Update failed. Error: " . $stmt2->error . "</div>";
    }
}

$conn->close();
?>
