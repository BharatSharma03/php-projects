<?php
// Get the current page's filename
$current_page = basename($_SERVER['PHP_SELF']);
$page_title =isset($title) ? $title : 'home';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <!-- Character Encoding -->
  <meta charset="UTF-8">
  
  <!-- Viewport for responsive design -->
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- Favicon -->
  <link rel="icon" href="path-to-your-favicon.ico">
  
  <!-- Title of the Page -->
  <title><?php echo htmlspecialchars($page_title);?></title>

  <!-- Include Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
  
  <!-- Include FontAwesome for icons -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
  
  <!-- Additional CSS -->
  <style>
    .nav-link i, .nav-link {
      color: white;
      font-weight: bold;
    }
    .navbar-nav .nav-item {
  margin-right: 15px; /* Adjust the value as needed */
  }


    .nav-link:hover i, .nav-link:hover {
      color: rgb(255, 0, 0);
      font-weight: bold;
    }

    .nav-link.active {
      background-color: rgba(255, 255, 255, 0.2);
      border-radius: 5px;
    }
  </style>
</head>
<body>
  <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container-fluid">
      <ul class="navbar-nav mx-auto">
        <li class="nav-item">
          <a class="nav-link <?= ($current_page == 'index.php') ? 'active' : '' ?>" href="index.php"><i class="fas fa-home"></i> Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?= ($current_page == 'contact.php') ? 'active' : '' ?>" href="contact.php"><i class="fas fa-phone-alt"></i> Contact us</a>
        </li>

        <!-- Show 'About' page only on specific pages -->
        <?php if ($current_page ==  'index.php' || $current_page == 'portfolio.php'): ?>
        <li class="nav-item">
          <a class="nav-link <?= ($current_page == 'about.php') ? 'active' : '' ?>" href="about.php"><i class="fas fa-info-circle"></i> About</a>
        </li>
        <?php endif; ?>

        <!-- Hide 'Register' on the login page -->
        <?php if ($current_page != 'login.php'): ?>
        <li class="nav-item">
          <a class="nav-link <?= ($current_page == 'registration.php') ? 'active' : '' ?>" href="registration.php"><i class="fas fa-user-plus"></i> Register</a>
        </li>
        <?php endif; ?>

        <!-- Show 'Login' only when on specific pages -->
        <?php if ($current_page == 'registration.php' || $current_page == 'about.php'): ?>
        <li class="nav-item">
          <a class="nav-link <?= ($current_page == 'login.php') ? 'active' : '' ?>" href="login.php"><i class="fas fa-sign-in-alt"></i> Login</a>
        </li>
        <?php endif; ?>

        <!-- Portfolio item visible only on the home page -->
        <?php if ($current_page == 'index.php'): ?>
        <li class="nav-item">
          <a class="nav-link <?= ($current_page == 'portfolio.php') ? 'active' : '' ?>" href="portfolio.php"><i class="fas fa-briefcase"></i> Portfolio</a>
        </li>
        <?php endif; ?>


        <!--hide login registration contact and about when user work on to manage and edit slider-->
      </ul>
    </div>
  </nav>

  <!-- Include Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

