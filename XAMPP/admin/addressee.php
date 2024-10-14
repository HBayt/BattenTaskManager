<?php 
// _______________________________________________
// Update time : 03.10.2024 
// Author : H. Baytar 
// _______________________________________________


session_start(); 


if($_SESSION["login"]) {
    
    require '../config.php';
    include '../utils/connectdb.php';    

    require 'vue/partials/header.php';
    include 'vue/partials/nav.php';   

    require '../model/mail.php';
    require __DIR__ . '/../model/task.php';

    // ____________________________________________ 
    // Variables for View /vue/addressee.php 
    // ____________________________________________
    $addressees = getAddressee (); // Datas from MySQL 
    $numOfAddressees = countAddressees() ;  

    createDefaultMail(DEFAULT_MAIL); // DEFAULT_MAIL -> Variable from /html/config.php  (for Default mail message)
    $mail = getMail();

    // ____________________________________________ 
    // IF SYSTEM GET HTTP POST REQUEST 
    // ____________________________________________ 
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        if(isset($_POST['textarea_mail'])) {
            updateMail($_POST['textarea_mail']);
            $_SESSION['message'] = '<div class="alert alert-success" role="alert"> <strong>Email content</strong> updated successfully!</div>'; 
        }

        // Check if a Addressee is selected from HTML Form 
        // IF the Addressee is selected, THEN add it to List 
        // FINALY Send a mail to Addressees List 
        if(isset($_POST['send_mail']) && isset($_POST['check_list'])){//to run PHP script on submit

            if(!empty($_POST['check_list'])){
                
                $bcc_recipients = $_POST['check_list']; 
                $now = new DateTime('Today');
                $now->setTime(0, 0, 0, 0);
                
                $taskeds = R::findall('tasked');
                foreach ($taskeds as $tasked){
                    $date = new DateTime($tasked->start);
                    if($date == $now){  
                        // ____________________________________________
                        // SEND MAIL TO RECIPIENTS LIST 
                        // ____________________________________________  
                        $sended = sendmail($bcc_recipients, $tasked); 
                        if($sended == true){

                            updateContacted($tasked->id, $tasked->task_id, $tasked->user_id, "YES"); // FROM Model mail.php
                            // Confirmation Message for user displayed in the view 
                            $_SESSION['message'] = '<div class="alert alert-success" role="alert">  <strong>Email</strong> sended successfully!</div>'; 
                        }
                    }
                }
            }
        } 


        // _________________________________________________
        // CREATE ADDRESSEE 
        // _________________________________________________
        if(isset($_POST['create_addressee']) && isset($_POST['addr_name']) && isset($_POST['addr_email'])){    
            $name = $_POST['addr_name']; 
            $email = $_POST['addr_email']; 

            createAddressee ($name, $email); 		
            $_SESSION['message'] = '<div class="alert alert-success" role="alert"> New <strong>recipient/addreessee</strong> <span style="color:green;">('.$name." / ".$email.')</span> created successfully!</div>'; 
           
        }


        // _________________________________________________
        // DELETE ADDRESSEE 
        // _________________________________________________
        if(isset($_POST['delete_addressee']) && isset($_POST['id_addressee'])){    
            $id = $_POST['id_addressee']; 

            deleteAddressee($id); 
            $_SESSION['message'] = '<div class="alert alert-success" role="alert"> Selected <strong>recipient/addreessee</strong> <span style="color:green;">( Id = '.$id.')</span> deleted successfully!</div>'; 
               
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
            $_SESSION['message'] = '<div class="alert alert-success" role="alert"> Selected <strong>recipient/addreessee</strong> <span style="color:green;">('.$name." / ".$email.')</span> updated successfully!</div>'; 
                    
        }


        // _________________________________________________________
        // PAGE REDIRECTION AFTER A CRUD ACTION
        // REDIRECTION / REFRESH TIME
        // _________________________________________________________
        header("Location: /admin/addressee.php");  // header("Refresh:0");   
        exit;

    }


    // _________________________________________________________
    // AFTER EACH PAGE CALL (REQUIRED/ INCLUDED FILES)
    // OR 
    // AFTER THE EXECUTION OF AN INSTRUCTION ON THE PAGE (CREATE, DELETE) 
    // _________________________________________________________
    global $message;   // Déclare a global $message before include it to view 
    include 'vue/addressee.php';  
    require 'vue/partials/footer.php'; 


} else {
   header("Location: /admin/");
} 



