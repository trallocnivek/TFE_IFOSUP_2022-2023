<?php
	/**
	 * @class HTML
	 * @static
	 * @description HTML generator
	 * @property
	 * 	[static private]
	 * 		- $html_attrs
	 * 		- $html_tags
	 * 		- $charset_type
	 * 		- $a_attr
	 * 		- $abbr_attr
	 * 		- $area_attr
	 * 		- $audio_attr
	 * 		- $base_attr
	 * 		- $bdo_attr
	 * 		- $blockquote_attr
	 * 		- $data_attr
	 * 		- $datalist_attr
	 * 		- $dialog_attr
	 * 		- $embed_attr
	 * 		- $form_attr
	 * 		- $html_attr
	 * 		- $iframe_attr
	 * 		- $img_attr
	 * 		- $input_attr
	 * 		- $label_attr
	 * 		- $link_attr
	 * 		- $map_attr
	 * 		- $meter_attr
	 * 		- $object_attr
	 * 		- $optgroup_attr
	 * 		- $option_attr
	 * 		- $output_attr
	 * 		- $param_attr
	 * 		- $progress_attr
	 * 		- $select_attr
	 * 		- $source_attr
	 * 		- $textarea_attr
	 * 		- $time_attr
	 * 		- $track_attr
	 * 		- $video_attr
	 * 		- $form_elem
	 * 		- $nav_elem
	 * 	[static public]
	 * @method
	 * 	[magic private]
	 * 		- __construct()
	 * 		- __clone()
	 * 	[static public]
	 * 		- get()
	 * 		- css()
	 * 	[static private]
	 * 		- get_html_attrs()
	 * 		- get_attr()
	 * 		- get_attr_infos()
	 * 		- get_self_attr()
	 * 		- get_bimode_attr()
	 * 		- get_assoc_attr()
	 * 		- get_html_tag()
	 * 		- get_tag()
	 * 		- get_doctype_html()
	 * 		- get_simple_tag_html()
	 * 		- get_double_tag_html()
	 * 		- get_comment_html()
	 * 		- debug()
	 * @uses class [CSS], function [url_data()]
	 * @api HTML 5
	 * @author Collart Kevin
	 * @version 2020/10/19 TO 08H20
	 */
	class HTML{
		// PROPERTY ZONE
		/**
		 * @property $html_attrs
		 * @var array
		 * @see private
		 * @static
		 * @description list of html attributes with attribute infos
		 */
		static private $html_attrs = [
			'assoc' => [
			// A
				'accept' => [
					'elem' => ['input[file]'],
					'val' => ['STRING', 'file_extension', 'audio/*', 'video/*', 'image/*', 'media_type'],
					'browser' => [
						'chrome' => '26.0',
						'IE' => '10.0',
						'firefox' => '37.0',
						'safari' => '11.1',
						'opera' => '15.0'
					]
				],
				'accept-charset' => [
					'elem' => ['form'],
					'val' => ['charset_type']
				],
				'accesskey' => [
					'elem' => ['ALL'],
					'val' => ['STRING']
				],
				'action' => [
					'elem' => ['form'],
					'val' => ['URL']
				],
				'alt' => [
					'elem' => ['area', 'img', 'input[img]'],
					'val' => ['STRING']
				],
				'autocomplete' => [
					'elem' => ['form', 'input[text,search,url,tel,email,password,date,datetime-local,month,time,week,range,color]'],
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
					'elem' => ['ALL'],
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
					'elem' => ['ALL'],
					'val' => ['true', 'false']
				],
				'contextmenu' => [
					'elem' => ['ALL'],
					'val' => ['STRING']
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
					'elem' => ['ALL'],
					'val' => ['STRING']
				],
				'datetime' => [
					'elem' => ['del', 'ins', 'time'],
					'val' => ['ALL_DATE_FORMATS']
				],
				'dir' => [
					'elem' => ['ALL'],
					'val' => ['ltr', 'rtl', 'auto']
				],
				'dirname' => [
					'elem' => ['input', 'textarea'],
					'val' => ['*.dir']
				],
				'draggable' => [
					'elem' => ['ALL'],
					'val' => ['true', 'false']
				],
			// E
				'enctype' => [
					'elem' => ['form'],
					'val' => ['	application/x-www-form-urlencoded', 'multipart/form-data', 'text/plain']
				],
			// F
				'for' => [
					'elem' => ['label', 'output'],
					'val' => ['STRING']
				],
				'form' => [
					'elem' => ['button', 'fieldset', 'input', 'label', 'meter', 'object', 'output', 'select', 'textarea'],
					'val' => ['STRING']
				],
				'formaction' => [
					'elem' => ['button[submit]', 'input[submit]'],
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
				'headers' => [
					'elem' => ['td', 'th'],
					'val' => ['STRING']
				],
				'height' => [
					'elem' => ['canvas', 'embed', 'iframe', 'img', 'input', 'object', 'video'],
					'val' => ['NUMBER']
				],
				'high' => [
					'elem' => ['meter'],
					'val' => ['NUMBER']
				],
				'href' => [
					'elem' => ['a', 'area', 'base', 'link'],
					'val' => ['URL']
				],
				'hreflang' => [
					'elem' => ['a', 'area', 'link'],
					'val' => ['URL']
				],
				'http-equiv' => [
					'elem' => ['meta'],
					'val' => ['STRING']
				],				
			// I
				'id' => [
					'elem' => ['ALL'],
					'val' => ['STRING']
				],
			// J
			// K
				'kind' => [
					'elem' => ['track'],
					'val' => ['STRING']
				],
			// L
				'label' => [
					'elem' => ['track', 'option', 'optgroup'],
					'val' => ['STRING']
				],
				'lang' => [
					'elem' => ['ALL'],
					'val' => ['STRING']
				],
				'list' => [
					'elem' => ['input'],
					'val' => ['STRING']
				],
				'low' => [
					'elem' => ['meter'],
					'val' => ['NUMBER']
				],
			// M
				'max' => [
					'elem' => ['input', 'meter', 'progress'],
					'val' => ['NUMBER', 'DATE']
				],
				'maxlength' => [
					'elem' => ['input[text,search,url,tel,email,password]', 'textarea'],
					'val' => ['NUMBER']
				],
				'media' => [
					'elem' => ['a', 'area', 'link', 'source', 'style'],
					'val' => ['STRING']
				],
				'min' => [
					'elem' => ['input', 'meter'],
					'val' => ['NUMBER', 'DATE']
				],
				'minlength' => [
					'elem' => ['input[text,search,url,tel,email,password]', 'textarea'],
					'val' => ['NUMBER']
				],
				'method' => [
					'elem' => ['form'],
					'val' => ['get', 'post']
				],
			// N
				'name' => [
					'elem' => ['button', 'fieldset','form', 'iframe', 'input', 'map', 'meta', 'object', 'output', 'param', 'select', 'textarea'],
					'val' => ['STRING']
				],
			// O
				'onabord' => [
					'elem' => ['audio', 'embed', 'img', 'object', 'video'],
					'val' => ['JS_STRING']
				],
				'onafterprint' => [
					'elem' => ['body'],
					'val' => ['JS_STRING']
				],
				'onbeforeprint' => [
					'elem' => ['body'],
					'val' => ['JS_STRING']
				],
				'onbeforeunload' => [
					'elem' => ['body'],
					'val' => ['JS_STRING']
				],
				'onblur' => [
					'elem' => ['ALL'],
					'val' => ['JS_STRING']
				],
				'oncanplay' => [
					'elem' => ['audio', 'embed', 'object', 'video'],
					'val' => ['JS_STRING']
				],
				'oncanplaythrough' => [
					'elem' => ['audio', 'video'],
					'val' => ['JS_STRING']
				],
				'onchange' => [
					'elem' => ['ALL'],
					'val' => ['JS_STRING']
				],
				'onclick' => [
					'elem' => ['ALL'],
					'val' => ['JS_STRING']
				],
				'oncontextmenu' => [
					'elem' => ['ALL'],
					'val' => ['JS_STRING']
				],
				'oncopy' => [
					'elem' => ['ALL'],
					'val' => ['JS_STRING']
				],
				'oncuechange' => [
					'elem' => ['track'],
					'val' => ['JS_STRING']
				],
				'oncut' => [
					'elem' => ['ALL'],
					'val' => ['JS_STRING']
				],
				'ondblclick' => [
					'elem' => ['ALL'],
					'val' => ['JS_STRING']
				],
				'ondrag' => [
					'elem' => ['ALL'],
					'val' => ['JS_STRING']
				],
				'ondragend' => [
					'elem' => ['ALL'],
					'val' => ['JS_STRING']
				],
				'ondragenter' => [
					'elem' => ['ALL'],
					'val' => ['JS_STRING']
				],
				'ondragleave' => [
					'elem' => ['ALL'],
					'val' => ['JS_STRING']
				],
				'ondragover' => [
					'elem' => ['ALL'],
					'val' => ['JS_STRING']
				],
				'ondragstart' => [
					'elem' => ['ALL'],
					'val' => ['JS_STRING']
				],
				'ondrop' => [
					'elem' => ['ALL'],
					'val' => ['JS_STRING']
				],
				'ondurationchange' => [
					'elem' => ['audio', 'video'],
					'val' => ['JS_STRING']
				],
				'onemptied' => [
					'elem' => ['audio', 'video'],
					'val' => ['JS_STRING']
				],
				'onended' => [
					'elem' => ['audio', 'video'],
					'val' => ['JS_STRING']
				],
				'onerror' => [
					'elem' => ['audio', 'body', 'embed', 'img', 'object', 'script', 'style', 'video'],
					'val' => ['JS_STRING']
				],
				'onfocus' => [
					'elem' => ['ALL'],
					'val' => ['JS_STRING']
				],
				'onhashchange' => [
					'elem' => ['body'],
					'val' => ['JS_STRING']
				],
				'oninput' => [
					'elem' => ['ALL'],
					'val' => ['JS_STRING']
				],
				'oninvalid' => [
					'elem' => ['ALL'],
					'val' => ['JS_STRING']
				],
				'onkeydown' => [
					'elem' => ['ALL'],
					'val' => ['JS_STRING']
				],
				'onkeypress' => [
					'elem' => ['ALL'],
					'val' => ['JS_STRING']
				],
				'onkeyup' => [
					'elem' => ['ALL'],
					'val' => ['JS_STRING']
				],
				'onload' => [
					'elem' => ['body', 'iframe', 'img', 'input', 'link', 'script', 'style'],
					'val' => ['JS_STRING']
				],
				'onloadeddata' => [
					'elem' => ['audio', 'video'],
					'val' => ['JS_STRING']
				],
				'onloadedmetadata' => [
					'elem' => ['audio', 'video'],
					'val' => ['JS_STRING']
				],
				'onloadstart' => [
					'elem' => ['audio', 'video'],
					'val' => ['JS_STRING']
				],
				'onmousedown' => [
					'elem' => ['ALL'],
					'val' => ['JS_STRING']
				],
				'onmousemove' => [
					'elem' => ['ALL'],
					'val' => ['JS_STRING']
				],
				'onmouseout' => [
					'elem' => ['ALL'],
					'val' => ['JS_STRING']
				],
				'onmouseover' => [
					'elem' => ['ALL'],
					'val' => ['JS_STRING']
				],
				'onmouseup' => [
					'elem' => ['ALL'],
					'val' => ['JS_STRING']
				],
				'onmousewheel' => [
					'elem' => ['ALL'],
					'val' => ['JS_STRING']
				],
				'onoffline' => [
					'elem' => ['body'],
					'val' => ['JS_STRING']
				],
				'ononline' => [
					'elem' => ['body'],
					'val' => ['JS_STRING']
				],
				'onpagehide' => [
					'elem' => ['body'],
					'val' => ['JS_STRING']
				],
				'onpageshow' => [
					'elem' => ['body'],
					'val' => ['JS_STRING']
				],
				'onpaste' => [
					'elem' => ['ALL'],
					'val' => ['JS_STRING']
				],
				'onpause' => [
					'elem' => ['audio', 'video'],
					'val' => ['JS_STRING']
				],
				'onplay' => [
					'elem' => ['audio', 'video'],
					'val' => ['JS_STRING']
				],
				'onplaying' => [
					'elem' => ['audio', 'video'],
					'val' => ['JS_STRING']
				],
				'onpopstate' => [
					'elem' => ['body'],
					'val' => ['JS_STRING']
				],
				'onprogress' => [
					'elem' => ['audio', 'video'],
					'val' => ['JS_STRING']
				],
				'onratechange' => [
					'elem' => ['audio', 'video'],
					'val' => ['JS_STRING']
				],
				'onreset' => [
					'elem' => ['form'],
					'val' => ['JS_STRING']
				],
				'onresize' => [
					'elem' => ['body'],
					'val' => ['JS_STRING']
				],
				'onscroll' => [
					'elem' => ['ALL'],
					'val' => ['JS_STRING']
				],
				'onsearch' => [
					'elem' => ['input'],
					'val' => ['JS_STRING']
				],
				'onseeked' => [
					'elem' => ['audio', 'video'],
					'val' => ['JS_STRING']
				],
				'onseeking' => [
					'elem' => ['audio', 'video'],
					'val' => ['JS_STRING']
				],
				'onselect' => [
					'elem' => ['ALL'],
					'val' => ['JS_STRING']
				],
				'onstalled' => [
					'elem' => ['audio', 'video'],
					'val' => ['JS_STRING']
				],
				'onstorage' => [
					'elem' => ['body'],
					'val' => ['JS_STRING']
				],
				'onsubmit' => [
					'elem' => ['form'],
					'val' => ['JS_STRING']
				],
				'onsuspend' => [
					'elem' => ['audio', 'video'],
					'val' => ['JS_STRING']
				],
				'ontimeupdate' => [
					'elem' => ['audio', 'video'],
					'val' => ['JS_STRING']
				],
				'ontoggle' => [
					'elem' => ['details'],
					'val' => ['JS_STRING']
				],
				'onunload' => [
					'elem' => ['body'],
					'val' => ['JS_STRING']
				],
				'onvolumechange' => [
					'elem' => ['audio', 'video'],
					'val' => ['JS_STRING']
				],
				'onwaiting' => [
					'elem' => ['audio', 'video'],
					'val' => ['JS_STRING']
				],
				'onwheel' => [
					'elem' => ['ALL'],
					'val' => ['JS_STRING']
				],
				'open' => [
					'elem' => ['details'],
					'val' => ['JS_STRING']
				],
				'optimum' => [
					'elem' => ['meter'],
					'val' => ['JS_STRING']
				],
			// P
				'pattern' => [
					'elem' => ['input'],
					'val' => ['REGEXP']
				],
				'ping' => [
					'elem' => ['a'],
					'val' => ['URL']
				],
				'placeholder' => [
					'elem' => ['input', 'textarea'],
					'val' => ['STRING']
				],
				'poster' => [
					'elem' => ['video'],
					'val' => ['URL']
				],
				'preload' => [
					'elem' => ['audio', 'video'],
					'val' => ['STRING']
				],
			// Q
			// R
				'rel' => [
					'elem' => ['a', 'area', 'form', 'link'],
					'val' => ['external', 'help', 'license', 'next', 'nofollow', 'noopener', 'noreferer', 'opener', 'prev', 'search']
				],
				'rows' => [
					'elem' => ['textarea'],
					'val' => ['NUMBER']
				],
				'rowspan' => [
					'elem' => ['td', 'th'],
					'val' => ['']
				],
			// S
				'scope' => [
					'elem' => ['th'],
					'val' => ['col', 'row', 'colgroup', 'rowgroup']
				],
				'shape' => [
					'elem' => ['area'],
					'val' => ['default', 'rect', 'circle', 'poly']
				],
				'size' => [
					'elem' => ['input', 'select'],
					'val' => ['NUMBER']
				],
				'sizes' => [
					'elem' => ['img', 'link', 'source'],
					'val' => ['any', 'HEIGHTxWIDTH']
				],
				'span' => [
					'elem' => ['col', 'colspan'],
					'val' => ['NUMBER']
				],
				'spellcheck' => [
					'elem' => ['ALL'],
					'val' => ['true', 'false']
				],
				'src' => [
					'elem' => ['audio', 'embed', 'iframe', 'img', 'input', 'script', 'source', 'track', 'video'],
					'val' => ['URL']
				],
				'srcdoc' => [
					'elem' => ['iframe'],
					'val' => ['URL']
				],
				'srclang' => [
					'elem' => ['track'],
					'val' => ['URL']
				],
				'srcset' => [
					'elem' => ['img', 'source'],
					'val' => ['URL']
				],
				'start' => [
					'elem' => ['ol'],
					'val' => ['NUMBER']
				],
				'step' => [
					'elem' => ['input'],
					'val' => ['NUMBER']
				],
				'style' => [
					'elem' => ['ALL'],
					'val' => ['CSS']
				],
			// T
				'tabindex' => [
					'elem' => ['ALL'],
					'val' => ['NUMBER']
				],
				'target' => [
					'elem' => ['a', 'area', 'base', 'form'],
					'val' => ['_blank', '_self', '_parent', '_top']
				],
				'title' => [
					'elem' => ['ALL'],
					'val' => ['STRING']
				],
				'translate' => [
					'elem' => ['ALL'],
					'val' => ['yes', 'no']
				],
				'type' => [
					'elem' => ['a', 'button', 'embed', 'input', 'link', 'menu', 'object', 'script', 'source', 'style'],
					'val' => [
						'button', 'checkbox', 'color', 'date', 'datetime-local', 'email', 'file', 'hidden', 'image', 'month',
						'number', 'password', 'radio', 'range', 'reset', 'search', 'submit', 'tel', 'text', 'time', 'url', 'week'
					]
				],
			// U
				'usemap' => [
					'elem' => ['img', 'object'],
					'val' => ['#STRING']
				],
			// V
				'value' => [
					'elem' => ['button', 'input', 'li', 'option', 'meter', 'progress', 'param'],
					'val' => ['STRING']
				],
			// W
				'width' => [
					'elem' => ['canvas', 'embed', 'iframe', 'img', 'input', 'object', 'video'],
					'val' => ['NUMBER']
				],
				'wrap' => [
					'elem' => ['textarea'],
					'val' => ['hard', 'soft']
				],
			// X // Y
			// Z
			],
			'self' => [
			// A
				'async' => ['script'],
				'autofocus' => ['button', 'input', 'select', 'textarea'],
				'autoplay' => ['audio', 'video'],
			// B
			// C
				'checked' => ['input[chackbox,radio]'],
				'controls' => ['audio', 'video'],
			// D
				'default' => ['track'],
				'defer' => ['script'],
				'disabled' => ['button', 'fieldset', 'input', 'optgroup', 'option', 'select', 'textarea'],
			// E
			// F
				'formnovalidate' => ['input'],
			// G
			// H
				'hidden' => ['ALL'],
			// I
				'ismap' => ['img'],
			// J // K
			// L
				'loop' => ['audio', 'video'],
			// M
				'multiple' => ['input', 'select'],
				'muted' => ['audio', 'video'],
			// N
				'novalidate' => ['form'],
			// O // P // Q
			// R
				'readonly' => ['input', 'textarea'],
				'required' => ['input', 'select', 'textarea'],
				'reversed' => ['ol'],
			// S
				'sandbox' => ['iframe'],
				'selected' => ['option'],
			// T // U // V // W // X // Y // Z
			],
			'bimode' => [
			// A // B // C
			// D
				'download' => [
					'self' => ['a'],
					'assoc' => [
						'elem' => ['area'],
						'val' => ['STRING']
					]
				],
			// E // F // G // H // I // J // K // L // M // N // O // P // Q // R // S // T // U // V // W // X // Y // Z
			],
			'deprecated' => [
				'align' => ['CSS' => ['text-align']],
				'bgcolor' => ['CSS' => ['background-color']],
				'border' => ['CSS' => ['border']],
				'color' => ['CSS' => ['color']]
			]
		];
		/**
		 * @property $html_tags
		 * @var array
		 * @see private
		 * @static
		 * @description list of html tags
		 */
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
				'!DOCTYPE html', '!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd"'
			],
			'deprecated' => [
				'acronym' => ['abbr'],
				'applet' => ['embed', 'object'],
				'basefont' => ['CSS' => ['color', 'font-family', 'font-size']],
				'big' => ['CSS' => ['font-size']],
				'center' => ['CSS' => ['text-align: center;']],
				'dir' => ['ul'],
				'font' => ['CSS' => ['color', 'font-family', 'font-size']],
				'frame' => ['iframe'],
				'frameset' => ['iframe'],
				'noframe' => ['iframe'],
				'strike' => ['del', 's'],
				'tt' => ['CSS' => ['font-family']]
			]
		];
		// MAGIC METHOD ZONE
		private function __construct(){}
		private function __clone(){}
		// GET ZONE
		/**
		 * @method get(string $method, $value = null)
		 * @see private
		 * @static
		 * @description get 'get_' method
		 * @return array
		 */
		public static function get(string $method, $value = null){
			if(method_exists(__CLASS__, $method)) return self::$method($value);
			else if(method_exists(__CLASS__, 'get_' . $method)) return self::{'get_' . $method}($value);
			else return self::debug('html method not exist', 'HTML::' . $method . '()', !empty($v) ? $v : 'no param');
		}
		// HTML ATTRIBUTE ZONE
		/**
		 * @method get_html_attrs()
		 * @see private
		 * @static
		 * @description get $html_attrs
		 * @return array
		 */
		public static function get_html_attrs(){
			return self::$html_attrs;
		}
		private static function get_attr($data){
			$attr = '';
			// var_dump($data);
			foreach($data['attr'] as $k => $v){
				if(array_key_exists($k, self::$html_attrs['assoc'])) $attr .= self::get_assoc_attr($k, $v);
				else if(array_key_exists($v, self::$html_attrs['self'])) $attr .= self::get_self_attr($v);
				else if(array_key_exists($k, self::$html_attrs['bimode'])) $attr .= self::get_bimode_attr($k, $v);
				else if(array_key_exists($v, self::$html_attrs['bimode'])) $attr .= self::get_bimode_attr($v);
				else if(array_key_exists($k, self::$html_attrs['deprecated'])) self::get_deprecated_attr($data['attr'], $k);
				else if(array_key_exists($v, self::$html_attrs['deprecated'])) self::get_deprecated_attr($data['attr'], $v);
				else self::debug('attribute not exist', $k, !empty($v) ? $v : 'no value');
			}
			return $attr;
		}
		private static function in_attr_tag($k, $v){
			$infos = self::get_attr_infos();
		}
		private static function get_attr_infos($type, $attr){
			if($type == 'self'){ return self::$html_attrs['self'][$attr];
			}else if($type == 'bimode_self'){ return self::$html_attrs['bimode']['self'][$attr];
			}else if($type == 'bimode_assoc'){ return self::$html_attrs['bimode'][$attr]['assoc'];
			}else if($type == 'assoc'){ return self::$html_attrs['assoc'][$attr];
			}else if($type == 'deprecated'){ self::debug('deprecated attribute', $attr, 'SEE NEXT VAR_DUMP');
			}else debug('no attribute infos', $type, $attr);
		}
		private static function get_deprecated_attr($data, $k){
			echo '-----------------------------------------------------------------------------------------------------------' . PHP_EOL;
			self::get_attr_infos('deprecated', $k);
			echo 'A remplacer par: ';
			var_dump(self::$html_attrs['deprecated'][$k]);
			echo '-----------------------------------------------------------------------------------------------------------' . PHP_EOL;
			exit;
		}
		private static function get_self_attr(string $attr, $space = true){
			// if(self::in_attr_tag()){

				return ($space ? ' ' : '') . $attr;
			// }else return '';
		}
		private static function get_bimode_attr(string $attr, $val = null, $space = true){
			return ($space ? ' ' : '') . $attr . (!empty($val) ? '="' . $val . '"' : '');
		}
		private static function get_assoc_attr(string $attr, string $val, $space = true){
			return ($space ? ' ' : '') . $attr . '="' . $val . '"';
		}
		// HTML TAG ZONE
		/**
		 * @method get_html_tags()
		 * @see private
		 * @static
		 * @description get $html_tags
		 * @return array
		 */
		public static function get_html_tags(){
			return self::$html_tags;
		}
		private static function get_tag(array $data){
			$key_list = ['tag', 'attr', 'content', 'index'];
			$html = '';
			foreach($data as $k => $v){
				if(is_string($k) && in_array($k, $key_list)){
					if($k == 'tag' && in_array($v, self::$html_tags['simple'])) 
						$html .= self::get_simple_tag_html($data);
					else if($k == 'tag' && in_array($v, self::$html_tags['double'])) 
						$html .= self::get_double_tag_html($data);
					else if($k == 'tag' && (in_array($v, self::$html_tags['comment']) || preg_match("/(<!-- ?|comment)/", $v))) 
						$html .= self::get_comment_html($data['content']);
					else if($k == 'tag' && (in_array($v, self::$html_tags['doctype']) || $v == 'doctype')) 
						$html .= self::get_doctype_html(!empty($data['index']) ? $data['index'] : 0);
					else if($k == 'tag' && array_key_exists($v, self::$html_tags['deprecated'])) 
						$html .= self::get_deprecated_html($v);
				}else $html .= self::get_tag($v) . PHP_EOL;
			}
			return $html;
		}
		private static function get_deprecated_html($tag){
			echo '<br>';
			echo '-----------------------------------------------------------------------------------------------------------<br>';
			echo 'Remplacer le tag < ' . $tag . ' > par :';
			var_dump(self::$html_tags['deprecated'][$tag]);
			echo '-----------------------------------------------------------------------------------------------------------<br>';
			exit;
		}
		/**
		 * @method get_doctype_html(int $index = 0)
		 * @see private
		 * @static
		 * @description build html doctype
		 * @param int $index array index
		 * @return html
		 */
		private static function get_doctype_html(int $index = 0){
			return '<' . self::$html_tags['doctype'][!empty($index) ? $index : 0] . '>';
		}
		/**
		 * @method get_simple_tag_html(array $data = [])
		 * @see private
		 * @static
		 * @description build html orphelin tag
		 * @param array $data tag infos ['tag' => 'html tag', 'attr' => [attr list]]
		 * @return html
		 */
		private static function get_simple_tag_html(array $data = []){
			$attr = !empty($data['attr']) ? self::get('attr', $data) : '';
			return '<' . $data['tag'] . $attr . '>';
		}
		/**
		 * @method get_double_tag_html(array $data = [])
		 * @see private
		 * @static
		 * @description build html normal tag
		 * @param array $data tag infos ['tag' => 'html tag', 'attr' => [attr list]]
		 * @return html
		 */
		private static function get_double_tag_html(array $data = []){
			$attr = !empty($data['attr']) ? self::get('attr', $data) : '';
			return '<' . $data['tag'] . $attr . '>' . (!empty($data['content']) ? $data['content'] : '') . '</' . $data['tag'] . '>';
		}
		// HTML COMMENT ZONE
		/**
		 * @method get_comment_html(string $comment)
		 * @see private
		 * @static
		 * @description build html comment
		 * @param string $comment
		 * @return html
		 */
		private static function get_comment_html(string $comment){
			return self::$html_tags['comment'][0] . $comment . self::$html_tags['comment'][1];
		}
		// CSS ZONE
		public static function css($data){
			if(class_exists('CSS')){
				if(is_array($data)){
					$css = '';
					foreach($data as $k => $v){
						if(method_exists("CSS", 'get_' . $k)){
							$css .= CSS::get($k, $v);
						}
					}
				}else{
					return $data;
				}
			}
		}
		// HTML BUILD ZONE
		/**
		 * @method topbar(multi $content)
		 * @see public
		 * @static
		 * @description build topbar before header
		 * @param multi $content content topbal
		 * @return html
		 */
		public static function topbar($content){
			return self::get_double_tag_html([
				'tag' => 'div',
				'attr' => [
					'id' => 'topbar'
				],
				'content' => $content
			]);
		}
		/**
		 * @method header(multi $content, array $attr)
		 * @see public
		 * @static
		 * @description build header
		 * @param multi $content 	content header
		 * @param array $attr 		attribute list
		 * @return html
		 */
		public static function header($content, array $attr){
			return self::get_double_tag_html([
				'tag' => 'header',
				'attr' => $attr,
				'content' => $content
			]);	
		}
		public static function nav($type_nav, $data){
			$list = '';
			foreach($data as $k => $v){
				$list .= self::get_double_tag_html([
					'tag' => 'li',
					'attr' => [
						'class' => 'pointer ' . ($k == 'page' && url_data('page') == $data[$k] ? 'active' : '')
					],
					'content' => self::get_double_tag_html([
						'tag' => 'a',
						'attr' => [
							'href' => (preg_match("/(url|href|src)/i", $k) && !empty($v) && is_string($v) ? $v : ''),
							'class' => url_data('page') == '' ? 'active' : ''
						],
						'content' => ''
					])
				]);
			}
			return self::get_double_tag_html([
				'tag' => 'nav',
				'attr' => [
					'id' => $type_nav
				],
				'content' => self::get_double_tag_html([
					'tag' => 'ul',
					'attr' => [],
					'content' => $list
				])
			]);
		}
		/**
		 * @method footer(array $footer, prefooter = null)
		 * @see public
		 * @static
		 * @description build footer
		 * @param array $footer
		 * @param array $prefooter [optional]
		 * @return html
		 */
		public static function footer(array $footer, $prefooter = null){
			$prefoot = !empty($prefooter) ? self::get_tag($prefooter) : '';
			return self::get_double_tag_html([
				'tag' => 'footer',
				'attr' => $footer['attr'],
				'content' => PHP_EOL . $prefoot . $footer['content']
			]);
		}
		public static function form($form, $data, $button){
			$content = self::get_tag($data);
			$content .= self::form_button($button);
			$attr_list = [
				'accept-charset' => 'utf-8', 
				'action' => $_SERVER['PHP_SELF'], 
				'autocomplete' => 'on', 
				'enctype' => 'application/x-www-form-urlencoded', 
				'method' => 'post', 
				'name' => null, 
				'novalidate' => false, 
				'rel' => null, 
				'target' => '_self'
			];
			$attr = [];
			foreach($attr_list as $k => $v){
				$x = '';
				array_push($attr, $x);
			}
			return self::get_double_tag_html([
				'tag' => 'form',
				'attr' => $attr,
				'content' => $content
			]);
		}
		public static function gallery_list(){}
		public static function gallery(){}
		public static function table($attr, $data){
			$content = '';
			foreach($data as $key => $val){
				$list = '';
				foreach($val as $k => $v){
					$list .= self::get_double_tag_html([
						'tag' => $v['tag'],
						'attr' => $v['attr'],
						'content' => $v['content']
					]);
				}
				$content .= self::get_double_tag_html([
					'tag' => 'tr',
					'attr' => [],
					'content' => $list
				]);
			}
			return self::get_double_tag_html([
				'tag' => 'table',
				'attr' => [],
				'content' => $content
			]);
		}
		public static function musician_fiche(){}
		public static function demo_sound(){}
		public static function demo_video(){}
		public static function lang_list(){}
		public static function form_button($data){
			$html = '';
			foreach($data as $k => $v){
				if(is_string($k)){
					$tag = $k == 'tag' && !empty($data[$k]) ? $v : 'input';
					$attr = self::get_attr($k == 'attr' && $v);
					if($tag == 'input' && !isset($data['attr']['value']) && !empty($data['content'])) array_push($attr, ['value' => $data['content']]);
					$data = [
						'tag' => $tag,
						'attr' => $attr
					];
					if($tag == 'button' && !empty($data['content'])) array_push($data, ['content' => $data['content']]);
					$html .= self::get_tag($data);
				}else $html .= self::form_button($v);
			}
			return $html;
		}
		/**
		 * @method title(string $site, string $page)
		 * @see public
		 * @static
		 * @description html title bookmark
		 * @param string $site 	site name
		 * @param string $page 	page name
		 * @return html
		 */
		public static function title(string $site, string $page){
			return self::get_double_tag_html([
				'tag' => 'title',
				'content' => ucwords($site) . ' - ' . ucwords($page)
			]);
		}
		/**
		 * @method favicon(string $url)
		 * @see public
		 * @static
		 * @description favicon bookmark
		 * @param string $url favicon url
		 * @return html
		 */
		public static function favicon(string $url){
			return self::get_simple_tag_html([
				'tag' => 'link',
				'attr' => [
					'rel' => 'shortcut icon',
					'type' => 'image/x-icon',
					'href' => $url
				]
			]);
		}
		/**
		 * @method noscript($time, string $page, $error = 'unknow')
		 * @see public
		 * @static
		 * @description noscript tag with meta refresh error page
		 * @param number|string $time 	refresh time
		 * @param string 		$page 	url page file
		 * @param string 		$error 	type of error [optional]
		 * @return html
		 */
		public static function noscript($time, string $page, $error = 'unknow'){
			return self::get_double_tag_html([
				'tag' => 'noscript',
				'content' => self::get_simple_tag_html([
					'tag' => 'meta',
					'attr' => [
						'http-equiv' => 'Refresh',
						'content' => $time . ';url=' . $page . '?error=' . $error
					]
				])
			]);
		}
		/**
		 * @method more(string $url, string $txt, $title = null)
		 * @see public
		 * @static
		 * @description link for more info
		 * @param string $url 	link
		 * @param string $txt 	link text
		 * @param string $title tooltip [optional]
		 * @return html
		 */
		public static function more(string $url, string $txt, $title = null){
			$attr = ['href' => $url, 'class' => 'pointer'];
			if(!empty($title)) $attr['title'] = $title;
			return self::get_double_tag_html([
				'tag' => 'a',
				'attr' => $attr,
				'content' => $txt
			]);
		}
		// public static function (){}
		// DEBUG ZONE
		/**
		 * @method debug(string $error, string $elem, $val = 'unknow')
		 * @see private
		 * @static
		 * @param string $error type of error
		 * @param string $elem 	error element
		 * @param string $val 	value error element [optional]
		 * @return error
		 */
		private static function debug($error, $elem, $val = 'unknow'){
			echo '<br>';
			echo 'HTML ERROR [ ' . strtoupper($error) . ' ] => ' . $elem . ' -> ' . $val . ' !' . PHP_EOL;
			echo '<br>';
		}
	}
?>