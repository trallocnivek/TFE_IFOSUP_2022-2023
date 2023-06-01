<!-- 
	@HTML header
	@SITE SwingShift
	@DOMAIN http://www.swingshift.be
	@AUTHORS Collart Kevin
	@VERSION 2020/08/10 TO 00H50
-->
<header id="header">
	<div id="logo">
		<?=$site->get('link', 'home_logo'); ?>
	</div>
	<?php $site->get('layout', 'nav'); ?>
</header>