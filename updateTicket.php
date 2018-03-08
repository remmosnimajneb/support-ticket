<?php
/********************************
* Project: Support Ticket System
* Code Version: 1.0
* Author: Benjamin Sommer
* GitHub: https://github.com/remmosnimajneb
* Theme Design by: HTML5 UP [HTML5UP.NET] - Theme `Identity`
* Licensing Information: CC BY-SA 4.0 (https://creativecommons.org/licenses/by-sa/4.0/)
***************************************************************************************/

/* Ticket Updater Page
* Get information from various forms and add, edit and close tickets in the system
*/

//Include Functions and Mailer scripts
require 'functions.php';
require 'mailer.php';

//Start Session and check user is authenticated, if not send to login page
session_start();
if($_SESSION['SupportTicketClient_username'] === null || $_SESSION['SupportTicketAdmin_username'] === null){
	header('Location: login.php');
};

//Get the update type [Options allowed: 'NewTicket', 'EditTicket', 'CloseTicket', 'DeleteTicket', 'EmailClient']
	$updateType = $_POST['UpdateType'];
	$sql;
	$msg;

//Switch to run script for various ticket updates, set the SQL code for DB update and $msg for the email sender
switch ($updateType) {
	case 'NewTicket':
		$sql = "INSERT INTO `tickets` (TicketUsername, TicketCompanyName, TicketDomainAffected, TicketTitle, TicketDescription, TicketStatus, TicketPriority, TicketSubmittionDate) VALUES ('".$_SESSION['SupportTicketClient_username']."','".$_SESSION['SupportTicketClient_CompanyName']."','".$_POST['TicketDomainAffected'] . "','" . $_POST['TicketTitle']."','". $_POST['TicketDescription'] . "','open','" . $_POST['TicketPriority'] . "','" . date("l jS \of F Y") . "')";
		$msg = "Ticket Title: " . $_POST['TicketTitle'] . "<br /> Ticket Description: " . $_POST['TicketDescription'] . "<br /> Domain Affected: " . $_POST['TicketDomainAffected'] . "<br /> Ticket Priority: " . $_POST['TicketPriority'] . "<br /> Company: " . $_SESSION['SupportTicketClient_CompanyName'] . "<br />User Submitted: " . $_SESSION['SupportTicketClient_username'];
		break;

	case 'EditTicket':
		$sql ="UPDATE `tickets` SET `TicketTitle` = '" . $_POST['TicketTitle'] . "', `TicketDescription` = '" . $_POST['TicketDescription'] . "', `TicketPriority` = '" . $_POST['TicketPriority'] . "', `TicketDomainAffected` = '" . $_POST['TicketDomainAffected'] . "' WHERE `TicketID` LIKE '" . $_POST['TicketID'] . "'";
		$msg =   "Ticket Title: " . $_POST['TicketTitle'] . "<br /> Ticket Description: " . $_POST['TicketDescription'] . "<br /> Domain Affected: " . $_POST['TicketDomainAffected'] . "<br /> Ticket Priority: " . $_POST['TicketPriority'];
		break;

	case 'DeleteTicket':
		$sql = "DELETE FROM `tickets` WHERE `TicketID` LIKE '" . $_POST['TicketID'] . "'";
		$msg = $_POST['TicketID'];
		break;

	case 'CloseTicket':
		$sql = "UPDATE `tickets` SET `TicketStatus` = 'closed' WHERE `TicketID` LIKE '" . $_POST['TicketID'] . "'";
		$msg = $_POST['TicketID'];
		break;
	case 'EmailClient':
		$msg = $_POST['TicketID'];
		break;
};

	$stm = $con->prepare($sql);
	$stm->execute();

	//If the code ran properly and DB is updated
	if($stm){
		//Send email via mailer.php
		sendMail($updateType, $msg, "", "");

		//And redirect to index.php
		if($_SESSION['SupportTicketClient_username'] != null){
			header('Location: index.php');
		} else if($_SESSION['SupportTicketAdmin_username'] != null){
			header('Location: admin/index.php');
		};
	};

?>