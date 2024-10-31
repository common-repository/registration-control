<?php

/*
* @Author 		pickplugins
* Copyright: 	2015 pickplugins
*/

if ( ! defined('ABSPATH')) exit;  // if direct access 

class class_registration_control_emails{
	
	public function __construct(){


	

		}
		
		
		
	public function send_email($to_email='', $email_subject='', $email_body='', $attachments=''){
		
		
		
		
		$registration_control_from_email = get_option('registration_control_from_email');

		$headers = "";
		$headers .= "From: ".$registration_control_from_email." \r\n";
		$headers .= "MIME-Version: 1.0\r\n";
		$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

		$status = wp_mail($to_email, $email_subject, $email_body, $headers, $attachments);
		
		return $status;
		
		}	
		
		
		
		
		

	public function email_templates_data(){
		
		require_once( 'emails-templates/account_blocked.php');	
		require_once( 'emails-templates/account_deleted.php');			
		
		$templates_data = array(
							
			'account_blocked'=>array(	'name'=>__('Account Blocked','registration_control'),
										'subject'=>__('Account Blocked - {site_url}','registration_control'),
										'html'=>$templates_data_html['account_blocked'],
						
									),
									
			'account_deleted'=>array(	'name'=>__('Account Deleted','registration_control'),
										'subject'=>__('Account Deleted - {site_url}','registration_control'),
										'html'=>$templates_data_html['account_deleted'],
						
									),									
			

		);
		
		$templates_data = apply_filters('registration_control_filters_email_templates_data', $templates_data);
		
		return $templates_data;

		}
		


	public function email_templates_parameters(){
		
		
			$parameters['site_parameter'] = array(
												'title'=>__('Site Parameters','registration_control'),
												'parameters'=>array('{site_name}','{site_description}','{site_url}','{site_logo_url}'),										
												);
												
			$parameters['user_parameter'] = array(
												'title'=>__('Users Parameters','registration_control'),
												'parameters'=>array('{user_name}','{user_avatar}','{user_email}'),										
												);	
												

												
			$parameters = apply_filters('registration_control_emails_templates_parameters',$parameters);
		
		
			return $parameters;
		
		}
	
		
		
		
		
		

	}
	
new class_registration_control_emails();