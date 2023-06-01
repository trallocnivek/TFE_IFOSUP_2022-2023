<?php
	foreach($GLOBALS as $k => $v) ${$k} = $v;
	$site->get('layout', 'm', 'topbar');
	$site->get('layout', 'm', 'header');
	$site->get('layout', 'm', 'nav');
	$site->get('layout', 'm', 'main');
	$site->get('layout', 'm', 'footer');
?>