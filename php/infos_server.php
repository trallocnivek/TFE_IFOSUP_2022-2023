<?php
	function is_ssl_exists($url){
        $original_parse = parse_url($url, PHP_URL_HOST);
        $get = stream_context_create(array("ssl" => array("capture_peer_cert" => TRUE)));
        $read = stream_socket_client("ssl://" . $original_parse . ":443", $errno, $errstr, 30, STREAM_CLIENT_CONNECT, $get);
        $cert = stream_context_get_params($read);
        $certinfo = openssl_x509_parse($cert['options']['ssl']['peer_certificate']);
		
		echo "<p>----------------------------------------------------------------</p>";
        foreach($certinfo as $k => $v){
			echo '<p>[' . $k . '] => ' . $v . '</p>';
		}
		echo "<p>----------------------------------------------------------------</p>";

        if(isset($certinfo) && !empty($certinfo)){
            if(isset($certinfo['name']) && !empty($certinfo['name']) && $certinfo['issuer'] && !empty($certinfo['issuer'])){
                return true;
            }
            return false;
        }
        return false;
    }
	is_ssl_exists('https://www.swingshift.be');
	foreach($_SERVER as $k => $v){
		echo '<p>[' . $k . '] => ' . $v . '</p>';
	}
?>
<form action="<?=$_SERVER['PHP_SELF'];?>" method="post">
	<input type="hidden" name="page" value="db_infos_server">
	<input type="hidden" name="action" value="create">
	<input type="hidden" name="token" value="token">
	<label for="db_elem_title">db_elem_title</label>
	<input type="text" name="db_elem_title" value="db_elem_title">
	<label for="auth_id">auth_id</label>
	<input type="text" name="auth_id" value="2">
	<label for="url">url</label>
	<input type="url" name="url" value="https://www.swingshift.be/?page=test">
	<label for="active">active</label>
	<input type="checkbox" name="active" checked>
	<input type="submit" value="send">
</form>