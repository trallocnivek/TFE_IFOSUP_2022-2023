<?php
	public static function form(array $form, $data, $button = 'submit_input', $order = true){
			global $secu;
			$content = '';
			$attr = [
				'accept-charset' => isset($form['charset']) 	 && !empty($form['charset']) 	  ? $form['charset'] : 'utf-8', 
				'action' 		 => isset($form['action']) 		 && !empty($form['action']) 	  ? $form['action'] : $_SERVER['PHP_SELF'], 
				'autocomplete' 	 => isset($form['autocomplete']) && !empty($form['autocomplete']) ? $form['autocomplete'] : 'on', 
				'enctype' 		 => isset($form['enctype']) 	 && !empty($form['enctype']) 	  ? $form['enctype'] : 'application/x-www-form-urlencoded', 
				'method' 		 => isset($form['method']) 		 && !empty($form['method']) 	  ? $form['method'] : 'post',
				'target' 		 => isset($form['target']) 		 && !empty($form['target']) 	  ? $form['target'] : '_self'
			];
			if(isset($form['id']) 	 && !empty($form['id'])) 	$attr['id'] = $form['id'];
			if(isset($form['class']) && !empty($form['class'])) $attr['class'] = $form['class'];
			if(isset($form['name'])  && !empty($form['name'])) 	$attr['name'] = $form['name'];
			if(isset($form['rel']) 	 && !empty($form['rel'])) 	$attr['rel'] = $form['rel'];
			if(isset($form['novalidate']) && !empty($form['novalidate'])) array_push($attr, 'novalidate');
			
			if(isset($data['title'], $data['title']['content']) && !empty($data['title']['content'])) $content .= self::get_tag($data['title']);
			
			if(isset($data['required_infos'], $data['required_infos']['content']) && !empty($data['required_infos']['content']))
				$content .= self::get_tag($data['required_infos']);
			
			if(isset($data['hidden']) && !empty($data['hidden'])) 
				foreach($data['hidden'] as $k => $v) 
					$content .= self::get_tag(['tag' => 'input', 'attr' => ['type' => 'hidden', 'name' => $k, 'value' => $v]]);
			
			if($secu->is_token_active()) $content .= $secu->token();
			
			foreach($data['content'] as $key => $val){
				$block = '';
				if(is_numeric($key)) foreach($val as $k => $v) $block .= $k == 'img_captcha' ? self::get_tag($v) : self::label_input($k, $v, $order);
				else $block .= self::label_input($key, $val, $order);
				if(isset($data['data_block']) && !empty($data['data_block'])){
					$data['data_block']['content'] = $block;
					$content .= self::get_tag($data['data_block']);
				} else $content .= $block;
			}
			
			if(isset($data['data_block']) && !empty($data['data_block'])){
				$data['data_block']['attr']['class'] .= ' center';
				$data['data_block']['content'] = self::form_button($button);
				$content .= self::get_tag($data['data_block']);
			} else $content .= self::form_button($button);
			
			return self::get_double_tag_html(['tag' => 'form', 'attr' => $attr, 'content' => $content]);
		}
	public static function label_input0($name, $data, $order = true){
			$label = $input = $infos = '';
			// label attribute
			if(isset($data['label']['attr']) && !empty($data['label']['attr'])) $label_attr = $data['label']['attr'];
			// for attribute
			if(!isset($data['label']['attr']['for']) || empty($data['label']['attr']['for'])) $label_attr['for'] = $name;
			// required
			if(in_array('required', $data)){
				if(isset($data['label']['attr']['class']) && !empty($data['label']['attr']['class'])) $label_attr['class'] .= ' required';
				else $label_attr['class'] = 'required';
			}
			// label content
			if(isset($data['label']) && !is_array($data['label']) && !empty($data['label'])) $label_content = $data['label'];
			else if(isset($data['label']['content']) && is_array($data['label']) && !empty($data['label']['content']))$label_content=$data['label']['content'];
			else $label_content = 'no text';
			// html label
			if(isset($data['label']) && !empty($data['label'])) $label = self::get_tag(['tag' => 'label', 'attr' => $label_attr, 'content' => $label_content]);
			

			// input type
			if(!isset($data['input']['id'])) $data['input']['id'] = $name;
			else if(!isset($data['textarea']['id'])) $data['textarea']['id'] = $name;
			else if(!isset($data['select']['id'])) $data['select']['id'] = $name;
			// input name
			if(!isset($data['input']['name'])) $data['input']['name'] = $name;
			else if(!isset($data['textarea']['name'])) $data['textarea']['name'] = $name;
			else if(!isset($data['select']['name'])) $data['select']['name'] = $name;
			// autofocus
			if(isset($data['input']) && in_array('autofocus', $data)) $data['input'][] = 'autofocus';
			else if(isset($data['textarea']) && in_array('autofocus', $data)) $data['textarea'][] = 'autofocus';
			else if(isset($data['select']) && in_array('autofocus', $data)) $data['select'][] = 'autofocus';

			
			// html input
			if(array_key_exists('input', $data) && isset($data['input']['type']) && in_array($data['input']['type'],self::$html_attrs['assoc']['type']['val']))
				$input = self::get_tag(['tag' => 'input', 'attr' => $data['input']]);
			else if(array_key_exists('input', $data) && isset($data['input']['type']) && $data['input']['type'] == 'textarea'){
				if(isset($data['input']['type'])) unset($data['input']['type']);
				$input = self::get_tag(['tag' => 'textarea', 'attr' => $data['input']]);
			}else if(array_key_exists('textarea', $data)){
				if(isset($data['textarea']['type'])) unset($data['textarea']['type']);
				$input = self::get_tag(['tag' => 'textarea', 'attr' => $data['textarea']]);
			}
			// input infos
			if(isset($data['infos']) && !empty($data['infos'])) $infos = self::input_infos($data['infos']);
			return $order ? $label . $input . $infos : $input . $label . $infos;
		}
?>