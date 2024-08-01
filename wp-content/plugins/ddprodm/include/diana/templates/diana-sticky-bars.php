<?php

$json_title='';

switch (get_option('ddpdm_sticky_bar_template')) {
    case 'diana_1':
        $json_title = 'Holiday Message Sticky Bar - PHP Templ - Diana';
        break;

    case 'diana_2':
        $json_title = 'Event Sticky Bar - PHP Templ - Diana';
        break;

    case 'diana_4':
        $json_title = 'Early Bird Sticky Bar - PHP Templ - Diana';
        break;

    case 'diana_5':
        $json_title = 'Brochure Download Sticky Bar - PHP Templ - Diana';
        break;

    case 'diana_6':
        $json_title = 'Location Sticky Bar - PHP Templ - Diana';
        break;

    case 'diana_7':
        $json_title = 'Set a Reminder Sticky Bar - PHP Templ - Diana';
        break;

    case 'diana_8':
        $json_title = 'New Collection Sticky Bar - PHP Templ - Diana';
        break;

    case 'diana_9':
        $json_title = 'Sale Furniture Sticky Bar - PHP Templ - Diana';
        break;

    case 'diana_10':
        $json_title = 'Download Ebook w Form Sticky Bar - PHP Templ - Diana';
        break;

    case 'diana_11':
        $json_title = 'Download Ebook Sticky Bar - PHP Templ - Diana';
        break;

    default:
         foreach(get_option('ddpdm_template_sticky_bar_custom') as $option => $value) {
            if ($option === get_option('ddpdm_sticky_bar_template')) {
                 $json_title = $value;
            }
        }
        break;
}

$args = array(
    'post_type' => 'et_pb_layout',
    'title' => $json_title,
    'post_status' => 'publish',
    'posts_per_page' => 1,
    'tax_query' => array(
        array(
            'taxonomy' => 'layout_category',
            'field' => 'name',
            'terms'    => 'Sticky Bar',
        ),
    ),
);

$my_query = new WP_Query($args);

if ($my_query->have_posts()) {
    while ($my_query->have_posts()) : $my_query->the_post();
        remove_filter('the_content', 'wpautop');
        echo '<div class="ddpdm_header_top_section">';
        the_content();
        echo '</div>';
    endwhile;
}

wp_reset_query();  // Restore global post data stomped by the_post()

if (get_option('ddpdm_sticky_bar_sticky') === 'top') {
    echo "<style>#page-container.notice_is_exist .ddpdm_header_top_section {position: fixed !important;}</style>";
echo "<script>jQuery(document).ready(function($) {
    setTimeout(function(){
    var sticky_bar_h = $('#page-container.notice_is_exist .ddpdm_header_top_section').height();
    //console.log('sticky_bar_h '+sticky_bar_h);
    $('body:not(.et_fixed_nav):not(.et-fb) #page-container.notice_is_exist .ddpdm_header_top_section+div, body:not(.et_fixed_nav):not(.et-fb) #page-container.notice_is_exist .ddpdm_header_top_section+header, body.et_fixed_nav.page-template-page-template-blank #page-container.notice_is_exist .ddpdm_header_top_section+div').css('padding-top', sticky_bar_h +'px');
$('body.et_fixed_nav #et-main-area').css('padding-top', sticky_bar_h +'px');
    }, ".esc_attr(get_option('ddpdm_sticky_bar_delay'))."*1000+50);
 //$('body #page-container.notice_is_exist > .et-fixed-header').css('padding-top', 0);
}); //jQuery(document).ready(function($)</script>";
}
if (get_option('ddpdm_sticky_bar_sticky') === 'bottom') {
    echo "<style>#page-container.notice_is_exist .ddpdm_header_top_section {position: fixed !important; bottom: 0 !important;}</style>";
}

if (get_theme_mod('ddpdm_sticky_show_close', true) !== true) {
    echo "<style>#page-container.notice_is_exist .ddpdm_header_top_section .close_icon {display: none !important;}</style>";
}