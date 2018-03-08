<?php
/********************************
* Project: Support Ticket System
* Code Version: 1.0
* Author: Benjamin Sommer
* GitHub: https://github.com/remmosnimajneb
* Theme Design by: HTML5 UP [HTML5UP.NET] - Theme `Identity`
* Licensing Information: CC BY-SA 4.0 (https://creativecommons.org/licenses/by-sa/4.0/)
***************************************************************************************/

/** Functions Page
* Contains Global Variables and Scripts for System to work
*/

//MySQL Connection Settings
$con = new PDO("mysql:host=HOST_NAME;dbname=DB_NAME", "USERNAME", "PASSWORD");

//Mail Settings
$adminEmail = ""; //Admin Email
$adminName = ""; //Admin Name

$helpDeskUrl = ""; //URL of HelpDesk

$emailSMTP = ""; //Your SMTP Host (smtp.something.com)
$emailUsername  = ""; //Your Email Username
$emailPassword = ""; //Password
$SMTPSecurity = ""; //SSL or TLS Connection to server (lowercase)
$SMTPPort = ""; //SMTP Port

?>