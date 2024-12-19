<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>W3.CSS Sidebar</title>
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
  </head>
  <body>
  
    <!-- Sidebar -->
    <div class="w3-sidebar w3-bar-block w3-card w3-animate-right" style="display:none;right:0;" id="rightMenu">
      <button onclick="closeRightMenu()" class="w3-bar-item w3-button w3-large">Close &times;</button>
      <a href="user_manage.php" target="_parent" class="w3-bar-item w3-button">user manages</a>
      <a href="slider.php" class="w3-bar-item w3-button">manageslider</a>
      <a href="login.php" class="w3-bar-item w3-button">logout</a>
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
    
  </body>
</html>
