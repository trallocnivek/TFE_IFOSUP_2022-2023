<?php
	// @ # users
	// @ # & pseudo
	// @ # & email
	// @ # & firstname et lastname
	// @ # & password
	// @ # & picture (url)
	// @ # & birthday
	// @ # & address (type rue, rue, numero, boite, code postal, ville, pays)
	// @ # & group
	// @ # & account type
	// @ # & lang
	// @ # & status
	// @ # & authorisation
	// @ # & ip (anti brute force) (ip, banned, status, count_fail)
	// @ # & tel et gsm
	// @ # & conditions (bool)
	// @ # & active (bool)
	// @ # & description
?>
<?php require_once './page/utils/form_parts.php'; ?>
<section id="admin">
	<h1>ZONE ADMIN</h1>
	<?=$site->nav('admin'); ?>
    <hr>
	<div id="content_page" class="row content">
		<h2>gestion users</h2>
		<div id="crud_select">
			<a href="?mode=admin&page=gestion_users&action=read" class="read_btn">list</a>
			<a href="?mode=admin&page=gestion_users&action=create" class="add_btn">create</a>
		</div>
		<hr>
		<?php
			if(empty(url_data('action')) || url_data('action') == 'read'){
				echo $user->get_users_table();
			}else if(url_data('action') == 'create'){
				$form_user_add = HTML::form(
					[
						'id' => 'admin_users_form_create',
		            	'class' => 'form-check-label',
		            	'autocomplete' => 'off'
					],
					[
						'title' => [
		            	    'tag' => 'h1',
		            	    'attr' => ['class' => 'form-group center'],
		            	    'content' => 'add user'//$site->txt('add_diary/title')
		            	],
		            	'hidden' => [
		            	    'page' => 'db_admin_users',
		            	    'action' => 'create'
		            	],
		            	'required_infos' => $required,
		            	'data_block' => $data_block,
		            	'content' => [
		            		$input_pseudo,
		            		$input_email,
		            		$input_firstname,
		            		$input_lastname,
		            		$input_pass_and_confirm,
		            		$input_poster,
		            		$input_birthday,
		            		$input_tel,
		            		$input_gsm,
		            		$input_google_map,
		            		$simple_descr
		            	]
					]
				);
				echo $form_user_add;
			}
		?>
	</div>
</section>