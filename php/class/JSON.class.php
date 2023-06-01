<?php
	/**
	 * @class JSON
	 * @static
	 * @description JSON <=> PHP convertor
	 * @property
	 * 	[static private]
	 * 	[static public]
	 * @method
	 * 	[magic private]
	 * 		- __construct()
	 * 		- __clone()
	 * 	[static public]
	 * 		- encode()
	 * 		- decode()
	 * 	[static private]
	 * 		- debug()
	 * @uses < none >
	 * @api JSON
	 * @author Collart Kevin
	 * @version 2020/10/14 TO 17H21
	 */
	class JSON{
		// MAGIC METHOD ZONE
		private function __construct(){}
		private function __clone(){}
		// METHOD ZONE
		/**
		 * @method encode($php)
		 * @description PHP to JSON
		 * @see public
		 * @static
		 * @param string $php code PHP ou autre
		 * @return JSON
		 */
		public static function encode($php){
			return json_encode($php);
		}
		/**
		 * @method decode($json)
		 * @description JSON to PHP
		 * @see public
		 * @static
		 * @param string $json code JSON
		 * @param boolean $assoc_array if decode to associative array or object
		 * @return PHP ou autre
		 */
		public static function decode($json, $assoc_array = false){
			return json_decode($json, $assoc_array);
		}
	}
?>