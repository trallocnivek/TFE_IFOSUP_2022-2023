<?php
	/**
	 * @class Config
	 * @description config site
	 * @const 
	 * 	- INI_FILE
	 * @property
	 * 	[private]
	 * 	 - $debug
	 * 	 - $mode
	 * 	 - $msg
	 * 	 - $error
	 * 	 - $success
	 * 	 - $regexp [option]
	 * @method
	 * [public]
	 * 	- __construct()
	 * 	- is_prod()
	 * 	- get()
	 * 	- msg()
	 * [protected]
	 * [private]
	 *  - cookie()
	 *  - init()
	 *  - lang()
	 *  - session()
	 *  - set()
	 *  - get_attr()
	 *  - get_debug()
	 *  - get_ini()
	 *  - get_mode()
	 *  - get_msg()
	 *  - get_users_infos()
	 * @uses trait [], class [Config, Site, Users], function [msg], file [config.ini]
	 * @api CONFIG_SITE
	 * @version 2020/07/28 to 08h22
	 */
	class Config{
		// CONSTANTS ZONE
		/**
		 * @const INI_FILE
		 * @description config.ini path
		 * @see public
		 */
		const INI_FILE = './config/config.ini'; // LOCAL DEV (WAMP)
		const INI_FILE_FORM = '../../config/config.ini'; // OVH
		const INI_FILE_AJAX = '../../config/config.ini'; // ajax
		private $form;
		private $ajax;
		// PROPERTIES ZONE
		/**
		 * @property $debug
		 * @see private
		 * @var boolean || string
		 */
		private $debug;
		/**
		 * @property $mode
		 * @see private
		 * @var boolean || string
		 */
		private $mode;
		/**
		 * @property $msg
		 * @see private
		 * @var boolean
		 */
		private $msg = true;
		/**
		 * @property $error
		 * @see private
		 * @var string
		 */
		private $error;
		/**
		 * @property $success
		 * @see private
		 * @var string
		 */
		private $success;
		/**
		 * @property $regexp
		 * @see private
		 * @var array
		 * @uses config.ini
		 */
		private $regexp;
		// MAGIC METHODS ZONE
		/**
		 * @method __construct() init instanceof Config
		 * @description initialization this class
		 * @see public
		 * @return void()
		 * @uses config.ini
		 */
		public function __construct($charge = true, $form = false, $ajax = false){
			// init class
			self::set('form', $form);
			self::set('ajax', $ajax);
			self::set('mode', self::get('mode'));
			self::set('debug', self::get('debug'));
			self::set('msg', self::get('msg'));
			self::set('regexp', self::get('ini', 'REGEXP'));
			// init site
			if($charge){
				self::init();
			}
			self::session();
			self::cookie();
			self::lang();
		}
		// INIT ZONE
		/**
		 * @method cookie()
		 * @description set cookie
		 * @see private
		 * @return void()
		 */
		private function cookie(){
			if((bool) self::get('ini', 'CONFIG')['cookie']) setcookie('swingshift_test_cookies', 'SWING_TEST_COOKIE');
		}
		/**
		 * @method init()
		 * @description initialization site
		 * @see private
		 * @return void()
		 * @uses config.ini
		 */
		private function init(){
			global $form_type;
			// (DES)ACTIVE DEBUG PHP
			if(!$this->debug || ($this->mode == 'prod' && $this->debug) || ($this->mode == 'prod' && !$this->debug)){
				// NO DEBUG
				ini_set("display_errors", false);
				error_reporting(0);
			}else{
				// OK DEBUG
				ini_set("display_errors", -1);
				error_reporting(E_ALL | E_STRICT | E_DEPRECATED | E_PARSE | E_NOTICE | E_CORE_ERROR | E_CORE_WARNING | E_RECOVERABLE_ERROR);
			}
			// DEFINE ROOTDIR FOR FUNCTIONS.PHP
			define('RDN', self::get('ini', 'ROOT')['DOCUMENT_ROOT']);
			// REQUIRE FILES
			require_once (isset($form_type) && !empty($form_type) ? '.' : '') . './php/function/functions.php';
			require_once (isset($form_type) && !empty($form_type) ? '.' : '') . './php/trait/db_utils.trait.php';
			require_once (isset($form_type) && !empty($form_type) ? '.' : '') . './php/class/HTML.class.php';
			// INIT CACHE
			if(! (bool) self::get('ini', 'CONFIG')['cache']) browser_no_cache();
			// INCLUDE FILES
			date_default_timezone_set(self::get('ini', 'CONFIG')['timezone']);
			// INCLUDE FILES
			//include_once (isset($form_type) && !empty($form_type) ? '.' : '') . './trad.php';
		}
		/**
		 * @method lang()
		 * @description set lang
		 * @return void()
		 * @uses config.ini $_SESSION $_COOKIES functions.php
		 */
		private function lang(){
			if(!isset($_SESSION['lang'])) $_SESSION['lang'] = self::get('ini', 'CONFIG')['default_lang'];
			if(isset($_COOKIES['lang'])) $_SESSION['lang'] = $_COOKIES['lang'];
			if(isset($_SESSION['user']['lang'])) $_SESSION['lang'] = $_SESSION['user']['lang'];
			if(url_data('lang') != null) $_SESSION['lang'] = url_data('lang'); 
		}
		/**
		 * @method session()
		 * @description active session
		 * @see private
		 * @return void()
		 * @uses config.ini
		 */
		private function session(){
			$session = self::get('ini', 'CONFIG')['session'];
			if(empty(status()) && $session) session_start();
			if(!empty(status())) $this->success['session'][] = 'Config SUCCESS : SESSION START !';
			else $this->error['session'][] = 'Config ERROR : SESSION NO-START !';
		}
		// IS ZONE
		/**
		 * @method is_prod()
		 * @description for file mode prod or dev
		 * @see public
		 * @return multi [type mode (prod or dev) or null]
		 * @uses config.ini
		 */
		public function is_prod(){
			$mode = self::get('ini', 'MODE')['mode'];
			return $mode == 'prod' ? 'min' : null;
		}
		// SET ZONE
		/**
		 * @method set(string $attr, multi $v)
		 * @description generic call set method
		 * @param string $attr $this->attribute_name
		 * @param multi $v value
		 * @return void()
		 */
		protected function DB_set(string $attr, $v){
			if(property_exists(__CLASS__, $attr)) $this->$attr = $v;
			else $this->error['attributes'][] = 'Config ERROR [no-attribute] : ' . $attr . ' !';
		}
		private function set(string $attr, $v){
			if(property_exists(__CLASS__, $attr)) $this->$attr = $v;
			else $this->error['attributes'][] = 'Config ERROR [no-attribute] : ' . $attr . ' !';
		}
		// GET ZONE
		/**
		 * @method get(string $f [, multi $p = null])
		 * @description generic call get method
		 * @see public
		 * @param string $f function name without 'get_'
		 * @param multi $p function param
		 * @return method self::{'get_' . $f}($p)
		 */
		public function get(string $f, $p = null){
			if(method_exists(__CLASS__, 'get_' . $f)) return self::{'get_' . $f}($p);
			else $this->error['methods'][] = 'DB ERROR [no-method] : get_' . $f . ' !';
		}
		/**
		 * @method get_ini($x)
		 * @description return attribute (property) on this class
		 * @see private
		 * @param string $x attrinute name
		 * @return $this->attr
		 */
		private function get_attr(string $x){
			return $this->$x;
		}
		/**
		 * @method get_debug()
		 * @description return debug mode
		 * @see private
		 * @return boolean
		 * @uses config.ini
		 */
		private function get_debug(){
			return (bool) self::get('ini', 'CONFIG')['debug']; // force bool type
		}
		/**
		 * @method get_ini($x)
		 * @description return config.ini infos
		 * @see private
		 * @param string $x array key
		 * @return array config.ini
		 * @uses config.ini
		 */
		private function get_ini(string $x){
			global $form_type;
			// var_dump(file_exists('../../config/config.ini'));
			$path = (bool) $this->form ? self::INI_FILE_FORM : (bool) $this->ajax ? self::INI_FILE_AJAX : self::INI_FILE;
			if(file_exists((isset($form_type) && !empty($form_type) ? '.' : '') . $path)){
				$data = parse_ini_file((isset($form_type) && !empty($form_type) ? '.' : '') . $path, true);
				// var_dump($data);
				return $data[$x];
			} else $this->error['ini'] = 'Config ERROR [no_file] : config.ini';
		}
		/**
		 * @method get_mode()
		 * @description return mode dev or prod
		 * @see private
		 * @return string mode developpement or production
		 * @uses config.ini
		 */
		private function get_mode(){
			return self::get('ini', 'MODE')['mode'];
		}
		/**
		 * @method get_msg()
		 * @description return debug mode
		 * @see private
		 * @return boolean debug mode
		 * @uses config.ini
		 */
		private function get_msg(){
			return self::get('debug');
		}
		/**
		 * @method get_users_infos()
		 * @description retourne la config user
		 * @see private
		 * @return array base config users
		 */
		private function get_users_infos($login){
			$dir_name = self::get('ini', 'FILE_USERS')['path'];
			$rename_file = self::get('ini', 'FILE_USERS')['rename_file'];
			$security = self::get('ini', 'SECURITY');
			return [$dir_name, $rename_file, $security];
		}
		// DEBUG ZONE !
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
?>