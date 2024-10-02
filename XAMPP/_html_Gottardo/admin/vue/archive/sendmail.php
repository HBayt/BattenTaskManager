<?php
// admin/sendmail.php 


if (!empty($_SERVER['REMOTE_ADDR'])) {

  // If a "remote" address is set, we know that this is not a CLI call
  header('HTTP/1.1 403 Forbidden');
  die('Access denied. Go away, shoo!');
  
}

require __DIR__ . '/../config.php';
require_once __DIR__ . '/../utils/connectdb.php';
require __DIR__ . '/../model/task.php';
require __DIR__ . '/../model/mail.php';

$tasked= R::findall('tasked');
$now = new DateTime('Today');
$now->setTime(0, 0, 0, 0);

foreach ($tasked as $t){
    
    $date = new DateTime($t->start);
    if($date == $now){   
      sendmail($t);
    }
}

?>