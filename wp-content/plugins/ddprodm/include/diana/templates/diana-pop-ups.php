<?php

$pop_ups_titles = array('Kingly Form Pop-Up - PHP Templ - Diana', 'Renowned Pricing Pop-Up - PHP Templ - Diana', 'Great Portfolio Pop-Up - PHP Templ - Diana', 'Striking Search Pop-Up - PHP Templ - Diana', 'Prominent Search Pop-Up - PHP Templ - Diana', 'Special Search Pop-Up - PHP Templ - Diana', 'Salient Search Pop-Up - PHP Templ - Diana');

for ($i = 1; $i < 18 ; $i++) {
    $pop_ups_titles[] = 'Pop-Up V'.$i.' - PHP Templ - Ragnar ';
}

//print_r($pop_ups_titles);


foreach ($pop_ups_titles as &$pop_ups_title) {
    $args = array(
    'post_type' => 'et_pb_layout',
    'title' => $pop_ups_title,
    'post_status' => 'publish',
    'posts_per_page' => 1,
    'tax_query' => array(
        array(
            'taxonomy' => 'layout_category',
            'field'    => 'slug',
            'terms'    => 'pop-up',
        ),
    ),
);

//$my_query = null;
$my_query = new WP_Query($args);

if ($my_query->have_posts()) {
   // echo $pop_ups_title;
    while ($my_query->have_posts()) : $my_query->the_post();
        remove_filter('the_content', 'wpautop');
        the_content();
    endwhile;
}

wp_reset_query();
}