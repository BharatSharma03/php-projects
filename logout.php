<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>logout</title>
    <!-- <link href="page1.css" rel="stylesheet"> -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  </head>
  <body>
    
  <?php require 'partials/_nav.php'?>
    <!-- <div class="container">
    
      <h1 class="text-center">Welcome to our website</h1>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</div> -->
<?php 
    if (isset($_POST['click']) && $_POST['click'] == "logout") { 
      session_destroy(); // Destroy session
    //   header("Refresh: 1; URL=login.php");
      header("Location: login.php");
      exit();

    }
  ?>
</body>
</html>