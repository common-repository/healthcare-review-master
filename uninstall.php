<?php

/**
 * Fired when the plugin is uninstalled.
 *
 * When populating this file, consider the following flow
 * of control:
 *
 * - This method should be static
 * - Check if the $_REQUEST content actually is the plugin name
 * - Run an admin referrer check to make sure it goes through authentication
 * - Verify the output of $_GET makes sense
 * - Repeat with other user roles. Best directly by using the links/query string parameters.
 * - Repeat things for multisite. Once for a single site in the network, once sitewide.
 *
 * This file may be updated more in future version of the Boilerplate; however, this is the
 * general skeleton and outline for how the file should work.
 *
 * For more information, see the following discussion:
 * https://github.com/tommcfarlin/WordPress-Plugin-Boilerplate/pull/123#issuecomment-28541913
 *
 * @link       http://caniwordpress.com/healthcare-review/
 * @since      1.0.0
 *
 * @package    Healthcare_Review_Master
 */

// If uninstall not called from WordPress, then exit.
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}
$hrm_options = array(
	'hrm_url_zocdoc_review',
	'hrm_num_show_zocdoc_review',
	'hrm_zocdoc_review_interval',
	'hrm_zocdoc_review_speed',
	'hrm_zocdoc_review_show_control',
	'hrm_zocdoc_review_pause_on_hover',
	'hrm_zocdoc_shortcode_text_widget'
);
foreach($hrm_options as $option){
	delete_option($option);
}
