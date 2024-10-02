<?php

session_start();

// var_dump(session_start()); 
// var_dump($_SESSION["login"]); 

if($_SESSION["login"]) {

    require '../config.php';
    require 'vue/partials/header.php';
    include '../utils/connectdb.php';
    require '../model/mail.php';
    include 'vue/partials/nav.php'; 
    
    
    createDefaultMail(DEFAULT_MAIL);
    $mail = getMail();
    
    // var_dump($mail); 
    // var_dump($_POST); 
    // var_dump($_POST['mail']); 

    if(isset($_POST) && isset($_POST['mail'])) {
        updateMail($_POST['mail']);
        header("Refresh:0");
    }



    // var_dump($mail); 
    // var_dump(sendmail ($mail)); 
    // sendmail ($mail); 

    include 'vue/mail.php';
    require 'vue/partials/footer.php';
} else {
    // header("Location: /admin/");
    header("Location: /admin/");
} 
