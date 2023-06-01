<!-- 
    @HTML sign up
    @SITE SwingShift Big Band
    @DOMAIN http://www.swingshift.be
    @AUTHORS Collart Kevin
    @VERSION 2021/06/07 TO 04H54
-->
<?php
    require_once './page/utils/form_parts.php';
    $pseudo = $robot = $firstname = $lastname = $email = $password = $confirm = $conditions = '';
    $form = HTML::form(
        [
            'id' => 'signin_form',
            'class' => 'form-check-label',
            'autocomplete' => 'off'
        ],
        [
            'title' => [
                'tag' => 'h1',
                'attr' => ['class' => 'form-group center'],
                'content' => (bool) url_data('news') ? 'newsletter' : $site->txt('sign_up/title')
            ],
            'hidden' => [
                'page' => 'db_register',
                'action' => 'register'
            ],
            'required_infos' => $required,
            'data_block' => $data_block,
            'content' => [
                $input_pseudo,
                $input_firstname,
                $input_lastname,
                $input_email,
                $input_pass_and_confirm,
                $captcha,
                $conditions_check
            ]
        ]
    );
?>
<?php // include_once "./page/return.php";?>
    <!-- ?=Page::build($site->get('content_page', !empty(url_data('page')) ? url_data('page') : 'home'));?> -->
<div id="signup" class="row content">
    <div class="col-lg-6 sign center_box">
        <?=$form;?>
    </div>
</div>