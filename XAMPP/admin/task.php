<?php

session_start();

if($_SESSION["login"]) {
    
    require '../config.php';
    require 'vue/partials/header.php';
    include '../utils/connectdb.php';
    include '../model/task.php';
    include '../model/group.php';
    include '../model/user.php';
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
                $_SESSION['message'] = '<div class="alert alert-success" role="alert"> New <strong>Task</strong> <span style="color:green;"> ('.$_POST['name'].') </span> created successfully!</div>'; 
            } elseif ($_POST['action'] == 'deleteTask'){
                deleteTask($_POST['id']);
                $_SESSION['message'] = '<div class="alert alert-success" role="alert"> Selected <strong>task</strong> <span style="color:green;"> ('.$_POST['id'].')</span> deleted successfully!</div>'; 
            } elseif ($_POST['action'] == 'updateTask'){
                updateTask($_POST['id'], $_POST['name'], $_POST['color'], $_POST['weekdays'], $_POST['idGroup'], $_POST['label']); 
                $_SESSION['message'] = '<div class="alert alert-success" role="alert"> Selected <strong>task</strong> for <span style="color:green;"> ('.$_POST['name'].')</span> updated successfully!</div>'; 
            }
            
        }

        // REDIRECTION / REFRESH TIME
        header("Location: /admin/task.php");// header("Refresh:0"); 
        exit; 


    } // SERVER REQUEST METHOD POST 



    // AFTER EACH PAGE CALL (REQUIRED/ INCLUDED FILES)
    // OR 
    // AFTER THE EXECUTION OF AN INSTRUCTION ON THE PAGE (CREATE, DELETE) 
    global $message;   // Déclare a global $message before include it to view    
    require 'vue/task.php';
    require 'vue/partials/footer.php';

 
} else {
    // _________________________________________________________________
    // ! $_SESSION["login"]
    // NO USER IS LOGGED IN TO THE TASK MANAGEMENT APPLICATION 
    // _________________________________________________________________

    header("Location: /admin/"); // OK -> Firefox : http://localhost/html/admin/ 
      
} 
