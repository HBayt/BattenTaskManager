# task-manager 

A php web-app for managing weekly task. 

## installation 

The installation is quite simple. You need a php server and a MYSQL database. 

Create a new database in mysql and a user for this database. 

Edit the config.php at the root of the project set your admin credentials and your DB. 

Setup a cron task for mail.php to execute each day. 

00 08 * * * curl http://task-manager/admin/sendmail.php

