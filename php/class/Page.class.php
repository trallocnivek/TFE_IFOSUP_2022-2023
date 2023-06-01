<?php
	/**
	 * @class Page
	 * @description build content page
	 * @property
	 * 	[private]
	 * @method
	 * [public]
	 * 	- __construct()
	 * 	- build()
	 * 	- method_content()
	 * 	- is_html_tag()
	 * 	- set_order_list()
	 * 	- get_attributes()
	 * 	- print_html()
	 * [public][static]
	 * [protected] => null
	 * [private] => null
	 * @uses class [HTML, JSON, Site], global [$site]
	 * @api NEWSLETTERS
	 * @version 2020/07/04 to 08h25
	 */
	class Page{
		public function __construct(){}
		/**
		 * @method build($data)
		 * @description build html page
		 * @static
		 * @see public
		 * @param  array $data content all infos for build page
		 * @return html content page
		 */
		public static function build($data){
			$html = $content = '';
			$current_tag = $current_list = $data_list = $split_list = $suspended_content = [];
			$level = 0;
			foreach($data as $k => $v){
				$shift = false;
				$array_loop = !empty($level) ? $current_list[$level - 1][$data_list[$level - 1]][$split_list[$level - 1]] : null;
				if(isset($v['elem'], $v['elem_id']) && preg_match("/^php_/i", $v['elem'])){
					if(!empty($level) && in_array($v['elem_id'], $array_loop)){
						$content .= self::method_content($v);
						$shift = true;
					} else $html .= self::method_content($v);
				}else if(isset($v['elem']) && self::is_html_tag($v['elem'])){
					if(preg_match("/\%{ swing_[A-Za-z_]+ : [A-Za-z_]+\[(.+,? ?.+)+] }\%/", $v['description'])){
						$data_current = explode(' : ', preg_replace("/ ?}%$/", '', preg_replace("/%{ ?/", '', $v['description'])));
						$data_list[] = $data_current[0];
						$split = explode('[', substr($data_current[1], 0, strlen($data_current[1]) - 1));
						$split_list[] = $split[0];
						$current_list[$level][$data_current[0]][$split[0]] = self::set_order_list(preg_split("/, ?/", $split[1]), $data);
						$current_tag[$level] = $v['elem'];
						$suspended_content[$level++] = ['tag' => $v['elem'], 'attr' => self::get_attributes($v)];
					}else if(!empty($array_loop) && in_array($v['elem_id'], $array_loop)){
						$content .= self::print_html($v['elem'], self::get_attributes($v), $v['txt']);
						$shift = true;
					} else $html .= self::print_html($v['elem'], self::get_attributes($v), $v['txt']);
				}
				if((bool) $shift){
					array_shift($current_list[$level - 1][$data_list[$level - 1]][$split_list[$level - 1]]);
					if(empty($current_list[$level - 1][$data_list[$level - 1]][$split_list[$level - 1]])){
						$html .= self::print_html($suspended_content[$level - 1]['tag'], $suspended_content[$level - 1]['attr'], $content);
						array_splice($current_tag, $level - 1, 1);
						array_splice($current_list, $level - 1, 1);
						array_splice($data_list, $level - 1, 1);
						array_splice($split_list, $level - 1, 1);
						array_splice($suspended_content, $level--, 1);
						$content = '';
					}
				}
			} return $html;
		}
		/**
		 * @method method_content($data)
		 * @description call method build on a defined class
		 * @static
		 * @see private
		 * @param  string $data
		 * @return multi
		 */
		private static function method_content($data){
			global $site;
			$split = explode("_", $data['elem']);
			$method = implode("_", array_slice($split, 2, count($split)));
			if(in_array($method, ['more', 'musician_fiche', 'build_diary', 'build_gallery', 'build_music_sheet'])){
				if(!empty($data['param'])) $param = $data['param'];
				else if(!empty($data['url'])) $param = $data['url'];
				else $param = null;
				return ${$split[1]}->$method($param);
			} else return '<p>ERROR [ METHOD ] => ' . $method . '  NOT EXIST !!!</p>';
		}
		/**
		 * @method is_html_tag($tag)
		 * @description define if an HTML tag
		 * @param  string  $tag html tag name
		 * @return boolean
		 */
		private static function is_html_tag($tag){
			if(in_array($tag, HTML::get_html_tags()['simple']) || in_array($tag, HTML::get_html_tags()['double'])) return true;
			return false;
		}
		/**
		 * @method set_order_list(array $list, array $array)
		 * @description build order elements content element
		 * @static
		 * @see private
		 * @param array $list DB data
		 * @param array $array DB id element list
		 * @return array
		 */
		private static function set_order_list(array $list, array $array){
			$result = [];
			foreach($array as $k => $v) if(in_array($v['elem_id'], $list)) $result[] = $v['elem_id'];
			return $result;
		}
		/**
		 * @method get_attributes($data)
		 * @description build attributes array
		 * @static
		 * @see private
		 * @param array $data DB data 
		 * @return array
		 */
		private static function get_attributes($data){
			$src_tag_list = ['img', 'script'];
			$href_tag_list = [];
			$attr = [];
			if(!empty($data['html_id'])) $attr['id'] = $data['html_id'];
			if(!empty($data['html_class'])) $attr['class'] = $data['html_class'];
			if(!empty($data['html_attr'])){
				$list = JSON::decode($data['html_attr'], true);
				// var_dump($list);
				// var_dump(HTML::get_html_attrs()['self']);
				foreach($list as $key => $val){
					if(is_string($key) && array_key_exists($key, HTML::get_html_attrs()['self'])) $attr[] = $key;
					else if(is_string($key)) $attr[$key] = $val;
					else $attr[] = $val;
				}
			}
			if(!empty($data['url'])){
				if(in_array($data['elem'], $src_tag_list)) $attr['src'] = $data['url'];
				else if(in_array($data['elem'], $href_tag_list)) $attr['href'] = $data['url'];
			}
			return $attr;
		}
		/**
		 * @method print_html($tag, $attr, $content)
		 * @description build html parts
		 * @static
		 * @see private
		 * @param string $tag html tag name
		 * @param array $attr html attributes with value
		 * @param string $content innerHTML
		 * @return html
		 */
		private static function print_html($tag, $attr, $content){
			return HTML::get('tag', [
				'tag' => $tag,
				'attr' => $attr,
				'content' => $content
			]);
		}
	}
?>