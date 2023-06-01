<!-- ****************************** VS 2 ******************************* -->
<!-- 
	HTML group
	SITE SwingShift
	DOMAIN http://www.swingshift.be
	AUTHORS Collart Kevin
	VERSION 2020/11/10 TO 15H55
-->
<section id="group">
<?php
	$page_content = $site->get('content_page', !empty(url_data('page')) ? url_data('page') : 'home');
	$current_list = [];
	$current_tag = null;
	$level = 0;
	$suspended_content = [];
	foreach($page_content as $k => $v){
		if(preg_match("/^php_/i", $v['elem'])){
			$split = explode("_", $v['elem']);
			$method = implode("_", array_slice($split, 2, count($split)));
			if(in_array($method, ['more']) && !empty($v['url'])){
				$param = $v['url'];
				// voir pour detect method static ou non !!!
				echo ${$split[1]}->$method($param);
			} else echo '<p>ERROR [ METHOD ] => ' . $method . ' : NOT EXIST !!!</p>';
		}else if(in_array($v['elem'], HTML::get_html_tags()['simple']) || in_array($v['elem'], HTML::get_html_tags()['double'])){
			$attr = [];
			$content = '';
			// attributes
			if(!empty($v['html_id'])) $attr['id'] = $v['html_id'];
			if(!empty($v['html_class'])) $attr['class'] = $v['html_class'];
			if(!empty($v['html_attr'])){
				$list = JSON::decode($v['html_attr'], true);
				foreach($list as $key => $val){
					if(is_string($key)) $attr[$key] = $val;
					else $attr[] = $val;
				}
			}
			if(!empty($v['url']) && $v['elem'] == 'img') $attr['src'] = $v['url'];
			// content
			if(preg_match("/%{ swing_[A-Za-z_]+ : [A-Za-z_]+\[(.+, ?.+)+] }%/", $v['description'])){
				$data = explode(' : ', preg_replace("/ ?}%$/", '', preg_replace("/%{ ?/", '', $v['description'])));
				$split = explode('[', substr($data[1], 0, strlen($data[1]) - 1));
				$current_list[$level][$data[0]][$split[0]] = preg_split("/, ?/", $split[1]);
				$suspended_content[$level] = [
					'tag' => $v['elem'],
					'attr' => $attr
				];
				$current_tag = $level++;
				print_r($current_list);
				var_dump(['current_tag' => $current_tag]);
				var_dump('suspended_content', $suspended_content);
				if(!empty($v['txt'])){
					echo HTML::get('tag', [
						'tag' => $v['elem'],
						'attr' => $attr,
						'content' => $v['txt']
					]);
				}
				$array = $current_list[$level - 1]['swing_content_page']['id'];
				if(isset($v['elem_id']) && in_array($v['elem_id'], $array) && !empty(array_search($v['elem_id'], $array))){
					array_splice(
						$current_list[$level - 1]['swing_content_page']['id'], 
						array_search($v['elem_id'], $current_list[$level - 1]['swing_content_page']['id']), 
						1
					);
				}
			}else{
				var_dump($v);
				if(!empty($suspended_content)){
					// $array = $suspended_content[$level - 1]['swing_content_page'];
					// $array = $current_list[$level - 1]['swing_content_page']['id'];
					$array = $current_list[$level - 1]['swing_content_page']['id'];
					var_dump($array);
					print_r($current_list);
					if(isset($v['elem_id']) && in_array($v['elem_id'], $array) && !empty(array_search($v['elem_id'], $array))){
						array_splice(
							$current_list[$level - 1]['swing_content_page']['id'], 
							array_search($v['elem_id'], $current_list[$level - 1]['swing_content_page']['id']), 
							1
						);
					}
				}else if(empty($suspended_content)){
					if(!empty($v['txt'])){
						echo HTML::get('tag', [
							'tag' => $v['elem'],
							'attr' => $attr,
							'content' => $v['txt']
						]);
					}
				} else echo 'ERROR [ NO DATA ] !!!';


				/*if(in_array($v['elem_id'], $current_list)){
					// array_search($current_tag, $suspended_content)
				}else if(!empty($v['txt']) && empty($suspended_content)){
					echo HTML::get('tag', [
						'tag' => $v['elem'],
						'attr' => $attr,
						'content' => $v['txt']
					]);
				}else if(!empty($suspended_content)){
					// array_shift(array);
				}*/
			}
		} else echo '<p>ERROR [ DATA PAGE ] : NOT VALID !!!</p>';
	}
?>
</section>
<!-- ****************************** VS 1 ******************************* -->
<?php
	$group = $site->get('content_page', 'group');
	$current = [];
	foreach($group as $index => $elem){
		if(preg_match("/^php_/", $elem['elem'])){
			$one_param = ['more'];
			$split = explode("_", $elem['elem']);
			$method = implode("_", array_slice($split, 2, count($split)));
			if(in_array($method, $one_param) && !empty($elem['url'])) $param = $elem['url'];
			else $param = null;
			echo ${$split[1]}->$method($param);
		}else if(in_array($elem['elem'], HTML::get_html_tags()['simple']) || in_array($elem['elem'], HTML::get_html_tags()['double'])){
			$attr = [];
			$content = '';
			if(!empty($elem['html_id'])) $attr['id'] = $elem['html_id'];
			if(!empty($elem['html_class'])) $attr['class'] = $elem['html_class'];
			if(!empty($elem['html_attr'])){
				$list = JSON::decode($elem['html_attr'], true);
				foreach($list as $k => $v){
					if(is_string($k)) $attr[$k] = $v;
					else $attr[] = $v;
				}
			}
			if(!empty($elem['url']) && $elem['elem'] == 'img') $attr['src'] = $elem['url'];
			if(empty($elem['txt']) && empty($elem['url']) && preg_match("/%{ swing_[A-Za-z_]+ : [A-Za-z_]+\[(.+, ?.+)+] }%/", $elem['description']) && empty($current)){
				$data = explode(' : ', preg_replace("/ ?}%$/", '', preg_replace("/^%{ ?/", '', $elem['description'])));
				$table = $data[0];
				$split = explode('[', substr($data[1], 0, strlen($data[1]) - 1));
				$column = $split[0];
				$array = preg_split("/, ?/", $split[1]);
				$current[$table][$column] = $array;
				var_dump($current);
			}else if(!empty($elem['txt']) && !preg_match("/%{ swing_[A-Za-z_]+ : [A-Za-z_]+\[(.+, ?.+)+] }%/", $elem['description']) && empty($content)){
				$content = $elem['txt'];
			}else if(!empty($elem['description']) && !preg_match("/%{ swing_[A-Za-z_]+ : [A-Za-z_]+\[(.+, ?.+)+] }%/", $elem['description']) && empty($content)){
				$content = 'KC_TEST ' . $elem['description'];
			}else{
				$content = 'NO CONTENT !';
			}
			if(!empty($current)){
				// array_shift($current);

			}else{
				echo HTML::get('tag', [
					'tag' => $elem['elem'],
					'attr' => $attr,
					'content' => $content
				]);
			}
		}else{
			echo "Data page not valid !";
		}
	}
	 
	$group = $site->get('infos_page', 'group');
	// var_dump($group);
	$txt = [];
	foreach($group['text'] as $k => $v){
		$key = preg_replace("/^group\//i", '', $v['trad']);
		$row = [$key => $v[$_SESSION['lang']]];
		$txt[] = $row;
	}
	// var_dump($txt);
	$presentation = [];
	$musicos = [];
	$musician = [];
	$title = '';
	foreach($txt as $key => $val){
		foreach($val as $k => $v){
			$tab = explode('_', $k);
			// var_dump($tab, $v);
			if($k == 'title'){
				$title = $v;
			}else if(preg_match("/^presentation/i", $tab[0]) && $tab[1] == 'title'){
				$presentation['title'] = $v;
			}else if(preg_match("/^presentation/i", $tab[0]) && $tab[1] != 'title'){
				$index = substr($tab[1], 1);
				$presentation[$index] = $v;
			}else if(preg_match("/^musicos/i", $tab[0])){
				$index = $tab[0];
				$musicos[$index] = $v;
			}
		}
		foreach($group['members'] as $k => $v){
			$musician[$k] = $v;
		}
	}
	// var_dump($article);
	// var_dump($title, $presentation, $musician);
?>
	<h1><?=$site->txt('page/group');?></h1>
	<section id="presentation">
		<h2><?=$presentation['title'];?></h2>
		<?php
			ksort($presentation);
			foreach($presentation as $k => $v){
				if($k != 'title'){
					echo HTML::get('tag', ['tag' => 'p', 'content' => $v]);
				}
			}
		?>
	</section>
	<section id="musicos">
		<h2>musicos</h2>
		<?php
			ksort($musicos);
			// var_dump($musicos);
			// var_dump($musician);
			$conductor = ['first_conductor'];
			$rythm = ['P', 'G', 'CB', 'GB', 'PRQ', 'D'];
			$sax = ['SA1', 'SA2', 'ST1', 'ST2', 'SB', 'C'];
			$trb = ['TB1', 'TB2', 'TB3', 'TB4'];
			$trp = ['TP1', 'TP2', 'TP3', 'TP4'];
			$vocal = ['CHF', 'CHM'];
			foreach($musicos as $key => $val){
				$tab = explode('/', $key);
				// var_dump($tab[1]);
				echo '<h3>' . ucwords($val) . '</h3>';
				echo '<article id="' . $tab[1] . '">';
				foreach($musician as $k => $v){
					if(in_array($v['instru_abvr'], ${$tab[1]}) || in_array($v['funct_name'], ${$tab[1]})){
						if(empty($v['firstname']) && empty($v['lastname'])){
							$firstname = 'Wanted';
							$lastname = '';
						}else{
							$firstname = $v['firstname'];
							$lastname = $v['lastname'];
						}
						if(preg_match("/%{ .+ }%+/i", $v['fonction'])){
							// var_dump($v['fonction']);
							$split = explode(', ', $v['fonction']);
							// var_dump($split);
							$result = '';
							$i = 0;
							foreach($split as $k_split => $v_split){
								// var_dump($v);
								if($i == 0) $i++;
								else $result .= ',<br><br>';
								$table 	= preg_replace("/^%{ ([a-z_]+) ([a-z_]+) = ([0-9]+) }%$/i", "$1", $v_split);
								$col 	= preg_replace("/^%{ ([a-z_]+) ([a-z_]+) = ([0-9]+) }%$/i", "$2", $v_split);
								$value 	= preg_replace("/^%{ ([a-z_]+) ([a-z_]+) = ([0-9]+) }%$/i", "$3", $v_split);
								if($table == 'trad') $result .= $site->txt($value);
							}
							$fonction = $result;
						}
						else $fonction = $v['fonction'];
						$img = !empty($v['image']) ? $v['image'] : './img/anonymous.jpg';
						echo HTML::musician_fiche([
							'url' => $img,
							'firstname' => $firstname,
							'lastname' => $lastname,
							'instru' => $v['instrument'],
							'fonction' => $fonction
						]);
					}
				}
				echo '</article>';
			}
		?>
	</section