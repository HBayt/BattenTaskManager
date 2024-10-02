<?php

session_start();

if($_SESSION["login"]) {
    require '../config.php';
    require_once '../utils/connectdb.php';
    require '../model/user.php';
    require '../model/vacation.php';

    
    require 'vue/partials/header.php';
    include 'vue/partials/nav.php';

    $vacations = getVacationByUser($_GET['user_id']);

    if(isset($_POST) && isset($_POST['start']) && isset($_POST['start']) && isset($_GET['user_id'])){
        createVacation($_GET['user_id'], $_POST['start'], $_POST['end']);
        header("Refresh:0");
    } 

    if (isset($_POST) && isset($_POST['id'])) {
        deleteVacation($_POST['id']);
        header("Refresh:0");
    }

    require 'vue/vacation.php';
    require 'vue/partials/footer.php';
    
} else {
    header("Location: /admin/");
} 