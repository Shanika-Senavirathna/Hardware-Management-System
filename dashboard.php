<?php
include('config/db.php');

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}


if (!isset($_SESSION['user_role'])) {
    header("Location: login.php");
    exit();
}


$today_date = date('Y-m-d');
$revenue_query = "SELECT SUM(total_amount) AS total_revenue FROM sales WHERE DATE(sale_date) = '$today_date'";
$revenue_result = mysqli_query($conn, $revenue_query);
$revenue_row = mysqli_fetch_assoc($revenue_result);
$today_revenue = $revenue_row['total_revenue'] ? $revenue_row['total_revenue'] : 0.00;


$items_query = "SELECT COUNT(*) AS total_items FROM products";
$items_result = mysqli_query($conn, $items_query);
$items_row = mysqli_fetch_assoc($items_result);
$total_items = $items_row['total_items'] ? $items_row['total_items'] : 0;


$low_stock_query = "SELECT COUNT(*) AS low_stock FROM products WHERE quantity <= 5";
$low_stock_result = mysqli_query($conn, $low_stock_query);
$low_stock_row = mysqli_fetch_assoc($low_stock_result);
$low_stock_count = $low_stock_row['low_stock'] ? $low_stock_row['low_stock'] : 0;


$sales_query = "SELECT invoice_no, total_amount, TIME_FORMAT(sale_date, '%h:%i %p') AS sale_time FROM sales WHERE DATE(sale_date) = '$today_date' ORDER BY id DESC";
$sales_result = mysqli_query($conn, $sales_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>3.S.D Store - Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/custom.css">
    <style>
        body { background-color: #f4f6f9; font-family: 'Segoe UI', sans-serif; }
        .navbar-dark { background-color: #1e3c72; }
        .card-stat { border-radius: 12px; border: none; transition: transform 0.2s; }
        .card-stat:hover { transform: translateY(-3px); }
        .icon-box { width: 50px; height: 50px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 22px; }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark sticky-top p-3 shadow">
    <div class="container-fluid">
        <a class="navbar-brand fw-bold" href="dashboard.php"><i class="fa-solid fa-screwdriver-wrench me-2"></i>3.S.D Store</a>
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link active" href="dashboard.php">Dashboard</a></li>
                <li class="nav-item"><a class="nav-link" href="billing.php">Billing</a></li>
                
                <?php if (isset($_SESSION['user_role']) && $_SESSION['user_role'] == 'Admin'): ?>
                    <li class="nav-item"><a class="nav-link" href="products.php">Products</a></li>
                    <li class="nav-item"><a class="nav-link" href="users.php">Users</a></li>
                <?php endif; ?>
                
                <li class="nav-item"><a class="nav-link" href="sales_history.php">Sales History</a></li>
                <li class="nav-item"><a class="nav-link text-white fw-bold" href="login.php">Logout</a></li>
            </ul>
        </div>
    </div>
</nav>

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold text-secondary mb-0"><i class="fa-solid fa-chart-line me-2"></i>Management Dashboard</h4>
        <span class="badge bg-primary px-3 py-2 fs-6 shadow-sm">Logged in as: <?php echo htmlspecialchars($_SESSION['username']); ?> (<?php echo $_SESSION['user_role']; ?>)</span>
    </div>
    
    <div class="row g-4">
        <div class="col-md-4">
            <div class="card card-stat shadow-sm p-4 bg-white">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted small fw-bold text-uppercase mb-1">Today's Revenue</p>
                        <h3 class="fw-bold mb-0">LKR <?php echo number_format($today_revenue, 2); ?></h3>
                    </div>
                    <div class="icon-box bg-info bg-opacity-20 text-info">
                        <i class="fa-solid fa-cash-register"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card card-stat shadow-sm p-4 bg-white">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted small fw-bold text-uppercase mb-1">Total Items</p>
                        <h3 class="fw-bold mb-0 text-primary"><?php echo $total_items; ?> Items</h3>
                    </div>
                    <div class="icon-box bg-primary bg-opacity-20 text-primary">
                        <i class="fa-solid fa-boxes-stacked"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <a href="products.php?filter=low" class="text-decoration-none">
                <div class="card card-stat shadow-sm p-4 bg-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted small fw-bold text-uppercase mb-1">Low Stock Alert</p>
                            <h3 class="fw-bold mb-0 text-danger"><?php echo $low_stock_count; ?> Items</h3>
                        </div>
                        <div class="icon-box bg-danger bg-opacity-20 text-danger">
                            <i class="fa-solid fa-triangle-exclamation"></i>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    </div>

    <div class="card shadow-sm p-4 bg-white mt-4">
        <h5 class="fw-bold text-secondary mb-3"><i class="fa-solid fa-history me-2"></i>Recent Invoices (Today)</h5>
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Invoice Number</th>
                        <th>Total Amount</th>
                        <th>Issued Time</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (mysqli_num_rows($sales_result) > 0) {
                        while ($row = mysqli_fetch_assoc($sales_result)) {
                            echo "<tr>";
                            echo "<td class='fw-bold text-primary'><i class='fa-solid fa-file-invoice me-1'></i>" . $row['invoice_no'] . "</td>";
                            echo "<td class='fw-bold'>LKR " . number_format($row['total_amount'], 2) . "</td>";
                            echo "<td>" . $row['sale_time'] . "</td>";
                            echo "<td><a href='print_bill.php?invoice=" . $row['invoice_no'] . "' class='btn btn-sm btn-outline-primary fw-bold' target='_blank'><i class='fa-solid fa-print me-1'></i> Print</a></td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='4' class='text-center text-muted py-3'>No sales recorded today yet.</td></tr>";
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