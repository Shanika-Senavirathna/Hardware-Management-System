<?php
include('config/db.php');

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] != 'Admin') {
    echo "<script>alert('Access Denied!'); window.location.href='dashboard.php';</script>";
    exit();
}

if (isset($_POST['save_user'])) {
    $u_name = mysqli_real_escape_string($conn, $_POST['username']);
    $p_word = mysqli_real_escape_string($conn, $_POST['password']);
    $role = mysqli_real_escape_string($conn, $_POST['role']);

    $check = "SELECT * FROM users WHERE username = '$u_name'";
    $res = mysqli_query($conn, $check);

    if (mysqli_num_rows($res) > 0) {
        echo "<script>alert('Username already exists!');</script>";
    } else {
        $insert = "INSERT INTO users (username, password, role) VALUES ('$u_name', '$p_word', '$role')";
        if (mysqli_query($conn, $insert)) {
            echo "<script>alert('User Added Successfully!'); window.location.href='users.php';</script>";
        }
    }
}

$query = "SELECT * FROM users ORDER BY id DESC";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>3.S.D Store - User Management</title>
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
                    <li class="nav-item"><a class="nav-link" href="products.php">Products</a></li>
                    <li class="nav-item"><a class="nav-link active" href="users.php">Users</a></li>
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
            <div class="card shadow-sm p-4 bg-white">
                <h5 class="fw-bold mb-3 text-secondary"><i class="fa-solid fa-user-plus me-1"></i> Add New User</h5>
                <form action="users.php" method="POST">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Username</label>
                        <input type="text" name="username" class="form-control" required autocomplete="off">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Password</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Role</label>
                        <select name="role" class="form-select" required>
                            <option value="Cashier">Cashier</option>
                            <option value="Admin">Admin</option>
                        </select>
                    </div>
                    <button type="submit" name="save_user" class="btn btn-primary w-100 fw-bold"><i class="fa-solid fa-floppy-disk me-1"></i> Save User</button>
                </form>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card shadow-sm p-4 bg-white">
                <h5 class="fw-bold mb-3 text-secondary"><i class="fa-solid fa-users me-1"></i> System Users</h5>
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>ID</th>
                                <th>Username</th>
                                <th>Role</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            while ($row = mysqli_fetch_assoc($result)) {
                                $badge = $row['role'] == 'Admin' ? 'bg-danger' : 'bg-success';
                                echo "<tr>";
                                echo "<td>" . $row['id'] . "</td>";
                                echo "<td class='fw-bold'>" . htmlspecialchars($row['username']) . "</td>";
                                echo "<td><span class='badge $badge'>" . $row['role'] . "</span></td>";
                                echo "</tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>