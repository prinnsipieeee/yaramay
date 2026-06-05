<?php
session_start();

// Database connection
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

// Handle POST request
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $invoice_no = trim($_POST['invoive_no']);
    $name = trim($_POST['name']);
    $company = trim($_POST['company']);
    $address = trim($_POST['address']);

    // Validate fields
    if (empty($invoice_no) || empty($name) || empty($company) || empty($address)) {
        $error = "All fields are required.";
    } elseif (!isset($_FILES['invoice_pdf']) || $_FILES['invoice_pdf']['error'] !== 0) {
        $error = "PDF upload failed.";
    } else {
        // File validation
        $file = $_FILES['invoice_pdf'];
        $fileName = $file['name'];
        $fileTmp = $file['tmp_name'];
        $fileSize = $file['size'];
        $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

        if ($fileExt !== 'pdf') {
            $error = "Only PDF files are allowed.";
        } elseif ($fileSize > 5 * 1024 * 1024) {
            $error = "PDF file must be less than 5MB.";
        } else {
            // Move file to uploads directory
            $uploadDir = 'uploads/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            $newFileName = uniqid('invoice_', true) . '.pdf';
            $uploadPath = $uploadDir . $newFileName;

            if (move_uploaded_file($fileTmp, $uploadPath)) {
                // Insert into database
                $stmt = $con->prepare("INSERT INTO invoices (invoice_no, name, company, address, pdf_filename) VALUES (?, ?, ?, ?, ?)");
                $stmt->bind_param("sssss", $invoice_no, $name, $company, $address, $newFileName);

                if ($stmt->execute()) {
                    $success = "Invoice submitted successfully.";
                } else {
                    $error = "Database error: " . $con->error;
                    // Optional: unlink($uploadPath);
                }
                $stmt->close();
            } else {
                $error = "Failed to move uploaded file.";
            }
        }
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
            background-color: rgb(26, 26, 126);
            border-radius: 5px;
            margin: 7px;
            padding-inline-start: 6px;
            padding-inline-end: 6px;
        }

        .register-container {
            max-width: 500px;
            margin: 0 auto;
            padding: 30px;
            background: rgb(255, 255, 255, 0.5);
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
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
            <h2 class="form-title text-center mb-4">Invoice Details</h2>

            <?php if ($error): ?>
                <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
            <?php endif; ?>

            <?php if ($success): ?>
                <div class="alert alert-success"><?php echo $success; ?></div>
            <?php endif; ?>

            <form method="POST" action="" enctype="multipart/form-data">
                <div class="mb-2">
                    <label for="invoive_no" class="form-label">Invoice Number</label>
                    <input type="text" name="invoive_no" id="invoive_no" class="form-control" required>
                </div>
                <div class="mb-2">
                    <label for="name" class="form-label">Complete Name</label>
                    <input type="text" name="name" id="name" class="form-control" required>
                </div>
                <div class="mb-2">
                    <label for="company" class="form-label">Company</label>
                    <input type="text" name="company" id="company" class="form-control" required minlength="6">
                </div>
                <div class="mb-2">
                    <label for="address" class="form-label">Address</label>
                    <input type="text" name="address" id="address" class="form-control" required>
                </div>

                <!-- PDF Upload Field -->
                <div class="mb-2">
                    <label for="invoice_pdf" class="form-label">Upload Invoice (PDF only)</label>
                    <input type="file" name="invoice_pdf" id="invoice_pdf" class="form-control" accept="application/pdf" required>
                </div>

                <button type="submit" class="btn btn-primary w-100" style="background-color: rgb(2, 2, 92);">Submit Invoice</button>
                <a class="btn text-decoration-none btn-primary w-100 my-2" style="background-color:rgb(109, 10, 10);" type="button" href="dashboard.php">Cancel</a>

            </form>
        </div>
    </div>
</body>

</html>