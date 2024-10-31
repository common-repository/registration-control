<?php
/*
* @Author 		pickplugins
* Copyright: 	pickplugins.com
*/

if ( ! defined('ABSPATH')) exit;  // if direct access 
	
	

add_action( 'register_form', 'registration_control_register_form' );
function registration_control_register_form() {

	$registration_control_reCAPTCHA_site_key = get_option('registration_control_reCAPTCHA_site_key');
	$registration_control_reCAPTCHA_enable = get_option('registration_control_reCAPTCHA_enable');	
	
	if($registration_control_reCAPTCHA_enable=='yes'){
		
    $g_recaptcha = ( ! empty( $_POST['g-recaptcha-response'] ) ) ? trim( $_POST['g-recaptcha-response'] ) : '';
        
        ?>
        <p>
            <label for="g_recaptcha"><?php _e( 'reCAPTCHA', registration_control_textdomain ) ?><br />
                
             	<script src="https://www.google.com/recaptcha/api.js"></script>
				<div class="g-recaptcha" data-sitekey="<?php echo $registration_control_reCAPTCHA_site_key; ?>"></div>
  
        </p>
        <?php
		
		}
	

    }

    //2. Add validation. In this case, we make sure g_recaptcha is required.
   add_filter( 'registration_errors', 'registration_control_registration_errors', 10, 3 );
    function registration_control_registration_errors( $errors, $sanitized_user_login, $user_email ) {
        
		//var_dump($_POST);
		
		$registration_control_reCAPTCHA_enable = get_option('registration_control_reCAPTCHA_enable');
		
		if($registration_control_reCAPTCHA_enable=='yes'){
				if ( empty( $_POST['g-recaptcha-response'] ) || ! empty( $_POST['g-recaptcha-response'] ) && trim( $_POST['g-recaptcha-response'] ) == '' ) {
					$errors->add( 'g_recaptcha_error', __( '<strong>ERROR</strong>: reCAPTCHA missing.', registration_control_textdomain ) );
				
				}
				return $errors;
				
			}
		else{
				return $errors;
			}
		


       
    }


	
	
	
	
add_action('edit_user_profile_update', 'registration_control_save_lock_status_options');
	
	
    function registration_control_save_lock_status_options($user_id){
		
        if(isset($_POST['account_status'])){
            if($_POST['account_status'] == 'locked') {
                update_user_meta($user_id, 'account_status', 'locked');
            } else {
                update_user_meta($user_id, 'account_status', 'unlocked');
            }
        }
    }
	
	
	
	
	
	
		
add_action('edit_user_profile', 'registration_control_output_lock_status_options');
	
    function registration_control_output_lock_status_options($user) {
		$locking_data =get_user_meta($user->data->ID, 'account_status', TRUE);
		$html = '';
		
		//var_dump($locking_data);
		
		$html.= '<h3>Lock User Account</h3>
<table class="form-table">
    <tr>
        <th><label for="account_status">Account status</label></th>
        <td>
            <select name="account_status" id="account_status">';
			
		if($locking_data=='unlocked'){
			
			$html.=   '<option value="unlocked" selected >Unlocked</option>';
		}
		else{
			$html.=   '<option value="unlocked" >Unlocked</option>';
			}
		
		
		if($locking_data=='locked'){
			$html.=  '<option value="locked" selected>Locked</option>';
			}
		else{
			$html.=  '<option value="locked">Locked</option>';
			
			}
			
              
                $html.=  '</select>
        </td>
    </tr>
</table>';		
		
		echo $html;
		}
	
	
	
	
	
	
	

add_filter('authenticate', 'registration_control_user_authentication', 9999);


    function registration_control_user_authentication($user) {
        $status = get_class($user);		
		
        if($status == 'WP_User') {
            $locking_data = fetch_lock_status($user->data->ID);

            if($locking_data=='locked') {
                $message = Apply_Filters('account_lock_message', SPrintF('<strong>%s</strong> %s', 'Error:', 'Your account has been locked. '), $user);
                return new \WP_Error('authentication_failed', $message);
            } else {
                return $user;
            }
        }
        return $user;
    }

	function fetch_lock_status($user_id) {
		
        return  get_user_meta($user_id, 'account_status', TRUE);
		
    }







add_action( 'user_register', 'registration_control_registration_action_block_domain', 100, 1 );

function registration_control_registration_action_block_domain( $user_id ) {

		
		$registration_control_enable_domain_block = get_option('registration_control_enable_domain_block');
		
		if($registration_control_enable_domain_block =='yes'){
			
			
		
			$class_registration_control_emails = new class_registration_control_emails();
					
			
			$registration_control_action_on_registration = get_option('registration_control_action_on_registration');
			$registration_control_blocked_domain = get_option('registration_control_blocked_domain');		
			$domain_blocked = $registration_control_blocked_domain;
	
			$user_data = get_user_by( 'id', $user_id );
			$user_login = $user_data->user_login;		
			$user_email = $user_data->user_email;				
	
			$email_parameter_vars = array(
				'{site_name}'=> get_bloginfo('name'),
				'{site_description}' => get_bloginfo('description'),
				'{site_url}' => get_bloginfo('url'),						
				'{site_logo_url}' => get_option('ads_bm_logo_url'),
			  
				'{user_name}' => $user_login,						  
				'{user_avatar}' => get_avatar( $user_email, 60 ),
				'{user_email}' => $user_email,
																						
	
			);
						
			$email_parameter_vars = apply_filters('registration_control_email_parameter_vars',$email_parameter_vars);
			
			$admin_email = get_option('admin_email');					
			$registration_control_email_templates_data = get_option( 'registration_control_email_templates_data' );
	
			$class_registration_control_emails = new class_registration_control_emails();
			$templates_data = $class_registration_control_emails->email_templates_data();
	
			if(empty($registration_control_email_templates_data)){
				//$templates_data = $class_registration_control_emails->registration_control_email_templates_data();
				$registration_control_email_templates_data = $templates_data;
				
				}
			else{
				//$templates_data = $class_registration_control_emails->registration_control_email_templates_data();
				$registration_control_email_templates_data =array_merge($templates_data, $registration_control_email_templates_data);
				
				}	
	
			$account_blocked_email_body = strtr($registration_control_email_templates_data['account_blocked']['html'], $email_parameter_vars);
			$account_blocked_email_subject =strtr($registration_control_email_templates_data['account_blocked']['subject'], $email_parameter_vars);
	
			$account_deleted_email_body = strtr($registration_control_email_templates_data['account_deleted']['html'], $email_parameter_vars);
			$account_deleted_email_subject =strtr($registration_control_email_templates_data['account_deleted']['subject'], $email_parameter_vars);
	
			$attachments = '';
			$to_email = $user_email;
			
	
			
			$user_email_array = explode('@',$user_email);
			
			$user_email_id = $user_email_array[0];
			$user_email_domain = $user_email_array[1];
			
			if(in_array($user_email_domain,$domain_blocked)){
				
				if($registration_control_action_on_registration=='delete'){
					
					require_once(ABSPATH . "wp-admin" . '/includes/user.php');
					wp_delete_user($user_id);
					
					$class_registration_control_emails->send_email($to_email, $account_deleted_email_subject, $account_deleted_email_body, $attachments);
					
					$action = 'deleted';
					}
				elseif($registration_control_action_on_registration=='block'){
					
					update_user_meta($user_id, 'account_status', 'locked');
						
					$class_registration_control_emails->send_email($to_email, $account_blocked_email_subject, $account_blocked_email_body, $attachments);
						$action = 'blocked';
					}
				
				
				global $wpdb;
				$table = $wpdb->prefix . "registration_control";
				
				$gmt_offset = get_option('gmt_offset');
				$datetime = date('Y-m-d H:i:s', strtotime('+'.$gmt_offset.' hour'));
				
				$result = $wpdb->get_results("SELECT * FROM $table WHERE email = '$user_email'", ARRAY_A);
				$total_rows = $wpdb->num_rows;	
					
				if($total_rows == 0 ){
						
						$wpdb->query( $wpdb->prepare("INSERT INTO $table 
							(id, datetime, username, email, action )
							VALUES( %d, %s, %s, %s, %s)",
							array('',$datetime, $user_login, $user_email, $action)
							));
		
					}
				else{
						$wpdb->query("UPDATE $table SET action = '$action' WHERE email = '$email'");
					}
				

				}

			}		

}





add_action( 'user_register', 'registration_control_registration_action_block_username', 100, 1 );

function registration_control_registration_action_block_username( $user_id ) {


		$registration_control_enable_username_block = get_option('registration_control_enable_username_block');
		
		if($registration_control_enable_username_block == 'yes'){
			

			$class_registration_control_emails = new class_registration_control_emails();
	
			$registration_control_action_on_registration = get_option('registration_control_action_on_registration');
					
			$registration_control_blocked_username = get_option('registration_control_blocked_username');		
			$blocked_username = $registration_control_blocked_username;
			
			
			
			$user_data = get_user_by( 'id', $user_id );
			
			
			$user_login = $user_data->user_login;		
			$user_email = $user_data->user_email;
			
			$email_parameter_vars = array(
				'{site_name}'=> get_bloginfo('name'),
				'{site_description}' => get_bloginfo('description'),
				'{site_url}' => get_bloginfo('url'),						
				'{site_logo_url}' => get_option('ads_bm_logo_url'),
			  
				'{user_name}' => $user_login,						  
				'{user_avatar}' => get_avatar( $user_email, 60 ),
				'{user_email}' => $user_email,
																						
	
			);
						
			$email_parameter_vars = apply_filters('registration_control_email_parameter_vars',$email_parameter_vars);
			
			$admin_email = get_option('admin_email');					
			$registration_control_email_templates_data = get_option( 'registration_control_email_templates_data' );
	
			$class_registration_control_emails = new class_registration_control_emails();
			$templates_data = $class_registration_control_emails->email_templates_data();
	
			if(empty($registration_control_email_templates_data)){
				//$templates_data = $class_registration_control_emails->registration_control_email_templates_data();
				$registration_control_email_templates_data = $templates_data;
				
				}
			else{
				//$templates_data = $class_registration_control_emails->registration_control_email_templates_data();
				$registration_control_email_templates_data =array_merge($templates_data, $registration_control_email_templates_data);
				
				}	
	
			$account_blocked_email_body = strtr($registration_control_email_templates_data['account_blocked']['html'], $email_parameter_vars);
			$account_blocked_email_subject =strtr($registration_control_email_templates_data['account_blocked']['subject'], $email_parameter_vars);
	
			$account_deleted_email_body = strtr($registration_control_email_templates_data['account_deleted']['html'], $email_parameter_vars);
			$account_deleted_email_subject =strtr($registration_control_email_templates_data['account_deleted']['subject'], $email_parameter_vars);
	
			$attachments = '';
			$to_email = $user_email;		
			
			
	
			//$time = date('H:i:s', strtotime('+'.$gmt_offset.' hour'));
			
			$username_match = registration_control_username_match($user_id);
			
			if(in_array($user_login,$blocked_username) || $username_match==true){
				
				if($registration_control_action_on_registration=='delete'){
					
					require_once(ABSPATH . "wp-admin" . '/includes/user.php');
					wp_delete_user($user_id);
					$class_registration_control_emails->send_email($to_email, $account_deleted_email_subject, $account_deleted_email_body, $attachments);
	
					$action = 'deleted';
					
					}
				elseif($registration_control_action_on_registration=='block'){
					
					update_user_meta($user_id, 'account_status', 'locked');
					$class_registration_control_emails->send_email($to_email, $account_blocked_email_subject, $account_blocked_email_body, $attachments);
					$action = 'blocked';
					}
				
				global $wpdb;
				$table = $wpdb->prefix . "registration_control";
				
				$gmt_offset = get_option('gmt_offset');
				$datetime = date('Y-m-d H:i:s', strtotime('+'.$gmt_offset.' hour'));
				
				$result = $wpdb->get_results("SELECT * FROM $table WHERE email = '$user_email'", ARRAY_A);
				$total_rows = $wpdb->num_rows;	
					
				if($total_rows == 0 ){
						
						$wpdb->query( $wpdb->prepare("INSERT INTO $table 
							(id, datetime, username, email, action )
							VALUES( %d, %s, %s, %s, %s)",
							array('',$datetime, $user_login, $user_email, $action)
							));
		
					}
				else{
						$wpdb->query("UPDATE $table SET action = '$action' WHERE email = '$email'");
					}

				
				}
			
			}


}




function registration_control_username_match( $user_id ) {
	
		$registration_control_blocked_username = get_option('registration_control_blocked_username');		
		$blocked_username = $registration_control_blocked_username;
		
		$user_data = get_user_by( 'id', $user_id );
		$user_login = $user_data->user_login;
	
		if(!empty($blocked_username)){
			
			foreach($blocked_username as $usename){
				
				if(stripos( $usename, $user_login)){
					
					return true;
					}
				else{
					return false;
					}
				
				}
			
			}
	
	}



