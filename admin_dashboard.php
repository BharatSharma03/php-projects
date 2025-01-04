<?php
session_start();

// Ensure the user is logged in
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    // If the user is not logged in, redirect to the login page
    // header('Location: login.php');
    // exit;
}

// Database connection (modify with your actual database credentials)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "users";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Ensure the user_id session variable is set
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id']; // Assuming the user ID is stored in the session
} else {
    // Handle error if session variable is not set
    $user_id = null; // You can redirect to login or handle the situation accordingly
}

// Fetch the number of portfolio items for the logged-in user
$total_items = 0;
if ($user_id !== null) {
    // Query to count portfolio items linked to the logged-in user (assuming the portfolio_items table has user_id as a foreign key)
    $sql = "SELECT COUNT(*) AS total_items FROM portfolio_items WHERE user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id); // Bind the user_id parameter
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if the query returns any results
    if ($result->num_rows > 0) {
        $data = $result->fetch_assoc();
        $total_items = isset($data['total_items']) ? $data['total_items'] : 0;
    }
}

// Additional data can be fetched here, such as number of active users or recent activity.

// Close the database connection
$conn->close();
?>

<?php 
    $title = "Admin Dashboard"; 
    require 'partials/bars/_nav.php'; 
    require 'partials/bars/sidebar.php'; 
?>

<!-- Add your admin dashboard content here -->
<div class=" bg-light" style="width: auto; padding: 10px; border-radius: 10px; margin: auto ;">
    <!-- Begin Content -->
    <div class="text-center" style="padding:30px;">
        <h1>Admin Dashboard</h1>
        <p>Welcome to the Admin Dashboard</p>
    </div>

    <!-- Cards or Widgets Section -->
    <div class="row">
        <!-- Portfolio Items Card -->
        <div class="col-md-4">
            <div class="card text-white bg-info mb-3">
                <div class="card-header">Portfolio Items</div>
                <div class="card-body">
                    <h5 class="card-title"><?php echo $total_items; ?></h5>
                    <p class="card-text">Number of portfolio items you have.</p>
                </div>
            </div>
        </div>

        <!-- Add more cards here if needed -->
        <!-- Example: -->
        <div class="col-md-4">
            <div class="card text-white bg-success mb-3">
                <div class="card-header">Users</div>
                <div class="card-body">
                    <h5 class="card-title">10</h5> <!-- This should be dynamic, e.g. count active users -->
                    <p class="card-text">Total number of active users.</p>
                </div>
            </div>
        </div>

        <!-- Example: Chart Card -->
        <div class="col-md-4">
            <div class="card bg-light mb-3">
                <div class="card-header">Activity Overview</div>
                <div class="card-body">
                    <!-- Chart.js Example -->
                    <canvas id="activityChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- End Content -->
</div>


<!-- Bootstrap and other libraries (same as previous) -->
<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script>
// Chart.js example (simple bar chart)
var ctx = document.getElementById('activityChart').getContext('2d');
var activityChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: ['January', 'February', 'March', 'April'], // Example months
        datasets: [{
            label: 'Portfolio Activity',
            data: [10, 20, 30, 40], // Example data points
            backgroundColor: 'rgba(54, 162, 235, 0.2)',
            borderColor: 'rgba(54, 162, 235, 1)',
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});
</script>

<?php require 'partials/bars/footer.php'; ?>