<?php 
session_start();

if($_SESSION["login"]) {
    require '../config.php';
    require_once '../utils/connectdb.php';
    require '../model/task.php';
    require '../model/user.php';
    require '../model/mail.php';

    if(isset($_POST['tasked_id'])){
        $t = randomPersonForTask( $_POST['tasked_id'] );
        sendmail($t);
        header("Location: /admin/callendar.php");
    }
    if(isset($_POST['id_user'])){
        $t = changePersonForTask( $_GET['tasked_id'], $_POST['id_user']);
        sendmail($t);
        header("Location: /admin/callendar.php");
    }
    
    require 'vue/partials/header.php';
    include 'vue/partials/nav.php';

    $tasked = R::load('tasked',  $_GET['tasked_id']);
    $user = [];
    foreach ($tasked->task->sharedGroup as $group) {
        $user = array_merge($user, $group->ownUserList);
    }
    require 'vue/sick.php';


    
} else {
    header("Location: /admin/");
} 