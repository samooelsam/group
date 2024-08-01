<?php // footers
function ddprodm_footer_template($archive_template) {
    if(get_option('ddpdm_footer_template') !== 'disabled' && get_option('ddpdm_coming_soon_template') === 'disabled') {
        global $post;
        wp_reset_query();  // Restore global post data stomped by the_post()

            $archive_template = WP_PLUGIN_DIR.'/ddprodm/include/diana/templates/diana-footer-template.php';
            include_once($archive_template);
    }

    if(isset(get_option('ddpdm_footer_custom')[get_option('ddpdm_footer_template')]) && !is_null(get_option('ddpdm_footer_custom')[get_option('ddpdm_footer_template')]) && get_option('ddpdm_footer_custom')[get_option('ddpdm_footer_template')] !== false)
      $title = str_replace("&#8211;", "-", get_option('ddpdm_footer_custom')[get_option('ddpdm_footer_template')]);
    else $title = '';

    $footer_layouts = get_posts(array(
        'post_type'   => 'et_pb_layout',
        'post_status' => 'publish',
        'title' => $title,
        )
    );

    //print_r($footer_layout);

   if(!empty($footer_layouts)) {
    foreach ($footer_layouts as $footer_layout):
       $footer_id = $footer_layout->ID;
       $footer_title = $footer_layout->post_title;
      // echo ' $footer_id '.$footer_id;
       if(has_term("Coco Collection", 'layout_category', $footer_id )) {
        wp_enqueue_style('ddpdm-coco-footers', WP_PLUGIN_URL.'/ddprodm/build/coco/css/coco-footers.css');
        wp_enqueue_script('ddpdm-coco-newsletter-js', WP_PLUGIN_URL.'/ddprodm/build/coco/js/newsletter-coco.js');
       }

       if(has_term("Diana Collection", 'layout_category', $footer_id )) {
        wp_enqueue_style('ddpdm-diana-footers', WP_PLUGIN_URL.'/ddprodm/build/diana/css/diana-footers.css');
        wp_enqueue_script('ddpdm-footers-js', WP_PLUGIN_URL.'/ddprodm/build/diana/js/diana-footers.js');
       }

       if(has_term("Pegasus Bundle", 'layout_category', $footer_id )) {
        wp_enqueue_style('ddpdm-pegasus-footers', WP_PLUGIN_URL.'/ddprodm/build/pegasus/css/pegasus-footers.css');
        wp_enqueue_script('ddpdm-pegasus-js', WP_PLUGIN_URL.'/ddprodm/build/pegasus/js/pegasus_divi.js');
       }

       if(has_term("Pixie Bundle", 'layout_category', $footer_id )) {
         wp_enqueue_style('ddpdm-pixie-footer', WP_PLUGIN_URL.'/ddprodm/build/pixie/css/pixie-footer.css');
         wp_enqueue_script('ddpdm-pixie-js', WP_PLUGIN_URL.'/ddprodm/build/pixie/js/pixie_divi.js');
       }

       if(has_term("Unicorn Bundle", 'layout_category', $footer_id )) {
         wp_enqueue_style('ddpdm-unicorn-footer', WP_PLUGIN_URL.'/ddprodm/build/unicorn/css/footer-unicorn-divi-layout-kit.css');
         wp_enqueue_script('ddpdm-unicorn-js', WP_PLUGIN_URL.'/ddprodm/build/unicorn/js/unicorn_divi.js');
       }

       if(has_term("Falkor Bundle", 'layout_category', $footer_id )) {
         wp_enqueue_style('ddpdm-falkor-footer', WP_PLUGIN_URL.'/ddprodm/build/falkor/css/falkor-footers.css');
         wp_enqueue_script('ddpdm-falkor-js', WP_PLUGIN_URL.'/ddprodm/build/falkor/js/falkor_divi.js');
       }

       if(has_term("Freddie Collection", 'layout_category', $footer_id )) {
        wp_enqueue_style('ddpdm-freddie-footer', WP_PLUGIN_URL.'/ddprodm/build/freddie/css/freddie-footers.css');
        wp_enqueue_script('ddpdm-freddie-gsap-jquery-js', WP_PLUGIN_URL.'/ddprodm/build/freddie/js/gsap/gsap.min.js');
        wp_enqueue_script('ddpdm-freddie-newsletter-js', WP_PLUGIN_URL.'/ddprodm/build/freddie/js/freddieNewsletter.js');
        wp_enqueue_script('ddpdm-freddie-footers-js', WP_PLUGIN_URL.'/ddprodm/build/freddie/js/freddieScriptsFooters.js');

        wp_enqueue_style('ddpdm-freddie-button-party', WP_PLUGIN_URL.'/ddprodm/build/freddie/css/freddie-buttons-party.css');
        wp_enqueue_script('ddpdm-freddie-button-party-js', WP_PLUGIN_URL.'/ddprodm/build/freddie/js/freddie-button-party.js');

        wp_enqueue_style('ddpdm-freddie-button-ogre-battle', WP_PLUGIN_URL.'/ddprodm/build/freddie/css/freddie-buttons-ogre-battle.css');
        wp_enqueue_script('ddpdm-freddie-button-ogre-battle-js', WP_PLUGIN_URL.'/ddprodm/build/freddie/js/freddie-button-ogre-battle.js');
       }
    endforeach;
   }


} //function ddprodm_pop_ups_template($archive_template)

add_action('wp_footer', 'ddprodm_footer_template');