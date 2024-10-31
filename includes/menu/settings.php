<?php	


/*
* @Author 		PickPlugins
* Copyright: 	2015 PickPlugins.com
*/

if ( ! defined('ABSPATH')) exit;  // if direct access 


	
	//var_dump($meta_fields);


	if(empty($_POST['registration_control_hidden']))
		{

			$registration_control_options = get_option( 'registration_control_options' );

		}
	else
		{	
			if($_POST['registration_control_hidden'] == 'Y') {
				//Form data sent
	

				

				//$registration_control_options = stripslashes_deep($_POST['registration_control_options']);
				//update_option('registration_control_options', $registration_control_options);
	
	
			$class_registration_control_functions = new class_registration_control_functions();
			$settings_form_options = $class_registration_control_functions->setings_options();
	
			
			foreach($settings_form_options as $key=>$option_set){
				
				foreach($option_set['options'] as $key=>$option){
					
					
					if(!empty($_POST[$key])){
						${$key} = stripslashes_deep($_POST[$key]);
						update_option($key, ${$key});
						}
					else{
						${$key} = array();
						update_option($key, ${$key});
						
						}


					//var_dump($option_key);
					
					}
				}
	
	
	
	
	
	
	
	
				//var_dump($_POST);
				?>
				<div class="updated"><p><strong><?php _e('Changes Saved.', registration_control_textdomain ); ?></strong></p></div>
		
				<?php
				} 
		}
	

	?>





<div class="wrap registration-control-admin front-form settings">

	<div id="icon-tools" class="icon32"><br></div>
    
	<h2><?php _e(sprintf('%s - Settings',registration_control_plugin_name), registration_control_textdomain); ?></h2>
    
		<form  method="post" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>">
            <input type="hidden" name="registration_control_hidden" value="Y">
            <?php settings_fields( 'registration_control_plugin_options' );
                    do_settings_sections( 'registration_control_plugin_options' );
    
                

			$class_registration_control_form = new class_registration_control_form();
			
			
			
			
			$class_registration_control_functions = new class_registration_control_functions();
			$settings_form_input = $class_registration_control_functions->setings_options();
			
			echo '<ul class="tab-nav">';
			
			$i= 1;
			foreach($settings_form_input as $key=>$option_set){
				//var_dump($option_set['options']);
				
				if($i==1){
					$active = 'active';
					}
				else{
					$active = '';
					}	
				
				echo '<li class="nav'.$i.' '.$active .'" nav="'.$i.'">'.$option_set['title'].'</li>';
				
				$i++;
				
			}
			
			echo '</ul>';
			
			
			
			echo '<ul class="box">';
			
			$i = 1;
			foreach($settings_form_input as $key=>$option_set){
				//var_dump($option_set['options']);
				
				
				if($i==1){
					$active = 'active';
					}
				else{
					$active = '';
					}
				
				if($i==1){
					$style = 'display: block;';
					}
				else{
					$style = 'display: none;';
					}				
				
				
				echo '<li class="tab-box box'.$i.' '.$active .'" style="'.$style.'">';
				foreach($option_set['options'] as $key=>$option ){
					
					//var_dump($option);
					echo $class_registration_control_form->settings_form_input($option);
					
					}
				
				
				echo '</li>';
				
				
				//echo $class_registration_control_form->settings_form_input($meta_fields[$key]);
				$i++;
				}
			
			echo '</ul>';
			
			?>



			<p class="submit">
				<input class="button button-primary" type="submit" name="Submit" value="<?php _e('Save Changes',registration_control_textdomain ); ?>" />
			</p>
		</form>


</div>
