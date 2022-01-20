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

// Retrieve Queues from database
$queues = $pdo->query('SELECT * FROM Queue')->fetchAll(PDO::FETCH_ASSOC);

// Retrieve Priorities from database
$priorities = $pdo->query('SELECT * FROM Priority')->fetchAll(PDO::FETCH_ASSOC);

// Retrieve Statuses from database
$statuses = $pdo->query('SELECT * from Status')->fetchAll(PDO::FETCH_ASSOC);

// Retrieve specific filters if included in URL or set to 'all'
$status_id = isset($_GET['status_id']) ? $_GET['status_id'] : 'all';
$queue_id = isset($_GET['queue_id']) ? $_GET['queue_id'] : 'all';
$priority_id = isset($_GET['priority_id']) ? $_GET['priority_id'] : 'all';

//Create SQL string that will be used to retrieve tickets from database
$sql = 'WHERE customer_id = :customer_id AND';
$sql .= $status_id != 'all' ? ' status_id = :status_id AND' : '';
$sql .= $queue_id != 'all' ? ' queue_id = :queue_id AND' : '';
$sql .= $priority_id != 'all' ? ' priority_id = :priority_id AND' : '';

//Remove final trailing AND from $sql
$sql = rtrim($sql,'AND');

//Prepare SQL query
$stmt = $pdo->prepare('SELECT * FROM Ticket ' . $sql . ' ORDER BY opened ASC');

//Bind the paramaters
$stmt->bindParam(':customer_id',$_SESSION['customer_id']);

if ($status_id != 'all') {
	$stmt->bindParam(':status_id',$status_id);
}
if ($queue_id != 'all') {
	$stmt->bindParam(':queue_id',$queue_id);
}
if ($priority_id != 'all') {
	$stmt->bindParam(':priority_id',$priority_id);
}

$stmt->execute();

//Retrieve tickets from database
$tickets = $stmt->fetchAll(PDO::FETCH_ASSOC);

//Get current totals of tickets for different categories
$stmt = $pdo->prepare('SELECT COUNT(*) FROM Ticket WHERE customer_id = ?');
$stmt->execute([$_SESSION['customer_id']]);
$num_tickets = $stmt->fetchColumn();

$stmt = $pdo->prepare('SELECT COUNT(*) FROM Ticket WHERE status_id= ? AND customer_id = ?');
$stmt->execute([1,$_SESSION['customer_id']]);
$num_open_tickets = $stmt->fetchColumn();

$stmt = $pdo->prepare('SELECT COUNT(*) FROM Ticket WHERE status_id= ? AND customer_id = ?');
$stmt->execute([2,$_SESSION['customer_id']]);
$num_closed_tickets = $stmt->fetchColumn();

$stmt = $pdo->prepare('SELECT COUNT(*) FROM Ticket WHERE status_id= ? AND customer_id = ?');
$stmt->execute([3,$_SESSION['customer_id']]);
$num_resolved_tickets = $stmt->fetchColumn();

//Set string values that will be used on page
if ($status_id == 1) {
	$status_str = 'open';
} elseif ($status_id == 2) {
	$status_str = 'closed';
} elseif ($status_id == 3) {
	$status_str = 'resolved';
} else {
	$status_str = 'all';
}

/*if ($priority_id == 1) {
	$priority_str = 'Low';
} elseif ($priority_id == 2) {
	$priority_str = 'Medium';
} elseif ($priority_id == 3) {
	$priority_str = 'High';
} else {
	$priority_str = 'all';
}*/

if ($queue_id == 1) {
	$queue_str = 'support';
} elseif ($queue_id == 2) {
	$queue_str = 'billing';
} elseif ($queue_id == 3) {
	$queue_str = 'sales';
} else {
	$queue_str = 'all';
}
?>
<?=template_header('Tickets')?>

<div class="content tickets">

<h2><?=ucfirst($status_str)?> Tickets</h2>


<form action="" method="get">
	<div>
		<label for="status_id">Status</label>
		<select name="status_id" id="status_id" onchange="this.parentElement.parentElement.submit()">
			<option value="all"<?=$status_id=='all'?' selected':''?>>All (<?=number_format($num_tickets)?>)</option>
			<option value=1<?=$status_id==1 ?' selected':""?>>Open (<?=number_format($num_open_tickets)?>)</option>
			<option value=2<?=$status_id==2 ?' selected':""?>>Closed (<?=number_format($num_closed_tickets)?>)</option>
			<option value=3<?=$status_id==3 ?' selected':""?>>Resolved (<?=number_format($num_resolved_tickets)?>)</option>
		</select>
		
		<label for="priority_id">Priority</label>
		<select name="priority_id"id="priority_id" onchange="this.parentElement.parentElement.submit()">
			<option value="all"<?=$priority_id=='all'?' selected':''?>>All</option>
			<option value=1<?=$priority_id==1 ?' selected':""?>>Low</option>
			<option value=2<?=$priority_id==2 ?' selected':""?>>Medium</option>
			<option value=3<?=$priority_id==3 ?' selected':""?>>High</option>
		</select>
		
		<label for="queue_id">Department</label>
		<select name="queue_id"id="queue_id" onchange="this.parentElement.parentElement.submit()">
			<option value="all"<?=$queue_id=='all'?' selected':''?>>All</option>
			<option value=1<?=$queue_id==1 ?' selected':""?>>Support</option>
			<option value=2<?=$queue_id==2 ?' selected':""?>>Billing</option>
			<option value=3<?=$queue_id==3 ?' selected':""?>>Sales</option>
		</select>
	</div>
</form>

<div class="tickets-list">
	<?php foreach ($tickets as $ticket): ?>
	<a href="view.php?ticket_id=<?=$ticket['ticket_id']?>" class="ticket"> 
		
		
		<span class="con">
			<?php if ($ticket['status_id'] == 1): ?>
			<i class="fas fa-ticket-alt fa-2x"></i>
			<?php elseif ($ticket['status_id'] == 2): ?>
			<i class="far fa-window-close fa-2x"></i>
			<?php elseif ($ticket['status_id'] == 3): ?>
			<i class="far fa-check-circle fa-2x"></i>
			<?php endif; ?>
		</span>
		
		<span class="con">
				<span class="title"><?=htmlspecialchars($ticket['subject'], ENT_QUOTES)?></span>
		</span>
		
		<span class="con2">
				<span class="created responsive-hidden"><?=date('F dS, G:ia', strtotime($ticket['opened']))?>
				</span>
				<?php if ($ticket['priority_id'] == 1): ?>
				<span class="priority low">Low</span>
				<?php elseif ($ticket['priority_id'] == 2): ?>
				<span class="priority medium">Medium</span>
				<?php elseif ($ticket['priority_id'] == 3): ?>
				<span class="priority high">High</span>
				<?php endif; ?>
		</span>
	<?php endforeach; ?>
	<?php if(!$tickets): ?>
	<p> No tickets match this criteria.</p>
	<?php endif; ?>
</div>
</div>