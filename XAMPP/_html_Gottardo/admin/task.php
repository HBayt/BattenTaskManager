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
    $group = getGroup();

    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        if(isset($_POST['action'])){
            if ($_POST['action'] == 'createTask') {
                createTask($_POST['name'], $_POST['color'], $_POST['weekdays'], $_POST['idGroup']);
            } elseif ($_POST['action'] == 'deleteTask'){
                deleteTask($_POST['id']);
            } elseif ($_POST['action'] == 'updateTask'){
                updateTask($_POST['id'], $_POST['name'], $_POST['color'], $_POST['weekdays'], $_POST['idGroup']);
            }
        }
        header("Refresh:0");
    }
    require 'vue/task.php';

    require 'vue/partials/footer.php';
} else {
    header("Location: /admin/");
} 
