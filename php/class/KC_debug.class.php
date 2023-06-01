<?php
	/**
	 * @class DB_debug
	 * @todo retourne les messages success, warning et error soit en message client ou en debug developpeur
	 * @author trallocnivek <trallocnivek@gmail.com>
	 * @version 03/05/2020
	 * @api static
	 */
	class KC_debug{
		private const TYPE_MSG = ['error', 'warning', 'success'];
		private $error = [];
		private $warning = [];
		private $success = [];
		public static function msg(string $type, array $msg, $target = null){
			if(in_array(strtolower($type), self::TYPE_MSG)){
				$this->{$type}[] = $msg;
			}else{
				$this->warning[] = [__METHOD__ => 'property_$type_invalid'];
				var_dump(['ERROR:' => $error, 'WARNING:' => $warning, 'SUCCESS:' => $success]);
				exit;
			}
			if($target != null){
				if(is_site_url($target)){
					header("location:$target");
				}else{
					$this->warning[] = [__METHOD__ => 'property_$target_invalid'];
					var_dump(['ERROR:' => $error, 'WARNING:' => $warning, 'SUCCESS:' => $success]);
					exit;
				}
			}
		}
		public static function html_msg(){
			$html = '';
			return $html;
		}
	}
?>