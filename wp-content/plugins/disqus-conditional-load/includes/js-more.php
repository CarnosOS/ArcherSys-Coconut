<?php
defined('ABSPATH') or die("Crap ! You can not access this directly.");
?>
<div id="jspro" class="wrap jspro-settings">

	<h2> <?php _e( 'Disqus Conditional Load' ); ?> : <?php _e( 'Pro Features (Dummy Page)'); ?></h2>
	
	<div id="jspro-content">
	<h3 style="color : red;">These features are not available on free version. Please <a href="http://store.joelsays.com/">upgrade to pro version</a></h3>
	<?php    echo "<h4>" . __( 'Disqus Woocommerce Settings', 'oscimp_trdom' ) . "</h4>"; ?>
        
		<form name="oscimp_form" method="post" action="#">
			<p><?php _e("Enable : " ); ?>
			<select>
				<option>Enable</option>
				<option>Disable</option>
			</select></p>
			<p><?php _e("Comments Tab Position : " ); ?>
			<select>
				<option>1st</option>
				<option>2nd</option>
				<option>3rd</option>
			</select></p>
		<p>These option will add a new tab to product tabs area, and then load Disqus comments there. You can decide tab position.</p>
		<hr />
		<div id='button_prop'><?php echo "<h4>" . __( 'Button Styling', 'oscimp_trdom' ) . "</h4>"; ?>
        <p><?php _e("Button Style : " ); ?>
			<select>
				<option>--select--</option>
				<option>Red Style</option>
				<option>Orange Style</option>
				<option>Cyan Style</option>
				<option>Black Style</option>
				<option>Green Style</option>
				<option>Magenta Style</option>
			</select></p>
			<p>If you choose one style here, this style class will be automatically added to class field in advanced tab. (More styles will be added soon)</p>
			<p><?php _e("Comments Count on Button : " ); ?>
			<select>
				<option>Enable</option>
				<option>Disable</option>
			</select></p>
        <p>Enabling comments count on buttons will work only if you add API key on Disqus settings tab. Also this feature will load an extra script to get comments count.</p>	
		<hr /></div>
		<?php echo "<h4>" . __( 'Comment Widget Settings', 'oscimp_trdom' ) . "</h4>"; ?>
                <p><?php _e("Enable Comment Widget : " ); ?>
			<select>
				<option>Enable</option>
				<option>Disable</option>
			</select></p>
			<p>If you enable this you will be able to show comments as a widget. That can be used in your footer, sidebars etc.!!</p>	
        <p class="submit">
        <button class="button-primary button" name="Submit" id="submit" disabled="disabled"><?php _e('Update Options', 'oscimp_trdom' ) ?></button>
        </p>
		</form>
	<?php include 'parts/js-footer.php'; ?>
</div>



<div id="jspro-sidebar">
	<?php include 'parts/js-sidebar.php'; ?>
</div>

</div>

