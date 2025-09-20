<?php
include 'includes/config.php';

// Simple authentication (in a real application, use proper authentication)
$admin_pass = "admin123"; // Change this password
if ($_POST['password'] !== $admin_pass) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        echo "Invalid password!";
    }
    ?>
    <!DOCTYPE html>
    <html>
    <head>
        <title>Admin Login</title>
        <link rel="stylesheet" href="assets/css/style.css">
    </head>
    <body>
        <div class="container" style="margin-top: 100px; text-align: center;">
            <h2>Admin Login</h2>
            <form method="POST">
                <input type="password" name="password" placeholder="Enter admin password" required>
                <button type="submit" class="btn">Login</button>
            </form>
        </div>
    </body>
    </html>
    <?php
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Panel</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        .admin-container {max-width: 1200px; margin: 20px auto; padding: 20px;}
        table {width: 100%; border-collapse: collapse; margin: 20px 0;}
        th, td {padding: 12px; text-align: left; border-bottom: 1px solid #ddd;}
        th {background-color: #1a1a1a; color: white;}
        tr:hover {background-color: #f5f5f5;}
        .section {margin-bottom: 40px;}
    </style>
</head>
<body>
    <div class="admin-container">
        <h1>Rocco Admin Panel</h1>
        
        <div class="section">
            <h2>Recent Bookings</h2>
            <table>
                <tr>
                    <th>Venue</th>
                    <th>Name</th>
                    <th>Date & Time</th>
                    <th>Guests</th>
                    <th>Contact</th>
                    <th>Special Requests</th>
                </tr>
                <?php
                $result = $conn->query("SELECT * FROM bookings ORDER BY created_at DESC LIMIT 10");
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                        <td>" . htmlspecialchars($row['venue'] ?? '') . "</td>
                        <td>{$row['name']}</td>
                        <td>{$row['date']} at {$row['time']}</td>
                        <td>{$row['guests']}</td>
                        <td>{$row['phone']}<br>{$row['email']}</td>
                        <td>{$row['special_requests']}</td>
                    </tr>";
                }
                ?>
            </table>
        </div>

        <div class="section">
            <h2>Contact Enquiries</h2>
            <table>
                <tr>
                    <th>Name</th>
                    <th>Contact</th>
                    <th>Message</th>
                    <th>Date</th>
                </tr>
                <?php
                $result = $conn->query("SELECT * FROM contact_entries ORDER BY created_at DESC LIMIT 10");
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                        <td>{$row['name']}</td>
                        <td>{$row['email']}<br>{$row['phone']}</td>
                        <td>{$row['message']}</td>
                        <td>{$row['created_at']}</td>
                    </tr>";
                }
                ?>
            </table>
        </div>

        <div class="section">
            <h2>Newsletter Subscribers</h2>
            <table>
                <tr>
                    <th>Email</th>
                    <th>Subscribed On</th>
                </tr>
                <?php
                $result = $conn->query("SELECT * FROM subscribers ORDER BY created_at DESC");
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                        <td>{$row['email']}</td>
                        <td>{$row['created_at']}</td>
                    </tr>";
                }
                ?>
            </table>
        </div>
    </div>
</body>
</html>