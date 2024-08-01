<?php // 404 page

function ddprodm_custom_404_template( $archive_template ) {
    if(get_option('ddpdm_404_page_template') !== 'disabled') $archive_template = WP_PLUGIN_DIR.'/ddprodm/include/diana/templates/diana-404-template.php';
    return $archive_template;
}

add_filter( '404_template', 'ddprodm_custom_404_template' );

function ddpdm_register_404_template_css() {
    if(is_404()) {
        if(get_option('ddpdm_404_page_template') === 'diana_1') {
            wp_enqueue_style('ddpdm-diana-404-page-1', WP_PLUGIN_URL.'/ddprodm/build/diana/css/diana-404-page1.css');
        }
        if(get_option('ddpdm_404_page_template') === 'diana_2') {
            wp_enqueue_style('ddpdm-diana-404-page-2', WP_PLUGIN_URL.'/ddprodm/build/diana/css/diana-404-page3.css');
        }
        if(get_option('ddpdm_404_page_template') === 'diana_3') {
            wp_enqueue_style('ddpdm-diana-404-page-3', WP_PLUGIN_URL.'/ddprodm/build/diana/css/diana-404-page2.css');
        }
    } // if(is_404())
}

add_action('wp_footer', 'ddpdm_register_404_template_css');
add_action('et_fb_enqueue_assets', 'ddpdm_register_404_template_css', 1);