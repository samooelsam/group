<?php
add_action( 'wp_enqueue_scripts', 'my_theme_enqueue_styles' );
function my_theme_enqueue_styles() {
    wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );
}
add_filter( 'wpcf7_form_elements', 'delicious_wpcf7_form_elements' ); 
function delicious_wpcf7_form_elements( $form ) {
$form = do_shortcode( $form );
return $form;
}
add_action( 'wp_print_styles', 'aa_deregister_styles', 100 );
function aa_deregister_styles() {
    if ( ! is_page( 'contact' ) ) {
        wp_deregister_style( 'contact-form-7' );
    }
}
// Deregister Contact Form 7 JavaScript files on all pages without a form
add_action( 'wp_print_scripts', 'aa_deregister_javascript', 100 );
function aa_deregister_javascript() {
    if ( ! is_page( 'contact' ) ) {
        wp_deregister_script( 'contact-form-7' );
    }
}
add_action( 'wp_print_scripts', 'my_deregister_javascript', 100 );
function my_deregister_javascript() {
wp_deregister_script( 'post_grid_scripts' );
}

//if modified since header gomahamaya//
add_action('template_redirect', 'gom_add_last_modified_header');
function gom_add_last_modified_header($headers) {
    if( is_singular() ) {
        $post_id = get_queried_object_id();
        if( $post_id ) {
            header("Last-Modified: " . get_the_modified_time("D, d M Y H:i:s", $post_id) );
        }
    }
}