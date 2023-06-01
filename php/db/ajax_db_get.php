<?php
	include_once '../function/functions.php';
	include_once '../trait/db_utils.trait.php';
	// include_once '../class/Config.class.php';
	// include_once '../class/DB.class.php';
	// include_once '../class/CRUD.class.php';
	// include_once '../class/Site.class.php';

	// AUTO LOAD CLASS PHP
	spl_autoload_register(function($x){
		if(!class_exists($x)) require_once "../class/" . $x . ".class.php";
	});

	$config = new Config(false, false, true);
	$db_class = new DB(true);
	$db = $db_class->get('db');
	$crud = new CRUD;
	$site = new Site(true);

	// $post = json_decode(file_get_contents("php://input"));
	// $post->table;

	$data = 'aucun';
	
	if(url_data('table') == 'gallery_img'){
		/* 
			URLS: [
				0 => undefined, 
				42 => img/musician/sax/Michel_B.jpg, 
				45 => img/musician/trumpet/Jean-Marie.jpg, 
				56 => ?mode=admin&page=gestion_diary,
				65 => img/gallery/2014/20_ans_swingshift_big_band/0a0e8516a4-SWING SHIFT BIGBAND 2014-6368.jpg
			]
		*/
	
		/**
		 * @description DB->get_gallery(gallery_id, active) => return a list of images in select gallery
		 */

		$db_elem = url_data('table');

		$data = $crud->call($db, $db_elem, ['procedure_type' => 'get', 'data' => ['gallery_id' => url_data('id'), 'active' => 1]]);

		array_multisort(array_column($data, 'order_list'), SORT_ASC, $data);

		$inc = 1;
		$data_count = count($data);

		$data = array_map(function($e){
			global $site;
			return [
				'url' => !empty($e['web_img_id']) || !empty($e['full_url_id']) 
					? $site->url(!empty($e['web_img_id']) ? (int) $e['web_img_id'] : (int) $e['full_url_id']) 
					: ''
				,
				'order' => !empty($e['order_list']) ? $e['order_list'] : $data_count + $inc++,
				'description' => $site->txt($e['description'])
			];
		}, $data);
	
	} 

	else $data = null;

	echo json_encode($data);
	exit;
?>