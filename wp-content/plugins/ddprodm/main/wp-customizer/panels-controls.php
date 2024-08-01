<?php

function ddpdm_customize_register($wp_customize)
{

    $ddpdm_plugin_name = 'Divi Den Pro';

    if (get_option('ddpdm_wl') == 'enabled') {
        if (get_option('ddpdm_plugin_name')) {
            if (!defined('DDPDM_NAME'))
                define('DDPDM_NAME', get_option('ddpdm_plugin_name'));
        } else {
            if (!defined('DDPDM_NAME'))
                define('DDPDM_NAME', $ddpdm_plugin_name);
        }
    } else if (!defined('DDPDM_NAME'))
        define('DDPDM_NAME', $ddpdm_plugin_name);


    //  ====================
    //  = HELPER FUNCTIONS =
    //  ====================


    // get an exiting category link

    function ddpdm_get_category_link()
    {
        global $post;
        $categories = get_categories();
        $categories = array_slice($categories, 0, 1);
        $link       = get_category_link($categories[0]->term_id);
        return $link;
    }

    // get an exiting tag link

    function ddpdm_get_tag_link()
    {
        global $post;
        $tags = get_tags();
        if (!empty($tags))
            $tags = array_slice($tags, 0, 1);
        if (!empty($tags))
            $link = get_tag_link($tags[0]->term_id);
        if (!empty($link))
            return $link;
    }

    // get an author link

    function ddpdm_get_author_link()
    {
        $users        = get_users();
        $users        = array_slice($users, 0, 10);
        $global_count = 1;
        $global_id    = 1;
        foreach ($users as $user) {
            $user_count = count_user_posts($user->ID);
            if ($user_count > $global_count) {
                $global_count = $user_count;
                $global_id    = $user->ID;
            }
        }
        $link = get_author_posts_url($global_id);
        return $link;
    }

    // get an exiting category link

    function ddpdm_get_single_post_link()
    {
        global $post;
        $link          = '';
        $wpb_all_query = new WP_Query(array(
            'post_type' => 'post',
            'post_status' => 'publish',
            'posts_per_page' => 1
        ));
        if ($wpb_all_query->have_posts()):
            while ($wpb_all_query->have_posts()):
                $wpb_all_query->the_post();
                $link = get_permalink();
            endwhile;
            wp_reset_postdata();
        endif;

        return $link;
    }

    //list of fonts

    $font_choices = array(
        'Source Sans Pro:400,700,400italic,700italic' => 'Source Sans Pro',
        'Open Sans:400italic,700italic,400,700' => 'Open Sans',
        'Oswald:400,700' => 'Oswald',
        'Playfair Display:400,700,400italic' => 'Playfair Display',
        'Montserrat:400,700' => 'Montserrat',
        'Raleway:400,700' => 'Raleway',
        'Droid Sans:400,700' => 'Droid Sans',
        'Lato:400,700,400italic,700italic' => 'Lato',
        'Arvo:400,700,400italic,700italic' => 'Arvo',
        'Lora:400,700,400italic,700italic' => 'Lora',
        'Merriweather:400,300italic,300,400italic,700,700italic' => 'Merriweather',
        'Oxygen:400,300,700' => 'Oxygen',
        'PT Serif:400,700' => 'PT Serif',
        'PT Sans:400,700,400italic,700italic' => 'PT Sans',
        'PT Sans Narrow:400,700' => 'PT Sans Narrow',
        'Cabin:400,700,400italic' => 'Cabin',
        'Fjalla One:400' => 'Fjalla One',
        'Francois One:400' => 'Francois One',
        'Josefin Sans:400,300,600,700' => 'Josefin Sans',
        'Libre Baskerville:400,400italic,700' => 'Libre Baskerville',
        'Arimo:400,700,400italic,700italic' => 'Arimo',
        'Ubuntu:400,700,400italic,700italic' => 'Ubuntu',
        'Bitter:400,700,400italic' => 'Bitter',
        'Droid Serif:400,700,400italic,700italic' => 'Droid Serif',
        'Roboto:400,400italic,700,700italic' => 'Roboto',
        'Open Sans Condensed:700,300italic,300' => 'Open Sans Condensed',
        'Roboto Condensed:400italic,700italic,400,700' => 'Roboto Condensed',
        'Roboto Slab:400,700' => 'Roboto Slab',
        'Yanone Kaffeesatz:400,700' => 'Yanone Kaffeesatz',
        'Rokkitt:400' => 'Rokkitt',
        'Poppins:400' => 'Poppins',
        'Poiret One:400' => 'Poiret One',
    );


    // Add new panel
    if (get_option('ddpdm_wl') !== 'enabled' || get_option('ddpdm_hide_customizer') !== 'enabled') {
        $wp_customize->add_panel('ddpdm_navigation_panel', array(
            'priority' => 0,
            'capability' => 'edit_theme_options',
            'title' => DDPDM_NAME . esc_html__(' Pages Settings', 'ddprodm'),
            'description' => esc_html__('Change ', 'ddprodm') . DDPDM_NAME . esc_html__(' settings', 'ddprodm')
        ));

        $wp_customize->add_panel('ddpdm_blog_navigation_panel', array(
            'priority' => 0,
            'capability' => 'edit_theme_options',
            'title' => DDPDM_NAME . esc_html__(' Blog Settings', 'ddprodm'),
            'description' => esc_html__('Change ', 'ddprodm') . DDPDM_NAME . esc_html__(' blog settings', 'ddprodm')
        ));

        $wp_customize->add_panel('ddpdm_global_navigation_panel', array(
            'priority' => 0,
            'capability' => 'edit_theme_options',
            'title' => DDPDM_NAME . esc_html__(' Global Settings', 'ddprodm'),
            'description' => esc_html__('Change ', 'ddprodm') . DDPDM_NAME . esc_html__(' global settings', 'ddprodm')
        ));
    }



    // Add global category tag author serach section
    $wp_customize->add_section('ddpdm_global_template_section', array(
        'priority' => 10,
        'title' => esc_html__('Global Archive Template', 'ddprodm'),
        'panel' => 'ddpdm_blog_navigation_panel'
    ));

    // Load category page preview

    $wp_customize->add_control('ddpdm_global_control_link', array(
        'section' => 'ddpdm_global_template_section',
        'settings' => array(),
        'type' => 'button',
        'priority' => 1,
        'input_attrs' => array(
            'value' => esc_html__('Load Global Template', 'ddprodm'),
            'class' => 'button button-secondary ddpdm-click-on-load hidden',
            'onclick' => 'wp.customize.previewer.previewUrl.set( "' . ddpdm_get_author_link() . '" );'
        )
    ));




    // Add 404 section
    $wp_customize->add_section('ddpdm_404_section', array(
        'priority' => 100,
        'title' => esc_html__('404 Page Not Found Template', 'ddprodm'),
        'panel' => 'ddpdm_navigation_panel'
        //'active_callback' => 'ddpdm_callback_404',
    ));

    // Load 404 page preview

    $wp_customize->add_control('ddpdm_not_found_link', array(
        'section' => 'ddpdm_404_section',
        'settings' => array(),
        'type' => 'button',
        'priority' => 1,
        'input_attrs' => array(
            'value' => esc_html__('Load Not Found Template', 'ddprodm'),
            'class' => 'button button-secondary ddpdm-click-on-load hidden',
            'onclick' => 'wp.customize.previewer.previewUrl.set( "/not-found-" + String( Math.random() ) + "/" );'
        )
    ));



    // Add category section
    $wp_customize->add_section('ddpdm_category_section', array(
        'priority' => 20,
        'title' => esc_html__('Category Archive Template', 'ddprodm'),
        'panel' => 'ddpdm_blog_navigation_panel'
    ));

    // Load category page preview

    $wp_customize->add_control('ddpdm_category_link', array(
        'section' => 'ddpdm_category_section',
        'settings' => array(),
        'type' => 'button',
        'priority' => 1,
        'input_attrs' => array(
            'value' => esc_html__('Load Category Template', 'ddprodm'),
            'class' => 'button button-secondary ddpdm-click-on-load hidden',
            'onclick' => 'wp.customize.previewer.previewUrl.set( "' . ddpdm_get_category_link() . '" );'
        )
    ));

    // Add tag section
    $wp_customize->add_section('ddpdm_tag_section', array(
        'priority' => 30,
        'title' => esc_html__('Tag Archive Template', 'ddprodm'),
        'panel' => 'ddpdm_blog_navigation_panel'
    ));

    // Load tag page preview

    $wp_customize->add_control('ddpdm_tag_link', array(
        'section' => 'ddpdm_tag_section',
        'settings' => array(),
        'type' => 'button',
        'priority' => 1,
        'input_attrs' => array(
            'value' => esc_html__('Load Tag Template', 'ddprodm'),
            'class' => 'button button-secondary ddpdm-click-on-load hidden',
            'onclick' => 'wp.customize.previewer.previewUrl.set( "' . ddpdm_get_tag_link() . '" );'
        )
    ));


    // Add author section
    $wp_customize->add_section('ddpdm_author_section', array(
        'priority' => 40,
        'title' => esc_html__('Author Archive Template', 'ddprodm'),
        'panel' => 'ddpdm_blog_navigation_panel'
    ));


    // Load author page preview

    $wp_customize->add_control('ddpdm_author_link', array(
        'section' => 'ddpdm_author_section',
        'settings' => array(),
        'type' => 'button',
        'priority' => 1,
        'input_attrs' => array(
            'value' => esc_html__('Load Author Template', 'ddprodm'),
            'class' => 'button button-secondary ddpdm-click-on-load hidden',
            'onclick' => 'wp.customize.previewer.previewUrl.set( "' . ddpdm_get_author_link() . '" );'
        )
    ));


    // Add search result section
    $wp_customize->add_section('ddpdm_search_results_section', array(
        'priority' => 60,
        'title' => esc_html__('Search Results Template', 'ddprodm'),
        'panel' => 'ddpdm_navigation_panel'
    ));

    // get an exiting search link

    function ddpdm_get_search_link()
    {
        global $post;
        return get_search_link('page');
    }

    // Load tag page preview

    $wp_customize->add_control('ddpdm_search_link', array(
        'section' => 'ddpdm_search_results_section',
        'settings' => array(),
        'type' => 'button',
        'priority' => 1,
        'input_attrs' => array(
            'value' => esc_html__('Load Search Template', 'ddprodm'),
            'class' => 'button button-secondary ddpdm-click-on-load hidden',
            'onclick' => 'wp.customize.previewer.previewUrl.set( "' . ddpdm_get_search_link() . '" );'
        )
    ));


    // Add menu sections
    $wp_customize->add_section('ddpdm_menu_section', array(
        'priority' => 100,
        'title' => esc_html__('Global Navigation Menu', 'ddprodm'),
        'panel' => 'ddpdm_global_navigation_panel'
    ));


    //  =============================
    //  = Global Select Box       =
    //  =============================

    $wp_customize->add_setting('ddpdm_global_page_template', array(
        'default' => 'disabled',
        'capability' => 'edit_theme_options',
        'type' => 'option'

    ));

    if (ddpdm_is_divi_item_exists('Global Archive - Row w Sidebar - PHP Templ - Diana')) {
        $choices_array = array(
            'diana_1' => esc_html__('Diana - Row - With Sidebar', 'ddprodm'),
            'diana_2' => esc_html__('Diana - 2 col grid', 'ddprodm'),
            'diana_3' => esc_html__('Diana - 3 col grid', 'ddprodm'),
            'diana_4' => esc_html__('Diana - 4 col grid', 'ddprodm'),
            'disabled' => esc_html__('Disabled (use WordPress default)', 'ddprodm')
        );

    }

    else {
        $choices_array = array(
            'diana_2' => esc_html__('Diana - 2 col grid', 'ddprodm'),
            'diana_3' => esc_html__('Diana - 3 col grid', 'ddprodm'),
            'diana_4' => esc_html__('Diana - 4 col grid', 'ddprodm'),
            'disabled' => esc_html__('Disabled (use WordPress default)', 'ddprodm')
        );

    }


    $wp_customize->add_control('ddpdm_global_page_select_box', array(
        'settings' => 'ddpdm_global_page_template',
        'label' => esc_html__('Global Archive Template', 'ddprodm'),
        'description' => '<p><a href="https://seku.re/divi-den-theme-builder" target="_blank" class="button button-secondary">'.__('Learn More - Watch a short video tutorial', 'ddprodm').'</a></p><p>'.__('This will rewrite your current category, tag and author page templates. No saved templates yet?', 'ddprodm').' <a href="/wp-admin/admin.php?page=divi_den_pro_dm_dashboard&tab=ddpdm_settings">'.__('First save some here', 'ddprodm').'</a>. '.__('After saving they will appear in the drop-down below. You can also modify certain saved templates <a href="/wp-admin/edit.php?post_type=et_pb_layout&layout_category=global-archive-page" target="_blank">in the Divi Library', 'ddprodm').'</a>.</p><label class="customize-control-title">'.__('Saved Global Archive Templates', 'ddprodm').'</label><p>'.__('Choose a saved template to edit.', 'ddprodm').'</p>',
        'section' => 'ddpdm_global_template_section',
        'type' => 'select',
        'choices' => $choices_array
    ));



    $wp_customize->add_setting('ddpdm_global_archive_content_color_value', array(
        'default' => '#a6a6a6',
        'transport' => 'refresh'
    ));

    $wp_customize->add_setting('ddpdm_global_archive_content_size_value', array(
        'default' => '16',
        'transport' => 'refresh'
    ));

    $wp_customize->add_setting('ddpdm_global_archive_rm_color_value', array(
        'default' => '#33373a',
        'transport' => 'refresh'
    ));

    $wp_customize->add_setting('ddpdm_global_archive_rm_size_value', array(
        'default' => '16',
        'transport' => 'refresh'
    ));

    //  ===================================================
    //  = Global Archive Pages author name color and size =
    //  ===================================================

    $wp_customize->add_setting('ddpdm_global_archive_author_name_color_value', array(
        'default' => '#33373a',
        'transport' => 'refresh'
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'ddpdm_global_archive_author_name_color', array(
        'label' => esc_html__('Author Name Color', 'ddprodm'),
        'section' => 'ddpdm_global_template_section',
        'settings' => 'ddpdm_global_archive_author_name_color_value'
    )));



    $wp_customize->add_setting('ddpdm_global_archive_author_name_size_value', array(
        'default' => '24',
        'transport' => 'refresh'
    ));

    $wp_customize->add_control(new ET_Divi_Range_Option($wp_customize, 'ddpdm_global_archive_author_name_size', array(
        'label' => esc_html__('Author Name Font Size', 'ddprodm'),
        'section' => 'ddpdm_global_template_section',
        'settings' => 'ddpdm_global_archive_author_name_size_value',
        'input_attrs' => array(
            'min' => 10,
            'max' => 72,
            'step' => 1
        )
    )));


    //  ===================================================
    //  = Global Archive Pages author bio color and size =
    //  ===================================================

    $wp_customize->add_setting('ddpdm_global_archive_author_bio_color_value', array(
        'default' => '#a6a6a6',
        'transport' => 'refresh'
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'ddpdm_global_archive_author_bio_color', array(
        'label' => esc_html__('Author Bio Color', 'ddprodm'),
        'section' => 'ddpdm_global_template_section',
        'settings' => 'ddpdm_global_archive_author_bio_color_value'
    )));



    $wp_customize->add_setting('ddpdm_global_archive_author_bio_size_value', array(
        'default' => '16',
        'transport' => 'refresh'
    ));

    $wp_customize->add_control(new ET_Divi_Range_Option($wp_customize, 'ddpdm_global_archive_author_bio_size', array(
        'label' => esc_html__('Author Bio Font Size', 'ddprodm'),
        'section' => 'ddpdm_global_template_section',
        'settings' => 'ddpdm_global_archive_author_bio_size_value',
        'input_attrs' => array(
            'min' => 10,
            'max' => 72,
            'step' => 1
        )
    )));

    //  ===============================
    //  = Global Archive Pages title color  =
    //  ===============================

    $wp_customize->add_setting('ddpdm_global_archive_header_color_value', array(
        'default' => '#635c5c',
        'transport' => 'refresh'
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'ddpdm_global_archive_header_color', array(
        'label' => esc_html__('Post Title Color', 'ddprodm'),
        'section' => 'ddpdm_global_template_section',
        'settings' => 'ddpdm_global_archive_header_color_value'
    )));



    $wp_customize->add_setting('ddpdm_global_archive_header_size_value', array(
        'default' => '18',
        'transport' => 'refresh'
    ));

    $wp_customize->add_control(new ET_Divi_Range_Option($wp_customize, 'ddpdm_global_archive_header_size', array(
        'label' => esc_html__('Post Title Font Size', 'ddprodm'),
        'section' => 'ddpdm_global_template_section',
        'settings' => 'ddpdm_global_archive_header_size_value',
        'input_attrs' => array(
            'min' => 10,
            'max' => 72,
            'step' => 1
        )
    )));


    //  =============================
    //  = Global Archive Pages title font =
    //  =============================

    $wp_customize->add_setting('ddpdm_global_archive_header_font', array(
        'sanitize_callback' => 'ddpdm_sanitize_fonts',
        'default' => 'Roboto',
        'transport' => 'refresh'
    ));

    $wp_customize->add_control('ddpdm_global_archive_header_font', array(
        'type' => 'select',
        'label' => esc_html__('Post Title Font', 'ddprodm'),
        'section' => 'ddpdm_global_template_section',
        'choices' => $font_choices
    ));


    //  ==============================
    //  = Global Archive Pages title style =
    //  ==============================

    $wp_customize->add_setting('ddpdm_global_archive_header_font_style', array(
        'transport' => 'refresh'
    ));

    $wp_customize->add_control(new ET_Divi_Font_Style_Option($wp_customize, 'ddpdm_global_archive_header_font_select', array(
        'label' => esc_html__('Post Title Font style', 'ddprodm'),
        'section' => 'ddpdm_global_template_section',
        'settings' => 'ddpdm_global_archive_header_font_style',
        'type' => 'font_style',
        'choices' => et_divi_font_style_choices()
    )));

    //  ===============================
    //  = Global Archive Pages date color  =
    //  ===============================

    $wp_customize->add_setting('ddpdm_global_archive_date_color_value', array(
        'default' => '#33373a',
        'transport' => 'refresh'
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'ddpdm_global_archive_date_color', array(
        'label' => esc_html__('Date Font Color', 'ddprodm'),
        'section' => 'ddpdm_global_template_section',
        'settings' => 'ddpdm_global_archive_date_color_value'
    )));

    $wp_customize->add_setting('ddpdm_global_archive_date_size_value', array(
        'default' => '16',
        'transport' => 'refresh'
    ));

    $wp_customize->add_control(new ET_Divi_Range_Option($wp_customize, 'ddpdm_global_archive_header_size', array(
        'label' => esc_html__('Date Font Size', 'ddprodm'),
        'section' => 'ddpdm_global_template_section',
        'settings' => 'ddpdm_global_archive_date_size_value',
        'input_attrs' => array(
            'min' => 10,
            'max' => 72,
            'step' => 1
        )
    )));

    $wp_customize->add_setting('ddpdm_global_archive_date_bgcolor_value', array(
        'default' => '#f2f1ec',
        'transport' => 'refresh'
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'ddpdm_global_archive_date_bgcolor', array(
        'label' => esc_html__('Date Background Color', 'ddprodm'),
        'section' => 'ddpdm_global_template_section',
        'settings' => 'ddpdm_global_archive_date_bgcolor_value'
    )));



    //  =============================
    //  = Global Archive Pages content     =
    //  =============================

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'ddpdm_global_archive_content_color', array(
        'label' => esc_html__('Body Text Color', 'ddprodm'),
        'section' => 'ddpdm_global_template_section',
        'settings' => 'ddpdm_global_archive_content_color_value'
    )));

    $wp_customize->add_control(new ET_Divi_Range_Option($wp_customize, 'ddpdm_global_archive_content_size', array(
        'label' => esc_html__('Body Font Size', 'ddprodm'),
        'section' => 'ddpdm_global_template_section',
        'settings' => 'ddpdm_global_archive_content_size_value',
        'input_attrs' => array(
            'min' => 10,
            'max' => 72,
            'step' => 1
        )
    )));


    //  ===============================
    //  = Global Archive Pages content font =
    //  ===============================

    $wp_customize->add_setting('ddpdm_global_archive_body_font', array(
        'sanitize_callback' => 'ddpdm_sanitize_fonts',
        'default' => 'Roboto',
        'transport' => 'refresh'
    ));

    $wp_customize->add_control('ddpdm_global_archive_body_font', array(
        'type' => 'select',
        'label' => esc_html__('Body Font', 'ddprodm'),
        'section' => 'ddpdm_global_template_section',
        'choices' => $font_choices
    ));


    //  ================================
    //  = Global Archive Pages content style =
    //  ================================

    $wp_customize->add_setting('ddpdm_global_archive_body_font_style', array(
        'transport' => 'refresh'
    ));

    $wp_customize->add_control(new ET_Divi_Font_Style_Option($wp_customize, 'ddpdm_global_archive_body_font_select', array(
        'label' => esc_html__('Body Font style', 'ddprodm'),
        'section' => 'ddpdm_global_template_section',
        'settings' => 'ddpdm_global_archive_body_font_style',
        'type' => 'font_style',
        'choices' => et_divi_font_style_choices()
    )));


    //  =============================
    //  = Global Archive Pages Read More    =
    //  =============================

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'ddpdm_global_archive_rm_color', array(
        'label' => esc_html__('Read More Text Color', 'ddprodm'),
        'section' => 'ddpdm_global_template_section',
        'settings' => 'ddpdm_global_archive_rm_color_value'
    )));

    $wp_customize->add_control(new ET_Divi_Range_Option($wp_customize, 'ddpdm_global_archive_rm_size', array(
        'label' => esc_html__('Read More Font Size', 'ddprodm'),
        'section' => 'ddpdm_global_template_section',
        'settings' => 'ddpdm_global_archive_rm_size_value',
        'input_attrs' => array(
            'min' => 10,
            'max' => 72,
            'step' => 1
        )
    )));


    $wp_customize->add_setting('ddpdm_global_archive_meta_color_value_col', array(
        'default' => '#a6a6a6',
        'transport' => 'refresh'
    ));

    $wp_customize->add_setting('ddpdm_global_archive_meta_size_value_col', array(
        'default' => '14',
        'transport' => 'refresh'
    ));

    $wp_customize->add_setting('ddpdm_global_archive_rm_color_value_col', array(
        'default' => '#33373a',
        'transport' => 'refresh'
    ));

    $wp_customize->add_setting('ddpdm_global_archive_rm_size_value_col', array(
        'default' => '16',
        'transport' => 'refresh'
    ));

    //  ===================================================
    //  = COLUMNS Global Archive Pages author name color and size =
    //  ===================================================

    $wp_customize->add_setting('ddpdm_global_archive_author_name_color_value_col', array(
        'default' => '#33373a',
        'transport' => 'refresh'
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'ddpdm_global_archive_author_name_color_col', array(
        'label' => esc_html__('Author Name Color', 'ddprodm'),
        'section' => 'ddpdm_global_template_section',
        'settings' => 'ddpdm_global_archive_author_name_color_value_col'
    )));



    $wp_customize->add_setting('ddpdm_global_archive_author_name_size_value_col', array(
        'default' => '24',
        'transport' => 'refresh'
    ));

    $wp_customize->add_control(new ET_Divi_Range_Option($wp_customize, 'ddpdm_global_archive_author_name_size_col', array(
        'label' => esc_html__('Author Name Font Size', 'ddprodm'),
        'section' => 'ddpdm_global_template_section',
        'settings' => 'ddpdm_global_archive_author_name_size_value_col',
        'input_attrs' => array(
            'min' => 10,
            'max' => 72,
            'step' => 1
        )
    )));


    //  ===================================================
    //  = Global Archive Pages author bio color and size =
    //  ===================================================

    $wp_customize->add_setting('ddpdm_global_archive_author_bio_color_value_col', array(
        'default' => '#a6a6a6',
        'transport' => 'refresh'
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'ddpdm_global_archive_author_bio_color_col', array(
        'label' => esc_html__('Author Bio Color', 'ddprodm'),
        'section' => 'ddpdm_global_template_section',
        'settings' => 'ddpdm_global_archive_author_bio_color_value_col'
    )));



    $wp_customize->add_setting('ddpdm_global_archive_author_bio_size_value_col', array(
        'default' => '16',
        'transport' => 'refresh'
    ));

    $wp_customize->add_control(new ET_Divi_Range_Option($wp_customize, 'ddpdm_global_archive_author_bio_size_col', array(
        'label' => esc_html__('Author Bio Font Size', 'ddprodm'),
        'section' => 'ddpdm_global_template_section',
        'settings' => 'ddpdm_global_archive_author_bio_size_value_col',
        'input_attrs' => array(
            'min' => 10,
            'max' => 72,
            'step' => 1
        )
    )));

    //  ===============================
    //  = COLUMNS Global Archive Pages Meta Data and Continue Reading Font  =
    //  ===============================

    $wp_customize->add_setting('ddpdm_global_archive_mdcr_font_col', array(
        'sanitize_callback' => 'ddpdm_sanitize_fonts',
        'default' => 'Roboto',
        'transport' => 'refresh'
    ));

    $wp_customize->add_control('ddpdm_global_archive_mdcr_font_col', array(
        'type' => 'select',
        'label' => esc_html__('Meta Data and Continue Reading Font', 'ddprodm'),
        'section' => 'ddpdm_global_template_section',
        'choices' => $font_choices
    ));


    //  ===============================
    //  = COLUMNS Global Archive Pages title color  =
    //  ===============================

    $wp_customize->add_setting('ddpdm_global_archive_header_color_value_col', array(
        'default' => '#635c5c',
        'transport' => 'refresh'
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'ddpdm_global_archive_header_color_col', array(
        'label' => esc_html__('Post Title Color', 'ddprodm'),
        'section' => 'ddpdm_global_template_section',
        'settings' => 'ddpdm_global_archive_header_color_value_col'
    )));



    $wp_customize->add_setting('ddpdm_global_archive_header_size_value_col', array(
        'default' => '18',
        'transport' => 'refresh'
    ));

    $wp_customize->add_control(new ET_Divi_Range_Option($wp_customize, 'ddpdm_global_archive_header_size_col', array(
        'label' => esc_html__('Post Title Font Size', 'ddprodm'),
        'section' => 'ddpdm_global_template_section',
        'settings' => 'ddpdm_global_archive_header_size_value_col',
        'input_attrs' => array(
            'min' => 10,
            'max' => 72,
            'step' => 1
        )
    )));


    //  =============================
    //  = COLUMNS Global Archive Pages title font =
    //  =============================

    $wp_customize->add_setting('ddpdm_global_archive_header_font_col', array(
        'sanitize_callback' => 'ddpdm_sanitize_fonts',
        'default' => 'Roboto',
        'transport' => 'refresh'
    ));

    $wp_customize->add_control('ddpdm_global_archive_header_font_col', array(
        'type' => 'select',
        'label' => esc_html__('Post Title Font', 'ddprodm'),
        'section' => 'ddpdm_global_template_section',
        'choices' => $font_choices
    ));


    //  ==============================
    //  = COLUMNS Global Archive Pages title style =
    //  ==============================

    $wp_customize->add_setting('ddpdm_global_archive_header_font_style_col', array(
        'transport' => 'refresh'
    ));

    $wp_customize->add_control(new ET_Divi_Font_Style_Option($wp_customize, 'ddpdm_global_archive_header_font_select_col', array(
        'label' => esc_html__('Post Title Font style', 'ddprodm'),
        'section' => 'ddpdm_global_template_section',
        'settings' => 'ddpdm_global_archive_header_font_style_col',
        'type' => 'font_style',
        'choices' => et_divi_font_style_choices()
    )));

    //  ===============================
    //  = COLUMNS Global Archive Pages date color  =
    //  ===============================

    $wp_customize->add_setting('ddpdm_global_archive_date_color_value_col', array(
        'default' => '#33373a',
        'transport' => 'refresh'
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'ddpdm_global_archive_date_color_col', array(
        'label' => esc_html__('Date Font Color', 'ddprodm'),
        'section' => 'ddpdm_global_template_section',
        'settings' => 'ddpdm_global_archive_date_color_value_col'
    )));

    $wp_customize->add_setting('ddpdm_global_archive_date_size_value_col', array(
        'default' => '16',
        'transport' => 'refresh'
    ));

    $wp_customize->add_control(new ET_Divi_Range_Option($wp_customize, 'ddpdm_global_archive_header_size_col', array(
        'label' => esc_html__('Date Font Size', 'ddprodm'),
        'section' => 'ddpdm_global_template_section',
        'settings' => 'ddpdm_global_archive_date_size_value_col',
        'input_attrs' => array(
            'min' => 10,
            'max' => 72,
            'step' => 1
        )
    )));

    $wp_customize->add_setting('ddpdm_global_archive_date_bgcolor_value_col', array(
        'default' => '#f2f1ec',
        'transport' => 'refresh'
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'ddpdm_global_archive_date_bgcolor_col', array(
        'label' => esc_html__('Date Background Color', 'ddprodm'),
        'section' => 'ddpdm_global_template_section',
        'settings' => 'ddpdm_global_archive_date_bgcolor_value_col'
    )));



    //  =============================
    //  = COLUMNS Global Archive Pages content     =
    //  =============================

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'ddpdm_global_archive_meta_color_col', array(
        'label' => esc_html__('Meta Data Text Color', 'ddprodm'),
        'section' => 'ddpdm_global_template_section',
        'settings' => 'ddpdm_global_archive_meta_color_value_col'
    )));

    $wp_customize->add_control(new ET_Divi_Range_Option($wp_customize, 'ddpdm_global_archive_meta_size_col', array(
        'label' => esc_html__('Meta Data Font Size', 'ddprodm'),
        'section' => 'ddpdm_global_template_section',
        'settings' => 'ddpdm_global_archive_meta_size_value_col',
        'input_attrs' => array(
            'min' => 10,
            'max' => 72,
            'step' => 1
        )
    )));



    //  ============================================
    //  = COLUMNS Global Archive Pages Continue Reading    =
    //  ============================================

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'ddpdm_global_archive_rm_color_col', array(
        'label' => esc_html__('Continue Reading Text Color', 'ddprodm'),
        'section' => 'ddpdm_global_template_section',
        'settings' => 'ddpdm_global_archive_rm_color_value_col'
    )));

    $wp_customize->add_control(new ET_Divi_Range_Option($wp_customize, 'ddpdm_global_archive_rm_size_col', array(
        'label' => esc_html__('Continue Reading Font Size', 'ddprodm'),
        'section' => 'ddpdm_global_template_section',
        'settings' => 'ddpdm_global_archive_rm_size_value_col',
        'input_attrs' => array(
            'min' => 10,
            'max' => 72,
            'step' => 1
        )
    )));



    //  =============================
    //  = Category Select Box       =
    //  =============================
    $wp_customize->add_setting('ddpdm_category_page_template', array(
        'default' => 'global',
        'capability' => 'edit_theme_options',
        'type' => 'option'

    ));

    if (ddpdm_is_divi_item_exists('Category Archive - Row w Sidebar - PHP Templ - Diana')) {
        $choices_array_cat = array(
            'global' => esc_html__('Global Template', 'ddprodm'),
            'diana_1' => esc_html__('Diana Category - Row - With Sidebar', 'ddprodm'),
            'diana_2' => esc_html__('Diana Category - 2 col grid', 'ddprodm'),
            'diana_3' => esc_html__('Diana Category - 3 col grid', 'ddprodm'),
            'diana_4' => esc_html__('Diana Category - 4 col grid', 'ddprodm'),
            'disabled' => esc_html__('Disabled (use WordPress default)', 'ddprodm')
        );

    }

    else {
        $choices_array_cat = array(
            'global' => esc_html__('Global Template', 'ddprodm'),
            'diana_2' => esc_html__('Diana Category - 2 col grid', 'ddprodm'),
            'diana_3' => esc_html__('Diana Category - 3 col grid', 'ddprodm'),
            'diana_4' => esc_html__('Diana Category - 4 col grid', 'ddprodm'),
            'disabled' => esc_html__('Disabled (use WordPress default)', 'ddprodm')
        );

    }


    $wp_customize->add_control('ddpdm_category_select_box', array(
        'settings' => 'ddpdm_category_page_template',
        'label' => esc_html__('Category Archive Template', 'ddprodm'),
        'description' => '<p><a href="https://seku.re/divi-den-theme-builder" target="_blank" class="button button-secondary">'.__('Learn More - Watch a short video tutorial', 'ddprodm').'</a></p><p>'.__('This will rewrite your current Category page template. No saved templates yet?', 'ddprodm').' <a href="/wp-admin/admin.php?page=divi_den_pro_dm_dashboard&tab=ddpdm_settings">'.__('First save some here', 'ddprodm').'</a>. '.__('After saving they will appear in the drop-down below. You can also modify certain saved templates', 'ddprodm').' <a href="/wp-admin/edit.php?post_type=et_pb_layout&layout_category=category-archive-page" target="_blank">'.__('in the Divi Library', 'ddprodm').'</a>.</p><label class="customize-control-title">'.__('Saved Category Archive Templates', 'ddprodm').'</label><p>'.__('Choose a saved template to edit.', 'ddprodm').'</p>',
        'section' => 'ddpdm_global_template_section',
        'section' => 'ddpdm_category_section',
        'type' => 'select',
        'choices' => $choices_array_cat
    ));

    $wp_customize->add_setting('ddpdm_category_content_color_value', array(
        'default' => '#a6a6a6',
        'transport' => 'refresh'
    ));

    $wp_customize->add_setting('ddpdm_category_content_size_value', array(
        'default' => '16',
        'transport' => 'refresh'
    ));

    $wp_customize->add_setting('ddpdm_category_rm_color_value', array(
        'default' => '#33373a',
        'transport' => 'refresh'
    ));

    $wp_customize->add_setting('ddpdm_category_rm_size_value', array(
        'default' => '16',
        'transport' => 'refresh'
    ));

    //  ===============================
    //  = Category Pages title color  =
    //  ===============================

    $wp_customize->add_setting('ddpdm_category_header_color_value', array(
        'default' => '#635c5c',
        'transport' => 'refresh'
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'ddpdm_category_header_color', array(
        'label' => esc_html__('Post Title Color', 'ddprodm'),
        'section' => 'ddpdm_category_section',
        'settings' => 'ddpdm_category_header_color_value'
    )));



    $wp_customize->add_setting('ddpdm_category_header_size_value', array(
        'default' => '18',
        'transport' => 'refresh'
    ));

    $wp_customize->add_control(new ET_Divi_Range_Option($wp_customize, 'ddpdm_category_header_size', array(
        'label' => esc_html__('Post Title Font Size', 'ddprodm'),
        'section' => 'ddpdm_category_section',
        'settings' => 'ddpdm_category_header_size_value',
        'input_attrs' => array(
            'min' => 10,
            'max' => 72,
            'step' => 1
        )
    )));


    //  =============================
    //  = Category Pages title font =
    //  =============================

    $wp_customize->add_setting('ddpdm_category_header_font', array(
        'sanitize_callback' => 'ddpdm_sanitize_fonts',
        'default' => 'Roboto',
        'transport' => 'refresh'
    ));

    $wp_customize->add_control('ddpdm_category_header_font', array(
        'type' => 'select',
        'label' => esc_html__('Post Title Font', 'ddprodm'),
        'section' => 'ddpdm_category_section',
        'choices' => $font_choices
    ));


    //  ==============================
    //  = Category Pages title style =
    //  ==============================

    $wp_customize->add_setting('ddpdm_category_header_font_style', array(
        'transport' => 'refresh'
    ));

    $wp_customize->add_control(new ET_Divi_Font_Style_Option($wp_customize, 'ddpdm_category_header_font_select', array(
        'label' => esc_html__('Post Title Font style', 'ddprodm'),
        'section' => 'ddpdm_category_section',
        'settings' => 'ddpdm_category_header_font_style',
        'type' => 'font_style',
        'choices' => et_divi_font_style_choices()
    )));

    //  ===============================
    //  = Category Pages date color  =
    //  ===============================

    $wp_customize->add_setting('ddpdm_category_date_color_value', array(
        'default' => '#33373a',
        'transport' => 'refresh'
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'ddpdm_category_date_color', array(
        'label' => esc_html__('Date Font Color', 'ddprodm'),
        'section' => 'ddpdm_category_section',
        'settings' => 'ddpdm_category_date_color_value'
    )));

    $wp_customize->add_setting('ddpdm_category_date_size_value', array(
        'default' => '16',
        'transport' => 'refresh'
    ));

    $wp_customize->add_control(new ET_Divi_Range_Option($wp_customize, 'ddpdm_category_date_size', array(
        'label' => esc_html__('Date Font Size', 'ddprodm'),
        'section' => 'ddpdm_category_section',
        'settings' => 'ddpdm_category_date_size_value',
        'input_attrs' => array(
            'min' => 10,
            'max' => 72,
            'step' => 1
        )
    )));

    $wp_customize->add_setting('ddpdm_category_date_bgcolor_value', array(
        'default' => '#f2f1ec',
        'transport' => 'refresh'
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'ddpdm_category_date_bgcolor', array(
        'label' => esc_html__('Date Background Color', 'ddprodm'),
        'section' => 'ddpdm_category_section',
        'settings' => 'ddpdm_category_date_bgcolor_value'
    )));



    //  =============================
    //  = Category Pages content     =
    //  =============================

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'ddpdm_category_content_color', array(
        'label' => esc_html__('Body Text Color', 'ddprodm'),
        'section' => 'ddpdm_category_section',
        'settings' => 'ddpdm_category_content_color_value'
    )));

    $wp_customize->add_control(new ET_Divi_Range_Option($wp_customize, 'ddpdm_category_content_size', array(
        'label' => esc_html__('Body Font Size', 'ddprodm'),
        'section' => 'ddpdm_category_section',
        'settings' => 'ddpdm_category_content_size_value',
        'input_attrs' => array(
            'min' => 10,
            'max' => 72,
            'step' => 1
        )
    )));


    //  ===============================
    //  = Category Pages content font =
    //  ===============================

    $wp_customize->add_setting('ddpdm_category_body_font', array(
        'sanitize_callback' => 'ddpdm_sanitize_fonts',
        'default' => 'Roboto',
        'transport' => 'refresh'
    ));

    $wp_customize->add_control('ddpdm_category_body_font', array(
        'type' => 'select',
        'label' => esc_html__('Body Font', 'ddprodm'),
        'section' => 'ddpdm_category_section',
        'choices' => $font_choices
    ));


    //  ================================
    //  = Category Pages content style =
    //  ================================

    $wp_customize->add_setting('ddpdm_category_body_font_style', array(
        'transport' => 'refresh'
    ));

    $wp_customize->add_control(new ET_Divi_Font_Style_Option($wp_customize, 'ddpdm_category_body_font_select', array(
        'label' => esc_html__('Body Font style', 'ddprodm'),
        'section' => 'ddpdm_category_section',
        'settings' => 'ddpdm_category_body_font_style',
        'type' => 'font_style',
        'choices' => et_divi_font_style_choices()
    )));


    //  =============================
    //  = Category Pages Read More    =
    //  =============================

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'ddpdm_category_rm_color', array(
        'label' => esc_html__('Read More Text Color', 'ddprodm'),
        'section' => 'ddpdm_category_section',
        'settings' => 'ddpdm_category_rm_color_value'
    )));

    $wp_customize->add_control(new ET_Divi_Range_Option($wp_customize, 'ddpdm_category_rm_size', array(
        'label' => esc_html__('Read More Font Size', 'ddprodm'),
        'section' => 'ddpdm_category_section',
        'settings' => 'ddpdm_category_rm_size_value',
        'input_attrs' => array(
            'min' => 10,
            'max' => 72,
            'step' => 1
        )
    )));


    $wp_customize->add_setting('ddpdm_category_meta_color_value_col', array(
        'default' => '#a6a6a6',
        'transport' => 'refresh'
    ));

    $wp_customize->add_setting('ddpdm_category_meta_size_value_col', array(
        'default' => '14',
        'transport' => 'refresh'
    ));

    $wp_customize->add_setting('ddpdm_category_rm_color_value_col', array(
        'default' => '#33373a',
        'transport' => 'refresh'
    ));

    $wp_customize->add_setting('ddpdm_category_rm_size_value_col', array(
        'default' => '16',
        'transport' => 'refresh'
    ));

    //  ===============================
    //  = COLUMNS Category Meta Data and Continue Reading Font  =
    //  ===============================

    $wp_customize->add_setting('ddpdm_category_mdcr_font_col', array(
        'sanitize_callback' => 'ddpdm_sanitize_fonts',
        'default' => 'Roboto',
        'transport' => 'refresh'
    ));

    $wp_customize->add_control('ddpdm_category_mdcr_font_col', array(
        'type' => 'select',
        'label' => esc_html__('Meta Data and Continue Reading Font', 'ddprodm'),
        'section' => 'ddpdm_category_section',
        'choices' => $font_choices
    ));


    //  ===============================
    //  = COLUMNS Category Pages title color  =
    //  ===============================

    $wp_customize->add_setting('ddpdm_category_header_color_value_col', array(
        'default' => '#635c5c',
        'transport' => 'refresh'
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'ddpdm_category_header_color_col', array(
        'label' => esc_html__('Post Title Color', 'ddprodm'),
        'section' => 'ddpdm_category_section',
        'settings' => 'ddpdm_category_header_color_value_col'
    )));



    $wp_customize->add_setting('ddpdm_category_header_size_value_col', array(
        'default' => '18',
        'transport' => 'refresh'
    ));

    $wp_customize->add_control(new ET_Divi_Range_Option($wp_customize, 'ddpdm_category_header_size_col', array(
        'label' => esc_html__('Post Title Font Size', 'ddprodm'),
        'section' => 'ddpdm_category_section',
        'settings' => 'ddpdm_category_header_size_value_col',
        'input_attrs' => array(
            'min' => 10,
            'max' => 72,
            'step' => 1
        )
    )));


    //  =============================
    //  = COLUMNS Category Pages title font =
    //  =============================

    $wp_customize->add_setting('ddpdm_category_header_font_col', array(
        'sanitize_callback' => 'ddpdm_sanitize_fonts',
        'default' => 'Roboto',
        'transport' => 'refresh'
    ));

    $wp_customize->add_control('ddpdm_category_header_font_col', array(
        'type' => 'select',
        'label' => esc_html__('Post Title Font', 'ddprodm'),
        'section' => 'ddpdm_category_section',
        'choices' => $font_choices
    ));


    //  ==============================
    //  = COLUMNS Category Pages title style =
    //  ==============================

    $wp_customize->add_setting('ddpdm_category_header_font_style_col', array(
        'transport' => 'refresh'
    ));

    $wp_customize->add_control(new ET_Divi_Font_Style_Option($wp_customize, 'ddpdm_category_header_font_select_col', array(
        'label' => esc_html__('Post Title Font style', 'ddprodm'),
        'section' => 'ddpdm_category_section',
        'settings' => 'ddpdm_category_header_font_style_col',
        'type' => 'font_style',
        'choices' => et_divi_font_style_choices()
    )));

    //  ===============================
    //  = COLUMNS Category Pages date color  =
    //  ===============================

    $wp_customize->add_setting('ddpdm_category_date_color_value_col', array(
        'default' => '#33373a',
        'transport' => 'refresh'
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'ddpdm_category_date_color_col', array(
        'label' => esc_html__('Date Font Color', 'ddprodm'),
        'section' => 'ddpdm_category_section',
        'settings' => 'ddpdm_category_date_color_value_col'
    )));

    $wp_customize->add_setting('ddpdm_category_date_size_value_col', array(
        'default' => '16',
        'transport' => 'refresh'
    ));

    $wp_customize->add_control(new ET_Divi_Range_Option($wp_customize, 'ddpdm_category_date_size_col', array(
        'label' => esc_html__('Date Font Size', 'ddprodm'),
        'section' => 'ddpdm_category_section',
        'settings' => 'ddpdm_category_date_size_value_col',
        'input_attrs' => array(
            'min' => 10,
            'max' => 72,
            'step' => 1
        )
    )));

    $wp_customize->add_setting('ddpdm_category_date_bgcolor_value_col', array(
        'default' => '#f2f1ec',
        'transport' => 'refresh'
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'ddpdm_category_date_bgcolor_col', array(
        'label' => esc_html__('Date Background Color', 'ddprodm'),
        'section' => 'ddpdm_category_section',
        'settings' => 'ddpdm_category_date_bgcolor_value_col'
    )));



    //  =============================
    //  = COLUMNS Category Pages content     =
    //  =============================

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'ddpdm_category_meta_color_col', array(
        'label' => esc_html__('Meta Data Text Color', 'ddprodm'),
        'section' => 'ddpdm_category_section',
        'settings' => 'ddpdm_category_meta_color_value_col'
    )));

    $wp_customize->add_control(new ET_Divi_Range_Option($wp_customize, 'ddpdm_category_meta_size_col', array(
        'label' => esc_html__('Meta Data Font Size', 'ddprodm'),
        'section' => 'ddpdm_category_section',
        'settings' => 'ddpdm_category_meta_size_value_col',
        'input_attrs' => array(
            'min' => 10,
            'max' => 72,
            'step' => 1
        )
    )));



    //  ============================================
    //  = COLUMNS Category Pages Continue Reading    =
    //  ============================================

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'ddpdm_category_rm_color_col', array(
        'label' => esc_html__('Continue Reading Text Color', 'ddprodm'),
        'section' => 'ddpdm_category_section',
        'settings' => 'ddpdm_category_rm_color_value_col'
    )));

    $wp_customize->add_control(new ET_Divi_Range_Option($wp_customize, 'ddpdm_category_rm_size_col', array(
        'label' => esc_html__('Continue Reading Font Size', 'ddprodm'),
        'section' => 'ddpdm_category_section',
        'settings' => 'ddpdm_category_rm_size_value_col',
        'input_attrs' => array(
            'min' => 10,
            'max' => 72,
            'step' => 1
        )
    )));




    // Tag

    if (ddpdm_is_divi_item_exists('Tag Archive - Row w Sidebar - PHP Templ - Diana')) {
        $choices_array_tag = array(
            'global' => esc_html__('Global Template', 'ddprodm'),
            'diana_1' => esc_html__('Diana Tag - Row - With Sidebar', 'ddprodm'),
            'diana_2' => esc_html__('Diana Tag - 2 col grid', 'ddprodm'),
            'diana_3' => esc_html__('Diana Tag - 3 col grid', 'ddprodm'),
            'diana_4' => esc_html__('Diana Tag - 4 col grid', 'ddprodm'),
            'disabled' => esc_html__('Disabled (use WordPress default)', 'ddprodm')
        );

    }

    else {
        $choices_array_tag = array(
            'global' => esc_html__('Global Template', 'ddprodm'),
            'diana_2' => esc_html__('Diana Tag - 2 col grid', 'ddprodm'),
            'diana_3' => esc_html__('Diana Tag - 3 col grid', 'ddprodm'),
            'diana_4' => esc_html__('Diana Tag - 4 col grid', 'ddprodm'),
            'disabled' => esc_html__('Disabled (use WordPress default)', 'ddprodm')
        );

    }


    //  =============================
    //  = Tag Select Box            =
    //  =============================
    $wp_customize->add_setting('ddpdm_tag_page_template', array(
        'default' => 'global',
        'capability' => 'edit_theme_options',
        'type' => 'option'

    ));
    $wp_customize->add_control('ddpdm_tag_select_box', array(
        'settings' => 'ddpdm_tag_page_template',
        'label' => esc_html__('Tag Archive Template', 'ddprodm'),
        'description' => '<p><a href="https://seku.re/divi-den-theme-builder" target="_blank" class="button button-secondary">'.__('Learn More - Watch a short video tutorial', 'ddprodm').'</a></p><p>'.__('This will rewrite your current Tag template. No saved templates yet?', 'ddprodm').' <a href="/wp-admin/admin.php?page=divi_den_pro_dm_dashboard&tab=ddpdm_settings">'.'First save some here'.'</a>. '.__('After saving they will appear in the drop-down below. You can also modify certain saved templates', 'ddprodm').' <a href="/wp-admin/edit.php?post_type=et_pb_layout&layout_category=tag-archive-page" target="_blank">'.__('in the Divi Library', 'ddprodm').'</a>.</p><label class="customize-control-title">'.__('Saved Tag Archive Templates', 'ddprodm').'</label><p>'.__('Choose a saved template to edit.', 'ddprodm').'</p>',
        'section' => 'ddpdm_global_template_section',
        'section' => 'ddpdm_tag_section',
        'type' => 'select',
        'choices' => $choices_array_tag
    ));

    $wp_customize->add_setting('ddpdm_tag_content_color_value', array(
        'default' => '#a6a6a6',
        'transport' => 'refresh'
    ));

    $wp_customize->add_setting('ddpdm_tag_content_size_value', array(
        'default' => '16',
        'transport' => 'refresh'
    ));

    $wp_customize->add_setting('ddpdm_tag_rm_color_value', array(
        'default' => '#33373a',
        'transport' => 'refresh'
    ));

    $wp_customize->add_setting('ddpdm_tag_rm_size_value', array(
        'default' => '16',
        'transport' => 'refresh'
    ));


    //  ===============================
    //  = Tag Pages title color  =
    //  ===============================

    $wp_customize->add_setting('ddpdm_tag_header_color_value', array(
        'default' => '#635c5c',
        'transport' => 'refresh'
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'ddpdm_tag_header_color', array(
        'label' => esc_html__('Post Title Color', 'ddprodm'),
        'section' => 'ddpdm_tag_section',
        'settings' => 'ddpdm_tag_header_color_value'
    )));



    $wp_customize->add_setting('ddpdm_tag_header_size_value', array(
        'default' => '18',
        'transport' => 'refresh'
    ));

    $wp_customize->add_control(new ET_Divi_Range_Option($wp_customize, 'ddpdm_tag_header_size', array(
        'label' => esc_html__('Post Title Font Size', 'ddprodm'),
        'section' => 'ddpdm_tag_section',
        'settings' => 'ddpdm_tag_header_size_value',
        'input_attrs' => array(
            'min' => 10,
            'max' => 72,
            'step' => 1
        )
    )));


    //  =============================
    //  = Tag Pages title font =
    //  =============================

    $wp_customize->add_setting('ddpdm_tag_header_font', array(
        'sanitize_callback' => 'ddpdm_sanitize_fonts',
        'default' => 'Roboto',
        'transport' => 'refresh'
    ));

    $wp_customize->add_control('ddpdm_tag_header_font', array(
        'type' => 'select',
        'label' => esc_html__('Post Title Font', 'ddprodm'),
        'section' => 'ddpdm_tag_section',
        'choices' => $font_choices
    ));


    //  ==============================
    //  = Tag Pages title style =
    //  ==============================

    $wp_customize->add_setting('ddpdm_tag_header_font_style', array(
        'transport' => 'refresh'
    ));

    $wp_customize->add_control(new ET_Divi_Font_Style_Option($wp_customize, 'ddpdm_tag_header_font_select', array(
        'label' => esc_html__('Post Title Font style', 'ddprodm'),
        'section' => 'ddpdm_tag_section',
        'settings' => 'ddpdm_tag_header_font_style',
        'type' => 'font_style',
        'choices' => et_divi_font_style_choices()
    )));

    //  ===============================
    //  = Tag Pages date color  =
    //  ===============================

    $wp_customize->add_setting('ddpdm_tag_date_color_value', array(
        'default' => '#33373a',
        'transport' => 'refresh'
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'ddpdm_tag_date_color', array(
        'label' => esc_html__('Date Font Color', 'ddprodm'),
        'section' => 'ddpdm_tag_section',
        'settings' => 'ddpdm_tag_date_color_value'
    )));

    $wp_customize->add_setting('ddpdm_tag_date_size_value', array(
        'default' => '16',
        'transport' => 'refresh'
    ));

    $wp_customize->add_control(new ET_Divi_Range_Option($wp_customize, 'ddpdm_tag_header_size', array(
        'label' => esc_html__('Date Font Size', 'ddprodm'),
        'section' => 'ddpdm_tag_section',
        'settings' => 'ddpdm_tag_date_size_value',
        'input_attrs' => array(
            'min' => 10,
            'max' => 72,
            'step' => 1
        )
    )));

    $wp_customize->add_setting('ddpdm_tag_date_bgcolor_value', array(
        'default' => '#f2f1ec',
        'transport' => 'refresh'
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'ddpdm_tag_date_bgcolor', array(
        'label' => esc_html__('Date Background Color', 'ddprodm'),
        'section' => 'ddpdm_tag_section',
        'settings' => 'ddpdm_tag_date_bgcolor_value'
    )));



    //  =============================
    //  = Tag Pages content     =
    //  =============================

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'ddpdm_tag_content_color', array(
        'label' => esc_html__('Body Text Color', 'ddprodm'),
        'section' => 'ddpdm_tag_section',
        'settings' => 'ddpdm_tag_content_color_value'
    )));

    $wp_customize->add_control(new ET_Divi_Range_Option($wp_customize, 'ddpdm_tag_content_size', array(
        'label' => esc_html__('Body Font Size', 'ddprodm'),
        'section' => 'ddpdm_tag_section',
        'settings' => 'ddpdm_tag_content_size_value',
        'input_attrs' => array(
            'min' => 10,
            'max' => 72,
            'step' => 1
        )
    )));


    //  ===============================
    //  = Tag Pages content font =
    //  ===============================

    $wp_customize->add_setting('ddpdm_tag_body_font', array(
        'sanitize_callback' => 'ddpdm_sanitize_fonts',
        'default' => 'Roboto',
        'transport' => 'refresh'
    ));

    $wp_customize->add_control('ddpdm_tag_body_font', array(
        'type' => 'select',
        'label' => esc_html__('Body Font', 'ddprodm'),
        'section' => 'ddpdm_tag_section',
        'choices' => $font_choices
    ));


    //  ================================
    //  = Tag Pages content style =
    //  ================================

    $wp_customize->add_setting('ddpdm_tag_body_font_style', array(
        'transport' => 'refresh'
    ));

    $wp_customize->add_control(new ET_Divi_Font_Style_Option($wp_customize, 'ddpdm_tag_body_font_select', array(
        'label' => esc_html__('Body Font style', 'ddprodm'),
        'section' => 'ddpdm_tag_section',
        'settings' => 'ddpdm_tag_body_font_style',
        'type' => 'font_style',
        'choices' => et_divi_font_style_choices()
    )));


    //  =============================
    //  = Tag Pages Read More    =
    //  =============================

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'ddpdm_tag_rm_color', array(
        'label' => esc_html__('Read More Text Color', 'ddprodm'),
        'section' => 'ddpdm_tag_section',
        'settings' => 'ddpdm_tag_rm_color_value'
    )));

    $wp_customize->add_control(new ET_Divi_Range_Option($wp_customize, 'ddpdm_tag_rm_size', array(
        'label' => esc_html__('Read More Font Size', 'ddprodm'),
        'section' => 'ddpdm_tag_section',
        'settings' => 'ddpdm_tag_rm_size_value',
        'input_attrs' => array(
            'min' => 10,
            'max' => 72,
            'step' => 1
        )
    )));


    $wp_customize->add_setting('ddpdm_tag_meta_color_value_col', array(
        'default' => '#a6a6a6',
        'transport' => 'refresh'
    ));

    $wp_customize->add_setting('ddpdm_tag_meta_size_value_col', array(
        'default' => '14',
        'transport' => 'refresh'
    ));

    $wp_customize->add_setting('ddpdm_tag_rm_color_value_col', array(
        'default' => '#33373a',
        'transport' => 'refresh'
    ));

    $wp_customize->add_setting('ddpdm_tag_rm_size_value_col', array(
        'default' => '16',
        'transport' => 'refresh'
    ));


    //  ===============================
    //  = COLUMNS Tag Meta Data and Continue Reading Font  =
    //  ===============================

    $wp_customize->add_setting('ddpdm_tag_mdcr_font_col', array(
        'sanitize_callback' => 'ddpdm_sanitize_fonts',
        'default' => 'Roboto',
        'transport' => 'refresh'
    ));

    $wp_customize->add_control('ddpdm_tag_mdcr_font_col', array(
        'type' => 'select',
        'label' => esc_html__('Meta Data and Continue Reading Font', 'ddprodm'),
        'section' => 'ddpdm_tag_section',
        'choices' => $font_choices
    ));

    //  ===============================
    //  = COLUMNS Tag Pages title color  =
    //  ===============================

    $wp_customize->add_setting('ddpdm_tag_header_color_value_col', array(
        'default' => '#635c5c',
        'transport' => 'refresh'
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'ddpdm_tag_header_color_col', array(
        'label' => esc_html__('Post Title Color', 'ddprodm'),
        'section' => 'ddpdm_tag_section',
        'settings' => 'ddpdm_tag_header_color_value_col'
    )));



    $wp_customize->add_setting('ddpdm_tag_header_size_value_col', array(
        'default' => '18',
        'transport' => 'refresh'
    ));

    $wp_customize->add_control(new ET_Divi_Range_Option($wp_customize, 'ddpdm_tag_header_size_col', array(
        'label' => esc_html__('Post Title Font Size', 'ddprodm'),
        'section' => 'ddpdm_tag_section',
        'settings' => 'ddpdm_tag_header_size_value_col',
        'input_attrs' => array(
            'min' => 10,
            'max' => 72,
            'step' => 1
        )
    )));


    //  =============================
    //  = COLUMNS Tag Pages title font =
    //  =============================

    $wp_customize->add_setting('ddpdm_tag_header_font_col', array(
        'sanitize_callback' => 'ddpdm_sanitize_fonts',
        'default' => 'Roboto',
        'transport' => 'refresh'
    ));

    $wp_customize->add_control('ddpdm_tag_header_font_col', array(
        'type' => 'select',
        'label' => esc_html__('Post Title Font', 'ddprodm'),
        'section' => 'ddpdm_tag_section',
        'choices' => $font_choices
    ));


    //  ==============================
    //  = COLUMNS Tag Pages title style =
    //  ==============================

    $wp_customize->add_setting('ddpdm_tag_header_font_style_col', array(
        'transport' => 'refresh'
    ));

    $wp_customize->add_control(new ET_Divi_Font_Style_Option($wp_customize, 'ddpdm_tag_header_font_select_col', array(
        'label' => esc_html__('Post Title Font style', 'ddprodm'),
        'section' => 'ddpdm_tag_section',
        'settings' => 'ddpdm_tag_header_font_style_col',
        'type' => 'font_style',
        'choices' => et_divi_font_style_choices()
    )));

    //  ===============================
    //  = COLUMNS Tag Pages date color  =
    //  ===============================

    $wp_customize->add_setting('ddpdm_tag_date_color_value_col', array(
        'default' => '#33373a',
        'transport' => 'refresh'
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'ddpdm_tag_date_color_col', array(
        'label' => esc_html__('Date Font Color', 'ddprodm'),
        'section' => 'ddpdm_tag_section',
        'settings' => 'ddpdm_tag_date_color_value_col'
    )));

    $wp_customize->add_setting('ddpdm_tag_date_size_value_col', array(
        'default' => '16',
        'transport' => 'refresh'
    ));

    $wp_customize->add_control(new ET_Divi_Range_Option($wp_customize, 'ddpdm_tag_header_size_col', array(
        'label' => esc_html__('Date Font Size', 'ddprodm'),
        'section' => 'ddpdm_tag_section',
        'settings' => 'ddpdm_tag_date_size_value_col',
        'input_attrs' => array(
            'min' => 10,
            'max' => 72,
            'step' => 1
        )
    )));

    $wp_customize->add_setting('ddpdm_tag_date_bgcolor_value_col', array(
        'default' => '#f2f1ec',
        'transport' => 'refresh'
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'ddpdm_tag_date_bgcolor_col', array(
        'label' => esc_html__('Date Background Color', 'ddprodm'),
        'section' => 'ddpdm_tag_section',
        'settings' => 'ddpdm_tag_date_bgcolor_value_col'
    )));



    //  =============================
    //  = COLUMNS Tag Pages content     =
    //  =============================

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'ddpdm_tag_meta_color_col', array(
        'label' => esc_html__('Meta Data Text Color', 'ddprodm'),
        'section' => 'ddpdm_tag_section',
        'settings' => 'ddpdm_tag_meta_color_value_col'
    )));

    $wp_customize->add_control(new ET_Divi_Range_Option($wp_customize, 'ddpdm_tag_meta_size_col', array(
        'label' => esc_html__('Meta Data Font Size', 'ddprodm'),
        'section' => 'ddpdm_global_template_section',
        'settings' => 'ddpdm_tag_meta_size_value_col',
        'input_attrs' => array(
            'min' => 10,
            'max' => 72,
            'step' => 1
        )
    )));



    //  ============================================
    //  = COLUMNS Tag Pages Continue Reading    =
    //  ============================================

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'ddpdm_tag_rm_color_col', array(
        'label' => esc_html__('Continue Reading Text Color', 'ddprodm'),
        'section' => 'ddpdm_tag_section',
        'settings' => 'ddpdm_tag_rm_color_value_col'
    )));

    $wp_customize->add_control(new ET_Divi_Range_Option($wp_customize, 'ddpdm_tag_rm_size_col', array(
        'label' => esc_html__('Continue Reading Font Size', 'ddprodm'),
        'section' => 'ddpdm_tag_section',
        'settings' => 'ddpdm_tag_rm_size_value_col',
        'input_attrs' => array(
            'min' => 10,
            'max' => 72,
            'step' => 1
        )
    )));





    //  =============================
    //  = Author Select Box         =
    //  =============================


    if (ddpdm_is_divi_item_exists('Author Archive - Row w Sidebar - PHP Templ - Diana')) {
        $choices_array_author = array(
            'global' => esc_html__('Global Template', 'ddprodm'),
            'diana_1' => esc_html__('Diana Author - Row - With Sidebar', 'ddprodm'),
            'diana_2' => esc_html__('Diana Author - 2 col grid', 'ddprodm'),
            'diana_3' => esc_html__('Diana Author - 3 col grid', 'ddprodm'),
            'diana_4' => esc_html__('Diana Author - 4 col grid', 'ddprodm'),
            'disabled' => esc_html__('Disabled (use WordPress default)', 'ddprodm')
        );

    }

    else {
        $choices_array_author = array(
            'global' => esc_html__('Global Template', 'ddprodm'),
            'diana_2' => esc_html__('Diana Author - 2 col grid', 'ddprodm'),
            'diana_3' => esc_html__('Diana Author - 3 col grid', 'ddprodm'),
            'diana_4' => esc_html__('Diana Author - 4 col grid', 'ddprodm'),
            'disabled' => esc_html__('Disabled (use WordPress default)', 'ddprodm')
        );

    }

    $wp_customize->add_setting('ddpdm_author_page_template', array(
        'default' => 'global',
        'capability' => 'edit_theme_options',
        'type' => 'option'

    ));
    $wp_customize->add_control('ddpdm_author_select_box', array(
        'settings' => 'ddpdm_author_page_template',
        'label' => esc_html__('Author Archive Template', 'ddprodm'),
        'description' => '<p><a href="https://seku.re/divi-den-theme-builder" target="_blank" class="button button-secondary">'.__('Learn More - Watch a short video tutorial', 'ddprodm').'</a></p><p>'.__('This will rewrite your current Author page template. No saved templates yet?', 'ddprodm').' <a href="/wp-admin/admin.php?page=divi_den_pro_dm_dashboard&tab=ddpdm_settings">'.'First save some here'.'</a>. '.__('After saving they will appear in the drop-down below. You can also modify certain saved templates', 'ddprodm').' <a href="/wp-admin/edit.php?post_type=et_pb_layout&layout_category=author-archive-page" target="_blank">'.__('in the Divi Library', 'ddprodm').'</a>.</p><label class="customize-control-title">'.__('Saved Author Archive Templates', 'ddprodm').'</label><p>'.__('Choose a saved template to edit.', 'ddprodm').'</p>',
        'section' => 'ddpdm_global_template_section',
        'section' => 'ddpdm_author_section',
        'type' => 'select',
        'choices' => $choices_array_author
    ));

    $wp_customize->add_setting('ddpdm_author_content_color_value', array(
        'default' => '#a6a6a6',
        'transport' => 'refresh'
    ));

    $wp_customize->add_setting('ddpdm_author_content_size_value', array(
        'default' => '16',
        'transport' => 'refresh'
    ));

    $wp_customize->add_setting('ddpdm_author_rm_color_value', array(
        'default' => '#33373a',
        'transport' => 'refresh'
    ));

    $wp_customize->add_setting('ddpdm_author_rm_size_value', array(
        'default' => '16',
        'transport' => 'refresh'
    ));

    //  ===================================================
    //  = Author Archive Pages author name color and size =
    //  ===================================================

    $wp_customize->add_setting('ddpdm_author_name_color_value', array(
        'default' => '#33373a',
        'transport' => 'refresh'
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'ddpdm_author_name_color', array(
        'label' => esc_html__('Author Name Color', 'ddprodm'),
        'section' => 'ddpdm_author_section',
        'settings' => 'ddpdm_author_name_color_value'
    )));



    $wp_customize->add_setting('ddpdm_author_name_size_value', array(
        'default' => '24',
        'transport' => 'refresh'
    ));

    $wp_customize->add_control(new ET_Divi_Range_Option($wp_customize, 'ddpdm_author_name_size', array(
        'label' => esc_html__('Author Name Font Size', 'ddprodm'),
        'section' => 'ddpdm_author_section',
        'settings' => 'ddpdm_author_name_size_value',
        'input_attrs' => array(
            'min' => 10,
            'max' => 72,
            'step' => 1
        )
    )));


    //  ===================================================
    //  = Author Archive Pages author bio color and size =
    //  ===================================================

    $wp_customize->add_setting('ddpdm_author_bio_color_value', array(
        'default' => '#a6a6a6',
        'transport' => 'refresh'
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'ddpdm_author_bio_color', array(
        'label' => esc_html__('Author Bio Color', 'ddprodm'),
        'section' => 'ddpdm_author_section',
        'settings' => 'ddpdm_author_bio_color_value'
    )));



    $wp_customize->add_setting('ddpdm_author_bio_size_value', array(
        'default' => '16',
        'transport' => 'refresh'
    ));

    $wp_customize->add_control(new ET_Divi_Range_Option($wp_customize, 'ddpdm_author_bio_size', array(
        'label' => esc_html__('Author Bio Font Size', 'ddprodm'),
        'section' => 'ddpdm_author_section',
        'settings' => 'ddpdm_author_bio_size_value',
        'input_attrs' => array(
            'min' => 10,
            'max' => 72,
            'step' => 1
        )
    )));

    //  ===============================
    //  = Author Pages title color  =
    //  ===============================

    $wp_customize->add_setting('ddpdm_author_header_color_value', array(
        'default' => '#635c5c',
        'transport' => 'refresh'
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'ddpdm_author_header_color', array(
        'label' => esc_html__('Post Title Color', 'ddprodm'),
        'section' => 'ddpdm_author_section',
        'settings' => 'ddpdm_author_header_color_value'
    )));



    $wp_customize->add_setting('ddpdm_author_header_size_value', array(
        'default' => '18',
        'transport' => 'refresh'
    ));

    $wp_customize->add_control(new ET_Divi_Range_Option($wp_customize, 'ddpdm_author_header_size', array(
        'label' => esc_html__('Post Title Font Size', 'ddprodm'),
        'section' => 'ddpdm_author_section',
        'settings' => 'ddpdm_author_header_size_value',
        'input_attrs' => array(
            'min' => 10,
            'max' => 72,
            'step' => 1
        )
    )));


    //  =============================
    //  = Author Pages title font =
    //  =============================

    $wp_customize->add_setting('ddpdm_author_header_font', array(
        'sanitize_callback' => 'ddpdm_sanitize_fonts',
        'default' => 'Roboto',
        'transport' => 'refresh'
    ));

    $wp_customize->add_control('ddpdm_author_header_font', array(
        'type' => 'select',
        'label' => esc_html__('Post Title Font', 'ddprodm'),
        'section' => 'ddpdm_author_section',
        'choices' => $font_choices
    ));


    //  ==============================
    //  = Author Pages title style =
    //  ==============================

    $wp_customize->add_setting('ddpdm_author_header_font_style', array(
        'transport' => 'refresh'
    ));

    $wp_customize->add_control(new ET_Divi_Font_Style_Option($wp_customize, 'ddpdm_author_header_font_select', array(
        'label' => esc_html__('Post Title Font style', 'ddprodm'),
        'section' => 'ddpdm_author_section',
        'settings' => 'ddpdm_author_header_font_style',
        'type' => 'font_style',
        'choices' => et_divi_font_style_choices()
    )));

    //  ===============================
    //  = Author Pages date color  =
    //  ===============================

    $wp_customize->add_setting('ddpdm_author_date_color_value', array(
        'default' => '#33373a',
        'transport' => 'refresh'
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'ddpdm_author_date_color', array(
        'label' => esc_html__('Date Font Color', 'ddprodm'),
        'section' => 'ddpdm_author_section',
        'settings' => 'ddpdm_author_date_color_value'
    )));

    $wp_customize->add_setting('ddpdm_author_date_size_value', array(
        'default' => '16',
        'transport' => 'refresh'
    ));

    $wp_customize->add_control(new ET_Divi_Range_Option($wp_customize, 'ddpdm_author_header_size', array(
        'label' => esc_html__('Date Font Size', 'ddprodm'),
        'section' => 'ddpdm_author_section',
        'settings' => 'ddpdm_author_date_size_value',
        'input_attrs' => array(
            'min' => 10,
            'max' => 72,
            'step' => 1
        )
    )));

    $wp_customize->add_setting('ddpdm_author_date_bgcolor_value', array(
        'default' => '#f2f1ec',
        'transport' => 'refresh'
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'ddpdm_author_date_bgcolor', array(
        'label' => esc_html__('Date Background Color', 'ddprodm'),
        'section' => 'ddpdm_author_section',
        'settings' => 'ddpdm_author_date_bgcolor_value'
    )));



    //  =============================
    //  = Author Pages content     =
    //  =============================

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'ddpdm_author_content_color', array(
        'label' => esc_html__('Body Text Color', 'ddprodm'),
        'section' => 'ddpdm_author_section',
        'settings' => 'ddpdm_author_content_color_value'
    )));

    $wp_customize->add_control(new ET_Divi_Range_Option($wp_customize, 'ddpdm_author_content_size', array(
        'label' => esc_html__('Body Font Size', 'ddprodm'),
        'section' => 'ddpdm_author_section',
        'settings' => 'ddpdm_author_content_size_value',
        'input_attrs' => array(
            'min' => 10,
            'max' => 72,
            'step' => 1
        )
    )));


    //  ===============================
    //  = Author Pages content font =
    //  ===============================

    $wp_customize->add_setting('ddpdm_author_body_font', array(
        'sanitize_callback' => 'ddpdm_sanitize_fonts',
        'default' => 'Roboto',
        'transport' => 'refresh'
    ));

    $wp_customize->add_control('ddpdm_author_body_font', array(
        'type' => 'select',
        'label' => esc_html__('Body Font', 'ddprodm'),
        'section' => 'ddpdm_author_section',
        'choices' => $font_choices
    ));


    //  ================================
    //  = Author Pages content style =
    //  ================================

    $wp_customize->add_setting('ddpdm_author_body_font_style', array(
        'transport' => 'refresh'
    ));

    $wp_customize->add_control(new ET_Divi_Font_Style_Option($wp_customize, 'ddpdm_author_body_font_select', array(
        'label' => esc_html__('Body Font style', 'ddprodm'),
        'section' => 'ddpdm_author_section',
        'settings' => 'ddpdm_author_body_font_style',
        'type' => 'font_style',
        'choices' => et_divi_font_style_choices()
    )));


    //  =============================
    //  = Author Pages Read More    =
    //  =============================

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'ddpdm_author_rm_color', array(
        'label' => esc_html__('Read More Text Color', 'ddprodm'),
        'section' => 'ddpdm_author_section',
        'settings' => 'ddpdm_author_rm_color_value'
    )));

    $wp_customize->add_control(new ET_Divi_Range_Option($wp_customize, 'ddpdm_author_rm_size', array(
        'label' => esc_html__('Read More Font Size', 'ddprodm'),
        'section' => 'ddpdm_author_section',
        'settings' => 'ddpdm_author_rm_size_value',
        'input_attrs' => array(
            'min' => 10,
            'max' => 72,
            'step' => 1
        )
    )));


    $wp_customize->add_setting('ddpdm_author_meta_color_value_col', array(
        'default' => '#a6a6a6',
        'transport' => 'refresh'
    ));

    $wp_customize->add_setting('ddpdm_author_meta_size_value_col', array(
        'default' => '14',
        'transport' => 'refresh'
    ));

    $wp_customize->add_setting('ddpdm_author_rm_color_value_col', array(
        'default' => '#33373a',
        'transport' => 'refresh'
    ));

    $wp_customize->add_setting('ddpdm_author_rm_size_value_col', array(
        'default' => '16',
        'transport' => 'refresh'
    ));

    //  ===================================================
    //  = COLUMNS Author Archive Pages author name color and size =
    //  ===================================================

    $wp_customize->add_setting('ddpdm_author_name_color_value_col', array(
        'default' => '#33373a',
        'transport' => 'refresh'
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'ddpdm_author_name_color_col', array(
        'label' => esc_html__('Author Name Color', 'ddprodm'),
        'section' => 'ddpdm_author_section',
        'settings' => 'ddpdm_author_name_color_value_col'
    )));



    $wp_customize->add_setting('ddpdm_author_name_size_value_col', array(
        'default' => '24',
        'transport' => 'refresh'
    ));

    $wp_customize->add_control(new ET_Divi_Range_Option($wp_customize, 'ddpdm_author_name_size_col', array(
        'label' => esc_html__('Author Name Font Size', 'ddprodm'),
        'section' => 'ddpdm_author_section',
        'settings' => 'ddpdm_author_name_size_value_col',
        'input_attrs' => array(
            'min' => 10,
            'max' => 72,
            'step' => 1
        )
    )));


    //  ===================================================
    //  = Author Archive Pages author bio color and size =
    //  ===================================================

    $wp_customize->add_setting('ddpdm_author_bio_color_value_col', array(
        'default' => '#a6a6a6',
        'transport' => 'refresh'
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'ddpdm_author_bio_color_col', array(
        'label' => esc_html__('Author Bio Color', 'ddprodm'),
        'section' => 'ddpdm_author_section',
        'settings' => 'ddpdm_author_bio_color_value_col'
    )));



    $wp_customize->add_setting('ddpdm_author_bio_size_value_col', array(
        'default' => '16',
        'transport' => 'refresh'
    ));

    $wp_customize->add_control(new ET_Divi_Range_Option($wp_customize, 'ddpdm_author_bio_size_col', array(
        'label' => esc_html__('Author Bio Font Size', 'ddprodm'),
        'section' => 'ddpdm_author_section',
        'settings' => 'ddpdm_author_bio_size_value_col',
        'input_attrs' => array(
            'min' => 10,
            'max' => 72,
            'step' => 1
        )
    )));


    //  ===============================
    //  = COLUMNS Author Meta Data and Continue Reading Font  =
    //  ===============================

    $wp_customize->add_setting('ddpdm_author_mdcr_font_col', array(
        'sanitize_callback' => 'ddpdm_sanitize_fonts',
        'default' => 'Roboto',
        'transport' => 'refresh'
    ));

    $wp_customize->add_control('ddpdm_author_mdcr_font_col', array(
        'type' => 'select',
        'label' => esc_html__('Meta Data and Continue Reading Font', 'ddprodm'),
        'section' => 'ddpdm_author_section',
        'choices' => $font_choices
    ));


    //  ===============================
    //  = COLUMNS Author Pages title color  =
    //  ===============================

    $wp_customize->add_setting('ddpdm_author_header_color_value_col', array(
        'default' => '#635c5c',
        'transport' => 'refresh'
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'ddpdm_author_header_color_col', array(
        'label' => esc_html__('Post Title Color', 'ddprodm'),
        'section' => 'ddpdm_author_section',
        'settings' => 'ddpdm_author_header_color_value_col'
    )));



    $wp_customize->add_setting('ddpdm_author_header_size_value_col', array(
        'default' => '18',
        'transport' => 'refresh'
    ));

    $wp_customize->add_control(new ET_Divi_Range_Option($wp_customize, 'ddpdm_author_header_size_col', array(
        'label' => esc_html__('Post Title Font Size', 'ddprodm'),
        'section' => 'ddpdm_author_section',
        'settings' => 'ddpdm_author_header_size_value_col',
        'input_attrs' => array(
            'min' => 10,
            'max' => 72,
            'step' => 1
        )
    )));


    //  =============================
    //  = COLUMNS Category Pages title font =
    //  =============================

    $wp_customize->add_setting('ddpdm_author_header_font_col', array(
        'sanitize_callback' => 'ddpdm_sanitize_fonts',
        'default' => 'Roboto',
        'transport' => 'refresh'
    ));

    $wp_customize->add_control('ddpdm_author_header_font_col', array(
        'type' => 'select',
        'label' => esc_html__('Post Title Font', 'ddprodm'),
        'section' => 'ddpdm_author_section',
        'choices' => $font_choices
    ));


    //  ==============================
    //  = COLUMNS Category Pages title style =
    //  ==============================

    $wp_customize->add_setting('ddpdm_author_header_font_style_col', array(
        'transport' => 'refresh'
    ));

    $wp_customize->add_control(new ET_Divi_Font_Style_Option($wp_customize, 'ddpdm_author_header_font_select_col', array(
        'label' => esc_html__('Post Title Font style', 'ddprodm'),
        'section' => 'ddpdm_author_section',
        'settings' => 'ddpdm_author_header_font_style_col',
        'type' => 'font_style',
        'choices' => et_divi_font_style_choices()
    )));

    //  ===============================
    //  = COLUMNS Author Pages date color  =
    //  ===============================

    $wp_customize->add_setting('ddpdm_author_date_color_value_col', array(
        'default' => '#33373a',
        'transport' => 'refresh'
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'ddpdm_author_date_color_col', array(
        'label' => esc_html__('Date Font Color', 'ddprodm'),
        'section' => 'ddpdm_author_section',
        'settings' => 'ddpdm_author_date_color_value_col'
    )));

    $wp_customize->add_setting('ddpdm_author_date_size_value_col', array(
        'default' => '16',
        'transport' => 'refresh'
    ));

    $wp_customize->add_control(new ET_Divi_Range_Option($wp_customize, 'ddpdm_author_header_size_col', array(
        'label' => esc_html__('Date Font Size', 'ddprodm'),
        'section' => 'ddpdm_author_section',
        'settings' => 'ddpdm_author_date_size_value_col',
        'input_attrs' => array(
            'min' => 10,
            'max' => 72,
            'step' => 1
        )
    )));

    $wp_customize->add_setting('ddpdm_author_date_bgcolor_value_col', array(
        'default' => '#f2f1ec',
        'transport' => 'refresh'
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'ddpdm_author_date_bgcolor_col', array(
        'label' => esc_html__('Date Background Color', 'ddprodm'),
        'section' => 'ddpdm_author_section',
        'settings' => 'ddpdm_author_date_bgcolor_value_col'
    )));



    //  =============================
    //  = COLUMNS Author Pages content     =
    //  =============================

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'ddpdm_author_meta_color_col', array(
        'label' => esc_html__('Meta Data Text Color', 'ddprodm'),
        'section' => 'ddpdm_author_section',
        'settings' => 'ddpdm_author_meta_color_value_col'
    )));

    $wp_customize->add_control(new ET_Divi_Range_Option($wp_customize, 'ddpdm_author_meta_size_col', array(
        'label' => esc_html__('Meta Data Font Size', 'ddprodm'),
        'section' => 'ddpdm_author_section',
        'settings' => 'ddpdm_author_meta_size_value_col',
        'input_attrs' => array(
            'min' => 10,
            'max' => 72,
            'step' => 1
        )
    )));



    //  ============================================
    //  = COLUMNS Category Pages Continue Reading    =
    //  ============================================

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'ddpdm_author_rm_color_col', array(
        'label' => esc_html__('Continue Reading Text Color', 'ddprodm'),
        'section' => 'ddpdm_author_section',
        'settings' => 'ddpdm_author_rm_color_value_col'
    )));

    $wp_customize->add_control(new ET_Divi_Range_Option($wp_customize, 'ddpdm_author_rm_size_col', array(
        'label' => esc_html__('Continue Reading Font Size', 'ddprodm'),
        'section' => 'ddpdm_author_section',
        'settings' => 'ddpdm_author_rm_size_value_col',
        'input_attrs' => array(
            'min' => 10,
            'max' => 72,
            'step' => 1
        )
    )));




    //  =============================
    //  = Search Results Select Box =
    //  =============================
    $wp_customize->add_setting('ddpdm_search_results_page_template', array(
        'default' => 'disabled',
        'capability' => 'edit_theme_options',
        'type' => 'option'

    ));

    $wp_customize->add_setting('ddpdm_search_results_meta_size_value', array(
        'default' => '14',
        'transport' => 'refresh'
    ));

    $wp_customize->add_setting('ddpdm_search_results_content_color_value', array(
        'default' => '#a6a6a6',
        'transport' => 'refresh'
    ));

    $wp_customize->add_setting('ddpdm_search_results_content_size_value', array(
        'default' => '16',
        'transport' => 'refresh'
    ));

    $wp_customize->add_setting('ddpdm_search_results_rm_color_value', array(
        'default' => '#33373a',
        'transport' => 'refresh'
    ));

    $wp_customize->add_setting('ddpdm_search_results_rm_size_value', array(
        'default' => '16',
        'transport' => 'refresh'
    ));

    $wp_customize->add_setting('ddpdm_search_results_line_color_value', array(
        'default' => '#e4e4e3',
        'transport' => 'refresh'
    ));

    $wp_customize->add_setting('ddpdm_search_results_line_thickness_value', array(
        'default' => '1',
        'transport' => 'refresh'
    ));


    if (ddpdm_is_divi_item_exists('Search - Row w Sidebar - PHP Templ - Diana')) {
        $choices_array_search = array(
            'disabled' => esc_html__('Disabled (use WordPress default)', 'ddprodm'),
            'diana_1' => esc_html__('Diana Search - Row - With Sidebar', 'ddprodm')
        );
    } else {
        $choices_array_search = array(
            'disabled' => esc_html__('Disabled (use WordPress default)', 'ddprodm')
        );

    }

    $wp_customize->add_control('ddpdm_search_results_select_box', array(
        'settings' => 'ddpdm_search_results_page_template',
        'label' => esc_html__('Search Results Template', 'ddprodm'),
        'description' => '<p><a href="https://seku.re/divi-den-theme-builder" target="_blank" class="button button-secondary">'.__('Learn More - Watch a short video tutorial', 'ddprodm').'</a></p><p>'.__('This will rewrite your current Search Results template. No saved templates yet?', 'ddprodm').' <a href="/wp-admin/admin.php?page=divi_den_pro_dm_dashboard&tab=ddpdm_settings">'.__('First save some here', 'ddprodm').'</a>. '.__('After saving they will appear in the drop-down below. You can also modify certain saved templates', 'ddprodm').' <a href="/wp-admin/edit.php?post_type=et_pb_layout&layout_category=search-results-page" target="_blank">'.__('in the Divi Library', 'ddprodm').'</a>.</p><label class="customize-control-title">'.__('Saved Search Results Templates', 'ddprodm').'</label><p>'.__('Choose a saved template to edit.', 'ddprodm').'</p>',
        'section' => 'ddpdm_global_template_section',
        'section' => 'ddpdm_search_results_section',
        'type' => 'select',
        'choices' => $choices_array_search
    ));


    //  ===============================
    //  = Search results title color  =
    //  ===============================

    $wp_customize->add_setting('ddpdm_search_results_header_color_value', array(
        'default' => '#635c5c',
        'transport' => 'refresh'
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'ddpdm_search_results_header_color', array(
        'label' => esc_html__('Post Title Color', 'ddprodm'),
        'section' => 'ddpdm_search_results_section',
        'settings' => 'ddpdm_search_results_header_color_value'
    )));



    $wp_customize->add_setting('ddpdm_search_results_header_size_value', array(
        'default' => '18',
        'transport' => 'refresh'
    ));

    $wp_customize->add_control(new ET_Divi_Range_Option($wp_customize, 'ddpdm_search_results_header_size', array(
        'label' => esc_html__('Post Title Font Size', 'ddprodm'),
        'section' => 'ddpdm_search_results_section',
        'settings' => 'ddpdm_search_results_header_size_value',
        'input_attrs' => array(
            'min' => 10,
            'max' => 72,
            'step' => 1
        )
    )));


    //  =============================
    //  = Search results title font =
    //  =============================

    $wp_customize->add_setting('ddpdm_search_results_header_font', array(
        'sanitize_callback' => 'ddpdm_sanitize_fonts',
        'default' => 'Roboto',
        'transport' => 'refresh'
    ));

    $wp_customize->add_control('ddpdm_search_results_header_font', array(
        'type' => 'select',
        'label' => esc_html__('Post Title Font', 'ddprodm'),
        'section' => 'ddpdm_search_results_section',
        'choices' => $font_choices
    ));


    //  ==============================
    //  = Search results title style =
    //  ==============================

    $wp_customize->add_setting('ddpdm_search_results_header_font_style', array(
        'transport' => 'refresh'
    ));

    $wp_customize->add_control(new ET_Divi_Font_Style_Option($wp_customize, 'ddpdm_search_results_header_font_select', array(
        'label' => esc_html__('Post Title Font style', 'ddprodm'),
        'section' => 'ddpdm_search_results_section',
        'settings' => 'ddpdm_search_results_header_font_style',
        'type' => 'font_style',
        'choices' => et_divi_font_style_choices()
    )));


    //  =============================
    //  = Search results meta       =
    //  =============================

    $wp_customize->add_setting('ddpdm_search_results_meta_color_value', array(
        'default' => '#a6a6a6',
        'transport' => 'refresh'
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'ddpdm_search_results_meta_color', array(
        'label' => esc_html__('Meta Data Color', 'ddprodm'),
        'section' => 'ddpdm_search_results_section',
        'settings' => 'ddpdm_search_results_meta_color_value'
    )));

    $wp_customize->add_control(new ET_Divi_Range_Option($wp_customize, 'ddpdm_search_results_meta_size', array(
        'label' => esc_html__('Meta Data Font Size', 'ddprodm'),
        'section' => 'ddpdm_search_results_section',
        'settings' => 'ddpdm_search_results_meta_size_value',
        'input_attrs' => array(
            'min' => 10,
            'max' => 72,
            'step' => 1
        )
    )));




    //  =============================
    //  = Search results content     =
    //  =============================

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'ddpdm_search_results_content_color', array(
        'label' => esc_html__('Body Text Color', 'ddprodm'),
        'section' => 'ddpdm_search_results_section',
        'settings' => 'ddpdm_search_results_content_color_value'
    )));

    $wp_customize->add_control(new ET_Divi_Range_Option($wp_customize, 'ddpdm_search_results_content_size', array(
        'label' => esc_html__('Body Font Size', 'ddprodm'),
        'section' => 'ddpdm_search_results_section',
        'settings' => 'ddpdm_search_results_content_size_value',
        'input_attrs' => array(
            'min' => 10,
            'max' => 72,
            'step' => 1
        )
    )));


    //  ===============================
    //  = Search results content font =
    //  ===============================

    $wp_customize->add_setting('ddpdm_search_results_body_font', array(
        'sanitize_callback' => 'ddpdm_sanitize_fonts',
        'default' => 'Roboto',
        'transport' => 'refresh'
    ));

    $wp_customize->add_control('ddpdm_search_results_body_font', array(
        'type' => 'select',
        'label' => esc_html__('Body Font', 'ddprodm'),
        'section' => 'ddpdm_search_results_section',
        'choices' => $font_choices
    ));


    //  ================================
    //  = Search results content style =
    //  ================================

    $wp_customize->add_setting('ddpdm_search_results_body_font_style', array(
        'transport' => 'refresh'
    ));

    $wp_customize->add_control(new ET_Divi_Font_Style_Option($wp_customize, 'ddpdm_search_results_body_font_select', array(
        'label' => esc_html__('Body Font style'),
        'section' => 'ddpdm_search_results_section',
        'settings' => 'ddpdm_search_results_body_font_style',
        'type' => 'font_style',
        'choices' => et_divi_font_style_choices()
    )));


    //  =============================
    //  = Search results Read Me    =
    //  =============================

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'ddpdm_search_results_rm_color', array(
        'label' => esc_html__('Read More Text Color', 'ddprodm'),
        'section' => 'ddpdm_search_results_section',
        'settings' => 'ddpdm_search_results_rm_color_value'
    )));

    $wp_customize->add_control(new ET_Divi_Range_Option($wp_customize, 'ddpdm_search_results_rm_size', array(
        'label' => esc_html__('Read More Font Size', 'ddprodm'),
        'section' => 'ddpdm_search_results_section',
        'settings' => 'ddpdm_search_results_rm_size_value',
        'input_attrs' => array(
            'min' => 10,
            'max' => 72,
            'step' => 1
        )
    )));

    //  =============================
    //  = Search results Line       =
    //  =============================

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'ddpdm_search_results_line_color', array(
        'label' => esc_html__('Separating Line Color', 'ddprodm'),
        'section' => 'ddpdm_search_results_section',
        'settings' => 'ddpdm_search_results_line_color_value'
    )));

    $wp_customize->add_control(new ET_Divi_Range_Option($wp_customize, 'ddpdm_search_results_line_size', array(
        'label' => esc_html__('Separating Line Thickness', 'ddprodm'),
        'section' => 'ddpdm_search_results_section',
        'settings' => 'ddpdm_search_results_line_thickness_value',
        'input_attrs' => array(
            'min' => 0,
            'max' => 30,
            'step' => 1
        )
    )));


    //  =============================
    //  = 404 Select Box            =
    //  =============================
    $wp_customize->add_setting('ddpdm_404_page_template', array(
        'default' => 'disabled',
        'capability' => 'edit_theme_options',
        'type' => 'option'

    ));

    $choices_array_404             = array();
    $choices_array_404['disabled'] = esc_html__('Disabled (use WordPress default)', 'ddprodm');
    if (ddpdm_is_divi_item_exists('404 Animated Eye - PHP Templ - Diana'))
        $choices_array_404['diana_1'] = ddpdm_return_new_name('404 Animated Eye - PHP Templ - Diana');
    if (ddpdm_is_divi_item_exists('404 Not Found - PHP Templ - Diana'))
        $choices_array_404['diana_2'] = ddpdm_return_new_name('404 Not Found - PHP Templ - Diana');
    if (ddpdm_is_divi_item_exists('404 Search Again - PHP Templ - Diana'))
        $choices_array_404['diana_3'] = ddpdm_return_new_name('404 Search Again - PHP Templ - Diana');
    $additional_choices_array_404 = ddpdm_get_all_category_items('404 Page');

    //print_r( $additional_choices_array_404);

    delete_option('ddpdm_template_404_pages_custom');
    add_option('ddpdm_template_404_pages_custom', $additional_choices_array_404);

    //   print_r(get_option('ddpdm_template_404_pages_custom'));

    $choices_array_404 = array_merge($choices_array_404, $additional_choices_array_404);

    // echo '<pre>';
    // print_r($additional_choices_array_404);
    // echo '</pre>';



    $wp_customize->add_control('ddpdm_404_select_box', array(
        'settings' => 'ddpdm_404_page_template',
        'label' => esc_html__('404 Page Not Found Template', 'ddprodm'),
        'description' => '<p><a href="https://seku.re/divi-den-theme-builder" target="_blank" class="button button-secondary">'.__('Learn More - Watch a short video tutorial', 'ddprodm').'</a></p><p>'.__('This will rewrite your current 404 page not found template. No saved templates yet?', 'ddprodm').' <a href="/wp-admin/admin.php?page=divi_den_pro_dm_dashboard&tab=ddpdm_settings">'.__('First save some here', 'ddprodm').'</a>. '.__('After saving they will appear in the drop-down below. You can also modify certain saved templates', 'ddprodm').' <a href="/wp-admin/edit.php?post_type=et_pb_layout&layout_category=404-page" target="_blank">'.__('in the Divi Library', 'ddprodm').'</a>.<br><br><a href="https://seku.re/custom-404" target="_blank">'.__('Learn how to add a custom 404 Page', 'ddprodm').'</a>.</p><label class="customize-control-title">'.__('404 Page Not Found Templates', 'ddprodm').'</label><p>'.__('Choose a saved template to edit.', 'ddprodm').'</p>',
        'section' => 'ddpdm_404_section',
        'type' => 'select',
        'choices' => $choices_array_404
    ));

    //  =============================
    //  = Menu Select Box         =
    //  =============================

    $choices_array_menu             = array();
    $choices_array_menu['disabled'] = esc_html__('Disabled (use WordPress default)', 'ddprodm');
    if (ddpdm_is_divi_item_exists('Magnificent Mega Menu - PHP Templ - Diana'))
        $choices_array_menu['diana_1'] = 'Magnificent Mega Menu - Diana';
    if (ddpdm_is_divi_item_exists('Stately Mega Menu - PHP Templ - Diana'))
        $choices_array_menu['diana_2'] = 'Stately Mega Menu - Diana';
    if (ddpdm_is_divi_item_exists('Grandiose Mega Menu - PHP Templ - Diana'))
        $choices_array_menu['diana_3'] = 'Grandiose Mega Menu - Diana';
    if (ddpdm_is_divi_item_exists('Arch Menu - PHP Templ - Diana'))
        $choices_array_menu['diana_4'] = 'Arch Menu - Diana';
    if (ddpdm_is_divi_item_exists('First Menu - PHP Templ - Diana'))
        $choices_array_menu['diana_5'] = 'First Menu - Diana';
    if (ddpdm_is_divi_item_exists('Champion Menu - PHP Templ - Diana'))
        $choices_array_menu['diana_6'] = 'Champion Menu';
    if (ddpdm_is_divi_item_exists('Front Menu - PHP Templ - Diana'))
        $choices_array_menu['diana_7'] = 'Front Menu - Diana';
    if (ddpdm_is_divi_item_exists('Leading Menu - PHP Templ - Diana'))
        $choices_array_menu['diana_8'] = 'Leading Menu - Diana';
    if (ddpdm_is_divi_item_exists('Main Menu - PHP Templ - Diana'))
        $choices_array_menu['diana_9'] = 'Main Menu - Diana';
    if (ddpdm_is_divi_item_exists('Pioneer Menu - PHP Templ - Diana'))
        $choices_array_menu['diana_10'] = 'Pioneer Menu - Diana';
    if (ddpdm_is_divi_item_exists('Premier Menu - PHP Templ - Diana'))
        $choices_array_menu['diana_11'] = 'Premier Menu - Diana';
    if (ddpdm_is_divi_item_exists('Prime Menu - PHP Templ - Diana'))
        $choices_array_menu['diana_12'] = 'Prime Menu - Diana';
    if (ddpdm_is_divi_item_exists('Principal Menu - PHP Templ - Diana'))
        $choices_array_menu['diana_13'] = 'Principal Menu';
    if (ddpdm_is_divi_item_exists('Stellar Menu - PHP Templ - Diana'))
        $choices_array_menu['diana_14'] = 'Stellar Menu - Diana';
    if (ddpdm_is_divi_item_exists('Gimmi the Prize Menu - PHP Templ - Freddie'))
        $choices_array_menu['freddie_1'] = 'Gimmi the Prize Menu - Freddie';
    if (ddpdm_is_divi_item_exists('Dragon Attack Menu - PHP Templ - Freddie'))
        $choices_array_menu['freddie_2'] = 'Dragon Attack Menu - Freddie';
    if (ddpdm_is_divi_item_exists('Earth Menu - PHP Templ - Freddie'))
        $choices_array_menu['freddie_3'] = 'Earth Menu - Freddie';
    if (ddpdm_is_divi_item_exists('Funny How Love Is Menu - PHP Templ - Freddie'))
        $choices_array_menu['freddie_4'] = 'Funny How Love Is Menu - Freddie';
    if (ddpdm_is_divi_item_exists('Hang On In There Menu - PHP Templ - Freddie'))
        $choices_array_menu['freddie_5'] = 'Hang On In There Menu - Freddie';
    if (ddpdm_is_divi_item_exists('Lover Boy Menu - PHP Templ - Freddie'))
        $choices_array_menu['freddie_6'] = 'Lover Boy Menu - Freddie';
    if (ddpdm_is_divi_item_exists('Hijack My Heart Menu - PHP Templ - Freddie'))
        $choices_array_menu['freddie_7'] = 'Hijack My Heart Menu - Freddie';

    $additional_choices_array_menus = ddpdm_get_all_category_items('Mega Menu');
    $additional_choices_array_menus2 = ddpdm_get_all_category_items('Navigation Menu');

    $additional_choices_array_menus = $additional_choices_array_menus + $additional_choices_array_menus2;

    // if (!get_option( 'ddpdm_template_menus_custom')) add_option( 'ddpdm_template_menus_custom', $additional_choices_array_menus);
    //  else {
    //     delete_option('ddpdm_template_menu_custom');
    //     add_option('ddpdm_template_menu_custom', $additional_choices_array_menus);
    // }
    delete_option('ddpdm_template_menus_custom');
    add_option('ddpdm_template_menus_custom', $additional_choices_array_menus);

    $choices_array_menu = array_merge($choices_array_menu, $additional_choices_array_menus);



    $wp_customize->add_setting('ddpdm_menu_template', array(
        'default' => 'disabled',
        'capability' => 'edit_theme_options',
        'type' => 'option'

    ));
    $wp_customize->add_control('ddpdm_menu_select_box', array(
        'settings' => 'ddpdm_menu_template',
        'label' => esc_html__('Top navigation menu', 'ddprodm'),
        'description' => '<p><a href="https://seku.re/divi-den-theme-builder" target="_blank" class="button button-secondary">'.__('Learn More - Watch a short video tutorial', 'ddprodm').'</a></p><p>'.__('This will rewrite your current global navigation menu. No saved templates yet?', 'ddprodm').' <a href="/wp-admin/admin.php?page=divi_den_pro_dm_dashboard&tab=ddpdm_settings">'.__('First save some here', 'ddprodm').'</a>. '.__('After saving they will appear in the drop-down below. You can also modify certain saved templates', 'ddprodm').' <a href="/wp-admin/edit.php?post_type=et_pb_layout&layout_category=mega-menu" target="_blank">'.__('in the Divi Library', 'ddprodm').'</a>. <br><br><a href="https://seku.re/custom-navigation-menu" target="_blank">'.__('Learn how to add a custom Navigation Menu', 'ddprodm').'</a>.</p><label class="customize-control-title">'.__('Saved Global Navigation Menus', 'ddprodm').'</label><p>'.__('Choose a saved template to edit.', 'ddprodm').'</p>',
        'section' => 'ddpdm_menu_section',
        'type' => 'select',
        'choices' => $choices_array_menu
    ));

    $wp_customize->add_setting('ddpdm_menu_fixed', array(
        // 'type'          => 'option',
        'capability' => 'edit_theme_options',
        'transport' => 'refresh',
        'default' => false,
        'sanitize_callback' => 'ddpdm_sanitize_checkbox'
    ));

    $wp_customize->add_control('ddpdm_menu_fixed_checkbox', array(
        'settings' => 'ddpdm_menu_fixed',
        'label' => esc_html__('Fixed Global Navigation Menu', 'ddprodm'),
        'section' => 'ddpdm_menu_section',
        'type' => 'checkbox'
    ));



    //Add mobile menu sections
    $wp_customize->add_section('ddpdm_mobile_menu_section', array(
        'priority' => 100,
        'title' => esc_html__('Global Mobile Menu', 'ddprodm'),
        'panel' => 'ddpdm_global_navigation_panel'
    ));

    $choices_array_mobile_menu             = array();
    $choices_array_mobile_menu['disabled'] = esc_html__('Divi Default Mobile Menu', 'ddprodm');
    $choices_array_mobile_menu['mobile_menu_custom'] = esc_html__('Custom Divi Mobile Menu', 'ddprodm');
    $choices_array_mobile_menu['mobile_menu_1'] = esc_html__('Tab Mobile Menu', 'ddprodm');
    $choices_array_mobile_menu['mobile_menu_2'] = esc_html__('Click Mobile Menu', 'ddprodm');
    $choices_array_mobile_menu['mobile_menu_3'] = esc_html__('Info Mobile Menu', 'ddprodm');




 $wp_customize->add_setting('ddpdm_mobile_menu_template', array(
        'default' => 'disabled',
        'capability' => 'edit_theme_options',
        'type' => 'option'

    ));
    $wp_customize->add_control('ddpdm_mobile_menu_select_box', array(
        'settings' => 'ddpdm_mobile_menu_template',
        'label' => esc_html__('Choose a mobile menu', 'ddprodm'),
        'description' => '<p><a href="https://seku.re/mobile-menu-kb" target="_blank" class="button button-secondary">'.__('Learn More - Watch a short video tutorial', 'ddprodm').'</a></p><p>'.__('For default Divi mobile menu only: This option will rewrite your current mobile menu or add a new one. Your desktop menu will remain unchanged. Or you can only show the mobile menu by using the settings below.', 'ddprodm').'</p><label class="customize-control-title">'.__('Global Mobile Menus', 'ddprodm').'</label><p>'.__('Choose a menu to edit.', 'ddprodm').'</p>',
        'section' => 'ddpdm_mobile_menu_section',
        'type' => 'select',
        'choices' => $choices_array_mobile_menu
    ));

    // Load post preview

    $wp_customize->add_control('ddpdm_mobile_menu_preview_mobile', array(
        'section' => 'ddpdm_mobile_menu_section',
        'settings' => array(),
        'type' => 'button',
        'priority' => 1,
        'input_attrs' => array(
            'value' => esc_html__('Preview the menu', 'ddprodm'),
            'class' => 'button button-secondary ddpdm-click-on-load hidden',
            'onclick' => 'document.body.classList.add("preview-ddp"); '
        )
    ));

     $wp_customize->add_setting('ddpdm_mobile_menu_show', array(
        // 'type'          => 'option',
        'capability' => 'edit_theme_options',
        // 'transport' => 'refresh',
        'default' => false,
        'sanitize_callback' => 'ddpdm_sanitize_checkbox'
    ));

    $wp_customize->add_control('ddpdm_mobile_menu_show_checkbox', array(
        'settings' => 'ddpdm_mobile_menu_show',
        'label' => esc_html__('Only show mobile menu (removes desktop menu)', 'ddprodm'),
        'section' => 'ddpdm_mobile_menu_section',
        'type' => 'checkbox'
    ));


    $wp_customize->add_setting('ddpdm_mobile_menu_screen_size', array(
        'default' => '980',
        'transport' => 'refresh'
    ));


    $wp_customize->add_control(new ET_Divi_Range_Option($wp_customize, 'ddpdm_mobile_menu_screen_size_range', array(
        'label' => esc_html__('Choose a screen size to show the Mobile menu from (and below)', 'ddprodm'),
        'description' => '0 - disable the Mobile menu',
        'section' => 'ddpdm_mobile_menu_section',
        'settings' => 'ddpdm_mobile_menu_screen_size',
        'input_attrs' => array(
            'min' => 0,
            'max' => 1920,
            'step' => 1
        )
    )));

        // MENU Custom


    //  $wp_customize->add_setting('ddpdm_mobile_menu_custom_open', array(
    //     // 'type'          => 'option',
    //     'capability' => 'edit_theme_options',
    //     // 'transport' => 'refresh',
    //     'default' => false,
    //     'sanitize_callback' => 'ddpdm_sanitize_checkbox'
    // ));

    // $wp_customize->add_control('ddpdm_mobile_menu_custom_open_checkbox', array(
    //     'settings' => 'ddpdm_mobile_menu_custom_open',
    //     'label' => esc_html__('Open sub-menus by default', 'ddprodm'),
    //     'section' => 'ddpdm_mobile_menu_section',
    //     'type' => 'checkbox'
    // ));


     $wp_customize->add_setting('ddpdm_mobile_menu_custom_background_color', array(
        'default' => '',
        'transport' => 'refresh'
    ));

      $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'ddpdm_mobile_menu_custom_background_color_control', array(
        'label' => esc_html__('Menu Background Color', 'ddprodm'),
        'section' => 'ddpdm_mobile_menu_section',
        'settings' => 'ddpdm_mobile_menu_custom_background_color'
    )));


      $wp_customize->add_setting('ddpdm_mobile_menu_custom_font', array(
        'sanitize_callback' => 'ddpdm_sanitize_fonts',
        'default' => false,
        'transport' => 'refresh'
    ));

    $wp_customize->add_control('ddpdm_mobile_menu_custom_font_select', array(
        'type' => 'select',
        'label' => esc_html__('Top items Font', 'ddprodm'),
        'section' => 'ddpdm_mobile_menu_section',
        'settings' => 'ddpdm_mobile_menu_custom_font',
        'choices' => $font_choices
    ));

       $wp_customize->add_setting('ddpdm_mobile_menu_custom_font_style', array(
        'transport' => 'refresh'
    ));

    $wp_customize->add_control(new ET_Divi_Font_Style_Option($wp_customize, 'ddpdm_mobile_menu_custom_font_style_select', array(
        'label' => esc_html__('Top items Font style', 'ddprodm'),
        'section' => 'ddpdm_mobile_menu_section',
        'settings' => 'ddpdm_mobile_menu_custom_font_style',
        'type' => 'font_style',
        'choices' => et_divi_font_style_choices()
    )));


    $wp_customize->add_setting('ddpdm_mobile_menu_custom_text_size', array(
        'default' => '',
        'transport' => 'refresh'
    ));

    $wp_customize->add_control(new ET_Divi_Range_Option($wp_customize, 'ddpdm_mobile_menu_custom_text_size_range', array(
        'label' => esc_html__('Top menu items Font Size', 'ddprodm'),
        'section' => 'ddpdm_mobile_menu_section',
        'settings' => 'ddpdm_mobile_menu_custom_text_size',
        'input_attrs' => array(
            'min' => 8,
            'max' => 50,
            'step' => 1
        )
    )));

     $wp_customize->add_setting('ddpdm_mobile_menu_custom_text_color', array(
        'default' => '',
        'transport' => 'refresh'
    ));

      $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'ddpdm_mobile_menu_custom_text_color_control', array(
        'label' => esc_html__('Top menu items text color', 'ddprodm'),
        'section' => 'ddpdm_mobile_menu_section',
        'settings' => 'ddpdm_mobile_menu_custom_text_color'
    )));


        $wp_customize->add_setting('ddpdm_mobile_menu_custom_text_hover_color', array(
        'default' => '',
        'transport' => 'refresh'
    ));

      $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'ddpdm_mobile_menu_custom_text_hover_color_control', array(
        'label' => esc_html__('Top items hover color', 'ddprodm'),
        'section' => 'ddpdm_mobile_menu_section',
        'settings' => 'ddpdm_mobile_menu_custom_text_hover_color'
    )));

        $wp_customize->add_setting('ddpdm_mobile_menu_custom_border_size', array(
        'default' => '',
        'transport' => 'refresh'
    ));

    $wp_customize->add_control(new ET_Divi_Range_Option($wp_customize, 'ddpdm_mobile_menu_custom_border_size_range', array(
        'label' => esc_html__('Top menu items Border Width (in px)', 'ddprodm'),
        'section' => 'ddpdm_mobile_menu_section',
        'settings' => 'ddpdm_mobile_menu_custom_border_size',
        'input_attrs' => array(
            'min' => 0,
            'max' => 10,
            'step' => 1
        )
    )));

         $wp_customize->add_setting('ddpdm_mobile_menu_custom_border_color', array(
        'default' => '',
        'transport' => 'refresh'
    ));

      $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'ddpdm_mobile_menu_custom_border_color_control', array(
        'label' => esc_html__('Top items border color', 'ddprodm'),
        'section' => 'ddpdm_mobile_menu_section',
        'settings' => 'ddpdm_mobile_menu_custom_border_color'
    )));


      // Sub-items

          $wp_customize->add_setting('ddpdm_mobile_menu_custom_sub_font', array(
        'sanitize_callback' => 'ddpdm_sanitize_fonts',
        'default' => false,
        'transport' => 'refresh'
    ));

    $wp_customize->add_control('ddpdm_mobile_menu_custom_sub_font_select', array(
        'type' => 'select',
        'label' => esc_html__('Sub-items Font', 'ddprodm'),
        'section' => 'ddpdm_mobile_menu_section',
        'settings' => 'ddpdm_mobile_menu_custom_sub_font',
        'choices' => $font_choices
    ));


     $wp_customize->add_setting('ddpdm_mobile_menu_custom_sub_font_style', array(
        'transport' => 'refresh'
    ));

    $wp_customize->add_control(new ET_Divi_Font_Style_Option($wp_customize, 'ddpdm_mobile_menu_custom_sub_font_style_select', array(
        'label' => esc_html__('Sub-items Font style', 'ddprodm'),
        'section' => 'ddpdm_mobile_menu_section',
        'settings' => 'ddpdm_mobile_menu_custom_sub_font_style',
        'type' => 'font_style',
        'choices' => et_divi_font_style_choices()
    )));

      $wp_customize->add_setting('ddpdm_mobile_menu_custom_sub_text_size', array(
        'default' => '',
        'transport' => 'refresh'
    ));


    $wp_customize->add_control(new ET_Divi_Range_Option($wp_customize, 'ddpdm_mobile_menu_custom_sub_text_size_range', array(
        'label' => esc_html__('Sub-items Font Size', 'ddprodm'),
        'section' => 'ddpdm_mobile_menu_section',
        'settings' => 'ddpdm_mobile_menu_custom_sub_text_size',
        'input_attrs' => array(
            'min' => 8,
            'max' => 50,
            'step' => 1
        )
    )));


      $wp_customize->add_setting('ddpdm_mobile_menu_custom_sub_text_color', array(
        'default' => '',
        'transport' => 'refresh'
    ));

      $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'ddpdm_mobile_menu_custom_sub_text_color_control', array(
        'label' => esc_html__('Sub-items text color', 'ddprodm'),
        'section' => 'ddpdm_mobile_menu_section',
        'settings' => 'ddpdm_mobile_menu_custom_sub_text_color'
    )));


    $wp_customize->add_setting('ddpdm_mobile_menu_custom_sub_text_hover_color', array(
        'default' => '',
        'transport' => 'refresh'
    ));

      $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'ddpdm_mobile_menu_custom_sub_text_hover_color_control', array(
        'label' => esc_html__('Sub-items hover color', 'ddprodm'),
        'section' => 'ddpdm_mobile_menu_section',
        'settings' => 'ddpdm_mobile_menu_custom_sub_text_hover_color'
    )));

          $wp_customize->add_setting('ddpdm_mobile_menu_custom_sub_border_size', array(
        'default' => '',
        'transport' => 'refresh'
    ));

    $wp_customize->add_control(new ET_Divi_Range_Option($wp_customize, 'ddpdm_mobile_menu_custom_sub_border_size_range', array(
        'label' => esc_html__('Sub-menu items Border Width (in px)', 'ddprodm'),
        'section' => 'ddpdm_mobile_menu_section',
        'settings' => 'ddpdm_mobile_menu_custom_sub_border_size',
        'input_attrs' => array(
            'min' => 0,
            'max' => 10,
            'step' => 1
        )
    )));

         $wp_customize->add_setting('ddpdm_mobile_menu_custom_sub_border_color', array(
        'default' => '',
        'transport' => 'refresh'
    ));

      $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'ddpdm_mobile_menu_custom_sub_border_color_control', array(
        'label' => esc_html__('Sub-items border color', 'ddprodm'),
        'section' => 'ddpdm_mobile_menu_section',
        'settings' => 'ddpdm_mobile_menu_custom_sub_border_color'
    )));



    // MENU 1


     $wp_customize->add_setting('ddpdm_mobile_menu_1_open', array(
        // 'type'          => 'option',
        'capability' => 'edit_theme_options',
        // 'transport' => 'refresh',
        'default' => false,
        'sanitize_callback' => 'ddpdm_sanitize_checkbox'
    ));

    $wp_customize->add_control('ddpdm_mobile_menu_1_open_checkbox', array(
        'settings' => 'ddpdm_mobile_menu_1_open',
        'label' => esc_html__('Open sub-menus by default', 'ddprodm'),
        'section' => 'ddpdm_mobile_menu_section',
        'type' => 'checkbox'
    ));


     $wp_customize->add_setting('ddpdm_mobile_menu_1_background_color', array(
        'default' => '#fff',
        'transport' => 'refresh'
    ));

      $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'ddpdm_mobile_menu_1_background_color_control', array(
        'label' => esc_html__('Menu Background Color', 'ddprodm'),
        'section' => 'ddpdm_mobile_menu_section',
        'settings' => 'ddpdm_mobile_menu_1_background_color'
    )));


      $wp_customize->add_setting('ddpdm_mobile_menu_1_font', array(
        'sanitize_callback' => 'ddpdm_sanitize_fonts',
        'default' => false,
        'transport' => 'refresh'
    ));

    $wp_customize->add_control('ddpdm_mobile_menu_1_font_select', array(
        'type' => 'select',
        'label' => esc_html__('Top items Font', 'ddprodm'),
        'section' => 'ddpdm_mobile_menu_section',
        'settings' => 'ddpdm_mobile_menu_1_font',
        'choices' => $font_choices
    ));

       $wp_customize->add_setting('ddpdm_mobile_menu_1_font_style', array(
        'transport' => 'refresh'
    ));

    $wp_customize->add_control(new ET_Divi_Font_Style_Option($wp_customize, 'ddpdm_mobile_menu_1_font_style_select', array(
        'label' => esc_html__('Top items Font style', 'ddprodm'),
        'section' => 'ddpdm_mobile_menu_section',
        'settings' => 'ddpdm_mobile_menu_1_font_style',
        'type' => 'font_style',
        'choices' => et_divi_font_style_choices()
    )));


    $wp_customize->add_setting('ddpdm_mobile_menu_1_text_size', array(
        'default' => '18',
        'transport' => 'refresh'
    ));

    $wp_customize->add_control(new ET_Divi_Range_Option($wp_customize, 'ddpdm_mobile_menu_1_text_size_range', array(
        'label' => esc_html__('Top menu items Font Size', 'ddprodm'),
        'section' => 'ddpdm_mobile_menu_section',
        'settings' => 'ddpdm_mobile_menu_1_text_size',
        'input_attrs' => array(
            'min' => 8,
            'max' => 50,
            'step' => 1
        )
    )));

     $wp_customize->add_setting('ddpdm_mobile_menu_1_text_color', array(
        'default' => '#000000',
        'transport' => 'refresh'
    ));

      $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'ddpdm_mobile_menu_1_text_color_control', array(
        'label' => esc_html__('Top menu items text color', 'ddprodm'),
        'section' => 'ddpdm_mobile_menu_section',
        'settings' => 'ddpdm_mobile_menu_1_text_color'
    )));


        $wp_customize->add_setting('ddpdm_mobile_menu_1_text_hover_color', array(
        'default' => '#fddd11',
        'transport' => 'refresh'
    ));

      $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'ddpdm_mobile_menu_1_text_hover_color_control', array(
        'label' => esc_html__('Top items hover color', 'ddprodm'),
        'section' => 'ddpdm_mobile_menu_section',
        'settings' => 'ddpdm_mobile_menu_1_text_hover_color'
    )));

        $wp_customize->add_setting('ddpdm_mobile_menu_1_border_size', array(
        'default' => '1',
        'transport' => 'refresh'
    ));

    $wp_customize->add_control(new ET_Divi_Range_Option($wp_customize, 'ddpdm_mobile_menu_1_border_size_range', array(
        'label' => esc_html__('Top menu items Border Width (in px)', 'ddprodm'),
        'section' => 'ddpdm_mobile_menu_section',
        'settings' => 'ddpdm_mobile_menu_1_border_size',
        'input_attrs' => array(
            'min' => 0,
            'max' => 10,
            'step' => 1
        )
    )));

         $wp_customize->add_setting('ddpdm_mobile_menu_1_border_color', array(
        'default' => '#000000',
        'transport' => 'refresh'
    ));

      $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'ddpdm_mobile_menu_1_border_color_control', array(
        'label' => esc_html__('Top items border color', 'ddprodm'),
        'section' => 'ddpdm_mobile_menu_section',
        'settings' => 'ddpdm_mobile_menu_1_border_color'
    )));


      // Sub-items

          $wp_customize->add_setting('ddpdm_mobile_menu_1_sub_font', array(
        'sanitize_callback' => 'ddpdm_sanitize_fonts',
        'default' => false,
        'transport' => 'refresh'
    ));

    $wp_customize->add_control('ddpdm_mobile_menu_1_sub_font_select', array(
        'type' => 'select',
        'label' => esc_html__('Sub-items Font', 'ddprodm'),
        'section' => 'ddpdm_mobile_menu_section',
        'settings' => 'ddpdm_mobile_menu_1_sub_font',
        'choices' => $font_choices
    ));


     $wp_customize->add_setting('ddpdm_mobile_menu_1_sub_font_style', array(
        'transport' => 'refresh'
    ));

    $wp_customize->add_control(new ET_Divi_Font_Style_Option($wp_customize, 'ddpdm_mobile_menu_1_sub_font_style_select', array(
        'label' => esc_html__('Sub-items Font style', 'ddprodm'),
        'section' => 'ddpdm_mobile_menu_section',
        'settings' => 'ddpdm_mobile_menu_1_sub_font_style',
        'type' => 'font_style',
        'choices' => et_divi_font_style_choices()
    )));

      $wp_customize->add_setting('ddpdm_mobile_menu_1_sub_text_size', array(
        'default' => '16',
        'transport' => 'refresh'
    ));


    $wp_customize->add_control(new ET_Divi_Range_Option($wp_customize, 'ddpdm_mobile_menu_1_sub_text_size_range', array(
        'label' => esc_html__('Sub-items Font Size', 'ddprodm'),
        'section' => 'ddpdm_mobile_menu_section',
        'settings' => 'ddpdm_mobile_menu_1_sub_text_size',
        'input_attrs' => array(
            'min' => 8,
            'max' => 50,
            'step' => 1
        )
    )));


      $wp_customize->add_setting('ddpdm_mobile_menu_1_sub_text_color', array(
        'default' => '#808080',
        'transport' => 'refresh'
    ));

      $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'ddpdm_mobile_menu_1_sub_text_color_control', array(
        'label' => esc_html__('Sub-items text color', 'ddprodm'),
        'section' => 'ddpdm_mobile_menu_section',
        'settings' => 'ddpdm_mobile_menu_1_sub_text_color'
    )));


    $wp_customize->add_setting('ddpdm_mobile_menu_1_sub_text_hover_color', array(
        'default' => '#fddd11',
        'transport' => 'refresh'
    ));

      $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'ddpdm_mobile_menu_1_sub_text_hover_color_control', array(
        'label' => esc_html__('Sub-items hover color', 'ddprodm'),
        'section' => 'ddpdm_mobile_menu_section',
        'settings' => 'ddpdm_mobile_menu_1_sub_text_hover_color'
    )));

          $wp_customize->add_setting('ddpdm_mobile_menu_1_sub_border_size', array(
        'default' => '1',
        'transport' => 'refresh'
    ));

    $wp_customize->add_control(new ET_Divi_Range_Option($wp_customize, 'ddpdm_mobile_menu_1_sub_border_size_range', array(
        'label' => esc_html__('Sub-menu items Border Width (in px)', 'ddprodm'),
        'section' => 'ddpdm_mobile_menu_section',
        'settings' => 'ddpdm_mobile_menu_1_sub_border_size',
        'input_attrs' => array(
            'min' => 0,
            'max' => 10,
            'step' => 1
        )
    )));

      $wp_customize->add_setting('ddpdm_mobile_menu_1_sub_border_color', array(
        'default' => '#e5e5e5',
        'transport' => 'refresh'
    ));

      $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'ddpdm_mobile_menu_1_sub_border_color_control', array(
        'label' => esc_html__('Sub-items border color', 'ddprodm'),
        'section' => 'ddpdm_mobile_menu_section',
        'settings' => 'ddpdm_mobile_menu_1_sub_border_color'
    )));




       // MENU 2

       $wp_customize->add_setting('ddpdm_mobile_menu_2_open', array(
        // 'type'          => 'option',
        'capability' => 'edit_theme_options',
        // 'transport' => 'refresh',
        'default' => false,
        'sanitize_callback' => 'ddpdm_sanitize_checkbox'
    ));

    $wp_customize->add_control('ddpdm_mobile_menu_2_open_checkbox', array(
        'settings' => 'ddpdm_mobile_menu_2_open',
        'label' => esc_html__('Open sub-menus by default', 'ddprodm'),
        'section' => 'ddpdm_mobile_menu_section',
        'type' => 'checkbox'
    ));

     $wp_customize->add_setting('ddpdm_mobile_menu_2_background_color', array(
        'default' => '#000',
        'transport' => 'refresh'
    ));

      $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'ddpdm_mobile_menu_2_background_color_control', array(
        'label' => esc_html__('Menu Background Color', 'ddprodm'),
        'section' => 'ddpdm_mobile_menu_section',
        'settings' => 'ddpdm_mobile_menu_2_background_color'
    )));


      $wp_customize->add_setting('ddpdm_mobile_menu_2_font', array(
        'sanitize_callback' => 'ddpdm_sanitize_fonts',
        'default' => false,
        'transport' => 'refresh'
    ));

    $wp_customize->add_control('ddpdm_mobile_menu_2_font_select', array(
        'type' => 'select',
        'label' => esc_html__('Top items Font', 'ddprodm'),
        'section' => 'ddpdm_mobile_menu_section',
        'settings' => 'ddpdm_mobile_menu_2_font',
        'choices' => $font_choices
    ));

       $wp_customize->add_setting('ddpdm_mobile_menu_2_font_style', array(
        'transport' => 'refresh'
    ));

    $wp_customize->add_control(new ET_Divi_Font_Style_Option($wp_customize, 'ddpdm_mobile_menu_2_font_style_select', array(
        'label' => esc_html__('Top items Font style', 'ddprodm'),
        'section' => 'ddpdm_mobile_menu_section',
        'settings' => 'ddpdm_mobile_menu_2_font_style',
        'type' => 'font_style',
        'choices' => et_divi_font_style_choices()
    )));


    $wp_customize->add_setting('ddpdm_mobile_menu_2_text_size', array(
        'default' => '18',
        'transport' => 'refresh'
    ));

    $wp_customize->add_control(new ET_Divi_Range_Option($wp_customize, 'ddpdm_mobile_menu_2_text_size_range', array(
        'label' => esc_html__('Top menu items Font Size', 'ddprodm'),
        'section' => 'ddpdm_mobile_menu_section',
        'settings' => 'ddpdm_mobile_menu_2_text_size',
        'input_attrs' => array(
            'min' => 8,
            'max' => 50,
            'step' => 1
        )
    )));

     $wp_customize->add_setting('ddpdm_mobile_menu_2_text_color', array(
        'default' => '#fff',
        'transport' => 'refresh'
    ));

      $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'ddpdm_mobile_menu_2_text_color_control', array(
        'label' => esc_html__('Top menu items text color', 'ddprodm'),
        'section' => 'ddpdm_mobile_menu_section',
        'settings' => 'ddpdm_mobile_menu_2_text_color'
    )));


        $wp_customize->add_setting('ddpdm_mobile_menu_2_text_hover_color', array(
        'default' => '#808080',
        'transport' => 'refresh'
    ));

      $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'ddpdm_mobile_menu_2_text_hover_color_control', array(
        'label' => esc_html__('Top items hover color', 'ddprodm'),
        'section' => 'ddpdm_mobile_menu_section',
        'settings' => 'ddpdm_mobile_menu_2_text_hover_color'
    )));

        $wp_customize->add_setting('ddpdm_mobile_menu_2_border_size', array(
        'default' => '1',
        'transport' => 'refresh'
    ));

    $wp_customize->add_control(new ET_Divi_Range_Option($wp_customize, 'ddpdm_mobile_menu_2_border_size_range', array(
        'label' => esc_html__('Top menu items Border Width (in px)', 'ddprodm'),
        'section' => 'ddpdm_mobile_menu_section',
        'settings' => 'ddpdm_mobile_menu_2_border_size',
        'input_attrs' => array(
            'min' => 0,
            'max' => 10,
            'step' => 1
        )
    )));

         $wp_customize->add_setting('ddpdm_mobile_menu_2_border_color', array(
        'default' => ' #808080',
        'transport' => 'refresh'
    ));

      $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'ddpdm_mobile_menu_2_border_color_control', array(
        'label' => esc_html__('Top items border color', 'ddprodm'),
        'section' => 'ddpdm_mobile_menu_section',
        'settings' => 'ddpdm_mobile_menu_2_border_color'
    )));


      // Sub-items

          $wp_customize->add_setting('ddpdm_mobile_menu_2_sub_font', array(
        'sanitize_callback' => 'ddpdm_sanitize_fonts',
        'default' => false,
        'transport' => 'refresh'
    ));

    $wp_customize->add_control('ddpdm_mobile_menu_2_sub_font_select', array(
        'type' => 'select',
        'label' => esc_html__('Sub-items Font', 'ddprodm'),
        'section' => 'ddpdm_mobile_menu_section',
        'settings' => 'ddpdm_mobile_menu_2_sub_font',
        'choices' => $font_choices
    ));


     $wp_customize->add_setting('ddpdm_mobile_menu_2_sub_font_style', array(
        'transport' => 'refresh'
    ));

    $wp_customize->add_control(new ET_Divi_Font_Style_Option($wp_customize, 'ddpdm_mobile_menu_2_sub_font_style_select', array(
        'label' => esc_html__('Sub-items Font style', 'ddprodm'),
        'section' => 'ddpdm_mobile_menu_section',
        'settings' => 'ddpdm_mobile_menu_2_sub_font_style',
        'type' => 'font_style',
        'choices' => et_divi_font_style_choices()
    )));

      $wp_customize->add_setting('ddpdm_mobile_menu_2_sub_text_size', array(
        'default' => '16',
        'transport' => 'refresh'
    ));


    $wp_customize->add_control(new ET_Divi_Range_Option($wp_customize, 'ddpdm_mobile_menu_2_sub_text_size_range', array(
        'label' => esc_html__('Sub-items Font Size', 'ddprodm'),
        'section' => 'ddpdm_mobile_menu_section',
        'settings' => 'ddpdm_mobile_menu_2_sub_text_size',
        'input_attrs' => array(
            'min' => 8,
            'max' => 50,
            'step' => 1
        )
    )));


      $wp_customize->add_setting('ddpdm_mobile_menu_2_sub_text_color', array(
        'default' => '#ffffff',
        'transport' => 'refresh'
    ));

      $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'ddpdm_mobile_menu_2_sub_text_color_control', array(
        'label' => esc_html__('Sub-items text color', 'ddprodm'),
        'section' => 'ddpdm_mobile_menu_section',
        'settings' => 'ddpdm_mobile_menu_2_sub_text_color'
    )));


    $wp_customize->add_setting('ddpdm_mobile_menu_2_sub_text_hover_color', array(
        'default' => '#808080',
        'transport' => 'refresh'
    ));

      $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'ddpdm_mobile_menu_2_sub_text_hover_color_control', array(
        'label' => esc_html__('Sub-items hover color', 'ddprodm'),
        'section' => 'ddpdm_mobile_menu_section',
        'settings' => 'ddpdm_mobile_menu_2_sub_text_hover_color'
    )));

          $wp_customize->add_setting('ddpdm_mobile_menu_2_sub_border_size', array(
        'default' => '1',
        'transport' => 'refresh'
    ));

    $wp_customize->add_control(new ET_Divi_Range_Option($wp_customize, 'ddpdm_mobile_menu_2_sub_border_size_range', array(
        'label' => esc_html__('Sub-menu items Border Width (in px)', 'ddprodm'),
        'section' => 'ddpdm_mobile_menu_section',
        'settings' => 'ddpdm_mobile_menu_2_sub_border_size',
        'input_attrs' => array(
            'min' => 0,
            'max' => 10,
            'step' => 1
        )
    )));

         $wp_customize->add_setting('ddpdm_mobile_menu_2_sub_border_color', array(
        'default' => '#808080',
        'transport' => 'refresh'
    ));

      $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'ddpdm_mobile_menu_2_sub_border_color_control', array(
        'label' => esc_html__('Sub-items border color', 'ddprodm'),
        'section' => 'ddpdm_mobile_menu_section',
        'settings' => 'ddpdm_mobile_menu_2_sub_border_color'
    )));


             // MENU 3

       $wp_customize->add_setting('ddpdm_mobile_menu_3_open', array(
        // 'type'          => 'option',
        'capability' => 'edit_theme_options',
        // 'transport' => 'refresh',
        'default' => false,
        'sanitize_callback' => 'ddpdm_sanitize_checkbox'
    ));

    $wp_customize->add_control('ddpdm_mobile_menu_3_open_checkbox', array(
        'settings' => 'ddpdm_mobile_menu_3_open',
        'label' => esc_html__('Open sub-menus by default', 'ddprodm'),
        'section' => 'ddpdm_mobile_menu_section',
        'type' => 'checkbox'
    ));

     $wp_customize->add_setting('ddpdm_mobile_menu_3_background_color', array(
        'default' => '#000',
        'transport' => 'refresh'
    ));

      $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'ddpdm_mobile_menu_3_background_color_control', array(
        'label' => esc_html__('Menu Background Color', 'ddprodm'),
        'section' => 'ddpdm_mobile_menu_section',
        'settings' => 'ddpdm_mobile_menu_3_background_color'
    )));

      // Social Icons

       $wp_customize->add_setting('ddpdm_mobile_menu_3_socials', array(
        'default' => '<a href="https://facebook.com" targer="_blank"><i class="fab fa-facebook-f"></i></a><a href="https://linkedin.com" targer="_blank"><i class="fab fa-linkedin-in"></i></a><a href="https://twitter.com" targer="_blank"><i class="fab fa-twitter"></i></a><a href="https://instagram.com" targer="_blank"><i class="fab fa-instagram"></i></a>',
        'transport' => 'refresh'
    ));


       $wp_customize->add_control('ddpdm_mobile_menu_3_socials_control', array(
        'type' => 'textarea',
        'section' => 'ddpdm_mobile_menu_section',
        'label' => esc_html__('Social Icons (optional)', 'ddprodm'),
        'settings' => 'ddpdm_mobile_menu_3_socials'
    ));


        $wp_customize->add_setting('ddpdm_mobile_menu_3_socials_text_size', array(
        'default' => '18',
        'transport' => 'refresh'
    ));

    $wp_customize->add_control(new ET_Divi_Range_Option($wp_customize, 'ddpdm_mobile_menu_3_socials_text_size_range', array(
        'label' => esc_html__('Social Icons Font Size', 'ddprodm'),
        'section' => 'ddpdm_mobile_menu_section',
        'settings' => 'ddpdm_mobile_menu_3_socials_text_size',
        'input_attrs' => array(
            'min' => 8,
            'max' => 50,
            'step' => 1
        )
    )));

     $wp_customize->add_setting('ddpdm_mobile_menu_3_socials_text_color', array(
        'default' => '#fff',
        'transport' => 'refresh'
    ));

      $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'ddpdm_mobile_menu_3_socials_text_color_control', array(
        'label' => esc_html__('Social Icons text color', 'ddprodm'),
        'section' => 'ddpdm_mobile_menu_section',
        'settings' => 'ddpdm_mobile_menu_3_socials_text_color'
    )));


        $wp_customize->add_setting('ddpdm_mobile_menu_3_socials_text_hover_color', array(
        'default' => '#808080',
        'transport' => 'refresh'
    ));

      $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'ddpdm_mobile_menu_3_socials_text_hover_color_control', array(
        'label' => esc_html__('Social Icons hover color', 'ddprodm'),
        'section' => 'ddpdm_mobile_menu_section',
        'settings' => 'ddpdm_mobile_menu_3_socials_text_hover_color'
    )));


      $wp_customize->add_setting('ddpdm_mobile_menu_3_font', array(
        'sanitize_callback' => 'ddpdm_sanitize_fonts',
        'default' => false,
        'transport' => 'refresh'
    ));

    $wp_customize->add_control('ddpdm_mobile_menu_3_font_select', array(
        'type' => 'select',
        'label' => esc_html__('Top items Font', 'ddprodm'),
        'section' => 'ddpdm_mobile_menu_section',
        'settings' => 'ddpdm_mobile_menu_3_font',
        'choices' => $font_choices
    ));

       $wp_customize->add_setting('ddpdm_mobile_menu_3_font_style', array(
        'transport' => 'refresh'
    ));

    $wp_customize->add_control(new ET_Divi_Font_Style_Option($wp_customize, 'ddpdm_mobile_menu_3_font_style_select', array(
        'label' => esc_html__('Top items Font style', 'ddprodm'),
        'section' => 'ddpdm_mobile_menu_section',
        'settings' => 'ddpdm_mobile_menu_3_font_style',
        'type' => 'font_style',
        'choices' => et_divi_font_style_choices()
    )));


    $wp_customize->add_setting('ddpdm_mobile_menu_3_text_size', array(
        'default' => '30',
        'transport' => 'refresh'
    ));

    $wp_customize->add_control(new ET_Divi_Range_Option($wp_customize, 'ddpdm_mobile_menu_3_text_size_range', array(
        'label' => esc_html__('Top menu items Font Size', 'ddprodm'),
        'section' => 'ddpdm_mobile_menu_section',
        'settings' => 'ddpdm_mobile_menu_3_text_size',
        'input_attrs' => array(
            'min' => 8,
            'max' => 50,
            'step' => 1
        )
    )));

     $wp_customize->add_setting('ddpdm_mobile_menu_3_text_color', array(
        'default' => '#fff',
        'transport' => 'refresh'
    ));

      $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'ddpdm_mobile_menu_3_text_color_control', array(
        'label' => esc_html__('Top menu items text color', 'ddprodm'),
        'section' => 'ddpdm_mobile_menu_section',
        'settings' => 'ddpdm_mobile_menu_3_text_color'
    )));


        $wp_customize->add_setting('ddpdm_mobile_menu_3_text_hover_color', array(
        'default' => '#808080',
        'transport' => 'refresh'
    ));

      $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'ddpdm_mobile_menu_3_text_hover_color_control', array(
        'label' => esc_html__('Top items hover color', 'ddprodm'),
        'section' => 'ddpdm_mobile_menu_section',
        'settings' => 'ddpdm_mobile_menu_3_text_hover_color'
    )));

        $wp_customize->add_setting('ddpdm_mobile_menu_3_border_size', array(
        'default' => '1',
        'transport' => 'refresh'
    ));

    $wp_customize->add_control(new ET_Divi_Range_Option($wp_customize, 'ddpdm_mobile_menu_3_border_size_range', array(
        'label' => esc_html__('Top menu items Border Width (in px)', 'ddprodm'),
        'section' => 'ddpdm_mobile_menu_section',
        'settings' => 'ddpdm_mobile_menu_3_border_size',
        'input_attrs' => array(
            'min' => 0,
            'max' => 10,
            'step' => 1
        )
    )));

         $wp_customize->add_setting('ddpdm_mobile_menu_3_border_color', array(
        'default' => ' #808080',
        'transport' => 'refresh'
    ));

      $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'ddpdm_mobile_menu_3_border_color_control', array(
        'label' => esc_html__('Top items border color', 'ddprodm'),
        'section' => 'ddpdm_mobile_menu_section',
        'settings' => 'ddpdm_mobile_menu_3_border_color'
    )));


      // Sub-items

          $wp_customize->add_setting('ddpdm_mobile_menu_3_sub_font', array(
        'sanitize_callback' => 'ddpdm_sanitize_fonts',
        'default' => false,
        'transport' => 'refresh'
    ));

    $wp_customize->add_control('ddpdm_mobile_menu_3_sub_font_select', array(
        'type' => 'select',
        'label' => esc_html__('Sub-items Font', 'ddprodm'),
        'section' => 'ddpdm_mobile_menu_section',
        'settings' => 'ddpdm_mobile_menu_3_sub_font',
        'choices' => $font_choices
    ));


     $wp_customize->add_setting('ddpdm_mobile_menu_3_sub_font_style', array(
        'transport' => 'refresh'
    ));

    $wp_customize->add_control(new ET_Divi_Font_Style_Option($wp_customize, 'ddpdm_mobile_menu_3_sub_font_style_select', array(
        'label' => esc_html__('Sub-items Font style', 'ddprodm'),
        'section' => 'ddpdm_mobile_menu_section',
        'settings' => 'ddpdm_mobile_menu_3_sub_font_style',
        'type' => 'font_style',
        'choices' => et_divi_font_style_choices()
    )));

      $wp_customize->add_setting('ddpdm_mobile_menu_3_sub_text_size', array(
        'default' => '24',
        'transport' => 'refresh'
    ));


    $wp_customize->add_control(new ET_Divi_Range_Option($wp_customize, 'ddpdm_mobile_menu_3_sub_text_size_range', array(
        'label' => esc_html__('Sub-items Font Size', 'ddprodm'),
        'section' => 'ddpdm_mobile_menu_section',
        'settings' => 'ddpdm_mobile_menu_3_sub_text_size',
        'input_attrs' => array(
            'min' => 8,
            'max' => 50,
            'step' => 1
        )
    )));


      $wp_customize->add_setting('ddpdm_mobile_menu_3_sub_text_color', array(
        'default' => '#ffffff',
        'transport' => 'refresh'
    ));

      $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'ddpdm_mobile_menu_3_sub_text_color_control', array(
        'label' => esc_html__('Sub-items text color', 'ddprodm'),
        'section' => 'ddpdm_mobile_menu_section',
        'settings' => 'ddpdm_mobile_menu_3_sub_text_color'
    )));


    $wp_customize->add_setting('ddpdm_mobile_menu_3_sub_text_hover_color', array(
        'default' => '#808080',
        'transport' => 'refresh'
    ));

      $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'ddpdm_mobile_menu_3_sub_text_hover_color_control', array(
        'label' => esc_html__('Sub-items hover color', 'ddprodm'),
        'section' => 'ddpdm_mobile_menu_section',
        'settings' => 'ddpdm_mobile_menu_3_sub_text_hover_color'
    )));

          $wp_customize->add_setting('ddpdm_mobile_menu_3_sub_border_size', array(
        'default' => '1',
        'transport' => 'refresh'
    ));

    $wp_customize->add_control(new ET_Divi_Range_Option($wp_customize, 'ddpdm_mobile_menu_3_sub_border_size_range', array(
        'label' => esc_html__('Sub-menu items Border Width (in px)', 'ddprodm'),
        'section' => 'ddpdm_mobile_menu_section',
        'settings' => 'ddpdm_mobile_menu_3_sub_border_size',
        'input_attrs' => array(
            'min' => 0,
            'max' => 10,
            'step' => 1
        )
    )));

         $wp_customize->add_setting('ddpdm_mobile_menu_3_sub_border_color', array(
        'default' => '#808080',
        'transport' => 'refresh'
    ));

      $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'ddpdm_mobile_menu_3_sub_border_color_control', array(
        'label' => esc_html__('Sub-items border color', 'ddprodm'),
        'section' => 'ddpdm_mobile_menu_section',
        'settings' => 'ddpdm_mobile_menu_3_sub_border_color'
    )));

      // Address


    $wp_customize->add_setting('ddpdm_mobile_menu_3_address', array(
        'default' => '105 Road Name<br>Berlin, Germany<br><br><a href="tel:012345678">012 345 678</a><br><a href="mailto:info@website.com">info@website.com</a>',
        'transport' => 'refresh'
    ));


       $wp_customize->add_control('ddpdm_mobile_menu_3_address_control', array(
        'type' => 'textarea',
        'section' => 'ddpdm_mobile_menu_section',
        'label' => esc_html__('Address Text (optional)', 'ddprodm'),
        'settings' => 'ddpdm_mobile_menu_3_address'
    ));


             $wp_customize->add_setting('ddpdm_mobile_menu_3_address_font', array(
        'sanitize_callback' => 'ddpdm_sanitize_fonts',
        'default' => false,
        'transport' => 'refresh'
    ));

    $wp_customize->add_control('ddpdm_mobile_menu_3_address_font_select', array(
        'type' => 'select',
        'label' => esc_html__('Address Font', 'ddprodm'),
        'section' => 'ddpdm_mobile_menu_section',
        'settings' => 'ddpdm_mobile_menu_3_address_font',
        'choices' => $font_choices
    ));


     $wp_customize->add_setting('ddpdm_mobile_menu_3_address_font_style', array(
        'transport' => 'refresh'
    ));

    $wp_customize->add_control(new ET_Divi_Font_Style_Option($wp_customize, 'ddpdm_mobile_menu_3_address_font_style_select', array(
        'label' => esc_html__('Address Font style', 'ddprodm'),
        'section' => 'ddpdm_mobile_menu_section',
        'settings' => 'ddpdm_mobile_menu_3_address_font_style',
        'type' => 'font_style',
        'choices' => et_divi_font_style_choices()
    )));

      $wp_customize->add_setting('ddpdm_mobile_menu_3_address_text_size', array(
        'default' => '16',
        'transport' => 'refresh'
    ));


    $wp_customize->add_control(new ET_Divi_Range_Option($wp_customize, 'ddpdm_mobile_menu_3_address_text_size_range', array(
        'label' => esc_html__('Address Font Size', 'ddprodm'),
        'section' => 'ddpdm_mobile_menu_section',
        'settings' => 'ddpdm_mobile_menu_3_address_text_size',
        'input_attrs' => array(
            'min' => 8,
            'max' => 50,
            'step' => 1
        )
    )));


      $wp_customize->add_setting('ddpdm_mobile_menu_3_address_text_color', array(
        'default' => '#ffffff',
        'transport' => 'refresh'
    ));

      $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'ddpdm_mobile_menu_3_address_text_color_control', array(
        'label' => esc_html__('Address text color', 'ddprodm'),
        'section' => 'ddpdm_mobile_menu_section',
        'settings' => 'ddpdm_mobile_menu_3_address_text_color'
    )));


    $wp_customize->add_setting('ddpdm_mobile_menu_3_address_text_hover_color', array(
        'default' => '#808080',
        'transport' => 'refresh'
    ));

      $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'ddpdm_mobile_menu_3_address_text_hover_color_control', array(
        'label' => esc_html__('Address links hover color', 'ddprodm'),
        'section' => 'ddpdm_mobile_menu_section',
        'settings' => 'ddpdm_mobile_menu_3_address_text_hover_color'
    )));







    // Add coming soon section
    $wp_customize->add_section('ddpdm_coming_soon_section', array(
        'priority' => 110,
        'title' => esc_html__('Coming Soon Page', 'ddprodm'),
        'panel' => 'ddpdm_navigation_panel'
    ));


    //  =============================
    //  = Coming Soon Select Box         =
    //  =============================

    $choices_array_coming_soon             = array();
    $choices_array_coming_soon['disabled'] = esc_html__('Disabled', 'ddprodm');
    if (ddpdm_is_divi_item_exists('Vertical Coming Soon Page - PHP Templ - Diana'))
        $choices_array_coming_soon['diana_1'] = 'Vertical Coming Soon Page - Diana';
    if (ddpdm_is_divi_item_exists('Coming Soon w Contact Form - PHP Templ - Diana'))
        $choices_array_coming_soon['diana_2'] = 'Coming Soon w Contact Form - Diana';

     for ($i = 1; $i < 10 ; $i++) {
        if (ddpdm_is_divi_item_exists('Coming Soon Page V'.$i.' - PHP Templ - Ragnar')) {
            $choices_array_coming_soon['ragnar_'.$i] = 'Coming Soon Page V'.$i.' - Ragnar';
        }
    }

    $additional_choices_array_coming_soon = ddpdm_get_all_category_items('Coming Soon Page');


    delete_option('ddpdm_template_coming_soon_custom');
    add_option('ddpdm_template_coming_soon_custom', $additional_choices_array_404);


    $choices_array_coming_soon = array_merge($choices_array_coming_soon, $additional_choices_array_coming_soon);

    //print_r($choices_array_coming_soon);


    $wp_customize->add_setting('ddpdm_coming_soon_template', array(
        'default' => 'disabled',
        'capability' => 'edit_theme_options',
        'type' => 'option'

    ));
    $wp_customize->add_control('ddpdm_coming_soon_select_box', array(
        'settings' => 'ddpdm_coming_soon_template',
        'label' => esc_html__('Coming Soon Page', 'ddprodm'),
        'description' => '<p><a href="https://seku.re/divi-den-theme-builder" target="_blank" class="button button-secondary">'.__('Learn More - Watch a short video tutorial', 'ddprodm').'</a></p><p>'.__('Add a Coming Soon Page to your site. After activation, all public visitors (not logged in) will see this page. Only WordPress users (logged in) with "administrator" permissions, will see all pages like normal (no coming soon page will be shown).', 'ddprodm').'<br><br><b>'.__('About Search Engine Visibility:', 'ddprodm').'</b> '.__('This coming soon page will NOT stop search engines from indexing your site. Please', 'ddprodm').' <a href="/wp-admin/options-reading.php" target="_blank">'.__('control Search Engine Visibility here', 'ddprodm').'</a> '.__('or use a', 'ddprodm').' <a href="https://moz.com/learn/seo/robotstxt" target="_blank">'.__('robots.txt file', 'ddprodm').'</a>.<br><br>'.__('No saved templates yet?', 'ddprodm').' <a href="/wp-admin/admin.php?page=divi_den_pro_dm_dashboard&tab=ddpdm_settings">'.__('First save some here', 'ddprodm').'</a>. '.__('After saving they will appear in the drop-down below. You can also modify saved templates', 'ddprodm').' <a href="/wp-admin/edit.php?post_type=et_pb_layout&layout_category=coming-soon-page" target="_blank">'.__('in the Divi Library', 'ddprodm').'</a>.<br><br><a href="https://seku.re/custom-coming-soon" target="_blank">'.__('Learn how to add a custom Coming Soon Page', 'ddprodm').'</a>.</p><label class="customize-control-title">'.__('Saved Coming Soon Pages', 'ddprodm').'</label><p>'.__('Choose a saved template.', 'ddprodm').'</p>',
        'section' => 'ddpdm_coming_soon_section',
        'type' => 'select',
        'choices' => $choices_array_coming_soon
    ));


    // Add sticky bar section
    $wp_customize->add_section('ddpdm_sticky_bar_section', array(
        'priority' => 120,
        'title' => esc_html__('Sticky Bar', 'ddprodm'),
        'panel' => 'ddpdm_global_navigation_panel'
    ));


    //  =============================
    //  = Skicky Bar Select Box         =
    //  =============================

    $choices_array_sticky_bar             = array();
    $choices_array_sticky_bar['disabled'] = esc_html__('Disabled', 'ddprodm');
    if (ddpdm_is_divi_item_exists('Holiday Message Sticky Bar - PHP Templ - Diana'))
        $choices_array_sticky_bar['diana_1'] = 'Holiday Message Sticky Bar - Diana';
    if (ddpdm_is_divi_item_exists('Event Sticky Bar - PHP Templ - Diana'))
        $choices_array_sticky_bar['diana_2'] = 'Event Sticky Bar - Diana';
    if (ddpdm_is_divi_item_exists('Early Bird Sticky Bar - PHP Templ - Diana'))
        $choices_array_sticky_bar['diana_4'] = 'Early Bird Sticky Bar - Diana';
    if (ddpdm_is_divi_item_exists('Brochure Download Sticky Bar - PHP Templ - Diana'))
        $choices_array_sticky_bar['diana_5'] = 'Brochure Download Sticky Bar - Diana';
    if (ddpdm_is_divi_item_exists('Location Sticky Bar - PHP Templ - Diana'))
        $choices_array_sticky_bar['diana_6'] = 'Location Sticky Bar - Diana';
    if (ddpdm_is_divi_item_exists('Set a Reminder Sticky Bar - PHP Templ - Diana'))
        $choices_array_sticky_bar['diana_7'] = 'Set a Reminder Sticky Bar - Diana';
    if (ddpdm_is_divi_item_exists('New Collection Sticky Bar - PHP Templ - Diana'))
        $choices_array_sticky_bar['diana_8'] = 'New Collection Sticky Bar - Diana';
    if (ddpdm_is_divi_item_exists('Sale Furniture Sticky Bar - PHP Templ - Diana'))
        $choices_array_sticky_bar['diana_9'] = 'Sale Furniture Sticky Bar - Diana';
    if (ddpdm_is_divi_item_exists('Download Ebook w Form Sticky Bar - PHP Templ - Diana'))
        $choices_array_sticky_bar['diana_10'] = 'Download Ebook w Form Sticky Bar - Diana';
    if (ddpdm_is_divi_item_exists('Download Ebook Sticky Bar - PHP Templ - Diana'))
        $choices_array_sticky_bar['diana_11'] = 'Download Ebook Sticky Bar - Diana';

    $additional_choices_array_sticky_bar = ddpdm_get_all_category_items('Sticky Bar');

    // if (!get_option( 'ddpdm_template_sticky_bar_custom')) add_option( 'ddpdm_template_sticky_bar_custom', $additional_choices_array_sticky_bar );
    //  else update_option('ddpdm_template_sticky_bar_custom', $additional_choices_array_sticky_bar);

    delete_option('ddpdm_template_sticky_bar_custom');
    add_option('ddpdm_template_sticky_bar_custom', $additional_choices_array_404);


    $choices_array_sticky_bar = array_merge($choices_array_sticky_bar, $additional_choices_array_sticky_bar);


    $wp_customize->add_setting('ddpdm_sticky_bar_template', array(
        'default' => 'disabled',
        'capability' => 'edit_theme_options',
        'type' => 'option'

    ));
    $wp_customize->add_control('ddpdm_sticky_bar_select_box', array(
        'settings' => 'ddpdm_sticky_bar_template',
        'label' => esc_html__('Sticky Bar', 'ddprodm'),
        'description' => '<p><a href="https://seku.re/divi-den-theme-builder" target="_blank" class="button button-secondary">'.__('Learn More - Watch a short video tutorial', 'ddprodm').'</a></p><p>'.__('Add a Sticky Bar to your site. After activation, all visitors will see this on top/bottom of all pages.', 'ddprodm').'<br><br>'.__('No saved sticky bar templates yet?', 'ddprodm').' <a href="/wp-admin/admin.php?page=divi_den_pro_dm_dashboard&tab=ddpdm_settings">'.__('First save some here', 'ddprodm').'</a>. '.__('After saving they will appear in the drop-down below. You can also modify saved sticky bar templates', 'ddprodm').' <a href="/wp-admin/edit.php?post_type=et_pb_layout&layout_category=sticky-bar" target="_blank">'.__('in the Divi Library', 'ddprodm').'</a>. <br><br><a href="https://seku.re/custom-sticky-bar" target="_blank">'.__('Learn how to add a custom Sticky Bars', 'ddprodm').'</a>.</p><label class="customize-control-title">'.__('Saved Sticky Bars', 'ddprodm').'</label><p>'.__('Choose a saved template.', 'ddprodm').'</p>',
        'section' => 'ddpdm_sticky_bar_section',
        'type' => 'select',
        'choices' => $choices_array_sticky_bar
    ));


    $choices_array_sticky = array(
        'disabled' => 'Disabled',
        'top' => 'Top of Window',
        'bottom' => 'Bottom of Window'
    );


    $wp_customize->add_setting('ddpdm_sticky_bar_sticky', array(
        'type' => 'option',
        'capability' => 'edit_theme_options',
        'transport' => 'refresh',
        'default' => 'top'
    ));

    $wp_customize->add_control('ddpdm_sticky_bar_sticky_select', array(
        'settings' => 'ddpdm_sticky_bar_sticky',
        'label' => esc_html__('Sticky Bar Location', 'ddprodm'),
        'description' => esc_html__('Stick the bar on page scroll to...', 'ddprodm'),
        'section' => 'ddpdm_sticky_bar_section',
        'type' => 'select',
        'choices' => $choices_array_sticky
    ));

    $wp_customize->add_setting('ddpdm_sticky_show_leave', array(
        // 'type'          => 'option',
        'capability' => 'edit_theme_options',
        'transport' => 'refresh',
        'default' => false,
        'sanitize_callback' => 'ddpdm_sanitize_checkbox'
    ));

    $wp_customize->add_control('ddpdm_sticky_show_leave_checkbox', array(
        'settings' => 'ddpdm_sticky_show_leave',
        'label' => esc_html__('Show the Bar only when a visitor tries to leave the site', 'ddprodm'),
        'section' => 'ddpdm_sticky_bar_section',
        'type' => 'checkbox'
    ));



    $wp_customize->add_setting('ddpdm_sticky_show_scroll', array(
        // 'type'          => 'option',
        'capability' => 'edit_theme_options',
        'transport' => 'refresh',
        'default' => false,
        'sanitize_callback' => 'ddpdm_sanitize_checkbox'
    ));

    $wp_customize->add_control('ddpdm_sticky_show_scroll_checkbox', array(
        'settings' => 'ddpdm_sticky_show_scroll',
        'label' => esc_html__('Show the Bar only when a visitor scrolls to', 'ddprodm'),
        'section' => 'ddpdm_sticky_bar_section',
        'type' => 'checkbox'
    ));

    $wp_customize->add_setting('ddpdm_sticky_bar_scroll_per', array(
        'capability' => 'edit_theme_options',
        'type' => 'option',
        'transport' => 'refresh',
        'default' => 20,
        'sanitize_callback' => 'ddpdm_sanitize_number'
    ));

    $wp_customize->add_control(new ET_Divi_Range_Option($wp_customize, 'ddpdm_sticky_bar_scroll_per_range', array(
        'label' => esc_html__('% depth of a page', 'ddprodm'),
        //'description' => esc_html__('In seconds. You can use values like 2, 1.5, 0.7',
        'section' => 'ddpdm_sticky_bar_section',
        'settings' => 'ddpdm_sticky_bar_scroll_per',
        'input_attrs' => array(
            'min' => 0,
            'max' => 100,
            'step' => 1
        )
    )));




    $wp_customize->add_setting('ddpdm_sticky_bar_delay', array(
        'capability' => 'edit_theme_options',
        'type' => 'option',
        'transport' => 'refresh',
        'default' => 0,
        'sanitize_callback' => 'ddpdm_sanitize_number'
    ));

    $wp_customize->add_control(new ET_Divi_Range_Option($wp_customize, 'ddpdm_sticky_bar_delay_range', array(
        'label' => esc_html__('Time delay before sticky bar appears', 'ddprodm'),
        'description' => esc_html__('In seconds. You can use values like 2, 1.5, 0.7', 'ddprodm'),
        'section' => 'ddpdm_sticky_bar_section',
        'settings' => 'ddpdm_sticky_bar_delay',
        'input_attrs' => array(
            'min' => 0,
            'max' => 60,
            'step' => 0.1
        )
    )));



    $wp_customize->add_setting('ddpdm_sticky_bar_cookie_days', array(
        'capability' => 'edit_theme_options',
        'type' => 'option',
        //'transport'     => 'refresh',
        'default' => 120,
        'sanitize_callback' => 'ddpdm_sanitize_number'
    ));

    $wp_customize->add_control(new ET_Divi_Range_Option($wp_customize, 'ddpdm_sticky_bar_cookie_days_range', array(
        'label' => esc_html__('Set number of days until the bar shows again', 'ddprodm'),
        'description' => esc_html__('Cookie expiry in days. Show the bar again X days after visitor closed the sticky bar. Take care not to annoy website visitors by showing the bar too often or too soon after it was dismissed by the visitor.', 'ddprodm'),
        'section' => 'ddpdm_sticky_bar_section',
        'settings' => 'ddpdm_sticky_bar_cookie_days',
        'input_attrs' => array(
            'min' => 1,
            'max' => 365,
            'step' => 1
        )
    )));



    $wp_customize->add_setting('ddpdm_sticky_show_close', array(
        // 'type'          => 'option',
        'capability' => 'edit_theme_options',
        'transport' => 'refresh',
        'default' => true,
        'sanitize_callback' => 'ddpdm_sanitize_checkbox'
    ));

    $wp_customize->add_control('ddpdm_sticky_show_close', array(
        'settings' => 'ddpdm_sticky_show_close',
        'label' => esc_html__('Show the Close Button', 'ddprodm'),
        'section' => 'ddpdm_sticky_bar_section',
        'type' => 'checkbox'
    ));



    function ddpdm_sanitize_checkbox($checked)
    {
        return ((isset($checked) && true == $checked) ? true : false);
    }

    function ddpdm_sanitize_number($number)
    {
        if (is_numeric($number)) {
            return $number;
        } else
            return 0;
    }

    /////////////////////////////////////////////////////////////////

    // Add pop up section
    $wp_customize->add_section('ddpdm_pop_up_section', array(
        'priority' => 120,
        'title' => esc_html__('Pop-up Customizer', 'ddprodm'),
        'panel' => 'ddpdm_global_navigation_panel'
    ));


    //  =============================
    //  = Pop-Up Select Box         =
    //  =============================

    $choices_array_pop_up             = array();
    $choices_array_pop_up['disabled'] = esc_html__('Disabled', 'ddprodm');
    if (ddpdm_is_divi_item_exists('Kingly Form Pop-Up - PHP Templ - Diana'))
        $choices_array_pop_up['diana_1'] = 'Kingly Form Pop-Up - Diana';
    if (ddpdm_is_divi_item_exists('Renowned Pricing Pop-Up - PHP Templ - Diana'))
        $choices_array_pop_up['diana_2'] = 'Renowned Pricing Pop-Up - Diana';
    if (ddpdm_is_divi_item_exists('Great Portfolio Pop-Up - PHP Templ - Diana'))
        $choices_array_pop_up['diana_3'] = 'Great Portfolio Pop-Up - Diana';
    if (ddpdm_is_divi_item_exists('Striking Search Pop-Up - PHP Templ - Diana'))
        $choices_array_pop_up['diana_4'] = 'Striking Search Pop-Up - Diana';
    if (ddpdm_is_divi_item_exists('Prominent Search Pop-Up - PHP Templ - Diana'))
        $choices_array_pop_up['diana_5'] = 'Prominent Search Pop-Up - Diana';
    if (ddpdm_is_divi_item_exists('Special Search Pop-Up - PHP Templ - Diana'))
        $choices_array_pop_up['diana_6'] = 'Special Search Pop-Up - Diana';
    if (ddpdm_is_divi_item_exists('Salient Search Pop-Up - PHP Templ - Diana'))
        $choices_array_pop_up['diana_7'] = 'Salient Search Pop-Up - Diana';
    for ($i = 1; $i < 18 ; $i++) {
        if (ddpdm_is_divi_item_exists('Pop-Up V'.$i.' - PHP Templ - Ragnar'))
        $choices_array_pop_up['ragnar_'.$i] = 'Pop-Up V'.$i.' - Ragnar';
    }



    $additional_choices_array_pop_up = ddpdm_get_all_category_items('Pop-Up');

    if (!get_option('ddpdm_template_pop_up_custom'))
        {
            delete_option('ddpdm_template_pop_up_custom');
            add_option('ddpdm_template_pop_up_custom', $additional_choices_array_pop_up);
        }
    else {
        delete_option('ddpdm_template_pop_up_custom');
        add_option('ddpdm_template_pop_up_custom', $additional_choices_array_pop_up);
    }


    $choices_array_pop_up = array_merge($choices_array_pop_up, $additional_choices_array_pop_up);

    $wp_customize->add_setting('ddpdm_pop_up_template', array(
        'default' => 'disabled',
        'capability' => 'edit_theme_options',
        'type' => 'option'

    ));
    $wp_customize->add_control('ddpdm_pop_up_select_box', array(
        'settings' => 'ddpdm_pop_up_template',
        'label' => esc_html__('Pop-Up', 'ddprodm'),
        'description' => '<p><a href="https://seku.re/divi-den-theme-builder" target="_blank" class="button button-secondary">'.__('Learn More - Watch a short video tutorial', 'ddprodm').'</a></p><p>'.__('Add a Pop-Up to your site.', 'ddprodm').' <br>'.__('You can always trigger a pop-up by adding a class to a button or an image.', 'ddprodm').' <a href="https://seku.re/trigger-pop-up-diana" target="_blank">'.__('Read more here', 'ddprodm').'</a>.<br><br>'.__('No saved Pop-Up templates yet?', 'ddprodm').' <a href="/wp-admin/admin.php?page=divi_den_pro_dm_dashboard&tab=ddpdm_settings">'.__('First save some here', 'ddprodm').'</a>. '.__('After saving they will appear in the drop-down below. You can also modify saved Pop-Up templates', 'ddprodm').' <a href="/wp-admin/edit.php?post_type=et_pb_layout&layout_category=pop-up" target="_blank">'.__('in the Divi Library', 'ddprodm').'</a>. <br><br><a href="https://seku.re/custom-pop-up" target="_blank">'.__('Learn how to add a custom Pop-Up', 'ddprodm').'</a>.</p><label class="customize-control-title">'.__('Saved Pop-Ups', 'ddprodm').'</label><p>'.__('Choose a saved template.', 'ddprodm').'</p>',
        'section' => 'ddpdm_pop_up_section',
        'type' => 'select',
        'choices' => $choices_array_pop_up
    ));

    $wp_customize->add_setting('ddpdm_pop_up_disable_clicks', array(
        // 'type'          => 'option',
        'capability' => 'edit_theme_options',
        'transport' => 'refresh',
        'default' => true,
        'sanitize_callback' => 'ddpdm_sanitize_checkbox'
    ));

    $wp_customize->add_control('ddpdm_pop_up_disable_clicks_checkbox', array(
        'settings' => 'ddpdm_pop_up_disable_clicks',
        'label' => esc_html__('Unload pop-up css and script files for on-click pop-up triggers (default: checked)', 'ddprodm'),
        'section' => 'ddpdm_pop_up_section',
        'type' => 'checkbox',
        'default' => true
    ));


    $wp_customize->add_setting('ddpdm_pop_up_show_load', array(
        // 'type'          => 'option',
        'capability' => 'edit_theme_options',
        'transport' => 'refresh',
        'default' => false,
        'sanitize_callback' => 'ddpdm_sanitize_checkbox'
    ));

    $wp_customize->add_control('ddpdm_pop_up_show_load_checkbox', array(
        'settings' => 'ddpdm_pop_up_show_load',
        'label' => esc_html__('Show the Pop-Up on a page load for all site pages', 'ddprodm'),
        'section' => 'ddpdm_pop_up_section',
        'type' => 'checkbox'
    ));

    $wp_customize->add_setting('ddpdm_pop_up_delay', array(
        'capability' => 'edit_theme_options',
        'type' => 'option',
        'transport' => 'refresh',
        'default' => 0,
        'sanitize_callback' => 'ddpdm_sanitize_number'
    ));

    $wp_customize->add_control(new ET_Divi_Range_Option($wp_customize, 'ddpdm_pop_up_delay_range', array(
        'label' => esc_html__('Time delay before pop up appears', 'ddprodm'),
        'description' => esc_html__('In seconds. You can use values like 2, 1.5, 0.7', 'ddprodm'),
        'section' => 'ddpdm_pop_up_section',
        'settings' => 'ddpdm_pop_up_delay',
        'input_attrs' => array(
            'min' => 0,
            'max' => 60,
            'step' => 0.1
        )
    )));




    $wp_customize->add_setting('ddpdm_pop_up_show_leave', array(
        // 'type'          => 'option',
        'capability' => 'edit_theme_options',
        'transport' => 'refresh',
        'default' => false,
        'sanitize_callback' => 'ddpdm_sanitize_checkbox'
    ));

    $wp_customize->add_control('ddpdm_pop_up_show_leave_checkbox', array(
        'settings' => 'ddpdm_pop_up_show_leave',
        'label' => esc_html__('Show pop-up when a visitor wants to leave the site - exit intent', 'ddprodm'),
        'section' => 'ddpdm_pop_up_section',
        'type' => 'checkbox'
    ));



    $wp_customize->add_setting('ddpdm_pop_up_show_scroll', array(
        // 'type'          => 'option',
        'capability' => 'edit_theme_options',
        'transport' => 'refresh',
        'default' => false,
        'sanitize_callback' => 'ddpdm_sanitize_checkbox'
    ));

    $wp_customize->add_control('ddpdm_pop_up_show_scroll_checkbox', array(
        'settings' => 'ddpdm_pop_up_show_scroll',
        'label' => esc_html__('Show the Pop-Up when a visitor scrolls to', 'ddprodm'),
        'section' => 'ddpdm_pop_up_section',
        'type' => 'checkbox'
    ));

    $wp_customize->add_setting('ddpdm_pop_up_scroll_per', array(
        'capability' => 'edit_theme_options',
        'type' => 'option',
        'transport' => 'refresh',
        'default' => 20,
        'sanitize_callback' => 'ddpdm_sanitize_number'
    ));

    $wp_customize->add_control(new ET_Divi_Range_Option($wp_customize, 'ddpdm_pop_up_scroll_per_range', array(
        'label' => esc_html__('% depth of a page', 'ddprodm'),
        //'description' => esc_html__('In seconds. You can use values like 2, 1.5, 0.7',
        'section' => 'ddpdm_pop_up_section',
        'settings' => 'ddpdm_pop_up_scroll_per',
        'input_attrs' => array(
            'min' => 0,
            'max' => 100,
            'step' => 1
        )
    )));


    $wp_customize->add_setting('ddpdm_pop_up_cookie_days', array(
        'capability' => 'edit_theme_options',
        'type' => 'option',
        //'transport'     => 'refresh',
        'default' => 120,
        'sanitize_callback' => 'ddpdm_sanitize_number'
    ));

    $wp_customize->add_control(new ET_Divi_Range_Option($wp_customize, 'ddpdm_pop_up_cookie_days_range', array(
        'label' => esc_html__('Set number of days until the pop-up shows again', 'ddprodm'),
        'description' => esc_html__('Set cookie expiry in days. Show the pop-up again, "X" many days after visitor closed the pop-up. Take care not to annoy website visitors by showing the pop-up too often or too soon after it was dismissed.', 'ddprodm'),
        'section' => 'ddpdm_pop_up_section',
        'settings' => 'ddpdm_pop_up_cookie_days',
        'input_attrs' => array(
            'min' => 1,
            'max' => 365,
            'step' => 1
        )
    )));

    // Clear cookie button


    $wp_customize->add_control('ddpdm_pop_up_clear_cookie_button', array(
        'section' => 'ddpdm_pop_up_section',
        'settings' => array(),
        'type' => 'button',
        'label' => esc_html__('Reset current pop-up to test again', 'ddprodm'),
        'description' => esc_html__('Get Pop-Up back again after clicking "X" to dismiss. Please save/publish your changes BEFORE clearing the cookie. The customizer will be reloaded after you click the button below. Important - Changes will be lost if you do not save/publish first.', 'ddprodm'),
        //'transport'     => 'refresh',
        'input_attrs' => array(
            'value' => esc_html__('Clear Local Pop-Up Cookie Now', 'ddprodm'),
            'class' => 'button button-secondary ddpdm-clear-popup-cookie'
        )
    ));

    //////////////////////////////

    // Add footer section
    $wp_customize->add_section('ddpdm_footer_section', array(
        'priority' => 150,
        'title' => esc_html__('Global Footer', 'ddprodm'),
        'panel' => 'ddpdm_global_navigation_panel'
    ));

    //  =============================
    //  = Footer Select Box         =
    //  =============================

    $choices_array_footer             = array();
    $choices_array_footer['disabled'] = esc_html__('Disabled', 'ddprodm');

    $args = array(
        'post_type' => 'et_pb_layout',
        'post_status' => 'publish',
        'orderby' => 'date',
        'order' => 'ASC',
        'posts_per_page' => -1
    );

    $my_query = new WP_Query($args);

    $count = 0;

    if ($my_query->have_posts()) {
        while ($my_query->have_posts()):
            $my_query->the_post();
            if (strpos(get_the_title(), 'Footer') !== false || strpos(get_the_title(), 'footer') !== false) {
                $choices_array_footer['footer_' . $count] = get_the_title();
                $count++;
            }
        endwhile;
    }

    wp_reset_query(); // Restore global post data stomped by the_post()

    if (!get_option('ddpdm_footer_custom'))
        add_option('ddpdm_footer_custom', $choices_array_footer);
    else {
        delete_option('ddpdm_footer_custom');
        add_option('ddpdm_footer_custom', $choices_array_footer);
    }


    $wp_customize->add_setting('ddpdm_footer_template', array(
        'default' => 'disabled',
        'capability' => 'edit_theme_options',
        'type' => 'option'

    ));
    $wp_customize->add_control('ddpdm_footer_select_box', array(
        'settings' => 'ddpdm_footer_template',
        'label' => esc_html__('Footer', 'ddprodm'),
        'description' => '<p><a href="https://seku.re/global-footer-kb" target="_blank" class="button button-secondary">'.__('Learn More - Watch a short video tutorial', 'ddprodm').'</a></p><p>'.__('This will rewrite your current Footer. No saved templates yet?', 'ddprodm').' <a href="/wp-admin/admin.php?page=divi_den_pro_dm_dashboard&tab=ddpdm_settings">'.__('First save some here', 'ddprodm').'</a>. '.__('After saving they will appear in the drop-down below. You can also modify certain saved templates', 'ddprodm').' <a href="/wp-admin/edit.php?post_type=et_pb_layout" target="_blank">'.__('in the Divi Library', 'ddprodm').'</a>. <br><br><a href="https://seku.re/custom-navigation-menu" target="_blank">'.__('Learn how to add a custom Footer', 'ddprodm').'</a>.</p><label class="customize-control-title">'.__('Saved Global Footers', 'ddprodm').'</label><p>'.__('Choose a saved template to edit.', 'ddprodm').'</p>',
        'section' => 'ddpdm_footer_section',
        'type' => 'select',
        'choices' => $choices_array_footer
    ));

     //////////////////////////////

    // Add icons section
    $wp_customize->add_section('ddpdm_icons_section', array(
        'priority' => 160,
        'title' => esc_html__('Add more icons to Divi', 'ddprodm'),
        'panel' => 'ddpdm_global_navigation_panel',
        'description' => '<label class="customize-control-title">'.__('Choose icon packs to use with Divi', 'ddprodm').'</label><p><a href="https://seku.re/add-icons-kb" target="_blank" class="button button-secondary">'.__('Learn More - Watch a short video tutorial', 'ddprodm').'</a></p><p>'.__('Add thousands more free icons to Divi builder. Search by keyword and/or icon set.', 'ddprodm').'</p>',
    ));

    $wp_customize->add_setting('ddpdm_icons_fa', array(
        'default' => false,
        'capability' => 'edit_theme_options',
        'sanitize_callback' => 'ddpdm_sanitize_checkbox',
        'transport' => 'postMessage'
    ));

    $wp_customize->add_control('ddpdm_icons_fa_checkbox', array(
        'settings' => 'ddpdm_icons_fa',
        'label' => esc_html__('Use Font Awesome 5 Free Icons', 'ddprodm'),
        'description' => esc_html__('This will add Font Awesome 5 Free icons to the Divi Builder.', 'ddprodm').' <a href="https://fontawesome.com/" target="_blank">'.__('See more about the font here', 'ddprodm').'</a>',
        'section' => 'ddpdm_icons_section',
        'type' => 'checkbox'
    ));

     $wp_customize->add_setting('ddpdm_icons_md', array(
        'default' => false,
        'capability' => 'edit_theme_options',
        'sanitize_callback' => 'ddpdm_sanitize_checkbox',
        'transport' => 'postMessage'
    ));

    $wp_customize->add_control('ddpdm_icons_md_checkbox', array(
        'settings' => 'ddpdm_icons_md',
        'label' => esc_html__('Use Material Design Icons', 'ddprodm'),
        'description' => esc_html__('This will add Material Design icons to the Divi Builder.', 'ddprodm').' <a href="https://material.io/tools/icons/?style=baseline" target="_blank">'.__('See more about the font here', 'ddprodm').'</a>',
        'section' => 'ddpdm_icons_section',
        'type' => 'checkbox'
    ));



      // Back to top Button
    $wp_customize->add_section('ddpdm_back_to_top_section', array(
        'priority' => 190,
        'title' => esc_html__('Customize Back to Top Button', 'ddprodm'),
        'panel' => 'ddpdm_global_navigation_panel',
        'description' => '<label class="customize-control-title">'.__('Customize the back to top button on your site.', 'ddprodm').'</label><p><a href="https://seku.re/back-to-top-kb" target="_blank" class="button button-secondary">'.__('Learn More - Watch a short video tutorial', 'ddprodm').'</a></p><p>'.__('Required actions: To edit the Back to Top Button, first enable it in', 'ddprodm').' <a href="/wp-admin/admin.php?page=et_divi_options">'.__('Divi theme options', 'ddprodm').'</a>.</p>',
    ));

     $wp_customize->add_setting('ddpdm_back_to_top', array(
        // 'type'          => 'option',
        'capability' => 'edit_theme_options',
        'transport' => 'refresh',
        'default' => false,
        'sanitize_callback' => 'ddpdm_sanitize_checkbox'
    ));

    $wp_customize->add_control('ddpdm_back_to_top_checkbox', array(
        'settings' => 'ddpdm_back_to_top',
        'label' => esc_html__('Customize the back to top button', 'ddprodm'),
        'section' => 'ddpdm_back_to_top_section',
        'type' => 'checkbox'
    ));

    // position x
    $wp_customize->add_setting( 'ddpdm_back_to_top_position_x',
       array(
          'default' => 'right',
          'transport' => 'refresh',
       )
    );

    $wp_customize->add_control( 'ddpdm_back_to_top_position_x_radio',
       array(
          'label' => __( 'Button Horizontal Position on page', 'ddprodm'),
          'section' => 'ddpdm_back_to_top_section',
          'type' => 'radio',
          'settings' => 'ddpdm_back_to_top_position_x',
          'choices' => array(
             'right' => __( 'Right' ),
             'left' => __( 'Left' ),
          )
       )
    );


    // margin x

    $wp_customize->add_setting('ddpdm_back_to_top_position_x_margin', array(
        'capability' => 'edit_theme_options',
        // 'type' => 'option',
        'transport' => 'refresh',
        'default' => 0,
        'sanitize_callback' => 'ddpdm_sanitize_number'
    ));

    $wp_customize->add_control(new ET_Divi_Range_Option($wp_customize, 'ddpdm_back_to_top_position_x_margin_range', array(
        'label' => esc_html__('Horizontal offset (in pixels)', 'ddprodm'),
        'section' => 'ddpdm_back_to_top_section',
        'settings' => 'ddpdm_back_to_top_position_x_margin',
        'input_attrs' => array(
            'min' => 0,
            'max' => 500,
            'step' => 1
        )
    )));



    // position y
    $wp_customize->add_setting( 'ddpdm_back_to_top_position_y',
       array(
          'default' => 'bottom',
          'transport' => 'refresh',
       )
    );

    $wp_customize->add_control( 'ddpdm_back_to_top_position_y_radio',
       array(
          'label' => __( 'Button Vertical Position on page', 'ddprodm'),
          'section' => 'ddpdm_back_to_top_section',
          'type' => 'radio',
          'settings' => 'ddpdm_back_to_top_position_y',
          'choices' => array(
             'top' => __( 'Top' ),
             'bottom' => __( 'Bottom' ),
          )
       )
    );

      // margin y

    $wp_customize->add_setting('ddpdm_back_to_top_position_y_margin', array(
        'capability' => 'edit_theme_options',
        // 'type' => 'option',
        'transport' => 'refresh',
        'default' => 125,
        'sanitize_callback' => 'ddpdm_sanitize_number'
    ));

    $wp_customize->add_control(new ET_Divi_Range_Option($wp_customize, 'ddpdm_back_to_top_position_y_margin_range', array(
        'label' => esc_html__('Vertical offset (in pixels)', 'ddprodm'),
        'section' => 'ddpdm_back_to_top_section',
        'settings' => 'ddpdm_back_to_top_position_y_margin',
        'input_attrs' => array(
            'min' => 0,
            'max' => 500,
            'step' => 1
        )
    )));

      //  Background
    $wp_customize->add_setting('ddpdm_back_to_top_bg_color', array(
        'default' => 'rgba(0, 0, 0, 0.4)',
        'transport' => 'refresh'
    ));

    $wp_customize->add_control(new Ddp_Customize_Alpha_Color_Control($wp_customize, 'ddpdm_back_to_top_bg_color_control', array(
        'label' => esc_html__('Button Background Color', 'ddprodm'),
        'section' => 'ddpdm_back_to_top_section',
        'settings' => 'ddpdm_back_to_top_bg_color'
    )));

    // background on hover

     $wp_customize->add_setting('ddpdm_back_to_top_hover_bg_color', array(
        'default' => 'rgba(0, 0, 0, 0.4)',
        'transport' => 'refresh'
    ));

    $wp_customize->add_control(new Ddp_Customize_Alpha_Color_Control($wp_customize, 'ddpdm_back_to_top_hover_bg_color_control', array(
        'label' => esc_html__('Button Background Color on hover', 'ddprodm'),
        'section' => 'ddpdm_back_to_top_section',
        'settings' => 'ddpdm_back_to_top_hover_bg_color'
    )));

    // button size

    $wp_customize->add_setting('ddpdm_back_to_top_size_value', array(
        'default' => '5',
        'transport' => 'refresh'
    ));

    $wp_customize->add_control(new ET_Divi_Range_Option($wp_customize, 'ddpdm_back_to_top_size', array(
        'label' => esc_html__('Button Size (padding in px)', 'ddprodm'),
        'section' => 'ddpdm_back_to_top_section',
        'settings' => 'ddpdm_back_to_top_size_value',
        'input_attrs' => array(
            'min' => 0,
            'max' => 50,
            'step' => 1
        )
    )));


    // BORDER

    // width

     $wp_customize->add_setting('ddpdm_back_to_top_border_width', array(
        'default' => '0',
        'transport' => 'refresh'
    ));

    $wp_customize->add_control(new ET_Divi_Range_Option($wp_customize, 'ddpdm_back_to_top_border_width_range', array(
        'label' => esc_html__('Button Border Width (in px)', 'ddprodm'),
        'section' => 'ddpdm_back_to_top_section',
        'settings' => 'ddpdm_back_to_top_border_width',
        'input_attrs' => array(
            'min' => 0,
            'max' => 30,
            'step' => 1
        )
    )));

    // color

    $wp_customize->add_setting('ddpdm_back_to_top_border_color', array(
        'default' => '#000',
        'transport' => 'refresh'
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'ddpdm_back_to_top_border_color_control', array(
        'label' => esc_html__('Button Border Color', 'ddprodm'),
        'section' => 'ddpdm_back_to_top_section',
        'settings' => 'ddpdm_back_to_top_border_color'
    )));


    // hover color

    $wp_customize->add_setting('ddpdm_back_to_top_border_hover_color', array(
        'default' => '#000',
        'transport' => 'refresh'
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'ddpdm_back_to_top_border_hover_color_control', array(
        'label' => esc_html__('Button Border Color on hover', 'ddprodm'),
        'section' => 'ddpdm_back_to_top_section',
        'settings' => 'ddpdm_back_to_top_border_hover_color'
    )));


    // radius

    $wp_customize->add_setting('ddpdm_back_to_top_border_top_left_radius', array(
        'default' => '5',
        'transport' => 'refresh'
    ));

    $wp_customize->add_control(new ET_Divi_Range_Option($wp_customize, 'ddpdm_back_to_top_border_top_left_radius_range', array(
        'label' => esc_html__('Top Left border radius (in px)', 'ddprodm'),
        'section' => 'ddpdm_back_to_top_section',
        'settings' => 'ddpdm_back_to_top_border_top_left_radius',
        'input_attrs' => array(
            'min' => 0,
            'max' => 50,
            'step' => 1
        )
    )));

         $wp_customize->add_setting('ddpdm_back_to_top_border_bottom_left_radius', array(
        'default' => '5',
        'transport' => 'refresh'
    ));

    $wp_customize->add_control(new ET_Divi_Range_Option($wp_customize, 'ddpdm_back_to_top_border_bottom_left_radius_range', array(
        'label' => esc_html__('Bottom Left border radius (in px)', 'ddprodm'),
        'section' => 'ddpdm_back_to_top_section',
        'settings' => 'ddpdm_back_to_top_border_bottom_left_radius',
        'input_attrs' => array(
            'min' => 0,
            'max' => 50,
            'step' => 1
        )
    )));


      $wp_customize->add_setting('ddpdm_back_to_top_border_top_right_radius', array(
        'default' => '0',
        'transport' => 'refresh'
    ));

    $wp_customize->add_control(new ET_Divi_Range_Option($wp_customize, 'ddpdm_back_to_top_border_top_right_radius_range', array(
        'label' => esc_html__('Top Right border radius (in px)', 'ddprodm'),
        'section' => 'ddpdm_back_to_top_section',
        'settings' => 'ddpdm_back_to_top_border_top_right_radius',
        'input_attrs' => array(
            'min' => 0,
            'max' => 50,
            'step' => 1
        )
    )));


      $wp_customize->add_setting('ddpdm_back_to_top_border_bottom_right_radius', array(
        'default' => '0',
        'transport' => 'refresh'
    ));

    $wp_customize->add_control(new ET_Divi_Range_Option($wp_customize, 'ddpdm_back_to_top_border_bottom_right_radius_range', array(
        'label' => esc_html__('Bottom Right border radius (in px)', 'ddprodm'),
        'section' => 'ddpdm_back_to_top_section',
        'settings' => 'ddpdm_back_to_top_border_bottom_right_radius',
        'input_attrs' => array(
            'min' => 0,
            'max' => 50,
            'step' => 1
        )
    )));


    // ICON

    // hide the icon

     $wp_customize->add_setting('ddpdm_back_to_top_icon_hide', array(
        // 'type'          => 'option',
        'capability' => 'edit_theme_options',
        'transport' => 'refresh',
        'default' => false,
        'sanitize_callback' => 'ddpdm_sanitize_checkbox'
    ));

    $wp_customize->add_control('ddpdm_back_to_top_icon_hide_checkbox', array(
        'settings' => 'ddpdm_back_to_top_icon_hide',
        'label' => esc_html__('Hide the icon', 'ddprodm'),
        'section' => 'ddpdm_back_to_top_section',
        'type' => 'checkbox'
    ));

    // change icon

    $wp_customize->add_setting( 'ddpdm_back_to_top_icon_change', array(
        'default'       => '2',
    ) );

    $wp_customize->add_control( new ET_Divi_Icon_Picker_Option ( $wp_customize, 'ddpdm_back_to_top_icon_change_option', array(
        'label'       => esc_html__( 'Select Icon', 'ddprodm' ),
        'section'     => 'ddpdm_back_to_top_section',
        'type'        => 'icon_picker',
        'settings' => 'ddpdm_back_to_top_icon_change'
    ) ) );

     //  ==============================
    //  = font style =
    //  ==============================

    $wp_customize->add_setting('ddpdm_back_to_top_icon_font_style', array(
        'transport' => 'refresh'
    ));

    $wp_customize->add_control(new ET_Divi_Font_Style_Option($wp_customize, 'ddpdm_back_to_top_icon_font_select', array(
        'label' => esc_html__('Icon Font style', 'ddprodm'),
        'section' => 'ddpdm_back_to_top_section',
        'settings' => 'ddpdm_back_to_top_icon_font_style',
        'type' => 'font_style',
        'choices' => et_divi_font_style_choices()
    )));

    // fields icon size

    $wp_customize->add_setting('ddpdm_back_to_top_icon_font_size_value', array(
        'default' => '30',
        'transport' => 'refresh'
    ));

    $wp_customize->add_control(new ET_Divi_Range_Option($wp_customize, 'ddpdm_back_to_top_icon_font_size', array(
        'label' => esc_html__('Icon Font Size', 'ddprodm'),
        'section' => 'ddpdm_back_to_top_section',
        'settings' => 'ddpdm_back_to_top_icon_font_size_value',
        'input_attrs' => array(
            'min' => 5,
            'max' => 72,
            'step' => 1
        )
    )));


    // fields icon color
    $wp_customize->add_setting('ddpdm_back_to_top_icon_color_value', array(
        'default' => '#fff',
        'transport' => 'refresh'
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'ddpdm_back_to_top_icon_color', array(
        'label' => esc_html__('Icon Color', 'ddprodm'),
        'section' => 'ddpdm_back_to_top_section',
        'settings' => 'ddpdm_back_to_top_icon_color_value'
    )));


     // fields icon hover color
    $wp_customize->add_setting('ddpdm_back_to_top_icon_color_hover_value', array(
        'default' => '#fff',
        'transport' => 'refresh'
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'ddpdm_back_to_top_icon_color_hover', array(
        'label' => esc_html__('Icon Hover Color', 'ddprodm'),
        'section' => 'ddpdm_back_to_top_section',
        'settings' => 'ddpdm_back_to_top_icon_color_hover_value'
    )));




    // TEXT

    // text field

    $wp_customize->add_setting( 'ddpdm_back_to_top_text', array(
      'capability' => 'edit_theme_options',
      'default' => '',
    ) );

    $wp_customize->add_control( 'ddpdm_back_to_top_text_field', array(
      'type' => 'text',
      'section' => 'ddpdm_back_to_top_section', // Add a default or your own section
      'label' => __( 'Button Text' , 'ddprodm'),
      'description' => __( 'Leave this field blank to show no text' , 'ddprodm'),
      'settings' => 'ddpdm_back_to_top_text',
    ) );


      // text position
    $wp_customize->add_setting( 'ddpdm_back_to_top_text_position',
       array(
          'default' => 'bottom',
          'transport' => 'refresh',
       )
    );

    $wp_customize->add_control( 'ddpdm_back_to_top_text_position_radio',
       array(
          'label' => __( 'Text position (relative to the icon)', 'ddprodm'),
          'section' => 'ddpdm_back_to_top_section',
          'type' => 'radio',
          'settings' => 'ddpdm_back_to_top_text_position',
          'choices' => array(
            'bottom' => __( 'Bottom' ),
            'top' => __( 'Top' ),
            'right' => __( 'Right' ),
            'left' => __( 'Left' ),
          )
       )
    );



       //  =============================
    //  =  font =
    //  =============================

    $wp_customize->add_setting('ddpdm_back_to_top_font_value', array(
        'sanitize_callback' => 'ddpdm_sanitize_fonts',
        'default' => 'Roboto',
        'transport' => 'refresh'
    ));

    $wp_customize->add_control('ddpdm_back_to_top_font', array(
        'type' => 'select',
        'label' => esc_html__('Text Font', 'ddprodm'),
        'section' => 'ddpdm_back_to_top_section',
        'choices' => $font_choices,
        'settings' => 'ddpdm_back_to_top_font_value'
    ));


    //  ==============================
    //  = font style =
    //  ==============================

    $wp_customize->add_setting('ddpdm_back_to_top_font_style', array(
        'transport' => 'refresh'
    ));

    $wp_customize->add_control(new ET_Divi_Font_Style_Option($wp_customize, 'ddpdm_back_to_top_font_select', array(
        'label' => esc_html__('Text Font style', 'ddprodm'),
        'section' => 'ddpdm_back_to_top_section',
        'settings' => 'ddpdm_back_to_top_font_style',
        'type' => 'font_style',
        'choices' => et_divi_font_style_choices()
    )));

    // fields font size

    $wp_customize->add_setting('ddpdm_back_to_top_font_size_value', array(
        'default' => '16',
        'transport' => 'refresh'
    ));

    $wp_customize->add_control(new ET_Divi_Range_Option($wp_customize, 'ddpdm_back_to_top_font_size', array(
        'label' => esc_html__('Text Font Size', 'ddprodm'),
        'section' => 'ddpdm_back_to_top_section',
        'settings' => 'ddpdm_back_to_top_font_size_value',
        'input_attrs' => array(
            'min' => 5,
            'max' => 52,
            'step' => 1
        )
    )));


    // fields text color
    $wp_customize->add_setting('ddpdm_back_to_top_color_value', array(
        'default' => '#fff',
        'transport' => 'refresh'
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'ddpdm_back_to_top_color', array(
        'label' => esc_html__('Text Color', 'ddprodm'),
        'section' => 'ddpdm_back_to_top_section',
        'settings' => 'ddpdm_back_to_top_color_value'
    )));


     // fields text hover color
    $wp_customize->add_setting('ddpdm_back_to_top_color_hover_value', array(
        'default' => '#fff',
        'transport' => 'refresh'
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'ddpdm_back_to_top_color_hover', array(
        'label' => esc_html__('Text Hover Color', 'ddprodm'),
        'section' => 'ddpdm_back_to_top_section',
        'settings' => 'ddpdm_back_to_top_color_hover_value'
    )));

    // Button animations


    $choices_array_back_to_top_animation = array();
    $choices_array_back_to_top_animation['faderight'] = esc_html__('Fade Right', 'ddprodm');
    $choices_array_back_to_top_animation['fadeleft'] = esc_html__('Fade Left', 'ddprodm');
    $choices_array_back_to_top_animation['fadetop'] = esc_html__('Fade Top', 'ddprodm');
    $choices_array_back_to_top_animation['fadebottom'] = esc_html__('Fade Bottom', 'ddprodm');
    $choices_array_back_to_top_animation['grow'] = esc_html__('Grow (in)', 'ddprodm');
    $choices_array_back_to_top_animation['bounce'] = esc_html__('Bounce (in)', 'ddprodm');
    $choices_array_back_to_top_animation['flip'] = esc_html__('Flip (in)', 'ddprodm');


    $wp_customize->add_setting('ddpdm_back_to_top_animation', array(
        'default' => 'faderight',
        'capability' => 'edit_theme_options',
        //'type' => 'option'

    ));
    $wp_customize->add_control('ddpdm_back_to_top_animation_select_box', array(
        'settings' => 'ddpdm_back_to_top_animation',
        'label' => esc_html__('Button animation (in-out)', 'ddprodm'),
        'section' => 'ddpdm_back_to_top_section',
        'type' => 'select',
        'choices' => $choices_array_back_to_top_animation
    ));



    // Hide for small screens

     $wp_customize->add_setting('ddpdm_back_to_top_hide_1100', array(
        'capability' => 'edit_theme_options',
        'transport' => 'refresh',
        'default' => false,
        'sanitize_callback' => 'ddpdm_sanitize_checkbox'
    ));

    $wp_customize->add_control('ddpdm_back_to_top_hide_1100_checkbox', array(
        'settings' => 'ddpdm_back_to_top_hide_1100',
        'label' => esc_html__('Hide the button for Laptops and Large Tablets (between 980px and 1100px)', 'ddprodm'),
        'section' => 'ddpdm_back_to_top_section',
        'type' => 'checkbox'
    ));


     $wp_customize->add_setting('ddpdm_back_to_top_hide_980', array(
        'capability' => 'edit_theme_options',
        'transport' => 'refresh',
        'default' => false,
        'sanitize_callback' => 'ddpdm_sanitize_checkbox'
    ));

    $wp_customize->add_control('ddpdm_back_to_top_hide_980_checkbox', array(
        'settings' => 'ddpdm_back_to_top_hide_980',
        'label' => esc_html__('Hide the button for Tablets (between 768px and 980px)', 'ddprodm'),
        'section' => 'ddpdm_back_to_top_section',
        'type' => 'checkbox'
    ));


     $wp_customize->add_setting('ddpdm_back_to_top_hide_768', array(
        'capability' => 'edit_theme_options',
        'transport' => 'refresh',
        'default' => false,
        'sanitize_callback' => 'ddpdm_sanitize_checkbox'
    ));

    $wp_customize->add_control('ddpdm_back_to_top_hide_768_checkbox', array(
        'settings' => 'ddpdm_back_to_top_hide_768',
        'label' => esc_html__('Hide the button for Smartphones and small Tablets (between 480px and 768px)', 'ddprodm'),
        'section' => 'ddpdm_back_to_top_section',
        'type' => 'checkbox'
    ));

     $wp_customize->add_setting('ddpdm_back_to_top_hide_480', array(
        'capability' => 'edit_theme_options',
        'transport' => 'refresh',
        'default' => false,
        'sanitize_callback' => 'ddpdm_sanitize_checkbox'
    ));

    $wp_customize->add_control('ddpdm_back_to_top_hide_480_checkbox', array(
        'settings' => 'ddpdm_back_to_top_hide_480',
        'label' => esc_html__('Hide the button for Smartphones (between 320px and 480px)', 'ddprodm'),
        'section' => 'ddpdm_back_to_top_section',
        'type' => 'checkbox'
    ));





    //////////////////////////////

    // Add login section
    $wp_customize->add_section('ddpdm_login_section', array(
        'priority' => 140,
        'title' => esc_html__('Login / Register / Lost Password', 'ddprodm'),
        'panel' => 'ddpdm_global_navigation_panel'
    ));

    $wp_customize->add_control('ddpdm_login_link', array(
        'section' => 'ddpdm_login_section',
        'settings' => array(),
        'type' => 'button',
        'priority' => 1,
        'input_attrs' => array(
            'value' => esc_html__('Load Login Page', 'ddprodm'),
            'class' => 'button button-secondary ddpdm-click-on-load hidden',
            'onclick' => 'wp.customize.previewer.previewUrl.set( "/?ddpdm_login_section=true" );'
        )
    ));


    //  =============================
    //  = Login Select Box         =
    //  =============================

    $choices_array_login             = array();
    $choices_array_login['disabled'] = esc_html__('Disabled', 'ddprodm');
    $choices_array_login['diana_1']  = esc_html__('Commanding Dark Login - Diana', 'ddprodm');
    $choices_array_login['diana_2']  = esc_html__('Ruling Login - Diana', 'ddprodm');
    $choices_array_login['diana_3']  = esc_html__('Queenly Login - Diana', 'ddprodm');


    $wp_customize->add_setting('ddpdm_login_template', array(
        'default' => 'disabled',
        'capability' => 'edit_theme_options',
        'type' => 'option'

    ));
    $wp_customize->add_control('ddpdm_login_select_box', array(
        'settings' => 'ddpdm_login_template',
        'label' => esc_html__('Login', 'ddprodm'),
        'description' => '<p><a href="https://seku.re/login-kb" target="_blank" class="button button-secondary">'.__('Learn More - Watch a short video tutorial', 'ddprodm').'</a></p><p>'.__('This will rewrite your current Wordpress Login / Register / Lost Password Pages.', 'ddprodm').'<label class="customize-control-title">'.__('Global Login Pages', 'ddprodm').'</label><p>'.__('Choose a template to edit.', 'ddprodm').'</p>',
        'section' => 'ddpdm_login_section',
        'type' => 'select',
        'choices' => $choices_array_login
    ));

    //////////////////////////////

    // Add header section
    $wp_customize->add_section('ddpdm_header_section', array(
        'priority' => 110,
        'title' => esc_html__('Global Header', 'ddprodm'),
        'panel' => 'ddpdm_global_navigation_panel'
    ));

    //  =============================
    //  = Header Select Box         =
    //  =============================

    $choices_array_header             = array();
    $choices_array_header['disabled'] = esc_html__('Disabled', 'ddprodm');

    $args = array(
        'post_type' => 'et_pb_layout',
        'post_status' => 'publish',
        'orderby' => 'date',
        'order' => 'ASC',
        'posts_per_page' => -1
    );

    $my_query = new WP_Query($args);

    $count = 0;

    if ($my_query->have_posts()) {
        while ($my_query->have_posts()):
            $my_query->the_post();
            if (strpos(get_the_title(), 'Header') !== false || strpos(get_the_title(), 'header') !== false) {
                $choices_array_header['header_' . $count] = get_the_title();
                $count++;
            }
        endwhile;
    }

    wp_reset_query(); // Restore global post data stomped by the_post()

    if (!get_option('ddpdm_header_custom'))
        add_option('ddpdm_header_custom', $choices_array_header);
    else {
        delete_option('ddpdm_header_custom');
        add_option('ddpdm_header_custom', $choices_array_header);
    }


    $wp_customize->add_setting('ddpdm_header_template', array(
        'default' => 'disabled',
        'capability' => 'edit_theme_options',
        'type' => 'option'

    ));
    $wp_customize->add_control('ddpdm_header_select_box', array(
        'settings' => 'ddpdm_header_template',
        'label' => esc_html__('Header', 'ddprodm'),
        'description' => '<p><a href="https://seku.re/divi-den-theme-builder" target="_blank" class="button button-secondary">'.__('Learn More - Watch a short video tutorial', 'ddprodm').'</a></p><p>'.__('This will add a header for all pages. No saved templates yet?', 'ddprodm').' <a href="/wp-admin/admin.php?page=divi_den_pro_dm_dashboard&tab=ddpdm_settings">'.__('First save some here', 'ddprodm').'</a>. '.__('After saving they will appear in the drop-down below. You can also modify certain saved templates', 'ddprodm').' <a href="/wp-admin/edit.php?post_type=et_pb_layout" target="_blank">'.__('in the Divi Library', 'ddprodm').'</a>. <br><br><a href="https://seku.re/custom-navigation-menu" target="_blank">'.__('Learn how to add a custom Header', 'ddprodm').'</a>.</p><label class="customize-control-title">'.__('Saved Global Headers', 'ddprodm').'</label><p>'.__('Choose a saved template to edit.', 'ddprodm').'</p>',
        'section' => 'ddpdm_header_section',
        'type' => 'select',
        'choices' => $choices_array_header
    ));



    // Diana 1

    // Background
    $wp_customize->add_setting('ddpdm_login_diana_1_bg_color_value', array(
        'default' => '#33373a',
        'transport' => 'refresh'
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'ddpdm_login_diana_1_bg_color', array(
        'label' => esc_html__('Background Color', 'ddprodm'),
        'section' => 'ddpdm_login_section',
        'settings' => 'ddpdm_login_diana_1_bg_color_value'
    )));


    // shadow color
    $wp_customize->add_setting('ddpdm_login_diana_1_shadow_color_value', array(
        'default' => 'rgba(0, 0, 0, 0.49)',
        'transport' => 'refresh'
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'ddpdm_login_diana_1_shadow_color', array(
        'label' => esc_html__('Login Box Shadow Color', 'ddprodm'),
        'section' => 'ddpdm_login_section',
        'settings' => 'ddpdm_login_diana_1_shadow_color_value'
    )));



    // Logo image upload

    $wp_customize->add_setting('ddpdm_login_diana_1_logo_image', array(
        'default' => WP_PLUGIN_URL.'/ddprodm/include/diana/img/login-page-logo.png',
        'transport' => 'refresh'
    ));


    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'ddpdm_login_diana_1_logo', array(
        'label' => esc_html__('Upload a logo', 'ddprodm'),
        'section' => 'ddpdm_login_section',
        'settings' => 'ddpdm_login_diana_1_logo_image'
    )));

    //  =============================
    //  =  font =
    //  =============================

    $wp_customize->add_setting('ddpdm_login_diana_1_font_value', array(
        'sanitize_callback' => 'ddpdm_sanitize_fonts',
        'default' => 'Roboto',
        'transport' => 'refresh'
    ));

    $wp_customize->add_control('ddpdm_login_diana_1_font', array(
        'type' => 'select',
        'label' => esc_html__('Font', 'ddprodm'),
        'section' => 'ddpdm_login_section',
        'choices' => $font_choices,
        'settings' => 'ddpdm_login_diana_1_font_value'
    ));


    //  ==============================
    //  = font style =
    //  ==============================

    $wp_customize->add_setting('ddpdm_login_diana_1_font_style', array(
        'transport' => 'refresh'
    ));

    $wp_customize->add_control(new ET_Divi_Font_Style_Option($wp_customize, 'ddpdm_login_diana_1_font_select', array(
        'label' => esc_html__('Font style', 'ddprodm'),
        'section' => 'ddpdm_login_section',
        'settings' => 'ddpdm_login_diana_1_font_style',
        'type' => 'font_style',
        'choices' => et_divi_font_style_choices()
    )));

    // fields font size

    $wp_customize->add_setting('ddpdm_diana_1_login_fields_font_size_value', array(
        'default' => '16',
        'transport' => 'refresh'
    ));

    $wp_customize->add_control(new ET_Divi_Range_Option($wp_customize, 'ddpdm_diana_1_login_fields_font_size', array(
        'label' => esc_html__('Input Fields Font Size', 'ddprodm'),
        'section' => 'ddpdm_login_section',
        'settings' => 'ddpdm_diana_1_login_fields_font_size_value',
        'input_attrs' => array(
            'min' => 8,
            'max' => 32,
            'step' => 1
        )
    )));


    // fields text color
    $wp_customize->add_setting('ddpdm_login_diana_1_fields_color_value', array(
        'default' => '#fff',
        'transport' => 'refresh'
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'ddpdm_login_diana_1_fields_color', array(
        'label' => esc_html__('Input Fields Text Color', 'ddprodm'),
        'section' => 'ddpdm_login_section',
        'settings' => 'ddpdm_login_diana_1_fields_color_value'
    )));

    // rememeber me font size

    $wp_customize->add_setting('ddpdm_diana_1_login_remember_me_font_size_value', array(
        'default' => '14',
        'transport' => 'refresh'
    ));

    $wp_customize->add_control(new ET_Divi_Range_Option($wp_customize, 'ddpdm_diana_1_login_remember_me_font_size', array(
        'label' => esc_html__('Remember Me Font Size', 'ddprodm'),
        'section' => 'ddpdm_login_section',
        'settings' => 'ddpdm_diana_1_login_remember_me_font_size_value',
        'input_attrs' => array(
            'min' => 8,
            'max' => 32,
            'step' => 1
        )
    )));

    // Remember Me color
    $wp_customize->add_setting('ddpdm_login_diana_1_remember_color_value', array(
        'default' => '#989898',
        'transport' => 'refresh'
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'ddpdm_login_diana_1_remember_color', array(
        'label' => esc_html__('Remember Me Text Color', 'ddprodm'),
        'section' => 'ddpdm_login_section',
        'settings' => 'ddpdm_login_diana_1_remember_color_value'
    )));

    //buttons font size

    $wp_customize->add_setting('ddpdm_diana_1_login_button_font_size_value', array(
        'default' => '14',
        'transport' => 'refresh'
    ));

    $wp_customize->add_control(new ET_Divi_Range_Option($wp_customize, 'ddpdm_diana_1_login_button_font_size', array(
        'label' => esc_html__('Button Text Font Size', 'ddprodm'),
        'section' => 'ddpdm_login_section',
        'settings' => 'ddpdm_diana_1_login_button_font_size_value',
        'input_attrs' => array(
            'min' => 8,
            'max' => 50,
            'step' => 1
        )
    )));

    // Button Background
    $wp_customize->add_setting('ddpdm_login_diana_1_bg_button_color_value', array(
        'default' => '#e9eae5',
        'transport' => 'refresh'
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'ddpdm_login_diana_1_bg_button_color', array(
        'label' => esc_html__('Buttons Background Color', 'ddprodm'),
        'section' => 'ddpdm_login_section',
        'settings' => 'ddpdm_login_diana_1_bg_button_color_value'
    )));

    // Button text color
    $wp_customize->add_setting('ddpdm_login_diana_1_button_color_value', array(
        'default' => '#33373a',
        'transport' => 'refresh'
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'ddpdm_login_diana_1_button_color', array(
        'label' => esc_html__('Buttons Text Color', 'ddprodm'),
        'section' => 'ddpdm_login_section',
        'settings' => 'ddpdm_login_diana_1_button_color_value'
    )));



    // Button Hover Background
    $wp_customize->add_setting('ddpdm_login_diana_1_bg_button_hover_color_value', array(
        'default' => '#e8d553 ',
        'transport' => 'refresh'
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'ddpdm_login_diana_1_bg_button_hover_color', array(
        'label' => esc_html__('Buttons Hover Background Color', 'ddprodm'),
        'section' => 'ddpdm_login_section',
        'settings' => 'ddpdm_login_diana_1_bg_button_hover_color_value'
    )));

    // Button Hover text color
    $wp_customize->add_setting('ddpdm_login_diana_1_button_hover_color_value', array(
        'default' => '#fff',
        'transport' => 'refresh'
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'ddpdm_login_diana_1_button_hover_color', array(
        'label' => esc_html__('Buttons Hover Text Color', 'ddprodm'),
        'section' => 'ddpdm_login_section',
        'settings' => 'ddpdm_login_diana_1_button_hover_color_value'
    )));

    // lost password text font size

    $wp_customize->add_setting('ddpdm_diana_1_login_lost_font_size_value', array(
        'default' => '16',
        'transport' => 'refresh'
    ));

    $wp_customize->add_control(new ET_Divi_Range_Option($wp_customize, 'ddpdm_diana_1_login_lost_font_size', array(
        'label' => esc_html__('Lost Your Password... Font Size', 'ddprodm'),
        'section' => 'ddpdm_login_section',
        'settings' => 'ddpdm_diana_1_login_lost_font_size_value',
        'input_attrs' => array(
            'min' => 8,
            'max' => 50,
            'step' => 1
        )
    )));


    // Lost your password... color
    $wp_customize->add_setting('ddpdm_login_diana_1_lost_color_value', array(
        'default' => '#a6a6a6',
        'transport' => 'refresh'
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'ddpdm_login_diana_1_lost_color', array(
        'label' => esc_html__('Lost Your Password... Text Color', 'ddprodm'),
        'section' => 'ddpdm_login_section',
        'settings' => 'ddpdm_login_diana_1_lost_color_value'
    )));



    // Diana 2

    // Background
    $wp_customize->add_setting('ddpdm_login_diana_2_bg_color_value', array(
        'default' => '#33373a',
        'transport' => 'refresh'
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'ddpdm_login_diana_2_bg_color', array(
        'label' => esc_html__('Background Color', 'ddprodm'),
        'section' => 'ddpdm_login_section',
        'settings' => 'ddpdm_login_diana_2_bg_color_value'
    )));


    // Background image upload

    $wp_customize->add_setting('ddpdm_login_diana_2_bg_image', array(
        'default' => WP_PLUGIN_URL.'/ddprodm/include/diana/img/login-page2-bg.jpg',
        'transport' => 'refresh'
    ));


    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'ddpdm_login_diana_2_bg', array(
        'label' => esc_html__('Upload a Background Image', 'ddprodm'),
        'section' => 'ddpdm_login_section',
        'settings' => 'ddpdm_login_diana_2_bg_image'
    )));


    // Logo image upload

    $wp_customize->add_setting('ddpdm_login_diana_2_logo_image', array(
        'default' => WP_PLUGIN_URL.'/ddprodm/include/diana/img/login-page-logo.png',
        'transport' => 'refresh'
    ));


    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'ddpdm_login_diana_2_logo', array(
        'label' => esc_html__('Upload a logo', 'ddprodm'),
        'section' => 'ddpdm_login_section',
        'settings' => 'ddpdm_login_diana_2_logo_image'
    )));

    //  =============================
    //  =  font =
    //  =============================

    $wp_customize->add_setting('ddpdm_login_diana_2_font_value', array(
        'sanitize_callback' => 'ddpdm_sanitize_fonts',
        'default' => 'Roboto',
        'transport' => 'refresh'
    ));

    $wp_customize->add_control('ddpdm_login_diana_2_font', array(
        'type' => 'select',
        'label' => esc_html__('Font', 'ddprodm'),
        'section' => 'ddpdm_login_section',
        'choices' => $font_choices,
        'settings' => 'ddpdm_login_diana_2_font_value'
    ));


    //  ==============================
    //  = font style =
    //  ==============================

    $wp_customize->add_setting('ddpdm_login_diana_2_font_style', array(
        'transport' => 'refresh'
    ));

    $wp_customize->add_control(new ET_Divi_Font_Style_Option($wp_customize, 'ddpdm_login_diana_2_font_select', array(
        'label' => esc_html__('Font style', 'ddprodm'),
        'section' => 'ddpdm_login_section',
        'settings' => 'ddpdm_login_diana_2_font_style',
        'type' => 'font_style',
        'choices' => et_divi_font_style_choices()
    )));

    // fields font size

    $wp_customize->add_setting('ddpdm_diana_2_login_fields_font_size_value', array(
        'default' => '16',
        'transport' => 'refresh'
    ));

    $wp_customize->add_control(new ET_Divi_Range_Option($wp_customize, 'ddpdm_diana_2_login_fields_font_size', array(
        'label' => esc_html__('Input Fields Font Size', 'ddprodm'),
        'section' => 'ddpdm_login_section',
        'settings' => 'ddpdm_diana_2_login_fields_font_size_value',
        'input_attrs' => array(
            'min' => 8,
            'max' => 32,
            'step' => 1
        )
    )));


    // fields text color
    $wp_customize->add_setting('ddpdm_login_diana_2_fields_color_value', array(
        'default' => '#fff',
        'transport' => 'refresh'
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'ddpdm_login_diana_2_fields_color', array(
        'label' => esc_html__('Input Fields Text Color', 'ddprodm'),
        'section' => 'ddpdm_login_section',
        'settings' => 'ddpdm_login_diana_2_fields_color_value'
    )));

    // fields border color
    $wp_customize->add_setting('ddpdm_login_diana_2_fields_border_color_value', array(
        'default' => '#484b4e',
        'transport' => 'refresh'
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'ddpdm_login_diana_2_fields_border_color', array(
        'label' => esc_html__('Input Fields Border Color', 'ddprodm'),
        'section' => 'ddpdm_login_section',
        'settings' => 'ddpdm_login_diana_2_fields_border_color_value'
    )));

    // fields border thickness

    $wp_customize->add_setting('ddpdm_diana_2_login_border_thick_size_value', array(
        'default' => '1',
        'transport' => 'refresh'
    ));

    $wp_customize->add_control(new ET_Divi_Range_Option($wp_customize, 'ddpdm_diana_2_login_border_thick_size', array(
        'label' => esc_html__('Input Fields Border Thickness', 'ddprodm'),
        'section' => 'ddpdm_login_section',
        'settings' => 'ddpdm_diana_2_login_border_thick_size_value',
        'input_attrs' => array(
            'min' => 0,
            'max' => 10,
            'step' => 1
        )
    )));

    // fields border radius
    $wp_customize->add_setting('ddpdm_diana_2_login_border_radius_size_value', array(
        'default' => '6',
        'transport' => 'refresh'
    ));

    $wp_customize->add_control(new ET_Divi_Range_Option($wp_customize, 'ddpdm_diana_2_login_border_radius_size', array(
        'label' => esc_html__('Input Fields Border Radius (in px)', 'ddprodm'),
        'section' => 'ddpdm_login_section',
        'settings' => 'ddpdm_diana_2_login_border_radius_size_value',
        'input_attrs' => array(
            'min' => 0,
            'max' => 50,
            'step' => 1
        )
    )));

    // rememeber me font size

    $wp_customize->add_setting('ddpdm_diana_2_login_remember_me_font_size_value', array(
        'default' => '14',
        'transport' => 'refresh'
    ));

    $wp_customize->add_control(new ET_Divi_Range_Option($wp_customize, 'ddpdm_diana_2_login_remember_me_font_size', array(
        'label' => esc_html__('Remember Me Font Size', 'ddprodm'),
        'section' => 'ddpdm_login_section',
        'settings' => 'ddpdm_diana_2_login_remember_me_font_size_value',
        'input_attrs' => array(
            'min' => 8,
            'max' => 32,
            'step' => 1
        )
    )));

    // Remember Me color
    $wp_customize->add_setting('ddpdm_login_diana_2_remember_color_value', array(
        'default' => '#989898',
        'transport' => 'refresh'
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'ddpdm_login_diana_2_remember_color', array(
        'label' => esc_html__('Remember Me Text Color', 'ddprodm'),
        'section' => 'ddpdm_login_section',
        'settings' => 'ddpdm_login_diana_2_remember_color_value'
    )));

    //buttons font size

    $wp_customize->add_setting('ddpdm_diana_2_login_button_font_size_value', array(
        'default' => '14',
        'transport' => 'refresh'
    ));

    $wp_customize->add_control(new ET_Divi_Range_Option($wp_customize, 'ddpdm_diana_2_login_button_font_size', array(
        'label' => esc_html__('Button Text Font Size', 'ddprodm'),
        'section' => 'ddpdm_login_section',
        'settings' => 'ddpdm_diana_2_login_button_font_size_value',
        'input_attrs' => array(
            'min' => 8,
            'max' => 50,
            'step' => 1
        )
    )));

    // Button Background
    $wp_customize->add_setting('ddpdm_login_diana_2_bg_button_color_value', array(
        'default' => '#e9eae5',
        'transport' => 'refresh'
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'ddpdm_login_diana_2_bg_button_color', array(
        'label' => esc_html__('Buttons Background Color', 'ddprodm'),
        'section' => 'ddpdm_login_section',
        'settings' => 'ddpdm_login_diana_2_bg_button_color_value'
    )));

    // Button text color
    $wp_customize->add_setting('ddpdm_login_diana_2_button_color_value', array(
        'default' => '#33373a',
        'transport' => 'refresh'
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'ddpdm_login_diana_2_button_color', array(
        'label' => esc_html__('Buttons Text Color', 'ddprodm'),
        'section' => 'ddpdm_login_section',
        'settings' => 'ddpdm_login_diana_2_button_color_value'
    )));



    // Button Hover Background
    $wp_customize->add_setting('ddpdm_login_diana_2_bg_button_hover_color_value', array(
        'default' => '#e8d553 ',
        'transport' => 'refresh'
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'ddpdm_login_diana_2_bg_button_hover_color', array(
        'label' => esc_html__('Buttons Hover Background Color', 'ddprodm'),
        'section' => 'ddpdm_login_section',
        'settings' => 'ddpdm_login_diana_2_bg_button_hover_color_value'
    )));

    // Button Hover text color
    $wp_customize->add_setting('ddpdm_login_diana_2_button_hover_color_value', array(
        'default' => '#fff',
        'transport' => 'refresh'
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'ddpdm_login_diana_2_button_hover_color', array(
        'label' => esc_html__('Buttons Hover Text Color', 'ddprodm'),
        'section' => 'ddpdm_login_section',
        'settings' => 'ddpdm_login_diana_2_button_hover_color_value'
    )));

    // lost password text font size

    $wp_customize->add_setting('ddpdm_diana_2_login_lost_font_size_value', array(
        'default' => '16',
        'transport' => 'refresh'
    ));

    $wp_customize->add_control(new ET_Divi_Range_Option($wp_customize, 'ddpdm_diana_2_login_lost_font_size', array(
        'label' => esc_html__('Lost Your Password... Font Size', 'ddprodm'),
        'section' => 'ddpdm_login_section',
        'settings' => 'ddpdm_diana_2_login_lost_font_size_value',
        'input_attrs' => array(
            'min' => 8,
            'max' => 50,
            'step' => 1
        )
    )));


    // Lost your password... color
    $wp_customize->add_setting('ddpdm_login_diana_2_lost_color_value', array(
        'default' => '#a6a6a6',
        'transport' => 'refresh'
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'ddpdm_login_diana_2_lost_color', array(
        'label' => esc_html__('Lost Your Password... Text Color', 'ddprodm'),
        'section' => 'ddpdm_login_section',
        'settings' => 'ddpdm_login_diana_2_lost_color_value'
    )));


    // Diana 3

    // Background
    $wp_customize->add_setting('ddpdm_login_diana_3_bg_color_value', array(
        'default' => '#ffffff',
        'transport' => 'refresh'
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'ddpdm_login_diana_3_bg_color', array(
        'label' => esc_html__('Background Color', 'ddprodm'),
        'section' => 'ddpdm_login_section',
        'settings' => 'ddpdm_login_diana_3_bg_color_value'
    )));

    //  =============================
    //  =  font =
    //  =============================

    $wp_customize->add_setting('ddpdm_login_diana_3_font_value', array(
        'sanitize_callback' => 'ddpdm_sanitize_fonts',
        'default' => 'Roboto',
        'transport' => 'refresh'
    ));

    $wp_customize->add_control('ddpdm_login_diana_3_font', array(
        'type' => 'select',
        'label' => esc_html__('Font', 'ddprodm'),
        'section' => 'ddpdm_login_section',
        'choices' => $font_choices,
        'settings' => 'ddpdm_login_diana_3_font_value'
    ));


    //  ==============================
    //  = font style =
    //  ==============================

    $wp_customize->add_setting('ddpdm_login_diana_3_font_style', array(
        'transport' => 'refresh'
    ));

    $wp_customize->add_control(new ET_Divi_Font_Style_Option($wp_customize, 'ddpdm_login_diana_3_font_select', array(
        'label' => esc_html__('Font style', 'ddprodm'),
        'section' => 'ddpdm_login_section',
        'settings' => 'ddpdm_login_diana_3_font_style',
        'type' => 'font_style',
        'choices' => et_divi_font_style_choices()
    )));


    // Header Text

    $wp_customize->add_setting('ddpdm_login_diana_3_header_value', array(
        'default' => esc_html__('Login', 'ddprodm'),
        'transport' => 'refresh'
    ));

    $wp_customize->add_control('ddpdm_login_diana_3_header', array(
        'type' => 'text',
        'section' => 'ddpdm_login_section',
        'label' => esc_html__('Header Text', 'ddprodm'),
        'settings' => 'ddpdm_login_diana_3_header_value'
    ));

    // Header font size

    $wp_customize->add_setting('ddpdm_diana_3_login_header_font_size_value', array(
        'default' => '21',
        'transport' => 'refresh'
    ));

    $wp_customize->add_control(new ET_Divi_Range_Option($wp_customize, 'ddpdm_diana_3_login_header_font_size', array(
        'label' => esc_html__('Header Font Size', 'ddprodm'),
        'section' => 'ddpdm_login_section',
        'settings' => 'ddpdm_diana_3_login_header_font_size_value',
        'input_attrs' => array(
            'min' => 10,
            'max' => 52,
            'step' => 1
        )
    )));


    // header text color
    $wp_customize->add_setting('ddpdm_login_diana_3_header_color_value', array(
        'default' => '#33373a',
        'transport' => 'refresh'
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'ddpdm_login_diana_3_header_color', array(
        'label' => esc_html__('Header Text Color', 'ddprodm'),
        'section' => 'ddpdm_login_section',
        'settings' => 'ddpdm_login_diana_3_header_color_value'
    )));


    // fields font size

    $wp_customize->add_setting('ddpdm_diana_3_login_fields_font_size_value', array(
        'default' => '16',
        'transport' => 'refresh'
    ));

    $wp_customize->add_control(new ET_Divi_Range_Option($wp_customize, 'ddpdm_diana_3_login_fields_font_size', array(
        'label' => esc_html__('Input Fields Font Size', 'ddprodm'),
        'section' => 'ddpdm_login_section',
        'settings' => 'ddpdm_diana_3_login_fields_font_size_value',
        'input_attrs' => array(
            'min' => 8,
            'max' => 32,
            'step' => 1
        )
    )));


    // fields text color
    $wp_customize->add_setting('ddpdm_login_diana_3_fields_color_value', array(
        'default' => '#a6a6a6',
        'transport' => 'refresh'
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'ddpdm_login_diana_3_fields_color', array(
        'label' => esc_html__('Input Fields Text Color', 'ddprodm'),
        'section' => 'ddpdm_login_section',
        'settings' => 'ddpdm_login_diana_3_fields_color_value'
    )));

    // fields border color
    $wp_customize->add_setting('ddpdm_login_diana_3_fields_border_color_value', array(
        'default' => '#e9eff4',
        'transport' => 'refresh'
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'ddpdm_login_diana_3_fields_border_color', array(
        'label' => esc_html__('Input Fields Border Color', 'ddprodm'),
        'section' => 'ddpdm_login_section',
        'settings' => 'ddpdm_login_diana_3_fields_border_color_value'
    )));

    // fields border thickness

    $wp_customize->add_setting('ddpdm_diana_3_login_border_thick_size_value', array(
        'default' => '1',
        'transport' => 'refresh'
    ));

    $wp_customize->add_control(new ET_Divi_Range_Option($wp_customize, 'ddpdm_diana_3_login_border_thick_size', array(
        'label' => esc_html__('Input Fields Border Thickness', 'ddprodm'),
        'section' => 'ddpdm_login_section',
        'settings' => 'ddpdm_diana_3_login_border_thick_size_value',
        'input_attrs' => array(
            'min' => 0,
            'max' => 10,
            'step' => 1
        )
    )));

    // fields border radius
    $wp_customize->add_setting('ddpdm_diana_3_login_border_radius_size_value', array(
        'default' => '6',
        'transport' => 'refresh'
    ));

    $wp_customize->add_control(new ET_Divi_Range_Option($wp_customize, 'ddpdm_diana_3_login_border_radius_size', array(
        'label' => esc_html__('Input Fields Border Radius (in px)', 'ddprodm'),
        'section' => 'ddpdm_login_section',
        'settings' => 'ddpdm_diana_3_login_border_radius_size_value',
        'input_attrs' => array(
            'min' => 0,
            'max' => 50,
            'step' => 1
        )
    )));

    // rememeber me font size

    $wp_customize->add_setting('ddpdm_diana_3_login_remember_me_font_size_value', array(
        'default' => '14',
        'transport' => 'refresh'
    ));

    $wp_customize->add_control(new ET_Divi_Range_Option($wp_customize, 'ddpdm_diana_3_login_remember_me_font_size', array(
        'label' => esc_html__('Remember Me Font Size', 'ddprodm'),
        'section' => 'ddpdm_login_section',
        'settings' => 'ddpdm_diana_3_login_remember_me_font_size_value',
        'input_attrs' => array(
            'min' => 8,
            'max' => 32,
            'step' => 1
        )
    )));

    // Remember Me color
    $wp_customize->add_setting('ddpdm_login_diana_3_remember_color_value', array(
        'default' => '#989898',
        'transport' => 'refresh'
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'ddpdm_login_diana_3_remember_color', array(
        'label' => esc_html__('Remember Me Text Color', 'ddprodm'),
        'section' => 'ddpdm_login_section',
        'settings' => 'ddpdm_login_diana_3_remember_color_value'
    )));

    //buttons font size

    $wp_customize->add_setting('ddpdm_diana_3_login_button_font_size_value', array(
        'default' => '12',
        'transport' => 'refresh'
    ));

    $wp_customize->add_control(new ET_Divi_Range_Option($wp_customize, 'ddpdm_diana_3_login_button_font_size', array(
        'label' => esc_html__('Button Text Font Size', 'ddprodm'),
        'section' => 'ddpdm_login_section',
        'settings' => 'ddpdm_diana_3_login_button_font_size_value',
        'input_attrs' => array(
            'min' => 8,
            'max' => 32,
            'step' => 1
        )
    )));

    // Button Background
    $wp_customize->add_setting('ddpdm_login_diana_3_bg_button_color_value', array(
        'default' => '#33373a',
        'transport' => 'refresh'
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'ddpdm_login_diana_3_bg_button_color', array(
        'label' => esc_html__('Buttons Background Color', 'ddprodm'),
        'section' => 'ddpdm_login_section',
        'settings' => 'ddpdm_login_diana_3_bg_button_color_value'
    )));

    // Button text color
    $wp_customize->add_setting('ddpdm_login_diana_3_button_color_value', array(
        'default' => '#ffffff',
        'transport' => 'refresh'
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'ddpdm_login_diana_3_button_color', array(
        'label' => esc_html__('Buttons Text Color', 'ddprodm'),
        'section' => 'ddpdm_login_section',
        'settings' => 'ddpdm_login_diana_3_button_color_value'
    )));


    // Button Hover Background
    $wp_customize->add_setting('ddpdm_login_diana_3_bg_button_hover_color_value', array(
        'default' => '#e8d553',
        'transport' => 'refresh'
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'ddpdm_login_diana_3_bg_button_hover_color', array(
        'label' => esc_html__('Buttons Hover Background Color', 'ddprodm'),
        'section' => 'ddpdm_login_section',
        'settings' => 'ddpdm_login_diana_3_bg_button_hover_color_value'
    )));

    // Button Hover text color
    $wp_customize->add_setting('ddpdm_login_diana_3_button_hover_color_value', array(
        'default' => '#ffffff',
        'transport' => 'refresh'
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'ddpdm_login_diana_3_button_hover_color', array(
        'label' => esc_html__('Buttons Hover Text Color', 'ddprodm'),
        'section' => 'ddpdm_login_section',
        'settings' => 'ddpdm_login_diana_3_button_hover_color_value'
    )));

    // lost password text font size

    $wp_customize->add_setting('ddpdm_diana_3_login_lost_font_size_value', array(
        'default' => '14',
        'transport' => 'refresh'
    ));

    $wp_customize->add_control(new ET_Divi_Range_Option($wp_customize, 'ddpdm_diana_3_login_lost_font_size', array(
        'label' => esc_html__('Lost Your Password... Font Size', 'ddprodm'),
        'section' => 'ddpdm_login_section',
        'settings' => 'ddpdm_diana_3_login_lost_font_size_value',
        'input_attrs' => array(
            'min' => 8,
            'max' => 50,
            'step' => 1
        )
    )));


    // Lost your password... color
    $wp_customize->add_setting('ddpdm_login_diana_3_lost_color_value', array(
        'default' => '#989898',
        'transport' => 'refresh'
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'ddpdm_login_diana_3_lost_color', array(
        'label' => esc_html__('Lost Your Password... Text Color', 'ddprodm'),
        'section' => 'ddpdm_login_section',
        'settings' => 'ddpdm_login_diana_3_lost_color_value'
    )));

    // Info Background
    $wp_customize->add_setting('ddpdm_login_diana_3_bg_info_color_value', array(
        'default' => '#f8f8f6',
        'transport' => 'refresh'
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'ddpdm_login_diana_3_bg_info_color', array(
        'label' => esc_html__('Info Box Background Color', 'ddprodm'),
        'section' => 'ddpdm_login_section',
        'settings' => 'ddpdm_login_diana_3_bg_info_color_value'
    )));

    // Logo image upload

    $wp_customize->add_setting('ddpdm_login_diana_3_logo_image', array(
        'default' => WP_PLUGIN_URL.'/ddprodm/include/diana/img/login-page3-logo.png',
        'transport' => 'refresh'
    ));


    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'ddpdm_login_diana_3_logo', array(
        'label' => esc_html__('Upload a logo', 'ddprodm'),
        'section' => 'ddpdm_login_section',
        'settings' => 'ddpdm_login_diana_3_logo_image'
    )));

    // Text info

    $wp_customize->add_setting('ddpdm_login_diana_3_info_address_value', array(
        'default' => '<h2>Office</h2><p>105 Road Name</p><p>Berlin</p><p>Germany</p>',
        'transport' => 'refresh'
    ));

    $wp_customize->add_control('ddpdm_login_diana_3_info_address', array(
        'type' => 'textarea',
        'section' => 'ddpdm_login_section',
        'label' => esc_html__('Address Text', 'ddprodm'),
        'settings' => 'ddpdm_login_diana_3_info_address_value'
    ));


    $wp_customize->add_setting('ddpdm_login_diana_3_info_contact_value', array(
        'default' => '<h2>Contacts</h2><p><a href="mailto:Name@website.com">Name@website.com</a></p>',
        'transport' => 'refresh'
    ));

    $wp_customize->add_control('ddpdm_login_diana_3_info_contact', array(
        'type' => 'textarea',
        'section' => 'ddpdm_login_section',
        'label' => esc_html__('Contact Text', 'ddprodm'),
        'settings' => 'ddpdm_login_diana_3_info_contact_value'
    ));

    $wp_customize->add_setting('ddpdm_login_diana_3_info_social_value', array(
        'default' => '<h2>Social</h2><p><a href="#">Facebook</a></p>   <p><a href="#">Instagram</a></p><p><a href="#">Twitter</a></p><p><a href="#">Behance</a></p><p><a href="#">Dribble</a></p>',
        'transport' => 'refresh'
    ));

    $wp_customize->add_control('ddpdm_login_diana_3_info_social', array(
        'type' => 'textarea',
        'section' => 'ddpdm_login_section',
        'label' => esc_html__('Social Links', 'ddprodm'),
        'settings' => 'ddpdm_login_diana_3_info_social_value'
    ));





    /////////////////////////////////////////


    // Add single post section
    $wp_customize->add_section('ddpdm_single_section', array(
        'priority' => 130,
        'title' => esc_html__('Single Blog Post Template', 'ddprodm'),
        'panel' => 'ddpdm_blog_navigation_panel'
    ));

    // Load post preview

    $wp_customize->add_control('ddpdm_single_post_link', array(
        'section' => 'ddpdm_single_section',
        'settings' => array(),
        'type' => 'button',
        'priority' => 1,
        'input_attrs' => array(
            'value' => esc_html__('Load Single Post Template', 'ddprodm'),
            'class' => 'button button-secondary ddpdm-click-on-load hidden',
            'onclick' => 'wp.customize.previewer.previewUrl.set( "' . ddpdm_get_single_post_link() . '" );'
        )
    ));

    //  =============================
    //  = Single Blog Post Select Box         =
    //  =============================


    if (ddpdm_is_divi_item_exists('Single Post Right Sidebar - PHP Template - Diana')) {
        $choices_array_single = array(
            'disabled' => esc_html__('Disabled (use WordPress default)', 'ddprodm'),
            'diana_1' => 'Diana Single Post - Right Sidebar'
        );

    }

    else {
        $choices_array_single = array(
            'disabled' => esc_html__('Disabled (use WordPress default)', 'ddprodm')
        );

    }

    $wp_customize->add_setting('ddpdm_single_post_template', array(
        'default' => 'disabled',
        'capability' => 'edit_theme_options',
        'type' => 'option'

    ));
    $wp_customize->add_control('ddpdm_single_select_box', array(
        'settings' => 'ddpdm_single_post_template',
        'label' => esc_html__('Single Blog Post Template', 'ddprodm'),
        'description' => '<p><a href="https://seku.re/single-blog-post-customizer-kb" target="_blank" class="button button-secondary">'.__('Learn More - Watch a short video tutorial', 'ddprodm').'</a></p><p>'.__('This will rewrite your current Single Blog Post template. No saved templates yet?', 'ddprodm').' <a href="/wp-admin/admin.php?page=divi_den_pro_dm_dashboard&tab=ddpdm_settings">'.__('First save some here', 'ddprodm').'</a>. '.__('After saving they will appear in the drop-down below. You can also modify certain saved templates', 'ddprodm').' <a href="/wp-admin/edit.php?post_type=et_pb_layout&layout_category=single-blog-post" target="_blank">'.__('in the Divi Library', 'ddprodm').'</a>.</p><label class="customize-control-title">'.__('Saved Single Blog Post Templates', 'ddprodm').'</label><p>'.__('Choose a saved template to edit.', 'ddprodm').'</p>',
        'section' => 'ddpdm_single_section',
        'type' => 'select',
        'choices' => $choices_array_single
    ));

    $wp_customize->add_setting('ddpdm_single_content_color_value', array(
        'default' => '#a6a6a6',
        'transport' => 'refresh'
    ));

    $wp_customize->add_setting('ddpdm_single_content_size_value', array(
        'default' => '16',
        'transport' => 'refresh'
    ));

    $wp_customize->add_setting('ddpdm_single_rm_color_value', array(
        'default' => '#33373a',
        'transport' => 'refresh'
    ));

    $wp_customize->add_setting('ddpdm_single_rm_size_value', array(
        'default' => '16',
        'transport' => 'refresh'
    ));


    //  ===============================
    //  = Single Blog Post Pages title color  =
    //  ===============================

    $wp_customize->add_setting('ddpdm_single_header_color_value', array(
        'default' => '#33373a',
        'transport' => 'refresh'
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'ddpdm_single_header_color', array(
        'label' => esc_html__('Post Title Color', 'ddprodm'),
        'section' => 'ddpdm_single_section',
        'settings' => 'ddpdm_single_header_color_value'
    )));



    $wp_customize->add_setting('ddpdm_single_header_size_value', array(
        'default' => '36',
        'transport' => 'refresh'
    ));

    $wp_customize->add_control(new ET_Divi_Range_Option($wp_customize, 'ddpdm_single_header_size', array(
        'label' => esc_html__('Post Title Font Size', 'ddprodm'),
        'section' => 'ddpdm_single_section',
        'settings' => 'ddpdm_single_header_size_value',
        'input_attrs' => array(
            'min' => 10,
            'max' => 72,
            'step' => 1
        )
    )));


    //  =============================
    //  = Single Blog Post Pages title font =
    //  =============================

    $wp_customize->add_setting('ddpdm_single_header_font', array(
        'sanitize_callback' => 'ddpdm_sanitize_fonts',
        'default' => 'Roboto',
        'transport' => 'refresh'
    ));

    $wp_customize->add_control('ddpdm_single_header_font_select', array(
        'type' => 'select',
        'label' => esc_html__('Post Title Font', 'ddprodm'),
        'section' => 'ddpdm_single_section',
        'settings' => 'ddpdm_single_header_font',
        'choices' => $font_choices
    ));


    //  ==============================
    //  = Single Blog Post Pages title style =
    //  ==============================

    $wp_customize->add_setting('ddpdm_single_header_font_style', array(
        'transport' => 'refresh'
    ));

    $wp_customize->add_control(new ET_Divi_Font_Style_Option($wp_customize, 'ddpdm_single_header_font_select', array(
        'label' => esc_html__('Post Title Font style', 'ddprodm'),
        'section' => 'ddpdm_single_section',
        'settings' => 'ddpdm_single_header_font_style',
        'type' => 'font_style',
        'choices' => et_divi_font_style_choices()
    )));

    //  ===============================
    //  = Single Blog Post Pages meta color  =
    //  ===============================

    $wp_customize->add_setting('ddpdm_single_meta_color_value', array(
        'default' => '#a6a6a6',
        'transport' => 'refresh'
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'ddpdm_single_meta_color', array(
        'label' => esc_html__('Meta Font Color', 'ddprodm'),
        'section' => 'ddpdm_single_section',
        'settings' => 'ddpdm_single_meta_color_value'
    )));

    $wp_customize->add_setting('ddpdm_single_meta_size_value', array(
        'default' => '16',
        'transport' => 'refresh'
    ));

    $wp_customize->add_control(new ET_Divi_Range_Option($wp_customize, 'ddpdm_single_meta_size', array(
        'label' => esc_html__('Meta Font Size', 'ddprodm'),
        'section' => 'ddpdm_single_section',
        'settings' => 'ddpdm_single_meta_size_value',
        'input_attrs' => array(
            'min' => 10,
            'max' => 36,
            'step' => 1
        )
    )));


    //  =============================
    //  = Single Blog Post Pages content     =
    //  =============================

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'ddpdm_single_content_color', array(
        'label' => esc_html__('Body Text Color', 'ddprodm'),
        'section' => 'ddpdm_single_section',
        'settings' => 'ddpdm_single_content_color_value'
    )));

    $wp_customize->add_control(new ET_Divi_Range_Option($wp_customize, 'ddpdm_single_content_size', array(
        'label' => esc_html__('Body Font Size', 'ddprodm'),
        'section' => 'ddpdm_single_section',
        'settings' => 'ddpdm_single_content_size_value',
        'input_attrs' => array(
            'min' => 10,
            'max' => 42,
            'step' => 1
        )
    )));


    //  ===============================
    //  = Single Blog Post Pages content font =
    //  ===============================

    $wp_customize->add_setting('ddpdm_single_body_font', array(
        'sanitize_callback' => 'ddpdm_sanitize_fonts',
        'default' => 'Roboto',
        'transport' => 'refresh'
    ));

    $wp_customize->add_control('ddpdm_single_body_font_select', array(
        'type' => 'select',
        'label' => esc_html__('Body Font', 'ddprodm'),
        'section' => 'ddpdm_single_section',
        'settings' => 'ddpdm_single_body_font',
        'choices' => $font_choices
    ));

    $wp_customize->add_setting('ddpdm_single_h1_h6_color_value', array(
        'default' => '#33373a',
        'transport' => 'refresh'
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'ddpdm_single_h1_h6_color', array(
        'label' => esc_html__('H1-H6 Font Color', 'ddprodm'),
        'section' => 'ddpdm_single_section',
        'settings' => 'ddpdm_single_h1_h6_color_value'
    )));

    $wp_customize->add_setting('ddpdm_single_h1_h6_font', array(
        'sanitize_callback' => 'ddpdm_sanitize_fonts',
        'default' => 'Roboto',
        'transport' => 'refresh'
    ));

    $wp_customize->add_control('ddpdm_single_h1_h6_font_select', array(
        'type' => 'select',
        'label' => esc_html__('H1-H6 Font', 'ddprodm'),
        'section' => 'ddpdm_single_section',
        'settings' => 'ddpdm_single_h1_h6_font',
        'choices' => $font_choices
    ));

    $wp_customize->add_setting('ddpdm_single_h1_h6_style_value', array(
        'transport' => 'refresh'
    ));

    $wp_customize->add_control(new ET_Divi_Font_Style_Option($wp_customize, 'ddpdm_single_h1_h6_style', array(
        'label' => esc_html__('H1-H6 Font style', 'ddprodm'),
        'section' => 'ddpdm_single_section',
        'settings' => 'ddpdm_single_h1_h6_style_value',
        'type' => 'font_style',
        'choices' => et_divi_font_style_choices()
    )));




    //  ===================================================
    //  = Single Blog Post author bio =
    //  ===================================================



    $wp_customize->add_setting('ddpdm_single_show_author', array(
        // 'type'          => 'option',
        'capability' => 'edit_theme_options',
        'transport' => 'refresh',
        'default' => true,
        'sanitize_callback' => 'ddpdm_sanitize_checkbox'
    ));

    $wp_customize->add_control('ddpdm_single_show_author_checkbox', array(
        'settings' => 'ddpdm_single_show_author',
        'label' => esc_html__('Show Author Bio after content', 'ddprodm'),
        'section' => 'ddpdm_single_section',
        'type' => 'checkbox'
    ));

    //  ===================================================
    //  = Single Blog Post author name color and size =
    //  ===================================================

    $wp_customize->add_setting('ddpdm_single_post_author_name_color_value', array(
        'default' => '#33373a',
        'transport' => 'refresh'
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'ddpdm_single_post_author_name_color', array(
        'label' => esc_html__('Author Name Color', 'ddprodm'),
        'section' => 'ddpdm_single_section',
        'settings' => 'ddpdm_single_post_author_name_color_value'
    )));



    $wp_customize->add_setting('ddpdm_single_post_author_name_size_value', array(
        'default' => '16',
        'transport' => 'refresh'
    ));

    $wp_customize->add_control(new ET_Divi_Range_Option($wp_customize, 'ddpdm_single_post_author_name_size', array(
        'label' => esc_html__('Author Name Font Size', 'ddprodm'),
        'section' => 'ddpdm_single_section',
        'settings' => 'ddpdm_single_post_author_name_size_value',
        'input_attrs' => array(
            'min' => 10,
            'max' => 72,
            'step' => 1
        )
    )));




    //  ===================================================
    //  = Single Blog Post author bio color and size =
    //  ===================================================


    $wp_customize->add_setting('ddpdm_single_post_author_bio_color_value', array(
        'default' => '#a6a6a6',
        'transport' => 'refresh'
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'ddpdm_single_post_author_bio_color', array(
        'label' => esc_html__('Author Bio Color', 'ddprodm'),
        'section' => 'ddpdm_single_section',
        'settings' => 'ddpdm_single_post_author_bio_color_value'
    )));



    $wp_customize->add_setting('ddpdm_single_post_author_bio_size_value', array(
        'default' => '16',
        'transport' => 'refresh'
    ));

    $wp_customize->add_control(new ET_Divi_Range_Option($wp_customize, 'ddpdm_single_post_author_bio_size', array(
        'label' => esc_html__('Author Bio Font Size', 'ddprodm'),
        'section' => 'ddpdm_single_section',
        'settings' => 'ddpdm_single_post_author_bio_size_value',
        'input_attrs' => array(
            'min' => 10,
            'max' => 72,
            'step' => 1
        )
    )));

    //  ===================================================
    //  = Single Blog Post related posts =
    //  ===================================================



    $wp_customize->add_setting('ddpdm_single_show_related', array(
        // 'type'          => 'option',
        'capability' => 'edit_theme_options',
        'transport' => 'refresh',
        'default' => true,
        'sanitize_callback' => 'ddpdm_sanitize_checkbox'
    ));

    $wp_customize->add_control('ddpdm_single_show_related_checkbox', array(
        'settings' => 'ddpdm_single_show_related',
        'label' => esc_html__('Show Related Posts', 'ddprodm'),
        'section' => 'ddpdm_single_section',
        'type' => 'checkbox'
    ));

    // Related Posts Header Text

    $wp_customize->add_setting('ddpdm_single_related_header_value', array(
        'default' => esc_html__('You may also like', 'ddprodm'),
        'transport' => 'refresh'
    ));

    $wp_customize->add_control('ddpdm_single_related_header', array(
        'type' => 'text',
        'section' => 'ddpdm_single_section',
        'label' => esc_html__('Related Posts Header Text', 'ddprodm'),
        'settings' => 'ddpdm_single_related_header_value'
    ));

    // Related Posts Header Color and size


    $wp_customize->add_setting('ddpdm_single_post_related_header_color_value', array(
        'default' => '#33373a',
        'transport' => 'refresh'
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'ddpdm_single_post_related_header_color', array(
        'label' => esc_html__('Related Posts Header Color', 'ddprodm'),
        'section' => 'ddpdm_single_section',
        'settings' => 'ddpdm_single_post_related_header_color_value'
    )));



    $wp_customize->add_setting('ddpdm_single_post_related_header_size_value', array(
        'default' => '21',
        'transport' => 'refresh'
    ));

    $wp_customize->add_control(new ET_Divi_Range_Option($wp_customize, 'ddpdm_single_post_related_header_size', array(
        'label' => esc_html__('Related Posts Header Size', 'ddprodm'),
        'section' => 'ddpdm_single_section',
        'settings' => 'ddpdm_single_post_related_header_size_value',
        'input_attrs' => array(
            'min' => 10,
            'max' => 72,
            'step' => 1
        )
    )));

    // Related Posts Single Post Color and size


    $wp_customize->add_setting('ddpdm_single_post_related_single_color_value', array(
        'default' => '#ffffff',
        'transport' => 'refresh'
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'ddpdm_single_post_related_single_color', array(
        'label' => esc_html__('Related Posts Single Post Color', 'ddprodm'),
        'section' => 'ddpdm_single_section',
        'settings' => 'ddpdm_single_post_related_single_color_value'
    )));


    $wp_customize->add_setting('ddpdm_single_post_related_single_header_size_value', array(
        'default' => '24',
        'transport' => 'refresh'
    ));

    $wp_customize->add_control(new ET_Divi_Range_Option($wp_customize, 'ddpdm_single_post_related_single_header_size', array(
        'label' => esc_html__('Related Posts Single Post Header Size', 'ddprodm'),
        'section' => 'ddpdm_single_section',
        'settings' => 'ddpdm_single_post_related_single_header_size_value',
        'input_attrs' => array(
            'min' => 10,
            'max' => 72,
            'step' => 1
        )
    )));

    $wp_customize->add_setting('ddpdm_single_post_related_single_date_size_value', array(
        'default' => '16',
        'transport' => 'refresh'
    ));

    $wp_customize->add_control(new ET_Divi_Range_Option($wp_customize, 'ddpdm_single_post_related_single_date_size', array(
        'label' => esc_html__('Related Posts Single Post Date Size', 'ddprodm'),
        'section' => 'ddpdm_single_section',
        'settings' => 'ddpdm_single_post_related_single_date_size_value',
        'input_attrs' => array(
            'min' => 8,
            'max' => 32,
            'step' => 1
        )
    )));

    // Comment Form Header Color and size


    $wp_customize->add_setting('ddpdm_single_post_comments_header_color_value', array(
        'default' => '#33373a',
        'transport' => 'refresh'
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'ddpdm_single_post_comments_header_color', array(
        'label' => esc_html__('Comment Form Header Color', 'ddprodm'),
        'section' => 'ddpdm_single_section',
        'settings' => 'ddpdm_single_post_comments_header_color_value'
    )));



    $wp_customize->add_setting('ddpdm_single_post_comments_header_size_value', array(
        'default' => '21',
        'transport' => 'refresh'
    ));

    $wp_customize->add_control(new ET_Divi_Range_Option($wp_customize, 'ddpdm_single_post_comments_header_size', array(
        'label' => esc_html__('Comment Form Header Size', 'ddprodm'),
        'section' => 'ddpdm_single_section',
        'settings' => 'ddpdm_single_post_comments_header_size_value',
        'input_attrs' => array(
            'min' => 10,
            'max' => 72,
            'step' => 1
        )
    )));

    // Comment form fields Color and size


    $wp_customize->add_setting('ddpdm_single_post_comments_fields_color_value', array(
        'default' => '#a6a6a6',
        'transport' => 'refresh'
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'ddpdm_single_post_comments_fields_color', array(
        'label' => esc_html__('Comment Form Fields Text Color', 'ddprodm'),
        'section' => 'ddpdm_single_section',
        'settings' => 'ddpdm_single_post_comments_fields_color_value'
    )));


    $wp_customize->add_setting('ddpdm_single_post_comments_fields_size_value', array(
        'default' => '16',
        'transport' => 'refresh'
    ));

    $wp_customize->add_control(new ET_Divi_Range_Option($wp_customize, 'ddpdm_single_post_comments_fields_size', array(
        'label' => esc_html__('Comment Form Fields Font Size', 'ddprodm'),
        'section' => 'ddpdm_single_section',
        'settings' => 'ddpdm_single_post_comments_fields_size_value',
        'input_attrs' => array(
            'min' => 10,
            'max' => 72,
            'step' => 1
        )
    )));

    //////////////////////////////

    // Add heading h1-h6 section
    $wp_customize->add_section('ddpdm_global_h1_h6_section', array(
        'priority' => 110,
        'title' => esc_html__('Global Headings (H1 - H6)', 'ddprodm'),
        'panel' => 'ddpdm_global_navigation_panel'
    ));

    $choices_array_h1_h6 = array(
        'disabled' => esc_html__('Disabled (use default)', 'ddprodm'),
        'global' => esc_html__('Global - change H1 - H6 styles together', 'ddprodm'),
        'individually' => esc_html__('Separately - change styles for each tag', 'ddprodm')
        // 'H1' => 'H1 Styles',
        // 'H2' => 'H2 Styles',
        // 'H3' => 'H3 Styles',
        // 'H4' => 'H4 Styles',
        // 'H5' => 'H5 Styles',
        // 'H6' => 'H6 Styles'
    );

    $wp_customize->add_setting('ddpdm_global_h1_h6', array(
        'default' => 'disabled',
        'capability' => 'edit_theme_options',
        'type' => 'option'

    ));
    $wp_customize->add_control('ddpdm_global_h1_h6_select_box', array(
        'settings' => 'ddpdm_global_h1_h6',
        'label' => esc_html__('Choose heading to customize', 'ddprodm'),
        'description' => '<p><a href="https://seku.re/global-headings-kb" target="_blank" class="button button-secondary">'.__('Learn More - Watch a short video tutorial', 'ddprodm').'</a></p><p>'.__('Change headings styles. Important: these settings will re-write ALL H1 - H6 styles - incl. all Divi modules, any-file-name.css or custom css entries.', 'ddprodm').'</p>',
        'section' => 'ddpdm_global_h1_h6_section',
        'type' => 'select',
        'choices' => $choices_array_h1_h6
    ));

    // Color
    $wp_customize->add_setting('ddpdm_global_h1_h6_color_value', array(
        // 'default' => '#000000',
        'transport' => 'refresh'
    ));

    $wp_customize->add_setting('ddpdm_global_h1_h6_font', array(
        'sanitize_callback' => 'ddpdm_sanitize_fonts',
        'default' => false,
        'transport' => 'refresh'
    ));

    $wp_customize->add_control('ddpdm_global_h1_h6_font_select', array(
        'type' => 'select',
        'label' => esc_html__('H1-H6 Font', 'ddprodm'),
        'section' => 'ddpdm_global_h1_h6_section',
        'settings' => 'ddpdm_global_h1_h6_font',
        'choices' => $font_choices
    ));

    $wp_customize->add_setting('ddpdm_global_h1_h6_style_value', array(
        'transport' => 'refresh'
    ));

    $wp_customize->add_control(new ET_Divi_Font_Style_Option($wp_customize, 'ddpdm_global_h1_h6_style', array(
        'label' => esc_html__('H1-H6 Font style', 'ddprodm'),
        'section' => 'ddpdm_global_h1_h6_section',
        'settings' => 'ddpdm_global_h1_h6_style_value',
        'type' => 'font_style',
        'choices' => et_divi_font_style_choices()
    )));



    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'ddpdm_global_h1_h6_color', array(
        'label' => esc_html__('H1 - H6 Color', 'ddprodm'),
        'section' => 'ddpdm_global_h1_h6_section',
        'settings' => 'ddpdm_global_h1_h6_color_value'
    )));

    $wp_customize->add_setting('ddpdm_global_h1_h6_size_value', array(
        // 'default' => '42',
        'transport' => 'refresh'
    ));

    $wp_customize->add_control(new ET_Divi_Range_Option($wp_customize, 'ddpdm_global_h1_h6_size', array(
        'label' => esc_html__('H1 - H6 Font Size', 'ddprodm'),
        'description' => esc_html__('Set max (H1) size. H2 - H6 sizes changes proportionally.', 'ddprodm'),
        'section' => 'ddpdm_global_h1_h6_section',
        'settings' => 'ddpdm_global_h1_h6_size_value',
        'input_attrs' => array(
            'min' => 18,
            'max' => 72,
            'step' => 1
        )
    )));

        $wp_customize->add_setting('ddpdm_global_h1_h6_line_height_value', array(
        // 'default' => '125',
        'transport' => 'refresh'
    ));

    $wp_customize->add_control(new ET_Divi_Range_Option($wp_customize, 'ddpdm_global_h1_h6_line_height', array(
        'label' => esc_html__('H1 - H6 Line Height', 'ddprodm'),
        'description' => esc_html__('In %', 'ddprodm'),
        'section' => 'ddpdm_global_h1_h6_section',
        'settings' => 'ddpdm_global_h1_h6_line_height_value',
        'input_attrs' => array(
            'min' => 0,
            'max' => 300,
            'step' => 1
        )
    )));

        $wp_customize->add_setting('ddpdm_global_h1_h6_letter_spacing_value', array(
        //'default' => '0',
        'transport' =>'refresh'
    ));

    $wp_customize->add_control(new ET_Divi_Range_Option($wp_customize, 'ddpdm_global_h1_h6_letter_spacing', array(
        'label' => esc_html__('H1 - H6 Letter Spacing', 'ddprodm'),
        'description' => esc_html__('In px', 'ddprodm'),
        'section' => 'ddpdm_global_h1_h6_section',
        'settings' => 'ddpdm_global_h1_h6_letter_spacing_value',
        'input_attrs' => array(
            'min' => -5,
            'max' => 10,
            'step' => 0.1
        )
    )));


    // H1
     // Color
    $wp_customize->add_setting('ddpdm_global_h1_color_value', array(
        // 'default' => '#000000',
        'transport' => 'refresh'
    ));

    $wp_customize->add_setting('ddpdm_global_h1_font', array(
        'sanitize_callback' => 'ddpdm_sanitize_fonts',
        'default' => false,
        'transport' => 'refresh'
    ));

    $wp_customize->add_control('ddpdm_global_h1_font_select', array(
        'type' => 'select',
        'label' => esc_html__('H1 Font', 'ddprodm'),
        'section' => 'ddpdm_global_h1_h6_section',
        'settings' => 'ddpdm_global_h1_font',
        'choices' => $font_choices
    ));

    $wp_customize->add_setting('ddpdm_global_h1_style_value', array(
        'transport' => 'refresh'
    ));

    $wp_customize->add_control(new ET_Divi_Font_Style_Option($wp_customize, 'ddpdm_global_h1_style', array(
        'label' => esc_html__('H1 Font style', 'ddprodm'),
        'section' => 'ddpdm_global_h1_h6_section',
        'settings' => 'ddpdm_global_h1_style_value',
        'type' => 'font_style',
        'choices' => et_divi_font_style_choices()
    )));



    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'ddpdm_global_h1_color', array(
        'label' => esc_html__('H1 Color', 'ddprodm'),
        'section' => 'ddpdm_global_h1_h6_section',
        'settings' => 'ddpdm_global_h1_color_value'
    )));

    $wp_customize->add_setting('ddpdm_global_h1_size_value', array(
        // 'default' => '42',
        'transport' => 'refresh'
    ));

    $wp_customize->add_control(new ET_Divi_Range_Option($wp_customize, 'ddpdm_global_h1_size', array(
        'label' => esc_html__('H1 Font Size', 'ddprodm'),
        'section' => 'ddpdm_global_h1_h6_section',
        'settings' => 'ddpdm_global_h1_size_value',
        'input_attrs' => array(
            'min' => 18,
            'max' => 72,
            'step' => 1
        )
    )));

        $wp_customize->add_setting('ddpdm_global_h1_line_height_value', array(
        // 'default' => '125',
        'transport' => 'refresh'
    ));

    $wp_customize->add_control(new ET_Divi_Range_Option($wp_customize, 'ddpdm_global_h1_line_height', array(
        'label' => esc_html__('H1 Line Height', 'ddprodm'),
        'description' => esc_html__('In %', 'ddprodm'),
        'section' => 'ddpdm_global_h1_h6_section',
        'settings' => 'ddpdm_global_h1_line_height_value',
        'input_attrs' => array(
            'min' => 0,
            'max' => 300,
            'step' => 1
        )
    )));

        $wp_customize->add_setting('ddpdm_global_h1_letter_spacing_value', array(
        //'default' => '0',
        'transport' =>'refresh'
    ));

    $wp_customize->add_control(new ET_Divi_Range_Option($wp_customize, 'ddpdm_global_h1_letter_spacing', array(
        'label' => esc_html__('H1 Letter Spacing', 'ddprodm'),
        'description' => esc_html__('In px', 'ddprodm'),
        'section' => 'ddpdm_global_h1_h6_section',
        'settings' => 'ddpdm_global_h1_letter_spacing_value',
        'input_attrs' => array(
            'min' => -5,
            'max' => 10,
            'step' => 0.1
        )
    )));

    //H2

                     // Color
    $wp_customize->add_setting('ddpdm_global_h2_color_value', array(
        // 'default' => '#000000',
        'transport' => 'refresh'
    ));

    $wp_customize->add_setting('ddpdm_global_h2_font', array(
        'sanitize_callback' => 'ddpdm_sanitize_fonts',
        'default' => false,
        'transport' => 'refresh'
    ));

    $wp_customize->add_control('ddpdm_global_h2_font_select', array(
        'type' => 'select',
        'label' => esc_html__('H2 Font', 'ddprodm'),
        'section' => 'ddpdm_global_h1_h6_section',
        'settings' => 'ddpdm_global_h2_font',
        'choices' => $font_choices
    ));

    $wp_customize->add_setting('ddpdm_global_h2_style_value', array(
        'transport' => 'refresh'
    ));

    $wp_customize->add_control(new ET_Divi_Font_Style_Option($wp_customize, 'ddpdm_global_h2_style', array(
        'label' => esc_html__('H2 Font style', 'ddprodm'),
        'section' => 'ddpdm_global_h1_h6_section',
        'settings' => 'ddpdm_global_h2_style_value',
        'type' => 'font_style',
        'choices' => et_divi_font_style_choices()
    )));



    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'ddpdm_global_h2_color', array(
        'label' => esc_html__('H2 Color', 'ddprodm'),
        'section' => 'ddpdm_global_h1_h6_section',
        'settings' => 'ddpdm_global_h2_color_value'
    )));

    $wp_customize->add_setting('ddpdm_global_h2_size_value', array(
        // 'default' => '42',
        'transport' => 'refresh'
    ));

    $wp_customize->add_control(new ET_Divi_Range_Option($wp_customize, 'ddpdm_global_h2_size', array(
        'label' => esc_html__('H2 Font Size', 'ddprodm'),
        'section' => 'ddpdm_global_h1_h6_section',
        'settings' => 'ddpdm_global_h2_size_value',
        'input_attrs' => array(
            'min' => 18,
            'max' => 72,
            'step' => 1
        )
    )));

        $wp_customize->add_setting('ddpdm_global_h2_line_height_value', array(
        // 'default' => '125',
        'transport' => 'refresh'
    ));

    $wp_customize->add_control(new ET_Divi_Range_Option($wp_customize, 'ddpdm_global_h2_line_height', array(
        'label' => esc_html__('H2 Line Height', 'ddprodm'),
        'description' => esc_html__('In %', 'ddprodm'),
        'section' => 'ddpdm_global_h1_h6_section',
        'settings' => 'ddpdm_global_h2_line_height_value',
        'input_attrs' => array(
            'min' => 0,
            'max' => 300,
            'step' => 1
        )
    )));

        $wp_customize->add_setting('ddpdm_global_h2_letter_spacing_value', array(
        //'default' => '0',
        'transport' =>'refresh'
    ));

    $wp_customize->add_control(new ET_Divi_Range_Option($wp_customize, 'ddpdm_global_h2_letter_spacing', array(
        'label' => esc_html__('H2 Letter Spacing', 'ddprodm'),
        'description' => esc_html__('In px', 'ddprodm'),
        'section' => 'ddpdm_global_h1_h6_section',
        'settings' => 'ddpdm_global_h2_letter_spacing_value',
        'input_attrs' => array(
            'min' => -5,
            'max' => 10,
            'step' => 0.1
        )
    )));

        //H3

                     // Color
    $wp_customize->add_setting('ddpdm_global_h3_color_value', array(
        // 'default' => '#000000',
        'transport' => 'refresh'
    ));

    $wp_customize->add_setting('ddpdm_global_h3_font', array(
        'sanitize_callback' => 'ddpdm_sanitize_fonts',
        'default' => false,
        'transport' => 'refresh'
    ));

    $wp_customize->add_control('ddpdm_global_h3_font_select', array(
        'type' => 'select',
        'label' => esc_html__('H3 Font', 'ddprodm'),
        'section' => 'ddpdm_global_h1_h6_section',
        'settings' => 'ddpdm_global_h3_font',
        'choices' => $font_choices
    ));

    $wp_customize->add_setting('ddpdm_global_h3_style_value', array(
        'transport' => 'refresh'
    ));

    $wp_customize->add_control(new ET_Divi_Font_Style_Option($wp_customize, 'ddpdm_global_h3_style', array(
        'label' => esc_html__('H3 Font style', 'ddprodm'),
        'section' => 'ddpdm_global_h1_h6_section',
        'settings' => 'ddpdm_global_h3_style_value',
        'type' => 'font_style',
        'choices' => et_divi_font_style_choices()
    )));



    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'ddpdm_global_h3_color', array(
        'label' => esc_html__('H3 Color', 'ddprodm'),
        'section' => 'ddpdm_global_h1_h6_section',
        'settings' => 'ddpdm_global_h3_color_value'
    )));

    $wp_customize->add_setting('ddpdm_global_h3_size_value', array(
        // 'default' => '42',
        'transport' => 'refresh'
    ));

    $wp_customize->add_control(new ET_Divi_Range_Option($wp_customize, 'ddpdm_global_h3_size', array(
        'label' => esc_html__('H3 Font Size', 'ddprodm'),
        'section' => 'ddpdm_global_h1_h6_section',
        'settings' => 'ddpdm_global_h3_size_value',
        'input_attrs' => array(
            'min' => 18,
            'max' => 72,
            'step' => 1
        )
    )));

        $wp_customize->add_setting('ddpdm_global_h3_line_height_value', array(
        // 'default' => '125',
        'transport' => 'refresh'
    ));

    $wp_customize->add_control(new ET_Divi_Range_Option($wp_customize, 'ddpdm_global_h3_line_height', array(
        'label' => esc_html__('H3 Line Height', 'ddprodm'),
        'description' => esc_html__('In %', 'ddprodm'),
        'section' => 'ddpdm_global_h1_h6_section',
        'settings' => 'ddpdm_global_h3_line_height_value',
        'input_attrs' => array(
            'min' => 0,
            'max' => 300,
            'step' => 1
        )
    )));

        $wp_customize->add_setting('ddpdm_global_h3_letter_spacing_value', array(
        //'default' => '0',
        'transport' =>'refresh'
    ));

    $wp_customize->add_control(new ET_Divi_Range_Option($wp_customize, 'ddpdm_global_h3_letter_spacing', array(
        'label' => esc_html__('H3 Letter Spacing', 'ddprodm'),
        'description' => esc_html__('In px', 'ddprodm'),
        'section' => 'ddpdm_global_h1_h6_section',
        'settings' => 'ddpdm_global_h3_letter_spacing_value',
        'input_attrs' => array(
            'min' => -5,
            'max' => 10,
            'step' => 0.1
        )
    )));

            //H4

                     // Color
    $wp_customize->add_setting('ddpdm_global_h4_color_value', array(
        // 'default' => '#000000',
        'transport' => 'refresh'
    ));

    $wp_customize->add_setting('ddpdm_global_h4_font', array(
        'sanitize_callback' => 'ddpdm_sanitize_fonts',
        'default' => false,
        'transport' => 'refresh'
    ));

    $wp_customize->add_control('ddpdm_global_h4_font_select', array(
        'type' => 'select',
        'label' => esc_html__('H4 Font', 'ddprodm'),
        'section' => 'ddpdm_global_h1_h6_section',
        'settings' => 'ddpdm_global_h4_font',
        'choices' => $font_choices
    ));

    $wp_customize->add_setting('ddpdm_global_h4_style_value', array(
        'transport' => 'refresh'
    ));

    $wp_customize->add_control(new ET_Divi_Font_Style_Option($wp_customize, 'ddpdm_global_h4_style', array(
        'label' => esc_html__('H4 Font style', 'ddprodm'),
        'section' => 'ddpdm_global_h1_h6_section',
        'settings' => 'ddpdm_global_h4_style_value',
        'type' => 'font_style',
        'choices' => et_divi_font_style_choices()
    )));



    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'ddpdm_global_h4_color', array(
        'label' => esc_html__('H4 Color', 'ddprodm'),
        'section' => 'ddpdm_global_h1_h6_section',
        'settings' => 'ddpdm_global_h4_color_value'
    )));

    $wp_customize->add_setting('ddpdm_global_h4_size_value', array(
        // 'default' => '42',
        'transport' => 'refresh'
    ));

    $wp_customize->add_control(new ET_Divi_Range_Option($wp_customize, 'ddpdm_global_h4_size', array(
        'label' => esc_html__('H4 Font Size', 'ddprodm'),
        'section' => 'ddpdm_global_h1_h6_section',
        'settings' => 'ddpdm_global_h4_size_value',
        'input_attrs' => array(
            'min' => 18,
            'max' => 72,
            'step' => 1
        )
    )));

        $wp_customize->add_setting('ddpdm_global_h4_line_height_value', array(
        // 'default' => '125',
        'transport' => 'refresh'
    ));

    $wp_customize->add_control(new ET_Divi_Range_Option($wp_customize, 'ddpdm_global_h4_line_height', array(
        'label' => esc_html__('H4 Line Height', 'ddprodm'),
        'description' => esc_html__('In %', 'ddprodm'),
        'section' => 'ddpdm_global_h1_h6_section',
        'settings' => 'ddpdm_global_h4_line_height_value',
        'input_attrs' => array(
            'min' => 0,
            'max' => 300,
            'step' => 1
        )
    )));

        $wp_customize->add_setting('ddpdm_global_h4_letter_spacing_value', array(
        //'default' => '0',
        'transport' =>'refresh'
    ));

    $wp_customize->add_control(new ET_Divi_Range_Option($wp_customize, 'ddpdm_global_h4_letter_spacing', array(
        'label' => esc_html__('H4 Letter Spacing', 'ddprodm'),
        'description' => esc_html__('In px', 'ddprodm'),
        'section' => 'ddpdm_global_h1_h6_section',
        'settings' => 'ddpdm_global_h4_letter_spacing_value',
        'input_attrs' => array(
            'min' => -5,
            'max' => 10,
            'step' => 0.1
        )
    )));

            //H5

                     // Color
    $wp_customize->add_setting('ddpdm_global_h5_color_value', array(
        // 'default' => '#000000',
        'transport' => 'refresh'
    ));

    $wp_customize->add_setting('ddpdm_global_h5_font', array(
        'sanitize_callback' => 'ddpdm_sanitize_fonts',
        'default' => false,
        'transport' => 'refresh'
    ));

    $wp_customize->add_control('ddpdm_global_h5_font_select', array(
        'type' => 'select',
        'label' => esc_html__('H5 Font', 'ddprodm'),
        'section' => 'ddpdm_global_h1_h6_section',
        'settings' => 'ddpdm_global_h5_font',
        'choices' => $font_choices
    ));

    $wp_customize->add_setting('ddpdm_global_h5_style_value', array(
        'transport' => 'refresh'
    ));

    $wp_customize->add_control(new ET_Divi_Font_Style_Option($wp_customize, 'ddpdm_global_h5_style', array(
        'label' => esc_html__('H5 Font style', 'ddprodm'),
        'section' => 'ddpdm_global_h1_h6_section',
        'settings' => 'ddpdm_global_h5_style_value',
        'type' => 'font_style',
        'choices' => et_divi_font_style_choices()
    )));



    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'ddpdm_global_h5_color', array(
        'label' => esc_html__('H5 Color', 'ddprodm'),
        'section' => 'ddpdm_global_h1_h6_section',
        'settings' => 'ddpdm_global_h5_color_value'
    )));

    $wp_customize->add_setting('ddpdm_global_h5_size_value', array(
        // 'default' => '42',
        'transport' => 'refresh'
    ));

    $wp_customize->add_control(new ET_Divi_Range_Option($wp_customize, 'ddpdm_global_h5_size', array(
        'label' => esc_html__('H5 Font Size', 'ddprodm'),
        'section' => 'ddpdm_global_h1_h6_section',
        'settings' => 'ddpdm_global_h5_size_value',
        'input_attrs' => array(
            'min' => 18,
            'max' => 72,
            'step' => 1
        )
    )));

        $wp_customize->add_setting('ddpdm_global_h5_line_height_value', array(
        // 'default' => '125',
        'transport' => 'refresh'
    ));

    $wp_customize->add_control(new ET_Divi_Range_Option($wp_customize, 'ddpdm_global_h5_line_height', array(
        'label' => esc_html__('H5 Line Height', 'ddprodm'),
        'description' => esc_html__('In %', 'ddprodm'),
        'section' => 'ddpdm_global_h1_h6_section',
        'settings' => 'ddpdm_global_h5_line_height_value',
        'input_attrs' => array(
            'min' => 0,
            'max' => 300,
            'step' => 1
        )
    )));

        $wp_customize->add_setting('ddpdm_global_h5_letter_spacing_value', array(
        //'default' => '0',
        'transport' =>'refresh'
    ));

    $wp_customize->add_control(new ET_Divi_Range_Option($wp_customize, 'ddpdm_global_h5_letter_spacing', array(
        'label' => esc_html__('H5 Letter Spacing', 'ddprodm'),
        'description' => esc_html__('In px', 'ddprodm'),
        'section' => 'ddpdm_global_h1_h6_section',
        'settings' => 'ddpdm_global_h5_letter_spacing_value',
        'input_attrs' => array(
            'min' => -5,
            'max' => 10,
            'step' => 0.1
        )
    )));

            //H6

                     // Color
    $wp_customize->add_setting('ddpdm_global_h6_color_value', array(
        // 'default' => '#000000',
        'transport' => 'refresh'
    ));

    $wp_customize->add_setting('ddpdm_global_h6_font', array(
        'sanitize_callback' => 'ddpdm_sanitize_fonts',
        'default' => false,
        'transport' => 'refresh'
    ));

    $wp_customize->add_control('ddpdm_global_h6_font_select', array(
        'type' => 'select',
        'label' => esc_html__('H6 Font', 'ddprodm'),
        'section' => 'ddpdm_global_h1_h6_section',
        'settings' => 'ddpdm_global_h6_font',
        'choices' => $font_choices
    ));

    $wp_customize->add_setting('ddpdm_global_h6_style_value', array(
        'transport' => 'refresh'
    ));

    $wp_customize->add_control(new ET_Divi_Font_Style_Option($wp_customize, 'ddpdm_global_h6_style', array(
        'label' => esc_html__('H6 Font style', 'ddprodm'),
        'section' => 'ddpdm_global_h1_h6_section',
        'settings' => 'ddpdm_global_h6_style_value',
        'type' => 'font_style',
        'choices' => et_divi_font_style_choices()
    )));



    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'ddpdm_global_h6_color', array(
        'label' => esc_html__('H6 Color', 'ddprodm'),
        'section' => 'ddpdm_global_h1_h6_section',
        'settings' => 'ddpdm_global_h6_color_value'
    )));

    $wp_customize->add_setting('ddpdm_global_h6_size_value', array(
        // 'default' => '42',
        'transport' => 'refresh'
    ));

    $wp_customize->add_control(new ET_Divi_Range_Option($wp_customize, 'ddpdm_global_h6_size', array(
        'label' => esc_html__('H6 Font Size', 'ddprodm'),
        'section' => 'ddpdm_global_h1_h6_section',
        'settings' => 'ddpdm_global_h6_size_value',
        'input_attrs' => array(
            'min' => 18,
            'max' => 72,
            'step' => 1
        )
    )));

        $wp_customize->add_setting('ddpdm_global_h6_line_height_value', array(
        // 'default' => '125',
        'transport' => 'refresh'
    ));

    $wp_customize->add_control(new ET_Divi_Range_Option($wp_customize, 'ddpdm_global_h6_line_height', array(
        'label' => esc_html__('H6 Line Height', 'ddprodm'),
        'description' => esc_html__('In %', 'ddprodm'),
        'section' => 'ddpdm_global_h1_h6_section',
        'settings' => 'ddpdm_global_h6_line_height_value',
        'input_attrs' => array(
            'min' => 0,
            'max' => 300,
            'step' => 1
        )
    )));

        $wp_customize->add_setting('ddpdm_global_h6_letter_spacing_value', array(
        //'default' => '0',
        'transport' =>'refresh'
    ));

    $wp_customize->add_control(new ET_Divi_Range_Option($wp_customize, 'ddpdm_global_h6_letter_spacing', array(
        'label' => esc_html__('H6 Letter Spacing', 'ddprodm'),
        'description' => esc_html__('In px', 'ddprodm'),
        'section' => 'ddpdm_global_h1_h6_section',
        'settings' => 'ddpdm_global_h6_letter_spacing_value',
        'input_attrs' => array(
            'min' => -5,
            'max' => 10,
            'step' => 0.1
        )
    )));


}

add_action('customize_register', 'ddpdm_customize_register');