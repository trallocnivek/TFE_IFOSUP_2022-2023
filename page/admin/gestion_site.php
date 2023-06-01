<?php require_once './page/utils/form_parts.php'; ?>
<?php
	$pages_list = [];
	$sql = "SELECT id, page, auth_id, (SELECT url FROM swing_url AS U WHERE U.id = P.url_id), active FROM swing_pages AS P";
	$exec = [];
	$db_data = CRUD::sql($sql, $exec);
	// var_dump($db_data);
	function get_list($data){
		$html = '';
		foreach($data as $key => $val){
			// var_dump($val);
			$html .= '<tr>';
			foreach($val as $k => $v){
				$html .= '<td>'
					. (($k == 'active') ? 
						(($v == 1) ? '<span class="lime bold">oui<span>' : '<span class="red bold">non<span>') 
						: (($k == 'auth_id') ?
							(($v == 1) ? '<span class="red bold">admin<span>'
								: (($v == 2) ? '<span class="lime bold">site<span>'
									: (($v == 3) ? '<span class="dodgerblue bold">newsletter<span>'
										: (($v == 4) ? '<span class="orange bold">user<span>'
											: (($v == 5) ? '<span class="yellow bold">group<span>' 
												: (($v == 6) ? '<span class="aqua bold">grant<span>' 
													: '<span class="grey bold">non defini<span>'
												)
											)
										)
									)
								)
							) : (empty($v) ? '<span class="grey bold">non defini</span>' : $v)
						)
					)
					. '</td>'
				;
			}
			$html .= '<td>'
					. '<a href="?mode=admin&page=gestion_site&action=view&id=' . $val['id'] . '" class="read_btn">read</a>'
                    . ' <a href="?mode=admin&page=gestion_site&action=update&id=' . $val['id'] . '" class="update_btn">update</a>'
                    . ' <a href="?mode=admin&page=gestion_site&action=delete&id=' . $val['id'] . '" class="delete_btn">delete</a>'
				. '</td>'
			;
			$html .= '</tr>';
		}
		return $html;
	}
?>
<section id="admin">
	<h1>ZONE ADMIN</h1>
	<?=$site->nav('admin'); ?>
    <hr>
	<div id="content_page" class="row content">
		<h2>gestion site</h2>
		<div id="crud_select">
			<a href="?mode=admin&page=gestion_site&action=read" class="read_btn">Liste des pages</a>
			<a href="?mode=admin&page=gestion_site&action=create" class="add_btn">creer une page</a>
		</div>
		<hr>
		<?php if(empty(url_data('action')) || url_data('action') == 'read'): ?>
			<section id="list">
				<h3>liste</h3>
				<table>
					<thead>
						<th>id</th>
						<th>page name</th>
						<th>authorization</th>
						<th>url_id</th>
						<th>active</th>
						<th>actions</th>
					</thead>
					<tbody>
						<?=get_list($db_data);?>
					</tbody>
				</table>
			</section>
		<?php elseif(url_data('action') == 'create' || url_data('action') == 'update'): ?>
			<?php 
				if(url_data('msg') == 'required'){
					$input_db_title_elem['db_elem_title']['input']['class'] .= ' border_red';
		            $select_auth_id['auth_id']['select']['attr']['class'] .= ' border_red';
		            $input_url['url']['input']['class'] .= ' border_red';
		            $error = "<div id='no_charge' style='display: block; text-align: center; width: 100%; border: 5px solid #ff000077; border-radius: 10px; background-color: #ff000077;color: #FFFFFF;'>
					<h3 style='color: #FFFFFF; text-transform: uppercase;'>Erreur de formulaire</h3>
					<p style='color: #FFFFFF; font-size: 2rem'>
						Veuillez vérifier que les champs requis soient remplis !
					</p>
					<small style='color: #FFFFFF;font-size:1rem;'>
						Si ce message persiste, veuillez, s'il vous plaît, contacter le webmaster. Le webmaster vous remercie de votre attention.
					</small><br><br>
				</div>"
			;
				}
				$form_add = HTML::form(
					[
						'id' => 'admin_site_form_' . url_data('action'),
		            	'class' => 'form-check-label',
		            	'autocomplete' => 'off',
		            	// 'onsubmit' => 'event.preventDefault();'
		            	// 'action' => '',
		            	'onsubmit' => "check_form(event.preventDefault(), this, '" . url_data('mode') . "', '" . url_data('page') . "');"
					],
					[
						'title' => [
		            	    'tag' => 'h1',
		            	    'attr' => ['class' => 'form-group center'],
		            	    'content' => 'add page'//$site->txt('add_site/page')
		            	],
		            	'hidden' => [
		            	    'page' => 'db_admin_site',
		            	    'action' => url_data('action')
		            	],
		            	'required_infos' => $required,
		            	'data_block' => $data_block,
		            	'content' => [
		            		$input_db_title_elem,
		            		$select_auth_id,
		            		$input_url,
		            		$active_check,
		            		$simple_descr
		            	]
					]
				);
			?>
			<section id="forms">
				<h3>create</h3>
				<?=(url_data('msg') == 'required') ? $error : ''; ?>
				<?=$form_add;?>
			</section>
		<?php elseif(url_data('action') == 'view'): ?>
			<section id="details">
				<h3>view</h3>
			</section>
		<?php else: ?>
			<h3>autre</h3>
		<?php endif; ?>
	</div>
</section>