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
    require 'vue/partials/header.php';
    include '../utils/connectdb.php';
    include '../model/user.php';
    include '../model/group.php';
    include 'vue/partials/nav.php'; 

    $groups = getGroup(); 

    // IF GROUP USERS 
    if(isset($_GET['group_id'])) {

        $user = getUserByGroup($_GET['group_id']);

        $group_id = $_GET['group_id'];
        $group = loadGroup($group_id );
        // print_r($group); die(); 

        $numOfUsers = countUsersByGroup($group_id) ; 

    } else {
        // IF ALL USERS
        $user = getUser(); 
        $numOfUsers = countUsers() ; 
    }


    // ___________________________________________________________________________________
    // IF FORM HTML SENDED -> SUBMIT BUTTON CLICKED (FOR CRUD INSTRUCTIONS )
    // ___________________________________________________________________________________    
    if($_SERVER['REQUEST_METHOD'] === 'POST'){

        // IF INPUT NAME = 'action' 
        if(isset($_POST['action'])){

            // UPDATE BUTTON CLICKED            
            if ($_POST['action'] == 'alterUser'    
                && !empty($_POST['id'])               
                && !empty($_POST['name'])
                && !empty($_POST['email'])
                && !empty($_POST['weekdays'])
                && !empty($_POST['id_group'])                    
            ) {

                updateUser($_POST['id'], $_POST['name'], $_POST['email'],  $_POST['weekdays'], $_POST['id_group']);
                $_SESSION['message'] = '<div class="alert alert-success" role="alert"> Selected <strong>user</strong> <span style="color:green;">('.$_POST['name'].' )</span> updated successfully!</div>'; 


            } // end.UPDATE 
            
            // DELETE BUTTON CLICKED
            elseif ($_POST['action'] == 'deleteUser') {  

                deleteUser($_POST['id']); 
                $_SESSION['message'] = '<div class="alert alert-success" role="alert"> Selected <strong>user</strong> <span style="color:green;">(Id = '.$_POST['id'].' )</span> deleted successfully!</div>'; 


            } // end.DELETE 
            
            // CREATE BUTTON CLICKED
            elseif ($_POST['action'] == 'createUser' 
                        && !empty($_POST['name'])
                        && !empty($_POST['email'])
                        && !empty($_POST['weekdays'])
                        && !empty($_POST['id_group'])                    
                    ) {

                $u = createUser($_POST['name'], $_POST['email'], $_POST['weekdays'], $_POST['id_group']); 
                $_SESSION['message'] = '<div class="alert alert-success" role="alert"> New <strong>user</strong> <span style="color:green;">('.$_POST['name'].' )</span> created successfully!</div>'; 

            }// end.CREATE 
        } 

        // _________________________________________________________
        // PAGE REDIRECTION AFTER A CRUD ACTION
        // REDIRECTION / REFRESH TIME
        // _________________________________________________________
        if(isset($group_id)) {
            header("Location: user.php?group_id=".$group_id); 
            exit;
        }else{
            // header("Refresh:0");
            header("Location: user.php");  
            exit;                            
        }

    }

    // AFTER EACH PAGE CALL (REQUIRED/ INCLUDED FILES)
    // OR 
    // AFTER THE EXECUTION OF AN INSTRUCTION ON THE PAGE (CREATE, DELETE) 
    global $message;   // Déclare a global $message before include it to view 
    require 'vue/user.php';
    require 'vue/partials/footer.php';


} else {
    // ______________________________________
    // ORIGINAL SERVEUR (LINUX) HEADER 
    // ______________________________________
    header("Location: /admin/");  
} 