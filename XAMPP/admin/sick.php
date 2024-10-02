<?php 
session_start();

if($_SESSION["login"]) { 

    require '../config.php';
    require_once '../utils/connectdb.php';
    require '../model/task.php';
    require '../model/user.php';
    require '../model/mail.php';
    require '../model/tasked.php';


    if(isset($_POST['tasked_id'])){

        $bcc_recipients = R::findall('addressee');  
        $t = randomPersonForTask( $_POST['tasked_id'] );
        // sendmail($t);
        sendmail($bcc_recipients, $t); 
        header("Location: /admin/callendar.php");
    }
    if(isset($_POST['id_user'])){
        $bcc_recipients = R::findall('addressee');  
        $t = changePersonForTask( $_GET['tasked_id'], $_POST['id_user']);
        sendmail($bcc_recipients, $t); 
        header("Location: /admin/callendar.php");
    }
    
    require 'vue/partials/header.php';
    include 'vue/partials/nav.php';

    $tasked = R::load('tasked',  $_GET['tasked_id']);
    $user = [];
    foreach ($tasked->task->sharedGroup as $group) {
        $user = array_merge($user, $group->ownUserList); 
    }

    $iterator = new ArrayIterator($user);
    $numOfUsers = iterator_count($iterator); 
    
    
    require 'vue/sick.php';
    
} else {
    header("Location: /admin/");
} 