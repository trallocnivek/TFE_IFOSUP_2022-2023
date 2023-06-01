<?php
	/**
	 * @class Security
	 * @description system of security
	 * @property
	 * 	[private]
	 * 	 - $secu_infos
	 * 	 - $cookie_infos
	 * 	 - $config_infos
	 * 	 - $ticket_infos
	 * 	 - $cookie_test
	 * 	 - $msg
	 * 	 - $error
	 * 	 - $success
	 * @method
	 * [public]
	 * 	- __construct()
	 * 	- verif_HTTP_REFERER()
	 * 	- is_HTTP_REFERER_active()
	 * 	- test_cookie()
	 * 	- is_cookie_active()
	 * 	- token()
	 * 	- verif_token()
	 * 	- is_token_active()
	 * 	- ticket()
	 * 	- verif_ticket()
	 * 	- is_ticket_active()
	 * 	- get()
	 * 	- msg()
	 * [protected] => null
	 * [private]
	 * 	- set()
	 * 	- get_attr()
	 * 	- get_config()
	 * 	- get_cookie()
	 * 	- get_ticket()
	 * @uses trait [], class [], function [url_data], global [$config], define [ROOT_DIR], $_SESSION, $_POST, $_COOKIE, file [config.ini]
	 * @api FORMS
	 * @version 2020/07/04 to 08h25
	 */
	class Security{
		/**
		 * @property $secu_infos
		 * @see private
		 * @var array
		 */
		private $secu_infos;
		/**
		 * @property $cookies_infos
		 * @see private
		 * @var array
		 */
		private $cookies_infos;
		/**
		 * @property $config_infos
		 * @see private
		 * @var array
		 */
		private $config_infos;
		/**
		 * @property $tocket_infos
		 * @see private
		 * @var array
		 */
		private $ticket_infos;
		/**
		 * @property $cookie_test
		 * @see private
		 * @var array
		 */
		private $cookie_test;
		/**
		 * @property $msg
		 * @see private
		 * @var boolean
		 */
		private $msg = true;
		/**
		 * @property $error
		 * @see private
		 * @var array
		 */
		private $error;
		/**
		 * @property $success
		 * @see private
		 * @var array
		 */
		private $success;
		/**
		 * @method __construct()
		 * @description initialization class instance
		 * @see public
		 * @return void()
		 * @uses config.ini
		 */
		public function __construct(){
			self::get('config');
			self::get('cookie');
			self::get('ticket');
			self::test_cookie();
		}
		// HTTP_REFERER ZONE
		/**
		 * @method verif_HTTP_REFERER(string $page)
		 * @description test HTTP_REFERER
		 * @see public
		 * @param string $page url page name
		 * @return boolean
		 */
		public function verif_HTTP_REFERER(string $page){
			/*$origin = $_SERVER['HTTP_REFERER'];
			$regexp = $_SERVER['HTTP_X_FORWARDED_PROTO'] . ':\/\/' . $_SERVER['HTTP_HOST'] . '\/\?page=' . $page;

			var_dump($_SERVER);
			var_dump(['VALUE' => $_SERVER['HTTP_REFERER'], 'HTTP_CONNECT' => $_SERVER['HTTP_CONNECTION']]);
			$HTTP_REFERER = $_SERVER['REQUEST_SCHEME'] . ':\/\/' . $_SERVER['HTTP_HOST'] . '\/' . ROOT_DIR . '\/\?page=' . $page;
			if(self::is_HTTP_REFERER_active()) return preg_match("#^${HTTP_REFERER}#", $_SERVER['HTTP_REFERER']);
			else return true;*/
			return true;
		}
		/**
		 * @method is_HTTP_REFERER_active()
		 * @description test if HTTP_REFERER is actived
		 * @see public
		 * @return boolean
		 * @uses config.ini
		 */
		public function is_HTTP_REFERER_active(){
			return (bool) $this->secu_infos['http_referer'];
		}
		// COOKIES ZONE
		/**
		 * @method test_cookie()
		 * @description test cookie has activated
		 * @see public
		 * @return void()
		 * @uses config.ini
		 */
		public function test_cookie(){
			if(self::is_cookie_active()){
				if(isset($_COOKIE['swingshift_test_cookies']) && $_COOKIE['swingshift_test_cookies'] == 'SWING_TEST_COOKIE') return $this->cookie_test = true;
				else $this->cookie_test = false;
			}else $this->cookie_test = false;
		}
		/**
		 * @method is_cookie_active()
		 * @description test if cookie is actived
		 * @see public
		 * @return void()
		 * @uses config.ini
		 */
		public function is_cookie_active(){
			return (bool) $this->config_infos['cookie'];
		}
		// TOKEN ZONE
		/**
		 * @method token()
		 * @description create token
		 * @see public
		 * @return void()
		 * @uses config.ini
		 */
		public function token(){
			if(self::is_token_active()){
				$token = bin2hex(random_bytes(32));
				$_SESSION['token'] = $token;
				return "<input type=hidden name=token value=" . $token . ">";
			}
		}
		/**
		 * @method verif_token()
		 * @description validation token
		 * @see public
		 * @return void()
		 * @uses config.ini
		 */
		public function verif_token(){
			if(!self::is_token_active()) return true;
			else return $_SESSION['token'] === $_POST['token'];
		}
		/**
		 * @method is_token_active()
		 * @description test if token is actived
		 * @see public
		 * @return void()
		 * @uses config.ini
		 */
		public function is_token_active(){
			return (bool) $this->secu_infos['token'];
		}
		// TICKET ZONE
		/**
		 * @method ticket()
		 * @description test if cookie is actived
		 * @see public
		 * @return void()
		 * @uses config.ini
		 */
		public function ticket(){
			if(self::is_ticket_active()){
				if(self::is_cookie_active() && self::test_cookie()){
					$cookie_name = $this->cookies_infos['prefix'] . 'ticket';
					$ticket = session_id().microtime().rand(0,9999999999);
					$ticket = hash('sha512', $ticket);
					$expire = (int) $this->ticket_infos['expire'];
					$path = (string) $this->ticket_infos['path'];
					$domain = (string) $this->ticket_infos['domain'];
					$secure = (bool) $this->cookies_infos['secure'];
					$httpOnly = (bool) $this->cookies_infos['http_only'];
					setcookie($cookie_name, $ticket, time() * $expire, $path, $domain, $secure, $httpOnly);
					$_SESSION[$cookie_name] = $ticket;
				}else $this->error['ticket'][] = 'Security ERROR [ticket] : COOKIES NO ACTIVED !';
			}
		}
		/**
		 * @method verif_ticket()
		 * @description test if cookie is actived
		 * @see public
		 * @return void()
		 * @uses config.ini
		 */
		public function verif_ticket(){
			if(self::is_ticket_active()){
				if(self::is_cookie_active()){
					if(self::test_cookie()){
						$key = $this->cookies_infos['prefix'] . 'ticket';
						return $_COOKIE[$key] == $_SESSION[$key];
					}else return false;
				}else return false;
			}else return true;
		}
		/**
		 * @method is_ticket_active()
		 * @description test if cookie is actived
		 * @see public
		 * @return void()
		 * @uses config.ini
		 */
		public function is_ticket_active(){
			return (bool) $this->secu_infos['ticket'];
		}
		// SET ZONE
		/**
		 * @method set(string $attr, multi $v)
		 * @description set class property value
		 * @see private
		 * @param string $attr $this->attribute_name
		 * @param multi $v set value
		 * @return void()
		 */
		private function set(string $attr, $v){
			if(property_exists(__CLASS__, $attr)) $this->$attr = $v;
			else $this->error['attributes']['set'][] = 'Security ERROR [no-attribute] : ' . $attr . ' !';
		}
		// GET ZONE
		/**
		 * @method get(string $f [, multi $p = null])
		 * @see public
		 * @param string $f no 'get_' function name
		 * @param multi $p function param
		 * @return method self::{'get_' . $f}($p)
		 * @description generic call get method
		 */
		public function get(string $f, $p = null){
			if(method_exists(__CLASS__, 'get_' . $f)) return self::{'get_' . $f}($p);
			else $this->error['methods'][] = 'Security ERROR [no-method] : get_' . $f . ' !';
		}
		/**
		 * @method get_attr(string $attr)
		 * @description test if cookie is actived
		 * @see public
		 * @param string $attr class property name
		 * @return void()
		 * @uses config.ini
		 */
		private function get_attr($attr){
			if(property_exists(__CLASS__, $attr)) return $this->$attr;
			else $this->error['attributes']['get'][] = 'Security ERROR [no-attribute] : ' . $attr . ' !';
		}
		/**
		 * @method get_config()
		 * @description test if cookie is actived
		 * @see public
		 * @return void()
		 * @uses config.ini
		 */
		private function get_config(){
			$config = $GLOBALS['config'];
			self::set('config_infos', $config->get('ini', 'CONFIG'));
			self::set('secu_infos', $config->get('ini', 'SECURITY'));
		}
		/**
		 * @method get_cookie()
		 * @description test if cookie is actived
		 * @see public
		 * @return void()
		 * @uses config.ini
		 */
		private function get_cookie(){
			$config = $GLOBALS['config'];
			self::set('cookies_infos', $config->get('ini', 'COOKIES'));
		}
		/**
		 * @method get_ticket()
		 * @description test if ticket is actived
		 * @see public
		 * @return void()
		 * @uses config.ini
		 */
		private function get_ticket(){
			$config = $GLOBALS['config'];
			self::set('ticket_infos', $config->get('ini', 'TICKET'));
		}
		// DEBUG ZONE
		/**
		 * @method msg()
		 * @description debug msg
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