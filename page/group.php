<!-- 
	@HTML group
	@SITE SwingShift Big Band
	@DOMAIN http://www.swingshift.be
	@AUTHORS Collart Kevin
	@VERSION 2021/01/11 TO 05H41
-->
<section id="group">
	<?=Page::build($site->get('content_page', !empty(url_data('page')) ? url_data('page') : 'home'));?>
</section>