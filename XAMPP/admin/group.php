<?php 
// Update time : 03.10.2024 
// Author : H. Baytar 

session_start();

if($_SESSION["login"]) {
    require '../config.php';
    require 'vue/partials/header.php';
    include '../utils/connectdb.php';
    include '../model/group.php';
    include 'vue/partials/nav.php';

    $group = getGroup(); 
    $numOfGroups = countGroups() ; 

    if($_SERVER['REQUEST_METHOD'] === 'POST'){

         // DELETE BUTTON CLICKED
        if (isset($_POST['method']) and $_POST['method'] == 'DELETE') {
            deleteGroup($_POST['id']);
            $_SESSION['message'] = '<div class="alert alert-success" role="alert"> Selected <strong>Group</strong> deleted successfully!</div>'; 
        } 

         // CREATE BUTTON CLICKED
         if (isset($_POST['label']) && isset($_POST['name'])) {
            createGroup($_POST['label'] , $_POST['name']);
            $_SESSION['message'] = '<div class="alert alert-success" role="alert"> New <strong>Group</strong> created successfully!</div>'; 
        }

        // _________________________________________________________
        // PAGE REDIRECTION AFTER A CRUD ACTION
        // REDIRECTION / REFRESH TIME
        // _________________________________________________________
        header("Location: /admin/group.php");// header("Refresh:0"); 
        exit;



    }

    // AFTER EACH PAGE CALL (REQUIRED/ INCLUDED FILES)
    // OR 
    // AFTER THE EXECUTION OF AN INSTRUCTION ON THE PAGE (CREATE, DELETE) 
    global $message;   // Déclare a global $message before include it to view 
    require 'vue/group.php';
    require 'vue/partials/footer.php'; 


} else {
        
    // _________________________________________________________________
    // ! $_SESSION["login"]
    // NO USER IS LOGGED IN TO THE TASK MANAGEMENT APPLICATION 
    // _________________________________________________________________

    header("Location: /admin/"); // OK -> Firefox : http://localhost/html/admin/ 
} 
