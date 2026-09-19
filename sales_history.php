<?php
include('config/db.php');

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}


if (!isset($_SESSION['user_role'])) {
    header("Location: login.php");
    exit();
}


$query = "SELECT invoice_no, SUM(total_amount) AS grand_total, sale_date 
          FROM sales 
          GROUP BY invoice_no 
          ORDER BY sale_date DESC";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>3.S.D Store - Sales History</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        body { background-color: #f4f6f9; font-family: 'Segoe UI', sans-serif; }
        .navbar-dark { background-color: #1e3c72; }
        .card { border-radius: 10px; border: none; }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark sticky-top p-3 shadow">
    <div class="container-fluid">
        <a class="navbar-brand fw-bold" href="dashboard.php"><i class="fa-solid fa-screwdriver-wrench me-2"></i>3.S.D Store</a>
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link" href="dashboard.php">Dashboard</a></li>
                <li class="nav-item"><a class="nav-link" href="billing.php">Billing</a></li>
                
                <?php if (isset($_SESSION['user_role']) && $_SESSION['user_role'] == 'Admin'): ?>
                    <li class="nav-item"><a class="nav-link" href="products.php">Products</a></li>
                    <li class="nav-item"><a class="nav-link" href="users.php">Users</a></li>
                <?php endif; ?>
                
                <li class="nav-item"><a class="nav-link active" href="sales_history.php">Sales History</a></li>
                <li class="nav-item"><a class="nav-link text-white fw-bold" href="login.php">Logout</a></li>
            </ul>
        </div>
    </div>
</nav>

<div class="container mt-4">
    <div class="card shadow-sm p-4 bg-white">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-bold text-secondary mb-0"><i class="fa-solid fa-clock-rotate-left me-2"></i>All Sales & Invoice History</h4>
            <span class="badge bg-secondary px-3 py-2 fs-6 shadow-sm">Total Invoices Issued</span>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Date & Time</th>
                        <th>Invoice Number</th>
                        <th>Total Amount</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                           
                            $formatted_date = date('Y-m-d (h:i A)', strtotime($row['sale_date']));
                            echo "<tr>";
                            echo "<td>" . $formatted_date . "</td>";
                            echo "<td class='fw-bold text-primary'><i class='fa-solid fa-file-invoice me-1'></i>" . $row['invoice_no'] . "</td>";
                            echo "<td class='fw-bold text-success'>LKR " . number_format($row['grand_total'], 2) . "</td>";
                            
                            echo "<td class='text-center'>
                                    <a href='print_bill.php?invoice=" . $row['invoice_no'] . "' class='btn btn-sm btn-outline-primary fw-bold' target='_blank'>
                                        <i class='fa-solid fa-print me-1'></i> Re-Print Bill
                                    </a>
                                  </td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='4' class='text-center text-muted py-4'>No sales records found in the system yet.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>