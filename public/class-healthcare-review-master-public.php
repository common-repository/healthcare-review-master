<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://caniwordpress.com/healthcare-review/
 * @since      1.0.0
 *
 * @package    Healthcare_Review_Master
 * @subpackage Healthcare_Review_Master/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Healthcare_Review_Master
 * @subpackage Healthcare_Review_Master/public
 * @author     iCanWP Team, Sean Roh, Chris Couweleers
 */
class Healthcare_Review_Master_Public {

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
	 * @param      string    $healthcare_review_master       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $healthcare_review_master, $version ) {

		$this->plugin_name = $healthcare_review_master;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
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

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/healthcare-review-master-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
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
		wp_enqueue_script( $this->plugin_name . '-public-js', plugin_dir_url( __FILE__ ) . 'js/healthcare-review-master-public.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_script( $this->plugin_name . '-easy-ticker-js', plugin_dir_url( __FILE__ ) . 'js/jquery.easy-ticker.min.js', array( 'jquery', 'jquery-effects-core' ), $this->version, false );
		$hrm_loc = array(
			'hrm_num_show_zocdoc_review' => get_option( 'hrm_num_show_zocdoc_review' ),
			'hrm_zocdoc_review_interval' => get_option( 'hrm_zocdoc_review_interval' ),
			'hrm_zocdoc_review_speed' => get_option( 'hrm_zocdoc_review_speed' ),
			'hrm_zocdoc_review_pause_on_hover' => get_option( 'hrm_zocdoc_review_pause_on_hover' )
		);
		wp_localize_script( $this->plugin_name . '-public-js', 'hrm_loc', $hrm_loc );
	}
	
	public function hrm_register_shortcode(){
		add_shortcode( 'show-reviews', array( $this, 'hrm_public_display'));
	}
	
	public function hrm_public_display(){
		$zocdoc_url = get_option( 'hrm_url_zocdoc_review' );
		$zocdoc = file_get_html( $zocdoc_url );
		if ( empty( $zocdoc_url) ){
			$html = '<h2>Please specify the specific ZocDoc review page URL.</h2>';
			return $html;
		} elseif ( empty( $zocdoc ) ) {
			$html = '<h2>Can not find ZocDoc Review.</h2>';
			return $html;
		}
		
		$asset_dir = plugin_dir_url( __FILE__ ) . 'assets/';
		
		$html = '
		<div class="hrm_zocdoc_container">
			<h3 class="hrm_zocdoc_head"><a href="'. $zocdoc_url .'" target="_blank">ZocDoc Reviews</a></h3>';
		if( intval( get_option( 'hrm_zocdoc_review_show_control' ) ) === 1 ){
			$html .= '
			<div class="hrm_zocdoc_control">
				<button class="hrm_zocdoc_up">Up</button>
				<button class="hrm_zocdoc_down">Down</button>
				<button class="hrm_zocdoc_toggle">Stop/Play</button>
			</div>';
		}
		$html .= '	<div class="hrm_review_display">
						<ul class="hrm_review_list">';
					
		foreach( $zocdoc->find( 'div.reviewsMain' ) as $review ){
			$rating_overall = $review->find('div.rec',0)->innertext;
			$star_overall = substr( $rating_overall, strpos( $rating_overall, 'sg-rating-') + 10, 3 );
			$rating_manner = $review->find('div.bedman',0)->innertext;
			$star_manner = substr( $rating_manner, strpos( $rating_manner, 'sg-rating-') + 10, 3 );
			$rating_wait = $review->find('div.waittime',0)->innertext;
			$star_wait = substr( $rating_wait, strpos( $rating_wait, 'sg-rating-') + 10, 3 );
			$when = $review->find('span[itemprop="datePublished"]',0)->innertext;
			$who = $review->find('span[itemprop="author"]',0)->innertext;
			$detail = $review->find('p[itemprop="reviewBody"]',0)->innertext;
			
			$html .= '
				<li class="hrm_review_list_item">
					<div class="hrm_review_container">
						<p class="hrm_review_detail_head"><span class="hrm_review_detail_when">' . $when . '</span> <span class="hrm_review_detail_who">' . $who .  '</span></p>
						<div class="hrm_review_ratings">
							<div class="hrm_review_ratings_overall">
								<span class="hrm_review_ratings_title">Overall Rating</span>
								<img src="' . $asset_dir . $star_overall . '.png" class="hrm_review_ratings_stars" alt="Overall Rating" />
							</div>
							<div class="hrm_review_ratings_bedside">
								<span class="hrm_review_ratings_title">Bedside Manner</span>
								<img src="' . $asset_dir . $star_manner . '.png" class="hrm_review_ratings_stars" alt="Overall Rating" />
							</div>
							<div class="hrm_review_ratings_wait">
								<span class="hrm_review_ratings_title">Wait Time</span>
								<img src="' . $asset_dir . $star_wait . '.png" class="hrm_review_ratings_stars" alt="Overall Rating" />
							</div>
						</div>
						<p class="hrm_review_detail_body">' . $detail . '</p>
					</div>
				</li>
			';
			
		}
		$html .= '</ul></div></div>';
		
		return $html;
	}
	
}
