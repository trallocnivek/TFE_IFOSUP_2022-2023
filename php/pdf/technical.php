<?php
	// http://www.fpdf.org/fr/doc/
	ini_set('default_charset', 'utf-8');
	session_start();
	
	require_once '../function/functions.php';
	require_once '../class/FPDF.class.php';
	require_once '../trait/db_utils.trait.php';
	
	spl_autoload_register(function($x){
		if(!class_exists($x)) require_once "../class/" . $x . ".class.php";
	});

	$config = new Config(false);
	
	$db_class = new DB;
	$db = $db_class->get('db');
	
	$site = new Site;
	$user = new Users;
	$secu = new Security;
	$valid = new Validity;
	
	// $infos_technical = $site->get('infos_page', 'doc_technical');

	$filename = 'technical_swingshift-2020.pdf';

	$pdf = new KC_PDF('P', 'mm', 'A4');

	$pdf->SetTitle('Swing Shift Big Band 2020', true);
	$pdf->SetAuthor('SwingShift Big Band', true);
	$pdf->SetCreator('technical', true);
	$pdf->SetSubject('technical', true);
	$pdf->SetMargins(10, 10);

// add_p($txt, $font_size, $position, $line = 10);

	// page 1
		$pdf->AddPage();
	
		// title
		$pdf->h(1, 'Swing Shift Big Band');
		$pdf->h(4, 'Technical Rider', 'C', 2);
		$pdf->h(4, 'www.swingshift.be', 'C', 2, 'blue', 'https://swingshift.be/');
	
		// contact
		$pdf->h(3, 'Contactpersonnen :', 'L');
		
		$pdf->add_p('President a.i. : Jean-Marie Ganhy : +32/475/95.78.35');
		$pdf->add_p('Dirigent : Ivo Hendrickx : +32/475/84.44.41');
		$pdf->add_p('Klanktechnieker : Geert De Deken : +32/497/43.17.65 / avinspire@gmail.com');
		
		// installation du son
		$pdf->h(3, 'Klankinstallatie :', 'L');
		$pdf->h(4, 'FOH', 'L', 10, 'black', '', null, 'multi', true);
		$pdf->add_p('Het gehuurde materiaal moet van goede kwalitijt zijn. Voor de keuze van merken vertrouwen we op de kennis en ervaring van de systeem-instalateur.');
		$pdf->add_p('Minimum Stereo PA, 95 dBA aan de mixerplaats.');
// test multicolumn
		$pdf->Ln(10);
		$pdf->MultiCell(15, 6, 'Multi kabel', 1, 'C', false, 0, false);
		$pdf->SetXY(25, 164.85);
		$pdf->MultiCell(15, 6, 'In mixer', 1, 'C', false, 0, false);
		$pdf->SetXY(40, 164.85);
		$pdf->MultiCell(45, 6, '          Instrument           ', 1, 'C', false, 0, false);
		$pdf->SetXY(85, 164.85);
		$pdf->MultiCell(75, 6, '                        Type micro                        ', 1, 'C', false, 0, false);
		$pdf->SetXY(160, 164.85);
		$pdf->MultiCell(30, 6, '                          ', 1, 'C', false, 0, false);

		// installation des lumieres
		// logistique
		// droits
		// liste des prix
		// plan

	/*$pdf->Text(75, 50, 'text');

	$pdf->SetFontSize(22);

	$pdf->Write(15, 'text', 'url_link'); // lien <a>

	$pdf->SetFontSize(12);

	$pdf->Ln(150); // passe ligne

	$pdf->SetLineWidth(5);

	$pdf->Line(5, 15, 205, 25); // passe ligne

	$pdf->MultiCell('210', '12', 'Swing Shift Big Band', 1, 'C', false);

	$pdf->Image('../../img/no_img.png', 5, 50, 50, 50, 'png', 'url_link');*/

	$pdf->Output($filename, 'I', true);

	// technical_rider_pdf/title1_0_c
?>	