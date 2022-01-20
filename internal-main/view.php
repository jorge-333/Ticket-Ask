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

if (!isset($_GET['ticket_id'])) {
	exit('No Ticket ID given!');
}

//Retrieve Ticket from database
$stmt = $pdo->prepare('Select * FROM Ticket WHERE ticket_id = ?');
$stmt->execute([$_GET['ticket_id']]);
$ticket = $stmt->fetch(PDO::FETCH_ASSOC);

//Check that ticket exists
if (!$ticket) {
	exit('Invalid Ticket ID!');
}

//Retrieve TicketContent from database
$stmt = $pdo->prepare('Select * FROM TicketContent WHERE ticket_id = ? AND content_type = 1 ORDER BY created ASC');
$stmt->execute([$_GET['ticket_id']]);
$ticketcontents = $stmt->fetchAll(PDO::FETCH_ASSOC);

//Check if "Update Status" form has been submited
if (isset($_POST['new_status'])){
	$stmt = $pdo->prepare('UPDATE Ticket SET status_id = ? WHERE ticket_id = ?');
	$stmt->execute([$_POST['new_status'],$ticket['ticket_id']]);
	header('Location: view.php?ticket_id=' . $ticket['ticket_id']);
	exit;
}

//Check if "Send Reply" form has been submitted
if (isset($_POST['reply'])) {
	//Store reply in database
	$stmt = $pdo->prepare('INSERT INTO TicketContent (ticket_id,content_type,content,customer_id,employee_id) VALUES (?,?,?,?,?)');
	$stmt->execute([$ticket['ticket_id'], 1, $_POST['reply'],NULL,$_SESSION['employee_id']]);
	$stmt = $pdo->prepare('UPDATE Ticket SET status_id = ? WHERE ticket_id = ?');
	$stmt->execute([1,$ticket['ticket_id']]);
	if(isset($_POST['uploadrequested'])){
		//Create "Upload Requested" notification
		$stmt = $pdo->prepare('INSERT INTO Notification (ticket_id,notification_type,customer_id,employee_id) VALUES (?,?,?,?)');
		$stmt->execute([$ticket['ticket_id'], 2,$ticket['customer_id'],$_SESSION['employee_id']]);
	}else {
		//Create "Reply" notification
		$stmt = $pdo->prepare('INSERT INTO Notification (ticket_id,notification_type,customer_id,employee_id) VALUES (?,?,?,?)');
		$stmt->execute([$ticket['ticket_id'], 1,$ticket['customer_id'],$_SESSION['employee_id']]);
	}
	header('Location: view.php?ticket_id=' . $ticket['ticket_id'] );
	exit;
}

if ($ticket['priority_id'] == 1) {
	$priority_str = 'Low';
} elseif ($ticket['priority_id'] == 2) {
	$priority_str = 'Medium';
} elseif ($ticket['priority_id'] == 3) {
	$priority_str = 'High';
}

if ($ticket['status_id'] == 1) {
	$status_str = 'Open';
} elseif ($ticket['status_id'] == 2) {
	$status_str = 'Closed';
} elseif ($ticket['status_id'] == 3) {
	$status_str = 'Resolved';
}

if ($ticket['queue_id'] == 1) {
	$queue_str = 'Support';
} elseif ($ticket['queue_id'] == 2) {
	$queue_str = 'Billing';
} elseif ($ticket['queue_id'] == 3) {
	$queue_str = 'Sales';
}
?>
<?=template_header(htmlspecialchars($ticket['subject'], ENT_QUOTES))?>

<div class="content view">
	<h2><?=htmlspecialchars($ticket['subject'], ENT_QUOTES)?><span class="<?=strtolower($status_str)?>">(<?=$status_str?>)</span></h2>
	
	<div class="ticket">
        <div>
            <p>
                <span class="priority <?=strtolower($priority_str)?>"><?=$priority_str?></span>
                <span class="sep">&bull;</span>
                <span class="category"><?=$queue_str?></span>
			</p>
			<p class="created"><?=date('F dS, G:ia', strtotime($ticket['opened']))?></p>
		</div>
    </div>
	<div class="content update">
	
		<form action="" method="post" class="responsive-width-100" enctype="multipart/form-data">
			<label for="new_status">Update Ticket Status:</label>
			<select name="new_status" id="new_status" required>
				<option value=2>Closed</option>
				<option value=3>Resolved</option>
			</select>
			<input type="submit" value="Update">
		</form>
	</div>


<div class="comments">
	<?php foreach ($ticketcontents as $ticketcontent): ?>
		<div class="comment">
			<div>
				<i class="fas fa-reply fa-2x"></i>
			</div>
			<p>
				<span class="header">
					<?php $name="Customer"; ?>
					<?php $class = ''; ?>
					<?php if ($ticketcontent['customer_id'] == NULL ): ?>
						<?php $name="YourLocalHost"; ?>
						<?php $class = ' is-admin'; ?>
					<?php endif; ?>
					<span class="name <?=$class?>"><?=$name ?> wrote:</span>
					
					<span class="date"><?=date('F dS, G:ia', strtotime($ticketcontent['created']))?></span>
				</span>
			<? echo $ticketcontent['content'] ?>
			</p>
		</div>
	<?php endforeach; ?>
	
	<div class="content update">
	
		<form action="" method="post" class="responsive-width-100" enctype="multipart/form-data">
			<label for="reply">New Reply</label>
			<textarea name="reply" placeholder="Enter your reply here..." id="reply" required></textarea>
			
			<label for="uploadrequested"> Check box if upload is requested. </label>
			<input type="checkbox" id="uploadrequested" name="uploadrequested" value="yes">
			
			<input type="submit" value="Send Reply">
		</form>
	</div>
</div>
	
