<?php
include __DIR__ . '/library/rb-mysql.php';


// ORIGINAL CONFIG 
// R::setup( 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME, DB_USER,  DB_PASS);
// R::setup( 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME, DB_USER,  DB_PASS);

// LOCALHOST CONFIG 
// R::setup("mysql:host=localhost;dbname=ufm;port=3306","root","root");
// R::setup( 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME.';port=' . DB_PORT, DB_USER,  DB_PASS);
R::setup( 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME.';port=' . DB_PORT, DB_USER,  DB_PASS);




