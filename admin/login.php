<?php
session_start();

if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
  header('Location: dashboard.php');
  exit;
}

$db_host = 'localhost';
$db_user = 'root';
$db_pass = '';
$db_name = 'yaramay';

$con = new mysqli($db_host, $db_user, $db_pass, $db_name);
if ($con->connect_error) {
  die("Connection failed: " . $con->connect_error);
}

$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (empty($_POST['email']) || empty($_POST['password'])) {
    $error = 'Please enter both email and password!';
  } else {
    $stmt = $con->prepare('SELECT id, password FROM users WHERE email = ?');
    $stmt->bind_param('s', $_POST['email']);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows == 1) {
      $stmt->bind_result($user_id, $password_hash);
      $stmt->fetch();

      if (password_verify($_POST['password'], $password_hash)) {
        session_regenerate_id();
        $_SESSION['loggedin'] = true;
        $_SESSION['user_id'] = $user_id;
        $_SESSION['user_email'] = $_POST['email'];

        header('Location: dashboard.php');
        exit;
      } else {
        $error = 'Incorrect email or password!';
      }
    } else {
      $error = 'Incorrect email or password!';
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
  <title>Yaramay</title>
  <link rel="stylesheet" href="../css/site.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .button {
      color: white;
      border-radius: 5px;
      margin: 7px;
      padding-inline-start: 6px;
      padding-inline-end: 6px;
    }


    .background {
      background-image: url('../image/image.png');
      background-repeat: no-repeat;
      background-position: center;
      background-size: cover;
      inline-size: 100%;
      block-size: 700px;
      color: white;
      padding: 100px 0;
      text-align: center;
    }

    .top {
      margin-top: -5%;
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
            <a class="nav-link active" href="../index.html">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="../index.html">About</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="../index.html">Services</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="../index.html">Feature</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="../index.html">Portfolio</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="../index.html">Team</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="../index.html">Pricing</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="../index.html">Contact</a>
          </li>
          <li class="nav-item " action="login.php">
            <a class="button text-decoration-none" style="background-color:rgb(26, 26, 126) ;" type="button" href="login.php">Login</a>
          </li>

        </ul>
      </div>
    </div>
  </nav>
  <section class="background overflow-hidden">
    <div class="container px-2 py-0 px-md-5 text-center text-lg-start my-0">
      <div class="row gx-lg-5 align-items-center mb-4">
        <div class="top col-lg-6 mb-0 mb-lg-0" style="z-index: 5">
          <img src="../image/logo.png" alt="MySite Logo" width="300" height="auto" class="logo">
          <h4 class="my-5 display-6 fw-bold ls-tight" style="color:rgb(2, 2, 92)">
            Make your Digital presence matter
          </h4>
        </div>

        <div class="col-lg-6 mb-5 mb-lg-0 position-relative">
          <div class="card bg-glass" style="background:rgb(253, 253, 253, 0.5); border-radius:20px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.5);">
            <div class="card-body px-4 py-6 px-md-5 py-md-5">
              <?php
              if ($error) {
                echo '<p style="color:red;">' . htmlspecialchars($error) . '</p>';
              }
              ?>
              <form method="POST" action="" autocomplete="off">
                <h1 style="color:rgb(2, 2, 92)">Login</h1>
                <h4 style="color:rgb(0, 0, 0, 0.55)">Welcome to Yaramay Computer Maintenance Services</h4>

                <!-- Email input -->
                <div class="form-outline mb-4">
                  <input type="email" id="email" name="email" class="form-control" required />
                  <label class="form-label" for="email">Email address</label>
                </div>

                <!-- Password input -->
                <div class="form-outline mb-4">
                  <input type="password" id="password" name="password" class="form-control" required />
                  <label class="form-label" for="password">Password</label>
                </div>

                <!-- Submit button -->
                <button type="submit" class="btn btn-primary btn-block mb-4"
                  style="background-color: rgb(2, 2, 92); box-shadow: 0 4px 8px rgba(0, 0, 0, 0.5);">
                  Log in
                </button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</body>

</html>