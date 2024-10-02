<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once __DIR__ . "/../vendor/autoload.php";


function createDefaultMail ($text) {
    $mails = R::findAll( 'mail' );
    if($mails == []) {
        $mail = R::dispense( 'mail' );
        $mail->text = $text;
        $id = R::store( $mail );
    }
}

function getMail () {
    $mails = R::findAll( 'mail' );
    return $mails[1];
}

function updateMail ($text) {
    $mail = getMail(); 
    $mail->text = $text;
    R::store($mail);
}

function sendmail ($t) {
    try {
        $mail = new PHPMailer(true); 

        $mail->isSMTP();
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = SMTP_SECU; 
        $mail->Host = SMTP_HOST;
        $mail->Port = SMTP_PORT;
        $mail->Username = SMTP_USER; 
        $mail->Password = SMTP_PASS;
        $mail->From = SMTP_USER;
        $mail->FromName = "Task Manager";
        
        $mail->Subject = $t->task->name . " -> " . $t->user->name;
        
        $body = getMail()->text;
        
        $mail->CharSet = 'utf-8';
        $body = str_replace('/name', $t->task->name, $body);
        $body = str_replace('/date', (new DateTime($t->start))->format('d-m-y'), $body);
        
        $mail->Body = $body;
        $mail->IsHTML(true);
                
        $mail->addAddress($t->user->email, $t->user->name);
        $mail->addBCC('dalai.wenger@battenberg.ch', $name='Dalai Wenger');
        $mail->addBCC('robin.gottardo@battenberg.ch', $name='Robin Gottardo');
        $mail->addBCC('andy.linder@battenberg.ch', $name='Andy Linder');
	$mail->addBCC('Richard.Grandgirard@battenberg.ch', $name='Richard Grandgirard');
	$mail->addBCC('Adriana.Aniello@battenberg.ch', $name='Adriana Aniello');
	$mail->addBCC('mohamed.ibrahim@battenberg.ch', $name='Mohamed Ibrahim');
	$mail->addBCC('Quentin.Keller@battenberg.ch', $name='Quentin Keller');
	$mail->addBCC('corinne.stotzer@battenberg.ch', $name='Corinne Stotzer');
	$mail->addBCC('stefanie.wick@battenberg.ch', $name='Stefanie Wick');
	$mail->addBCC('sylvia.baelli@battenberg.ch', $name='Sylvia Bälli');
	$mail->addBCC('monika.vonaesch@battenberg.ch', $name='Monika von Aesch');
	$mail->addBCC('elisabeth.ruckstuhl@battenberg.ch', $name='Elisabeth Ruckstuhl');
	$mail->addBCC('frank.krumm@battenberg.ch', $name='Frank Krumm');
        $mail->send();
        echo 'Email has been sent';
    } catch (Exception $e) {
        echo 'Email could not be sent. Mailer Error: '. $mail->ErrorInfo;
    }
}
?>
