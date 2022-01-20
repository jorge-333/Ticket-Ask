<?php
// Include functions file
include 'functions.php';

// Open connection to database
$pdo = pdo_connect_mysql();

// Initialize output error variable
$login_errors = '';

// Customer authentication
if (isset($_POST['login'],$_POST['email'],$_POST['password'])) {
	// Get customer info from database
	$stmt = $pdo->prepare('SELECT * FROM Customer WHERE email = ?');
	$stmt->execute([$_POST['email']]);
	$customer = $stmt->fetch(PDO::FETCH_ASSOC);
	
	//Make sure customer account exists and that they've entered the correct password
	if ($customer && password_verify($_POST['password'],$customer['password'])) {
		// Declare the session variables
		$_SESSION['customer_logged_in'] = true;
		$_SESSION['customer_id'] = $customer['customer_id'];
		//Redirect to home page
		header('Location: index.php');
		exit;
	}else {
		$login_errors = 'Email or password is incorrect!';
	}
}
?>

<?=template_header('Login')?>

<div class="content update login">

	<div class="con">
		<h2>Login</h2>
		
		<form action="" method="post">
            <label for="email">Email</label>
            <input id="email" type="email" name="email" placeholder="Email" required>
            <label for="password">Password</label>
            <input id="password" type="password" name="password" placeholder="Password" required>
            <input type="submit" name="login">
            <p><?=$login_errors?></p>
        </form>

    </div>
</div>