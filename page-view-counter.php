<?php
/*
Plugin Name: Page View Counter
Plugin URI: http://paratheme.com
Description: Every page view count for WordPress.
Version: 1.0
Author: paratheme
Author URI: http://paratheme.com
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
*/



require_once( plugin_dir_path( __FILE__ ) . 'includes/pvc-paratheme-functions.php');
require_once( plugin_dir_path( __FILE__ ) . 'includes/pvc-paratheme-shortcodes.php');



define('pvc_paratheme_plugin_url', WP_PLUGIN_URL . '/' . plugin_basename( dirname(__FILE__) ) . '/' );
define('pvc_paratheme_plugin_dir', plugin_dir_path( __FILE__ ) );
define('pvc_paratheme_wp_url', 'http://wordpress.org/plugins/page-view-counter/' );
define('pvc_paratheme_pro_url', '' );
define('pvc_paratheme_demo_url', '' );
define('pvc_paratheme_conatct_url', 'http://paratheme.com/contact' );
define('pvc_paratheme_qa_url', 'http://paratheme.com/qa' );
define('pvc_paratheme_plugin_name', 'Page View Counter' );
define('pvc_paratheme_share_url', 'http://wordpress.org/plugins/page-view-counter/' );



function pvc_paratheme_init_scripts()
	{
		wp_enqueue_script('jquery');
		wp_enqueue_style('wp-live-statistics-style', pvc_paratheme_plugin_url.'css/style.css');
		wp_enqueue_script('wp-live-statistics-js', plugins_url( '/js/scripts.js' , __FILE__ ) , array( 'jquery' ));
		
		
		//ParaAdmin
		wp_enqueue_style('ParaAdmin', pvc_paratheme_plugin_url.'ParaAdmin/css/ParaAdmin.css');
		wp_enqueue_style('ParaIcons', pvc_paratheme_plugin_url.'ParaAdmin/css/ParaIcons.css');		
		wp_enqueue_script('ParaAdmin', plugins_url( 'ParaAdmin/js/ParaAdmin.js' , __FILE__ ) , array( 'jquery' ));
		
			
	}
add_action("init","pvc_paratheme_init_scripts");






register_activation_hook(__FILE__, 'pvc_paratheme_install');
register_uninstall_hook(__FILE__, 'pvc_paratheme_drop');


function pvc_paratheme_install()
	{
		global $wpdb;
        $sql = "CREATE TABLE IF NOT EXISTS " . $wpdb->prefix . "pvc_paratheme"
                 ."( UNIQUE KEY id (id),
					id int(100) NOT NULL AUTO_INCREMENT,
					url_id  VARCHAR( 255 ) NOT NULL,
					count  int(10) NOT NULL)";
		$wpdb->query($sql);
		
        $sql2 = "CREATE TABLE IF NOT EXISTS " . $wpdb->prefix . "pvc_paratheme_info"
                 ."( UNIQUE KEY id (id),
					id int(100) NOT NULL AUTO_INCREMENT,
					url_id  VARCHAR( 255 ) NOT NULL,
					count  int(10) NOT NULL,
					date DATE NOT NULL)";
		$wpdb->query($sql2);		



		$pvc_paratheme_version= "1.0";
		update_option('pvc_paratheme_version', $pvc_paratheme_version); //update plugin version.
		
		$pvc_paratheme_customer_type= "pro"; //customer_type "free"
		update_option('pvc_paratheme_customer_type', $pvc_paratheme_customer_type); //update plugin customer type.







		}




function pvc_paratheme_drop() {
	if ( get_option('pvc_paratheme_delete_data') == 'yes' ) {
		
		global $wpdb;

		$wpdb->query('DROP TABLE IF EXISTS ' . $wpdb->prefix . 'pvc_paratheme');
		$wpdb->query('DROP TABLE IF EXISTS ' . $wpdb->prefix . 'pvc_paratheme_info');
		
		
		delete_option( 'pvc_paratheme_version' );
		delete_option( 'pvc_paratheme_customer_type' );		
		delete_option( 'pvc_paratheme_delete_data' );			
				
	}
	

	
	
	
}


	



function pvc_paratheme_visit()
	{
		
	
	$pvc_paratheme_date = pvc_paratheme_date();
	$url_id = pvc_paratheme_geturl_id();

	
	
	global $wpdb;
	$table = $wpdb->prefix . "pvc_paratheme";




	$result = $wpdb->get_results("SELECT count FROM $table WHERE url_id = '$url_id'", ARRAY_A);
	if(empty($result[0]['count']))
		{
			$view_count = 0;
		}
	else
		{
			$view_count = $result[0]['count'];
		}
	
	
	$already_insert = $wpdb->num_rows;


	if($already_insert > 0 )
		{
			$wpdb->query("UPDATE $table SET count = count+1 WHERE url_id = '$url_id'");
		}
	else
		{
						
			$wpdb->query( $wpdb->prepare("INSERT INTO $table 
								( id, url_id, count   )
								VALUES	( %d, %s, %s)",
								array	( '',  $url_id, 1 )
										
										));			
										
										
										
		}


	$table = $wpdb->prefix . "pvc_paratheme_info";
	
	$result = $wpdb->get_results("SELECT * FROM $table WHERE date = '$pvc_paratheme_date' AND url_id = '$url_id'", ARRAY_A);
	$already_insert = $wpdb->num_rows;

	if($already_insert > 0 )
		{


			$wpdb->query("UPDATE $table SET count = count+1 WHERE (date = '$pvc_paratheme_date') AND (url_id = '$url_id')");
			

		}
	else
		{


			$wpdb->query( $wpdb->prepare("INSERT INTO $table 
										( id, url_id, count, date )
								VALUES	( %d, %s, %d, %s)",
								array	( '', $url_id, 1, $pvc_paratheme_date)
										));
			
			

		}


		



					
	}

add_action('wp_head', 'pvc_paratheme_visit');










add_action('admin_init', 'pvc_paratheme_options_init' );
add_action('admin_menu', 'pvc_paratheme_menu_init');


function pvc_paratheme_options_init(){
	register_setting('pvc_paratheme_options', 'pvc_paratheme_version');
	register_setting('pvc_paratheme_options', 'pvc_paratheme_customer_type');	
	register_setting('pvc_paratheme_options', 'pvc_paratheme_delete_data');

    }

function pvc_paratheme_settings(){
	include('pvc-paratheme-settings.php');
	}
	
	
function pvc_paratheme_dashboard(){
	include('pvc-paratheme-dashboard.php');
	}
		




function pvc_paratheme_menu_init() {


	add_menu_page(__('Page View Counter - Settings','pvc_paratheme'), __('Page View Counter','pvc_paratheme'), 'manage_options', 'pvc_paratheme_settings', 'pvc_paratheme_settings');

	//add_submenu_page('pvc_paratheme_settings', __('Page View Counter Dashboard','menu-pvc_paratheme'), __('Dashboard','menu-pvc_paratheme'), 'manage_options', 'pvc_paratheme_dashboard', 'pvc_paratheme_dashboard');



	
}
























































