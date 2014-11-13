<?php

	if(empty($_POST['pvc_paratheme_hidden']))
		{
			$pvc_paratheme_delete_data = get_option( 'pvc_paratheme_delete_data' );	
				
					
		}

	else
		{
		
		if($_POST['pvc_paratheme_hidden'] == 'Y')
			{
			//Form data sent
			
			
			$pvc_paratheme_delete_data = $_POST['pvc_paratheme_delete_data'];
			update_option('pvc_paratheme_delete_data', $pvc_paratheme_delete_data);			

			
			?>
			<div class="updated"><p><strong><?php _e('Changes Saved.' ); ?></strong></p>
            </div>
            
            
            
            
<?php
			}
		} 
?>

 
 
 
 
 
 
 
<div class="wrap">
 
	<div id="icon-tools" class="icon32"><br></div><?php echo "<h2>".__(pvc_paratheme_plugin_name.' Settings')."</h2>";?>
<form  method="post" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>">
	<input type="hidden" name="pvc_paratheme_hidden" value="Y">
        <?php settings_fields( 'pvc_paratheme_options' );
				do_settings_sections( 'pvc_paratheme_options' );
		?>



    <div class="para-settings">
    
        <ul class="tab-nav"> 
            <li nav="1" class="nav1 active">Custom Fields</li>
            <li nav="2" class="nav2 ">Short-Codes</li>         
            <li nav="3" class="nav3">Help & Upgrade</li>
           
        </ul> <!-- tab-nav end --> 

		<ul class="box">
            <li style="display: block;" class="box1 tab-box active">
            
				<div class="option-box">
                    <p class="option-title">Reset Data ?</p>
                    <p class="option-info">Delete all data on database when uninstall or delete plugin.</p>
					<label ><input type="radio" name="pvc_paratheme_delete_data"  value="yes" <?php  if($pvc_paratheme_delete_data=='yes') echo "checked"; ?>/><span title="yes" class="pvc_paratheme_delete_data_yes <?php  if($pvc_paratheme_delete_data=='yes') echo "selected"; ?>">Yes</span></label>
            
 					<label ><input type="radio" name="pvc_paratheme_delete_data"  value="no" <?php  if($pvc_paratheme_delete_data=='no') echo "checked"; ?>/><span title="no" class="pvc_paratheme_delete_data_no <?php  if($pvc_paratheme_delete_data=='no') echo "selected"; ?>">No</span></label>
                    
                </div>
            
    
            
            </li>
            
            
            <li style="display: none;" class="box2 tab-box ">
				<div class="option-box">
                    <p class="option-title">Short-code for php file</p>
                    <p class="option-info">Short-code by dynamic post/page id you can use anywhere inside .php files.</p>
                    
                    <pre>&#60;?php<br />echo do_shortcode( '&#91;pvc_paratheme &#93;' ); <br />?&#62;</pre>


                </div>
                
                
				<div class="option-box">
                    <p class="option-title">Short-code inside content</p>
                    <p class="option-info"></p>
                    
                    <pre>&#91;pvc_paratheme &#93;


                </div>    
                
                
                
                
                
            </li>       
            
            
            
            <li style="display: none;" class="box3 tab-box ">
				<div class="option-box">
                    <p class="option-title">Need Help ?</p>
                    <p class="option-info">Feel free to Contact with any issue for this plugin, Ask any question via forum <a href="<?php echo pvc_paratheme_qa_url; ?>"><?php echo pvc_paratheme_qa_url; ?></a> <strong style="color:#139b50;">(free)</strong><br />
                    
                    
                    

	<?php
    
    $pvc_paratheme_customer_type = get_option('pvc_paratheme_customer_type');
    $pvc_paratheme_version = get_option('pvc_paratheme_version');
    

    if($pvc_paratheme_customer_type=="free")
        {
    
            echo 'You are using <strong> '.$pvc_paratheme_customer_type.' version  '.$pvc_paratheme_version.'</strong> of <strong>'.pvc_paratheme_plugin_name.'</strong>, To get more feature you could try our premium version. ';
            
            echo '<a href="'.pvc_paratheme_pro_url.'">'.pvc_paratheme_pro_url.'</a>';
            
        }
    elseif($pvc_paratheme_customer_type=="pro")
        {
    
            echo 'Thanks for using <strong> premium version  '.$pvc_paratheme_version.'</strong> of <strong>'.pvc_paratheme_plugin_name.'</strong> ';	
            
            
        }
    
     ?>       

           
                    
                    
                    
                    </p>
					
                    
                    
                </div>
            
            </li>

            
		</ul>
	</div> <!-- para-settings --> 	  
	
    <p class="submit">
    	<input class="button button-primary" type="submit" name="Submit" value="<?php _e('Save Changes' ) ?>" />
	</p>


</form>

</div>