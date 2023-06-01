<?php
	/**
	 * @trait db_utils
	 * @description DB tools box
	 * @property
	 * [private]
	 *  - $alias_table
	 *  - $alias_join
	 * @method
	 * [public]
	 *  - if_exist()
	 *  - request()
	 *  - return_id()
	 *  - get_cols()
	 * [private]
	 *  - is_db_table()
	 *  - sanitize()
	 * @uses global [$db], class [Config, DB], file [config.ini]
	 * @api DB
	 * @version 2021/02/06 TO 02H22
	 */
	trait db_utils{
		/**
		 * @property $alias_table
		 * @description alias de la table principale
		 * @see private 
		 * @var string
		 */
		private $alias_table = '';
		/**
		 * @property $alias_join
		 * @description liste des alias des jointures de tables
		 * @see private 
		 * @var array
		 */
		private $alias_join = [];
		/**
		 * @method if_exist(string $table, string $col, multi $value)
	 	 * @see public
	 	 * @description elem if exist in DB
		 * @param  string $table search table
		 * @param  string $col  search column
		 * @param  multi $value search value
		 * @return boolean
		 */
		public function if_exist(string $table, string $col, $value){
			$prefix = parent::get('ini', 'DB_CONFIG')['prefix_table'];
			if(!preg_match("/^{$prefix}/", $table)) $table = $prefix . $table;
			// var_dump('db_utils->if_exist() table name => ' . $table);
			$sql = "SELECT * FROM $table WHERE $col = :$col LIMIT 1";
			$exec = [$col => htmlspecialchars($value)];
			// var_dump($sql, self::request($sql));
			// var_dump('db_utils->if_exist() sql => ' . $sql);
			// var_dump(['db_utils->if_exist() self::request(' . $table . ')', self::request($sql)]);
			if(!empty(self::request($sql, $exec, 'fetch'))) return true;
			else return false;
		}
		/**
		 * @method request(string $sql [, array $exec = [] [, string $fetch = 'fetchAll']])
	 	 * @description execute sql query
	 	 * @see public
		 * @param  string $sql   sql query
		 * @param  array  $exec  execute array
		 * @param  string $fetch fetch or fetchAll (PDO::FETCH_ASSOC)
		 * @return multi [lastInsertId(), boolean, array]
		 */
		public function request(string $sql, array $exec = [], $fetch = 'fetchAll', $sanitise = true/*, $db_replace = null*/){
			global $db;
			$cond = false;
			// var_dump($db);
			// if(empty($db) && !empty($db_replace)) $db = $db_replace;
			//var_dump($exec);
			try{
				//$exec = $sanitise ? self::sanitize($exec) : $exec;
				$req = $db->prepare($sql);
				$req->execute($exec);
				// var_dump([$sql, $exec, $req, $req->fetchAll(PDO::FETCH_ASSOC)]);
				// return $req;
				$cond = true;
			}catch(PDOException $e){
				return false;
			}
			// var_dump($cond);
			if($cond){
				//var_dump($req->fetchAll(PDO::FETCH_ASSOC));
				if(preg_match("/^SELECT/", $sql)) return $req->$fetch(PDO::FETCH_ASSOC);
				else if(preg_match("/^INSERT/", $sql)) return $db->lastInsertId();
				else if(preg_match("/^DELETE/", $sql)) return true;
				else if(preg_match("/^CALL/", $sql)) return $req->$fetch(PDO::FETCH_ASSOC);
				else if(preg_match("/^UPDATE/", $sql)) return true;
				// else if(preg_match("/^CREATE/", $sql)) return $req->lastInsertId();
			}else{
				$this->error['DB'][] = 'db_utils ERROR [request] : ' . $sql . ' !';
			}
		}
	public static function request_static(string $sql, array $exec = [], $fetch = 'fetchAll', $sanitise = true/*, $db_replace = null*/){
			global $db;
			$cond = false;
			// var_dump($db);
			// if(empty($db) && !empty($db_replace)) $db = $db_replace;
			//var_dump($exec);
			try{
				//$exec = $sanitise ? self::sanitize($exec) : $exec;
				$req = $db->prepare($sql);
				$req->execute($exec);
				// var_dump([$sql, $exec, $req, $req->fetchAll(PDO::FETCH_ASSOC)]);
				// return $req;
				$cond = true;
			}catch(PDOException $e){
				return false;
			}
			// var_dump($cond);
			if($cond){
				//var_dump($req->fetchAll(PDO::FETCH_ASSOC));
				if(preg_match("/^SELECT/", $sql)) return $req->$fetch(PDO::FETCH_ASSOC);
				else if(preg_match("/^INSERT/", $sql)) return $db->lastInsertId();
				else if(preg_match("/^DELETE/", $sql)) return true;
				else if(preg_match("/^CALL/", $sql)) return $req->$fetch(PDO::FETCH_ASSOC);
				else if(preg_match("/^UPDATE/", $sql)) return true;
				// else if(preg_match("/^CREATE/", $sql)) return $req->lastInsertId();
			}else{
				$this->error['DB'][] = 'db_utils ERROR [request] : ' . $sql . ' !';
			}
		}
		
		private function is_db_table(string $x){
			$tables = [];
			$prefix = parent::get('ini', 'DB_CONFIG')['prefix_table'];
			if(!preg_match("/^$prefix/", $x)) $table = $prefix . $table;
			else $table = $x;
			foreach(parent::get('ini', 'DB_TABLES') as $k => $v) array_push($tables, $v['DB_TABLE']);
			if(in_array($tables, preg_replace("/^$prefix/", '', $table))) return true;
			return false;
		}
		/**
		 * @method return_id(string $sql, array $exec)
	 	 * @description retrun lastInsertId()
	 	 * @see public
		 * @param  string $sql  sql query
		 * @param  array  $exec execute array
		 * @return integer id
		 */
		public function return_id(string $sql, array $exec){
			return self::request($sql, $exec, 'fetch')['id'];
		}
		/**
		 * @method get_cols(string $table = '')
	 	 * @description array of columns table DB
	 	 * @see public
		 * @param  string $table table name
		 * @return array
		 */
		public function get_cols(string $table = ''){
			$table = !empty($table) ? $table : $this->table;
			$sql = "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = :table";
			$exec = self::sanitize(['table' => $table]);
			return self::request($sql, $exec, 'fetchAll');
		}
		public function last_id(){
			return self::request("SELECT LAST_INSERT_ID()", []);
		}
		/**
		 * @method sanitize($data [, $type = 'exec'])
		 * @param multi $data element for sanitize
		 * @param string $type type of sanitize
		 * @return multi htmlspecialchars($result)
		 */
		private function sanitize($data, $type = 'exec'){
			if(strtolower($type) == 'exec' && is_array($data)){
				$result = [];
				foreach($data as $k => $v) array_push($result, [$k => htmlspecialchars($v)]); 
			}else $result = htmlspecialchars($data);
			return $result;
		}
	}
?>