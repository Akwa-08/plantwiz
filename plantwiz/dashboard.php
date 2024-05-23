<?php
include 'config.php';
include 'connect.php';
redirect_if_not_logged_in();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <link rel="stylesheet" type="text/css" href="css/styles.css">
</head>
<body>
    <div class="sidebar">
        <a href="dashboard.php">Dashboard</a>
        <a href="orders.php">Orders</a>
        <a href="plants.php">Plants</a>
        <a href="about.php">About Us</a>
        <a href="logout.php">Logout</a>
    </div>
    <div class="content">
        <h2>Dashboard</h2>
        <!-- Display plant statistics -->
        <div class="stats">
            <?php
            $plants = $conn->query("SELECT * FROM plants");
            while ($plant = $plants->fetch_assoc()) {
                echo "<div class='card'>
                        <img src='images/{$plant['photo']}' alt='{$plant['name']}'>
                        <h3>{$plant['name']}</h3>
                        <p>Quantity Ordered: [sum of orders for this plant]</p>
                        <p>Quantity Remaining: {$plant['quantity']}</p>
                      </div>";
            }
            ?>
        </div>
        <!-- Display recent orders -->
        <h3>Recent Orders</h3>
        <ul>
            <?php
            $orders = $conn->query("SELECT * FROM orders ORDER BY date_order DESC LIMIT 5");
            while ($order = $orders->fetch_assoc()) {
                echo "<li>{$order['ordering_person_name']} ordered {$order['quantity']} of plant ID {$order['plant_order']} on {$order['date_order']} ({$order['status']})</li>";
            }
            ?>
        </ul>
    </div>
    <script src="js/scripts.js"></script>
</body>
</html>