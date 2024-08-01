<?php

//  ==============================
//  = Conditionaly hide settings =
//  ==============================

add_action( 'customize_register', function( $wp_customize ) {
    // search results settings
    $search_results_controls = array_filter( array(
        $wp_customize->get_control( 'ddpdm_search_results_header_color' ),
        $wp_customize->get_control( 'ddpdm_search_results_header_size' ),
        $wp_customize->get_control( 'ddpdm_search_results_header_font' ),
        $wp_customize->get_control( 'ddpdm_search_results_header_font_select' ),
        $wp_customize->get_control( 'ddpdm_search_results_meta_color' ),
        $wp_customize->get_control( 'ddpdm_search_results_meta_size' ),
        $wp_customize->get_control( 'ddpdm_search_results_content_color' ),
        $wp_customize->get_control( 'ddpdm_search_results_content_size' ),
        $wp_customize->get_control( 'ddpdm_search_results_body_font' ),
        $wp_customize->get_control( 'ddpdm_search_results_body_font_select' ),
        $wp_customize->get_control( 'ddpdm_search_results_rm_color' ),
        $wp_customize->get_control( 'ddpdm_search_results_rm_size' ),
        $wp_customize->get_control( 'ddpdm_search_results_line_color' ),
        $wp_customize->get_control( 'ddpdm_search_results_line_size' ),


    ) );
    foreach ( $search_results_controls as $control ) {
        $control->active_callback = function( $control ) {
            $setting = $control->manager->get_setting( 'ddpdm_search_results_page_template' );
            if ( ! $setting ) {
                return true;
            }
            return 'disabled' !== $setting->value();
        };
    }

        // global archive settings
    $global_archive_controls = array_filter( array(
        $wp_customize->get_control( 'ddpdm_global_archive_header_color' ),
        $wp_customize->get_control( 'ddpdm_global_archive_header_size' ),
        $wp_customize->get_control( 'ddpdm_global_archive_header_font' ),
        $wp_customize->get_control( 'ddpdm_global_archive_header_font_select' ),
        $wp_customize->get_control( 'ddpdm_global_archive_content_color' ),
        $wp_customize->get_control( 'ddpdm_global_archive_content_size' ),
        $wp_customize->get_control( 'ddpdm_global_archive_author_name_color' ),
        $wp_customize->get_control( 'ddpdm_global_archive_author_name_size' ),
        $wp_customize->get_control( 'ddpdm_global_archive_author_bio_color' ),
        $wp_customize->get_control( 'ddpdm_global_archive_author_bio_size' ),
        $wp_customize->get_control( 'ddpdm_global_archive_body_font' ),
        $wp_customize->get_control( 'ddpdm_global_archive_body_font_select' ),
        $wp_customize->get_control( 'ddpdm_global_archive_rm_color' ),
        $wp_customize->get_control( 'ddpdm_global_archive_rm_size' ),
        $wp_customize->get_control( 'ddpdm_global_archive_date_color' ),
        $wp_customize->get_control( 'ddpdm_global_archive_date_bgcolor' ),


    ) );
    foreach ( $global_archive_controls as $control ) {
        $control->active_callback = function( $control ) {
            $setting = $control->manager->get_setting( 'ddpdm_global_page_template' );
            if ( ! $setting ) {
                return true;
            }
            return 'diana_1' === $setting->value();
        };
    }

    $global_archive_controls_col = array_filter( array(
        $wp_customize->get_control( 'ddpdm_global_archive_header_color_col' ),
        $wp_customize->get_control( 'ddpdm_global_archive_header_size_col' ),
        $wp_customize->get_control( 'ddpdm_global_archive_header_font_col' ),
        $wp_customize->get_control( 'ddpdm_global_archive_header_font_select_col' ),
        $wp_customize->get_control( 'ddpdm_global_archive_meta_color_col' ),
        $wp_customize->get_control( 'ddpdm_global_archive_meta_size_col' ),
        $wp_customize->get_control( 'ddpdm_global_archive_author_name_color_col' ),
        $wp_customize->get_control( 'ddpdm_global_archive_author_name_size_col' ),
        $wp_customize->get_control( 'ddpdm_global_archive_author_bio_color_col' ),
        $wp_customize->get_control( 'ddpdm_global_archive_author_bio_size_col' ),
        $wp_customize->get_control( 'ddpdm_global_archive_rm_color_col' ),
        $wp_customize->get_control( 'ddpdm_global_archive_rm_size_col' ),
        $wp_customize->get_control( 'ddpdm_global_archive_date_color_col' ),
        $wp_customize->get_control( 'ddpdm_global_archive_date_bgcolor_col' ),
        $wp_customize->get_control( 'ddpdm_global_archive_mdcr_font_col' ),
    ) );

    foreach ( $global_archive_controls_col as $control ) {
        $control->active_callback = function( $control ) {
            $setting = $control->manager->get_setting( 'ddpdm_global_page_template' );
            if ( ! $setting ) {
                return true;
            }
            return 'diana_1' !== $setting->value() && 'disabled' !== $setting->value();
        };
    }


        // category archive settings
    $category_controls = array_filter( array(
        $wp_customize->get_control( 'ddpdm_category_header_color' ),
        $wp_customize->get_control( 'ddpdm_category_header_size' ),
        $wp_customize->get_control( 'ddpdm_category_header_font' ),
        $wp_customize->get_control( 'ddpdm_category_header_font_select' ),
        $wp_customize->get_control( 'ddpdm_category_content_color' ),
        $wp_customize->get_control( 'ddpdm_category_content_size' ),
        $wp_customize->get_control( 'ddpdm_category_body_font' ),
        $wp_customize->get_control( 'ddpdm_category_body_font_select' ),
        $wp_customize->get_control( 'ddpdm_category_rm_color' ),
        $wp_customize->get_control( 'ddpdm_category_rm_size' ),
        $wp_customize->get_control( 'ddpdm_category_date_color' ),
        $wp_customize->get_control( 'ddpdm_category_date_size' ),
        $wp_customize->get_control( 'ddpdm_category_date_bgcolor' ),


    ) );
    foreach ( $category_controls as $control ) {
        $control->active_callback = function( $control ) {
            $setting = $control->manager->get_setting( 'ddpdm_category_page_template' );
            if ( ! $setting ) {
                return true;
            }
            return 'diana_1' === $setting->value();
        };
    }

    $category_controls_col = array_filter( array(
        $wp_customize->get_control( 'ddpdm_category_header_color_col' ),
        $wp_customize->get_control( 'ddpdm_category_header_size_col' ),
        $wp_customize->get_control( 'ddpdm_category_header_font_col' ),
        $wp_customize->get_control( 'ddpdm_category_header_font_select_col' ),
        $wp_customize->get_control( 'ddpdm_category_meta_color_col' ),
        $wp_customize->get_control( 'ddpdm_category_meta_size_col' ),
        $wp_customize->get_control( 'ddpdm_category_rm_color_col' ),
        $wp_customize->get_control( 'ddpdm_category_rm_size_col' ),
        $wp_customize->get_control( 'ddpdm_category_date_color_col' ),
        $wp_customize->get_control( 'ddpdm_category_date_bgcolor_col' ),
        $wp_customize->get_control( 'ddpdm_category_date_size_col' ),
        $wp_customize->get_control( 'ddpdm_category_mdcr_font_col' ),
    ) );

    foreach ( $category_controls_col as $control ) {
        $control->active_callback = function( $control ) {
            $setting = $control->manager->get_setting( 'ddpdm_category_page_template' );
            if ( ! $setting ) {
                return true;
            }
            return 'diana_1' !== $setting->value() && 'disabled' !== $setting->value() && 'global' !== $setting->value();
        };
    }

         // tag archive settings
    $tag_controls = array_filter( array(
        $wp_customize->get_control( 'ddpdm_tag_header_color' ),
        $wp_customize->get_control( 'ddpdm_tag_header_size' ),
        $wp_customize->get_control( 'ddpdm_tag_header_font' ),
        $wp_customize->get_control( 'ddpdm_tag_header_font_select' ),
        $wp_customize->get_control( 'ddpdm_tag_content_color' ),
        $wp_customize->get_control( 'ddpdm_tag_content_size' ),
        $wp_customize->get_control( 'ddpdm_tag_body_font' ),
        $wp_customize->get_control( 'ddpdm_tag_body_font_select' ),
        $wp_customize->get_control( 'ddpdm_tag_rm_color' ),
        $wp_customize->get_control( 'ddpdm_tag_rm_size' ),
        $wp_customize->get_control( 'ddpdm_tag_date_color' ),
        $wp_customize->get_control( 'ddpdm_tag_date_bgcolor' ),


    ) );
    foreach ( $tag_controls as $control ) {
        $control->active_callback = function( $control ) {
            $setting = $control->manager->get_setting( 'ddpdm_tag_page_template' );
            if ( ! $setting ) {
                return true;
            }
            return 'diana_1' === $setting->value();
        };
    }

    $tag_controls_col = array_filter( array(
        $wp_customize->get_control( 'ddpdm_tag_header_color_col' ),
        $wp_customize->get_control( 'ddpdm_tag_header_size_col' ),
        $wp_customize->get_control( 'ddpdm_tag_header_font_col' ),
        $wp_customize->get_control( 'ddpdm_tag_header_font_select_col' ),
        $wp_customize->get_control( 'ddpdm_tag_meta_color_col' ),
        $wp_customize->get_control( 'ddpdm_tag_meta_size_col' ),
        $wp_customize->get_control( 'ddpdm_tag_rm_color_col' ),
        $wp_customize->get_control( 'ddpdm_tag_rm_size_col' ),
        $wp_customize->get_control( 'ddpdm_tag_date_color_col' ),
        $wp_customize->get_control( 'ddpdm_tag_date_bgcolor_col' ),
        $wp_customize->get_control( 'ddpdm_tag_mdcr_font_col' ),
    ) );

    foreach ( $tag_controls_col as $control ) {
        $control->active_callback = function( $control ) {
            $setting = $control->manager->get_setting( 'ddpdm_tag_page_template' );
            if ( ! $setting ) {
                return true;
            }
            return 'diana_1' !== $setting->value() && 'disabled' !== $setting->value() && 'global' !== $setting->value();
        };
    }

         // author archive settings
    $author_controls = array_filter( array(
        $wp_customize->get_control( 'ddpdm_author_header_color' ),
        $wp_customize->get_control( 'ddpdm_author_header_size' ),
        $wp_customize->get_control( 'ddpdm_author_header_font' ),
        $wp_customize->get_control( 'ddpdm_author_header_font_select' ),
        $wp_customize->get_control( 'ddpdm_author_content_color' ),
        $wp_customize->get_control( 'ddpdm_author_content_size' ),
        $wp_customize->get_control( 'ddpdm_author_name_color' ),
        $wp_customize->get_control( 'ddpdm_author_name_size' ),
        $wp_customize->get_control( 'ddpdm_author_bio_color' ),
        $wp_customize->get_control( 'ddpdm_author_bio_size' ),
        $wp_customize->get_control( 'ddpdm_author_body_font' ),
        $wp_customize->get_control( 'ddpdm_author_body_font_select' ),
        $wp_customize->get_control( 'ddpdm_author_rm_color' ),
        $wp_customize->get_control( 'ddpdm_author_rm_size' ),
        $wp_customize->get_control( 'ddpdm_author_date_color' ),
        $wp_customize->get_control( 'ddpdm_author_date_bgcolor' ),


    ) );
    foreach ( $author_controls as $control ) {
        $control->active_callback = function( $control ) {
            $setting = $control->manager->get_setting( 'ddpdm_author_page_template' );
            if ( ! $setting ) {
                return true;
            }
            return 'diana_1' === $setting->value();
        };
    }

    $author_controls_col = array_filter( array(
        $wp_customize->get_control( 'ddpdm_author_header_color_col' ),
        $wp_customize->get_control( 'ddpdm_author_header_size_col' ),
        $wp_customize->get_control( 'ddpdm_author_header_font_col' ),
        $wp_customize->get_control( 'ddpdm_author_header_font_select_col' ),
        $wp_customize->get_control( 'ddpdm_author_meta_color_col' ),
        $wp_customize->get_control( 'ddpdm_author_meta_size_col' ),
        $wp_customize->get_control( 'ddpdm_author_name_color_col' ),
        $wp_customize->get_control( 'ddpdm_author_name_size_col' ),
        $wp_customize->get_control( 'ddpdm_author_bio_color_col' ),
        $wp_customize->get_control( 'ddpdm_author_bio_size_col' ),
        $wp_customize->get_control( 'ddpdm_author_rm_color_col' ),
        $wp_customize->get_control( 'ddpdm_author_rm_size_col' ),
        $wp_customize->get_control( 'ddpdm_author_date_color_col' ),
        $wp_customize->get_control( 'ddpdm_author_date_bgcolor_col' ),
        $wp_customize->get_control( 'ddpdm_author_mdcr_font_col' ),
    ) );

    foreach ( $author_controls_col as $control ) {
        $control->active_callback = function( $control ) {
            $setting = $control->manager->get_setting( 'ddpdm_author_page_template' );
            if ( ! $setting ) {
                return true;
            }
            return 'diana_1' !== $setting->value() && 'disabled' !== $setting->value() && 'global' !== $setting->value();
        };
    }

         // login diana 1 settings
    $login_diana_1_controls = array_filter( array(
        $wp_customize->get_control( 'ddpdm_login_diana_1_bg_color' ),
        $wp_customize->get_control( 'ddpdm_login_diana_1_shadow_color' ),
        $wp_customize->get_control( 'ddpdm_login_diana_1_logo' ),
        $wp_customize->get_control( 'ddpdm_login_diana_1_font' ),
        $wp_customize->get_control( 'ddpdm_login_diana_1_font_select' ),
        $wp_customize->get_control( 'ddpdm_diana_1_login_fields_font_size' ),
        $wp_customize->get_control( 'ddpdm_login_diana_1_fields_color' ),
        $wp_customize->get_control( 'ddpdm_diana_1_login_remember_me_font_size' ),
        $wp_customize->get_control( 'ddpdm_login_diana_1_remember_color' ),
        $wp_customize->get_control( 'ddpdm_diana_1_login_button_font_size' ),
        $wp_customize->get_control( 'ddpdm_login_diana_1_bg_button_color' ),
        $wp_customize->get_control( 'ddpdm_login_diana_1_button_color' ),
        $wp_customize->get_control( 'ddpdm_login_diana_1_bg_button_hover_color' ),
        $wp_customize->get_control( 'ddpdm_login_diana_1_button_hover_color' ),
        $wp_customize->get_control( 'ddpdm_diana_1_login_lost_font_size' ),
        $wp_customize->get_control( 'ddpdm_login_diana_1_lost_color' ),


    ) );
    foreach ( $login_diana_1_controls as $control ) {
        $control->active_callback = function( $control ) {
            $setting = $control->manager->get_setting( 'ddpdm_login_template' );
            if ( ! $setting ) {
                return true;
            }
            return 'diana_1' === $setting->value();
        };
    }

          // login diana 2 settings
    $login_diana_2_controls = array_filter( array(
        $wp_customize->get_control( 'ddpdm_login_diana_2_bg_color' ),
        $wp_customize->get_control( 'ddpdm_login_diana_2_logo' ),
        $wp_customize->get_control( 'ddpdm_login_diana_2_font' ),
        $wp_customize->get_control( 'ddpdm_login_diana_2_font_select' ),
        $wp_customize->get_control( 'ddpdm_diana_2_login_fields_font_size' ),
        $wp_customize->get_control( 'ddpdm_login_diana_2_fields_color' ),
        $wp_customize->get_control( 'ddpdm_diana_2_login_remember_me_font_size' ),
        $wp_customize->get_control( 'ddpdm_login_diana_2_remember_color' ),
        $wp_customize->get_control( 'ddpdm_diana_2_login_button_font_size' ),
        $wp_customize->get_control( 'ddpdm_login_diana_2_bg_button_color' ),
        $wp_customize->get_control( 'ddpdm_login_diana_2_button_color' ),
        $wp_customize->get_control( 'ddpdm_login_diana_2_bg_button_hover_color' ),
        $wp_customize->get_control( 'ddpdm_login_diana_2_button_hover_color' ),
        $wp_customize->get_control( 'ddpdm_diana_2_login_lost_font_size' ),
        $wp_customize->get_control( 'ddpdm_login_diana_2_lost_color' ),
        $wp_customize->get_control( 'ddpdm_login_diana_2_bg' ),
        $wp_customize->get_control( 'ddpdm_diana_2_login_border_thick_size' ),
        $wp_customize->get_control( 'ddpdm_diana_2_login_border_radius_size' ),
        $wp_customize->get_control( 'ddpdm_login_diana_2_fields_border_color' ),


    ) );
    foreach ( $login_diana_2_controls as $control ) {
        $control->active_callback = function( $control ) {
            $setting = $control->manager->get_setting( 'ddpdm_login_template' );
            if ( ! $setting ) {
                return true;
            }
            return 'diana_2' === $setting->value();
        };
    }

           // login diana 2 settings
    $login_diana_3_controls = array_filter( array(
        $wp_customize->get_control( 'ddpdm_login_diana_3_bg_color' ),
        $wp_customize->get_control( 'ddpdm_login_diana_3_logo' ),
        $wp_customize->get_control( 'ddpdm_login_diana_3_font' ),
        $wp_customize->get_control( 'ddpdm_login_diana_3_font_select' ),
        $wp_customize->get_control( 'ddpdm_login_diana_3_header' ),
        $wp_customize->get_control( 'ddpdm_login_diana_3_header_color' ),
        $wp_customize->get_control( 'dp_diana_3_login_header_font_size' ),
        $wp_customize->get_control( 'ddpdm_diana_3_login_fields_font_size' ),
        $wp_customize->get_control( 'ddpdm_login_diana_3_fields_color' ),
        $wp_customize->get_control( 'ddpdm_diana_3_login_remember_me_font_size' ),
        $wp_customize->get_control( 'ddpdm_login_diana_3_remember_color' ),
        $wp_customize->get_control( 'ddpdm_diana_3_login_button_font_size' ),
        $wp_customize->get_control( 'ddpdm_login_diana_3_bg_button_color' ),
        $wp_customize->get_control( 'ddpdm_login_diana_3_button_color' ),
        $wp_customize->get_control( 'ddpdm_login_diana_3_bg_button_hover_color' ),
        $wp_customize->get_control( 'ddpdm_login_diana_3_button_hover_color' ),
        $wp_customize->get_control( 'ddpdm_diana_3_login_lost_font_size' ),
        $wp_customize->get_control( 'ddpdm_login_diana_3_lost_color' ),
        $wp_customize->get_control( 'ddpdm_login_diana_3_bg' ),
        $wp_customize->get_control( 'ddpdm_diana_3_login_border_thick_size' ),
        $wp_customize->get_control( 'ddpdm_diana_3_login_border_radius_size' ),
        $wp_customize->get_control( 'ddpdm_login_diana_3_fields_border_color' ),
        $wp_customize->get_control( 'ddpdm_login_diana_3_bg_info_color' ),
        $wp_customize->get_control( 'ddpdm_login_diana_3_info_address' ),
        $wp_customize->get_control( 'ddpdm_login_diana_3_info_social' ),
        $wp_customize->get_control( 'ddpdm_login_diana_3_info_contact' ),


    ) );
    foreach ( $login_diana_3_controls as $control ) {
        $control->active_callback = function( $control ) {
            $setting = $control->manager->get_setting( 'ddpdm_login_template' );
            if ( ! $setting ) {
                return true;
            }
            return 'diana_3' === $setting->value();
        };
    }


           // global h1-h6 settigns settings
    $global_h1_h6_controls = array_filter( array(
        $wp_customize->get_control( 'ddpdm_global_h1_h6_font_select' ),
        $wp_customize->get_control( 'ddpdm_global_h1_h6_style' ),
        $wp_customize->get_control( 'ddpdm_global_h1_h6_color' ),
        $wp_customize->get_control( 'ddpdm_global_h1_h6_size' ),
        $wp_customize->get_control( 'ddpdm_global_h1_h6_line_height' ),
        $wp_customize->get_control( 'ddpdm_global_h1_h6_letter_spacing' ),

    ) );
    foreach ( $global_h1_h6_controls as $control ) {
        $control->active_callback = function( $control ) {
            $setting = $control->manager->get_setting( 'ddpdm_global_h1_h6' );
            if ( ! $setting ) {
                return true;
            }
            return 'global' === $setting->value();
        };
    }

               // global h1 settigns settings
    $global_h1_controls = array_filter( array(
        $wp_customize->get_control( 'ddpdm_global_h1_font_select' ),
        $wp_customize->get_control( 'ddpdm_global_h1_style' ),
        $wp_customize->get_control( 'ddpdm_global_h1_color' ),
        $wp_customize->get_control( 'ddpdm_global_h1_size' ),
        $wp_customize->get_control( 'ddpdm_global_h1_line_height' ),
        $wp_customize->get_control( 'ddpdm_global_h1_letter_spacing' ),
        $wp_customize->get_control( 'ddpdm_global_h2_font_select' ),
        $wp_customize->get_control( 'ddpdm_global_h2_style' ),
        $wp_customize->get_control( 'ddpdm_global_h2_color' ),
        $wp_customize->get_control( 'ddpdm_global_h2_size' ),
        $wp_customize->get_control( 'ddpdm_global_h2_line_height' ),
        $wp_customize->get_control( 'ddpdm_global_h2_letter_spacing' ),
        $wp_customize->get_control( 'ddpdm_global_h3_font_select' ),
        $wp_customize->get_control( 'ddpdm_global_h3_style' ),
        $wp_customize->get_control( 'ddpdm_global_h3_color' ),
        $wp_customize->get_control( 'ddpdm_global_h3_size' ),
        $wp_customize->get_control( 'ddpdm_global_h3_line_height' ),
        $wp_customize->get_control( 'ddpdm_global_h3_letter_spacing' ),
        $wp_customize->get_control( 'ddpdm_global_h4_font_select' ),
        $wp_customize->get_control( 'ddpdm_global_h4_style' ),
        $wp_customize->get_control( 'ddpdm_global_h4_color' ),
        $wp_customize->get_control( 'ddpdm_global_h4_size' ),
        $wp_customize->get_control( 'ddpdm_global_h4_line_height' ),
        $wp_customize->get_control( 'ddpdm_global_h4_letter_spacing' ),
        $wp_customize->get_control( 'ddpdm_global_h5_font_select' ),
        $wp_customize->get_control( 'ddpdm_global_h5_style' ),
        $wp_customize->get_control( 'ddpdm_global_h5_color' ),
        $wp_customize->get_control( 'ddpdm_global_h5_size' ),
        $wp_customize->get_control( 'ddpdm_global_h5_line_height' ),
        $wp_customize->get_control( 'ddpdm_global_h5_letter_spacing' ),
        $wp_customize->get_control( 'ddpdm_global_h6_font_select' ),
        $wp_customize->get_control( 'ddpdm_global_h6_style' ),
        $wp_customize->get_control( 'ddpdm_global_h6_color' ),
        $wp_customize->get_control( 'ddpdm_global_h6_size' ),
        $wp_customize->get_control( 'ddpdm_global_h6_line_height' ),
        $wp_customize->get_control( 'ddpdm_global_h6_letter_spacing' ),

    ) );
    foreach ( $global_h1_controls as $control ) {
        $control->active_callback = function( $control ) {
            $setting = $control->manager->get_setting( 'ddpdm_global_h1_h6' );
            if ( ! $setting ) {
                return true;
            }
            return 'individually' === $setting->value();
        };
    }


               // mobile menu settings
    $mobile_menu_1_controls = array_filter( array(
        $wp_customize->get_control( 'ddpdm_mobile_menu_1_open_checkbox'),
        $wp_customize->get_control( 'ddpdm_mobile_menu_1_background_color_control'),
        $wp_customize->get_control( 'ddpdm_mobile_menu_1_font_select'),
        $wp_customize->get_control( 'ddpdm_mobile_menu_1_font_style_select'),
        $wp_customize->get_control( 'ddpdm_mobile_menu_1_text_size_range' ),
        $wp_customize->get_control( 'ddpdm_mobile_menu_1_text_color_control' ),
        $wp_customize->get_control( 'ddpdm_mobile_menu_1_text_hover_color_control'),
        $wp_customize->get_control( 'ddpdm_mobile_menu_1_border_size_range'),
        $wp_customize->get_control( 'ddpdm_mobile_menu_1_border_color_control'),
        $wp_customize->get_control( 'ddpdm_mobile_menu_1_sub_font_select' ),
        $wp_customize->get_control( 'ddpdm_mobile_menu_1_sub_text_size_range'),
        $wp_customize->get_control( 'ddpdm_mobile_menu_1_sub_text_color_control' ),
        $wp_customize->get_control( 'ddpdm_mobile_menu_1_sub_text_hover_color_control'),
        $wp_customize->get_control( 'ddpdm_mobile_menu_1_sub_border_size_range' ),
        $wp_customize->get_control( 'ddpdm_mobile_menu_1_sub_border_color_control'),
        $wp_customize->get_control( 'ddpdm_mobile_menu_1_sub_font_style_select' ),

    ) );
    foreach ( $mobile_menu_1_controls as $control ) {
        $control->active_callback = function( $control ) {
            $setting = $control->manager->get_setting( 'ddpdm_mobile_menu_template' );
            if ( ! $setting ) {
                return true;
            }
            return 'mobile_menu_1' === $setting->value();
        };
    }


    $mobile_menu_2_controls = array_filter( array(
        $wp_customize->get_control( 'ddpdm_mobile_menu_2_open_checkbox'),
        $wp_customize->get_control( 'ddpdm_mobile_menu_2_background_color_control'),
        $wp_customize->get_control( 'ddpdm_mobile_menu_2_font_select'),
        $wp_customize->get_control( 'ddpdm_mobile_menu_2_font_style_select'),
        $wp_customize->get_control( 'ddpdm_mobile_menu_2_text_size_range' ),
        $wp_customize->get_control( 'ddpdm_mobile_menu_2_text_color_control' ),
        $wp_customize->get_control( 'ddpdm_mobile_menu_2_text_hover_color_control'),
        $wp_customize->get_control( 'ddpdm_mobile_menu_2_border_size_range'),
        $wp_customize->get_control( 'ddpdm_mobile_menu_2_border_color_control'),
        $wp_customize->get_control( 'ddpdm_mobile_menu_2_sub_font_select' ),
        $wp_customize->get_control( 'ddpdm_mobile_menu_2_sub_text_size_range'),
        $wp_customize->get_control( 'ddpdm_mobile_menu_2_sub_text_color_control' ),
        $wp_customize->get_control( 'ddpdm_mobile_menu_2_sub_text_hover_color_control'),
        $wp_customize->get_control( 'ddpdm_mobile_menu_2_sub_border_size_range' ),
        $wp_customize->get_control( 'ddpdm_mobile_menu_2_sub_border_color_control'),
        $wp_customize->get_control( 'ddpdm_mobile_menu_2_sub_font_style_select' ),

    ) );
    foreach ( $mobile_menu_2_controls as $control ) {
        $control->active_callback = function( $control ) {
            $setting = $control->manager->get_setting( 'ddpdm_mobile_menu_template' );
            if ( ! $setting ) {
                return true;
            }
            return 'mobile_menu_2' === $setting->value();
        };
    }


    $mobile_menu_3_controls = array_filter( array(
        $wp_customize->get_control( 'ddpdm_mobile_menu_3_open_checkbox'),
        $wp_customize->get_control( 'ddpdm_mobile_menu_3_background_color_control'),
        $wp_customize->get_control( 'ddpdm_mobile_menu_3_socials_control'),
        $wp_customize->get_control( 'ddpdm_mobile_menu_3_socials_text_size_range'),
        $wp_customize->get_control( 'ddpdm_mobile_menu_3_socials_text_color_control'),
        $wp_customize->get_control( 'ddpdm_mobile_menu_3_socials_text_hover_color_control'),
        $wp_customize->get_control( 'ddpdm_mobile_menu_3_font_select'),
        $wp_customize->get_control( 'ddpdm_mobile_menu_3_font_style_select'),
        $wp_customize->get_control( 'ddpdm_mobile_menu_3_text_size_range' ),
        $wp_customize->get_control( 'ddpdm_mobile_menu_3_text_color_control' ),
        $wp_customize->get_control( 'ddpdm_mobile_menu_3_text_hover_color_control'),
        $wp_customize->get_control( 'ddpdm_mobile_menu_3_border_size_range'),
        $wp_customize->get_control( 'ddpdm_mobile_menu_3_border_color_control'),
        $wp_customize->get_control( 'ddpdm_mobile_menu_3_sub_font_select' ),
        $wp_customize->get_control( 'ddpdm_mobile_menu_3_sub_text_size_range'),
        $wp_customize->get_control( 'ddpdm_mobile_menu_3_sub_text_color_control' ),
        $wp_customize->get_control( 'ddpdm_mobile_menu_3_sub_text_hover_color_control'),
        $wp_customize->get_control( 'ddpdm_mobile_menu_3_sub_border_size_range' ),
        $wp_customize->get_control( 'ddpdm_mobile_menu_3_sub_border_color_control'),
        $wp_customize->get_control( 'ddpdm_mobile_menu_3_sub_font_style_select' ),
        $wp_customize->get_control( 'ddpdm_mobile_menu_3_address_control' ),
        $wp_customize->get_control( 'ddpdm_mobile_menu_3_address_font_select' ),
        $wp_customize->get_control( 'ddpdm_mobile_menu_3_address_font_style_select' ),
        $wp_customize->get_control( 'ddpdm_mobile_menu_3_address_text_size_range' ),
        $wp_customize->get_control( 'ddpdm_mobile_menu_3_address_text_color_control' ),
        $wp_customize->get_control( 'ddpdm_mobile_menu_3_address_text_hover_color_control' ),

    ) );
    foreach ( $mobile_menu_3_controls as $control ) {
        $control->active_callback = function( $control ) {
            $setting = $control->manager->get_setting( 'ddpdm_mobile_menu_template' );
            if ( ! $setting ) {
                return true;
            }
            return 'mobile_menu_3' === $setting->value();
        };
    }

      $mobile_menu_custom_controls = array_filter( array(
        $wp_customize->get_control( 'ddpdm_mobile_menu_custom_open_checkbox'),
        $wp_customize->get_control( 'ddpdm_mobile_menu_custom_background_color_control'),
        $wp_customize->get_control( 'ddpdm_mobile_menu_custom_font_select'),
        $wp_customize->get_control( 'ddpdm_mobile_menu_custom_font_style_select'),
        $wp_customize->get_control( 'ddpdm_mobile_menu_custom_text_size_range' ),
        $wp_customize->get_control( 'ddpdm_mobile_menu_custom_text_color_control' ),
        $wp_customize->get_control( 'ddpdm_mobile_menu_custom_text_hover_color_control'),
        $wp_customize->get_control( 'ddpdm_mobile_menu_custom_border_size_range'),
        $wp_customize->get_control( 'ddpdm_mobile_menu_custom_border_color_control'),
        $wp_customize->get_control( 'ddpdm_mobile_menu_custom_sub_font_select' ),
        $wp_customize->get_control( 'ddpdm_mobile_menu_custom_sub_text_size_range'),
        $wp_customize->get_control( 'ddpdm_mobile_menu_custom_sub_text_color_control' ),
        $wp_customize->get_control( 'ddpdm_mobile_menu_custom_sub_text_hover_color_control'),
        $wp_customize->get_control( 'ddpdm_mobile_menu_custom_sub_border_size_range' ),
        $wp_customize->get_control( 'ddpdm_mobile_menu_custom_sub_border_color_control'),
        $wp_customize->get_control( 'ddpdm_mobile_menu_custom_sub_font_style_select' ),

    ) );
    foreach ( $mobile_menu_custom_controls as $control ) {
        $control->active_callback = function( $control ) {
            $setting = $control->manager->get_setting( 'ddpdm_mobile_menu_template' );
            if ( ! $setting ) {
                return true;
            }
            return 'mobile_menu_custom' === $setting->value();
        };
    }

     $mobile_menu_global_controls = array_filter( array(
        $wp_customize->get_control( 'ddpdm_mobile_menu_show_checkbox'),
        $wp_customize->get_control( 'ddpdm_mobile_menu_screen_size_range'),

    ) );
    foreach ( $mobile_menu_global_controls as $control ) {
        $control->active_callback = function( $control ) {
            $setting = $control->manager->get_setting( 'ddpdm_mobile_menu_template' );
            if ( ! $setting ) {
                return true;
            }
            return 'disabled' !== $setting->value();
        };
    }

}, 11 );