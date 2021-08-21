<?php  
	
	$to      = explode(',', $_POST['to']);
	//$addBcc  = explode(',', $_POST['bcc']);
	//$addCcc  = explode(',', $_POST['cc']);

	$errorMsg   = 'Hm.. seems there is a problem, sorry!';
	$successMsg = 'Thank you, mail sent successfuly!';

	//$to      = $_POST['to'];
	$addBcc  = $_POST['bcc'];
	$addCcc  = $_POST['cc'];
	$subject = $_POST['subject'];
	$message = $_POST['message'];
	$from 	 = "ibrahimadedayo@rocketmail.com";

	/*$headers1 = "MIME-Version: 1.0" . "\\r\
	";
	/*$headers1 .= "Content-type:text/html;charset=iso-8859-1" . "\\r\
	";*/

	/*$headers1 .= "Content-type:text/html;charset=UTF-8" . "\\r\
	";
	$headers1 .= "From: <support@facebook.com>". "\\r\
	";*/

	//$headers = "From: <> \r\n";
	$headers = "";
	$headers .= 'From: ' . $_POST['companyName'] .' <'.$from.'>'. "\r\n";
	if ($addCcc !== "") {
		$headers .= "Cc:" .$addCcc. "\r\n";
	}
	if ($addBcc !== "") {
		$headers .= "Bcc:" .$addBcc. "\r\n";
	}
	$headers .= "MIME-Version: 1.0\r\n";
	$headers .= "Content-Type: text/html; charset=UTF-8\r\n";

	foreach ($to as $receiver) {
		$mailer = mail($receiver, $subject, $message, $headers);
	}
	if ($mailer) {
		$json_arr = array( "type" => "success", "msg" => $successMsg );
		echo json_encode( $json_arr );
	}else{
		$json_arr = array( "type" => "error", "msg" => $errorMsg );
		echo json_encode( $json_arr );
	}
	
?>