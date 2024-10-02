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
    include '../utils/connectdb.php';    

    require 'vue/partials/header.php';
    include 'vue/partials/nav.php';   

    require '../model/mail.php';
    require __DIR__ . '/../model/task.php';

    // ____________________________________________ 
    // Manage Addressees (Mail Receivers) for View /vue/addressee.php 
    // ____________________________________________
    $addressees = getAddressee (); // var_dump($addressees ); 
    $header_location = false; 
    $numOfAddressees = countAddressees() ; 


    // ____________________________________________
    // Manage Mail 
     // ____________________________________________
    createDefaultMail(DEFAULT_MAIL); // DEFAULT_MAIL (//Default mail message) -> Variable from /html/config.php 
    $mail = getMail();


    // Vérification de la soumission du formulaire en POST
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {


    
        if(isset($_POST) && isset($_POST['textarea_mail'])) {
            updateMail($_POST['textarea_mail']);
            $header_location = true; 

            // REDIRECTION / REFRESH TIME
            header("Location: /admin/addressee.php");  // header("Refresh:0"); 

        }

        // ____________________________________________
        // TEST CHECK LIST OF RECIPIENTS / ADDRESSEES 
        // ____________________________________________
        /* 
        if(isset($_POST['send_mail']) && isset($_POST['check_list'])){//to run PHP script on submit
            
            if(!empty($_POST['check_list'])){
                
                $recipients = $_POST['check_list']; 
                foreach($_POST['check_list'] as $selected){  
                    echo "Recipient : ".$selected."<br>"; 
                }
                echo "<br>"; 
            }
        } // OK 
        */ 


        // ____________________________________________
        // SI Bouton SEND cliqué
        // ____________________________________________

        // CREATE UNE LISTE D'EXPEDITEURS (ADDRESSEES) A PARTIR DES ID SELECTIONNES 
        if(isset($_POST['send_mail']) && isset($_POST['check_list'])){//to run PHP script on submit

            if(!empty($_POST['check_list'])){
                
                $bcc_recipients = $_POST['check_list']; 
                $now = new DateTime('Today');
                $now->setTime(0, 0, 0, 0);
                
                $taskeds = R::findall('tasked');
                foreach ($taskeds as $tasked){
                    $date = new DateTime($tasked->start);
                    if($date == $now){  
                       
                        // TEST : sendmail($user, $tasked);   
                        $sended = sendmail($bcc_recipients, $tasked); 
                        if($sended == true){
                            updateContacted($tasked->id, $tasked->task_id, $tasked->user_id, "YES"); // FROM Model mail.php
                            // Afficher destinataires liste 
                        }
                    }
                }
            }

            $header_location = true; 

            // REDIRECTION / REFRESH TIME
            header("Location: /admin/addressee.php");  // header("Refresh:0"); 
            
        } // OK 


        // _________________________________________________
        // CREATE ADDRESSEE 
        // _________________________________________________
        if(isset($_POST['create_addressee']) && isset($_POST['addr_name']) && isset($_POST['addr_email'])){    
            $name = $_POST['addr_name']; 
            $email = $_POST['addr_email']; 

            createAddressee ($name, $email); 		
            $header_location = true; 

            // REDIRECTION / REFRESH TIME
            header("Location: /admin/addressee.php");  // header("Refresh:0");             
        }


        // _________________________________________________
        // DELETE ADDRESSEE 
        // _________________________________________________
        if(isset($_POST['delete_addressee']) && isset($_POST['id_addressee'])){    
            $id = $_POST['id_addressee']; 

            deleteAddressee($id); 
            $header_location = true; 

            // REDIRECTION / REFRESH TIME
            header("Location: /admin/addressee.php");  // header("Refresh:0"); 
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
                    
            // REDIRECTION / REFRESH TIME
            header("Location: /admin/addressee.php");  // header("Refresh:0"); 
        }



    }

    // _____________________________________________________________________________________________________________________
    // _____________________________________________________________________________________________________________________

    // Vues
    include 'vue/addressee.php';    
    require 'vue/partials/footer.php'; 


} else {
   header("Location: /admin/");
} 



