<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: login.php');
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

// Pagination setup
$limit = 10;
$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
$page = max($page, 1);
$offset = ($page - 1) * $limit;

$totalResult = $con->query("SELECT COUNT(*) AS total FROM invoices");
$totalRow = $totalResult->fetch_assoc();
$totalInvoices = $totalRow['total'];
$totalPages = ceil($totalInvoices / $limit);

$query = "SELECT * FROM invoices ORDER BY created_at DESC LIMIT $limit OFFSET $offset";
$result = $con->query($query);
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Dashboard</title>
    <link rel="stylesheet" href="../css/site.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<style>
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
        background-color: rgb(26, 26, 126);
        color: white;
        border-radius: 5px;
        margin: 2px;
        padding-inline: 5px;
        padding-block: 5px;
        text-decoration: none;
    }

    .invoice-table {
        background-color: rgba(2, 2, 92, 0.5);
        border-radius: 8px;
        padding: 15px;
    }

    .invoice-table th {
        background-color: rgba(0, 0, 0, 0.9);
    }

    .invoice-table td {
        background-color: rgba(255, 255, 255, 0.5);
    }
</style>

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
                    <li class="nav-item"><a class="nav-link active" href="#home">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="#about">About</a></li>
                    <li class="nav-item"><a class="nav-link" href="#services">Services</a></li>
                    <li class="nav-item"><a class="nav-link" href="#features">Feature</a></li>
                    <li class="nav-item"><a class="nav-link" href="#portfolio">Portfolio</a></li>
                    <li class="nav-item"><a class="nav-link" href="#team">Team</a></li>
                    <li class="nav-item"><a class="nav-link" href="#pricing">Pricing</a></li>
                    <li class="nav-item"><a class="nav-link" href="#footer">Contact</a></li>
                    <li class="nav-item"><a class="button text-decoration-none" href="logout.php">Logout</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="background">
        <div>
            <a class="button text-decoration-none" href="invoice.php">+ Add Invoice</a>
            <a class="button text-decoration-none" href="register.php">+ Add User</a>
        </div>

        <div class="container mt-2">
            <h3 style="color: darkblue; font-weight: 700;">Invoices List</h3>
            <table class="table table-bordered table-hover mt-3 invoice-table">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Invoice No</th>
                        <th>Name</th>
                        <th>Company</th>
                        <th>Address</th>
                        <th>Date Uploaded</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($result->num_rows > 0): ?>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?= htmlspecialchars($row['id']) ?></td>
                                <td><?= htmlspecialchars($row['invoice_no']) ?></td>
                                <td><?= htmlspecialchars($row['name']) ?></td>
                                <td><?= htmlspecialchars($row['company']) ?></td>
                                <td><?= htmlspecialchars($row['address']) ?></td>
                                <td><?= htmlspecialchars($row['created_at']) ?></td>
                                <td>
                                    <a href="uploads/<?= htmlspecialchars($row['pdf_filename']) ?>" target="_blank" class="button btn-sm btn-info ">View PDF</a>
                                    <a href="uploads/<?= htmlspecialchars($row['pdf_filename']) ?>" download class="button btn-sm btn-success ">Download</a>
                                    <a href="edit_invoice.php?id=<?= $row['id'] ?>" class="button btn-sm btn-warning">Edit</a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7" class="text-center">No invoices found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>

            <!-- Pagination -->
            <nav>
                <ul class="pagination justify-content-center">
                    <?php if ($page > 1): ?>
                        <li class="page-item">
                            <a class="page-link" href="?page=<?= $page - 1 ?>">Previous</a>
                        </li>
                    <?php endif; ?>

                    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                        <li class="page-item <?= ($i == $page) ? 'active' : '' ?>">
                            <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                        </li>
                    <?php endfor; ?>

                    <?php if ($page < $totalPages): ?>
                        <li class="page-item">
                            <a class="page-link" href="?page=<?= $page + 1 ?>">Next</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
    </div>
</body>

</html>