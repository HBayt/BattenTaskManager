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
    include 'vue/partials/nav.php';


    // GET ALL TASKED FROM DATABASE TABLE TASKED
    $taskeds = getTaskeds();

    // IF FORM SENDED 
    if($_SERVER['REQUEST_METHOD'] === 'POST'){ 

        // IF USER CLICKED ON BUTTON DELETE AND IF TASKED_ID IS SET 
        if(isset($_POST['delete_tasked']) && isset($_POST['id_tasked'])){

            // DELETE THE TASK USING THE TASK ID 
            deleteTasked($_POST['id_tasked']);

            // echo "<h1> hello </h1>"; die();             
        }

        // header("Refresh:0");
        header("Location: /admin/tasked.php");
    }

    // REQUIRED FILE BY CALLING admin/tasked.php 
    require 'vue/tasked.php';
    require 'vue/partials/footer.php';

} else {
    // ______________________________________
    // ORIGINAL SERVEUR LINUX
    // ______________________________________
    // header("Location: /admin/"); // Original KO sur XAMPP 

    // ______________________________________
    // DEV LOCAL SERVEUR XAMPP 
    // ______________________________________

    // header("Location: http://localhost/admin/"); // KO  sur XAMPP 
    header("Location: /admin/"); // OK sur XAMPP | Firefox : http://localhost/html/admin/ 
} 