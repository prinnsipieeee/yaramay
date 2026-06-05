<?php
session_start();

$db_host = 'localhost';
$db_user = 'root';
$db_pass = '';
$db_name = 'yaramay';

$con = new mysqli($db_host, $db_user, $db_pass, $db_name);
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}

$error = '';
$success = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if (empty($email) || empty($password) || empty($confirm_password)) {
        $error = 'All fields are required.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Invalid email format.';
    } elseif ($password !== $confirm_password) {
        $error = 'Passwords do not match.';
    } else {
        // Check for existing user
        $stmt = $con->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $error = 'Email already registered.';
        } else {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $insert_stmt = $con->prepare("INSERT INTO users (email, password) VALUES (?, ?)");
            $insert_stmt->bind_param("ss", $email, $hashed_password);
            if ($insert_stmt->execute()) {
                $success = 'Registration successful. <a href="login.php">Click here to login</a>.';
            } else {
                $error = 'Registration failed. Please try again.';
            }
            $insert_stmt->close();
        }
        $stmt->close();
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Register | Yaramay CMS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .background {
            background-image: url('../image/image.png');
            background-repeat: no-repeat;
            background-position: center;
            background-size: cover;
            inline-size: 100%;
            block-size: 700px;
            color: white;
            padding: 25px 0;
            text-align: center;
        }

        .button {
            color: white;
            border-radius: 5px;
            margin: 7px;
            padding-inline-start: 6px;
            padding-inline-end: 6px;
        }

        .register-container {
            max-width: 500px;
            margin: 80px auto;
            padding: 30px;
            background: rgb(255, 255, 255, 0.5);
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.5);
        }

        .form-label {
            color: black;
        }

        .form-title {
            color: #02025c;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light sticky-top">
        <div class="container">
            <a class="navbar-brand" href="#">
                <img src="../image/logo.png" alt="MySite Logo" width="150" height="40" class="logo">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" style="padding: 7px;" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link active" href="#home">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#about">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#services">Services</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#features">Feature</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#portfolio">Portfolio</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#team">Team</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#pricing">Pricing</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#footer">Contact</a>
                    </li>
                    <li class="nav-item ">
                        <a class="button text-decoration-none" style="background-color:rgb(26, 26, 126) ;" type="button" href="logout.php">logout</a>
                    </li>

                </ul>
            </div>
        </div>
    </nav>
    <div class="background">
        <div class="register-container">
            <h2 class="form-title text-center mb-4">Create Account</h2>

            <?php if ($error): ?>
                <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
            <?php endif; ?>

            <?php if ($success): ?>
                <div class="alert alert-success"><?php echo $success; ?></div>
            <?php endif; ?>

            <form method="POST" action="">
                <div class="mb-3">
                    <label for="email" class="form-label">Email address</label>
                    <input type="email" name="email" id="email" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" name="password" id="password" class="form-control" required minlength="6">
                </div>

                <div class="mb-3">
                    <label for="confirm_password" class="form-label">Confirm Password</label>
                    <input type="password" name="confirm_password" id="confirm_password" class="form-control" required>
                </div>

                <button type="submit" class="btn btn-primary w-100" style="background-color: rgb(2, 2, 92);">Register</button>
                <a class="btn text-decoration-none btn-primary w-100 my-2" style="background-color:rgb(109, 10, 10);" type="button" href="dashboard.php">Cancel</a>

            </form>
        </div>
    </div>
</body>

</html>