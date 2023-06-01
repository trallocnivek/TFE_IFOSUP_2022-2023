<!-- 
	@HTML demos
	@SITE SwingShift
	@DOMAIN http://www.swingshift.be
	@AUTHORS Collart Kevin
	@VERSION 2020/11/10 TO 15H55
	' . pathinfo($file)['extension'] . '
-->
<section id="demos" style="max-width: 100%;">
	<!-- ?=Page::build($site->get('content_page', !empty(url_data('page')) ? url_data('page') : 'home'));?> -->
	<h2><?=$site->txt('page/demos');?></h2>
	<!-- <h3>videos</h3> -->
	<!-- <div id="video"> -->
		<!-- <figure>
			<video preload="none" poster="./img/video.png" autobuffer="autobuffer">
				<source src="./video/" type="video/">
				<track></track>
			</video>
			<figcaption>
				
			</figcaption>
		</figure> -->
	<?php
		/*$dirname = './video';
		$dir = opendir($dirname);
		$video_list = [];
		$i = 0;
		while($file = readdir($dir)){
			$path = $dirname . '/' . $file;
			if($file != '.' && $file != '..' && !is_dir($path) && $i === 0){
				$finfo = finfo_open(FILEINFO_DEVICES);
				var_dump(finfo_file($finfo, $path));
				finfo_close($finfo);
				$i++;*/
				// $video_list[] = [
					// 'path' => $path,
					// 'file' => $file,
					// 'mime' => mime_content_type($path)
				// ];
			//}
		// }
		// closedir($dir);
				// var_dump(pathinfo($file)['filename']);
				/*echo '
					<div class="video_box">
						<video preload="metadata" style="width: 100%;" controls>
							<source src="' . $dirname . DIRECTORY_SEPARATOR . $file . '" type="video/mp4">
						</video>
						<div class="video_infos">
							<p>' . pathinfo($file)['filename'] . '</p>
						</div>
					</div>
				';*/
	?>
	<!-- </div> -->
	
	<!-- <p style="padding-left: 1rem;">Pas de vidéos !</p> -->
	<!--h3>bandes sons</h3-->
	<?php
		$dirname = './sound';
		$dir = opendir($dirname);
		while($file = readdir($dir)){
			if($file != '.' && $file != '..' && !is_dir($dirname . $file)){
				echo '<p style="text-align: center; border:1px white solid;padding: 0.5rem;"><span style="text-align: left !important; display: inline-block; padding: 1.25rem; vertical-align: top; width: 50%;">' . $file . '</span> <audio style="padding-left: 1rem;" controls><source src="' . $dirname . '/' . $file . '"></audio></p>';
			}
		}
		closedir($dir);
	?>
</section>
<?php
/**
 * GetID3
 * Gestion des métadonnées de fichiers sonores et vidéos directement dans SPIP
 *
 * Auteurs :
 * kent1 (http://www.kent1.info - kent1@arscenic.info), BoOz
 * 2008-2016 - Distribué sous licence GNU/GPL
 *
 * @package SPIP\GetID3\Metadatas
 */

// if (!defined('_ECRIRE_INC_VERSION')) {
	// return;
// }

/**
 * Fonction de récupération des métadonnées sur les fichiers vidéo
 * appelée à l'insertion en base dans le plugin medias (inc/renseigner_document)
 *
 * @param string $file
 *    Le chemin du fichier à analyser
 * @return array $metas
 *    Le tableau comprenant les différentes metas à mettre en base
 */
// function metadata_video($file) {
	// $meta = array();
// 
	// include_spip('lib/getid3/getid3');
	// $getID3 = new getID3;
	// $getID3->setOption(array('tempdir' => _DIR_TMP));
// 
	// Scan file - should parse correctly if file is not corrupted
	// $file_info = $getID3->analyze($file);
// 
	// /**
	 // * Les pistes vidéos
	 // */
	// if (isset($file_info['video'])) {
		// $id3['hasvideo'] = 'oui';
		// if (isset($file_info['video']['resolution_x'])) {
			// $meta['largeur'] = $file_info['video']['resolution_x'];
		// }
		// if (isset($file_info['video']['resolution_y'])) {
			// $meta['hauteur'] = $file_info['video']['resolution_y'];
		// }
		// if (isset($file_info['video']['frame_rate'])) {
			// $meta['framerate'] = $file_info['video']['frame_rate'];
		// }
	// }
	// if (isset($file_info['playtime_seconds'])) {
		// $meta['duree'] = round($file_info['playtime_seconds'], 0);
	// }
// 
	// return $meta;
// }
/*
<button onclick="makeBig()">Big</button>
<button onclick="makeSmall()">Small</button>
<button onclick="makeNormal()">Normal</button>
<button onclick="makeNosound()">Muted</button>
<br><br>
<video title="Wildlife" preload="auto" controls width="420" class="center-block" id="video1">
<source src="medias/wildlife.ogv" type="video/ogg">
<p>Wildlife</p>
</video>
</div>

<script>
var myVideo = document.getElementById("video1");
function playPause() {
if (myVideo.paused)
myVideo.play();
else
myVideo.pause();
}
function makeBig() {
myVideo.width = 560;
}
function makeSmall() {
myVideo.width = 320;
}
function makeNormal() {
myVideo.width = 420;
}
function makeNosound() {
myVideo.muted="muted";
}
</script>
 */