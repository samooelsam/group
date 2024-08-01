<?php


// ******** LOGIN PAGE ************************

if (!function_exists('ddpdm_allowed_html')) {
    require_once(plugin_dir_path(__FILE__) . 'ddpdm-allowed-html-tags');
}

function ddprodm_login() {
    switch (get_option('ddpdm_login_template')) {
        case 'diana_1':
           wp_enqueue_style('ddpdm-diana-login1', WP_PLUGIN_URL.'/ddprodm/build/diana/css/diana-login-page1.css');
           wp_enqueue_script("jquery");
           wp_enqueue_script('ddpdm-diana-login1-js', WP_PLUGIN_URL.'/ddprodm/build/diana/js/dianaLoginPage1.js');
            break;
        case 'diana_2':
           wp_enqueue_style('ddpdm-diana-login2', WP_PLUGIN_URL.'/ddprodm/build/diana/css/diana-login-page2.css');
           wp_enqueue_style('ddpdm-diana-login2-divi', '/wp-content/themes/Divi/core/admin/css/core.css');
           wp_enqueue_script("jquery");
           wp_enqueue_script('ddpdm-diana-login2-js', WP_PLUGIN_URL.'/ddprodm/build/diana/js/dianaLoginPage2.js');
            break;
        case 'diana_3':
           wp_enqueue_style('ddpdm-diana-login3', WP_PLUGIN_URL.'/ddprodm/build/diana/css/diana-login-page3.css');
           wp_enqueue_style('ddpdm-diana-login3-divi', '/wp-content/themes/Divi/core/admin/css/core.css');
           wp_enqueue_script("jquery");
           wp_enqueue_script('ddpdm-diana-login3-js', WP_PLUGIN_URL.'/ddprodm/build/diana/js/dianaLoginPage3.js');
            break;
        default:
            break;
    }
}
add_action('login_head', 'ddprodm_login');


function ddprodm_login_logo() { ?>
    <style type="text/css">
      <?php  if(get_option('ddpdm_login_template') === 'diana_1' || get_option('ddpdm_login_template') === 'diana_2') { ?>
        /*ruling login and commanding dark login*/
        #login h1 a, .login h1 a {
            background-image: url(<?php echo esc_attr(WP_PLUGIN_URL).'/ddprodm/include/diana/img/login-page-logo.png';?>);
        }
    <?php }
        if(get_option('ddpdm_login_template') === 'diana_1'){ ?>
        /*commanding dark login*/
        body.login form label[for="user_email"]:before,
        body.login form label[for="user_login"]:before,
        body.login form label[for="user_pass"]:before{
            background-image: url(<?php echo esc_attr(WP_PLUGIN_URL).'/ddprodm/include/diana/img/login-page-error-bg.png';?>);
        }

    <?php }
        if(get_option('ddpdm_login_template') === 'diana_2'){
    ?>


        /*ruling login*/
        body.login .column_2{
            background-image: url(<?php echo esc_attr(WP_PLUGIN_URL).'/ddprodm/include/diana/img/login-page2-bg.jpg';?>);
        }

    <?php } ?>

    </style>
<?php }
add_action( 'login_enqueue_scripts', 'ddprodm_login_logo' );


// only for queenly login

function ddprodm_login_content( $page ) {
    if(get_option('ddpdm_login_template') === 'diana_3') {
    echo '<div class="queenly_ddprodm_login_content"><img src="' . esc_url(get_theme_mod('ddpdm_login_diana_3_logo_image', WP_PLUGIN_URL.'/ddprodm/include/diana/img/login-page3-logo.png')). '">
          <div class="info"><div class="office">'.wp_kses(get_theme_mod('ddpdm_login_diana_3_info_address_value', '<h2>Office</h2><p>105 Road Name</p><p>Berlin</p><p>Germany</p>'), ddpdm_allowed_html()).'</div>
          <div class="contact">'.wp_kses(get_theme_mod('ddpdm_login_diana_3_info_contact_value', '<h2>Contacts</h2><p><a href="mailto:Name@website.com">Name@website.com</a></p>'), ddpdm_allowed_html()).'</div></div>
          <div class="social">'.wp_kses(get_theme_mod('ddpdm_login_diana_3_info_social_value', '<h2>Social</h2><p><a href="#">Facebook</a></p>   <p><a href="#">Instagram</a></p><p><a href="#">Twitter</a></p><p><a href="#">Behance</a></p><p><a href="#">Dribble</a></p>'), ddpdm_allowed_html()).'</div></div>';
    }
}
add_action( 'login_footer', 'ddprodm_login_content' );


function ddpdm_login_main( $template ) {

        if ( is_customize_preview() && isset( $_REQUEST['ddpdm_login_section'] ) && is_user_logged_in() ) { // phpcs:ignore
            include_once('wp-login.php');
            echo "<style>
            #page-container {display: none !important;}
            </style>";
            if(get_option('ddpdm_login_template') === 'diana_1') {
                echo "<style>
            * {
                -webkit-box-sizing: unset !important;
                -moz-box-sizing: unset !important;
                box-sizing: unset !important;
            }
            </style>";
            }
            ddprodm_login();
        }
    }

add_action('wp', 'ddpdm_login_main');


// ******** END LOGIN PAGE ************************




