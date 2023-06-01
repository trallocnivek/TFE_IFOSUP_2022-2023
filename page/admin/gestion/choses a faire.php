<?php
	// ZONE ADMIN
	
	// @ GESTION
	
	// @ # users
	// @ # & pseudo
	// @ # & email
	// @ # & firstname et lastname
	// @ # & password
	// @ # & picture (url)
	// @ # & birthday
	// @ # & address (type rue, rue, numero, boite, code postal, ville, pays)
	// @ # & group
	// @ # & account type
	// @ # & lang
	// @ # & status
	// @ # & authorisation
	// @ # & ip (anti brute force) (ip, banned, status, count_fail)
	// @ # & tel et gsm
	// @ # & conditions (bool)
	// @ # & active (bool)
	// @ # & description
	
	// @ # diary
	// @ # & date
	// @ # & heure
	// @ # & titre
	// @ # & prix
	// @ # & poster
	// @ # & gallery
	// @ # & event planner
	// @ # & group
	// @ # & address & google map
	// @ # & status (closed, annuler, sold out)
	// @ # & email, tel & gsm
	// @ # & site (reservation, organisateur, groupe)
	// @ # & description
	
	// @ # newsletter
	// @ # & email
	// @ # & actif
	// @ # & diary (bool)
	// @ # & gallery (bool)
	// @ # & demo (bool)
	// @ # & conditions
	
	// @ # email
	// @ # & email
	
	// @ # address
	// @ # & type rue
	// @ # & rue
	// @ # & numero
	// @ # & boite
	// @ # & ville
	// @ # & code postal
	// @ # & pays
	// @ # & continent
	// @ # & district
	// @ # & ...
	
	// @ # partitions
	// @ # & numero
	// @ # & titre
	// @ # & author
	// @ # & arranger
	// @ # & instrument
	// @ # & tone
	// @ # & style music
	// @ # & group
	// @ # & date
	// @ # & url doc
	// @ # & num page
	// @ # & nbr pages
	// @ # & description
	
	// @ # gallery
	// @ # & name
	// @ # & img presentation
	// @ # & dir
	// @ # & date
	// @ # & diary
	// @ # & address
	// @ # & description
	
	// @ # demos
	// @ # & dir
	// @ # & name
	// @ # & type (video, son)
	// @ # & url
	// @ # & actif
	// @ # & description
	// @ # & img presentation (null)
	
	// @ # membre du group (fiche)
	// @ # & first/last name
	// @ # & email
	// @ # & tel & gsm
	// @ # & picture presentation
	// @ # & fonction
	// @ # & sexe
	// @ # & description
	// @ # & instrument
	
	// @ # pages du site
	// @ # & content (page, elem, html(id, attr, class), trad, url, authorization, param, order, active, description)
	// @ # & page name
	// @ # & authorization
	// @ # & menu ou il apparait
	// @ # & active
	// @ # & url
	
	// @ # instruments
	// @ # & name
	// @ # & ton
	// @ # & type
	// @ # & description
	// @ # & img
	// @ # & num
	// @ # & pays
	
	// @ # ip (anti brute force)
	// @ # & ip
	// @ # & banned
	// @ # & status
	// @ # & user
	// @ # & fails (count & date)
	
	// @ # lang et trad
	// @ # & fr, nl, en, de
	// @ # & description
	// @ # & name
	// @ # & abvr
	// @ # & pays
	
	// @ # url
	// @ # & url
	// @ # & name
	// @ # & description
	// @ # & authorization
	// @ # & target
	
	// @ # divers

function get_dir_size($dir_name){
        $dir_size =0;
           if (is_dir($dir_name)) {
               if ($dh = opendir($dir_name)) {
                  while (($file = readdir($dh)) !== false) {
                        if($file !="." && $file != ".."){
                              if(is_file($dir_name."/".$file)){
                                   $dir_size += filesize($dir_name."/".$file);
                             }
                             if(is_dir($dir_name."/".$file)){
                                $dir_size +=  get_dir_size($dir_name."/".$file);
                              }
                           }
                     }
             }
       }
closedir($dh);
return $dir_size;
}

$dir_name = $_SERVER['DOCUMENT_ROOT'];
$total_size= round((get_dir_size($dir_name) / 1048576),2) ;
echo "Directory $dir_name size : $total_size MB";

var_dump($_SERVER['DOCUMENT_ROOT']);

?>