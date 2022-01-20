<?php
// Include functions file
include 'functions.php';

// Open connection to database
$pdo = pdo_connect_mysql();

// Initialize output error variable
$login_errors = '';

// Employee authentication
if (isset($_POST['login'],$_POST['email'],$_POST['password'])) {
	// Get Employee info from database
	$stmt = $pdo->prepare('SELECT * FROM Employee WHERE email = ?');
	$stmt->execute([$_POST['email']]);
	$employee = $stmt->fetch(PDO::FETCH_ASSOC);
	
	//Make sure employee account exists and that they've entered the correct password
	if ($employee && password_verify($_POST['password'],$employee['password'])) {
		// Declare the session variables
		$_SESSION['employee_logged_in'] = true;
		$_SESSION['employee_id'] = $employee['employee_id'];
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