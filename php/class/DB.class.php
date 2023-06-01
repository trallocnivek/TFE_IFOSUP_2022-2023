<?php
	/**
	 * @class DB
	 * @description gestion DB connexion
	 * @property
	 * [public]
	 * [protected]
	 *  - $db_config
	 *  - $db_infos
	 *  - $db
	 * [private]
	 *  - $msg
	 *  - $error
	 *  - $success
	 * @method
	 * [public]
	 * 	- __construct()
	 *  - get()
	 *  - msg()
	 * [protected]
	 * [private]
	 *  - connect()
	 * 	- disconnect()
	 *  - set()
	 *  - get_db()
	 * @uses class [Config]
	 * @api DB
	 * @version 2021/01/18 TO 12H14
	 */
	class DB extends Config{
		// PROPERTIES ZONE
		/**
		 * @property $db_config
		 * @see protected
		 * @var array
		 * @description PDO DB config
		 */
		protected $db_config;
		/**
		 * @property $db_infos
		 * @see protected
		 * @var array
		 * @description PDO DB infos connexion
		 */
		protected $db_infos;
		/**
		 * @property $db
		 * @see protected
		 * @var object
		 * @description db object
		 */
		protected $db;
		/**
		 * @property $msg
		 * @see private
		 * @var boolean
		 * @description active debug msg
		 */
		private $msg = true;
		/**
		 * @property $error
		 * @see private
		 * @var array
		 * @description error msg
		 */
		private $error;
		/**
		 * @property $success
		 * @see private
		 * @var array
		 * @description success msg
		 */
		private $success;
		// MAGIC METHODS ZONE
		/**
		 * @method __construct() init instanceof DB
		 * @see public
		 * @uses config.ini, Config
		 * @return void()
		 */
		public function __construct($ajax = false){
			if(class_exists('Config')){
				if((bool) $ajax) parent::db_set('ajax', true);
				self::set('msg', parent::get('debug'));
				self::set('db_config', parent::get('ini', 'DB_CONFIG'));
				self::set('db_infos', parent::get('ini', 'DB_INFOS'));
				self::connect();
			}else{
				$this->error['construct'][] = 'DB ERROR [no-class] : Config_not_exist !';
			}
		}
		// INIT ZONE
		/**
		 * @method connect()
		 * @description connexion to DB via PDO
		 * @compatibility mysql
		 * @see private
		 * @return void() $this->db = new PDO()
		 * @uses PDO
		 */
		private function connect(){
			// var_dump($this->db_infos['server']);
			try{
				$this->db = new PDO(
					  $this->db_infos['server'] . ":" 
					. "host=" . $this->db_infos['host'] 
					. (!empty($this->db_infos['port']) ? ";port=" . $this->db_infos['port'] : '')
					. ";dbname="
						. (!empty($this->db_config['prefix_dbname']) ? $this->db_config['prefix_dbname'] : '')
						. $this->db_infos['dbname']
						. (!empty($this->db_config['suffix_dbname']) ? $this->db_config['suffix_dbname'] : '')
					. (!empty($this->db_infos['charset']) ? ";charset=" . $this->db_infos['charset'] : '')
					
					, $this->db_infos['login']
					, $this->db_infos['password']
					, $this->db_infos['options']
				);
				$this->success['connect'][] = 'DB SUCCESS [db-connexion] : db_connect !';
			}catch(PDOException $e){
				$this->error['connect'][] = 'DB ERROR [db-connexion] : db_no_connect !';
			}
			//self::msg();
		}
		/**
		 * @method disconnect()
		 * @description db->close()
		 * @see private
		 * @return void() $this->db = null
		 */
		private function disconnect(){
			$this->db = null;
		}
		// SET ZONE
		/**
		 * @method set(string $attr, multi $v)
		 * @description generic call set property
		 * @see private
		 * @param string $attr $this->attribute_name
		 * @param multi $v value
		 * @return void()
		 */
		private function set(string $attr, $v){
			if(property_exists(__CLASS__, $attr)) $this->$attr = $v;
			else $this->error['attributes'][] = 'DB ERROR [no-attribute] : ' . $attr . ' !';
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
		 * @method get_db()
		 * @description return PDO connexion object
		 * @see private
		 * @return object $this->db
		 */
		private function get_db(){
			return $this->db;
		}
		// DEBUG ZONE
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