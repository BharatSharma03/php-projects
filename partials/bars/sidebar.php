
  <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <style>
        /* Custom styles for the sidebar items */
        .w3-sidebar {
            background-color: #f4f4f4; /* Light background for sidebar */
        }

        .w3-sidebar .w3-bar-item {
            font-weight: bold;
            padding: 12px 20px;
            border-bottom: 1px solid #ddd; /* Add separation between items */
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        .w3-sidebar .w3-bar-item:hover {
            background-color: #007BFF; /* Highlight color */
            color: white; /* Text color on hover */
        }

        .w3-sidebar .w3-bar-item:active {
            background-color: #0056b3; /* Active color */
            color: white;
        }
    </style>


<!-- Sidebar -->
<div class="w3-sidebar w3-bar-block w3-card w3-animate-right" style="display:none;right:0;" id="rightMenu">
    <button onclick="closeRightMenu()" class="w3-bar-item w3-button w3-large w3-text-red">Close &times;</button>
    <a href="user_manage.php" target="_parent" class="w3-bar-item w3-button">Manage Users</a>
    <a href="slider.php" class="w3-bar-item w3-button">Manage Slider</a>
    <a href="add_portfolio.php" class="w3-bar-item w3-button">Add Portfolio Items</a>
    <a href="manage_portfolio.php" class="w3-bar-item w3-button">Manage Portfolio</a>
    <a href="manage_technologies.php" class="w3-bar-item w3-button">Manage Technologies</a>
    <a href="login.php" class="w3-bar-item w3-button">Logout</a>
</div>

<!-- Top Bar -->
<div class="w3-teal">
    <button class="w3-button w3-teal w3-xlarge w3-right" onclick="openRightMenu()">&#9776;</button>
    <div class="w3-container">
        <!-- Any additional content can go here -->
    </div>
</div>

<!-- JavaScript -->
<script>
    function openRightMenu() {
        // Make the sidebar visible
        document.getElementById("rightMenu").style.display = "block";
    }

    function closeRightMenu() {
        // Hide the sidebar
        document.getElementById("rightMenu").style.display = "none";
    }
</script>

