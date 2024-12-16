<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <?php require 'partials/_nav.php'; ?>
    <div class="container">
        <h1 class="text-center">Login to our website</h1>

        <!-- Form -->
        <form action="" method="post">
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Email address</label>
                <input type="email" name="email" class="form-control" id="exampleInputEmail1" required>
            </div>
            <div class="mb-3">
                <label for="exampleInputPassword1" class="form-label">Password</label>
                <input type="password" name="password" class="form-control" id="exampleInputPassword1" required>
            </div>
            <button type="submit" class="btn btn-primary" name="btn" value="set">Login</button>
        </form>

        <!-- PHP Logic -->
        <?php

        $host = "localhost";
        $username = "root";
        $password = "";
        $db = "users";

        $conn = new mysqli($host, $username, $password, $db);

        if ($conn->connect_error) {
            die("<div class='alert alert-danger mt-3'>Connection failed: " . $conn->connect_error . "</div>");
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['btn']) && $_POST['btn'] === 'set') {
            $email = htmlspecialchars(trim($_POST['email']));
            $password = $_POST['password'];
            // Prepared statement to fetch hashed password
            $stmt = $conn->prepare("SELECT password FROM user WHERE email = ?");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $stmt->store_result();

            if ($stmt->num_rows > 0) {
                $stmt->bind_result($hashedPassword);
                $stmt->fetch();

                // Verify password
                if (password_verify($password, $hashedPassword)) {
                    session_start();
                    $_SESSION['email'] = $email;
                    echo "<div class='alert alert-success mt-3'>Login successful! Redirecting...</div>";
                    header("Refresh: 1; URL=display.php");
                    exit();
                } else {
                    echo "<div class='alert alert-danger mt-3'>Invalid email or password</div>";
                }
            } else {
                echo "<div class='alert alert-danger mt-3'>Invalid email or password</div>";
            }

            $stmt->close();
        }

        $conn->close();
        ?>
    </div>
</body>

</html>
