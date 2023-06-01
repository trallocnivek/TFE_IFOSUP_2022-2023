<?php
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

	$data = json_decode(file_get_contents("php://input"));

	$table_users = [
		'id', 'pseudo_id', 'email_id', 'firstname_id', 'lastname_id', 'password',
		'picture_id', 'birthday_id', 'address_id', 'group_id',
		'account_type_id', 'lang_id', 'status_id', 'auth_id', 'ip_id', 'tel_id', 'gsm_id',
		'conditions', 'token', 'active', 'description',
		'last_connexion', 'created_at', 'updated_at'
	];
	$table_pseudo = ['id', 'pseudo'];
	$table_email = ['id', 'email'];
	$table_name = ['id', 'name'];
	$table_url = ['id', 'name', 'url', 'auth_id', 'target', 'description'];
	$table_birthday = ['id', 'date'];
	$table_address = ['id', 'type_id', 'street_id', 'number', 'bte', 'town_id'];
	$table_street_type = ['id', 'type', 'abvr', 'description'];
	$table_street = ['id', 'street'];
	$table_town = ['id', 'town', 'abvr', 'postal_code', 'land_id', 'district_id', 'description'];
	$table_ = [];

	$table_group = [];
	$table_account_type = [];
	$table_lang = [];
	$table_status = [];
	$table_authorization = [];
	$table_ip = [];
	$table_tel = [];
	$table_gsm = [];
?>