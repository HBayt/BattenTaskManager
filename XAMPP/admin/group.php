<?php
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
        if (isset($_POST['method']) and $_POST['method'] == 'DELETE') {
            deleteGroup($_POST['id']);
        } else {
            createGroup($_POST['label'] , $_POST['name']);
        }
        // header("Refresh:0"); 
        header("Location: /admin/group.php");
    }

    require 'vue/group.php';
    require 'vue/partials/footer.php'; 
} else {
    header("Location: /admin/");
} 
