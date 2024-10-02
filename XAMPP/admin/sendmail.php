<?php 

/* 
  if (!empty($_SERVER['REMOTE_ADDR'])) {
    // If a "remote" address is set, we know that this is not a CLI call
    header('HTTP/1.1 403 Forbidden');
    die('Access denied. Go away, shoo!');
  }
*/ 

  
require __DIR__ . '/../config.php';
require_once __DIR__ . '/../utils/connectdb.php';
require __DIR__ . '/../model/task.php';
require __DIR__ . '/../model/mail.php'; 
include '../model/tasked.php'; 


$now = new DateTime('Today');
$now->setTime(0, 0, 0, 0);

$taskeds = R::findall('tasked');
$bcc_recipients = R::findall('addressee'); 

// $mail = "halide.baytar@battenberg.ch"; 
// $bcc_recipients =  R::find( 'addressee', "email = '" . $mail . "'");
// var_dump($bcc_recipients); 
// print_r((array) $bcc_recipients); 


foreach ($taskeds as $tasked){

    $date = new DateTime($tasked->start);
    if($date == $now){  
       
      // TEST : sendmail($user, $tasked);   
      $sended = sendmail($bcc_recipients, $tasked); 
      if($sended == true){
        updateContacted($tasked->id, $tasked->task_id, $tasked->user_id, "YES"); 
        // Afficher destinataires liste 
      }

    }
}


?>