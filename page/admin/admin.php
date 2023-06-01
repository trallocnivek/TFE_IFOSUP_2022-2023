<!-- 
	@HTML admin
	@SITE SwingShift
	@DOMAIN http://www.swingshift.be
	@AUTHORS Collart Kevin
	@VERSION 2020/11/10 TO 15H55
-->
<?php
    require_once './page/utils/form_parts.php';

    $crud = new CRUD;
    /*$id = '';
	$swing_pages = [
		'id',
		'page' => 'nom de la page',
		'url_id' => 'url de la page',
		'auth_id' => "type d'authorization",
		'active' => 'si la page est active ou non'
	];
	$swing_logs = [
		'id',
		'ip_id' => 'auteur du changement',
		'table' => 'table de la DB creer ou modifier',
		'row_id' => 'numero de la ligne',
		'column' => 'colonne de la table en question',
		'action' => 'create, read, update, delete',
		'col_attr' => 'attribut de la colonne en question',
		'value' => 'valeur de la colonne',
		'created_at' => 'timestamp de creation du log',
	];
	$statistiques = [
		'id',
		'element' => '',
		'type_elem' => '',
		'value' => '',
		'created_at' => '',
		'updated_at' => '',
		'' => '',
		'' => '',
		'' => '',
		'' => '',
		'' => '',
	];*/
    // utils
    // $select_account_type = HTML::select_input([], 'account_type', []);
    // $select_arrangers = HTML::select_input([], 'arranger', []);
    // $select_authors = HTML::select_input([], 'author', []);
    // $select_lang = HTML::select_input([], 'lang', []);
    // $select_land = HTML::select_input([], 'land', []);
    // $select_street_type = HTML::select_input([], 'street_type', []);
    // $select_status = HTML::select_input([], 'status', []);
    // $select_authorization = HTML::select_input([], 'authorization', []);
    // $select_styles = HTML::select_input([], 'style', []);
    // $select_tone = HTML::select_input([], 'tone', []);
    // $select_trad_id = HTML::select_input([], 'trad_id', []);
    // $select_url = HTML::select_input([], 'url', []);
    // $select_town = HTML::select_input([], 'town', []);
    // $select_ = HTML::select();
    // $select_ = HTML::select();
    // $select_ = HTML::select();
    // $select_ = HTML::select();
    // $select_ = HTML::select();
    // $textarea_trad = [
    //  HTML::label_input(), // NL
    //  HTML::label_input(), // FR
    //  HTML::label_input(), // EN
    //  HTML::label_input()  // DE
    // ];
	// administration
	// site
	// # accueil
	// # groupe
	// # agenda
	// # gallery
	// # demos
	// # technique
	// # contact
	// # partitions
	// db
	// # users
	// # agenda
	// # gallery
	// # partitions
	// # demos
	// # groupe
	// # statistiques
	// # url
	// # menu
	// # images
	// # address ip
	// # auteur
	// # arrangeur
	// # instruments
	// # societe
	// # traductions
	// # metadonnees du site
	// # langues
	// # logs
	// # address
	// # newsletter
	// # fonctions
	// # pages
	// # password list
    function get_dir_size($dir_name){
        $dir_size = 0;
        if(is_dir($dir_name)){
            if($dh = opendir($dir_name)){
                while(($file = readdir($dh)) !== false){
                    if($file != "." && $file != ".."){
                        if(is_file($dir_name . "/" . $file)){
                            $dir_size += filesize($dir_name . "/" . $file);
                        }
                        if(is_dir($dir_name . "/" . $file)){
                            $dir_size += get_dir_size($dir_name . "/" . $file);
                        }
                    }
                }
            }
        }
        closedir($dh);
        return $dir_size;
    }

    function is_ssl_exists($url){
        $original_parse = parse_url($url, PHP_URL_HOST);
        $get = stream_context_create(array("ssl" => array("capture_peer_cert" => TRUE)));
        $read = stream_socket_client("ssl://" . $original_parse . ":443", $errno, $errstr, 30, STREAM_CLIENT_CONNECT, $get);
        $cert = stream_context_get_params($read);
        $certinfo = openssl_x509_parse($cert['options']['ssl']['peer_certificate']);
        $_SESSION['SSL']['create'] = $certinfo['validFrom_time_t'];
        $_SESSION['SSL']['expire'] = $certinfo['validTo_time_t'];
        if(isset($certinfo) && !empty($certinfo)){
            if(isset($certinfo['name']) && !empty($certinfo['name']) && $certinfo['issuer'] && !empty($certinfo['issuer'])){
                return true;
            }
            return false;
        }
        return false;
    }

    $domain = 'https://www.swingshift.be';
    $SSL = is_ssl_exists($domain) ? '<span class="lime">ON</span>' : '<span class="red">OFF</span>';


    $dir_name = './';
    $total_size = round((get_dir_size($dir_name) / 1073741824), 2);	

    $DB_LIST = [
        'swingsradmin' => [
            'size' => 0,
            'url' => 'https://phpmyadmin.cluster030.hosting.ovh.net/index.php?pma_username=swingstadmin&pma_servername=swingstadmin.mysql.db'
        ]
    ];

    $dbname = "swingstadmin";
    $txt = "Mo";
    $sql = "SELECT table_schema $dbname, SUM( data_length + index_length) / 1024 / 1024 $txt FROM information_schema.TABLES WHERE TABLE_NAME like 'swing%' GROUP BY table_schema;";
    $exec = [];
    $db_size = CRUD::sql($sql, $exec, 'fetchAll', $dbname);

    function get_db_size($db_size, $dbname){
        // var_dump("DB_NAME", $dbname);
        $txt = 'Mo';
        $size = 0;
        $DB_INFOS = [];
        for($i = 0; $i < count($dbname); $i++){
            $db = $dbname[$i];
            // $DB_INFOS[$db];
            foreach($db_size as $key => $val){
                foreach($val as $k => $v){
                    if($val[$k] == $db){
                        // var_dump([$db => $val[$txt]]);
                        $size += $val[$txt];
                    }
                }
            }
            $DB_INFOS[$db] = $size;
        }
        
        // var_dump($DB_INFOS);

        $result = "<div>";
        foreach($DB_INFOS as $k => $v){
            $result .= '<p>&emsp;' . $k . ": " . round($v, 2) . " Mo / 200 Mo" . " - <a href='https://phpmyadmin.cluster030.hosting.ovh.net/index.php?pma_username=swingstadmin&pma_servername=swingstadmin.mysql.db'>swingstadmin</a>" . "</p>";
        }
        $result .= "</div>";

        // var_dump($result);

        return $result;
    }
    // get_db_size($db_size, [$dbname]);

?>
<!-- form add task -->
<div class="modal" id="add_task_form">
    <div class="cadre">
        <h2>Nouvelle tâche</h2>
        <form method="post" onsubmit="return send_task(this);">
            <input type="hidden" id="user_id" name="user_id" value="<?=$_SESSION['user']['id'];?>">
            <p>
                <label for="task">nom de la tâche :</label>
                <input type="text" id="task" name="task" maxlength="255" required>
            </p>
            <p>
                <label for="description">description: </label>
                <textarea name="description" id="description" cols="30" rows="10"></textarea>
            </p>
            <p>
                <input type="submit" class="submit_btn" value="OK">
                <input type="button" class="cancel_btn" onclick="Tools.css(Tools.id('add_task_form'), 'display', 'none');" value="Annuler">
            </p>
        </form>
    </div>
</div>

<!-- page -->
<section id="admin">
	<h1>ZONE ADMIN</h1>
    <?=$site->nav('admin'); ?>
    <hr>
	<div id="content_page" class="row content">
        <?php if(!empty(url_data('subpage'))): ?>
            <?php
               /* if(url_data('mode') == 'admin'){
                    $test_list = ['admin_', 'admin_gestion_', 'gestion_', 'admin_build_', 'build_'];
                    $dir_list = ['gestion'];
                    $split = explode('_', url_data('page'));
                    $dir = in_array($split[0], $dir_list) ? $split[0] : null;
                    $page = '';

                    if(in_array(, [])){

                    }else{

                    }
                }*/
                
            ?>
            <?php //include_once "./page/${url_data('mode')}/gestion/" . url_data('subpage') . ".php"; ?>
            <?php include_once "./page/admin/gestion/" . url_data('subpage') . ".php"; ?>
        <?php else: ?>
	        <h2 class="">Panneau de contrôle</h2>
	        <div id="server_infos" class="panel">
                <h3 class="center">Infos hébergement</h3>
                <hr>
                <p>Domaine: <?=$_SERVER['SERVER_NAME'] ;?></p>
                <p>Hébergeur: <a href="https://www.ovh.com/be/">OVH</a></p>
                <p>Niveau de support: Perso</p>
                <p>Type de serveur: <?=$_SERVER['SERVER_SOFTWARE']; ?> - <a href="https://httpd.apache.org/">DOC Apache</a></p>
                <p>HTTPS: <?=(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on' ? '<span class=lime>ON' : '<span class=red>OFF') . '</span>'; ?></p>
                <?=$config->get('ini', 'SERVER')['host'] == 'OVH' ? "<p>OVH utilisateur: " . $_SERVER['USER'] . "</p>" : '';?>
                <p>Server admin: <?=$_SERVER['SERVER_ADMIN']; ?></p>
                <p>IPv4: <?=$_SERVER['SERVER_ADDR']; ?></p>
                <p>IPv6: <?=$_SERVER['REMOTE_ADDR']; ?></p>
                <p>Port: <?=$_SERVER['SERVER_PORT']; ?></p>
                <p>Protocol: <?=$_SERVER['SERVER_PROTOCOL']; ?></p>
                <p>Certificat SSL: <?=$SSL; ?> <a href="https://letsencrypt.org/fr/">(Letsencrypte)</a>
                    <p>&emsp;Créé le: <?=date('d-m-Y H:i:s', $_SESSION['SSL']['create']);?></p>
                    <p>&emsp;Expire le: <?=date('d-m-Y H:i:s', $_SESSION['SSL']['expire']);?></p>
                </p>
                <p>Root: <?=$_SERVER['DOCUMENT_ROOT']; ?></p>
                <p>Espace disque: <?="$total_size Go / 100 Go" ?></p>
                <p>Email: <span class="lime">ON</span> - <a href="mailto:contact.swingshift@gmail.com">contact.swingshift@gmail.com</a></p>
                <p>FTP: <span class="lime">ON</span> - <a href="https://net2ftp.cluster030.hosting.ovh.net/?username=swingst">FTP accès</a></p>
                <p class="bg_white_05">
                    DB: <?=get_db_size($db_size, [$dbname])?>
                </p>
            </div>
            <div id="statistic" class="panel">
                <h3 class="center">statistiques (exemple non fonctionnel)</h3>
                <hr>
                <p>Visiteurs actuellement sur le site: 0</p>
                <p>Nombre total de visites: 0</p>
                <p>Nombre d'abonné à la newsletter: 0</p>
                <p>Nombre d'utilisateurs actuellement connecté: 1</p>
                <p>Nombre total d'utilisateurs: 1</p>
                <p>Page la plus visitée: home</p>
                <p>Langue la plus utilisée: français</p>
                <p>Nombre de membres actuellement sur le site: 1</p>
                <p>Nombre de membres total: 1</p>
                <p>Nombre de téléchargement d'images: 0</p>
                <p>Nombre de téléchargement de sons: 0</p>
                <p>Nombre de téléchargement de vidéos: 0</p>
                <p>Nombre de téléchargement de partitions: 0</p>
                <p>Nombre de téléchargement de la fiche technique: 0</p>
                <p>Nombre de bannis actuellement: 0</p>
            </div>
            <div id="taches" class="panel" style="border: 1px solid white;">
                <h3 class="center">Liste de tâches <button class="add_plus_btn pointer" onclick="add_task();">+</button></h3>
                <hr>
                <div id="task_list"><!-- vide ! --></div>
            </div>
        <?php endif; ?>
	</div>
</section>
