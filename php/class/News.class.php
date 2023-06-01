<?php
	/**
	 * @class News extends Users
	 * @description actions de bases que peut faire un utilisateur de newsletters
	 * @method
	 * [public]
	 * 	- __construct()
	 * [protected]
	 * [private]
	 *  - 
	 * @uses trait [db_utils], class [Config, Site, Users], function [msg]
	 * @api USERS_SESSION
	 * @version 2020/07/04 to 08h24
	 */
	class News extends Users{
		// private $db;
		/**
		 *
		 */
		private $msg = true;
		public function __construct(){
			$this->msg = parent::get('debug');
			if(empty($this->db)){
				parent::__construct();
			}
		}
		public function toggle_activation($email){
			if($this->if_exist()){	
				$this->db;
				$sql = "SELECT status FROM {$this->infos['table']} WHERE email = :email";
				$exec = [
					'email' => htmlspecialchars($email)
				];
				$status = $this->db_request($sql, $exec);
				$sql = "UPDATE {$this->infos['table']} SET status = :status WHERE email = :email";
				$exec = [
					'status' => true || false,
					'email' => htmlspecialchars($email)
				];
				$this->db_request($sql, $exec, null, 'update');
			}else{

			}
		}
		public function lang($lang = null){
			if(empty($lang)){
				// todo set lang
			}else{
				// todo get lang
			}
		}
		public function change_email($old_email, $new_email){
			$this->db;
			$sql = "UPDATE {$this->infos['table']} SET email = :new_email WHERE email = :old_email";
			$exec = [
				'new_email' => htmlspecialchars($new_email),
				'old_email' => htmlspecialchars($old_email)
			];
			$this->db_request($sql, $exec, null, 'update');
		}
		/**
		 * @method msg()
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