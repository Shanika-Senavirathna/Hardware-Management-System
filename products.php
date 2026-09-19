<?php
include('config/db.php');

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_role'])) {
    header("Location: login.php");
    exit();
}

if ($_SESSION['user_role'] == 'Cashier') {
    echo "<script>alert('Access Denied! Cashiers are not allowed to manage products.'); window.location.href='dashboard.php';</script>";
    exit();
}

if (isset($_POST['save_product'])) {
    $p_code = mysqli_real_escape_string($conn, $_POST['product_code']);
    $p_name = mysqli_real_escape_string($conn, $_POST['product_name']);
    $p_category = mysqli_real_escape_string($conn, $_POST['product_category']); 
    $price = floatval($_POST['unit_price']);
    $stock = floatval($_POST['initial_stock']);

    $check_query = "SELECT * FROM products WHERE product_code = '$p_code'";
    $check_result = mysqli_query($conn, $check_query);

    if (mysqli_num_rows($check_result) > 0) {
        echo "<script>alert('Product Code already exists!'); window.location.href='products.php';</script>";
    } else {
        $insert_query = "INSERT INTO products (product_code, product_name, category_name, unit_price, quantity) 
                         VALUES ('$p_code', '$p_name', '$p_category', $price, $stock)";
        if (mysqli_query($conn, $insert_query)) {
            echo "<script>alert('Product Added Successfully!'); window.location.href='products.php';</script>";
        }
    }
}

if (isset($_POST['import_csv'])) {
    $filename = $_FILES['csv_file']['tmp_name'];

    if ($_FILES['csv_file']['size'] > 0) {
        $file = fopen($filename, "r");
        fgetcsv($file); 

        $success_count = 0;
        $error_count = 0;

        while (($column = fgetcsv($file, 1000, ",")) !== FALSE) {
            $p_code = mysqli_real_escape_string($conn, $column[0]);
            $p_name = mysqli_real_escape_string($conn, $column[1]);
            $p_category = mysqli_real_escape_string($conn, $column[2]);
            $price = floatval($column[3]);
            $stock = floatval($column[4]);

            if (!empty($p_code) && !empty($p_name)) {
                $check = mysqli_query($conn, "SELECT id FROM products WHERE product_code = '$p_code'");
                
                if (mysqli_num_rows($check) > 0) {
                    $sql = "UPDATE products SET product_name='$p_name', category_name='$p_category', unit_price=$price, quantity=quantity+$stock WHERE product_code='$p_code'";
                } else {
                    $sql = "INSERT INTO products (product_code, product_name, category_name, unit_price, quantity) VALUES ('$p_code', '$p_name', '$p_category', $price, $stock)";
                }
                
                if (mysqli_query($conn, $sql)) {
                    $success_count++;
                } else {
                    $error_count++;
                }
            }
        }
        fclose($file);
        echo "<script>alert('Import Complete! Successfully added/updated $success_count items.'); window.location.href='products.php';</script>";
    } else {
        echo "<script>alert('Please select a valid CSV file!'); window.location.href='products.php';</script>";
    }
}

if (isset($_POST['update_product'])) {
    $p_id = intval($_POST['product_id']);
    $p_name = mysqli_real_escape_string($conn, $_POST['product_name']);
    $p_category = mysqli_real_escape_string($conn, $_POST['product_category']);
    $price = floatval($_POST['unit_price']);
    $stock = floatval($_POST['quantity']);

    $update_query = "UPDATE products SET product_name='$p_name', category_name='$p_category', unit_price=$price, quantity=$stock WHERE id=$p_id";
    if (mysqli_query($conn, $update_query)) {
        echo "<script>alert('Product Updated Successfully!'); window.location.href='products.php';</script>";
    }
}

if (isset($_GET['delete'])) {
    $p_id = intval($_GET['delete']);
    $delete_query = "DELETE FROM products WHERE id=$p_id";
    if (mysqli_query($conn, $delete_query)) {
        echo "<script>alert('Product Deleted Successfully!'); window.location.href='products.php';</script>";
    }
}

if (isset($_GET['filter']) && $_GET['filter'] == 'low') {
    $query = "SELECT * FROM products WHERE quantity <= 5 ORDER BY id DESC";
    $page_title = "Low Stock Items Inventory";
} else {
    $query = "SELECT * FROM products ORDER BY id DESC";
    $page_title = "Stock Items Inventory";
}
$result = mysqli_query($conn, $query);

$categories = ["Building Materials", "Electrical", "Plumbing", "Cement & Blocks", "Paint & Accessories", "Tools & Hardware"];

$cat_query = "SELECT * FROM categories ORDER BY name ASC";
$cat_result = mysqli_query($conn, $cat_query);
while($cat_row = mysqli_fetch_assoc($cat_result)) {
    if (!in_array($cat_row['name'], $categories)) {
        $categories[] = $cat_row['name'];
    }
}
sort($categories); 


$next_code_number = 1;

$code_query = "SELECT product_code FROM products WHERE product_code LIKE 'HW-%' ORDER BY CAST(SUBSTRING(product_code, 4) AS UNSIGNED) DESC LIMIT 1";
$code_result = mysqli_query($conn, $code_query);

if (mysqli_num_rows($code_result) > 0) {
    $last_code_row = mysqli_fetch_assoc($code_result);
    $last_code = $last_code_row['product_code']; 
    $last_number = intval(substr($last_code, 3)); 
    $next_code_number = $last_number + 1; 
}
$suggested_next_code = "HW-" . $next_code_number;

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>3.S.D Store - Products Management</title>
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
                <li class="nav-item"><a class="nav-link" href="billing.php">Billing</a></li>
                <?php if (isset($_SESSION['user_role']) && $_SESSION['user_role'] == 'Admin'): ?>
                    <li class="nav-item"><a class="nav-link active" href="products.php">Products</a></li>
                    <li class="nav-item"><a class="nav-link" href="users.php">Users</a></li>
                <?php endif; ?>
                <li class="nav-item"><a class="nav-link" href="sales_history.php">Sales History</a></li>
                <li class="nav-item"><a class="nav-link text-white fw-bold" href="login.php">Logout</a></li>
            </ul>
        </div>
    </div>
</nav>

<div class="container mt-4">
    <div class="row g-4">
        <div class="col-md-4">
            <div class="card shadow-sm p-4 bg-white mb-4 border-start border-primary border-4">
                <h5 class="fw-bold mb-3 text-primary"><i class="fa-solid fa-file-excel me-1"></i> Bulk Import (Excel)</h5>
                <form action="products.php" method="POST" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Select CSV File (.csv)</label>
                        <input type="file" name="csv_file" class="form-control" accept=".csv" required>
                    </div>
                    <button type="submit" name="import_csv" class="btn btn-primary w-100 fw-bold"><i class="fa-solid fa-cloud-arrow-up me-1"></i> Upload & Import Items</button>
                </form>
            </div>

            <div class="card shadow-sm p-4 bg-white">
                <h5 class="fw-bold mb-3 text-secondary"><i class="fa-solid fa-square-plus me-1"></i> Add Single Item</h5>
                <form action="products.php" method="POST">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Product Name</label>
                        <input type="text" name="product_name" id="product_name_input" class="form-control" placeholder="e.g., Paint Brush 4 inch" required autocomplete="off">
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold">Product Code</label>
                        <input type="text" name="product_code" id="product_code_input" class="form-control bg-light fw-bold text-primary" value="<?php echo $suggested_next_code; ?>" readonly required>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold">Category</label>
                        <select name="product_category" class="form-select" required>
                            <option value="">-- Select Category --</option>
                            <?php foreach ($categories as $cat) { echo "<option value='$cat'>$cat</option>"; } ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Unit Price (LKR)</label>
                        <input type="number" step="0.01" name="unit_price" class="form-control" placeholder="0.00" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Initial Stock Qty</label>
                        <input type="number" name="initial_stock" class="form-control" value="0" min="0" step="any" required>
                    </div>
                    <button type="submit" name="save_product" class="btn btn-success w-100 fw-bold"><i class="fa-floppy-disk fa-solid me-1"></i> Save Product</button>
                </form>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card shadow-sm p-4 bg-white">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="fw-bold text-secondary mb-0"><i class="fa-solid fa-boxes-stacked me-1"></i> <?php echo $page_title; ?></h5>
                    <?php if (isset($_GET['filter'])) { ?>
                        <a href="products.php" class="btn btn-sm btn-outline-secondary fw-bold"><i class="fa-solid fa-eye me-1"></i> Show All</a>
                    <?php } ?>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Code</th>
                                <th>Name</th>
                                <th>Category</th> 
                                <th>Price</th>
                                <th>Qty</th>
                                <th>Status</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (mysqli_num_rows($result) > 0) {
                                while ($row = mysqli_fetch_assoc($result)) {
                                    $status_badge = $row['quantity'] <= 5 ? '<span class="badge bg-warning text-dark">Low Stock</span>' : '<span class="badge bg-success">In Stock</span>';
                                    echo "<tr>";
                                    echo "<td class='fw-bold'>" . $row['product_code'] . "</td>";
                                    echo "<td>" . $row['product_name'] . "</td>";
                                    echo "<td><span class='badge bg-secondary'>" . ($row['category_name'] ? $row['category_name'] : 'Uncategorized') . "</span></td>"; 
                                    echo "<td>LKR " . number_format($row['unit_price'], 2) . "</td>";
                                    echo "<td class='fw-bold'>" . floatval($row['quantity']) . "</td>";
                                    echo "<td>" . $status_badge . "</td>";
                                    echo "<td class='text-center'>
                                            <button class='btn btn-sm btn-outline-primary me-1 edit-btn' 
                                                data-id='".$row['id']."' 
                                                data-code='".$row['product_code']."' 
                                                data-name='".$row['product_name']."' 
                                                data-category='".$row['category_name']."' 
                                                data-price='".$row['unit_price']."' 
                                                data-qty='".floatval($row['quantity'])."'>
                                                <i class='fa-solid fa-pen'></i>
                                            </button>
                                            <a href='products.php?delete=".$row['id']."' class='btn btn-sm btn-outline-danger' onclick='return confirm(\"Are you sure you want to delete this product?\");'>
                                                <i class='fa-solid fa-trash'></i>
                                          </td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='7' class='text-center text-muted py-3'>No products found.</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="editModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title fw-bold text-secondary"><i class="fa-solid fa-pen-to-square me-1"></i> Edit Product</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="products.php" method="POST">
          <div class="modal-body">
                <input type="hidden" name="product_id" id="mod_id">
                <div class="mb-3">
                    <label class="form-label fw-bold">Product Code (Cannot Change)</label>
                    <input type="text" id="mod_code" class="form-control bg-light" readonly>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold">Product Name</label>
                    <input type="text" name="product_name" id="mod_name" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold">Category</label>
                    <select name="product_category" id="mod_category" class="form-select" required>
                        <?php foreach ($categories as $cat) { echo "<option value='$cat'>$cat</option>"; } ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold">Unit Price (LKR)</label>
                    <input type="number" step="0.01" name="unit_price" id="mod_price" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold">Stock Quantity</label>
                    <input type="number" name="quantity" id="mod_qty" class="form-control" step="any" required>
                </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary fw-bold" data-bs-dismiss="modal">Close</button>
            <button type="submit" name="update_product" class="btn btn-primary fw-bold">Save Changes</button>
          </div>
      </form>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    const editButtons = document.querySelectorAll('.edit-btn');
    const editModal = new bootstrap.Modal(document.getElementById('editModal'));

    editButtons.forEach(button => {
        button.addEventListener('click', function() {
            document.getElementById('mod_id').value = this.dataset.id;
            document.getElementById('mod_code').value = this.dataset.code;
            document.getElementById('mod_name').value = this.dataset.name;
            document.getElementById('mod_category').value = this.dataset.category;
            document.getElementById('mod_price').value = this.dataset.price;
            document.getElementById('mod_qty').value = this.dataset.qty;
            editModal.show();
        });
    });
</script>
</body>
</html>