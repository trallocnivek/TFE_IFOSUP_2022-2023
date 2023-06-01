<!-- 
	@HTML profil
	@SITE SwingShift
	@DOMAIN http://www.swingshift.be
	@AUTHORS Collart Kevin
	@VERSION 2020/11/10 TO 15H55
-->
<!-- 
	formulaire par section
	- identite
	- contact
	- adresse
	- description
	- photo profil
	- infos du compte (infos que seul l'admin peut changer)
	- config du compte (infos que l'user peut changer)
 -->
<?php require_once './page/utils/form_parts.php'; ?>
<section id="profil">
	<!-- ?=Page::build($site->get('content_page', !empty(url_data('page')) ? url_data('page') : 'home'));?> -->

	<?php
		// $data = $site->get('profil');
		$get_vars_kc = get_defined_vars();
					$user_id = url_data('mode') == 'admin' && !empty(url_data('id')) ? url_data('id') : $_SESSION['user']['id'];
					// $data = $user->get_users($user_id)[0];
					// var_dump($data);
		/**
		 * @function build_profil()
		 * @param  array 	$data 	DB data 			[required]
		 * @param  string 	$type 	profil or account 	[required]
		 * @return html
		 */
		function build_profil($type, $vars){
			// global $site;
			// var_dump($vars);
			foreach($GLOBALS as $k => $v) ${$k} = $v;
			require_once $_SERVER['DOCUMENT_ROOT'] . '/GITHUB/SWING_SHIFT_BIG_BAND_2020/page/utils/form_parts.php';
			$list = [
				'profil' => [
					'identity' => [
						'lastname' => 'lastname', // input_lastname
						'firstname' => 'firstname', // input_firstname
						'birthday' => 'birthday',	// input_birthday
						'sexe' => '', // 
						'picture_profil' => 'picture', // 
						'description' => 'descr', // simple_descr
						'groups' => 'user_group', // 
						'instru' => '', // 
						'metier' => 'metier', //
					], 
					 'contact' => [
						'email' => 'user_email',	// input_email
						'gsm' => 'user_gsm',	// input_gsm
						'tel' => 'user_tel',	// input_tel
						'format_gsm' => 'format_gsm', // 
						'format_tel' => 'format_tel', // 
						'website' => '', // 
						'visitcard' => '', // 
					], 
					 'address' => [
						'street_type' => 'user_street_type', // 
						'street' => 'user_street', // 
						'numero' => 'numero', // 
						'bte' => 'user_bte', // 
						'town' => 'user_town', // 
						'cp' => 'cp', // 
						'land' => 'user_land', // 
						// 'continent' => '', // 
						'district' => 'user_district', // 
						// 'planet' => '', // 
						'googlemap' => '', // 
					]
				],
				'account' => [
					'account' => [
						'pseudo' => 'user_pseudo', // input_pseudo
						'email' => 'user_email',	// input_email
						'password' => 'user_password', // $input_pass_and_confirm
						'confirm' => 'user_password',  // $input_pass_and_confirm
						'lang' => 'user_lang_abvr', // select_lang
						'conditions' => 'conditions', // conditions_check
					],
					'news' => [
						'news' => 'active', // 
						'diary' => 'diary', // input_check_news
						'email' => 'email', // 
						'lang' => 'user_lang_abvr', // select_lang
						'conditions' => 'conditions', // conditions_check
						'gallery' => 'gallery', // input_check_news
						'demos' => 'demos', // input_check_news
					],/*
					'member' => [
						'functions' => '', // 
						'folder' => '', // 
						'pseudo' => 'user_pseudo', // input_pseudo
						'firstname' => 'firstname', // 
						'lastname' => 'lastname', // 
						'instru' => '', // 
						'instru_add' => '', // 
					],*/
					/* 'stats' => [
						// 'created_at' => 'user_create', // 
						// 'updated_at' => 'user_update', // 
						// 'ip_v4' => 'user_ip', // 
						// 'ip_v6' => 'user_ip', // 
						// 'account_type' => 'user_auth', // 
						// 'banned' => 'user_banned', // 
						// 'last_connection' => 'last_connexion', // 
						// 'visibility' => '', // 
						// '' => '', // 
					// ]*/
				]
			];
			$html = $result = $block = '';
			foreach($list[$type] as $keywords => $value){
				var_dump(['SECTION KEYWORDS' => $keywords,'DATA USER VALUE' => $value]);				
				$content = [];
				$test_kc = $site->get('build_profil', $keywords);
				var_dump($test_kc);
				foreach($site->get('build_profil', $keywords) as $val){
					// var_dump(['FOREACH VAL' => $val]);
					$split_name = explode("/", $val["name"]);
					$val_input_name = $split_name[1];
					$label_txt = ucfirst($site->txt($val['trad_id']));
					$html_id = json_decode($val['label_infos'], true)['for'];
					$input_infos = json_decode($val['input_infos'], true);
					$box_id = $val['js_add_block_idname'];
					/*var_dump([
						"label txt" => $label_txt,
						"html id" => $html_id,
						"input infos" => $input_infos,
						"box id" => $box_id,
						"split name" => $split_name,
					]);*/
					$user_id = url_data('mode') == 'admin' && !empty(url_data('id')) ? url_data('id') : $_SESSION['user']['id'];
					$data = $user->get_users($user_id)[0];
					// var_dump($data);
					$news_infos = $site->get('user_news_infos', $user_id);
					// var_dump($news_infos);
					$KC_elem = [];
					$key = $split_name[1];
					$elem = [];
					if(isset($vars['input_' . $val_input_name])){
						// var_dump($val_input_name . ' => OK');
						$elem = $vars['input_' . $val_input_name];
						$key_list = array_keys($elem);
						// var_dump($elem);
						if(!empty($html_id)) $keyword = $html_id;
						else if(array_key_exists($key, $list[$value]) && !empty($list[$value][$key])) $keyword = $list[$key];
						else $keyword = $key;
						//foreach($key_list as $key_val){
							/*if()*/ 
							/*var_dump([
								'$list[type][split_name[0]]' => $list[$type][$split_name[0]],
								'val_input_name' => $val_input_name,
								'input_infos' => $input_infos,
								'val' => $val
							]);*/
							if(in_array($input_infos['type'], ['tel'])){
								// var_dump($data[$list[$type][$split_name[0]][$val_input_name]]);
								if(!empty($data[$list[$type][$split_name[0]][$val_input_name]])){
									$num_content = [];
									foreach($elem['format_' . $val_input_name]['select']['content'] as $S_k => $S_v){
										$num_content[$S_k]['attr']['value'] = $S_v['attr']['value'];
										$num_content[$S_k]['content'] = $S_v['content'];
										if($S_v['attr']['value'] == $data[$list[$type][$split_name[0]]['format_' . $val_input_name]]) array_push($num_content[$S_k]['attr'], 'selected');
									}
									$elem['format_' . $val_input_name]['select']['content'] = $num_content;
									$elem[$val_input_name]['input']['value'] = $data[$list[$type][$split_name[0]][$val_input_name]] ?? '';
								}
							}else if(in_array($input_infos['type'], ['text', 'email',/*'checkbox', 'radio',*/ 'date'])){
								if($input_infos['type'] == 'date'){
									if(!empty($data[$list[$type][$split_name[0]][$val_input_name]])){
										$elem[$val_input_name]['input']['value'] = $data[$list[$type][$split_name[0]][$val_input_name]] ?? '';
									}
								}else if($val_input_name == 'numero'){
									$elem['numero']['input']['value'] = $data[$list[$type][$split_name[0]]['numero']] ?? '';
									$elem['bte']['input']['value'] = $data[$list[$type][$split_name[0]]['bte']] ?? '';
								}else{
									if($split_name[0] == 'news' && $val_input_name == 'email'){
										$elem[$val_input_name]['input']['value'] = $news_infos[$list[$type][$split_name[0]][$val_input_name]] ?? '';
									}else{
										$elem[$val_input_name]['input']['value'] = $data[$list[$type][$split_name[0]][$val_input_name]] ?? '';
									}
								}
								// var_dump(['KC_FORM_ELEM_VALUE' => $elem[$val_input_name]['input']]);
							}else{
								// var_dump('KC_NOT_ELEM_LIST');
							}
							if(in_array($val_input_name, ['tel', 'gsm', 'numero'])){
								$KC_elem = $elem;
							}else{
								$KC_elem[$keyword] = $elem[$val_input_name];
							}
							// var_dump($KC_elem);
							/*
							var_dump([
								'KC_KEY_LIST' => $key_list,
								'KC_ELEM' => $KC_elem,
								'VAL INPUT NAME' => $val_input_name,
								'ELEM NOT INPUT NAME' => $elem
							]);*/
						//}
						$content[] = $KC_elem;
					}else if(isset($vars['select_' . $val_input_name]) && $val_input_name !== 'lang'){
						$elem = $vars['select_' . $val_input_name];
						$key_list = array_keys($elem);
						if(!empty($html_id)) $keyword = $html_id;
						else if(array_key_exists($key, $list[$value]) && !empty($list[$value][$key])) $keyword = $list[$key];
						else $keyword = $key;
						$KC_elem[$keyword] = $elem[$val_input_name];
						$content[] = $KC_elem;
					}else if(isset($vars['select_' . $val_input_name]) && $val_input_name == 'lang'){
						$elem = $vars['select_' . $val_input_name];
						$key_list = array_keys($elem);
						if(!empty($html_id)) $keyword = $html_id;
						else if(array_key_exists($key, $list[$value]) && !empty($list[$value][$key])) $keyword = $list[$key];
						else $keyword = $key;
						$KC_elem[$keyword] = $elem[$val_input_name];
						$new_attr = [];
						/*var_dump([
							'ELEM' => $elem,
							'KEY_LIST' => $key_list,
							'KEYWORD' => $keyword,
							'KC_ELEM[KEYWORD][SELECT][CONTENT][0]' => $KC_elem[$keyword]['select']['content'][0],
							'KC_ELEM[KEYWORD][SELECT][CONTENT][1]' => $KC_elem[$keyword]['select']['content'][1],
							'KC_ELEM[KEYWORD][SELECT][CONTENT][2]' => $KC_elem[$keyword]['select']['content'][2],
							'KC_ELEM[KEYWORD][SELECT][CONTENT][3]' => $KC_elem[$keyword]['select']['content'][3]
						]);*/
						foreach($KC_elem[$keyword]['select']['content'] as $S_k => $S_v){
							$new_attr[$S_k]['attr']['value'] = $S_v['attr']['value'];
							$new_attr[$S_k]['content'] = $S_v['content'];
							if($S_v['attr']['value'] == $data[$list[$type][$split_name[0]]['lang']]) array_push($new_attr[$S_k]['attr'], 'selected');
						}
						$KC_elem[$keyword]['select']['content'] = $new_attr;
						// var_dump($KC_elem[$keyword]['select']['content']);
						$content[] = $KC_elem;
					}else if(isset($vars['textarea_' . $val_input_name])){
						$elem = $vars['textarea_' . $val_input_name];
						$key_list = array_keys($elem);
						if(!empty($html_id)) $keyword = $html_id;
						else if(array_key_exists($key, $list[$value]) && !empty($list[$value][$key])) $keyword = $list[$key];
						else $keyword = $key;
						$KC_elem[$keyword] = $elem[$val_input_name];
						$KC_elem[$keyword]['textarea']['content'] = $data[$list[$type][$split_name[0]][$val_input_name]] ?? '';
						$content[] = $KC_elem;
					}else{
						// var_dump(strtoupper($keywords));
						if(strtolower($val_input_name) == 'description'){
							$elem[$split_name[0] . '_description'] = $vars['simple_descr']['description'];
							$elem[$split_name[0] . '_description']['textarea']['content'] = $data['descr'];
							// var_dump($elem);
							$content[] = $elem;
						}else if(strtolower($val_input_name) == 'conditions'){
							$elem['account_conditions'] = $vars['conditions_check']['conditions'];
							if((bool) $data['conditions']) $elem['account_conditions']['input'][] = 'checked';
							$content[] = $elem;
						}else if(strtolower($val_input_name) == 'news'){
							$elem = $vars['news_check'];
							if((bool) $news_infos['active']) $elem['news_active']['input'][] = 'checked';
							$content[] = $elem;
						}else if(strtolower($val_input_name) == 'diary'){
							$elem = $vars['input_check_news'];
							if((bool) $news_infos['diary']) $elem['event']['input'][] = 'checked';
							if((bool) $news_infos['gallery']) $elem['gallery']['input'][] = 'checked';
							if((bool) $news_infos['demos']) $elem['demos']['input'][] = 'checked';
							$content[] = $elem;
						}else{
							$content[] = [
								$val_input_name . '_identity' => [
									'label' => $val_input_name . '_identity'
								]
							];	
						}
					}
					// $result .= '<p>' . '' . '</p>';
				}
				if(!empty($block)){

				}
				$form = HTML::form(
					[
						'id' => $keywords . '_form',
						'class' => 'form-check-label',
						// 'onsubmit' => 'form_profil_check_pass(this)',
						'action' => './php/form/db_profil.php'
					], 
					[
						'title' => [
							'tag' => 'h1',
							'attr' => ['class' => 'form-group center'],
							'content' => $site->txt($keywords)
						],
						'hidden' => [
							'action' => $keywords
						],
						'required_infos' => $vars['required'],
						'data_block' => $vars['data_block'],
						'content' => $content
					], 
					[
						'tag' => 'div',
						'attr' => ['class' => 'form-group center'],
						'content' => HTML::get('tag', [
							'tag' => 'input',
							'attr' => [
								'type' => 'submit',
								'class' => 'submit_button profil_update pointer center',
								'value' => $site->txt('word_update')
							]
						])
					]
				);
				$html .= '<hr><article id="' /*. $split_name[0]*/ . '">' . $form . '</article>';
			}
			return $html;
		}
		// $data = $site->get('content_page', 'profil');
		// var_dump($data);
		
		$profil_infos = build_profil('profil', $get_vars_kc);
		$profil_account = build_profil('account', $get_vars_kc);
		
		// $data = $user->get_users($_SESSION['user']['id'])[0];
		// var_dump($data);
	?>
	<h1>Mon compte</h1>
	<section id="infos">
		<?=$profil_infos;?>
	</section>
	<section id="plus">
		<?=$profil_account; ?>
	</section>
</section>