<?php

session_start();

if($_SESSION["login"]) {
    
    require '../config.php';
    require 'vue/partials/header.php';
    include '../utils/connectdb.php';
    include '../model/task.php';
    include '../model/group.php';
    include 'vue/partials/nav.php';

    $task = getTasks();
    // print_r($task ); 
    
    $group = getGroup();
    // print_r($group ); 
    
    $numOfTasks = countTasks() ; 



    if($_SERVER['REQUEST_METHOD'] === 'POST'){

        if(isset($_POST['action'])){

            if ($_POST['action'] == 'createTask') {
                createTask($_POST['name'], $_POST['color'], $_POST['weekdays'], $_POST['idGroup'], $_POST['label']);
            } elseif ($_POST['action'] == 'deleteTask'){
                deleteTask($_POST['id']);
            } elseif ($_POST['action'] == 'updateTask'){
                updateTask($_POST['id'], $_POST['name'], $_POST['color'], $_POST['weekdays'], $_POST['idGroup'], $_POST['label']);
            }
            
        }

        // REDIRECTION / REFRESH TIME
        header("Location: /admin/task.php");// header("Refresh:0");

    } // SERVER REQUEST METHOD POST 


    require 'vue/task.php';
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