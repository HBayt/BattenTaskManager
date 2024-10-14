<?php 
// _______________________________________________
// Update time : 03.10.2024 
// Author : H. Baytar 
// _______________________________________________



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

            if($_POST['action'] == 'CreateTasked'  && empty($_POST['start'])){
                // Afficher un message d'erreur ou renvoyer un message d'erreur
                $_SESSION['message'] = '<div class="alert alert-success" role="alert"> <strong>Start date </strong> is required to create a tasked! </div>'; // Message de confirmation     
            }

            // CREATE TASKED 
            // IF INPUT NAME = 'action' && value= 'CreateTasked' 
            if($_POST['action'] == 'CreateTasked'  && !empty($_POST['start']) && isset($_POST['selected_userId']) && isset($_POST['checked_taskId']) ) 
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
                $_SESSION['message'] = '<div class="alert alert-success" role="alert"> <strong>Tasked</strong> <span style="color:green;">(Task_Id = '.$_POST['checked_taskId'].' / User_Id = '. $_POST['selected_userId'].' )</span> created successfully!</div>'; // Message de confirmation     
            


               
            }
            // UPDATE TASKED 
            elseif($_POST['action'] == 'updateTasked' 
                && isset($_POST['radio_contacted']) 
                && isset($_POST['datePicker_start']) 
                && isset($_POST['selected_userId']) 
                && isset($_POST['selected_taskId'])
            ){

                          
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
                $_SESSION['message'] = '<div class="alert alert-success" role="alert"> Selected <strong>Tasked</strong> <span style="color:green;">(Id = '.$tasked_id.' )</span> updated successfully!</div>'; // Message de confirmation     
            
            }
            // DELETE TASKED 
            elseif($_POST['action'] == 'deleteTasked' && isset($_POST['tasked_id'])) {
                    
                $tasked_id = $_POST['tasked_id']; 
                deleteTasked($tasked_id);          
                // echo '<h3><span style="color:red;">'."Suppression de Tasked (ID = ".$tasked_id.") réussie".'<br></span></h3>';
                // echo '<div class="alert alert-primary" role="alert">Suppression de Tasked (ID ='.$tasked_id.') réussie</div>';
                $_SESSION['message'] = '<div class="alert alert-success" role="alert"> Selected <strong>Tasked</strong> <span style="color:green;">(Id = '.$_POST['tasked_id'].' )</span> deleted successfully!</div>'; // Message de confirmation     
            } 
            else {
                echo "<div class='alert alert-danger' role='alert'>Missing parameters for suppression.</div>";// Message de confirmation      
            }           


        }// ACTION 


        // _________________________________________________________
        // PAGE REDIRECTION AFTER A CRUD ACTION
        // REDIRECTION / REFRESH TIME
        // _________________________________________________________
        header("Location: /admin/tasked.php");  // header("Refresh:0"); 
        exit;

    } // SERVER REQUEST METHOD POST 


    // AFTER EACH PAGE CALL (REQUIRED/ INCLUDED FILES)
    // OR 
    // AFTER THE EXECUTION OF AN INSTRUCTION ON THE PAGE (CREATE, DELETE) 
    global $message;   // Déclare a global $message before include it to view 
    require 'vue/tasked.php';
    require 'vue/partials/footer.php';


}// SESSION LOGIN 
else {
    // _________________________________________________________________
    // ! $_SESSION["login"]
    // NO USER IS LOGGED IN TO THE TASK MANAGEMENT APPLICATION 
    // _________________________________________________________________

     header("Location: /admin/"); // OK -> Firefox : http://localhost/html/admin/ 
      
    } 