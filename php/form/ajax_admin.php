<?php
	/**
	 * @POST
	 * 	- data_type [task]
	 * 	- action [add, update, delete, read]
	 * 	- user [user_id]
	 * 	- name [TXT]
	 * 	- description [TXT]
	 */

	include_once '../function/functions.php';
	include_once '../trait/db_utils.trait.php';

	// AUTO LOAD CLASS PHP
	spl_autoload_register(function($x){
		if(!class_exists($x)) require_once "../class/" . $x . ".class.php";
	});

	$config = new Config(false, false, true);
	$db_class = new DB(true);
	$db = $db_class->get('db');
	$crud = new CRUD;
	$site = new Site(true);
	$admin = new Admin();

	$data = json_decode(file_get_contents("php://input"));
	$data_get = $_GET;

	// var_dump(['data' => $data, 'get' => $data_get]);

	$valid_elem = ['task', 'site', 'diary', 'gallery', 'music_sheet', 'users', 'members', 'news'];

	if(!empty($data) && in_array($data->data_type, $valid_elem)) $json = $admin->db($data->data_type, $data->action, $data, $data->bool ?? false);
	else if(!empty($data_get) && in_array($data_get['data_type'], $valid_elem)) $json = $admin->db($data_get['data_type'], $data_get['action'], $data_get, $data_get['bool'] ?? false);
	else $json = ['error' => 'no_valid_data'];

	echo json_encode($json);
	exit;
?>