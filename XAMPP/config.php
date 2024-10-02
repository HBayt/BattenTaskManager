<?php
// Login credentials for admin user

// TaskManager Administrations User
define('DEFAULT_ADMIN_USER', 'admin'); 
define('DEFAULT_ADMIN_PASS', 'Admlocal1');

// DB credentials
define('DB_USER', 'php'); // root / NULL 
define('DB_PASS', 'Pa$$word1');
define('DB_HOST', 'localhost');
define('DB_NAME', 'taskmanager'); 
define('DB_PORT', '4306'); 



// SMTP credentials mail
define('SMTP_USER', 'battenberg@toots.ch');
//define('SMTP_USER', 'taskmanager-igv@battenberg.ch');
define('SMTP_PASS', 'Battenberg100$$24');
//define('SMTP_PASS', '2kjHIO2604$!');
define('SMTP_HOST', 'lx46.hoststar.hosting');
//define('SMTP_HOST', 'outlook.office365.com');
define('SMTP_PORT', 465);
//define('SMTP_SECU', "starttls"); 
define('SMTP_SECU', "ssl");


// Default mail title 
define('DEFAULT_TITLE', "Task Manager");

//Default mail message -> Used to Insert new mail into MySQL if not mail found in DB MySQL 
define('DEFAULT_MAIL', "Aujourd'hui, le /date , 
    vous êtes priés de réaliser la tâche suivante: /name
    \r\n\r\nVisitez http://task-manager pour avoir accès à la planification complète.
    \r\n\r\nMerci beaucoup et meilleures salutations
    \r\n\r\n-----------------------------------------------------------------------------------------------------------------
    \r\n\r\n
    Heute am /date sind mit der Aufgabe /name an der Reihe\r\n\r\nDie Planung koennen Sie unter http://task-manager einsehen.
    \r\n\r\nVielen Dank und freundliche Gruesse");



