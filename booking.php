<?php
$pageTitle = "Rococo | Booking";
require_once __DIR__ . '/includes/config.php';
include __DIR__ . '/includes/header.php';

$success = false;
$error = '';

// Accept prefill from quick booking bar (GET)
$prefill = [
	'venue' => $_GET['venue'] ?? '',
	'date' => $_GET['date'] ?? '',
	'time' => $_GET['time'] ?? '',
	'guests' => $_GET['guests'] ?? ''
];

$validVenues = ['st-kilda','hawthorn','point-cook','mordialloc'];
if ($prefill['venue'] && !in_array($prefill['venue'], $validVenues, true)) {
	$prefill['venue'] = '';
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$venue = isset($_POST['venue']) && in_array($_POST['venue'], $validVenues, true) ? $_POST['venue'] : null;
	$date = $_POST['date'] ?? '';
	$time = $_POST['time'] ?? '';
	$guests = $_POST['guests'] ?? '';
	$name = trim($_POST['name'] ?? '');
	$phone = trim($_POST['phone'] ?? '');
	$email = trim($_POST['email'] ?? '');
	$special_requests = trim($_POST['special_requests'] ?? '');

	if (!$date || !$time || !$guests || !$name || !$phone || !$email) {
		$error = 'Please fill in all required fields.';
	} elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		$error = 'Invalid email address.';
	} else {
		$stmt = $conn->prepare("INSERT INTO bookings (venue, date, time, guests, name, phone, email, special_requests) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
		if ($stmt) {
			$stmt->bind_param('sssissss', $venue, $date, $time, $guests, $name, $phone, $email, $special_requests);
			if ($stmt->execute()) {
				$success = true;
			} else {
				$error = 'Database execution error.';
			}
			$stmt->close();
		} else {
			$error = 'Database preparation error.';
		}
	}

	if (!$success) { // repopulate on failure
		$prefill['venue'] = $venue ?? '';
		$prefill['date'] = $date;
		$prefill['time'] = $time;
		$prefill['guests'] = $guests;
	}
}
?>
<main>
   <section class="booking-section section">
	   <div class="container">
		   <h1 class="section-heading">Book a Table</h1>
		   <div class="section-divider"></div>
		   <?php if ($success): ?>
			   <div class="success-message">Thank you for your booking! We will contact you soon.</div>
		   <?php else: ?>
			   <?php if ($error): ?>
				   <div class="error-message"><?php echo htmlspecialchars($error); ?></div>
			   <?php endif; ?>
			   <form action="booking.php" method="POST" class="booking-form" aria-label="Booking Form">
			   <div class="form-group">
			       <label for="venue">Venue</label>
			       <select id="venue" name="venue">
			           <option value="" <?php echo $prefill['venue']===''? 'selected':''; ?>>Select Venue (optional)</option>
			           <?php foreach ($validVenues as $v): ?>
			               <option value="<?php echo htmlspecialchars($v); ?>" <?php echo $prefill['venue']===$v? 'selected':''; ?>><?php echo ucwords(str_replace('-', ' ', $v)); ?></option>
			           <?php endforeach; ?>
			       </select>
			   </div>
				   <div class="form-group">
					   <label for="date">Date</label>
					   <input type="date" id="date" name="date" value="<?php echo htmlspecialchars($prefill['date']); ?>" required>
				   </div>
				   <div class="form-group">
					   <label for="time">Time</label>
					   <input type="time" id="time" name="time" value="<?php echo htmlspecialchars($prefill['time']); ?>" required>
				   </div>
				   <div class="form-group">
					   <label for="guests">Number of Guests</label>
					   <input type="number" id="guests" name="guests" min="1" value="<?php echo htmlspecialchars($prefill['guests']); ?>" required>
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
				   <div class="form-btn" style="margin-top:32px; text-align:center;">
					   <button type="submit" class="button" aria-label="Book Now">Book Now</button>
				   </div>
			   </form>
		   <?php endif; ?>
	   </div>
   </section>
</main>
<?php
include __DIR__ . '/includes/footer.php';
?>
