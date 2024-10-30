<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       http://caniwordpress.com/healthcare-review/
 * @since      1.0.0
 *
 * @package    Healthcare_Review_Master
 * @subpackage Healthcare_Review_Master/admin/partials
 */
?>
<h2>Healthcare Review Master Settings </h2>
<p>Copy and paste the following shortcode in the contents area:</p>
<input type="text" name="hrm_shortcode" value="[show-reviews]" class="hrm-shortcode-display" readonly="readonly" />
<br />
<form class="hrm-settings" method="post" action="options.php"> 
<?php 
	settings_fields( 'hrm_main_menu' );
	do_settings_sections( 'hrm_main_menu' ); 
	submit_button(); 
?>
</form>