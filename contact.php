
<?php
$pageTitle = "Rococo | Contact";
include __DIR__ . '/includes/header.php';

$success = false;
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$name = $_POST['name'] ?? '';
	$email = $_POST['email'] ?? '';
	$message = $_POST['message'] ?? '';
	if ($name && $email && $message) {
		// Here you would normally send an email or save to a database
		$success = true;
	} else {
		$error = 'Please fill in all required fields.';
	}
}
?>
<main>
	<section class="contact-section">
		<div class="container">
			<h1 class="section-heading">Contact Us</h1>
			<div class="contact-grid">
				<div class="contact-details">
					<h3>Contact Information</h3>
					<ul>
						<li>123 Via Roma, Milan, Italy</li>
						<li>Phone: +39 02 1234 5678</li>
						<li>Email: info@rococo.com</li>
					</ul>
				</div>
				<div class="contact-form-wrapper">
					<?php if ($success): ?>
						<div class="success-message">Thank you for contacting us! We will respond soon.</div>
					<?php else: ?>
						<?php if ($error): ?>
							<div class="error-message"><?php echo htmlspecialchars($error); ?></div>
						<?php endif; ?>
						<form action="contact.php" method="POST" class="contact-form">
							<div class="form-group">
								<label for="name">Full Name</label>
								<input type="text" id="name" name="name" required>
							</div>
							<div class="form-group">
								<label for="email">Email Address</label>
								<input type="email" id="email" name="email" required>
							</div>
							<div class="form-group">
								<label for="message">Message</label>
								<textarea id="message" name="message" rows="4" required></textarea>
							</div>
							<div class="form-btn">
								<button type="submit" class="btn btn-primary">Send Message</button>
							</div>
						</form>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</section>
</main>
<?php
include __DIR__ . '/includes/footer.php';
?>
