<?php
/* This file contains the functions used by the support ticket system */

session_start();

// Inlcude the configuration file
include_once 'config.php';

/* This function establishes the connection to the database. If the connection fails, it outputs an error */
function pdo_connect_mysql() {
	try {
		$pdo = new PDO('mysql:host=' . db_host . ';dbname=' . db_name . ';charset=' . db_charset, db_user, db_pass);
		
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	} catch (PDOException $exception) {
		exit('Database connection error!');
	}
	return $pdo;
}

/* This is the template header we can use to keep the header consistent across all pages */
function template_header($title) {
	$login_link = isset($_SESSION['customer_logged_in']) ? '<a href="logout.php"><i class="bx bx-log-out"></i><span class="links_name">Log out</span></a>' : '<a href="login.php"><i class="bx bx-log-in"></i><span>Login</span></a>';
	
echo <<<EOT
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>$title</title>
		<link href="style.css" rel="stylesheet" type="text/css">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
		<link href="https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css" rel="stylesheet">
	</head>
	<body>
		<div class="sidebar">
    		<div class="logo-details">
				<i class='bx bx-message-alt-dots'></i>
      			<span class="logo_name">TicketAsk</span>
    		</div>
      			<ul class="nav-links">
        			<li>
          				<a href="index.php" class="active">
            				<i class='bx bx-grid-alt' ></i>
            				<span class="links_name">Dashboard</span>
          				</a>
        			</li>
        			<li>
						<a href="create.php">
							<i class='bx bxs-coupon'></i>
							<span class="links_name">Submit Ticket</span>
						</a>
					</li>
					<li>
						<a href="tickets.php">
							<i class='bx bx-list-ul' ></i>
							<span class="links_name">View Tickets</span>
						</a>
					</li>
					<li>
						<a href="#">
							<i class='bx bx-cog' ></i>
							<span class="links_name">Setting</span>
						</a>
					</li>
					<li class="log_out">
						$login_link
					</li>
				</ul>
		</div>
	<section class="home-section">
		<nav>
			<div class="sidebar-button">
				<i class='bx bx-menu sidebarBtn'></i>
				<span class="dashboard">Welcome To The Employee Internal Portal</span>
			</div>
			<div class="search-box">
				<input type="text" placeholder="Search...">
				<i class='bx bx-search' ></i>
			</div>
		</nav>
	
	<script>
		let sidebar = document.querySelector(".sidebar");
	let sidebarBtn = document.querySelector(".sidebarBtn");
	sidebarBtn.onclick = function() {
  		sidebar.classList.toggle("active");
 		if(sidebar.classList.contains("active")){
  		sidebarBtn.classList.replace("bx-menu" ,"bx-menu-alt-right");
	}else
  		sidebarBtn.classList.replace("bx-menu-alt-right", "bx-menu");
	}
 	</script>
EOT;
}
?>