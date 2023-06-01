<!-- 
	@HTML technical
	@SITE SwingShift
	@DOMAIN http://www.swingshift.be
	@AUTHORS Collart Kevin
	@VERSION 2020/11/10 TO 15H55
-->
<?php
	
?>
<section id="technical">
	<?=Page::build($site->get('content_page', !empty(url_data('page')) ? url_data('page') : 'home'));?>
</section>