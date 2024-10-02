<?php

session_start();

if($_SESSION["login"]) {
    require '../config.php';
    require 'vue/partials/header.php';
    include '../utils/connectdb.php';
    require '../model/admin.php';
    include 'vue/partials/nav.php';
    
    $admin = getAdmin();

    if(isset($_POST['name']) and isset($_POST['password'])){
        createAdmin($_POST['name'], $_POST['password']);
        header("Refresh:0");
    }
    if (isset($_POST['id_admin'])) {
        deleteAdmin($_POST['id_admin']);
        header("Refresh:0");
    }
   
    include 'vue/admin.php';
    require 'vue/partials/footer.php';
} else {
    header("Location: /admin/");
} 
