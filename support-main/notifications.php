<?php
// Include functions file
include 'functions.php';

// Open connection to database
$pdo = pdo_connect_mysql();

// Check if customer is logged in and send them to login page if not
if (authentication_required && !isset($_SESSION['customer_logged_in'])) {
	header('Location: login.php');
	exit;
}



// Get Reply Notifications from database

$stmt = $pdo->prepare('Select * FROM Notification WHERE customer_id = ? AND notification_type = ? AND seen = False ORDER BY created ASC');

$stmt->execute([$_SESSION['customer_id'],1]);

$replynotifications = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Get Upload Request Notifications from database

$stmt = $pdo->prepare('Select * FROM Notification WHERE customer_id = ? AND notification_type = ? AND seen = False ORDER BY created ASC');

$stmt->execute([$_SESSION['customer_id'],2]);

$uploadnotifications = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<?=template_header('Notifications')?>

<div class="content tickets">

<h2>Tickets that have received a reply:</h2>

<div class="tickets-list">
	<?php foreach ($replynotifications as $replynotification): ?>
	<a href="view.php?ticket_id=<?=$replynotification['ticket_id']?>" class="ticket"> <?=$replynotification['ticket_id'] ?> </a>
	<?php endforeach; ?>
	<?php if(!$replynotifications): ?>
	<p> None of your open tickets have received a reply.</p>
	<?php endif; ?>
</div>
</div>

<div class="content tickets">

<h2>Tickets where an upload has been requested:</h2>

<div class="tickets-list">
	<?php foreach ($uploadnotifications as $uploadnotification): ?>
	<a href="view.php?ticket_id=<?=$uploadnotification['ticket_id']?>" class="ticket"> <?=$uploadnotification['ticket_id'] ?> </a>
	<?php endforeach; ?>
	<?php if(!$uploadnotifications): ?>
	<p> You have not received any requests to upload more information</p>
	<?php endif; ?>
</div>
</div>