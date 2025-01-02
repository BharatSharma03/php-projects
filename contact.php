<title>Contact Us</title>

<?php require 'partials/bars/_nav.php'; ?>

<div class="container" style="margin-bottom: 50px;">
    <h1 class="text-center my-4">Contact Us</h1>
    <p class="text-center">Have any questions or feedback? We'd love to hear from you.</p>

    <form action="" method="post">
        <div class="mb-3">
            <label for="name" class="form-label">Your Name</label>
            <input type="text" class="form-control" id="name" name="name" placeholder="Enter your full name" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Your Email</label>
            <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email" required>
        </div>
        <div class="mb-3">
            <label for="message" class="form-label">Your Message</label>
            <textarea class="form-control" id="message" name="message" rows="5" placeholder="Enter your message" required></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>

    <!-- PHP Logic -->
    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $host = "localhost";
        $username = "root";
        $password = "";
        $dbname = "users";

        // Database connection
        $conn = new mysqli($host, $username, $password, $dbname);
        if ($conn->connect_error) {
            die("<div class='alert alert-danger mt-3'>Connection failed: " . $conn->connect_error . "</div>");
        }

        $name = htmlspecialchars(trim($_POST['name']));
        $email = htmlspecialchars(trim($_POST['email']));
        $message = htmlspecialchars(trim($_POST['message']));

        // Insert the data into the database
        $stmt = $conn->prepare("INSERT INTO contact_info (name, email, mesage) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $name, $email, $message);

        if ($stmt->execute()) {
            echo "<div class='alert alert-success mt-3'>Thanks for your response</div>";
            header("Refresh: 1; URL=index.php");
        } else {
            echo "<div class='alert alert-danger mt-3'>Error: " . $stmt->error . "</div>";
        }

        $stmt->close();
        $conn->close();

        // Add your logic to store this information in a database or send an email
        echo "<div class='alert alert-success mt-3'>Thank you, $name! Your message has been received.</div>";
    }
    ?>
</div>

<?php require 'partials/bars/footer.php'; ?>
