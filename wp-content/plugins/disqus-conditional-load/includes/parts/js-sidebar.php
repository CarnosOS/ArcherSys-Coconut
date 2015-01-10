<?php defined('ABSPATH') or die("Crap ! You can not access this directly."); ?>
<?php
	$base = is_ssl() ? 'https://' : 'http://';
    $url = get_option('disqus_forum_url');
    if ($url) { $mod_url = $base.$url.'.'.DISQUS_DOMAIN.'/admin/moderate/'; }
    else { $mod_url = DISQUS_URL.'admin/moderate/'; }
	$mod_url;
 ?>
<div class="jspro-box"><h3><a href="<?php echo $mod_url; ?>">Moderate Comments Now</a></h3></div> 
<div class="jspro-box">
	<h4 class="jspro-title">Need Any Help?</h4>
	<p>You can always use the <a href="http://wordpress.org/support/plugin/disqus-conditional-load/">official WordPress support forum</a>.</p>
	<p>If you need quick support, kindly <a href="http://store.joelsays.com/">upgrade to pro version</a>.</p>
</div>
<div class="jspro-box" id="jspro-upgrade-box">
	<h3>Disqus Advanced ( DCL Pro )</h3>
	
	<p><em>There is a Pro version of this plugin with many other features that you will love!</em></p>

	<p>Pro features include woocommerce support, many default button styles, comments on sidebar/widget, comments count on button and quick support.</p>

	<p><a href="http://store.joelsays.com/">More information about DCL Pro &raquo;</a></p>
</div>
<div class="jspro-box">
	<h4 class="jspro-title">Please Support this Work</h4><div align="center">
	<p>Show your appreciation by adding <a href="https://wordpress.org/support/view/plugin-reviews/disqus-conditional-load?filter=5#postform" target="_blank">review on WordPress</a></p>
	<iframe src="//www.facebook.com/plugins/like.php?href=https%3A%2F%2Ffacebook.com%2FSaysJoel&amp;width&amp;layout=standard&amp;action=like&amp;show_faces=false&amp;share=false&amp;height=35&amp;appId=1406599162929386" scrolling="no" frameborder="0" style="border:none; overflow:hidden; height:35px;" allowTransparency="true"></iframe>
	<script src="https://apis.google.com/js/platform.js" async defer></script>
	<div class="g-follow" data-annotation="bubble" data-height="20" data-href="//plus.google.com/u/0/105457272740332174541" data-rel="author"></div>
</div></div>
<div class="jspro-box">
	<h4 class="jspro-title">Meet the <a href="http://www.joelsays.com/about-me/">Developer</a> of this plugin!</h4>
	<p>This plugin is developed by <a href="http://www.joelsays.com/about-me/">Joel James</a>, a web lover and developer from Kerala, India.</p>
	<p>If you would like to support his works, please consider a <a href="http://www.joelsays.com/donation/" target="_blank">small donation</a></p>
</div>