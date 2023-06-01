<?php
	/**
	 * @version 2020/08/04 TO 16H16
	 */
	$form_input = [
		'firstname', 'lastname', 'email', 'password', 'confirm', 'captcha', 'conditions'
	];
	$register = [
		'firstname', 'lastname', 'email', 'ip', 'user'
	];
	// var_dump($_SERVER);
	// var_dump(status());
	// var_dump($_SESSION);
	$error = true;
	if($secu->verif_HTTP_REFERER('sign_up')){
		echo '' . PHP_EOL;
		echo "SUCCESS HTTP_REFERER !<br>";
		if($secu->verif_token()){
			echo 'SUCCESS TOKEN !<br>';
			if($secu->verif_ticket()){
				echo 'SUCCESS TICKET !<br>';
				if(if_exist('url_data', $form_input, false)){
					echo 'SUCCESS URL_DATA !<br>';
					foreach($form_input as $v){
						if($valid->is($v)){ 
							echo 'SUCCESS ' . strtoupper($v) . ' !<br>';
							$error = false;
						}else{
							$error = true;
							echo 'ERROR ' . strtoupper($v) . ' !<br>';
							$type_error = $v;
							break;
						}
					}
					if((bool) $user->sign_up($register, $error)){
						echo 'SUCCESS ' . strtoupper('register') . ' !<br>';
						$header = 'sign_in'; $msg_type = 'success'; $msg_txt = 'register';
					}else{
						echo 'ERROR ' . strtoupper('no_register') . ' !<br>';
						$header = 'sign_up'; $msg_type = 'error'; $msg_txt = 'no_register-' . (!empty($type_error) ? $type_error : 'user');
					}
				}else{
					echo 'ERROR URL_DATA !<br>';
					$header = 'sign_up'; $msg_type = 'error'; $msg_txt = 'url_data';
				}
			}else{
				echo 'ERROR TICKET !<br>';
				$header = 'sign_up'; $msg_type = 'error'; $msg_txt = 'ticket';
			}
		}else{
			echo 'ERROR TOKEN !<br>';
			$header = 'sign_up'; $msg_type = 'error'; $msg_txt = 'token';
		}
	}else{
		echo "ERROR HTTP_REFERER !<br>";
		$header = 'sign_up'; $msg_type = 'error'; $msg_txt = 'http_referer';
	}
	header("Location:" . $site->redirect($header, $msg_type . '=' . $msg_txt));
	exit();
?>