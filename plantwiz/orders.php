<?php
include 'config.php';
include 'connect.php';
redirect_if_not_logged_in();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $ordering_person_name = $_POST['ordering_person_name'];
    $date_order = $_POST['date_order'];
    $plant_order = $_POST['plant_order'];
    $quantity = $_POST['quantity'];
    $contact = $_POST['contact'];

    $sql = "INSERT INTO orders (ordering_person_name, date_order, plant_order, quantity, contact)
            VALUES ('$ordering_person_name', '$date_order', '$plant_order', '$quantity', '$contact')";

    if ($conn->query($sql) === TRUE) {
        // Update plant quantity if order status is completed
        $conn->query("UPDATE plants SET quantity = quantity + $quantity WHERE id = $plant_order");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Orders</title>
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
        <h2>Orders</h2>
        <button onclick="document.getElementById('orderForm').style.display='block'">Add Order</button>
        <div id="orderForm" style="display:none;">
            <form method="post">
                <input type="text" name="ordering_person_name" placeholder="Ordering Person Name" required><br>
                <input type="date" name="date_order" placeholder="Date of Order" required><br>
                <input type="number" name="plant_order" placeholder="Plant ID" required><br>
                <input type="number" name="quantity" placeholder="Quantity" required><br>
                <input type="text" name="contact" placeholder="Contact" required><br>
                <button type="submit">Add Order</button>
            </form>
        </div>
        <h3>Pending Orders</h3>
        <ul>
            <?php
            $pending_orders = $conn->query("SELECT * FROM orders WHERE status='pending'");
            while ($order = $pending_orders->fetch_assoc()) {
                echo "<li>{$order['ordering_person_name']} ordered {$order['quantity']} of plant ID {$order['plant_order']} on {$order['date_order']} ({$order['status']})</li>";
            }
            ?>
        </ul>
        <h3>Completed Orders</h3>
        <ul>
            <?php
            $completed_orders = $conn->query("SELECT * FROM orders WHERE status='completed'");
            while ($order = $completed_orders->fetch_assoc()) {
                echo "<li>{$order['ordering_person_name']} ordered {$order['quantity']} of plant ID {$order['plant_order']} on {$order['date_order']} ({$order['status']})</li>";
            }
            ?>
        </ul>
    </div>
    <script src="js/scripts.js"></script>
</body>
</html>