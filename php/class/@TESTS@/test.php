<?php
		class Site function get_page
			/*if((bool) $type){
				foreach($GLOBALS as $k => $v) ${$k} = $v;
				// echo $user->get('type');
				$dir = $this->page;
				$file = null;
				$login = ['sign_up', 'sign_in'];
				$newsletter = ['news'];
				$noConnect = ['', 'home', 'group', 'diary', 'gallery', 'demos', 'technical', 'contact'];
				$connect = ['profil'];
				$members = ['partitions'];
				$admin = ['admin', 'admin_stats'];
				$admin_pages = ['admin_diary', 'admin_gallery'];
				$grant = ['grant', 'grant_partitions', 'grant_users', 'grant_site', 'grant_logs'];
				if(is_connect()){
					$pages = array_KC_push([$noConnect, $newsletter]);
					$newsletterPages = array_KC_push([$pages]);
					$connectPages = array_KC_push([$pages, $connect]);
					$membersPages = array_KC_push([$pages, $members]);
					$adminPages = array_KC_push([$pages, $admin, $admin_pages, $connect, $members]);
					$grantPages = array_KC_push([$pages, $admin, $grant, $connect, $members]);
					// grant connect
					if(in_array(url_data('page'), $grantPages) && $user->get('type') == 'grant'){
						$dir0 = in_array(url_data('page'), $grant) ? "/grant" : '';
						$dir0 = in_array(url_data('page'), $admin_pages) ? "/admin" : $dir0;
						$dir0 = in_array(url_data('page'), $admin) ? "/admin" : $dir0;
						$dir0 = in_array(url_data('page'), $members) ? "/members" : $dir0;
						$dir0 = in_array(url_data('page'), $connect) ? "/connect" : $dir0;
						$dir0 = in_array(url_data('page'), $newsletter) ? "/newsletter/" : $dir0;
						$dir0 = in_array(url_data('page'), $noConnect) ? "" : $dir0;
						$dir .= $dir0;
						if($user->get('type') == 'grant') $file = !empty(url_data('page')) ? url_data('page') : (!empty($dir0) ? 'grant' : 'home');
						else echo 'ERROR GRANT ! ' . self::txt('page_error/permiss');
						// echo 'GRANT<br>';
					}
					// admin connect
					else if(in_array(url_data('page'), $adminPages) && $user->get('type') == 'admin'){
						$dir0 = in_array(url_data('page'), $admin_pages) ? "/admin" : '';
						$dir0 = in_array(url_data('page'), $admin) ? "/admin" : $dir0;
						$dir0 = in_array(url_data('page'), $members) ? "/members" : $dir0;
						$dir0 = in_array(url_data('page'), $connect) ? "/connect" : $dir0;
						$dir0 = in_array(url_data('page'), $newsletter) ? "/newsletter/" : $dir0;
						$dir0 = in_array(url_data('page'), $noConnect) ? "" : $dir0;
						$dir .= $dir0;
						if($user->get('type') == 'admin') $file = !empty(url_data('page')) ? url_data('page') : (!empty($dir0) ? 'admin' : 'home');
						else echo 'ERROR ADMIN ! ' . self::txt('page_error/permiss');
						// echo 'ADMIN<br>';
					}
					// member connect
					else if(in_array(url_data('page'), $membersPages) && $user->get('type') == 'group'){
						$dir0 = in_array(url_data('page'), $members) ? "/members" : $dir0;
						$dir0 = in_array(url_data('page'), $connect) ? "/connect" : $dir0;
						$dir0 = in_array(url_data('page'), $newsletter) ? "/newsletter/" : $dir0;
						$dir0 = in_array(url_data('page'), $noConnect) ? "" : $dir0;
						$dir .= $dir0;
						if($user->get('type') == 'member') $file = !empty(url_data('page')) ? url_data('page') : (!empty($dir0) ? 'partitions' : 'home');
						else echo 'ERROR GROUP ! ' . self::txt('page_error/permiss');
						// echo 'MEMBER<br>';
					}
					// user connect
					else if(in_array(url_data('page'), $connectPages) && $user->get('type') == 'user'){
						$dir0 = in_array(url_data('page'), $connect) ? "/connect" : $dir0;
						$dir0 = in_array(url_data('page'), $newsletter) ? "/newsletter/" : $dir0;
						$dir0 = in_array(url_data('page'), $noConnect) ? "" : $dir0;
						$dir .= $dir0;
						if($user->get('type') == 'user') $file = !empty(url_data('page')) ? url_data('page') : (!empty($dir0) ? 'profil' : 'home');
						else echo 'ERROR USER ! ' . self::txt('page_error/permiss');
						// echo 'USER<br>';
					}
					// newsletter connect
					else if(in_array(url_data('page'), $newsletterPages) && $user->get('type') == 'newsletter'){
						$dir0 = in_array(url_data('page'), $newsletter) ? "/newsletter/" : $dir0;
						$dir0 = in_array(url_data('page'), $noConnect) ? "" : $dir0;
						$dir .= $dir0;
						if($user->get('type') == 'user') $file = !empty(url_data('page')) ? url_data('page') : (!empty($dir0) ? 'newsletter' : 'home');
						else echo 'ERROR NEWSLETTER ! ' . self::txt('page_error/permiss');
						// echo 'NEWSLETTER<br>';
					}
					// no connect
					else if(in_array(url_data('page'), $pages)) $file = !empty(url_data('page')) ? url_data('page') : 'home';
					else echo 'CONNECT ERROR 404 NOT FOUND ! ' . self::txt('page_error/not_found', url_data('page'));
				}else{
					$pages = array_KC_push([$noConnect, $login, $newsletter]);
					if(empty(url_data('page')) || in_array(url_data('page'), $pages)) $file = url_data('page') != null ? url_data('page') : 'home';
					else echo 'NO CONNECT ERROR 404 NOT FOUND ! ' . self::txt('page_error/not_found', !empty(url_data('page')) ? url_data('page') : 'home');
					// echo 'VISITOR<br>';
				}
				// file
				if(!empty($file) && file_exists('./' . $dir . '/' . $file . '.php')) return include_once './' . $dir . '/' . $file . '.php';
				else $this->error['page'][] = 'Site ERROR [no-page] : ./' . $dir . '/' . $file . '.php';
				if(!empty($file) && !file_exists('./' . $dir . '/' . $file . '.php')) echo 'FILE ERROR 404 NOT FOUND ! ' . self::txt('page_error/not_found', url_data('page')) . ' => ' . $dir . $file;
			}else{
				return ucwords(url_data('page') != null ? self::txt('page/' . url_data('page')) : self::txt('page/home'));
			}*/

		class Users function select_generic
			/**
		 * @method select_generic(string $table, $id)
		 * @see private
		 * @description sql query selector
		 * @param  string $table table name
		 * @param  int || string $id selected id
		 * @return array
		 */
		/*private function select_generic(string $table, $id){
			$elem = in_array($table, ['lastname', 'firstname']) ? 'name' : '';
			$user_name = parent::get('ini', 'DB_TABLES')['user']['DB_TABLE'];
			$table_name = parent::get('ini', 'DB_TABLES')[$elem]['DB_TABLE'];
			$user = $this->prefix_table . $user_name;
			$tab = $this->prefix_table . $table_name;
			$select = "T." . $elem;
			$join = "U." . $elem . "_id";
			$sql = "
				SELECT $select AS X
				FROM $user AS U
				INNER JOIN $tab AS T ON $join = T.id
				WHERE U.id = :id
				LIMIT 1
			";
			$exec = ['id' => $id];
			if(self::if_exist($elem, 'id', $id)) return self::request($sql, $exec, 'fetch')['X'];
			else return 'SELECT_DB::' . $table . '=>no_elem->id=' . $id;
		}*/
		// REGISTER ZONE
		/**
		 * @method register(string $f [, multi $p = null])
		 * @see protected
		 * @description generic call register method
		 * @param  string $f function sub name
		 * @param  multi $p param call method
		 * @return function
		 */
		/*protected function register(string $f, $p = null){
			return self::{'register_' . $f}($p);
		}*/
		/**
		 * @method register_generic(string $type)
		 * @see protected
		 * @description 
		 * @param  string $type element for register
		 * @return integer id elem register
		 */
		/*protected function register_generic(string $type){
			$name = ['firstname', 'lastname'];
			$x = $type;
			if(in_array($type, $name)) $x = 'name';
			$table_name = parent::get('ini', 'DB_TABLES')[$x]['DB_TABLE'];
			$table = $this->prefix_table . $table_name;
			$value = $type == 'ip' ? get_ip() : url_data($type, true);
			$exec = [$type => $value];
			// var_dump(url_data($x));
			// var_dump(!self::if_exist($table, $x, $value));
			// var_dump(['TEST KC ' . $type, self::if_exist($table, $x, $value)]);
			if(!self::if_exist($table, $x, $value)){
				$sql = "INSERT INTO $table ($x) VALUES (:$type)";
				// var_dump('SQL => ' . $sql);
				// $_SESSION['sql'][$type] = $sql;
				return self::request($sql, $exec);
			}else{
				// $no_return = ['email'];
				//if(in_array($type, $no_return)) return 0;
				$sql = "SELECT * FROM $table WHERE $x = :$type LIMIT 1";
				// $_SESSION['sql'][$type] = $sql;
				// var_dump('SQL => ' . $sql);
				return self::return_id($sql, $exec);
			}
		}*/
		/**
		 * @method register_user(array $register)
		 * @see private
		 * @description new user register
		 * @param  array $register register value for user table DB
		 * @return integer register new user id
		 */
		/*private function register_user(array $register){
			$table = $this->table;
			$exec = [
				'email' => $register['email'],
				'pass' => self::hash_pass(url_data('password')),
				'first' => $register['firstname'],
				'last' => $register['lastname'],
				'ip' => $register['ip']
			];
			// var_dump($exec);
			if(!self::if_exist($table, 'email', url_data('email', true))){
				$cols = 'email_id, password, firstname_id, lastname_id, ip_id';
				$vals = ':email, :pass, :first, :last, :ip';
				$sql = "INSERT INTO $table ($cols) VALUES ($vals)";
				// $_SESSION['sql']['user'] = $sql;
				return self::request($sql, $exec);
			}else{
				return 0;
			}
		}*/

		class Site function txt
			
		/*public static function txt(string $x, $replace = ''){
			global $trad;
			if(strtolower($x) === 'lang') return url_data('lang') != null ? url_data('lang') : $_SESSION['lang'];
			$lang = preg_match('/be-(fr|nl)/', $_SESSION['lang']) ? substr($_SESSION['lang'], 3) : $_SESSION['lang'];
			$split = explode('/', $x);
			$key[] = strtolower($lang);
			for($i = 0; $i < count($split); $i++){
				array_push($key, $split[$i]);
			}
			if(!empty($replace)) return preg_replace("/%{[a-z0-9_]+}%/i", $replace, self::while_table($trad, $key, 0));
			else return self::while_table($trad, $key, 0);
		}*/
		/*public static function while_table($table, array $key, int $index){
			if(array_key_exists($key[$index], $table)){
				if(is_string($table[$key[$index]])){
					return $table[$key[$index]];
				}else if(is_array($table[$key[$index]])){
					return self::while_table($table[$key[$index++]], $key, $index++);
				}else{
					return var_dump($table, $key, $index);
				}
			}else{
				return var_dump('no ' . $key[$index] . ' in $trad in trad.php !');
			}
		}*/
?>