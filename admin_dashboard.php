<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>admin_dashboard</title>
    <link href="partials/css/msg.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  </head>
  <body>
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
      <?php require 'partials/bars/sidebar.php'?>
      <!-- ?php require 'partials/bars/crousals.php'?> -->
      <?php require 'partials/bars/_nav.php'?>
      
      <div class="message">
      <p>Admin Dashboard..!</p>
      </div>
      
      <?php require 'partials/bars/footer.php'?>
      
      
  </body>
</html>
