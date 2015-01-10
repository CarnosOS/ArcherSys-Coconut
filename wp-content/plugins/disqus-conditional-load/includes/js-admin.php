<?php defined('ABSPATH') or die("Crap ! You can not access this directly."); ?>
<div id="jspro" class="wrap jspro-settings">

	<h2> <?php _e( 'Disqus Conditional Load' ); ?>: <?php _e( 'Advanced Settings'); ?></h2>

	<div id="jspro-content">
	<?php
/*
* Admin setting form
* Using post values
*/
	// Checking for post value - Suggested by Jeff Behnke
	
    if( isset($_POST['js_hidden']) && $_POST['js_hidden'] == 'Y' ) {
        $js_type = $_POST['js_type'];
        update_option('js_type', $js_type);
		
		$js_button = $_POST['js_button'];
        update_option('js_button', $js_button);
        
        $js_class = $_POST['js_class'];
        update_option('js_class', $js_class);
		
		$js_message = $_POST['js_message'];
        update_option('js_message', $js_message);
		
		$js_shortcode = $_POST['js_shortcode'];
        update_option('js_shortcode', $js_shortcode);
		
		$js_count_disable = $_POST['js_count_disable'];
        update_option('js_count_disable', $js_count_disable);
         
        ?>
        
        <?php
    } else {
        $js_type = get_option('js_type');
		$js_button = get_option('js_button');
        $js_class = get_option('js_class');
		$js_message = get_option('js_message');
		$js_shortcode = get_option('js_shortcode');
		$js_count_disable = get_option('js_count_disable');
    }
?>
    <form name="oscimp_form" method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
	<?php wp_nonce_field('dsq-wpnonce_js', 'dsq-form_nonce_js'); ?>
        <input type="hidden" name="js_hidden" value="Y">
        <?php    echo "<h4>" . __( 'Disqus Load Settings', 'oscimp_trdom' ) . "</h4>"; ?>
        <p><?php _e("Load Disqus when : " ); ?><select name='js_type' id='js_type'><option value='click' <?php if($js_type == 'click'){echo 'selected';}?>>On Click</option>
																			<option value='scroll' <?php if($js_type == 'scroll'){echo 'selected';}?>>On Scroll</option>
																			<option value='normal' <?php if($js_type == 'normal'){echo 'selected';}?>>Normal - Disable Lazy Load</option>
												</select></p>
		<p>This option will prevent Disqus from automatically loading comments and scripts on pages or posts. If you choose "Normal" comments will be loaded normally and no lazy load effect will be there.
		Shortcode will work on all these options.</p>
		<p><?php _e("Disable Default Disqus Count Script Loading : " ); ?>
		<select name='js_count_disable' id='js_count_disable'><option value='no' <?php if($js_count_disable == 'no'){echo 'selected';}?>>No</option>
																			<option value='yes' <?php if($js_count_disable == 'yes'){echo 'selected';}?>>Yes</option>
		</select></p>
		<p>By default Disqus may load a script (count.js) to get the comments count to show somewhere on your pages. If you want to disable loading that script enable this feature. Enabling this feature can improve page loading speed.
		<hr />
		<div id='button_prop'><?php echo "<h4>" . __( 'Button Settings', 'oscimp_trdom' ) . "</h4>"; ?>
        <p><?php _e("Button Name : " ); ?><input type="text" name="js_button" value="<?php echo $js_button; ?>" size="20"></p>
        <p><?php _e("Button Class : " ); ?><input type="text" name="js_class" value="<?php echo $js_class; ?>" size="20"><br/>
        By using custom class you can use your own style for comment button. Leave empty if you don't want.</p>	
		<p><?php _e("Loading Comments Message : " ); ?><input type="text" name="js_message" value="<?php echo $js_message; ?>" size="25"></p>
		<hr /></div>
		<?php    echo "<h4>" . __( 'ShortCode Settings', 'oscimp_trdom' ) . "</h4>"; ?>
                <p><?php _e("Enable <b>Short Code</b> : " ); ?><select name='js_shortcode'><option value='no' <?php if($js_shortcode=='no'){echo 'selected';}?>>No</option><option value='yes' <?php if($js_shortcode=='yes'){echo 'selected';}?>>Yes</option></select><br/>
                    Please note that if you enable this comments will be loaded where the shortcode <b>[js-disqus]</b> placed. If shortcode not found Disqus comments will be loaded normally.</p>
        <p class="submit">
        <button class="button-primary button" type="submit" name="Submit" id="submit"><?php _e('Update Options', 'oscimp_trdom' ) ?></button>
        </p>
    </form>
<script type="text/javascript">
	jQuery('#js_type').change(function(){
		var selected = jQuery(this).val();
		if (selected == 'scroll') { jQuery('#button_prop').hide(); }
		if (selected == 'normal') { jQuery('#button_prop').hide(); }
		if (selected == 'click') { jQuery('#button_prop').show(); }
	});
	jQuery( document ).ready(function() {
		var bu = jQuery( "#js_type" ).val();
		if (bu == 'scroll') { jQuery('#button_prop').hide(); }
		if (bu == 'normal') { jQuery('#button_prop').hide(); }
		if (bu == 'click') { jQuery('#button_prop').show(); }
	});
</script>
	
	<?php include 'parts/js-footer.php'; ?>
</div>



<div id="jspro-sidebar">
	<?php include 'parts/js-sidebar.php'; ?>
</div>

</div>

