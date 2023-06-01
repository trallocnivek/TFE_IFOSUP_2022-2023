<?php
// LOCALHOST
	// HTTP_REFERER => http://localhost/GITHUB/SWINGSHIFT_OVH_2023/?mode=admin&page=gestion_site&action=create
	// HTTP_HOST => localhost
	// HTTP_ORIGIN => http://localhost
	// HTTP_SEC_FETCH_SITE => same-origin
	// DOCUMENT_ROOT => C:/Wamp64_23-06-2019/www
	// REQUEST_METHOD => POST || GET
	// CONTENT_TYPE => application/x-www-form-urlencoded
	// REMOTE_ADDR => ::1
	// SERVER_ADDR => ::1
	// 
	
	// REQUEST_SCHEME => http

// OVH
	// HTTP_REFERER => https://swingshift.be/php/infos_server.php
	// HTTP_HOST => swingshift.be
	// HTTP_ORIGIN => https://swingshift.be
	// HTTP_SEC_FETCH_SITE => same-origin
	// DOCUMENT_ROOT => /home/swingst/www
	// REQUEST_METHOD => POST || GET
	// CONTENT_TYPE => application/x-www-form-urlencoded
	// REMOTE_ADDR => 2a02:a03f:c05b:bb00:17fc:6342:71d2:16eb
	// SERVER_ADDR => 10.30.20.144
	// 
	
	// [HTTP_X_FORWARDED_PROTO] => https
	
	// HTTPS => on
	// [USER] => swingst




	// ERRORS
	// ------
	
	$error = [];


	// DATA
	// ----

	$file_get_content = file_get_contents("php://input") ?? false;

	if($_SERVER['REQUEST_METHOD'] == 'POST'){
		$array = $_POST;
	}else if($_SERVER['REQUEST_METHOD'] == 'GET'){
		$query = $_GET;
		$split = split('&', $query);
		$array = [];
		foreach($split as $k => $v){
			$v_split = split("=", $v);
			$array[$v_split[0]] = $v_split[1];
		}
	}else if($file_get_content){
		$array = JSON::decode($file_get_content, true);
	}
	
	$data = array_map(function($x){
		return htmlspecialchars(stripslashes(trim($x)));
	}, $array);


	// SECURITY
	// --------

	$valid = [];
	
	// return array query from HTTP_REFERER
	// ------------------------------------

	
	function get_params_referer(){
		$params = [];
		$split = split("/?", $_SERVER['HTTP_REFERER']);
		$query = split("&", $split[1]);
		foreach($query as $k => $v){
			$split = split("=", $v);
			$params[$split[0]] = $split[1];
		}
		return $params;
	}

	$params_referer = get_params_referer();
	$return_page_error = $params_referer['page'];
	
	function is_admin($x){
		$mode = $x['mode'] ?? null;
		if(!empty($mode)){
			if($mode == 'admin') return true;
		} return false;
	}

	function is_ssl_exists($url){
        $original_parse = parse_url($url, PHP_URL_HOST);
        $get = stream_context_create(array("ssl" => array("capture_peer_cert" => TRUE)));
        $read = stream_socket_client("ssl://" . $original_parse . ":443", $errno, $errstr, 30, STREAM_CLIENT_CONNECT, $get);
        $cert = stream_context_get_params($read);
        $certinfo = openssl_x509_parse($cert['options']['ssl']['peer_certificate']);

        if(isset($certinfo) && !empty($certinfo)){
            if(isset($certinfo['name']) && !empty($certinfo['name']) && $certinfo['issuer'] && !empty($certinfo['issuer'])){
                return true;
            }
            return false;
        }
        return false;
    }

// OVH
	// [HTTP_X_FORWARDED_PROTO] => https
	// HTTPS => on
	// [USER] => swingst	
	
	// HTTP_REFERER => https://swingshift.be/php/infos_server.php
	
	// HTTP_HOST => swingshift.be
	// HTTP_ORIGIN => https://swingshift.be
	// HTTP_SEC_FETCH_SITE => same-origin
	// DOCUMENT_ROOT => /home/swingst/www
	// REQUEST_METHOD => POST || GET
	// CONTENT_TYPE => application/x-www-form-urlencoded
	// REMOTE_ADDR => 2a02:a03f:c05b:bb00:17fc:6342:71d2:16eb
	// SERVER_ADDR => 10.30.20.144
	// 
	

	if(is_admin($params_referer)){
		if(is_ssl_exists('https://www.swingshift.be')){

		} header("Location ./?page=admin&mode=admin&msg=no_ssl");
	}
	
	if($secu->verif_HTTP_REFERER(url_data('page'))) $valid['HTTP_REFERER'] = true;
	if($secu->verif_tocken()) $valid['token'] = true;
	if($secu->verif_ticket()) $valid['ticket'] = true;
	
	if($_SERVER['HTTP_HOST'] == $config->get('ini', 'SERVER')['host']) $valid['HTTP_HOST'] = true;
	if($_SERVER['HTTP_ORIGIN'] == '') $valid['HTTP_ORIGIN'] = true;
	if($_SERVER['HTTP_SEC_FETCH_SITE'] == 'same-origin') $valid['HTTP_SEC_FETCH_SITE'] = true;
	if($_SERVER['REQUEST_SCHEME'] == '') $valid['REQUEST_SCHEME'] = true;
	if($_SERVER['CONTEXT_DOCUMENT_ROOT'] == $_SERVER['DOCUMENT_ROOT']) $valid['CONTEXT_DOCUMENT_ROOT'] = true;
	// if($_SERVER['HTTP_'] == '') $valid['HTTP_'] = true;

	foreach($valid as $k => $v) if(!$v) header("Location ./?page=" . $return_page_error . ($mode ? '&mode=' . $mode : '') . "&msg=" . $v);




	
	if($secu){
		// request_method
		// query_string
		// http_referer
		// verif_token
		// verif_ticket
		// http_connection
		// http_host
		// http_sec_fetch_site
		// context_document_root

		// http_origin
		// request_scheme
	}
	if($valid){
		// is_firstname
		// is_lastname
		// is_email
		// is_password
		// is_confirm
		// is_captcha
		// is_conditions
		// is_pseudo
		// is_login
	}
	if($user){
		// id
		// auth
		// ip
		// mode
		// page
		// action
	}
	if($db){
		// db connected
	}
	if($admin){
		// get type authorization
	}
	if($config){
		// 
	}
	if($lang){
		// lang user
	}
	if($error){
		// return error
	}
	if($data){
		// get data form
	}
	if($action){
		// action form
	}
	if($auth){
		// return authorisation user
	}
	if($regex){
		// search regex list
	}
	if($){}
	if($){}
	if($){}
	if($){}
	if($){}
	if($){}

?>