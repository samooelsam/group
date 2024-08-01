<?php
// headers
function ddprodm_header_template($archive_template) {

    if(get_option('ddpdm_header_template') !== 'disabled' && get_option('ddpdm_coming_soon_template') === 'disabled') {
        global $post;
        wp_reset_query();  // Restore global post data stomped by the_post()

            $archive_template = WP_PLUGIN_DIR.'/ddprodm/include/diana/templates/diana-header-template.php';
            include_once($archive_template);
    }

    if(isset(get_option('ddpdm_header_custom')[get_option('ddpdm_header_template')]) && !is_null(get_option('ddpdm_header_custom')[get_option('ddpdm_header_template')]) && get_option('ddpdm_header_custom')[get_option('ddpdm_header_template')] !== false)
      $title = str_replace("&#8211;", "-", get_option('ddpdm_header_custom')[get_option('ddpdm_header_template')]);
    else $title = '';

    $header_layouts = get_posts(array(
        'post_type'   => 'et_pb_layout',
        'post_status' => 'publish',
        'title' => $title,
        )
    );

   if(!empty($header_layouts)) {
    foreach ($header_layouts as $header_layout):
       $header_id = $header_layout->ID;
       $header_title = $header_layout->post_title;
      // echo ' $header_id '.$header_id;
       if(has_term("Diana Collection", 'layout_category', $header_id )) {
        wp_enqueue_style('ddpdm-diana-headers', WP_PLUGIN_URL.'/ddprodm/build/diana/css/diana-headers.css');
        wp_enqueue_script('ddpdm-sliders-js', WP_PLUGIN_URL.'/ddprodm/build/diana/js/diana-sliders.js');
        wp_enqueue_script('ddpdm-social-icons-js', WP_PLUGIN_URL.'/ddprodm/build/diana/js/diana-social-icons.js');
       }

       if(has_term("Impi Collection", 'layout_category', $header_id )) {
        wp_enqueue_style('ddpdm-impi-headers', WP_PLUGIN_URL.'/ddprodm/build/impi/css/impi-headers.css');
       }

       if(has_term("Coco Collection", 'layout_category', $header_id )) {
        wp_enqueue_style('ddpdm-coco-headers', WP_PLUGIN_URL.'/ddprodm/build/coco/css/coco-headers.css');
        wp_enqueue_style('ddpdm-coco-sliders', WP_PLUGIN_URL.'/ddprodm/build/coco/css/coco-sliders.css');
        wp_enqueue_script('ddpdm-coco-sliders-js', WP_PLUGIN_URL.'/ddprodm/build/coco/js/sliders-coco.js');
        wp_enqueue_script('ddpdm-coco-socials-js', WP_PLUGIN_URL.'/ddprodm/build/coco/js/socials-coco.js');
       }

       if(has_term("Sigmund Collection", 'layout_category', $header_id )) {
        wp_enqueue_style('ddpdm-sigmund-header', WP_PLUGIN_URL.'/ddprodm/build/sigmund/css/headers-sigmund.css');
        wp_enqueue_style('ddpdm-sigmund-contact-pages', WP_PLUGIN_URL.'/ddprodm/build/sigmund/css/contact_pages_sigmund.css');
        wp_enqueue_script('ddpdm-sigmund-typed-js', WP_PLUGIN_URL.'/ddprodm/build/sigmund/js/typed-sigmund.js');
        wp_enqueue_script('ddpdm-sigmund-typing-js', WP_PLUGIN_URL.'/ddprodm/build/sigmund/js/typing-sigmund.js');
        wp_enqueue_script('ddpdm-sigmund-service-page1-js', WP_PLUGIN_URL.'/ddprodm/build/sigmund/js/sigmund-services-1.js');
       }

       if(has_term("Venus Bundle", 'layout_category', $header_id )) {
         wp_enqueue_style('ddpdm-venus-header', WP_PLUGIN_URL.'/ddprodm/build/venus/css/header-venus.css');
         wp_enqueue_style('ddpdm-venus-features', WP_PLUGIN_URL.'/ddprodm/build/venus/css/features-venus.css');
         wp_enqueue_script('ddpdm-venus-charming-js', WP_PLUGIN_URL.'/ddprodm/build/venus/js/charming.min.js');
         wp_enqueue_script('ddpdm-venus-hoverdir-js', WP_PLUGIN_URL.'/ddprodm/build/venus/js/jquery.hoverdir.js');
         wp_enqueue_script('ddpdm-venus-inview-js', WP_PLUGIN_URL.'/ddprodm/build/venus/js/jquery.inview.js');
         wp_enqueue_script('ddpdm-venus-masonry-js', WP_PLUGIN_URL.'/ddprodm/build/venus/js/masonry.pkgd.min.js');
         wp_enqueue_script('ddpdm-venus-nearby-js', WP_PLUGIN_URL.'/ddprodm/build/venus/js/nearby.js');
         wp_enqueue_script('ddpdm-venus-tweenmax-js', WP_PLUGIN_URL.'/ddprodm/build/venus/js/TweenMax.min.js');
         wp_enqueue_script('ddpdm-venus-header-js', WP_PLUGIN_URL.'/ddprodm/build/venus/js/venus-header.js');
         wp_enqueue_script('ddpdm-venus-features-js', WP_PLUGIN_URL.'/ddprodm/build/venus/js/venus-features.js');
       }

       if(has_term("Pegasus Bundle", 'layout_category', $header_id )) {
        wp_enqueue_style('ddpdm-pegasus-headers', WP_PLUGIN_URL.'/ddprodm/build/pegasus/css/pegasus-headers.css');
        wp_enqueue_script('ddpdm-pegasus-hoverdir-js', WP_PLUGIN_URL.'/ddprodm/build/pegasus/js/jquery.hoverdir.js');
        wp_enqueue_script('ddpdm-pegasus-inview-js', WP_PLUGIN_URL.'/ddprodm/build/pegasus/js/jquery.inview.js');
        wp_enqueue_script('ddpdm-pegasus-masonry-js', WP_PLUGIN_URL.'/ddprodm/build/pegasus/js/masonry.pkgd.min.js');
        wp_enqueue_script('ddpdm-pegasus-js', WP_PLUGIN_URL.'/ddprodm/build/pegasus/js/pegasus_divi.js');
       }

       if(has_term("Falkor Bundle", 'layout_category', $header_id )) {
        wp_enqueue_style('ddpdm-falkor-headers', WP_PLUGIN_URL.'/ddprodm/build/falkor/css/falkor-headers.css');
        wp_enqueue_script('ddpdm-falkor-js', WP_PLUGIN_URL.'/ddprodm/build/falkor/js/falkor_divi.js');
       }

       if(has_term("Pixie Bundle", 'layout_category', $header_id )) {
         wp_enqueue_style('ddpdm-pixie-header', WP_PLUGIN_URL.'/ddprodm/build/pixie/css/pixie-headers.css');
         wp_enqueue_script('ddpdm-pixie-js', WP_PLUGIN_URL.'/ddprodm/build/pixie/js/pixie_divi.js');
       }

       if(has_term("Unicorn Bundle", 'layout_category', $header_id )) {
         wp_enqueue_style('ddpdm-unicorn-header', WP_PLUGIN_URL.'/ddprodm/build/unicorn/css/header-unicorn-divi-layout-kit.css');
         wp_enqueue_script('ddpdm-unicorn-js', WP_PLUGIN_URL.'/ddprodm/build/unicorn/js/unicorn_divi.js');
       }
    endforeach;
   }


} //function ddprodm_pop_ups_template($archive_template)

add_action('wp_footer', 'ddprodm_header_template');