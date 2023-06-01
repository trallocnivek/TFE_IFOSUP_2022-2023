<!-- 
	@HTML topbar
	@SITE SwingShift
	@DOMAIN http://www.swingshift.be
	@AUTHORS Collart Kevin
	@VERSION 2021/06/02 TO 15H23
-->
<?php
	if(is_connect()){
		if(in_array($user->get('type'), ['admin', 'grant'])) $admin_topbar = $site->nav('topleft');
		else $admin_topbar = '';
		$profil_topbar = $site->nav('topright');
	} else $admin_topbar = $profil_topbar = '';
?>
<div id="topbar">
	<span class="left">
		<?=$admin_topbar;?>
	</span>
	<span class="right">
		<span id="topbar_span_lang"><?=$site->get('langs');?></span>
		<?=$profil_topbar;?>
	</span>
</div>