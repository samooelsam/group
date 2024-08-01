<?php

// menu
function ddprodm_custom_menu_template( $archive_template ) {
    global $post;
    wp_reset_query();  // Restore global post data stomped by the_post()

    if (get_option('ddpdm_menu_template') === 'diana_1' && get_option('ddpdm_coming_soon_template') === 'disabled') {
        $archive_template = WP_PLUGIN_DIR.'/ddprodm/include/diana/templates/diana-menu.php';
        include($archive_template);
        wp_enqueue_style('ddpdm-diana-menu1-css', WP_PLUGIN_URL.'/ddprodm/build/diana/css/diana-menu1-styles.css');
        wp_enqueue_script('ddpdm-diana-menu1-js', WP_PLUGIN_URL.'/ddprodm/build/diana/js/diana-menu.js');
    }

    if (get_option('ddpdm_menu_template') === 'diana_2' && get_option('ddpdm_coming_soon_template') === 'disabled') {
        $archive_template = WP_PLUGIN_DIR.'/ddprodm/include/diana/templates/diana-menu.php';
        include($archive_template);
        wp_enqueue_style('ddpdm-diana-menu2-css', WP_PLUGIN_URL.'/ddprodm/build/diana/css/diana-menu2-styles.css');
        wp_enqueue_script('ddpdm-diana-menu2-js', WP_PLUGIN_URL.'/ddprodm/build/diana/js/diana-menu-2.js');
    }

    if (get_option('ddpdm_menu_template') === 'diana_3' && get_option('ddpdm_coming_soon_template') === 'disabled') {
        $archive_template = WP_PLUGIN_DIR.'/ddprodm/include/diana/templates/diana-menu.php';
        include($archive_template);
        wp_enqueue_style('ddpdm-diana-menu3-css', WP_PLUGIN_URL.'/ddprodm/build/diana/css/diana-menu3-styles.css');
        wp_enqueue_script('ddpdm-diana-menu3-js', WP_PLUGIN_URL.'/ddprodm/build/diana/js/diana-menu-3.js');
    }

     if (strpos(get_option('ddpdm_menu_template'), 'custom') !== false && get_option('ddpdm_coming_soon_template') === 'disabled') {
        $archive_template = WP_PLUGIN_DIR.'/ddprodm/include/diana/templates/diana-menu.php';
        include($archive_template);
        wp_enqueue_style('ddpdm-diana-menu-css', WP_PLUGIN_URL.'/ddprodm/build/diana/css/diana-menu-styles.css');
        wp_enqueue_script('ddpdm-diana-menu-js', WP_PLUGIN_URL.'/ddprodm/build/diana/js/diana-menu-global.js');
    }

    if (get_option('ddpdm_menu_template') === 'diana_4' && get_option('ddpdm_coming_soon_template') === 'disabled') {
        $archive_template = WP_PLUGIN_DIR.'/ddprodm/include/diana/templates/diana-menu.php';
        include($archive_template);
        wp_enqueue_style('ddpdm-diana-arch-menu-css', WP_PLUGIN_URL.'/ddprodm/build/diana/css/diana-nav-menu-arch.css');
        wp_enqueue_script('ddpdm-diana-arch-menu-js', WP_PLUGIN_URL.'/ddprodm/build/diana/js/dianaNavMenuArch.js');
    }

     if (get_option('ddpdm_menu_template') === 'diana_5' && get_option('ddpdm_coming_soon_template') === 'disabled') {
        $archive_template = WP_PLUGIN_DIR.'/ddprodm/include/diana/templates/diana-menu.php';
        include($archive_template);
        wp_enqueue_style('ddpdm-diana-first-menu-css', WP_PLUGIN_URL.'/ddprodm/build/diana/css/diana-nav-menu-first.css');
        wp_enqueue_script('ddpdm-diana-first-menu-js', WP_PLUGIN_URL.'/ddprodm/build/diana/js/dianaNavMenuFirst.js');
    }

     if (get_option('ddpdm_menu_template') === 'diana_6' && get_option('ddpdm_coming_soon_template') === 'disabled') {
        $archive_template = WP_PLUGIN_DIR.'/ddprodm/include/diana/templates/diana-menu.php';
        include($archive_template);
        wp_enqueue_style('ddpdm-diana-champion-menu-css', WP_PLUGIN_URL.'/ddprodm/build/diana/css/diana-nav-menu-champion.css');
        wp_enqueue_script('ddpdm-diana-champion-menu-js', WP_PLUGIN_URL.'/ddprodm/build/diana/js/dianaNavMenuChampion.js');
    }

     if (get_option('ddpdm_menu_template') === 'diana_7' && get_option('ddpdm_coming_soon_template') === 'disabled') {
        $archive_template = WP_PLUGIN_DIR.'/ddprodm/include/diana/templates/diana-menu.php';
        include($archive_template);
        wp_enqueue_style('ddpdm-diana-front-menu-css', WP_PLUGIN_URL.'/ddprodm/build/diana/css/diana-nav-menu-front.css');
        wp_enqueue_script('ddpdm-diana-front-menu-js', WP_PLUGIN_URL.'/ddprodm/build/diana/js/dianaNavMenuFront.js');
    }

     if (get_option('ddpdm_menu_template') === 'diana_8' && get_option('ddpdm_coming_soon_template') === 'disabled') {
        $archive_template = WP_PLUGIN_DIR.'/ddprodm/include/diana/templates/diana-menu.php';
        include($archive_template);
        wp_enqueue_style('ddpdm-diana-leading-menu-css', WP_PLUGIN_URL.'/ddprodm/build/diana/css/diana-nav-menu-leading.css');
        wp_enqueue_script('ddpdm-diana-leading-menu-js', WP_PLUGIN_URL.'/ddprodm/build/diana/js/dianaNavMenuLeading.js');
    }
     if (get_option('ddpdm_menu_template') === 'diana_9' && get_option('ddpdm_coming_soon_template') === 'disabled') {
        $archive_template = WP_PLUGIN_DIR.'/ddprodm/include/diana/templates/diana-menu.php';
        include($archive_template);
        wp_enqueue_style('ddpdm-diana-main-menu-css', WP_PLUGIN_URL.'/ddprodm/build/diana/css/diana-nav-menu-main.css');
        wp_enqueue_script('ddpdm-diana-main-menu-js', WP_PLUGIN_URL.'/ddprodm/build/diana/js/dianaNavMenuMain.js');
    }
     if (get_option('ddpdm_menu_template') === 'diana_10' && get_option('ddpdm_coming_soon_template') === 'disabled') {
        $archive_template = WP_PLUGIN_DIR.'/ddprodm/include/diana/templates/diana-menu.php';
        include($archive_template);
        wp_enqueue_style('ddpdm-diana-pioneer-menu-css', WP_PLUGIN_URL.'/ddprodm/build/diana/css/diana-nav-menu-pioneer.css');
        wp_enqueue_script('ddpdm-diana-pioneer-menu-js', WP_PLUGIN_URL.'/ddprodm/build/diana/js/dianaNavMenuPioneer.js');
    }
     if (get_option('ddpdm_menu_template') === 'diana_11' && get_option('ddpdm_coming_soon_template') === 'disabled') {
        $archive_template = WP_PLUGIN_DIR.'/ddprodm/include/diana/templates/diana-menu.php';
        include($archive_template);
        wp_enqueue_style('ddpdm-diana-primer-menu-css', WP_PLUGIN_URL.'/ddprodm/build/diana/css/diana-nav-menu-premier.css');
        wp_enqueue_script('ddpdm-diana-primer-menu-js', WP_PLUGIN_URL.'/ddprodm/build/diana/js/dianaNavMenuPremier.js');
    }
     if (get_option('ddpdm_menu_template') === 'diana_12' && get_option('ddpdm_coming_soon_template') === 'disabled') {
        $archive_template = WP_PLUGIN_DIR.'/ddprodm/include/diana/templates/diana-menu.php';
        include($archive_template);
        wp_enqueue_style('ddpdm-diana-prime-menu-css', WP_PLUGIN_URL.'/ddprodm/build/diana/css/diana-nav-menu-prime.css');
        wp_enqueue_script('ddpdm-diana-prime-menu-js', WP_PLUGIN_URL.'/ddprodm/build/diana/js/dianaNavMenuPrime.js');
    }
     if (get_option('ddpdm_menu_template') === 'diana_13' && get_option('ddpdm_coming_soon_template') === 'disabled') {
        $archive_template = WP_PLUGIN_DIR.'/ddprodm/include/diana/templates/diana-menu.php';
        include($archive_template);
        wp_enqueue_style('ddpdm-diana-principal-menu-css', WP_PLUGIN_URL.'/ddprodm/build/diana/css/diana-nav-menu-principal.css');
        wp_enqueue_script('ddpdm-diana-principal-menu-js', WP_PLUGIN_URL.'/ddprodm/build/diana/js/dianaNavMenuPrincipal.js');
    }
     if (get_option('ddpdm_menu_template') === 'diana_14' && get_option('ddpdm_coming_soon_template') === 'disabled') {
        $archive_template = WP_PLUGIN_DIR.'/ddprodm/include/diana/templates/diana-menu.php';
        include($archive_template);
        wp_enqueue_style('ddpdm-diana-stellar-menu-css', WP_PLUGIN_URL.'/ddprodm/build/diana/css/diana-nav-menu-stellar.css');
        wp_enqueue_script('ddpdm-diana-stellar-menu-js', WP_PLUGIN_URL.'/ddprodm/build/diana/js/dianaNavMenuStellar.js');
    }
    if (get_option('ddpdm_menu_template') === 'freddie_1' && get_option('ddpdm_coming_soon_template') === 'disabled') {
        $archive_template = WP_PLUGIN_DIR.'/ddprodm/include/diana/templates/diana-menu.php';
        include($archive_template);
        wp_enqueue_style('ddpdm-freddie-menu-prize', WP_PLUGIN_URL.'/ddprodm/build/freddie/css/freddie-menu-prize-menu.css');

        wp_enqueue_script('ddpdm-freddie-gsap-split-text-js', WP_PLUGIN_URL.'/ddprodm/build/freddie/js/gsap/gsap.min.js');
        wp_enqueue_script('ddpdm-freddie-menu-prize-js', WP_PLUGIN_URL.'/ddprodm/build/freddie/js/freddieScriptPrizeMenu.js');
    }

    if (get_option('ddpdm_menu_template') === 'freddie_2' && get_option('ddpdm_coming_soon_template') === 'disabled') {
        $archive_template = WP_PLUGIN_DIR.'/ddprodm/include/diana/templates/diana-menu.php';
        include($archive_template);
        wp_enqueue_style('ddpdm-freddie-menu-attac-dragon', WP_PLUGIN_URL.'/ddprodm/build/freddie/css/freddie-menu-dragon-attack.css');

        wp_enqueue_script('ddpdm-freddie-gsap-split-text-js', WP_PLUGIN_URL.'/ddprodm/build/freddie/js/gsap/gsap.min.js');
        wp_enqueue_script('ddpdm-freddie-menu-attac-dragon-js', WP_PLUGIN_URL.'/ddprodm/build/freddie/js/freddieScriptAttackDragonMenu.js');
    }

    if (get_option('ddpdm_menu_template') === 'freddie_3' && get_option('ddpdm_coming_soon_template') === 'disabled') {
        $archive_template = WP_PLUGIN_DIR.'/ddprodm/include/diana/templates/diana-menu.php';
        include($archive_template);
        wp_enqueue_style('ddpdm-freddie-menu-earth', WP_PLUGIN_URL.'/ddprodm/build/freddie/css/freddie-menu-earth.css');

        wp_enqueue_script('ddpdm-freddie-gsap-split-text-js', WP_PLUGIN_URL.'/ddprodm/build/freddie/js/gsap/gsap.min.js');
        wp_enqueue_script('ddpdm-freddie-menu-earth-js', WP_PLUGIN_URL.'/ddprodm/build/freddie/js/freddieScriptEarthMenu.js');
    }

    if (get_option('ddpdm_menu_template') === 'freddie_4' && get_option('ddpdm_coming_soon_template') === 'disabled') {
        $archive_template = WP_PLUGIN_DIR.'/ddprodm/include/diana/templates/diana-menu.php';
        include($archive_template);
        wp_enqueue_style('ddpdm-freddie-menu-funny-how-love', WP_PLUGIN_URL.'/ddprodm/build/freddie/css/freddie-menu-funny-how-love.css');

        wp_enqueue_script('ddpdm-freddie-gsap-split-text-js', WP_PLUGIN_URL.'/ddprodm/build/freddie/js/gsap/gsap.min.js');
        wp_enqueue_script('ddpdm-freddie-menu-funny-how-love-js', WP_PLUGIN_URL.'/ddprodm/build/freddie/js/freddieScriptFunnyHowLoveMenu.js');
    }

    if (get_option('ddpdm_menu_template') === 'freddie_5' && get_option('ddpdm_coming_soon_template') === 'disabled') {
        $archive_template = WP_PLUGIN_DIR.'/ddprodm/include/diana/templates/diana-menu.php';
        include($archive_template);
        wp_enqueue_style('ddpdm-freddie-menu-hang-on-in-there', WP_PLUGIN_URL.'/ddprodm/build/freddie/css/freddie-menu-hang-on-in-there.css');

        wp_enqueue_script('ddpdm-freddie-gsap-split-text-js', WP_PLUGIN_URL.'/ddprodm/build/freddie/js/gsap/gsap.min.js');
        wp_enqueue_script('ddpdm-freddie-menu-hang-on-in-there-js', WP_PLUGIN_URL.'/ddprodm/build/freddie/js/freddieScriptHangOnInThereMenu.js');
    }

    if (get_option('ddpdm_menu_template') === 'freddie_6' && get_option('ddpdm_coming_soon_template') === 'disabled') {
        $archive_template = WP_PLUGIN_DIR.'/ddprodm/include/diana/templates/diana-menu.php';
        include($archive_template);
        wp_enqueue_style('ddpdm-freddie-menu-lover-boy', WP_PLUGIN_URL.'/ddprodm/build/freddie/css/freddie-menu-lover-boy.css');

        wp_enqueue_script('ddpdm-freddie-gsap-split-text-js', WP_PLUGIN_URL.'/ddprodm/build/freddie/js/gsap/gsap.min.js');
        wp_enqueue_script('ddpdm-freddie-menu-lover-boy-js', WP_PLUGIN_URL.'/ddprodm/build/freddie/js/freddieScriptLoverBoyMenu.js');
    }

    if (get_option('ddpdm_menu_template') === 'freddie_7' && get_option('ddpdm_coming_soon_template') === 'disabled') {
        $archive_template = WP_PLUGIN_DIR.'/ddprodm/include/diana/templates/diana-menu.php';
        include($archive_template);
        wp_enqueue_style('ddpdm-freddie-hijack-my-heart', WP_PLUGIN_URL.'/ddprodm/build/freddie/css/freddie-hijack-my-heart.css');

        wp_enqueue_script('ddpdm-freddie-gsap-split-text-js', WP_PLUGIN_URL.'/ddprodm/build/freddie/js/gsap/gsap.min.js');
        wp_enqueue_script('ddpdm-freddie-menu-lover-boy-js', WP_PLUGIN_URL.'/ddprodm/build/freddie/js/freddieHijackMyHeart.js');
    }
}

add_action('wp_footer', 'ddprodm_custom_menu_template');