<!-- 
	@CSS select css page
	@SITE SwingShift
	@DOMAIN http://www.swingshift.be
	@AUTHORS Collart Kevin
	@VERSION 2020/10/06 TO 08H02
-->
<style>
/* CONNECTED */
	<?php if(is_connect()):?>
		/*#lang{border-radius: 5rem 0 0 5rem;}*/
	/* TOPBAR */
		#topbar .right #topbar_span_lang a/*, #topbar .right:not(#topright_menu a)*/{
			display: inline-block;
			width: 3rem;
			height: 2rem;
			padding: 0;
			margin: 0 0.5rem;
			background-repeat: no-repeat;
			background-size: cover;
			background-position: center;
			color: transparent;
			opacity: 0.5;
			border: 2px solid transparent;
			transition: 1s border-color ease-in-out;
		}
		#topbar .right #topbar_span_lang a.active{
			opacity: 1;
		}
		#topbar .right #topbar_span_lang a:hover{
			border-color: white;
		}
		#topright_menu nav, #topright_menu ul{ /*li.active*/
			border: none;
			padding: 0;
			margin: 0;
		}
		#topright_menu{
			display: inline-block;
			vertical-align: top;
		}
		#topright_menu ul{
			list-style: none;
		}
		#topright_menu li{
			display: inline-block;
			transition: 1s filter ease-in-out;
		}
		/* profil */
		#topright_menu li:first-of-type{
			background-color: green;
			margin-right: 0.5rem;
		}
		/* deconnect */
		#topright_menu li:last-of-type{
			background-color: darkred;
		}
		#topright_menu li:hover{
			filter: grayscale(0.5);
		}
		#topright_menu li.active{

		}
		#topright_menu li.active:hover{

		}
		#topright_menu a{
			border: none;
			border-color: transparent;
			background-color: transparent;
			color: white;
			display: inline-block;
			margin: 0.5rem 1rem;
		}
		#topleft_menu nav, #topleft_menu ul{ /*li.active*/
			border: none;
			padding: 0;
			margin: 0;
		}
		#topleft_menu{
			display: inline-block;
			vertical-align: top;
		}
		#topleft_menu ul{
			list-style: none;
		}
		#topleft_menu li{
			display: inline-block;
			transition: 1s background-color ease-in-out;
		}
		/* admin */
		#topleft_menu li:first-of-type{
			margin-right: 0.5rem;
			background-color: black;
		}
		<?php if(url_data('mode') == 'admin' || url_data('page') == 'admin'): ?>
			/* site */
			#topleft_menu li:last-of-type{
				background-color: black;
			}
		<?php else: ?>
			/* site */
			#topleft_menu li:last-of-type{
				background-color: #FFA111;
			}
		<?php endif; ?>
		#topleft_menu li:hover{
			background-color: transparent;
		}
		#topleft_menu li.active{
			background-color: #FFA111;
		}
		#topleft_menu li.active:hover{
			background-color: transparent;
		}
		#topleft_menu a{
			border: none;
			border-color: transparent;
			background-color: transparent;
			color: white;
			display: inline-block;
			margin: 0.5rem 1rem;
		}
/* UNCONNECTED */
	<?php else:?>
	/* TOPBAR */	
		#topbar a{
			display: inline-block;
			width: 3rem;
			height: 2rem;
			padding: 0;
			margin: 0 0.5rem;
			background-repeat: no-repeat;
			background-size: cover;
			background-position: center;
			color: transparent;
			opacity: 0.5;
			border: 2px solid transparent;
			transition: 1s border-color ease-in-out;
		}
		#topbar a.active{
			opacity: 1;
		}
		#topbar a:hover{
			border-color: white;
		}
	/* HOME */
		<?php if(url_data('page') === null):?>

		<?php endif; // pages?>
	<?php endif; // is_connect?>
</style>