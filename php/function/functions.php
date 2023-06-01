<?php
	/**
	 * @version 2020/10/06 TO 08H13
	 */
	/**
	 * @function url_data(string $x [, boolean $protected = true])
	 * @param string $x array key
	 * @param boolean $protected htmlspecialshers()
	 * @return string or null
	 */
	function url_data($x, $protected = true){
		if(isset($_GET[$x]) && !empty($_GET[$x])) return $protected ? htmlspecialchars($_GET[$x]) : $_GET[$x];
		else if(isset($_POST[$x]) && !empty($_POST[$x])) return $protected ? htmlspecialchars($_POST[$x]) : $_POST[$x];
		else if(isset($_SESSION[$x]) && !empty($_SESSION[$x])) return $protected ? htmlspecialchars($_SESSION[$x]) : $_SESSION[$x];
		else return null;
	}
	function loop_url_data(array $array, $test = false){
		if($test){	
			var_dump($array);
			foreach($array as $v){
		 		var_dump($v);
		 		if(url_data($v) == null) var_dump('ERROR => ' . $v);
			}
		}else foreach($array as $v) if(url_data($v) == null) return false;
		return true;
	}
	function url_kc(){
		global $wamp_table, $wamp_lang;
		$url = array(
			'wamp' => (!empty(url_data('wamp')) ? url_data('wamp') : ''),
			'lang' => $wamp_table[$wamp_lang]['otherLangLink'],
			'go_admin' => (url_data('go_admin') != null ? url_data('go_admin') : null)
		);
		$html = '';
		$i = 1;
		foreach($url as $key => $value) if($value != null) $html .= ($i++ === 1 ? '?' : '&') . $key . '=' . $value;
		if(!empty($html)) return $html;
		else{
			header('loication:./?wamp=error&msg=nourlkc');
			exit();
		}
	}
	/**
	 * @function if_exist(string $type, string $elem)
	 * @param string $type search type
	 * @param string $elem filename with extension
	 * @return  boolean
	 */
	function if_exist($type, $elem, $test = false){
		$result = false;
		switch(strtolower($type)){
			case 'layout': $result = file_exists('./template/' . $elem); break;
			case 'url_data': $result = loop_url_data($elem, $test); break;
		}
		return $result;
	}
	/**
	 * @function status()
	 * @description test if active session ($_SESSION)
	 * @return boolean || null 
	 */
	function status(){
		if(session_status() === PHP_SESSION_ACTIVE) return true;
		elseif(session_status() === PHP_SESSION_DISABLED) return false;
		elseif(session_status() === PHP_SESSION_NONE) return null;
	}
	/**
	 * @function browser_no_cache()
	 * @description execute this if no-cache config
	 * @return void()
	 * @uses config.ini
	 */
  	function browser_no_cache(){
  		$cache = '';
  		if(preg_match("#MSIE [56789]#", (isset($HTTP_USER_AGENT)) ? $HTTP_USER_AGENT : getenv("HTTP_USER_AGENT"))) 
  			$Cache = ", pre-check=0, post-check=0, max-age=0";
  	  	header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
  	  	header('Cache-Control: no-cache, must-revalidate' . $cache);
  	  	header('Pragma: no-cache');
  	  	header('Expires: 0');
  	}
  	/**
  	 * @function current_file(string $x)
  	 * @param  string $x url current file
  	 * @return string  filename
  	 */
	function current_file($url){
    	return substr(preg_replace('#^(.+[\\\/])*([^\\\/]+)$#', '$2', $url), 0, -4);
	}
	/**
	 * @function count_parent_dir(string $x)
	 * @param  string $x url current file
	 * @return string  ../ of COUNT PARENT DIR OF THE CURRENT FILE
	 */
	function count_parent_dir($x){
		$stok = explode('/', $x);
		$count = 0;
		$dircount = '';
		for($i = count($stok) - 1; $i > 0; $i--){
			if($stok[$i] === RDN) break;
			else $count++;
		}
		for($i = 0; $i < $count; $i++) $dircount .= '../';
		return $dircount;
	}
	// CURRENT HIERARCHY
	/**
	 * @function current_hierarchy(string $x)
	 * @param string $x url current file
	 * @return string path current file for rootdir
	 */
	function current_hierarchy($x){
		$stok = explode('/', $x);
		$count = 0;
		$dir = '/';
		for($i = count($stok) - 1; $i > 0; $i--){
			if($stok[$i] === RDN){
				$count = $i;
				break;
			}
		}
		for($i = 1; $i <= $count; $i++) $dir .= $stok[$i] . '/';
		return $dir;
	}
	function current_pathdir($x){
		$stok = explode('/', $x);
		$html = '';
		foreach($stok as $t){
			if($t === RDN) continue;
			else $html .= $t . '/';
		}
		return $html;
	}
	// LIST OF PDO DRIVERS ON THE SERVER
	function PDODrivers(){
		$i = 1;
		foreach(PDO::getAvailableDrivers() as $driver) echo "Drivers" . $i++ . ": $driver <br>";
	}
	function get_ip(){
		if(isset($_SERVER['HTTP_CLIENT_IP'])) return $_SERVER['HTTP_CLIENT_IP'];
		elseif(isset($_SERVER['HTTP_X_FORWARDED_FOR'])) return $_SERVER['HTTP_X_FORWARDED_FOR'];
		else return (isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : null);
	}
	function is_connect(){
		return !empty(url_data('user', false)) ? true : false;
	}

	function array_KC_push(array $data){
        foreach($data as $key => $val) if(is_array($val)) foreach($val as $k => $v) $result[] = $v;
        return $result;
    }
    function array_KC_sort(array $array, $value = null, $order = true, $index_assoc = true, $fct = null){
    	if(!empty($value)){
    		if(count($array) !== count($array, 1)){

    		} else return (bool) $order ? sort($array) : rsort($array);	
    	} else return (bool) $order ? ksort($array) : krsort($array);
    }
    /**
     * sort($array [, $flag]) => Trie un tableau
     * rsort($array [, $flag]) => Trie un tableau en ordre inverse
     * 
     * asort($array [, $flag]) => Trie un tableau et conserve l'association des index
     * arsort($array [, $flag]) => Trie un tableau en ordre inverse et conserve l'association des index
     * 
     * ksort($array [, $flag]) => Trie un tableau suivant les clés
     * krsort($array [, $flag]) => Trie un tableau en sens inverse et suivant les clés
     * 
     * natcasesort($array) => Trie un tableau avec l'algorithme à "ordre naturel" insensible à la casse
     * natsort($array) => Trie un tableau avec l'algorithme à "ordre naturel"
     * 
     * usort($array, $callback) => Trie un tableau en utilisant une fonction de comparaison
     * uasort($array, $callback) => Trie un tableau en utilisant une fonction de rappel
     * uksort($array, $callback) => Trie un tableau par ses clés en utilisant une fonction de rappel
     * 
     * array_multisort($array [, $order [, $flag]], ... $rest) => Trie les tableaux multidimensionnels
     */
?>