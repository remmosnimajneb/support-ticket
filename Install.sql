--
-- Database: `supportticket`
--
CREATE DATABASE IF NOT EXISTS `supportticket` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `supportticket`;

-- --------------------------------------------------------

--
-- Table structure for table `companies`
--

DROP TABLE IF EXISTS `companies`;
CREATE TABLE IF NOT EXISTS `companies` (
  `CompanyID` int(9) NOT NULL AUTO_INCREMENT,
  `CompanyName` varchar(140) NOT NULL,
  `CompanyEmail` varchar(140) NOT NULL,
  `PrimaryDomain` varchar(140) NOT NULL DEFAULT 'NOT NULL',
  PRIMARY KEY (`CompanyID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tickets`
--

DROP TABLE IF EXISTS `tickets`;
CREATE TABLE IF NOT EXISTS `tickets` (
  `TicketID` int(9) NOT NULL AUTO_INCREMENT,
  `TicketUsername` varchar(120) NOT NULL,
  `TicketCompanyName` varchar(120) NOT NULL,
  `TicketDomainAffected` varchar(40) NOT NULL,
  `TicketTitle` varchar(120) NOT NULL,
  `TicketDescription` text NOT NULL,
  `TicketStatus` varchar(40) NOT NULL,
  `TicketPriority` varchar(140) NOT NULL DEFAULT 'NOT NULL',
  `TicketSubmittionDate` varchar(40) NOT NULL,
  `TicketCompletionDate` varchar(40) DEFAULT NULL,
  PRIMARY KEY (`TicketID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `UserID` int(9) NOT NULL AUTO_INCREMENT,
  `name` varchar(120) NOT NULL,
  `username` varchar(40) NOT NULL,
  `password` varchar(40) NOT NULL,
  `email` varchar(40) NOT NULL,
  `CompanyName` varchar(140) DEFAULT NULL,
  `UserType` varchar(40) NOT NULL DEFAULT 'client',
  PRIMARY KEY (`UserID`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`UserID`, `name`, `username`, `password`, `email`, `CompanyName`, `UserType`) VALUES
(1, 'Support Ticket Admin', 'ticketadmin', '0192023a7bbd73250516f069df18b500', 'example@example.net', 'Example Company', 'admin');
COMMIT;
