<!--
	
		/$$$$$$$$\ 	  $$\   /$$\   $$\   $$\   $$\   $$\   /$$$$$\      $$\   /$$$$$$$$\    /$$$$$$$$\    $$\   $$\   $$\   $$$$$$$$\   $$$$$$$$$$\	
		$$/ ______|	  $$ |  $$$	|  $$ |  $$ |  $$ |  $$ |  $$ /\$$\     $$ |  $$/ ______|   $$/ ______|   $$ |  $$ |  $$ |  $$  _____|  \___$$  ___|
		$$\|          $$ |  $$$	|  $$ |  $$ |  $$ |  \__|  $$ | \$$\    $$ |  $$ |          $$\|          $$ |  $$ |  \__|  $$ |            $$ |    
		\$$$$$$$$\\	  $$ |  $$$	|  $$ |  $$ |  $$ |  $$ |  $$ |  \$$\   $$ |  $$ | $$$$$\   \$$$$$$$$\\   $$$$$$$$ |  $$ |  $$$$$$\         $$ |    
		 \_____\$$ |  $$ |  $$$	|  $$ |  $$ |  $$ |  $$ |  $$ |   \$$\  $$ |  $$ | \_\$$ |   \_____\$$ |  $$  __$$ |  $$ |  $$  ___|        $$ |    
		       /$$ |  $$ |  $$$	|  $$ |  $$ |  $$ |  $$ |  $$ |    \$$\/$$ |  $$ |   /$$ |         /$$ |  $$ |  $$ |  $$ |  $$ |            $$ |    
		/$$$$$$$$/ |  \$$$$$$ $$$$$$$ |  \$$$$$$/ |  $$ |  $$ |     \$$$$/ |  $$$$$$$$$/ |  /$$$$$$$$/ |  $$ |  $$ |  $$ |  $$ |            $$ |    
		\_________|	  \_____/\_______|   \________|  \__|  \__|      \_____|  \_________|   \_________|   \__/  \__/  \__|  \__|            \__|    

		$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$\ 
		\___________________________________________________________________________________________________________________________________________/

						$$$$$$$\   $$\   /$$$$$$$$\  		    $$$$$$$\   $$$$$$$$\   /$$$$$\      $$\   $$$$$$$\     $$\  
						$$  __$$|  $$ |  $$/ ______| 		    $$  __$$|  $$  __$$ |  $$ /\$$\     $$ |  $$  __$$\    $$ | 
						$$ |  $$|  \__|  $$ |        		    $$ |  $$|  $$ |  $$ |  $$ | \$$\    $$ |  $$ |   $$    $$ | 
						$$$$$$$\   $$ |  $$ | $$$$$\ 		    $$$$$$$\   $$$$$$$$ |  $$ |  \$$\   $$ |  $$ |   $$    $$ | 
						$$  __$$|  $$ |  $$ | \_\$$ |		    $$  __$$|  $$  __$$ |  $$ |   \$$\  $$ |  $$ |   $$    \__/ 
						$$ |  $$|  $$ |  $$ |   /$$ |		    $$ |  $$|  $$ |  $$ |  $$ |    \$$\/$$ |  $$ |  $$|    $$\  
						$$$$$$$/|  $$ |  $$$$$$$$$/ |		    $$$$$$$/|  $$ |  $$ |  $$ |     \$$$$/ |  $$$$$$$/|    $$ | 
						\_______/  \__|  \_________| 		    \_______/  \__/  \__/  \__|      \_____|  \_______/    \__/ 
	                                                                                                                        
						$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$\ 
						\__________________________________________________________________________________________________/
	
-->
<!-- 
	@HTML site index
	@SITE SwingShift Big Band
	@DOMAIN http://www.swingshift.be
	@AUTHORS Collart Kevin
	@VERSION 2021/01/15 TO 17H50
-->
<?php
	// FORM MODE OBSELETE ?
	if(isset($_POST['action']) || isset($_GET['action'])){
		// var_dump(['INFOS_POST', $_POST]);
		//if(isset($_POST['page']) && !empty($_POST['page'])) $GLOBALS['form_type'] = $_POST['page'];
		//else if(isset($_GET['page']) && !empty($_GET['page'])) $GLOBALS['form_type'] = $_GET['page'];
	}
	
	// AUTO LOAD CLASS PHP
	spl_autoload_register(function($x){
		if(!class_exists($x)) require_once "./php/class/" . $x . ".class.php";
	});
	
	// CONFIG CLASS
	$config = new Config;
	
	// DEFINE ROOT
	define('ROOT_DIR', '' . $config->get('ini', 'ROOT')['ROOT'] . '');
	if($config->get('ini', 'SERVER')['host'] == 'localhost'){
		define('ROOT', $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . ROOT_DIR . DIRECTORY_SEPARATOR);
	}else if($config->get('ini', 'SERVER')['host'] == 'OVH'){
		define('ROOT', $_SERVER['HTTP_HOST']);
	}else{
		define('ROOT', $_SERVER['DOCUMENT_ROOT']);
	}
	
	// PAGES OK
	$ok_pages = ['', 'home', 'group', 'diary', 'demos', 'contact', 'conditions', 'db_contact', 'admin', 'gallery', 'technical'];
	$no_mode = ['admin'];
	$dir_ok = ['img', 'sound'];

	/*if(!in_array(url_data('page'), $ok_pages) || in_array(url_data('mode'), $no_mode)){
		// header('Location: https://swingshift.be');
		header('Location: ./');
	}*/
	/*if(
		in_array(preg_replace("/^(https?:\/\/swingshift.be)(\/)([a-zA-Z0-9]+){1}(.*)?/", '$3', $_SERVER['PHP_SELF']), $dir_ok)
		|| preg_match("/^https?:\/\/swingshift.be\/?(\?[a-z0-9_-]+=[a-z0-9_-]+)?(\&[a-z0-9_-]+=[a-z0-9_-]+)*$/i", $_SERVER['PHP_SELF'])
	){}
	else header('Location: https://swingshift.be');*/

	// SESSION DEFINE ROOT
	if(!isset($_SESSION['ROOT']) && empty($_SESSION['ROOT'])) $_SESSION['ROOT'] = ROOT;
	
	// INSTANCES CLASS PHP
	$db_class = new DB;
	$db = $db_class->get('db');
	
	$site = new Site;
	$user = new Users;
	$secu = new Security;
	$valid = new Validity;
	$date = new Date;
	$page = new Page;

	// var_dump($_SESSION);
	
	// SIGN OUT AND SESSION DESTROY
	if(url_data('action') === 'destroy') $user->sign_out();

	// TICKET FOR FORMS
	$tiket_page = ['db_register', 'db_login'];
	if(!in_array(url_data('page'), $tiket_page)) $secu->ticket();
	
	// unset($_SESSION['']);
?>

<!-- FORM MODE -->
<?php if(preg_match("/^(db_|ajax_)/", url_data('page'))): ?>
	<?php	
		switch(url_data('page')){
			case 'db_register': include_once "./php/form/db_register.php";  break;
			case 'db_login': 	include_once "./php/form/db_login.php"; 	break;
			case 'db_contact': 	include_once "./php/form/db_contact.php"; 	break;
			case 'db_sheet': 	include_once "./php/form/db_sheet.php"; 	break;
			// case 'db_contact': 	include_once "./php/form/db_news.php"; 	break;
			case 'ajax_regexp': include_once "./php/form/ajax_regexp.php"; 	break;
			case 'db_admin_site': include_once "./php/form/db_admin_site.php"; 	break;
			// case 'ajax_admin': 	include_once "./php/form/ajax_admin.php"; 	break;
			// case 'ajax_db_get': include_once "./php/db/ajax_db_get.php"; 	break;
			// default: ROOT . "http_error.php?err=404&page=" . url_data('page'); login_log
		}
	?>

<!-- SITE MODE -->
<?php else: ?>	
	<!DOCTYPE html>
	<!--html lang="< ?=$site->get('attr', 'site_infos')['LANG'];?>"-->
	<html lang="<?=$_SESSION['lang'];?>">
		<head>
			<?=$site->get('meta');?>
			<?=$site->get('title');?>
			<?=$site->get('favicon');?>
			<!-- CSS -->
			<!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css"> -->
			<!--link rel="stylesheet" href="https://use.fontawesome.com/release/v5.7.2/css/all.css"-->
			
			<?php $site->get('php', 'reset_css');?>
			<!-- < ?=$site->include_file('css');?> -->
			<?=$site->include_file('css-main');?>
			<!-- JS -->
			<?=$site->include_file('js');?>
			<?=$site->include_file('js_page_start', url_data('page'));?>
		</head>
		<body>
			<?php
				// VAR_DUMP()
				// ----------
					// var_dump(headers_list());
					/*var_dump(['SERVER' => [
						'ADDR' => $_SERVER['SERVER_ADDR'],
						'NAME' => $_SERVER['SERVER_NAME'],
						'HTTP_HOST' => $_SERVER['HTTP_HOST'],
						'HTTPS' => $_SERVER['HTTPS'],
						'SERVER_INI' => $config->get('ini', 'SERVER')['host']
					]]);*/
				
				// TODO SITE:
				// ----------
					$site->get('layout', 'layout');
					echo $site->get('noscript');
	
				// DEBUGS:
				// -------
					// $config->msg();
					// $db_class->msg();
					// $site->msg();
					// $user->msg();
					// $secu->msg();
					// $valid->msg();
					// $date->msg();
					// $page->msg();
			?>
			<?=$site->include_file('js-main');?>
			<?=$site->include_file('js_page_end', url_data('page'));?>
		</body>
	</html>
<?php endif; ?>