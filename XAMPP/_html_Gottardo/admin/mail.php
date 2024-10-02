<?php

session_start();

if($_SESSION["login"]) {
    require '../config.php';
    require 'vue/partials/header.php';
    include '../utils/connectdb.php';
    require '../model/mail.php';
    include 'vue/partials/nav.php';
    
    
    createDefaultMail(DEFAULT_MAIL);
    $mail = getMail();
    
    if(isset($_POST) && isset($_POST['mail'])) {
        updateMail($_POST['mail']);
        header("Refresh:0");
    }

    include 'vue/mail.php';
    require 'vue/partials/footer.php';
} else {
    header("Location: /admin/");
} 
