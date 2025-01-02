
    <title>Admin Dashboard</title>
    <link href="partials/css/message.css" rel="stylesheet">
    <?php
    session_start();

    if (!isset($_SESSION['logged in']) || $_SESSION['logged in'] !== true) {
        // If the user is not logged in, redirect to the login page
        header('Location: login.php');
        exit;
    }

    // Continue with the page content if logged in
    // echo "Welcome to the protected page!";
    ?>

<?php require 'partials/bars/_nav.php'; ?>
    <?php require 'partials/bars/sidebar.php'; ?>
  

    <div class="message">
        <p>Admin Dashboard..!</p>
    </div>

    <?php require 'partials/bars/footer.php'; ?>
