<?php
	/**
	 * @class Validity
	 * @description validation of forms and html construction of messages for fields to be tested
	 * @property
	 * 	[private]
	 * 	 - $error
	 * 	 - $success
	 * 	 - $regexp
	 * @method
	 * [public]
	 * 	- __construct()
	 * 	- set()
	 * 	- get()
	 * 	- is()
	 * 	- msg()
	 * [protected] => null
	 * [private]
	 *  - get_regexp()
	 *  - is_captcha()
	 *  - is_conditions()
	 *  - is_email()
	 *  - is_confirm()
	 *  - is_firstname()
	 *  - is_lastname()
	 *  - is_password()
	 *  - is_pseudo()
	 *  - is_login()
	 * @uses trait [], class [Config], function [url_data]
	 * @api FORMS
	 * @version 2020/07/28 to 08h26
	 */
	class Validity extends Config{
		// PROPERTIES ZONE
		/**
		 * @property $error
		 * @see private
		 * @var array
		 */
		private $error;
		/**
		 * @property $error
		 * @see private
		 * @var array
		 */
		private $success;
		/**
		 * @property $regexp
		 * @see private
		 * @var array
		 * @uses config.ini
		 */
		private $regexp;
		/**
		 * @property $msg
		 * @see private
		 * @var boolean
		 * @uses config.ini
		 */
		private $msg;
		// MAGIC METHODS ZONE
		/**
		 * @method __construct() init instanceof Validity
		 * @description initialize class instance
		 * @see  public
		 * @uses config.ini, Config
		 */
		public function __construct(){
			if(class_exists('Config')){
				self::set('msg', parent::get('debug'));
				self::set('regexp', parent::get('ini', 'REGEXP'));
			}else{
				$this->error['class'][] = 'Validity ERROR [no-class] : Config !';
			}
		}
		// SET ZONE
		/**
		 * @method set(string $attr, multi $v)
		 * @description generic set class property value
		 * @param string $attr $this->attribute_name
		 * @param multi $v    value
		 * @return  void
		 */
		public function set(string $attr, $v){
			if(property_exists(__CLASS__, $attr)) $this->$attr = $v;
			else $this->error['attributes']['set'][] = 'Validity ERROR [no-attribute] : ' . $attr . ' !';
		}
		// GET ZONE
		/**
		 * @method get(string $f [, multi $p = null])
		 * @description generic call get method
		 * @see public
		 * @param string $f no 'get_' function name
		 * @param multi $p function param [optional]
		 * @return method self::{'get_' . $f}($p)
		 */
		public function get(string $f, $p = null){
			if(method_exists(__CLASS__, 'get_' . $f)) return self::{'get_' . $f}($p);
			else $this->error['methods'][] = 'Validity ERROR [no-method] : get_' . $f . ' !';
		}
		/**
		 * @method get_regexp(string $key)
		 * @description get all regexp in config.ini
		 * @see private
		 * @param  string $key table key
		 * @return string  regexp string
		 * @uses config.ini
		 */
		private function get_regexp($key){
			return $this->regexp[$key];
		}
		// IS ZONE
		/**
		 * @method is(string $f [, multi $p = null])
		 * @description generic call is method
		 * @see public
		 * @param string $f no 'get_' function name
		 * @param multi $p function param [optional]
		 * @return method self::{'get_' . $f}($p)
		 */
		public function is($f, $p = null){
			if(method_exists(__CLASS__, 'is_' . $f)) return self::{'is_' . $f}($p);
			else $this->error['methods'][] = 'Validity ERROR [no-method] : is_' . $f . ' !';
		}
		/**
		 * @method is_firstname()
		 * @description verif is valid firstname
		 * @see private
		 * @return boolean
		 * @uses Config, config.ini
		 */
		private function is_firstname(){
			return preg_match("{$this->regexp['firstname']}", url_data('firstname'));
		}
		/**
		 * @method is_lastname()
		 * @description verif is valid lastname
		 * @see private
		 * @return boolean
		 * @uses Config, config.ini
		 */
		private function is_lastname(){
			return preg_match("{$this->regexp['lastname']}", url_data('lastname'));
		}
		/**
		 * @method is_email()
		 * @description verif is valid email
		 * @see private
		 * @return boolean
		 * @uses Config, config.ini
		 */
		private function is_email(){
			return preg_match("{$this->regexp['email']}", url_data('email', true));
		}
		/**
		 * @method is_password()
		 * @description verif is valid password
		 * @see private
		 * @return boolean
		 * @uses Config, config.ini
		 */
		private function is_password(){
			$min = parent::get('ini', 'SECURITY')['password_length']['min'];
			$max = parent::get('ini', 'SECURITY')['password_length']['max'];
			$pass = url_data('password');
			if(strlen($pass) >= $min && strlen($pass) <= $max){
				if(preg_match("{$this->regexp['password']}", $pass)) return true;
			}else return false;
		}
		/**
		 * @method is_confirm()
		 * @description verif is valid confirm password
		 * @see private
		 * @return boolean
		 * @uses Config, config.ini
		 */
		private function is_confirm(){
			return url_data('confirm') == url_data('password');
		}
		/**
		 * @method is_captcha()
		 * @description verif is valid captcha code
		 * @see private
		 * @return boolean
		 * @uses Config, config.ini, $_SESSION
		 */
		private function is_captcha(){
			return $_SESSION['code'] == url_data('captcha');
		}
		/**
		 * @method is_conditions()
		 * @description verif is valided accept legals conditions 
		 * @see private
		 * @return boolean
		 * @uses Config, config.ini
		 */
		private function is_conditions(){
			return url_data('conditions') == 'on';
		}
		/**
		 * @method is_pseudo([ $pseudo = null, $regexp = null ])
		 * @description verif is valid pseudo
		 * @see public
		 * @param  string  $pseudo value for testing [optional]
		 * @param  regexp  $regexp regexp string [optional]
		 * @return boolean
		 */
		public function is_pseudo($pseudo = null, $regexp = null){
			if(!empty($pseudo) && !empty($regexp)){
				return preg_match("{$regexp}", $pseudo);
			}else if(!empty(url_data('pseudo'))){
				return preg_match("{$this->regexp['pseudo']}", url_data('pseudo', true));
			}else{
				return false;
			}
		}
		/**
		 * @method is_login()
		 * @description verif is valid email OR valid pseudo
		 * @see private
		 * @return boolean
		 * @uses Config, config.ini
		 */
		private function is_login(){
			if(preg_match("{$this->regexp['email']}", url_data('email', true))){
				return true;
			}else if(preg_match("{$this->regexp['pseudo']}", url_data('pseudo', true))){
				return true;
			}else{
				return false;
			}
		}
		// DEBUG ZONE !
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