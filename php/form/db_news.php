<?php
	echo 'db_news';
	var_dump($_POST);
	if(!empty($_POST['subject']) && !empty($_POST['name']) && !empty($_POST['email']) && !empty($_POST['msg'])){
		try{
			$boundary = md5(uniqid(microtime(), TRUE));
			$priority = '1';
			$trans_encode = '8bit';
			$to = 'trallocnivek@gmail.com';
			// $from = $_POST['email'];
			$from = 'contact.swingshift@gmail.be';
			$subject = 'SWINGSHIFT BIG BAND NEWSLETTER !';
			$headers = 'Mime-Version: 1.0' . "\r\n";
			$headers .= 'Content-Type: multipart/mixed;boundary=' . $boundary . "\r\n";
			$headers .= 'From: ' . $from . "\r\n";
			$headers .= 'Content-Transfert-Encoding: ' . $trans_encode . "\r\n";
			$headers .= 'X-Priority: ' . $priority . "\r\n";
			$headers .= 'X-Mailer: PHP/' . phpversion() . "\r\n";
			$headers .= 'Date: ' . date("D, d M Y h:s:i") . "+0200\r\n";
			// mail('contact@swingshift-examen.be', $_POST['subject'], $_POST['msg'], $email_header);
			// $message = '---' . $boundary . "\r\n";
			$message = 'Content-type: text/html; charset=utf-8'."\r\n\r\n";
			$message .= '
	<htmL>
	<main>
		<h1>Informations</h1>
		<p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Odio a incidunt cumque excepturi nesciunt, libero sit vero ullam quaerat quod voluptates pariatur quis officiis praesentium accusamus voluptate, magnam numquam ducimus.</p>
		<article id="contact_localisation">
			
		</article>
	</main>
	<footer>
		<a href="./?page=profil&user=1">Votre compte newsletter</a> - <a href="./?page=unsubscribe&mail=1">Se désabonné</a>
	</footer></html>' . "\r\n";
			// $message .= '---' . $boundary . "\r\n";
			mail($to, $subject, $message, $headers/*, $parameters*/);
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
<!-- <html lang="fr">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>SwingShift Big Band Newsletter</title>
	<style media="all">
		*{
			font-family: Arial, sans-serif;
		}
		body{
			margin: 0.5rem;
		}
		a, footer a{
			color: lightgrey;
			text-decoration: none;
			transition: color 1s ease-in-out;
		}
		a:hover, footer a:hover{
			color: white;
		}
		header, footer{
			background-color: black;
		}
		header{
			position: relative;
			padding: 1rem;
		}
		header div{
			display: inline-block;
			position: relative;
		}
		header #logo{
			width: 7.5%;
		}
		header img{
			width: 100%;
		}
		header #meta{
			position: absolute;
			bottom: 0;
			right: 0;
			padding: 0 1rem;
			color: lightgrey;
			font-size: 0.8rem;
		}
		main{
			margin: 0 auto; 
			width: 80%;
		}
		footer{
			background-color: black; 
			color: white; 
			text-align: center; 
			padding: 1rem 0.5rem; 
			vertical-align: middle;
		}
	</style>
</head>
<body> -->