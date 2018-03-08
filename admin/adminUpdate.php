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

//Include Functions and Mailer Scripts
require '../functions.php';
require '../mailer.php';

//Start Session and check user is authenticated, if not send to login page
session_start();
if($_SESSION['SupportTicketAdmin_username'] === null){
	header('Location: login.php');
};

//Set Update Type
$updateType = $_POST['UpdateType'];

$sql;

//Switch, based on $UpdateType update DB and Send Email [Options: 'NewUser', 'NewCompany']
switch ($updateType) {
	case 'NewUser':
		$sql = "INSERT INTO `users` (name, username, password, email, CompanyName, UserType) VALUES ('" . $_POST['UserTitle'] . "', '" . $_POST['Username'] . "', '" . md5($_POST['Password']) . "', '" . $_POST['Email'] . "', '" . $_POST['CompanyName'] . "','" . $_POST['UserType'] . "')";
		sendMail("newUser", $_POST['Email'], $_POST['Username'], $_POST['Password']);
		break;
	case 'NewCompany':
		$sql = "INSERT INTO `companies` (CompanyName, CompanyEmail, PrimaryDomain) VALUES ('" . $_POST['CompanyName'] . "', '" . $_POST['Email'] . "', '" . $_POST['PrimaryDomain'] . "')";
		$stm = $con->prepare($sql);
		$stm->execute();

		$sql = "INSERT INTO `users` (name, username, password, email, CompanyName) VALUES ('" . $_POST['Name'] . "', '" . $_POST['Username'] . "', '" . md5($_POST['Password']) . "', '" . $_POST['Email'] . "', '" . $_POST['CompanyName'] . "')";
		sendMail("newCompany", $_POST['Email'], $_POST['Username'], $_POST['Password']);
};

	$stm = $con->prepare($sql);
	$stm->execute();
	//If update worked, go back home
	if($stm){
		header('Location: index.php');
	}
?>