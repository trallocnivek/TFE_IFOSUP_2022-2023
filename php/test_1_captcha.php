<?php
	session_start();
	srand(); //initialisation du générateur mais plus obligatoire > PHP 4.2
	// Définition du content-type
	header("Content-type: image/png");
	$lettres = array('a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z');
	$code = $lettres[rand(0,25)].rand(100,1000000); //si on met que des chiffres, il faut mettre (string)
	$longueurcode = strlen($code);
	$_SESSION['code'] = $code;
	$largeur = $longueurcode * 25;
	$hauteur =  40;
	$image = imagecreatetruecolor($largeur, $hauteur);
	$couleurfond = imagecolorallocate(
		$image, rand(150,255),rand(150,255),rand(150,255)
	);
	imagefilledrectangle($image, 0, 0, $largeur, $hauteur, $couleurfond);
	$fontchiffre = array('1.ttf','2.ttf');
	$fontlettre = array('3.ttf');
	imagettftext(
		$image, rand(15,30), rand(-45,15), 10, 35, 
		imagecolorallocate(
			$image, rand(10,100) ,rand(10,100),rand(10,100)
		), 
		$fontlettre[0], $code[0]
	);
	for ($i = 1; $i < $longueurcode; $i++) {
    	$largeurx = 20 * $i + 30;
    	$hauteury = rand(25,40);
    	imagettftext(
    		$image, rand(27,32), rand(0,45), $largeurx, $hauteury,
    		imagecolorallocate(
    			$image, rand(10,100) ,rand(10,100), rand(10,100)
    		), 
    		$fontchiffre[rand(0,1)], $code[$i]
    	);
		/* imagestring(
			$image, rand(1,15), $largeurx, $hauteury, $codegenere[$i], 
			imagecolorallocate(
				$image, rand(100,255) ,rand(100,255),rand(100,255)
			) 
		);*/
	}
	imagepng($image);
	imagedestroy($image);
?>