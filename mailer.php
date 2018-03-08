<?php
/********************************
* Project: Support Ticket System
* Code Version: 1.0
* Author: Benjamin Sommer
* GitHub: https://github.com/remmosnimajneb
* Theme Design by: HTML5 UP [HTML5UP.NET] - Theme `Identity`
* Licensing Information: CC BY-SA 4.0 (https://creativecommons.org/licenses/by-sa/4.0/)
***************************************************************************************/

/* Mailer Script
* Send Emails to Admins and Clients on Ticket Updates
* [!Important!] Set Mail Server information in functions.php!
* Note: This code is from the PHPMailer Repository found at: https://github.com/PHPMailer/PHPMailer
*/

    // Import PHPMailer classes into the global namespace
    // These must be at the top of your script, not inside a function
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    //Set Variables
    $emailTitle;
    $emailContents;

//Send Email Function
function sendMail($mailType, $ObjectID, $username, $password){

    //Include functions.php
    require 'functions.php';

    require 'PHPMailer/src/Exception.php';
    require 'PHPMailer/src/PHPMailer.php';
    require 'PHPMailer/src/SMTP.php';

    $mail = new PHPMailer(true); // Passing `true` enables exceptions

    try {
        //Server settings
        $mail->SMTPDebug = 2;                       // Enable verbose debug output [0 is Disable, 2 is Show all]
        $mail->isSMTP();                            // Set mailer to use SMTP
        $mail->Host = $emailSMTP;                   // Specify main and backup SMTP servers
        $mail->SMTPAuth = true;                     // Enable SMTP authentication
        $mail->Username = $emailUsername;           // SMTP username
        $mail->Password = $emailPassword;           // SMTP password
        $mail->SMTPSecure = $SMTPSecurity;          // Enable TLS encryption, `ssl` also accepted
        $mail->Port = $SMTPPort;                    // TCP port to connect to

    switch ($mailType) {
        case 'newCompany':
            $emailTitle = "Welcome to HelpDesk!";
            $emailContents = "
                Welcome to the HelpDesk System! <br />
                To login to the HelpDesk, go to " . $helpDeskUrl . ". <br />
                Your company login is: <br />
                Username: " . $username . "<br />
                Password: " . $password . "<br />
                You can use this system to submit support tickets when something goes wrong. Feel free to email us at " . $adminEmail . " if you need any help or have any issues!
                ";
                $mail->addAddress($ObjectID);
            break;
        case 'newUser':
            $emailTitle = "Welcome to HelpDesk!";
            $emailContents = "
                Welcome to the HelpDesk System! <br />
                To login to the HelpDesk, go to " . $helpDeskUrl . ". <br />
                Your user login is: <br />
                Username: " . $username . "<br />
                Password: " . $password . "<br />
                You can use this system to submit support tickets when something goes wrong. Feel free to email us at " . $adminEmail . " if you need any help or have any issues!
                ";
            $mail->addAddress($ObjectID);
        break;
        case 'NewTicket':
            //Email all Admins details
            $emailTitle = "New Support Ticket Submitted!";
            $emailContents = $ObjectID;
            $sql = "SELECT * FROM `users` WHERE `UserType` LIKE 'admin'";
            $stm = $con->prepare($sql);
            $stm->execute();
            $records = $stm->fetchAll();
            foreach ($records as $row) {
                $mail->addAddress($row['email'], $row['name']);
            }
        break;
        case 'EditTicket':
            //Email all Admins details
            $emailTitle = "Support Ticket Edited";
            $emailContents = $ObjectID;
            $sql = "SELECT * FROM `users` WHERE `UserType` LIKE 'admin'";
            $stm = $con->prepare($sql);
            $stm->execute();
            $records = $stm->fetchAll();
            foreach ($records as $row) {
                $mail->addAddress($row['email'], $row['name']);
            }
        break;
        case 'CloseTicket':
            //Email all Admins details
            $emailTitle = "Support Ticket Closed";
            $emailContents = "Please note that Support Ticket Number " . $ObjectID . " has been closed.";
            $sql = "SELECT `TicketUsername` FROM `tickets` WHERE `TicketID` LIKE '" . $ObjectID . "'";
            $stm = $con->prepare($sql);
            $stm->execute();
            $result = $stm->fetchColumn();
            $sql = "SELECT * FROM `users` WHERE `UserType` LIKE 'admin' OR `username` LIKE '" . $result . "'";
            $stm = $con->prepare($sql);
            $stm->execute();
            $records = $stm->fetchAll();
            foreach ($records as $row) {
                $mail->addAddress($row['email'], $row['name']);
            }
        break;
        case 'DeleteTicket':
            //Email all Admins details
            $emailTitle = "Support Ticket Deleted";
            $emailContents = "Please be aware, Support Ticket Number " . $ObjectID . " has been deleted.";
            $sql = "SELECT * FROM `users` WHERE `UserType` LIKE 'admin'";
            $stm = $con->prepare($sql);
            $stm->execute();
            $records = $stm->fetchAll();
            foreach ($records as $row) {
                $mail->addAddress($row['email'], $row['name']);
            }
        break;
        case 'EmailClient':
            $sql = "SELECT `TicketUsername` FROM `tickets` WHERE `TicketID` LIKE '" . $ObjectID . "'";

            $stm = $con->prepare($sql);
            $stm->execute();
            $username = $stm->fetchColumn();

            $sql = "SELECT `email` FROM `users` WHERE `Username` LIKE '" . $username . "'";
            $stm = $con->prepare($sql);
            $stm->execute();
            $result = $stm->fetchColumn();

                $mail->addAddress($result);
            $emailTitle = "Message Regarding Support Ticket ID: " . $ObjectID;
            $emailContents = "There has been a message sent regarding your support ticket submission. Please see message below: <br />" . $_POST['Message'];
        break;
    }

        //Recipients
        $mail->setFrom($emailUsername);
        
        //Content
        $mail->isHTML(true); // Set email format to HTML
        $mail->Subject = $emailTitle;
        $mail->Body    = $emailContents;

        $mail->send();
        echo 'Message has been sent';
    } catch (Exception $e) {
        echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
    };
};
?>