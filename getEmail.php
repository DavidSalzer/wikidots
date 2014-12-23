<?php
	require_once("PHPMailer_5.2.4/class.phpmailer.php");
	
	$mail = new PHPMailer();
	$mail->CharSet = 'UTF-8';

	
	$mail->SetFrom('<no-reply@wikidot.com>', 'wikidot');
	$mail->AddAddress("ldaniel@cambium.co.il");
	$mail->AddAddress("elad@pixidigital.com");
	
	$mail->Subject  = "message from wikidot";
	$mail->Body     = $_POST["message"];
	$mail->WordWrap = 50;
	
	if(!$mail->Send()) {
		echo 0;
		//echo 'Mailer error: ' . $mail->ErrorInfo;
	} else {
		echo 1;
	}