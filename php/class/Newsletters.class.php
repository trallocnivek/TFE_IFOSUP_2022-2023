<?php
	/**
	 * @class Newsletters
	 * @description system of newsletters
	 * @property
	 * 	[private]
	 * @method
	 * [public]
	 * 	- __construct()
	 * [public][static]
	 * 	- send()
	 * 	- get_list()
	 * 	- unsubscribe()
	 * 	- subscribe()
	 * 	- desinscription()
	 * 	- inscription()
	 * 	- form()
	 * [protected] => null
	 * [private] => null
	 * @uses trait [], class [], function [url_data], global [$config], define [ROOT_DIR], $_SESSION, $_POST, $_COOKIE, file [config.ini]
	 * @api NEWSLETTERS
	 * @version 2020/07/04 to 08h25
	 */
	class Newsletters{
		public function __construct(){
			/*
				db
				table newsletters
				colonnes id email_id status create_at update_at
			*/
		}
		public static function form(){
			return '
				La newsletter :
				<form method="post" action="index.php?email=1">
					Adresse e-mail : <input type="text" name="email" size="25" /><br />
					<input type="radio" name="new" value="0" />S\'inscrire
					<input type="radio" name="new" value="1" />Se désinscrire<br />
					<input type="submit" value="Envoyer" name="submit" /> 
					<input type="reset" name="reset" value="Effacer" />
				</form>
			';
		}
		public static function inscription(){
			$email = $_POST['email'];
			$message = 'Pour valider votre inscription à la newsletter du site SwingShift.be, <a href="http://www.swingshift.be?page=newsletter&action=inscription&email=' . $email . '">Cliquer içi</a>.';
			$destinataire = $email;
			$object = 'inscription à la newsletter.';
			$header = 'MIME-Version: 1.0' . "\r\n";
			$header .= 'Content-type: text/html; charset=utf-8' . "\r\n";
			$header .= 'From: no-reply@swingshift.be' . "\r\n";
			if(mail($destinataire, $object, $message, $header)){
				echo "Pour valider votre inscription, veuillez cliquer sur le lien dans l'email que nous venons de vous envoyer.";
			}else{
				echo "Il y a eu une erreur lors de l'envoi du mail pour votre inscription.";
			}
		}
		public static function desinscription(){
			$email = $_POST['email'];
			$message = 'Pour valider votre désinscription à la newsletter du site SwingShift.be, <a href="http://www.swingshift.be?page=newsletter&action=desinscription&email=' . $email . '">Cliquer içi</a>.';
			$destinataire = $email;
			$object = 'désinscription à la newsletter.';
			$header = 'MIME-Version: 1.0' . "\r\n";
			$header .= 'Content-type: text/html; charset=utf-8' . "\r\n";
			$header .= 'From: no-reply@swingshift.be' . "\r\n";
			if(mail($destinataire, $object, $message, $header)){
				echo "Pour valider votre désinscription, veuillez cliquer sur le lien dans l'email que nous venons de vous envoyer.";
			}else{
				echo "Il y a eu une erreur lors de l'envoi du mail pour votre désinscription.";
			}
		}
		public static function subscribe(){

		}
		public static function unsubscribe(){

		}
		private static function get_list($x = 'all'){
			return $list;
		}
		public static function send(){
			$liste = 'no-reply@swingshift.be';
			foreach($data = self::get_list($x) as $k => $v){
				$liste .= ',' . $data[$v];
			}
			$header = 'MIME-Version: 1.0' . "\r\n";
			$header .= 'Content-type: text/html; charset=utf-8' . "\r\n";
			$header .= 'From: no-reply@swingshift.be' . "\r\n";
			$header .= 'Bcc: ' . $liste . "\r\n";
			$date = date("d/m/Y");
			$object = "SwingShift newsletter " . $date;
			if(mail($liste, $object, $message, $header)){
				echo 'mails envoyé !';
			}else{
				echo "erreur lors de l'envois";
			}
		}
	}
	// Cc = copie carbone -> visible par tous
	// Bcc = Cci = copie carbone invisible -> invisible par tous
?>