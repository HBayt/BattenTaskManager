<?php
// admin/mail.php 

session_start(); 

/*
if (!empty($_SERVER['REMOTE_ADDR'])) {

    // If a "remote" address is set, we know that this is not a CLI call
    header('HTTP/1.1 403 Forbidden');
    die('Access denied. Go away, shoo!');
    
  }

*/ 
if($_SESSION["login"]) {
    
    require '../config.php';
    require 'vue/partials/header.php';
    include '../utils/connectdb.php';
    require '../model/mail.php';
    include 'vue/partials/nav.php'; 
    include '../model/tasked.php';
    
    // To send mail 
    // require __DIR__ . '/../config.php';
    // require_once __DIR__ . '/../utils/connectdb.php';
    require __DIR__ . '/../model/task.php';


    $header_location = false; 

    // ____________________________________________
    // Manage Mail 
     // ____________________________________________
    createDefaultMail(DEFAULT_MAIL); // DEFAULT_MAIL (//Default mail message) -> Variable from /html/config.php 
    $mail = getMail();
    
    if(isset($_POST) && isset($_POST['mail'])) {
        updateMail($_POST['mail']);
        $header_location = true; 
        header("Refresh:0");
    }


    // ____________________________________________
    // Manage Addressees (Mail Receivers)
    // ____________________________________________

   
    // ____________________________________________ 
    // Manage Addressees (Mail Receivers) for View /vue/addressee.php 
    // ____________________________________________
    $addressees = getAddressee (); 
    // var_dump($addressees ); 



    // ____________________________________________
    // TEST CHECK LIST OF RECIPIENTS / ADDRESSEES 
    // ____________________________________________

    if(isset($_POST['send_mail']) && isset($_POST['check_list'])){//to run PHP script on submit
        
        if(!empty($_POST['check_list'])){
            
            $recipients = $_POST['check_list']; 
            foreach($_POST['check_list'] as $selected){  // Loop to store and display values of individual checked checkbox.
            }
        }
    } // OK 

// _____________________________________________________________________________________________________________________
// _____________________________________________________________________________________________________________________

    // ____________________________________________
    // SI Bouton SEND cliqué
    // ____________________________________________


    // CREATE UNE LISTE D'EXPEDITEURS (ADDRESSEES) A PARTIR DES ID SELECTIONNES 

    if(isset($_POST['send_mail']) && isset($_POST['check_list'])){//to run PHP script on submit

        if(!empty($_POST['check_list'])){
            
            $bcc_recipients = $_POST['check_list']; 
            sendmail($bcc_recipients); 





            $header_location = true; 
        }

        // header("Location: /admin/addressee.php");
        // header("Refresh:0");
		
    } // OK 


// _____________________________________________________________________________________________________________________
// _____________________________________________________________________________________________________________________


    // _________________________________________________
    // CREATE ADDRESSEE 
    // _________________________________________________
    if(isset($_POST['create_addressee']) && isset($_POST['addr_name']) && isset($_POST['addr_email'])){    
        $name = $_POST['addr_name']; 
        $email = $_POST['addr_email']; 

        createAddressee ($name, $email); 	
        $header_location = true; 	
    }


    // _________________________________________________
    // DELETE ADDRESSEE 
    // _________________________________________________
    if(isset($_POST['delete_addressee']) && isset($_POST['id_addressee'])){    
        $id = $_POST['id_addressee']; 

        deleteAddressee($id); 
        $header_location = true; 
    }


    // _________________________________________________
    // UPDATE ADDRESSEE 
    // _________________________________________________
    if(isset($_POST['update_addressee']) && isset($_POST['id_addressee'])){    
       // echo "hell0"; // check if PHP interpreter enters in the function 
        $id = $_POST['id_addressee']; 
        $name = $_POST['addr_name']; 
        $email = $_POST['addr_email']; 

        updateAddressee($id, $name, $email); 		
        $header_location = true; 
    }

    // _____________________________________________________________________________________________________________________
    // _____________________________________________________________________________________________________________________






    // Vues
    include 'vue/addressee.php';    
    require 'vue/partials/footer.php'; 

    if( $header_location == true){

         // header('Location: ' . $_SERVER['HTTP_REFERER']); 
        // header("Location: /admin/generateTasks.php");  
        header("Location: /admin/addressee.php");   

    }



} else {
   header("Location: /admin/");
} 



