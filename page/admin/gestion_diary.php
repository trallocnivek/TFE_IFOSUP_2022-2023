<?php
	// @ # diary
	// @ # & date
	// @ # & heure
	// @ # & titre
	// @ # & prix
	// @ # & poster
	// @ # & gallery
	// @ # & event planner
	// @ # & group
	// @ # & address & google map
	// @ # & status (closed, annuler, sold out)
	// @ # & email, tel & gsm
	// @ # & site (reservation, organisateur, groupe)
	// @ # & description
	// 
	// => voir site.class.php line 342 & 390 & 747
?>
<?php require_once './page/utils/form_parts.php'; ?>
<section id="admin">
	<h1>ZONE ADMIN</h1>
	<?=$site->nav('admin'); ?>
    <hr>
	<div id="content_page" class="row content">
		<h2>gestion agenda</h2>
		<div id="crud_select">
			<a href="?mode=admin&page=gestion_diary&action=read" class="read_btn">Afficher la liste</a>
			<a href="?mode=admin&page=gestion_diary&action=create" class="add_btn">Créer une nouvelle date</a>
		</div>
		<hr>
		<?php 
			// liste des event
			if(empty(url_data('action')) || url_data('action') == 'read'){
				echo $site->diary_table(true);
			}else if(url_data('action') == 'create'){
				// add event
				// # titre, date, heure, prix
				$form_add = HTML::form(
					[
						'id' => 'admin_diary_form_create',
		            	'class' => 'form-check-label',
		            	'autocomplete' => 'off'
					],
					[
						'title' => [
		            	    'tag' => 'h1',
		            	    'attr' => ['class' => 'form-group center'],
		            	    'content' => 'add diary'//$site->txt('add_diary/title')
		            	],
		            	'hidden' => [
		            	    'page' => 'db_admin_diary',
		            	    'action' => 'create'
		            	],
		            	'required_infos' => $required,
		            	'data_block' => $data_block,
		            	'content' => [
		            		$input_db_title_elem,
		            		$input_date,
		            		$input_hour,
		            		$input_price,
		            		$input_tel,
		            		$input_gsm,
		            		$input_google_map,
		            		$input_poster,
		            		$description
		            	]
					]
				);
				echo $form_add;
				// config event
				// # tel, gsm, email, address, google_map, poster, gallery, description, organisateur, reservation url, sold out, closed, canceled
		
			}else if(url_data('action') == 'update'){
				// update all elem 1 par 1
		
			}else if(url_data('action') == 'delete'){
				// del via id (uniquement dans swing_diary)
		
			}
		?>
	</div>
</section>