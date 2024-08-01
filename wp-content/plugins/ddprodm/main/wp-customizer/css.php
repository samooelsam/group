<?php

//  =====================================
//  = Change css according the settings =
//  =====================================


if (!function_exists('ddpdm_allowed_html')) {
    require_once(plugin_dir_path(__FILE__) . 'include/ddpdm-allowed-html-tags.php');
}

function ddprodm_customize_css()
{   // Search results page
    if(is_search() && get_option('ddpdm_search_results_page_template') === 'diana_1') {
    ?>
         <style type="text/css">
            html body.search .et_pb_posts article h2.entry-title {
                color: <?php echo esc_attr(get_theme_mod('ddpdm_search_results_header_color_value', '#635c5c')); ?> !important;
                font-size: <?php echo esc_attr(get_theme_mod('ddpdm_search_results_header_size_value', '18')); ?>px !important;
            }
            html body.search .et_pb_posts article .post-meta a, html body.search .et_pb_posts article .post-meta {
                color: <?php echo esc_attr(get_theme_mod('ddpdm_search_results_meta_color_value', '#a6a6a6')); ?> !important;
                font-size: <?php echo esc_attr(get_theme_mod('ddpdm_search_results_meta_size_value', '14')); ?>px !important;
                font-family: <?php echo "'".esc_attr(strstr(esc_attr(get_theme_mod('ddpdm_search_results_body_font', 'Roboto')), ":", true))."'"; ?>, Helvetica, Arial, Lucida, sans-serif !important;
            }
            html body.search .et_pb_posts article .post-content {
                color: <?php echo esc_attr(get_theme_mod('ddpdm_search_results_content_color_value', '#a6a6a6')); ?> !important;
                font-size: <?php echo esc_attr(get_theme_mod('ddpdm_search_results_content_size_value', '16')); ?>px !important;
                font-family: <?php echo "'".esc_attr(strstr(esc_attr(get_theme_mod('ddpdm_search_results_body_font', 'Roboto')), ":", true))."'"; ?>, Helvetica, Arial, Lucida, sans-serif !important;
                <?php echo esc_attr(ddpdm_process_font_styles(esc_attr(get_theme_mod('ddpdm_search_results_body_font_style')))); ?>
            }
            html body.search .et_pb_posts .pagination a {
                color: <?php echo esc_attr(get_theme_mod('ddpdm_search_results_content_color_value', '#33373a')); ?> !important;
                font-size: <?php echo esc_attr(get_theme_mod('ddpdm_search_results_content_size_value', '16')); ?>px !important;
                font-family: <?php echo "'".esc_attr(strstr(esc_attr(get_theme_mod('ddpdm_search_results_body_font', 'Roboto')), ":", true))."'"; ?>, Helvetica, Arial, Lucida, sans-serif !important;
            }
            html body.search .et_pb_posts article a.more-link, html body.search .et_pb_posts article a.more-link:before {
                color: <?php echo esc_attr(get_theme_mod('ddpdm_search_results_rm_color_value', '#33373a')); ?> !important;
                font-size: <?php echo esc_attr(get_theme_mod('ddpdm_search_results_rm_size_value', '16')); ?>px !important;
            }

            html body.search .et_pb_posts article {
                border-bottom: <?php echo esc_attr(get_theme_mod('ddpdm_search_results_line_thickness_value', '1')); ?>px solid <?php echo esc_attr(get_theme_mod('ddpdm_search_results_line_color_value', '#e4e4e3')); ?>  !important;
            }
            html body.search .et_pb_posts article h2.entry-title {
                font-family: <?php echo "'".esc_attr(strstr(esc_attr(get_theme_mod('ddpdm_search_results_header_font', 'Roboto')), ":", true))."'"; ?>, Helvetica, Arial, Lucida, sans-serif !important;
                <?php echo esc_attr(ddpdm_process_font_styles(esc_attr(get_theme_mod('ddpdm_search_results_header_font_style')))); ?>
            }
         </style>
    <?php
} // if(is_search() && get_option('ddpdm_search_results_page_template') === 'diana_1')

if(get_option('ddpdm_global_page_template') === 'diana_1') {
     if(is_category() && get_option('ddpdm_category_page_template') === 'global') {
    ?>
         <style type="text/css">
            html body.archive.category .et_pb_posts article h2.entry-title {
                color: <?php echo esc_attr(get_theme_mod('ddpdm_global_archive_header_color_value', '#635c5c')); ?> !important;
                font-size: <?php echo esc_attr(get_theme_mod('ddpdm_global_archive_header_size_value', '18')); ?>px !important;
            }
            html body.archive.category .et_pb_posts article .post-content{
                color: <?php echo esc_attr(get_theme_mod('ddpdm_global_archive_content_color_value', '#a6a6a6')); ?> !important;
                font-size: <?php echo esc_attr(get_theme_mod('ddpdm_global_archive_content_size_value', '16')); ?>px !important;
                font-family: <?php echo "'".esc_attr(strstr(esc_attr(get_theme_mod('ddpdm_global_archive_body_font', 'Roboto')), ":", true))."'"; ?>, Helvetica, Arial, Lucida, sans-serif !important;
                <?php echo esc_attr(ddpdm_process_font_styles(esc_attr(get_theme_mod('ddpdm_global_archive_body_font_style')))); ?>
            }
            html body.archive.category .et_pb_posts .pagination a {
                color: <?php echo esc_attr(get_theme_mod('ddpdm_global_archive_content_color_value', '#33373a')); ?> !important;
                font-size: <?php echo esc_attr(get_theme_mod('ddpdm_global_archive_content_size_value', '16')); ?>px !important;
                font-family: <?php echo "'".esc_attr(strstr(esc_attr(get_theme_mod('ddpdm_global_archive_body_font', 'Roboto')), ":", true))."'"; ?>, Helvetica, Arial, Lucida, sans-serif !important;
            }
            html body.archive.category .et_pb_posts article a.more-link, html body.archive.category .et_pb_posts article a.more-link:before {
                color: <?php echo esc_attr(get_theme_mod('ddpdm_global_archive_rm_color_value', '#33373a')); ?> !important;
                font-size: <?php echo esc_attr(get_theme_mod('ddpdm_global_archive_rm_size_value', '16')); ?>px !important;
            }
            html body.archive.category .et_pb_posts article h2.entry-title {
                font-family: <?php echo "'".esc_attr(strstr(esc_attr(get_theme_mod('ddpdm_global_archive_header_font', 'Roboto')), ":", true))."'"; ?>, Helvetica, Arial, Lucida, sans-serif !important;
                <?php echo esc_attr(ddpdm_process_font_styles(esc_attr(get_theme_mod('ddpdm_global_archive_header_font_style')))); ?>
            }
            html body.archive.category .et_pb_posts article .published{
                color: <?php echo esc_attr(get_theme_mod('ddpdm_global_archive_date_color_value', '#33373a')); ?> !important;
                font-family: <?php echo "'".esc_attr(strstr(esc_attr(get_theme_mod('ddpdm_global_archive_body_font', 'Roboto')), ":", true))."'"; ?>, Helvetica, Arial, Lucida, sans-serif !important;
                font-size: <?php echo esc_attr(get_theme_mod('ddpdm_global_archive_date_size_value', '16')); ?>px !important;
                background-color: <?php echo esc_attr(get_theme_mod('ddpdm_global_archive_date_bgcolor_value', '#f2f1ec')); ?> !important;
            }
         </style>
    <?php
    } // if(is_category() && get_option('ddpdm_category_page_template') === 'global')
    if(is_tag() && get_option('ddpdm_tag_page_template') === 'global') {
    ?>
         <style type="text/css">
            html body.archive.tag .et_pb_posts article h2.entry-title {
                color: <?php echo esc_attr(get_theme_mod('ddpdm_global_archive_header_color_value', '#635c5c')); ?> !important;
                font-size: <?php echo esc_attr(get_theme_mod('ddpdm_global_archive_header_size_value', '18')); ?>px !important;
            }
            html body.archive.tag .et_pb_posts article .post-content{
                color: <?php echo esc_attr(get_theme_mod('ddpdm_global_archive_content_color_value', '#a6a6a6')); ?> !important;
                font-size: <?php echo esc_attr(get_theme_mod('ddpdm_global_archive_content_size_value', '16')); ?>px !important;
                font-family: <?php echo "'".esc_attr(strstr(esc_attr(get_theme_mod('ddpdm_global_archive_body_font', 'Roboto')), ":", true))."'"; ?>, Helvetica, Arial, Lucida, sans-serif !important;
                <?php echo esc_attr(ddpdm_process_font_styles(esc_attr(get_theme_mod('ddpdm_global_archive_body_font_style')))); ?>
            }
            html body.archive.tag .et_pb_posts .pagination a {
                color: <?php echo esc_attr(get_theme_mod('ddpdm_global_archive_content_color_value', '#33373a')); ?> !important;
                font-size: <?php echo esc_attr(get_theme_mod('ddpdm_global_archive_content_size_value', '16')); ?>px !important;
                font-family: <?php echo "'".esc_attr(strstr(esc_attr(get_theme_mod('ddpdm_global_archive_body_font', 'Roboto')), ":", true))."'"; ?>, Helvetica, Arial, Lucida, sans-serif !important;
            }
            html body.archive.tag .et_pb_posts article a.more-link, html body.tag.category .et_pb_posts article a.more-link:before {
                color: <?php echo esc_attr(get_theme_mod('ddpdm_global_archive_rm_color_value', '#33373a')); ?> !important;
                font-size: <?php echo esc_attr(get_theme_mod('ddpdm_global_archive_rm_size_value', '16')); ?>px !important;
            }
            html body.archive.tag .et_pb_posts article h2.entry-title{
                font-family: <?php echo "'".esc_attr(strstr(esc_attr(get_theme_mod('ddpdm_global_archive_header_font', 'Roboto')), ":", true))."'"; ?>, Helvetica, Arial, Lucida, sans-serif !important;
                <?php echo esc_attr(ddpdm_process_font_styles(esc_attr(get_theme_mod('ddpdm_global_archive_header_font_style')))); ?>
            }
            html body.archive.tag .et_pb_posts article .published {
                color: <?php echo esc_attr(get_theme_mod('ddpdm_global_archive_date_color_value', '#33373a')); ?> !important;
                font-family: <?php echo "'".esc_attr(strstr(esc_attr(get_theme_mod('ddpdm_global_archive_body_font', 'Roboto')), ":", true))."'"; ?>, Helvetica, Arial, Lucida, sans-serif !important;
                font-size: <?php echo esc_attr(get_theme_mod('ddpdm_global_archive_date_size_value', '16')); ?>px !important;
                background-color: <?php echo esc_attr(get_theme_mod('ddpdm_global_archive_date_bgcolor_value', '#f2f1ec')); ?> !important;
            }
         </style>
    <?php
    } // if(is_tag() && get_option('ddpdm_tag_page_template') === 'global')
    if(is_author() && get_option('ddpdm_author_page_template') === 'global') {
    ?>
         <style type="text/css">
            html body.archive.author #author_info_text h2#author-name {
                color: <?php echo esc_attr(get_theme_mod('ddpdm_global_archive_author_name_color_value', '#33373a')); ?> !important;
                font-size: <?php echo esc_attr(get_theme_mod('ddpdm_global_archive_author_name_size_value', '24')); ?>px !important;
            }
            html body.archive.author #author-desc {
                color: <?php echo esc_attr(get_theme_mod('ddpdm_global_archive_author_bio_color_value', '#a6a6a6')); ?> !important;
                font-size: <?php echo esc_attr(get_theme_mod('ddpdm_global_archive_author_bio_size_value', '16')); ?>px !important;
                font-family: <?php echo "'".esc_attr(strstr(esc_attr(get_theme_mod('ddpdm_global_archive_body_font', 'Roboto')), ":", true))."'"; ?>, Helvetica, Arial, Lucida, sans-serif !important;
            }
            html body.archive.author .et_pb_posts article h2.entry-title {
                color: <?php echo esc_attr(get_theme_mod('ddpdm_global_archive_header_color_value', '#635c5c')); ?> !important;
                font-size: <?php echo esc_attr(get_theme_mod('ddpdm_global_archive_header_size_value', '18')); ?>px !important;
            }
            html body.archive.author .et_pb_posts article .post-content,
            html body.archive.author .et_pb_posts article {
                color: <?php echo esc_attr(get_theme_mod('ddpdm_global_archive_content_color_value', '#a6a6a6')); ?> !important;
                font-size: <?php echo esc_attr(get_theme_mod('ddpdm_global_archive_content_size_value', '16')); ?>px !important;
                font-family: <?php echo "'".esc_attr(strstr(esc_attr(get_theme_mod('ddpdm_global_archive_body_font', 'Roboto')), ":", true))."'"; ?>, Helvetica, Arial, Lucida, sans-serif !important;
                <?php echo esc_attr(ddpdm_process_font_styles(esc_attr(get_theme_mod('ddpdm_global_archive_body_font_style')))); ?>
            }
            html body.archive.author .et_pb_posts .pagination a {
                color: <?php echo esc_attr(get_theme_mod('ddpdm_global_archive_content_color_value', '#33373a')); ?> !important;
                font-size: <?php echo esc_attr(get_theme_mod('ddpdm_global_archive_content_size_value', '16')); ?>px !important;
                font-family: <?php echo "'".esc_attr(strstr(esc_attr(get_theme_mod('ddpdm_global_archive_body_font', 'Roboto')), ":", true))."'"; ?>, Helvetica, Arial, Lucida, sans-serif !important;
            }
            html body.archive.author .et_pb_posts article a.more-link, html body.author.category .et_pb_posts article a.more-link:before {
                color: <?php echo esc_attr(get_theme_mod('ddpdm_global_archive_rm_color_value', '#33373a')); ?> !important;
                font-size: <?php echo esc_attr(get_theme_mod('ddpdm_global_archive_rm_size_value', '16')); ?>px !important;
            }
            html body.archive.author .et_pb_posts article h2.entry-title {
                font-family: <?php echo "'".esc_attr(strstr(esc_attr(get_theme_mod('ddpdm_global_archive_header_font', 'Roboto')), ":", true))."'"; ?>, Helvetica, Arial, Lucida, sans-serif !important;
                <?php echo esc_attr(ddpdm_process_font_styles(esc_attr(get_theme_mod('ddpdm_global_archive_header_font_style')))); ?>
            }
            html body.archive.author .et_pb_posts article .published {
                color: <?php echo esc_attr(get_theme_mod('ddpdm_global_archive_date_color_value', '#33373a')); ?> !important;
                font-family: <?php echo "'".esc_attr(strstr(esc_attr(get_theme_mod('ddpdm_global_archive_body_font', 'Roboto')), ":", true))."'"; ?>, Helvetica, Arial, Lucida, sans-serif !important;
                font-size: <?php echo esc_attr(get_theme_mod('ddpdm_global_archive_date_size_value', '16')); ?>px !important;
                background-color: <?php echo esc_attr(get_theme_mod('ddpdm_global_archive_date_bgcolor_value', '#f2f1ec')); ?> !important;
            }
         </style>
    <?php
    } // if(is_author() && get_option('ddpdm_author_page_template') === 'global')
} //if(is_archive() && get_option('ddpdm_global_page_template') === 'diana_1') {

if(get_option('ddpdm_global_page_template') === 'diana_2' || get_option('ddpdm_global_page_template') === 'diana_3' || get_option('ddpdm_global_page_template') === 'diana_4') {
    if(is_category() && get_option('ddpdm_category_page_template') === 'global') {
    ?>
         <style type="text/css">
            html body.archive.category #left-area article h2.entry-title{
                color: <?php echo esc_attr(get_theme_mod('ddpdm_global_archive_header_color_value_col', '#635c5c')); ?> !important;
                font-size: <?php echo esc_attr(get_theme_mod('ddpdm_global_archive_header_size_value_col', '18')); ?>px !important;
            }
            html body.archive.category #left-area article .post-meta a{
                color: <?php echo esc_attr(get_theme_mod('ddpdm_global_archive_meta_color_value_col', '#a6a6a6')); ?> !important;
                font-size: <?php echo esc_attr(get_theme_mod('ddpdm_global_archive_meta_size_value_col', '14')); ?>px !important;
            }

            html body.archive.category #left-area article a.more-link, html body.archive.category #left-area article a.more-link:before {
                color: <?php echo esc_attr(get_theme_mod('ddpdm_global_archive_rm_color_value_col', '#33373a')); ?> !important;
                font-size: <?php echo esc_attr(get_theme_mod('ddpdm_global_archive_rm_size_value_col', '16')); ?>px !important;
            }
            html body.archive.category #left-area article a.more-link {
                font-family: <?php echo "'".esc_attr(strstr(esc_attr(get_theme_mod('ddpdm_global_archive_mdrc_font_col', 'Roboto')), ":", true))."'"; ?>, Helvetica, Arial, Lucida, sans-serif !important;
             }

            html body.archive.category #left-area article h2.entry-title {
                font-family: <?php echo "'".esc_attr(strstr(esc_attr(get_theme_mod('ddpdm_global_archive_header_font_col', 'Roboto')), ":", true))."'"; ?>, Helvetica, Arial, Lucida, sans-serif !important;
                <?php echo esc_attr(ddpdm_process_font_styles(esc_attr(get_theme_mod('ddpdm_global_archive_header_font_style_col')))); ?>
            }
            html body.archive.category #left-area article .published {
                color: <?php echo esc_attr(get_theme_mod('ddpdm_global_archive_date_color_value_col', '#33373a')); ?> !important;
                font-family: <?php echo "'".esc_attr(strstr(esc_attr(get_theme_mod('ddpdm_global_archive_body_font_col', 'Roboto')), ":", true))."'"; ?>, Helvetica, Arial, Lucida, sans-serif !important;
                font-size: <?php echo esc_attr(get_theme_mod('ddpdm_global_archive_date_size_value_col', '16')); ?>px !important;
                background-color: <?php echo esc_attr(get_theme_mod('ddpdm_global_archive_date_bgcolor_value_col', '#f2f1ec')); ?> !important;
            }
         </style>
    <?php
    } // if(is_category() && get_option('ddpdm_category_page_template') === global)
    if(is_tag() && get_option('ddpdm_tag_page_template') === 'global') {
    ?>
         <style type="text/css">

            html body.archive.tag #left-area article h2.entry-title {
                color: <?php echo esc_attr(get_theme_mod('ddpdm_global_archive_header_color_value_col', '#635c5c')); ?> !important;
                font-size: <?php echo esc_attr(get_theme_mod('ddpdm_global_archive_header_size_value_col', '18')); ?>px !important;
            }
            html body.archive.tag #left-area article .post-meta a{
                color: <?php echo esc_attr(get_theme_mod('ddpdm_global_archive_meta_color_value_col', '#a6a6a6')); ?> !important;
                font-size: <?php echo esc_attr(get_theme_mod('ddpdm_global_archive_meta_size_value_col', '14')); ?>px !important;
            }

            html body.archive.tag #left-area article a.more-link, html body.tag.category #left-area article a.more-link:before{
                color: <?php echo esc_attr(get_theme_mod('ddpdm_global_archive_rm_color_value_col', '#33373a')); ?> !important;
                font-size: <?php echo esc_attr(get_theme_mod('ddpdm_global_archive_rm_size_value_col', '16')); ?>px !important;
            }
            html body.archive.tag #left-area article a.more-link {
                font-family: <?php echo "'".esc_attr(strstr(esc_attr(get_theme_mod('ddpdm_global_archive_mdrc_font_col', 'Roboto')), ":", true))."'"; ?>, Helvetica, Arial, Lucida, sans-serif !important;
             }
            html body.archive.tag #left-area article h2.entry-title {
                font-family: <?php echo "'".esc_attr(strstr(esc_attr(get_theme_mod('ddpdm_global_archive_header_font_col', 'Roboto')), ":", true))."'"; ?>, Helvetica, Arial, Lucida, sans-serif !important;
                <?php echo esc_attr(ddpdm_process_font_styles(esc_attr(get_theme_mod('ddpdm_global_archive_header_font_style_col')))); ?>
            }
            html body.archive.tag #left-area article .published {
                color: <?php echo esc_attr(get_theme_mod('ddpdm_global_archive_date_color_value_col', '#33373a')); ?> !important;
                font-family: <?php echo "'".esc_attr(strstr(esc_attr(get_theme_mod('ddpdm_global_archive_body_font_col', 'Roboto')), ":", true))."'"; ?>, Helvetica, Arial, Lucida, sans-serif !important;
                font-size: <?php echo esc_attr(get_theme_mod('ddpdm_global_archive_date_size_value_col', '16')); ?>px !important;
                background-color: <?php echo esc_attr(get_theme_mod('ddpdm_global_archive_date_bgcolor_value_col', '#f2f1ec')); ?> !important;
            }
            </style>
    <?php
    } //if(is_tag() && get_option('ddpdm_tag_page_template') === global)
    if(is_author() && get_option('ddpdm_author_page_template') === 'global') {
    ?>
         <style type="text/css">
             html body.archive.author #author_info_text h2#author-name {
                color: <?php echo esc_attr(get_theme_mod('ddpdm_global_archive_author_name_color_value_col', '#33373a')); ?> !important;
                font-size: <?php echo esc_attr(get_theme_mod('ddpdm_global_archive_author_name_size_value_col', '24')); ?>px !important;
            }
            html body.archive.author #author-desc {
                color: <?php echo esc_attr(get_theme_mod('ddpdm_global_archive_author_bio_color_value_col', '#a6a6a6')); ?> !important;
                font-size: <?php echo esc_attr(get_theme_mod('ddpdm_global_archive_author_bio_size_value_col', '16')); ?>px !important;
            }
            html body.archive.author .et_pb_posts article h2.entry-title {
                color: <?php echo esc_attr(get_theme_mod('ddpdm_global_archive_header_color_value_col', '#635c5c')); ?> !important;
                font-size: <?php echo esc_attr(get_theme_mod('ddpdm_global_archive_header_size_value_col', '18')); ?>px !important;
            }
            html body.archive.author .et_pb_posts article .post-meta a{
                color: <?php echo esc_attr(get_theme_mod('ddpdm_global_archive_meta_color_value_col', '#a6a6a6')); ?> !important;
                font-size: <?php echo esc_attr(get_theme_mod('ddpdm_global_archive_meta_size_value_col', '14')); ?>px !important;
            }

            html body.archive.author .et_pb_posts article a.more-link, html body.author.category #left-area article a.more-link:before {
                color: <?php echo esc_attr(get_theme_mod('ddpdm_global_archive_rm_color_value_col', '#33373a')); ?> !important;
                font-size: <?php echo esc_attr(get_theme_mod('ddpdm_global_archive_rm_size_value_col', '16')); ?>px !important;
            }
            html body.archive.author .et_pb_posts article a.more-link {
                font-family: <?php echo "'".esc_attr(strstr(esc_attr(get_theme_mod('ddpdm_global_archive_mdcr_font_col', 'Roboto')), ":", true))."'"; ?>, Helvetica, Arial, Lucida, sans-serif !important;
            }
            html body.archive.author .et_pb_posts article h2.entry-title {
                font-family: <?php echo "'".esc_attr(strstr(esc_attr(get_theme_mod('ddpdm_global_archive_header_font_col', 'Roboto')), ":", true))."'"; ?>, Helvetica, Arial, Lucida, sans-serif !important;
                <?php echo esc_attr(ddpdm_process_font_styles(esc_attr(get_theme_mod('ddpdm_global_archive_header_font_style_col')))); ?>
            }
            html body.archive.author .et_pb_posts article .published {
                color: <?php echo esc_attr(get_theme_mod('ddpdm_global_archive_date_color_value_col', '#33373a')); ?> !important;
                font-family: <?php echo "'".esc_attr(strstr(esc_attr(get_theme_mod('ddpdm_global_archive_body_font_col', 'Roboto')), ":", true))."'"; ?>, Helvetica, Arial, Lucida, sans-serif !important;
                font-size: <?php echo esc_attr(get_theme_mod('ddpdm_global_archive_date_size_value_col', '16')); ?>px !important;
                background-color: <?php echo esc_attr(get_theme_mod('ddpdm_global_archive_date_bgcolor_value_col', '#f2f1ec')); ?> !important;
            }
            </style>
    <?php
    } //if(is_author() && get_option('ddpdm_author_page_template') === global) {
} //if(get_option('ddpdm_global_page_template') === 'diana_2' || get_option('ddpdm_global_page_template') === 'diana_3'...

if(is_category() && get_option('ddpdm_category_page_template') === 'diana_1') {
    ?>
         <style type="text/css">
            html body.archive.category .et_pb_posts article h2.entry-title {
                color: <?php echo esc_attr(get_theme_mod('ddpdm_category_header_color_value', '#635c5c')); ?> !important;
                font-size: <?php echo esc_attr(get_theme_mod('ddpdm_category_header_size_value', '18')); ?>px !important;
            }
            html body.archive.category .et_pb_posts article .post-content {
                color: <?php echo esc_attr(get_theme_mod('ddpdm_category_content_color_value', '#a6a6a6')); ?> !important;
                font-size: <?php echo esc_attr(get_theme_mod('ddpdm_category_content_size_value', '16')); ?>px !important;
                font-family: <?php echo "'".esc_attr(strstr(esc_attr(get_theme_mod('ddpdm_category_body_font', 'Roboto')), ":", true))."'"; ?>, Helvetica, Arial, Lucida, sans-serif !important;
                <?php echo esc_attr(ddpdm_process_font_styles(esc_attr(get_theme_mod('ddpdm_category_body_font_style')))); ?>
            }
            html body.archive.category .et_pb_posts .pagination a{
                color: <?php echo esc_attr(get_theme_mod('ddpdm_category_content_color_value', '#33373a')); ?> !important;
                font-size: <?php echo esc_attr(get_theme_mod('ddpdm_category_content_size_value', '16')); ?>px !important;
                font-family: <?php echo "'".esc_attr(strstr(esc_attr(get_theme_mod('ddpdm_category_body_font', 'Roboto')), ":", true))."'"; ?>, Helvetica, Arial, Lucida, sans-serif !important;
            }
            html body.archive.category .et_pb_posts article a.more-link, html body.archive.category .et_pb_posts article a.more-link:before {
                color: <?php echo esc_attr(get_theme_mod('ddpdm_category_rm_color_value', '#33373a')); ?> !important;
                font-size: <?php echo esc_attr(get_theme_mod('ddpdm_category_rm_size_value', '16')); ?>px !important;
            }
            html body.archive.category .et_pb_posts article h2.entry-title {
                font-family: <?php echo "'".esc_attr(strstr(esc_attr(get_theme_mod('ddpdm_category_header_font', 'Roboto')), ":", true))."'"; ?>, Helvetica, Arial, Lucida, sans-serif !important;
                <?php echo esc_attr(ddpdm_process_font_styles(esc_attr(get_theme_mod('ddpdm_category_header_font_style')))); ?>
            }
            html body.archive.category .et_pb_posts article .published {
                color: <?php echo esc_attr(get_theme_mod('ddpdm_category_date_color_value', '#33373a')); ?> !important;
                font-family: <?php echo "'".esc_attr(strstr(esc_attr(get_theme_mod('ddpdm_category_body_font', 'Roboto')), ":", true))."'"; ?>, Helvetica, Arial, Lucida, sans-serif !important;
                font-size: <?php echo esc_attr(get_theme_mod('ddpdm_category_date_size_value', '16')); ?>px !important;
                background-color: <?php echo esc_attr(get_theme_mod('ddpdm_category_date_bgcolor_value', '#f2f1ec')); ?> !important;
            }
         </style>
    <?php
} //if(is_archive() && get_option('ddpdm_global_page_template') === 'diana_1') {

if(is_category() && (get_option('ddpdm_category_page_template') === 'diana_2' || get_option('ddpdm_category_page_template') === 'diana_3' || get_option('ddpdm_category_page_template') === 'diana_4')) {
    ?>
         <style type="text/css">
            html body.archive.category #left-area article h2.entry-title {
                color: <?php echo esc_attr(get_theme_mod('ddpdm_category_header_color_value_col', '#635c5c')); ?> !important;
                font-size: <?php echo esc_attr(get_theme_mod('ddpdm_category_header_size_value_col', '18')); ?>px !important;
            }
            html body.archive.category #left-area article .post-meta a{
                color: <?php echo esc_attr(get_theme_mod('ddpdm_category_meta_color_value_col', '#a6a6a6')); ?> !important;
                font-size: <?php echo esc_attr(get_theme_mod('ddpdm_category_meta_size_value_col', '14')); ?>px !important;
            }

            html body.archive.category #left-area article a.more-link, html body.archive.category #left-area article a.more-link:before{
                color: <?php echo esc_attr(get_theme_mod('ddpdm_category_rm_color_value_col', '#33373a')); ?> !important;
                font-size: <?php echo esc_attr(get_theme_mod('ddpdm_category_rm_size_value_col', '16')); ?>px !important;
            }

             html body.archive.category #left-area article a.more-link {
                font-family: <?php echo "'".esc_attr(strstr(esc_attr(get_theme_mod('ddpdm_category_mdrc_font_col', 'Roboto')), ":", true))."'"; ?>, Helvetica, Arial, Lucida, sans-serif !important;
             }

            html body.archive.category #left-area article h2.entry-title {
                font-family: <?php echo "'".esc_attr(strstr(esc_attr(get_theme_mod('ddpdm_category_header_font_col', 'Roboto')), ":", true))."'"; ?>, Helvetica, Arial, Lucida, sans-serif !important;
                <?php echo esc_attr(ddpdm_process_font_styles(esc_attr(get_theme_mod('ddpdm_category_header_font_style_col')))); ?>
            }
            html body.archive.category #left-area article .published {
                color: <?php echo esc_attr(get_theme_mod('ddpdm_category_date_color_value_col', '#33373a')); ?> !important;
                font-family: <?php echo "'".esc_attr(strstr(esc_attr(get_theme_mod('ddpdm_category_body_font_col', 'Roboto')), ":", true))."'"; ?>, Helvetica, Arial, Lucida, sans-serif !important;
                font-size: <?php echo esc_attr(get_theme_mod('ddpdm_category_date_size_value_col', '16')); ?>px !important;
                background-color: <?php echo esc_attr(get_theme_mod('ddpdm_category_date_bgcolor_value_col', '#f2f1ec')); ?> !important;
            }
         </style>
    <?php
} //if(is_archive() && get_option('ddpdm_global_page_template') === 'diana_1') {

if(is_tag() && get_option('ddpdm_tag_page_template') === 'diana_1') {
    ?>
         <style type="text/css">
            html body.archive.tag .et_pb_posts article h2.entry-title {
                color: <?php echo esc_attr(get_theme_mod('ddpdm_tag_header_color_value', '#635c5c')); ?> !important;
                font-size: <?php echo esc_attr(get_theme_mod('ddpdm_tag_header_size_value', '18')); ?>px !important;
            }
            html body.archive.tag .et_pb_posts article .post-content {
                color: <?php echo esc_attr(get_theme_mod('ddpdm_tag_content_color_value', '#a6a6a6')); ?> !important;
                font-size: <?php echo esc_attr(get_theme_mod('ddpdm_tag_content_size_value', '16')); ?>px !important;
                font-family: <?php echo "'".esc_attr(strstr(esc_attr(get_theme_mod('ddpdm_tag_body_font', 'Roboto')), ":", true))."'"; ?>, Helvetica, Arial, Lucida, sans-serif !important;
                <?php echo esc_attr(ddpdm_process_font_styles(esc_attr(get_theme_mod('ddpdm_tag_body_font_style')))); ?>
            }
            html body.archive.tag .et_pb_posts .pagination a{
                color: <?php echo esc_attr(get_theme_mod('ddpdm_tag_content_color_value', '#33373a')); ?> !important;
                font-size: <?php echo esc_attr(get_theme_mod('ddpdm_tag_content_size_value', '16')); ?>px !important;
                font-family: <?php echo "'".esc_attr(strstr(esc_attr(get_theme_mod('ddpdm_tag_body_font', 'Roboto')), ":", true))."'"; ?>, Helvetica, Arial, Lucida, sans-serif !important;
            }
            html body.archive.tag .et_pb_posts article a.more-link, html body.archive.tag .et_pb_posts article a.more-link:before {
                color: <?php echo esc_attr(get_theme_mod('ddpdm_tag_rm_color_value', '#33373a')); ?> !important;
                font-size: <?php echo esc_attr(get_theme_mod('ddpdm_tag_rm_size_value', '16')); ?>px !important;
            }
            html body.archive.tag .et_pb_posts article h2.entry-title {
                font-family: <?php echo "'".esc_attr(strstr(esc_attr(get_theme_mod('ddpdm_tag_header_font', 'Roboto')), ":", true))."'"; ?>, Helvetica, Arial, Lucida, sans-serif !important;
                <?php echo esc_attr(ddpdm_process_font_styles(esc_attr(get_theme_mod('ddpdm_tag_header_font_style')))); ?>
            }
            html body.archive.tag .et_pb_posts article .published {
                color: <?php echo esc_attr(get_theme_mod('ddpdm_tag_date_color_value', '#33373a')); ?> !important;
                font-family: <?php echo "'".esc_attr(strstr(esc_attr(get_theme_mod('ddpdm_tag_body_font', 'Roboto')), ":", true))."'"; ?>, Helvetica, Arial, Lucida, sans-serif !important;
                font-size: <?php echo esc_attr(get_theme_mod('ddpdm_tag_date_size_value', '16')); ?>px !important;
                background-color: <?php echo esc_attr(get_theme_mod('ddpdm_tag_date_bgcolor_value', '#f2f1ec')); ?> !important;
            }
         </style>
    <?php
} //if(is_archive() && get_option('ddpdm_global_page_template') === 'diana_1') {

if(is_tag() && (get_option('ddpdm_tag_page_template') === 'diana_2' || get_option('ddpdm_tag_page_template') === 'diana_3' || get_option('ddpdm_tag_page_template') === 'diana_4')) {
    ?>
         <style type="text/css">
            html body.archive.tag #left-area article h2.entry-title {
                color: <?php echo esc_attr(get_theme_mod('ddpdm_tag_header_color_value_col', '#635c5c')); ?> !important;
                font-size: <?php echo esc_attr(get_theme_mod('ddpdm_tag_header_size_value_col', '18')); ?>px !important;
            }
            html body.archive.tag #left-area article .post-meta a{
                color: <?php echo esc_attr(get_theme_mod('ddpdm_tag_meta_color_value_col', '#a6a6a6')); ?> !important;
                font-size: <?php echo esc_attr(get_theme_mod('ddpdm_tag_meta_size_value_col', '14')); ?>px !important;
            }

            html body.archive.tag #left-area article a.more-link, html body.archive.tag #left-area article a.more-link:before{
                color: <?php echo esc_attr(get_theme_mod('ddpdm_tag_rm_color_value_col', '#33373a')); ?> !important;
                font-size: <?php echo esc_attr(get_theme_mod('ddpdm_tag_rm_size_value_col', '16')); ?>px !important;
            }

             html body.archive.tag #left-area article a.more-link {
                font-family: <?php echo "'".esc_attr(strstr(esc_attr(get_theme_mod('ddpdm_tag_mdrc_font_col', 'Roboto')), ":", true))."'"; ?>, Helvetica, Arial, Lucida, sans-serif !important;
             }
            html body.archive.tag #left-area article h2.entry-title {
                font-family: <?php echo "'".esc_attr(strstr(esc_attr(get_theme_mod('ddpdm_tag_header_font_col', 'Roboto')), ":", true))."'"; ?>, Helvetica, Arial, Lucida, sans-serif !important;
                <?php echo esc_attr(ddpdm_process_font_styles(esc_attr(get_theme_mod('ddpdm_tag_header_font_style_col')))); ?>
            }
            html body.archive.tag #left-area article .published {
                color: <?php echo esc_attr(get_theme_mod('ddpdm_tag_date_color_value_col', '#33373a')); ?> !important;
                font-family: <?php echo "'".esc_attr(strstr(esc_attr(get_theme_mod('ddpdm_tag_body_font_col', 'Roboto')), ":", true))."'"; ?>, Helvetica, Arial, Lucida, sans-serif !important;
                font-size: <?php echo esc_attr(get_theme_mod('ddpdm_tag_date_size_value_col', '16')); ?>px !important;
                background-color: <?php echo esc_attr(get_theme_mod('ddpdm_tag_date_bgcolor_value_col', '#f2f1ec')); ?> !important;
            }
         </style>
    <?php
} //if(is_archive() && get_option('ddpdm_global_page_template') === 'diana_1') {

 if(is_author() && get_option('ddpdm_author_page_template') === 'diana_1') {
    ?>
         <style type="text/css">
            html body.archive.author #author_info_text h2#author-name {
                color: <?php echo esc_attr(get_theme_mod('ddpdm_author_name_color_value', '#33373a')); ?> !important;
                font-size: <?php echo esc_attr(get_theme_mod('ddpdm_author_name_size_value', '24')); ?>px !important;
            }
            html body.archive.author #author-desc {
                color: <?php echo esc_attr(get_theme_mod('ddpdm_author_bio_color_value', '#a6a6a6')); ?> !important;
                font-size: <?php echo esc_attr(get_theme_mod('ddpdm_author_bio_size_value', '16')); ?>px !important;
            }
            html body.archive.author .et_pb_posts article h2.entry-title {
                color: <?php echo esc_attr(get_theme_mod('ddpdm_author_header_color_value', '#635c5c')); ?> !important;
                font-size: <?php echo esc_attr(get_theme_mod('ddpdm_author_header_size_value', '18')); ?>px !important;
            }
            html body.archive.author .et_pb_posts article .post-content {
                color: <?php echo esc_attr(get_theme_mod('ddpdm_author_content_color_value', '#a6a6a6')); ?> !important;
                font-size: <?php echo esc_attr(get_theme_mod('ddpdm_author_content_size_value', '16')); ?>px !important;
                font-family: <?php echo "'".esc_attr(strstr(esc_attr(get_theme_mod('ddpdm_author_body_font', 'Roboto')), ":", true))."'"; ?>, Helvetica, Arial, Lucida, sans-serif !important;
                <?php echo esc_attr(ddpdm_process_font_styles(esc_attr(get_theme_mod('ddpdm_author_body_font_style')))); ?>
            }
            html body.archive.author .et_pb_posts .pagination a{
                color: <?php echo esc_attr(get_theme_mod('ddpdm_author_content_color_value', '#33373a')); ?> !important;
                font-size: <?php echo esc_attr(get_theme_mod('ddpdm_author_content_size_value', '16')); ?>px !important;
                font-family: <?php echo "'".esc_attr(strstr(esc_attr(get_theme_mod('ddpdm_author_body_font', 'Roboto')), ":", true))."'"; ?>, Helvetica, Arial, Lucida, sans-serif !important;
            }
            html body.archive.author .et_pb_posts article a.more-link, html body.archive.author .et_pb_posts article a.more-link:before {
                color: <?php echo esc_attr(get_theme_mod('ddpdm_author_rm_color_value', '#33373a')); ?> !important;
                font-size: <?php echo esc_attr(get_theme_mod('ddpdm_author_rm_size_value', '16')); ?>px !important;
            }
            html body.archive.author .et_pb_posts article h2.entry-title {
                font-family: <?php echo "'".esc_attr(strstr(esc_attr(get_theme_mod('ddpdm_author_header_font', 'Roboto')), ":", true))."'"; ?>, Helvetica, Arial, Lucida, sans-serif !important;
                <?php echo esc_attr(ddpdm_process_font_styles(esc_attr(get_theme_mod('ddpdm_author_header_font_style')))); ?>
            }
            html body.archive.author .et_pb_posts article .published {
                color: <?php echo esc_attr(get_theme_mod('ddpdm_author_date_color_value', '#33373a')); ?> !important;
                font-family: <?php echo "'".esc_attr(strstr(esc_attr(get_theme_mod('ddpdm_author_body_font', 'Roboto')), ":", true))."'"; ?>, Helvetica, Arial, Lucida, sans-serif !important;
                font-size: <?php echo esc_attr(get_theme_mod('ddpdm_author_date_size_value', '16')); ?>px !important;
                background-color: <?php echo esc_attr(get_theme_mod('ddpdm_author_date_bgcolor_value', '#f2f1ec')); ?> !important;
            }
         </style>
    <?php
} //if(is_archive() && get_option('ddpdm_global_page_template') === 'diana_1') {

if(is_author() && (get_option('ddpdm_author_page_template') === 'diana_2' || get_option('ddpdm_author_page_template') === 'diana_3' || get_option('ddpdm_author_page_template') === 'diana_4')) {
    ?>
         <style type="text/css">
             html body.archive.author #author_info_text h2#author-name {
                color: <?php echo esc_attr(get_theme_mod('ddpdm_author_name_color_value_col', '#33373a')); ?> !important;
                font-size: <?php echo esc_attr(get_theme_mod('ddpdm_author_name_size_value_col', '24')); ?>px !important;
            }
            html body.archive.author #author-desc {
                color: <?php echo esc_attr(get_theme_mod('ddpdm_author_bio_color_value_col', '#a6a6a6')); ?> !important;
                font-size: <?php echo esc_attr(get_theme_mod('ddpdm_author_bio_size_value_col', '16')); ?>px !important;
            }
            html body.archive.author .et_pb_posts article h2.entry-title {
                color: <?php echo esc_attr(get_theme_mod('ddpdm_author_header_color_value_col', '#635c5c')); ?> !important;
                font-size: <?php echo esc_attr(get_theme_mod('ddpdm_author_header_size_value_col', '18')); ?>px !important;
            }
            html body.archive.author .et_pb_posts article .post-meta a{
                color: <?php echo esc_attr(get_theme_mod('ddpdm_author_meta_color_value_col', '#a6a6a6')); ?> !important;
                font-size: <?php echo esc_attr(get_theme_mod('ddpdm_author_meta_size_value_col', '14')); ?>px !important;
                font-family: <?php echo "'".esc_attr(strstr(esc_attr(get_theme_mod('ddpdm_author_mdcr_font_col', 'Roboto')), ":", true))."'"; ?>, Helvetica, Arial, Lucida, sans-serif !important;
            }

            html body.archive.author .et_pb_posts article a.more-link, html body.archive.author .et_pb_posts article a.more-link:before{
                color: <?php echo esc_attr(get_theme_mod('ddpdm_author_rm_color_value_col', '#33373a')); ?> !important;
                font-size: <?php echo esc_attr(get_theme_mod('ddpdm_author_rm_size_value_col', '16')); ?>px !important;
            }
            html body.archive.author .et_pb_posts article a.more-link {
                font-family: <?php echo "'".esc_attr(strstr(esc_attr(get_theme_mod('ddpdm_author_mdcr_font_col', 'Roboto')), ":", true))."'"; ?>, Helvetica, Arial, Lucida, sans-serif !important;
            }
            html body.archive.author .et_pb_posts article h2.entry-title {
                font-family: <?php echo "'".esc_attr(strstr(esc_attr(get_theme_mod('ddpdm_author_header_font_col', 'Roboto')), ":", true))."'"; ?>, Helvetica, Arial, Lucida, sans-serif !important;
                <?php echo esc_attr(ddpdm_process_font_styles(esc_attr(get_theme_mod('ddpdm_author_header_font_style_col')))); ?>
            }
            html body.archive.author .et_pb_posts article .published {
                color: <?php echo esc_attr(get_theme_mod('ddpdm_author_date_color_value_col', '#33373a')); ?> !important;
                font-family: <?php echo "'".esc_attr(strstr(esc_attr(get_theme_mod('ddpdm_author_body_font_col', 'Roboto')), ":", true))."'"; ?>, Helvetica, Arial, Lucida, sans-serif !important;
                font-size: <?php echo esc_attr(get_theme_mod('ddpdm_author_date_size_value_col', '16')); ?>px !important;
                background-color: <?php echo esc_attr(get_theme_mod('ddpdm_author_date_bgcolor_value_col', '#f2f1ec')); ?> !important;
            }
         </style>
    <?php
} //if(is_archive() && get_option('ddpdm_global_page_template') === 'diana_1') {
if(get_option('ddpdm_single_post_template') === 'diana_1')  {?>
    <style>
        html body.single.single-post #main-content #diana_single_post_wrapper h1.entry-title {
            font-family: <?php echo "'".esc_attr(strstr(esc_attr(get_theme_mod('ddpdm_single_header_font', 'Roboto')), ":", true))."'"; ?>, Helvetica, Arial, Lucida, sans-serif !important;
            <?php echo esc_attr(ddpdm_process_font_styles(esc_attr(get_theme_mod('ddpdm_single_header_font_style')))); ?>
            font-size: <?php echo esc_attr(get_theme_mod('ddpdm_single_header_size_value', '36')); ?>px !important;
            color: <?php echo esc_attr(get_theme_mod('ddpdm_single_header_color_value', '#33373a')); ?> !important;
        }
        html body.single.single-post article .post-meta {
            font-family: <?php echo "'".esc_attr(strstr(esc_attr(get_theme_mod('ddpdm_single_body_font', 'Roboto')), ":", true))."'"; ?>, Helvetica, Arial, Lucida, sans-serif !important;
            font-size: <?php echo esc_attr(get_theme_mod('ddpdm_single_meta_size_value', '16')); ?>px !important;
            color: <?php echo esc_attr(get_theme_mod('ddpdm_single_meta_color_value', '#a6a6a6')); ?> !important;
        }
        html body.single.single-post #diana_single_post_wrapper .entry-content {
            font-family: <?php echo "'".esc_attr(strstr(esc_attr(get_theme_mod('ddpdm_single_body_font', 'Roboto')), ":", true))."'"; ?>, Helvetica, Arial, Lucida, sans-serif !important;
            font-size: <?php echo esc_attr(get_theme_mod('ddpdm_single_content_size_value', '16')); ?>px !important;
            color: <?php echo esc_attr(get_theme_mod('ddpdm_single_content_color_value', '#a6a6a6')); ?> !important;
        }
        html body.single.single-post #diana_single_post_wrapper .entry-content h1 {
            font-size: calc(<?php echo esc_attr(get_theme_mod('ddpdm_single_content_size_value', '16')); ?>px + 12px) !important;
            color: <?php echo esc_attr(get_theme_mod('ddpdm_single_h1_h6_color_value', '#33373a')); ?> !important;
            font-family: <?php echo "'".esc_attr(strstr(esc_attr(get_theme_mod('ddpdm_single_h1_h6_font', 'Roboto')), ":", true))."'"; ?>, Helvetica, Arial, Lucida, sans-serif !important;
            <?php echo esc_attr(ddpdm_process_font_styles(esc_attr(get_theme_mod('ddpdm_single_h1_h6_style_value')))); ?>
        }
        html body.single.single-post #diana_single_post_wrapper .entry-content h2 {
            font-size: calc(<?php echo esc_attr(get_theme_mod('ddpdm_single_content_size_value', '16')); ?>px + 8px) !important;
            color: <?php echo esc_attr(get_theme_mod('ddpdm_single_h1_h6_color_value', '#33373a')); ?> !important;
            font-family: <?php echo "'".esc_attr(strstr(esc_attr(get_theme_mod('ddpdm_single_h1_h6_font', 'Roboto')), ":", true))."'"; ?>, Helvetica, Arial, Lucida, sans-serif !important;
            <?php echo esc_attr(ddpdm_process_font_styles(esc_attr(get_theme_mod('ddpdm_single_h1_h6_style_value')))); ?>
        }
        html body.single.single-post #diana_single_post_wrapper .entry-content h3 {
            font-size: calc(<?php echo esc_attr(get_theme_mod('ddpdm_single_content_size_value', '16')); ?>px + 4px) !important;
            color: <?php echo esc_attr(get_theme_mod('ddpdm_single_h1_h6_color_value', '#33373a')); ?> !important;
            font-family: <?php echo "'".esc_attr(strstr(esc_attr(get_theme_mod('ddpdm_single_h1_h6_font', 'Roboto')), ":", true))."'"; ?>, Helvetica, Arial, Lucida, sans-serif !important;
            <?php echo esc_attr(ddpdm_process_font_styles(esc_attr(get_theme_mod('ddpdm_single_h1_h6_style_value')))); ?>
        }
        html body.single.single-post #diana_single_post_wrapper .entry-content h4 {
            font-size: calc(<?php echo esc_attr(get_theme_mod('ddpdm_single_content_size_value', '16')); ?>px + 2px) !important;
            color: <?php echo esc_attr(get_theme_mod('ddpdm_single_h1_h6_color_value', '#33373a')); ?> !important;
            font-family: <?php echo "'".esc_attr(strstr(esc_attr(get_theme_mod('ddpdm_single_h1_h6_font', 'Roboto')), ":", true))."'"; ?>, Helvetica, Arial, Lucida, sans-serif !important;
            <?php echo esc_attr(ddpdm_process_font_styles(esc_attr(get_theme_mod('ddpdm_single_h1_h6_style_value')))); ?>
        }
        html body.single.single-post #diana_single_post_wrapper .entry-content h5 {
            font-size: calc(<?php echo esc_attr(get_theme_mod('ddpdm_single_content_size_value', '16')); ?>px + 1px) !important;
            color: <?php echo esc_attr(get_theme_mod('ddpdm_single_h1_h6_color_value', '#33373a')); ?> !important;
            font-family: <?php echo "'".esc_attr(strstr(esc_attr(get_theme_mod('ddpdm_single_h1_h6_font', 'Roboto')), ":", true))."'"; ?>, Helvetica, Arial, Lucida, sans-serif !important;
            <?php echo esc_attr(ddpdm_process_font_styles(esc_attr(get_theme_mod('ddpdm_single_h1_h6_style_value')))); ?>
        }
        html body.single.single-post #diana_single_post_wrapper .entry-content h6 {
            font-size: <?php echo esc_attr(get_theme_mod('ddpdm_single_content_size_value', '16')); ?>px !important;
            color: <?php echo esc_attr(get_theme_mod('ddpdm_single_h1_h6_color_value', '#33373a')); ?> !important;
            font-family: <?php echo "'".esc_attr(strstr(esc_attr(get_theme_mod('ddpdm_single_h1_h6_font', 'Roboto')), ":", true))."'"; ?>, Helvetica, Arial, Lucida, sans-serif !important;
            <?php echo esc_attr(ddpdm_process_font_styles(esc_attr(get_theme_mod('ddpdm_single_h1_h6_style_value')))); ?>
        }
        html body.single.single-post #author-info h2#author-name {
            color: <?php echo esc_attr(get_theme_mod('ddpdm_single_post_author_name_color_value', '#33373a')); ?> !important;
            font-size: <?php echo esc_attr(get_theme_mod('ddpdm_single_post_author_name_size_value', '16')); ?>px !important;
        }
        html body.single.single-post #author-info p#author-desc, html body.single.single-post #author-info p#author-text {
            color: <?php echo esc_attr(get_theme_mod('ddpdm_single_post_author_bio_color_value', '#a6a6a6')); ?> !important;
            font-size: <?php echo esc_attr(get_theme_mod('ddpdm_single_post_author_bio_size_value', '16')); ?>px !important;
        }
        html body.single.single-post #author-info p#author-desc,
        html body.single.single-post #author-info p#author-text,
        html body.single.single-post #author-info h2#author-name {
             font-family: <?php echo "'".esc_attr(strstr(esc_attr(get_theme_mod('ddpdm_single_body_font', 'Roboto')), ":", true))."'"; ?>, Helvetica, Arial, Lucida, sans-serif !important;
        }
        html body.single.single-post #diana_single_post_wrapper .entry-content .wp-caption p {
            font-family: <?php echo "'".esc_attr(strstr(esc_attr(get_theme_mod('ddpdm_single_body_font', 'Roboto')), ":", true))."'"; ?>, Helvetica, Arial, Lucida, sans-serif !important;
        }
        html body.single.single-post #page-container #diana_single_post_wrapper .cu-tags a {
            font-family: <?php echo "'".esc_attr(strstr(esc_attr(get_theme_mod('ddpdm_single_body_font', 'Roboto')), ":", true))."'"; ?>, Helvetica, Arial, Lucida, sans-serif !important;
            font-size: <?php echo esc_attr(get_theme_mod('ddpdm_single_content_size_value', '16')); ?>px !important;
            color: <?php echo esc_attr(get_theme_mod('ddpdm_single_content_color_value', '#a6a6a6')); ?> !important;
            border-color: <?php echo esc_attr(get_theme_mod('ddpdm_single_content_color_value', '#d8dbe2')); ?> !important;
        }
        html body.single.single-post .relatedposts h3 {
            color: <?php echo esc_attr(get_theme_mod('ddpdm_single_post_related_header_color_value', '#33373a')); ?> !important;
            font-family: <?php echo "'".esc_attr(strstr(esc_attr(get_theme_mod('ddpdm_single_body_font', 'Roboto')), ":", true))."'"; ?>, Helvetica, Arial, Lucida, sans-serif !important;
            font-size: <?php echo esc_attr(get_theme_mod('ddpdm_single_post_related_header_size_value', '16')); ?>px !important;
        }
        html body.single.single-post .relatedposts .relatedthumb p.date {
            color: <?php echo esc_attr(get_theme_mod('ddpdm_single_post_related_single_color_value', '#ffffff')); ?> !important;
            font-family: <?php echo "'".esc_attr(strstr(esc_attr(get_theme_mod('ddpdm_single_body_font', 'Roboto')), ":", true))."'"; ?>, Helvetica, Arial, Lucida, sans-serif !important;
            font-size: <?php echo esc_attr(get_theme_mod('ddpdm_single_post_related_single_date_size_value', '16')); ?>px !important;
        }
        html body.single.single-post .relatedposts .relatedthumb p.title {
            color: <?php echo esc_attr(get_theme_mod('ddpdm_single_post_related_single_color_value', '#ffffff')); ?> !important;
            font-family: <?php echo "'".esc_attr(strstr(esc_attr(get_theme_mod('ddpdm_single_body_font', 'Roboto')), ":", true))."'"; ?>, Helvetica, Arial, Lucida, sans-serif !important;
            font-size: <?php echo esc_attr(get_theme_mod('ddpdm_single_post_related_single_header_size_value', '24')); ?>px !important;
        }
        html body #comment-wrap #respond h3.comment-reply-title {
            color: <?php echo esc_attr(get_theme_mod('ddpdm_single_post_comments_header_color_value', '#33373a')); ?> !important;
            font-family: <?php echo "'".esc_attr(strstr(esc_attr(get_theme_mod('ddpdm_single_body_font', 'Roboto')), ":", true))."'"; ?>, Helvetica, Arial, Lucida, sans-serif !important;
            font-size: <?php echo esc_attr(get_theme_mod('ddpdm_single_post_comments_header_size', '21')); ?>px !important;
        }
        html body #comment-wrap #respond input, html body #comment-wrap #respond textarea {
            color: <?php echo esc_attr(get_theme_mod('ddpdm_single_post_comments_fields_color_value', '#a6a6a6')); ?> !important;
            border-color: <?php echo esc_attr(get_theme_mod('ddpdm_single_post_comments_fields_color_value', '#d8dbe2')); ?> !important;
            font-family: <?php echo "'".esc_attr(strstr(esc_attr(get_theme_mod('ddpdm_single_body_font', 'Roboto')), ":", true))."'"; ?>, Helvetica, Arial, Lucida, sans-serif !important;
            font-size: <?php echo esc_attr(get_theme_mod('ddpdm_single_post_comments_fields_size_value', '16')); ?>px !important;
        }
        html body #comment-wrap #respond .form-submit input.submit {
            color: <?php echo esc_attr(get_theme_mod('ddpdm_single_post_comments_header_color_value', '#2b2b33')); ?> !important;
            border-color: <?php echo esc_attr(get_theme_mod('ddpdm_single_post_comments_fields_color_value', '#d8dbe2')); ?> !important;
            font-family: <?php echo "'".esc_attr(strstr(esc_attr(get_theme_mod('ddpdm_single_body_font', 'Roboto')), ":", true))."'"; ?>, Helvetica, Arial, Lucida, sans-serif !important;
            font-size: <?php echo esc_attr(get_theme_mod('ddpdm_single_post_comments_fields_size_value', '16')); ?>px !important;
        }
    </style>
<?php } //if(get_option('ddpdm_single_post_template') === 'diana_1')

if(get_option('ddpdm_global_h1_h6') === 'global')  {?>
    <script>
    	(function ($) {
    		setTimeout(function() {
    		$('h1, h2, h3, h4, h5, h6, h1 *, h2 *, h3 *, h4 *, h5 *, h6 *').each(function(){
    			var old_styles = '';
    			old_styles = $(this).attr('style');
    			new_styles = '';
    			<?php if(esc_attr(get_theme_mod('ddpdm_global_h1_h6_color_value', 'initial')) !== '') { ?>
    				new_styles+= "color: <?php echo esc_attr(get_theme_mod('ddpdm_global_h1_h6_color_value', 'initial')); ?> !important;";
    			<?php } ?>

    			<?php if(esc_attr(get_theme_mod('ddpdm_global_h1_h6_style_value', '')) !== '') { ?>
    				new_styles+= "<?php echo esc_attr(ddpdm_process_font_styles(esc_attr(get_theme_mod('ddpdm_global_h1_h6_style_value')))); ?>;";
    			<?php } ?>

    			<?php if(esc_attr(get_theme_mod('ddpdm_global_h1_h6_line_height_value', 'initial')) !== '') { ?>
    				new_styles+= "line-height: <?php echo esc_attr(get_theme_mod('ddpdm_global_h1_h6_line_height_value', 'initial')); ?>% !important;";
    			<?php } ?>

    			<?php if(esc_attr(get_theme_mod('ddpdm_global_h1_h6_letter_spacing_value', 'initial')) !== '') { ?>
    				new_styles+= "letter-spacing:  <?php echo esc_attr(get_theme_mod('ddpdm_global_h1_h6_letter_spacing_value', 'initial')); ?>px !important;";
    			<?php } ?>

    			<?php if(esc_attr(get_theme_mod('ddpdm_global_h1_h6_font', '')) !== '') { ?>
    				new_styles+= "font-family: <?php echo "'".esc_attr(strstr(esc_attr(get_theme_mod('ddpdm_global_h1_h6_font', 'initial')), ":", true))."'"; ?> !important;";
    			<?php } ?>

    			final_styles = new_styles + old_styles;

    			$(this).attr('style', final_styles);
    		});
             <?php if(esc_attr(get_theme_mod('ddpdm_global_h1_h6_size_value', '')) !== '') { ?>
    		$('h1, h1 *').each(function(){
    			var old_styles = '';
    			old_styles = $(this).attr('style');
    			new_styles = "font-size: <?php echo esc_attr(get_theme_mod('ddpdm_global_h1_h6_size_value', 'initial')); ?>px !important;";

    			final_styles = new_styles + old_styles;

    			$(this).attr('style', final_styles);
    		});
    		$('h2, h2 *').each(function(){
    			var old_styles = '';
    			old_styles = $(this).attr('style');
    			new_styles = "font-size: calc(<?php echo esc_attr(get_theme_mod('ddpdm_global_h1_h6_size_value', '')); ?>px - 8px) !important;";

    			final_styles = new_styles + old_styles;

    			$(this).attr('style', final_styles);
    		});
    		$('h3, h3 *').each(function(){
    			var old_styles = '';
    			old_styles = $(this).attr('style');
    			new_styles = "font-size: calc(<?php echo esc_attr(get_theme_mod('ddpdm_global_h1_h6_size_value', 'initial')); ?>px - 10px) !important;";

    			final_styles = new_styles + old_styles;

    			$(this).attr('style', final_styles);
    		});
    		$('h4, h4 *').each(function(){
    			var old_styles = '';
    			old_styles = $(this).attr('style');
    			new_styles = "font-size: calc(<?php echo esc_attr(get_theme_mod('ddpdm_global_h1_h6_size_value', 'initial')); ?>px - 12px) !important;";

    			final_styles = new_styles + old_styles;

    			$(this).attr('style', final_styles);
    		});
    		$('h5, h5 *').each(function(){
    			var old_styles = '';
    			old_styles = $(this).attr('style');
    			new_styles = "font-size: calc(<?php echo esc_attr(get_theme_mod('ddpdm_global_h1_h6_size_value', 'initial')); ?>px - 13px) !important;";

    			final_styles = new_styles + old_styles;

    			$(this).attr('style', final_styles);
    		});
    		$('h6, h6 *').each(function(){
    			var old_styles = '';
    			old_styles = $(this).attr('style');
    			new_styles = "font-size: calc(<?php echo esc_attr(get_theme_mod('ddpdm_global_h1_h6_size_value', 'initial')); ?>px - 14px) !important;";

    			final_styles = new_styles + old_styles;

    			$(this).attr('style', final_styles);
    		});
            <?php } ?>
    		 },100);
    	})(jQuery);
    </script>
<?php } //if(get_option('ddpdm_global_h1_h6') === 'global')
if(get_option('ddpdm_global_h1_h6') === 'individually')  {?>
    <script>
        (function ($) {
            setTimeout(function() {
            $('h1, h1 *').each(function(){
                var old_styles = '';
                old_styles = $(this).attr('style');
                new_styles = '';
                <?php if(esc_attr(get_theme_mod('ddpdm_global_h1_color_value', 'initial')) !== '') { ?>
                    new_styles+= "color: <?php echo esc_attr(get_theme_mod('ddpdm_global_h1_color_value', 'initial')); ?> !important;";
                <?php } ?>

                <?php if(esc_attr(get_theme_mod('ddpdm_global_h1_style_value', '')) !== '') { ?>
                    new_styles+= "<?php echo esc_attr(ddpdm_process_font_styles(esc_attr(get_theme_mod('ddpdm_global_h1_style_value')))); ?>;";
                <?php } ?>

                <?php if(esc_attr(get_theme_mod('ddpdm_global_h1_line_height_value', 'initial')) !== '') { ?>
                    new_styles+= "line-height: <?php echo esc_attr(get_theme_mod('ddpdm_global_h1_line_height_value', 'initial')); ?>% !important;";
                <?php } ?>

                <?php if(esc_attr(get_theme_mod('ddpdm_global_h1_letter_spacing_value', 'initial')) !== '') { ?>
                    new_styles+= "letter-spacing:  <?php echo esc_attr(get_theme_mod('ddpdm_global_h1_letter_spacing_value', 'initial')); ?>px !important;";
                <?php } ?>

                <?php if(esc_attr(get_theme_mod('ddpdm_global_h1_font', '')) !== '') { ?>
                    new_styles+= "font-family: <?php echo "'".esc_attr(strstr(esc_attr(get_theme_mod('ddpdm_global_h1_font', 'initial')), ":", true))."'"; ?> !important;";
                <?php } ?>

                 <?php if(esc_attr(get_theme_mod('ddpdm_global_h1_size_value', '')) !== '') { ?>
                    new_styles += "font-size: <?php echo esc_attr(get_theme_mod('ddpdm_global_h1_size_value', 'initial')); ?>px !important;";
                 <?php } ?>

                final_styles = new_styles + old_styles;

                $(this).attr('style', final_styles);
            });

             $('h2, h2 *').each(function(){
                var old_styles = '';
                old_styles = $(this).attr('style');
                new_styles = '';
                <?php if(esc_attr(get_theme_mod('ddpdm_global_h2_color_value', 'initial')) !== '') { ?>
                    new_styles+= "color: <?php echo esc_attr(get_theme_mod('ddpdm_global_h2_color_value', 'initial')); ?> !important;";
                <?php } ?>

                <?php if(esc_attr(get_theme_mod('ddpdm_global_h2_style_value', '')) !== '') { ?>
                    new_styles+= "<?php echo esc_attr(ddpdm_process_font_styles(esc_attr(get_theme_mod('ddpdm_global_h2_style_value')))); ?>;";
                <?php } ?>

                <?php if(esc_attr(get_theme_mod('ddpdm_global_h2_line_height_value', 'initial')) !== '') { ?>
                    new_styles+= "line-height: <?php echo esc_attr(get_theme_mod('ddpdm_global_h2_line_height_value', 'initial')); ?>% !important;";
                <?php } ?>

                <?php if(esc_attr(get_theme_mod('ddpdm_global_h2_letter_spacing_value', 'initial')) !== '') { ?>
                    new_styles+= "letter-spacing:  <?php echo esc_attr(get_theme_mod('ddpdm_global_h2_letter_spacing_value', 'initial')); ?>px !important;";
                <?php } ?>

                <?php if(esc_attr(get_theme_mod('ddpdm_global_h2_font', '')) !== '') { ?>
                    new_styles+= "font-family: <?php echo "'".esc_attr(strstr(esc_attr(get_theme_mod('ddpdm_global_h2_font', 'initial')), ":", true))."'"; ?> !important;";
                <?php } ?>

                 <?php if(esc_attr(get_theme_mod('ddpdm_global_h2_size_value', '')) !== '') { ?>
                    new_styles += "font-size: <?php echo esc_attr(get_theme_mod('ddpdm_global_h2_size_value', 'initial')); ?>px !important;";
                 <?php } ?>

                final_styles = new_styles + old_styles;

                $(this).attr('style', final_styles);
            });

            $('h3, h3 *').each(function(){
                var old_styles = '';
                old_styles = $(this).attr('style');
                new_styles = '';
                <?php if(esc_attr(get_theme_mod('ddpdm_global_h3_color_value', 'initial')) !== '') { ?>
                    new_styles+= "color: <?php echo esc_attr(get_theme_mod('ddpdm_global_h3_color_value', 'initial')); ?> !important;";
                <?php } ?>

                <?php if(esc_attr(get_theme_mod('ddpdm_global_h3_style_value', '')) !== '') { ?>
                    new_styles+= "<?php echo esc_attr(ddpdm_process_font_styles(esc_attr(get_theme_mod('ddpdm_global_h3_style_value')))); ?>;";
                <?php } ?>

                <?php if(esc_attr(get_theme_mod('ddpdm_global_h3_line_height_value', 'initial')) !== '') { ?>
                    new_styles+= "line-height: <?php echo esc_attr(get_theme_mod('ddpdm_global_h3_line_height_value', 'initial')); ?>% !important;";
                <?php } ?>

                <?php if(esc_attr(get_theme_mod('ddpdm_global_h3_letter_spacing_value', 'initial')) !== '') { ?>
                    new_styles+= "letter-spacing:  <?php echo esc_attr(get_theme_mod('ddpdm_global_h3_letter_spacing_value', 'initial')); ?>px !important;";
                <?php } ?>

                <?php if(esc_attr(get_theme_mod('ddpdm_global_h3_font', '')) !== '') { ?>
                    new_styles+= "font-family: <?php echo "'".esc_attr(strstr(esc_attr(get_theme_mod('ddpdm_global_h3_font', 'initial')), ":", true))."'"; ?> !important;";
                <?php } ?>

                 <?php if(esc_attr(get_theme_mod('ddpdm_global_h3_size_value', '')) !== '') { ?>
                    new_styles += "font-size: <?php echo esc_attr(get_theme_mod('ddpdm_global_h3_size_value', 'initial')); ?>px !important;";
                 <?php } ?>

                final_styles = new_styles + old_styles;

                $(this).attr('style', final_styles);
            });

            $('h4, h4 *').each(function(){
                var old_styles = '';
                old_styles = $(this).attr('style');
                new_styles = '';
                <?php if(esc_attr(get_theme_mod('ddpdm_global_h4_color_value', 'initial')) !== '') { ?>
                    new_styles+= "color: <?php echo esc_attr(get_theme_mod('ddpdm_global_h4_color_value', 'initial')); ?> !important;";
                <?php } ?>

                <?php if(esc_attr(get_theme_mod('ddpdm_global_h4_style_value', '')) !== '') { ?>
                    new_styles+= "<?php echo esc_attr(ddpdm_process_font_styles(esc_attr(get_theme_mod('ddpdm_global_h4_style_value')))); ?>;";
                <?php } ?>

                <?php if(esc_attr(get_theme_mod('ddpdm_global_h4_line_height_value', 'initial')) !== '') { ?>
                    new_styles+= "line-height: <?php echo esc_attr(get_theme_mod('ddpdm_global_h4_line_height_value', 'initial')); ?>% !important;";
                <?php } ?>

                <?php if(esc_attr(get_theme_mod('ddpdm_global_h4_letter_spacing_value', 'initial')) !== '') { ?>
                    new_styles+= "letter-spacing:  <?php echo esc_attr(get_theme_mod('ddpdm_global_h4_letter_spacing_value', 'initial')); ?>px !important;";
                <?php } ?>

                <?php if(esc_attr(get_theme_mod('ddpdm_global_h4_font', '')) !== '') { ?>
                    new_styles+= "font-family: <?php echo "'".esc_attr(strstr(esc_attr(get_theme_mod('ddpdm_global_h4_font', 'initial')), ":", true))."'"; ?> !important;";
                <?php } ?>

                 <?php if(esc_attr(get_theme_mod('ddpdm_global_h4_size_value', '')) !== '') { ?>
                    new_styles += "font-size: <?php echo esc_attr(get_theme_mod('ddpdm_global_h4_size_value', 'initial')); ?>px !important;";
                 <?php } ?>

                final_styles = new_styles + old_styles;

                $(this).attr('style', final_styles);
            });

            $('h5, h5 *').each(function(){
                var old_styles = '';
                old_styles = $(this).attr('style');
                new_styles = '';
                <?php if(esc_attr(get_theme_mod('ddpdm_global_h5_color_value', 'initial')) !== '') { ?>
                    new_styles+= "color: <?php echo esc_attr(get_theme_mod('ddpdm_global_h5_color_value', 'initial')); ?> !important;";
                <?php } ?>

                <?php if(esc_attr(get_theme_mod('ddpdm_global_h5_style_value', '')) !== '') { ?>
                    new_styles+= "<?php echo esc_attr(ddpdm_process_font_styles(esc_attr(get_theme_mod('ddpdm_global_h5_style_value')))); ?>;";
                <?php } ?>

                <?php if(esc_attr(get_theme_mod('ddpdm_global_h5_line_height_value', 'initial')) !== '') { ?>
                    new_styles+= "line-height: <?php echo esc_attr(get_theme_mod('ddpdm_global_h5_line_height_value', 'initial')); ?>% !important;";
                <?php } ?>

                <?php if(esc_attr(get_theme_mod('ddpdm_global_h5_letter_spacing_value', 'initial')) !== '') { ?>
                    new_styles+= "letter-spacing:  <?php echo esc_attr(get_theme_mod('ddpdm_global_h5_letter_spacing_value', 'initial')); ?>px !important;";
                <?php } ?>

                <?php if(esc_attr(get_theme_mod('ddpdm_global_h5_font', '')) !== '') { ?>
                    new_styles+= "font-family: <?php echo "'".esc_attr(strstr(esc_attr(get_theme_mod('ddpdm_global_h5_font', 'initial')), ":", true))."'"; ?> !important;";
                <?php } ?>

                 <?php if(esc_attr(get_theme_mod('ddpdm_global_h5_size_value', '')) !== '') { ?>
                    new_styles += "font-size: <?php echo esc_attr(get_theme_mod('ddpdm_global_h5_size_value', 'initial')); ?>px !important;";
                 <?php } ?>

                final_styles = new_styles + old_styles;

                $(this).attr('style', final_styles);
            });

            $('h6, h6 *').each(function(){
                var old_styles = '';
                old_styles = $(this).attr('style');
                new_styles = '';
                <?php if(esc_attr(get_theme_mod('ddpdm_global_h6_color_value', 'initial')) !== '') { ?>
                    new_styles+= "color: <?php echo esc_attr(get_theme_mod('ddpdm_global_h6_color_value', 'initial')); ?> !important;";
                <?php } ?>

                <?php if(esc_attr(get_theme_mod('ddpdm_global_h6_style_value', '')) !== '') { ?>
                    new_styles+= "<?php echo esc_attr(ddpdm_process_font_styles(esc_attr(get_theme_mod('ddpdm_global_h6_style_value')))); ?>;";
                <?php } ?>

                <?php if(esc_attr(get_theme_mod('ddpdm_global_h6_line_height_value', 'initial')) !== '') { ?>
                    new_styles+= "line-height: <?php echo esc_attr(get_theme_mod('ddpdm_global_h6_line_height_value', 'initial')); ?>% !important;";
                <?php } ?>

                <?php if(esc_attr(get_theme_mod('ddpdm_global_h6_letter_spacing_value', 'initial')) !== '') { ?>
                    new_styles+= "letter-spacing:  <?php echo esc_attr(get_theme_mod('ddpdm_global_h6_letter_spacing_value', 'initial')); ?>px !important;";
                <?php } ?>

                <?php if(esc_attr(get_theme_mod('ddpdm_global_h6_font', '')) !== '') { ?>
                    new_styles+= "font-family: <?php echo "'".esc_attr(strstr(esc_attr(get_theme_mod('ddpdm_global_h6_font', 'initial')), ":", true))."'"; ?> !important;";
                <?php } ?>

                 <?php if(esc_attr(get_theme_mod('ddpdm_global_h6_size_value', '')) !== '') { ?>
                    new_styles += "font-size: <?php echo esc_attr(get_theme_mod('ddpdm_global_h6_size_value', 'initial')); ?>px !important;";
                 <?php } ?>

                final_styles = new_styles + old_styles;

                $(this).attr('style', final_styles);
            });
        },100);
        })(jQuery);
    </script>
<?php } //if(get_option('ddpdm_global_h1_h6') === 'global')

//echo 'THE SCROLLBAR '.esc_attr(get_theme_mod('ddpdm_scrollbar_width', false);

if (esc_attr(get_theme_mod('ddpdm_scrollbar', false)) == 1 ) { ?>
        <style>
            html body.os-theme-dark > .os-scrollbar > .os-scrollbar-track > .os-scrollbar-handle {
                background: <?php echo esc_attr(get_theme_mod('ddpdm_scrollbar_color', 'rgba(0, 0, 0, 0.4)')); ?> !important;
            }
            html body.os-theme-dark > .os-scrollbar-horizontal {
                right: <?php echo esc_attr(get_theme_mod('ddpdm_scrollbar_width', '10')); ?>px !important;
                height: <?php echo esc_attr(get_theme_mod('ddpdm_scrollbar_width', '10')); ?>px !important;
            }
            html body.os-theme-dark > .os-scrollbar-vertical{
                width: <?php echo esc_attr(get_theme_mod('ddpdm_scrollbar_width', '10')); ?>px !important;
            }
            html body.os-theme-dark.os-host-rtl > .os-scrollbar-horizontal {
                left: <?php echo esc_attr(get_theme_mod('ddpdm_scrollbar_width', '10')); ?>px !important;
                right: 0;
            }
            html body.os-theme-dark > .os-scrollbar-corner {
                height: <?php echo esc_attr(get_theme_mod('ddpdm_scrollbar_width', '10')); ?>px !important;
                width:<?php echo esc_attr(get_theme_mod('ddpdm_scrollbar_width', '10')); ?>px !important;
            }
            html body.os-theme-dark > .os-scrollbar > .os-scrollbar-track {
                background: <?php echo esc_attr(get_theme_mod('ddpdm_scrollbar_bg_color', 'rgba(0, 0, 0, 0)')); ?> !important;
            }
            html body.os-theme-dark > .os-scrollbar:hover > .os-scrollbar-track > .os-scrollbar-handle,
            html body.os-theme-dark > .os-scrollbar > .os-scrollbar-track > .os-scrollbar-handle.active {
                background: <?php echo esc_attr(get_theme_mod('ddpdm_scrollbar_hover_color', 'rgba(0, 0, 0, .7)')); ?> !important;
            }
            html body.os-theme-dark > .os-scrollbar > .os-scrollbar-track > .os-scrollbar-handle {
                border-radius: <?php echo esc_attr(get_theme_mod('ddpdm_scrollbar_border_radius', '10')); ?>px !important;
                border-width: <?php echo esc_attr(get_theme_mod('ddpdm_scrollbar_border_width', '0')); ?>px !important;
                border-color: <?php echo esc_attr(get_theme_mod('ddpdm_scrollbar_border_color', '#000000')); ?> !important;
                border-style: solid;
            }

            html body.os-theme-dark > .os-scrollbar > .os-scrollbar-track {
                border-radius: <?php echo esc_attr(get_theme_mod('ddpdm_scrollbar_br_border_radius', '10')); ?>px !important;
                border-width: <?php echo esc_attr(get_theme_mod('ddpdm_scrollbar_bg_border_width', '0')); ?>px !important;
                border-color: <?php echo esc_attr(get_theme_mod('ddpdm_scrollbar_bg_border_color', '#000000')); ?> !important;
                border-style: solid !important;
            }

        </style>
<?php
} // if (esc_attr(get_theme_mod('ddpdm_scrollbar', false) == 1 )

if (esc_attr(get_theme_mod('ddpdm_back_to_top', false)) == 1 ) { ?>
<style>
    <?php if(esc_attr(get_theme_mod('ddpdm_back_to_top_position_x', 'right')) === 'right') { ?>

    body .et_pb_scroll_top {

        right: <?php echo esc_attr(get_theme_mod('ddpdm_back_to_top_position_x_margin', 0)); ?>px !important;

    }

    <?php } ?>

    <?php if(esc_attr(get_theme_mod('ddpdm_back_to_top_position_x', 'right')) === 'left') { ?>

    body .et_pb_scroll_top {

        left: <?php echo esc_attr(get_theme_mod('ddpdm_back_to_top_position_x_margin', 0)); ?>px !important;
        right: auto !important;

    }

    <?php } ?>

    <?php if(esc_attr(get_theme_mod('ddpdm_back_to_top_position_y', 'bottom')) === 'bottom') { ?>

    body .et_pb_scroll_top {

        bottom: <?php echo esc_attr(get_theme_mod('ddpdm_back_to_top_position_y_margin', 125)); ?>px !important;

    }

    <?php } ?>

    <?php if(esc_attr(get_theme_mod('ddpdm_back_to_top_position_y', 'right') )=== 'top') { ?>

    body .et_pb_scroll_top {

        top: <?php echo esc_attr(get_theme_mod('ddpdm_back_to_top_position_y_margin', 125)); ?>px !important;
        bottom: auto !important;
    }

    <?php } ?>
    /* text */
    body .et_pb_scroll_top:after {
        content: "<?php echo esc_attr(get_theme_mod('ddpdm_back_to_top_text', "")); ?>" !important;
        display: block !important;
        font-family: <?php echo "'".esc_attr(strstr(esc_attr(get_theme_mod('ddpdm_back_to_top_font_value', '')), ":", true))."'"; ?>, Helvetica, Arial, Lucida, sans-serif !important;
        <?php echo esc_attr(ddpdm_process_font_styles(esc_attr(get_theme_mod('ddpdm_back_to_top_font_style')))); ?>
        color: <?php echo esc_attr(get_theme_mod('ddpdm_back_to_top_color_value', '#fff')); ?> !important;
        font-size: <?php echo esc_attr(get_theme_mod('ddpdm_back_to_top_font_size_value', '16')); ?>px !important;
    }

    body .et_pb_scroll_top:hover:after {
        color: <?php echo esc_attr(get_theme_mod('ddpdm_back_to_top_color_hover_value', '#fff')); ?> !important;
    }

    /* text position */

     <?php if(esc_attr(get_theme_mod('ddpdm_back_to_top_text_position', 'bottom')) === 'top') { ?>

        body .et-pb-icon {display:table !important;}
        body .et-pb-icon:after {display:table-header-group;}
        body .et-pb-icon:before {display:table-footer-group;}
    <?php } ?>

    <?php if(esc_attr(get_theme_mod('ddpdm_back_to_top_text_position', 'bottom')) === 'left') { ?>

         body .et_pb_scroll_top:before {
            float: right;
            display: block;
        }

        body .et_pb_scroll_top:after {
            float: left;
            display: block;
            line-height: 140%;
        }
    <?php } ?>


     <?php if(esc_attr(get_theme_mod('ddpdm_back_to_top_text_position', "bottom")) === 'right') { ?>

         body .et_pb_scroll_top:before {
            float: left;
            display: block;
        }

        body .et_pb_scroll_top:after {
            float: right;
            display: block;
            line-height: 140%;
        }
    <?php } ?>

    /* ICON */

    <?php if(esc_attr(get_theme_mod('ddpdm_back_to_top_icon_hide', false)) == 1) { ?>

    body .et_pb_scroll_top:before {
        display: none !important;
    }
    <?php } ?>

     body .et_pb_scroll_top:before {
        <?php echo esc_attr(ddpdm_process_font_styles(esc_attr(get_theme_mod('ddpdm_back_to_top_icon_font_style')))); ?>
        color: <?php echo esc_attr(get_theme_mod('ddpdm_back_to_top_icon_color_value', '#fff')); ?> !important;
        font-size: <?php echo esc_attr(get_theme_mod('ddpdm_back_to_top_icon_font_size_value', '30')); ?>px !important;
        content:  "<?php echo esc_attr(get_theme_mod('ddpdm_back_to_top_icon_change', '2')); ?>" !important;
    }

    body .et_pb_scroll_top:hover:before {
        color: <?php echo esc_attr(get_theme_mod('ddpdm_back_to_top_icon_color_hover_value', '#fff')); ?> !important;
    }

    body .et_pb_scroll_top {
        background: <?php echo esc_attr(get_theme_mod('ddpdm_back_to_top_bg_color', 'rgba(0, 0, 0, 0.4)')); ?> !important;
        padding: <?php echo esc_attr(get_theme_mod('ddpdm_back_to_top_size_value', 5)); ?>px !important;
        border-top-left-radius: <?php echo esc_attr(get_theme_mod('ddpdm_back_to_top_border_top_left_radius', 5)); ?>px !important;
        border-top-right-radius: <?php echo esc_attr(get_theme_mod('ddpdm_back_to_top_border_top_right_radius', 0)); ?>px !important;
        border-bottom-left-radius: <?php echo esc_attr(get_theme_mod('ddpdm_back_to_top_border_bottom_left_radius', 5)); ?>px !important;
        border-bottom-right-radius: <?php echo esc_attr(get_theme_mod('ddpdm_back_to_top_border_bottom_right_radius', 0)); ?>px !important;
        border: <?php echo esc_attr(get_theme_mod('ddpdm_back_to_top_border_width', 0)); ?>px solid  <?php echo esc_attr(get_theme_mod('ddpdm_back_to_top_border_color', '#000')); ?>  !important;
    }

     body .et_pb_scroll_top:hover, body .et_pb_scroll_top:active {
        transition: all 0.3s;
        background: <?php echo esc_attr(get_theme_mod('ddpdm_back_to_top_hover_bg_color', 'rgba(0, 0, 0, 0.4)')); ?> !important;
        border: <?php echo esc_attr(get_theme_mod('ddpdm_back_to_top_border_width', 0)); ?>px solid  <?php echo esc_attr(get_theme_mod('ddpdm_back_to_top_border_hover_color', '#000')); ?>  !important;
    }

    /* responsive */

     <?php if(esc_attr(get_theme_mod('ddpdm_back_to_top_hide_1100', false)) == 1) { ?>

    @media screen and (min-width: 981px) and (max-width: 1100px) {

        body .et_pb_scroll_top {
            display: none !important;
        }
    }
    <?php } ?>


     <?php if(esc_attr(get_theme_mod('ddpdm_back_to_top_hide_980', false)) == 1) { ?>

    @media screen and (min-width: 768px) and (max-width: 980px) {

        body .et_pb_scroll_top {
            display: none !important;
        }
    }
    <?php } ?>

     <?php if(esc_attr(get_theme_mod('ddpdm_back_to_top_hide_768', false)) == 1) { ?>

    @media screen and (min-width: 481px) and (max-width: 767px) {

        body .et_pb_scroll_top {
            display: none !important;
        }
    }
    <?php } ?>

     <?php if(esc_attr(get_theme_mod('ddpdm_back_to_top_hide_480', false)) == 1) { ?>

    @media screen and (max-width: 480px) {

        body .et_pb_scroll_top {
            display: none !important;
        }
    }
    <?php } ?>

    /* animations */

    <?php if(esc_attr(get_theme_mod('ddpdm_back_to_top_animation', 'faderight')) === 'fadeleft') { ?>

        body .et_pb_scroll_top.et-visible {
            opacity: 1;
            -webkit-animation: fadeInLeft 1s 1 cubic-bezier(0.77, 0, 0.175, 1);
            -moz-animation: fadeInLeft 1s 1 cubic-bezier(0.77, 0, 0.175, 1);
            -o-animation: fadeInLeft 1s 1 cubic-bezier(0.77, 0, 0.175, 1);
            animation: fadeInLeft 1s 1 cubic-bezier(0.77, 0, 0.175, 1);
        }

        body .et_pb_scroll_top.et-hidden {
            opacity: 0;
            -webkit-animation: fadeOutLeft 1s 1 cubic-bezier(0.77, 0, 0.175, 1);
            -moz-animation: fadeOutLeft 1s 1 cubic-bezier(0.77, 0, 0.175, 1);
            -o-animation: fadeOutLeft 1s 1 cubic-bezier(0.77, 0, 0.175, 1);
            animation: fadeOutLeft 1s 1 cubic-bezier(0.77, 0, 0.175, 1);
        }

    <?php } ?>

     <?php if(esc_attr(get_theme_mod('ddpdm_back_to_top_animation', 'faderight')) === 'fadetop') { ?>

        body .et_pb_scroll_top.et-visible {
            opacity: 1;
            -webkit-animation: fadeInTop 1s 1 cubic-bezier(0.77, 0, 0.175, 1);
            -moz-animation: fadeInTop 1s 1 cubic-bezier(0.77, 0, 0.175, 1);
            -o-animation: fadeInTop 1s 1 cubic-bezier(0.77, 0, 0.175, 1);
            animation: fadeInTop 1s 1 cubic-bezier(0.77, 0, 0.175, 1);
        }

        body .et_pb_scroll_top.et-hidden {
            opacity: 0;
            -webkit-animation: fadeOutTop 1s 1 cubic-bezier(0.77, 0, 0.175, 1);
            -moz-animation: fadeOutTop 1s 1 cubic-bezier(0.77, 0, 0.175, 1);
            -o-animation: fadeOutTop 1s 1 cubic-bezier(0.77, 0, 0.175, 1);
            animation: fadeOutTop 1s 1 cubic-bezier(0.77, 0, 0.175, 1);
        }

    <?php } ?>


     <?php if(esc_attr(get_theme_mod('ddpdm_back_to_top_animation', 'faderight')) === 'fadebottom') { ?>

        body .et_pb_scroll_top.et-visible {
            opacity: 1;
            -webkit-animation: fadeInBottom 1s 1 cubic-bezier(0.77, 0, 0.175, 1);
            -moz-animation: fadeInBottom 1s 1 cubic-bezier(0.77, 0, 0.175, 1);
            -o-animation: fadeInBottom 1s 1 cubic-bezier(0.77, 0, 0.175, 1);
            animation: fadeInBottom 1s 1 cubic-bezier(0.77, 0, 0.175, 1);
        }

        body .et_pb_scroll_top.et-hidden {
            opacity: 0;
            -webkit-animation: fadeOutBottom 1s 1 cubic-bezier(0.77, 0, 0.175, 1);
            -moz-animation: fadeOutBottom 1s 1 cubic-bezier(0.77, 0, 0.175, 1);
            -o-animation: fadeOutBottom 1s 1 cubic-bezier(0.77, 0, 0.175, 1);
            animation: fadeOutBottom 1s 1 cubic-bezier(0.77, 0, 0.175, 1);
        }

    <?php } ?>

     <?php if(esc_attr(get_theme_mod('ddpdm_back_to_top_animation', 'faderight')) === 'grow') { ?>

        body .et_pb_scroll_top.et-visible {
            -webkit-animation: Grow 1s ease-in-out;
            -moz-animation: Grow 1s ease-in-out;
            -o-animation: Grow 1s ease-in-out;
            animation: Grow 1s ease-in-out;
        }

    <?php } ?>


     <?php if(esc_attr(get_theme_mod('ddpdm_back_to_top_animation', 'faderight')) === 'bounce') { ?>

        body .et_pb_scroll_top.et-visible {
            -webkit-animation-name: et_pb_bounceBottom;
            animation-name: et_pb_bounceBottom;
        }

    <?php } ?>


    <?php if(esc_attr(get_theme_mod('ddpdm_back_to_top_animation', 'faderight')) === 'flip') { ?>

        body .et_pb_scroll_top.et-visible {
            -webkit-animation: flipInX 0.6s ease-in-out;
        -moz-animation: flipInX 0.6s ease-in-out;
        -o-animation: flipInX 0.6s ease-in-out;
        animation: flipInX 0.6s ease-in-out;
        -webkit-backface-visibility: visible !important;
        backface-visibility: visible !important;
        }

    <?php } ?>



</style>
<?php
}

if (get_option('ddpdm_mobile_menu_template') !== 'disabled' && get_option('ddpdm_menu_template') === 'disabled' ) {
    if (esc_attr(get_theme_mod('ddpdm_mobile_menu_show', false)) == 1 )  { ?>
        <style>
            #et_mobile_nav_menu { display:block !important;     margin-top: -5px;}
            #top-menu-nav { display:none !important; }

            @media only screen and ( max-width: 980px ) {
                #et_mobile_nav_menu {  margin-top: 0px;}
            }
    <?php } // if (esc_attr(get_theme_mod('ddpdm_mobile_menu_show', false) == 1
    else { ?>
        <style>
            @media only screen and (min-width: calc(<?php echo esc_attr(get_theme_mod('ddpdm_mobile_menu_screen_size', '980')); ?>px + 1px )) {
                #et_mobile_nav_menu { display: none !important;}
                 #top-menu-nav, #top-menu { display: block !important;}
            }
            @media only screen and ( max-width: <?php echo esc_attr(get_theme_mod('ddpdm_mobile_menu_screen_size', '980')); ?>px ) {
                #et_mobile_nav_menu { display:block !important;     margin-top: -5px;}
                #top-menu-nav { display:none !important; }
            }
            @media only screen and ( max-width: 980px ) {
                #et_mobile_nav_menu {     margin-top: 0px;}
            }
        <?php } //else ?>
        <?php if (get_option('ddpdm_mobile_menu_template') === 'mobile_menu_custom' ) {?>
                body .et_mobile_menu li a,  body .et_mobile_menu li span.close:before {
                    color: <?php echo esc_attr(get_theme_mod('ddpdm_mobile_menu_custom_text_color', '')); ?> !important;
                    font-size: <?php echo esc_attr(get_theme_mod('ddpdm_mobile_menu_custom_text_size', '')); ?>px !important;
                }
                body .et_mobile_menu > li > a {
                    border-width: <?php echo esc_attr(get_theme_mod('ddpdm_mobile_menu_custom_border_size', '')); ?>px !important;
                    border-color: <?php echo esc_attr(get_theme_mod('ddpdm_mobile_menu_custom_border_color', '')); ?> !important;
                    font-family: <?php echo "'".esc_attr(strstr(esc_attr(get_theme_mod('ddpdm_mobile_menu_custom_font', '')), ":", true))."'"; ?>, Helvetica, Arial, Lucida, sans-serif !important;
                    <?php echo esc_attr(ddpdm_process_font_styles(esc_attr(get_theme_mod('ddpdm_mobile_menu_custom_font_style')))); ?>
                }
                body .et_mobile_menu ul.sub-menu li a {
                    color: <?php echo esc_attr(get_theme_mod('ddpdm_mobile_menu_custom_sub_text_color', '')); ?> !important;
                    font-size: <?php echo esc_attr(get_theme_mod('ddpdm_mobile_menu_custom_sub_text_size', '')); ?>px !important;
                    border-width: <?php echo esc_attr(get_theme_mod('ddpdm_mobile_menu_custom_sub_border_size', '')); ?>px !important;
                    border-color: <?php echo esc_attr(get_theme_mod('ddpdm_mobile_menu_custom_sub_border_color', '')); ?> !important;
                    font-family: <?php echo "'".esc_attr(strstr(esc_attr(get_theme_mod('ddpdm_mobile_menu_custom_sub_font', '')), ":", true))."'"; ?>, Helvetica, Arial, Lucida, sans-serif !important;
                    <?php echo esc_attr(ddpdm_process_font_styles(esc_attr(get_theme_mod('ddpdm_mobile_menu_custom_sub_font_style')))); ?>
                }
                body .et_mobile_menu ul.sub-menu li span.close:before {
                     color: <?php echo esc_attr(get_theme_mod('ddpdm_mobile_menu_custom_sub_text_color', '')); ?> !important;
                    font-size: <?php echo esc_attr(get_theme_mod('ddpdm_mobile_menu_custom_sub_text_size', '')); ?>px !important;
                }
                body  #main-header .et_mobile_menu, body .et_mobile_menu .menu-item-has-children > a,
                body .et_mobile_menu li a:hover, body .et_mobile_menu li a:active,
                body .et_mobile_menu li.current-menu-item a {
                    background: <?php echo esc_attr(get_theme_mod('ddpdm_mobile_menu_custom_background_color', '')); ?> !important;
                }
                body .et_mobile_menu > span.close:hover:before,
                body .et_mobile_menu li span.close:hover:before,
                body .et_mobile_menu li a:hover, body .et_mobile_menu li a:active,
                body .et_mobile_menu li.current-menu-item a {
                    color: <?php echo esc_attr(get_theme_mod('ddpdm_mobile_menu_custom_text_hover_color', '')); ?> !important;
                }

                body .et_mobile_menu ul.sub-menu li a:hover,
                body .et_mobile_menu ul.sub-menu li a:active,
                body .et_mobile_menu ul.sub-menu li.current-menu-item a {
                     color: <?php echo esc_attr(get_theme_mod('ddpdm_mobile_menu_custom_sub_text_hover_color', '')); ?> !important;
                }

                <style>

         <?php  } ?>
            <?php if (get_option('ddpdm_mobile_menu_template') === 'mobile_menu_1' ) {?>
                body .et_mobile_menu li a,  body .et_mobile_menu li span.close:before {
                    color: <?php echo esc_attr(get_theme_mod('ddpdm_mobile_menu_1_text_color', '#000000')); ?> !important;
                    font-size: <?php echo esc_attr(get_theme_mod('ddpdm_mobile_menu_1_text_size', '18')); ?>px !important;
                }
                body .et_mobile_menu > li > a {
                    border-width: <?php echo esc_attr(get_theme_mod('ddpdm_mobile_menu_1_border_size', '1')); ?>px !important;
                    border-color: <?php echo esc_attr(get_theme_mod('ddpdm_mobile_menu_1_border_color', '#000000')); ?> !important;
                    font-family: <?php echo "'".esc_attr(strstr(esc_attr(get_theme_mod('ddpdm_mobile_menu_1_font', 'Roboto')), ":", true))."'"; ?>, Helvetica, Arial, Lucida, sans-serif !important;
                    <?php echo esc_attr(ddpdm_process_font_styles(esc_attr(get_theme_mod('ddpdm_mobile_menu_1_font_style')))); ?>
                }
                body .et_mobile_menu ul.sub-menu li a {
                    color: <?php echo esc_attr(get_theme_mod('ddpdm_mobile_menu_1_sub_text_color', '#808080')); ?> !important;
                    font-size: <?php echo esc_attr(get_theme_mod('ddpdm_mobile_menu_1_sub_text_size', '16')); ?>px !important;
                    border-width: <?php echo esc_attr(get_theme_mod('ddpdm_mobile_menu_1_sub_border_size', '1')); ?>px !important;
                    border-color: <?php echo esc_attr(get_theme_mod('ddpdm_mobile_menu_1_sub_border_color', '#e5e5e5')); ?> !important;
                    font-family: <?php echo "'".esc_attr(strstr(esc_attr(get_theme_mod('ddpdm_mobile_menu_1_sub_font', 'Roboto')), ":", true))."'"; ?>, Helvetica, Arial, Lucida, sans-serif !important;
                    <?php echo esc_attr(ddpdm_process_font_styles(esc_attr(get_theme_mod('ddpdm_mobile_menu_1_sub_font_style')))); ?>
                }
                body .et_mobile_menu ul.sub-menu li span.close:before {
                     color: <?php echo esc_attr(get_theme_mod('ddpdm_mobile_menu_1_sub_text_color', '#808080')); ?> !important;
                    font-size: <?php echo esc_attr(get_theme_mod('ddpdm_mobile_menu_1_sub_text_size', '16')); ?>px !important;
                }
                body  #main-header .et_mobile_menu, body .et_mobile_menu .menu-item-has-children > a,
                body .et_mobile_menu li a:hover, body .et_mobile_menu li a:active,
                body .et_mobile_menu li.current-menu-item a {
                    background: <?php echo esc_attr(get_theme_mod('ddpdm_mobile_menu_1_background_color', '#fff')); ?> !important;
                }
                body .et_mobile_menu > span.close:hover:before,
                body .et_mobile_menu li span.close:hover:before,
                body .et_mobile_menu li a:hover, body .et_mobile_menu li a:active,
                body .et_mobile_menu li.current-menu-item a {
                    color: <?php echo esc_attr(get_theme_mod('ddpdm_mobile_menu_1_text_hover_color', '#fddd11')); ?> !important;
                }

                body .et_mobile_menu ul.sub-menu li a:hover,
                body .et_mobile_menu ul.sub-menu li a:active,
                body .et_mobile_menu ul.sub-menu li.current-menu-item a {
                     color: <?php echo esc_attr(get_theme_mod('ddpdm_mobile_menu_1_sub_text_hover_color', '#fddd11')); ?> !important;
                }

                <?php
                if (esc_attr(get_theme_mod('ddpdm_mobile_menu_1_open', false)) == 1 )  { ?>
                    </style><script>
                        (function ($) {
                            setTimeout(function(){
                                $('li.menu-item-has-children').each(function(){
                                    $(this).removeClass('menu-closed').addClass('menu-opened');
                                });
                            }, 2500);
                         })(jQuery);
                    </script>
                    <style>

         <?php  } } ?>

            <?php if (get_option('ddpdm_mobile_menu_template') === 'mobile_menu_2' ) {?>
                body .et_mobile_menu li a, .et_mobile_menu li span.close:before {
                    color: <?php echo esc_attr(get_theme_mod('ddpdm_mobile_menu_2_text_color', '#ffffff')); ?> !important;
                    font-size: <?php echo esc_attr(get_theme_mod('ddpdm_mobile_menu_2_text_size', '18')); ?>px !important;
                }
                body .et_mobile_menu > li > a {
                    border-width: <?php echo esc_attr(get_theme_mod('ddpdm_mobile_menu_2_border_size', '1')); ?>px !important;
                    border-color: <?php echo esc_attr(get_theme_mod('ddpdm_mobile_menu_2_border_color', '#fffffff')); ?> !important;
                    font-family: <?php echo "'".esc_attr(strstr(esc_attr(get_theme_mod('ddpdm_mobile_menu_2_font', 'Roboto')), ":", true))."'"; ?>, Helvetica, Arial, Lucida, sans-serif !important;
                    <?php echo esc_attr(ddpdm_process_font_styles(esc_attr(get_theme_mod('ddpdm_mobile_menu_2_font_style')))); ?>
                }
                body .et_mobile_menu ul.sub-menu li a {
                    color: <?php echo esc_attr(get_theme_mod('ddpdm_mobile_menu_2_sub_text_color', '#ffffff')); ?> !important;
                    font-size: <?php echo esc_attr(get_theme_mod('ddpdm_mobile_menu_2_sub_text_size', '16')); ?>px !important;
                    border-width: <?php echo esc_attr(get_theme_mod('ddpdm_mobile_menu_2_sub_border_size', '1')); ?>px !important;
                    border-color: <?php echo esc_attr(get_theme_mod('ddpdm_mobile_menu_2_sub_border_color', '#808080')); ?> !important;
                    font-family: <?php echo "'".esc_attr(strstr(esc_attr(get_theme_mod('ddpdm_mobile_menu_2_sub_font', 'Roboto')), ":", true))."'"; ?>, Helvetica, Arial, Lucida, sans-serif !important;
                    <?php echo esc_attr(ddpdm_process_font_styles(esc_attr(get_theme_mod('ddpdm_mobile_menu_2_sub_font_style')))); ?>
                }
                body .et_mobile_menu ul.sub-menu li span.close:before {
                    color: <?php echo esc_attr(get_theme_mod('ddpdm_mobile_menu_2_sub_text_color', '#ffffff')); ?> !important;
                    font-size: <?php echo esc_attr(get_theme_mod('ddpdm_mobile_menu_2_sub_text_size', '16')); ?>px !important;
                }
                body  #main-header .et_mobile_menu, body .et_mobile_menu .menu-item-has-children > a,
                body .et_mobile_menu li a:hover, body .et_mobile_menu li a:active,
                body .et_mobile_menu li.current-menu-item a {
                    background: <?php echo esc_attr(get_theme_mod('ddpdm_mobile_menu_2_background_color', '#000')); ?> !important;
                }
                body .et_mobile_menu > span.close:hover:before,
                body .et_mobile_menu li span.close:hover:before,
                body .et_mobile_menu li a:hover, body .et_mobile_menu li a:active,
                body .et_mobile_menu li.current-menu-item a {
                    color: <?php echo esc_attr(get_theme_mod('ddpdm_mobile_menu_2_text_hover_color', '#808080')); ?> !important;
                }

                body .et_mobile_menu ul.sub-menu li a:hover,
                body .et_mobile_menu ul.sub-menu li a:active,
                body .et_mobile_menu ul.sub-menu li.current-menu-item a {
                     color: <?php echo esc_attr(get_theme_mod('ddpdm_mobile_menu_2_sub_text_hover_color', '#808080')); ?> !important;
                }

          <?php
                if (esc_attr(get_theme_mod('ddpdm_mobile_menu_2_open', false)) == 1 )  { ?>
                    </style><script>
                        (function ($) {
                            setTimeout(function(){
                                $('li.menu-item-has-children').each(function(){
                                    $(this).removeClass('menu-closed').addClass('menu-opened');
                                });
                            }, 2500);
                         })(jQuery);
                    </script>
                    <style>

         <?php  } } ?>

        <?php if (get_option('ddpdm_mobile_menu_template') === 'mobile_menu_3' ) {?>
                body .et_mobile_menu li a, .et_mobile_menu li span.close:before {
                    color: <?php echo esc_attr(get_theme_mod('ddpdm_mobile_menu_3_text_color', '#fff')); ?> !important;
                    font-size: <?php echo esc_attr(get_theme_mod('ddpdm_mobile_menu_3_text_size', '30')); ?>px !important;
                }
                body .et_mobile_menu > li > a {
                    font-family: <?php echo "'".esc_attr(strstr(esc_attr(get_theme_mod('ddpdm_mobile_menu_3_font', 'Poppins')), ":", true))."'"; ?>, Helvetica, Arial, Lucida, sans-serif !important;
                    <?php echo esc_attr(ddpdm_process_font_styles(esc_attr(get_theme_mod('ddpdm_mobile_menu_3_font_style')))); ?>
                }
                body .et_mobile_menu > li > span.close {
                    border-width: <?php echo esc_attr(get_theme_mod('ddpdm_mobile_menu_3_border_size', '1')); ?>px !important;
                    border-color: <?php echo esc_attr(get_theme_mod('ddpdm_mobile_menu_3_border_color', '#808080')); ?> !important;
                }

                body .et_mobile_menu ul.sub-menu li a {
                    color: <?php echo esc_attr(get_theme_mod('ddpdm_mobile_menu_3_sub_text_color', '#ffffff')); ?> !important;
                    font-size: <?php echo esc_attr(get_theme_mod('ddpdm_mobile_menu_3_sub_text_size', '24')); ?>px !important;
                    font-family: <?php echo "'".esc_attr(strstr(esc_attr(get_theme_mod('ddpdm_mobile_menu_3_sub_font', 'Poppins')), ":", true))."'"; ?>, Helvetica, Arial, Lucida, sans-serif !important;
                    <?php echo esc_attr(ddpdm_process_font_styles(esc_attr(get_theme_mod('ddpdm_mobile_menu_3_sub_font_style')))); ?>
                }
                body  #main-header .et_mobile_menu, body .et_mobile_menu .menu-item-has-children > a,
                body .et_mobile_menu li a:hover, body .et_mobile_menu li a:active,
                body .et_mobile_menu li.current-menu-item a {
                    background: <?php echo esc_attr(get_theme_mod('ddpdm_mobile_menu_3_background_color', '#000000')); ?> !important;
                }
                body .et_mobile_menu > span.close:hover:before,
                body .et_mobile_menu li span.close:hover:before,
                body .et_mobile_menu > li > a:hover, body .et_mobile_menu > li > a:active,
                body .et_mobile_menu > li:hover > a, body .et_mobile_menu > li:active > a,
                body .et_mobile_menu li.current-menu-item a {
                    color: <?php echo esc_attr(get_theme_mod('ddpdm_mobile_menu_3_text_hover_color', '#808080')); ?> !important;
                }

                body .et_mobile_menu ul.sub-menu li a:hover,
                body .et_mobile_menu ul.sub-menu li a:active,
                body .et_mobile_menu ul.sub-menu li.current-menu-item a {
                     color: <?php echo esc_attr(get_theme_mod('ddpdm_mobile_menu_3_sub_text_hover_color', '#808080')); ?> !important;
                }
        </style>
        <script type="text/javascript" charset="utf-8">
            (function ($) {
                setTimeout(function(){
                ddpdm_menu_3_address = '<?php echo wp_kses(get_theme_mod('ddpdm_mobile_menu_3_address', '105 Road Name<br>Berlin, Germany<br><br><a href="tel:012345678">012 345 678</a><br><a href="mailto:info@website.com">info@website.com</a>'), ddpdm_allowed_html()); ?> ';
                ddpdm_menu_3_address  = ddpdm_menu_3_address.replace(/"/g,'\'');
                $('ul#mobile_menu:not(.added-class)').append("<div class='ddpdm-menu-3-address'><p>"+ ddpdm_menu_3_address +"</p></div>");
                $('ul#mobile_menu').addClass('added-class');


                ddpdm_menu_3_socials = '<?php echo wp_kses(get_theme_mod('ddpdm_mobile_menu_3_socials', '<a href="https://facebook.com" target="_blank"><i>&#xe093;</i></a><a href="https://linkedin.com" target="_blank"><i>&#xe09d;</i></a><a href="https://twitter.com" target="_blank"><i>&#xe094;</i></a><a href="https://instagram.com" target="_blank"><i>&#xe09a;</i></a>'), ddpdm_allowed_html()); ?> ';
               // ddpdm_menu_3_socials  = ddpdm_menu_3_socials.replace(/"/g,'/"');
                $("<div class='ddpdm-menu-3-socials'>"+ ddpdm_menu_3_socials +"</div>").insertBefore('.et_mobile_menu > li:first-of-type');
            }, 1000);
            })(jQuery);
        </script>
        <style>

          body .et_mobile_menu .ddpdm-menu-3-address p, body .et_mobile_menu .ddpdm-menu-3-address p a {
            color: <?php echo esc_attr(get_theme_mod('ddpdm_mobile_menu_3_address_text_color', '#ffffff')); ?> !important;
            font-size: <?php echo esc_attr(get_theme_mod('ddpdm_mobile_menu_3_address_text_size', '16')); ?>px !important;
            font-family: <?php echo "'".esc_attr(strstr(esc_attr(get_theme_mod('ddpdm_mobile_menu_3_address_font', 'Poppins')), ":", true))."'"; ?>, Helvetica, Arial, Lucida, sans-serif !important;
            <?php echo esc_attr(ddpdm_process_font_styles(esc_attr(get_theme_mod('ddpdm_mobile_menu_3_address_font_style')))); ?>
          }

          body .et_mobile_menu .ddpdm-menu-3-address p a:hover, body .et_mobile_menu .ddpdm-menu-3-address p a:active {
            color: <?php echo esc_attr(get_theme_mod('ddpdm_mobile_menu_3_address_text_hover_color', '#ffffff')); ?> !important;
          }

          body .et_mobile_menu .ddpdm-menu-3-socials a i {
            color: <?php echo esc_attr(get_theme_mod('ddpdm_mobile_menu_3_socials_text_color', '#ffffff')); ?> !important;
            font-size: <?php echo esc_attr(get_theme_mod('ddpdm_mobile_menu_3_socials_text_size', '18')); ?>px !important;
            font-family: 'ETmodules';
            font-style: normal;
          }

          body .et_mobile_menu .ddpdm-menu-3-socials a:hover i {
            color: <?php echo esc_attr(get_theme_mod('ddpdm_mobile_menu_3_socials_text_hover_color', '##808080')); ?> !important;
          }

          @media only screen and ( max-width: 600px) {
            body .et_mobile_menu > li:first-of-type {
                margin-top: 0 !important;
            }
            body .et_mobile_menu {
                padding: 65px 40px 40px 40px !important;
            }
            body .et_mobile_menu li a, .et_mobile_menu li span.close:before {
                    font-size: calc(<?php echo esc_attr(get_theme_mod('ddpdm_mobile_menu_3_text_size', '30')); ?>px * 0.8) !important;
            }
            body .et_mobile_menu ul.sub-menu li a {
                    font-size: calc(<?php echo esc_attr(get_theme_mod('ddpdm_mobile_menu_3_sub_text_size', '24')); ?>px * 0.8)!important;
            }
          }

          @media only screen and ( max-width: 400px) {

            body .et_mobile_menu li a, .et_mobile_menu li span.close:before {
                    font-size: 18px !important;
            }
            body .et_mobile_menu ul.sub-menu li a {
                    font-size: 16px !important;
            }
            body .et_mobile_menu {
                padding: 60px 20px 20px 20px !important;
            }
            body .et_mobile_menu .ddpdm-menu-3-socials {
                right: 26px;
            }
            body .et_mobile_menu > li {
                max-width: 85%;
            }

          }



          <?php
                if (esc_attr(get_theme_mod('ddpdm_mobile_menu_3_open', false)) == 1 )  { ?>
                    </style><script>
                        (function ($) {
                            setTimeout(function(){
                                $('li.menu-item-has-children').each(function(){
                                    $(this).removeClass('menu-closed').addClass('menu-opened');
                                });
                            }, 2500);
                         })(jQuery);
                    </script>
                    <style>

         <?php  } } ?>

        </style>
<?php
} // if (esc_attr(get_theme_mod('ddpdm_mobile_menu', false) !== 'disabled'
}
add_action( 'wp_head', 'ddprodm_customize_css');

function ddprodm_is_wplogin(){
    $ABSPATH_MY = str_replace(array('\\','/'), DIRECTORY_SEPARATOR, ABSPATH);
    return ((in_array($ABSPATH_MY.'wp-login.php', get_included_files()) || in_array($ABSPATH_MY.'wp-register.php', get_included_files()) ) || (isset($_GLOBALS['pagenow']) && $GLOBALS['pagenow'] === 'wp-login.php') || (isset($_SERVER['PHP_SELF']) && $_SERVER['PHP_SELF'] == '/wp-login.php'));
}

function ddprodm_login_customize_css() {
// Login page
 if (get_option('ddpdm_login_template') !== 'disabled') {
    if ( ddprodm_is_wplogin() || is_customize_preview() ) {
    if(get_option('ddpdm_login_template') === 'diana_1')  {?>
        <style>
            body.login {
                background: <?php echo esc_attr(get_theme_mod('ddpdm_login_diana_1_bg_color_value', '#33373a')); ?> !important;
            }

            body.login #login {
                box-shadow: 0 12px 93px <?php echo esc_attr(get_theme_mod('ddpdm_login_diana_1_shadow_color_value', 'rgba(0, 0, 0, 0.49)')); ?> !important;
            }
            #login h1 a, .login h1 a {
                background-image: url(<?php echo esc_attr(get_theme_mod('ddpdm_login_diana_1_logo_image', WP_PLUGIN_URL.'/ddprodm/include/diana/img/login-page-logo.png')); ?>)  !important;
            }
            html body.login *, html .login_bottom_box #nav .register_container:before{
                 font-family: <?php echo "'".esc_attr(strstr(esc_attr(get_theme_mod('ddpdm_login_diana_1_font_value', 'Roboto')), ":", true))."'"; ?>, Helvetica, Arial, Lucida, sans-serif !important;
                  <?php echo esc_attr(ddpdm_process_font_styles(esc_attr(get_theme_mod('ddpdm_login_diana_1_font_style')))); ?>
            }

            html .login .button.wp-hide-pw .dashicons {
                 color: <?php echo esc_attr(get_theme_mod('ddpdm_login_diana_1_fields_color_value', '#ffffff')); ?> !important;
                 font-family: dashicons !important;
            }

            html .login .button.wp-hide-pw {
                right: 15px;
            }

            html body.login form input::-webkit-input-placeholder, #user_pass {
                font-family: <?php echo "'".esc_attr(strstr(esc_attr(get_theme_mod('ddpdm_login_diana_1_font_value', 'Roboto')), ":", true))."'"; ?>, Helvetica, Arial, Lucida, sans-serif !important;
                font-size: <?php echo esc_attr(get_theme_mod('ddpdm_diana_1_login_fields_font_size_value', '16')); ?>px !important;
                color: <?php echo esc_attr(get_theme_mod('ddpdm_login_diana_1_fields_color_value', '#ffffff')); ?> !important;
                  <?php echo esc_attr(ddpdm_process_font_styles(esc_attr(get_theme_mod('ddpdm_login_diana_1_font_style')))); ?>
            }
            html body.login form input::-moz-placeholder, #user_pass {
                font-family: <?php echo "'".esc_attr(strstr(esc_attr(get_theme_mod('ddpdm_login_diana_1_font_value', 'Roboto')), ":", true))."'"; ?>, Helvetica, Arial, Lucida, sans-serif !important;
                font-size: <?php echo esc_attr(get_theme_mod('ddpdm_diana_1_login_fields_font_size_value', '16')); ?>px !important;
                color: <?php echo esc_attr(get_theme_mod('ddpdm_login_diana_1_fields_color_value', '#ffffff')); ?> !important;
                  <?php echo esc_attr(ddpdm_process_font_styles(esc_attr(get_theme_mod('ddpdm_login_diana_1_font_style')))); ?>
            }
            html body.login form input:-ms-input-placeholder, #user_pass {
                font-family: <?php echo "'".esc_attr(strstr(esc_attr(get_theme_mod('ddpdm_login_diana_1_font_value', 'Roboto')), ":", true))."'"; ?>, Helvetica, Arial, Lucida, sans-serif !important;
                font-size: <?php echo esc_attr(get_theme_mod('ddpdm_diana_1_login_fields_font_size_value', '16')); ?>px !important;
                color: <?php echo esc_attr(get_theme_mod('ddpdm_login_diana_1_fields_color_value', '#ffffff')); ?> !important;
                  <?php echo esc_attr(ddpdm_process_font_styles(esc_attr(get_theme_mod('ddpdm_login_diana_1_font_style')))); ?>
            }
            html body.login form input:-moz-placeholder, #user_pass {
                font-family: <?php echo "'".esc_attr(strstr(esc_attr(get_theme_mod('ddpdm_login_diana_1_font_value', 'Roboto')), ":", true))."'"; ?>, Helvetica, Arial, Lucida, sans-serif !important;
                font-size: <?php echo esc_attr(get_theme_mod('ddpdm_diana_1_login_fields_font_size_value', '16')); ?>px !important;
                color: <?php echo esc_attr(get_theme_mod('ddpdm_login_diana_1_fields_color_value', '#ffffff')); ?> !important;
                  <?php echo esc_attr(ddpdm_process_font_styles(esc_attr(get_theme_mod('ddpdm_login_diana_1_font_style')))); ?>
            }

            html body.login form p:not(.forgetmenot) input {
                font-size: <?php echo esc_attr(get_theme_mod('ddpdm_diana_1_login_fields_font_size_value', '16')); ?>px !important;
                color: <?php echo esc_attr(get_theme_mod('ddpdm_login_diana_1_fields_color_value', '#ffffff')); ?> !important;
            }
            html body.login form .forgetmenot label, html body.login form #reg_passmail, html body.login .message {
                font-size: <?php echo esc_attr(get_theme_mod('ddpdm_diana_1_login_remember_me_font_size_value', '14')); ?>px !important;
                color: <?php echo esc_attr(get_theme_mod('ddpdm_login_diana_1_remember_color_value', '#989898')); ?> !important;
            }
            html body.login form .submit input#wp-submit {
                font-size: <?php echo esc_attr(get_theme_mod('ddpdm_diana_1_login_button_font_size_value', '14')); ?>px !important;
                color: <?php echo esc_attr(get_theme_mod('ddpdm_login_diana_1_button_color_value', '#33373a')); ?> !important;
                background-color: <?php echo esc_attr(get_theme_mod('ddpdm_login_diana_1_bg_button_color_value', '#e9eae5')); ?> !important;
            }
            html body.login form .submit input#wp-submit:hover {
                color: <?php echo esc_attr(get_theme_mod('ddpdm_login_diana_1_button_hover_color_value', '#ffffff')); ?> !important;
                background-color: <?php echo esc_attr(get_theme_mod('ddpdm_login_diana_1_bg_button_hover_color_value', '#e8d553')); ?> !important;
            }
            html .login_bottom_box #nav .register_container a {
                color: <?php echo esc_attr(get_theme_mod('ddpdm_login_diana_1_bg_button_color_value', '#e9eae5')); ?> !important;
            }
            html .login_bottom_box #nav a, html .login_bottom_box #nav .register_container:before {
                font-size: <?php echo esc_attr(get_theme_mod('ddpdm_diana_1_login_lost_font_size_value', '16')); ?>px !important;
                color: <?php echo esc_attr(get_theme_mod('ddpdm_login_diana_1_lost_color_value', '#a6a6a6')); ?> !important;

            }
        </style>
<?php
    } //if(get_option('ddpdm_login_template') === 'diana_1')

    if(get_option('ddpdm_login_template') === 'diana_2')  {?>
        <style>
            body.login {
                background: <?php echo esc_attr(get_theme_mod('ddpdm_login_diana_2_bg_color_value', '#33373a')); ?> !important;
            }

            body.login .column_2 {
                background-image: url(<?php echo esc_attr(get_theme_mod('ddpdm_login_diana_2_bg_image', WP_PLUGIN_URL.'/ddprodm/include/diana/img/login-page2-bg.jpg')); ?>)  !important;
            }

            #login h1 a, .login h1 a {
                background-image: url(<?php echo esc_attr(get_theme_mod('ddpdm_login_diana_2_logo_image', WP_PLUGIN_URL.'/ddprodm/include/diana/img/login-page-logo.png')); ?>)  !important;
            }
            html body.login *, html body.login .message {
                 font-family: <?php echo "'".esc_attr(strstr(esc_attr(get_theme_mod('ddpdm_login_diana_2_font_value', 'Roboto')), ":", true))."'"; ?>, Helvetica, Arial, Lucida, sans-serif !important;
                  <?php echo esc_attr(ddpdm_process_font_styles(esc_attr(get_theme_mod('ddpdm_login_diana_2_font_style')))); ?>
            }

            html body.login form input::-webkit-input-placeholder {
                font-family: <?php echo "'".esc_attr(strstr(esc_attr(get_theme_mod('ddpdm_login_diana_2_font_value', 'Roboto')), ":", true))."'"; ?>, Helvetica, Arial, Lucida, sans-serif !important;
                font-size: <?php echo esc_attr(get_theme_mod('ddpdm_diana_2_login_fields_font_size_value', '16')); ?>px !important;
                color: <?php echo esc_attr(get_theme_mod('ddpdm_login_diana_2_fields_color_value', '#ffffff')); ?> !important;
                  <?php echo esc_attr(ddpdm_process_font_styles(esc_attr(get_theme_mod('ddpdm_login_diana_2_font_style')))); ?>
            }
            html body.login form input::-moz-placeholder {
                font-family: <?php echo "'".esc_attr(strstr(esc_attr(get_theme_mod('ddpdm_login_diana_2_font_value', 'Roboto')), ":", true))."'"; ?>, Helvetica, Arial, Lucida, sans-serif !important;
                font-size: <?php echo esc_attr(get_theme_mod('ddpdm_diana_2_login_fields_font_size_value', '16')); ?>px !important;
                color: <?php echo esc_attr(get_theme_mod('ddpdm_login_diana_2_fields_color_value', '#ffffff')); ?> !important;
                  <?php echo esc_attr(ddpdm_process_font_styles(esc_attr(get_theme_mod('ddpdm_login_diana_2_font_style')))); ?>
            }
            html body.login form input:-ms-input-placeholder {
                font-family: <?php echo "'".esc_attr(strstr(esc_attr(get_theme_mod('ddpdm_login_diana_2_font_value', 'Roboto')), ":", true))."'"; ?>, Helvetica, Arial, Lucida, sans-serif !important;
                font-size: <?php echo esc_attr(get_theme_mod('ddpdm_diana_2_login_fields_font_size_value', '16')); ?>px !important;
                color: <?php echo esc_attr(get_theme_mod('ddpdm_login_diana_2_fields_color_value', '#ffffff')); ?> !important;
                  <?php echo esc_attr(ddpdm_process_font_styles(esc_attr(get_theme_mod('ddpdm_login_diana_2_font_style')))); ?>
            }
            html body.login form input:-moz-placeholder {
                font-family: <?php echo "'".esc_attr(strstr(esc_attr(get_theme_mod('ddpdm_login_diana_2_font_value', 'Roboto')), ":", true))."'"; ?>, Helvetica, Arial, Lucida, sans-serif !important;
                font-size: <?php echo esc_attr(get_theme_mod('ddpdm_diana_2_login_fields_font_size_value', '16')); ?>px !important;
                color: <?php echo esc_attr(get_theme_mod('ddpdm_login_diana_2_fields_color_value', '#ffffff')); ?> !important;
                  <?php echo esc_attr(ddpdm_process_font_styles(esc_attr(get_theme_mod('ddpdm_login_diana_2_font_style')))); ?>
            }

            html body.login form p:not(.forgetmenot) input,  html body.login form .user-pass-wrap input {
                font-size: <?php echo esc_attr(get_theme_mod('ddpdm_diana_2_login_fields_font_size_value', '16')); ?>px !important;
                color: <?php echo esc_attr(get_theme_mod('ddpdm_login_diana_2_fields_color_value', '#ffffff')); ?> !important;
                border: <?php echo esc_attr(get_theme_mod('ddpdm_diana_2_login_border_thick_size_value', '1')); ?>px solid <?php echo esc_attr(get_theme_mod('ddpdm_login_diana_2_fields_border_color_value', '#484b4e')); ?>!important;
                border-radius: <?php echo esc_attr(get_theme_mod('ddpdm_diana_2_login_border_radius_size_value', '6')); ?>px !important;
            }

            html body.login form label[for="user_email"]:after,
            html body.login form label[for="user_login"]:after,
            html body.login form label[for="user_pass"]:after {
                color: <?php echo esc_attr(get_theme_mod('ddpdm_login_diana_2_fields_color_value', '#ffffff')); ?> !important;
            }
            html body.login form .forgetmenot label, html body.login form #reg_passmail, html body.login .message {
                font-size: <?php echo esc_attr(get_theme_mod('ddpdm_diana_2_login_remember_me_font_size_value', '14')); ?>px !important;
                color: <?php echo esc_attr(get_theme_mod('ddpdm_login_diana_2_remember_color_value', '#989898')); ?> !important;
            }
            html body.login form .submit input#wp-submit {
                font-size: <?php echo esc_attr(get_theme_mod('ddpdm_diana_2_login_button_font_size_value', '14')); ?>px !important;
                color: <?php echo esc_attr(get_theme_mod('ddpdm_login_diana_2_button_color_value', '#33373a')); ?> !important;
                background-color: <?php echo esc_attr(get_theme_mod('ddpdm_login_diana_2_bg_button_color_value', '#e9eae5')); ?> !important;
            }
            html body.login form .submit:after {
                font-size: <?php echo esc_attr(get_theme_mod('ddpdm_diana_2_login_button_font_size_value', '14')); ?>px !important;
                color: <?php echo esc_attr(get_theme_mod('ddpdm_login_diana_2_button_color_value', '#33373a')); ?> !important;
            }
            html body.login form .submit input#wp-submit:hover, html body.login form .submit:hover:after {
                color: <?php echo esc_attr(get_theme_mod('ddpdm_login_diana_2_button_hover_color_value', '#ffffff')); ?> !important;
                background-color: <?php echo esc_attr(get_theme_mod('ddpdm_login_diana_2_bg_button_hover_color_value', '#e8d553')); ?> !important;
            }
            html .login_bottom_box #nav .register_container a {
                color: <?php echo esc_attr(get_theme_mod('ddpdm_login_diana_2_bg_button_color_value', '#e9eae5')); ?> !important;
            }
            html body.login #login #nav a {
                font-size: <?php echo esc_attr(get_theme_mod('ddpdm_diana_2_login_lost_font_size_value', '16')); ?>px !important;
                color: <?php echo esc_attr(get_theme_mod('ddpdm_login_diana_2_lost_color_value', '#a6a6a6')); ?> !important;

            }
        </style>
<?php
    } //if(get_option('ddpdm_login_template') === 'diana_2')

    if(get_option('ddpdm_login_template') === 'diana_3')  {?>
        <style>
            body.login {
                background: <?php echo esc_attr(get_theme_mod('ddpdm_login_diana_3_bg_color_value', '#fff')); ?> !important;
            }

            html body.login *, html body.login .message {
                 font-family: <?php echo "'".esc_attr(strstr(esc_attr(get_theme_mod('ddpdm_login_diana_3_font_value', 'Roboto')), ":", true))."'"; ?>, Helvetica, Arial, Lucida, sans-serif !important;
                  <?php echo esc_attr(ddpdm_process_font_styles(esc_attr(get_theme_mod('ddpdm_login_diana_3_font_style')))); ?>
            }

            html .login #login h1:before{
                content: "<?php echo esc_attr(get_theme_mod('ddpdm_login_diana_3_header_value', 'Login')); ?>" !important;
                font-size: <?php echo esc_attr(get_theme_mod('ddpdm_diana_3_login_header_font_size_value', '21')); ?>px !important;
                 color: <?php echo esc_attr(get_theme_mod('ddpdm_login_diana_3_header_color_value', '#33373a')); ?> !important;
            }

            html body.login form input::-webkit-input-placeholder {
                font-family: <?php echo "'".esc_attr(strstr(esc_attr(get_theme_mod('ddpdm_login_diana_3_font_value', 'Roboto')), ":", true))."'"; ?>, Helvetica, Arial, Lucida, sans-serif !important;
                font-size: <?php echo esc_attr(get_theme_mod('ddpdm_diana_3_login_fields_font_size_value', '16')); ?>px !important;
                color: <?php echo esc_attr(get_theme_mod('ddpdm_login_diana_3_fields_color_value', '#a6a6a6')); ?> !important;
                  <?php echo esc_attr(ddpdm_process_font_styles(esc_attr(get_theme_mod('ddpdm_login_diana_3_font_style')))); ?>
            }
            html body.login form input::-moz-placeholder {
                font-family: <?php echo "'".esc_attr(strstr(esc_attr(get_theme_mod('ddpdm_login_diana_3_font_value', 'Roboto')), ":", true))."'"; ?>, Helvetica, Arial, Lucida, sans-serif !important;
                font-size: <?php echo esc_attr(get_theme_mod('ddpdm_diana_3_login_fields_font_size_value', '16')); ?>px !important;
                color: <?php echo esc_attr(get_theme_mod('ddpdm_login_diana_3_fields_color_value', '#a6a6a6')); ?> !important;
                  <?php echo esc_attr(ddpdm_process_font_styles(esc_attr(get_theme_mod('ddpdm_login_diana_3_font_style')))); ?>
            }
            html body.login form input:-ms-input-placeholder {
                font-family: <?php echo "'".esc_attr(strstr(esc_attr(get_theme_mod('ddpdm_login_diana_3_font_value', 'Roboto')), ":", true))."'"; ?>, Helvetica, Arial, Lucida, sans-serif !important;
                font-size: <?php echo esc_attr(get_theme_mod('ddpdm_diana_3_login_fields_font_size_value', '16')); ?>px !important;
                color: <?php echo esc_attr(get_theme_mod('ddpdm_login_diana_3_fields_color_value', '#a6a6a6')); ?> !important;
                  <?php echo esc_attr(ddpdm_process_font_styles(esc_attr(get_theme_mod('ddpdm_login_diana_3_font_style')))); ?>
            }
            html body.login form input:-moz-placeholder {
                font-family: <?php echo "'".esc_attr(strstr(esc_attr(get_theme_mod('ddpdm_login_diana_3_font_value', 'Roboto')), ":", true))."'"; ?>, Helvetica, Arial, Lucida, sans-serif !important;
                font-size: <?php echo esc_attr(get_theme_mod('ddpdm_diana_3_login_fields_font_size_value', '16')); ?>px !important;
                color: <?php echo esc_attr(get_theme_mod('ddpdm_login_diana_3_fields_color_value', '#a6a6a6')); ?> !important;
                  <?php echo esc_attr(ddpdm_process_font_styles(esc_attr(get_theme_mod('ddpdm_login_diana_3_font_style')))); ?>
            }

            html body.login form p:not(.forgetmenot) input,  html body.login form .user-pass-wrap input {
                font-size: <?php echo esc_attr(get_theme_mod('ddpdm_diana_3_login_fields_font_size_value', '16')); ?>px !important;
                color: <?php echo esc_attr(get_theme_mod('ddpdm_login_diana_3_fields_color_value', '#a6a6a6')); ?> !important;
                border: <?php echo esc_attr(get_theme_mod('ddpdm_diana_3_login_border_thick_size_value', '1')); ?>px solid <?php echo esc_attr(get_theme_mod('ddpdm_login_diana_3_fields_border_color_value', '#e9eff4')); ?>!important;
                border-radius: <?php echo esc_attr(get_theme_mod('ddpdm_diana_3_login_border_radius_size_value', '6')); ?>px !important;
            }

            html body.login form label[for="user_email"]:after,
            html body.login form label[for="user_login"]:after,
            html body.login form label[for="user_pass"]:after {
                color: <?php echo esc_attr(get_theme_mod('ddpdm_login_diana_3_header_color_value', '#333333')); ?> !important;
            }
            html body.login form .forgetmenot label, html body.login form #reg_passmail, html body.login .message {
                font-size: <?php echo esc_attr(get_theme_mod('ddpdm_diana_3_login_remember_me_font_size_value', '14')); ?>px !important;
                color: <?php echo esc_attr(get_theme_mod('ddpdm_login_diana_3_remember_color_value', '#989898')); ?> !important;
            }
            html body.login form .submit input#wp-submit {
                font-size: <?php echo esc_attr(get_theme_mod('ddpdm_diana_3_login_button_font_size_value', '12')); ?>px !important;
                color: <?php echo esc_attr(get_theme_mod('ddpdm_login_diana_3_button_color_value', '#33373a')); ?> !important;
                background-color: <?php echo esc_attr(get_theme_mod('ddpdm_login_diana_3_bg_button_color_value', '#e9eae5')); ?> !important;
            }

            html body.login form .submit input#wp-submit:hover {
                color: <?php echo esc_attr(get_theme_mod('ddpdm_login_diana_3_button_hover_color_value', '#ffffff')); ?> !important;
                background-color: <?php echo esc_attr(get_theme_mod('ddpdm_login_diana_3_bg_button_hover_color_value', '#e8d553')); ?> !important;
            }
            html .login_bottom_box #nav .register_container a {
                color: <?php echo esc_attr(get_theme_mod('ddpdm_login_diana_3_bg_button_color_value', '#e9eae5')); ?> !important;
            }
            html body.login #login #nav a {
                font-size: <?php echo esc_attr(get_theme_mod('ddpdm_diana_3_login_lost_font_size_value', '14')); ?>px !important;
                color: <?php echo esc_attr(get_theme_mod('ddpdm_login_diana_3_lost_color_value', '#989898')); ?> !important;
            }
            html body.login .queenly_login_content {
                 background-color: <?php echo esc_attr(get_theme_mod('ddpdm_login_diana_3_bg_info_color_value', '#f8f8f6')); ?> !important;
            }
        </style>
<?php
    } //if(get_option('ddpdm_login_template') === 'diana_3')
} //ddprodm_is_wplogin() || is_customize_preview()
} //get_option('ddpdm_login_template') !== 'disabled' )

} //ddprodm_login_customize_css()

add_action('login_head', 'ddprodm_login_customize_css');
