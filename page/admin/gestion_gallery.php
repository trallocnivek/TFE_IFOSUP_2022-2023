<?php require_once './page/utils/form_parts.php'; ?>
<section id="admin">
	<h1>ZONE ADMIN</h1>
	<?=$site->nav('admin'); ?>
    <hr>
	<div id="content_page" class="row content">
		<h2>gestion gallery</h2>
		<div id="crud_select">
			<a href="?mode=admin&page=gestion_gallery&action=read" class="read_btn">list</a>
			<a href="?mode=admin&page=gestion_gallery&action=create" class="add_btn">create</a>
		</div>
		<hr>
	</div>
</section>