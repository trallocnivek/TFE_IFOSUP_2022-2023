<?php
	/**
	 * @class Site
	 * @description gestion site
	 * @property
	 * [public]
	 *  - $error
	 *  - $success
	 * [private]
	 *  - $site_infos
	 * @method
	 * [public]
	 * 	- __construct()
	 * 	- include_file()
	 * 	- get()
	 * 	- msg()
	 * [protected]
	 * [private]
	 *  - get_meta()
	 *  - get_page()
	 *  - get_title()
	 *  - get_favicon()
	 * @uses trait [db_utils], class [Config, Site, Users], function [msg]
	 * @api USERS_SESSION
	 * @version 2020/07/28 to 08h25
	 */
	class Site extends Config{
		// PROPERTY ZONE
		// PROTECTED
		/**
		 * @property $prefix_table
		 * @see protected
		 * @var string
		 * @description prefix table DB
		 */
		protected $prefix_table;
		// PRIVATE
		/**
		 * @property $table
		 * @see private
		 * @var string
		 * @uses config.ini
		 */
		private $table = 'site'; // ?
		/**
		 * @property $site_infos
		 * @see private
		 * @var array
		 * @uses config.ini
		 */
		private $site_infos;
		/**
		 * @property $CSS
		 * @see private
		 * @var array
		 * @uses config.ini
		 */
		private $CSS;
		/**
		 * @property $JS
		 * @see private
		 * @var array
		 * @uses config.ini
		 */
		private $JS;
		/**
		 * @property $msg
		 * @see private
		 * @var boolean
		 * @uses config.ini
		 */
		private $msg = true;
		// PUBLIC
		/**
		 * @property $error
		 * @see public
		 * @var string
		 */
		public $error;// = 'Site ERROR : aucun !<br>';
		/**
		 * @property $success
		 * @see public
		 * @var string
		 */
		public $success;// = 'Site SUCCESS : aucun !';
		/**
		 * @property $layout
		 * @see private
		 * @var string
		 * @uses config.ini
		 */
		private $layout = 'default';
		/**
		 * @property $page
		 * @see private
		 * @var string
		 */
		private $page = 'page';
		// USE ZONE
		/**
		 * @trait db_utils
		 */
		use db_utils;
		// MAGIC METHOD ZONE
		/**
		 * @method __construct() init instanceof Site
		 * @see public
		 * @uses config.ini, Config
		 */
		public function __construct($ajax = false){
			if(class_exists('Config')){
				if((bool) $ajax) parent::db_set('ajax', true);
				self::set('msg', parent::get('debug'));
				self::set('site_infos', parent::get('ini', 'SITE'));
				self::set('CSS', parent::get('ini', 'CSS'));
				self::set('JS', parent::get('ini', 'JS'));
				self::set('page', parent::get('ini', 'PATH')['page']);
				self::set('layout', self::get('layout_name'));
				self::set('prefix_table', parent::get('ini', 'DB_CONFIG')['prefix_table']);
			}else{
				$this->error['Site'][] = 'Site ERROR [no-class] : Config';
			}
		}
		// INCLUDE ZONE
		/**
		 * @method include_file(string $type [, multi $style = null])
		 * @see public
		 * @param string $type include file extention not '.'
		 * @param multi $style null or mode type return ('min')
		 * @return string build html
		 */
		public function include_file(string $type, $page = null){
			$style = preg_match("/^(css|js)-main$/", $type) ? 'main' : parent::get('ini', 'MODE')['mode'];
			$ext = strtolower($style) == 'prod' ? 'min' : '';
			if(strtoLower($type) === 'css' || strtoLower($type) === 'css-main') return self::html_file_include('css', $style, $ext);
			else if(strtoLower($type) === 'js' || strtoLower($type) === 'js-main') return self::html_file_include('js', $style, $ext);
			else if(preg_match("/^js_page_(start|end)$/", $type)) {
				$page = !empty($page) ? $page : 'home';
				$split = explode('_', $type)[2];
				$position = isset($split) && !empty($split) ? '_' . $split : '';
				$url = './js/' . $page . $position .  '.js';
				if(file_exists($url)) return HTML::get('tag', ['tag' => 'script', 'attr' => ['src' => $url, 'defer'], 'content' => '']);
				else $this->error['JS'][$type][] = 'FILE NOT EXIST !';
			}
		}
		private function html_file_include(string $type, string $style, string $ext){
			$error = strtoupper($type) . ' ERROR [no-file] :';
			$path = parent::get('ini', 'PATH')[strtolower($type)];
			$cond = false;
			$html = '';
			// var_dump($this->{strtoupper($type)}[strtolower($style)]);
			foreach($this->{strtoupper($type)}[strtolower($style)] as $k => $v){
				$split = explode('/', $v);
				if(preg_match("/%{([A-Z]+)}%/", $split[0])){
					$search = preg_replace("/.*%{([A-Z]+)}%.*/", "$1", $split[0]);
					$split[0] = preg_replace("/%{([A-Z]+)}%/", substr(parent::get('ini', 'VERSION')[$search], 0, -1), $split[0]);
				}
				if(file_exists($path . $split[0])){
					if(strtolower($type) == 'css'){
						$html .= '<link rel="stylesheet" href="' . $path . $split[0] 
							. '?' . filemtime($path . $split[0]) . '" media="' . $split[1] . '">' . PHP_EOL
						;
					}else if(strtolower($type) == 'js'){
						$html .= '<script src="' . $path . $split[0] 
							. '?' . filemtime($path . $split[0]) . '" ' . $split[1] . '></script>' . PHP_EOL
						;
					}
				}else{
					$cond = true;
					$error .= ' ' . $path . $split[0];
				}
			}
			if(!empty($error) && $cond) $this->error['JS'][$type][] = $error;
			return $html;
		}
		// URL ZONE
		public function redirect(string $page, string $msg = ''){
			// $root_dir = '/' .  ROOT_DIR . '/index.php';
			// start get urls
			// $sql = "SELECT * FROM swing_pages";
			// $exec = [];
			// $urls = self::request($sql, $exec);
			// var_dump($urls);
			// $sql = "SELECT id, auth FROM swing_authorization";
			// $exec = [];
			// $user_type = self::request($sql, $exec);
			// var_dump($user_type);
			// $data = [];
			// foreach($urls as $k => $v){

			// }
			// end get urls 
			$root_dir = ROOT;
			$js_url = ['home_js'];
			$url_visitor = ['home', 'group', 'diary', 'gallery', 'demos', 'technical', 'contact', 'sign_in', 'sign_up', 'news'];
			$url_newsletter = ['news_account'];
			$url_user = ['profil'];
			$url_group = ['partitions'];
			$url_admin = ['admin', 'stats'];
			$url_grant = ['gestion_users'];
			$array = ['grant', 'admin', 'group', 'user', 'newsletter', 'visitor'];
			if(in_array($page, $js_url)) return "onclick=redirect('" . $page . "');";
			else{
				foreach($array as $v){
					if(in_array($page, ${'url_' . $v})){
						$msg_type = "(msg|success|warning|error)";
						$var_url_msg = preg_match("/^(?!(&|\?)?(msg|success|warning|error)=).*$/", $msg) && $page == 'home' ? '?msg=' . $msg 
									: (preg_match("/^(?!(&|\?)?(msg|success|warning|error)=).*$/", $msg) && $page != 'home' ? '&msg=' . $msg 
									: (preg_match("/^(msg|success|warning|error)=.*$/", $msg) && $page == 'home' ? '?' . $msg 
									: (preg_match("/^(msg|success|warning|error)=.*$/", $msg) && $page != 'home' ? '&' . $msg 
									: $msg
								)
							)
						);
						return /*$_SERVER['REQUEST_SCHEME']'' . 'http://' . $_SERVER['HTTP_HOST'] . $root_dir 
							. */($page != 'home' ? '?page=' . $page : './') . $var_url_msg
						;
					} 
				} 
			}
		}
		public function url(string $x){
			$table = $this->prefix_table . parent::get('ini', 'DB_TABLES')['url']['DB_TABLE'];
			// var_dump($table);
			$sql = "SELECT url FROM $table WHERE active = 1 AND name = :x OR id = :x LIMIT 1";
			$exec = ['x' => htmlspecialchars($x)];
			if(in_array($x, ['rezal_facebook', 'rezal_youtube', 'hamburger_menu'])){
				return self::request($sql, $exec, 'fetch')['url'];
			}else{
				return '/' . self::request($sql, $exec, 'fetch')['url'];
			}
		}
		// NAV ZONE
		public function get_nav(string $type){
			// $lang = $_SESSION['lang'];
			$auth = 'site';
			// var_dump($_SESSION['user']['type']);
			if(isset($_SESSION['user']['type']) && !empty($_SESSION['user']['type'])) $auth = $_SESSION['user']['type'];
			$sql = 'CALL get_menu(:like, :auth)';
			$exec = [
				'like' => $type . '_%',
				'auth' => $auth
			];		
			$data = self::request($sql, $exec);
			foreach($data as $k => $v) $result[] = ['txt' => $v['trad'], 'url' => $v['url']];
			return $result;
		}
		public function nav($x){
			global $user;
			if(strtolower($x) == 'main'){
				$url_mode = 'page';
				$fct = 'ucwords';
				$list = self::get('nav', 'main');
				$nav = ['id' => 'main_menu'];
				$data = ['attr' => ['class' => ['pointer', 'active']]];
			}else if(strtolower($x) == 'hamburger'){
				$url_mode = 'page';
				$fct = 'ucwords';
				$list = self::get('nav', 'main');
				$nav = ['id' => 'hamburger'];
				$data = ['attr' => ['class' => ['pointer', 'active']]];
			}else if(strtolower($x) == 'admin'){
				$url_mode = 'page';
				$fct = 'ucwords';
				$list = self::get('nav', 'admin');
				if($user->get('type') == 'grant') $list = array_merge($list, self::get('nav', 'grant'));
				$nav = ['id' => 'admin_menu'];
				$data = ['attr' => ['class' => ['pointer', 'active']]];
			}else if(strtolower($x) == 'topleft'){
				$url_mode = 'mode';
				$fct = 'ucwords';
				$list = self::get('nav', 'topleft');
				$nav = ['id' => 'topleft_menu'];
				$data = ['attr' => ['class' => ['pointer', 'active']]];
			}else if(strtolower($x) == 'topright'){
				$url_mode = 'page';
				$fct = 'ucwords';
				$list = self::get('nav', 'topright');
				$nav = ['id' => 'topright_menu'];
				$data = ['attr' => ['class' => ['pointer', 'active']]];
			}
			if(!empty($list)) foreach($list as $k => $v) $data['list'][$k] = $v;
			else{
				$data['list'] = [];
				$this->error['Site']['nav'] = 'Site ERROR [DB-null-value] : self::get("nav", "admin") = null !';
				return self::msg();
			}
			if(strtolower($x) == 'hamburger') return HTML::hamburger($nav, $data, $this, $fct, $url_mode);
			else return HTML::nav($nav, $data, $this, $fct, $url_mode);
		}
		// FOOTER ZONE
		public function footer(){
			return HTML::footer(
				['attr' => [], 'content' => HTML::get('tag', [
					'tag' => 'p', 
					'content' => strtoupper(parent::get('ini', 'SITE')['footer']) . date('Y')
						. '<span class="css_media"> - </span>' 
						. HTML::get('tag', ['tag' => 'a', 'attr' => ['href' => '.' . self::url('conditions'), 'class' => 'css_media'], 'content' => strtoupper(self::txt('url/conditions'))]) 
						/*. '<span class="css_media"> - </span>' 
						. HTML::get('tag', ['tag' => 'a', 'attr' => ['href' => '.' . self::url('sitemap'), 'class' => 'css_media'], 'content' => strtoupper(self::txt('url/sitemap'))])*/
					])	
				],
				['tag' => 'div', 'content' => 
					HTML::get('tag', [
						['tag' => 'span', 'attr' => ['class' => 'left'], 'content' => 
							(!is_connect() ? ''
								// HTML::get('tag', ['tag' => 'a', 'attr' => ['href' => '.' . self::url('news_sign_up'), 'class' => 'newsletter_btn newsletter pointer'], 'content' => self::txt('newsletter/title')]) 
								/*HTML::get('tag', ['tag' => 'a', 'attr' => ['href' => '.' . self::url('sign_up') . '&news=true', 'class' => 'newsletter_btn newsletter pointer'], 'content' => self::txt('newsletter/title')]) 
								. HTML::get('tag', ['tag' => 'a', 'attr' => ['href' => '.' . self::url('sign_in'), 'class' => 'sign_in_btn sign pointer'],'content' => self::txt('sign_in/title')])*/ 
								: ''
							)
						],
						['tag' => 'span', 'attr' => ['class' => 'right'], 'content' => 
							HTML::get('tag', ['tag' => 'a', 'attr' => ['href' => self::url('rezal_facebook'), 'class' => 'rezal_btn facebook pointer'], 'content' => 'facebook']) 
							/*. HTML::get('tag', ['tag' => 'a', 'attr' => ['href' => self::url('rezal_youtube'), 'class' => 'rezal_btn youtube pointer'], 'content' => 'youtube'])*/
						]
					])
				]
			);
		}
		// TEXT ZONE (TRAD)
		public function txt(string $x, $replace = ''){
			$table = parent::get('ini', 'DB_CONFIG')['prefix_table'] . 'trad';
			$lang = $_SESSION['lang'] == 'be-fr' ? 'fr' : ($_SESSION['lang'] == 'be-nl' ? 'nl' : $_SESSION['lang']);
			$sql = "SELECT $lang FROM $table WHERE trad = :v OR id = :v LIMIT 1";
			$exec = ['v' => htmlspecialchars($x)];
			// var_dump($sql);
			$elem = isset(self::request($sql, $exec, 'fetch')[$lang]) ? self::request($sql, $exec, 'fetch')[$lang] : $x;
			if(preg_match("/%{[[:alnum:]_]+}%/i", $elem)) $elem = preg_replace("/%{[[:alnum:]_]+}%/i", $replace, $elem); 
			return $elem;
		}
		// BUILD FUNCTION PAGE ZONE
		/**
		 * @method more()
		 * @see public
		 * @return html 
		 * @uses class HTML
		 */
		public function more(string $url){
			return HTML::get('tag', ['tag' => 'a', 'attr' => ['href' => $url], 'content' => self::txt('more_infos')]);
		}
		public function musician_fiche($data){
			$lang = strtolower($_SESSION['lang']);
			$musicos = self::request("CALL get_musicians(:lang)", ['lang' => $lang]);
			$title = ['conductor', 'sax', 'trp', 'trb', 'rythm', 'vocal'];
			$data = JSON::decode($data, true);
			for($i = 0; $i < count($title); $i++) $combine[$title[$i]] = $data[$i];
			$html = '';
			foreach($combine as $key => $instru){
				$html .= '<h3>' . self::txt('group/musicos/' . $key . '_title') . '</h3><article id="' . $key . '">';
				foreach($musicos as $k => $v){
					if(in_array($v['instru_abvr'], $instru) || ($key == 'conductor' && $v['funct_name'] == 'first_conductor')){
						// names
						if(empty($v['firstname']) && empty($v['lastname'])){
							$firstname = 'Wanted';
							$lastname = '';
						}else{
							$firstname = $v['firstname'];
							$lastname = $v['lastname'];
						}
						// fonctions
						if(preg_match("/%{ .+ }%+/i", $v['fonction'])){
							$split = explode(', ', $v['fonction']);
							$fonction = '';
							$i = 0;
							foreach($split as $k_split => $v_split){
								if($i == 0) $i++;
								else $fonction .= ',<br><br>';
								$table 	= preg_replace("/^%{ ([a-z_]+) ([a-z_]+) = ([0-9]+) }%$/i", "$1", $v_split);
								$col 	= preg_replace("/^%{ ([a-z_]+) ([a-z_]+) = ([0-9]+) }%$/i", "$2", $v_split);
								$value 	= preg_replace("/^%{ ([a-z_]+) ([a-z_]+) = ([0-9]+) }%$/i", "$3", $v_split);
								if($table == 'trad') $fonction .= self::txt($value);
							}
						} else $fonction = $v['fonction'];
						// html build musician fiche
						$html .= HTML::musician_fiche([
							'url' => !empty($v['image']) ? $v['image'] : './img/musician/web_square_anonymous.jpg',
							'firstname' => $firstname,
							'lastname' => $lastname,
							'instru' => $v['instrument'],
							'fonction' => $fonction
						]);
					}
				} $html .= '</article>';
			} return $html;
		}
		public function diary_table($is_admin = false){
			$GLOBALS['is_admin'] = $is_admin;
			$data_diary = self::get('diary');
			if(!empty($data_diary)){
				$data = array_map(function($x){
					global $date, $is_admin, $user;
					if($is_admin && $user->is_admin()){
						$action = HTML::get('tag', [
							['tag' => 'a', 'attr' => ['href' => '?mode=admin&page=diary&id=' . $x['id'], 'class' => 'read_btn'], 'content' => 'read'],
							['tag' => 'a', 'attr' => ['href' => '?mode=admin&page=gestion_diary&action=update&id=' . $x['id'], 'class' => 'update_btn'], 'content' => 'update'],
							['tag' => 'a', 'attr' => ['href' => '?mode=admin&page=gestion_diary&action=delete&id=' . $x['id'], 'class' => 'delete_btn'], 'content' => 'delete']
						]);
					}else $action = null;
					return [
						[
							'title' => ucwords(self::txt('word_diary_table_details')) . ' - ' . $x['event_name'],
							'onclick' => "location.href = './?" . ($is_admin ? 'mode=admin&' : '') . "page=diary&id=" . $x['id'] . "';"
						],
						'id' => $x['id'],
						'date' => $date->get('KC_date_int', $x['date']),
						'hour' => !empty($x['hour']) ? $date->get('KC_time', $x['hour']) : '-',
						'event' => $x['event_name'],
						'price' => !empty($x['price']) ? self::get('string_price', $x['price']) : self::txt('word_free'),
						'label' => (bool) $x['closed'] ? '<span class="orange closed">' . ucfirst(self::txt('word_diary_table_closed')) . '</span>' 
							: ((bool) $x['canceled'] ? '<span class="red canceled">' . ucfirst(self::txt('word_diary_table_canceled')) . '</span>' 
								: ((bool) $x['sold_out'] ? '<span class="red sold_out">' . ucfirst(self::txt('word_diary_table_sold_out')) . '</span>' 
									: '<span class=lime>' . ucfirst(self::txt('word_diary_table_available_seats')) . '</span>')),
						'details' => '<a class="details_btn" href="./?page=diary&id=' . $x['id'] . '">' . ucwords(self::txt('word_diary_table_details')) . '</a>',
						'action' => $action
					];
				}, self::get('diary'));
				// $list = $is_admin ? ['id', 'date', 'hour', 'event', 'price', 'label', 'action'] : ['date', 'hour', 'event', 'price', 'label', 'details'];
			}else{
				$data = [[
					[],
					'id' => [['colspan' => 7], self::txt('diary/no_data')],
					'date' => [['colspan' => 6], self::txt('diary/no_data')]
				]];
				// $list = $is_admin ? ['id'] : ['date'];
			}
			$list = $is_admin ? ['id', 'date', 'hour', 'event', 'price', 'label', 'action'] : ['date', 'hour', 'event', 'price', 'label', 'details'];
			// var_dump($data);
			// var_dump(self::get('diary'));
			foreach($list as $v) $headers[] = ['list' => $v, 'content' => self::txt('word_diary_table_' . $v)];
			return (!$is_admin ? HTML::get('tag', ['tag' => 'h2', 'attr' => [], 'content' => self::txt('page/diary')]) : '')
				. HTML::table([], [
					'header' => [
						'content' => [$headers]
					],
					'body' => [
						'attr' => [
							'class' => 'pointer',
							'onmouseenter' => "Tools.css(this, 'backgroundColor', '#FFFFFF33');",
							'onmouseleave' => "Tools.css(this, 'backgroundColor', 'transparent');"
						],
						'content' => $data
					]
				])
			;
		}
		public function diary_details($id){
			global $date;
			$data = self::get('diary', $id);
			// var_dump($data);
			$html = '';
			$poster = !empty($data['poster']) ? $data['poster'] : null;
			$html .= HTML::get('tag', ['tag' => 'h2', 'attr' => [], 'content' => '# ' . $data['id'] . ' - ' . $data['event_name']])
				. self::close('./?' . (url_data('mode') == 'admin' ? 'mode=admin&page=gestion_diary' : 'page=diary'))
				. HTML::get('tag', [
					'tag' => 'div', 
					'attr' => ['id' => 'diary_poster'], 
					'content' => (!empty($poster) ? HTML::get('tag', ['tag' => 'div', 'attr' => [], 'content' => 
						HTML::get('tag', ['tag' => 'img', 'attr' => ['id' => 'poster', 'src' => './' . $poster, 'alt' => 'affiche']])
					]) : '')
					. HTML::get('tag', ['tag' => 'div', 'attr' => ['id' => 'google_map'], 'content' => 
						(!empty($data['map']) ? HTML::get('tag', [
							'tag' => 'iframe',
							'attr' => [
								'src' => $data['map'],
								'width' => '400',
								'height' => '400',
								'frameborder' => '0',
								'allowfullscreen' => '',
								'aria-hidden' => 'false',
								'tabindex' => '0'
							]
						]) : '')
					])
				])
			;
			$html .= HTML::get('tag', [
				'tag' => 'div', 'attr' => ['id' => 'diary_description'],
				'content' => HTML::get('tag', [
					'tag' => 'div', 'attr' => [], 'content' => HTML::get('tag', [
						['tag' => 'p', 'attr' => [], 'content' => self::txt('word_diary_table_date') . ' : ' . $date->get('KC_date', $data['date'])],
						['tag' => 'p', 'attr' => [], 'content' => self::txt('word_diary_table_hour') . ' : ' . $date->get('KC_time', $data['hour'])],
						[
							'tag' => 'p', 'attr' => [],
							'content' => self::txt('page/group') . ' : ' . (!empty($data['groupe']) ? $data['groupe'] : 'Swing Shift Big Band')
						],
						['tag' => 'p', 'attr' => [], 'content' => 
							!empty($data['reservation']) ? self::txt('word_reservation') . ' : <a href="' .  $data['reservation'] . '">' .  substr(preg_replace('/^(https?:\/\/)([^\/?]+|[^?])(.+)?/i', '$1$2', $data['reservation']), 0, 80) . (strlen($data['reservation']) > 100 ? ' ... ' : '') . '</a>' : ''],
						['tag' => 'p', 'attr' => [], 'content' => !empty($data['planner']) ? self::txt('word_planner') . ' : ' .  $data['planner'] : ''],
						['tag' => 'p', 'attr' => [], 'content' => !empty($data['email']) ? self::txt('word_mail') . ' : ' .  $data['email'] : ''],
						['tag' => 'p', 'attr' => [], 'content' => !empty($data['tel']) ? self::txt('word_tel') . ' : ' .  $data['tel'] : ''],
						['tag' => 'p', 'attr' => [], 'content' => !empty($data['gsm']) ? self::txt('word_gsm') . ' : ' .  $data['gsm'] : ''],
						[
							'tag' => 'p', 'attr' => [], 
							'content' => 
								self::txt('word_price') . ' : ' . (!empty($data['price']) ? self::get('string_price', $data['price']) : self::txt('word_free'))
						]
					])
				]) 
				. (!empty($data['description']) ? HTML::get('tag', ['tag' => 'div', 'attr' => ['style' => 'margin-top: 5rem;'], 'content' => self::txt($data['description'])]) : '')
				. HTML::get('tag', 
					['tag' => 'p', 'attr' => [], 'content' => HTML::get('tag', 
						['tag' => 'small', 'attr' => ['class' => 'last_update'], 'content' => '(' . self::txt('word_last_update') . ': ' . $data['updated_at'] . ')']
					)
				])
				. (!empty($data['gallery_id']) ? HTML::get('tag', [
					'tag' => 'a',
					'attr' => ['href' => '?page=gallery&id=' . $data['gallery_id'], 'class' => 'gallery_btn'],
					'content' => self::txt('view_gallery')
				]) : '')
			]);
			return $html;
		}
		public function build_diary(){
			return !empty(url_data('id')) ? self::diary_details(url_data('id')) : self::diary_table();
		}
		/*private*/public function close($url){
			return HTML::get('tag', [
				'tag' => 'span',
				'attr' => [
					'class' => 'right close',
					'style' => 'position: absolute; right: 0; top: 0;'
				],
				'content' => HTML::get('tag', [
					'tag' => 'a',
					'attr' => ['href' => $url, 'style' => 'background-color: grey; color: black; font-size: 2rem; padding: 0.25rem 0;'],
					'content' => '&#x274C;'
				])
			]);
		}
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
		 * @method get(string $e [, string $type = 'a' [, multi $p = null]])
		 * @see public
		 * @param string $e attribute name or no 'get_' function name
		 * @param multi $p function param
		 * @return multi attribute or method
		 */
		public function get(string $f, $p = null){
			if(method_exists(__CLASS__, 'get_' . $f)) return self::{'get_' . $f}($p);
			else $this->error['methods'][] = 'Security ERROR [no-method] : get_' . $f . ' !';
		}
		/**
		 * @method get_attr(string $x)
		 * @see private
		 * @param  string $x property name
		 * @return self property
		 */
		private function get_attr(string $x){
			return $this->$x;
		}
		private function get_diary($id = null){
			$sql = 'CALL get_diary(:lang, :id)';
			$exec = [
				'lang' => strtolower($_SESSION['lang']),
				'id' => $id
			];		
			return self::request($sql, $exec, !empty($id) ? 'fetch' : 'fetchAll');
		}
		/**
		 * @method get_favicon()
		 * @see private
		 * @return string build html
		 * @uses config.ini, Config
		 */
		private function get_favicon(){
			return HTML::favicon(parent::get('ini', 'SITE')['FAVICON']);
		}
		private function get_musicsheet(array $data){
			// var_dump($data);
			$sql = "SELECT N.id AS sheet_id, `number`, title, active 
					FROM swing_musicsheet_num AS N
						INNER JOIN swing_musicsheet_title AS T ON N.title_id = T.id"
			;
			if(isset($data['id'], $data['search']) && !empty($data['id']) && !empty($data['search'])){
				$sql .= " WHERE lower(T.title) LIKE :search AND N.id = :id OR N.number = :search_id";
				$exec = ['search' => "'%" . strtolower($data['search']) . "%'", 'id' => $data['id'], 'search_id' => $data['search']];
			}else if(isset($data['search']) && !empty($data['search'])){
				$sql .= " WHERE lower(T.title) LIKE :search OR N.number = :id";
				$exec = ['search' => "%" . strtolower($data['search']) . "%", 'id' => $data['search']];
			}else if(isset($data['id']) && !empty($data['id'])){
				$sql .= " WHERE N.id = :id";
				$exec = ['id' => $data['id']];
			}else{
				$exec = [];
			}
			return self::request($sql, $exec, !empty($id) ? 'fetch' : 'fetchAll');
		}
		private function get_gallery($id = null){
			$sql = 'CALL get_gallery(:lang, :id)';
			$exec = [
				'lang' => strtolower($_SESSION['lang']),
				'id' => $id
			];		
			return self::request($sql, $exec, !empty($id) ? 'fetch' : 'fetchAll');
		}
		private function get_content_page(string $page){
			global $user;
			$lang = strtolower($_SESSION['lang']);
			$page = strtolower($page);
			$auth = strtolower($user->get('type'));
			$sql = "CALL get_content_page(:page, :lang, :auth)";
			$exec = [
				'page' => $page,
				'lang' => $lang,
				'auth' => $auth
			];
			return self::request($sql, $exec);
		}
		private function get_user_news_infos($id){
			return self::request("CALL get_news(:id)", ['id' => htmlspecialchars($id)], 'fetch');
		}
		private function get_build_profil($categ){
			$sql = "SELECT * FROM swing_profil_infos WHERE active = 1 AND name LIKE :categ ORDER BY `order`";
			$exec = ['categ' => htmlspecialchars(strtolower($categ)) . '/%'];
			return self::request($sql, $exec);
		}
		private function get_build_profil_new($id){
			return self::request("CALL get_users_infos(:id)", ['id' => htmlspecialchars($id)]);
		}
		/**
		 * @method get_infos_page(string $page)
		 * @description infos current page
		 * @see public
		 * @param string $page
		 * @return array
		 */
		private function get_infos_page(string $page){
			$table_trad = $this->prefix_table . parent::get('ini', 'DB_TABLES')['trad']['DB_TABLE'];
			$table_url = $this->prefix_table . parent::get('ini', 'DB_TABLES')['url']['DB_TABLE'];
			$lang = $_SESSION['lang'];
			$sql = "SELECT id, trad, $lang FROM $table_trad WHERE trad LIKE :page ORDER BY id ASC";
			$exec = ['page' => $page . '/%'];
			$text = self::request($sql, $exec);
			$sql = "SELECT id, name, url FROM $table_url WHERE name LIKE :img";
			$exec = ['img' => $page . '_%'];
			$img = self::request($sql, $exec);
			if($page == 'group'){
				$table_members = $this->prefix_table . parent::get('ini', 'DB_TABLES')['membres']['DB_TABLE'];
				$sql = "SELECT 
						M.id, 
						N.name AS firstname, 
						N0.name AS lastname, 
						U.url AS image, 
						I.name AS instru_abvr, 
						T.$lang AS instrument, 
						T0.$lang AS fonction, 
						F.name AS funct_name,
						M.description
					FROM swing_members AS M
					LEFT JOIN swing_name AS N 
						ON M.firstname_id = N.id
					LEFT JOIN swing_name AS N0 
						ON M.lastname_id = N0.id
					LEFT JOIN swing_instruments AS I 
						ON M.instru_id = I.id
					LEFT JOIN swing_trad AS T 
						ON I.instru_id = T.id
					LEFT JOIN swing_functions_group AS F 
						ON M.function_id = F.id
					LEFT JOIN swing_trad AS T0 
						ON F.fonction_id = T0.id
					LEFT JOIN swing_url AS U 
						ON M.img_id = U.id
					ORDER BY M.id ASC"
				;
				$exec = [];
				$members = self::request($sql, $exec);
				return ['text' => $text, 'img' => $img, 'members' => $members];
			}else if($page == 'gallery'){
				$table_gallery = $this->prefix_table . parent::get('ini', 'DB_TABLES')['gallery']['DB_TABLE'];
				$sql = "SELECT * FROM $table_gallery";
				$exec = [];
			}
			else return ['text' => $text, 'img' => $img];
		}
		/**
		 * @method get_langs()
		 * @description build html liste link langs
		 * @see public
		 * @return html
		 */
		public function get_langs(){
			$table_lang = $this->prefix_table . parent::get('ini', 'DB_TABLES')['lang']['DB_TABLE'];
			$table_url = $this->prefix_table . parent::get('ini', 'DB_TABLES')['url']['DB_TABLE'];
			$table_land = $this->prefix_table . parent::get('ini', 'DB_TABLES')['land']['DB_TABLE'];
			$sql = 
				"SELECT L.id AS lang_id, L.abvr, L.lang, L.flag_id, L.land_id, L.active, 
						U.id AS url1_id, U.url AS url1, U.auth_id AS auth1, U.target AS target1, U.description AS descr1,
						P.id AS land_id, P.land, P.flag_id,
						UR.id AS url2_id, UR.url AS url2, UR.auth_id AS auth2, UR.target AS target2, UR.description AS descr2
					FROM $table_lang AS L 
					INNER JOIN $table_url AS U ON L.flag_id = U.id
					INNER JOIN $table_land AS P ON L.land_id = P.id
					INNER JOIN $table_url AS UR ON P.flag_id = UR.id
				WHERE L.active = 1
				ORDER BY L.lang ASC"
			;
			$exec = [];
			$data = self::request($sql, $exec);
			$html = '';
			foreach($data as $k => $v){
				$html .= '<a href="./?' 
					. (!empty(url_data('mode')) ? 'mode=' 	. url_data('mode') 	. '&' : '') 
					. (!empty(url_data('page')) ? 'page=' 	. url_data('page') 	. '&' : '') 
					. (!empty(url_data('subpage')) ? 'subpage=' 	. url_data('subpage') 	. '&' : '') 
					. (!empty(url_data('action')) 	? 'action=' 	. url_data('action') 	. '&' : '') 
					. (!empty(url_data('id')) 	? 'id=' 	. url_data('id') 	. '&' : '') 
					. 'lang=' . $v['abvr'] . '"'
					. ($v['abvr'] == $_SESSION['lang'] ? ' class="active"' : '')
					. ' title="' . $v['lang'] . '"'
					. ' style="background-image:url(./' . $v['url1'] . ');"></a>'
				;
			}
			return $html;
		}
		/**
		 * @method get_layout()
		 * @see private
		 * @return file
		 * @uses config.ini, Config
		 */
		private function get_layout(string $file){
			foreach($GLOBALS as $k => $v) ${$k} = $v;
			$dir = $this->layout;
			if(file_exists('./template/' . $dir . '/' . $file . '.php')) return include_once './template/' . $dir . '/' . $file . '.php';
			else $this->error['layout'][] = 'CSS ERROR [no-layout] : ./template/' . $dir . '/' . $file . '.php';
		}
		/**
		 * @method get_layout()
		 * @see private
		 * @return file
		 * @uses config.ini, Config, functions [if_exist]
		 */
		private function get_layout_name(){
			$file = parent::get('ini', 'SITE')['LAYOUT'];
			return !empty(if_exist('layout', $file)) ? $file : 'default';
		}
		/**
		 * @method get_link(string $type)
		 * @see private
		 * @param string $type type of link
		 * @return html
		 * @uses class HTML
		 */
		private function get_link(string $type){
			if($type === 'home_logo'){
				// return HTML::button([HTML::a(['', ['href' => './', 'title' => self::txt('page/home')]]), []]);
				return HTML::get('tag', [
					'tag' => 'button', 
					'content' => HTML::get('tag', [
						'tag' => 'a', 
						'attr' => [
							'href' => './',
							'title' => self::txt('page/home')
						],
						'content' => ''
					])
				]);
			}
		}
		/**
		 * @method get_meta()
		 * @see private
		 * @return string build html
		 * @uses config.ini, Config
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
		/**
		 * @method get_noscript()
		 * @description build noscript tag
		 * @see public
		 * @return html
		 */
		private function get_noscript(){
			$time = parent::get('ini', 'NOSCRIPT')['time'];
			$page = parent::get('ini', 'NOSCRIPT')['page'];
			$error = 'js';
			return parent::get('ini', 'CONFIG')['noscript'] 
				? HTML::noscript($time, $page, $error) . PHP_EOL
				: ''
			;
		}
		/**
		 * @method get_page(multi $type)
		 * @see private
		 * @param multi $type boolean or null or empty
		 * @return string
		 * @uses functions [url_data($x), is_connect()]
		 */
		private function get_page($type = false){
			if((bool) $type){
				foreach($GLOBALS as $k => $v) ${$k} = $v;
				$dir = $this->page;
				$file = $dir0 = $default = '';
				//*	
				$infos = [];
				$sql = "SELECT * FROM swing_pages";
				$exec = [];
				$pages = self::request($sql, $exec);
				// var_dump($pages);
				//*/
				$infos = [
					'grant' => [
						'dir' => 'grant/', 'default' => 'grant_home', 
						'pages' => ['grant_home', 'gestion_users', 'grant_logs']
					],
					'admin' => [
						'dir' => 'admin/', 
						'default' => 'admin_home', 
						'pages' => ['admin', 'admin_stats', 'gestion_site', 'gestion_diary', 'gestion_gallery', 'gestion_partitions', 'gestion_menu']
					],
					'build' => [
						'dir' => 'admin/', 'default' => 'build_home',
						'pages' => ['build_home', 'build_group', 'build_diary', 'build_gallery', 'build_demos', 'build_technical', 'build_contact', 'build_sign_up', 'build_sign_in', 'build_news', 'build_profil', 'build_partitions']
					],
					'group' => ['dir' => 'group/', 'default' => 'partitions', 'pages' => ['partitions']],
					'user' 	=> ['dir' => 'user/', 'default' => 'profil', 'pages' => ['profil']],
					'news' 	=> ['dir' => 'newsletter/', 'default' => 'news', 'pages' => ['news']],
					'login' => ['dir' => '', 'default' => 'sign_in', 'pages' => ['sign_up', 'sign_in']],
					'visitor' => ['dir' => '', 'default' => 'home', 'pages' => ['', 'home', 'group', 'diary', 'gallery', 'demos', 'technical', 'contact', 'conditions', 'sitemap']]
				];
				$array_list = [
					'grant' => ['grant', 'admin', 'build', 'group', 'user', 'news', 'login', 'visitor'],
					'admin' => ['admin', 'build', 'group', 'user', 'news', 'login', 'visitor'],
					'group' => ['group', 'user', 'news', 'login', 'visitor'],
					'user' => ['user', 'news', 'login', 'visitor'],
					'newsletter' => ['news', 'login', 'visitor'],
					'site' => ['news', 'login', 'visitor']
				];
				foreach($infos as $key => $val){
					$pages = []; $dir0 = '';
 					if(array_key_exists($user->get('type'), $array_list)){
 						foreach($array_list[$user->get('type')] as $v) $pages = array_merge($pages, $infos[$v]['pages']);
						if(in_array(url_data('page'), $pages)){
							foreach($infos as $k => $v){
								if(in_array(url_data('page'), $v['pages'])){
									$default = $v['default'];
									$dir0 = $v['dir']; break;
								}else continue;
							}
						}else{
							echo 'ERROR [ SITE ] => ' . strtoupper($user->get('type')) . ' ! ' . self::txt('page_error/permiss');
							break;
						}
					}else echo '<p>ERROR [ Site ] =>  PAGES [ NOT EXIST ] => PAGE_NAME [ ' . url_data('page') . ' ] IN METHOD [ ' . __METHOD__ . ' ] ON LINE [ ' . __LINE__ . ' ] !</p>';
				}
				$dir .= $dir0;
				$file .= $dir . (!empty(url_data('page')) ? url_data('page') : (!empty($default) ? $default : 'home'));
				if(!empty($file) && file_exists($file . '.php')) return include_once $file . '.php';
				else $this->error['page'][] = 'ERROR [ Site ] => PAGE [ NOR EXIST ] : ' . $file . '.php !';
				// if(!empty($file) && !file_exists('./' . $file . '.php')) return include_once './' . $file . '.php';
				if(!empty($file) && !file_exists($file . '.php')) echo 'ERROR FILE [ 404 NOT FOUND ] : ' . self::txt('page_error/not_found', url_data('page')) . ' => ' . $file . '.php !';
			}else{
				return ucwords(!empty(url_data('page')) ? self::txt('page/' . url_data('page')) : self::txt('page/home'));
			}
		}
		/**
		 * @method get_php(string $file)
		 * @description include_once php file
		 * @see public
		 * @param string $file file name
		 * @return resources file
		 * @uses file [config.ini], class [Config]
		 */
		private function get_php(string $file){
			$path = parent::get('ini', 'PATH')['php'];
			$php = parent::get('ini', 'PHP')['main'];
			$flip = array_flip(parent::get('ini', 'PHP')['main']);
			$file = $file . '.php';
			$elem = in_array($file, $php) ? $php[$flip[$file]] : $file . '.php';
			if(file_exists($path . $elem)) return include_once $path . $elem;
			else $this->error['php'][] = 'CSS ERROR [no-php] : ' . $path . $elem;
		}
		private function get_social(){
			$social = parent::get('ini', 'SOCIALS');
			$html = '';
			return $html;
		}
		private function get_string_price(string $x){
			$string = '';
			$array = [];
			$i = 0;
			$split = explode(", ", $x);
			foreach($split as $k => $v){
				$elem = preg_replace("/^%{ ([a-z_]+) = [0-9]+€ }%$/i", "$1", $v);
				$val = preg_replace("/^%{ [a-z_]+ = ([0-9]+)€ }%$/i", "$1", $v);
				$array[$k] = ['elem' => self::txt("word_" . $elem), 'value' => $val];
			}
			foreach($array as $k => $v){
				if($i != 0) $string .= ', ';
				else $i++;
				$string .= ucwords($v['elem']) . ' : ' . $v['value'] . ' €';
			}
			return $string;
		}
		/**
		 * @method get_title()
		 * @see private
		 * @return string build html
		 * @uses file [config.ini], class [Config, HTML]
		 */
		private function get_title(){
			return HTML::title(parent::get('ini', 'SITE')['TITLE'], self::get('page'));
		}
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