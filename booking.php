<?php
$pageTitle = "Rococo | Booking";
require_once __DIR__ . '/includes/config.php';
include __DIR__ . '/includes/header.php';

$success = false;
$errors = [];

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
	$allowedTimes = [
		'12:00','12:30','13:00','13:30','14:00','14:30','15:00','15:30',
		'16:00','16:30','17:00','17:30','18:00','18:30','19:00','19:30',
		'20:00','20:30','21:00','21:30'
	];
	$guests = $_POST['guests'] ?? '';
	$seating = $_POST['seating'] ?? 'none';
	$policy = isset($_POST['policy']);
	if (ctype_digit((string)$guests) && (int)$guests > 10) {
		// Redirect large parties to group bookings page with context
		$qs = '?guests=' . urlencode($guests);
		if ($date) $qs .= '&date=' . urlencode($date);
		if ($time) $qs .= '&time=' . urlencode($time);
		header('Location: group-bookings.php' . $qs);
		exit;
	}
	$name = trim($_POST['name'] ?? '');
	$phone = trim($_POST['phone'] ?? '');
	$email = trim($_POST['email'] ?? '');
	$special_requests = trim($_POST['special_requests'] ?? '');

	// Validation
	if (!$venue) { $errors['venue'] = 'Choose a venue.'; }
	if (!$date) { $errors['date'] = 'Select a date.'; }
	if (!$time) { $errors['time'] = 'Select a time.'; }
	if (!$guests) { $errors['guests'] = 'Select guests.'; }
	if (!$name) { $errors['name'] = 'Enter full name.'; }
	if (!$phone) { $errors['phone'] = 'Enter phone.'; }
	if (!$email) { $errors['email'] = 'Enter email.'; }
	elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) { $errors['email'] = 'Invalid email.'; }
	if ($time && !in_array($time, $allowedTimes, true)) { $errors['time'] = 'Invalid slot.'; }
	if ($guests && (!ctype_digit((string)$guests) || (int)$guests < 1 || (int)$guests > 20)) { $errors['guests'] = '1–20 only.'; }
	if (!$policy) { $errors['policy'] = 'Required.'; }

	if (!$errors) {
		$stmt = $conn->prepare("INSERT INTO bookings (venue, date, time, guests, name, phone, email, special_requests) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
		if ($stmt) {
			$stmt->bind_param('sssissss', $venue, $date, $time, $guests, $name, $phone, $email, $special_requests);
			if ($stmt->execute()) {
				$success = true;
			} else {
				$errors['general'] = 'Database error. Please try again.';
			}
			$stmt->close();
		} else {
			$errors['general'] = 'Server error. Please try later.';
		}
	}

	if (!$success) { // repopulate on failure
		$prefill['venue'] = $venue ?? '';
		$prefill['date'] = $date;
		$prefill['time'] = $time;
		$prefill['guests'] = $guests;
		$prefill['seating'] = $seating;
	}
}
?>
<main>
   <section class="booking-hero">
       <div class="booking-hero-inner">
           <h1>Book a Table</h1>
           <p class="lead">Reserve your spot for relaxed Italian hospitality. For 11+ guests please use our <a href="group-bookings.php">group enquiry form</a>.</p>
       </div>
   </section>
   <section class="booking-main">
       <div class="booking-wrapper">
           <?php if ($success): ?>
               <div class="booking-success" role="status" aria-live="polite">
                   <h2>Booking Received</h2>
                   <p>Thank you <?php echo htmlspecialchars($name); ?>. We’ve logged your request for <strong><?php echo htmlspecialchars(ucwords(str_replace('-', ' ', $venue))); ?></strong> on <strong><?php echo htmlspecialchars($date); ?></strong> at <strong><?php echo htmlspecialchars($time); ?></strong> for <strong><?php echo htmlspecialchars($guests); ?></strong>.</p>
                   <p>We’ll be in touch only if we need clarification. Otherwise just arrive a few minutes early. Need changes? <a href="booking.php">Make another booking</a>.</p>
               </div>
           <?php else: ?>
           <div class="booking-grid">
               <div class="booking-form-panel">
                   <?php if(!empty($errors['general'])): ?>
                       <div class="form-alert" role="alert"><?php echo htmlspecialchars($errors['general']); ?></div>
                   <?php endif; ?>
                   <form action="booking.php" method="POST" novalidate class="booking-form" aria-label="Booking Form">
                       <fieldset class="fg fg-inline">
                           <legend class="visually-hidden">Reservation Details</legend>
                           <div class="form-row">
                               <label for="venue">Venue</label>
                               <select id="venue" name="venue" aria-invalid="<?php echo isset($errors['venue'])? 'true':'false'; ?>">
                                   <option value="" disabled <?php echo ($prefill['venue']??'')===''? 'selected':''; ?>>Select venue</option>
                                   <?php foreach ($validVenues as $v): ?>
                                       <option value="<?php echo htmlspecialchars($v); ?>" <?php echo ($prefill['venue']??'')===$v? 'selected':''; ?>><?php echo ucwords(str_replace('-', ' ', $v)); ?></option>
                                   <?php endforeach; ?>
                               </select>
                               <?php if(isset($errors['venue'])): ?><span class="err-msg"><?php echo htmlspecialchars($errors['venue']); ?></span><?php endif; ?>
                           </div>
                           <div class="form-row">
                               <label for="guests">Guests</label>
                               <select id="guests" name="guests" aria-invalid="<?php echo isset($errors['guests'])? 'true':'false'; ?>">
                                   <option value="" disabled <?php echo ($prefill['guests']??'')===''? 'selected':''; ?>>Select</option>
                                   <?php for($g=1;$g<=20;$g++): ?>
                                       <option value="<?php echo $g; ?>" <?php echo ((string)($prefill['guests']??''))===(string)$g? 'selected':''; ?>><?php echo $g; ?></option>
                                   <?php endfor; ?>
                               </select>
                               <?php if(isset($errors['guests'])): ?><span class="err-msg"><?php echo htmlspecialchars($errors['guests']); ?></span><?php endif; ?>
                           </div>
                           <div class="form-row">
                               <label for="date">Date</label>
                               <input type="date" id="date" name="date" value="<?php echo htmlspecialchars($prefill['date']??''); ?>" aria-invalid="<?php echo isset($errors['date'])? 'true':'false'; ?>">
                               <?php if(isset($errors['date'])): ?><span class="err-msg"><?php echo htmlspecialchars($errors['date']); ?></span><?php endif; ?>
                           </div>
                           <div class="form-row">
                               <label for="time">Time</label>
                               <select id="time" name="time" aria-invalid="<?php echo isset($errors['time'])? 'true':'false'; ?>">
                                   <option value="" disabled <?php echo ($prefill['time']??'')===''? 'selected':''; ?>>Select</option>
                                   <?php foreach ($allowedTimes as $slot): ?>
                                       <option value="<?php echo $slot; ?>" <?php echo ($prefill['time']??'')===$slot? 'selected':''; ?>><?php $h=(int)substr($slot,0,2); $m=substr($slot,3,2); $ampm=$h>=12?'PM':'AM'; $displayH=$h>12?$h-12:$h; echo $displayH.':'.$m.' '.$ampm; ?></option>
                                   <?php endforeach; ?>
                               </select>
                               <?php if(isset($errors['time'])): ?><span class="err-msg"><?php echo htmlspecialchars($errors['time']); ?></span><?php endif; ?>
                           </div>
                       </fieldset>
                       <fieldset class="fg">
                           <legend class="visually-hidden">Contact Details</legend>
                           <div class="form-row">
                               <label for="name">Full Name</label>
                               <input type="text" id="name" name="name" maxlength="120" value="<?php echo htmlspecialchars($name ?? ''); ?>" aria-invalid="<?php echo isset($errors['name'])? 'true':'false'; ?>">
                               <?php if(isset($errors['name'])): ?><span class="err-msg"><?php echo htmlspecialchars($errors['name']); ?></span><?php endif; ?>
                           </div>
                           <div class="form-row">
                               <label for="phone">Phone</label>
                               <input type="tel" id="phone" name="phone" maxlength="40" value="<?php echo htmlspecialchars($phone ?? ''); ?>" aria-invalid="<?php echo isset($errors['phone'])? 'true':'false'; ?>">
                               <?php if(isset($errors['phone'])): ?><span class="err-msg"><?php echo htmlspecialchars($errors['phone']); ?></span><?php endif; ?>
                           </div>
                           <div class="form-row">
                               <label for="email">Email</label>
                               <input type="email" id="email" name="email" maxlength="160" value="<?php echo htmlspecialchars($email ?? ''); ?>" aria-invalid="<?php echo isset($errors['email'])? 'true':'false'; ?>">
                               <?php if(isset($errors['email'])): ?><span class="err-msg"><?php echo htmlspecialchars($errors['email']); ?></span><?php endif; ?>
                           </div>
                       </fieldset>
                       <fieldset class="fg">
                           <legend class="visually-hidden">Preferences</legend>
                           <div class="form-row">
                               <label for="seating">Seating Preference <span class="opt">(optional)</span></label>
                               <select id="seating" name="seating">
                                   <?php $seatVal = $prefill['seating'] ?? 'none'; ?>
                                   <option value="none" <?php echo $seatVal==='none'?'selected':''; ?>>No preference</option>
                                   <option value="inside" <?php echo $seatVal==='inside'?'selected':''; ?>>Inside</option>
                                   <option value="outside" <?php echo $seatVal==='outside'?'selected':''; ?>>Outside</option>
                               </select>
                           </div>
                           <div class="form-row full">
                               <label for="special_requests">Special Requests <span class="opt">(optional)</span></label>
                               <textarea id="special_requests" name="special_requests" rows="4" maxlength="600"><?php echo htmlspecialchars($special_requests ?? ''); ?></textarea>
                           </div>
                           <div class="form-row policy-row">
                               <label class="policy-checkbox">
                                   <input type="checkbox" name="policy" value="1" <?php echo isset($policy)&&$policy? 'checked':''; ?>>
                                   <span>I accept the <a href="#" tabindex="0">booking terms</a> & 2‑hour seating policy.</span>
                               </label>
                               <?php if(isset($errors['policy'])): ?><span class="err-msg"><?php echo htmlspecialchars($errors['policy']); ?></span><?php endif; ?>
                           </div>
                       </fieldset>
                       <div class="form-actions">
                           <button type="submit" class="btn alt-btn">Confirm Booking</button>
                       </div>
                   </form>
               </div>
               <aside class="booking-side">
                   <div class="booking-photo-card">
                       <img src="assets/images/wood-fire.jpg" loading="lazy" width="600" height="780" alt="Warm Italian restaurant interior with wood-fired oven and rustic ambience">
                       <div class="booking-photo-overlay">
                           <p class="booking-photo-caption"><span aria-hidden="true">🍷</span> La tavola è pronta</p>
                       </div>
                   </div>
                   <div class="side-card">
                       <h3>Before You Visit</h3>
                       <ul class="bullet-mini">
                           <li>We hold tables for 10 minutes past booking time.</li>
                           <li>Outdoor seating subject to weather.</li>
                           <li>Dietaries? List them in Special Requests.</li>
                           <li>11+ guests: <a href="group-bookings.php">group enquiry</a>.</li>
                       </ul>
                   </div>
                   <div class="side-card alt">
                       <h3>Need to Change?</h3>
                       <p>Email <a href="mailto:enquiry@rococo.local">enquiry@rococo.local</a> or call the venue directly.</p>
                   </div>
               </aside>
           </div>
           <?php endif; ?>
       </div>
   </section>
</main>
<?php
include __DIR__ . '/includes/footer.php';
?>
