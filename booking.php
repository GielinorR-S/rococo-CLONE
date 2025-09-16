<?php
$pageTitle = "Rococo | Booking";
include __DIR__ . '/includes/header.php';

$success = false;
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$date = $_POST['date'] ?? '';
	$time = $_POST['time'] ?? '';
	$guests = $_POST['guests'] ?? '';
	$name = $_POST['name'] ?? '';
	$phone = $_POST['phone'] ?? '';
	$email = $_POST['email'] ?? '';
	$special_requests = $_POST['special_requests'] ?? '';

	if ($date && $time && $guests && $name && $phone && $email) {
		// Here you would normally save to a database or send an email
		$success = true;
	} else {
		$error = 'Please fill in all required fields.';
	}
}
?>
<main>
	<section class="booking-section">
		<div class="container">
			<h1 class="section-heading">Book a Table</h1>
			<?php if ($success): ?>
				<div class="success-message">Thank you for your booking! We will contact you soon.</div>
			<?php else: ?>
				<?php if ($error): ?>
					<div class="error-message"><?php echo htmlspecialchars($error); ?></div>
				<?php endif; ?>
				<form action="booking.php" method="POST" class="booking-form">
					<div class="form-group">
						<label for="date">Date</label>
						<input type="date" id="date" name="date" required>
					</div>
					<div class="form-group">
						<label for="time">Time</label>
						<input type="time" id="time" name="time" required>
					</div>
					<div class="form-group">
						<label for="guests">Number of Guests</label>
						<input type="number" id="guests" name="guests" min="1" required>
					</div>
					<div class="form-group">
						<label for="name">Full Name</label>
						<input type="text" id="name" name="name" required>
					</div>
					<div class="form-group">
						<label for="phone">Phone Number</label>
						<input type="tel" id="phone" name="phone" required>
					</div>
					<div class="form-group">
						<label for="email">Email Address</label>
						<input type="email" id="email" name="email" required>
					</div>
					<div class="form-group">
						<label for="special_requests">Special Requests</label>
						<textarea id="special_requests" name="special_requests" rows="3"></textarea>
					</div>
					<div class="form-btn">
						<button type="submit" class="btn btn-primary">Book Now</button>
					</div>
				</form>
			<?php endif; ?>
		</div>
	</section>
</main>
<?php
include __DIR__ . '/includes/footer.php';
?>
