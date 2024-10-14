<?php 
session_start();

if($_SESSION["login"]) {



    // ________________________________________________________________
    // REQUIRE & INCLUDE 
    // ________________________________________________________________
    require '../config.php';
    include '../utils/connectdb.php';
    require '../model/task.php';

    // include '../model/user.php';
    // include '../model/group.php';
 

    // ________________________________________________________________
    // TASK GENERATOR 
    // ________________________________________________________________

    if(isset($_POST['from'])) {

        $from = new DateTime($_POST['from']); // $from = $from->format("Y-m-d");
        $to = new DateTime($_POST['from']); // $to = $to->format("Y-m-d"); 

        // date_add($to, date_interval_create_from_date_string('1 month')); // GENERATOR for 1 month (32 days)
        date_add($to, date_interval_create_from_date_string('30 days')); // GENERATOR for X days 


    // _________________________________________________
    // WHILE START_DATE < CURRENT_DATE < END_DATE 
    // _________________________________________________

    // GENERATOR EXECUTION 
    // generateTasks($from, $to); 
    generateUsersTasks($from, $to); 
    $_SESSION['message'] = '<div class="alert alert-success" role="alert"> New <strong>Callendar</strong> generated successfully!</div>'; 
          
    } 

    header('Location: ' . $_SERVER['HTTP_REFERER']); 
    exit; 

    } else {
        // ______________________________________
        // ORIGINAL SERVEUR (LINUX) HEADER 
        // ______________________________________
        header("Location: /admin/"); 
    
    } 