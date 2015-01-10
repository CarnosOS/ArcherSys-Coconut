<?php

defined('ABSPATH') or die("Crap ! You can not access this directly.");


	/**
	* Adding default option values if not available.
	* Without values for options plugin may not work.
	*/

		if(!get_option('js_type')){
		add_option('js_type', 'click');
		}
		if(!get_option('js_button')){
		add_option('js_button', 'Load Comments');
		}
		if(!get_option('js_message')){
		add_option('js_message', 'Loading...');
		}
		if(!get_option('js_shortcode')){
		add_option('js_shortcode', 'no');
		}
		if(!get_option('js_count_disable')){
		add_option('js_count_disable', 'no');
		}

		/**
		* Gets all option values of DCL from database
		* This page can be included to other pages in order to get option values
		**/
		
		$js_type = get_option('js_type');
		
		if( get_option('js_button') !== '')
			$js_button = get_option('js_button');
		else
			$js_button = 'Load Comments'; 

		$js_class = get_option('js_class');
		
		$js_message = get_option('js_message');
		
		$js_shortcode = get_option('js_shortcode');
		
		$js_count_disable = get_option('js_count_disable');

		
/**
* Here ends the options page
* Exit();
*
*/