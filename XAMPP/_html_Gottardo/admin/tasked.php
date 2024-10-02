<?php


// START SESSION 
session_start();

// IF USER IS LOGGED IN 
if($_SESSION["login"]) {

    // REQUIRED & INCLUDED FILES 
    require '../config.php';
    require 'vue/partials/header.php';
    include '../utils/connectdb.php';
    include '../model/tasked.php';
    include '../model/user.php';
    include '../model/task.php';
    include 'vue/partials/nav.php';


    $header_location = false; 


    // GET ALL TASKED FROM DATABASE TABLE TASKED
    $taskeds = getTaskeds();
    $tasks = getTasks(); 
    $users = getUser() ; 


        // IF USER CLICKED ON BUTTON DELETE AND IF TASKED_ID IS SET 
        if(isset($_POST['delete_tasked']) && isset($_POST['id_tasked'])){

            // DELETE THE TASK USING THE TASK ID 
            deleteTasked($_POST['id_tasked']);
    
            // REDIRECTION / REFRESH TIME
            header("Location: /admin/tasked.php");  // header("Refresh:0");


        }

        // IF INPUT NAME = 'action' 
        if(isset($_POST['action']) && $_POST['action'] == 'CreateTasked' && !empty($_POST['start']) && !empty($_POST['selected_userId']) && !empty($_POST['checked_taskId'])) {

            $start_date = $_POST['start']; 
            $selected_userId =  $_POST['selected_userId']; 
            $checked_taskId = $_POST['checked_taskId']; 

            createTasked ($start_date, $checked_taskId, $selected_userId) ; 

            // REDIRECTION / REFRESH TIME
            header("Location: /admin/tasked.php");  // header("Refresh:0");   


            // echo "<h1> Tasked <br> START : ".$start_date." | USER : ".$selected_userId." | TASK : ". $checked_taskId."</h1><br>"; die();   
        }// end.CREATE 

    
    // REQUIRED FILE BY CALLING admin/tasked.php 
    require 'vue/tasked.php';
    require 'vue/partials/footer.php';


    if( $header_location == true){
        //  header("Refresh:0");
       header("Location: /admin/tasked.php");   
   }

   // header("Location: /admin/tasked.php");   


} else {
    // ______________________________________
    // ORIGINAL SERVEUR LINUX
    // ______________________________________
    header("Location: /admin/"); // Original KO sur XAMPP 
} 