<?php
	/**
	 * @version 2020/10/10 TO 02H13
	 */
	// func_get_arg(int arg_num); // retourne un argument de la function
	// func_get_args(); // retourne array arguments function
	// func_num_args(); // retourne le nombre d'arguments function
	class HTML{
		// ATTRIBUTES ZONE
		private static $html_tags = [
			'simple' => [
				'area', 'br', 'embed', 'hr', 'img', 'input', 'link', 'meta', 'output', 'param', 'source', 'track'
			],
			'double' => [
				'a', 'abbr', 'address', 'article', 'aside', 'audio',
				'b', 'base', 'bdi', 'bdo', 'blockquote', 'body', 'button',
				'canvas', 'caption', 'cite', 'code', 'col', 'colgroup',
				'data', 'datalist', 'dd', 'del', 'details', 'dfn', 'dialog', 'div', 'dl', 'dt',
				'em',
				'fieldset', 'figcaption', 'figure', 'footer', 'form',
				'h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'head', 'header', 'html',
				'i', 'iframe', 'ins',
				'kbd',
				'label', 'legend', 'li',
				'main', 'map', 'mark', 'meter',
				'nav', 'noscript',
				'object', 'ol', 'optgroup', 'option',
				'p', 'picture', 'pre', 'progress',
				'q',
				'rp', 'rt', 'ruby',
				's', 'samp', 'script', 'section', 'select', 'small', 'span', 'strong', 'style', 'sub', 'summary', 'sup', 'svg',
				'table', 'tbody', 'td', 'template', 'textarea', 'tfoot', 'th', 'thead', 'time', 'title', 'tr',
				'u', 'ul',
				'var', 'video',
				'wbr'
			],
			'comment' => [
				'<!-- ', ' -->'
			],
			'doctype' => [
				'!DOCTYPE html'
			],
			'deprecated' => [
				'acronym' => ['abbr'],
				'applet' => ['embed', 'object'],
				'basefont' => ['CSS' => ['color', 'font-family', 'font-size']],
				'big' => ['CSS' => ['font-size']],
				'center' => ['CSS' => ['text-align']],
				'dir' => ['ul'],
				'font' => ['CSS' => ['color', 'font-family', 'font-size']],
				'frame' => ['iframe'],
				'frameset' => ['iframe'],
				'noframe' => ['iframe'],
				'strike' => ['del', 's'],
				'tt' => ['CSS' => ['font-family']]
			]
		];
		private static $attributes = [
			'values' => [
			// A
				'accept' => [
					'elem' => ['input[type=file]'],
					'val' => ['STRING', 'file_extension', 'audio/*', 'video/*', 'image/*', 'media_type']
				],
				'accept-charset' => [
					'elem' => ['form'],
					'val' => ['charset_type']
				],
				'accesskey' => [
					'elem' => ['all_html_tags'],
					'val' => ['STRING']
				],
				'action' => [
					'elem' => ['form'],
					'val' => ['URL']
				],
				'alt' => [
					'elem' => ['area', 'img', 'input'],
					'val' => ['STRING']
				],
				'autocomplete' => [
					'elem' => ['form', 'input'],
					'val' => ['on', 'off']
				],
			// B
			// C
				'charset' => [
					'elem' => ['meta', 'script'],
					'val' => ['charset_type']
				],
				'cite' => [
					'elem' => ['blockquote', 'del', 'ins', 'q'],
					'val' => ['URL']
				],
				'class' => [
					'elem' => ['all_html_tags'],
					'val' => ['STRING']
				],
				'cols' => [
					'elem' => ['textarea'],
					'val' => ['NUMBER']
				],
				'colspan' => [
					'elem' => ['td', 'th'],
					'val' => ['NUMBER']
				],
				'content' => [
					'elem' => ['meta'],
					'val' => ['STRING']
				],
				'contenteditable' => [
					'elem' => ['all_html_tags'],
					'val' => ['true', 'false']
				],
				'coords' => [
					'elem' => ['area'],
					'val' => ['NUMBER_STRING']
				],
			// D
				'data' => [
					'elem' => ['object'],
					'val' => ['URL']
				],
				'data-*' => [
					'*' => "/[[:alpha:]]+/i",
					'elem' => ['all_html_tags'],
					'val' => ['STRING']
				],
				'datetime' => [
					'elem' => ['del', 'ins', 'time'],
					'val' => ['ALL_DATE_FORMATS']
				],
				'dir' => [
					'elem' => ['all_html_tags'],
					'val' => ['ltr', 'rtl', 'auto']
				],
				'dirname' => [
					'elem' => ['input'],
					'val' => ['*.dir']
				],
				'' => [
					'elem' => [],
					'val' => []
				],
			// E
				'enctype' => [
					'elem' => ['form'],
					'val' => ['	application/x-www-form-urlencoded', 'multipart/form-data', 'text/plain']
				],
			// F
				'for' => [
					'elem' => ['label'],
					'val' => ['STRING']
				],
				'form' => [
					'elem' => ['input', 'fieldset', 'label', 'textarea'],
					'val' => ['STRING']
				],
				'formaction' => [
					'elem' => ['input'],
					'val' => ['URL']
				],
				'formenctype' => [
					'elem' => ['input'],
					'val' => ['	application/x-www-form-urlencoded', 'multipart/form-data', 'text/plain']
				],
				'formmethod' => [
					'elem' => ['input'],
					'val' => ['get', 'post']
				],
				'formtarget' => [
					'elem' => ['a', 'form'],
					'val' => ['_blank', '_self', '_parent', '_top', 'framename']
				],
			// G
			// H
				'height' => [
					'elem' => ['input'],
					'val' => ['NUMBER']
				],
			// I
			// J
			// K
			// L
			// M
				'max' => [
					'elem' => ['input'],
					'val' => ['NUMBER', 'DATE']
				],
				'maxlength' => [
					'elem' => ['input', 'textarea'],
					'val' => ['NUMBER']
				],
				'min' => [
					'elem' => ['input'],
					'val' => ['NUMBER', 'DATE']
				],
				'minlength' => [
					'elem' => ['input'],
					'val' => ['NUMBER']
				],
				'method' => [
					'elem' => ['form'],
					'val' => ['get', 'post']
				],
			// N
				'name' => [
					'elem' => ['form', 'select', 'input', 'textarea', 'fieldset'],
					'val' => ['STRING']
				],
			// O
			// P
				'pattern' => [
					'elem' => ['input'],
					'val' => ['REGEXP']
				],
				'placeholder' => [
					'elem' => ['input', 'textarea'],
					'val' => ['STRING']
				],
			// Q
			// R
				'rel' => [
					'elem' => ['form'],
					'val' => ['external', 'help', 'license', 'next', 'nofollow', 'noopener', 'noreferer', 'opener', 'prev', 'search']
				],
				'rows' => [
					'elem' => ['textarea'],
					'val' => ['NUMBER']
				],
			// S
				'size' => [
					'elem' => ['input'],
					'val' => ['NUMBER']
				],
				'src' => [
					'elem' => ['input'],
					'val' => ['URL']
				],
				'step' => [
					'elem' => ['input'],
					'val' => ['NUMBER']
				],
				'style' => [
					'elem' => ['all_html_tags'],
					'val' => ['CSS']
				],
			// T
				'target' => [
					'elem' => ['a', 'form'],
					'val' => ['_blank', '_self', '_parent', '_top']
				],
				'type' => [
					'elem' => ['button', 'input'],
					'val' => [
						'button', 'checkbox', 'color', 'date', 'datetime-local', 'email', 'file', 'hidden', 'image', 'month',
						'number', 'password', 'radio', 'range', 'reset', 'search', 'submit', 'tel', 'text', 'time', 'url', 'week'
					]
				],
			// U
			// V
				'value' => [
					'elem' => ['input', 'option'],
					'val' => ['STRING']
				],
			// W
				'width' => [
					'elem' => ['input'],
					'val' => ['NUMBER']
				],
				'wrap' => [
					'elem' => ['textarea'],
					'val' => ['hard', 'soft']
				],
			// X
			// Y
			// Z
				'' => [
					'elem' => [],
					'val' => []
				],
			],
			'self' => [
			// A
				'async' => ['script'],
				'autofocus' => ['button', 'input', 'select', 'textarea'],
				'autoplay' => ['audio', 'video'],
			// B
			// C
				'checked' => ['input'],
				'controls' => ['audio', 'video'],
			// D
				'default' => ['track'],
				'defer' => ['script'],
				'disabled' => ['button', 'fieldset', 'input', 'textarea'],
			// E
			// F
				'formnovalidate' => ['input'],
			// G
			// H
			// I
			// J
			// K
			// L
			// M
				'multiple' => ['input'],
			// N
				'novalidate' => ['form'],
			// O
			// P
			// Q
			// R
				'readonly' => ['input', 'textarea'],
				'required' => ['input'],
			// S
			// T
			// U
			// V
			// W
			// X
			// Y
			// Z
				'' => [''],
				'' => [''],
				'' => [''],
				'' => [''],
				'' => [''],
				'' => [''],
				'' => [''],
				'' => [''],
			],
			'deprecated' => [
				'align' => ['CSS' => ['text-align']],
				'bgcolor' => ['CSS' => ['background-color']],
				'border' => ['CSS' => ['border']],
				'color' => ['CSS' => ['color']]
			]	
		];
		private static $charset_type = ['UTF-8'];
		
		private static $a_attr = ['href'];
		private static $abbr_attr = ['title'];
		private static $area_attr = ['shape', 'coords', 'alt', 'href'];
		private static $audio_attr = ['controls'];
		private static $base_attr = ['href', 'target'];
		private static $bdo_attr = ['dir'];
		private static $blockquote_attr = ['cite'];
		private static $data_attr = ['value'];
		private static $datalist_attr = ['id'];
		private static $dialog_attr = ['open'];
		private static $embed_attr = ['type', 'src'];
		private static $form_attr = ['accept-charset', 'action', 'autocomplete', 'enctype', 'method', 'name', 'novalidate', 'rel', 'target'];
		private static $html_attr = ['lang'];
		private static $iframe_attr = ['src'];
		private static $img_attr = ['src', 'alt'];
		private static $input_attr = ['type', 'name', 'id'];
		private static $label_attr = ['for'];
		private static $link_attr = ['rel', 'href'];
		private static $map_attr = ['name'];
		private static $meter_attr = ['id', 'value'];
		private static $object_attr = ['data'];
		private static $optgroup_attr = ['label'];
		private static $option_attr = ['value'];
		private static $output_attr = ['name', 'for'];
		private static $param_attr = ['name', 'value'];
		private static $progress_attr = ['id', 'value', 'max'];
		private static $select_attr = ['name', 'id'];
		private static $source_attr = ['src', 'type'];
		private static $textarea_attr = ['id', 'name'];
		private static $time_attr = ['datetime'];
		private static $track_attr = ['src', 'kind', 'srclang', 'label'];
		private static $video_attr = ['controls'];

		private static $form_elem = [
			'button',
			'datalist',
			'fieldset',
			'form',
			'input',
			'label',
			'legend',
			'optgroup',
			'option',
			'output',
			'select',
			'textarea'
		];

		// MAGIC FUNCTION ZONE
		private function __construct(){}
		private function __clone(){}
		
		// UTILS ZONE
		/**
		 * @method txt_value(multi $x)
		 * @description 
		 * @see private
		 * @static
		 * @param  multi $x
		 * @return string
		 */
		private static function txt_value($x){
			if(is_array($x)){
				$txt = '';
				if(!empty($x)) foreach($x as $v) $txt .= ($x[0] == $v ? '' : ' ') . $v;
				return $txt;
			}else return !empty($x) ? $x : '';
		}

		// GENERATOR ZONE
		/**
		 * @method attr_loop(multi $x)
		 * @description redirect all build html attribute string
		 * @see private
		 * @static
		 * @param array $x
		 * @return string
		 * @generator
		 */
		private static function attr_loop(array $x){
			if(!empty($x) && is_array($x)){	
				foreach($x as $k => $v){
					if($k == 'data_list') continue;
					else if(gettype($k) == 'integer'){
						if(is_array($v)) yield self::attr_loop($v);
						else yield self::$v();
					}else if(gettype($k) == 'string'){
						if($k == 'title') $k = 'title_attr';
						else if($k == 'label') $k = 'label_attr';
						if(is_array($v) && $k == 'class') yield self::$k($v);
						else yield self::$k($v);
					}
				}
			}else return '';
		}

		// ATTRIBUTES ZONE
		/**
		 * @method action(string $x)
		 * @description action attribute
		 * @see public
		 * @static
		 * @param  string $x value attribute
		 * @return string
		 */
		public static function action(string $x){
			return 'action="' . $x . '"';
		}
		/**
		 * @method active(string $x)
		 * @description value active for current active page class attribute
		 * @see public
		 * @static
		 * @param  string $x value attribute
		 * @return string
		 */
		public static function active(string $x){
			return (url_data('page') === $x && $x != 'index') || (empty(url_data('page')) && $x === 'index') ? 'active' : '';
		}
		/**
		 * @method alt(string $alt)
		 * @description alt attribute
		 * @see public
		 * @static
		 * @param  string $alt value attribute
		 * @return string
		 */
		public static function alt(string $alt){
			return 'alt="' . $alt . '"';
		}
		/**
		 * @method attribute(string $attr, $v = null)
		 * @description unknow attribute with value
		 * @see public
		 * @static
		 * @param string $attr attribute name
		 * @param string $v attribute value
		 * @return string
		 */
		public static function attribute(string $attr, $v = null){
			return '' . $attr . (!empty($v) ? self::txt_value($v) : '');
		}
		/**
		 * @method autocomplete(boolean $x = false)
		 * @description autocomplete attribute
		 * @see public
		 * @static
		 * @param  string $x select value attribute
		 * @return string
		 */
		public static function autocomplete(bool $x = false){
			return 'autocomplete="' . ($x ? 'on' : 'off') . '"';
		}
		/**
		 * @method autofocus()
		 * @description autofocus attribute
		 * @see public
		 * @static
		 * @return string
		 */
		public static function autofocus(){
			return 'autofocus';
		}
		/**
		 * @method active(string $x)
		 * @description values class attribute
		 * @see public
		 * @static
		 * @args[]
		 * @return string
		 */
		public static function class(){
			$func_list = ['active'];
			$page_list = ['index', 'home'];
			$args = func_get_args()[0];
			$class = '';
			if(is_array($args)){
				$i = 0;
				foreach($args as $k => $v){
					if($i != 0) $class .= ' ';
					if(is_string($k) && in_array($k, $func_list)) $class .= self::$k(in_array($v, $page_list) ? 'index' : $v);
					else $class .= $v;
					$i++;
				}
			} return !empty($class) ? 'class="' . $class . '"' : '';
		}
		public static function cols($val){
			return 'cols="' . $val . '"';
		}
		/**
		 * @method data_target(string $x)
		 * @description value data-target attribute
		 * @see public
		 * @static
		 * @param  string $x attribute value
		 * @return string
		 */
		public static function data_target(string $x){
			return 'data-target="' . $x . '"';
		}
		/**
		 * @method data_toggle($)
		 * @description value data-toggle attribute
		 * @see public
		 * @static
		 * @param  string $x attribute value
		 * @return string
		 */
		public static function data_toggle(string $x){
			return 'data-toggle="' . $x . '"';
		}
		public static function disabled(bool $space = false){
			return ($space ? ' ' : '') . 'disabled';
		}
		public static function for_label(string $for){
			return 'for="' . $for . '"';
		}
		/**
		 * @method hidden()
		 * @description hidden attribute
		 * @see public
		 * @static
		 * @return string
		 */
		public static function hidden(){
			return 'hidden';
		}
		/**
		 * @method href(string $url)
		 * @description value href attribute
		 * @see public
		 * @static
		 * @param  string $url attribute value
		 * @return string
		 */
		public static function href(string $url){
			return 'href="' . $url . '"';
		}
		/**
		 * @method id(string $id)
		 * @description value id attribute
		 * @see public
		 * @static
		 * @param  string $id attribute value
		 * @return string
		 */
		public static function id(string $id){
			return 'id="' . $id . '"';
		}
		/**
		 * @method label(string $label)
		 * @description value label attribute
		 * @see public
		 * @static
		 * @param  string $label attribute value
		 * @return string
		 */
		public static function label_attr(string $label){
			return 'label="' . $label . '"';
		}
		/**
		 * @method max(float $max)
		 * @description value max attribute
		 * @see public
		 * @static
		 * @param  string $mas attribute value
		 * @return string
		 */
		public static function max(float $max){
			return 'max="' . $max . '"';
		}
		/**
		 * @method method(string $method)
		 * @description value method attribute
		 * @see public
		 * @static
		 * @param  string $method attribute value
		 * @return string
		 */
		public static function method(string $method){
			return 'method="' . $method . '"';
		}
		/**
		 * @method min(fmoat $min)
		 * @description value min attribute
		 * @see public
		 * @static
		 * @param  string $min attribute value
		 * @return string
		 */
		public static function min(float $min){
			return 'min="' . $min . '"';
		}
		public static function name(string $name){
			return 'name="' . $name . '"';
		}
		public static function onclick($onclick){
			return 'onclick="' . $onclick . '"';
		}
		/**
		 * @method pattern(string $pattern)
		 * @description value pattern attribute
		 * @see public
		 * @static
		 * @param  string $pattern attribute value
		 * @return string
		 */
		public static function pattern(string $pattern){
			return 'pattern="' . $pattern . '"';
		}
		public static function placeholder($x = ''){
			return 'placeholder="' . $x . '"';
		}
		/**
		 * @method pointer(boolean $space = false)
		 * @description value active for current active page class attribute
		 * @see public
		 * @static
		 * @param boolean $space if start string with a space caracter
		 * @return string
		 */
		public static function pointer(bool $space = false){
			return ($space ? ' ' : '') . 'pointer';
		}
		/**
		 * @method required()
		 * @description required attribute
		 * @see public
		 * @static
		 * @return string
		 */
		public static function required(){
			return 'required';
		}
		public static function rows($val){
			return 'rows="' . $val . '"';
		}
		public static function selected(bool $space = false){
			return ($space ? ' ' : '') . 'selected';
		}
		/**
		 * @method src(string $url)
		 * @description value src attribute
		 * @see public
		 * @static
		 * @param string $url attribute value
		 * @return string
		 */
		public static function src(string $url){
			return 'src="' . $url . '"';
		}
		/**
		 * @method step(float $step)
		 * @description value step attribute
		 * @see public
		 * @static
		 * @param  string $step attribute value
		 * @return string
		 */
		public static function step(float $step){
			return 'step="' . $step . '"';
		}
		/**
		 * @method style(string $css)
		 * @description value style attribute
		 * @see public
		 * @static
		 * @param  string $css attribute value
		 * @return string
		 */
		public static function style(string $css){
			return 'style="' . $css . '"';
		}
		/**
		 * @method title_attr(string $title)
		 * @description value title attribute
		 * @see public
		 * @static
		 * @param  string $title attribute value
		 * @return string
		 */
		public static function title_attr($title = 'no title'){
			return 'title="' . $title . '"';
		}
		/**
		 * @method type(string $type)
		 * @description value type attribute
		 * @see public
		 * @static
		 * @param  string $type attribute value
		 * @return string
		 */
		public static function type(string $type){
			return 'type="' . $type . '"';
		}
		public static function value($value){
			return 'value="' . $value . '"';
		}
		/**
		 * @method width($)
		 * @description value width attribute
		 * @see public
		 * @static
		 * @param multi $x attribute value
		 * @return string
		 */
		public static function width($x){
			return !empty($x) ? ' width="' . $x . '"' : '';
		}

		// BALISES ZONE
		/**
		 * @method a()
		 * @description html <a> tag
		 * @see public
		 * @static
		 * @args[]
		 * @return string
		 */
		public static function a(){
			$args = func_get_args()[0];
			$attr_list = (isset($args[1]) ? self::attr_loop($args[1]) : '');
			$attr = '';
			if(is_object($attr_list)) foreach($attr_list as $v) $attr .= ' ' . $v;
			return "<a" . $attr . ">" . $args[0] . '</a>';
		}
		/**
		 * @method button()
		 * @description html <button> tag
		 * @see public
		 * @static
		 * @args[]
		 * @return string
		 */
		public static function button(){
			$args = func_get_args()[0];
			$attr_list = (isset($args[1]) ? self::attr_loop($args[1]) : '');
			$attr = '';
			if(is_object($attr_list)) foreach($attr_list as $v) $attr .= ' ' . $v;
			return "<button" . $attr . ">" . $args[0] . '</button>';
		}
		/**
		 * @method div()
		 * @description html <div> tag
		 * @see public
		 * @static
		 * @args[]
		 * @return string
		 */
		public static function div(){
			$args = func_get_args()[0];
			$attr_list = (isset($args[1]) ? self::attr_loop($args[1]) : '');
			$attr = '';
			if(is_object($attr_list)) foreach($attr_list as $v) $attr .= ' ' . $v;
			return "<div" . $attr . ">" . $args[0] . "</div>";
		}
		public static function figure(){
			$args = func_get_args()[0];
			$attr_list = (isset($args[1]) ? self::attr_loop($args[1]) : '');
			$attr = '';
			if(is_object($attr_list)) foreach($attr_list as $v) $attr .= ' ' . $v;
			return '<figure' . $attr . '>' . $args[0] . '</figure>';
		}
		/**
		 * @method form()
		 * @description html <form> tag
		 * @see public
		 * @static
		 * @args[]
		 * @return string
		 */
		public static function form(){
			$args = func_get_args()[0];
			$attr_list = (isset($args[1]) ? self::attr_loop($args[1]) : '');
			$attr = '';
			if(is_object($attr_list)) foreach($attr_list as $v) $attr .= ' ' . $v;
			return '<form' . $attr . '>' . $args[0] . '</form>';
		}
		/**
		 * @method h()
		 * @description html <h[0-6]> tag
		 * @see public
		 * @static
		 * @args[]
		 * @return string
		 */
		public static function h(){
			$args = func_get_args()[0];
			$attr_list = (isset($args[2]) ? self::attr_loop($args[2]) : '');
			$attr = '';
			if(is_object($attr_list)) foreach($attr_list as $v) $attr .= ' ' . $v;
			return "<h" . $args[0] . $attr . ">" . $args[1] . '</h' . $args[0] . '>';
		}
		/**
		 * @method i()
		 * @description html <i> tag
		 * @see public
		 * @static
		 * @args[]
		 * @return string
		 */
		public static function i(){
			$args = func_get_args()[0];
			$attr_list = (isset($args[1]) ? self::attr_loop($args[1]) : '');
			$attr = '';
			if(is_object($attr_list)) foreach($attr_list as $v) $attr .= ' ' . $v;
			return "<i" . $attr . ">" . $args[0] . '</i>';
		}
		/**
		 * @method img()
		 * @description html <img> tag
		 * @see public
		 * @static
		 * @args[]
		 * @return string
		 */
		public static function img(){
			$data = func_get_args()[0];
			if(!empty($data['url'])){
				$url = self::src($data['url']);
				$title = isset($data['object']['site'], $data['title']) && !empty($data['object']['site']) && !empty($data['title']) ? ' ' . self::title_attr($data['object']['site']->txt($data['title'])) : '';
				$width = isset($data['width']) && !empty($data['width']) ? ' ' . self::width($data['width']) : '';
				$alt = ' ' . (isset($data['alt']) && !empty($data['alt']) ? self::alt($data['alt']) : self::alt($data['url']));
				$title = ' ' . (isset($data['title']) && !empty($data['title']) ? self::title_attr($data['title']) : '');
				$onclick = ' ' . (isset($data['onclick']) && !empty($data['onclick']) ? self::onclick($data['onclick']) : '');
				$class_list = isset($data['class']) && !empty($data['class']) ? $data['class'] : [];
				$pointer = isset($data['pointer']) && (bool) $data['pointer'] ? array_push($class_list, self::pointer()) : '';
				$id = isset($data['id']) && !empty($data['id']) ? ' ' . self::id($data['id']) : '';
				$class = !empty($class_list) ? ' ' . self::class($class_list) : '';
				return "<img " . $url . $id . $class . $title . $alt . $width . $onclick . $title . '>';
			}else return 'no_img_arg !';
		}
		public static function input(){
			$args = func_get_args()[0];
			$attr_list = (isset($args) ? self::attr_loop($args) : '');
			$attr = '';
			if(is_object($attr_list)) foreach($attr_list as $v) $attr .= ' ' . $v;
			if($args['type'] == 'textarea') return "<textarea" . $attr . "></textarea>";
			else if($args['type'] == 'select') return self::select($args);
			else return "<input" . $attr . ">";
		}
		public static function label(){
			$args = func_get_args()[0];
			$attr_list = (isset($args[1]) ? self::attr_loop($args[1]) : '');
			$attr = '';
			if(is_object($attr_list)) foreach($attr_list as $v) $attr .= ' ' . $v;
			return "<label" . $attr . ">" . $args[0] . '</label>';
		}
		/**
		 * @method li()
		 * @description html <li> tag
		 * @see public
		 * @static
		 * @args[]
		 * @return string
		 */
		public static function li(){
			$args = func_get_args()[0];
			$attr_list = (isset($args[1]) ? self::attr_loop($args[1]) : '');
			$attr = '';
			if(is_object($attr_list)) foreach($attr_list as $v) $attr .= ' ' . $v;
			return "<li" . $attr . ">" . $args[0] . '</li>';
		}
		/**
		 * @method noscript(string $elem)
		 * @description html <noscript> tag
		 * @see public
		 * @static
		 * @param  string $elem noscript data
		 * @return string
		 */
		public static function noscript(string $elem){
			return '<noscript>' . $elem . '</noscript>';
		}
		/**
		 * @method nav(array $list, array $data = [] [ , $class = null [ , $str_func = 'ucwords' ]])
		 * @description html <nav> tag
		 * @see public
		 * @static
		 * @param  array  $list     
		 * @param  array  $data
		 * @param  [type] $class php class uses list
		 * @param  string $str_func php string function 
		 * @return string
		 */
		public static function nav(array $list, array $data = [], $class = null, $str_func = 'ucwords'){
			$page_list = ['index', 'home'];
			$replace_page = [
				'administration' => 'admin',
				'my account' => 'profil',
				'sheet music' => 'partitions'
			];
			$html = '';
			foreach($list as $k => $v){
				if(isset($replace_page[$v]) && !empty($replace_page[$v])) $v = $replace_page[$v];
				if(isset($data[$v]['url'])) $url = $data[$v]['url'];
				else if(is_object($class)) $url = $class->url($v);
				else $url = './' . (in_array($v, $page_list) ? '' : '?page=' . $v);
				$attr = [
					'class' => [
						$data['list']['class'] => $v
					]
				];
				$html .= self::li([self::a([$str_func($class->txt('page/' . $v)), ['href' => $url]]), $attr]);
			}
			$nav_attr = '';
			foreach($data as $k => $v) if(in_array($k, ['id', 'class'])) $nav_attr .= self::$k($v);
			return '<nav ' . $nav_attr . '><ul>' . $html . '</ul></nav>';
		}
		/**
		 * @method p()
		 * @description html <p> tag
		 * @see public
		 * @static
		 * @args[]
		 * @return string
		 */
		public static function p(){
			$args = func_get_args()[0];
			$attr_list = (isset($args[1]) ? self::attr_loop($args[1]) : '');
			$attr = '';
			if(is_object($attr_list)) foreach($attr_list as $v) $attr .= ' ' . $v;
			return "<p" . $attr . ">" . $args[0] . '</p>';
		}
		public static function select($data){
			$attr_list = (isset($data) ? self::attr_loop($data) : '');
			$attr = '';
			if(is_object($attr_list)) foreach($attr_list as $v) $attr .= ' ' . $v;
			return '<select' . $attr . '>' . self::select_list($data['data_list']) . '</select>';
		}
		private static function select_list($data){
			$html = '';
			foreach($data as $k => $v){
				if($k == 'optgroup'){
					$html .= self::optgroup($v);
				}else if($k == 'option'){
					foreach($v as $keys => $value){
						$attr = '';
						foreach($value as $key => $val){
							switch($key){
								case 'label': $attr .= ' ' . self::label_attr($value['label']); break;
								case 'value': $attr .= ' ' . self::value($value['value']); break;
								case 'disabled': $attr .= self::disabled($value['disabled']); break;
								case 'selected': $attr .= self::selected($value['selected']); break;
							}
						}
						$html .= self::option($value['txt'], $attr);
					}
				}else{
					$html .= '<option>ERROR : [ INVALID DATA ] : ' . $k . ' !</option>';
				}
			}
			return $html;
		}
		public static function optgroup(){
			$args = func_get_args()[0];
			$attr_list = (isset($args[1]) ? self::attr_loop($args[1]) : '');
			$option = $attr = '';
			if(is_object($attr_list)) foreach($attr_list as $v) $attr .= ' ' . $v;
			foreach($$args[0] as $k => $v) $option .= self::option($args[0]);
			return '<optgroup' . $attr . '>' . $option . '</optgroup>';	
		}
		public static function option($txt, $attr){
			return '<option' . $attr . '>' . ucfirst($txt) . '</option>';	
		}
		/**
		 * @method span()
		 * @description html <span> tag
		 * @see public
		 * @static
		 * @args[]
		 * @return string
		 */
		public static function span(){
			$args = func_get_args()[0];
			$attr_list = (isset($args[1]) ? self::attr_loop($args[1]) : '');
			$attr = '';
			if(is_object($attr_list)) foreach($attr_list as $v) $attr .= ' ' . $v;
			return "<span" . $attr . ">" . $args[0] . "</span>";
		}
		/**
		 * @method title_html($site, $page)
		 * @description html <title> tag
		 * @see public
		 * @static
		 * @param string $site site name
		 * @param string $page current page name
		 * @return string         
		 */
		public static function title_html(string $site, string $page){
			$html = '<title>'
				. ucwords($site) . ' - '
				. ucwords($page)
				. '</title>' . PHP_EOL
			;
			return $html;
		}

		/**
		 * @method get_form(array $from_infos, array $data [ , boolean $order = true ])
		 * @description html build form
		 * @see public
		 * @static
		 * @return string
		 */
		public static function get_form($form_data, $data, $order = true){
			global $secu;
			$html = '';
			if(isset($data['page']) && !empty($data['page'])) $html .= self::input(['type' => 'hidden', 'name' => 'page', 'value' => $data['page']]);
			if(isset($data['action']) && !empty($data['action'])) $html .= self::input(['type' => 'hidden', 'name' => 'action', 'value' => $data['action']]);
			if($secu->is_token_active()) $html .= $secu->token();
			$html .= isset($data['required_label_info']) ? self::get_form_require($data['required_label_info']) : '';
			$html .= self::form_loop($data['data'], $order);
			if(isset($data['submit']) && !empty($data['submit'])) $html .= self::submit($data['submit']);
			return self::form([$html, $form_data]);
		}
		private static function form_loop($data, $order, $loop = true, $multi = false){
			$html = '';
			if($loop){
				foreach($data as $k => $v){
					if(is_array($v)){
						// $html .= '<h2>' . $k . '</h2>';
						if((isset($v['input']) || isset($v['label']) || isset($v['infos']))){
							if(isset($v['label'], $v['input'])) $input = self::label_input($v['label'], $v['input'], $order);
							else if(isset($v['label'])) $input = self::label($v['label']);
							else if(isset($v['input'])) $input = self::input($v['input']);
							else if(isset($v['img'])) $input = self::img($v['img']);
							else $input = '<p class=red>ERROR : [ NO VALID DATA ] : ' . $k . ' !</p>';
							$html .= self::div([$input, ['class' => ['form-group']]]);
						}else{
							$elem = self::form_loop($data[$k], $order, false, $multi);
							$html .= self::div([$elem, ['class' => ['form-group']]]);
						}
					} else return '<p class=red>ERROR : NO VALID DATA !</p>';
				}	
			}else{
				foreach($data as $k => $v){
					if(is_array($v)){
						if((isset($v['input']) || isset($v['label']) || isset($v['infos']))){
							if(isset($v['label'], $v['input'])) $input = self::label_input($v['label'], $v['input'], $order);
							else if(isset($v['label'])) $input = self::label($v['label']);
							else if(isset($v['input'])) $input = self::input($v['input']);
							else if(isset($v['img'])) $input = self::img($v['img']);
							else $input = '<p class=red>ERROR : [ NO VALID DATA ] : ' . $k . ' !</p>';
							$html .= self::p([$input, ['id' => $k . '_p']]);
						}elseif(is_array($v)){
							$html .= self::form_loop($v, $order, false, $multi);
						}
					} else $html .= $v;
				}
			}
			return $html;
		}
		public static function get_form_require($data){
			$html = '';
			foreach($data as $k => $v){
				$html .= self::$k($v);
			}
			return $html;
		}
		/**
		 * @method label_input(array $label_data, array $input_data [ , boolean $order = true ])
		 * @description html build label + input or reverse
		 * @see public
		 * @static
		 * @return string
		 */
		public static function label_input($label_data, $input_data, $order = true){
			$label = self::label($label_data);
			$input = self::input($input_data);
			if($order) $html = $label . $input;
			else $html = $input . $label;
			return $html;
		}
		public static function submit($data){
			if($data['elem'] == 'button') $send = self::button([$data['value'], $data['send']]);
			else if($data['elem'] == 'input') $send = self::input($data['send']);
			return self::div([$send, $data['div']]);
		}
		/**
		 * @method get_meta()
		 * @description html meta tag
		 * @see public
		 * @static
		 * @return string
		 * @uses class [Config], file [config.ini]
		 */
		private function get_meta(){
			$meta = $this->site_infos['meta'];
			$conf = parent::get('ini', 'CONFIG');
			$html = "<meta charset='" . $this->site_infos['CHARSET'] . "'>" . PHP_EOL;
			foreach($meta as $k => $v){
				if(preg_match("/^http-equiv_refresh/", $k)){
					if($conf['refresh']){
						$split = explode('*', $conf['refresh_default_time']);
						$result = 1;
						for($i = 0; $i < count($split); $i++) $result *= (int) $split[$i];
						$time = $result;
						$split = explode('_', $k);
						$html .= '<meta ' . $split[0] . '="' . $split[1] . '" content="' . $time . $v . '">' . PHP_EOL;
					}
				}else if(preg_match("/^http-equiv/", $k) && !empty($v)){
					$split = explode('_', $k);
					$html .= '<meta ' . $split[0] . '="' . $split[1] . '" content="' . $v . '">' . PHP_EOL;
				}else{
					$html .= '<meta name="' . $k . '" content="' . $v . '">' . PHP_EOL;
				}
			}
			return $html;
		}
		public static function meta_http_equiv(string $elem, string $content){
			return '<meta http-equiv="' . $elem . '" content="' . $content . '">';
		}
		public static function get_musicos(){
			global $site;
			$args = func_get_args()[0];
			$firstname 	= $args['firstname'];
			$lastname 	= $args['lastname'];
			$instrument = $args['instru'];
			$fonctions 	= $args['fonction'];
			return HTML::div([
				HTML::figure([
					HTML::img([
						'object' => ['site' => $site],
						'url' => $args['url'],
						'alt' => 'url',
						'class' => ['img_fiche_musicos']
					])
				])
				. HTML::div([
					HTML::p([
						$firstname 
						. ' ' 
						. $lastname, 
						['class' => ['names']]
					]) 
					. HTML::p([
						$instrument, 
						['class' => ['instru']]
					]) 
					. HTML::p([
						$fonctions, 
						['class' => ['functions']]
					]),
					['class' => ['infos']]
				]), 
				['class' => ['musicos']]
			]);
		}
		private function get_favicon(){
			$icon = parent::get('ini', 'SITE')['FAVICON'];
			$html = '<link rel="shortcut icon" type="image/x-icon" href="' . $icon . '">' . PHP_EOL;
			return $html;
		}
		
		/**
		 * @method fa_icon()
		 * @description build fa-icon only, with button
		 * @see public
		 * @static
		 * @args[]
		 * @return string         
		 */
		public static function fa_icon(){
			$args = func_get_args()[0];
			// var_dump($args['i'], $args['button']);
			// var_dump(self::i($args['i']));
			// return self::i($args['i']);
			if(isset($args['i'])) $i = self::i($args['i']);
			if(isset($args['button'], $args['i'])){
				array_unshift($args['button'], $i);
				$button_i = self::button($args['button']);
			}
			if(isset($args['i'], $args['button'])) return $button_i;
			// else if(isset($args['button'])) return $button;
			// else if(isset($args['i'])) return $i;
		}
		/**
		 * @method pager(int $current, int $pages)
		 * @description build pager
		 * @see public
		 * @static
		 * @param integer $current number of current page
		 * @param integer $pages number of occurence pages
		 * @return string         
		 */
		public static function pager(int $current, int $pages){
			$html = '< ' . $current . '/' . $pages . ' >';
			return self::div([$html, ['class' => ['pager']]]);
		}
	}
?>