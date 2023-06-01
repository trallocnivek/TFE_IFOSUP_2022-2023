<?php
	/**
	 * @class CSS
	 * @static
	 * @description CSS generator
	 * @property
	 * 	[static private]
	 * 		- $html_tags
	 * 		- $css_prefix
	 * 		- $css_functions
	 * 		- $css_property
	 * 		- $css_values
	 * 		- $css_comment
	 * 		- $css_default
	 * 	[static public]
	 * @method
	 * 	[magic private]
	 * 		- __construct()
	 * 		- __clone()
	 * 	[static public]
	 * 		- get()
	 * 	[static private]
	 * 		- reset()
	 * 		- get_prefix()
	 * 		- get_select()
	 * 		- get_property()
	 * 		- get_value()
	 * 		- get_comment()
	 * 		- debug()
	 * @uses class [HTML]
	 * @api CSS 3
	 * @author Collart Kevin
	 * @version 2020/10/12 TO 05H07
	 */
	class CSS{
		private static $html_tags = HTML::get('html_tags');
		private static $html_attrs = HTML::get('html_attrs');
		private static $css_prefix = [
			'W' => '-webkit-',
			'M' => '-moz-',
			'E' => '-ms-',
			'O' => '-o-'
		];
		private static $css_selectors = [
			'class' => "/\.[[:alnum:]]+/",
			'id' => "/#[[:alnum:]]+/",
			'ALL' => "/\*/",
			'tag' => "/[a-z_-]/i",
			'separator' => ',',
			'combinators' => [
				'desc' => ' ',
				'child' => '>',
				'brother_adj' => '+',
				'brother_ALL' => '~'
			],
			'pseudo' => [
				'class' => [
					'symbol' => ':',
					'active',
					'checked',
					'disabled',
					'empty',
					'enabled',
					'first-child',
					'first-of-type',
					'focus',
					'hover',
					'in-range',
					'invalid',
					'lang(LANG)',
					'last-child',
					'last-of-type',
					'link',
					'not(SELECTOR)',
					'nth-child(NUMBER|odd|even|NUMBERn+NUMBER)',
					'nth-last-child(NUMBER|odd|even|NUMBERn+NUMBER)',
					'nth-last-of-type(NUMBER|odd|even|NUMBERn+NUMBER)',
					'nth-of-type(NUMBER|odd|even|NUMBERn+NUMBER)',
					'only-of-type',
					'only-child',
					'optional',
					'out-of-range',
					'read-only',
					'read-write',
					'required',
					'root',
					'target',
					'valid',
					'visited'
				],
				'elem' => [
					'symbol' => '::',
					'after',
					'before',
					'first-letter',
					'first-line',
					'selection'
				],
				'attr' => [
					"/\[[a-z_-]+((~|\||\^|\$|\*)?=[[:alnum:][:punct:]])?\]/i"
				]
			]
		];
		private static $css_property = [
			'align-content' => [
				'anim' => false,
				'prefix' => 'W',
				'transition'  => null,
				'val' => ['center', 'flex-end', 'flex-start', 'initial', 'inherit', 'space-around', 'space-between', 'stretch'],
				'default' => ''
			],
			'align-items' => [
				'anim' => false,
				'prefix' => 'W',
				'transition'  => null,
				'val' => ['baseline', 'center', 'flex-end', 'flex-start', 'initial', 'inherit', 'stretch']
			],
			'align-self' => [
				'anim' => false,
				'prefix' => 'W',
				'transition'  => null,
				'val' => ['auto', 'baseline', 'center', 'flex-end', 'flex-start', 'initial', 'inherit', 'stretch']
			],
			'all' => [
				'anim' => false,
				'prefix' => null,
				'transition'  => null,
				'val' => ['initial', 'inherit', 'unset']
			],
			'animation' => [
				'anim' => false,
				'list' => ['name', 'duration', 'timing-function', 'delay', 'iteration-count', 'direction', 'fill-mode', 'play-state'],
				'prefix' => 'WMO',
				'transition'  => null
			],
			'animation-delay' => [
				'anim' => false,
				'prefix' => 'WMO',
				'transition'  => null,
				'val' => ['TIME', 'initial', 'inherit']
			],
			'animation-direction' => [
				'anim' => false,
				'prefix' => 'WMO',
				'transition'  => null,
				'val' => ['alternate', 'alternate-reverse', 'initial', 'inherit', 'normal', 'reverse']
			],
			'animation-duration' => [
				'anim' => false,
				'prefix' => 'WMO',
				'transition'  => null,
				'val' => ['TIME', 'initial', 'inherit']
			],
			'animation-fill-mode' => [
				'anim' => false,
				'prefix' => 'WMO',
				'transition'  => null,
				'val' => ['backwards', 'both', 'forwards', 'initial', 'inherit', 'none']
			],
			'animation-iteration-count' => [
				'anim' => false,
				'prefix' => 'WMO',
				'transition'  => null,
				'val' => ['']
			],
			'animation-name' => [
				'anim' => false,
				'prefix' => 'WMO',
				'transition'  => null,
				'val' => ['']
			],
			'animation-play-state' => [
				'anim' => false,
				'prefix' => 'WMO',
				'transition'  => null,
				'val' => ['']
			],
			'animation-timing-function' => [
				'anim' => false,
				'prefix' => 'WMO',
				'transition'  => null,
				'val' => ['']
			],
			'' => [
				'anim' => false,
				'prefix' => '',
				'transition'  => null,
				'val' => ['']
			],
			'' => [
				'anim' => false,
				'prefix' => '',
				'transition'  => null,
				'val' => ['']
			],
			'' => [
				'anim' => false,
				'prefix' => '',
				'transition'  => null,
				'val' => ['']
			],
			'' => [
				'anim' => false,
				'prefix' => '',
				'transition'  => null,
				'val' => ['']
			],
			'' => [
				'anim' => false,
				'prefix' => '',
				'transition'  => null,
				'val' => ['']
			],
			'' => [
				'anim' => false,
				'prefix' => '',
				'transition'  => null,
				'val' => ['']
			],
			'' => [
				'anim' => false,
				'prefix' => '',
				'transition'  => null,
				'val' => ['']
			]
		];
		private static $css_values = [
			'SHAPE' => ['ellipse', 'circle'],
			'SIZE' => ['farthest-corner', 'closest-side', 'closest-corner', 'farthest-side']
		];
		private static $css_functions = [
			'attr' => ['ATTR'],
			'calc' => ['NUBER_VALUE_CALC'],
			'cubic-bezier' => ['X1', 'Y1', 'X2', 'Y2'],
			'hsl' => ['HUE', 'SATURATION', 'LIGHTNESS'],
			'hsla' => ['HUE', 'SATURATION', 'LIGHTNESS', 'ALPHA'],
			'linear-gradient' => ['DIRECTION', 'COLOR-STOP_X'],
			'radial-gradient' => ['SHAPE', 'SIZE', 'POSITION', 'COLOR_X'],
			'repeating-linear-gradient' => ['ANGLE|SIDE', 'COLOR_X'],
			'repeating-radial-gradient' => ['SHAPE', 'SIZE', 'POSITION', 'COLOR_X'],
			'rgb' => ['RED', 'GREEN', 'BLUE'],
			'rgba' => ['RED', 'GREEN', 'BLUE', 'ALPHA'],
			'url' => ['URL'],
			'var' => ['PROPERTY', 'VALUE']
		];
		private static $css_comment = ['/*', '*/'];
		private static $css_type = [
			'number' => [
				'ch','cm', 'em', 'ex', 'in', 'mm', 'px', 'pt', 'pc', 'rem', 'vh','vmin','vmax','vw','%'
			],
			'time' => ['s', 'ms'],
			'' => [],
			'' => [],
			'' => [],
			'' => [],
		];
		private static $css_code = '';
		// MAGIC METHOD ZONE
		private function __construct(){}
		private function __clone(){}
		// SET ZONE
		// GET ZONE
		public static function get($method, $param = null){

		}
		// private function
		private static function get_headers(){
			header('content-type: text/css');
			ob_start('ob_gzhandler');
			header('cache-control: max-age=31536000, must-revalidate');
		}
		private static function selector($select){
			$list = self::$css_selectors;
		}
		private static function prefix($property){
			$list = self::$css_prefix;	
		}
		/**
		 * [property description]
		 * @param  [type] $html_tag [description]
		 * @param  [type] $property [description]
		 * @param  [type] $value    [description]
		 * @return [type]           [description]
		 * $property = [
			'align-content' => [
				'anim' => false,
				'prefix' => 'W',
				'transition'  => null,
				'val' => ['center', 'flex-end', 'flex-start', 'initial', 'inherit', 'space-around', 'space-between', 'stretch'],
				'default' => 'stretch'
			],
		 */
		private static function property($html_tag, $property, $value = null, $type = null){}
		private static function value($property, $value = null){
			if(!empty($value)){
				if(array_key_exists($type, self::$css_type)){

				}
				else return self::$css_property[$property][$value];
			}else return self::$css_property[$property]['default'];
		}
		private static function build_function($name, $param = null){

		}
	}
?>