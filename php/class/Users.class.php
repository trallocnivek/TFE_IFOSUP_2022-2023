<?php
	/**
	 * 
	 * @class Users
	 * @description bases actions fors a simple user
	 * @property
	 * [protected]
	 *  - $DB_tables
	 *  - $prefix_table
	 *  - $table_name
	 *  - $table
	 *  - $infos
	 *  - $cols
	 * [private]
	 *  - $type
	 *  - $msg
	 *  - $error
	 *  - $success
	 * @method
	 * [public]
	 * 	- __construct()
	 * 	- sign_in()
	 * 	- sign_out()
	 * 	- sign_up()
	 * 	- get()
	 * [protected]
	 * [private]
	 *  - get_cols()
	 *  - sql_login()
	 *  - hash_pass()
	 *  - verif_pass()
	 * @uses trait [db_utils], class [Config, Site], function [msg]
	 * @api USERS_SESSION
	 * @version 2020/07/28 to 14h45
	 */
	class Users extends Config{
		// PROPERTY ZONE
		/**
		 * @property $DB_tables
		 * @see protected
		 * @var array
		 * @description DB tables list
		 */
		protected $DB_tables;
		/**
		 * @property $prefix_table
		 * @see protected
		 * @var string
		 * @description prefix table DB
		 */
		protected $prefix_table;
		/**
		 * @property $table_name
		 * @see protected
		 * @var string
		 * @description table name DB
		 */
		protected $table_name;
		/**
		 * @property $table
		 * @see protected
		 * @var string
		 * @description $prefix_table . $table_name
		 */
		protected $table;
		/**
		 * @property $infos
		 * @var array
		 * @see protected
		 * @description users infos
		 */
		protected $infos;
		/**
		 * @property $cols
		 * @var array
		 * @see protected
		 * @description DB columns user_table DB
		 */
		protected $cols;
		/**
		 * @property $type
		 * @var string
		 * @see private
		 * @description user type
		 */
		private $type = 'user';
		/**
		 * @property $msg
		 * @see private
		 * @var boolean || string
		 * @description active debug msg
		 */
		private $msg = true;
		/**
		 * @property $error
		 * @see private
		 * @var array
		 * @description error msg
		 */
		public $error;
		/**
		 * @property $success
		 * @see private
		 * @var array
		 * @description success msg
		 */
		public $success;
		// USE ZONE
		/**
		 * @uses trait db_utils
		 * @description db_utils.trait.php
		 */
		use db_utils;
		// MAGIC METHOD ZONE
		/**
		 * @method __construct()
		 * @see public
		 * @uses config.ini Config
		 */
		public function __construct(){
			if(class_exists('Config')){
				self::set('msg', parent::get('debug'));
				self::set('infos', parent::get('users_infos'));
				self::set('prefix_table', parent::get('ini', 'DB_CONFIG')['prefix_table']);
				self::set('DB_tables', parent::get('ini', 'DB_TABLES'));
				self::set('table_name', parent::get('ini', 'DB_TABLES')['users']['DB_TABLE']);
				self::set('table', $this->prefix_table . $this->table_name);
				//$this->cols = $this->get('cols', $this->table);
			}else{
				$this->error[] = 'Users ERROR : Config_not_exist';
			}
		}
		// SIGN ZONE
		/**
		 * @method sign_in()
		 * @see public
		 * @description user login
		 * @param string $login input email or pseudo
		 * @param string $pass input password
		 * @param string $type type of input entry
		 * @return boolean
		 */
		public function sign_in(string $login, string $pass, string $type){
			global $valid;
			$table_type_1 = $this->prefix_table . parent::get('ini', 'DB_TABLES')['pseudo']['DB_TABLE'];
			$table_type_2 = $this->prefix_table . parent::get('ini', 'DB_TABLES')['email']['DB_TABLE'];
			$table_lang = $this->prefix_table . parent::get('ini', 'DB_TABLES')['lang']['DB_TABLE'];
			$table_auth = $this->prefix_table . parent::get('ini', 'DB_TABLES')['authorizations']['DB_TABLE'];
			if(self::if_exist($table_type_1, 'pseudo', $login)) $type = 'pseudo';
			else if(self::if_exist($table_type_2, 'email', $login)) $type = 'email';
			$table_type = $this->prefix_table . parent::get('ini', 'DB_TABLES')[$type]['DB_TABLE'];
			if(self::if_exist($table_type, $type, $login)){
				echo 'SUCCESS USER EXIST !<br>';
				if(self::verif_pass($login, $pass, $type)){
					echo 'SUCCESS USER PASSWORD OK !<br>';
					$user = parent::get('users_infos', $login);
					$sql = self::sql_login($login, $type);
					$exec = ['login' => $login];
					$data = self::request($sql, $exec, 'fetch');
					if(!empty($data['active'])){
						$_SESSION['user']['id'] = $data['id'];
						$_SESSION['user']['pseudo'] = $data['pseudo_id'];
						$_SESSION['user']['firstname'] = $data['firstname_id'];
						$_SESSION['user']['lastname'] = $data['lastname_id'];
						$_SESSION['user']['email'] = $data['email_id'];
						$_SESSION['user']['account'] = $data['account_type_id'];
						$_SESSION['user']['img'] = $data['picture_id'];
						$_SESSION['user']['auth'] = $data['auth_id'];
						// lang
						$sql_lang = "SELECT abvr FROM $table_lang WHERE id = :id AND active = 1 LIMIT 1";
						$exec_lang = ['id' => $data['lang_id']];
						// authorization
						$sql_type = "SELECT auth FROM $table_auth WHERE id = :id LIMIT 1";
						$exec_type = ['id' => $data['auth_id']];
						// execute
						$data_lang = self::request($sql_lang, $exec_lang, 'fetch');
						$data_type = self::request($sql_type, $exec_type, 'fetch');
						$_SESSION['user']['lang'] = !empty($data_lang['abvr']) ? $data_lang['abvr'] : 'nl';
						$_SESSION['user']['type'] = $data_type['auth'];
						return true;
					}else $_SESSION['error'] = 'user_banned';
				}else $this->error['signin'][] = 'invalid_pass';
			}else $this->error['signin'][] = 'no_exist';
			return false;
		}
		/**
		 * @method sign_up(array $elem, [boolean $error = true])
		 * @see public
		 * @description new user register
		 * @param  array  $elem  list of register elements
		 * @param  boolean $error if error => no sign up
		 * @return boolean
		 */
		public function sign_up(array $elem, bool $error = true){
			global $valid;
			if(!$error){
				$_SESSION['register'] = null;
				$_SESSION['errors']['register'] = null;
				$cond = false;
				if(!self::if_exist('email', 'email', url_data('email', true))
					&& $valid->is('email')
					&& !empty(url_data('firstname'))
					&& !empty(url_data('lastname'))
					&& $valid->is('password')
					&& strtolower(url_data('conditions')) === 'on'
				){
					$sql1 = 'CALL user_register(:regexp, :firstname, :lastname, :ip, :email, :password, :pseudo, @O_user_id, @O_message)';
					$exec1 = [
						'regexp' => substr(parent::get('ini', 'REGEXP')['email'], 1, -1),
						'firstname' => url_data('firstname'),
						'lastname' => url_data('lastname'),
						'ip' => get_ip(),
						'email' => url_data('email'),
						'password' => self::hash_pass(url_data('password')),
						'pseudo' => url_data('pseudo')
					];
					$data = self::request($sql1, $exec1, 'fetch', false);
					$sql2 = "SELECT @O_user_id AS user, @O_message AS msg";
					$exec2 = [];
					$data = self::request($sql2, $exec2, 'fetch', false);
					if(!empty($data['user']) && strtoupper($data['msg']) == 'SUCCESS'){
						//if((bool) url_data('autoconnect')) self::sign_in($data('user'));
						return true;
					}//else $msg = $data['msg'];
				} return false;
			}else return false;
		}
		/**
		 * @method sign_out()
		 * @see public
		 * @description user log out
		 * @return void()
		 */
		public function sign_out(){
			global $site;
			unset($_SESSION['user']);
			session_destroy();
			header("Location: {$site->redirect('home', 'success=disconnect')}");
			exit;
		}
		// DELETE ZONE
		/**
		 * @method delete($table, $id)
		 * @see private
		 * @description delete id element on table DB
		 * @param string $table table name (config.ini)
		 * @param int || string $id delete id
		 * @return array
		 */
		private function delete(string $table, $id){
			$table_name = parent::get('ini', 'DB_TABLES')[$table]['DB_TABLE'];
			$table = $this->prefix_table . $table_name;
			if(self::if_exist($table, 'id', $id)){
				// $sql = "DELETE FROM $table WHERE id = :id";
				$sql = "UPDATE $table SET active = false WHERE id = :id";
				$exec = ['id' => htmlspecialchars($id)];
				return self::request($sql, $exec);
			}
		}
		// SET ZONE
		/**
		 * @method set(string $attr, multi $v)
		 * @see private
		 * @description generic call set method
		 * @param string $attr $this->attribute_name
		 * @param multi $v value
		 * @return void()
		 */
		private function set(string $attr, $v){
			if(property_exists(__CLASS__, $attr)) $this->$attr = $v;
			else $this->error['attributes'][] = 'Users ERROR [no-attribute] : ' . $attr . ' !';
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
			else $this->error['methods'][] = 'Users ERROR [no-method] : get_' . $f . ' !';
		}
		public function get_users($id){
			$sql = "CALL get_users_infos(:id)";
			$exec = ['id' => htmlspecialchars($id)];
			return self::request($sql, $exec);
		}
		public function get_users_table(){
			$data = self::get_users(0);
			// var_dump($data);
			$data = array_map(function($x){
				$action = HTML::get('tag', [
					['tag' => 'a', 'attr' => ['href' => '?mode=admin&page=gestion_users&action=read&id=' . $x['user_id'], 'class' => 'read_btn'], 'content' => 'read'],
					['tag' => 'a', 'attr' => ['href' => '?mode=admin&page=gestion_users&action=update&id=' . $x['user_id'], 'class' => 'update_btn'], 'content' => 'update'],
					['tag' => 'a', 'attr' => ['href' => '?mode=admin&page=gestion_users&action=delete&id=' . $x['user_id'], 'class' => 'delete_btn'], 'content' => 'delete']
				]);
				return [
					[
						'title' => 'User id : ' . $x['user_id'],
						'onclick' => "location.href = './?mode=admin&page=gestion_users&action=read&id=" . $x['user_id'] . "';"
					],
					'id' => $x['user_id'],
					'pseudo' => $x['user_pseudo'],
					'email' => $x['user_email'],
					'name' => $x['user_name'],
					'auth' => (
						($x['user_auth'] == 'admin') ? '<span class="red bold">admin<span>'
							: (($x['user_auth'] == 'site') ? '<span class="lime bold">site<span>'
								: (($x['user_auth'] == 'newsletter') ? '<span class="dodgerblue bold">newsletter<span>'
									: (($x['user_auth'] == 'user') ? '<span class="orange bold">user<span>'
										: (($x['user_auth'] == 'group') ? '<span class="yellow bold">group<span>' 
											: (($x['user_auth'] == 'grant') ? '<span class="aqua bold">grant<span>' 
												: '<span class="grey bold">non defini<span>'
											)
										)
									)
								)
							)
						),
					'ip' => $x['user_ip'],
					'banned' => (bool) $x['user_banned'] ? '<span class=red>banned</span>' : '<span class=lime>clean</span>',
					'status_ip' => (bool) $x['ip_status'] ? '<span class=lime>active</span>' : '<span class=red>close</span>',
					'active' => (bool) $x['active'] ? '<span class=lime>YES</span>' : '<span class=red>NO</span>',
					'create' => $x['user_create'],
					'update' => $x['user_update'],
					'connexion' => $x['last_connexion'],
					'action' => $action
				];
			}, $data);
			// var_dump($data);
			$list = ['id', 'pseudo', 'email', 'name', 'auth', 'ip', 'banned', 'status_ip', 'active', 'create', 'update', 'connexion', 'action'];
			foreach($list as $v) $headers[] = ['list' => $v, 'content' => /*self::txt('word_user_table_' . */$v/*)*/];
			return HTML::get('tag', ['tag' => 'h2', 'attr' => [], 'content' => /*self::txt('page/admin_users')*/'users list'])
				. HTML::table([], [
					'header' => [
						'content' => [$headers]
					],
					'body' => [
						'attr' => [
							'class' => 'pointer',
							'onmouseenter' => "Tools.css(this, 'backgroundColor', '#FFFFFF33');",
							'onmouseleave' => "Tools.css(this, 'backgroundColor', 'transparent');"
						],
						'content' => $data
					]
				])
			;
		}
		/**
		 * @method get_debug()
		 * @description return debug mode
		 * @see private
		 * @return boolean
		 * @uses config.ini
		 */
		private function get_debug(){
			return parent::get('debug');
		}
		/**
		 * @method sql_login()
		 * @see private
		 * @description build sql selector for login
		 * @param  [type] $login [description]
		 * @return string sql select email or pseudo 
		 */
		private function sql_login($login, $type){
			$col_type_id = $type . '_id';
			$table_type = $this->prefix_table . parent::get('ini', 'DB_TABLES')[$type]['DB_TABLE'];
			$sql = "SELECT * FROM $this->table WHERE $col_type_id = (SELECT id FROM $table_type WHERE $type = :login LIMIT 1) LIMIT 1";
			return $sql;
		}
		/**
		 * @method get_type()
		 * @see private
		 * @description user type
		 * @return string
		 */
		private function get_type(){
			return isset($_SESSION['user']['type']) ? $_SESSION['user']['type'] : 'site';
		}
		private function get_id(){
			return $_SESSION['user']['id'];
		}
		public function is_admin(){
			return self::get_type() == 'admin' || self::get_type() == 'grant';
		}
		// PASSWORD ZONE
		/**
		 * @method hash_pass(string $pass)
		 * @see private
		 * @description password for hash with salt
		 * @param  string $pass user password
		 * @return string hashed password
		 */
		private function hash_pass(string $pass){
			$secu_pass_salt = parent::get('ini', 'SECURITY')['password_salt'];
			$secu_pass_hash = parent::get('ini', 'SECURITY')['password_hash'];
			$prefix = isset($secu_pass_salt['prefix']) ? (string) $secu_pass_salt['prefix'] : '';
			$midfix = isset($secu_pass_salt['midfix']) ? (string) $secu_pass_salt['midfix'] : '';
			$suffix = isset($secu_pass_salt['suffix']) ? (string) $secu_pass_salt['suffix'] : '';
			if((bool) $secu_pass_salt['active']){
				$length = strlen($pass);
				$prepass = substr($pass, 0, $length / 2);
				$sufpass = substr($pass, $length / 2, $length);
				$password = $prefix . $prepass . $midfix . $sufpass . $suffix;
				return password_hash($password, PASSWORD_DEFAULT, ['cost' => 12]);	
			}else{
				$password_hash = password_hash($pass, PASSWORD_DEFAULT, ['cost' => 12]);
				$length = strlen($password_hash);
				$prepass = substr($password_hash, 0, $length / 2);
				$sufpass = substr($password_hash, $length / 2, $length);
				$password = $prefix . $prepass . $midfix . $sufpass . $suffix;
				return $password;
			}
		}
		/**
		 * @method verif_pass(string $pass)
		 * @see private
		 * @description password verification
		 * @param  string $login user login
		 * @param  string $pass user password
		 * @param  boolean $salt_hash if hash salt activated
		 * @return boolean
		 */
		private function verif_pass($login, $pass, $type){
			$secu_pass_salt = parent::get('ini', 'SECURITY')['password_salt'];
			$secu_pass_length = parent::get('ini', 'SECURITY')['password_length'];
			$secu_pass_hash = parent::get('ini', 'SECURITY')['password_hash'];
			$sql = $this->sql_login($login, $type);
			$exec = ['login' => htmlspecialchars($login)];
			$req = $this->request($sql, $exec, 'fetch');
			$prefix = isset($secu_pass_salt['prefix']) ? (string) $secu_pass_salt['prefix'] : '';
			$midfix = isset($secu_pass_salt['midfix']) ? (string) $secu_pass_salt['midfix'] : '';
			$suffix = isset($secu_pass_salt['suffix']) ? (string) $secu_pass_salt['suffix'] : '';
			if((bool) $secu_pass_salt['active']){
				$length = strlen($pass);
				$prepass = substr($pass, 0, $length / 2);
				$sufpass = substr($pass, $length / 2, $length);
				$password = $prefix . $prepass . $midfix . $sufpass . $suffix;
				if(password_verify($password, $req['password'])) return true;
				else $this->error['verif_password'][] = 'false_pass';
			}else{
				$db_pass = $req['password'];
				if(!empty($prefix)) $db_pass = preg_replace("/^{$prefix}$/", '', $db_pass);
				if(!empty($midfix)) $db_pass = preg_replace("/^{$midfix}$/", '', $db_pass);
				if(!empty($suffix)) $db_pass = preg_replace("/^{$suffix}$/", '', $db_pass);
				if(password_verify($pass, $db_pass)) return true;
				else $this->error['verif_password'][] = 'false_pass';
			} return false;
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