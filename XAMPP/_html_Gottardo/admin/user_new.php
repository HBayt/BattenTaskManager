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
    include 'vue/partials/nav.php';


    $groups = getGroup(); 


    // IF GROUP USERS 
    if(isset($_GET['group_id'])) {

        $user = getUserByGroup($_GET['group_id']);

        $group_id = $_GET['group_id'];
        $group = loadGroup($group_id );
        // echo "<h1> HiHi ".$_GET['group_id']."</h1>"; 
        // print_r($user); 
        // die(); 

    } else {
        // IF ALL USERS
        $user = getUser();
    }

    // IF FORM HTML (CRUD INSTRUCTIONS )
    if($_SERVER['REQUEST_METHOD'] === 'POST'){


        // IF INPUT NAME = 'action' 
        if(isset($_POST['action'])){
            
            if ($_POST['action'] == 'alterUser'    
                && !empty($_POST['id'])               
                && !empty($_POST['name'])
                && !empty($_POST['email'])
                && !empty($_POST['weekdays'])
                && !empty($_POST['id_group'])                    
            ) {

                // echo "<h1>".$_POST['id']." ".$_POST['name']." ".$_POST['email']." ".$_POST['id_group']."</h1>"; 
                // die(); 

                // IF INPUT NAME = 'action' AND INPUT VALUE == 'alterUser'
                // UPDATE USER 
                updateUser($_POST['id'], $_POST['name'], $_POST['email'],  $_POST['weekdays'], $_POST['id_group']);

            } // end.UPDATE 
            elseif ($_POST['action'] == 'deleteUser') {  
                // ELSE IF INPUT NAME = 'action' AND INPUT VALUE == 'deleteUser'
                deleteUser($_POST['id']);

            } // end.DELETE 
            elseif ($_POST['action'] == 'createUser' 
                        && !empty($_POST['name'])
                        && !empty($_POST['email'])
                        && !empty($_POST['weekdays'])
                        && !empty($_POST['id_group'])                    
                    ) {
                $u = createUser($_POST['name'], $_POST['email'], $_POST['weekdays'], $_POST['id_group']);

                // ALSO ADD USER.GROUP_ID VALUE INTO THE DATABASE 
                // addUserToGroup($_GET['group_id'], $u);
            }// end.CREATE 



        } 


        // _________________________________________________________
        // PAGE REDIRECTION AFTER A CRUD ACTION
        // _________________________________________________________

        if(isset($group_id)) {
            header("Location: /html/admin/user.php?group_id=".$group_id); 
        }else{
            // header("Refresh:0");
            header("Location: /html/admin/user.php");                  
        }

    }

    // REQUIRED/ INCLUDED FILES 
    require 'vue/user.php';
    require 'vue/partials/footer.php';


} else {
    // ______________________________________
    // ORIGINAL SERVEUR (LINUX) HEADER 
    // ______________________________________
    // header("Location: /admin/"); // Original KO sur XAMPP 

    // ______________________________________
    // DEV LOCAL SERVEUR (LOCAL XAMPP) HEADER 
    // ______________________________________
    header("Location: /html/admin/"); // OK sur XAMPP | Firefox : http://localhost/html/admin/ 
} 