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
    $numOfTaskeds = countTaskeds (); 
    


    // IF FORM HTML SENDED -> BUTTON SEND CLICKED (CRUD INSTRUCTIONS )
    if($_SERVER['REQUEST_METHOD'] === 'POST'){


        // IF INPUT NAME = 'action' 
        if(isset($_POST['action'])){


            // CREATE TASKED 
            // IF INPUT NAME = 'action'  [FORM SEND] 
            if($_POST['action'] == 'CreateTasked'  && isset($_POST['start']) && isset($_POST['selected_userId']) && isset($_POST['checked_taskId']) ) 
            {

                $selected_userId =  $_POST['selected_userId']; 
                $checked_taskId = $_POST['checked_taskId']; 

                
                // String to be converted to DateTime
                $startString = $_POST['start'] ; // $dateString = "2021-07-05 17:57:38";

                // Specify the format of the input string
                $stringFormat = 'd.m.Y'; // $format = 'Y-m-d H:i:s';
                $setDbFormat = 'Y-m-d'; // $format = 'Y-m-d H:i:s';

                // Convert the string to a DateTime object
                // $dateTime = DateTime::createFromFormat($format, $dateString);
                // $start = DateTime::createFromFormat('d-m-Y', $_POST['start'])->format('Y-m-d');  
                $start = DateTime::createFromFormat($stringFormat, $startString)->format($setDbFormat);
                
                createTasked ($start, $checked_taskId, $selected_userId) ; 

            // }elseif($_POST['action'] == 'updateTasked' && !empty($_POST['radio_contacted']) && !empty($_POST['datePicker_start']) && !empty($_POST['selected_userId']) && !empty($_POST['selected_taskId'])) 
           
            }elseif($_POST['action'] == 'updateTasked' && isset($_POST['radio_contacted']) && isset($_POST['datePicker_start']) && isset($_POST['selected_userId']) && isset($_POST['selected_taskId'])) 
            {

                // UPDATE TASKED           

                // echo "<h1> Ttasked: </h1>";  
                $tasked_id = $_POST['id']; ; 
                $selected_userId =  $_POST['selected_userId']; // selected_userId
                $selected_taskId = $_POST['selected_taskId']; 
                $radio_contacted = $_POST['radio_contacted']; 

                // String to be converted to DateTime
                $startString = $_POST['datePicker_start'] ; // $dateString = "2021-07-05 17:57:38";

                // echo "<h1> Ttasked: ".$tasked_id.", start: ".$startString.", task: ".$selected_taskId.", user: ".$selected_userId.", contacted y/n : ".$radio_contacted."</h1>"; 
                // die(); 

                // Specify the format of the input string
                $stringFormat = 'd.m.Y'; // $format = 'Y-m-d H:i:s';
                $setDbFormat = 'Y-m-d'; // $format = 'Y-m-d H:i:s';

                // Convert the string to a DateTime object
                // $dateTime = DateTime::createFromFormat($format, $dateString);
                // $start = DateTime::createFromFormat('d-m-Y', $_POST['start'])->format('Y-m-d');  
                $start = DateTime::createFromFormat($stringFormat, $startString)->format($setDbFormat);
                
                updateTasked ($tasked_id, $start, $selected_userId, $selected_taskId, $radio_contacted) ; 


            }
            
            if(isset($_POST['delete_tasked']) && isset($_POST['id_tasked'])){

                // IF USER CLICKED ON BUTTON DELETE AND IF TASKED_ID IS SET 
                // DELETE THE TASK USING THE TASK ID 
                deleteTasked($_POST['id_tasked']); 
            }







        }// ACTION 


        // REDIRECTION / REFRESH TIME
        header("Location: /admin/tasked.php");  // header("Refresh:0"); 


    } // SERVER REQUEST METHOD POST 


    // REQUIRED FILE BY CALLING admin/tasked.php 
    require 'vue/tasked.php';
    require 'vue/partials/footer.php';


}// SESSION LOGIN 
else {
    // ______________________________________
    // ORIGINAL SERVEUR (LINUX) HEADER 
    // ______________________________________
    header("Location: /admin/"); // Original KO sur XAMPP 

    // ______________________________________
    // DEV LOCAL SERVEUR (LOCAL XAMPP) HEADER 
    // ______________________________________
    // header("Location: /html/admin/ "); // OK sur XAMPP | Firefox : http://localhost/html/admin/ 
}

