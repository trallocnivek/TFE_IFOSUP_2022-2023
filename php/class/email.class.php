<?php
	/**
	 * @class email
	 * @description build email
	 * @property
	 * 	[private]
	 * @method
	 * [public]
	 * 	- __construct()
	 * [public][static]
	 * [protected] => null
	 * [private] => null
	 * @uses class [HTML, JSON, Site], global [$site]
	 * @api EMAIL
	 * @version 2020/07/04 to 08h25
	 *
	 * contact mail: contact@swingshift-examen.be
	 * newsletter mail: no-reply_news@swingshift-examen.be
	 * admin contact mail: admin@swingshift-examen.be
	 */
	class email{
		private $boudary;
		private $from = 'no-reply_news@swingshift-examen.be';
		private $to = '';
		private $subject = 'SwingShift Big Band';
		private $sub_subject = ['contact', 'news', 'admin', 'object'];
		private $headers = [];
		private $attachment = [];
		public function __construct(){}
		public function set(){}
		public function get(){}
		public function set_boundary(){
			$this->$boudary = md5(uniqid(microtime(), TRUE));
		}
		private function set_headers(array $data, $type = 'base', $attachment = false){
			if(in_array($type, ['base', 'html'])){
				$headers['From'] = 'From: ' . $data['From']['name'] . ' <' . $data['From']['mail'] . '>';
				$headers['Reply'] = 'Reply-To: ' . $data['Reply'];
				$headers['To'] = 'To: ' . $data['To'];
				$headers['Cc'] = 'Cc: ' . $data['Cc'];
				$headers['Bcc'] = 'Bcc: ' . $data['Bcc'];

			}
			if($type == 'html'){
				$headers['Mime'] = 'MIME-Version: 1.0';
				$headers['ContentType'] = 'Content-Type: text/html; charset=UTF-8';

			}

			if(!empty($attachment)){
				$headers['AttachmentType'] = 'application/octet-stream';
				$headers['Attachment'] = 'Content-Disposition: attachment; filename=';
				$headers['Mime'] = 'MIME-Version: 1.0';
				$headers['ContentTypeAttachment'] = 'Content-Type: multipart/mixed; boundary="==Multipart_Boundary_x' . md5(uniqid(microtime(), TRUE)) . 'x"';

			}
				$headers['XMailer'] = 'X-Mailer: PHP/' . phpversion();
				// $headers[''] = '';
				$headers['Encode'] = 'Content-Transfer-Encoding: 8bit';
				$headers['Date'] = 'Date: ' . date("r (T)");
				$headers['Sensitivity'] = 'Sensitivity: ' . $data['Sensitivity'];
				$headers['uid'] = '--' . $data['uid'] . '--';
			$this->headers = $headers;
		}
		private function set_subject(string $subject){
			$this->subject = htmlspecialchars($subject);
		}
		private function set_message(string $msg){
			$this->message = preg_replace("/<\/?script>/i", "[ SCRIPT ZONE ]", wordwrap($msg, 70, "\r\n"));
		}
		private function set_attachment($file_url){
			$file = fopen($file_url, 'rb');
			$data = fread($file, filesize($file_url));
			fclose($file);
		}
		private function get_email(string $type){
			
		}
		private function send_mail(string $type = 'news'){
			switch(strtolower($type)){
				case 'news': $email_list = self::get_email('news');
			}
			foreach($email_list as $k => $v){
				if(mail($v['to'], $v['subject'], $v['message'], implode(" \r\n", $this->headers))){
					$this->$success[] = 'SEND EMAIL [ ' . $v['to'] . ' ] !!!';
				}else{
					$this->$error[] = 'NO SEND EMAIL [ ' . $v['to'] . ' ] !!!';
				}
			}
		}
		// DEBUG ZONE
		/**
		 * @method msg()
		 * @description debug messages
		 * @see public
		 * @return var_dump($this->error)
		 */
		public function msg(){
			if($this->msg){
				if(!empty($this->error)) var_dump($this->error);
				if(!empty($this->success)) var_dump($this->success);
			}
		}
	}
	function mail_attachment($filename, $path, $mailto, $from_mail, $from_name, $replyto, $subject, $message) {
		$file = $path.$filename;
		$file_size = filesize($file);
		
		$handle = fopen($file, "r");
		$content = fread($handle, $file_size);
		fclose($handle);
		
		$content = chunk_split(base64_encode($content));
		$uid = md5(uniqid(time()));
		
		$header = "From: ".$from_name." <".$from_mail.">\r\n";
		$header .= "Reply-To: ".$replyto."\r\n";
		$header .= "MIME-Version: 1.0\r\n";
		$header .= "Content-Type: multipart/mixed; boundary=\"".$uid."\"\r\n\r\n";
		$header .= "This is a multi-part message in MIME format.\r\n";
		$header .= "--".$uid."\r\n";
		$header .= "Content-type:text/plain; charset=iso-8859-1\r\n";
		$header .= "Content-Transfer-Encoding: 7bit\r\n\r\n";
		$header .= $message."\r\n\r\n";
		$header .= "--".$uid."\r\n";
		$header .= "Content-Type: application/octet-stream; name=\"".$filename."\"\r\n"; // use different content types here
		$header .= "Content-Transfer-Encoding: base64\r\n";
		$header .= "Content-Disposition: attachment; filename=\"".$filename."\"\r\n\r\n";
		$header .= $content."\r\n\r\n";
		$header .= "--".$uid."--";
		
		if (mail($mailto, $subject, "", $header)) {
			echo "mail send ... OK"; // or use booleans here
		} else {
			echo "mail send ... ERROR!";
		}
	}
	$headers[] = 'From: <Kadoremi.com>';
?>
<?php
/*
    ********************************************************************************************
    CONFIGURATION
    ********************************************************************************************
*/
// destinataire est votre adresse mail. Pour envoyer à plusieurs à la fois, séparez-les par une virgule
$destinataire = 'METTRETONEMAIL';
 
// copie ? (envoie une copie au visiteur)
$copie = 'oui'; // 'oui' ou 'non'
 
// Messages de confirmation du mail
$message_envoye = "Votre message nous est bien parvenu !";
$message_non_envoye = "L'envoi du mail a échoué, veuillez réessayer SVP.";
 
// Messages d'erreur du formulaire
$message_erreur_formulaire = "Vous devez d'abord <a href=\"vue/contactUs.php\">envoyer le formulaire</a>.";
$message_formulaire_invalide = "Vérifiez que tous les champs soient bien remplis et que l'email soit sans erreur.";
 
/*
    ********************************************************************************************
    FIN DE LA CONFIGURATION
    ********************************************************************************************
*/
 
// on teste si le formulaire a été soumis
if (!isset($_POST['envoi']))
{
    // formulaire non envoyé
    echo '<p>'.$message_erreur_formulaire.'</p>'."\n";
}
else
{
    /*
     * cette fonction sert à nettoyer et enregistrer un texte
     */
    function Rec($text)
    {
        $text = htmlspecialchars(trim($text), ENT_QUOTES);
        if (1 === get_magic_quotes_gpc())
        {
            $text = stripslashes($text);
        }
 
        $text = nl2br($text);
        return $text;
    };
 
    /*
     * Cette fonction sert à vérifier la syntaxe d'un email
     */
    function IsEmail($email)
    {
        $value = preg_match('/^(?:[\w\!\#\$\%\&\'\*\+\-\/\=\?\^\`\{\|\}\~]+\.)*[\w\!\#\$\%\&\'\*\+\-\/\=\?\^\`\{\|\}\~]+@(?:(?:(?:[a-zA-Z0-9_](?:[a-zA-Z0-9_\-](?!\.)){0,61}[a-zA-Z0-9_-]?\.)+[a-zA-Z0-9_](?:[a-zA-Z0-9_\-](?!$)){0,61}[a-zA-Z0-9_]?)|(?:\[(?:(?:[01]?\d{1,2}|2[0-4]\d|25[0-5])\.){3}(?:[01]?\d{1,2}|2[0-4]\d|25[0-5])\]))$/', $email);
        return (($value === 0) || ($value === false)) ? false : true;
    }
 
    // formulaire envoyé, on récupère tous les champs.
    $nom     = (isset($_POST['nom']))     ? Rec($_POST['nom'])     : '';
    $email   = (isset($_POST['email']))   ? Rec($_POST['email'])   : '';
    $objet   = (isset($_POST['objet']))   ? Rec($_POST['objet'])   : '';
    $message = (isset($_POST['message'])) ? Rec($_POST['message']) : '';
 
    // On va vérifier les variables et l'email ...
    $email = (IsEmail($email)) ? $email : ''; // soit l'email est vide si erroné, soit il vaut l'email entré
 
    if (($nom != '') && ($email != '') && ($objet != '') && ($message != ''))
    {
        // les 4 variables sont remplies, on génère puis envoie le mail
        $headers  = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'From:'.$nom.' <'.$email.'>' . "\r\n" .
            'Reply-To:'.$email. "\r\n" .
            'Content-Type: text/plain; charset="utf-8"; DelSp="Yes"; format=flowed '."\r\n" .
            'Content-Disposition: inline'. "\r\n" .
            'Content-Transfer-Encoding: 7bit'." \r\n" .
            'X-Mailer:PHP/'.phpversion();
 
        // envoyer une copie au visiteur ?
        if ($copie == 'oui')
        {
            $cible = $destinataire.';'.$email;
        }
        else
        {
            $cible = $destinataire;
        };
 
        // Remplacement de certains caractères spéciaux
        $message = str_replace("&#039;","'",$message);
        $message = str_replace("&#8217;","'",$message);
        $message = str_replace("&quot;",'"',$message);
        $message = str_replace('<br>','',$message);
        $message = str_replace('<br />','',$message);
        $message = str_replace("&lt;","<",$message);
        $message = str_replace("&gt;",">",$message);
        $message = str_replace("&amp;","&",$message);
 
        // Envoi du mail
        $num_emails = 0;
        $tmp = explode(';', $cible);
        foreach($tmp as $email_destinataire)
        {
            if (mail($email_destinataire, $objet, $message, $headers))
                $num_emails++;
        }
 
        if ((($copie == 'oui') && ($num_emails == 2)) || (($copie == 'non') && ($num_emails == 1)))
        {
            echo '<p>'.$message_envoye.'</p>';
        }
        else
        {
            echo '<p>'.$message_non_envoye.'</p>';
        };
    }
    else
    {
        // une des 3 variables (ou plus) est vide ...
        echo '<p>'.$message_formulaire_invalide.' <a href="vue/contactUs.php">Retour au formulaire</a></p>'."\n";
    };
}; // fin du if (!isset($_POST['envoi']))
?>
<?php
    $headers  = "From: testsite < mail@testsite.com >\n";
    $headers .= "Cc: testsite < mail@testsite.com >\n"; 
    $headers .= "X-Sender: testsite < mail@testsite.com >\n";
    $headers .= 'X-Mailer: PHP/' . phpversion();
    $headers .= "X-Priority: 1\n"; // Urgent message!
    $headers .= "Return-Path: mail@testsite.com\n"; // Return path for errors
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/html; charset=iso-8859-1\n";
?>
<?php
if($_POST['button'] && isset($_FILES['attachment'])) 
{ 
  
    $from_email         = 'sender@abc.com'; //from mail, sender email addrress 
    $recipient_email    = 'recipient@xyz.com'; //recipient email addrress 
      
    //Load POST data from HTML form 
    $sender_name    = $_POST["sender_name"] //sender name 
    $reply_to_email = $_POST["sender_email"] //sender email, it will be used in "reply-to" header 
    $subject        = $_POST["subject"] //subject for the email 
    $message        = $_POST["message"] //body of the email 
      
  
    /*Always remember to validate the form fields like this 
    if(strlen($sender_name)<1) 
    { 
        die('Name is too short or empty!'); 
    }  
    */
      
    //Get uploaded file data using $_FILES array 
    $tmp_name    = $_FILES['my_file']['tmp_name']; // get the temporary file name of the file on the server 
    $name        = $_FILES['my_file']['name'];  // get the name of the file 
    $size        = $_FILES['my_file']['size'];  // get size of the file for size validation 
    $type        = $_FILES['my_file']['type'];  // get type of the file 
    $error       = $_FILES['my_file']['error']; // get the error (if any) 
  
    //validate form field for attaching the file 
    if($file_error > 0) 
    { 
        die('Upload error or No files uploaded'); 
    } 
  
    //read from the uploaded file & base64_encode content 
    $handle = fopen($tmp_name, "r");  // set the file handle only for reading the file 
    $content = fread($handle, $size); // reading the file 
    fclose($handle);                  // close upon completion 
  
    $encoded_content = chunk_split(base64_encode($content)); 
  
    $boundary = md5("random"); // define boundary with a md5 hashed value 
  
    //header 
    $headers = "MIME-Version: 1.0\r\n"; // Defining the MIME version 
    $headers .= "From:".$from_email."\r\n"; // Sender Email 
    $headers .= "Reply-To: ".$reply_to_email."\r\n"; // Email addrress to reach back 
    $headers .= "Content-Type: multipart/mixed;\r\n"; // Defining Content-Type 
    $headers .= "boundary = $boundary\r\n"; //Defining the Boundary 
          
    //plain text  
    $body = "--$boundary\r\n"; 
    $body .= "Content-Type: text/plain; charset=ISO-8859-1\r\n"; 
    $body .= "Content-Transfer-Encoding: base64\r\n\r\n";  
    $body .= chunk_split(base64_encode($message));  
          
    //attachment 
    $body .= "--$boundary\r\n"; 
    $body .="Content-Type: $file_type; name=".$file_name."\r\n"; 
    $body .="Content-Disposition: attachment; filename=".$file_name."\r\n"; 
    $body .="Content-Transfer-Encoding: base64\r\n"; 
    $body .="X-Attachment-Id: ".rand(1000, 99999)."\r\n\r\n";  
    $body .= $encoded_content; // Attaching the encoded file with email 
      
    $sentMailResult = mail($recipient_email, $subject, $body, $headers); 
  
    if($sentMailResult )  
    { 
       echo "File Sent Successfully."; 
       unlink($name); // delete the file after attachment sent. 
    } 
    else
    { 
       die("Sorry but the email could not be sent. 
                    Please go back and try again!"); 
    } 
} 
?>