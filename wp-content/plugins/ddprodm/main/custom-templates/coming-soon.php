<?php
function ddpdm_register_coming_soon_template_css() {
    if(get_option('ddpdm_coming_soon_template') === 'diana_1')  {
        wp_enqueue_style('ddpdm-diana1-coming-soon-css', WP_PLUGIN_URL.'/ddprodm/build/diana/css/diana-coming-soon-page1.css');
    }

    if(get_option('ddpdm_coming_soon_template') === 'diana_2')  {
        wp_enqueue_style('ddpdm-diana2-coming-soon-css', WP_PLUGIN_URL.'/ddprodm/build/diana/css/diana-coming-soon-page2.css');
    }

    for ($i = 1; $i < 10 ; $i++) {
        if (get_option('ddpdm_coming_soon_template') === 'ragnar_'.$i) {
            wp_enqueue_style('ddpdm-ragnar-coming-soon'.$i.'-css', WP_PLUGIN_URL.'/ddprodm/build/ragnar/css/ragnar-coming-soon/ragnar-coming-soon-'.$i.'.css');
        }
    }
}

add_action('wp_footer', 'ddpdm_register_coming_soon_template_css');
add_action('et_fb_enqueue_assets', 'ddpdm_register_coming_soon_template_css', 1);


function ddpdm_coming_soon($archive_template ){
    global $post;
    $archive_template = WP_PLUGIN_DIR.'/ddprodm/include/diana/templates/diana-coming-soon-template.php';
    return $archive_template;
}
//add_filter( 'template_include', 'ddpdm_coming_soon' );

function ddpdm_coming_soon_main() {
if(get_option('ddpdm_coming_soon_template') !== 'disabled') {
    if(!current_user_can('edit_themes') || !is_user_logged_in() || is_customize_preview()) add_filter( 'template_include', 'ddpdm_coming_soon' );
    }
}


add_action('wp', 'ddpdm_coming_soon_main');