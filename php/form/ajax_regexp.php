<?php
	include_once '../function/functions.php';
	// include_once '../trait/db_utils.trait.php';
	// include_once '../class/Config.class.php';
	// include_once '../class/DB.class.php';
	// include_once '../class/CRUD.class.php';
	// include_once '../class/Site.class.php';

	// AUTO LOAD CLASS PHP
	spl_autoload_register(function($x){
		if(!class_exists($x)) require_once "../class/" . $x . ".class.php";
	});

	// $post = json_decode(file_get_contents("php://input"));
	// $post->regexp;

	$config = new Config(false, true);

	$authorized_value = ['email', 'file', 'firstname', 'lastname', 'login', 'password', 'pseudo'];
	
	if(!empty($_REQUEST['regexp']) && in_array($_REQUEST['regexp'], $authorized_value) && isset($_REQUEST['value'])){
		$type = $_REQUEST['regexp'];
		$value = $_REQUEST['value'];
		$regexp = $config->get('ini', 'REGEXP')[$_REQUEST['regexp']];
		$value_length = strlen($value);
		$min_length = (int) preg_replace("/{/", '', explode(",", preg_replace("/(.+)?(\{.+\})(.+)?/", "$2", $regexp))[0]);
		$max_length = (int) preg_replace("/(.+)}/", "$1", explode(",", preg_replace("/(.+)?(\{.+\})(.+)?/", "$2", $regexp))[1]);
		// ALL
		if($validity->{'is_' . $type}($value, $regexp)){
			$json = [
				'success' => 'true',
				'length' => [
					'min' => $min_length,
					'max' => $max_length,
					'current' => $value_length
				]
			];
		}else{
			// DOC
			if($type == 'doc'){
				// name, ext, type_of_doc(music_sheet, technical_rider, autre)
			}
			// IMG
			if($type == 'img'){
				// name, ext, type_of_img(profil, gallery, affiche, membre de group, autre)
			}
			// SOUND
			if($type == 'sound'){
				// name, ext, type_of_doc(demo, extrait musical pour les membres du group)
			}
			// VIDEO
			if($type == 'video'){
				// name, ext, type_of_doc(demo, extrait musical pour les membres du group)
			}
			// FIRSTNAME
			if($type == 'firstname'){
				// alpha [A-Za-z]
			}
			// LASTNAME
			if($type == 'lastname'){
				// alpha [A-Za-z]
			}
			// EMAIL
			if($type == 'email'){
				// structure, length min/max/current, ext, @, domaine
			}
			// LOGIN
			if($type == 'login'){
				// email => structure, length min/max/current, ext, @, domaine
				// pseudo => just no script value -> sanitize
				// ou autre s'il y a !
			}
			// PASSWORD
			if($type == 'password'){
				// alpha upper/lower, punct, length min/max/current
			}
			// PSEUDO
			if($type == 'pseudo'){
				// just no script value -> sanitize
				$json = ['warning' => []];
				if($value_length == 0){
					$json['warning']['length'] = [
						'min' => $min_length,
						'current' => $value_length
					];
				}
			}
		}
		/*
			if(in_array($_REQUEST['regexp'], ['password'])){
				$min_length = (int) preg_replace("/{/", '', explode(",", preg_replace("/(.+)?(\{.+\})(.+)?/", "$2", $regexp))[0]);
				$max_length = (int) preg_replace("/(.+)}/", "$1", explode(",", preg_replace("/(.+)?(\{.+\})(.+)?/", "$2", $regexp))[1]);

			}
			$punct = preg_match("/[[:punct:]]]/", $value);
			$email_struct = preg_match("/^(.+)@{1}(.+)\.(.{2,6}])$/", $value);
			// $ext_img = preg_match("{$config->get('ini', 'REGEXP')['img']}", $value);
			// $ext_doc = preg_match("{$config->get('ini', 'REGEXP')['doc']}", $value);
			$json = [
				'length' => [
					'min' => $min_length,
					'max' => $max_length,
					'current' => $value_length
				],
				'alpha' => [
					'low' => $alpha_lowcase,
					'up' => $alpha_upcase
				],
				'punct' => $punct,
				'email' => [
					'struct' => $email_struct
				]
			];
		}*/
	}else{
		$json = ['error' => 'Unauthorized value !'];
	}
	
	echo json_encode($json);
?>