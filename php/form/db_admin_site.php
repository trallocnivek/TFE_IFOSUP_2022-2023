<?php

	/**
	 * C:\Wamp64_23-06-2019\www\GITHUB\SWINGSHIFT_OVH_2023\php\form\db_admin_site.php:3: array (size=8)
  		'page' => string 'db_admin_site' (length=13)
  		'action' => string 'create' (length=6)
  		'token' => string 'fa5a124c972a96c756a2f984f08829606d3e2373f7be411856a290532c37905b' (length=64)
  		'db_elem_title' => string 'test' (length=4)
  		'auth_id' => string '1' (length=1)
  		'url' => string '?page=test' (length=10)
  		'page_active' => string 'on' (length=2)
  		'description' => string 'description test' (length=16)


  		Émis le		mercredi 	26 	avril 	2023 à 09:18:30
		Expire le	mardi 		25 	juillet 2023 à 09:18:29
	 */

  	var_dump('SSL date valid from => ' . date('d-m-Y H:i:s', '1682493510'));
  	var_dump('SSL date valid to => ' . date('d-m-Y H:i:s', '1690269509'));

  	var_dump($_SERVER);
  	var_dump($_SERVER['HTTP_REFERER']);

  	var_dump(headers_list());

  	$user = $_SESSION['user'];

  	if($user['type'] == 'grant' || $user['type'] == 'admin'){

  	}else{
  		header("Location: ./?page=gestion_site&mode=admin&msg=noAuth");
  		exit();
  	}

	// include & require files
  	// $site = ok
  	// $config ) ok
  	$admin = new Admin();


	// data
	$data = array_map(function($x){
		return htmlspecialchars(stripcslashes(trim($x)));
	}, $_POST);
  	
	$_SESSION['POST'] = $data;

  	var_dump($_SESSION);
  	
  	var_dump($admin->site_read(['id' => $_SESSION['user']['id']]));

	if(!isset($data['page_active'])) $data['page_active'] = 'off';
	var_dump($data);

	// var_dump($_COOKIE);
	// var_dump($_SESSION);

	if($_SESSION['token'] == $data['token']){
		var_dump('SECURE FORM AND SESSION');
	}
	/*if(){

	}*/

	// gestion DB
	if(!empty($data['db_elem_title']) && !empty($data['auth_id']) && !empty($data['url'])){
		if(preg_match("/^[a-z0-9_]+$/i", $data['db_elem_title'])){

		}else{

		}
		if(preg_match("/^[1-6]$/", $data['auth_id'])){

		}
		if(preg_match("/^\?page=[a-zA-Z0-9]+(&mode=admin)?(&action=(read|view|update|create|delete))?$/", $data['url'])){

		}
		switch ($data['action']) {
			case 'create':
				// URL INFOS
				$sql = "INSERT INTO swing_url (url, description) VALUES (:url, :descr)";
				$exec = [
					'url' => htmlspecialchars($data['url']),
					'descr' => htmlspecialchars($data['description'])
				];
				// request($sql, $exec);
				// PAGE INFOS
				$sql = "INSERT INTO swing_page (page, auth_id, active) VALUES (:page, :auth, :active)";
				$exec = [
					'page' => htmlspecialchars($data['page']),
					'auth' => htmlspecialchars($data['auth_id']),
					'active' => htmlspecialchars($data['page_active'] == 'on' ? 1 : 0)
				];
				// request($sql, $exec);
			  break;
			case 'read': 
				$sql = "SELECT * FROM swing_page WHERE id = :id";
				$exec = ['id' => htmlspecialchars($data['id'])]; 
			  break;
			case 'update': 
				$sql = "";
				$exec = []; 
			  break;
			case 'delete': 
				$sql = ""; 
				$exec = ['id' => htmlspecialchars($data['id'])]; 
			  break;
		}
	}else{
		header('Location: ./?page=gestion_site&mode=admin&action=create&msg=required');
	}
?>