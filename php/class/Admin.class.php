<?php
	class Admin{
		use db_utils;
		public function __construct(){}
		public function db($elem, $action, $data = null, $bool = false){
			$method = $elem . '_' . $action;
			// var_dump($method);
			return method_exists(__CLASS__, $method) ? self::{$method}($data, $bool) : ['error' => 'invalid_data'];
		}
		private function toggle($elem, $data){
			$method = $elem . '_update';
			return self::$method($data->elem);
		}
		// TASK
		private function task_read($data){
			try{
				if(isset($data->id)) $exec = ['id' => $data->id];
				else $exec = [];
				return self::request("SELECT * FROM swing_task", $exec);
			}catch(Exception $e){
				return ['error' => 'invalid data'];
			}
		}
		private function task_add($data){
			try{
				$sql = "INSERT INTO swing_task (user_id, name, description)  VALUES (:id, :name, :descr)";
				$exec = [
					'id' => $data->user,
					'name' => $data->name,
					'descr' => $data->description
				];
				self::request($sql, $exec);
				return ['success' => 'add ok'];
			}catch(PDOException $e){
				return ['error' => 'no task add'];
			}
		}
		private function task_delete($data){
			try{
				$id = $data->id;
				self::request("DELETE FROM swing_task WHERE id = :id", ['id' => htmlspecialchars($id)]);
				return ['success' => 'del task_id ' . $id];
			}catch(PDOexception $e){
				return ['error' => 'task not delete'];
			}
		}
		private function task_update($id, $data){
			try{
				$id = $data->id;
				$sql = "UPDATE swing_task SET name = :name AND description = :descr WHERE id = :id";
				$exec = ['id' => htmlspecialchars($id), 'name' => htmlspecialchars($data['name']), 'descr' => htmlspecialchars($data['descr'])];
				return self::request($sql, $exec);
			}catch(Exception $e){
				return ['error' => 'invalid data'];
			}
		}
		// SITE
		public function site_read($data){
			try{
				if(isset($data['id'])){
					$exec = ['id' => $data['id']];
					var_dump(self::last_id());
					return self::request("SELECT * FROM swing_pages WHERE id = :id", $exec, 'fetch');
				}
				else{
					$exec = [];
					return self::request("SELECT * FROM swing_pages", $exec);
				}
			}catch(Exception $e){
				return ['error' => 'invalid data'];
			}
		}
		private function site_add($data){
			try{
				$sql = "INSERT INTO swing_url (name, url, auth_id, target, active, description)  VALUES (:name, :url, :auth_id, :target, :active, :descr)";
				$exec = [
					'name' => htmlspecialchars($data['db_elem_title']),
					'url' => htmlspecialchars($data['url']),
					'auth_id' => (int) $data['auth_id'],
					'target' => '_self',
					'active' => $data['page_active'] == 'on' ? 1 : 2,
					'descr' => htmlspecialchars($data['description'])
				];
				self::request($sql, $exec);
				return ['success' => 'add ok'];
			}catch(PDOException $e){
				return ['error' => 'no task add'];
			}
		}
		private function site_update($data){
			try{
				$sql = "UPDATE swing_pages SET name = :name AND auth_id = :auth WHERE id = :id";
				$exec = [
					'id' => htmlspecialchars($data['id']),
					'name' => htmlspecialchars($data['name']),
					'auth' => htmlspecialchars($data['auth_id'])
				];
				return self::request($sql, $exec);
			}catch(Exception $e){
				return ['error' => 'invalid data'];
			}
		}
		private function site_delete($data){
			try{
				$id = $data->id;
				self::request("UPDATE swing_pages SET active = 0 WHERE id = :id", ['id' => htmlspecialchars($id)]);
				return ['success' => 'del task_id ' . $id];
			}catch(PDOexception $e){
				return ['error' => 'task not delete'];
			}
		}
		// DIARY
		private function diary_read($data){
			try{
				$sql = "CALL get_diary(:lang, :id)";
				$exec = [
					'lang' => $data->lang,
					'id' => $data->id
				];
				return self::request("CALL get_diary(:lang, :id)", $exec);
			}catch(Exception $e){
				return ['error' => 'invalid data'];
			}
		}
		private function diary_add($data){
			try{
				$sql = "INSERT INTO swing_diary (user_id, name, description)  VALUES (:id, :name, :descr)";
				$exec = [
					'id' => $data->user,
					'name' => $data->name,
					'descr' => $data->description
				];
				self::request($sql, $exec);
				return ['success' => 'add ok'];
			}catch(PDOException $e){
				return ['error' => 'no task add'];
			}
		}
		private function diary_update($data){
			try{
				$sql = "UPDATE swing_diary SET name = :name AND description = :descr WHERE id = :id";
				$exec = ['id' => htmlspecialchars($data['id']), 'name' => htmlspecialchars($data['name']), 'descr' => htmlspecialchars($data['descr'])];
				return self::request($sql, $exec);
			}catch(Exception $e){
				return ['error' => 'invalid data'];
			}
		}
		private function diary_delete($data){
			try{
				$id = $data->id;
				self::request("DELETE FROM swing_diary WHERE id = :id", ['id' => htmlspecialchars($id)]);
				return ['success' => 'del task_id ' . $id];
			}catch(PDOexception $e){
				return ['error' => 'task not delete'];
			}
		}
		// GALLERY
		private function gallery_read($data, $bool){
			try{
				$procedure = 'get_' . ($bool ? 'gallery_img' : 'gallery');
				$params = $bool ? ":id, :active" : ":lang, :id";
				$exec = $bool ? ['id' => $data->id, 'active' => $data->active] : ['lang' => $data->lang, 'id' => $data->id];
				return self::request("CALL $procedure($params)", $exec);
			}catch(Exception $e){
				return ['error' => 'invalid data'];
			}
		}
		private function gallery_add($data, $bool){
			try{
				if($bool){
					$sql = "INSERT INTO swing_gallery_img (web_img_id, full_url_id, gallery_id, order_list, description)  VALUES (:web, :full, :gallery, :order, :descr)";
					$exec = [
						'web' => $data->web,
						'full' => $data->full,
						'gallery' => $data->gallery,
						'order' => $data->order,
						'descr' => $data->description
					];
				}else{
					$sql = "INSERT INTO swing_gallery (name_id, picture_id, date, address_id, url_id, description)  VALUES (:name, :img, :date, :address, :url, :descr)";
					$exec = [
						'name' => $data->name,
						'img' => $data->img,
						'date' => $data->date,
						'address' => $data->address,
						'url' => $data->url,
						'descr' => $data->description
					];
				}
				self::request($sql, $exec);
				return ['success' => 'add ok'];
			}catch(PDOException $e){
				return ['error' => 'no task add'];
			}
		}
		private function gallery_update($data, $bool){
			try{
				$table = 'swing_' . ($bool ? 'gallery_img' : 'gallery');
				$sql = "UPDATE $table SET name = :name AND description = :descr WHERE id = :id";
				$exec = ['id' => htmlspecialchars($data['id']), 'name' => htmlspecialchars($data['name']), 'descr' => htmlspecialchars($data['descr'])];
				return self::request($sql, $exec);
			}catch(Exception $e){
				return ['error' => 'invalid data'];
			}
		}
		private function gallery_delete($data, $bool){
			try{
				$id = $data->id;
				$table = 'swing_' . ($bool ? 'gallery_img' : 'gallery');
				self::request("DELETE FROM $table WHERE id = :id", ['id' => htmlspecialchars($id)]);
				return ['success' => 'del task_id ' . $id];
			}catch(PDOexception $e){
				return ['error' => 'task not delete'];
			}
		}
		// MUSIC SHEET
		// swing_musicsheet 		[id, title_id, 	url_id, 	instru_id, 		ton_id, 	num_page, 	nbr_pages, description]
		// swing_musicsheet_num 	[id, title_id, 	group_id, 	number, 		active]
		// swing_musicsheet_title 	[id, title, 	author_id, 	arranger_id, 	style_id, 	date, 		groupe_id, description]
		private function music_sheet_read($data){
			try{
				if(isset($data->id)) $exec = ['id' => $data->id];
				else $exec = [];
				return self::request("SELECT * FROM swing_musicsheet", $exec);
			}catch(Exception $e){
				return ['error' => 'invalid data'];
			}
		}
		private function music_sheet_add($data){
			try{
				$sql_title = "INSERT INTO swing_musicsheet_title (title, author_id, arranger_id, style_id, date, groupe_id, description) VALUES (:title, :author, :arranger, :style, :date, :group, :descr)";
				$exec_title = [
					'title' => $data->title_title,
					'author' => $data->title_author,
					'arranger' => $data->title_arranger,
					'style' => $data->title_style,
					'date' => $data->title_date,
					'group' => $data->title_group,
					'descr' => $data->title_description
				];
				$title = self::request($sql_title, $exec_title);
				$sql_num = "INSERT INTO swing_musicsheet_num (title_id, group_id, number)  VALUES (:title, :group, :num)";
				$exec_num = [
					'title' => $title->id,
					'group' => $data->num_group,
					'num' => $data->num_num
				];
				$num = self::request($sql_num, $exec_num);
				$sql = "INSERT INTO swing_musicsheet (title_id, url_id, instru_id, ton_id, num_page, nbr_pages, description)  VALUES (:title, :url, :instru, :ton, :num, :nbr, :descr)";
				$exec = [
					'title' => $title->id,
					'url' => $data->url,
					'instru' => $data->instru,
					'ton' => $data->ton,
					'num' => $data->num_page,
					'nbr' => $data->nbr_pages,
					'descr' => $data->description
				];
				self::request($sql, $exec);
				return ['success' => 'add ok'];
			}catch(PDOException $e){
				return ['error' => 'no task add'];
			}
		}
		private function music_sheet_update($data){
			try{
				$sql = "UPDATE swing_musicsheet SET name = :name AND description = :descr WHERE id = :id";
				$exec = ['id' => htmlspecialchars($data['id']), 'name' => htmlspecialchars($data['name']), 'descr' => htmlspecialchars($data['descr'])];
				return self::request($sql, $exec);
			}catch(Exception $e){
				return ['error' => 'invalid data'];
			}
		}
		private function music_sheet_delete($data){
			try{
				$id = $data->id;
				self::request("DELETE FROM swing_musicsheet WHERE id = :id", ['id' => htmlspecialchars($id)]);
				return ['success' => 'del task_id ' . $id];
			}catch(PDOexception $e){
				return ['error' => 'task not delete'];
			}
		}
		// USER
		private function user_read($data){
			try{
				return self::request("CALL get_users(:id)", ['id' => $data->id]);
			}catch(Exception $e){
				return ['error' => 'invalid data'];
			}
		}
		private function user_add($data){
			global $user;
			try{
				$sql = "INSERT INTO swing_users (user_id, name, description)  VALUES (:id, :name, :descr)";
				$exec = [
					'id' => $data->user,
					'name' => $data->name,
					'descr' => $data->description
				];
				self::request($sql, $exec);
				return ['success' => 'add ok'];
			}catch(PDOException $e){
				return ['error' => 'no task add'];
			}
		}
		private function user_update($data){
			try{
				$sql = "UPDATE swing_users SET name = :name AND description = :descr WHERE id = :id";
				$exec = ['id' => htmlspecialchars($data['id']), 'name' => htmlspecialchars($data['name']), 'descr' => htmlspecialchars($data['descr'])];
				return self::request($sql, $exec);
			}catch(Exception $e){
				return ['error' => 'invalid data'];
			}
		}
		private function user_delete($data){
			try{
				$id = $data->id;
				self::request("DELETE FROM swing_users WHERE id = :id", ['id' => htmlspecialchars($id)]);
				return ['success' => 'del task_id ' . $id];
			}catch(PDOexception $e){
				return ['error' => 'task not delete'];
			}
		}
		// MEMBER
		private function member_read($data){
			try{
				if(isset($data->id)) $exec = ['id' => $data->id];
				else if(isset($data['id'])) $exec = ['id' => $data['id']];
				else $exec = [];
				// var_dump($exec);
				return self::request("SELECT * FROM swing_members", $exec);
			}catch(Exception $e){
				return ['error' => 'invalid data'];
			}
		}
		private function member_add($data){
			try{
				$sql = "INSERT INTO swing_members (firstname_id, lastname_id, email_id, tel_id, gsm_id, img_id, instru_id, function_id, sexe, order, description)  VALUES (:firstname, :lastname, :email, :tel, :gsm, :img, :instru, :function, :sexe, :order, :descr)";
				$exec = [
					'firstname' => $data->firstname,
					'lastname' => $data->lastname,
					'email' => $data->email,
					'tel' => $data->tel,
					'gsm' => $data->gsm,
					'img' => $data->img,
					'instru' => $data->instru,
					'function' => $data->function,
					'sexe' => $data->sexe,
					'order' => $data->order,
					'descr' => $data->description
				];
				self::request($sql, $exec);
				return ['success' => 'add ok'];
			}catch(PDOException $e){
				return ['error' => 'no task add'];
			}
		}
		private function member_update($data){
			try{
				$sql = "UPDATE swing_members SET name = :name AND description = :descr WHERE id = :id";
				$exec = ['id' => htmlspecialchars($data['id']), 'name' => htmlspecialchars($data['name']), 'descr' => htmlspecialchars($data['descr'])];
				return self::request($sql, $exec);
			}catch(Exception $e){
				return ['error' => 'invalid data'];
			}
		}
		private function member_delete($data){
			try{
				$id = $data->id;
				self::request("DELETE FROM swing_members WHERE id = :id", ['id' => htmlspecialchars($id)]);
				return ['success' => 'del task_id ' . $id];
			}catch(PDOexception $e){
				return ['error' => 'task not delete'];
			}
		}
		// NEWS
		private function news_read($data){
			try{
				if(isset($data->id)) $exec = ['id' => $data->id];
				else if(isset($data['id'])) $exec = ['id' => $data['id']];
				else $exec = [];
				// var_dump($exec);
				return self::request("SELECT * FROM swing_newsletters", $exec);
			}catch(Exception $e){
				return ['error' => 'invalid data'];
			}
		}
		private function news_add($data){
			try{
				$sql = "INSERT INTO swing_newsletters (email_id, user_id, password, email, diary, gallery, demos)  VALUES (:email_id, :user_id, password, email, diary, gallery, demos)";
				$exec = [
					'email_id' => (int) $data->email_id, 	// (int) email_id
					'user_id' => (int) $data->user_id, 	// (int) user_id
					'password' => (string) $data->password,	// (txt) password
					'email' => (bool) $data->email,		// (bool) ???
					'diary' => (bool) $data->diary,		// (bool) new or change event date
					'gallery' => (bool) $data->gallery,	// (bool) new or change gallery
					'demos' => (bool) $data->demos 		// (bool) new or change demos
				];
				self::request($sql, $exec);
				return ['success' => 'add newsletter ok'];
			}catch(PDOException $e){
				return ['error' => 'no newsletter add'];
			}
		}
		private function news_update($data){
			try{
				$sql = "UPDATE swing_newsletters SET name = :name AND description = :descr WHERE id = :id";
				$exec = ['id' => htmlspecialchars($data->id), 'name' => htmlspecialchars($data['name']), 'descr' => htmlspecialchars($data['descr'])];
				return self::request($sql, $exec);
			}catch(Exception $e){
				return ['error' => 'invalid data'];
			}
		}
		private function news_delete($data){
			try{
				$id = $data->id;
				self::request("DELETE FROM swing_newsletters WHERE id = :id", ['id' => htmlspecialchars($id)]);
				return ['success' => 'del task_id ' . $id];
			}catch(PDOexception $e){
				return ['error' => 'task not delete'];
			}
		}
		/*// 
		private function _read($data){}
		private function _add($data){}
		private function _update($data){}
		private function _delete($data){}*/
		// DB PROCEDURE
		public function procedure(){
			$sql = "SELECT ROUTINE_NAME FROM INFORMATION_SCHEMA.ROUTINES WHERE ROUTINE_TYPE = 'PROCEDURE' AND ROUTINE_SCHEMA = 'swingshift'";
			$exec = [];
			return self::request($sql, $exec);
		}
	// $valid_elem = ['task', 'site', 'diary', 'gallery', 'music_sheet', 'users', 'members', 'news'];
	}
?>