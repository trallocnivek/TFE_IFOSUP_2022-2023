<?php
	class SQL{
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
		public function select(object $data){
			$sql = '';
			// cols
			if(!empty($data->select) && is_array($data->select)){
				$select = self::columns($data->select);
			}else $select = '*';
			// table
			if(!empty($data->table) && is_array($data->table)){
				$result_table = self::tables($data->table);
				if(is_array($result_table)){
					$table = $result_table[0];
					$table_join = $result_table[1];
				}else $table = $result_table;
			}else $table = $this->table;
			if(!empty($select) && !empty($table)){
				if(is_array($table)){
					$table = $table[0];
					$join = $table[1];
				}
				$this->alias_table = strtoupper(substr($table, 0, 1));
				$sql .= "SELECT $select FROM $table";
				if(!empty($join)) $sql .=  ' ' . self::joins($join); // $join is string
			}else{
				$this->error['DB'][] = 'db_utils ERROR [select] : $data doesn\'t valid !';
				return;
			}
			// join
			if(!empty($data->join) && is_array($data->join)){
				$sql .= ' ' . self::joins($data->join);
			}
			// where
			if(!empty($data->where) && is_array($data->where)){}
			// group by
			if(!empty($data->group) && is_array($data->group)){}
			// having
			if(!empty($data->having) && is_array($data->having)){}
			// order by
			if(!empty($data->having) && is_array($data->order)){}
			// limit
			if(!empty($data->having) && is_array($data->limit)){}
			// return result
			return $sql;
		}
		public function update(string $table, string $col, $val){

		}
		public function insert(string $table, array $data){

		}
		public function delete(string $table, $id){

		}
		private function columns($data){
			$result = '';
			if(is_array($data)){
				$i = 0;
				foreach($data as $k => $v){
					if(is_array($v)){
						$j = 0;
						foreach($v as $key => $val){
							if(is_array($val)){
								$result .= ($j === 0 ? ', ' : '') . $val[0] . '.' . $key . ' AS ' . $val[1];
							}else if(is_string($val)){
								$result .= ($j === 0 ? ', ' : '') . $key . ' AS ' . $val;
							}else{
								$this->error['DB'][] = 'db_utils ERROR [columns] : typeof $val doesn\'t valid !';
								return;
							}
						}
					}else if(is_string($v)){
						$result .= ($i === 0 ? ', ' : '') . $v;
						$i++;
					}else{
						$this->error['DB'][] = 'db_utils ERROR [columns] : typeof $v doesn\'t valid !';
						return;
					}
				}
			}else if(is_string($data)){
				$result = $data;
			}else{
				$this->error['DB'][] = 'db_utils ERROR [columns] : typeof $data doesn\'t valid !';
				return;
			}
			return $result;
		}
		private function tables($data){
			$result;
			if(is_array($data)){
				if(count($data) === 1){
					$result = $data[0];
				}else{
					$i = 0; $table = $join = '';
					foreach($data as $k => $v){
						if($i === 0) $table = $v;
						else $join .= ($i === 1 ? ', ' : '') . $v;
						$i++;
					}
					$result = [$table, $join];
				}
			}else if(is_string($data) && preg_match("/, ?/", $data)){
				$split = explode("/, ?/", $data);
				$result = self::tables($split);
			}else if(is_string($data)){
				$result = $data;
			}else{
				$this->error['DB'][] = 'db_utils ERROR [columns] : typeof $data doesn\'t valid !';
				return;
			}
			return $result;
		}
		private function joins(array $data){
			$sql = '';
			$types = ['natural', 'left', 'right', 'inner', 'outer', 'full', 'left outer', 'right outer'];
			foreach($data as $k => $v){
				if(is_int($k) || preg_match('/^[0-9]+$/', $k)){
					// STRING $v
					if(is_string($v) && preg_match('/, ?/', $v)){
						$j = 0;
						$t = -1;
						$tables = [];
						$options = [];
						$v = explode('/, ?/', $v);
						foreach($v as $value){
							if(preg_match('/=/', $value)){
								$sql .= $j === 0 ? '' : ' ';
								if(preg_match('/^[A-Z]* ?JOIN/', $value)){
									$sql .= $value;
								}else{
									$sql .= 'INNER JOIN ' . $value;
								}
							}else if(self::is_db_table($value) && !preg_match('/[A-Z]+/', $value)){
								array_push($tables, $value);
								$t++;
							}else if(preg_match('/^[A-Z]+_?[0-9]*$/', $value)){
								if(empty($options[$t])) array_push($options, $t);
								if(!is_array($options[$t])){
									$options[$t] = [];
								}else{
									array_push($options[$t], $value);
								}
							}else{

							}
							if(!empty($tables) && empty($options)){
								foreach($tables as $val){
									$sql .= 'INNER JOIN ' . $val 
										. ' AS ' . self::alias($val) 
										. ' ON ' . $this->alias_table . '.' . $val . '_id = ' . $this->alias_join[$val] . '.id'
									; 
								}
							}else if(!empty($tables) && !empty($options)){

							}
						}
					// ARRAY $v
					}else if(is_array($v)){

					}else{

					}
				}else if(is_string($k) && preg_match('//', $k)){

				}else{
					$this->error['DB'][] = 'db_utils ERROR [joins] : typeof $k isn\'t valid !';
					return;
				} return $sql;
			}
		}
	}
?>