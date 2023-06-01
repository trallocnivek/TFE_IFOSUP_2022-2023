<?php
	header('content-type: text/css');
	ob_start('ob_gzhandler');
	header('Cache-Control: max-age=31536000, must-revalidate');

	/*if($_SESSION['swingshift']['theme'] === 'default'){
		$header_bg = '#0B1241';
		$navbar_bg = 'black';
		$nav_a_color = 'white';
		$nav_active_bg = '#FFA418';
		$nav_a_active_color = 'white';
		$nav_hover_bg = '#FFA418';
		$nav_a_hover_color = '#0B1241';
		$main_bg = '#0B1241';
		$main_color = 'white';
		$aside_bg = 'grey';
		$footer_bg = '#FFA418';
		$footer_color = '#0B1241';
	}*/
?>
<!-- header{
	background-color: < ?=$header_bg;?>;
}
#main_menu{
	background-color: < ?=$navbar_bg;?>;
} -->
