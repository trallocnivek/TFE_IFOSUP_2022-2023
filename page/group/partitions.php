<!-- 
	@HTML sheet music
	@SITE SwingShift
	@DOMAIN http://www.swingshift.be
	@AUTHORS Collart Kevin
	@VERSION 2020/11/10 TO 15H55
-->
<?php
	require_once './page/utils/form_parts.php';
	/**
	 * @class Sheet_music
	 * @description music sheet filters and search in DB
	 * @property
	 *  [private]
	 *  	- $filters
	 * @method
	 *  [public]
	 *  	- __construct()
	 *  	- set()
	 *  	- get()
	 *  [private]
	 *  	- get_filters()
	 * @uses global [$db], class [DB, HTML], file []
	 * @api sheet music
	 * @author COLLART Kevin <trallocnivek@gmail.com>
	 * @version 2021/01/07 TO 02H00
	 */
	class Sheet_music{
		private $filters = [
			'active',
			'arranger',
			'author',
			'date', 
			'group',
			'instrument',
			'land',
			'music_num',
			'nbr_pages', 
			'page',
			'style',
			'title',
			'ton',
			'type_instru',
		];
		use db_utils;
		public function __construct(){

		}
		public function set($attr, $v){
			$this->$attr = $v;
		}
		public function get($f, $p = null){
			return self::{'get_' . $f}($p);
		}
		private function get_filters(){
			$filters = $this->$filters;
			$html = '';
			foreach($filters as $v){
				$infos = '';
				$html .= '';
			}
			return HTML::form($form = [], $data = [$input], $button = 'submit_input', $order = true);
		}
		private function get_list_authors(){
			$sql = "SELECT * FROM swing_authors";
			$exec = [];
			return self::request($sql, $exec);
		}
	}
?>
<?php
	$form_search = HTML::form(
		[
			'id' => 'cheet_search',
			'name' => 'cheet_search',
			'action' => './',
			'method' => 'get',
			'class' => '',
			'style' => 'display: inline-block; padding: 0.125rem 1rem; width: 100%; border: 1px solid white;',
			'autocomplete' => 'off'
		],
		[
			/*'title' => [
				'tag' => 'h2',
				'attr' => ['class' => 'form-group'],
				'content' => 'search'
			],*/
			'hidden' => [
				'page' => 'partitions'//,
				// 'action' => 'search'
			],
			'data_block' => [],
			'content' => [
				'search' => [
					'label' => [
						'attr' => [
							'style' => 'display: inline-block; width: 5%;'
						],
						'content' => /*$site->txt('word_title') . */'search :'
					],
					'input' => [
						'type' => 'search',
						'placeholder' => 'search ...',
						'class' => '',
						'style' => 'display: inline-block; width: 87%;'
					]
				]
			]
		],
		[
			'tag' => 'button',
			'attr' => [
				'type' => 'submit',
				'class' => 'submit_button pointer',
				'style' => 'margin-left: 1rem;'
			],
			'content' => 'Search'
		]
	);
	$form_filters = HTML::form(
		[
			'id' => 'filters_music_sheet_form',
			'class' => 'form-check-label',
			'autocomplete' => 'off'
		],
		[
			'data_block' => [
				'tag' => 'div',
				'attr' => ['class' => 'form-group']
			],
			'content' => [
				'actif' => [
					'label' => [
						'attr' => [
							'style' => 'display: inline-block; width: 5%;'
						],
						'content' => /*$site->txt('word_title') . */'actif :'
					],
					'input' => [
						'type' => 'checkbox',
						'class' => 'form-control',
						'onchange' => ""
					]
				]
			]
		],
		null
	);
	$form_create_dir = '';/*HTML::form(
		[
			'id' => 'new_music_sheet_form',
			'class' => 'form-check-label',
			'autocomplete' => 'off'
		],
		[
			'title' => [
				'tag' => 'h2',
				'attr' => ['class' => 'form-group'],
				// 'content' => $site->txt('form/search_musicsheet')
				'content' => "Ajouter une partition"
			],
			'hidden' => [
				'page' => 'db_sheet',
				'action' => 'add_sheet',
				'id' => url_data('id')
			],
			'required_infos' => [
				'tag' => 'p',
				'attr' => ['class' => 'form-group required bold red'],
				'content' => $site->txt('form/require')
			],
			'data_block' => [
				'tag' => 'div',
				'attr' => ['class' => 'form-group']
			],
			'content' => [
				'title' => [
					'label' => $site->txt('word_title') . ' :',
					'input' => [
						'type' => 'text',
						'placeholder' => 'titre du morceau',
						'class' => 'form-control'
					],
					'infos' => [
						'count' => [
							'min' => '1',
							'max' => '255'
						],
						'valid' => $site->txt('form/valid'),
						'invalid' => $site->txt('form/invalid/name')
					],
					'required',
					'autofocus'
				],
				'number' => [
					'label' => $site->txt('word_number') . ' :',
					'input' => [
						'type' => 'text',
						'placeholder' => 'numero du morceau',
						'class' => 'form-control'
					],
					'infos' => [
						'count' => [
							'min' => '1',
							'max' => '255'
						],
						'valid' => $site->txt('form/valid'),
						'invalid' => $site->txt('form/invalid/number')
					],
					'required'
				]
			]
		]
	);*/
	// SELECT * FROM `swing_trad` WHERE trad LIKE "word%"
	// SELECT * FROM `swing_trad` WHERE trad LIKE "%title%"
?>
<style>
	input[type=search]{
		color: black;
	}
</style>
<section id="musicsheet" style="position: relative;">
	<!-- ?=Page::build($site->get('content_page', !empty(url_data('page')) ? url_data('page') : 'home'));? -->
	<h1>Partitions</h1>
	<?=(!empty(url_data('id')) ? $site->close('./?page=partitions') : '');?>
	<div id="search_sheet">
		<?=$form_search;?>
		<!-- < ?=$form_filters;?> -->
	</div>
<?php if(url_data('action') == 'add'): ?>
	<div id="crud_sheet">
		<?=$form_create_dir;?>
	</div>
<?php endif; ?>
<?php if(!empty(url_data('id'))): ?>
	<div id="sheet_id">
		<?php
			$data = $site->get('musicsheet', ['id' => url_data('id')])[0];
			// var_dump($data);
		?>
		<div>
			<h2 style="display: inline-block;"># <?=$data['number'];?> - <?=$data['title'];?></h2>
			<!-- <div id="sheet_id_crud" class="right" style="display: inline-block; padding: 1rem;">
				<a class="read_btn" href="./?page=partitions&id=< ?=url_data('id');?>&action=read">Visionner une partition</a>
				<a class="add_btn" href="./?page=partitions&id=< ?=url_data('id');?>&action=add">Ajouter une nouvelle partition</a>
				<a class="update_btn" href="./?page=partitions&id=< ?=url_data('id');?>&action=update">Mettre a jour une partiton</a>	
				<a class="delete_btn" href="./?page=partitions&id=< ?=url_data('id');?>&action=delete">Supprimer une partition</a>
			</div> -->
		</div>
		<?php
			$error = "<div id='no_charge' style='display: block; text-align: center; width: 100%; border: 5px solid #ff000077; border-radius: 10px; background-color: #ff000077;color: #FFFFFF;'>
					<h3 style='color: #FFFFFF; text-transform: uppercase;'>Erreur de chargement</h3>
					<p style='color: #FFFFFF;'>
						Impossible de charger les partitions !
					</p>
					<small style='color: #FFFFFF;'>
						Si ce message persiste, veuillez, s'il vous plaît, contacter le groupe qu'il y a une défaillance dans la galerie. Le webmaster vous remercie de votre attention.
					</small><br><br>
				</div>"
			;
			$name = $data['title'];
			$name = preg_replace("/\s/", '', ucwords($name));
			$dirname = "./admin/music_sheet/" . $data['number'] . '-' . $name;
			// var_dump($dirname);
			$dirname = file_exists($dirname) ? $dirname : null;
			// var_dump(scandir($dirname));
			$iframe = './img/no_img.png';
			if(!empty($dirname)){
				$dir = opendir($dirname);
				// var_dump($dir);
				$i = 1;
				$j = 0;
				$list = '';
				while($file = readdir($dir)){
					if($file != '.' && $file != '..' && !is_dir($dirname . '/' . $file)){
						// var_dump($file);
						if(empty($j)) $iframe = $dirname . '/' . $file;
						$list .= '<p><button style="width: 10rem;" class="details_btn" onclick="change_frame(\'' . $dirname . '/' . $file . '\');">' 
							. preg_replace("/ ?-.*/", "", $file) . '</button></p>'
						;
					}else{
						$i--;
					}
				}
				closedir($dir);
				if(!empty($list)){
					echo '<div class="left" style="max-height: 600px; overflow: auto; padding: 0 4rem; background: rgb(82, 86, 89);">' . $list . '</div>';
					echo '<div class="right"><iframe id="partosch" src="' . $iframe . '" frameborder="0" width="1250px" height="600px" style="color: white;"></iframe></div>';
				} else echo $error;
			} else echo $error
		?>
	</div>
<?php else: ?>
	<div id="sheet_list">
		<h2>Liste des morceaux</h2>
		<?php
			$data = $site->get('musicsheet', ['search' => url_data('search')]);
			// id = sheet_id, number, title, active
			// var_dump($data);
			$data = array_map(function($x){
				$action = '<a class="details_btn" href="./?page=partitions&id=' . $x['sheet_id'] . '">Détails</a>';
				return [
					[
						'class' => 'pointer',
						'title' => '# ' . $x['number'] . ' - ' . $x['title'],
						'onmouseenter' => "Tools.css(this, 'backgroundColor', '#FFFFFF33');",
						'onmouseleave' => "Tools.css(this, 'backgroundColor', 'transparent');",
						'onclick' => "location.href = './?page=partitions&id=" . $x['sheet_id'] . "';"
					],
					'sheet_id' => $x['sheet_id'],
					'number' => " {$x['number']} ",
					'title' => $x['title'],
					'active' => (string) $x['active'] != '0' ? '<span class=lime>joué</span>' : '<span class=red>non joué</span>',
					'action' => $action
				];
			}, $data);
			// var_dump($data);
			echo HTML::table([], [
				'header' => [
					'content' => [
						[
							[
								'list' => 'number',
								'attr' => [
									'style' => 'background-color: black;'
								],
								// 'content' => 'n°'
								'content' => '&numero;'
							],
							[
								'list' => 'title',
								'content' => 'titre'
							],
							[
								'list' => 'active',
								'content' => 'actif'
							],
							[
								'list' => 'action',
								'content' => 'actions'
							]
						]
					]
				],
				'body' => ['content' => $data]
			]);
		?>	
	</div>
<?php endif; ?>
</section>