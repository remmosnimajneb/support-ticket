# Support Ticket System
## Another, I got bored and built something, by Benjamin Sommer
	Project: Support Ticket System
	Code Version: 1.0
	Author: Benjamin Sommer
	GitHub: https://github.com/remmosnimajneb
	Theme Design by: HTML5 UP [HTML5UP.NET] - Theme `Identity`
	Licensing Information: CC BY-SA 4.0 (https://creativecommons.org/licenses/by-sa/4.0/)

	1. Overview
	2. Requirements & Install Instructions
	3. Files Explanation
	4. Updates to come

# 1. Overview - What is this?
	Well I was bored one day and decided to build something. So this is a standard Support Ticket System, clients login, send a support ticket for something that's wrong and the admin can close the ticket when completed.

	So what makes this better than any other free support ticket system?
	Nothing. Heck it's probably worse, but it's working so I figured might as well push to GitHub

# 2. Requirments:

		-A web server, that can be accessed over the internet for use out of Local Area Network
		-MySQL with PDO type PHP Extention (!Important!)
		-PHP
		-That's it

	Aight, let's go! Let's install this thing already!!

	Install: 

	Here's how to install this:
		1. Create a new MySQL Database on your server
		2. Import or run the SQL commands to setup the system on the server - (File: Install.sql)
			A. You will either need to add your admin email in the SQL code or after in the `users` table to ensure admin emails will go to the right place!
		3. Open the functions file (File: functions.php) in your favorite text editor (h/t to mine Sublime Text 3) and Insert the MySQL and Email information there.
		4. Move all the files to your public directory on the server (Can exclude this file and SQLInstall.sql, everything else required)
		5. Login to the admin panel at {Your_Install_Location}/admin the defualt login is ticketadmin and admin123
		6. Use the backend to add new companies and users, the email system (if setup) will auto-send them there logins

# 3. Files Explanation
	Just goes through the files (even thought I left comments) to explain how it all works
		/
		->Functions.php - Sets global variables for the MySQL connection and the Email Function (SMTP Server)
		->Login.php - Login page
		->Auth.php - Authentication for Login Page
		->newTicket.php - Create a new Support Ticket - goes to updateTicket.php
		->editTicket.php - Edit an existing Support Ticket - goes to updateTicket.php
		->updateTicket.php - Updates tickets in the MySQL, calles mailer.php to send emails
		->mailer.php - Sends emails about Tickets and Users
			->/admin
				->Login.php - Admin Login page
				->Auth.php - Authentication for login page
				->newCompany.php - Add New Company to System, automatically creates a user account
				->newUser.php - add new user to system, allows creation of new admins for backend
				->adminUpdate.php - Update MySQL and send emails (via mailer.php) for newUser.php and newCompany.php

# 4. Updates
	Things I want to one day fix
		1. Cleanup mailer.php
		2. Connect login pages (login.php and /admin/login.php)
		3. Add more information on tickets (besides just saying TicketID x) on emails