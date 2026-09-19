<?php
include('config/db.php');

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_role'])) {
    header("Location: login.php");
    exit();
}

if (!isset($_GET['invoice'])) {
    echo "<h3>Invoice number is missing!</h3>";
    exit();
}

$invoice_no = mysqli_real_escape_string($conn, $_GET['invoice']);

$query = "SELECT s.*, p.product_name, p.unit_price 
          FROM sales s 
          JOIN products p ON s.product_code = p.product_code 
          WHERE s.invoice_no = '$invoice_no'";

$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) == 0) {
    echo "<h3>Invoice not found in system!</h3>";
    exit();
}

$items = array();
$sale_date = "";
while ($row = mysqli_fetch_assoc($result)) {
    $items[] = $row;
    $sale_date = $row['sale_date'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print Invoice - <?php echo $invoice_no; ?></title>
    <style>
        body {
            font-family: 'Courier New', Courier, monospace;
            font-size: 14px;
            line-height: 1.4;
            color: #000;
            margin: 0;
            padding: 20px;
            background-color: #fff;
        }
        .receipt-container {
            max-width: 400px;
            margin: 0 auto;
        }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        
        .store-title {
            font-size: 22px;
            font-weight: bold;
            margin-bottom: 2px;
        }
        .store-subtitle {
            font-size: 12px;
            margin-bottom: 5px;
        }
        
        .divider {
            border-top: 1px dashed #000;
            margin: 10px 0;
        }
        
        .info-table, .items-table {
            width: 100%;
            border-collapse: collapse;
        }
        
        .info-table td {
            font-size: 13px;
            padding: 2px 0;
        }
        
        .items-table th {
            border-bottom: 1px solid #000;
            text-align: left;
            padding: 5px 0;
            font-size: 13px;
        }
        
        .items-table td {
            padding: 6px 0;
            vertical-align: top;
            font-size: 13px;
        }
        
        .grand-total-container {
            margin-top: 10px;
            padding-top: 5px;
            border-top: 1px double #000;
            border-bottom: 1px double #000;
            font-size: 16px;
            font-weight: bold;
        }
        
        .footer-text {
            font-size: 11px;
            margin-top: 25px;
            color: #555;
        }

        @media print {
            body { padding: 0; margin: 0; }
            .receipt-container { max-width: 100%; }
            .no-print { display: none; }
        }
    </style>
</head>
<body>

<div class="receipt-container">
    
    <div class="text-center">
        <div class="store-title">3.S.D Store</div>
        <div class="store-subtitle">Hardware Shop</div>
        <div class="store-subtitle">Tel: 077 902 3009</div>
    </div>

    <div class="divider"></div>

    <table class="info-table">
        <tr>
            <td><strong>Invoice No:</strong> <?php echo $invoice_no; ?></td>
            <td class="text-right"><strong>Date:</strong> <?php echo date('Y-m-d', strtotime($sale_date)); ?></td>
        </tr>
        <tr>
            <td><strong>Time:</strong> <?php echo date('h:i A', strtotime($sale_date)); ?></td>
            <td class="text-right"><strong>Cashier:</strong> <?php echo htmlspecialchars($_SESSION['username'] ?? 'Staff'); ?></td>
        </tr>
    </table>

    <div class="divider"></div>

    <table class="items-table">
        <thead>
            <tr>
                <th style="width: 55%;">Item Description</th>
                <th style="width: 15%; text-align: center;">Qty</th>
                <th style="width: 30%; text-align: right;">Amount</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $grand_total = 0;
            foreach ($items as $item) {
                $grand_total += $item['total_amount'];
                
                echo "<tr>";
                echo "<td>" . htmlspecialchars($item['product_name']) . "<br><span style='font-size: 11px; color:#444;'>@ " . number_format($item['unit_price'], 2) . "</span></td>";
                echo "<td class='text-center'>" . floatval($item['quantity']) . "</td>";
                echo "<td class='text-right'>LKR " . number_format($item['total_amount'], 2) . "</td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>

    <div class="grand-total-container">
        <table style="width: 100%;">
            <tr>
                <td>GRAND TOTAL:</td>
                <td class="text-right">LKR <?php echo number_format($grand_total, 2); ?></td>
            </tr>
        </table>
    </div>

    <div class="text-center footer-text">
        <p>Thank You For Dealing With Us!<br>
        <span style="font-weight: bold;">3.S.D Store </span></p>
    </div>

</div>

<script>
    window.addEventListener('DOMContentLoaded', () => {
      
        window.print();
    });

    
    window.onafterprint = function() {
        window.location.href = 'dashboard.php';
    };
    
    
    setTimeout(function() {
        window.location.href = 'dashboard.php';
    }, 2000); 
</script>

</body>
</html>