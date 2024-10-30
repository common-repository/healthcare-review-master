<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://caniwordpress.com/healthcare-review/
 * @since      1.0.0
 *
 * @package    Healthcare_Review_Master
 * @subpackage Healthcare_Review_Master/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Healthcare_Review_Master
 * @subpackage Healthcare_Review_Master/admin
 * @author     iCanWP Team, Sean Roh, Chris Couweleers
 */
class Healthcare_Review_Master_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $healthcare_review_master    The ID of this plugin.
	 */
	private $healthcare_review_master;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $healthcare_review_master       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $healthcare_review_master, $version ) {

		$this->plugin_name = $healthcare_review_master;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Healthcare_Review_Master_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Healthcare_Review_Master_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/healthcare-review-master-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Healthcare_Review_Master_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Healthcare_Review_Master_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/healthcare-review-master-admin.js', array( 'jquery' ), $this->version, false );

	}
	
	//Add Plugin Menu Pages
	public function hrm_add_admin_menu(){
		add_menu_page(
			'Healthcare Review Master',
			'Healthcare Review',
			'manage_options',
			'hrm_main_menu',
			array($this, 'display_hrm_main_menu_page'),
			plugin_dir_url( __FILE__ ) . 'assets/admin-icon.jpg',
			141.838
		);
	}
	public function hrm_init_options(){
		add_settings_section (
			'settings_section_hrm_general_section',
			'General Settings',
			array($this, 'callback_section_hrm_general_section'),
			'hrm_main_menu'
		);
		add_settings_field( 
			'hrm_url_zocdoc_review',
			'Enter ZocDoc Review Page URL',
			array($this, 'callback_hrm_url_zocdoc_review'),
			'hrm_main_menu',
			'settings_section_hrm_general_section',
			array('Enter the URL for Zocdoc Review Page')
		);
		add_settings_field( 
			'hrm_num_show_zocdoc_review',
			'# of Reviews to Show at a time',
			array($this, 'callback_hrm_num_show_zocdoc_review'),
			'hrm_main_menu',
			'settings_section_hrm_general_section',
			array('Total number of reviews to display in the viewer')
		);
		add_settings_field( 
			'hrm_zocdoc_review_interval',
			'Time Interval',
			array($this, 'callback_hrm_zocdoc_interval_time'),
			'hrm_main_menu',
			'settings_section_hrm_general_section',
			array('Time in milliseconds until loading next batch')
		);
		add_settings_field( 
			'hrm_zocdoc_review_speed',
			'Transition Time',
			array($this, 'callback_hrm_zocdoc_transition_speed'),
			'hrm_main_menu',
			'settings_section_hrm_general_section',
			array('Transition speed - loading animation speed.')
		);
		add_settings_field( 
			'hrm_zocdoc_review_show_control',
			'Show Control',
			array($this, 'callback_hrm_zocdoc_show_control'),
			'hrm_main_menu',
			'settings_section_hrm_general_section',
			array('Display manual control for loaded reviews: up, down, pause, and play.')
		);
		
		add_settings_field( 
			'hrm_zocdoc_review_pause_on_hover',
			'Pause Transition on Mouse Hover',
			array($this, 'callback_hrm_zocdoc_pause_on_hover'),
			'hrm_main_menu',
			'settings_section_hrm_general_section',
			array('Pauses loading next set of reviews on mouse hover.')
		);
		add_settings_field( 
			'hrm_zocdoc_shortcode_text_widget',
			'Allow shortcode from the "Text" widget',
			array($this, 'callback_hrm_allow_shortcode_in_text_widget'),
			'hrm_main_menu',
			'settings_section_hrm_general_section',
			array(
				'Check to allow the use of shortcode in the text widget. <br /><span class="hrm_warning"><strong>WARNING:</strong> This will allow the use of any shortcode from the text widget globally.</span>'
			)
		);
		
		register_setting(
			'hrm_main_menu',
			'hrm_url_zocdoc_review',
			array($this, 'sanitize_url_input')
		);
		register_setting(
			'hrm_main_menu',
			'hrm_num_show_zocdoc_review',
			array($this, 'sanitize_number_input')
		);
		register_setting(
			'hrm_main_menu',
			'hrm_zocdoc_review_interval',
			array($this, 'sanitize_number_input')
		);
		register_setting(
			'hrm_main_menu',
			'hrm_zocdoc_review_speed'
		);
		register_setting(
			'hrm_main_menu',
			'hrm_zocdoc_review_show_control'
		);
		register_setting(
			'hrm_main_menu',
			'hrm_zocdoc_review_pause_on_hover'
		);
		register_setting(
			'hrm_main_menu',
			'hrm_zocdoc_shortcode_text_widget'
		);
		
		if ( get_option( 'hrm_zocdoc_review_speed' ) === false ) {
			update_option( 'hrm_zocdoc_review_speed', 'slow' );
		}
		if ( get_option( 'hrm_num_show_zocdoc_review' ) === false ) {
			update_option( 'hrm_num_show_zocdoc_review', 5 );
		}
		if ( get_option( 'hrm_zocdoc_review_interval' ) === false ) {
			update_option( 'hrm_zocdoc_review_interval', 3000);
		}
	}
	public function display_hrm_main_menu_page(){
		require_once('partials/menu-hrm-main-settings.php');
	}
	
	public function callback_section_hrm_general_section(){
		require_once('partials/settings-section-general.php');
	}
	
	public function callback_hrm_url_zocdoc_review( $options ){	
		$html = '<input type="text" class="hrm-text-input" id="hrm_url_zocdoc_review" name="hrm_url_zocdoc_review" value="' . get_option( 'hrm_url_zocdoc_review' ) .'" />';
		$html .= '<label for="hrm_url_zocdoc_review"> '  . $options[0] . '</label>'; 
		echo $html;
	}
	
	public function callback_hrm_num_show_zocdoc_review ( $options ){
		$html = '<input type="number" min="1" class="hrm-number-field" id="hrm_num_show_zocdoc_review" name="hrm_num_show_zocdoc_review" value="' . get_option( 'hrm_num_show_zocdoc_review' ) .'" />';
		$html .= '<label for="hrm_num_show_zocdoc_review"> '  . $options[0] . '</label>'; 
		echo $html;
	}
	
	public function callback_hrm_zocdoc_interval_time ( $options ){
		$html = '<input type="number" min="1" class="hrm-number-field" id="hrm_zocdoc_review_interval" name="hrm_zocdoc_review_interval" value="' . get_option( 'hrm_zocdoc_review_interval' ) .'" />';
		$html .= '<label for="hrm_zocdoc_review_interval"> '  . $options[0] . '</label>'; 
		echo $html;
	}
	
	public function callback_hrm_zocdoc_transition_speed ( $options ){
		$selected = get_option( 'hrm_zocdoc_review_speed' );
		$speeds = array(
			'slow' => 'Slow',
			'normal' => 'Normal',
			'fast' => 'Fast'
		);
		$html = '<select class="hrm_zocdoc_review_speed" name="hrm_zocdoc_review_speed">';
		foreach($speeds as $speed => $speed_display){
			$html .= '<option value="' . $speed . '" name="' . $speed . '" ';
			if($speed == $selected){
				$html .= 'selected="selected"';
			}
			$html .= '>' . $speed_display . '</option>';
		}
		$html .= '</selected>';
		$html .= '<label for="hrm_zocdoc_review_speed"> '  . $options[0] . '</label>'; 
		echo $html;
	}
	
	public function callback_hrm_zocdoc_show_control ( $options ){
		$html = '<input type="checkbox" id="hrm_zocdoc_review_show_control" name="hrm_zocdoc_review_show_control" value="1" ' . checked(1, get_option('hrm_zocdoc_review_show_control'), false) . '/>'; 
		$html .= '<label for="hrm_zocdoc_review_show_control"> '  . $options[0] . '</label>'; 
		echo $html;
	}
	
	public function callback_hrm_zocdoc_pause_on_hover ( $options ){
		$html = '<input type="checkbox" id="hrm_zocdoc_review_pause_on_hover" name="hrm_zocdoc_review_pause_on_hover" value="1" ' . checked(1, get_option('hrm_zocdoc_review_pause_on_hover'), false) . '/>'; 
		$html .= '<label for="hrm_zocdoc_review_pause_on_hover"> '  . $options[0] . '</label>'; 
		echo $html;
	}
	
	function callback_hrm_allow_shortcode_in_text_widget ( $options ){
		$html = '<input type="checkbox" id="hrm_zocdoc_shortcode_text_widget" name="hrm_zocdoc_shortcode_text_widget" value="1" ' . checked(1, get_option('hrm_zocdoc_shortcode_text_widget'), false) . '/>'; 
		 
		$html .= '<label for="hrm_zocdoc_shortcode_text_widget"> '  . $options[0] . '</label>'; 
		 
		echo $html;
	}
	
	//Sanitization
	public function sanitize_text_input( $input ) {
		return sanitize_text_field( $input );
	}
	
	public function sanitize_number_input( $input ) {
		if ( !empty( $input ) ){
			$input = sanitize_text_field( $input );
			$input = intval( $input );
			if ( $input < 0 ) {
				$input = $input * -1;
			}
		} 	
		return $input;
	}
	
	public function sanitize_url_input( $input, $allowed_protocols = array( 'http', 'https' ) ) {
		return esc_url_raw( sanitize_text_field( rawurldecode( $input ) ), $allowed_protocols );
	}
}
