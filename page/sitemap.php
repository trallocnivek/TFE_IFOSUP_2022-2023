<!-- 
	@HTML sitemap
	@SITE SwingShift
	@DOMAIN http://www.swingshift.be
	@AUTHORS Collart Kevin
	@VERSION 2020/11/10 TO 15H55
-->
<section id="sitemap">
	<!-- ?=Page::build($site->get('content_page', !empty(url_data('page')) ? url_data('page') : 'home'));?> -->
	<h1>Swingshift Big Band</h1>
	<h2>Plan du site</h2>
	<h3>Simple visiteur:</h3>
	<nav id="sitemap_nav_visitor">
		<ul style="padding-left: 2rem;">
			<li><a href="./">Accueil</a></li>
			<li><a href="./?page=group">Groupe</a></li>
			<li><a href="./?page=diary">Agenda</a></li>
			<!--li><a href="./?page=gallery">Galerie</a></li-->
			<li><a href="./?page=demos">Démos</a></li>
			<!--li><a href="./?page=technical">Technique</a></li-->
			<li><a href="./?page=contact">Contact</a></li>
			<li><a href="./?page=conditions">Mentions Legales</a></li>
			<li><a href="./?page=sitemap">Plan du site</a></li>
			<li><a href="./?page=sign_in">se connecter</a></li>
			<li><a href="./?page=sign_up">s'enregistrer</a></li>
			<!--li><a href="./?page=news">newsletter</a></li-->
		</ul>
	</nav>
	<?php if(is_connect()): ?>
		<h3>Simple utilisateur:</h3>
		<nav id="sitemap_nav_user">
			<ul style="padding-left: 2rem;">
				<li><a href="./?page=music_sheet">Partitions</a></li>
				<li><a href="./?page=profil">Mon compte</a></li>
				<li><a href="./?action=destroy">Se déconnecter</a></li>
			</ul>
		</nav>
	<?php endif; ?>
	<?php if(is_connect() && $user->is_admin()): ?>
		<h3>Switch admin <-> site:</h3>
		<nav>
			<ul style="padding-left: 2rem;">
				<li><a href="./?mode=admin&page=admin">Administration</a></li>
				<li><a href="./">site (home)</a></li>
			</ul>
		</nav>
		<h3>Administration:</h3>
		<nav>
			<ul style="padding-left: 2rem;">
				<li><a href="./?mode=admin&page=admin">Administration</a></li>
				<li><a href="./?mode=admin&page=gestion_site">gestion du site</a></li>
				<li><a href="./?mode=admin&page=gestion_diary">gestion de l'agenda</a></li>
				<li><a href="./?mode=admin&page=gestion_gallery">gestion des galeries</a></li>
				<li><a href="./?mode=admin&page=gestion_partitions">gestion des partitions</a></li>
				<li><a href="./?mode=admin&page=gestion_users">gestion des utilisateurs</a></li>
				<!-- <li><a href="./?mode=admin&page=">gestion autres ...</a></li> -->
			</ul>
		</nav>
	<?php endif; ?>
	<h3>Liens extérieurs:</h3>
	<nav>
		<ul style="padding-left: 2rem;">
			<li><a href="https://www.facebook.com/swingshiftbigb/">Facebook</a></li>
			<!--li><a href="https://www.youtube.com/watch?v=5rzYgaUmIfA">Youtube</a></li-->
		</ul>
	</nav>
</section>