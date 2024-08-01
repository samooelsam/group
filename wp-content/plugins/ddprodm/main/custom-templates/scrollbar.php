<?php
// scrollbar
function ddprodm_scrollbar_template() {

	//echo "SCROLLBAR ".get_theme_mod('ddpdm_scrollbar', false);

    if (get_theme_mod('ddpdm_scrollbar', false) == 1 ) {

        // wp_enqueue_style('ddpdm-scrollbar-overlay-scrollbars-css', WP_PLUGIN_URL.'/ddprodm/css/OverlayScrollbars.css');
        // wp_enqueue_script('ddpdm-scrollbar-overlay-scrollbars-js', WP_PLUGIN_URL.'/ddprodm/js/jquery.overlayScrollbars.min.js');
        // wp_enqueue_script('ddpdm-scrollbar-js', WP_PLUGIN_URL.'/ddprodm/js/ddpdm-scrollbar.js');


    } // if (get_theme_mod('ddpdm_scrollbar', false) == 1

} //function ddproscrollbar_template

add_action('wp_footer', 'ddprodm_scrollbar_template');