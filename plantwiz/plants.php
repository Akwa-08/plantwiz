<?php
include 'config.php';
include 'connect.php';
redirect_if_not_logged_in();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $photo = $_POST['photo'];
    $quantity = $_POST['quantity'];

    $sql = "INSERT INTO plants (name, description, photo, quantity)
            VALUES ('$name', '$description', '$photo', '$quantity')";

    if ($conn->query($sql) === TRUE) {
        echo "New plant added successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Plants</title>
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
        <h2>Plants</h2>
        <button onclick="document.getElementById('plantForm').style.display='block'">Add Plant</button>
        <div id="plantForm" style="display:none;">
            <form method="post">
                <input type="text" name="name" placeholder="Plant Name" required><br>
                <textarea name="description" placeholder="Plant Description" required></textarea><br>
                <input type="text" name="photo" placeholder="Plant Photo URL" required><br>
                <input type="number" name="quantity" placeholder="Quantity" required><br>
                <button type="submit">Add Plant</button>
            </form>
        </div>
        <h3>Plant List</h3>
        <ul>
            <?php
            $plants = $conn->query("SELECT * FROM plants");
            while ($plant = $plants->fetch_assoc()) {
                echo "<li>{$plant['name']} ({$plant['quantity']}) - <a href='edit_plant.php?id={$plant['id']}'>Edit</a> | <a href='delete_plant.php?id={$plant['id']}'>Delete</a></li>";
            }
            ?>
        </ul>
    </div>
    <script src="js/scripts.js"></script>
</body>
</html>