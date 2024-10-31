<?php
/*
Plugin Name: Registration Control
Plugin URI: http://pickplugins.com
Description: Block or Delete spam user on Registration by email domain &amp; username.
Version: 1.0.2
Author: projectW
Author URI: http://pickplugins.com
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
*/

if ( ! defined('ABSPATH')) exit;  // if direct access 



class RegistrationControl{
	
	public function __construct(){
	
	define('registration_control_plugin_url', plugins_url('/', __FILE__)  );
	define('registration_control_plugin_dir', plugin_dir_path( __FILE__ ) );
	define('registration_control_wp_url', 'https://wordpress.org/plugins/registration-control/' );
	define('registration_control_wp_reviews', 'http://wordpress.org/support/view/plugin-reviews/registration-control' );
	define('registration_control_pro_url','http://www.pickplugins.com/item/registration-control/' );
	define('registration_control_demo_url', 'http://www.pickplugins.com/demo/registration-control/' );
	define('registration_control_conatct_url', 'http://www.pickplugins.com/contact/' );
	define('registration_control_qa_url', 'http://www.pickplugins.com/questions/' );
	define('registration_control_plugin_name', 'Registration Control' );
	define('registration_control_plugin_version', '1.0.2' );
	define('registration_control_customer_type', 'free' );	 
	define('registration_control_share_url', '' );
	define('registration_control_tutorial_video_url', '' );
	define('registration_control_textdomain', 'registration_control' );
	
	
	// Class

	require_once( plugin_dir_path( __FILE__ ) . 'includes/class-functions.php');
	require_once( plugin_dir_path( __FILE__ ) . 'includes/class-settings.php');

	require_once( plugin_dir_path( __FILE__ ) . 'includes/class-emails.php');		
	require_once( plugin_dir_path( __FILE__ ) . 'includes/class-form.php');
	
	require_once( plugin_dir_path( __FILE__ ) . 'includes/functions.php');


	
	
	//add_action( 'admin_enqueue_scripts', 'wp_enqueue_media' );
	add_action( 'wp_enqueue_scripts', array( $this, 'registration_control_front_scripts' ) );
	add_action( 'admin_enqueue_scripts', array( $this, 'registration_control_admin_scripts' ) );
	add_action( 'plugins_loaded', array( $this, 'registration_control_load_textdomain' ));
	

	
	register_activation_hook( __FILE__, array( $this, 'registration_control_activation' ) );
	//register_deactivation_hook( __FILE__, array( $this, 'registration_control_deactivation' ) );
	//register_uninstall_hook( __FILE__, array( $this, 'registration_control_uninstall' ) );

	
	}
	
	public function registration_control_load_textdomain() {
	  load_plugin_textdomain( 'registration_control', false, plugin_basename( dirname( __FILE__ ) ) . '/languages/' ); 
	}
	
	public function registration_control_activation(){
		
		global $wpdb;
        $sql = "CREATE TABLE IF NOT EXISTS " . $wpdb->prefix . "registration_control"
                 ."( UNIQUE KEY id (id),
					id int(100) NOT NULL AUTO_INCREMENT,
					datetime  VARCHAR( 255 ) NOT NULL,					
					username  VARCHAR( 255 ) NOT NULL,
					email  VARCHAR( 255 ) NOT NULL,
					action  VARCHAR( 255 ) NOT NULL							

					)";
					
					
		$wpdb->query($sql);
		
		do_action( 'registration_control_action_install' );
		}		
		
	public function registration_control_uninstall(){
		
		do_action( 'registration_control_action_uninstall' );
		}		
		
	public function registration_control_deactivation(){
		
		do_action( 'registration_control_action_deactivation' );
		}
		
	
		

		
		
		
	public function registration_control_front_scripts(){
		
		wp_enqueue_script('jquery');
		
		wp_enqueue_script('registration_control_front_js', plugins_url( '/assets/front/js/scripts.js' , __FILE__ ) , array( 'jquery' ));
		wp_enqueue_script('registration_control_front_scripts-form', plugins_url( '/assets/front/js/scripts-form.js' , __FILE__ ) , array( 'jquery' ));		
		
		wp_enqueue_style('registration_control_style', registration_control_plugin_url.'assets/front/css/style.css');

		
		}

	public function registration_control_admin_scripts(){
		
		wp_enqueue_script('jquery');
		
		wp_enqueue_script('registration_control_admin_js', plugins_url( '/assets/admin/js/scripts.js' , __FILE__ ) , array( 'jquery' ));
		wp_localize_script( 'registration_control_admin_js', 'registration_control_ajax', array( 'registration_control_ajaxurl' => admin_url( 'admin-ajax.php')));
		
		wp_enqueue_style('registration_control_admin_style', registration_control_plugin_url.'assets/admin/css/style.css');

		}
	
	
	
	
	}

new RegistrationControl();









