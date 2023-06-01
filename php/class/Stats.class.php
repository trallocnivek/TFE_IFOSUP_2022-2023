<?php
	class Stats{
		public static function create(){
			// via db
			// table download
			// colonne id element date_create
		}
		public static function read(){
			// via db
			// table read
			// colonne id element et count++ date_update et date_create
		}
		public static function upload(){
			// via db
			// table upload
			// colonne id element et count++ change date_update et date_create
		}
		public static function delete(){
			// via db
			// table delete
			// colonne id element date_create
		}
		public static function download(){
			// via db
			// table download
			// colonne id element et count++ date_update et date_create
		}
		public static function visit(){
			// via db
			// table visit
			// colonne id user_ip, user_id, count++ date_update et date_create
		}
	}
?>