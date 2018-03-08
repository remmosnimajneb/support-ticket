<?php
/********************************
* Project: Support Ticket System
* Code Version: 1.0
* Author: Benjamin Sommer
* GitHub: https://github.com/remmosnimajneb
* Theme Design by: HTML5 UP [HTML5UP.NET] - Theme `Identity`
* Licensing Information: CC BY-SA 4.0 (https://creativecommons.org/licenses/by-sa/4.0/)
***************************************************************************************/

/* Admin Updater Page
* Allows Administrators to review and close tickets
*/

//Include Functions Scripts
require '../functions.php';

//Start Session and check user is authenticated, if not send to login page
session_start();
if($_SESSION['SupportTicketAdmin_username'] === null){
	header('Location: login.php');
};
?>
<!DOCTYPE HTML>
<html>
	<head>
		<title>Add New Company | Support Ticket System</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<!--[if lte IE 8]><script src="../assets/js/html5shiv.js"></script><![endif]-->
		<link rel="stylesheet" href="../assets/css/main.css" />
		<!--[if lte IE 9]><link rel="stylesheet" href="../assets/css/ie9.css" /><![endif]-->
		<!--[if lte IE 8]><link rel="stylesheet" href="../assets/css/ie8.css" /><![endif]-->
		<noscript><link rel="stylesheet" href="../assets/css/noscript.css" /></noscript>
	</head>
	<body class="is-loading">

		<!-- Wrapper -->
			<div id="wrapper">

				<!-- Main -->
					<section id="main">
						<header>
							<h1>Add New Company | Support Ticket System</h1>
						</header>
						
						<hr />
							<form method="POST" action="adminUpdate.php">
								<input type="hidden" name="UpdateType" value="NewCompany" required="">
								<input type="text" name="CompanyName" placeholder="Company Name" required=""><br />								
								<input type="email" name="Email" placeholder="Email" required=""><br />
								<input type="text" name="PrimaryDomain" placeholder="Primary Domain" required=""><br />
								<input type="text" name="Name" placeholder="Name" required=""><br />
								<input type="text" name="Username" placeholder="Username" required=""><br />
								<input type="text" name="Password" placeholder="Password" required=""><br />
								<input type="submit" value="Submit">
							</form>						
						
						<hr />
					</section>

				<!-- Footer -->
					<footer id="footer">
						<ul class="copyright">
							<li>&copy; <a href="https://bensommer.net" target="_blank">Benjamin Sommer, 2017</a></li><li>Design: <a href="http://html5up.net">HTML5 UP</a></li>
						</ul>
					</footer>

			</div>

		<!-- Scripts -->
			<!--[if lte IE 8]><script src="assets/js/respond.min.js"></script><![endif]-->
			<script>
				if ('addEventListener' in window) {
					window.addEventListener('load', function() { document.body.className = document.body.className.replace(/\bis-loading\b/, ''); });
					document.body.className += (navigator.userAgent.match(/(MSIE|rv:11\.0)/) ? ' is-ie' : '');
				}
			</script>

	</body>
</html>