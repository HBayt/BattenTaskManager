<?php 
session_start();

if($_SESSION["login"]) {
    require '../config.php';
    include '../utils/connectdb.php';
    require '../model/task.php';
    if(isset($_POST['from'])) {
        $from = new DateTime($_POST['from']);
        $to = new DateTime($_POST['from']);
        date_add($to, date_interval_create_from_date_string('3 month'));
        gennerateTasks($from, $to);
    } 
    header('Location: ' . $_SERVER['HTTP_REFERER']);
} else {
    header("Location: /admin/");
} 