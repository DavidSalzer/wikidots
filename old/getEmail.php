<?php
	require_once("PHPMailer_5.2.4/class.phpmailer.php");
	
	$mail = new PHPMailer();
	$mail->CharSet = 'UTF-8';

	
	//$mail->SetFrom('<no-reply@wikidot.com>', 'wikidot');
	$mail->AddAddress("ldaniel@cambium.co.il");
	$mail->AddAddress("elad@pixidigital.com");
	
	$mail->Subject  = "message from wikidot";
	$mail->Body     = "type: " . $_POST["type"]."\n\r";
	$mail->Body     .= "email: " . $_POST["email"]."\n\r";
	$mail->Body     .= "feedback: " . $_POST["feedback"]."\n\r";
	$mail->WordWrap = 50;
	
	if(!$mail->Send()) {
		echo 0;
		//echo 'Mailer error: ' . $mail->ErrorInfo;
	} else {
		echo 1;
	}