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
    include '../model/gUsers.php';
    include 'vue/partials/nav.php';




    $dbGroups = getGroup(); 

    // _________________________________________________
    // WHILE START_DATE < CURRENT_DATE < END_DATE 
    // _________________________________________________

    $today = new DateTime(); // $today = $from->format("Y-m-d");
    $lastDay =  new DateTime();  // $lastDay = $to->format("Y-m-d"); 
    
    // $nbDays = countUsers();   
    // date_add($lastDay, date_interval_create_from_date_string($nbDays.'days')); // GENERATOR for X days / X months PARAM = ('1 month') 
    date_add($lastDay, date_interval_create_from_date_string('30 days')); 

    // TEST 
    // $lastDay =  new DateTime($lastDay->format('c')); // ISO 8601 date | Example returned values : 2004-02-12T15:19:21+00:00 
    // echo "today (var = new DateTime()) + 30 days is : ".$lastDay->format('l, d. M , G.i'). "<br><br>";
    // echo "Jour J + 30D ---> ".$lastDay->format('l, d. M , G.i'). "<br><br>";


    // GENERATOR EXECUTION 
    generateUsersTasks($today, $lastDay); 


    // _________________________________________________
    // CREATE DYNAMIC ARRAY FOR EACH USER GROUP  
    // _________________________________________________
    // $group_id = 4; 

      // $date = new DateTime('2000-12-31');
      $generator_firstDay = new DateTime($today->format('Y-m-d') ); 
      $generator_firstDay->modify('+1 days');
      // echo $generator_firstDay->format('d.m.Y') . "<br>";
      // createDynamicUserArrayOfGroups($group_id, $generator_firstDay ); 



      // getFreeUsersArray(); 
      echo "<br>"; 
















    // REQUIRED/ INCLUDED FILES 
    // require 'vue/gUsers.php';
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