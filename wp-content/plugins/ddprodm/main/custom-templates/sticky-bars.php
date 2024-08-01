<?php // sticky bars
function ddprodm_sticky_bars_template($archive_template) {
    global $post;
    wp_reset_query();  // Restore global post data stomped by the_post()

    if (strpos(get_option('ddpdm_sticky_bar_template'), 'diana') !== false && get_option('ddpdm_coming_soon_template') === 'disabled') {
        $archive_template = WP_PLUGIN_DIR.'/ddprodm/include/diana/templates/diana-sticky-bars.php';
        include($archive_template);

        wp_enqueue_script('ddpdm-diana-sticky-bars-cookies-js', WP_PLUGIN_URL.'/ddprodm/build/diana/js/diana-jquery.cookie.js');

        wp_enqueue_script('ddpdm-diana-sticky-bars-js', WP_PLUGIN_URL.'/ddprodm/build/diana/js/dianaStickyHeaders.js');
        $ddpdm_dataToBePassed = array(
            'ddpdm_sticky_delay'  => get_option('ddpdm_sticky_bar_delay'),
            'ddpdm_sticky_cookie_days'  => get_option('ddpdm_sticky_bar_cookie_days'),
            'ddpdm_sticky_show_leave'  => get_theme_mod('ddpdm_sticky_show_leave', false),
            'ddpdm_sticky_bar_position' => get_option('ddpdm_sticky_bar_sticky'),
            'ddpdm_sticky_show_scroll'  => get_theme_mod('ddpdm_sticky_show_scroll', false),
            'ddpdm_sticky_bar_scroll_per' => get_option('ddpdm_sticky_bar_scroll_per'),
            'ddpdm_pop_template'  => get_option('ddpdm_pop_up_template'),
            'ddpdm_pop_show_load' => get_theme_mod('ddpdm_pop_up_show_load', false),
            'ddpdm_pop_delay'  => get_option('ddpdm_pop_up_delay'),
            'ddpdm_pop_show_leave'  => get_theme_mod('ddpdm_pop_up_show_leave', false),
            'ddpdm_pop_show_scroll'  => get_theme_mod('ddpdm_pop_up_show_scroll', false),
            'ddpdm_pop_scroll_per' => get_option('ddpdm_pop_up_scroll_per'),
        );
        wp_localize_script( 'ddpdm-diana-sticky-bars-js', 'ddpdm_php_vars', $ddpdm_dataToBePassed);

        wp_enqueue_style('ddpdm-diana-sticky-bar-css', WP_PLUGIN_URL.'/ddprodm/build/diana/css/diana-sticky-header.css');

        $diana_sticky_template = get_option('ddpdm_sticky_bar_template');
        $diana_sticky_template_number = str_replace("diana_", "", $diana_sticky_template);

        wp_enqueue_style('ddpdm-diana-sticky-bar'.$diana_sticky_template_number.'-css', WP_PLUGIN_URL.'/ddprodm/build/diana/css/diana-sticky-header'.$diana_sticky_template_number.'.css');

    } //if (strpos(get_option('ddpdm_sticky_bar_template'), 'diana') !== false && get_option('ddpdm_coming_soon_template') === 'disabled')
    if (strpos(get_option('ddpdm_sticky_bar_template'), 'custom') !== false && get_option('ddpdm_coming_soon_template') === 'disabled') {
        $archive_template = WP_PLUGIN_DIR.'/ddprodm/include/diana/templates/diana-sticky-bars.php';
        include($archive_template);

        wp_enqueue_script('ddpdm-diana-sticky-bars-cookies-js', WP_PLUGIN_URL.'/ddprodm/build/diana/js/diana-jquery.cookie.js');

        wp_enqueue_script('ddpdm-diana-sticky-bars-js', WP_PLUGIN_URL.'/ddprodm/build/diana/js/dianaStickyHeaders.js');
        $ddpdm_dataToBePassed = array(
            'ddpdm_sticky_delay'  => get_option('ddpdm_sticky_bar_delay'),
            'ddpdm_sticky_cookie_days'  => get_option('ddpdm_sticky_bar_cookie_days'),
            'ddpdm_sticky_show_leave'  => get_theme_mod('ddpdm_sticky_show_leave', false),
            'ddpdm_sticky_bar_position' => get_option('ddpdm_sticky_bar_sticky'),
            'ddpdm_sticky_show_scroll'  => get_theme_mod('ddpdm_sticky_show_scroll', false),
            'ddpdm_sticky_bar_scroll_per' => get_option('ddpdm_sticky_bar_scroll_per'),
            'ddpdm_pop_template'  => get_option('ddpdm_pop_up_template'),
            'ddpdm_pop_show_load' => get_theme_mod('ddpdm_pop_up_show_load', false),
            'ddpdm_pop_delay'  => get_option('ddpdm_pop_up_delay'),
            'ddpdm_pop_show_leave'  => get_theme_mod('ddpdm_pop_up_show_leave', false),
            'ddpdm_pop_show_scroll'  => get_theme_mod('ddpdm_pop_up_show_scroll', false),
            'ddpdm_pop_scroll_per' => get_option('ddpdm_pop_up_scroll_per'),
        );
        wp_localize_script( 'ddpdm-diana-sticky-bars-js', 'ddpdm_php_vars', $ddpdm_dataToBePassed);

        wp_enqueue_style('ddpdm-diana-sticky-bar-css', WP_PLUGIN_URL.'/ddprodm/build/diana/css/diana-sticky-header.css');
    }
} //function ddprodm_sticky_bars_template($archive_template)

add_action('wp_footer', 'ddprodm_sticky_bars_template');