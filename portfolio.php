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

$name = $_GET['name'] ?? 'all'; // Default to 'all' if no 'name' is provided

if ($name === 'all') {
    $sql = "SELECT * FROM portfolio";
    $stmt = $conn->prepare($sql);
} else {
    $sql = "SELECT p.*
            FROM portfolio p
            JOIN portfolio_technologies pt ON p.id = pt.portfolio_id
            JOIN technologies t ON pt.technology_id = t.id
            WHERE LOWER(t.name) = LOWER(?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $name);
}

if ($stmt) {
    $stmt->execute();
    $result = $stmt->get_result();
    $items = $result->fetch_all(MYSQLI_ASSOC);
    $stmt->close();
} else {
    die("<div class='alert alert-danger mt-3'>Error: " . $conn->error . "</div>");
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Portfolio</title>
  <!-- Add Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <?php require 'partials/bars/portfolio_nav.php'; ?>

    <div class="container mt-5">
        <div class="row" data-masonry='{"percentPosition": true}'>
            <?php 
            // Debugging: Check the filtered 'name' and the number of items
            // echo "Filter applied: " . htmlspecialchars($name);
            if (!empty($items)) {
                foreach ($items as $item): 
                    $imagePath = $item['original_image_path'];
                    $title = htmlspecialchars($item['title']);
                    $description = htmlspecialchars($item['description']);
                    // $filepath = $item['file_path'];
            ?>
            <div class="col-lg-4 col-md-6 mb-4">
                    <div class="card">
                        <img src="<?php echo $imagePath; ?>" class="card-img-top" alt="Portfolio Image">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $title; ?></h5>
                            <p class="card-text"><?php echo $description; ?></p>
                        </div>
                    </div>
                </a>
            </div>
            <?php 
                endforeach;
            } else {
                echo "<p class='text-center mt-3'>No portfolio items found for the filter: " . htmlspecialchars($name) . ".</p>";
            }
            ?>
        </div>
    </div>

    <!-- Add Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Add Masonry JS -->
    <script src="https://cdn.jsdelivr.net/npm/masonry-layout@4.2.2/dist/masonry.pkgd.min.js"></script>
</body>
</html>
