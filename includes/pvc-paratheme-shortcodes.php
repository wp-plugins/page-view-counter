<?php




if ( ! defined('ABSPATH')) exit; // if direct access 


	function pvc_paratheme_display($atts )
		{
			$atts = shortcode_atts(
				array(
					'today' => "yes",				
					'total' => "yes",
					), $atts);
					
			
			
			
			$pvc_paratheme = '';
			
			$pvc_paratheme .= '<div class="pvc-paratheme">';
			$pvc_paratheme .= '<span class="pvc-paratheme-today">Today view: '.pvc_paratheme_today_total_view().'</span>';
			$pvc_paratheme .= '<span class="pvc-paratheme-total"> - Total View: '.pvc_paratheme_total_view().'</span>';
			
			$pvc_paratheme .= '</div>';	
			
			
			
			
			return $pvc_paratheme;
					
					
	
		}
	
	
	add_shortcode('pvc_paratheme', 'pvc_paratheme_display');