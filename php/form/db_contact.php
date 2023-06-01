<?php
	echo 'db_contact';
	var_dump($_POST);
	$blacklist = [
		'eric.jones.z.mail@gmail.com',
		'dillonstanton905051@gmail.com'
	];
	if(!empty($_POST['subject']) && !empty($_POST['name']) && !empty($_POST['email']) && !empty($_POST['msg'])){
		if(in_array($_POST['email'], $blacklist)){
			$header = 'contact'; $msg_type = 'warning'; $msg_txt = 'blacklisted';
			header('location: ' . $site->redirect($header, $msg_type . '=' . $msg_txt));
			exit();
		}
		try{
			$boundary = md5(uniqid(microtime(), TRUE));
			$from = $_POST['email'];
			$priority = '1';
			$trans_encode = '8bit';
			$email_header = '';
			$email_header .= 'Mime-Version: 1.0' . "\r\n";
			$email_header .= 'Content-Type: multipart/mixed;boundary=' . $boundary . "\r\n";
			$email_header .= 'From: ' . $from . "\r\n";
			$email_header .= 'Content-Transfert-Encoding: ' . $trans_encode . "\r\n";
			$email_header .= 'X-Priority: ' . $priority . "\r\n";
			$email_header .= 'X-Mailer: PHP/' . phpversion() . "\r\n";
			$email_header .= 'Date: ' . date("D, d M Y h:s:i") . "+0200\r\n";
			$email_message = "--" . $boundary . "\r\n" . $_POST['msg'] . "--" . $boundary . "--";

			// $uid = md5(uniqid(time()));
			// $header = "From: ".$from_name." <".$from_mail.">\r\n";
			// $header .= "Reply-To: ".$replyto."\r\n";
			// $header .= "MIME-Version: 1.0\r\n";
			// $header .= "Content-Type: multipart/mixed; boundary=\"".$uid."\"\r\n\r\n";
			// $header .= "This is a multi-part message in MIME format.\r\n";
			// $header .= "--".$uid."\r\n";
			// $header .= "Content-type:text/plain; charset=iso-8859-1\r\n";
			// $header .= "Content-Transfer-Encoding: 7bit\r\n\r\n";
			// $header .= $message."\r\n\r\n";
			// $header .= "--".$uid."\r\n";
			// $header .= "Content-Type: application/octet-stream; name=\"".$filename."\"\r\n"; // use different content types here
			// $header .= "Content-Transfer-Encoding: base64\r\n";
			// $header .= "Content-Disposition: attachment; filename=\"".$filename."\"\r\n\r\n";
			// $header .= $content."\r\n\r\n";
			// $header .= "--".$uid."--";

			// var_dump(['contact@swingshift-examen.be', $_POST['subject'], $_POST['msg'], $email_header]);
			// mail('contact@swingshift-examen.be', $_POST['subject'], $_POST['msg'], $email_header);
			mail('contact.swingshift@gmail.com', $_POST['subject'] . ' ' . $_POST['name'], $_POST['msg'], $email_header);
			$header = 'contact'; $msg_type = 'success'; $msg_txt = 'send_email';
			header('location: ' . $site->redirect($header, $msg_type . '=' . $msg_txt));
		}catch(EXception $e){
			var_dump($e);
			$header = 'contact'; $msg_type = 'error'; $msg_txt = 'send_email';
			header('location: ' . $site->redirect($header, $msg_type . '=' . $msg_txt));
		}
	}else{
		echo 'error: no send email !';
		$header = 'contact'; $msg_type = 'error'; $msg_txt = 'invalide_data';
		header('location: ' . $site->redirect($header, $msg_type . '=' . $msg_txt));
	}
?>