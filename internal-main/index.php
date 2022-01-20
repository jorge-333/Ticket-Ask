<?php
// Include functions file
include 'functions.php';

// Open connection to database
$pdo = pdo_connect_mysql();

// Check if employee is logged in and send them to login page if not
if (authentication_required && !isset($_SESSION['employee_logged_in'])) {
	header('Location: login.php');
	exit;
}

// Get total number of tickets for each status

$stmt = $pdo->prepare('SELECT COUNT(*) FROM Ticket WHERE status_id = ?');

$stmt->execute([1]);
$num_tickets_open = $stmt->fetchColumn();

$stmt = $pdo->prepare('SELECT COUNT(*) FROM Ticket WHERE status_id = ?');

$stmt->execute([2]);
$num_tickets_closed = $stmt->fetchColumn();

$stmt = $pdo->prepare('SELECT COUNT(*) FROM Ticket WHERE status_id = ?');

$stmt->execute([3]);
$num_tickets_resolved = $stmt->fetchColumn();
?>

<?=template_header('Home')?>

<div class="content home">

	<div class="tickets-links responsive-width-100">
		<a href="tickets.php?status_id=1" class="open responsive-width-100">
			<i class="fas fa-ticket-alt fa-10x"></i>
			<span class="num"><?=number_format($num_tickets_open)?></span>
			<span class="title">Open Tickets</span>
		</a>
		<a href="tickets.php?status_id=2" class="closed responsive-width-100">
			<i <i class="far fa-window-close fa-10x"></i>
			<span class="num"><?=number_format($num_tickets_closed)?></span>
			<span class="title">Closed Tickets</span>
		</a>
		<a href="tickets.php?status=3" class="resolved responsive-width-100">
			<i class="far fa-check-circle fa-10x"></i>
			<span class="num"><?=number_format($num_tickets_resolved)?></span>
			<span class="title">Resolved Tickets</span>
		</a>

	</div>	
</div>