<?php 

/*
 * Plugin Name:  Techvertu Video Fetcher
 * Plugin URI: https://techvertu.co.uk/
 * Description: A plugin for fetching videos from a channel on youtube.
 * Version: 1.0
 * Author: Saman Tohidian
 * Author URI: https://techvertu.co.uk
 * Text Domain: tech-fetcher
 * Domain Path: /languages/
 *
 */

define('TECH_FETCHER_DIR', plugin_dir_path(__FILE__));
define('TECH_FETCHER_URL', plugin_dir_url(__FILE__));
define('TECH_FETCHER_API_KEY', 'AIzaSyBXfYeHDlgOgRJXyiRVQ8Vd2q7BxSeLtQg');
define('TECH_FETCHER_JFHG_CHANNEL_ID', 'UCOWyyn0YcmWp-njZ30eC9Hg');
define('TECH_FETCHER_JFHREGEN_CHANNEL_ID', 'UCkmFUaiymdLYs0Op-pkc3ww');
define('TECH_FETCHER_BASE_URL', 'https://www.googleapis.com/youtube/v3/search');
define('TECH_FETCHER_MAXRESULTS', '15');
define('TECH_FETCHER_JFHG_TRANSIENT_NAME', 'youtube_page_1' . get_the_ID());
define('TECH_FETCHER_REGEN_TRANSIENT_NAME', 'regen_youtube_1' . get_the_ID());

require_once(TECH_FETCHER_DIR.'includes/functions.php');

add_action('plugins_loaded', 'techvertu_fetcher_textdomain');
function techvertu_fetcher_textdomain() {
	load_plugin_textdomain( 'tech-fetcher', false, dirname( plugin_basename(__FILE__) ) . '/languages/' );
}

// Register a new shortcode: [techvertu_youtube_video_fetcher]
add_shortcode( 'techvertu_youtube_video_fetcher', 'techvertu_fetcher_shortcode' );

function techvertu_fetcher_shortcode() {
    ob_start();
    techvertu_youtube_api_call(TECH_FETCHER_JFHG_TRANSIENT_NAME, TECH_FETCHER_JFHG_CHANNEL_ID, TECH_FETCHER_MAXRESULTS, TECH_FETCHER_API_KEY, TECH_FETCHER_BASE_URL, 'John F Hunt Group');
    return ob_get_clean();
}

// Register a new shortcode: [techvertu_regen_fetcher]
add_shortcode( 'techvertu_regen_fetcher', 'techvertu_regen_fetcher_shortcode' );

function techvertu_regen_fetcher_shortcode() {
    ob_start();
    techvertu_youtube_api_call(TECH_FETCHER_REGEN_TRANSIENT_NAME, TECH_FETCHER_JFHREGEN_CHANNEL_ID, TECH_FETCHER_MAXRESULTS, TECH_FETCHER_API_KEY, TECH_FETCHER_BASE_URL, 'John F Hunt Regeneration');
    return ob_get_clean();
}
