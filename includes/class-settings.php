<?php

/*
* @Author 		pickplugins
* Copyright: 	2015 pickplugins
*/

if ( ! defined('ABSPATH')) exit;  // if direct access 


class class_registration_control_settings  {
	
	
    public function __construct(){

		add_action( 'admin_menu', array( $this, 'admin_menu' ), 12 );
    }
	

	
	
	public function admin_menu() {
		
		add_menu_page(__('Registration Control','breadcrumb'), __('Registration Control','breadcrumb'), 'manage_options', 'registration_control_settings', array( $this, 'registration_control_settings' ));
		
		//add_menu_page(__('Emails','breadcrumb'), __('Emails','breadcrumb'), 'manage_options', 'registration_control_emails', array( $this, 'registration_control_emails' ));		
		
		add_submenu_page('registration_control_settings', __('Emails',registration_control_textdomain), __('Emails',registration_control_textdomain), 'manage_options', 'registration_control_emails', array( $this, 'registration_control_emails' ));
		
		add_submenu_page('registration_control_settings', __('History',registration_control_textdomain), __('History',registration_control_textdomain), 'manage_options', 'registration_control_history', array( $this, 'registration_control_history' ));		
		
		
	}
	
	public function registration_control_settings(){
		
		include( 'menu/settings.php' );
		}	
	
	public function registration_control_emails(){
		
		include( 'menu/emails-templates.php' );
		}	
		
	public function registration_control_history(){
		
		include( 'menu/history.php' );
		}		
		
		
		
		
		
		
		

	}


new class_registration_control_settings();

