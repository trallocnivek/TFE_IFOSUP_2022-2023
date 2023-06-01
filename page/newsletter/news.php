<!-- 
    @HTML news (newsletter)
    @SITE SwingShift Big Band
    @DOMAIN http://www.swingshift.be
    @AUTHORS Collart Kevin
    @VERSION 2020/06/07 TO 04H55
-->
<?php
    require_once './page/utils/form_parts.php';
    $robot = '';
	$form = HTML::form(
		[
			'id' => 'news_form',
			'class' => 'form-check-label',
			'autocomplete' => 'off'
		],
		[
			'title' => [
				'tag' => 'h1',
				'attr' => ['class' => 'form-group center'],
				'content' => 'Abonnement à la newsletter'
			],
			'hidden' => [
				'page' => 'db_news',
				'action' => 'subscribe'
			],
			'required_infos' => $required,
			'data_block' => $data_block,
			'content' => [
                $input_email,
                $input_pass_and_confirm,
                $select_lang,
                $input_check_news,
                $captcha,
                $conditions_check
			]
		]
	);
?>
<section id="news">
    <!-- ?=Page::build($site->get('content_page', !empty(url_data('page')) ? url_data('page') : 'home'));?> -->
	<div class="col-lg-6 news center_box">
		<?=$form;?>
	</div>
</section>