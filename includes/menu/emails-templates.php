<?php	


/*
* @Author 		PickPlugins
* Copyright: 	2015 PickPlugins.com


*/

if ( ! defined('ABSPATH')) exit;  // if direct access 



class class_registration_control_emails_templates  {
	
	
    public function __construct(){
		
		echo $this->registration_control_templates_settings_display();
		
    }
	
	
	
	public function registration_control_templates_editor(){
		
			$registration_control_email_templates_data = get_option( 'registration_control_email_templates_data' );
			
			if(empty($registration_control_email_templates_data)){
				
				$class_registration_control_emails = new class_registration_control_emails();
				$templates_data = $class_registration_control_emails->email_templates_data();
				
				
				}
			else{

				
				$class_registration_control_emails = new class_registration_control_emails();
				$templates_data = $class_registration_control_emails->email_templates_data();
				
				$templates_data =array_merge($templates_data, $registration_control_email_templates_data);
				
				}
			
			//echo '<pre>'.var_export($templates_data).'</pre>';
		
			$html = '';
			
			//$templates_data = $this->registration_control_email_templates_data();
		
			$html.= '<div class="templates-editors ">';		
			foreach($templates_data as $key=>$templates){
				
				$html.= '<div class="items expandable template '.$key.'">';
				$html.= '<div class="header">'.$templates['name'].'</div>';
				$html.= '<input type="hidden" name="registration_control_email_templates_data['.$key.'][name]" value="'.$templates['name'].'" />';				
									
				$html.= '<div class="options">';
				
				$html.= '<label>'.__('Email Subject:','registration_control').'<br/>';	// .options				
				$html.= '<input type="text" name="registration_control_email_templates_data['.$key.'][subject]" value="'.$templates['subject'].'" />';	// .options	
				$html.= '</label>';					
						
						
				ob_start();
				wp_editor( $templates['html'], $key, $settings = array('textarea_name'=>'registration_control_email_templates_data['.$key.'][html]','media_buttons'=>false,'wpautop'=>true,'teeny'=>true,'editor_height'=>'400px', ) );				
				$editor_contents = ob_get_clean();
			
				$html.= '<br/><label>'.__('Email Body:','registration_control').'<br/>';	// .options				
				$html.= $editor_contents;
				$html.= '</label>';		

				$html.= '</div>';	// .options			
				$html.= '</div>'; //.items

				
				}
		
		$html.= '</div>';	
		
		return $html;
		}
		
		
	
	
	
	public function registration_control_templates_settings_display(){
		
		$html = '';
		
		$html.= '<div class="wrap classified-maker-admin emails-templates">';	
		$html.= '<div id="icon-tools" class="icon32"><br></div><h2>'.__(registration_control_plugin_name.' - Emails Templates', 'registration_control').'</h2>';	
		
		
		if(empty($_POST['registration_control_hidden']))
			{
				$registration_control_email_templates_data = get_option( 'registration_control_email_templates_data' );				

				
							
			}
		else{
			if($_POST['registration_control_hidden'] == 'Y'){
				
				
				$registration_control_email_templates_data = stripslashes_deep($_POST['registration_control_email_templates_data']);
				update_option('registration_control_email_templates_data', $registration_control_email_templates_data);				
		
			
				$html.= '<div class="updated"><p><strong>'.__('Changes Saved.', 'post_grid' ).'</strong></p></div>';	
				}
			}
		
		
		
		
		
		
		
		
		
		
		

		
		
		
		$html.= '<form  method="post" action="'.str_replace( '%7E', '~', $_SERVER['REQUEST_URI']).'">';		
		$html.= '<input type="hidden" name="registration_control_hidden" value="Y">';			

		
		
		$html.= $this->registration_control_templates_editor();
		
		$html.= '<p class="submit">
                    <input class="button button-primary" type="submit" name="Submit" value="'.__('Save Changes','registration_control' ).'" />
                </p>';
		$html.= '</form>';


		$class_registration_control_emails = new class_registration_control_emails();
		$parameters = $class_registration_control_emails->email_templates_parameters();

		$html.= '<div class="parameters"><ul>';			
		
		foreach($parameters as $key=>$parameter){
			
			$html.='<li><br /><b>'.$parameter['title'].'</b>';
			foreach($parameter['parameters'] as $parameter_name){
				$html.='<li>'.$parameter_name;			
				$html.='</li>';
				}
			
			$html.='</li>';
			
			}
			
		$html.= '</ul>';
			
		$html.= '</div>';			
		$html.= '</div>';				
			
		return $html;	
			
			
		
		}
	
	

	
	
}

new class_registration_control_emails_templates();


