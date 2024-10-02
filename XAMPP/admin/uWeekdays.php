<?php


// _______________________________________________
// FILE admin/admin.php  
// http://localhost/html/admin/admin.php 
// _______________________________________________


// TESTS 
// console.log("Message"); console.log(variable); 
// PHP INTERPRETER STOP TO EXECUTE CODE -> die(); 
// var_dump(VARIABLE ); 


// _______________________________________________
// CREATE SESSSION 
// _______________________________________________
session_start();



// _______________________________________________
// USER IS CONNECTED 
// _______________________________________________
if($_SESSION["login"]) {

     // REQUIRED & INCLUDED FILES 
    require '../config.php';
    require 'vue/partials/header.php';
    include '../utils/connectdb.php';
    include '../model/user.php';
    include '../model/group.php';
    include '../model/task.php';
    include 'vue/partials/nav.php';


    $groups = getGroup(); 

    $users = getUser(); 
    $numOfUsers = countUsers() ; 
    $tasks = getTasks(); 



    // REQUIRED/ INCLUDED FILES 
    require 'vue/uWeekdays.php';
    require 'vue/partials/footer.php';


} else {
    // ______________________________________
    // ORIGINAL SERVEUR (LINUX) HEADER 
    // ______________________________________
    header("Location: /admin/"); // Original KO sur XAMPP 

    // ______________________________________
    // DEV LOCAL SERVEUR (LOCAL XAMPP) HEADER 
    // ______________________________________
    // header("Location: /html/admin/ "); // OK sur XAMPP | Firefox : http://localhost/html/admin/ 
} 