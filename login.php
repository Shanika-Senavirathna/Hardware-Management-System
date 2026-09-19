<?php
include('config/db.php');

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$error_msg = "";

if (isset($_POST['login_btn'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    $query = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) == 1) {
        $user_data = mysqli_fetch_assoc($result);
        
        $_SESSION['user_id'] = $user_data['id'];
        $_SESSION['username'] = $user_data['username'];
        $_SESSION['user_role'] = $user_data['role']; 

        header("Location: dashboard.php");
        exit();
    } else {
        $error_msg = "❌ Invalid Username or Password!";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>3.S.D Store - Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Segoe+UI:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/custom.css">
    
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
            overflow: hidden;
            position: relative;
            background-color: #1e3c72; 
        }

        .bg-container {
            position: absolute;
            top: 0; left: 0; width: 100%; height: 100%;
            background-image: url('hardware.jpg'), url('hardware.JPG');
            background-repeat: no-repeat;
            background-position: center center;
            background-size: cover;
            filter: blur(0px); 
            transform: scale(1.05);
            z-index: 1;
        }

        .bg-overlay {
            position: absolute;
            top: 0; left: 0; width: 100%; height: 100%;
            background: rgba(12, 25, 52, 0.3); 
            z-index: 2;
        }

        .login-card {
            background: rgba(255, 255, 255, 0.95);
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.4);
            width: 100%;
            max-width: 400px;
            position: relative;
            z-index: 3;
        }

        .btn-primary {
            background-color: #1e3c72;
            border: none;
        }
        .btn-primary:hover {
            background-color: #2a5298;
        }
    </style>
</head>
<body>

<div class="bg-container"></div>
<div class="bg-overlay"></div>

<div class="login-card">
    <div class="text-center mb-4">
        <h2 class="fw-bold" style="color: #1e3c72;">3.S.D Store</h2>
        <p class="text-muted small">Hardware Store Management System</p>
    </div>

    <!-- FIXED: වැරදි පාස්වර්ඩ් එකක් ගැහුවොත් රතු පාටින් ඇලර්ට් එක මෙතන ඩිස්ප්ලේ වෙනවා -->
    <?php if (!empty($error_msg)): ?>
        <div class="alert alert-danger alert-dismissible fade show p-2 mb-3 text-center small fw-bold shadow-sm" role="alert">
            <?php echo $error_msg; ?>
            <button type="button" class="btn-close p-2" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>
    
    <form action="login.php" method="POST">
        <div class="mb-3">
            <label class="form-label fw-semibold">Username</label>
            <input type="text" class="form-control" name="username" placeholder="Enter username" required>
        </div>
        <div class="mb-4">
            <label class="form-label fw-semibold">Password</label>
            <input type="password" class="form-control" name="password" placeholder="Enter password" required>
        </div>
        <button type="submit" name="login_btn" class="btn btn-primary w-100 py-2 fw-bold">Login</button>
    </form>

    <div class="mt-3 text-center">
        <?php
        if (isset($_POST['login_btn'])) {
            if (!isset($conn) || $conn->connect_error) {
                echo '<div class="alert alert-danger mt-2 small" role="alert">
                        ❌ Database Connection Error!
                      </div>';
            }
        }
        ?>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>