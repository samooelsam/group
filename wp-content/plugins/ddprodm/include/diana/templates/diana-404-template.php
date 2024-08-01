<?php get_header(); ?>

<div id="main-content">
    <div class="container">
        <div id="content-area" class="clearfix">
<?php
if(get_option('ddpdm_404_page_template') !== 'disabled') {

    if(get_option('ddpdm_404_page_template') === 'diana_1') $title_not_found = ddpdm_return_new_name('404 Animated Eye - PHP Templ - Diana');
    if(get_option('ddpdm_404_page_template') === 'diana_2') $title_not_found = ddpdm_return_new_name('404 Not Found - PHP Templ - Diana');
    if(get_option('ddpdm_404_page_template') === 'diana_3') $title_not_found = ddpdm_return_new_name('404 Search Again - PHP Templ - Diana');


    if(strpos(get_option('ddpdm_404_page_template'), 'custom') !== false) {
        foreach(get_option('ddpdm_template_404_pages_custom') as $option => $value) {
            if ($option === get_option('ddpdm_404_page_template')) {
                $title_not_found = $value;
            }
        }
    }


    $args = array(
    'post_type' => 'et_pb_layout',
    'title' => $title_not_found,
    'post_status' => 'publish',
    'posts_per_page' => 1,
    'tax_query' => array(
        array(
            'taxonomy' => 'layout_category',
            'field'    => 'slug',
            'terms'    => '404-page',
        ),
    ),
);

	//$my_query = null;
    $my_query = new WP_Query($args);

    if ($my_query->have_posts()) {
   		while ($my_query->have_posts()) : $my_query->the_post();
    		the_content();
      	endwhile;
    }

wp_reset_query();  // Restore global post data stomped by the_post()

}

?>
</div> <!-- #content-area -->
    </div> <!-- .container -->
</div> <!-- #main-content -->


<?php

echo "<style>
body.error404 #main-content > .container:before{
   display: none !important;
}
body.error404 #main-content > .container{
   width: 100% !important;
   max-width: 100% !important;
}</style>";

get_footer();
