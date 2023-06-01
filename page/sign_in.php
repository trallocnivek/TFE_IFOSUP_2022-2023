<!-- 
	@HTML sign in
	@SITE SwingShift Big Band
	@DOMAIN http://www.swingshift.be
	@AUTHORS Collart Kevin
	@VERSION 2020/09/04 TO 18H40
-->
<?php
    require_once './page/utils/form_parts.php';
    $login = $password = '';
    $form = HTML::form(
        [
            'id' => 'signin_form',
            'class' => 'form-check-label',
            'autocomplete' => 'on'
        ],
        [
            'title' => [
                'tag' => 'h2',
                'attr' => ['class' => 'form-group'],
                'content' => $site->txt('sign_in/title')
            ],
            'hidden' => [
                'page' => 'db_login',
                'action' => 'connexion'
            ],
            'required_infos' => $required,
            'data_block' => $data_block,
            'content' => [
                $input_login,
                $input_password
            ]
        ]
    );
?>
<?php // include_once "./page/return.php";?>
    <!-- ?=Page::build($site->get('content_page', !empty(url_data('page')) ? url_data('page') : 'home'));?> -->
<div id="signin" class="row content">
    <div class="col-lg-6 sign center_box">
        <a href="./?page=sign_up">S'enregistrer</a>
        <?=$form;?>
    </div>    
</div>    