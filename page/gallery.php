<!-- 
	@HTML gallery
	@SITE SwingShift
	@DOMAIN http://www.swingshift.be
	@AUTHORS Collart Kevin
	@VERSION 2020/11/10 TO 15H55
-->
<section id="galery" style="position: relative;">
<?php if(!empty(url_data('id'))): ?>
	<?php
		$crud = new CRUD;
		$gallery_name = $site->txt($crud->select($db, 'gallery', 'name_id', ['id' => url_data('id')], 'fetch')['name_id']) ?? 'NO GALLERY NAME';
	?>
	<h2><?=$site->txt('page/gallery');?> - <?=$gallery_name;?></h2>
	<?=$site->close('./?page=gallery');?>
<?php else: ?>
	<h2><?=$site->txt('page/gallery');?></h2>
<?php endif; ?>
<section id="galerie" style="position: relative;">
	<?php if(!empty(url_data('id'))): ?>
		<style>
			#defile_img{
				position: relative;
				display: -ms-flexbox;
				display: -webkit-box;
				   display: -moz-box;
				display: -webkit-flex;
						display: flex;
				-ms-flex-direction: row;
					flex-direction: row;
				justify-content: flex-start;
				align-items: stretch;
				width: 100%;
				padding: 1rem;
				background-color: transparent;
				margin: 0;
				border: 0;
				overflow: hidden;
			}
			#backward, #print_img, #forward{
				margin: 0;
				padding: 1rem;
				-webkit-box-flex: 0 1 auto;
				   -moz-box-flex: 0 1 auto;
					-webkit-flex: 0 1 auto;
						-ms-flex: 0 1 auto;
							flex: 0 1 auto;
				background-color: rgba(0, 0, 0, 0.25);
				text-align: center;
			}
			#print_img figure{
				position: relative;
				margin: 0 auto;
				border: 3px solid black;
				padding: 0;
				width: 1000px;
				height: 500px;
				text-align: center;
				overflow: hidden;
			}
			#print_img figure img{
				position: relative;
				margin: 0;
				border: 0;
				padding: 0;
				display: block;
				width: none;
			}
			#backward{
				width: 10%;
			}
			#forward{
				width: 10%;
			}
			#backward, #forward{
				font-size: 5rem;
				color: rgba(255, 255, 255, 0.5);
				transition: 1s background-color ease-in-out;
				padding-top: 12.5%;
			}
			#backward:hover, #forward:hover{
				background-color: rgba(0, 0, 0, 0.5);
			}
			#print_img{
				margin: 0 auto;
				width: 80%;
			}
			#loading{
				margin: 0;
				border: 1 solid transparent;
				padding: 0;
				display: block;
				position: absolute;
				background-color: rgba(0, 0, 0, 0.5);
				background-image: url('./img/site/loading.gif');
				background-repeat: no-repeat;
				background-size: 12.5%;
				background-position: 50%;
				width: 100%;
				height: 100%;
				z-index: 1050;
				text-align: center;
			}
			#no_charge{
				display: block;
			}
		</style>
		<script>var gallery_id = <?=url_data('id');?>;</script>
		<div id="no_charge" style="display: block; text-align: center; width: 100%; border: 5px solid #ff000077; border-radius: 10px; background-color: #ff000077;color: #FFFFFF;">
			<h3 style="color: #FFFFFF; text-transform: uppercase;">Erreur de chargement</h3>
			<p style="color: #FFFFFF;">
				Impossible de charger la gallerie !
			</p>
			<small style="color: #FFFFFF;">
				Si ce message persiste, veuillez, s'il vous plaît, contacter le groupe qu'il y a une défaillance dans la galerie. Le webmaster vous remercie de votre attention.
			</small><br><br>
		</div>
		<div id="defile_img">
			<div id="backward" class="pointer" title="image precedente" onclick="jean_pierre.backward();">&#10096;</div>
			<div id="print_img">
				<figure>
					<div id="loading"></div>
					<!-- <img id="gallery_img_print" src="./logo.jpg" alt="jean_pierre.alt" title="jean_pierre.title"> -->
					<img id="gallery_img_print" src="./img/no_img.png" alt="jean_pierre.alt" title="jean_pierre.title">
				</figure>
				<p id="gallery_img_descr">no description !</p>
			</div>
			<div id="forward" class="pointer" title="image suivante" onclick="jean_pierre.forward();">&#10097;</div>
			<div id="options_defile"></div>
		</div>
		<?php
		/*
		AJAX -> PHP -> JS
		 */
			/*$gallery_infos = $site->get('infos_page', 'gallery');
			$gallery_elem = $site->get('gallery', url_data('id', true));
			$dirname = !empty($gallery_elem['dir']) ? './' . $gallery_elem['dir'] : null;
			if(!empty($dirname)){
				$dir = opendir($dirname);
				while($file = readdir($dir)){
					if($file != '.' && $file != '..' && !is_dir($dirname . $file)){
						echo '<article style="background-color:transparent;"><img style="vertical-align:middle;" src="' . $dirname . '/' . $file . '" alt="img"></article>';
					}
				}
				closedir($dir);
			}else{
				echo '<p class=infos>NO IMAGES DIRECTORY !</p>';
			}*/
		?>
	<?php else: ?>
		<?php
			$gallery_infos = $site->get('infos_page', 'gallery');
			$gallery_list = $site->get('gallery');
			// var_dump($gallery_infos);
			$gallery = '';
			foreach($gallery_list as $k => $v){
				$picture = !empty($v['picture']) ? $v['picture'] : 'img/affiches/no_poster.jpg';
				echo '<article title="' . $site->txt('word_diary_table_details') . ' - ' . $v['title'] . '">'
					. '<a href="./?page=gallery&id=' . $v['gallery_id'] . '">'
					. '<figure><img src="./' . $picture . '" alt="img" style="width: 100%;"></figure>'
					. '<p class=title>' . $v['date'] . ' - ' . $v['title'] . '</p>'
					. '</a>'
					. '</article>'
				;
			}
		?>
	<?php endif; ?>
</section>
</section>