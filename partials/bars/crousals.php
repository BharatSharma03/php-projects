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

$sql = "SELECT * FROM slider";
$result = $conn->query($sql);
$items = $result->fetch_all(MYSQLI_ASSOC);

?>
<style>
    html, body {
      height: 100%;
      margin: 0;
    }
    .carousel,
    .carousel-inner,
    .carousel-item {
      height: 100%;
    }
    .carousel-item img {
      object-fit: cover;
      height: 100%;
      width: 100%;
    }
  </style>

  <div id="carouselExampleInterval" class="carousel slide" data-bs-ride="carousel">
    <div class="carousel-inner" name="sldier">
      <?php 
      $isActive = true;
      foreach ($items as $item): 
        $imagePath = $item['path'];
        $title = $item['title'];
        $description = $item['description'];
      ?>
      <div class="carousel-item <?php echo $isActive ? 'active' : ''; ?>" data-bs-interval="2000">
        
        <img src="<?php echo $imagePath; ?>" class="d-block w-100" alt="<?php echo $title; ?>">
        <div class="carousel-caption d-flex flex-column align-items-center justify-content-center h-100">
          <h1 class="text-center text-light"><?php echo $title; ?></h1>
          <p class="text-center text-light"><?php echo $description; ?></p>
        </div>
      </div>
      <?php 
        $isActive = false; // Only the first item should be active
      endforeach; 
      ?>
    </div>

    <!-- Previous Button -->
    <a class="carousel-control-prev" href="#carouselExampleInterval" role="button" data-bs-slide="prev">
      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Previous</span>
    </a>
    <!-- Next Button -->
    <a class="carousel-control-next" href="#carouselExampleInterval" role="button" data-bs-slide="next">
      <span class="carousel-control-next-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Next</span>
    </a>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>

