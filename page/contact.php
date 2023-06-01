<!-- 
	@HTML contact
	@SITE SwingShift
	@DOMAIN http://www.swingshift.be
	@AUTHORS Collart Kevin
	@VERSION 2020/06/06 TO 02H42
-->
<?php
	require_once './page/utils/form_parts.php';
	$form = HTML::form(
		[
			'id' => 'contact_form',
			'class' => 'form-check-label',
			'autocomplete' => 'off'
		],
		[
			'title' => [
				'tag' => 'h2',
				'attr' => ['class' => 'form-group'],
				'content' => $site->txt('form/contact')
			],
			'hidden' => [
				'page' => 'db_contact',
				'action' => 'email',
				'subject' => 'SWINGSHIFT CONTACT WEB !'
			],
			'required_infos' => $required,
			'data_block' => $data_block,
			'content' => [
				$input_name,
				$input_email,
				$textarea_msg	
			]
		]
	);
?>
<section id="contact">
	<!-- ?=Page::build($site->get('content_page', !empty(url_data('page')) ? url_data('page') : 'home'));?> -->
	<article id="contact_list">
		<h2><?=$site->txt('page/contact');?></h2>
		<?=$form;?>
	</article>
	<article id="contact_localisation">
		<h2>Lieu</h2>
		<div class="center">
			<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1784.320449355017!2d4.472522025659175!3d50.76796948687359!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47c3da0d1c45e41f%3A0x3449a14400624915!2sCafe%20Sportecho!5e0!3m2!1sfr!2sbe!4v1597186996413!5m2!1sfr!2sbe" width="80%" height="500" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
		</div>
	</article>
</section>