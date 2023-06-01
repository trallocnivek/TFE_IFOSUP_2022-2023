<?php
	// lire et ecrire dans un fichier en php !!!
	// -----------------------------------------
	$handle = fopen("users.txt", "r");
	while ($userInfo = fscanf($handle, "%s\t%s\t%s\n")) {
		list($name, $profession, $country) = $userInfo;
		// traitement donnees ...
		echo $name . ' ' . $profession . ' ' . $country . '<br>';
	}
	fclose($handle);
	// ouvrir un fichier
	// -----------------
	// r => lecture seule
	// r+ => lecture et ecriture
	// a => ecriture seule
	// a+ => lecture et ecriture mais si fichier n'existe pas -> creer automatiquement ! avoir un repertoire en CMOD 777
	// w => ecriture et cree fichier if not exist
	// w+ => lecture et ecriture et cree fichier if not exist
	// x = cree et ouvre le fichier en ecriture
	// x+ => cree et ouvre le fichier en lecture ecriture
	// c => ouvre le fichier en ecriture et s'il n'existe pas il est cree et s'il existe, il ne sera pas tronquer contrairement au mode w et l'appel de la fonction n'echoue pas contrairement au mode x
	// c+ => ouvre fichier en lecture ecriture
	// e => defini l'indicateur close-on-exec sur le descripteur ouvert
	// 
	// mode additionnel
	// b => pour ecrire en binaire conseiller a etre utiliser a outrance !
	// t => pour traduction de \n \r
	$monFichier = fopen('monFichier.txt', 'r+');

	// lire le fichier
	// ---------------
	$contents = fread($monFichier, filesize($monFichier)); // lit tout le fichier
	
	// modifier le fichier
	// -------------------
	// lire caractere par caractere
	$char = fgetc($monFichier);

	// lire ligne par ligne
	$ligne = fgets($monFichier, filesize($monFichier));

	// placement du curseur d'ecriture
	fseek($monFichier, 0); // debut du fichier

	// ajouter du contenut
	fwrite($monFichier, 'texte ...');
	fputs($monFichier, 'texte ...');

	// fermer un fichier
	// -----------------
	fclose($monFichier);


	// test
	
	$handle = fopen("users.txt", "r");
	while ($userInfo = fscanf($handle, "%s\t%s\t%s\n")) {
		list($name, $profession, $country) = $userInfo;
		// traitement donnees ...
	}
	fclose($handle);
	/**
	 * @class Repertory
	 * @static
	 * @description Directory management
	 * @property
	 * 	[static private]
	 * 	[static public]
	 * @method
	 * 	[magic private]
	 * 		- __construct()
	 * 		- __clone()
	 * 	[static public]
	 * 	[static private]
	 * 		- debug()
	 * @uses < none >
	 * @api DIRECTORY
	 * @author Collart Kevin
	 * @version 2021/01/31 TO 02H15
	 */
	class Repertory{
		// CONST
		// PROPERTY
		static private $path;
		static private $dir;
		static private $opendir = false;
		static private $file;
		static private $openfile = false;
		static private $current_type = 'file';
		// MAGIC METHOD
		private function __construct(){}
		private function __clone(){}
		// TRAIT
		// UTILS
		public static function init(string $type, string $path = './', $file = null){
			self::$path = $path;
			self::$dir = basename(dirname($path));
			if(!empty($file) && is_string($file) && is_file($path . $file)) self::$file = basename($file, pathinfo($path . $file, '.' . PATHINFO_EXTENSION));
		}
		public static function switch(){
			self::$current_type = self::$current_type === 'file' ? 'dir' : 'file';
		}
		public static function open($type, $mode = 'r'){
			opendir($path, $context);
			fopen(self::$file, $mode);
		}
		public static function close($type = 'file'){
			closedir($dir);
			fclose(self::${$type});
		}
		public static function rename($type, $name, $rename){}
		public static function exist(){}
		public static function chmod(){}
		// DIRECTORY
		public static function set_dir(){}
		public static function scan_dir(){
			scandir($dir, $order, $context);
		}
		public static function first_dir(){
			rewinddir($dir);
		}
		public static function current_dir(){
			getcwd();
		}
		public static function directory_class(){
			dir($dir, $context);
		}
		public static function root_dir($url){
			chroot($url);
		}
		public static function change_dir($name){
			chdir($name);
		}
		public static function create_dir($dir){
			if(!self::exist($dir)) mkdir(self::$path . $dir);
		}
		public static function read_dir(){
			readdir($dir);
		}
		public static function updata_dir(){}
		public static function delete_dir(){
			if(!self::exist($dir)) rmdir($dir);
		}
		// FILE
		public static function set_file(){}
		public static function upload_file(){}
		public static function download_file(){}
		public static function zip_file(){}
		public static function create_file(){}
		public static function read_file(){}
		public static function update_file(){}
		public static function delete_file(){}
		// DEBUG
		public static function debug(){}
	}
	$sheet = (new Repository)::init('dir', './admin/music_sheet/')::create_dir('0-CantTakeMyEyesOffYou');
?>