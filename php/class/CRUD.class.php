<?php
	/**
	 * @class CRUD
	 * @static
	 * @description DB CRUD utilities
	 * @property < none >
	 * @method
	 * 	[magic private]
	 * 		- __construct()
	 * 		- __clone()
	 * 	[public static]
	 * 		- add()
	 * 		- create()
	 * 		- insert()
	 * 		- read()
	 * 		- call()
	 * 		- select()
	 * 		- update()
	 * 		- delete()
	 * 		- procedure()
	 * @uses class [Config], trait [db_utils]
	 * @api DB
	 * @author Collart Kevin
	 * @version 2021/05/24 TO 21H57
	 */
	class CRUD{
		// USE TRAIT ZONE
		use db_utils;
		// MAGIC METHOD ZONE
		public function __construct(){}
		private function __clone(){}
		// METHOD ZONE
		public static function sql($sql, $exec = [], $fetch = 'fetchAll',  $dbname = 'swingstadmin', $sanitize = true){
			return self::request_static($sql, $exec, $fetch, $sanitize, $dbname);
		}
		/**
		 * @method add(string $table, array $data, $type = 'insert')
		 * @static
		 * @see public
		 * @description redirect self method [create, insert]
		 * @param  string $table table name 							[required]
		 * @param  array  $data DB insert values [elem name => value] 	[required]
		 * @param  string $type self method name 						[optional]
		 * @return multi
		 */
		public static function add(string $table, array $data, $type = 'insert'){
			switch(strtolower($type)){
				case 'insert': return self::insert($table, $data); break;
				// case 'create': return self::create($elem, $data); break;
				default: return 'nop';
			}
		}
		/**
		 * @method create()
		 * @not use for the moment !
		 * @return ?
		 */
		public static function create(){}
		/**
		 * @method insert(string $table, array $data)
		 * @static
		 * @see public
		 * @description insert value in DB table
		 * @param  string $table table name 							[required]
		 * @param  array  $data DB insert values [elem name => value] 	[required]
		 * @return integer DB->lastInsertId() | false
		 */
		public static function insert(string $table, array $data){
			$table = htmlspecialchars($table);
			$cols = $values = "";
			$exec = [];
			$i = 0;
			foreach($data as $k => $v){
				$cols .= ($i++ > 0 ? ", " : "") . htmlspecialchars($k);
				$values .= ($i++ > 0 ? ", " : "") . ":" . htmlspecialchars($k);
				$exec[$k] = htmlspecialchars($v);
			}
			$sql = "INSERT INTO $table ($cols) VALUES ($values)";
			return self::request($sql, $exec);
		}
		/**
		 * @method read(string $elem, array $data = [], $type = 'select')
		 * @static
		 * @see public
		 * @description redirect self method [read, call]
		 * @param  string $elem elem name 						[required]
		 * @param  array  $data list of self method arguments 	[optional]
		 * @param  string $type self method name 				[optional]
		 * @return multi
		 */
		public static function read(string $elem, array $data = [], $type = 'select'){
			switch(strtolower($type)){
				case 'select': return self::select($elem, $data['cols'], $data['id']); break;
				case 'call': return self::call($elem, $data); break;
				default: return 'nop';
			}
		}
		/**
		 * @method call(string $procedure, $data)
		 * @static
		 * @see public
		 * @description DB call procedure or function
		 * @param  string $procedure procedure name 						[required]
		 * @param  array  $data      list of procedure|function arguments 	[optional]
		 * @return multi
		 */
		public function call($db, string $procedure, $data = []){
			$procedure = htmlspecialchars(
				(isset($data['procedure_type']) && !empty($data['procedure_type']) ? $data['procedure_type'] . '_' : '') . $procedure
			);
			$params = "";
			$exec = [];
			$i = 0;
			foreach($data['data'] as $k => $v){
				$params .= ($i++ > 0 ? ", " : "") . ":" . htmlspecialchars($k);
				$exec[$k] = htmlspecialchars($v);
			}
			$sql = "CALL $procedure($params)";
			// var_dump($sql, $exec);
			return self::request($sql, $exec);
		}
		/**
		 * @method select(string $table, array $cols = [], int $id = 0)
		 * @static
		 * @see public
		 * @description select elem in DB
		 * @param  string 	$table table name 								[required]
		 * @param  array    $cols  DB cols list								[optional]
		 * @param  array 	$where  array or where options [name => value]	[optional]
		 * @return array|string
		 */
		public function select($db, string $table, $cols = null, $where_list = null, $fetch = 'fetchAll'){
			$table = 'swing_' . htmlspecialchars($table);
			$exec = [];
			if(!empty($cols) && is_array($cols)){
				$cols_list = "";
				foreach($cols as $k => $v) if((int) $k) $cols_list .= ($k > 0 ? ", " : "") . htmlspecialchars($v);
			} else $cols_list = "*";
			if(!empty($where_list && is_array($where_list))){
				$where = " WHERE ";
				$i = 0;
				foreach($where_list as $k => $v){
					$exec[$k] = htmlspecialchars($v);
					$where .= ($i++ > 0 ? " AND " : "") . htmlspecialchars($k) . " = :" . htmlspecialchars($k);
				}
			} else $where = "";
			$sql = "SELECT $cols_list FROM $table" . $where;
			// var_dump([$sql, $exec]);
			return self::request($sql, $exec, $fetch, true, $db);
		}
		/**
		 * @method update(string $table, array $data)
		 * @static
		 * @see public
		 * @generator
		 * @description update elem in DB
		 * @param  string $table table name 								[required]
		 * @param  array  $data  all data for update [colname => value] 	[required]
		 * @return boolean
		 */
		public static function update(string $table, array $data){
			$table = htmlspecialchars($table);
			foreach($data as $k => $v){
				$k = htmlspecialchars($k);
				$sql = "UPDATE $table SET $k = :v WHERE id = :id AND $k != :v";
				$exec = ['id' => htmlspecialchars(abs($id)), 'v' => htmlspecialchars($v)];
				yield self::request($sql, $exec);
			}
		}
		/**
		 * @method delete(string $table, int $id)
		 * @static
		 * @see public
		 * @description delete elem in DB
		 * @param  string $table table name [required]
		 * @param  int    $id    DB elem id [required]
		 * @return boolean
		 */
		public static function delete(string $table, int $id){
			$table = htmlspecialchars($table);
			$sql = "DELETE FROM $table WHERE id = :id";
			$exec = ['id' => htmlspecialchars(abs($id))];
			return self::request($sql, $exec);
		}
		/**
		 * @method get_procedure()
		 * @static
		 * @see public
		 * @description get all procedures in DB
		 * @return array
		 */
		public static function get_procedure(){
			global $config;
			$db_name = $config->get('ini', 'DB_INFOS')['dbname'];
			$sql = "SELECT ROUTINE_NAME FROM INFORMATION_SCHEMA.ROUTINES WHERE ROUTINE_TYPE = 'PROCEDURE' AND ROUTINE_SCHEMA = :dbname";
			$exec = ['dbname' => htmlspecialchars($db_name)];
			return self::request($sql, $exec);
		}
	}
?>