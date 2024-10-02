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


    // IF GROUP USERS 
    if(isset($_GET['group_id'])) {

        $user = getUserByGroup($_GET['group_id']);
        $group = loadGroup($_GET['group_id']);
        $group_id = $_GET['group_id'];

    } else {
        // IF ALL USERS
        $user = getUser();
    }

    // IF FORM HTML (CRUD INSTRUCTIONS )
    if($_SERVER['REQUEST_METHOD'] === 'POST'){


        // IF INPUT NAME = 'action' 
        if(isset($_POST['action'])){
            
            if ($_POST['action'] == 'alterUser') {

                // IF INPUT NAME = 'action' AND INPUT VALUE == 'alterUser'
                // UPDATE USER 
                updateUser($_POST['id'], $_POST['name'], $_POST['email'],  $_POST['weekdays']);

            } elseif ($_POST['action'] == 'deleteUser') {  
                // ELSE IF INPUT NAME = 'action' AND INPUT VALUE == 'deleteUser'
                deleteUser($_POST['id']);

            } elseif ($_POST['action'] == 'createUser') {
                // ELSE IF INPUT NAME = 'action' AND INPUT VALUE == 'deleteUser'
                $u = createUser($_POST['name'], $_POST['email'], $_POST['weekdays']);

                if(isset($_GET['group_id'])) { 
                    // ALSO ADD USER.GROUP_ID VALUE INTO THE DATABASE 
                    addUserToGroup($_GET['group_id'], $u);
                }
            }
        } 


        // _________________________________________________________
        // PAGE REDIRECTION AFTER A CRUD ACTION
        // _________________________________________________________

        if(isset($group_id)) {
            header("Location: /admin/user.php?group_id=".$group_id); 
        }else{
            // header("Refresh:0");
            header("Location: /admin/user.php");                  
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
    header("Location: /admin/"); // OK sur XAMPP | Firefox : http://localhost/html/admin/ 
} 