<?php
	class KC_PDF extends FPDF{
		private $color = [
			'black' 	=> [0, 0 , 0],
			'blue' 		=> [0, 0 , 255],
			'white' 	=> [255, 255, 255]
		];
		private $hx = [
			1 => ['size' => 32		, 'weight' => 'bold'],
			2 => ['size' => 24		, 'weight' => 'bold'],
			3 => ['size' => 18.72	, 'weight' => 'bold'],
			4 => ['size' => 16		, 'weight' => 'bold'],
			5 => ['size' => 13.28	, 'weight' => 'bold'],
			6 => ['size' => 10.72	, 'weight' => 'bold']
		];
		private $length = [
			'A4' => [
				'P' => [
					'mesure' => 'mm',
					'width' => 210,
					'height' => 297
				],
				'L' => [
					'mesure' => 'mm',
					'width' => 297,
					'height' => 210
				]
			]
		];
		private $current = [
			'orientation' => 'P',
			'mesure' => 'mm',
			'size_type' => 'A4',
			'margin' => 1
		];
		private $px = [
			'mm' => 1 * 25.4 / 96,
			'cm' => 1 * 2.54 / 96,
			'pt' => 1 * 72 / 96,
			'in' => 1 / 96,
			'px' => 1
		];
		private $table_width = 0;
		private $table_head = [];
		private $table_row = [];
		public function __construct($orientation = 'P', $mesure = 'mm', $size_type = 'A4'){
			parent::__construct($orientation, $mesure, $size_type);
			$this->SetMargins(0, 0, 0);
			$this->SetFont('arial', '', 12);
			$this->AliasNbPages();
			$this->current['orientation'] = $orientation;
			$this->current['size_type'] = $size_type;
			$this->current['mesure'] = $mesure;
		}
		public function h(int $num, string $txt, 
			$position = 'C', $line = 15, $color = 'black', 
			$url = '', $font_size = null, $type = 'multi', $underline = false,
			$border = null, $font_family = null, $fill = false
		){
			// margin top
			$this->Ln($line);
			// set text color
			$this->SetTextColor($this->color[strtolower($color)][0], $this->color[strtolower($color)][1], $this->color[strtolower($color)][2]);
			// font size
			$font_size = !empty($font_size) ? $font_size : $this->hx[$num]['size'];
			$this->SetFontSize(!empty($font_size) ? $font_size : $this->hx[$num]['size']);
			// position
			$width = $this->length[$this->current['size_type']][$this->current['orientation']]['width'] - $this->lMargin - $this->rMargin;
			if(is_array($position)){
				$dx = $position;
			}else if($position == 'C'){
				$dx = ($width - $this->GetStringWidth($txt)) / 2;
			}
			// set text
			$txt = iconv('UTF-8', 'cp1252', $txt);
			$height = $font_size * $this->px[$this->current['mesure']];
			if($underline) $this->set_underline(true);
			switch(strtolower($type)){
				case 'txt': $this->Text($dx, $this->current['margin'], $txt);
				  break;
				case 'write': $this->Write($height, $txt, $url);
				  break;
				case 'multi': $this->MultiCell($width, $height, $txt, $border, $position, $fill);
				  break;
				default: $this->add_text($txt, $font_size, $position);
			}
			if($underline) $this->set_underline(false);
		}
		public function current_margin(int $x){
			$this->current['margin'] = $x;
		}
		public function add_text($txt, $font_size = 12, $position = 'L'){
			$width = $this->length[$this->current['size_type']][$this->current['orientation']]['width'] - $this->lMargin - $this->rMargin;
			$this->SetFontSize($font_size);
			if($this->GetStringWidth($txt) > $width){
				$length = $this->GetStringWidth($txt);
				$strlen = strlen($txt);
				$i = 1;
				do{
					$split = wordwrap($txt, $strlen - $i, '%{BREAK}%');
					$array = explode('%{BREAK}%', $split);
					$length = $this->GetStringWidth($array[0]);
					$i++;
				}while($length >= $width - 5);
				foreach($array as $k => $v){
					if($k != 0) $this->Ln($font_size / 2.5);
					$this->add_text($v, $font_size, $position);
				}
			}else $this->MultiCell($width, null, iconv('UTF-8', 'cp1252', $txt), null, $position, false);
		}
		public function add_text_underline($txt, $font_size = 12, $position = 'L'){
			$this->set_underline(true);
			$this->add_text($txt, $font_size, $position);
			$this->set_underline(false);
		}
		public function add_p($txt, $font_size = 12, $position = 'L', $line = 10){
			$this->Ln($line);
			$this->add_text($txt, $font_size, $position);
		}
		public function row_head(string $txt, $width = 30, $align = 'C'){
			$this->table_head[] = ['text' => $txt, 'width' => $width, 'align' => $align];
			$this->table_width += intval($width);
		}
		public function add_row($data = ''){
			$this->table_row[] = $data;
		}
		private function build_row($width, $height, $head_data, $row_data, $template, $frontground, $background){
			
		}
	}
?>