<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://caniwordpress.com/healthcare-review/
 * @since             1.0.0
 * @package           Healthcare_Review_Master
 *
 * @wordpress-plugin
 * Plugin Name:       Healthcare Review Master
 * Plugin URI:        http://caniwordpress.com/healthcare-review//healthcare-review-master-uri/
 * Description:       Healthcare Review Master is the quickest and easiest way to pull reviews right off your Zocdoc page and directly onto your personal WordPress website. It's equipped with a modern responsive design so you can proudly show off your Zocdoc reviews on any device. Also enjoy easy customization within the settings panel so you can make it work the way you want.
 * Version:           1.0.0
 * Author:            iCanWP Team, Sean Roh, Chris Couweleers
 * Author URI:        http://caniwordpress.com/healthcare-review//
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       healthcare-review-master
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-healthcare-review-master-activator.php
 */
function activate_healthcare_review_master() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-healthcare-review-master-activator.php';
	Healthcare_Review_Master_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-healthcare-review-master-deactivator.php
 */
function deactivate_healthcare_review_master() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-healthcare-review-master-deactivator.php';
	Healthcare_Review_Master_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_healthcare_review_master' );
register_deactivation_hook( __FILE__, 'deactivate_healthcare_review_master' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-healthcare-review-master.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_healthcare_review_master() {

	$plugin = new Healthcare_Review_Master();
	$plugin->run();

}
run_healthcare_review_master();
