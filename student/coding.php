<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/Exception.php';
require 'phpmailer/PHPMailer.php';
require 'phpmailer/SMTP.php';

if(isset($_GET['submit'])){
$to="mrugadre3004@gmail.com";// this is your Email address
$from=$_GET['email'];// this is the sender's Email address
$name=$_GET['name'];
$email=$_GET['email'];
$ans=$_GET['ans'];



//replace this file path with your attchements filepath in project
//$attachment = 'uploads/assignment1.txt';


// To teacher
$subject="Form submission";
$body="Name: ".$name."\nEMAIL is: ".$email."\nAnswer: ".$ans;
send_email_to_user($to, $from, $subject, $body);//, $attachment);


//To student
$subject2="Copy of your form submission";
$body2="Here is a copy of your Form ".$name."\n\n".$ans;
//$headers2="From:".$to;
send_email_to_user($from, $from, $subject2, $body2);//, $attachment);


//mail($to,$subject,$ph_number,$headers);
//mail($from,$subject2,$ph_number2,$headers2);// sends a copy of the ph_number to the sender
//echo "Thanks".$name."We received your email.";
// You can also use header('Location: thank_you.php'); to redirect to another page.
}
function send_email_to_user($to, $from, $subject, $body)//, $attachment)
 {
	// send email with phpmailer
	
	$mail = new PHPMailer;
	$mail->isSMTP(); 
	$mail->SMTPDebug = 0; // 0 = off (for production use) - 1 = client messages - 2 = client and server messages
	$mail->Host = "smtp.office365.com"; // use $mail->Host = gethostbyname('smtp.gmail.com'); // if your network does not support SMTP over IPv6
	$mail->Port = 587; // TLS only
	$mail->SMTPSecure = 'tls'; // ssl is depracated
	$mail->SMTPAuth = true;
	$mail->Username = 'mrugadre3004@gmail';
	$mail->Password = 'semester@2';
	$mail->setFrom($from, $from);
	$mail->addAddress($to, $to);
	$mail->isHTML(true);
	
	
	$mail->Subject = $subject;
	$mail->Body = $body;
	$mail->AltBody = 'HTML messaging not supported';
	//$mail->addAttachment($attachment, $attachment);


	if(!$mail->send()){
		echo "Mailer Error: " . $mail->ErrorInfo;
	}else{
		echo "Message sent!";
	}	
}


?>