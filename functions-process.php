<?php
include 'includes/config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $event_date = trim($_POST['event_date']);
    $guests = trim($_POST['guests']);
    $message = trim($_POST['message']);

    // Validate email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("Invalid email format");
    }

    // You might want to create a separate table for function enquiries
    // For now, we'll use the contact_entries table
    $stmt = $conn->prepare("INSERT INTO contact_entries (name, email, phone, message) VALUES (?, ?, ?, ?)");
    $full_message = "Event Date: $event_date\nGuests: $guests\nMessage: $message";
    $stmt->bind_param("ssss", $name, $email, $phone, $full_message);

    if ($stmt->execute()) {
        echo "Thank you for your enquiry! We'll contact you shortly to discuss your event.";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}
$conn->close();

header("refresh:3;url=functions.php");
?>