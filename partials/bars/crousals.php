<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
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
  <title>Full-Page Carousel</title>
</head>
<body>
  <div id="carouselExampleInterval" class="carousel slide" data-bs-ride="carousel">
    <div class="carousel-inner">
      <!-- First Slide -->
      <div class="carousel-item active" data-bs-interval="2000">
        <div class="carousel-caption d-flex flex-column align-items-center justify-content-center h-100">
          <h1 class="text-center text-light">Welcome to our Website</h1>
          <p class="text-center text-light">Your journey begins here.</p>
        </div>
        <img src="partials/images_crousal/halloween.jpg" class="d-block w-100" alt="First Slide">
      </div>
      <!-- Second Slide -->
      <div class="carousel-item" data-bs-interval="2000">
        <img src="partials/images_crousal/slide1.jpg" class="d-block w-100" alt="Second Slide">
      </div>
      <!-- Third Slide -->
      <div class="carousel-item" data-bs-interval="2000">
        <img src="partials/images_crousal/robot.jpg" class="d-block w-100" alt="Third Slide">
      </div>
      <!-- Fourth Slide -->
      <div class="carousel-item" data-bs-interval="2000">
        <img src="partials/images_crousal/demo.jpg" class="d-block w-100" alt="Fourth Slide">
      </div>
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
  <script>
  // Ensure the carousel starts
  const carousel = document.querySelector('#carouselExampleInterval');
  const carouselInstance = new bootstrap.Carousel(carousel, {
    interval: 1500, // 2-second interval between slides
    wrap: true // Loop back to the first slide
  });
</script>


  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
</body>
</html>
