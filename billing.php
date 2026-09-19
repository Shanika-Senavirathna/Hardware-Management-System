<?php
include('config/db.php');

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_role'])) {
    header("Location: login.php");
    exit();
}

if (!isset($_SESSION['bill_items'])) {
    $_SESSION['bill_items'] = array();
}

$invoice_created = false;
$generated_invoice_no = "";

if (isset($_GET['action']) && $_GET['action'] == 'new') {
    $_SESSION['bill_items'] = array();
    unset($_SESSION['last_invoice_no']);
    unset($_SESSION['saved_bill_view']);
    header("Location: billing.php");
    exit();
}

if (isset($_POST['add_to_bill'])) {
    $p_code = mysqli_real_escape_string($conn, $_POST['product_code']);
    $qty = floatval($_POST['quantity']);

    $product_query = "SELECT * FROM products WHERE product_code = '$p_code'";
    $product_result = mysqli_query($conn, $product_query);

    if (mysqli_num_rows($product_result) > 0) {
        $product = mysqli_fetch_assoc($product_result);
        
        $already_in_bill_qty = 0;
        foreach ($_SESSION['bill_items'] as $item) {
            if ($item['code'] == $p_code) {
                $already_in_bill_qty = $item['qty'];
                break;
            }
        }

        $total_requested_qty = $already_in_bill_qty + $qty;

        if ($product['quantity'] >= $total_requested_qty) {
            $total = $product['unit_price'] * $qty;
            
            $found = false;
            foreach ($_SESSION['bill_items'] as $key => $item) {
                if ($item['code'] == $p_code) {
                    $_SESSION['bill_items'][$key]['qty'] += $qty;
                    $_SESSION['bill_items'][$key]['total'] += $total;
                    $found = true;
                    break;
                }
            }

            if (!$found) {
                $_SESSION['bill_items'][] = array(
                    'code' => $product['product_code'],
                    'name' => $product['product_name'],
                    'price' => $product['unit_price'],
                    'qty' => $qty,
                    'total' => $total
                );
            }
            header("Location: billing.php");
            exit();
        } else {
            $available_to_add = $product['quantity'] - $already_in_bill_qty;
            echo "<script>alert('Sorry! Total stock is " . $product['quantity'] . ". You have already added " . $already_in_bill_qty . " to bill. You can only add " . $available_to_add . " more.'); window.location.href='billing.php';</script>";
        }
    } else {
        echo "<script>alert('Product not found! Please select from the suggestion list.'); window.location.href='billing.php';</script>";
    }
}

if (isset($_POST['clear_bill'])) {
    $_SESSION['bill_items'] = array();
    unset($_SESSION['last_invoice_no']);
    unset($_SESSION['saved_bill_view']);
    header("Location: billing.php");
    exit();
}

if (isset($_GET['remove'])) {
    $remove_key = intval($_GET['remove']);
    if (isset($_SESSION['bill_items'][$remove_key])) {
        unset($_SESSION['bill_items'][$remove_key]);
        $_SESSION['bill_items'] = array_values($_SESSION['bill_items']); 
    }
    header("Location: billing.php");
    exit();
}

if (isset($_POST['confirm_bill'])) {
    if (!empty($_SESSION['bill_items'])) {
        $success = true;
        
        $inv_query = "SELECT invoice_no FROM sales WHERE invoice_no LIKE 'INV-%' ORDER BY id DESC LIMIT 1";
        $inv_result = mysqli_query($conn, $inv_query);
        
        $next_numeric_id = 1;
        
        if (mysqli_num_rows($inv_result) > 0) {
            $last_inv_row = mysqli_fetch_assoc($inv_result);
            $last_invoice_no = $last_inv_row['invoice_no'];
            
            $last_number = intval(substr($last_invoice_no, 4)); 
            $next_numeric_id = $last_number + 1;
        }
        
        $invoice_no = "INV-" . str_pad($next_numeric_id, 4, "0", STR_PAD_LEFT); 

        foreach ($_SESSION['bill_items'] as $item) {
            $p_code = $item['code'];
            $qty = $item['qty'];
            $total = $item['total'];

            $query = "INSERT INTO sales (invoice_no, product_code, quantity, total_amount, sale_date) 
                      VALUES ('$invoice_no', '$p_code', $qty, $total, NOW())";
            
            if (mysqli_query($conn, $query)) {
                $update_stock = "UPDATE products SET quantity = quantity - $qty WHERE product_code = '$p_code'";
                mysqli_query($conn, $update_stock);
            } else {
                $success = false;
                break;
            }
        }

        if ($success) {
            $_SESSION['saved_bill_view'] = $_SESSION['bill_items'];
            $_SESSION['bill_items'] = array(); 
            $_SESSION['last_invoice_no'] = $invoice_no;
            
            $invoice_created = true;
            $generated_invoice_no = $invoice_no;
        } else {
            echo "<script>alert('Something went wrong while saving the invoice.'); window.location.href='billing.php';</script>";
        }
    } else {
        echo "<script>alert('Your bill is empty!'); window.location.href='billing.php';</script>";
    }
}

if (isset($_SESSION['last_invoice_no'])) {
    $invoice_created = true;
    $generated_invoice_no = $_SESSION['last_invoice_no'];
}

$prod_query = "SELECT product_code, product_name, unit_price, quantity FROM products WHERE quantity > 0 ORDER BY product_name ASC";
$prod_result = mysqli_query($conn, $prod_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>3.S.D Store - Billing System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/custom.css">
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
                <li class="nav-item"><a class="nav-link active" href="billing.php">Billing</a></li>
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
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="fw-bold text-secondary mb-0"><i class="fa-solid fa-calculator me-2"></i>Billing Point</h4>
        <span class="badge bg-primary px-3 py-2 fs-6 shadow-sm">Operator: <?php echo htmlspecialchars($_SESSION['username'] ?? 'User'); ?></span>
    </div>

    <?php if ($invoice_created): ?>
        <div class="alert alert-success shadow-sm p-3 mb-4 d-flex justify-content-between align-items-center">
            <span><i class="fa-solid fa-circle-check me-2"></i> Invoice <strong><?php echo $generated_invoice_no; ?></strong> Confirmed successfully! You can now print it below.</span>
            <a href="billing.php?action=new" class="btn btn-sm btn-success fw-bold"><i class="fa-solid fa-plus"></i> Start New Bill</a>
        </div>
    <?php endif; ?>

    <div class="row g-4">
        <div class="col-md-4">
            <div class="card shadow-sm p-4 bg-white">
                <h5 class="fw-bold mb-3 text-secondary"><i class="fa-solid fa-cart-plus me-1"></i> Add Item to Bill</h5>
                <form action="billing.php" method="POST">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Select Product</label>
                        <input type="text" id="product_search" list="products_datalist" class="form-control" placeholder="Start typing..." required autocomplete="off" <?php echo $invoice_created ? 'disabled' : ''; ?>>
                        <datalist id="products_datalist">
                            <?php
                            if (mysqli_num_rows($prod_result) > 0) {
                                while ($p_row = mysqli_fetch_assoc($prod_result)) {
                                    echo "<option value='" . $p_row['product_code'] . "'>" . htmlspecialchars($p_row['product_name']) . " (Stock: " . floatval($p_row['quantity']) . ")</option>";
                                }
                            }
                            ?>
                        </datalist>
                    </div>
                    <input type="hidden" name="product_code" id="hidden_product_code">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Quantity</label>
                        <input type="number" name="quantity" class="form-control" value="1" min="0.1" step="any" required <?php echo $invoice_created ? 'disabled' : ''; ?>>
                    </div>
                    <button type="submit" name="add_to_bill" class="btn btn-primary w-100 fw-bold" <?php echo $invoice_created ? 'disabled' : ''; ?>><i class="fa-solid fa-plus me-1"></i> Add to List</button>
                </form>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card shadow-sm p-4 bg-white">
                <h5 class="fw-bold mb-3 text-secondary"><i class="fa-solid fa-file-invoice-dollar me-1"></i> Current Invoice Items</h5>
                <div class="table-responsive">
                    <table class="table table-bordered align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Code</th>
                                <th>Product Name</th>
                                <th>Price</th>
                                <th>Qty</th>
                                <th>Total</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $grand_total = 0;
                            $display_items = $invoice_created ? ($_SESSION['saved_bill_view'] ?? array()) : $_SESSION['bill_items'];

                            if (!empty($display_items)) {
                                foreach ($display_items as $key => $item) {
                                    $grand_total += $item['total'];
                                    echo "<tr>";
                                    echo "<td>" . $item['code'] . "</td>";
                                    echo "<td>" . $item['name'] . "</td>";
                                    echo "<td>LKR " . number_format($item['price'], 2) . "</td>";
                                    echo "<td>" . floatval($item['qty']) . "</td>";
                                    echo "<td class='fw-bold'>LKR " . number_format($item['total'], 2) . "</td>";
                                    echo "<td>";
                                    if (!$invoice_created) {
                                        echo "<a href='billing.php?remove=" . $key . "' class='btn btn-sm btn-danger'><i class='fa-solid fa-trash'></i> Remove</a>";
                                    } else {
                                        echo "<span class='badge bg-light text-success fw-bold'><i class='fa-solid fa-lock'></i> Saved</span>";
                                    }
                                    echo "</td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='6' class='text-center text-muted py-3'>No items added to the bill yet.</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-between align-items-center mt-3 p-3 bg-light rounded">
                    <h4 class="fw-bold text-dark mb-0">Grand Total:</h4>
                    <h3 class="fw-bold text-success mb-0">LKR <?php echo number_format($grand_total, 2); ?></h3>
                </div>

                <div class="mt-4">
                    <?php if (!$invoice_created): ?>
                        <form action="billing.php" method="POST" class="d-flex gap-2">
                            <button type="submit" name="clear_bill" class="btn btn-outline-danger fw-bold w-50" onclick="return confirm('Are you sure you want to clear the whole bill?');"><i class="fa-solid fa-rotate-left me-1"></i> Clear Bill</button>
                            <button type="submit" name="confirm_bill" class="btn btn-success fw-bold w-50" <?php echo empty($_SESSION['bill_items']) ? 'disabled' : ''; ?>><i class="fa-solid fa-check me-1"></i> Confirm Bill</button>
                        </form>
                    <?php else: ?>
                        <div class="d-flex gap-2">
                            <a href="billing.php?action=new" class="btn btn-outline-secondary fw-bold w-50"><i class="fa-solid fa-arrow-left me-1"></i> Back / New Bill</a>
                            <a href="print_bill.php?invoice=<?php echo $generated_invoice_no; ?>" class="btn btn-dark fw-bold w-50 py-2 fs-5 shadow"><i class="fa-solid fa-print me-2"></i> Print Bill</a>
                        </div>
                    <?php endif; ?>
                </div>

            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.getElementById('product_search').addEventListener('input', function() {
        var inputVal = this.value;
        var datalist = document.getElementById('products_datalist');
        var options = datalist.getElementsByTagName('option');
        var hiddenInput = document.getElementById('hidden_product_code');
        hiddenInput.value = ""; 
        for (var i = 0; i < options.length; i++) {
            if (options[i].value === inputVal) {
                hiddenInput.value = inputVal;
                break;
            }
        }
    });
</script>
</body>
</html>