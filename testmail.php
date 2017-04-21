<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once('includes/classes/phpmailer.class.php');
require_once('includes/classes/smtp.class.php');

$body             = "Hello this is email test";
$address 		  = "lackonendes@gmail.com";
$subject		  = "Your First Jump video is ready!";

$mail             = new PHPMailer();
$mail->IsSMTP(); 
$mail->SMTPDebug  = 0;
$mail->SMTPAuth   = true;
$mail->Host       = "mail.skydivechicago.com";
$mail->Port       = 25;                    
$mail->Username   = "wwwmail@skydivechicago.com";
$mail->Password   = "iwanttoskydive";
$mail->SetFrom('info@skydivechicago.com', 'Skydive Chicago');
$mail->AddReplyTo("info@skydivechicago.com","Skydive Chicago");
$mail->AddAddress($address);
$mail->Subject    = $subject
$mail->MsgHTML($body);

if(!$mail->Send()) {
	return true;
} else {
	return false;
}
?>