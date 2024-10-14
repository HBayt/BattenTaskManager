<?php 
// Update time : 03.10.2024 
// Author : H. Baytar 

// _______________________________________________
// FILE admin/admin.php  
// http://localhost/html/admin/admin.php 
// _______________________________________________



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
    require_once '../utils/connectdb.php';
    require '../model/user.php';
    require '../model/vacation.php';
    require 'vue/partials/header.php';
    include 'vue/partials/nav.php';

    // ______________________________________________________________
    // FOR DROPDOWN lIST OF USER EMAILS 
    // ______________________________________________________________
    $users = getUser() ; 


    // ______________________________________________________________
    // Get All Vacations or by User ID 
    // ______________________________________________________________
    if(isset($_GET['user_id'])){ 

        // GET USER VACATION 
        $user_name = $_GET['user_name'];         
        $user_id = $_GET['user_id']; 
        $user = getUserIdById($user_id); 
		$vacations = getVacationByUser($user_id);   
        $numOfUserVacations = countVacationsByUserId ($user_id);             

    } else{
        // GET ALL VACATIONS 
        $vacations = getVacations();
        $numOfVacations = countVacations() ;       
    }

    // ______________________________________________________________
    // IF FORM HTML (CRUD INSTRUCTIONS )
    // ______________________________________________________________
    if($_SERVER['REQUEST_METHOD'] === 'POST'){

        if(empty($_POST['start']) || empty($_POST['end'])  ){
            // Afficher un message d'erreur ou renvoyer un message d'erreur
            $_SESSION['message'] = '<div class="alert alert-success" role="alert"> <strong>Start date and End date </strong> are required to create a tasked! </div>'; // Message de confirmation     
        }

        // ______________________________________________________________
        // CREATE VACATION 
        // ______________________________________________________________
        if(!empty($_POST['start']) && !empty($_POST['end']) && isset($_POST['create_vacation'])){  


            // String to be converted to DateTime
            $startString = $_POST['start'] ; // $dateString = "2021-07-05 17:57:38";
            $endString =  $_POST['end'] ; 

            // Specify the format of the input string
            $stringFormat = 'd.m.Y'; // $format = 'Y-m-d H:i:s';
            $setDbFormat = 'Y-m-d'; // $format = 'Y-m-d H:i:s';


            // Convert the string to a DateTime object
            $start = DateTime::createFromFormat($stringFormat, $startString)->format($setDbFormat);  // $start = DateTime::createFromFormat('d-m-Y', $_POST['start'])->format('Y-m-d');
            $end = DateTime::createFromFormat($stringFormat, $endString)->format($setDbFormat); // $end = DateTime::createFromFormat('d-m-Y', '30.12.2024')->format('Y-m-d');  


            // PROCESSING / HANDLING A USER'S VACATIONS
            if(isset($_POST['selected_userId'])){ 

                $selected_userId =  $_POST['selected_userId']; // Get selected user by his ID from Form HTML 
                $user =  getUserIdById($selected_userId); // Look for user        
                                                        
            } elseif(isset($user_id)){ 
                $user = getUserIdById($user_id);  // Get user                                             
            }

            // INSERT INTO DATABASE THE NEW VACATION 
            createVacation($user['id'], $start, $end);    
            $_SESSION['message'] = '<div class="alert alert-success" role="alert"> New <strong>vacation</strong> for <span style="color:green;">'.$user['name'].'</span> created successfully!</div>'; 
      } 

        // ______________________________________________________________
        // UPDATE VACATION
        // ______________________________________________________________ 
        if (isset($_POST['start']) && isset($_POST['end']) && isset($_POST['user_id']) && isset($_POST['id_vacation']) && isset($_POST['save_changes'])) {

            $u_id = $_POST['user_id']; 

            //________________________________________________________________
            // To format date of HTML Form view into 30.11.2000 
            // DB date format ist 2002-10-23            
            //________________________________________________________________
            $formatInput = 'd.m.Y'; // HTML FORM format 
            $formatDb = 'Y-m-d'; // MySQL DB format

            // Dates from HTML FORM for 'Vacation Update'
            $startdate = DateTime::createFromFormat($formatInput, $_POST['start']); 
            $enddate = DateTime::createFromFormat($formatInput, $_POST['end']);

            // Dates converted for DB MySQL 
            $db_startdate = $startdate->format( $formatDb); 
            $db_enddate = $enddate->format($formatDb); 

            //________________________________________________________________
            // PROCESSING / HANDLING A USER'S VACATIONS
            //________________________________________________________________
            if(isset($u_id)){ 
                $user = getUserIdById($u_id);   // GET USER                                                                   
            } else{
                
                $email = (string) $_POST['email']; 
                $user = getUserIdByEmail($email); // var_dump($user ); die(); 
            }

            //________________________________________________________________
            // UPDATE TABLE VACATIONS ROW IN THE DATABASE 
            //________________________________________________________________
            updateVacation( $_POST['id_vacation'], $db_startdate, $db_enddate,  $user["id"]); 
            $_SESSION['message'] = '<div class="alert alert-success" role="alert"><strong>Vacation</strong> for <span style="color:green;">'.$user['name'].'</span> updated successfully!</div>'; 

        } 

        // ______________________________________________________________
        // DELETE VACATION
        // ______________________________________________________________ 
        if (isset($_POST['delete_vacation'] ) && isset($_POST['id_email'] )) {

            $email = (string) $_POST['id_email']; 
            $user = getUserIdByEmail($email); 

            deleteVacation($_POST['id_vacation']);     
            $_SESSION['message'] = '<div class="alert alert-success" role="alert"> Selected <strong>vacation</strong> for <span style="color:green;">'.$user['name'].' </span> deleted successfully!</div>';
        }


        // _________________________________________________________
        // PAGE REDIRECTION AFTER A CRUD ACTION
        // _________________________________________________________

        if(isset($user_id) && isset($user_name) ) {

            // GET ALL USER VACATIONS 
            $vacations = getVacationByUser($u_id);   
            header("Location: /admin/vacationlist.php?user_id=".$user_id."&user_name=".$user_name);
            exit; 
        } else{

            // GET ALL VACATIONS   
            $vacations = getVacations();   
            header("Location: /admin/vacationlist.php"); // header("Refresh:0");   
            exit; 
               
        }

    }// IF FORM CALLED

    // AFTER EACH PAGE CALL (REQUIRED/ INCLUDED FILES)
    // OR 
    // AFTER THE EXECUTION OF AN INSTRUCTION ON THE PAGE (CREATE, DELETE) 
    global $message;   // Déclare a global $message before include it to view 
    require 'vue/vacationlist.php';
    require 'vue/partials/footer.php';
    
} else {
    // ______________________________________
    // ORIGINAL SERVEUR (LINUX) HEADER 
    // ______________________________________
    header("Location: /admin/"); 
} 


