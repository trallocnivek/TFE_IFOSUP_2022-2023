<?php
	/**
	 * @class Date
	 * @description gestion Dates
	 * @property
	 * [public]
	 * [protected]
	 * [private]
	 *  - $msg
	 *  - $error
	 *  - $success
	 *  - $format
	 *  - $day
	 *  - $month
	 * @method
	 * [public]
	 * 	- __construct()
	 *  - get()
	 *  - msg()
	 * [protected]
	 * [private]
	 *  - set()
	 *  - get_KC_date_int()
	 *  - get_KC_date()
	 *  - get_KC_time()
	 *  - get_datetime()
	 *  - get_date()
	 *  - get_fulltime()
	 *	- get_time()
	 *	- get_timastamp()
	 *	- get_fullyear()
	 *	- get_minyear()
	 *  - get_month()
	 *  - get_month_int()
	 *  - get_month_string()
	 *  - get_day_int()
	 *  - get_day_string()
	 *  - get_hour($x){}
	 *  - get_minute()
	 *  - get_second()
	 *  - get_millisecond()
	 * @uses class [Config]
	 * @api DATE
	 * @version 2021/01/18 TO 12H24
	 */
	class Date extends Config{
		// PROPERTIES ZONE
		/**
		 * @property $msg
		 * @see private
		 * @var boolean
		 * @description active debug msg
		 */
		private $msg = true;
		/**
		 * @property $error
		 * @see private
		 * @var array
		 * @description error msg
		 */
		private $error;
		/**
		 * @property $success
		 * @see private
		 * @var array
		 * @description success msg
		 */
		private $success;
		/**
		 * @property $format
		 * @see private
		 * @var array
		 * @description list of land formats
		 */
		private $format = [
			'datetime' => [
				'fr' => ['d', 'm', 'Y', 'H', 'H', 'i', ':', 's'],
				'nl' => ['d', 'm', 'Y', 'H', 'u', 'i', ':', 's'],
				'en' => ['Y', 'm', 'd', 'h', ':', 'i', ':', 's a'],
				'de' => ['d', 'm', 'Y', 'h', ':', 'i', ':', 's a']
			],
			'date' => [
				'fr' => ['d', 'm', 'Y'],
				'nl' => ['d', 'm', 'Y'],
				'en' => ['Y', 'm', 'd'],
				'de' => ['d', 'm', 'Y']
			],
			'fulltime' => [
				'fr' => ['H', 'H', 'i', ':', 's'],
				'nl' => ['H', 'u', 'i', ':', 's'],
				'en' => ['h', ':', 'i', ':', 's a'],
				'de' => ['h', ':', 'i', ':', 's a']
			],
			'timestamp' => ['Y-m-d H:i:s'],
			'time' => [
				'fr' => ['H', 'H', 'i'],
				'nl' => ['H', 'u', 'i'],
				'en' => ['h', ':', 'i a'],
				'de' => ['h', ':', 'i a']
			]
		];
		/**
		 * @property $day
		 * @see private
		 * @var array
		 * @description names day
		 */
		private $day = [
			'fr' => ['Dimanche', 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'],
			'nl' => ['Zondag', 'Maandag', 'Dinsdag', 'Woensdag', 'Donderdag', 'Vrijdag', 'Zaterdag'],
			'en' => ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'],
			'de' => ['Sonntag', 'Montag', 'Dienstag', 'Mittwoch', 'Donnerstag', 'Freitag', 'Samstag']
		];
		/**
		 * @property $month
		 * @see private
		 * @var array
		 * @description names month
		 */
		private $month = [
			'fr' => [
				'Janvier', 'Février', 'Mars', 'Avril',
            	'Mai', 'Juin', 'Juillet', 'Août',
            	'Septembre', 'Octobre', 'Novembre', 'Décembre'
			],
			'nl' => [
				'Januari', 'Februari', 'Maart', 'April',
             	'Mei', 'Juni', 'Juli', 'Augustus',
             	'September', 'Oktober', 'November', 'December'
			],
			'en' => [
				'January', 'February', 'March', 'April',
             	'May', 'June', 'July', 'August',
             	'September', 'October', 'November', 'December'
			],
			'de' => [
				'Januar', 'Februar', 'März', 'April',
             	'Mai', 'Juni', 'Juli', 'August',
             	'September', 'Oktober', 'November', 'Dezember'
			]
		];
		// MAGIC METHODS ZONE
		/**
		 * @method __construct() init instanceof DB
		 * @see public
		 * @uses config.ini, Config
		 * @return void()
		 */
		public function __construct(){
			if(class_exists('Config')){
				self::set('msg', parent::get('debug'));
			}else{
				$this->error['construct'][] = 'DB ERROR [no-class] : Config_not_exist !';
			}
		}
		// INIT ZONE
		// SET ZONE
		/**
		 * @method set(string $attr, multi $v)
		 * @description generic call set property
		 * @see private
		 * @param string $attr $this->attribute_name
		 * @param multi $v value
		 * @return void()
		 */
		private function set(string $attr, $v){
			if(property_exists(__CLASS__, $attr)) $this->$attr = $v;
			else $this->error['attributes'][] = 'DB ERROR [no-attribute] : ' . $attr . ' !';
		}
		// GET ZONE
		/**
		 * @method get(string $f [, multi $p = null])
		 * @description generic call get method
		 * @see public
		 * @param string $f function name without 'get_'
		 * @param multi $p function param
		 * @return method self::{'get_' . $f}($p)
		 */
		public function get(string $f, $p = null){
			if(method_exists(__CLASS__, 'get_' . $f)) return self::{'get_' . $f}($p);
			else $this->error['methods'][] = 'DB ERROR [no-method] : get_' . $f . ' !';
		}
		/**
		 * @method get_KC_date_int($x)
		 * @description return PDO connexion object
		 * @see private
		 * @return date
		 */
		private function get_KC_date_int($x){
			$date = date_create($x);
			$slash = ' / ';
			$i = 0;
			$format = '';
			foreach($this->format['date'][$_SESSION['lang']] as $k => $v){
				if($i == 0) $i++;
				else $format .= $slash;
				$format .= $v;
			}
			return date_format($date, $format);
		}
		private function get_KC_date($x){
			// ['d', 'm', 'Y']
			$date = date_create($x);
			$space = ' ';
			$i = 0;
			$result = '';
			foreach($this->format['date'][$_SESSION['lang']] as $k => $v){
				if($i == 0) $i++;
				else $result .= $space;
				if($v == 'd') $result .= self::get('day_string', ['date' => $date, 'value' => $v]);
				else if($v == 'm') $result .= self::get('month_string', date_format($date, $v));
				else if($v == 'Y') $result .= self::get('fullyear', $date);
			}
			return $result;	
		}
		private function get_KC_time($x){
			$date = date_create($x);
			$format = $this->format['time'][$_SESSION['lang']];
			return date_format($date, $format[0]) . ' ' . $format[1] . ' ' . date_format($date, $format[2]);
		}
		private function get_datetime($x = 'time'){
			$x = $x == 'time' ? time() : $x;
			$create = date_create($x);
			$format = $this->format['datetime'][$_SESSION['lang']];
		}
		private function get_date(){}
		private function get_fulltime(){}
		private function get_time(){}
		private function get_timestamp(){}
		private function get_fullyear($x){
			return date_format($x, 'Y');
		}
		private function get_minyear($x){}
		private function get_month($x){}
		private function get_month_int($x){}
		private function get_month_string($x){
			return $this->month[$_SESSION['lang']][$x - 1];
		}
		private function get_day_int($x){}
		private function get_day_string($x){
			$date = $x['date'];
			$diary = GregorianToJD(date_format($date, 'm'), date_format($date, 'd'), date_format($date, 'Y'));
			return $this->day[$_SESSION['lang']][JDDayOfWeek($diary, 0)] . ' ' . date_format($date, $x['value']);
		}
		private function get_hour($x){}
		private function get_minute($x){}
		private function get_second($x){}
		private function get_millisecond($x){}
		// DEBUG ZONE
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