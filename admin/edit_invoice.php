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

// Fetch invoice ID
$invoice_id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Update invoice
    $invoice_no = $_POST['invoice_no'];
    $name = $_POST['name'];
    $company = $_POST['company'];
    $address = $_POST['address'];

    $stmt = $con->prepare("UPDATE invoices SET invoice_no = ?, name = ?, company = ?, address = ? WHERE id = ?");
    $stmt->bind_param("ssssi", $invoice_no, $name, $company, $address, $invoice_id);

    if ($stmt->execute()) {
        header("Location: dashboard.php");
        exit;
    } else {
        $error = "Failed to update invoice.";
    }
}

// Fetch invoice data
$stmt = $con->prepare("SELECT * FROM invoices WHERE id = ?");
$stmt->bind_param("i", $invoice_id);
$stmt->execute();
$result = $stmt->get_result();
$invoice = $result->fetch_assoc();

if (!$invoice) {
    die("Invoice not found.");
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit Invoice</title>
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
</style>

<body class="bg-light">
    <div class="background mt-5">
        <h2 class="mb-4">Edit Invoice</h2>

        <?php if (!empty($error)): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <form method="POST" action="">
            <div class="mb-3">
                <label for="invoice_no" class="form-label">Invoice Number</label>
                <input type="text" class="form-control" id="invoice_no" name="invoice_no" value="<?= htmlspecialchars($invoice['invoice_no']) ?>" required>
            </div>
            <div class="mb-3">
                <label for="name" class="form-label">Client Name</label>
                <input type="text" class="form-control" id="name" name="name" value="<?= htmlspecialchars($invoice['name']) ?>" required>
            </div>
            <div class="mb-3">
                <label for="company" class="form-label">Company</label>
                <input type="text" class="form-control" id="company" name="company" value="<?= htmlspecialchars($invoice['company']) ?>" required>
            </div>
            <div class="mb-3">
                <label for="address" class="form-label">Address</label>
                <textarea class="form-control" id="address" name="address" rows="3" required><?= htmlspecialchars($invoice['address']) ?></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Update Invoice</button>
            <a href="dashboard.php" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</body>

</html>