<?php 
session_start();

if($_SESSION["login"]) {



    // ________________________________________________________________
    // REQUIRE & INCLUDE 
    // ________________________________________________________________
    require '../config.php';
    include '../utils/connectdb.php';
    require '../model/task.php';



    // ________________________________________________________________
    // TASK GENERATOR 
    // ________________________________________________________________

    if(isset($_POST['from'])) {

        $from = new DateTime($_POST['from']); 
        $to = new DateTime($_POST['from']); 

        // $from = $from->format("Y-m-d");
        // $to = $to->format("Y-m-d"); 

        // date_add($to, date_interval_create_from_date_string('1 month')); // GENERATOR for 1 month (32 days)
        date_add($to, date_interval_create_from_date_string('21 days')); // GENERATOR for X days 
        generateTasks($from, $to);


    } 
    header('Location: ' . $_SERVER['HTTP_REFERER']); 

    } else {
        header("Location: /admin/");
    } 