<?php

if ( ! defined('ABSPATH')) exit; // if direct access 








	function pvc_paratheme_total_view()
		{
		
			$pvc_paratheme_date = pvc_paratheme_date();
			
			if(in_the_loop())
				{
					$url_id = get_the_ID();
				}
			else
				{
					$url_id = pvc_paratheme_geturl_id();
				}
			
			
			
			
			global $wpdb;
			$table = $wpdb->prefix . "pvc_paratheme";
			$post_id = get_the_id();
			$result = $wpdb->get_results("SELECT * FROM $table WHERE url_id = '$url_id'", ARRAY_A);
			
			if(empty($result[0]['count']))
				{
					$view_count = 0;
				}
			else 
				{
					$view_count = $result[0]['count'];
				}
			
			return $view_count;
		
		}







	function pvc_paratheme_today_total_view()
		{
		
			$pvc_paratheme_date = pvc_paratheme_date();
			$url_id = pvc_paratheme_geturl_id();
			if(in_the_loop())
				{
					$url_id = get_the_ID();
				}
			else
				{
					
				}
			
			
			global $wpdb;
			$table = $wpdb->prefix . "pvc_paratheme_info";
			$post_id = get_the_id();
			$result = $wpdb->get_results("SELECT * FROM $table WHERE url_id = '$url_id' AND date='$pvc_paratheme_date'", ARRAY_A);
			
			if(empty($result[0]['count']))
				{
					$view_count = 0;
				}
			else 
				{
					$view_count = $result[0]['count'];
				}
			
			return $view_count;
		
		}


	function pvc_paratheme_date()
		{	
			$gmt_offset = get_option('gmt_offset');
			$pvc_paratheme_datetime = date('Y-m-d', strtotime('+'.$gmt_offset.' hour'));
			
			return $pvc_paratheme_datetime;
		
		}






function pvc_paratheme_geturl_id()
	{	
		global $post;
		
		
		
		if(is_home()) // working fine with http://
			{
				
				$url_id = get_bloginfo( 'url' );

			}
		elseif(is_singular()) //working fine
			{

				$url_id = get_the_ID();
			}
		elseif( is_tag()) // http added
			{

				$url_id = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
			}			
			
		elseif(is_archive()) // http added
			{

				$url_id = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
			}
		elseif(is_search())
			{

				$url_id = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
			}			
			
			
		elseif( is_404())
			{

				$url_id = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
			}			
		elseif( is_admin())
			{

				$url_id = admin_url();
			}	

		else
			{

				$url_id = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
			}
					
	
		return $url_id;
		
	}
