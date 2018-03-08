<?php
/********************************
* Project: Support Ticket System
* Code Version: 1.0
* Author: Benjamin Sommer
* GitHub: https://github.com/remmosnimajneb
* Theme Design by: HTML5 UP [HTML5UP.NET] - Theme `Identity`
* Licensing Information: CC BY-SA 4.0 (https://creativecommons.org/licenses/by-sa/4.0/)
***************************************************************************************/

/* Main Index page 
* Shows current tickets with options to add new tickets
*/

//Include functions page
require 'functions.php';

//Start Session and check user is authenticated, if not send to login page
session_start();
if($_SESSION['SupportTicketClient_username'] === null){
	header('Location: login.php');
};
?>
<!DOCTYPE HTML>
<html>
	<head>
		<title>Main | Support Ticket System</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<!--[if lte IE 8]><script src="assets/js/html5shiv.js"></script><![endif]-->
		<link rel="stylesheet" href="assets/css/main.css" />
		<!--[if lte IE 9]><link rel="stylesheet" href="assets/css/ie9.css" /><![endif]-->
		<!--[if lte IE 8]><link rel="stylesheet" href="assets/css/ie8.css" /><![endif]-->
		<noscript><link rel="stylesheet" href="assets/css/noscript.css" /></noscript>
		<script type="text/javascript" src="assets/js/jquery.js"></script>
	</head>
	<body class="is-loading">

		<!-- Wrapper -->
			<div id="wrapper">

				<!-- Main -->
					<section id="main">
						<header>
							<h1>Support Ticket System</h1>
						</header>
						<a href="newTicket.php"><button>Add New Ticket</button></a> | <a href="logout.php"><button>Log Out</button></a>
						
						<hr />
						<?php
							//Select all open tickets from the database for this company name. Company Name is Global Variable set by $_SESSION when logged in
							$sql = "SELECT * FROM `tickets` WHERE `TicketCompanyName` like '".$_SESSION['SupportTicketClient_CompanyName']."' AND `TicketStatus` like 'open'";
							$stm = $con->prepare($sql);
							$stm->execute();
							$records = $stm->fetchAll();
							echo "<table><tr>
										<td>Ticket ID</td>
										<td>Ticket Priority</td>
										<td>Ticket Status</td>
										<td>Ticket Title</td>
										<td>Ticket Date</td>
										<td>Ticket Creator</td>
										<td>Edit Ticket</td>
										<td>Delete Ticket</td>
									</tr>";
							//On your marks, get set, recursion!
							foreach($records as $row){
								echo "<tr>
										<td>" . $row['TicketID'] . "</td>
										<td>" . $row['TicketPriority'] . "</td>
										<td>" . $row['TicketStatus'] . "</td>
										<td>" . $row['TicketTitle'] . "</td>
										<td>" . $row['TicketSubmittionDate'] . "</td>
										<td>" . $row['TicketUsername'] . "</td>
										<td><a href='editTicket.php?TicketID=".$row['TicketID']."'>Edit</a></td>
										<td onclick='confirmDelete(" . $row['TicketID'] . ")'>Delete</td>
									</tr>";
							};
							echo "</table>";
							?>
							<!--Start Modal-->
							<div id="modal" class="modal" style="padding-top: 304px; display: none;">
								<div class="modal-content">
									<div class="modal-header">
										<span class="close">×</span>
										<h2>Delete Ticket</h2>
									</div>
									<div class="modal-body">
										<p>Are you sure you want to delete this Ticket?</p>
										<input id="TicketID" value="" type="hidden">
										<button id="idButton" onclick="deleteTicket(TicketID)">Delete Ticket</button><br><br>
									</div>
									<div class="modal-footer">
										<h3></h3>
									</div>
								</div>
							</div>
							<!--End Modal-->
						
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
			<script type="text/javascript">
				//Modal Setup
				var modal = document.getElementById('modal');
				var span = document.getElementsByClassName("close")[0];

				function confirmDelete(TicketID){
					document.getElementById("idButton").setAttribute("onclick", "sendUpdate("+TicketID+")"); 
					var length = $(window).scrollTop();
					var modal = document.getElementById('modal');
					modal.style.paddingTop = length + "px";
					modal.style.display = "block";
					document.getElementById('modal' + action).style.display = "block";
				};

				span.onclick = function() { //Close modal on click of 'x'
				    modal.style.display = "none";
				}
				window.onclick = function(event) { //Close modal if click anywhere else on page
				    if (event.target == modal) {
				        modal.style.display = "none";
				    }
				}

				function sendUpdate(TicketID){
					$.ajax({ 
						data: {'UpdateType': 'DeleteTicket', 'TicketID':TicketID}, //Send the database ID number
						url: 'updateTicket.php', 
						method: 'POST', 
						success: function(msg){ 
							alert("Update Success!");
							modal.style.display = "none";
							window.location.reload(false);
						},
						error: function(){
			   				alert("Yikes! It seems something went wrong. Please try again or reload the page.");
						},
					});
				};
			</script>
	</body>
</html>