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
    require '../model/admin.php';
    include 'vue/partials/nav.php';
    
    $admin = getAdmin(); // Get All admins from databse table 'Admin' 

    // ___________________________________________________________________________________
    // IF FORM HTML SENDED -> SUBMIT BUTTON CLICKED (FOR CRUD INSTRUCTIONS )
    // ___________________________________________________________________________________
    if($_SERVER['REQUEST_METHOD'] === 'POST'){

        // CREATE BUTTON CLICKED
        if(isset($_POST['name']) and isset($_POST['password'])){

            createAdmin($_POST['name'], $_POST['password']); // Insert into DB a new admin
            $_SESSION['message'] = '<div class="alert alert-success" role="alert"> New <strong>administrator</strong> created successfully!</div>'; 

        }

         // DELETE BUTTON CLICKED
        if (isset($_POST['id_admin'])) {
            
            deleteAdmin($_POST['id_admin']); // Delete an existing admin by his ID 
            $_SESSION['message'] = '<div class="alert alert-success" role="alert"> Selected <strong>administrator</strong> deleted successfully!</div>'; 

        }


        // _________________________________________________________
        // PAGE REDIRECTION AFTER A CRUD ACTION
        // REDIRECTION / REFRESH TIME
        // _________________________________________________________

        header("Location: /admin/admin.php"); // header("Refresh:0");    
        exit;

    }

    // AFTER EACH PAGE CALL (REQUIRED/ INCLUDED FILES)
    // OR 
    // AFTER THE EXECUTION OF AN INSTRUCTION ON THE PAGE (CREATE, DELETE) 
    global $message;   // Déclare a global $message before include it to view 
    include 'vue/admin.php';
    require 'vue/partials/footer.php';

} 
else {
    // _________________________________________________________________
    // ! $_SESSION["login"]
    // NO USER IS LOGGED IN TO THE TASK MANAGEMENT APPLICATION 
    // _________________________________________________________________

     header("Location: /admin/"); // OK -> Firefox : http://localhost/html/admin/ 
      
    } 
    
