<?php

/*
* @Author 		pickplugins
* Copyright: 	2015 pickplugins
*/

if ( ! defined('ABSPATH')) exit;  // if direct access 


class class_registration_control_functions{
	
	public function __construct(){

	


		}




	public function setings_options($options = array()){






			$options[] = array(
								
								'title'=>__('General',registration_control_textdomain),
								'description'=>'',								
								
								'options'=>array(

													'registration_control_enable_domain_block'=>array(
														'key'=>'registration_control_enable_domain_block',
														'css_class'=>'enable_domain_block',
														'placeholder'=>'example.com',
														'title'=>__('Enable domain block', registration_control_textdomain),
														'option_details'=>__('Enable domain blocking.', registration_control_textdomain),					
														'input_type'=>'select', // text, radio, checkbox, select,
														'input_values'=> array(''), // could be array
														'input_args'=> array('yes'=>__('Yes', registration_control_textdomain),'no'=>__('No',registration_control_textdomain)),
														),		

													'registration_control_blocked_domain'=>array(
														'key'=>'registration_control_blocked_domain',
														'css_class'=>'blocked_domain',
														'placeholder'=>'example.com',
														'title'=>__('Blocked domain', registration_control_textdomain),
														'option_details'=>__('One domain per line. wihtout http://', registration_control_textdomain),					
														'input_type'=>'text-multi', // text, radio, checkbox, select,
														'input_values'=>'', // could be array
														),				
								
													'registration_control_enable_username_block'=>array(
														'key'=>'registration_control_enable_username_block',
														'css_class'=>'enable_username_block',
														'placeholder'=>'',
														'title'=>__('Enable username block', registration_control_textdomain),
														'option_details'=>__('Enable username blocking.', registration_control_textdomain),					
														'input_type'=>'select', // text, radio, checkbox, select,
														'input_values'=> array(''), // could be array
														'input_args'=> array('yes'=>__('Yes', registration_control_textdomain),'no'=>__('No',registration_control_textdomain)),
														),	

													'registration_control_blocked_username'=>array(
														'key'=>'registration_control_blocked_username',
														'css_class'=>'blocked_username',
														'placeholder'=>'',
														'title'=>__('Blocked username', registration_control_textdomain),
														'option_details'=>__('One name per line.', registration_control_textdomain),					
														'input_type'=>'text-multi', // text, radio, checkbox, select, wp_editor
														'input_values'=>'', // could be array
														),
														
													'registration_control_action_on_registration'=>array(
														'key'=>'registration_control_action_on_registration',
														'css_class'=>'action_on_registration',
														'placeholder'=>'',
														'title'=>__('Action on registration', registration_control_textdomain),
														'option_details'=>__('Action after complete registration.', registration_control_textdomain),					
														'input_type'=>'select', // text, radio, checkbox, select,
														'input_values'=> array(''), // could be array
														'input_args'=> array('delete'=>__('Delete', registration_control_textdomain),'block'=>__('Block',registration_control_textdomain),'none'=>__('None',registration_control_textdomain)),
														),
														
													'registration_control_send_notify_email_user'=>array(
														'key'=>'registration_control_send_notify_email_user',
														'css_class'=>'send_notify_email_user',
														'placeholder'=>'',
														'title'=>__('Send notify email to user ', registration_control_textdomain),
														'option_details'=>__('Send notify email to user after complete action.', registration_control_textdomain),					
														'input_type'=>'select', // text, radio, checkbox, select,
														'input_values'=> array(''), // could be array
														'input_args'=> array('yes'=>__('Yes', registration_control_textdomain),'no'=>__('No',registration_control_textdomain)),
														),														

												),								

								);






			$options[] = array(
								
								'title'=>__('Security',registration_control_textdomain),
								'description'=>'',								
								
								'options'=>array(

													'registration_control_reCAPTCHA_enable'=>array(
														'key'=>'registration_control_reCAPTCHA_enable',
														'css_class'=>'reCAPTCHA_enable',
														'placeholder'=>'',
														'title'=>__('reCAPTCHA on Registration ', registration_control_textdomain),
														'option_details'=>__('reCAPTCHA enable', registration_control_textdomain),					
														'input_type'=>'select', // text, radio, checkbox, select,
														'input_values'=> array(''), // could be array
														'input_args'=> array('no'=>__('No',registration_control_textdomain),'yes'=>__('Yes', registration_control_textdomain),), // could be array	
														),				
								
													'registration_control_reCAPTCHA_site_key'=>array(
														'key'=>'registration_control_reCAPTCHA_site_key',
														'css_class'=>'reCAPTCHA_site_key',
														'placeholder'=>'',
														'title'=>__('reCAPTCHA site key', registration_control_textdomain),
														'option_details'=>__('reCAPTCHA site key', registration_control_textdomain),					
														'input_type'=>'text', // text, radio, checkbox, select,
														'input_values'=>'', // could be array
														),
														
													'registration_control_reCAPTCHA_secret_key'=>array(
														'key'=>'registration_control_reCAPTCHA_secret_key',
														'css_class'=>'reCAPTCHA_secret_key',
														'placeholder'=>'',
														'title'=>__('reCAPTCHA secret key', registration_control_textdomain),
														'option_details'=>__('reCAPTCHA secret key', registration_control_textdomain),					
														'input_type'=>'text', // text, radio, checkbox, select,
														'input_values'=>'', // could be array
														),

												),								

								);










			
			$options = apply_filters( 'registration_control_filter_ads_meta_fields', $options );

			return $options;
		
		}




		
	
	
	

	
	
	
	
	
	
	}
	
	//new class_registration_control_functions();