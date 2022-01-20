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

// Check if customer has filled out form
if (isset($_POST['subject'], $_POST['msg'],$_POST['priority'],$_POST['queue'])) {
	//Perform Validation Checks
	if (empty($_POST['subject']) || empty($_POST['msg']) || empty($_POST['priority']) || empty($_POST['queue'])) {
		$msg = "Please make sure you complete all fields in the form.";
	} else {
		// Create new ticket and insert data
		$stmt = $pdo->prepare('INSERT INTO Ticket (subject,customer_id,priority_id,queue_id) VALUES (?,?,?,?)');
		$stmt->execute([ $_POST['subject'],$_SESSION['customer_id'],$_POST['priority'],$_POST['queue'] ]);
		
		// Retrieve ticket_id from newly created ticket
		$ticket_id = $pdo->lastInsertID();
		
		// Create new TicketContent entry and insert data
		$stmt = $pdo->prepare('INSERT INTO TicketContent (ticket_id,content_type,content,customer_id,employee_id) VALUES (?,?,?,?,?)');
		$stmt->execute([$ticket_id, 1, $_POST['msg'],$_SESSION['customer_id'],NULL]);
		header('Location: view.php?ticket_id=' . $ticket_id );
	}
	
} ?>

<?=template_header('Submit Ticket')?>

 <div class="content update">


    <form action="" method="post" class="responsive-width-100" enctype="multipart/form-data">
        <label for="subject">Subject</label>
        <input type="text" name="subject" placeholder="Subject" id="subject" required>
        <label for="queue">Department</label>
        <select name="queue" id="queue">
            <?php foreach($queues as $queue): ?>
            <option value="<?=$queue['queue_id']?>"><?=$queue['queue']?></option>
            <?php endforeach; ?>
        </select>
        <label for="priority">Priority</label>
        <select name="priority" id="priority" required>
             <?php foreach($priorities as $priority): ?>
             <option value="<?=$priority['priority_id']?>"><?=$priority['priority']?></option>
             <?php endforeach; ?>
        </select>
        <label for="msg">Message</label>
        <textarea name="msg" placeholder="Enter your message here..." id="msg" required></textarea>
        <input type="submit" value="Submit">
    </form>

    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>

</div>