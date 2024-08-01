<?php
// pop ups
function ddprodm_pop_ups_template($archive_template) {
    global $post;
    wp_reset_query();  // Restore global post data stomped by the_post()
    if (get_option('ddpdm_pop_up_template') === 'disabled' && get_theme_mod('ddpdm_pop_up_disable_clicks', true)) { }
    else {
        $archive_template = WP_PLUGIN_DIR.'/ddprodm/include/diana/templates/diana-pop-ups.php';
        include_once($archive_template);

        wp_enqueue_script('ddpdm-diana-cookies-js', WP_PLUGIN_URL.'/ddprodm/build/diana/js/diana-jquery.cookie.js');

        wp_enqueue_script('ddpdm-diana-pop-up-js', WP_PLUGIN_URL.'/ddprodm/build/diana/js/dianaPopups.js');
        $ddpdm_dataToBePassed = array(
            'ddpdm_pop_template'  => get_option('ddpdm_pop_up_template'),
            'ddpdm_pop_show_load' => get_theme_mod('ddpdm_pop_up_show_load', false),
            'ddpdm_pop_delay'  => get_option('ddpdm_pop_up_delay'),
            'ddpdm_pop_show_leave'  => get_theme_mod('ddpdm_pop_up_show_leave', false),
            'ddpdm_pop_show_scroll'  => get_theme_mod('ddpdm_pop_up_show_scroll', false),
            'ddpdm_pop_scroll_per' => get_option('ddpdm_pop_up_scroll_per'),
            'ddpdm_sticky_delay'  => get_option('ddpdm_sticky_bar_delay'),
            'ddpdm_sticky_cookie_days'  => get_option('ddpdm_sticky_bar_cookie_days'),
            'ddpdm_sticky_show_leave'  => get_theme_mod('ddpdm_sticky_show_leave', false),
            'ddpdm_sticky_bar_position' => get_option('ddpdm_sticky_bar_sticky'),
            'ddpdm_sticky_show_scroll'  => get_theme_mod('ddpdm_sticky_show_scroll', false),
            'ddpdm_sticky_bar_scroll_per' => get_option('ddpdm_sticky_bar_scroll_per'),
        );
      //  print_r($ddpdm_dataToBePassed);
        wp_localize_script( 'ddpdm-diana-pop-up-js', 'ddpdm_php_vars', $ddpdm_dataToBePassed);

        if(!get_theme_mod('ddpdm_pop_up_disable_clicks', true)) { // on click is enabled

            wp_enqueue_style('ddpdm-diana-pop-up-css', WP_PLUGIN_URL.'/ddprodm/build/diana/css/diana-overlays-popups.css');

           if(ddpdm_is_divi_item_exists('Kingly Form Pop-Up - PHP Templ - Diana')) wp_enqueue_style('ddpdm-diana-pop-up6-css', WP_PLUGIN_URL.'/ddprodm/build/diana/css/diana-overlays-popups6.css');

           if(ddpdm_is_divi_item_exists('Renowned Pricing Pop-Up - PHP Templ - Diana')) wp_enqueue_style('ddpdm-diana-pop-up8-css', WP_PLUGIN_URL.'/ddprodm/build/diana/css/diana-overlays-popups8.css');

           if(ddpdm_is_divi_item_exists('Great Portfolio Pop-Up - PHP Templ - Diana')) wp_enqueue_style('ddpdm-diana-pop-up7-css', WP_PLUGIN_URL.'/ddprodm/build/diana/css/diana-overlays-popups7.css');

            if(ddpdm_is_divi_item_exists('Striking Search Pop-Up - PHP Templ - Diana')) wp_enqueue_style('ddpdm-diana-pop-up5-css', WP_PLUGIN_URL.'/ddprodm/build/diana/css/diana-overlays-popups5.css');

            if(ddpdm_is_divi_item_exists('Prominent Search Pop-Up - PHP Templ - Diana')) wp_enqueue_style('ddpdm-diana-pop-up4-css', WP_PLUGIN_URL.'/ddprodm/build/diana/css/diana-overlays-popups4.css');

            if(ddpdm_is_divi_item_exists('Special Search Pop-Up - PHP Templ - Diana')) wp_enqueue_style('ddpdm-diana-pop-up3-css', WP_PLUGIN_URL.'/ddprodm/build/diana/css/diana-overlays-popups3.css');

            if(ddpdm_is_divi_item_exists('Salient Search Pop-Up - PHP Templ - Diana')) wp_enqueue_style('ddpdm-diana-pop-up2-css', WP_PLUGIN_URL.'/ddprodm/build/diana/css/diana-overlays-popups2.css');

            for ($i = 1; $i < 18 ; $i++) {
                if(ddpdm_is_divi_item_exists('Pop-Up V'.$i.' - PHP Templ - Ragnar')) {
                    wp_enqueue_script('ddpdm-ragnar-pop-up'.$i.'-js', WP_PLUGIN_URL.'/ddprodm/build/ragnar/js/ragnar-popups/ragnarPopupsV'.$i.'.js');
                    wp_enqueue_style('ddpdm-ragnar-pop-up'.$i.'-css', WP_PLUGIN_URL.'/ddprodm/build/ragnar/css/ragnar-popups/ragnar-popups-v'.$i.'.css');
                }

            }
        }
        else {
            wp_enqueue_style('ddpdm-diana-pop-up-css', WP_PLUGIN_URL.'/ddprodm/build/diana/css/diana-overlays-popups.css');

            if (get_option('ddpdm_pop_up_template') === 'diana_1') wp_enqueue_style('ddpdm-diana-pop-up6-css', WP_PLUGIN_URL.'/ddprodm/build/diana/css/diana-overlays-popups6.css');
            if (get_option('ddpdm_pop_up_template') === 'diana_2') wp_enqueue_style('ddpdm-diana-pop-up8-css', WP_PLUGIN_URL.'/ddprodm/build/diana/css/diana-overlays-popups8.css');
            if (get_option('ddpdm_pop_up_template') === 'diana_3') wp_enqueue_style('ddpdm-diana-pop-up7-css', WP_PLUGIN_URL.'/ddprodm/build/diana/css/diana-overlays-popups7.css');
            if (get_option('ddpdm_pop_up_template') === 'diana_4') wp_enqueue_style('ddpdm-diana-pop-up5-css', WP_PLUGIN_URL.'/ddprodm/build/diana/css/diana-overlays-popups5.css');
            if (get_option('ddpdm_pop_up_template') === 'diana_5') wp_enqueue_style('ddpdm-diana-pop-up4-css', WP_PLUGIN_URL.'/ddprodm/build/diana/css/diana-overlays-popups4.css');
            if (get_option('ddpdm_pop_up_template') === 'diana_6') wp_enqueue_style('ddpdm-diana-pop-up3-css', WP_PLUGIN_URL.'/ddprodm/build/diana/css/diana-overlays-popups3.css');
            if (get_option('ddpdm_pop_up_template') === 'diana_7') wp_enqueue_style('ddpdm-diana-pop-up2-css', WP_PLUGIN_URL.'/ddprodm/build/diana/css/diana-overlays-popups2.css');

            for ($i = 1; $i < 18 ; $i++) {
                if (get_option('ddpdm_pop_up_template') === 'ragnar_'.$i) {
                    wp_enqueue_script('ddpdm-ragnar-pop-up'.$i.'-js', WP_PLUGIN_URL.'/ddprodm/build/ragnar/js/ragnar-popups/ragnarPopupsV'.$i.'.js');
                    wp_enqueue_style('ddpdm-ragnar-pop-up'.$i.'-css', WP_PLUGIN_URL.'/ddprodm/build/ragnar/css/ragnar-popups/ragnar-popups-v'.$i.'.css');
                }
            }

        }


   } //else
} //function ddprodm_pop_ups_template($archive_template)

add_action('wp_footer', 'ddprodm_pop_ups_template');