<?php
   if(get_option('ddpdm_menu_template') === 'diana_1') {
    $title_menu = ddpdm_return_new_name('Magnificent Mega Menu - PHP Templ - Diana');
}

    if(get_option('ddpdm_menu_template') === 'diana_2') {
        $title_menu = ddpdm_return_new_name('Stately Mega Menu - PHP Templ - Diana');
    }

     if(get_option('ddpdm_menu_template') === 'diana_3') {
        $title_menu = ddpdm_return_new_name('Grandiose Mega Menu - PHP Templ - Diana');
    }

     if(get_option('ddpdm_menu_template') === 'diana_4') {
        $title_menu = ddpdm_return_new_name('Arch Menu - PHP Templ - Diana');
    }

     if(get_option('ddpdm_menu_template') === 'diana_5') {
        $title_menu = ddpdm_return_new_name('First Menu - PHP Templ - Diana');
    }

    if(get_option('ddpdm_menu_template') === 'diana_6') {
        $title_menu = ddpdm_return_new_name('Champion Menu - PHP Templ - Diana');
    }
     if(get_option('ddpdm_menu_template') === 'diana_7') {
        $title_menu = ddpdm_return_new_name('Front Menu - PHP Templ - Diana');
    }
    if(get_option('ddpdm_menu_template') === 'diana_8') {
        $title_menu = ddpdm_return_new_name('Leading Menu - PHP Templ - Diana');
    }
    if(get_option('ddpdm_menu_template') === 'diana_9') {
        $title_menu = ddpdm_return_new_name('Main Menu - PHP Templ - Diana');
    }
    if(get_option('ddpdm_menu_template') === 'diana_10') {
        $title_menu = ddpdm_return_new_name('Pioneer Menu - PHP Templ - Diana');
    }
    if(get_option('ddpdm_menu_template') === 'diana_11') {
        $title_menu = ddpdm_return_new_name('Premier Menu - PHP Templ - Diana');
    }

     if(get_option('ddpdm_menu_template') === 'diana_12') {
        $title_menu = ddpdm_return_new_name('Prime Menu - PHP Templ - Diana');
    }

    if(get_option('ddpdm_menu_template') === 'diana_13') {
        $title_menu = ddpdm_return_new_name('Principal Menu - PHP Templ - Diana');
    }

    if(get_option('ddpdm_menu_template') === 'diana_14') {
        $title_menu = ddpdm_return_new_name('Stellar Menu - PHP Templ - Diana');
    }

     if(get_option('ddpdm_menu_template') === 'freddie_1') {
        $title_menu = ddpdm_return_new_name('Gimmi the Prize Menu - PHP Templ - Freddie');
    }

     if(get_option('ddpdm_menu_template') === 'freddie_2') {
        $title_menu = ddpdm_return_new_name('Dragon Attack Menu - PHP Templ - Freddie');
    }

     if(get_option('ddpdm_menu_template') === 'freddie_3') {
        $title_menu = ddpdm_return_new_name('Earth Menu - PHP Templ - Freddie');
    }

     if(get_option('ddpdm_menu_template') === 'freddie_4') {
        $title_menu = ddpdm_return_new_name('Funny How Love Is Menu - PHP Templ - Freddie');
    }

     if(get_option('ddpdm_menu_template') === 'freddie_5') {
        $title_menu = ddpdm_return_new_name('Hang On In There Menu - PHP Templ - Freddie');
    }

     if(get_option('ddpdm_menu_template') === 'freddie_6') {
        $title_menu = ddpdm_return_new_name('Lover Boy Menu - PHP Templ - Freddie');
    }

     if(get_option('ddpdm_menu_template') === 'freddie_7') {
        $title_menu = ddpdm_return_new_name('Hijack My Heart Menu - PHP Templ - Freddie');
    }

     if(strpos(get_option('ddpdm_menu_template'), 'custom') !== false) {
        foreach(get_option('ddpdm_template_menu_custom') as $option => $value) {
            if ($option === get_option('ddpdm_menu_template')) {
                $title_menu = $value;
            }
        }

    }

    if(get_option('ddpdm_menu_template') !== 'disabled' ) {
      //  echo get_option('ddpdm_menu_template');
   // echo '$title_menu '.$title_menu;
    $args = array(
    'post_type' => 'et_pb_layout',
    'tax_query' => array(
        array(
            'taxonomy' => 'layout_category',
            'field'    => 'slug',
            'terms'    => array('mega-menu','navigation-menu'),
        ),
    ),
    'title' => $title_menu,
    'posts_per_page' => 1,
    'post_status' => 'publish');

    $my_query = null;
    $my_query = new WP_Query($args);

    if ($my_query->have_posts()) {
        while ($my_query->have_posts()) : $my_query->the_post();
            remove_filter('the_content', 'wpautop');
            echo '<div id="custom-ddpdm-menu">';
            the_content();
            echo '</div>';
        endwhile;
    }

    wp_reset_query();  // Restore global post data stomped by the_post()
echo "<style>#main-header {display: none !important;}</style>";
echo "<script>jQuery(document).ready(function($) {
    $('body:not(.et-fb) > div#custom-ddpdm-menu').insertBefore('#page-container #et-main-area');
}); //jQuery(document).ready(function($)</script>";
if(get_theme_mod('ddpdm_menu_fixed', false) === 1 ) {
echo "<script>jQuery(document).ready(function($) {
    $('div#custom-ddpdm-menu').addClass('fixed');
}); //jQuery(document).ready(function($)</script>";
}
}