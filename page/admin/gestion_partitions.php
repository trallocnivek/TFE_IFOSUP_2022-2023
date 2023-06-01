<?php require_once './page/utils/form_parts.php'; ?>
<section id="admin">
	<h1>ZONE ADMIN</h1>
	<?=$site->nav('admin'); ?>
    <hr>
	<div id="content_page" class="row content">
		<h2 class="">Gestion partitions</h2>
		<div id="crud_select">
			<a href="?mode=admin&page=gestion_partitions&action=read" class="read_btn">Afficher la liste</a>
			<a href="?mode=admin&page=gestion_partitions&action=create" class="add_btn">Créer une nouvelle date</a>
		</div>
		<hr>
	</div>
</section>