<!-- 
	@HTML diary
	@SITE SwingShift Big Band
	@DOMAIN http://www.swingshift.be
	@AUTHORS Collart Kevin
	@VERSION 2020/11/10 TO 15H55
-->
<section id="diary" style="position: relative;">
	<?=Page::build($site->get('content_page', !empty(url_data('page')) ? url_data('page') : 'home'));?>
</section>