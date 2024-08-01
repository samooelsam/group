<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>" />
<?php
    elegant_description();
    elegant_keywords();
    elegant_canonical();

    /**
     * Fires in the head, before {@see wp_head()} is called. This action can be used to
     * insert elements into the beginning of the head before any styles or scripts.
     *
     * @since 1.0
     */
    do_action( 'et_head_meta' );

    $template_directory_uri = get_template_directory_uri();
?>

    <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />

    <script type="text/javascript">
        document.documentElement.className = 'js';
    </script>

    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php
    $product_tour_enabled = et_builder_is_product_tour_enabled();
    $page_container_style = $product_tour_enabled ? ' style="padding-top: 0px;"' : ''; ?>
    <div id="page-container"<?php echo et_core_intentionally_unescaped( $page_container_style, 'fixed_string' ); ?>>
        <div id="et-main-area">
    <?php

do_action( 'et_before_main_content' );


if(get_option('ddpdm_coming_soon_template') !== 'disabled') {

    if(get_option('ddpdm_coming_soon_template') === 'diana_1') $title_coming_soon = 'Vertical Coming Soon Page - PHP Templ - Diana';
    if(get_option('ddpdm_coming_soon_template') === 'diana_2') $title_coming_soon = 'Coming Soon w Contact Form - PHP Templ - Diana';

    for ($i = 1; $i < 10 ; $i++) {
        if (get_option('ddpdm_coming_soon_template') === 'ragnar_'.$i) {
            $title_coming_soon = 'Coming Soon Page V'.$i.' - PHP Templ - Ragnar';
        }
    }

    if(strpos(get_option('ddpdm_coming_soon_template'), 'custom') !== false) {
         foreach(get_option('ddpdm_template_coming_soon_custom') as $option => $value) {
            if ($option === get_option('ddpdm_coming_soon_template')) {
                $title_coming_soon = $value;
            }
        }

    }

    $args = array(
    'post_type' => 'et_pb_layout',
    'title' => $title_coming_soon,
    'post_status' => 'publish',
    'posts_per_page' => 1,
    'tax_query' => array(
        array(
            'taxonomy' => 'layout_category',
            'field'    => 'slug',
            'terms'    => 'coming-soon-page',
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
</div> <!-- #main-content -->


<?php do_action( 'et_after_main_content' );

if ( 'on' === et_get_option( 'divi_back_to_top', 'false' ) ) : ?>

    <span class="et_pb_scroll_top et-pb-icon"></span>

<?php endif; ?>

    </div> <!-- #page-container -->

    <?php wp_footer(); ?>
</body>
</html>

