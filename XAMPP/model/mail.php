<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require_once __DIR__ . "/../vendor/autoload.php";


// UPDATE `tasked` SET `title`='Halide BAYTAR',`user_id`=128 WHERE `start`=curdate(); 

//________________________________________________________
// Create A DEFAULT EMAIL INTO MySQL DB IF NOT EMAIL FOUND  
//________________________________________________________
function createDefaultMail ($text) {

    $mails = R::findAll( 'mail' );

    if($mails == []) {
        $mail = R::dispense( 'mail' );
        $mail->text = $text;
        $id = R::store( $mail );
    }

}

//________________________________________________________
// GET /SELECT EMAIL FROM MySQL DB  
//________________________________________________________
function getMail () {
    $mails = R::findAll( 'mail' );
    return $mails[1];
}

//________________________________________________________
// UPDATE THE EMAIL SAVED/ INSERTED INTO MySQL DB 
//________________________________________________________
function updateMail ($text) {
    $mail = getMail();
    $mail->text = $text;
    R::store($mail);
}

//________________________________________________________
// SEND AN EMAIL FOR A TASKED
//________________________________________________________
function sendmail($bcc_recipients, $tasked) {
    $sended = false; 

    // CREATE PHP DATETIME OBJECT FOR TODAY DATE 
    $now = new DateTime('Today');
    $now->setTime(0, 0, 0, 0);
    $now = $now->format('Y-m-d'); // $now = $now->format('Y-m-d H:i:s'); 

    // SELECT ALL ASSIGNED TASKS FROM TABLE TASKED (MySQL DATABASE)
    $taskededs = R::findall('tasked');    

    try {
        // Try/Attempt to create a new instance of the PHPMailer class, with exceptions enabled
        // Tentative de création d’une nouvelle instance de la classe PHPMailer, avec les exceptions activées
        $mail = new PHPMailer(true); 

        // SMTP Configuration
        $mail->isSMTP();
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = SMTP_SECU;
        $mail->Host = SMTP_HOST; // Your SMTP server
        $mail->Port = SMTP_PORT;
        $mail->Username = SMTP_USER; // Your Mailtrap username
        $mail->Password = SMTP_PASS; // Your Mailtrap password

        //________________________________________________________
        // FOR EACH TASKED GENERETAD (ASSIGNED)
        //________________________________________________________

            // GET Task start date
            $date = new DateTime($tasked->start);
            $result = $date->format('Y-m-d');   

            // IF TASK START DATE IS SAME AS TODAY (EMAIL SEND DAY)
            if($result == $now){ 

                // _______________________________
                // Sender and recipient settings                
                // _______________________________

                // Sender (Expéditeur) 
                $mail->setFrom(SMTP_USER, "Task Manager");
                
                // Primary (To)
                // Recipient name can also be specified as an option | Le nom du Destinataire peut également être indiqué en option 
                // $mail->addAddress($t->user->email); 
                $mail->addAddress($tasked->user->email, $tasked->user->name); // Primary (To) 

                //____________________________________________________________________________
                // CREATE AN HIDDEN COPY FOR EACH ADDRESSEE/ RECIPIENT (Copies cachées) 
                 //____________________________________________________________________________
                foreach($bcc_recipients as $bcc){         

                    // FIND ADDRESSEE/ RECIPIENT 
                    $addressee = getAddresseeById($bcc); 

                    $bcc_name = $addressee['name']; // var_dump($name ); 
                    $bcc_email = $addressee['email']; //  var_dump($email )

                    // $mail->addBCC($bcc_email, $name=$bcc_name); 
                    $mail->addBCC($bcc_email, $bcc_name); 

                }// addBCC() 

                // _______________________________________________________
                // CONTENT (BODY) OF EMAIL TO BE SEND 
                // _______________________________________________________

                //SET EMAIL BODY CONTENT FORMAT TO HTML ==> DOES NOT SET EMAIL FORMAT TO PLAIN TEXT ==> $mail->IsHTML(false); 
                $mail->IsHTML(true); 

                // EMAIL OBJECT (TITLE)
                $mail->Subject = $tasked->task->name . " -> " . $tasked->user->name; 

                // CREATE HTML-CONTENT  
                $body = getMail()->text; // MySQL Request 

                // REPLACE NAME AND DATE OF EMAIL TO BE SEND WITH THE TASK NAME AND THE EMAIL MESSAGE FROM TABLE "MAIL" (MySQL DATABASE) 
                $body = str_replace('/name', $tasked->task->name, $body);
                $body = str_replace('/date', (new DateTime($tasked->start))->format('d-m-y'), $body); 



                //$mail->Body = 'The email message. It is possible to add HTML elements (tags), for example, <b>bold</b>, ... '; 
                $mail->Body = $body;
                // $mail->AltBody = 'Le texte comme simple élément textuel';


                // Ajouter une pièce jointe
                // $mail->addAttachment("/home/user/Desktop/image.png", "image.png");
                
                $mail->CharSet = 'UTF-8';
                $mail->Encoding = 'base64';

                // _______________________________
                // SEND
                // _______________________________
                // Method One 
                // $mail->send();  

                // Method Two 
                if(!$mail->send()) {
                    $sended = false; 
                    echo 'Message could not be sent. <br>';
                    echo 'Mailer Error: ' . $mail->ErrorInfo;

                }else {
                    $sended = true; 
                    echo 'Message has been sent <br>';
                }

                // clear addresses of all types             
                $mail->ClearAddresses();  // each AddAddress add to list
                /* 
                $mail->ClearCCs();
                $mail->ClearBCCs();
                $mail->ClearAllRecipients(); 

                */  

            } 

    } catch (Exception $e) {
        echo 'Email could not be sent. Mailer Error: <br>'. $mail->ErrorInfo; 
        echo $e->getMessage();
    }
    return  $sended; 
}// Send mail 


// _____________________________________________________________________________________
// COUNTING NUMBER OF USERS IN THE DATABASE   
// _____________________________________________________________________________________
function countAddressees() {
    $numOfAddressees = R::count( 'addressee');
    return $numOfAddressees; 
}



//____________________________________________________________________________
// Get all addressee from MySQL DB 
//____________________________________________________________________________
function getAddressee () {
    return R::findAll('addressee');
}


//____________________________________________________________________________
// Get an addressee from MySQL DB 
//____________________________________________________________________________
function getAddresseeById($id) {
    return R::load('addressee', $id ); 
}

//____________________________________________________________________________
// Insert Into 'Addressee'
//____________________________________________________________________________
function createAddressee ($name, $email) {
    $addressee = R::dispense('addressee');
    $addressee->name = $name;
    $addressee->email = $email;
    return R::store( $addressee );
}

//____________________________________________________________________________
// Delete 'Addressee' Row 
//____________________________________________________________________________
function deleteAddressee($id) {
    $addressee = R::load('addressee', $id ); 
    R::trash( $addressee );
}

//____________________________________________________________________________
// Update 'Addressee' Row
//____________________________________________________________________________
function updateAddressee($id, $name, $email) {
    $addressee = R::load( 'addressee', $id );
    $addressee->name = $name;
    $addressee->email = $email;
    R::store( $addressee );
}



// ____________________________________________________________________________________________
// UPDATE TASKED / SET CONTACTED COLUMN TO YES (= EMAIL SENDED)
// _____________________________________________________________________________________________
function updateContacted($id, $tasked_id, $user_id, $contacted) {
    $taskeded = R::load( 'tasked', $id );

    $taskeded->task_id = $tasked_id;
    $taskeded->user_id = $user_id;
    $taskeded->contacted = $contacted;
    // echo "<h1> Ttasked: ".$id.", task: ".$taskeded->task_id.", user: ".$taskeded->user_id."</h1>"; die(); 
    R::store( $taskeded );
}



//____________________________________________________________________________
// Display AN POPUP WITH A GIVEN MESSAGE 
//____________________________________________________________________________
function alert($msg) {
    echo "<script type='text/javascript'>alert('$msg');</script>";
}


?>