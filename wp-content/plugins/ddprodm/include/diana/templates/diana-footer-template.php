<?php

if(get_option('ddpdm_footer_template') !== 'disabled') {
	global $post;
	$title_footer = '';

	foreach(get_option('ddpdm_footer_custom') as $option => $value) {
        if ($option === get_option('ddpdm_footer_template')) {
            $title_footer = $value;
        }
    }


    if($title_footer !== '') {
    $title_footer =  str_replace("&#8211;", "-", $title_footer);

	$args = array(
	    'post_type' => 'et_pb_layout',
	    'title' => $title_footer,
	    'post_status' => 'publish',
	);

    $my_query = new WP_Query($args);

    if ($my_query->have_posts()) {
   		while ($my_query->have_posts()) : $my_query->the_post();
        echo '<footer id="ddpdm_footer">';
    		the_content();
        echo '</footer>';
      	endwhile;
    }

wp_reset_query();  // Restore global post data stomped by the_post()
?>
<script type="text/javascript">
        (function($) {
            $('footer#ddpdm_footer').insertAfter('#main-content > :last-child');
            $('footer#main-footer').remove();
        })(jQuery);
    </script>
<?php
} // if($title_footer !== '')

} //if(get_option('ddpdm_footer_template') !== 'disabled')
