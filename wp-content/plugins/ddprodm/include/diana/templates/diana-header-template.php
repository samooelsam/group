<?php

if(get_option('ddpdm_header_template') !== 'disabled') {
	global $post;
	$title_header = '';

	foreach(get_option('ddpdm_header_custom') as $option => $value) {
        if ($option === get_option('ddpdm_header_template')) {
            $title_header = $value;
        }
    }


    if($title_header !== '') {
    $title_header =  str_replace("&#8211;", "-", $title_header);


	$args = array(
	    'post_type' => 'et_pb_layout',
	    'title' => $title_header,
	    'post_status' => 'publish',
	);

    $my_query = new WP_Query($args);

    if ($my_query->have_posts()) {
   		while ($my_query->have_posts()) : $my_query->the_post();
        echo '<header id="ddpdm_header">';
    		the_content();
        echo '</header>';
      	endwhile;
    }

wp_reset_query();  // Restore global post data stomped by the_post()
?>
<script type="text/javascript">
        (function($) {
            setTimeout(function(){
                $('header#ddpdm_header').insertAfter($('#custom-ddpdm-menu')); }, 1000);
                $('header#ddpdm_header').insertAfter('#main-header');
           // $('header#main-header').remove();
        })(jQuery);
    </script>
<?php
} // if($title_header !== '')

} //if(get_option('ddpdm_header_template') !== 'disabled')
