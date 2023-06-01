<?php
	/**
	 * @class HTML
	 * @static
	 * @description HTML generator
	 * @property
	 * 	[static private]
	 * 		- $html_attrs
	 * 		- $html_tags
	 * 	[static public]
	 * @method
	 * 	[magic private]
	 * 		- __construct()
	 * 		- __clone()
	 * 	[static public]
	 * 		- get()
	 * 		- get_html_attrs()
	 * 		- get_attr()
	 * 		- get_html_tags()
	 * 		- css()
	 * 		- topbar()
	 * 		- header()
	 * 		- nav()
	 * 		- footer()
	 * 		- form()
	 * 		- label_input()
	 * 		- gallery_list()
	 * 		- gallery()
	 * 		- table()
	 * 		- musician_fiche()
	 * 		- demo_sound()
	 * 		- demo_video()
	 * 		- lang_list()
	 * 		- form_button()
	 * 		- title()
	 * 		- favicon()
	 * 		- noscript()
	 * 		- more()
	 * 	[static private]
	 * 		- in_attr_tag()
	 * 		- get_attr_infos()
	 * 		- get_deprecated_attr()
	 * 		- get_self_attr()
	 * 		- get_bimode_attr()
	 * 		- get_assoc_attr()
	 * 		- get_html_tags()
	 * 		- get_tag()
	 * 		- get_deprecated_html()
	 * 		- get_doctype_html()
	 * 		- get_simple_tag_html()
	 * 		- get_double_tag_html()
	 * 		- get_comment_html()
	 * 		- content_form()
	 * 		- buttons_form()
	 * 		- label()
	 * 		- input_attr()
	 * 		- input_input()
	 * 		- select_input()
	 * 		- textarea_input()
	 * 		- select_option()
	 * 		- input_infos()
	 * 		- table_header()
	 * 		- table_body()
	 * 		- table_footer()
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
				'allowfullscreen' => [
					'elem' => ['iframe'],
					'val' => ['NULL', 'STRING', 'BOOL']
				],
				'alt' => [
					'elem' => ['area', 'img', 'input[img]'],
					'val' => ['STRING']
				],
				'aria-hidden' => [
					'elem' => ['iframe'],
					'val' => ['BOOL']
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
				'frameborder' => [
					'elem' => ['iframe'],
					'val' => ['STRING', 'NUMBER']
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
				'onmouseenter' => [
					'elem' => ['ALL'],
					'val' => ['JS_STRING']
				],
				'onmouseleave' => [
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
		 * @method get(string $method [ , $value = null ])
		 * @see private
		 * @static
		 * @description get 'get_' method
		 * @param string 	$method 	method name 	[required]
		 * @param multi 	$method 	method params 	[option]
		 * @return array
		 */
		public static function get(string $method, $value = null){
			if(method_exists(__CLASS__, $method)) return self::$method($value);
			else if(method_exists(__CLASS__, 'get_' . $method)) return self::{'get_' . $method}($value);
			else return self::debug('html method not exist', 'HTML::' . $method . '()', !empty($v) ? $v : 'no param', __LINE__);
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
		/**
		 * @method get_attr($data)
		 * @see private
		 * @static
		 * @description build html attributes
		 * @param  multi $data 	attribute data [required]
		 * @return html
		 */
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
				else self::debug('attribute not exist', $k, !empty($v) ? $v : 'no value', __LINE__);
			}
			return $attr;
		}
		/**
		 * ?
		 * @param  [type] $k [description]
		 * @param  [type] $v [description]
		 * @return [type]    [description]
		 */
		private static function in_attr_tag($k, $v){
			$infos = self::get_attr_infos();
		}
		/**
		 * ?
		 * @param  [type] $type [description]
		 * @param  [type] $attr [description]
		 * @return [type]       [description]
		 */
		private static function get_attr_infos($type, $attr){
			if($type == 'self') return self::$html_attrs['self'][$attr];
			else if($type == 'bimode_self') return self::$html_attrs['bimode']['self'][$attr];
			else if($type == 'bimode_assoc') return self::$html_attrs['bimode'][$attr]['assoc'];
			else if($type == 'assoc') return self::$html_attrs['assoc'][$attr];
			else if($type == 'deprecated') self::debug('deprecated attribute', $attr, 'SEE NEXT VAR_DUMP', __LINE__);
			else debug('no attribute infos', $type, $attr, __LINE__);
		}
		/**
		 * @method get_deprecated_attr($data, $k)
		 * @see private
		 * @static
		 * @description debug html attribute with replace example
		 * @param  multi 	$data 	unknow			[required] ?
		 * @param  string 	$k   	attribute name 	[required]
		 * @return var_dump()
		 */
		private static function get_deprecated_attr($data, $k){
			echo '-----------------------------------------------------------------------------------------------------------' . PHP_EOL;
			self::get_attr_infos('deprecated', $k);
			echo 'A remplacer par: ';
			var_dump(self::$html_attrs['deprecated'][$k]);
			echo '-----------------------------------------------------------------------------------------------------------' . PHP_EOL;
			exit;
		}
		/**
		 * @method get_self_attr(string $attr [ , $pace = true ])
		 * @see private
		 * @static
		 * @description get html attribute without value
		 * @param  string  	$attr  	attribute name 				[required]
		 * @param  boolean 	$space 	if white space required 	[option]
		 * @return string
		 */
		private static function get_self_attr(string $attr, $space = true){
			// if(self::in_attr_tag()){
				return ($space ? ' ' : '') . $attr;
			// }else return '';
		}
		/**
		 * @method get_bimode_attr(string $attr [ , $val = null [ , $pace = true ]])
		 * @see private
		 * @static
		 * @description get html attribute with(out) value
		 * @param  string  $attr 	attribute name 				[required]
		 * @param  string  $val  	attribute value 			[option]
		 * @param  boolean $space 	if white space required 	[option]
		 * @return string
		 */
		private static function get_bimode_attr(string $attr, $val = null, $space = true){
			return ($space ? ' ' : '') . $attr . (!empty($val) ? '="' . $val . '"' : '');
		}
		/**
		 * @method get_assoc_attr(string $attr, string $val = null [ , $pace = true ])
		 * @see private
		 * @static
		 * @description get html attribute with value
		 * @param  string  $attr  	attribute name 				[required]
		 * @param  string  $val  	attribute value 			[option]
		 * @param  boolean $space 	if white space required 	[option]
		 * @return string
		 */
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
		/**
		 * @method get_tag(array $data)
		 * @see private
		 * @static
		 * @description switch of html tag type function
		 * @param  array  $data html tag data 	[required]
		 * @return html
		 */
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
		/**
		 * @method get_deprecated_html($tag)
		 * @see private
		 * @static
		 * @description debug html tag with replace example
		 * @param  string 	$tag 	html tag name 	[required]
		 * @return var_dump()
		 */
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
		 * @param int 	$index 	array index 	[option]
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
		 * @param array $data tag infos ['tag' => 'html tag', 'attr' => [attr list]] 	[required]
		 * @return html
		 */
		private static function get_simple_tag_html(array $data = []){
			return '<' . $data['tag'] . (!empty($data['attr']) ? self::get('attr', $data) : '') . '>';
		}
		/**
		 * @method get_double_tag_html(array $data = [])
		 * @see private
		 * @static
		 * @description build html normal tag
		 * @param array $data tag infos ['tag' => 'html tag', 'attr' => [attr list]] 	[required]
		 * @return html
		 */
		private static function get_double_tag_html(array $data = []){
			$attr = !empty($data['attr']) ? self::get('attr', $data) : '';
			return '<' . $data['tag'] . $attr . '>' . (!empty($data['content']) ? $data['content'] : '') . '</' . $data['tag'] . '>';
		}
		// HTML COMMENT ZONE
		/**
		 * @method get_comment_html([ string $comment = '' ])
		 * @see private
		 * @static
		 * @description build html comment
		 * @param string $comment comment string 	[option]
		 * @return html
		 */
		private static function get_comment_html(string $comment = ''){
			return self::$html_tags['comment'][0] . $comment . self::$html_tags['comment'][1];
		}
		// CSS ZONE
		/**
		 * @method css($data)
		 * @see public
		 * @static
		 * @description build css string for style attribute
		 * @param  multi 	$data 	css data 	[required]
		 * @return css
		 */
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
		 * @param multi $content 	content topbal 	[required]
		 * @return html
		 */
		public static function topbar($content){
			return self::get_double_tag_html(['tag' => 'div', 'attr' => ['id' => 'topbar'], 'content' => $content]);
		}
		/**
		 * @method header(multi $content, array $attr)
		 * @see public
		 * @static
		 * @description build header
		 * @param multi $content 	content header 	[required]
		 * @param array $attr 		attribute list 	[required]
		 * @return html
		 */
		public static function header($content, array $attr){
			return self::get_double_tag_html(['tag' => 'header', 'attr' => $attr, 'content' => $content]);	
		}
		/**
		 * @method nav(array $nav, array $data, object $class [ , $fct = 'ucwords' ])
		 * @see public
		 * @static
		 * @description build html menu
		 * @param array 	$nav   infos menu 						[required]
		 * @param array 	$data  infos + elements list of menu 	[required]
		 * @param object 	$class Site class 						[required]
		 * @param string 	$fct   function name 					[option]
		 * @return html
		 */
		public static function nav(array $nav, array $data, object $class, $fct = 'ucwords'){
			$page_list = ['index', 'home'];
			$admin_list = ['admin', 'gestion_site', 'gestion_diary', 'gestion_gallery', 'gestion_partitions', 'gestion_users', 'gestion_menu'];
			// var_dump($data['list']);
			$replace_page = [
				'administration' => 'admin',
				'my account' => 'profil',
				'sheet music' => 'partitions',
				'User Management' => 'gestion_users',
				'diary management' => 'gestion_diary',
				'gallery management' => 'gestion_gallery',
				'music sheet management' => 'gestion_partitions',
				'site management' => 'gestion_site',
				'Sign out' => 'disconnect',
				'website' => 'site',
				'nav management' => 'gestion_menu'
			];
			$list = '';
			// var_dump($data['list']);
			foreach($data['list'] as $k => $v){
				// var_dump($v);
				$name = $active = $v['txt'];
				if(isset($replace_page[$v['txt']]) && !empty($replace_page[$v['txt']])) $name = $active = $replace_page[$v['txt']];
				// var_dump($name);
				$list .= self::get_double_tag_html([
					'tag' => 'li',
					'attr' => [
						'class' => 'pointer ' 
						. (
							(url_data('mode') == 'admin' && $nav['id'] == 'topleft_menu' && in_array(url_data('page'), $admin_list) && $v['url'] != './') 
							|| url_data('page') == $active 
							|| (in_array($active, $page_list) && empty(url_data('page')) && $nav['id'] != 'topleft_menu') 
								? 'active' : ''
						)
					],
					'content' => self::get_double_tag_html([
						'tag' => 'a',
						'attr' => ['href' => !in_array($name, $page_list) ? $v['url'] : './' /*$class->url('home')*/],
						'content' => $fct($class->txt('page/' . $name))
					])
				]);
			}
			return self::get_double_tag_html(['tag' => 'nav', 'attr' => $nav, 'content' => self::get_double_tag_html(['tag' => 'ul', 'content' => $list])]);
		}
		/**
		 * @description print hamburger main menu
		 * @param  array  $nav   [description]
		 * @param  array  $data  [description]
		 * @param  object $class [description]
		 * @param  string $fct   [description]
		 * @return [type]        [description]
		 */
		public static function hamburger(array $nav, array $data, object $class, $fct = 'ucwords'){
			return self::get_double_tag_html([
				'tag' => 'div', 'attr' => $nav, 'content' => self::get_simple_tag_html([
						'tag' => 'img',
						'attr' => [
							'src' => $class->url('hamburger_menu'),
							// 'src' => 'img/site/hamburger.png',
							'alt' => 'menu hamburger png',
							'class' => 'hamburger'
						]
					])
					. self::nav(['id' => 'hamburger_main'], $data, $class, $fct)
			]);
		}
		/**
		 * @method footer(array $footer [ , prefooter = null ])
		 * @see public
		 * @static
		 * @description build footer
		 * @param array $footer 	[required]
		 * @param array $prefooter 	[option]
		 * @return html
		 */
		public static function footer(array $footer, $prefooter = null){
			$prefoot = !empty($prefooter) ? self::get_tag($prefooter) : '';
			return self::get_double_tag_html(['tag' => 'footer', 'attr' => $footer['attr'], 'content' => PHP_EOL . $prefoot . $footer['content']]);
		}
		/**
		 * @method form(array $form, $data [ , $button = 'submit_input' [ , $order = true ]] )
		 * @see public
		 * @static
		 * @description build complete html form
		 * @param  array   	$form   	form attributes 					[required]
		 * @param  array  	$data   	form content 						[required]
		 * @param  multi  	$button 	form button list type 				[option]		(value: submit_button, submit_input, get_tag(array))
		 * @param  boolean 	$order  	order label/inputs or inputs/label 	[option]
		 * @return html complete form
		 */
		public static function form(array $form, array $data, $button = 'submit_input', $order = true){
			global $secu;
			$content = '';
			$attr_list = [
				'action' => $_SERVER['PHP_SELF'], // url execute form page
				'method' => 'post', // [get, post]
				'enctype' => 'application/x-www-form-urlencoded', // [application/x-www-form-urlencoded, multipart/form-data, text/plain]
				'accept-charset' => 'utf-8', // charset-type
				'target' => '_self', // [_blank, _self, _parent, _top, framename]
				'autocomplete' => 'on'  // [on, off]
			];
			$attr = array_merge($attr_list, $form);
			if(isset($data['title'], $data['title']['content']) && !empty($data['title']['content'])) $content .= self::get_tag($data['title']);
			if(isset($data['required_infos'], $data['required_infos']['content']) && !empty($data['required_infos']['content']))
				$content .= self::get_tag($data['required_infos']);
			if(isset($data['hidden']) && !empty($data['hidden'])) 
				foreach($data['hidden'] as $k => $v) 
					$content .= self::get_tag(['tag' => 'input', 'attr' => ['type' => 'hidden', 'name' => $k, 'value' => $v]]);
			if($secu->is_token_active()) $content .= $secu->token();
			$content .= self::content_form($data, $order);
			$content .= self::buttons_form($data['data_block'], $button);
			return self::get_double_tag_html(['tag' => 'form', 'attr' => $attr, 'content' => $content]);
		}
		/**
		 * @method content_form($data, $order)
		 * @see private
		 * @static
		 * @description build content form
		 * @param  array 	$data 		content data 						[required]
		 * @param  boolean 	$order  	order label/inputs or inputs/label 	[option]
		 * @return html
		 */
		private static function content_form($data, $order){
			$content = '';
			foreach($data['content'] as $key => $val){
				$block = '';
				if(is_numeric($key)) foreach($val as $k => $v) $block .= $k == 'img_captcha' ? self::get_tag($v) : self::label_input($k, $v, $order);
				else $block .= self::label_input($key, $val, $order);
				if(isset($data['data_block']) && !empty($data['data_block'])){
					$data['data_block']['content'] = $block;
					$content .= self::get_tag($data['data_block']);
				} else $content .= $block;
			}
			return $content;
		}
		/**
		 * @method buttons_form($data, $button)
		 * @see private
		 * @static
		 * @description build block buttons
		 * @param  array 	$data   	buttons parent block data 	[required]
		 * @param  multi 	$button 	buttons data 				[required]
		 * @return html
		 */
		private static function buttons_form($data, $button){
			$content = '';
			if(is_string($button)){
				if(isset($data) && !empty($data)){
					$data['attr']['class'] .= ' center';
					$data['content'] = self::form_button($button);
					$content .= self::get_tag($data);
				} else $content .= self::form_button($button);
			}else if(is_array($button)){
				$content = self::get_tag($button);
			}
			return $content;
		}
		/**
		 * @method label_input($name, $data [ , $order = true ])
		 * @see public
		 * @static
		 * @description build couple of label and input
		 * @param  string  	$name 	default name and id value 			[required]
		 * @param  array  	$data 	elements data 						[required]
		 * @param  boolean 	$order 	order label/inputs or inputs/label 	[option]
		 * @return 	html
		 */
		public static function label_input($name, $data, $order = true){
			$label = $input = $infos = '';
			// label
			$label = isset($data['label']) && !empty($data['label']) ? self::label($data['label'], $name, in_array('required', $data)) : '';
			// input
			if(array_key_exists('input', $data)){
				$input = self::input_input($data['input'], $name, in_array('required', $data), in_array('autofocus', $data));
			}else if(array_key_exists('textarea', $data)){
				$content = isset($data['textarea']['content']) ? $data['textarea']['content'] : '';
				$input = self::textarea_input($data['textarea']['attr'], $name, $content, in_array('required', $data), in_array('autofocus', $data));
			}else if(array_key_exists('select', $data)){
				$content = isset($data['select']['content']) ? $data['select']['content'] : [];
				$input = self::select_input($data['select']['attr'], $name, $content, in_array('required', $data), in_array('autofocus', $data));
			}
			return $order ? $label . $input . $infos : $input . $label . $infos;
		}
		private static function label($data, $name, $required = false){
			$attr = [];
			$content = '';
			// attr
			if(isset($data['attr']) && !empty($data['attr'])) $attr = $data['attr'];
			if(!isset($data['attr']['for'])) $attr['for'] = $name;
			if((bool) $required){
				if(isset($data['attr']) && array_key_exists('class', $data['attr']) && !empty($data['attr']['class']))  $attr['class'] .= ' required';
				else $attr['class'] = 'required';
			}
			// content
			$content = isset($data['content']) && array_key_exists('content', $data) && !empty($data['content']) 
				? $data['content'] : (!empty($data) && is_string($data) ? $data : (!empty($name) ? $name : 'NO LABEL : '))
			;
			return self::get_tag(['tag' => 'label', 'attr' => $attr, 'content' => $content]);
		}
		private static function input_attr($data, $name, $required = false, $autofocus = false){
			if(!isset($data['id'])) $data['id'] = $name;
			if(!isset($data['name'])) $data['name'] = $name;
			if((bool) $required) $data[] = 'required';
			if((bool) $autofocus) $data[] = 'autofocus';
			return $data;
		}
		private static function input_input($data, $name, $required = false, $autofocus = false){
			$data = self::input_attr($data, $name, $required = false, $autofocus = false);
			if(isset($data['type']) && in_array($data['type'], self::$html_attrs['assoc']['type']['val']))
				return self::get_tag(['tag' => 'input', 'attr' => $data]);
			else return self::get_tag(['tag' => 'p', 'attr' => [], 'content' => 'ERROR [ INPUT ] : NO DATA !']);
		}
		public static function select_input($data, $name, $content = [], $required = false, $autofocus = false){
			$data = self::input_attr($data, $name, $required = false, $autofocus = false);
			return self::get_tag(['tag' => 'select', 'attr' => $data, 'content' => self::select_option($content)]);
		}
		private static function textarea_input($data, $name, $content = '',$required = false, $autofocus = false){
			$data = self::input_attr($data, $name, $required = false, $autofocus = false);
			return self::get_tag(['tag' => 'textarea', 'attr' => $data, 'content' => $content]);
		}
		private static function select_option($data){
			$html = '';
			foreach($data as $key => $val){
				$block = '';
				if(is_string($key) && !is_numeric($key)){
					$html .= self::get_tag(['tag' => 'optgroup', 'attr' => $val['attr'], 'content' => self::select_option($val['content'])]);
				} else $html .= self::get_tag(['tag' => 'option', 'attr' => $val['attr'], 'content' => $val['content']]);
			}
			return $html;
		}
		private static function input_infos($data){
			$html = '';
			if(isset($data['count'])){}
			if(isset($data['valid'])){}
			if(isset($data['invalid'])){}
			return $html;
		}
		public static function gallery_list(){}
		public static function gallery(){}
		public static function table($attr, $data){
			// var_dump($data);
			$content = $header = $body = $footer = '';
			$list = ['header', 'body', 'footer'];
			foreach($list as $v) if(array_key_exists($v, $data)) ${$v} = self::{'table_' . $v}($data[$v], $header);
			$content = $header['content'] . $body . $footer;
			return self::get_tag(['tag' => 'table', 'attr' => $attr, 'content' => $content]);
		}
		private static function table_header($data){
			$content = $list = '';
			$table_attr = isset($data['attr']) && !empty($data['attr']) ? $data['attr'] : [];
			foreach($data['content'] as $key => $val){
				$header = '';
				$list = [];
				foreach($val as $k => $v){
					$attr = isset($v['attr']) && !empty($v['attr']) ? $v['attr'] : [];
					$header .= self::get_tag(['tag' => 'th', 'attr' => $attr, 'content' => $v['content']]);
					if(isset($v['list']) && !empty($v['list'])) $list[] = $v['list'];
				}
				$content .= self::get_tag(['tag' => 'tr', 'attr' => [], 'content' => $header]);
			}
			return ['list' => $list, 'content' => self::get_tag(['tag' => 'thead', 'attr' => $table_attr, 'content' => $content])];
		}
		private static function table_body($data, $header_list){
			//var_dump(['header_list' => $header_list['list']]);
			$content = '';
			// var_dump(['body data' => $data['content']]);
			// var_dump($data['content']); // chnull
			$tr_attr = isset($data['attr']) && !empty($data['attr']) ? $data['attr'] : [];
			foreach($data['content'] as $key => $val){
				// var_dump(['data content' => $val]);//test=>relou
				$header = '';
				if(isset($val[0]) && !empty($val[0])) $tr_attr = array_merge($tr_attr, $val[0]);
				//var_dump(['$str_attr' => $tr_attr]);
				if(!empty($header_list['list'])){
					foreach($header_list['list'] as $k => $v){
						//var_dump(['header list loop' => [$k => $v]]);
						if(isset($val[$v]) && is_array($val[$v])){
							if(array_key_exists($v, $val)) $header .= self::get_tag(['tag' => 'td', 'attr' => $val[$v][0], 'content' => $val[$v][1]]);
							else $header .= self::get_tag(['tag' => 'td', 'attr' => ['colspan' => count($header_list['list'])], 'content' => 'aucun']);
						}else{
							if(array_key_exists($v, $val)) $header .= self::get_tag(['tag' => 'td', 'attr' => [], 'content' => $val[$v]]);
							else $header .= self::get_tag(['tag' => 'td', 'attr' => ['colspan' => count($header_list['list'])], 'content' => 'aucun']);
						}
						if(isset($val[$v][0]['colspan']) && (int) $val[$v][0]['colspan'] == count($header_list['list'])) break;
					}
				}else if(isset($val[1]) && !empty($val[1])){
					// var_dump(['data else' => $val[1]]);//test=>relou
					foreach($val[1] as $k => $v){
						// var_dump([$k => $v]);
						$header .= self::get_tag(['tag' => 'td', 'attr' => $v['attr'], 'content' => $v['content']]);
					}
					// $header .= self::get_tag([]);
				}
				// var_dump('expression');
				$content .= self::get_tag(['tag' => 'tr', 'attr' => $tr_attr, 'content' => $header]);
			}
			return self::get_tag(['tag' => 'tbody', 'attr' => [], 'content' => $content]);
		}
		private static function table_footer($data, $header){
			$content = '<td colspan="' . count($header['list']) . '">Ah ! Apparemment il y a un footer ! Veuillez le configurer dans le fichier ./php/class/HTML.class.php !</td>';
			return self::get_tag(['tag' => 'tfoot', 'attr' => [], 'content' => $content]);
		}
		/**
		 * @method musician_fiche(array $data)
		 * @see public
		 * @static
		 * @description build one musician fiche
		 * @param  array  $data 
		 * @return html
		 */
		public static function musician_fiche(array $data){
			return self::get_double_tag_html([
				'tag' => 'div',
				'attr' => ['class' => 'musicos'],
				'content' => self::get('tag', [
					[
						'tag' => 'figure',
						'content' => self::get_simple_tag_html([
							'tag' => 'img',
							'attr' => [
								'src' => $data['url'],
								'alt' => $data['url'],
								'class' => 'img_fiche_musicos'
							]
						])
					],
					[
						'tag' => 'div',
						'attr' => ['class' => 'infos'],
						'content' => self::get('tag', [
							['tag' => 'p', 'attr' => ['class' => 'names'], 'content' => $data['firstname'] . ' ' . $data['lastname']],
							['tag' => 'p', 'attr' => ['class' => 'instru'], 'content' => $data['instru']],
							['tag' => 'p', 'attr' => ['class' => 'functions'], 'content' => $data['fonction']]
						])
					]
				])
			]);
		}
		public static function media($type, $id, $url){
			return self::get_tag([
					'tag' => 'audio',
					'attr' => [
						'id' => 'player_' . $id,
						'ontimeupdate' => 'AUDIO.update(' . $id . ', this);'
					],
					'content' => '<source src="' . $url . '">'
				])
			;
		}
		public static function audio_controls($id){
			return self::get_tag([
					'tag' => 'span',
					'attr' => ['class' => 'i_volume'],
					'content' => '&#x1F4E2;'
				])
				. self::get_tag([
					'tag' => 'input',
					'attr' => [
						'type' => 'range',
						'min' => '0',
						'max' => '100',
						'step' => '1',
						'value' => '100',
						'oninput' => 'AUDIO.volume(' . $id . ', this.value);'
					]
				])
				. self::get_tag([
					'tag' => 'span',
					'attr' => ['class' => 'show_vol'],
					'content' => '100%'
				])
				. self::get_tag([
					'tag' => 'span',
					'content' => self::get_tag([
						'tag' => 'button',
						'attr' => [
							'class' => 'btn_play',
							'onclick' => 'AUDIO.toggle_play(' . $id . ', this);'
						],
						'content' => '&#9654;'
					])
				])
				. self::get_tag([
					'tag' => 'span',
					'content' => self::get_tag([
						'tag' => 'button',
						'attr' => [
							'class' => 'btn_reload',
							'onclick' => 'AUDIO.replay(' . $id . ');'
						],
						'content' => '&#x21BA;'
					])
				])
			;
		}
		public static function progressbar($id){
			return self::get_tag([
					'tag' => 'div',
					'attr' => [
						'id' => 'progress_box_' . $id,
						'class' => 'progress_box',
						'onclick' => 'AUDIO.clickProgress(event, 0);',
						'onmousedown' => 'AUDIO.changeProgress(event, 0);'
					],
					'content' => self::get_tag([
						'tag' => 'div',
						'attr' => [
							'id' => 'progress_bar_' . $id,
							'class' => 'progress_bar'
						],
						'content' => self::get_tag([
							'tag' => 'div',
							'attr' => [
								'id' => 'progress_bar_cursor' . $id,
								'class' => 'progress_bar_cursor'
							],
							'content' => '<!-- VIDE ! -->'
						])
					])
				])
			;
		}
		public static function demo_sound(){}
		public static function demo_video(){}
		public static function lang_list(){}
		public static function form_button($data){
			global $site;
			$html = '';
			if(is_array($data)) foreach($data as $k => $v) $html .= self::get_tag($v);
			else if($data == 'submit_input') $html .= self::get_tag([
				'tag' => 'input', 
				'attr' => [
					'type' => 'submit',
					'class' => 'submit_button pointer',
					'value' => $site->txt('word_send')
				]
			]);
			else if($data == 'submit_button') $html .= self::get_tag([
				'tag' => 'button', 
				'attr' => [
					'type' => 'submit',
					'class' => 'submit_button pointer'
				],
				'content' => $site->txt('word_send')
			]);
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
			return self::get_double_tag_html(['tag' => 'title', 'content' => ucwords($site) . ' - ' . ucwords($page)]);
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
			return self::get_simple_tag_html(['tag' => 'link', 'attr' => ['rel' => 'shortcut icon', 'type' => 'image/x-icon', 'href' => $url]]);
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
			return self::get_double_tag_html(['tag' => 'a', 'attr' => $attr, 'content' => $txt]);
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
		private static function debug($error, $elem, $val = 'unknow', $line = 'unknow'){
			echo '<br>';
			echo 'HTML ERROR [ ' . strtoupper($error) . ' ] => ' . $elem . ' -> ' . $val . ' => LINE : ' . $line . ' !' . PHP_EOL;
			echo '<br>';
		}
	}
?>