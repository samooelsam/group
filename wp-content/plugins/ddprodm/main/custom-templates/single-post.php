<?php


// Add single blog post template

function ddprodm_custom_single_post_template( $template ) {
    if(get_option('ddpdm_single_post_template') !== 'disabled') {
        $template = WP_PLUGIN_DIR.'/ddprodm/include/diana/templates/diana-single-blog-post.php';
        wp_enqueue_style('ddpdm-diana-single-post-css', WP_PLUGIN_URL.'/ddprodm/build/diana/css/diana-single-post.css');
        wp_enqueue_script('ddpdm-diana-single-post-js', WP_PLUGIN_URL.'/ddprodm/build/diana/js/dianaSinglePost.js');
    }


    return $template;
}

add_filter( "single_template", "ddprodm_custom_single_post_template" );
