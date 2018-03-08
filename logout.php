<?php
/********************************
* Project: Support Ticket System
* Code Version: 1.0
* Author: Benjamin Sommer
* GitHub: https://github.com/remmosnimajneb
* Theme Design by: HTML5 UP [HTML5UP.NET] - Theme `Identity`
* Licensing Information: CC BY-SA 4.0 (https://creativecommons.org/licenses/by-sa/4.0/)
***************************************************************************************/

/* Logout page
* Kills all $_SESSIONS and redirects to Login Page
*/

session_start();

$_SESSION['SupportTicketAdmin_username'] = null;
$_SESSION['SupportTicketClient_CompanyName'] = null;
$_SESSION['SupportTicketClient_username'] = null;

header('Location: login.php');

?>