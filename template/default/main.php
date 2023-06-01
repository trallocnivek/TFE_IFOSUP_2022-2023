<?php foreach($GLOBALS as $k => $v) ${$k} = $v;?>
<main>
	<aside id="left">aside gauche</aside>
	<div id="container">
		<?=$site->get('page', 'm');?>
	</div>
	<aside id="right">aside droite</aside>
</main>