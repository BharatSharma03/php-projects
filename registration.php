<title>Registration</title>

<body>
    <?php require 'partials/bars/_nav.php';?>

    <div class="container" >
        <h1 class="text-center">Register to our website</h1>

        <!-- Registration Form -->
        <form action="" method="post">
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" name="name" class="form-control" placeholder="Enter your full name" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" name="mail" class="form-control" placeholder="name@example.com" required>
            </div>
            <div class="mb-3">
                <label for="password1" class="form-label">Password</label>
                <input type="password" name="password1" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="password2" class="form-label">Confirm Password</label>
                <input type="password" name="password2" class="form-control" required>
            </div>
            <button type="submit" name="btn" value="set" class="btn btn-primary">Submit</button>
        </form>
        <?php

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['btn']) && $_POST['btn'] === 'set') {
            $host = "localhost";
            $username = "root";
            $password = "";
            $dbname = "users";

            // Database connection
            $conn = new mysqli($host, $username, $password, $dbname);
            if ($conn->connect_error) {
                die("<div class='alert alert-danger mt-3'>Connection failed: " . $conn->connect_error . "</div>");
            }

            // Sanitize inputs
            $name = htmlspecialchars(trim($_POST['name']));
            $email = htmlspecialchars(trim($_POST['mail']));
            $password1 = $_POST['password1'];
            $password2 = $_POST['password2'];

            if ($password1 !== $password2) {
                echo "<div class='alert alert-danger mt-3'>Passwords do not match!</div>";
            } else {
                // Hash password
                $hashedPassword = password_hash($password1,PASSWORD_DEFAULT);

                // Highlighted Issue 3: Duplicate email handling
                $stmt = $conn->prepare("INSERT INTO user (name, email, password) VALUES (?, ?, ?)");
                $stmt->bind_param("sss", $name, $email, $hashedPassword);

                if ($stmt->execute()) {
                    echo "<div class='alert alert-success mt-3'>Registration successful! Redirecting to login page...</div>";
                    header("Refresh: 1; URL=login.php");
                } else {
                    if (strpos($stmt->error, 'Duplicate entry') !== false) {
                        echo "<div class='alert alert-danger mt-3'>This email is already registered!</div>";
                    } else {
                        echo "<div class='alert alert-danger mt-3'>Error: " . $stmt->error . "</div>";
                    }
                }

                $stmt->close();
            }

            $conn->close();
        }
        ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <?php require 'partials/bars/footer.php';?>   
</body>

</html>
