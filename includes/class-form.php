<?php

/*
* @Author 		pickplugins
* Copyright: 	2015 pickplugins
*/

if ( ! defined('ABSPATH')) exit;  // if direct access 


class class_registration_control_form{
	
	public function __construct(){

		
		

		}

	public function author_settigns_form_input($field_data){
		
				$option_id = $field_data['key'];	
				$css_class = $field_data['css_class'];
				$placeholder = $field_data['placeholder'];
				$title = $field_data['title'];				
				$option_details = $field_data['option_details'];
				$input_type = $field_data['input_type'];				
				
				
				if(isset($field_data['input_args'])){
					$input_args = $field_data['input_args'];
					}
				
				if ( is_user_logged_in() ) 
					{
						$current_user_id = get_current_user_id();
					}
				
				//$input_values =  get_option( $option_id );	
				$input_values = get_the_author_meta( $option_id, $current_user_id );
				//var_dump($input_values);
	
				if(empty($input_values)){
					$input_values = $field_data['input_values'];
					}
	
	
	
				$html = '';
				
				$html.= '<div class="option-box">';
				
				if($input_type == 'hidden'){
					
					
					}
				else{
					$html.= '<div class="option-title">'.$title.'</div>';
					$html.= '<div class="option-details">'.$option_details.'</div>';
					}
								
				
				if($input_type == 'text'){
					$html.= '<input id="'.$option_id.'" type="text" placeholder="" name="'.$option_id.'" value="'.$input_values.'" /> ';					

					}
					
					
				elseif($input_type == 'text-multi'){
					
					//var_dump($input_values);
					
					$html.= '<div class="repatble">';
					if(!empty($input_values)){
						if(is_array($input_values)){
							
							foreach($input_values as $key=>$value){
								
								$html.= '<div class="single">';
								$html.= '<input type="text" placeholder="" name="'.$option_id.'['.$key.']" value="'.$input_values[$key].'" />';
								$html.= '<input class="remove-field" type="button" value="'.__('Remove',registration_control_textdomain).'" />';	
								
								$html.= '</div>';
								}
	
							
							}
						else{
							$html.= '<input type="text" placeholder="" name="'.$option_id.'[]" value="'.$input_values.'" /> ';
							$html.= '<input class="remove-field" type="button" value="'.__('Remove',registration_control_textdomain).'" />';
							}
						}
					else{
						$html.= '<input type="text" placeholder="" name="'.$option_id.'[]" value="'.$input_values.'" /> ';
						$html.= '<input class="remove-field" type="button" value="'.__('Remove',registration_control_textdomain).'" />';
						}

					//$html.= '<input type="text" placeholder="" name="'.$option_id.'[]" value="'.$input_values.'" /> ';
					
					$html.= '</div>';
					
					//$html.= '<br /><br />';						
					$html.= '<input class="add-field" option-id="'.$option_id.'" type="button" value="'.__('Add more',registration_control_textdomain).'" /> ';					
					
					
					
					}					
					
					
					
					
				elseif($input_type == 'hidden'){
					$html.= '<input id="'.$option_id.'" type="hidden" placeholder="" name="'.$option_id.'" value="'.$input_values.'" /> ';
					
					}					
					
					
				elseif($input_type == 'textarea'){
					$html.= '<textarea placeholder="" id="'.$option_id.'" name="'.$option_id.'" >'.$input_values.'</textarea> ';
					
					}
					
				elseif($input_type == 'wp_editor'){

					ob_start();
					wp_editor( stripslashes($input_values), $option_id, $settings = array('textarea_name'=>$option_id, 'media_buttons'=>false,'wpautop'=>true,'teeny'=>true,'editor_height'=>'200px', ) );				
					$editor_contents = ob_get_clean();
					
					$html.= $editor_contents;

					}
					
				elseif($input_type == 'select'){

					$html.= '<select name="'.$option_id.'" >';
					
					foreach($input_args as $input_args_key => $input_args_values){
						
						if($input_args_key == $input_values){
							$selected = 'selected';
							}
						else{
							$selected = '';
							}
						
						$html.= '<option '.$selected.' value="'.$input_args_key.'">'.$input_args_values.'</option>';

						}
					$html.= '</select>';
					
					}
					
				elseif($input_type  == 'radio'){
					
					foreach($input_args as $input_args_key=>$input_args_values){
						
						if($input_args_key == $input_values){
							$checked = 'checked';
							}
						else{
							$checked = '';
							}
							
						$html.= '<label><input class="'.$option_id.'" type="radio" '.$checked.' value="'.$input_args_key.'" name="'.$option_id.'"   >'.$input_args_values.'</label><br/>';
						
						}
					
					
					}
					
				elseif($input_type == 'checkbox'){

					//var_dump($input_values);

					foreach($input_args as $input_args_key => $input_args_values){

						//var_dump($input_values);
						if(in_array($input_args_key, $input_values)){
							$checked = 'checked';
							}
						else{
							$checked = '';
							}
						$html.= '<label><input class="'.$option_id.'" '.$checked.' value="'.$input_args_key.'" name="'.$option_id.'[]"  type="checkbox" >'.$input_args_values.'</label><br/>';
						
						
						}
					
					}	
					
				elseif($input_type == 'upload'){
					
					$html.= '<input id="'.$option_id.'" type="hidden" placeholder="" name="'.$option_id.'" value="'.$input_values.'" /> ';
					$html .= '<div id="file-upload-container">';

					$html.= '<div id="uploaded-image-container">';

					$cookie_name = 'registration_control_ads_thumbs';
					
					if(!empty($_COOKIE[$cookie_name])){
						
						$attach_ids = $_COOKIE[$cookie_name]; 
						
						$attach_ids = explode(',',$attach_ids);
						
						foreach($attach_ids as $attach_id){
							
							$attach_url = wp_get_attachment_url($attach_id);
							$attach_title = get_the_title($attach_id);	
							if(!empty($attach_id)){
								
							$html.= '<div  class="file"><div class="preview"><img src="'.$attach_url.'" title="'.$attach_title.'" /></div><div class="name">'.$attach_title.'</div><span attach_id="'.$attach_id.'" class="remove"><i class="fa fa-times"></i></span></div>';
								
								}

								
							}	

						}
			
					$html.= '</div>';	
					
					$html .= '<a title="'.__('filetype: (jpg, png, jpeg), max size: 200Mb',registration_control_textdomain).'" id="file-uploader" href="#">'.__('Upload',registration_control_textdomain).'</a>';
					
					$html .= '<div class="reset">'.__('Reset',registration_control_textdomain).'</div>';					
					
														
					$html.= '</div>';

					
					}
					
					
					
		
				$html.= '</div>';
		
		
			return $html;			
					
					

	}



	public function settings_form_input($field_data){
		
				$option_id = $field_data['key'];	
				$css_class = $field_data['css_class'];
				$placeholder = $field_data['placeholder'];
				$title = $field_data['title'];				
				$option_details = $field_data['option_details'];
				$input_type = $field_data['input_type'];				
				
				
				if(isset($field_data['input_args'])){
					$input_args = $field_data['input_args'];
					}
				
				$input_values =  get_option( $option_id );	
	
				//var_dump($input_values);
	
				if(empty($input_values)){
					$input_values = $field_data['input_values'];
					}
	
	
	
				$html = '';
				
				$html.= '<div class="option-box">';
				
				if($input_type == 'hidden'){
					
					
					}
				else{
					$html.= '<div class="option-title">'.$title.'</div>';
					$html.= '<div class="option-details">'.$option_details.'</div>';
					}
								
				
				if($input_type == 'text'){
					$html.= '<input id="'.$option_id.'" type="text" placeholder="" name="'.$option_id.'" value="'.$input_values.'" /> ';					

					}
					
					
					
					
					
				elseif($input_type == 'text-multi'){
					
					//var_dump($input_values);
					
					$html.= '<div class="repatble">';
					if(!empty($input_values)){
						if(is_array($input_values)){
							
							foreach($input_values as $key=>$value){
								
								$html.= '<div class="single">';
								$html.= '<input type="text" placeholder="" name="'.$option_id.'['.$key.']" value="'.$input_values[$key].'" />';
								$html.= '<input class="remove-field button" type="button" value="'.__('Remove',registration_control_textdomain).'" />';	
								
								$html.= '</div>';
								}
	
							
							}
						else{
							$html.= '<input type="text" placeholder="" name="'.$option_id.'[]" value="'.$input_values.'" /> ';
							$html.= '<input class="remove-field button" type="button" value="'.__('Remove',registration_control_textdomain).'" />';
							}
						}
					else{
						$html.= '<input type="text" placeholder="" name="'.$option_id.'[]" value="'.$input_values.'" /> ';
						$html.= '<input class="remove-field button" type="button" value="'.__('Remove',registration_control_textdomain).'" />';
						}

					//$html.= '<input type="text" placeholder="" name="'.$option_id.'[]" value="'.$input_values.'" /> ';
					
					$html.= '</div>';
					
					//$html.= '<br /><br />';						
					$html.= '<input class="add-field button" option-id="'.$option_id.'" type="button" value="'.__('Add more',registration_control_textdomain).'" /> ';					
					
					
					
					}
					
					
					
					
					
					
				elseif($input_type == 'multi-text'){
					
					var_dump($input_values);
					
					
					if(!empty($input_values)){
						
					foreach($input_values as $key=>$value){
						
						$html.= '<input type="text" placeholder="" name="'.$option_id.'['.$key.']" value="'.$input_values[$key].'" /> ';
						}
						
						}
					else{
						$html.= '<input type="text" placeholder="" name="'.$option_id.'[]" value="'.$input_values[0].'" /> ';
						}

					//$html.= '<input type="text" placeholder="" name="'.$option_id.'[]" value="'.$input_values.'" /> ';
					
					
					//$html.= '<br /><br />';						
					$html.= '<input class="add-field" option-id="'.$option_id.'" type="button" value="'.__('Add more',registration_control_textdomain).'" /> ';					
					
					
					}					
					
					
					
					
				elseif($input_type == 'hidden'){
					$html.= '<input id="'.$option_id.'" type="hidden" placeholder="" name="'.$option_id.'" value="'.$input_values.'" /> ';
					
					}					
					
					
				elseif($input_type == 'textarea'){
					$html.= '<textarea placeholder="" id="'.$option_id.'" name="'.$option_id.'" >'.$input_values.'</textarea> ';
					
					}
					
				elseif($input_type == 'wp_editor'){

					ob_start();
					wp_editor( stripslashes($input_values), $option_id, $settings = array('textarea_name'=>$option_id, 'media_buttons'=>false,'wpautop'=>true,'teeny'=>true,'editor_height'=>'200px', ) );				
					$editor_contents = ob_get_clean();
					
					$html.= $editor_contents;

					}
					
				elseif($input_type == 'select'){

					$html.= '<select name="'.$option_id.'" >';
					
					foreach($input_args as $input_args_key => $input_args_values){
						
						if($input_args_key == $input_values){
							$selected = 'selected';
							}
						else{
							$selected = '';
							}
						
						$html.= '<option '.$selected.' value="'.$input_args_key.'">'.$input_args_values.'</option>';

						}
					$html.= '</select>';
					
					}
					
				elseif($input_type  == 'radio'){
					
					foreach($input_args as $input_args_key=>$input_args_values){
						
						if($input_args_key == $input_values){
							$checked = 'checked';
							}
						else{
							$checked = '';
							}
							
						$html.= '<label><input class="'.$option_id.'" type="radio" '.$checked.' value="'.$input_args_key.'" name="'.$option_id.'"   >'.$input_args_values.'</label><br/>';
						
						}
					
					
					}
					
				elseif($input_type == 'checkbox'){

					//var_dump($input_values);

					foreach($input_args as $input_args_key => $input_args_values){

						//var_dump($input_values);
						if(in_array($input_args_key, $input_values)){
							$checked = 'checked';
							}
						else{
							$checked = '';
							}
						$html.= '<label><input class="'.$option_id.'" '.$checked.' value="'.$input_args_key.'" name="'.$option_id.'[]"  type="checkbox" >'.$input_args_values.'</label><br/>';
						
						
						}
					
					}	
					
				elseif($input_type == 'upload'){
					
					
					//$html_box.= '<br /><br /><div style="overflow:hidden;max-height:150px;max-width:150px;" class="logo-preview"></div>';
					
					//$html .= '<div class="file-upload">';
					//$html.= '<input  type="text" id="file_'.$meta_key.'" name="'.$meta_key.'" value="'.$input_values.'" />';

					//$html .= '<span class="loading">'.__('loading',registration_control_textdomain).'</span>';	
					//$html .= '<a title="'.__('filetype: (jpg, png, jpeg), max size: 2Mb',registration_control_textdomain).'" id="file-uploader" href="#">'.__('Upload',registration_control_textdomain).'</a>';			
					//$html.= '</div>';
					$html.= '<input id="'.$option_id.'" type="hidden" placeholder="" name="'.$option_id.'" value="'.$input_values.'" /> ';
					$html .= '<div id="file-upload-container">';
					//$html.= '<input  type="text" id="file_'.$option_key.'" name="'.$option_key.'" value="'.$input_values.'" />';
					//$html_box.= '<br /><br /><div style="overflow:hidden;max-height:150px;max-width:150px;" class="logo-preview"></div>';

					$html.= '<div id="uploaded-image-container">';

					$cookie_name = 'registration_control_ads_thumbs';
					
					if(!empty($_COOKIE[$cookie_name])){
						
						$attach_ids = $_COOKIE[$cookie_name]; 
						
						$attach_ids = explode(',',$attach_ids);
						
						foreach($attach_ids as $attach_id){
							
							$attach_url = wp_get_attachment_url($attach_id);
							$attach_title = get_the_title($attach_id);	
							if(!empty($attach_id)){
								
							$html.= '<div  class="file"><div class="preview"><img src="'.$attach_url.'" title="'.$attach_title.'" /></div><div class="name">'.$attach_title.'</div><span attach_id="'.$attach_id.'" class="remove"><i class="fa fa-times"></i></span></div>';
								
								}

								
							}	
						
						
						
						}
									
										
										
					$html.= '</div>';	
					
					$html .= '<a title="'.__('filetype: (jpg, png, jpeg), max size: 200Mb',registration_control_textdomain).'" id="file-uploader" href="#">'.__('Upload',registration_control_textdomain).'</a>';
					
					$html .= '<div class="reset">'.__('Reset',registration_control_textdomain).'</div>';					
					
														
					$html.= '</div>';
					
					
					
					
					
					
					
					
					}
					
					
					
		
				$html.= '</div>';
		
		
			return $html;			
					
					

	}








	public function form_input($field_data){
		
				$registration_control_reCAPTCHA_enable = get_option('registration_control_reCAPTCHA_enable');
				$registration_control_reCAPTCHA_site_key = get_option('registration_control_reCAPTCHA_site_key');
		
				$meta_key = $field_data['meta_key'];	
				$css_class = $field_data['css_class'];
				$placeholder = $field_data['placeholder'];
				$title = $field_data['title'];				
				$option_details = $field_data['option_details'];
				$input_type = $field_data['input_type'];				
				$input_values = $field_data['input_values'];
				
				if(isset($field_data['input_args'])){
					$input_args = $field_data['input_args'];
					}								
				
							
				//var_dump($input_values);
				
				$html = '';
				
				$html.= '<div class="option">';
				
				if($input_type == 'hidden' || ($meta_key=='registration_control_ads_recaptcha' && $registration_control_reCAPTCHA_enable=='no' )){
					
					
					}
				
				else{
					$html.= '<div class="option-title">'.$title.'</div>';
					$html.= '<div class="option-details">'.$option_details.'</div>';
					}
								
				
				if($input_type == 'text'){
				$html.= '<input id="'.$meta_key.'" type="text" placeholder="" name="'.$meta_key.'" value="'.$input_values.'" /> ';					

					}
					
					
					
					
					
				elseif($input_type == 'hidden'){
					$html.= '<input id="'.$meta_key.'" type="hidden" placeholder="" name="'.$meta_key.'" value="'.$input_values.'" /> ';
					
					}					
					
					
				elseif($input_type == 'textarea'){
					$html.= '<textarea placeholder="" id="'.$meta_key.'" name="'.$meta_key.'" >'.$input_values.'</textarea> ';
					
					}
					
				elseif($input_type == 'wp_editor'){

					ob_start();
					wp_editor( stripslashes($input_values), $meta_key, $settings = array('textarea_name'=>$meta_key, 'media_buttons'=>false,'wpautop'=>true,'teeny'=>true,'editor_height'=>'200px', ) );				
					$editor_contents = ob_get_clean();
					
					$html.= $editor_contents;

					}
					
				elseif($input_type == 'select'){

					$html.= '<select name="'.$meta_key.'" >';
					
					foreach($input_args as $input_args_key => $input_args_values){
						
						if($input_args_key == $input_values){
							$selected = 'selected';
							}
						else{
							$selected = '';
							}
						
						$html.= '<option '.$selected.' value="'.$input_args_key.'">'.$input_args_values.'</option>';

						}
					$html.= '</select>';
					
					}
					
				elseif($input_type  == 'radio'){
					
					foreach($input_args as $input_args_key=>$input_args_values){
						
						if($input_args_key == $input_values){
							$checked = 'checked';
							}
						else{
							$checked = '';
							}
							
						$html.= '<label><input class="'.$meta_key.'" type="radio" '.$checked.' value="'.$input_args_key.'" name="'.$meta_key.'"   >'.$input_args_values.'</label><br/>';
						
						}
					
					
					}
					
				elseif($input_type == 'checkbox'){

					//var_dump($input_values);

					foreach($input_args as $input_args_key => $input_args_values){

						//var_dump($input_values);
						if(in_array($input_args_key, $input_values)){
							$checked = 'checked';
							}
						else{
							$checked = '';
							}
						$html.= '<label><input class="'.$meta_key.'" '.$checked.' value="'.$input_args_key.'" name="'.$meta_key.'[]"  type="checkbox" >'.$input_args_values.'</label><br/>';
						
						
						}
					
					}	
					
				elseif($input_type == 'ajax_upload_single'){
					
					

					$html.= '<input id="'.$meta_key.'" type="hidden" placeholder="" name="'.$meta_key.'" value="'.$input_values.'" /> ';
					$html .= '<div id="file-upload-container">';

					$html.= '<div id="uploaded-image-container">';

					if(!empty($input_values)){
						
						$attach_ids = explode(',',$input_values);
						
						}
					else{
						$attach_ids = array();
						}
						
						foreach($attach_ids as $attach_id){
							
							$attach_url = wp_get_attachment_url($attach_id);
							$attach_title = get_the_title($attach_id);	
							if(!empty($attach_id) && !empty($attach_url)){
								
							$html.= '<div attach_id="'.$attach_id.'" class="file"><div class="preview"><img src="'.$attach_url.'" title="'.$attach_title.'" /></div><div class="name">'.$attach_title.'</div><span attach_id="'.$attach_id.'" class="remove"><i class="fa fa-times"></i></span><span class="move"><i class="fa fa-sort"></i></span></div>';
								
								}

								
							}	

									
										
										
					$html.= '</div>';	
					
					$html .= '<a title="'.__('filetype: (jpg, png, jpeg), max size: 200Mb',registration_control_textdomain).'" id="file-uploader" href="#">'.__('Upload',registration_control_textdomain).'</a>';
					
					$html .= '<div class="reset">'.__('Reset',registration_control_textdomain).'</div>';					
					
														
					$html.= '</div>';
					
					
					
					
					
					
					
					
					}
					
				elseif($input_type == 'file-single'){
					
					
					$html.= '<input type="file" multiple="multiple" name="'.$meta_key.'[]" /> ';				
					}
					
				elseif($input_type == 'file-multi'){
					
					
					$html.= '<div class="file-list sortable">';
					$html.= '<div><input type="file" multiple="multiple" name="'.$meta_key.'[]" /></div>';					
					$html.= '</div>';					
					$html.= '<input type="button" key="'.$meta_key.'" class="add-more-file" placeholder=""  value="Add more" /> ';					
							
					}					
					
					
					
				elseif($input_type == 'recaptcha'){
					

					
					
					if($registration_control_reCAPTCHA_enable=='yes'){
						
						$html.= '<script src="https://www.google.com/recaptcha/api.js"></script>';
						$html.= '<div class="g-recaptcha" data-sitekey="'.$registration_control_reCAPTCHA_site_key.'"></div>';
						$html.= '<input id="'.$meta_key.'" type="hidden" placeholder="" name="'.$meta_key.'" value="'.$input_values.'" /> ';
						
						}
					

					
					}
					
		
				$html.= '</div>';
		
		
			return $html;
		
		}
		
	
	}
	
	//new class_registration_control_functions();