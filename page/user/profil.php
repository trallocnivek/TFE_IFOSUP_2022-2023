<!-- 
	@HTML profil
	@SITE SwingShift
	@DOMAIN http://www.swingshift.be
	@AUTHORS Collart Kevin
	@VERSION 2020/11/10 TO 15H55
-->
<?php require_once './page/utils/form_parts.php'; ?>
<section id="profil">
	<?php
		// variables
		$profil = [];

		// get data
		$data = $site->get('build_profil_new', 1)[0];
		// var_dump($data);

		// form_infos
		$input_poster['poster']['input']['value'] = $data['picture'] ?? '';
		$input_firstname['firstname']['input']['value'] = $data['firstname'];
		$input_lastname['lastname']['input']['value'] = $data['lastname'];
		$input_birthday['birthday']['input']['value'] = $data['birthday'] ?? '';
		$simple_descr['description']['textarea']['content'] = $data['descr'];
		$simple_descr['description']['textarea']['attr']['cols'] = 10;
		
		$input_pseudo['pseudo']['input']['value'] = $data['user_pseudo'];
		$input_email['email']['input']['value'] = $data['user_email'];
		// $input_password['']['input']['value'] = $data[''];
		
		$input_street['street']['input']['value'] = $data['user_street'];
		$input_numero['numero']['input']['value'] = $data['numero'];
		$input_numero['bte']['input']['value'] = $data['user_bte'] ?? '';
		$input_town['town']['input']['value'] = $data['user_town'];
		$input_cp['cp']['input']['value'] = $data['cp'];
		$input_land['land']['input']['value'] = $data['user_land'];
		
		$input_tel['tel']['input']['value'] = $data['user_tel'];
		$input_gsm['gsm']['input']['value'] = $data['user_gsm'];
		$input_email['email']['input']['value'] = $data['user_email'];

		$conditions_check['conditions']['input'][] = $data['conditions'] ? 'checked' : '';
		// $_check['']['input'][] = $data[''];
		// $_check['']['input'][] = $data[''];
		// $_check['']['input'][] = $data[''];


		// $input_['']['input']['value'] = $data[''];
		// [] = ;
		
		$langs = $select_lang['lang']['select']['content'];
		$new_array = [];
		
		foreach($langs as $key => $val){
			$attr = [];
			$attr['value'] = $val['attr']['value'];
			if($val['attr']['value'] == $data['user_lang_abvr']){
				$attr[] = 'selected';
			}
			$new_array[] = ['attr' => $attr, 'content' => $val['content']];
		}

		$select_lang['lang']['select']['content'] = $new_array;

		// lists
		$section = [
			'user',
			'account',
			'address',
			'contact',
			'site',
			'options',
			'ip',
			'metadata'
		];
		$user = [
			'picture' => 'input_poster',
			'firstname' => 'input_firstname',
			'lastname' => 'input_lastname',
			'birthday' => 'input_birthday',
			'descr' => 'simple_descr'
		];
		$account = [
			'user_id' => $data['user_id'],
			'user_pseudo' => 'input_pseudo',
			'user_email' => 'input_email',
			'user_password' => 'input_pass_and_confirm'
		];
		$address = [
			'user_street_type' => $data['user_street_type'],
			'user_street' => 'input_street',
			'numero' => 'input_numero',
			// 'user_bte' => 'input_numero',
			'user_town' => 'input_town',
			'cp' => 'input_cp',
			'user_land' => 'input_land'
		];
		$contact = [
			'user_tel' => 'input_tel',
			'user_gsm' => 'input_gsm',
			'user_email' => 'input_email'
		];
		$site = [
			'user_lang' => 'select_lang',
			'user_auth' => $data['user_auth'],
			'active' => $data['active'] ? '<span class="lime bold">oui</span>' : '<span class="red bold">non</span>'
		];
		$options = [
			'conditions' => 'conditions_check', 
			'newsletter' => 'news_check',
			'option news' => 'input_check_news'
		];
		$ip = [
			'user_ip' => $data['user_ip'],
			'user_banned' => $data['user_banned'],
			'first_fail' => $data['first_fail'],
			'user_count_fail_date' => $data['user_count_fail_date'],
			'user_count_fail' => $data['user_count_fail'],
			'ip_status' => $data['ip_status'] == 'active' ? '<span class="lime bold">active</span>' : '<span class="red bold">desactive</span>',
			'ip_create' => $data['ip_create'],
			'ip_update' => $data['ip_update']
		];
		$metadata = [
			'user_create' => $data['user_create'],
			'user_update' => $data['user_update'],
			'last_connexion' => $data['last_connexion'],
			'token' => $data['token']
		];

		// create profil infos
		foreach($section as $keys => $values){
				// var_dump([$keys => $values]);
			foreach(${$values} as $key => $value){
				// var_dump([$keys => [$key => $value]]);
				// $profil[$values][] = ${$value};
				if(preg_match('/_(check)$/', $value) || preg_match('/^(input|select|simple)_/', $value)){
					$profil[$values][] = HTML::form(
						[
							'id' => $key,
							'class' => '',
							'action' => './'
						],
						[
							'hidden' => [
								'page' => 'profil'
							],
							'title' => $key,
							'data_block' => [],
							'content' => [
								${$value}
							]
						],
						[
							'tag' => 'button',
							'attr' => [
								'type' => 'submit',
								'class' => 'submit_button pointer',
								'style' => 'margin-left: 1rem;'
							],
							'content' => 'Modifier'
						]
					);
				}else{
					$profil[$values][] = '<p><b>' . $key . '</b> : ' . (!empty($value) ? $value : '<span class="red">no value</span>') . '<p/>';
				}
			}
		}
		// var_dump($profil);
	?>
	<h1>Mon compte</h1>
	<section id="profil_content">
		<?php
			foreach($profil as $key => $val){
				echo '<section id="' . $key . '">';
				echo '<h2>' . $key . '</h2>';
				foreach($val as $k => $v){
					echo $v;
				}
				echo '</section>';
			}
		?>
	</section>
</section>