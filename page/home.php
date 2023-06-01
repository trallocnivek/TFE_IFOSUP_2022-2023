<!-- 
	@HTML home
	@SITE SwingShift Big Band
	@DOMAIN http://www.swingshift.be
	@AUTHORS Collart Kevin
	@VERSION 2021/01/11 TO 05H35
-->
<section id="home">
	<?=Page::build($site->get('content_page', !empty(url_data('page')) ? url_data('page') : 'home'));?>
</section>