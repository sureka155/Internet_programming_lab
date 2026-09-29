<?php
// insert_order.php
include "db_connect.php";

$customer_name = $_POST['customer_name'];
$product_name  = $_POST['product_name'];
$quantity      = $_POST['quantity'];
$price         = $_POST['price'];

$sql = "INSERT INTO orders (customer_name, product_name, quantity, price) VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Order Status</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f7f6;
            margin: 0;
            padding: 40px 20px;
            display: flex;
            justify-content: center;
        }
        .container {
            background-color: #ffffff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            width: 100%;
            max-width: 450px;
            text-align: center;
        }
        .msg-box {
            background-color: #e3f2fd;
            color: #0d47a1;
            padding: 15px;
            border-radius: 5px;
            border-left: 5px solid #4a90e2;
            font-weight: 500;
            margin-bottom: 15px;
        }
        .error-box {
            background-color: #ffebee;
            color: #c62828;
            padding: 15px;
            border-radius: 5px;
            border-left: 5px solid #c62828;
            font-weight: 500;
            margin-bottom: 15px;
        }
        a {
            color: #4a90e2;
            text-decoration: none;
            font-weight: 500;
        }
        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <?php
        if ($stmt) {
            $stmt->bind_param("ssid", $customer_name, $product_name, $quantity, $price);
            
            if ($stmt->execute()) {
                echo "<div class='msg-box'>Order placed successfully!</div>";
            } else {
                echo "<div class='error-box'>Execution Error: " . $stmt->error . "</div>";
            }
            $stmt->close();
        } else {
            echo "<div class='error-box'>Preparation Error: " . $conn->error . "</div>";
        }
        $conn->close();
        ?>
        <a href='view_orders.php'>View all orders →</a>
    </div>
</body>
</html>
