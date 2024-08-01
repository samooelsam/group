<?php
/*
Plugin Name: Divi Den Pro DM
Plugin URI:  https://seku.re/dm-divi-den-pro
Description: Divi Den Pro DM is a huge layout library made for Elegant Themes' Divi Marketplace. Search the cloud library for page layouts, sections and modules. Build beautiful websites at twice the speed.

Version:     5.3.5
Author:      Divi Den
Author URI:  https://seku.re/divi-den-author-divi-marketplace
License:     GPLv3
License URI: https://www.gnu.org/licenses/gpl-3.0.html

Text Domain: ddprodm
Domain Path: /languages
*/

if (!defined('ABSPATH')) {
    exit;
}

//======================================================================
// Load Persist Admin notices Dismissal
//======================================================================

if (!class_exists('PAnD')) {
    require_once(plugin_dir_path(__FILE__) . '/include/persist-admin-notices-dismissal.php');
    add_action('admin_init', array(
        'PAnD',
        'init'
    ));
}

//======================================================================
//  Load the main plugin class
//======================================================================

if (!class_exists('ddpdm_Main_Class')) {
    require_once(plugin_dir_path(__FILE__) . 'ddprodm-main.php');
    ddpdm_Main_Class::instance(__FILE__, 'Divi Den Pro DM', '5.3.5');
}

if (!function_exists('ddpdm_allowed_html')) {
    require_once(plugin_dir_path(__FILE__) . 'include/ddpdm-allowed-html-tags.php');
}

//======================================================================
// CHECK IF DIVI THEME INSTALLED
//======================================================================

function ddpdm_not_installed_admin_notice__error()
{
    $class   = 'notice notice-error is-dismissible';
    $message = __('<strong>Action Required:</strong> The Divi Theme is not installed. You must install the Divi Theme for the ', 'ddprodm').DDPDM_NAME.__(' to work. If you do not already have it,', 'ddprodm').' <a href="https://seku.re/get-divi" target="_blank">'.__('Get it here', 'ddprodm').'</a>';

    printf('<div data-dismissible="disable-ddpdm-status-warning-notice-forever" class="%1$s"><p>%2$s</p></div>', esc_attr($class), wp_kses($message, ddpdm_allowed_html()));
}

$divi_theme = wp_get_theme('Divi');
if (!($divi_theme->exists())) {
    add_action('admin_notices', 'ddpdm_not_installed_admin_notice__error');
}



//======================================================================
// HIDE DDFREE
//======================================================================

function ddpdm_hide_plugin_ddd()
{
    global $wp_list_table;
    $hidearr   = array(
        'ddfree/ddfree.php'
    );
    $myplugins = $wp_list_table->items;
    foreach ($myplugins as $key => $val) {
        if (in_array($key, $hidearr)) {
            unset($wp_list_table->items[$key]);
        }
    }
}

add_action('pre_current_active_plugins', 'ddpdm_hide_plugin_ddd');

function ddpdm_mu_hide_plugins_network($plugins)
{
    if (in_array('ddfree/dfree.php', array_keys($plugins))) {
        unset($plugins['ddfree/ddfree.php']);
    }
    return $plugins;
}

add_filter('all_plugins', 'ddpdm_mu_hide_plugins_network');

//======================================================================
// DDP WPD IS ACTIVE NOTICE
//======================================================================

function ddpdm_ddpwpd_active_admin_notice__error()
{
    $class   = 'notice notice-error is-dismissible ddpwpd-active-notice';
    $message = __('<strong>WARNING:</strong> Two different versions of the Divi Den Pro plugin was detected. Only one version should be used. To avoid errors, please', 'ddprodm').' <a href="'.admin_url('plugins.php').'">'.__('deactivate', 'ddprodm').'</a> '.__('either "Divi Den Pro DM" or "Divi Den Pro".', 'ddprodm').'<br>'.__('<strong>IMPORTANT:</strong> Please create a backup of your website and database before making the switch. Backward compatibility cannot be guaranteed. Please proceed with caution and test thoroughly after any changes. ', 'ddprodm').' <a href="https://seku.re/ddpdm-wpnotice-support" target="_blank">'.__('Contact support', 'ddprodm').'</a> '.__('if you have any questions', 'ddprodm').'.';

    if (PAnD::is_admin_notice_active('disable-ddpwpd-active-notice-forever')) {
        printf('<div data-dismissible="disable-ddpwpd-active-notice-forever" class="%1$s"><p>%2$s</p></div>', esc_attr($class), wp_kses($message, ddpdm_allowed_html()));
    }
}

//======================================================================
// CHECK IF DDP WPD IS ACTIVE
//======================================================================

function ddpdm_check_ddpwpd()
{
    if (! function_exists('is_plugin_active')) {
        require_once(ABSPATH . '/wp-admin/includes/plugin.php');
    }

    if (is_plugin_active('ddpro/ddpro.php')) {
        add_action('admin_notices', 'ddpdm_ddpwpd_active_admin_notice__error');
    }
}
add_action('admin_init', 'ddpdm_check_ddpwpd');

if (!get_option('ddpdm_wl')) {
    add_option('ddpdm_wl', 'disabled');
}

add_action('wp_ajax_ddpdm_get_option_wl', 'ddpdm_get_option_wl', 9, 1);
add_action('wp_ajax_nopriv_ddpdm_get_option_wl', 'ddpdm_get_option_wl', 9, 1);

//======================================================================
// HIDE TABS IF WL ENABLED
//======================================================================

function ddpdm_wl_hide_tabs()
{
    if (get_option('ddpdm_wl') == 'enabled') {// update_option('ddpdm_enable', 'disabled');
    } else {
        update_option('ddpdm_enable', 'enabled');
        update_option('ddpdm_allow_upd', 'enabled');
    }
}
add_action('admin_init', 'ddpdm_wl_hide_tabs');



//======================================================================
// ADD ADMIN SCRIPTS
//======================================================================

add_action('admin_enqueue_scripts', 'ddpdm_enqueue_admin_js');
add_action('et_builder_ready', 'ddpdm_enqueue_admin_js_to_vb');

function ddpdm_enqueue_admin_js($hook_suffix)
{
    wp_enqueue_script('ddpdm-clipboard', plugins_url('js/clipboard.min.js', __FILE__), array(), "5.2.0", 'false');
    wp_enqueue_script('ddpdm-cookie', plugins_url('build/diana/js/diana-jquery.cookie.js', __FILE__), array(), "5.2.0", 'false');
    wp_enqueue_script('ddpdm-alphanum', plugins_url('js/jquery.alphanum.js', __FILE__), array(), "5.2.0", 'false');
    wp_enqueue_script('ddpdm-admin-masonry', plugins_url('js/masonry.pkgd.js', __FILE__), array(), "5.2.0", 'false');
    wp_enqueue_script('ddpdm-admin', plugins_url('js/ddpdm-admin.js', __FILE__), array( 'wp-i18n' ), "5.2.0", 'false');
    if (get_theme_mod('ddpdm_icons_fa', false) == 1 || get_theme_mod('ddpdm_icons_fa', false) == 1) {
        wp_enqueue_script('ddpdm-icons-admin', plugins_url('js/ddpdm-admin-custom-icons.js', __FILE__), array( 'wp-i18n' ), "5.2.0", 'false');
    }
    if (get_option('ddpdm_wl') == 'enabled' && get_option('ddpdm_plugin_name')) {
        $ddpdm_wl_pn = get_option('ddpdm_plugin_name');
    } else {
        $ddpdm_wl_pn = 'Divi Den Pro DM';
    }

    if (get_option('ddpdm_wl') == 'enabled') {
        if (get_option('ddpdm_plugin_icon') != '') {
            $ddpdm_wl_i = get_option('ddpdm_plugin_icon');
        } else {
            $ddpdm_wl_i = plugin_dir_url(__FILE__) . '/include/ddpdm-wl-default-icon.png';
        }
    } else {
        $ddpdm_wl_i = plugin_dir_url(__FILE__) . '/include/ddpdm-icon.png';
    }

    $ddpdm_status = get_option('ddpdm_enable');

    $ddpdm_expired_status = get_option('ddpdm_subscription_expired');

    $ddpdm_js_options_array = array(
        'ddpdm_wl_pn_for_js' => $ddpdm_wl_pn,
        'ddpdm_wl_i_for_js' => $ddpdm_wl_i,
        'ddpdm_ajax_url' => admin_url('admin-ajax.php'),
        'ddpdm_plugin_setting_tab_position' => get_option('ddpdm_plugin_setting_tab_position'),
        'ddpdm_status' => $ddpdm_status,
        'ddpdm_expired_status' => $ddpdm_expired_status,
        'ddpdm_nonce' => wp_create_nonce('ddpdm-main-nonce'),
    );

    wp_localize_script('ddpdm-admin', 'ddpdm_wl_options_for_js', $ddpdm_js_options_array);
}

function ddpdm_enqueue_admin_js_to_vb($hook_suffix)
{
    $time = '<span>1</span>';
    wp_enqueue_script('jquery');
    wp_enqueue_script('ddpdm-clipboard', plugins_url('js/clipboard.min.js', __FILE__), array(), "5.2.0", 'false');
//    wp_enqueue_script('ddpdm-alphanum', plugins_url('js/jquery.alphanum.js', __FILE__),  array(), "5.2.0", 'false');
    wp_enqueue_script('ddpdm-admin', plugins_url('js/ddpdm-admin.js', __FILE__), array( 'wp-i18n' ), "5.2.0", 'false');
    if (get_option('ddpdm_wl') == 'enabled' && get_option('ddpdm_plugin_name')) {
        $ddpdm_wl_pn = get_option('ddpdm_plugin_name');
    } else {
        $ddpdm_wl_pn = 'Divi Den Pro DM';
    }
    if (get_option('ddpdm_wl') == 'enabled' && get_option('ddpdm_plugin_icon')) {
        $ddpdm_wl_i = get_option('ddpdm_plugin_icon');
    } else {
        $ddpdm_wl_i = plugin_dir_url(__FILE__) . '/include/ddpdm-icon.png';
    }

    $ddpdm_status = get_option('ddpdm_enable');

    $ddpdm_expired_status = get_option('ddpdm_subscription_expired');

    $ddpdm_js_options_array = array(
        'ddpdm_wl_pn_for_js' => $ddpdm_wl_pn,
        'ddpdm_wl_i_for_js' => $ddpdm_wl_i,
        'ddpdm_ajax_url' => admin_url('admin-ajax.php'),
        'ddpdm_plugin_setting_tab_position' => get_option('ddpdm_plugin_setting_tab_position'),
        'ddpdm_status' => $ddpdm_status,
        'ddpdm_expired_status' => $ddpdm_expired_status,
        'ddpdm_nonce' => wp_create_nonce('ddpdm-main-nonce'),
    );

    wp_localize_script('ddpdm-admin', 'ddpdm_wl_options_for_js', $ddpdm_js_options_array);
}


//======================================================================
// ADD ADMIN CSS
//======================================================================

add_action('admin_enqueue_scripts', 'ddpdm_enqueue_admin_css');

function ddpdm_enqueue_admin_css()
{
    if (get_theme_mod('ddpdm_icons_fa', false) == 1) {
        wp_register_style('ddpdm-admin-font-awesome', plugins_url('fonts/font-awesome/all.min.css', __FILE__), array(), '5.2.0', 'all');
        wp_enqueue_style('ddpdm-admin-font-awesome');
    }

    if (get_theme_mod('ddpdm_icons_md', false) == 1) {
        wp_register_style('ddpdm-admin-material-design-icons', plugins_url('fonts/material-design/iconfont/material-icons.css', __FILE__), array(), '5.2.0', 'all');
        wp_enqueue_style('ddpdm-admin-material-design-icons');
    }

    wp_register_style('ddpdm-admin', plugins_url('css/ddpdm-admin.css', __FILE__), array(), '5.2.0', 'all');
    wp_register_style('ddpdm-admin-eb', plugins_url('css/ddpdm-admin-eb.css', __FILE__), array(), '5.2.0', 'all');
    wp_enqueue_style('ddpdm-admin');
    wp_enqueue_style('ddpdm-admin-eb');
}


//======================================================================
// ADD ADMIN CSS FOR VB
//======================================================================

add_action('et_builder_ready', 'ddpdm_enqueue_admin_css_for_vb');
//add_action('admin_enqueue_scripts', 'ddpdm_enqueue_admin_css_for_vb');

function ddpdm_enqueue_admin_css_for_vb()
{
    wp_register_style('ddpdm-admin-css-vb', plugins_url('css/ddpdm-admin-vb.css', __FILE__), array(), '5.2.0', 'all');
    wp_enqueue_style('ddpdm-admin-css-vb');
}


//======================================================================
// New options for plugin's setting
//======================================================================
    function ddpdm_add_options_on_activate()
    {
        if (!get_option('ddpdm_enable')) {
            add_option('ddpdm_enable', 'enabled');
        }
        if (!get_option('ddpdm_allow_upd')) {
            add_option('ddpdm_allow_upd', 'enabled');
        }
    }

register_activation_hook(__FILE__, 'ddpdm_add_options_on_activate');

//======================================================================
// New options for plugin's setting
//======================================================================

function ddpdm_add_options()
{
    if (!get_option('ddpdm_404_page_template')) {
        add_option('ddpdm_404_page_template', 'disabled');
    }

    if (!get_option('ddpdm_category_page_template')) {
        add_option('ddpdm_category_page_template', 'global');
    }

    if (!get_option('ddpdm_author_page_template')) {
        add_option('ddpdm_author_page_template', 'global');
    }

    if (!get_option('ddpdm_tag_page_template')) {
        add_option('ddpdm_tag_page_template', 'global');
    }

    if (!get_option('ddpdm_global_page_template')) {
        add_option('ddpdm_global_page_template', 'disabled');
    }

    if (!get_option('ddpdm_search_results_page_template')) {
        add_option('ddpdm_search_results_page_template', 'disabled');
    }

    if (!get_option('ddpdm_menu_template')) {
        add_option('ddpdm_menu_template', 'disabled');
    }

    if (!get_option('ddpdm_coming_soon_template')) {
        add_option('ddpdm_coming_soon_template', 'disabled');
    }

    if (!get_option('ddpdm_sticky_bar_template')) {
        add_option('ddpdm_sticky_bar_template', 'disabled');
    }

    if (!get_option('ddpdm_sticky_bar_delay')) {
        add_option('ddpdm_sticky_bar_delay', 0);
    }

    if (!get_option('ddpdm_sticky_bar_cookie_days')) {
        add_option('ddpdm_sticky_bar_cookie_days', 120);
    }

    if (!get_option('ddpdm_sticky_show_close')) {
        add_option('ddpdm_sticky_show_close', true);
    }

    if (!get_option('ddpdm_sticky_show_leave')) {
        add_option('ddpdm_sticky_show_leave', false);
    }

    if (!get_option('ddpdm_pop_up_template')) {
        add_option('ddpdm_pop_up_template', 'disabled');
    }

    if (!get_option('ddpdm_pop_up_scroll_per')) {
        add_option('ddpdm_pop_up_scroll_per', 20);
    }

    if (!get_option('ddpdm_single_post_template')) {
        add_option('ddpdm_single_post_template', 'disabled');
    }

    if (!get_option('ddpdm_footer_template')) {
        add_option('ddpdm_footer_template', 'disabled');
    }

    if (!get_option('ddpdm_header_template')) {
        add_option('ddpdm_header_template', 'disabled');
    }

    if (!get_option('ddpdm_mobile_menu_template')) {
        add_option('ddpdm_mobile_menu_template', 'disabled');
    }

    if (!get_option('ddpdm_plugin_setting_tab_position')) {
        add_option('ddpdm_plugin_setting_tab_position', 'on');
    }

    if (post_type_exists('et_footer_layout')) {
        add_post_type_support('et_footer_layout', 'custom-fields');
    }

    if (post_type_exists('et_header_layout')) {
        add_post_type_support('et_header_layout', 'custom-fields');
    }

    if (post_type_exists('et_body_layout')) {
        add_post_type_support('et_body_layout', 'custom-fields');
    }
}

add_action('plugins_loaded', 'ddpdm_add_options');

if (file_exists(ABSPATH . 'wp-includes/class-wp-customize-control.php')) {
    include_once ABSPATH . 'wp-includes/class-wp-customize-control.php';
}

if (get_option('ddpdm_subscription_stopped') == 'no') {

    //======================================================================
    // CHECK IF OLD BETA VERSION IS ACTIVE
    //======================================================================

    function ddprodm_beta_version_installed_admin_notice__warning()
    {
        $class   = 'notice notice-warning is-dismissible';
        $message = __('Divi Den on Demand BETA plugin is not required anymore. It has been deactivated and can safely be removed - ', 'ddprodm').'<a href="';
        $message .= admin_url('plugins.php');
        $message .= '">'.__('Go to plugins page to remove', 'ddprodm').'</a>';

        if (PAnD::is_admin_notice_active('disable-ddpdm-beta-warning-notice-forever')) {
            printf('<div data-dismissible="disable-ddpdm-beta-warning-notice-forever" class="%1$s"><p>%2$s</p></div>', esc_attr($class), wp_kses($message, ddpdm_allowed_html()));
        }
    }

    if (file_exists(str_replace('ddprodm', 'divi-den-on-demand', plugin_dir_path(__FILE__)) . 'divi-den-on-demand.php')) {
        include_once(ABSPATH . 'wp-admin/includes/plugin.php');
        if (get_option('ddpdm_wl') !== 'enabled') {
            add_action('admin_notices', 'ddprodm_beta_version_installed_admin_notice__warning');
        }
        deactivate_plugins('/divi-den-on-demand/divi-den-on-demand.php');
    }

    $ddpdm_plugin_data = get_file_data(__FILE__, array('Version' => 'Version'), false);
    $ddpdm_plugin_version = $ddpdm_plugin_data['Version'];

    define('DDPDM_VERSION', $ddpdm_plugin_version);


    //======================================================================
    // ADD A LINK TO SETTINGS PAGE
    //======================================================================
    function add_ddprodm_settings_link($links)
    {
        return array_merge($links, array(
            '<a href="' . admin_url('/admin.php?page=' . DDPDM_LINK . '_dashboard') . '">' . __('Settings') . '</a>'
        ));
    }

    add_filter('plugin_action_links_' . plugin_basename(__FILE__), 'add_ddprodm_settings_link');

    // require_once(ABSPATH . 'wp-admin/includes/plugin.php');

    //======================================================================
    // CHECK IF ASSISTANT PLUGINS ARE ACTIVE
    //======================================================================

    function ddprodm_assistant_plugins_installed_admin_notice__warning()
    {
        $list_of_assistant_plugins_text = '';


        if (file_exists(str_replace('ddprodm', 'falkor-assistant', plugin_dir_path(__FILE__)) . 'falkor-assistant.php')) {
            $list_of_assistant_plugins_text .= 'Falkor Assistant, ';
        }

        if (file_exists(str_replace('ddprodm', 'jackson-assistant', plugin_dir_path(__FILE__)) . 'jackson-assistant.php')) {
            $list_of_assistant_plugins_text .= 'Jackson Assistant, ';
        }

        if (file_exists(str_replace('ddprodm', 'mermaid-divi', plugin_dir_path(__FILE__)) . 'mermaid-divi.php')) {
            $list_of_assistant_plugins_text .= 'Mermaid Assistant, ';
        }

        if (file_exists(str_replace('ddprodm', 'mozart-assistant', plugin_dir_path(__FILE__)) . 'mozart-assistant.php')) {
            $list_of_assistant_plugins_text .= 'Mozart Assistant, ';
        }

        if (file_exists(str_replace('ddprodm', 'pegasus-assistant', plugin_dir_path(__FILE__)) . 'pegasus-assistant.php')) {
            $list_of_assistant_plugins_text .= 'Pegasus Assistant, ';
        }

        if (file_exists(str_replace('ddprodm', 'pixie-assistant', plugin_dir_path(__FILE__)) . 'pixie-assistant.php')) {
            $list_of_assistant_plugins_text .= 'Pixie Assistant, ';
        }

        if (file_exists(str_replace('ddprodm', 'unicorn-assistant', plugin_dir_path(__FILE__)) . 'unicorn-assistant.php')) {
            $list_of_assistant_plugins_text .= 'Unicorn Assistant, ';
        }

        if (file_exists(str_replace('ddprodm', 'venus-assistant', plugin_dir_path(__FILE__)) . 'venus-assistant.php')) {
            $list_of_assistant_plugins_text .= 'Venus Assistant, ';
        }

        $class   = 'notice notice-warning is-dismissible';
        $message = __('<strong>Action Required:</strong> To avoid conflicts with ', 'ddprodm').DDPDM_NAME.__(' plugin, it is <strong>strongly recommended</strong> to remove the following plugins: <strong><i>', 'ddprodm');
        $message .= substr($list_of_assistant_plugins_text, 0, -2) . '</i></strong>.';
        $message .= __(' Please <a href="https://seku.re/conflict-avoid-ddp" target="_blank">read this article</a> for best results. Then  <a href="', 'ddprodm');
        $message .= admin_url('plugins.php');
        $message .= __('">go to the plugins page</a> to deactivate and remove the plugins.', 'ddprodm');

        if (get_option('ddpdm_wl') !== 'enabled' && PAnD::is_admin_notice_active('disable-ddpdm-assistant-plugins-installed-warning-notice-forever')) {
            printf('<div data-dismissible="disable-ddpdm-assistant-plugins-installed-warning-notice-forever" class="%1$s"><p>%2$s</p></div>', esc_attr($class), wp_kses($message, ddpdm_allowed_html()));
        }
    }

    function ddpdm_add_meta_on_plugin_activation()
    {
        if (get_option('ddpdm_posts_saved') != 'yes') {
            $ddpdm_pages = get_posts(array('post_type' => 'page', 'post_status'      => 'publish' ));

            foreach ($ddpdm_pages as $ddpdm_page):
            wp_update_post($ddpdm_page);
            endforeach;

            $ddpdm_posts = get_posts(array('post_type' => 'post', 'post_status'      => 'publish' ));

            foreach ($ddpdm_posts as $ddpdm_post):
            wp_update_post($ddpdm_post);
            endforeach;

            $ddpdm_projects = get_posts(array('post_type' => 'project', 'post_status'      => 'publish' ));

            foreach ($ddpdm_projects as $ddpdm_project):
            wp_update_post($ddpdm_project);
            endforeach;

            update_option('ddpdm_posts_saved', 'yes');
        }
    }

    $list_of_assistant_plugins = array();

    if (file_exists(str_replace('ddprodm', 'falkor-assistant', plugin_dir_path(__FILE__)) . 'falkor-assistant.php')) {
        $list_of_assistant_plugins[] = 'falkor-assistant/falkor-assistant.php';
    }

    if (file_exists(str_replace('ddprodm', 'jackson-assistant', plugin_dir_path(__FILE__)) . 'jackson-assistant.php')) {
        $list_of_assistant_plugins[] = 'jackson-assistant/jackson-assistant.php';
    }

    if (file_exists(str_replace('ddprodm', 'mermaid-divi', plugin_dir_path(__FILE__)) . 'mermaid-divi.php')) {
        $list_of_assistant_plugins[] = 'mermaid-divi/mermaid-divi.php';
    }

    if (file_exists(str_replace('ddprodm', 'mozart-assistant', plugin_dir_path(__FILE__)) . 'mozart-assistant.php')) {
        $list_of_assistant_plugins[] = 'mozart-assistant/mozart-assistant.php';
    }

    if (file_exists(str_replace('ddprodm', 'pegasus-assistant', plugin_dir_path(__FILE__)) . 'pegasus-assistant.php')) {
        $list_of_assistant_plugins[] = 'pegasus-assistant/pegasus-assistant.php';
    }

    if (file_exists(str_replace('ddprodm', 'pixie-assistant', plugin_dir_path(__FILE__)) . 'pixie-assistant.php')) {
        $list_of_assistant_plugins[] = 'pixie-assistant/pixie-assistant.php';
    }

    if (file_exists(str_replace('ddprodm', 'unicorn-assistant', plugin_dir_path(__FILE__)) . 'unicorn-assistant.php')) {
        $list_of_assistant_plugins[] = 'unicorn-assistant/unicorn-assistant.php';
    }

    if (file_exists(str_replace('ddprodm', 'venus-assistant', plugin_dir_path(__FILE__)) . 'venus-assistant.php')) {
        $list_of_assistant_plugins[] = 'venus-assistant/venus-assistant.php';
    }

    if (!empty($list_of_assistant_plugins) && get_option('ddpdm_subscription_cancelled') == 'no') {
        // echo 'NOT EMPTY';
        add_action('admin_notices', 'ddprodm_assistant_plugins_installed_admin_notice__warning');
        // deactivate_plugins($list_of_assistant_plugins);

        if (get_option('ddpdm_posts_saved') != 'yes') {
            ddpdm_add_meta_on_plugin_activation();
        }
    }

    if (!get_option('ddpdm_hide_menu')) {
        add_option('ddpdm_hide_menu', 'disabled');
    }

    if (!get_option('ddpdm_hide_customizer')) {
        add_option('ddpdm_hide_customizer', 'disabled');
    }

    // hide premade divi layouts
    if (get_option('ddpdm_wl') == 'enabled') {
        if (get_option('ddpdm_hide_premade') == 'enabled') {
            add_action('wp_head', 'ddpdm_hide_premade_function');
            add_action('admin_head', 'ddpdm_hide_premade_function');
        }
    }

    // hide View details for WL

    if (get_option('ddpdm_wl') == 'enabled') {
        add_action('admin_head', 'ddpdm_hide_view_details_function');
    }

    function ddpdm_hide_view_details_function()
    {
        echo '<style>body.wp-admin tr[data-plugin="ddprodm/ddprodm.php"] .open-plugin-details-modal {display: none !important;}</style>';
    }


    function ddpdm_hide_premade_function()
    {
        echo '<style>
       body.wp-admin .et-fb-main-settings--load_layout .et-pb-options-tabs-links li.et-pb-new-module, body.wp-admin .et-fb-main-settings--load_layout div.et-pb-all-modules-tab{display:none !important;}
       body.wp-admin .et-fb-main-settings--load_layout div.et-pb-all-modules-tab {opacity: 0 !important;}
       .et-fb-main-settings--load_layout li.et-fb-settings-options_tab_modules_all {display:none !important;}
      </style>';
        echo "<script>jQuery(document).ready(function($) {
        $(document).on('mouseup', '.et-pb-layout-buttons-load', function() {
            $('div.et-pb-all-modules-tab').attr('style', 'display:none !important; opacity: 0;');
                   setTimeout(function() {
                    var tabbar = $('.et-pb-saved-modules-switcher');
                        if (tabbar.length) {
                            $('li.et-pb-new-module').remove();
                            setInterval(function(){
                                if(!$('li[data-open_tab=et-pb-existing_pages-tab]').hasClass('et-pb-options-tabs-links-active')) {
                                    $('li[data-open_tab=et-pb-saved-modules-tab] a').click();

                                    setTimeout(function() {
                                   $('div.et-pb-all-modules-tab').attr('style', 'display:block !important; opacity: 1 !important;');
                                    }, 200);
                                }
                            }, 2000);

                        }

                    }, 200);

    });
    setInterval(function(){
      var tabbar_vb = $('.et-fb-main-settings--load_layout .et-fb-settings-tabs-nav');
                    if (tabbar_vb.length) {

                                if(!$('li.et-fb-settings-options_tab_existing_pages').hasClass('et-fb-settings-tabs-nav-item--active')) {
                                    $('li.et-fb-settings-options_tab_modules_library').addClass('et-fb-settings-tabs-nav-item--active');
                                   $('li.et-fb-settings-options_tab_modules_library a')[0].click();
                                  $(this).parents('#et-fb-settings-column').addClass('et-fb-modal-settings--modules_library').removeClass('et-fb-modal-settings--modules_all ');
                                   // $('div.et-pb-all-modules-tab').show();
                                }

                    }
         }, 500);
 }); </script>";
    }


    //======================================================================
    // For ajax get and set options
    //======================================================================

    function ddpdm_get_option()
    {
        echo esc_attr(get_option('ddpdm_enable'));
        die();
    }

    function ddpdm_get_option_subscription()
    {
        echo esc_attr(get_option('ddpdm_subscription_cancelled'));
        die();
    }

    function ddpdm_get_option_wl()
    {
        echo esc_attr(get_option('ddpdm_wl'));
        die();
    }

    function ddpdm_get_option_ddpdm_plugin_setting_tab_position()
    {
        echo esc_attr(get_option('ddpdm_plugin_setting_tab_position'));
        die();
    }

    function ddpdm_update_option()
    {
        // NONCE VERIFICATION
        if (!isset($_POST['ddpdm_nonce']) || !wp_verify_nonce(sanitize_key($_POST['ddpdm_nonce']), 'ddpdm-main-nonce')) {
            die();
        }

        if (isset($_POST['ddpdm_option']) && isset($_POST['ddpdm_option_val'])) {
            update_option(sanitize_text_field($_POST['ddpdm_option']), wp_kses($_POST['ddpdm_option_val'], ddpdm_allowed_html()));
        }
    }

    function ddpdm_get_plugin_activation_state()
    {
        // NONCE VERIFICATION
        if (!isset($_POST['ddpdm_nonce']) || !wp_verify_nonce(sanitize_key($_POST['ddpdm_nonce']), 'ddpdm-main-nonce')) {
            die();
        }

        if (isset($_GET['plugin_name'])) {
            $plugin_name = sanitize_text_field($_GET['plugin_name']) . '_assistant_activated';
            echo esc_html(get_option($plugin_name));
        }

        die();
    }


    if (is_admin()) {
        add_action('wp_ajax_ddpdm_update_option', 'ddpdm_update_option', 10, 2);
        add_action('wp_ajax_ddpdm_get_option', 'ddpdm_get_option', 9, 1);
        add_action('wp_ajax_ddpdm_get_option_subscription', 'ddpdm_get_option_subscription', 9, 1);
        add_action('wp_ajax_ddpdm_get_plugin_activation_state', 'ddpdm_get_plugin_activation_state', 8, 1);
        add_action('wp_ajax_ddpdm_import_posts', 'ddpdm_import_posts', 5, 1);
        add_action('wp_ajax_ddpdm_import_featured_image', 'ddpdm_import_featured_image', 3, 1);
        add_action('wp_ajax_ddpdm_show_featured_image', 'ddpdm_show_featured_image', 2, 1);
    }

    add_action('wp_ajax_ddpdm_get_option_ddpdm_plugin_setting_tab_position', 'ddpdm_get_option_ddpdm_plugin_setting_tab_position', 9, 1);

    if (get_option('ddpdm_enable') == 'enabled') {

    /* Theme Builder */

        function ddpdm_for_theme_builder_page($hook_suffix)
        {
            if ($hook_suffix == 'divi_page_et_theme_builder') {
                wp_register_style('ddpdm-tb-admin', plugins_url('css/ddpdm-tb-admin.css', __FILE__), array(), '5.2.0', 'all');
                wp_enqueue_style('ddpdm-tb-admin');

                wp_enqueue_script('ddpdm-tb-admin', plugins_url('js/ddpdm-tb-admin.js', __FILE__), array(), '5.2.0', 'false');
            }
        }

        if (get_option('ddpdm_wl') !== 'enabled') {
            add_action('admin_enqueue_scripts', 'ddpdm_for_theme_builder_page');
        }


        function ddpdm_set_filesystem()
        {
            global $wp_filesystem;

            // add_filter( 'filesystem_method', array( 'replace_filesystem_method' ) );
            WP_Filesystem();

            return $wp_filesystem;
        }

        //======================================================================
        // UPLOAD IMAGES
        //======================================================================

        function ddpdm_upload_images($images)
        {
            $filesystem = ddpdm_set_filesystem();

            foreach ($images as $key => $image) {
                $basename    = sanitize_file_name(wp_basename($image['url']));
                $attachments = get_posts(array(
                'posts_per_page' => -1,
                'post_type'      => 'attachment',
                'meta_key'       => '_wp_attached_file',
                'meta_value'     => pathinfo($basename, PATHINFO_FILENAME),
                'meta_compare'   => 'LIKE',
            ));
                $id = 0;
                $url = '';

                // Avoid duplicates.
                if (! is_wp_error($attachments) && ! empty($attachments)) {
                    foreach ($attachments as $attachment) {
                        $attachment_url = wp_get_attachment_url($attachment->ID);
                        $file           = get_attached_file($attachment->ID);
                        $filename       = sanitize_file_name(wp_basename($file));

                        // Use existing image only if the content matches.
                        if ($filesystem->get_contents($file) === base64_decode($image['encoded'])) {
                            $id = isset($image['id']) ? $attachment->ID : 0;
                            $url = $attachment_url;

                            break;
                        }
                    }
                }

                // Create new image.
                if (empty($url)) {
                    $temp_file = wp_tempnam();
                    $filesystem->put_contents($temp_file, base64_decode($image['encoded']));
                    $filetype = wp_check_filetype_and_ext($temp_file, $basename);

                    // Avoid further duplicates if the proper_file name match an existing image.
                    if (isset($filetype['proper_filename']) && $filetype['proper_filename'] !== $basename) {
                        if (isset($filename) && $filename === $filetype['proper_filename']) {
                            // Use existing image only if the basenames and content match.
                            if ($filesystem->get_contents($file) === $filesystem->get_contents($temp_file)) {
                                $filesystem->delete($temp_file);
                                continue;
                            }
                        }
                    }

                    $file = array(
                    'name'     => $basename,
                    'tmp_name' => $temp_file,
                );
                    $upload = media_handle_sideload($file, 0);

                    if (! is_wp_error($upload)) {
                        // Set the replacement as an id if the original image was set as an id (for gallery).
                        $id = isset($image['id']) ? $upload : 0;
                        $url = wp_get_attachment_url($upload);
                    } else {
                        // Make sure the temporary file is removed if media_handle_sideload didn't take care of it.
                        $filesystem->delete($temp_file);
                    }
                }

                // Only declare the replace if a url is set.
                if ($id > 0) {
                    $images[$key]['replacement_id'] = $id;
                }

                if (! empty($url)) {
                    $images[$key]['replacement_url'] = $url;
                }

                unset($url);
            }

            return $images;
        }

        //======================================================================
        // REPLACE IMAGES URL
        //======================================================================

        function ddpdm_replace_image_url($subject, $image)
        {
            if (isset($image['replacement_id']) && isset($image['id'])) {
                $search      = $image['id'];
                $replacement = $image['replacement_id'];
                $subject     = preg_replace("/(gallery_ids=.*){$search}(.*\")/", "\${1}{$replacement}\${2}", $subject);
            }

            if (isset($image['url']) && isset($image['replacement_url']) && $image['url'] !== $image['replacement_url']) {
                $search      = $image['url'];
                $replacement = $image['replacement_url'];
                $subject     = str_replace($search, $replacement, $subject);
            }

            return $subject;
        }

        function ddpdm_replace_images_urls($images, $data)
        {
            foreach ($data as $post_id => &$post_data) {
                foreach ($images as $image) {
                    if (is_array($post_data)) {
                        foreach ($post_data as $post_param => &$param_value) {
                            if (! is_array($param_value)) {
                                $data[ $post_id ][ $post_param ] = ddpdm_replace_image_url($param_value, $image);
                            }
                        }
                        unset($param_value);
                    } else {
                        $data[ $post_id ] = ddpdm_replace_image_url($post_data, $image);
                    }
                }
            }
            unset($post_data);

            return $data;
        }

        function ddpdm_temp_file($id, $group, $temp_file = false)
        {
            $temp_files = get_option('_et_core_portability_temp_files', array());

            if (! isset($temp_files[$group])) {
                $temp_files[$group] = array();
            }

            if (isset($temp_files[$group][$id]) && file_exists($temp_files[$group][$id])) {
                return $temp_files[$group][$id];
            }

            $temp_file = $temp_file ? $temp_file : wp_tempnam();
            $temp_files[$group][$id] = $temp_file;

            update_option('_et_core_portability_temp_files', $temp_files, false);

            return $temp_file;
        }


        function ddpdm_maybe_paginate_images($images, $method, $timestamp)
        {
            et_core_nonce_verified_previously();

            /**
             * Filters whether or not images in the file being imported should be paginated.
             *
             * @since 3.0.99
             *
             * @param bool $paginate_images Default `true`.
             */
            $paginate_images = apply_filters('et_core_portability_paginate_images', true);

            if ($paginate_images && count($images) > 5) {
                $images = $method($images);
            } else {
                $images = $method($images);
            }
            return $images;
        }

        function ddpdm_get_timestamp()
        {
            et_core_nonce_verified_previously();

            return isset($_POST['timestamp']) && ! empty($_POST['timestamp']) ? sanitize_text_field($_POST['timestamp']) : current_time('timestamp');
        }

        //======================================================================
        // SAVE TO DIVI LIBRALY
        //======================================================================

        function ddpdm_import_posts($posts)
        {

        // NONCE VERIFICATION
            if (!isset($_POST['ddpdm_nonce']) || !wp_verify_nonce(sanitize_key($_POST['ddpdm_nonce']), 'ddpdm-main-nonce')) {
                return;
                die();
            }

            global $wpdb;
            session_start();

            if (!function_exists('post_exists')) {
                require_once(ABSPATH . 'wp-admin/includes/post.php');
            }

            if (!get_option('ddpdm_post_id_for_image')) {
                add_option('ddpdm_post_id_for_image', '');
            }

            $imported = array();

            if (isset($_POST['posts'])) {
                $posts_raw = $_POST['posts']; // phpcs:ignore
            } 
            else {
                return;
            }


            if (empty($posts_raw)) {
                //echo 'empty posts raw';
                return;
            }

            $posts = str_replace('\\"', '"', $posts_raw);
            $posts = str_replace('\\\\', '\\', $posts);
            $posts = str_replace("\'", "'", $posts);
            $posts = html_entity_decode($posts, ENT_COMPAT, 'UTF-8');
            $posts = json_decode($posts, true);

            if (empty($posts)) {
                return;
            }


            $posts_data = $posts['data'];
            // Upload images and replace current urls.
            if (isset($posts['images'])) {
                $posts_images = $posts['images'];
                $timestamp = ddpdm_get_timestamp();
                $new_images = ddpdm_maybe_paginate_images((array) $posts_images, 'ddpdm_upload_images', $timestamp);
                $posts_data = ddpdm_replace_images_urls($new_images, $posts_data);
            }

            foreach ($posts_data as $old_post_id => $post) {
                if (isset($post['post_status']) && 'auto-draft' === $post['post_status']) {
                    continue;
                }

                $post_exists = post_exists($post['post_title']);

                // Make sure the post is published and stop here if the post exists.
                if ($post_exists && get_post_type($post_exists) == $post['post_type']) {
                    if ('publish' == get_post_status($post_exists)) {
                        $imported[$post_exists] = $post['post_title'];
                        //$_SESSION['ddpdm_post_id_for_image'] = $post_exists; //echo 'SET $_SESSION: '.$_SESSION['ddpdm_post_id_for_image'];
                        update_option('ddpdm_post_id_for_image', $post_exists);
                        $time = current_time('mysql');

                        wp_update_post(
                            array(
                            'ID'            => $post_exists, // ID of the post to update
                            'post_date'     => $time,
                            'post_date_gmt' => get_gmt_from_date($time)
                        )
                        );
                        continue;
                    }
                }

                if (isset($post['ID'])) {
                    $post['import_id'] = $post['ID'];
                    unset($post['ID']);
                }


                $post['post_author'] = (int) get_current_user_id();

                $post['post_date'] = current_time('mysql');

                $post['post_date_gmt'] = current_time('mysql', 1);

                // Insert or update post.
                $post_id = wp_insert_post($post, true);

                if (!$post_id || is_wp_error($post_id)) {
                    continue;
                }

                if (!isset($post['terms'])) {
                    $post['terms'] = array();
                }

                $post['terms'][] = array(
                'name' => 'Divi Den',
                'slug' => 'divi-den',
                'taxonomy' => 'layout_category',
                'parent' => 0,
                'description' => ''
            );

                // Insert and set terms.
                if (count($post['terms']) > 0) {
                    $processed_terms = array();

                    foreach ($post['terms'] as $term) {
                        if (empty($term['parent'])) {
                            $parent = 0;
                        } else {
                            $parent = term_exists($term['name'], $term['taxonomy'], $term['parent']);

                            if (is_array($parent)) {
                                $parent = $parent['term_id'];
                            }
                        }

                        if (!$insert = term_exists($term['name'], $term['taxonomy'], $term['parent'])) {
                            $insert = wp_insert_term($term['name'], $term['taxonomy'], array(
                            'slug' => $term['slug'],
                            'description' => $term['description'],
                            'parent' => intval($parent)
                        ));
                        }

                        if (is_array($insert) && !is_wp_error($insert)) {
                            $processed_terms[$term['taxonomy']][] = $term['slug'];
                        }
                    }

                    // Set post terms.
                    foreach ($processed_terms as $taxonomy => $ids) {
                        wp_set_object_terms($post_id, $ids, $taxonomy);
                    }
                }

                // Insert or update post meta.
                if (isset($post['post_meta']) && is_array($post['post_meta'])) {
                    foreach ($post['post_meta'] as $meta_key => $meta) {
                        $meta_key = sanitize_text_field($meta_key);

                        if (count($meta) < 2) {
                            $meta = wp_kses_post($meta[0]);
                        } else {
                            $meta = array_map('wp_kses_post', $meta);
                        }

                        update_post_meta($post_id, $meta_key, $meta);
                    }
                }

                $imported[$post_id] = $post['post_title'];
            }

            if (!empty($post_id) && $post_id !== 0) {
                //$_SESSION['ddpdm_post_id_for_image'] = $post_id; //echo 'SET $_SESSION: '.$_SESSION['ddpdm_post_id_for_image'];
                update_option('ddpdm_post_id_for_image', $post_id);
            }

            return $imported;

            die();
        }


        function ddpdm_media_file_already_exists($filename)
        {
            global $wpdb;
            //  $query = $wpdb->prepare("SELECT post_id FROM {$wpdb->postmeta} WHERE meta_value LIKE %s", '%/$filename');

            if ($wpdb->get_var($wpdb->prepare("SELECT post_id FROM {$wpdb->postmeta} WHERE meta_value LIKE %s", '%/$filename'))) {
                return $wpdb->get_var($wpdb->prepare("SELECT post_id FROM {$wpdb->postmeta} WHERE meta_value LIKE %s", '%/$filename'));
            }

            return 0;
        }

        //======================================================================
        // ADD FEATURED IMAGE
        //======================================================================
        function ddpdm_import_featured_image($ddpdm_featured_image)
        {
            global $wpdb;
            session_start();

            // NONCE VERIFICATION
            if (!isset($_POST['ddpdm_nonce']) || !wp_verify_nonce(sanitize_key($_POST['ddpdm_nonce']), 'ddpdm-main-nonce')) {
                exit();
            }

            if (isset($_POST['ddpdm_featured_image'])) {
                $ddpdm_featured_image = sanitize_text_field($_POST['ddpdm_featured_image']);
            } else {
                return;
            }

            if (isset($_SESSION['ddpdm_post_id_for_image'])) {
                $ddpdm_post_id_for_featured_image = $_SESSION['ddpdm_post_id_for_image'];
            } else {
                $ddpdm_post_id_for_featured_image = get_option('ddpdm_post_id_for_image');
            }
            if (empty($ddpdm_featured_image) || empty($ddpdm_post_id_for_featured_image)) {
                return;
            }

            if (!function_exists('post_exists')) {
                require_once(ABSPATH . 'wp-admin/includes/post.php');
            }

            $ddpdm_post_title = strstr($ddpdm_featured_image, 'http', true);
            $ddpdm_image_link = str_replace($ddpdm_post_title, "", $ddpdm_featured_image);
            $ddpdm_post_title = sanitize_file_name($ddpdm_post_title);
            $ddpdm_filename = $ddpdm_post_title.'-featured-image-ddp.jpg';

            $post_id =  $ddpdm_post_id_for_featured_image;


            if ($post_id) {
                if (ddpdm_media_file_already_exists($ddpdm_filename) === 0) {
                    $ddpdm_upload_file = wp_upload_bits($ddpdm_filename, null, @file_get_contents($ddpdm_image_link));
                    if (!$ddpdm_upload_file['error']) {
                        //if succesfull insert the new file into the media library (create a new attachment post type)
                        $ddpdm_wp_filetype = wp_check_filetype($ddpdm_filename, null);
                        $ddpdm_attachment = array(
                'post_mime_type' => $ddpdm_wp_filetype['type'],
                'post_parent' => $post_id,
                'post_title' => preg_replace('/\.[^.]+$/', '', $ddpdm_filename),
                'post_content' => '',
                'post_status' => 'inherit'
              );
                        //wp_insert_attachment( $ddpdm_attachment, $ddpdm_filename, $parent_post_id );
                        $ddpdm_attachment_id = wp_insert_attachment($ddpdm_attachment, $ddpdm_upload_file['file'], $post_id);
                        if (!is_wp_error($ddpdm_attachment_id)) {
                            //if attachment post was successfully created, insert it as a thumbnail to the post $post_id
                            require_once(ABSPATH . "wp-admin" . '/includes/image.php');
                            //wp_generate_attachment_metadata( $ddpdm_attachment_id, $file ); for images
                            $ddpdm_attachment_data = wp_generate_attachment_metadata($ddpdm_attachment_id, $ddpdm_upload_file['file']);
                            wp_update_attachment_metadata($ddpdm_attachment_id, $ddpdm_attachment_data);
                            set_post_thumbnail($post_id, $ddpdm_attachment_id);
                        }
                    }
                } else {
                    set_post_thumbnail($post_id, ddpdm_media_file_already_exists($ddpdm_filename));
                }
            }

            die();
        } //ddpdm_import_featured_image($ddpdm_featured_image)



        //======================================================================
        // SHOW FEATURED IMAGE
        //======================================================================
        function ddpdm_show_featured_image($ddpdm_title_image)
        {

        // NONCE VERIFICATION
            if (!isset($_POST['ddpdm_nonce']) || !wp_verify_nonce(sanitize_key($_POST['ddpdm_nonce']), 'ddpdm-main-nonce')) {
                die();
            }


            global $wpdb;

            if (isset($_POST['ddpdm_title_image'])) {
                $ddpdm_title_image = sanitize_text_field($_POST['ddpdm_title_image']);
            } else {
                return;
            }

            if (empty($ddpdm_title_image)) {
                //echo 'empry posts raw';
                return;
            }

            if (!function_exists('post_exists')) {
                require_once(ABSPATH . 'wp-admin/includes/post.php');
            }


            $page = get_page_by_title(html_entity_decode($ddpdm_title_image, ENT_COMPAT, 'UTF-8'), OBJECT, 'et_pb_layout');

            if (isset($page)) {
                $post_id =  $page->ID;
            }

            if (isset($post_id)) {
                if (has_post_thumbnail($post_id)) {
                    $image = wp_get_attachment_image_src(get_post_thumbnail_id($post_id), 'single-post-thumbnail');
                    echo esc_html($ddpdm_title_image)."|".esc_html($image[0]);
                }
            }

            die();
        } //ddpdm_show_featured_image

        //======================================================================
        // CHECK DIVI GLOBAL TEMPLATES
        //======================================================================

        function ddpdm_check_divi_global_templates()
        {
            $layouts = et_theme_builder_get_template_layouts();

            if (isset($layouts['et_header_layout']) && $layouts['et_header_layout']['override'] === true) {
                $post = get_post($layouts['et_header_layout']['id']);
                ddpdm_register_css($post);
                ddpdm_register_js($post);
            }

            if (isset($layouts['et_body_layout']) && $layouts['et_body_layout']['override'] === true) {
                $post = get_post($layouts['et_body_layout']['id']);
                ddpdm_register_css($post);
                ddpdm_register_js($post);
            }

            if (isset($layouts['et_footer_layout']) && $layouts['et_footer_layout']['override'] === true) {
                $post = get_post($layouts['et_footer_layout']['id']);
                ddpdm_register_css($post);
                ddpdm_register_js($post);
            }
        }


        // let's check the Divi's version

        $divi_theme = wp_get_theme('Divi');

        $diviVersion = $divi_theme->get('Version')[0];

        if ((int)$diviVersion > 3) {
            add_action('wp_footer', 'ddpdm_check_divi_global_templates');
            add_action('et_fb_enqueue_assets', 'ddpdm_check_divi_global_templates', 1);
        }

        //======================================================================
        // ON POST SAVE
        //======================================================================

        add_action('save_post', 'ddpdm_save_post_function', 10, 3);


        function ddpdm_save_post_function($post_id, $post, $update)
        {
            delete_post_meta($post_id, 'ddp-css-falkor');
            delete_post_meta($post_id, 'ddp-css-jackson');
            delete_post_meta($post_id, 'ddp-css-mermaid');
            delete_post_meta($post_id, 'ddp-css-mozart');
            delete_post_meta($post_id, 'ddp-css-pegasus');
            delete_post_meta($post_id, 'ddp-css-pixie');
            delete_post_meta($post_id, 'ddp-css-unicorn');
            delete_post_meta($post_id, 'ddp-css-venus');
            delete_post_meta($post_id, 'ddp-css-sigmund');
            delete_post_meta($post_id, 'ddp-css-impi');
            delete_post_meta($post_id, 'ddp-css-jamie');
            delete_post_meta($post_id, 'ddp-css-coco');
            delete_post_meta($post_id, 'ddp-css-demo');
            delete_post_meta($post_id, 'ddp-css-diana');
            delete_post_meta($post_id, 'ddp-css-freddie');
            delete_post_meta($post_id, 'ddp-css-tina');
            delete_post_meta($post_id, 'ddp-css-ragnar');
            delete_post_meta($post_id, 'ddp-css-grace');

            $post_content = get_post_field('post_content', $post_id);

            // Falkor

            if (strpos($post_content, 'falkor')) {
                add_post_meta($post_id, 'ddp-css-falkor', 'animated-lines');
            }


            if (strpos($post_content, 'falkor_blog')) {
                add_post_meta($post_id, 'ddp-css-falkor', 'falkor-blog');
            }


            if (preg_match('/_class="blurb.{3,}f"/', $post_content)) {
                add_post_meta($post_id, 'ddp-css-falkor', 'falkor-blurb');
            }


            if (preg_match('/_class="call_to_action_._f/', $post_content) || preg_match('/_class="falkor-cta-."/', $post_content) || strpos($post_content, 'call_to_action_1_f')) {
                add_post_meta($post_id, 'ddp-css-falkor', 'falkor-cta');
            }


            if (preg_match('/_class="contact_._falkor/', $post_content)) {
                add_post_meta($post_id, 'ddp-css-falkor', 'falkor-contact-forms');
            }


            if (strpos($post_content, 'falkor-contact-page')) {
                add_post_meta($post_id, 'ddp-css-falkor', 'falkor-contact-page');
            }


            if (preg_match('/_class="content.{3,}f"/', $post_content) || strpos($post_content, 'content_2_f') || strpos($post_content, 'content_8_f')) {
                add_post_meta($post_id, 'ddp-css-falkor', 'falkor-content');
            }


            if (preg_match('/_class="footer.{3,}f"/', $post_content)) {
                add_post_meta($post_id, 'ddp-css-falkor', 'falkor-footers');
            }


            if (preg_match('/_class="headers.{3}f"/', $post_content) || strpos($post_content, 'header_') || strpos($post_content, 'demo_header')) {
                add_post_meta($post_id, 'ddp-css-falkor', 'falkor-headers');
            }


            if (preg_match('/_class="home.{3,}f"/', $post_content) || strpos($post_content, 'falkor_home') || strpos($post_content, 'falkor-home')) {
                add_post_meta($post_id, 'ddp-css-falkor', 'falkor-home-pages');
            }


            if (preg_match('/_class="contentpage.{3,}f"/', $post_content) || preg_match('/_class="blurb_services.{3,}f"/', $post_content) || strpos($post_content, 'falkor_logos_team')) {
                add_post_meta($post_id, 'ddp-css-falkor', 'falkor-inside-pages');
            }


            if (strpos($post_content, 'falkor_logos_')) {
                add_post_meta($post_id, 'ddp-css-falkor', 'falkor-logos');
            }


            if (strpos($post_content, 'falkor_numers_')) {
                add_post_meta($post_id, 'ddp-css-falkor', 'falkor-numbers');
            }


            if (preg_match('/_class="person_._falkor"/', $post_content) || preg_match('/_class="person.{3,}f"/', $post_content) || strpos($post_content, 'person_4_f')) {
                add_post_meta($post_id, 'ddp-css-falkor', 'falkor-person');
            }


            if (strpos($post_content, 'falkor-pt') || strpos($post_content, 'pricing_tabel_falkor')) {
                add_post_meta($post_id, 'ddp-css-falkor', 'falkor-pricing-table');
            }


            if (strpos($post_content, 'falkor_slider')) {
                add_post_meta($post_id, 'ddp-css-falkor', 'falkor-slider');
            }


            if (strpos($post_content, 'falkor-testimonial')) {
                add_post_meta($post_id, 'ddp-css-falkor', 'falkor-testimonials');
            }

            // Jackson

            if (strpos($post_content, 'error_404_page')) {
                add_post_meta($post_id, 'ddp-css-jackson', 'jackson-404');
            }


            if (strpos($post_content, 'seo_about_')) {
                add_post_meta($post_id, 'ddp-css-jackson', 'jackson-about');
            }


            if (strpos($post_content, 'author-info ')) {
                add_post_meta($post_id, 'ddp-css-jackson', 'jackson-author');
            }


            if (strpos($post_content, 'seo_blog')) {
                add_post_meta($post_id, 'ddp-css-jackson', 'jackson-blog');
            }


            if (strpos($post_content, 'seo-case-study')) {
                add_post_meta($post_id, 'ddp-css-jackson', 'jackson-case-study');
            }


            if (strpos($post_content, 'cat_page_content')) {
                add_post_meta($post_id, 'ddp-css-jackson', 'jackson-category-page');
            }


            if (strpos($post_content, 'seo-contact')) {
                add_post_meta($post_id, 'ddp-css-jackson', 'jackson-contact');
            }

            if (strpos($post_content, 'seo_content_') || strpos($post_content, 'seo-sidebar-list')) {
                add_post_meta($post_id, 'ddp-css-jackson', 'jackson-content');
            }

            if (strpos($post_content, 'seo_footer')) {
                add_post_meta($post_id, 'ddp-css-jackson', 'jackson-footer');
            }


            if (strpos($post_content, 'seo_home')) {
                add_post_meta($post_id, 'ddp-css-jackson', 'jackson-home');
            }


            if (strpos($post_content, 'seo_how_we_work_')) {
                add_post_meta($post_id, 'ddp-css-jackson', 'jackson-how-we-work');
            }


            if (strpos($post_content, 'seo_services')) {
                add_post_meta($post_id, 'ddp-css-jackson', 'jackson-services');
            }

            if (strpos($post_content, 'seo_team_')) {
                add_post_meta($post_id, 'ddp-css-jackson', 'jackson-team');
            }

            // Mermaid

            if (preg_match('/_class="blog.*_M/', $post_content)) {
                add_post_meta($post_id, 'ddp-css-mermaid', 'mermaid-blog');
            }

            if (preg_match('/_class="blurbs.{3,}M/', $post_content) || preg_match('/_class="blurb.{3,}M"/', $post_content)) {
                add_post_meta($post_id, 'ddp-css-mermaid', 'mermaid-blurbs');
            }

            if (preg_match('/_class="contact_form.{3,}M/', $post_content)) {
                add_post_meta($post_id, 'ddp-css-mermaid', 'mermaid-contact=form');
            }

            if (preg_match('/_class="content.{3,}M/', $post_content)) {
                add_post_meta($post_id, 'ddp-css-mermaid', 'mermaid-content');
            }

            if (strpos($post_content, 'footer_top')) {
                add_post_meta($post_id, 'ddp-css-mermaid', 'mermaid-footer');
            }

            if (preg_match('/_class="list_style."/', $post_content)) {
                add_post_meta($post_id, 'ddp-css-mermaid', 'mermaid-lists');
            }

            if (preg_match('/_class="mask_._M/', $post_content)) {
                add_post_meta($post_id, 'ddp-css-mermaid', 'mermaid-masks');
            }

            if (strpos($post_content, 'super_size_button') ||  strpos($post_content, 'button_') || strpos($post_content, 'mermaid_button')) {
                add_post_meta($post_id, 'ddp-css-mermaid', 'mermaid-buttons');
            }

            if (strpos($post_content, 'showreel_section') || strpos($post_content, 'contact_map') || strpos($post_content, 'content_page_') || strpos($post_content, 'services_boxed')) {
                add_post_meta($post_id, 'ddp-css-mermaid', 'mermaid-pages');
            }

            if (preg_match('/_class="person.{2,}M/', $post_content)) {
                add_post_meta($post_id, 'ddp-css-mermaid', 'mermaid-persons');
            }

            if (preg_match('/_class="slider.{3,}M/', $post_content)) {
                add_post_meta($post_id, 'ddp-css-mermaid', 'mermaid-slider');
            }

            if (strpos($post_content, 'aboutM') || strpos($post_content, 'about_page_bonusM')) {
                add_post_meta($post_id, 'ddp-css-mermaid', 'mermaid-about-page');
            }

            // Mozart

            if (strpos($post_content, 'moz_about_')) {
                add_post_meta($post_id, 'ddp-css-mozart', 'mozart-about');
            }

            if (strpos($post_content, 'mozart_accountant')) {
                add_post_meta($post_id, 'ddp-css-mozart', 'mozart-accountant');
            }

            if (strpos($post_content, 'author-info')) {
                add_post_meta($post_id, 'ddp-css-mozart', 'mozart-author');
            }

            if (strpos($post_content, 'moz_simple_blog') || strpos($post_content, 'moz_blog')) {
                add_post_meta($post_id, 'ddp-css-mozart', 'mozart-blog');
            }

            if (strpos($post_content, 'cat_page_content')) {
                add_post_meta($post_id, 'ddp-css-mozart', 'mozart-category-page');
            }

            if (strpos($post_content, 'mozart_coach_')) {
                add_post_meta($post_id, 'ddp-css-mozart', 'mozart-coach');
            }

            if (strpos($post_content, 'mozart_conference_')) {
                add_post_meta($post_id, 'ddp-css-mozart', 'mozart-conference');
            }

            if (strpos($post_content, 'mozart_consult')) {
                add_post_meta($post_id, 'ddp-css-mozart', 'mozart-consulting');
            }

            if (strpos($post_content, 'moz_contact')) {
                add_post_meta($post_id, 'ddp-css-mozart', 'mozart-contact');
            }

            if (strpos($post_content, 'mozart_corporation')) {
                add_post_meta($post_id, 'ddp-css-mozart', 'mozart-corporation');
            }

            if (strpos($post_content, 'moz_dig_bus')) {
                add_post_meta($post_id, 'ddp-css-mozart', 'mozart-digital-business');
            }

            if (strpos($post_content, 'moz_services_top_blurb')) {
                add_post_meta($post_id, 'ddp-css-mozart', 'mozart-digital-business');
            }

            if (strpos($post_content, 'mozart_faq') || strpos($post_content, 'mazart_faq')) {
                add_post_meta($post_id, 'ddp-css-mozart', 'mozart-faq');
            }

            if (strpos($post_content, 'mozart_footer')) {
                add_post_meta($post_id, 'ddp-css-mozart', 'mozart-footer');
            }

            if (strpos($post_content, 'mozart_consult_header') || strpos($post_content, 'moz-header1')) {
                add_post_meta($post_id, 'ddp-css-mozart', 'mozart-header');
            }

            if (strpos($post_content, 'case_study_') || strpos($post_content, 'moz_content_page') || strpos($post_content, 'moz_video_section') || strpos($post_content, 'moz_services_') || strpos($post_content, 'moz_list_style')) {
                add_post_meta($post_id, 'ddp-css-mozart', 'mozart-inside');
            }

            if (strpos($post_content, 'mozart_investment')) {
                add_post_meta($post_id, 'ddp-css-mozart', 'mozart-investment');
            }

            if (strpos($post_content, 'mozart_law') || strpos($post_content, 'mozart_text_boxes')) {
                add_post_meta($post_id, 'ddp-css-mozart', 'mozart-law');
            }

            if (strpos($post_content, 'single_blog_page_content')) {
                add_post_meta($post_id, 'ddp-css-mozart', 'mozart-single-post');
            }

            if (strpos($post_content, 'mozart_start_up')) {
                add_post_meta($post_id, 'ddp-css-mozart', 'mozart-start-up');
            }

            if (strpos($post_content, 'moz_team_')) {
                add_post_meta($post_id, 'ddp-css-mozart', 'mozart-team');
            }

            //Pegasus
            if (strpos($post_content, 'pegasus_blog')) {
                add_post_meta($post_id, 'ddp-css-pegasus', 'pegasus-blog-pages');
                add_post_meta($post_id, 'ddp-css-pegasus', 'pegasus-blogs');
            }

            if (strpos($post_content, 'pegasus-blurb')) {
                add_post_meta($post_id, 'ddp-css-pegasus', 'pegasus-blurb');
            }

            if (strpos($post_content, 'pegasus-cta')) {
                add_post_meta($post_id, 'ddp-css-pegasus', 'pegasus-cta');
            }

            if (strpos($post_content, 'contact_page_') || strpos($post_content, 'contact-page')) {
                add_post_meta($post_id, 'ddp-css-pegasus', 'pegasus-contact-page');
            }

            if (strpos($post_content, 'pegasus-content')) {
                add_post_meta($post_id, 'ddp-css-pegasus', 'pegasus-content');
            }

            if (strpos($post_content, 'pegasus-footer')) {
                add_post_meta($post_id, 'ddp-css-pegasus', 'pegasus-footer');
            }

            if (strpos($post_content, 'pegasus_form')) {
                add_post_meta($post_id, 'ddp-css-pegasus', 'pegasus-forms');
            }

            if (strpos($post_content, 'pegasus_header')) {
                add_post_meta($post_id, 'ddp-css-pegasus', 'pegasus-headers');
            }

            if (strpos($post_content, 'pegasus-landscape-portfolio') || strpos($post_content, 'pegasus_agency_video') || strpos($post_content, 'pegasus_about_us') || strpos($post_content, 'pegasus_about_us2') || strpos($post_content, 'pegasus_team_landing')) {
                add_post_meta($post_id, 'ddp-css-pegasus', 'pegasus-pages');
            }

            if (strpos($post_content, 'pegasus_person')) {
                add_post_meta($post_id, 'ddp-css-pegasus', 'pegasus-persons');
            }

            if (strpos($post_content, 'pegasus_portfolio')) {
                add_post_meta($post_id, 'ddp-css-pegasus', 'pegasus-portfolio');
            }

            if (strpos($post_content, 'pegasus_pricing_tables')) {
                add_post_meta($post_id, 'ddp-css-pegasus', 'pegasus-pricing-tables');
            }

            if (strpos($post_content, 'pegasus_project_planner')) {
                add_post_meta($post_id, 'ddp-css-pegasus', 'pegasus-project-planner-page');
            }

            if (strpos($post_content, 'pegasus_slider')) {
                add_post_meta($post_id, 'ddp-css-pegasus', 'pegasus-sliders');
            }

            if (strpos($post_content, 'pegasus_tabs')) {
                add_post_meta($post_id, 'ddp-css-pegasus', 'pegasus-tabs');
            }

            if (strpos($post_content, 'pegasus-tstm')) {
                add_post_meta($post_id, 'ddp-css-pegasus', 'pegasus-testimonials');
            }

            // Pixie

            if (preg_match('/blog_._pixie/', $post_content)) {
                add_post_meta($post_id, 'ddp-css-pixie', 'pixie-blog');
            }

            if (strpos($post_content, 'pixie_blurb')) {
                add_post_meta($post_id, 'ddp-css-pixie', 'pixie-blurbs');
            }

            if (strpos($post_content, 'pixie-cta')) {
                add_post_meta($post_id, 'ddp-css-pixie', 'pixie-cta');
            }

            if (strpos($post_content, 'pixie-contact-basic-map')) {
                add_post_meta($post_id, 'ddp-css-pixie', 'pixie-contact-basic-map');
            }

            if (strpos($post_content, 'pixie-contact')) {
                add_post_meta($post_id, 'ddp-css-pixie', 'pixie-contact');
            }

            if (strpos($post_content, 'pixie-content')) {
                add_post_meta($post_id, 'ddp-css-pixie', 'pixie-content');
            }

            if (strpos($post_content, 'pixie-footer') || strpos($post_content, 'pixel-footer')) {
                add_post_meta($post_id, 'ddp-css-pixie', 'pixie-footer');
            }

            if (strpos($post_content, 'pixie-header')) {
                add_post_meta($post_id, 'ddp-css-pixie', 'pixie-headers');
            }

            if (strpos($post_content, 'pixie')) {
                add_post_meta($post_id, 'ddp-css-pixie', 'pixie-master');
            }

            if (strpos($post_content, 'pixie_numbers')) {
                add_post_meta($post_id, 'ddp-css-pixie', 'pixie-numbers');
            }

            if (strpos($post_content, 'pixie_person')) {
                add_post_meta($post_id, 'ddp-css-pixie', 'pixie-person');
            }

            if (strpos($post_content, 'portfolio_content') || strpos($post_content, 'portfolio_slider')) {
                add_post_meta($post_id, 'ddp-css-pixie', 'pixie-personal-portfolio');
                add_post_meta($post_id, 'ddp-css-pixie', 'pixie-project-page');
            }

            if (strpos($post_content, 'pixie_portfolio')) {
                add_post_meta($post_id, 'ddp-css-pixie', 'pixie-portfolio');
            }

            if (strpos($post_content, 'pricing_tables_pixie')) {
                add_post_meta($post_id, 'ddp-css-pixie', 'pixie-pricing-tables');
            }

            if (strpos($post_content, 'pixie_tabs')) {
                add_post_meta($post_id, 'ddp-css-pixie', 'pixie-tabs');
            }

            if (strpos($post_content, 'pixie_testimonials')) {
                add_post_meta($post_id, 'ddp-css-pixie', 'pixie-testimonials');
            }

            // Unicorn

            if (preg_match('/_class="blog_./', $post_content)) {
                add_post_meta($post_id, 'ddp-css-unicorn', 'unicorn-blog');
            }

            if (preg_match('/_class="blurb.{2,}/', $post_content)) {
                add_post_meta($post_id, 'ddp-css-unicorn', 'unicorn-blurbs');
            }

            if (preg_match('/_class="contact_./', $post_content)) {
                add_post_meta($post_id, 'ddp-css-unicorn', 'unicorn-contact-form');
                add_post_meta($post_id, 'ddp-css-unicorn', 'unicorn-contact-page');
            }

            if (preg_match('/_class="content.{1,}/', $post_content)) {
                add_post_meta($post_id, 'ddp-css-unicorn', 'unicorn-content');
            }

            if (preg_match('/_class="form_./', $post_content)) {
                add_post_meta($post_id, 'ddp-css-unicorn', 'unicorn-optin');
            }

            if (preg_match('/_class="features.{1,}/', $post_content)) {
                add_post_meta($post_id, 'ddp-css-unicorn', 'unicorn-feature');
            }

            if (preg_match('/_class="footer./', $post_content)) {
                add_post_meta($post_id, 'ddp-css-unicorn', 'unicorn-footer');
            }

            if (preg_match('/_class="header./', $post_content)) {
                add_post_meta($post_id, 'ddp-css-unicorn', 'unicorn-header');
            }

            if (preg_match('/_class="team.{1,}/', $post_content) || preg_match('/_class="team."/', $post_content)) {
                add_post_meta($post_id, 'ddp-css-unicorn', 'unicorn-person');
            }

            if (preg_match('/_class="price_table_./', $post_content)) {
                add_post_meta($post_id, 'ddp-css-unicorn', 'unicorn-pricing-tables');
            }

            if (preg_match('/_class="testimonial./', $post_content)) {
                add_post_meta($post_id, 'ddp-css-unicorn', 'unicorn-testimonials');
            }

            if (strpos($post_content, 'unicorn_about')) {
                add_post_meta($post_id, 'ddp-css-unicorn', 'unicorn-about-bonus');
            }


            // Venus

            if (preg_match('/_class="blog._venus/', $post_content)) {
                add_post_meta($post_id, 'ddp-css-venus', 'blog');
            }


            if (preg_match('/_class="blurb._venus/', $post_content)) {
                add_post_meta($post_id, 'ddp-css-venus', 'blurbs');
            }


            if (preg_match('/_class="contact_form._venus/', $post_content)) {
                add_post_meta($post_id, 'ddp-css-venus', 'contact');
            }


            if (preg_match('/_class="cta._venus/', $post_content)) {
                add_post_meta($post_id, 'ddp-css-venus', 'cta');
            }


            if (preg_match('/_class="faq._venus/', $post_content)) {
                add_post_meta($post_id, 'ddp-css-venus', 'faq');
            }


            if (preg_match('/_class="feature.-venus/', $post_content)) {
                add_post_meta($post_id, 'ddp-css-venus', 'features');
            }


            if (preg_match('/_class="header._venus/', $post_content)) {
                add_post_meta($post_id, 'ddp-css-venus', 'header');
            }


            if (preg_match('/_class="person.-venus/', $post_content)) {
                add_post_meta($post_id, 'ddp-css-venus', 'person');
            }


            if (preg_match('/_class="pricing-tables.-venus/', $post_content)) {
                add_post_meta($post_id, 'ddp-css-venus', 'pricing-tables');
            }


            if (preg_match('/_class="optin_module._venus/', $post_content)) {
                add_post_meta($post_id, 'ddp-css-venus', 'subscribe');
            }


            // Sigmund

            if (strpos($post_content, 'about_us1') || strpos($post_content, 'about_us2') || strpos($post_content, 'about_us3') || strpos($post_content, 'about_me1') || strpos($post_content, 'header-socialmedia') || strpos($post_content, 'about_me2') || strpos($post_content, 'cv-socialmedia')) {
                add_post_meta($post_id, 'ddp-css-sigmund', 'about-pages');
            }


            if (strpos($post_content, 'studio_blurbs') || strpos($post_content, 'skills_blurbs') || strpos($post_content, 'studio_blurbs') || strpos($post_content, 'job_Experience_blurbs') || strpos($post_content, 'counting_Blurbs') || strpos($post_content, 'timeline_process_blurbs') || strpos($post_content, 'sigmund_blurbs') || strpos($post_content, 'cute_circle_blurbs') || strpos($post_content, 'helpful_blurbs') || strpos($post_content, 'lovely_blurb') || strpos($post_content, 'Interests_blurbs') || strpos($post_content, 'contact_us3_growing_blurbs') || strpos($post_content, 'sigmund_blurbs_images_hover')) {
                add_post_meta($post_id, 'ddp-css-sigmund', 'blurbs');
            }

            if (strpos($post_content, 'contact_form_header') || strpos($post_content, 'pop_form_contact') || strpos($post_content, 'sigmund_blurbs_social_hover') || strpos($post_content, 'sigmund_hover_effect_article') || strpos($post_content, 'sigmund_pages_footer') || strpos($post_content, 'questions_header ') || strpos($post_content, 'contact_us1_blurbs') || strpos($post_content, 'get_in_touch_form') || strpos($post_content, 'contact_us3_growing_blurbs') || strpos($post_content, 'compact_cta') || strpos($post_content, 'studio_blurbs') || strpos($post_content, 'sigmun_make_jump_header') || strpos($post_content, 'sigmund_home2_big_pop_person') || strpos($post_content, 'contact_us_2_contact_team') || strpos($post_content, 'text_effect_slider')) {
                add_post_meta($post_id, 'ddp-css-sigmund', 'contact-pages');
            }

            if (strpos($post_content, 'pop_form_contact') || strpos($post_content, 'support_form')) {
                add_post_meta($post_id, 'ddp-css-sigmund', 'contact');
            }

            if (strpos($post_content, 'pop_form')) {
                add_post_meta($post_id, 'ddp-css-sigmund', 'forms');
            }

            if (strpos($post_content, 'sigmund_hover_effect') || strpos($post_content, 'sigmund_column_hover_effect') || strpos($post_content, 'sigmund_blurbs_images_hover') || strpos($post_content, 'blurb_4_header') || strpos($post_content, 'triangle_header') || strpos($post_content, 'image_split_header')  || strpos($post_content, 'animate_header') || strpos($post_content, 'our_office_header') || strpos($post_content, 'questions_header') || strpos($post_content, 'contact_form_header') || strpos($post_content, 'sigmund_say_hello_header')  || strpos($post_content, 'sigmun_make_jump_header')) {
                add_post_meta($post_id, 'ddp-css-sigmund', 'headers');
            }

            if (strpos($post_content, 'office_top_row') || strpos($post_content, 'our_office') || strpos($post_content, 'blurb_module_text') || strpos($post_content, 'map_form_contact')) {
                add_post_meta($post_id, 'ddp-css-sigmund', 'office');
            }

            if (strpos($post_content, 'engaging_person') || strpos($post_content, 'hello_person') || strpos($post_content, 'sweet_person_module') || strpos($post_content, 'big_pop_person') || strpos($post_content, 'sigmund_home2_big_pop_person')) {
                add_post_meta($post_id, 'ddp-css-sigmund', 'persons');
            }

            if (strpos($post_content, 'pleasing_portfolio') || strpos($post_content, 'pop_portfolio')) {
                add_post_meta($post_id, 'ddp-css-sigmund', 'portfolio');
            }

            if (strpos($post_content, 'sigmund_committed_content') || strpos($post_content, 'sigmund_home2_result_content')) {
                add_post_meta($post_id, 'ddp-css-sigmund', 'contents');
            }

            if (strpos($post_content, 'sigmund_showcase_cta') || strpos($post_content, 'sigmund_start_project_cta')) {
                add_post_meta($post_id, 'ddp-css-sigmund', 'cta');
            }

            if (strpos($post_content, 'pricing2_questions') || strpos($post_content, 'sigmund_boxey_faq')) {
                add_post_meta($post_id, 'ddp-css-sigmund', 'faq');
            }

            if (strpos($post_content, 'sigmund_logos_section')) {
                add_post_meta($post_id, 'ddp-css-sigmund', 'table-page1');
            }

            if (strpos($post_content, 'sigmund_landscape_pricing_tables') || strpos($post_content, 'sigmund_tall_pricing_tables')) {
                add_post_meta($post_id, 'ddp-css-sigmund', 'pricing-tables');
            }

            if (strpos($post_content, 'sigmund_big_options_content') || strpos($post_content, 'sigmund_pricing1_intro_content') || strpos($post_content, 'pricing2_questions') || strpos($post_content, 'sigmund_services_skills_blurbs')) {
                add_post_meta($post_id, 'ddp-css-sigmund', 'services-page1');
            }

            if (strpos($post_content, 'sigmund_cute_slider') || strpos($post_content, 'sigmund_team_text_effect_slider') || strpos($post_content, 'sigmund_text_effect_slider')) {
                add_post_meta($post_id, 'ddp-css-sigmund', 'team-page1');
            }

            if (strpos($post_content, 'sigmund_achieved_content') || strpos($post_content, 'sigmund_team3_engaging_person')) {
                add_post_meta($post_id, 'ddp-css-sigmund', 'team-page2');
            }

            if (strpos($post_content, 'intro_tabs')) {
                add_post_meta($post_id, 'ddp-css-sigmund', 'tabs');
            }

            if (strpos($post_content, 'blue_accordion')) {
                add_post_meta($post_id, 'ddp-css-sigmund', 'accordion');
            }

            if (strpos($post_content, 'Rated_testimonials') || strpos($post_content, 'incredible_testimonials')) {
                add_post_meta($post_id, 'ddp-css-sigmund', 'testimonials');
            }

            if (strpos($post_content, 'sigmund_pages_footer')) {
                add_post_meta($post_id, 'ddp-css-sigmund', 'footers');
            }

            if (strpos($post_content, 'sigmund_tailored_testimonails') || strpos($post_content, 'sigmund_pricing1_testimnoials') || strpos($post_content, 'sigmund_home2_testimonial')) {
                add_post_meta($post_id, 'ddp-css-sigmund', 'testimonials');
            }


            // Impi

            if (strpos($post_content, 'impi_3col_partner_header') || strpos($post_content, 'impi_question_header') || strpos($post_content, 'impi_next_here_header') || strpos($post_content, 'impi_ally_header') || strpos($post_content, 'impi_endorser_header') || strpos($post_content, 'impi_top_dog_header') || strpos($post_content, 'impi_about_me_question_header')) {
                add_post_meta($post_id, 'ddp-css-impi', 'headers');
            }

            if (strpos($post_content, 'impi_circle_click_testimonials') || strpos($post_content, 'impi_3_col_testimonails') || strpos($post_content, 'impi_trooper_testimonial') || strpos($post_content, 'impi_victor_testimonials')) {
                add_post_meta($post_id, 'ddp-css-impi', 'testimonials');
            }

            if (strpos($post_content, 'impi_blurbs') || strpos($post_content, 'impi_partner_benefits_blurbs') || strpos($post_content, 'impi_neat_circle_blurbs') || strpos($post_content, 'impi_all_plans_blurbs') || strpos($post_content, 'impi_patron_blurbs') || strpos($post_content, 'impi_work_with_blurbs') || strpos($post_content, 'impi_perks_blurbs') || strpos($post_content, 'impi_faq2_accordion')) {
                add_post_meta($post_id, 'ddp-css-impi', 'blurbs');
            }

            if (strpos($post_content, 'impi_pink_faq_accordion') || strpos($post_content, 'impi_pink_accordion') || strpos($post_content, 'impi_faq2_accordion')) {
                add_post_meta($post_id, 'ddp-css-impi', 'faq');
            }

            if (strpos($post_content, 'impi_fill_me_portfolio') || strpos($post_content, 'impi_warrior_slider_portfolio') || strpos($post_content, 'impi_champ_portfolio') || strpos($post_content, 'impi_about_me_portfolio')) {
                add_post_meta($post_id, 'ddp-css-impi', 'portfolio');
            }

            if (strpos($post_content, 'impi_person') || strpos($post_content, 'impi_box_slider_person') || strpos($post_content, 'impi_guardian_person')) {
                add_post_meta($post_id, 'ddp-css-impi', 'persons');
            }

            if (strpos($post_content, 'impi_home')) {
                add_post_meta($post_id, 'ddp-css-impi', 'home-pages');
            }

            if (strpos($post_content, 'impi_supporter_woo_products')) {
                add_post_meta($post_id, 'ddp-css-impi', 'products');
            }

            if (strpos($post_content, 'impi_services')) {
                add_post_meta($post_id, 'ddp-css-impi', 'service-pages');
            }

            if (strpos($post_content, 'side_by_side_blog') || strpos($post_content, 'impi_fill_up_blog') || strpos($post_content, 'impi_postcard_blog') || strpos($post_content, 'impi_timeline_blog')) {
                add_post_meta($post_id, 'ddp-css-impi', 'blogs');
            }

            if (strpos($post_content, 'impi_say_hello_form') || strpos($post_content, 'impi_get_in_touch_form') || strpos($post_content, 'impi_paladin_signup') || strpos($post_content, 'impi_tight_cta')) {
                add_post_meta($post_id, 'ddp-css-impi', 'forms');
            }

            if (strpos($post_content, 'impi_pro_pricing_table') || strpos($post_content, 'impi_box_pricing_tables') || strpos($post_content, 'impi_fill_up_pricing_tables') || strpos($post_content, 'impi_victor_pricing_tables')) {
                add_post_meta($post_id, 'ddp-css-impi', 'pricing-tables');
            }

            if (strpos($post_content, 'impi_slider') || strpos($post_content, 'impi_heroine_product_slider') || strpos($post_content, 'impi_endorser_slider') || strpos($post_content, 'impi_our_work_slider')) {
                add_post_meta($post_id, 'ddp-css-impi', 'sliders');
            }

            if (strpos($post_content, 'impi_pages_footer')) {
                add_post_meta($post_id, 'ddp-css-impi', 'footers');
            }

            if (strpos($post_content, 'impi_about')) {
                add_post_meta($post_id, 'ddp-css-impi', 'about-page');
            }

            if (strpos($post_content, 'impi_stories_content') || strpos($post_content, 'impi_clients_content') || strpos($post_content, 'impi_learn_more_content') || strpos($post_content, 'impi_accredit_intro_content') || strpos($post_content, 'impi_123_video_content') || strpos($post_content, 'impi_mid_way_content') || strpos($post_content, 'impi_low_down_content') || strpos($post_content, 'impi_ally_content') || strpos($post_content, 'impi_boxy_case_study_content') || strpos($post_content, 'impi_case_study_video_content') || strpos($post_content, 'impi_about_me_text_content') || strpos($post_content, 'impi_about_me_clients_content')|| strpos($post_content, 'impi_about_me_specialization') || strpos($post_content, 'impi_opening_content')) {
                add_post_meta($post_id, 'ddp-css-impi', 'contents');
            }

            if (strpos($post_content, 'impi_get_started_cta') || strpos($post_content, 'impi_tight_cta')) {
                add_post_meta($post_id, 'ddp-css-impi', 'cta');
            }

            if (strpos($post_content, 'impi_intro_logos')) {
                add_post_meta($post_id, 'ddp-css-impi', 'logos');
            }

            if (strpos($post_content, 'impi_team')) {
                add_post_meta($post_id, 'ddp-css-impi', 'team-page');
            }

            // Jamie

            if (strpos($post_content, 'jamie_about')) {
                add_post_meta($post_id, 'ddp-css-jamie', 'about');
            }

            if (strpos($post_content, 'jamie_blog_6') || strpos($post_content, 'jamiefooter2')) {
                add_post_meta($post_id, 'ddp-css-jamie', 'blog-landing-1');
            }

            if (strpos($post_content, 'jamie_blog')) {
                add_post_meta($post_id, 'ddp-css-jamie', 'blog');
            }

            if (strpos($post_content, 'jamie_contact')) {
                add_post_meta($post_id, 'ddp-css-jamie', 'contact');
            }

            if (strpos($post_content, 'jamie-content')) {
                add_post_meta($post_id, 'ddp-css-jamie', 'content');
            }

            if (strpos($post_content, 'jamie-events')) {
                add_post_meta($post_id, 'ddp-css-jamie', 'events');
            }

            if (strpos($post_content, 'jamie_footer')) {
                add_post_meta($post_id, 'ddp-css-jamie', 'footer');
            }

            if (strpos($post_content, 'jamie_home')) {
                add_post_meta($post_id, 'ddp-css-jamie', 'home');
            }

            if (strpos($post_content, 'jamie_menu')) {
                add_post_meta($post_id, 'ddp-css-jamie', 'menu');
            }

            if (strpos($post_content, 'jamie_services')) {
                add_post_meta($post_id, 'ddp-css-jamie', 'services');
            }

            if (strpos($post_content, 'jamie-team-detail')) {
                add_post_meta($post_id, 'ddp-css-jamie', 'team-detail');
            }

            if (strpos($post_content, 'jamie-team-page')) {
                add_post_meta($post_id, 'ddp-css-jamie', 'team-page');
            }

            if (strpos($post_content, 'jamie-home-bar') || strpos($post_content, 'jamie_bar') || strpos($post_content, 'jamie_home_bunner_bar')) {
                add_post_meta($post_id, 'ddp-css-jamie', 'home-bar-page');
            }

            if (strpos($post_content, 'jamie-home-hotel')) {
                add_post_meta($post_id, 'ddp-css-jamie', 'home-hotel-page');
            }


            // Coco

            if (strpos($post_content, 'coco_chic_blurbs') || strpos($post_content, 'coco_eclectic_blurbs') || strpos($post_content, 'coco_shop_blurbs') || strpos($post_content, 'coco_decide_blurbs') || strpos($post_content, 'coco_kind_blurbs') || strpos($post_content, 'coco_decorative_blurbs')) {
                add_post_meta($post_id, 'ddp-css-coco', 'blurbs');
            }

            if (strpos($post_content, 'coco_sleek_footer') || strpos($post_content, 'coco_basic_footer') || strpos($post_content, 'coco_step_footer') || strpos($post_content, 'coco_drop_footer')|| strpos($post_content, 'coco_cast_footer') || strpos($post_content, 'coco_boxy_footer') || strpos($post_content, 'coco_image_footer') || strpos($post_content, 'coco_square_footer') || strpos($post_content, 'coco_idea_footer') || strpos($post_content, 'coco_services_simple_footer')) {
                add_post_meta($post_id, 'ddp-css-coco', 'footers');
            }

            if (strpos($post_content, 'coco_empowered_slider_header') || strpos($post_content, 'coco_style_header') || strpos($post_content, 'coco_go_header') || strpos($post_content, 'coco_fresh_header') || strpos($post_content, 'coco_groove_header') || strpos($post_content, 'coco_want_header') || strpos($post_content, 'coco_empowered_header') || strpos($post_content, 'coco_cult_header') || strpos($post_content, 'coco_image_swop_header') || strpos($post_content, 'coco_tailor_header') || strpos($post_content, 'coco_property_header') || strpos($post_content, 'coco_convert_header') || strpos($post_content, 'coco_services_header') || strpos($post_content, 'coco_in_the_loop_contact_header')) {
                add_post_meta($post_id, 'ddp-css-coco', 'headers');
            }

            if (strpos($post_content, 'coco_flashy_pricing_tabels') || strpos($post_content, 'coco_bold_pricing_tables') || strpos($post_content, 'coco_want_pricing_table') || strpos($post_content, 'coco_hip_pricing_tables') || strpos($post_content, 'coco_flashy_pricing_tabels') || strpos($post_content, 'coco_together_pricing_tables') || strpos($post_content, 'coco_smart_pricing_tables') || strpos($post_content, 'coco_sqweez2_want_pricing_table')) {
                add_post_meta($post_id, 'ddp-css-coco', 'pricing-tables');
            }

            if (strpos($post_content, 'coco_artistic_signup')) {
                add_post_meta($post_id, 'ddp-css-coco', 'newsletter');
            }

            if (strpos($post_content, 'coco_lifestyle_slider') || strpos($post_content, 'coco_case_study_slider') || strpos($post_content, 'coco_vogue_slider') || strpos($post_content, 'coco_sassy_slider') || strpos($post_content, 'coco_our_history_timeline')) {
                add_post_meta($post_id, 'ddp-css-coco', 'sliders');
            }

            if (strpos($post_content, 'coco_dotty_content') || strpos($post_content, 'coco_snappy_content') || strpos($post_content, 'coco_magical_content') || strpos($post_content, 'coco_committed_content') || strpos($post_content, 'coco_ability_content') || strpos($post_content, 'coco_class_content') || strpos($post_content, 'coco_start_today_content') || strpos($post_content, 'coco_tone_content') || strpos($post_content, 'coco_fit_content') || strpos($post_content, 'coco_good_intro_content') || strpos($post_content, 'coco_direct_content') || strpos($post_content, 'coco_peasant_conten') || strpos($post_content, 'coco_wow_case_study') || strpos($post_content, 'coco_dream_case_study') || strpos($post_content, 'coco_we_are_content') || strpos($post_content, 'coco_desire_content') || strpos($post_content, 'coco_this_way_that_way_content') || strpos($post_content, 'coco_video_content') || strpos($post_content, 'coco_champions_content') || strpos($post_content, 'coco_contact_basic_dream_case_study') || strpos($post_content, 'coco_applique_content') || strpos($post_content, 'coco_history_wow_case_study')) {
                add_post_meta($post_id, 'ddp-css-coco', 'content');
            }

            if (strpos($post_content, 'coco_intend_testimonial') || strpos($post_content, 'coco_attitude_testimonial') || strpos($post_content, 'coco_diva_testimonials') || strpos($post_content, 'coco_tab_testimonials') || strpos($post_content, 'demo_tab_testimonials') || strpos($post_content, 'coco_tab_testimonials') || strpos($post_content, 'coco_love_testimonial')  || strpos($post_content, 'coco_popular_testimonials') || strpos($post_content, 'coco_grow_testimonials') || strpos($post_content, 'coco_gaiter_testimonials')) {
                add_post_meta($post_id, 'ddp-css-coco', 'testimonials');
            }

            if (strpos($post_content, 'coco_objective_portfolio') || strpos($post_content, 'coco_decor_portfolio')) {
                add_post_meta($post_id, 'ddp-css-coco', 'portfolio');
            }

            if (strpos($post_content, 'coco_purpose_call_to_action') || strpos($post_content, 'coco_hello_call_to_action') || strpos($post_content, 'coco_target_call_to_action') || strpos($post_content, 'coco_groovy_sign_up') || strpos($post_content, 'coco_display_call_to_action') || strpos($post_content, 'coco_target_call_to_action')) {
                add_post_meta($post_id, 'ddp-css-coco', 'cta');
            }

            if (strpos($post_content, 'coco_idea_person_module') || strpos($post_content, 'coco_tall_person_module') || strpos($post_content, 'coco_sleek_person') || strpos($post_content, 'coco_catwalk_person') || strpos($post_content, 'coco_tall_person_module_cont')) {
                add_post_meta($post_id, 'ddp-css-coco', 'persons');
            }

            if (strpos($post_content, 'coco_class_content') || strpos($post_content, 'coco_committed_content') || strpos($post_content, 'coco_dotty_content') || strpos($post_content, 'coco_objective_portfolio')) {
                add_post_meta($post_id, 'ddp-css-coco', 'image-loader');
            }

            if (strpos($post_content, 'coco_say_hello_form') || strpos($post_content, 'coco_convert_header')) {
                add_post_meta($post_id, 'ddp-css-coco', 'forms');
            }

            if (strpos($post_content, 'coco_contact_page_banner') || strpos($post_content, 'coco_contact_intro_section') || strpos($post_content, 'coco_contact_page_footer')) {
                add_post_meta($post_id, 'ddp-css-coco', 'contact-page');
            }

            if (strpos($post_content, 'coco_hot_new_products') || strpos($post_content, 'coco_hot_featured_products')) {
                add_post_meta($post_id, 'ddp-css-coco', 'products');
            }

            if (strpos($post_content, 'coco_ecommerce_style_header')) {
                add_post_meta($post_id, 'ddp-css-coco', 'ecommerce-pages');
            }


            // Demo

            if (strpos($post_content, 'demo_personal_trainer')) {
                add_post_meta($post_id, 'ddp-css-demo', 'demo-personal-trainer-page');
            }

            if (strpos($post_content, 'demos_dentist')) {
                add_post_meta($post_id, 'ddp-css-demo', 'demo-dentist-page');
            }

            if (strpos($post_content, 'demo_electrician')) {
                add_post_meta($post_id, 'ddp-css-demo', 'demo-electrician-page');
            }

            if (strpos($post_content, 'demo_driving_school')) {
                add_post_meta($post_id, 'ddp-css-demo', 'demo-driving-school-page');
            }

            if (strpos($post_content, 'demo_vet')) {
                add_post_meta($post_id, 'ddp-css-demo', 'demo-vet-page');
            }

            if (strpos($post_content, 'demo_plumber')) {
                add_post_meta($post_id, 'ddp-css-demo', 'demo-plumber-page');
            }

            if (strpos($post_content, 'demo_landscaping')) {
                add_post_meta($post_id, 'ddp-css-demo', 'demo-landscaping-page');
            }

            if (strpos($post_content, 'demo_band')) {
                add_post_meta($post_id, 'ddp-css-demo', 'demo-band-page');
            }

            if (strpos($post_content, 'demo_hairdresser')) {
                add_post_meta($post_id, 'ddp-css-demo', 'demo-hairdresser-page');
            }

            if (strpos($post_content, 'demo_high_school')) {
                add_post_meta($post_id, 'ddp-css-demo', 'demo-high-school-page');
            }

            if (strpos($post_content, 'demo_ngo')) {
                add_post_meta($post_id, 'ddp-css-demo', 'demo-ngo-page');
            }

            if (strpos($post_content, 'demo_onlineapp')) {
                add_post_meta($post_id, 'ddp-css-demo', 'demo-onlineapp');
            }

            if (strpos($post_content, 'demo_real_estate')) {
                add_post_meta($post_id, 'ddp-css-demo', 'demo-real-estate');
            }

            if (strpos($post_content, 'demo_handyman')) {
                add_post_meta($post_id, 'ddp-css-demo', 'demo-handyman');
            }

            if (strpos($post_content, 'demo_catering')) {
                add_post_meta($post_id, 'ddp-css-demo', 'demo-catering');
            }

            if (strpos($post_content, 'demo_call_center')) {
                add_post_meta($post_id, 'ddp-css-demo', 'demo-call-center');
            }

            if (strpos($post_content, 'demo_dance_studio')) {
                add_post_meta($post_id, 'ddp-css-demo', 'demo-dance-studio');
            }

            if (strpos($post_content, 'demo_clinic')) {
                add_post_meta($post_id, 'ddp-css-demo', 'demo-clinic');
            }

            if (strpos($post_content, 'demo_florist')) {
                add_post_meta($post_id, 'ddp-css-demo', 'demo-florist');
            }

            if (strpos($post_content, 'demo_cleaner')) {
                add_post_meta($post_id, 'ddp-css-demo', 'demo-cleaner');
            }

            if (strpos($post_content, 'dietitian_')) {
                add_post_meta($post_id, 'ddp-css-demo', 'demo-dietitian');
            }

            if (strpos($post_content, 'factory_')) {
                add_post_meta($post_id, 'ddp-css-demo', 'demo-factory');
            }

            if (strpos($post_content, 'flooring_')) {
                add_post_meta($post_id, 'ddp-css-demo', 'demo-flooring');
            }

            if (strpos($post_content, 'movers_')) {
                add_post_meta($post_id, 'ddp-css-demo', 'demo-movers');
            }

            if (strpos($post_content, 'logistics_')) {
                add_post_meta($post_id, 'ddp-css-demo', 'demo-logistics');
            }

            if (strpos($post_content, 'kindergarten_')) {
                add_post_meta($post_id, 'ddp-css-demo', 'demo-kindergarten');
            }

            if (strpos($post_content, 'massage_')) {
                add_post_meta($post_id, 'ddp-css-demo', 'demo-massage');
            }

            if (strpos($post_content, 'model_')) {
                add_post_meta($post_id, 'ddp-css-demo', 'demo-model');
            }

            if (strpos($post_content, 'novelist_')) {
                add_post_meta($post_id, 'ddp-css-demo', 'demo-novelist');
            }

            if (strpos($post_content, 'psyhologist_')) {
                add_post_meta($post_id, 'ddp-css-demo', 'demo-psychologist');
            }

            if (strpos($post_content, 'ski_')) {
                add_post_meta($post_id, 'ddp-css-demo', 'demo-ski');
            }

            if (strpos($post_content, 'wedding_')) {
                add_post_meta($post_id, 'ddp-css-demo', 'demo-wedding');
            }

            if (strpos($post_content, 'taxi_')) {
                add_post_meta($post_id, 'ddp-css-demo', 'demo-taxi');
            }

            if (strpos($post_content, 'tea_')) {
                add_post_meta($post_id, 'ddp-css-demo', 'demo-tea');
            }

            if (strpos($post_content, 'summer_camp_')) {
                add_post_meta($post_id, 'ddp-css-demo', 'demo-summer-camp');
            }

            if (strpos($post_content, 'tailor_')) {
                add_post_meta($post_id, 'ddp-css-demo', 'demo-tailor');
            }

            if (strpos($post_content, 'surf_club_')) {
                add_post_meta($post_id, 'ddp-css-demo', 'demo-surf-club');
            }

            if (strpos($post_content, 'beer_')) {
                add_post_meta($post_id, 'ddp-css-demo', 'demo-beer');
            }

            if (strpos($post_content, 'translator_')) {
                add_post_meta($post_id, 'ddp-css-demo', 'demo-translator');
            }

            if (strpos($post_content, 'vegetable_')) {
                add_post_meta($post_id, 'ddp-css-demo', 'demo-vegetable');
            }

            if (strpos($post_content, 'demo_photographer')) {
                add_post_meta($post_id, 'ddp-css-demo', 'demo-photographer');
            }

            if (strpos($post_content, 'demo_eat_your_slider')) {
                add_post_meta($post_id, 'ddp-css-demo', 'demo-eat-your-slider');
            }

            if (strpos($post_content, 'camp_ground_')) {
                add_post_meta($post_id, 'ddp-css-demo', 'demo-camp-ground');
            }

            if (strpos($post_content, 'wine_')) {
                add_post_meta($post_id, 'ddp-css-demo', 'demo-wine');
            }

            if (strpos($post_content, 'upholsterer_')) {
                add_post_meta($post_id, 'ddp-css-demo', 'demo-upholsterer');
            }

            if (strpos($post_content, 'marina_')) {
                add_post_meta($post_id, 'ddp-css-demo', 'demo-marina');
            }

            if (strpos($post_content, 'nail_')) {
                add_post_meta($post_id, 'ddp-css-demo', 'demo-nail');
            }

            if (strpos($post_content, 'print_')) {
                add_post_meta($post_id, 'ddp-css-demo', 'demo-print');
            }

            if (strpos($post_content, 'security_')) {
                add_post_meta($post_id, 'ddp-css-demo', 'demo-security');
            }

            if (strpos($post_content, 'animalshelter_')) {
                add_post_meta($post_id, 'ddp-css-demo', 'demo-animalshelter');
            }

            if (strpos($post_content, 'horse_')) {
                add_post_meta($post_id, 'ddp-css-demo', 'demo-horse');
            }

            if (strpos($post_content, 'icecream_')) {
                add_post_meta($post_id, 'ddp-css-demo', 'demo-icecream');
            }

            if (strpos($post_content, 'demo_fight_')) {
                add_post_meta($post_id, 'ddp-css-demo', 'demo-fight');
            }

            if (strpos($post_content, 'yoga_home_')) {
                add_post_meta($post_id, 'ddp-css-demo', 'demo-yoga-home');
            }
        
            if (strpos($post_content, 'makeup_home_')) {
                add_post_meta($post_id, 'ddp-css-demo', 'demo-makeup-home');
            }



            if (strpos($post_content, 'business_home_')) {
                add_post_meta($post_id, 'ddp-css-demo', 'demo-business-home');
            }

            if (strpos($post_content, 'event_home_')) {
                add_post_meta($post_id, 'ddp-css-demo', 'demo-event-home');
            }

            if (strpos($post_content, 'spa_home_')) {
                add_post_meta($post_id, 'ddp-css-demo', 'demo-spa-home');
            }

            if (strpos($post_content, 'hostel_home_')) {
                add_post_meta($post_id, 'ddp-css-demo', 'demo-hostel-home');
            }

            if (strpos($post_content, 'life_coach_home_')) {
                add_post_meta($post_id, 'ddp-css-demo', 'life-coach-home');
            }

            if (strpos($post_content, 'carpet_cleaner_home_')) {
                add_post_meta($post_id, 'ddp-css-demo', 'carpet-cleaner-home');
            }

            if (strpos($post_content, 'styling_home_')) {
                add_post_meta($post_id, 'ddp-css-demo', 'styling-home');
            }


            // Diana

            if (strpos($post_content, 'diana_stately_blog') || strpos($post_content, 'diana_baronial_blog')) {
                add_post_meta($post_id, 'ddp-css-diana', 'diana-blogs');
            }

            if (strpos($post_content, 'diana_extraordinary_blurbs') || strpos($post_content, 'diana_great_intro_blurbs') || strpos($post_content, 'diana_marked_blurbs') || strpos($post_content, 'diana_no_sweat_blurbs') || strpos($post_content, 'diana_common_blurbs') || strpos($post_content, 'diana_petticoat_blurbs') || strpos($post_content, 'diana_about2_blurbs') || strpos($post_content, 'diana_gal_blurbs') || strpos($post_content, 'diana_great_flip_blurbs') || strpos($post_content, 'diana_eminent_contact_blurbs') || strpos($post_content, 'diana_grandiose_blurbs') || strpos($post_content, 'diana_home8_blurbs') || strpos($post_content, 'diana_tycoon_blurbs') || strpos($post_content, 'diana_babe_blurbs') || strpos($post_content, 'diana_yes_please_blurbs')) {
                add_post_meta($post_id, 'ddp-css-diana', 'diana-blurbs');
            }

            if (strpos($post_content, 'diana_brilliant_content') || strpos($post_content, 'diana_home2_content') || strpos($post_content, 'diana_evident_video_content') || strpos($post_content, 'diana_boxey_content') || strpos($post_content, 'diana_love_this_content') || strpos($post_content, 'diana_magnificent_content') || strpos($post_content, 'diana_mama_content') || strpos($post_content, 'diana_case_study_content') || strpos($post_content, 'diana_doll_content') || strpos($post_content, 'diana_tour_timeline') || strpos($post_content, 'diana_video_content') || strpos($post_content, 'diana_special_content') || strpos($post_content, 'diana_superb_content') || strpos($post_content, 'diana_highborn_content') || strpos($post_content, 'diana_renowned_content') || strpos($post_content, 'diana_kingly_content ') || strpos($post_content, 'diana_glorious_content') || strpos($post_content, 'diana_reputable_content') ||strpos($post_content, 'diana_right_bullet_content') || strpos($post_content, 'diana_left_bullet_content') || strpos($post_content, 'diana_news_intro_content') || strpos($post_content, 'diana_crowned_content')) {
                add_post_meta($post_id, 'ddp-css-diana', 'diana-contents');
            }

            if (strpos($post_content, 'diana_marked_footer') || strpos($post_content, 'diana_glorious_footer') || strpos($post_content, 'diana_piece_of_cake_footer') || strpos($post_content, 'diana_ample_footer') || strpos($post_content, 'diana_dignified_footer') || strpos($post_content, 'diana_salient_footer') || strpos($post_content, 'diana_judge_footer') || strpos($post_content, 'diana_home9_footer')) {
                add_post_meta($post_id, 'ddp-css-diana', 'diana-footers');
            }

            if (strpos($post_content, 'diana_celebrated_header') || strpos($post_content, 'diana_noted_header') || strpos($post_content, 'diana_noble_header') || strpos($post_content, 'diana_majestic_header') || strpos($post_content, 'diana_authoritative_header') || strpos($post_content, 'diana_simple_social_header') || strpos($post_content, 'diana_case_study_header') || strpos($post_content, 'diana_fancy_header') || strpos($post_content, 'diana_leader_header') || strpos($post_content, 'diana_showy_header') || strpos($post_content, 'diana_discover_header') || strpos($post_content, 'diana_dean_header') || strpos($post_content, 'diana_top_brass_header') || strpos($post_content, 'diana_fashion_header')) {
                add_post_meta($post_id, 'ddp-css-diana', 'diana-headers');
            }

            if (strpos($post_content, 'diana_noble_person_module') || strpos($post_content, 'diana_high_person') || strpos($post_content, 'diana_vip_person_module') || strpos($post_content, 'diana_light_person_module') || strpos($post_content, 'diana_simple_person_module') || strpos($post_content, 'diana_dignified_person_module') || strpos($post_content, 'diana_officer_person_module') || strpos($post_content, 'diana_executive_person_module')) {
                add_post_meta($post_id, 'ddp-css-diana', 'diana-persons');
            }

            if (strpos($post_content, 'diana_famed_slider') || strpos($post_content, 'diana_prominent_slider') || strpos($post_content, 'diana_princely_slider') || strpos($post_content, 'diana_imperial_slider') || strpos($post_content, 'diana_dig_slider')  || strpos($post_content, 'diana_crowned_content')) {
                add_post_meta($post_id, 'ddp-css-diana', 'diana-sliders');
            }

            if (strpos($post_content, 'diana_royal_testimonial') || strpos($post_content, 'diana_celebrated_testimonial') || strpos($post_content, 'diana_boxy_testimonials') || strpos($post_content, 'diana_no_sweat_testimonials') || strpos($post_content, 'diana_cute_testimonial') || strpos($post_content, 'diana_numbers_testimonial')) {
                add_post_meta($post_id, 'ddp-css-diana', 'diana-testimonials');
            }

            if (strpos($post_content, 'diana_animated_eye_404')) {
                add_post_meta($post_id, 'ddp-css-diana', 'diana-404');
            }

            if (strpos($post_content, 'diana_vetical_coming_soon')) {
                add_post_meta($post_id, 'ddp-css-diana', 'diana-vetical-coming-soon');
            }

            if (strpos($post_content, 'diana_full_width_under_construction')) {
                add_post_meta($post_id, 'ddp-css-diana', 'diana-full-width-under-construction');
            }

            if (strpos($post_content, 'diana_sticky_header')) {
                add_post_meta($post_id, 'ddp-css-diana', 'diana-sticky-bars');
            }

            if (strpos($post_content, 'diana_overlays_popup')) {
                add_post_meta($post_id, 'ddp-css-diana', 'diana-pop-up');
            }

            if (strpos($post_content, 'diana_mare_cta') || strpos($post_content, 'diana_eminent_call_to_action')) {
                add_post_meta($post_id, 'ddp-css-diana', 'diana-cta');
            }

            if (strpos($post_content, 'diana_single_post_content')) {
                add_post_meta($post_id, 'ddp-css-diana', 'diana-single-post-v1');
            }

            if (strpos($post_content, 'diana_side_strip_numbers') || strpos($post_content, 'diana_chief_numbers')) {
                add_post_meta($post_id, 'ddp-css-diana', 'diana-numbers');
            }

            if (strpos($post_content, 'diana_ruling_header')) {
                add_post_meta($post_id, 'ddp-css-diana', 'diana-ruling-header');
            }

            if (strpos($post_content, 'diana_venerable_pricing_tables')) {
                add_post_meta($post_id, 'ddp-css-diana', 'diana-pricing-tables');
            }

            if (strpos($post_content, 'diana_fashion_header')) {
                add_post_meta($post_id, 'ddp-css-diana', 'diana-fashion-header');
            }

            if (strpos($post_content, 'diana_authoritative_products')) {
                add_post_meta($post_id, 'ddp-css-diana', 'diana-authoritative-products');
            }

            if (strpos($post_content, 'diana_about_four')) {
                add_post_meta($post_id, 'ddp-css-diana', 'diana-about-four');
            }

            if (strpos($post_content, 'diana_norma_jean_content')) {
                add_post_meta($post_id, 'ddp-css-diana', 'diana-norma-jean-content');
            }

            if (strpos($post_content, 'diana_never_knew_content')) {
                add_post_meta($post_id, 'ddp-css-diana', 'diana-never-knew-content');
            }

            if (strpos($post_content, 'diana_no_sweat_v2_blurbs')) {
                add_post_meta($post_id, 'ddp-css-diana', 'diana-no-sweat-v2-blurbs');
            }

            if (strpos($post_content, 'diana_you_change_content')) {
                add_post_meta($post_id, 'ddp-css-diana', 'diana-you-change-content');
            }

            if (strpos($post_content, 'diana_woodwork_header')) {
                add_post_meta($post_id, 'ddp-css-diana', 'diana-woodwork-header');
            }

            if (strpos($post_content, 'diana_treadmill_content')) {
                add_post_meta($post_id, 'ddp-css-diana', 'diana-treadmill-content');
            }

            if (strpos($post_content, 'diana_your_brain_call_to_action')) {
                add_post_meta($post_id, 'ddp-css-diana', 'diana-your-brain-call-to-action');
            }

            if (strpos($post_content, 'diana_your_name_content')) {
                add_post_meta($post_id, 'ddp-css-diana', 'diana-your-name-content');
            }

            if (strpos($post_content, 'diana_cling_to_testimonial')) {
                add_post_meta($post_id, 'ddp-css-diana', 'diana-cling-to-testimonial');
            }

            if (strpos($post_content, 'diana_known_you_content')) {
                add_post_meta($post_id, 'ddp-css-diana', 'diana-known-you-content');
            }

            if (strpos($post_content, 'diana_seems_numbers')) {
                add_post_meta($post_id, 'ddp-css-diana', 'diana-seems-numbers');
            }

            if (strpos($post_content, 'diana_your_life_content')) {
                add_post_meta($post_id, 'ddp-css-diana', 'diana-your-life-content');
            }

            if (strpos($post_content, 'diana_set_in_call_to_action')) {
                add_post_meta($post_id, 'ddp-css-diana', 'diana-set-in-call-to-action');
            }

            if (strpos($post_content, 'diana_boxey_v2_content')) {
                add_post_meta($post_id, 'ddp-css-diana', 'diana-boxey-v2-content');
            }

            if (strpos($post_content, 'diana_in_the_wind_content')) {
                add_post_meta($post_id, 'ddp-css-diana', 'diana-content-in-the-wind');
            }

            if (strpos($post_content, 'diana_candle_blurbs')) {
                add_post_meta($post_id, 'ddp-css-diana', 'diana-blurbs-candle');
            }

            if (strpos($post_content, 'diana_cling_to_content')) {
                add_post_meta($post_id, 'ddp-css-diana', 'diana-content-cling-to');
            }

            if (strpos($post_content, 'diana_set_in_content')) {
                add_post_meta($post_id, 'ddp-css-diana', 'diana-content-set-in');
            }

            if (strpos($post_content, 'diana_always_know_content')) {
                add_post_meta($post_id, 'ddp-css-diana', 'diana-content-always-know');
            }

            if (strpos($post_content, 'diana_big_dream_cta')) {
                add_post_meta($post_id, 'ddp-css-diana', 'diana-cta-big-dream');
            }

            if (strpos($post_content, 'diana_ever_did_header')) {
                add_post_meta($post_id, 'ddp-css-diana', 'diana-header-ever-did');
            }

            if (strpos($post_content, 'diana_your_legend_blurbs')) {
                add_post_meta($post_id, 'ddp-css-diana', 'diana-blurbs-your-legend');
            }

            if (strpos($post_content, 'diana_who_sees_content')) {
                add_post_meta($post_id, 'ddp-css-diana', 'diana-content-who-sees');
            }

            if (strpos($post_content, 'diana_just_our_blurbs')) {
                add_post_meta($post_id, 'ddp-css-diana', 'diana-blurbs-just-our');
            }

            if (strpos($post_content, 'diana_goodbye_blurbs')) {
                add_post_meta($post_id, 'ddp-css-diana', 'diana-blurbs-goodbye');
            }

            if (strpos($post_content, 'diana_just_a_kid_testimonial')) {
                add_post_meta($post_id, 'ddp-css-diana', 'diana-testimonial-just-a-kid');
            }

            if (strpos($post_content, 'diana_services_button')) {
                add_post_meta($post_id, 'ddp-css-diana', 'diana-services-button');
            }

            // Menus

            if (strpos($post_content, 'menu1_logo_section')) {
                add_post_meta($post_id, 'ddp-css-diana', 'diana_menu_1');
            }
            if (strpos($post_content, 'menu2_top_section')) {
                add_post_meta($post_id, 'ddp-css-diana', 'diana_menu_2');
            }
            if (strpos($post_content, 'menu3_top_section')) {
                add_post_meta($post_id, 'ddp-css-diana', 'diana_menu_3');
            }
            if (strpos($post_content, 'diana_arch_menu')) {
                add_post_meta($post_id, 'ddp-css-diana', 'diana_menu_4');
            }
            if (strpos($post_content, 'diana_first_menu')) {
                add_post_meta($post_id, 'ddp-css-diana', 'diana_menu_5');
            }
            if (strpos($post_content, 'diana_champion_menu')) {
                add_post_meta($post_id, 'ddp-css-diana', 'diana_menu_6');
            }
            if (strpos($post_content, 'diana_front_menu')) {
                add_post_meta($post_id, 'ddp-css-diana', 'diana_menu_7');
            }
            if (strpos($post_content, 'diana_leading_menu')) {
                add_post_meta($post_id, 'ddp-css-diana', 'diana_menu_8');
            }
            if (strpos($post_content, 'diana_main_menu')) {
                add_post_meta($post_id, 'ddp-css-diana', 'diana_menu_9');
            }
            if (strpos($post_content, 'diana_pioneer_menu')) {
                add_post_meta($post_id, 'ddp-css-diana', 'diana_menu_10');
            }
            if (strpos($post_content, 'diana_premier_menu')) {
                add_post_meta($post_id, 'ddp-css-diana', 'diana_menu_11');
            }
            if (strpos($post_content, 'diana_prime_menu')) {
                add_post_meta($post_id, 'ddp-css-diana', 'diana_menu_12');
            }
            if (strpos($post_content, 'diana_principal_menu')) {
                add_post_meta($post_id, 'ddp-css-diana', 'diana_menu_13');
            }
            if (strpos($post_content, 'diana_stellar_menu')) {
                add_post_meta($post_id, 'ddp-css-diana', 'diana_menu_14');
            }


            // Freddie


            if (strpos($post_content, 'page_loader') || strpos($post_content, 'freddie_doing_all_right_content') || strpos($post_content, 'freddie_big_spender_intro_content')) {
                add_post_meta($post_id, 'ddp-css-freddie', 'freddie-transitions');
            }

            // menu templates

            if (strpos($post_content, 'freddie_gimme_the_prize_menu_container')) {
                add_post_meta($post_id, 'ddp-css-freddie', 'freddie-menu-prize');
            }

            if (strpos($post_content, 'freddie_attack_dragon_menu_container')) {
                add_post_meta($post_id, 'ddp-css-freddie', 'freddie-menu-attac-dragon');
            }

            if (strpos($post_content, 'freddie_earth_menu_container')) {
                add_post_meta($post_id, 'ddp-css-freddie', 'freddie-menu-earth');
            }

            if (strpos($post_content, 'freddie_funny_love_menu_container')) {
                add_post_meta($post_id, 'ddp-css-freddie', 'freddie-menu-funny-love');
            }

            if (strpos($post_content, 'freddie_hang_on_in_there_menu_container')) {
                add_post_meta($post_id, 'ddp-css-freddie', 'freddie-menu-hang-on-in-there');
            }

            if (strpos($post_content, 'freddie_lover_boy_menu_container')) {
                add_post_meta($post_id, 'ddp-css-freddie', 'freddie-menu-lover-boy');
            }

            if (strpos($post_content, 'freddie_hijack_my_heart')) {
                add_post_meta($post_id, 'ddp-css-freddie', 'freddie-menu-hijack-my-heart');
            }

            // usual modules

            if (strpos($post_content, 'freddie_kind_of_magic_header') || strpos($post_content, 'freddie_all_dead_header') || strpos($post_content, 'freddie_drowse_header') || strpos($post_content, 'freddie_for_everyone_header') || strpos($post_content, 'freddie_princes_of_the_universe') || strpos($post_content, 'freddie_fairy_king_header') || strpos($post_content, 'freddie_i_want_it_all_header') || strpos($post_content, 'freddie_bring_music_header') || strpos($post_content, 'freddie_dont_try_header') || strpos($post_content, 'freddie_the_show_header') || strpos($post_content, 'freddie_friends_header') || strpos($post_content, 'freddie_we_are_header') || strpos($post_content, 'freddie_hang_on_header') || strpos($post_content, 'freddie_born_to_header') || strpos($post_content, 'freddie_leap_ahead_header')) {
                add_post_meta($post_id, 'ddp-css-freddie', 'freddie-headers');
            }

            if (strpos($post_content, 'frddie_all_dead_header_hero') || strpos($post_content, 'freddie_all_dead_header_hero')) {
                add_post_meta($post_id, 'ddp-css-freddie', 'freddie-header-not-dead');
            }

            if (strpos($post_content, 'freddie_big_spender_intro_content') || strpos($post_content, 'freddie_body_langauge_content') || strpos($post_content, 'freddie_doing_all_right_content') || strpos($post_content, 'freddie_cool_cat_content') || strpos($post_content, 'freddie_fun_it_content') || strpos($post_content, 'freddie_fine_sensation_content') || strpos($post_content, 'freddie_innuendo_content') || strpos($post_content, 'freddie_info_content') || strpos($post_content, 'freddie_rain_must_fall_content') || strpos($post_content, 'freddie_scandal_content') || strpos($post_content, 'freddie_home6_images_content') || strpos($post_content, 'freddie_tutti_frutti_content') || strpos($post_content, 'freddie_artist_case_study_content')) {
                add_post_meta($post_id, 'ddp-css-freddie', 'freddie-contents');
            }

            if (strpos($post_content, 'freddie_brighton_rock_blurbs') || strpos($post_content, 'freddie_fight_from_the_inside_blurbs') || strpos($post_content, 'freddie_good_company_blurbs') || strpos($post_content, 'freddie_blurred_vision_blurbs') || strpos($post_content, 'freddie_live_with_you_blurbs') || strpos($post_content, 'freddie_nevermore_blurbs') || strpos($post_content, 'freddie_now_im_here_blurbs') || strpos($post_content, 'freddie_tutti_blurbs') || strpos($post_content, 'freddie_home_studio_blurbs')) {
                add_post_meta($post_id, 'ddp-css-freddie', 'freddie-blurbs');
            }

            if (strpos($post_content, 'freddie_gimme_some_lovin_slider') || strpos($post_content, 'freddie_back_chat_slider') || strpos($post_content, 'freddie_love_you_slider')) {
                add_post_meta($post_id, 'ddp-css-freddie', 'freddie-sliders');
            }

            if (strpos($post_content, 'freddie_hammer_to_fall_testimonals') || strpos($post_content, 'freddie_breakthru_testimonails') || strpos($post_content, 'freddie_seven_days_testmonail') || strpos($post_content, 'freddie_close_to_pleasure_testimonials') || strpos($post_content, 'freddie_frutti_testimonial')) {
                add_post_meta($post_id, 'ddp-css-freddie', 'freddie-testimonials');
            }

            if (strpos($post_content, 'freddie_hello_mary_lou_pricing_tables')) {
                add_post_meta($post_id, 'ddp-css-freddie', 'freddie-pricing-tables');
            }

            if (strpos($post_content, 'freddie_the_miracle_footer') || strpos($post_content, 'freddie_prowl_footer') || strpos($post_content, 'freddie_father_to_son_footer') || strpos($post_content, 'freddie_open_windows_footer') || strpos($post_content, 'freddie_dear_friends_footer') || strpos($post_content, 'freddie_days_of_our_lifes_footer') || strpos($post_content, 'freddie_we_created_footer') || strpos($post_content, 'freddie_wavy_footer')) {
                add_post_meta($post_id, 'ddp-css-freddie', 'freddie-footers');
            }

            if (strpos($post_content, 'freddie_blurred_vision_accordion')) {
                add_post_meta($post_id, 'ddp-css-freddie', 'freddie-accordions');
            }

            if (strpos($post_content, 'freddie_dead_on_time_personal') || strpos($post_content, 'freddie_lap_of_gods_person_module') || strpos($post_content, 'freddie_waltz_person_module') || strpos($post_content, 'freddie_alive_on_time_person') || strpos($post_content, 'freddie_dead_on_time_person') || strpos($post_content, 'freddie-nevermore-person-module')) {
                add_post_meta($post_id, 'ddp-css-freddie', 'freddie-persons');
            }

            if (strpos($post_content, 'freddie_drowse_blog') || strpos($post_content, 'freddie_hard_life_blog') || strpos($post_content, 'freddie_hot_and_cold_blog')) {
                add_post_meta($post_id, 'ddp-css-freddie', 'freddie-blogs');
            }

            if (strpos($post_content, 'freddie_more_info')) {
                add_post_meta($post_id, 'ddp-css-freddie', 'freddie-more-info');
            }

            if (strpos($post_content, 'freddie_album')) {
                add_post_meta($post_id, 'ddp-css-freddie', 'freddie-album');
            }

            if (strpos($post_content, 'freddie_song_slider')) {
                add_post_meta($post_id, 'ddp-css-freddie', 'freddie-song-slider');
            }

            if (strpos($post_content, 'freddie_music')) {
                add_post_meta($post_id, 'ddp-css-freddie', 'freddie-music');
            }

            if (strpos($post_content, 'freddie_music_speak_cta') || strpos($post_content, 'freddie_make_things_cta')) {
                add_post_meta($post_id, 'ddp-css-freddie', 'freddie-cta');
            }

            if (strpos($post_content, 'freddie_process_circle')) {
                add_post_meta($post_id, 'ddp-css-freddie', 'freddie-process-circle');
            }

            if (strpos($post_content, 'freddie_sidewalk_header')) {
                add_post_meta($post_id, 'ddp-css-freddie', 'freddie-sidewalk-header');
            }

            if (strpos($post_content, 'freddie_song_for_lennon_content')) {
                add_post_meta($post_id, 'ddp-css-freddie', 'freddie-song-for-lennon-content');
            }

            if (strpos($post_content, 'freddie_stealin_video_content')) {
                add_post_meta($post_id, 'ddp-css-freddie', 'freddie-stealin-video-content');
            }

            if (strpos($post_content, 'freddie_sweet_lady_slider')) {
                add_post_meta($post_id, 'ddp-css-freddie', 'freddie-sweet-lady-slider');
            }

            if (strpos($post_content, 'freddie_event')) {
                add_post_meta($post_id, 'ddp-css-freddie', 'freddie-portfolio');
            }

            if (strpos($post_content, 'freddie_film_studio_header')) {
                add_post_meta($post_id, 'ddp-css-freddie', 'freddie-film-studio-header');
            }

            if (strpos($post_content, 'freddie_bicycle_blurbs')) {
                add_post_meta($post_id, 'ddp-css-freddie', 'freddie-bicycle-blurbs');
            }

            if (strpos($post_content, 'freddie_our_films_content')) {
                add_post_meta($post_id, 'ddp-css-freddie', 'freddie-our-films-content');
            }

            if (strpos($post_content, 'freddie_race_content')) {
                add_post_meta($post_id, 'ddp-css-freddie', 'freddie-race-content');
            }

            if (strpos($post_content, 'freddie_film_studio_music')) {
                add_post_meta($post_id, 'ddp-css-freddie', 'freddie-film-studio-hitman-music-module');
            }

            if (strpos($post_content, 'freddie_nevermore_person_module')) {
                add_post_meta($post_id, 'ddp-css-freddie', 'freddie-nevermore-person-module');
            }

            if (strpos($post_content, 'freddie_my_heart_header')) {
                add_post_meta($post_id, 'ddp-css-freddie', 'freddie-my-heart-header');
            }

            if (strpos($post_content, 'freddie_blown_over_blurbs')) {
                add_post_meta($post_id, 'ddp-css-freddie', 'freddie-blown-over-blurbs');
            }

            if (strpos($post_content, 'freddie_by_the_way_content')) {
                add_post_meta($post_id, 'ddp-css-freddie', 'freddie-by-the-way-content');
            }

            if (strpos($post_content, 'freddie_desert_me_faq')) {
                add_post_meta($post_id, 'ddp-css-freddie', 'freddie-desert-me-faq');
            }

            if (strpos($post_content, 'freddie_other_day_testimonial')) {
                add_post_meta($post_id, 'ddp-css-freddie', 'freddie-other-day-testimonial');
            }

            if (strpos($post_content, 'freddie_going_to_look_optin')) {
                add_post_meta($post_id, 'ddp-css-freddie', 'freddie-going-to-look-optin');
            }

            if (strpos($post_content, 'freddie_be_better_footer')) {
                add_post_meta($post_id, 'ddp-css-freddie', 'freddie-be-better-footer');
            }

            if (strpos($post_content, 'modern_times_blog_') || strpos($post_content, 'mtbs')) {
                add_post_meta($post_id, 'ddp-css-freddie', 'freddie-modern-times-blog');
            }

            if (strpos($post_content, 'old-times-blog-') || strpos($post_content, 'otbs')) {
                add_post_meta($post_id, 'ddp-css-freddie', 'freddie-old-times-blog');
            }

            if (strpos($post_content, 'freddie_let_me_header')) {
                add_post_meta($post_id, 'ddp-css-freddie', 'freddie-let-me-header');
            }

            if (strpos($post_content, 'freddie_open_windows_products')) {
                add_post_meta($post_id, 'ddp-css-freddie', 'freddie-open-windows-products');
            }

            if (strpos($post_content, 'freddie_ga_ga_content')) {
                add_post_meta($post_id, 'ddp-css-freddie', 'freddie-ga-ga-content');
            }

            if (strpos($post_content, 'freddie_party_footer')) {
                add_post_meta($post_id, 'ddp-css-freddie', 'freddie-party-footer');
            }

            if (strpos($post_content, 'pop_product')) {
                add_post_meta($post_id, 'ddp-css-freddie', 'freddie-pop-product');
            }

            if (strpos($post_content, 'product_webdesign_package_top') || strpos($post_content, 'freddie_included_section')) {
                add_post_meta($post_id, 'ddp-css-freddie', 'freddie-product-details-webdesign-package');
            }

            if (strpos($post_content, 'freddie_cuff_me_archive')) {
                add_post_meta($post_id, 'ddp-css-freddie', 'freddie-cuff-me-archive');
            }

            if (strpos($post_content, 'freddie_really_does_archive')) {
                add_post_meta($post_id, 'ddp-css-freddie', 'freddie-really-does-archive');
            }

            if (strpos($post_content, 'freddie_misfire_search_results')) {
                add_post_meta($post_id, 'ddp-css-freddie', 'freddie-misfire-search-results');
            }

            if (strpos($post_content, 'freddie_baby_does_search_results')) {
                add_post_meta($post_id, 'ddp-css-freddie', 'freddie-baby-does-search-results');
            }

            if (strpos($post_content, 'freddie_that_glitter_blog_post')) {
                add_post_meta($post_id, 'ddp-css-freddie', 'freddie-that-glitter-blog-post');
            }

            if (strpos($post_content, 'freddie_thunderbolt_product')) {
                add_post_meta($post_id, 'ddp-css-freddie', 'freddie-thunderbolt-product');
            }

            if (strpos($post_content, 'freddie_happy_man_tastymonial') || strpos($post_content, 'freddie_razzmatazz_testimonial')) {
                add_post_meta($post_id, 'ddp-css-freddie', 'freddie-happy-man-testimonial');
            }

            if (strpos($post_content, 'freddie_pretty_lights_tabs')) {
                add_post_meta($post_id, 'ddp-css-freddie', 'freddie-pretty-lights-tabs');
            }

            if (strpos($post_content, 'freddie_my_body_testimonial')) {
                add_post_meta($post_id, 'ddp-css-freddie', 'freddie-my-body-testimonial');
            }

            if (strpos($post_content, 'freddie_we_will_rock_you_header')) {
                add_post_meta($post_id, 'ddp-css-freddie', 'freddie-we-will-rock-you-header');
            }

            if (strpos($post_content, 'freddie_live_forever_content')) {
                add_post_meta($post_id, 'ddp-css-freddie', 'freddie-live-forever-content');
            }

            if (strpos($post_content, 'freddie_best_friend_blurbs')) {
                add_post_meta($post_id, 'ddp-css-freddie', 'freddie-best-friend-blurbs');
            }

            if (strpos($post_content, 'freddie_dont_care_content')) {
                add_post_meta($post_id, 'ddp-css-freddie', 'freddie-dont-care-content');
            }

            if (strpos($post_content, 'freddie_nevermore_person_module_about')) {
                add_post_meta($post_id, 'ddp-css-freddie', 'freddie-nevermore-person-module-about');
            }

            if (strpos($post_content, 'freddie_winters_tale_footer')) {
                add_post_meta($post_id, 'ddp-css-freddie', 'freddie-winters-tale-footer');
            }

            if (strpos($post_content, 'freddie_about2')) {
                add_post_meta($post_id, 'ddp-css-freddie', 'freddie-about-page-2');
            }

            if (strpos($post_content, 'freddie_crueladeville_slider')) {
                add_post_meta($post_id, 'ddp-css-freddie', 'freddie-crueladeville-slider');
            }

            if (strpos($post_content, 'freddie_pleasure_chest_content')) {
                add_post_meta($post_id, 'ddp-css-freddie', 'freddie-pleasure-chest-content');
            }

            if (strpos($post_content, 'freddie_pull_you_testimonial')) {
                add_post_meta($post_id, 'ddp-css-freddie', 'freddie-pull-you-testimonial');
            }

            if (strpos($post_content, 'freddie_some_good_blurbs')) {
                add_post_meta($post_id, 'ddp-css-freddie', 'freddie-some-good-blurbs');
            }

            if (strpos($post_content, 'freddie_about3')) {
                add_post_meta($post_id, 'ddp-css-freddie', 'freddie-about-page-3');
            }

            if (strpos($post_content, 'freddie_sell_you_testimonial')) {
                add_post_meta($post_id, 'ddp-css-freddie', 'freddie-sell-you-testimonial');
            }

            if (strpos($post_content, 'freddie_nothing_but_content')) {
                add_post_meta($post_id, 'ddp-css-freddie', 'freddie-nothing-but-content');
            }

            if (strpos($post_content, 'freddie_about5')) {
                add_post_meta($post_id, 'ddp-css-freddie', 'freddie-about-page-5');
            }

            if (strpos($post_content, 'freddie_attraction_timeline')) {
                add_post_meta($post_id, 'ddp-css-freddie', 'freddie-attraction-timeline');
            }

            if (strpos($post_content, 'freddie_gonna_rock_footer')) {
                add_post_meta($post_id, 'ddp-css-freddie', 'freddie-gonna-rock-footer');
            }

            if (strpos($post_content, 'freddie_some_action_content')) {
                add_post_meta($post_id, 'ddp-css-freddie', 'freddie-some-action-content');
            }

            if (strpos($post_content, 'freddie_tonight_content')) {
                add_post_meta($post_id, 'ddp-css-freddie', 'freddie-tonight-content');
            }

            if (strpos($post_content, 'freddie_black_lips_content')) {
                add_post_meta($post_id, 'ddp-css-freddie', 'freddie-black-lips-content');
            }

            if (strpos($post_content, 'freddie_youre_hot_contact_form')) {
                add_post_meta($post_id, 'ddp-css-freddie', 'freddie-youre-hot-contact-form');
            }

            if (strpos($post_content, 'freddie_gonna_look_footer')) {
                add_post_meta($post_id, 'ddp-css-freddie', 'freddie-gonna-look-footer');
            }

            if (strpos($post_content, 'freddie_step_on_testimonial')) {
                add_post_meta($post_id, 'ddp-css-freddie', 'freddie-step-on-testimonial');
            }

            if (strpos($post_content, 'freddie_my_life_testimonial')) {
                add_post_meta($post_id, 'ddp-css-freddie', 'freddie-my-life-testimonial');
            }

            if (strpos($post_content, 'freddie_galileo_header')) {
                add_post_meta($post_id, 'ddp-css-freddie', 'freddie-galileo-header');
            }

            if (strpos($post_content, 'freddie_really_matters_product_detail')) {
                add_post_meta($post_id, 'ddp-css-freddie', 'freddie-really-matters-product-detail');
            }

            if (strpos($post_content, 'freddie_my_time_recent_products')) {
                add_post_meta($post_id, 'ddp-css-freddie', 'freddie-my-time-recent-products');
            }

            if (strpos($post_content, 'freddie_drummer_footer_white')) {
                add_post_meta($post_id, 'ddp-css-freddie', 'freddie-drummer-footer-white');
            }


            if (strpos($post_content, 'freddie_person_module_my_band')) {
                add_post_meta($post_id, 'ddp-css-freddie', 'freddie-person-module-my-band');
            }


            if (strpos($post_content, 'freddie_thank_you_person_module')) {
                add_post_meta($post_id, 'ddp-css-freddie', 'freddie-thank-you-person-module');
            }

            if (strpos($post_content, 'freddie_person_module_greatest_treasure')) {
                add_post_meta($post_id, 'ddp-css-freddie', 'freddie-greatest-treasure-person-module');
            }

            if (strpos($post_content, 'freddie_person_module_rocking_world')) {
                add_post_meta($post_id, 'ddp-css-freddie', 'freddie-rocking-world-person-module');
            }

            if (strpos($post_content, 'freddie_ride_em_person_module')) {
                add_post_meta($post_id, 'ddp-css-freddie', 'freddie-ride-em-person-module');
            }

            if (strpos($post_content, 'freddie_person_module_my_pleasure')) {
                add_post_meta($post_id, 'ddp-css-freddie', 'freddie-my-pleasure-person-module');
            }

            if (strpos($post_content, 'freddie_person_module_you_got')) {
                add_post_meta($post_id, 'ddp-css-freddie', 'freddie-you-got-person-module');
            }

            if (strpos($post_content, 'freddie_world_go_person_module')) {
                add_post_meta($post_id, 'ddp-css-freddie', 'freddie-world-go-person-module');
            }

            if (strpos($post_content, 'freddie_bikes_person_module')) {
                add_post_meta($post_id, 'ddp-css-freddie', 'freddie-bikes-person-module');
            }

            if (strpos($post_content, 'freddie_singing_person_module')) {
                add_post_meta($post_id, 'ddp-css-freddie', 'freddie-singing-person-module');
            }

            if (strpos($post_content, 'freddie_the_bones_person_module')) {
                add_post_meta($post_id, 'ddp-css-freddie', 'freddie-the-bones-person-module');
            }

            if (strpos($post_content, 'freddie_blue_eyed_person_module')) {
                add_post_meta($post_id, 'ddp-css-freddie', 'freddie-blue-eyed-person-module');
            }

            if (strpos($post_content, 'freddie_person_module_nanny')) {
                add_post_meta($post_id, 'ddp-css-freddie', 'freddie-nanny-person-module');
            }

            if (strpos($post_content, 'freddie_person_module_red_fire')) {
                add_post_meta($post_id, 'ddp-css-freddie', 'freddie-red-fire-person-module');
            }

            if (strpos($post_content, 'freddie_every_time_person_module')) {
                add_post_meta($post_id, 'ddp-css-freddie', 'freddie-every-time-person-module');
            }

            if (strpos($post_content, 'freddie_person_module_skinny_lad')) {
                add_post_meta($post_id, 'ddp-css-freddie', 'freddie-person-module-skinny-lad');
            }

            if (strpos($post_content, 'freddie_hanging_gardens_pricing_tables')) {
                add_post_meta($post_id, 'ddp-css-freddie', 'freddie-hanging-gardens-pricing-tables');
            }

            if (strpos($post_content, 'freddie_sahara_desert_pricing_tables')) {
                add_post_meta($post_id, 'ddp-css-freddie', 'freddie-sahara-desert-pricing-tables');
            }

            if (strpos($post_content, 'freddie_world_go_pricing_tables')) {
                add_post_meta($post_id, 'ddp-css-freddie', 'freddie-world-go-pricing-tables');
            }

            if (strpos($post_content, 'freddie_one_thing_pricing_tables')) {
                add_post_meta($post_id, 'ddp-css-freddie', 'freddie-one-thing-pricing-tables');
            }

            if (strpos($post_content, 'freddie_creations_pricing_tables')) {
                add_post_meta($post_id, 'ddp-css-freddie', 'freddie-creations-pricing-tables');
            }

            if (strpos($post_content, 'freddie_on_earth_pricing_tables')) {
                add_post_meta($post_id, 'ddp-css-freddie', 'freddie-on-earth-pricing-tables');
            }




            // featured blurbs (features)

            if (strpos($post_content, 'freddie_calling_me_blurb')) {
                add_post_meta($post_id, 'ddp-css-freddie', 'freddie-calling-me-blurb');
            }

            if (strpos($post_content, 'freddie_entertain_you_blurb')) {
                add_post_meta($post_id, 'ddp-css-freddie', 'freddie-entertain-you-blurb');
            }

            if (strpos($post_content, 'freddie_get_better_blurb')) {
                add_post_meta($post_id, 'ddp-css-freddie', 'freddie-get-better-blurb');
            }

            if (strpos($post_content, 'freddie_i_have_blurb')) {
                add_post_meta($post_id, 'ddp-css-freddie', 'freddie-i-have-blurb');
            }

            if (strpos($post_content, 'freddie_main_thing_blurb')) {
                add_post_meta($post_id, 'ddp-css-freddie', 'freddie-main-thing-blurb');
            }

            if (strpos($post_content, 'freddie_my_shoes_blurb')) {
                add_post_meta($post_id, 'ddp-css-freddie', 'freddie-my-shoes-blurb');
            }

            if (strpos($post_content, 'freddie_no_blame_blurb')) {
                add_post_meta($post_id, 'ddp-css-freddie', 'freddie-no-blame-blurb');
            }

            if (strpos($post_content, 'freddie_on_my_way_blurb')) {
                add_post_meta($post_id, 'ddp-css-freddie', 'freddie-on-my-way-blurb');
            }

            if (strpos($post_content, 'freddie_only_way_blurb')) {
                add_post_meta($post_id, 'ddp-css-freddie', 'freddie-only-way-blurb');
            }

            if (strpos($post_content, 'freddie_satisfied_blurb')) {
                add_post_meta($post_id, 'ddp-css-freddie', 'freddie-satisfied-blurb');
            }

            if (strpos($post_content, 'freddie_steps_nearer_blurb')) {
                add_post_meta($post_id, 'ddp-css-freddie', 'freddie-steps-nearer-blurb');
            }

            if (strpos($post_content, 'freddie_the_line_blurb')) {
                add_post_meta($post_id, 'ddp-css-freddie', 'freddie-the-line-blurb');
            }

            if (strpos($post_content, 'freddie_your_time_blurb')) {
                add_post_meta($post_id, 'ddp-css-freddie', 'freddie-your-time-blurb');
            }

            if (strpos($post_content, 'freddie_needs_you_header')) {
                add_post_meta($post_id, 'ddp-css-freddie', 'freddie-needs-you-header');
            }

            if (strpos($post_content, 'freddie_put_out_products')) {
                add_post_meta($post_id, 'ddp-css-freddie', 'freddie-put-out-products');
            }

            if (strpos($post_content, 'freddie_drummer_footer')) {
                add_post_meta($post_id, 'ddp-css-freddie', 'freddie-drummer-footer');
            }

            // Gallery

            if (strpos($post_content, 'freddie_gallery_a_hero')) {
                add_post_meta($post_id, 'ddp-css-freddie', 'freddie-gallery-a-hero');
            }

            if (strpos($post_content, 'freddie_gallery_every_child')) {
                add_post_meta($post_id, 'ddp-css-freddie', 'freddie-gallery-every-child');
            }

            if (strpos($post_content, 'freddie_gallery_the_mighty')) {
                add_post_meta($post_id, 'ddp-css-freddie', 'freddie-gallery-the-mighty');
            }

            if (strpos($post_content, 'freddie_gallery_oooh_yeah')) {
                add_post_meta($post_id, 'ddp-css-freddie', 'freddie-gallery-oooh-yeah');
            }

            if (strpos($post_content, 'freddie_gallery_my_friend')) {
                add_post_meta($post_id, 'ddp-css-freddie', 'freddie-gallery-my-friend');
            }

            if (strpos($post_content, 'freddie_gallery_every_one')) {
                add_post_meta($post_id, 'ddp-css-freddie', 'freddie-gallery-every-one');
            }

            if (strpos($post_content, 'freddie_gallery_be_somebody')) {
                add_post_meta($post_id, 'ddp-css-freddie', 'freddie-gallery-be-somebody');
            }


            // buttons

            if (strpos($post_content, 'freddie_brighton_rock_blurbs')) {
                add_post_meta($post_id, 'ddp-css-freddie', 'freddie-blurbs');
            }

            if (strpos($post_content, 'freddie_the_miracle_footer')) {
                add_post_meta($post_id, 'ddp-css-freddie', 'freddie-footers');
            }

            if (strpos($post_content, 'freddie_button_')) {
                add_post_meta($post_id, 'ddp-css-freddie', 'freddie-buttons');
            }

            if (strpos($post_content, 'freddie_button_jealousy')) {
                add_post_meta($post_id, 'ddp-css-freddie', 'freddie-button-jealousy');
            }

            if (strpos($post_content, 'freddie_button_the_loser')) {
                add_post_meta($post_id, 'ddp-css-freddie', 'freddie-button-the-loser');
            }

            if (strpos($post_content, 'freddie_button_lazing_on')) {
                add_post_meta($post_id, 'ddp-css-freddie', 'freddie-button-lazing-on');
            }

            if (strpos($post_content, 'freddie_button_liar')) {
                add_post_meta($post_id, 'ddp-css-freddie', 'freddie-button-liar');
            }

            if (strpos($post_content, 'freddie_button_love_kills')) {
                add_post_meta($post_id, 'ddp-css-freddie', 'freddie-button-love-kills');
            }

            if (strpos($post_content, 'freddie_button_misfire')) {
                add_post_meta($post_id, 'ddp-css-freddie', 'freddie-button-misfire');
            }

            if (strpos($post_content, 'freddie_button_been_saved')) {
                add_post_meta($post_id, 'ddp-css-freddie', 'freddie-button-been-saved');
            }

            if (strpos($post_content, 'freddie_button_mother_love')) {
                add_post_meta($post_id, 'ddp-css-freddie', 'freddie-button-mother-love');
            }

            if (strpos($post_content, 'freddie_button_ogre_battle')) {
                add_post_meta($post_id, 'ddp-css-freddie', 'freddie-button-ogre-battle');
            }

            if (strpos($post_content, 'freddie_button_party')) {
                add_post_meta($post_id, 'ddp-css-freddie', 'freddie-button-party');
            }

            if (strpos($post_content, 'freddie_button_the_fire')) {
                add_post_meta($post_id, 'ddp-css-freddie', 'freddie-button-the-fire');
            }

            if (strpos($post_content, 'freddie_button_wild_wind')) {
                add_post_meta($post_id, 'ddp-css-freddie', 'freddie-button-wild-wind');
            }

            if (strpos($post_content, 'freddie_button_seaside')) {
                add_post_meta($post_id, 'ddp-css-freddie', 'freddie-button-seaside');
            }

            if (strpos($post_content, 'freddie_button_rendezvous')) {
                add_post_meta($post_id, 'ddp-css-freddie', 'freddie-button-rendezvous');
            }

            if (strpos($post_content, 'freddie_button_some_day')) {
                add_post_meta($post_id, 'ddp-css-freddie', 'freddie-button-some-day');
            }

            if (strpos($post_content, 'freddie_button_one_day')) {
                add_post_meta($post_id, 'ddp-css-freddie', 'freddie-button-one-day');
            }

            if (strpos($post_content, 'freddie_button_soul_brother')) {
                add_post_meta($post_id, 'ddp-css-freddie', 'freddie-button-soul-brother');
            }

            if (strpos($post_content, 'freddie_button_step_on_me')) {
                add_post_meta($post_id, 'ddp-css-freddie', 'freddie-button-step-on-me');
            }

            if (strpos($post_content, 'freddie_button_tear_it_up')) {
                add_post_meta($post_id, 'ddp-css-freddie', 'freddie-button-tear-it-up');
            }

            if (strpos($post_content, 'freddie_button_teo_torriate')) {
                add_post_meta($post_id, 'ddp-css-freddie', 'freddie-button-teo-torriate');
            }

            if (strpos($post_content, 'freddie_button_fairy_feller')) {
                add_post_meta($post_id, 'ddp-css-freddie', 'freddie-button-fairy-feller');
            }

            if (strpos($post_content, 'freddie_button_radio_ga_ga')) {
                add_post_meta($post_id, 'ddp-css-freddie', 'freddie-button-radio-ga-ga');
            }

            if (strpos($post_content, 'freddie_button_under_pressure')) {
                add_post_meta($post_id, 'ddp-css-freddie', 'freddie-button-under-pressure');
            }

            if (strpos($post_content, 'freddie_button_you_andi')) {
                add_post_meta($post_id, 'ddp-css-freddie', 'freddie-button-you-andi');
            }

            if (strpos($post_content, 'freddie_button_action_this_day')) {
                add_post_meta($post_id, 'ddp-css-freddie', 'freddie-button-action-this-day');
            }

            if (strpos($post_content, 'freddie_button_april_lady')) {
                add_post_meta($post_id, 'ddp-css-freddie', 'freddie-button-april-lady');
            }

            if (strpos($post_content, 'freddie_button_bicycle_race')) {
                add_post_meta($post_id, 'ddp-css-freddie', 'freddie-button-bicycle-race');
            }

            if (strpos($post_content, 'freddie_button_blag')) {
                add_post_meta($post_id, 'ddp-css-freddie', 'freddie-button-blag');
            }

            if (strpos($post_content, 'freddie_button_bohemian')) {
                add_post_meta($post_id, 'ddp-css-freddie', 'freddie-button-bohemian');
            }

            if (strpos($post_content, 'freddie_button_rhapsody')) {
                add_post_meta($post_id, 'ddp-css-freddie', 'freddie-button-rhapsody');
            }

            if (strpos($post_content, 'freddie_button_calling_All_girls')) {
                add_post_meta($post_id, 'ddp-css-freddie', 'freddie-button-calling-all-girls');
            }

            if (strpos($post_content, 'freddie_button_dancer')) {
                add_post_meta($post_id, 'ddp-css-freddie', 'freddie-button-dancer');
            }

            if (strpos($post_content, 'freddie_button_delilah')) {
                add_post_meta($post_id, 'ddp-css-freddie', 'freddie-button-delilah');
            }

            if (strpos($post_content, 'freddie_button_dont_stop_me')) {
                add_post_meta($post_id, 'ddp-css-freddie', 'freddie-button-dont-stop-me');
            }

            if (strpos($post_content, 'freddie_button_fat_bottomed')) {
                add_post_meta($post_id, 'ddp-css-freddie', 'freddie-button-fat-bottomed');
            }

            if (strpos($post_content, 'freddie_button_get_down')) {
                add_post_meta($post_id, 'ddp-css-freddie', 'freddie-button-get-down');
            }

            if (strpos($post_content, 'freddie_button_the_queen')) {
                add_post_meta($post_id, 'ddp-css-freddie', 'freddie-button-the-queen');
            }

            if (strpos($post_content, 'freddie_button_good_old')) {
                add_post_meta($post_id, 'ddp-css-freddie', 'freddie-button-good-old');
            }

            if (strpos($post_content, 'freddie_button_headlong')) {
                add_post_meta($post_id, 'ddp-css-freddie', 'freddie-button-headlong');
            }

            if (strpos($post_content, 'freddie_button_break_free')) {
                add_post_meta($post_id, 'ddp-css-freddie', 'freddie-button-break-free');
            }

            if (strpos($post_content, 'freddie_button_beat_them')) {
                add_post_meta($post_id, 'ddp-css-freddie', 'freddie-button-beat-them');
            }

            if (strpos($post_content, 'freddie_button_beautiful_day')) {
                add_post_meta($post_id, 'ddp-css-freddie', 'freddie-button-beautiful-day');
            }

            if (strpos($post_content, 'freddie_button_killer_queen')) {
                add_post_meta($post_id, 'ddp-css-freddie', 'freddie-button-killer-queen');
            }

            if (strpos($post_content, 'freddie_button_life_is_real')) {
                add_post_meta($post_id, 'ddp-css-freddie', 'freddie-button-life-is-real');
            }

            if (strpos($post_content, 'freddie_button_love_of')) {
                add_post_meta($post_id, 'ddp-css-freddie', 'freddie-button-love-of');
            }

            if (strpos($post_content, 'freddie_button_made_in_heaven')) {
                add_post_meta($post_id, 'ddp-css-freddie', 'freddie-button-made-in-heaven');
            }

            if (strpos($post_content, 'freddie_button_melancholy_blues')) {
                add_post_meta($post_id, 'ddp-css-freddie', 'freddie-button-melancholy-blues');
            }

            if (strpos($post_content, 'freddie_button_no_violins')) {
                add_post_meta($post_id, 'ddp-css-freddie', 'freddie-button-no-violins');
            }

            if (strpos($post_content, 'freddie_button_one_vision')) {
                add_post_meta($post_id, 'ddp-css-freddie', 'freddie-button-one-vision');
            }

            if (strpos($post_content, 'freddie_button_play_the_game')) {
                add_post_meta($post_id, 'ddp-css-freddie', 'freddie-button-play-the-game');
            }

            // Menus

            if (strpos($post_content, 'freddie_gimme_the_prize_menu')) {
                add_post_meta($post_id, 'ddp-css-freddie', 'freddie-menu-1');
            }

            if (strpos($post_content, 'freddie_attack_dragon_menu')) {
                add_post_meta($post_id, 'ddp-css-freddie', 'freddie-menu-2');
            }

            if (strpos($post_content, 'ffreddie_earth_menu') || strpos($post_content, 'freddie_earth_menu')) {
                add_post_meta($post_id, 'ddp-css-freddie', 'freddie-menu-3');
            }

            if (strpos($post_content, 'freddie_funny_love_menu')) {
                add_post_meta($post_id, 'ddp-css-freddie', 'freddie-menu-4');
            }

            if (strpos($post_content, 'freddie_hang_on_in_there_menu')) {
                add_post_meta($post_id, 'ddp-css-freddie', 'freddie-menu-5');
            }

            if (strpos($post_content, 'freddie_lover_boy_menu')) {
                add_post_meta($post_id, 'ddp-css-freddie', 'freddie-menu-6');
            }

            if (strpos($post_content, 'freddie_hijack_my_heart')) {
                add_post_meta($post_id, 'ddp-css-freddie', 'freddie-menu-7');
            }

            // TB Blog Posts

            if (strpos($post_content, 'freddie_to_son')) {
                add_post_meta($post_id, 'ddp-css-freddie', 'freddie-blog-post-to-son');
            }

            if (strpos($post_content, 'freddie_drowse_post')) {
                add_post_meta($post_id, 'ddp-css-freddie', 'freddie-blog-post-drowse');
            }

            if (strpos($post_content, 'freddie_all_girls_post')) {
                add_post_meta($post_id, 'ddp-css-freddie', 'freddie-blog-post-all-girls');
            }

            if (strpos($post_content, 'freddie_make_love_blog_post')) {
                add_post_meta($post_id, 'ddp-css-freddie', 'freddie-make-love-blog-post');
            }

            if (strpos($post_content, 'freddie_funster_testimonial')) {
                add_post_meta($post_id, 'ddp-css-freddie', 'freddie-funster-testimonial');
            }

            if (strpos($post_content, 'freddie_blog_post_mother_love')) {
                add_post_meta($post_id, 'ddp-css-freddie', 'freddie-blog-post-mother-love');
            }

            if (strpos($post_content, 'freddie_blog_post_human_body')) {
                add_post_meta($post_id, 'ddp-css-freddie', 'freddie-blog-post-human-body');
            }

            // TB Navigation Menus

            if (strpos($post_content, 'freddie_without_counting_header')) {
                add_post_meta($post_id, 'ddp-css-freddie', 'freddie-without-counting-header');
            }

            if (strpos($post_content, 'freddie_bali_header')) {
                add_post_meta($post_id, 'ddp-css-freddie', 'freddie-bali-header');
            }

            if (strpos($post_content, 'freddie_hungry_header')) {
                add_post_meta($post_id, 'ddp-css-freddie', 'freddie-hungry-header');
            }

            if (strpos($post_content, 'freddie_breaking_header')) {
                add_post_meta($post_id, 'ddp-css-freddie', 'freddie-breaking-header');
            }

            if (strpos($post_content, 'freddie_mona_lis_header')) {
                add_post_meta($post_id, 'ddp-css-freddie', 'freddie-mona-lis-header');
            }

            if (strpos($post_content, 'freddie_private_affair_header')) {
                add_post_meta($post_id, 'ddp-css-freddie', 'freddie-private-affair-header');
            }

            if (strpos($post_content, 'freddie_pleading_header')) {
                add_post_meta($post_id, 'ddp-css-freddie', 'freddie-pleading-header');
            }

            if (strpos($post_content, 'freddie_headline_header')) {
                add_post_meta($post_id, 'ddp-css-freddie', 'freddie-headline-header');
            }

            if (strpos($post_content, 'freddie_twisted_header')) {
                add_post_meta($post_id, 'ddp-css-freddie', 'freddie-twisted-header');
            }

            if (strpos($post_content, 'freddie_get_started_header')) {
                add_post_meta($post_id, 'ddp-css-freddie', 'freddie-get-started-header');
            }

            if (strpos($post_content, 'freddie_he_pulled_header')) {
                add_post_meta($post_id, 'ddp-css-freddie', 'freddie-he-pulled-header');
            }

            if (strpos($post_content, 'freddie_no_one_header')) {
                add_post_meta($post_id, 'ddp-css-freddie', 'freddie-no-one-header');
            }

            if (strpos($post_content, 'freddie_just_like_header')) {
                add_post_meta($post_id, 'ddp-css-freddie', 'freddie-just-like-header');
            }

            if (strpos($post_content, 'freddie_got_all_header')) {
                add_post_meta($post_id, 'ddp-css-freddie', 'freddie-got-all-header');
            }

            if (strpos($post_content, 'freddie_i_know_header')) {
                add_post_meta($post_id, 'ddp-css-freddie', 'freddie-i-know-header');
            }

            if (strpos($post_content, 'freddie_come_back_header')) {
                add_post_meta($post_id, 'ddp-css-freddie', 'freddie-come-back-header');
            }

            if (strpos($post_content, 'freddie_day_next_header')) {
                add_post_meta($post_id, 'ddp-css-freddie', 'freddie-day-next-header');
            }

            if (strpos($post_content, 'freddie_jamming_header')) {
                add_post_meta($post_id, 'ddp-css-freddie', 'freddie-jamming-header');
            }

            if (strpos($post_content, 'freddie_header_las_palabras_de_amor')) {
                add_post_meta($post_id, 'ddp-css-freddie', 'freddie-header-las-palabras-de-amor');
            }

            if (strpos($post_content, 'freddie_content_let_me_live')) {
                add_post_meta($post_id, 'ddp-css-freddie', 'freddie-content-let-me-live');
            }

            if (strpos($post_content, 'freddie_content_long_away')) {
                add_post_meta($post_id, 'ddp-css-freddie', 'freddie-content-long-away');
            }

            if (strpos($post_content, 'freddie_testimonial_back_to_humans')) {
                add_post_meta($post_id, 'ddp-css-freddie', 'freddie-testimonial-back-to-humans');
            }

            if (strpos($post_content, 'freddie_tabs_more_of_that_jazz')) {
                add_post_meta($post_id, 'ddp-css-freddie', 'freddie-tabs-more-of-that-jazz');
            }

            if (strpos($post_content, 'freddie_footer_black_queen')) {
                add_post_meta($post_id, 'ddp-css-freddie', 'freddie-footer-black-queen');
            }

            if (strpos($post_content, 'freddie_header_going_slightly_mad')) {
                add_post_meta($post_id, 'ddp-css-freddie', 'freddie-header-going-slightly-mad');
            }

            if (strpos($post_content, 'freddie_content_lap_of_the_gods')) {
                add_post_meta($post_id, 'ddp-css-freddie', 'freddie-content-lap-of-the-gods');
            }

            if (strpos($post_content, 'freddie_content_everybody_happy')) {
                add_post_meta($post_id, 'ddp-css-freddie', 'freddie-content-everybody-happy');
            }

            if (strpos($post_content, 'freddie_person_module_Its_late')) {
                add_post_meta($post_id, 'ddp-css-freddie', 'freddie-person-module-its-late');
            }

            if (strpos($post_content, 'freddie_footer_keep_yourself_alive')) {
                add_post_meta($post_id, 'ddp-css-freddie', 'freddie-footer-keep-yourself-alive');
            }

            if (strpos($post_content, 'freddie_author_worthwhile')) {
                add_post_meta($post_id, 'ddp-css-freddie', 'freddie-author-1');
            }


            if (strpos($post_content, 'freddie_products_featured_mama_oooh')) {
                add_post_meta($post_id, 'ddp-css-freddie', 'freddie-products-featured-mama-oooh');
            }


            if (strpos($post_content, 'freddie_products_featured_ha_haa')) {
                add_post_meta($post_id, 'ddp-css-freddie', 'freddie-products-featured-ha-haa');
            }


            if (strpos($post_content, 'freddie_products_featured_this_rage')) {
                add_post_meta($post_id, 'ddp-css-freddie', 'freddie-products-featured-this-rage');
            }

            if (strpos($post_content, 'freddie_products_featured_wooh')) {
                add_post_meta($post_id, 'ddp-css-freddie', 'freddie-products-featured-wooh');
            }


            if (strpos($post_content, 'freddie_product_thrown_it_all_away')) {
                add_post_meta($post_id, 'ddp-css-freddie', 'freddie-product-thrown-it-all-away');
            }


            if (strpos($post_content, 'freddie_product_time_tomorrow')) {
                add_post_meta($post_id, 'ddp-css-freddie', 'freddie-product-time-tomorrow');
            }


            if (strpos($post_content, 'freddie_product_gimme_some')) {
                add_post_meta($post_id, 'ddp-css-freddie', 'freddie-product-gimme-some');
            }


            // Tina
            if (strpos($post_content, 'tina_the_girl_header')) {
                add_post_meta($post_id, 'ddp-css-tina', 'tina-header-the-girl');
            }

            if (strpos($post_content, 'tina_easy_babe_blurbs')) {
                add_post_meta($post_id, 'ddp-css-tina', 'tina-blurbs-easy-babe');
            }

            if (strpos($post_content, 'tina_the_change_tabs')) {
                add_post_meta($post_id, 'ddp-css-tina', 'tina-tabs-the-change');
            }

            if (strpos($post_content, 'tina_she_talks_person_module')) {
                add_post_meta($post_id, 'ddp-css-tina', 'tina-person-module-she-talks');
            }

            if (strpos($post_content, 'tina_down_to_me_content')) {
                add_post_meta($post_id, 'ddp-css-tina', 'tina-content-down-to-me');
            }

            if (strpos($post_content, 'tina_its_alright_blog')) {
                add_post_meta($post_id, 'ddp-css-tina', 'tina-blog-its-alright');
            }

            if (strpos($post_content, 'tina_siamese_testimonial')) {
                add_post_meta($post_id, 'ddp-css-tina', 'tina-testimonial-siamese');
            }

            if (strpos($post_content, 'tina_the_change_footer')) {
                add_post_meta($post_id, 'ddp-css-tina', 'tina-footer-the-change');
            }

            if (strpos($post_content, 'tina_private_dancer_header')) {
                add_post_meta($post_id, 'ddp-css-tina', 'tina-header-private-dancer');
            }

            if (strpos($post_content, 'tina_these_places_content')) {
                add_post_meta($post_id, 'ddp-css-tina', 'tina-content-these-places');
            }

            if (strpos($post_content, 'tina_these_places_content')) {
                add_post_meta($post_id, 'ddp-css-tina', 'tina-content-their-faces');
            }

            if (strpos($post_content, 'tina_a_dancer_content')) {
                add_post_meta($post_id, 'ddp-css-tina', 'tina-content-a-dancer');
            }

            if (strpos($post_content, 'tina_my_thumb_person_module')) {
                add_post_meta($post_id, 'ddp-css-tina', 'tina-person-module-my-thumb');
            }

            if (strpos($post_content, 'tina_a_diamond_content')) {
                add_post_meta($post_id, 'ddp-css-tina', 'tina-content-a-diamond');
            }

            if (strpos($post_content, 'tina_all_day_blog')) {
                add_post_meta($post_id, 'ddp-css-tina', 'tina-blog-all-day');
            }

            if (strpos($post_content, 'tina_dont_walk_footer')) {
                add_post_meta($post_id, 'ddp-css-tina', 'tina-footer-dont-walk');
            }

            if (strpos($post_content, 'tina_see_this_header')) {
                add_post_meta($post_id, 'ddp-css-tina', 'tina-header-see-this');
            }

            if (strpos($post_content, 'tina_smile_to_blurbs')) {
                add_post_meta($post_id, 'ddp-css-tina', 'tina-blurbs-smile-to');
            }

            if (strpos($post_content, 'tina_a_fire_blurbs')) {
                add_post_meta($post_id, 'ddp-css-tina', 'tina-blurbs-a-fire');
            }

            if (strpos($post_content, 'tina_get_enough_blurbs')) {
                add_post_meta($post_id, 'ddp-css-tina', 'tina-blurbs-get-enough');
            }

            if (strpos($post_content, 'tina_goes_around_numbers')) {
                add_post_meta($post_id, 'ddp-css-tina', 'tina-numbers-goes-around');
            }

            if (strpos($post_content, 'tina_flowing_persons')) {
                add_post_meta($post_id, 'ddp-css-tina', 'tina-persons-flowing');
            }

            if (strpos($post_content, 'tina_seek_call_to_action')) {
                add_post_meta($post_id, 'ddp-css-tina', 'tina-call-to-action-seek');
            }

            if (strpos($post_content, 'tina_the_flame_blog')) {
                add_post_meta($post_id, 'ddp-css-tina', 'tina-blog-the-flame');
            }

            if (strpos($post_content, 'tina_still_play_footer')) {
                add_post_meta($post_id, 'ddp-css-tina', 'tina-footer-still-play');
            }

            if (strpos($post_content, 'tina_my_lover_sidebar')) {
                add_post_meta($post_id, 'ddp-css-tina', 'tina-my-lover-sidebar');
            }

            if (strpos($post_content, 'tina_he_belongs_header')) {
                add_post_meta($post_id, 'ddp-css-tina', 'tina-header-he-belongs');
            }

            if (strpos($post_content, 'tina_never_been_blurbs')) {
                add_post_meta($post_id, 'ddp-css-tina', 'tina-blurbs-never-been');
            }

            if (strpos($post_content, 'tina_buy_into_blurbs')) {
                add_post_meta($post_id, 'ddp-css-tina', 'tina-blurbs-buy-into');
            }

            if (strpos($post_content, 'tina_the_flame_content')) {
                add_post_meta($post_id, 'ddp-css-tina', 'tina-content-the-flame');
            }

            if (strpos($post_content, 'tina_i_wanna_be_blurbs')) {
                add_post_meta($post_id, 'ddp-css-tina', 'tina-blurbs-i-wanna-be');
            }

            if (strpos($post_content, 'tina_you_lead_me_blurbs')) {
                add_post_meta($post_id, 'ddp-css-tina', 'tina-blurbs-you-lead-me');
            }

            if (strpos($post_content, 'tina_who_did_testimonial')) {
                add_post_meta($post_id, 'ddp-css-tina', 'tina-testimonial-who-did');
            }

            if (strpos($post_content, 'tina_time_to_footer')) {
                add_post_meta($post_id, 'ddp-css-tina', 'tina-time-footer-to');
            }

            // optins

            if (strpos($post_content, 'tina_so_familiar_optin')) {
                add_post_meta($post_id, 'ddp-css-tina', 'tina-optin-so-familiar');
            }

            if (strpos($post_content, 'tina_you_need_optin')) {
                add_post_meta($post_id, 'ddp-css-tina', 'tina-optin-you-need');
            }

            if (strpos($post_content, 'tina_gonna_be_optin')) {
                add_post_meta($post_id, 'ddp-css-tina', 'tina-optin-gonna-be');
            }

            if (strpos($post_content, 'tina_be_right_optin')) {
                add_post_meta($post_id, 'ddp-css-tina', 'tina-optin-be-right');
            }

            if (strpos($post_content, 'tina_right_here_optin')) {
                add_post_meta($post_id, 'ddp-css-tina', 'tina-optin-right-here');
            }

            if (strpos($post_content, 'tina_your_kiss_optin')) {
                add_post_meta($post_id, 'ddp-css-tina', 'tina-optin-your-kiss');
            }

            if (strpos($post_content, 'tina_a_kind_optin')) {
                add_post_meta($post_id, 'ddp-css-tina', 'tina-optin-a-kind');
            }

            if (strpos($post_content, 'tina_other_lives_optin')) {
                add_post_meta($post_id, 'ddp-css-tina', 'tina-optin-other-lives');
            }

            // Content Pages

            if (strpos($post_content, 'tina_content_page_1') || strpos($post_content, 'tina_page_content')) {
                add_post_meta($post_id, 'ddp-css-tina', 'tina-content-page-1');
            }

            if (strpos($post_content, 'tina_content_page2') || strpos($post_content, 'tina_page_content_2')) {
                add_post_meta($post_id, 'ddp-css-tina', 'tina-content-page-2');
            }

            if (strpos($post_content, 'tina_page_content_3') || strpos($post_content, 'tina_content3')) {
                add_post_meta($post_id, 'ddp-css-tina', 'tina-content-page-3');
            }

            if (strpos($post_content, 'tina_page_content_4') || strpos($post_content, 'tina_content4')) {
                add_post_meta($post_id, 'ddp-css-tina', 'tina-content-page-4');
            }

            if (strpos($post_content, 'tina_page_content_5')) {
                add_post_meta($post_id, 'ddp-css-tina', 'tina-content-page-5');
            }

            if (strpos($post_content, 'tina_page_content_6')) {
                add_post_meta($post_id, 'ddp-css-tina', 'tina-content-page-6');
            }

            if (strpos($post_content, 'tina_page_content_7')) {
                add_post_meta($post_id, 'ddp-css-tina', 'tina-content-page-7');
            }

            if (strpos($post_content, 'tina_page_content_8') || strpos($post_content, 'tina_contentpage8')) {
                add_post_meta($post_id, 'ddp-css-tina', 'tina-content-page-8');
            }

            if (strpos($post_content, 'tina_page_content_9')) {
                add_post_meta($post_id, 'ddp-css-tina', 'tina-content-page-9');
            }

            if (strpos($post_content, 'tina_page_content_10')) {
                add_post_meta($post_id, 'ddp-css-tina', 'tina-content-page-10');
            }

            if (strpos($post_content, 'tina_page_content_11')) {
                add_post_meta($post_id, 'ddp-css-tina', 'tina-content-page-11');
            }


            // Sidebars

            if (strpos($post_content, 'tina_my_end_sidebar')) {
                add_post_meta($post_id, 'ddp-css-tina', 'tina-my-end-sidebar');
            }

            if (strpos($post_content, 'tina_my_beggining_sidebar')) {
                add_post_meta($post_id, 'ddp-css-tina', 'tina-my-beggining-sidebar');
            }

            if (strpos($post_content, 'tina_feel_like_sidebar')) {
                add_post_meta($post_id, 'ddp-css-tina', 'tina-feel-like-sidebar');
            }

            if (strpos($post_content, 'tina_this_time_sidebar')) {
                add_post_meta($post_id, 'ddp-css-tina', 'tina-this-time-sidebar');
            }

            if (strpos($post_content, 'tina_be_right_sidebar')) {
                add_post_meta($post_id, 'ddp-css-tina', 'tina-be-right-sidebar');
            }

            if (strpos($post_content, 'tina_waiting_baby_sidebar')) {
                add_post_meta($post_id, 'ddp-css-tina', 'tina-waiting-baby-sidebar');
            }

            if (strpos($post_content, 'tina_will_be_sidebar')) {
                add_post_meta($post_id, 'ddp-css-tina', 'tina-will-be-sidebar');
            }

            if (strpos($post_content, 'tina_this_life_sidebar')) {
                add_post_meta($post_id, 'ddp-css-tina', 'tina-this-life-sidebar');
            }

            if (strpos($post_content, 'tina_contentpage10_sidebar')) {
                add_post_meta($post_id, 'ddp-css-tina', 'tina-contentpage10-sidebar');
            }

            if (strpos($post_content, 'tina_the_sun_sidebar')) {
                add_post_meta($post_id, 'ddp-css-tina', 'tina-the-sun-sidebar');
            }

            if (strpos($post_content, 'sidewalk-contact')) {
                add_post_meta($post_id, 'ddp-css-tina', 'tina-sidewalk-contact-page');
            }

            if (strpos($post_content, 'tina_here_waiting_blurbs')) {
                add_post_meta($post_id, 'ddp-css-tina', 'tina-here-waiting-blurbs');
            }

            if (strpos($post_content, 'tina_my_friend_content')) {
                add_post_meta($post_id, 'ddp-css-tina', 'tina-my-friend-content');
            }

            if (strpos($post_content, 'tina_go_down_content')) {
                add_post_meta($post_id, 'ddp-css-tina', 'tina-go-down-content');
            }

            if (strpos($post_content, 'tina_good_times_blurbs')) {
                add_post_meta($post_id, 'ddp-css-tina', 'tina-good-times-blurbs');
            }

            if (strpos($post_content, 'tina_way_down_blurbs')) {
                add_post_meta($post_id, 'ddp-css-tina', 'tina-way-down-blurbs');
            }

            if (strpos($post_content, 'tina_wanna_content')) {
                add_post_meta($post_id, 'ddp-css-tina', 'tina-wanna-content');
            }

            if (strpos($post_content, 'tina_every_inch_testimonial')) {
                add_post_meta($post_id, 'ddp-css-tina', 'tina-every-inch-testimonial');
            }

            if (strpos($post_content, 'tina_come_on_blurbs')) {
                add_post_meta($post_id, 'ddp-css-tina', 'tina-come-on-blurbs');
            }

            if (strpos($post_content, 'tina_finest_girl_content')) {
                add_post_meta($post_id, 'ddp-css-tina', 'tina-finest-girl-content');
            }

            if (strpos($post_content, 'tina_know_girl_content')) {
                add_post_meta($post_id, 'ddp-css-tina', 'tina-know-girl-content');
            }

            if (strpos($post_content, 'tina_perks_content')) {
                add_post_meta($post_id, 'ddp-css-tina', 'tina-perks-content');
            }

            if (strpos($post_content, 'tina_your_decisions_header')) {
                add_post_meta($post_id, 'ddp-css-tina', 'tina-your-decisions-header');
            }

            if (strpos($post_content, 'tina_sometimes_content')) {
                add_post_meta($post_id, 'ddp-css-tina', 'tina-sometimes-content');
            }

            if (strpos($post_content, 'tina_and_that_tabs')) {
                add_post_meta($post_id, 'ddp-css-tina', 'tina-and-that-tabs');
            }

            if (strpos($post_content, 'tina_stronger_content')) {
                add_post_meta($post_id, 'ddp-css-tina', 'tina-stronger-content');
            }

            if (strpos($post_content, 'tina_you_again_tabs')) {
                add_post_meta($post_id, 'ddp-css-tina', 'tina-you-again-tabs');
            }

            if (strpos($post_content, 'tina_about_all_blog')) {
                add_post_meta($post_id, 'ddp-css-tina', 'tina-about-all-blog');
            }

            if (strpos($post_content, 'tina_I_can_footer')) {
                add_post_meta($post_id, 'ddp-css-tina', 'tina-I-can-footer');
            }

            if (strpos($post_content, 'tina_backdoor_man_content')) {
                add_post_meta($post_id, 'ddp-css-tina', 'tina-backdoor-man-content');
            }

            if (strpos($post_content, 'tina_coolin_content')) {
                add_post_meta($post_id, 'ddp-css-tina', 'tina-coolin-content');
            }

            if (strpos($post_content, 'tina_schoolin_content')) {
                add_post_meta($post_id, 'ddp-css-tina', 'tina-schoolin-content');
            }

            if (strpos($post_content, 'tina_every_inch_blurbs')) {
                add_post_meta($post_id, 'ddp-css-tina', 'tina-every-inch-blurbs');
            }

            if (strpos($post_content, 'tina_shake_content')) {
                add_post_meta($post_id, 'ddp-css-tina', 'tina-shake-content');
            }

            if (strpos($post_content, 'tina_girl_testimonial')) {
                add_post_meta($post_id, 'ddp-css-tina', 'tina-girl-testimonial');
            }

            // Accordions

            if (strpos($post_content, 'tina_accordion_chardge_of')) {
                add_post_meta($post_id, 'ddp-css-tina', 'tina-accordion-charge-of');
            }

            if (strpos($post_content, 'tina_accordion_you_alone')) {
                add_post_meta($post_id, 'ddp-css-tina', 'tina-accordion-you-alone');
            }

            if (strpos($post_content, 'tina_accordion_da_dap')) {
                add_post_meta($post_id, 'ddp-css-tina', 'tina-accordion-da-dap');
            }

            if (strpos($post_content, 'tina_accordion_looked_down')) {
                add_post_meta($post_id, 'ddp-css-tina', 'tina-accordion-looked-down');
            }

            if (strpos($post_content, 'tina_accordion_anybody')) {
                add_post_meta($post_id, 'ddp-css-tina', 'tina-accordion-anybody');
            }

            if (strpos($post_content, 'tina_accordion_the_start')) {
                add_post_meta($post_id, 'ddp-css-tina', 'tina-accordion-the-start');
            }

            if (strpos($post_content, 'tina_accordion_my_heart')) {
                add_post_meta($post_id, 'ddp-css-tina', 'tina-accordion-my-heart');
            }

            if (strpos($post_content, 'tina_accordion_my_home')) {
                add_post_meta($post_id, 'ddp-css-tina', 'tina-accordion-my-home');
            }

            if (strpos($post_content, 'tina_accordion_key_to')) {
                add_post_meta($post_id, 'ddp-css-tina', 'tina-accordion-key-to');
            }

            if (strpos($post_content, 'tina_accordion_common_sense')) {
                add_post_meta($post_id, 'ddp-css-tina', 'tina-accordion-common-sense');
            }

            if (strpos($post_content, 'tina_accordion_i_grew')) {
                add_post_meta($post_id, 'ddp-css-tina', 'tina-accordion-i-grew');
            }

            // accordions end

            if (strpos($post_content, 'tina_thinking_about_header')) {
                add_post_meta($post_id, 'ddp-css-tina', 'tina-thinking-about-header');
            }

            if (strpos($post_content, 'tina_the_past_content')) {
                add_post_meta($post_id, 'ddp-css-tina', 'tina-the-past-content');
            }

            if (strpos($post_content, 'tina_my_shoulder_blurbs')) {
                add_post_meta($post_id, 'ddp-css-tina', 'tina-my-shoulder-blurbs');
            }

            if (strpos($post_content, 'tina_lifetime_blurbs')) {
                add_post_meta($post_id, 'ddp-css-tina', 'tina-lifetime-blurbs');
            }

            if (strpos($post_content, 'tina_all_behind_blurbs')) {
                add_post_meta($post_id, 'ddp-css-tina', 'tina-all-behind-blurbs');
            }

            if (strpos($post_content, 'tina_all_behind_button')) {
                add_post_meta($post_id, 'ddp-css-tina', 'tina-all-behind-button');
            }

            if (strpos($post_content, 'tina_orgotten_moments_blurbs')) {
                add_post_meta($post_id, 'ddp-css-tina', 'tina-orgotten-moments-blurbs');
            }

            if (strpos($post_content, 'tina_other_lives_blurbs')) {
                add_post_meta($post_id, 'ddp-css-tina', 'tina-other-lives-blurbs');
            }

            if (strpos($post_content, 'tina_my_lover_blog')) {
                add_post_meta($post_id, 'ddp-css-tina', 'tina-my-lover-blog');
            }

            if (strpos($post_content, 'tina_I_breathe_footer')) {
                add_post_meta($post_id, 'ddp-css-tina', 'tina-I-breathe-footer');
            }

            if (strpos($post_content, 'tina_contact_3_')) {
                add_post_meta($post_id, 'ddp-css-tina', 'tina-contact-3-page');
            }

            if (strpos($post_content, 'tina_content_second_try')) {
                add_post_meta($post_id, 'ddp-css-tina', 'tina-content-second-try');
            }

            if (strpos($post_content, 'tina_contact_form_talk_now')) {
                add_post_meta($post_id, 'ddp-css-tina', 'tina-contact-form-talk-now');
            }

            if (strpos($post_content, 'tina_blurbs_hear_my')) {
                add_post_meta($post_id, 'ddp-css-tina', 'tina-blurbs-hear-my');
            }

            if (strpos($post_content, 'tina_content_eight_wheeler')) {
                add_post_meta($post_id, 'ddp-css-tina', 'tina-content-eight-wheeler');
            }

            if (strpos($post_content, 'tina_cta_im_moving')) {
                add_post_meta($post_id, 'ddp-css-tina', 'tina-cta-im-moving');
            }

            if (strpos($post_content, 'tina_testimonial_i_got')) {
                add_post_meta($post_id, 'ddp-css-tina', 'tina-testimonial-i-got');
            }

            if (strpos($post_content, 'tina_content_throttle')) {
                add_post_meta($post_id, 'ddp-css-tina', 'tina-content-throttle');
            }

            if (strpos($post_content, 'tina_content_ease')) {
                add_post_meta($post_id, 'ddp-css-tina', 'tina-content-ease');
            }

            if (strpos($post_content, 'tina_testimonial_you_got')) {
                add_post_meta($post_id, 'ddp-css-tina', 'tina-testimonial-you-got');
            }

            if (strpos($post_content, 'tina_content_listen')) {
                add_post_meta($post_id, 'ddp-css-tina', 'tina-content-listen');
            }

            if (strpos($post_content, 'tina_content_mister')) {
                add_post_meta($post_id, 'ddp-css-tina', 'tina-content-mister');
            }

            if (strpos($post_content, 'tina_testimonial_told_you')) {
                add_post_meta($post_id, 'ddp-css-tina', 'tina-testimonial-told-you');
            }

            if (strpos($post_content, 'tina_come_on_projects')) {
                add_post_meta($post_id, 'ddp-css-tina', 'tina-come-on-projects');
            }

            if (strpos($post_content, 'tina_blurbs_second_try')) {
                add_post_meta($post_id, 'ddp-css-tina', 'tina-blurbs-second-try');
            }

            if (strpos($post_content, 'tina_content_back_baby')) {
                add_post_meta($post_id, 'ddp-css-tina', 'tina-content-back-baby');
            }

            if (strpos($post_content, 'tina_content_wanna_hear')) {
                add_post_meta($post_id, 'ddp-css-tina', 'tina-content-wanna-hear');
            }

            if (strpos($post_content, 'tina_person_talk_now')) {
                add_post_meta($post_id, 'ddp-css-tina', 'tina-person-talk-now');
            }

            if (strpos($post_content, 'tina_slider_sail_away')) {
                add_post_meta($post_id, 'ddp-css-tina', 'tina-slider-sail-away');
            }

            if (strpos($post_content, 'tina_slider_you_take')) {
                add_post_meta($post_id, 'ddp-css-tina', 'tina-slider-you-take');
            }

            if (strpos($post_content, 'tina_slider_you_take_V2')) {
                add_post_meta($post_id, 'ddp-css-tina', 'tina-slider-you-take-v2');
            }

            if (strpos($post_content, 'tina_portfolio_bayou')) {
                add_post_meta($post_id, 'ddp-css-tina', 'tina-portfolio-bayou');
            }

            if (strpos($post_content, 'tina_portfolio_ribbon')) {
                add_post_meta($post_id, 'ddp-css-tina', 'tina-portfolio-ribbon');
            }

            if (strpos($post_content, 'tina_header_have_ridden')) {
                add_post_meta($post_id, 'ddp-css-tina', 'tina-header-have-ridden');
            }

            if (strpos($post_content, 'tina_numbers_orignal')) {
                add_post_meta($post_id, 'ddp-css-tina', 'tina-numbers-orignal');
            }

            if (strpos($post_content, 'tina_video_sage')) {
                add_post_meta($post_id, 'ddp-css-tina', 'tina-video-sage');
            }

            if (strpos($post_content, 'tina_case_studies_takes_two')) {
                add_post_meta($post_id, 'ddp-css-tina', 'tina-case-studies-takes-two');
            }

            if (strpos($post_content, 'tina_blurbs_me_and_you')) {
                add_post_meta($post_id, 'ddp-css-tina', 'tina-blurbs-me-and-you');
            }

            if (strpos($post_content, 'tina_footer_proud')) {
                add_post_meta($post_id, 'ddp-css-tina', 'tina-footer-proud');
            }

            if (strpos($post_content, 'tina_content_the_people')) {
                add_post_meta($post_id, 'ddp-css-tina', 'tina-content-the-people');
            }

            if (strpos($post_content, 'tina_content_the_fields')) {
                add_post_meta($post_id, 'ddp-css-tina', 'tina-content-the-fields');
            }

            if (strpos($post_content, 'tina_blurbs_church_house')) {
                add_post_meta($post_id, 'ddp-css-tina', 'tina-blurbs-church-house');
            }

            if (strpos($post_content, 'tina_content_call_it')) {
                add_post_meta($post_id, 'ddp-css-tina', 'tina-content-call-it');
            }

            if (strpos($post_content, 'tina_testimonial_go_to')) {
                add_post_meta($post_id, 'ddp-css-tina', 'tina-testimonial-go-to');
            }

            if (strpos($post_content, 'tina_person_call_it')) {
                add_post_meta($post_id, 'ddp-css-tina', 'tina-person-call-it');
            }

            if (strpos($post_content, 'tina_content_church_house')) {
                add_post_meta($post_id, 'ddp-css-tina', 'tina-content-church-house');
            }

            if (strpos($post_content, 'tina_blurbs_speed_limit')) {
                add_post_meta($post_id, 'ddp-css-tina', 'tina-blurbs-speed-limit');
            }

            if (strpos($post_content, 'tina_tabs_highway')) {
                add_post_meta($post_id, 'ddp-css-tina', 'tina-tabs-highway');
            }

            if (strpos($post_content, 'tina_testimonial_city_limites')) {
                add_post_meta($post_id, 'ddp-css-tina', 'tina-testimonial-city-limites');
            }

            if (strpos($post_content, 'tina_archive_1')) {
                add_post_meta($post_id, 'ddp-css-tina', 'tina-archive-1');
            }

            if (strpos($post_content, 'tina_footer_nutbush')) {
                add_post_meta($post_id, 'ddp-css-tina', 'tina-footer-nutbush');
            }

            if (strpos($post_content, 'tina_header_switched')) {
                add_post_meta($post_id, 'ddp-css-tina', 'tina-header-switched');
            }

            if (strpos($post_content, 'tina_blog_rain_falling')) {
                add_post_meta($post_id, 'ddp-css-tina', 'tina-blog-rain-falling');
            }

            if (strpos($post_content, 'tina_blog_bad_enough')) {
                add_post_meta($post_id, 'ddp-css-tina', 'tina-blog-bad-enough');
            }

            if (strpos($post_content, 'tina_products_working_for')) {
                add_post_meta($post_id, 'ddp-css-tina', 'tina-products-working-for');
            }

            if (strpos($post_content, 'tina_video_talk_much')) {
                add_post_meta($post_id, 'ddp-css-tina', 'tina-video-talk-much');
            }

            if (strpos($post_content, 'tina_blog_this_town')) {
                add_post_meta($post_id, 'ddp-css-tina', 'tina-blog-this-town');
            }

            if (strpos($post_content, 'tina_content_the_movies')) {
                add_post_meta($post_id, 'ddp-css-tina', 'tina-content-the-movies');
            }

            if (strpos($post_content, 'tina_pricing_tables_pinch_of')) {
                add_post_meta($post_id, 'ddp-css-tina', 'tina-pricing-tables-pinch-of');
            }

            if (strpos($post_content, 'tina_testimonial_one_can')) {
                add_post_meta($post_id, 'ddp-css-tina', 'tina-testimonial-one-can');
            }

            if (strpos($post_content, 'tina_pricing_1_footer')) {
                add_post_meta($post_id, 'ddp-css-tina', 'tina-pricing-1-footer');
            }

            if (strpos($post_content, 'tina_magazine_still_play_footer')) {
                add_post_meta($post_id, 'ddp-css-tina', 'tina-magazine-still-play-footer');
            }

            if (strpos($post_content, 'tina_header_pale_moon')) {
                add_post_meta($post_id, 'ddp-css-tina', 'tina-header-pale-moon');
            }

            if (strpos($post_content, 'tina_pricing_table_pretending')) {
                add_post_meta($post_id, 'ddp-css-tina', 'tina-pricing-table-pretending');
            }

            if (strpos($post_content, 'tina_testimonial_two_can')) {
                add_post_meta($post_id, 'ddp-css-tina', 'tina-testimonial-two-can');
            }

            if (strpos($post_content, 'tina_blog_1')) {
                add_post_meta($post_id, 'ddp-css-tina', 'tina-blog-1');
            }

            if (strpos($post_content, 'tina_blog_2')) {
                add_post_meta($post_id, 'ddp-css-tina', 'tina-blog-2');
            }

            if (strpos($post_content, 'tina_blog_3')) {
                add_post_meta($post_id, 'ddp-css-tina', 'tina-blog-3');
            }

            if (strpos($post_content, 'tina_blog_4')) {
                add_post_meta($post_id, 'ddp-css-tina', 'tina-blog-4');
            }

            if (strpos($post_content, 'tina_blog_5')) {
                add_post_meta($post_id, 'ddp-css-tina', 'tina-blog-5');
            }

            if (strpos($post_content, 'tina_blog_6')) {
                add_post_meta($post_id, 'ddp-css-tina', 'tina-blog-6');
            }

            if (strpos($post_content, 'tina_blog_7')) {
                add_post_meta($post_id, 'ddp-css-tina', 'tina-blog-7');
            }

            if (strpos($post_content, 'tina_header_girls')) {
                add_post_meta($post_id, 'ddp-css-tina', 'tina-header-girls');
            }

            if (strpos($post_content, 'tina_content_lets_dance')) {
                add_post_meta($post_id, 'ddp-css-tina', 'tina-content-lets-dance');
            }

            if (strpos($post_content, 'tina_content_broom')) {
                add_post_meta($post_id, 'ddp-css-tina', 'tina-content-broom');
            }

            if (strpos($post_content, 'tina_testimonials_idolize_you')) {
                add_post_meta($post_id, 'ddp-css-tina', 'tina-testimonials-idolize-you');
            }

            if (strpos($post_content, 'tina_numbers_acid')) {
                add_post_meta($post_id, 'ddp-css-tina', 'tina-numbers-acid');
            }

            if (strpos($post_content, 'tina_pricing_table_tonight')) {
                add_post_meta($post_id, 'ddp-css-tina', 'tina-pricing-table-tonight');
            }

            if (strpos($post_content, 'tina_person_module_open_arms')) {
                add_post_meta($post_id, 'ddp-css-tina', 'tina-person-module-open-arms');
            }

            if (strpos($post_content, 'tina_blurbs_I_see')) {
                add_post_meta($post_id, 'ddp-css-tina', 'tina-blurbs-i-see');
            }

            if (strpos($post_content, 'tina_header_steam')) {
                add_post_meta($post_id, 'ddp-css-tina', 'tina-header-steam');
            }

            if (strpos($post_content, 'tina_content_universe')) {
                add_post_meta($post_id, 'ddp-css-tina', 'tina-content-universe');
            }

            if (strpos($post_content, 'tina_content_liberty')) {
                add_post_meta($post_id, 'ddp-css-tina', 'tina-content-liberty');
            }

            if (strpos($post_content, 'tina_content_cause')) {
                add_post_meta($post_id, 'ddp-css-tina', 'tina-content-cause');
            }

            if (strpos($post_content, 'tina_content_producers')) {
                add_post_meta($post_id, 'ddp-css-tina', 'tina-content-producers');
            }

            if (strpos($post_content, 'tina_content_eternal')) {
                add_post_meta($post_id, 'ddp-css-tina', 'tina-content-eternal');
            }

            if (strpos($post_content, 'tina_testimonials_lead_3')) {
                add_post_meta($post_id, 'ddp-css-tina', 'tina-testimonials-lead-3');
            }

            if (strpos($post_content, 'tina_header_crazy')) {
                add_post_meta($post_id, 'ddp-css-tina', 'tina-header-crazy');
            }

            if (strpos($post_content, 'tina_content_way')) {
                add_post_meta($post_id, 'ddp-css-tina', 'tina-content-way');
            }

            if (strpos($post_content, 'tina_blurb_white')) {
                add_post_meta($post_id, 'ddp-css-tina', 'tina-blurb-white');
            }

            if (strpos($post_content, 'tina_trusted_by_logo')) {
                add_post_meta($post_id, 'ddp-css-tina', 'tina-trusted-by-logo');
            }

            if (strpos($post_content, 'tina_testimonial_finest_girl')) {
                add_post_meta($post_id, 'ddp-css-tina', 'tina-testimonial-finest-girl');
            }

            if (strpos($post_content, 'tina_pricing_table_it_on')) {
                add_post_meta($post_id, 'ddp-css-tina', 'tina-pricing-table-it-on');
            }

            // Tina ends

            // Ragnar

            // for 25 Nov

            if (strpos($post_content, 'ragnar_header_arne')) {
                add_post_meta($post_id, 'ddp-css-ragnar', 'ragnar-header-arne');
            }

            if (strpos($post_content, 'ragnar_content_eagle')) {
                add_post_meta($post_id, 'ddp-css-ragnar', 'ragnar-content-eagle');
            }

            if (strpos($post_content, 'ragnar_blurbs_birger')) {
                add_post_meta($post_id, 'ddp-css-ragnar', 'ragnar-blurbs-birger');
            }

            if (strpos($post_content, 'ragnar_blurbs_keeper')) {
                add_post_meta($post_id, 'ddp-css-ragnar', 'ragnar-blurbs-keeper');
            }

            if (strpos($post_content, 'ragnar_blog_bjorn')) {
                add_post_meta($post_id, 'ddp-css-ragnar', 'ragnar-blog-bjorn');
            }

            if (strpos($post_content, 'ragnar_content_bear')) {
                add_post_meta($post_id, 'ddp-css-ragnar', 'ragnar-content-bear');
            }

            if (strpos($post_content, 'ragnar_footer_ro') || strpos($post_content, 'ragnar_footer_bo')) {
                add_post_meta($post_id, 'ddp-css-ragnar', 'ragnar-footer-bo');
            }

            if (strpos($post_content, 'ragnar_header_resident')) {
                add_post_meta($post_id, 'ddp-css-ragnar', 'ragnar-header-resident');
            }

            if (strpos($post_content, 'ragnar_content_erik')) {
                add_post_meta($post_id, 'ddp-css-ragnar', 'ragnar-content-erik');
            }

            if (strpos($post_content, 'ragnar_blurbs_ruler')) {
                add_post_meta($post_id, 'ddp-css-ragnar', 'ragnar-blurbs-ruler');
            }

            if (strpos($post_content, 'ragnar_content_frode')) {
                add_post_meta($post_id, 'ddp-css-ragnar', 'ragnar-content-frode');
            }

            if (strpos($post_content, 'ragnar_tesimonails_gorm')) {
                add_post_meta($post_id, 'ddp-css-ragnar', 'ragnar-testimonails-gorm');
            }

            if (strpos($post_content, 'ragnar_blog_halfdan')) {
                add_post_meta($post_id, 'ddp-css-ragnar', 'ragnar-blog-halfdan');
            }

            if (strpos($post_content, 'ragnar_footer_danish')) {
                add_post_meta($post_id, 'ddp-css-ragnar', 'ragnar-footer-danish');
            }

            if (strpos($post_content, 'ragnar_header_left')) {
                add_post_meta($post_id, 'ddp-css-ragnar', 'ragnar-header-left');
            }

            if (strpos($post_content, 'ragnar_content_curly')) {
                add_post_meta($post_id, 'ddp-css-ragnar', 'ragnar-content-curly');
            }

            if (strpos($post_content, 'ragnar_content_kare')) {
                add_post_meta($post_id, 'ddp-css-ragnar', 'ragnar-content-kare');
            }

            if (strpos($post_content, 'ragnar_content_knot')) {
                add_post_meta($post_id, 'ddp-css-ragnar', 'ragnar-content-knot');
            }

            if (strpos($post_content, 'ragnar_blog_knud')) {
                add_post_meta($post_id, 'ddp-css-ragnar', 'ragnar-blog-knud');
            }

            if (strpos($post_content, 'ragnar_header_descendant')) {
                add_post_meta($post_id, 'ddp-css-ragnar', 'ragnar-header-descendant');
            }

            if (strpos($post_content, 'ragnar_content_njal')) {
                add_post_meta($post_id, 'ddp-css-ragnar', 'ragnar-content-njal');
            }

            if (strpos($post_content, 'ragnar_content_giant')) {
                add_post_meta($post_id, 'ddp-css-ragnar', 'ragnar-content-giant');
            }

            if (strpos($post_content, 'ragnar_content_roar')) {
                add_post_meta($post_id, 'ddp-css-ragnar', 'ragnar-content-roar');
            }

            if (strpos($post_content, 'ragnar_content_fame')) {
                add_post_meta($post_id, 'ddp-css-ragnar', 'ragnar-content-fame');
            }

            if (strpos($post_content, 'ragnar_blog_rune')) {
                add_post_meta($post_id, 'ddp-css-ragnar', 'ragnar-blog-rune');
            }

            if (strpos($post_content, 'ragnar_content_movin_on')) {
                add_post_meta($post_id, 'ddp-css-ragnar', 'ragnar-content-movin-on');
            }

            if (strpos($post_content, 'ragnar_content_wheeler')) {
                add_post_meta($post_id, 'ddp-css-ragnar', 'ragnar-content-wheeler');
            }

            if (strpos($post_content, 'ragnar_testimonial_daddy')) {
                add_post_meta($post_id, 'ddp-css-ragnar', 'ragnar-testimonial-daddy');
            }

            if (strpos($post_content, 'ragnar_blog_loud_whistle')) {
                add_post_meta($post_id, 'ddp-css-ragnar', 'ragnar-blog-loud-whistle');
            }

            if (strpos($post_content, 'ragnar_footer_my_mother')) {
                add_post_meta($post_id, 'ddp-css-ragnar', 'ragnar-footer-my-mother');
            }


            // for 26 Nov

            if (strpos($post_content, 'ragnar_contact_trygve_office')) {
                add_post_meta($post_id, 'ddp-css-ragnar', 'ragnar-contact-trygve');
            }

            if (strpos($post_content, 'ragnar_footer_harald')) {
                add_post_meta($post_id, 'ddp-css-ragnar', 'ragnar-footer-harald');
            }


            if (strpos($post_content, 'ragnar_header_wolf')) {
                add_post_meta($post_id, 'ddp-css-ragnar', 'ragnar-header-wolf');
            }

            if (strpos($post_content, 'ragnar_contact_wealth')) {
                add_post_meta($post_id, 'ddp-css-ragnar', 'ragnar-contact-wealth');
            }


            if (strpos($post_content, 'ragnar_header_age')) {
                add_post_meta($post_id, 'ddp-css-ragnar', 'ragnar-header-age');
            }

            if (strpos($post_content, 'ragnar_contact_ploughs')) {
                add_post_meta($post_id, 'ddp-css-ragnar', 'ragnar-contact-ploughs');
            }

            if (strpos($post_content, 'ragnar_person_ancestor')) {
                add_post_meta($post_id, 'ddp-css-ragnar', 'ragnar-person-ancestor');
            }


            if (strpos($post_content, 'ragnar_contact_loved')) {
                add_post_meta($post_id, 'ddp-css-ragnar', 'ragnar-contact-loved');
            }

            if (strpos($post_content, 'ragnar_content_astrid')) {
                add_post_meta($post_id, 'ddp-css-ragnar', 'ragnar-content-astrid');
            }


            if (strpos($post_content, 'ragnar_content_bodil')) {
                add_post_meta($post_id, 'ddp-css-ragnar', 'ragnar-content-bodil');
            }

            if (strpos($post_content, 'ragnar_contact_penance')) {
                add_post_meta($post_id, 'ddp-css-ragnar', 'ragnar-contact-penance');
            }


            if (strpos($post_content, 'ragnar_content_tove')) {
                add_post_meta($post_id, 'ddp-css-ragnar', 'ragnar-content-tove');
            }

            if (strpos($post_content, 'ragnar_contact_form_dove')) {
                add_post_meta($post_id, 'ddp-css-ragnar', 'ragnar-contact-form-dove');
            }


            if (strpos($post_content, 'ragnar_header_toke')) {
                add_post_meta($post_id, 'ddp-css-ragnar', 'ragnar-header-toke');
            }

            if (strpos($post_content, 'ragnar_slider_thor')) {
                add_post_meta($post_id, 'ddp-css-ragnar', 'ragnar-slider-thor');
            }

            if (strpos($post_content, 'ragnar_content_helmet')) {
                add_post_meta($post_id, 'ddp-css-ragnar', 'ragnar-content-helmet');
            }

            if (strpos($post_content, 'ragnar_content_torsten')) {
                add_post_meta($post_id, 'ddp-css-ragnar', 'ragnar-content-torsten');
            }


            if (strpos($post_content, 'ragnar_slider_voice_id_sing')) {
                add_post_meta($post_id, 'ddp-css-ragnar', 'ragnar-slider-voice-id-sing');
            }

            if (strpos($post_content, 'ragnar_content_noble_barque')) {
                add_post_meta($post_id, 'ddp-css-ragnar', 'ragnar-content-noble-barque');
            }

            if (strpos($post_content, 'ragnar_content_i_steer')) {
                add_post_meta($post_id, 'ddp-css-ragnar', 'ragnar-content-i-steer');
            }

            if (strpos($post_content, 'ragnar_projects_good_oars')) {
                add_post_meta($post_id, 'ddp-css-ragnar', 'ragnar-projects-good-oars');
            }


            if (strpos($post_content, 'ragnar_person_module_roar')) {
                add_post_meta($post_id, 'ddp-css-ragnar', 'ragnar-person-module-roar');
            }

            if (strpos($post_content, 'ragnar_content_spear')) {
                add_post_meta($post_id, 'ddp-css-ragnar', 'ragnar-content-spear');
            }


            if (strpos($post_content, 'ragnar_portfolio_good_oars')) {
                add_post_meta($post_id, 'ddp-css-ragnar', 'ragnar-portfolio-good-oars');
            }

            if (strpos($post_content, 'ragnar_subscribe_galleys')) {
                add_post_meta($post_id, 'ddp-css-ragnar', 'ragnar-subscribe-galleys');
            }


            // for 27 Nov


            if (strpos($post_content, 'ragnar_menu_farmer')) {
                add_post_meta($post_id, 'ddp-css-ragnar', 'ragnar-menu-farmer');
            }

            if (strpos($post_content, 'ragnar_menu_hulks')) {
                add_post_meta($post_id, 'ddp-css-ragnar', 'ragnar-menu-hulks');
            }

            if (strpos($post_content, 'ragnar_menu_idun')) {
                add_post_meta($post_id, 'ddp-css-ragnar', 'ragnar-menu-idun');
            }

            if (strpos($post_content, 'ragnar_menu_longhouse')) {
                add_post_meta($post_id, 'ddp-css-ragnar', 'ragnar-menu-longhouse');
            }

            if (strpos($post_content, 'ragnar_menu_pursuit')) {
                add_post_meta($post_id, 'ddp-css-ragnar', 'ragnar-menu-pursuit');
            }

            if (strpos($post_content, 'ragnar_menu_skalds')) {
                add_post_meta($post_id, 'ddp-css-ragnar', 'ragnar-menu-skalds');
            }

            if (strpos($post_content, 'ragnar_menu_valhalla')) {
                add_post_meta($post_id, 'ddp-css-ragnar', 'ragnar-menu-valhalla');
            }

            if (strpos($post_content, 'ragnar_menu_odin')) {
                add_post_meta($post_id, 'ddp-css-ragnar', 'ragnar-menu-odin');
            }

            if (strpos($post_content, 'ragnar_menu_stolen')) {
                add_post_meta($post_id, 'ddp-css-ragnar', 'ragnar-menu-stolen');
            }

            if (strpos($post_content, 'ragnar_menu_giants')) {
                add_post_meta($post_id, 'ddp-css-ragnar', 'ragnar-menu-giants');
            }


            if (strpos($post_content, 'ragnar_menu_titan')) {
                add_post_meta($post_id, 'ddp-css-ragnar', 'ragnar-menu-titan');
            }

            // for 30 Nov

            if (strpos($post_content, 'ragnar-not-found-1')) {
                add_post_meta($post_id, 'ddp-css-ragnar', 'ragnar-not-found-1');
            }

            if (strpos($post_content, 'ragnar-not-found-2')) {
                add_post_meta($post_id, 'ddp-css-ragnar', 'ragnar-not-found-2');
            }

            if (strpos($post_content, 'ragnar-not-found-3')) {
                add_post_meta($post_id, 'ddp-css-ragnar', 'ragnar-not-found-3');
            }

            if (strpos($post_content, 'ragnar-not-found-4')) {
                add_post_meta($post_id, 'ddp-css-ragnar', 'ragnar-not-found-4');
            }

            if (strpos($post_content, 'ragnar-not-found-5')) {
                add_post_meta($post_id, 'ddp-css-ragnar', 'ragnar-not-found-5');
            }

            if (strpos($post_content, 'ragnar-not-found-6')) {
                add_post_meta($post_id, 'ddp-css-ragnar', 'ragnar-not-found-6');
            }

            if (strpos($post_content, 'ragnar-not-found-7')) {
                add_post_meta($post_id, 'ddp-css-ragnar', 'ragnar-not-found-7');
            }

            if (strpos($post_content, 'ragnar-not-found-8')) {
                add_post_meta($post_id, 'ddp-css-ragnar', 'ragnar-not-found-8');
            }

            if (strpos($post_content, 'ragnar-not-found-9')) {
                add_post_meta($post_id, 'ddp-css-ragnar', 'ragnar-not-found-9');
            }

            if (strpos($post_content, 'ragnar-not-found-10')) {
                add_post_meta($post_id, 'ddp-css-ragnar', 'ragnar-not-found-10');
            }

            if (strpos($post_content, 'ragnar-not-found-11')) {
                add_post_meta($post_id, 'ddp-css-ragnar', 'ragnar-not-found-11');
            }

            if (strpos($post_content, 'ragnar-not-found-12')) {
                add_post_meta($post_id, 'ddp-css-ragnar', 'ragnar-not-found-12');
            }

            if (strpos($post_content, 'ragnar-not-found-13')) {
                add_post_meta($post_id, 'ddp-css-ragnar', 'ragnar-not-found-13');
            }

            if (strpos($post_content, 'ragnar-not-found-14')) {
                add_post_meta($post_id, 'ddp-css-ragnar', 'ragnar-not-found-14');
            }

            if (strpos($post_content, 'ragnar-not-found-15')) {
                add_post_meta($post_id, 'ddp-css-ragnar', 'ragnar-not-found-15');
            }

            if (strpos($post_content, 'ragnar-not-found-16')) {
                add_post_meta($post_id, 'ddp-css-ragnar', 'ragnar-not-found-16');
            }

            if (strpos($post_content, 'ragnar-not-found-17')) {
                add_post_meta($post_id, 'ddp-css-ragnar', 'ragnar-not-found-17');
            }

            if (strpos($post_content, 'ragnar-not-found-18')) {
                add_post_meta($post_id, 'ddp-css-ragnar', 'ragnar-not-found-18');
            }

            if (strpos($post_content, 'ragnar-not-found-19')) {
                add_post_meta($post_id, 'ddp-css-ragnar', 'ragnar-not-found-19');
            }

            if (strpos($post_content, 'ragnar-not-found-20')) {
                add_post_meta($post_id, 'ddp-css-ragnar', 'ragnar-not-found-20');
            }

            if (strpos($post_content, 'ragnar-not-found-21')) {
                add_post_meta($post_id, 'ddp-css-ragnar', 'ragnar-not-found-21');
            }

            // for 2 Dec

            for ($i = 1; $i < 18; $i++) {
                if (strpos($post_content, 'ragnar_popups_'.$i)) {
                    add_post_meta($post_id, 'ddp-css-ragnar', 'ragnar-popups-'.$i);
                }
            }

            for ($i = 1; $i < 10; $i++) {
                if (strpos($post_content, 'ragnar_coming_soon_'.$i)) {
                    add_post_meta($post_id, 'ddp-css-ragnar', 'ragnar-coming-soon-'.$i);
                }
            }

            // for 2 Feb

            if (strpos($post_content, 'ragnar_cta_loud_whistle')) {
                add_post_meta($post_id, 'ddp-css-ragnar', 'ragnar-cta-loud-whistle');
            }

            if (strpos($post_content, 'ragnar_tabs_the_track')) {
                add_post_meta($post_id, 'ddp-css-ragnar', 'ragnar-tabs-the-track');
            }

            if (strpos($post_content, 'ragnar_content_little_old')) {
                add_post_meta($post_id, 'ddp-css-ragnar', 'ragnar-content-little-old');
            }

            if (strpos($post_content, 'ragnar_content_descendant')) {
                add_post_meta($post_id, 'ddp-css-ragnar', 'ragnar-content-descendant');
            }

            if (strpos($post_content, 'ragnar_content_njal_v2')) {
                add_post_meta($post_id, 'ddp-css-ragnar', 'ragnar-content-njal-v2');
            }

            if (strpos($post_content, 'ragnar_person_leif')) {
                add_post_meta($post_id, 'ddp-css-ragnar', 'ragnar-person-leif');
            }

            if (strpos($post_content, 'ragnar_header_rune')) {
                add_post_meta($post_id, 'ddp-css-ragnar', 'ragnar-header-rune');
            }

            if (strpos($post_content, 'ragnar_content_secret')) {
                add_post_meta($post_id, 'ddp-css-ragnar', 'ragnar-content-secret');
            }

            if (strpos($post_content, 'ragnar_content_sten')) {
                add_post_meta($post_id, 'ddp-css-ragnar', 'ragnar-content-sten');
            }

            if (strpos($post_content, 'ragnar_blurbs_stone')) {
                add_post_meta($post_id, 'ddp-css-ragnar', 'ragnar-blurbs-stone');
            }

            if (strpos($post_content, 'ragnar_content_skarde')) {
                add_post_meta($post_id, 'ddp-css-ragnar', 'ragnar-content-skarde');
            }

            if (strpos($post_content, 'ragnar_accordion_stone')) {
                add_post_meta($post_id, 'ddp-css-ragnar', 'ragnar-accordion-stone');
            }

            if (strpos($post_content, 'ragnar_blog_skarde')) {
                add_post_meta($post_id, 'ddp-css-ragnar', 'ragnar-blog-skarde');
            }

            if (strpos($post_content, 'ragnar_blog_sten')) {
                add_post_meta($post_id, 'ddp-css-ragnar', 'ragnar-blog-sten');
            }

            if (strpos($post_content, 'ragnar_blurbs_chin')) {
                add_post_meta($post_id, 'ddp-css-ragnar', 'ragnar-blurbs-chin');
            }

            if (strpos($post_content, 'ragnar_blurbs_cleft')) {
                add_post_meta($post_id, 'ddp-css-ragnar', 'ragnar-blurbs-cleft');
            }

            if (strpos($post_content, 'ragnar_blurbs_freeman')) {
                add_post_meta($post_id, 'ddp-css-ragnar', 'ragnar-blurbs-freeman');
            }

            if (strpos($post_content, 'ragnar_blurbs_svend')) {
                add_post_meta($post_id, 'ddp-css-ragnar', 'ragnar-blurbs-svend');
            }

            if (strpos($post_content, 'ragnar_footer_secret')) {
                add_post_meta($post_id, 'ddp-css-ragnar', 'ragnar-footer-secret');
            }

            if (strpos($post_content, 'ragnar_header_son')) {
                add_post_meta($post_id, 'ddp-css-ragnar', 'ragnar-header-son');
            }

            for ($i = 1; $i < 14; $i++) {
                if (strpos($post_content, 'ragnar_thank_you_'.$i)) {
                    add_post_meta($post_id, 'ddp-css-ragnar', 'ragnar-thank-you-'.$i);
                }
            }



            // for 30 March

            if (strpos($post_content, 'ragnar_portfolio_william')) {
                add_post_meta($post_id, 'ddp-css-ragnar', 'ragnar-portfolio-william');
            }

            if (strpos($post_content, 'ragnar_header_freja')) {
                add_post_meta($post_id, 'ddp-css-ragnar', 'ragnar-header-freja');
            }

            if (strpos($post_content, 'ragnar_products_josefine')) {
                add_post_meta($post_id, 'ddp-css-ragnar', 'ragnar-products-josefine');
            }

            if (strpos($post_content, 'ragnar_content_karla')) {
                add_post_meta($post_id, 'ddp-css-ragnar', 'ragnar-content-karla');
            }

            if (strpos($post_content, 'ragnar_products_clara')) {
                add_post_meta($post_id, 'ddp-css-ragnar', 'ragnar-products-clara');
            }

            if (strpos($post_content, 'ragnar_content_anna')) {
                add_post_meta($post_id, 'ddp-css-ragnar', 'ragnar-content-anna');
            }

            if (strpos($post_content, 'ragnar_content_laura')) {
                add_post_meta($post_id, 'ddp-css-ragnar', 'ragnar-content-laura');
            }

            if (strpos($post_content, 'ragnar_header_my_thumb')) {
                add_post_meta($post_id, 'ddp-css-ragnar', 'ragnar-header-my-thumb');
            }

            if (strpos($post_content, 'ragnar_content_feels_alright')) {
                add_post_meta($post_id, 'ddp-css-ragnar', 'ragnar-content-feels-alright');
            }

            if (strpos($post_content, 'ragnar_lead_page_v1')) {
                add_post_meta($post_id, 'ddp-css-ragnar', 'ragnar-lead-page-v1');
            }

            if (strpos($post_content, 'ragnar_content_easy_babe')) {
                add_post_meta($post_id, 'ddp-css-ragnar', 'ragnar-content-easy-babe');
            }

            if (strpos($post_content, 'ragnar_content_the_change')) {
                add_post_meta($post_id, 'ddp-css-ragnar', 'ragnar-content-the-change');
            }

            if (strpos($post_content, 'ragnar_person_the_difference')) {
                add_post_meta($post_id, 'ddp-css-ragnar', 'ragnar-person-the-difference');
            }

            if (strpos($post_content, 'ragnar_blog_adrian')) {
                add_post_meta($post_id, 'ddp-css-ragnar', 'ragnar-blog-adrian');
            }

            if (strpos($post_content, 'ragnar_blog_agata')) {
                add_post_meta($post_id, 'ddp-css-ragnar', 'ragnar-blog-agata');
            }

            if (strpos($post_content, 'ragnar_blog_agneta')) {
                add_post_meta($post_id, 'ddp-css-ragnar', 'ragnar-blog-agneta');
            }

            if (strpos($post_content, 'ragnar_blog_aina')) {
                add_post_meta($post_id, 'ddp-css-ragnar', 'ragnar-blog-aina');
            }

            if (strpos($post_content, 'ragnar_blog_ake')) {
                add_post_meta($post_id, 'ddp-css-ragnar', 'ragnar-blog-ake');
            }

            if (strpos($post_content, 'ragnar_blog_albert')) {
                add_post_meta($post_id, 'ddp-css-ragnar', 'ragnar-blog-albert');
            }

            if (strpos($post_content, 'ragnar_blog_albin')) {
                add_post_meta($post_id, 'ddp-css-ragnar', 'ragnar-blog-albin');
            }

            if (strpos($post_content, 'ragnar_blog_alexander')) {
                add_post_meta($post_id, 'ddp-css-ragnar', 'ragnar-blog-alexander');
            }

            if (strpos($post_content, 'ragnar_blog_light_alfred')) {
                add_post_meta($post_id, 'ddp-css-ragnar', 'ragnar-blog-light-alfred');
            }

            if (strpos($post_content, 'ragnar_blog_alma')) {
                add_post_meta($post_id, 'ddp-css-ragnar', 'ragnar-blog-alma');
            }


//        For April 27

            if (strpos($post_content, 'ragnar_portfolio_noah')) {
                add_post_meta($post_id, 'ddp-css-ragnar', 'ragnar-portfolio-noah');
            }

            if (strpos($post_content, 'ragnar_header_alberte')) {
                add_post_meta($post_id, 'ddp-css-ragnar', 'ragnar-header-alberte');
            }

            if (strpos($post_content, 'ragnar_products_olivia')) {
                add_post_meta($post_id, 'ddp-css-ragnar', 'ragnar-products-olivia');
            }

            if (strpos($post_content, 'ragnar_content_agnes')) {
                add_post_meta($post_id, 'ddp-css-ragnar', 'ragnar-content-agnes');
            }

            if (strpos($post_content, 'ragnar_products_nora')) {
                add_post_meta($post_id, 'ddp-css-ragnar', 'ragnar-products-nora');
            }

            if (strpos($post_content, 'ragnar_content_luna')) {
                add_post_meta($post_id, 'ddp-css-ragnar', 'ragnar-content-luna');
            }

            if (strpos($post_content, 'ragnar_footer_isabella')) {
                add_post_meta($post_id, 'ddp-css-ragnar', 'ragnar-footer-isabella');
            }

            if (strpos($post_content, 'ragnar_pricing_table_cecilia')) {
                add_post_meta($post_id, 'ddp-css-ragnar', 'ragnar-pricing-table-cecilia');
            }

            if (strpos($post_content, 'ragnar_pricing_table_dagmar')) {
                add_post_meta($post_id, 'ddp-css-ragnar', 'ragnar-pricing-table-dagmar');
            }

            if (strpos($post_content, 'ragnar_pricing_table_eleonora')) {
                add_post_meta($post_id, 'ddp-css-ragnar', 'ragnar-pricing-table-eleonora');
            }

            if (strpos($post_content, 'ragnar_pricing_table_elin')) {
                add_post_meta($post_id, 'ddp-css-ragnar', 'ragnar-pricing-table-elin');
            }

            if (strpos($post_content, 'ragnar_pricing_table_ellinor')) {
                add_post_meta($post_id, 'ddp-css-ragnar', 'ragnar-pricing-table-ellinor');
            }

            if (strpos($post_content, 'ragnar_pricing_table_emil')) {
                add_post_meta($post_id, 'ddp-css-ragnar', 'ragnar-pricing-table-emil');
            }

            if (strpos($post_content, 'ragnar_pricing_table_emilia')) {
                add_post_meta($post_id, 'ddp-css-ragnar', 'ragnar-pricing-table-emilia');
            }

            if (strpos($post_content, 'ragnar_pricing_table_emma')) {
                add_post_meta($post_id, 'ddp-css-ragnar', 'ragnar-pricing-table-emma');
            }

            if (strpos($post_content, 'ragnar_pricing_table_enar')) {
                add_post_meta($post_id, 'ddp-css-ragnar', 'ragnar-pricing-table-enar');
            }



            //        For June 2021

            if (strpos($post_content, 'ragnar_portfolio_valdemar')) {
                add_post_meta($post_id, 'ddp-css-ragnar', 'ragnar-portfolio-valdemar');
            }

            if (strpos($post_content, 'ragnar_blog_ida')) {
                add_post_meta($post_id, 'ddp-css-ragnar', 'ragnar-blog-ida');
            }

            if (strpos($post_content, 'ragnar_blurbs_emma')) {
                add_post_meta($post_id, 'ddp-css-ragnar', 'ragnar-blurbs-emma');
            }

            if (strpos($post_content, 'ragnar_header_emil')) {
                add_post_meta($post_id, 'ddp-css-ragnar', 'ragnar-header-emil');
            }

            if (strpos($post_content, 'ragnar_products_elias')) {
                add_post_meta($post_id, 'ddp-css-ragnar', 'ragnar-products-elias');
            }

            if (strpos($post_content, 'ragnar_content_aksel')) {
                add_post_meta($post_id, 'ddp-css-ragnar', 'ragnar-content-aksel');
            }

            if (strpos($post_content, 'ragnar_blog_august')) {
                add_post_meta($post_id, 'ddp-css-ragnar', 'ragnar-blog-august');
            }

            if (strpos($post_content, 'ragnar_header_gabriella')) {
                add_post_meta($post_id, 'ddp-css-ragnar', 'ragnar-header-gabriella');
            }

            if (strpos($post_content, 'ragnar_content_frideborg')) {
                add_post_meta($post_id, 'ddp-css-ragnar', 'ragnar-content-frideborg');
            }

            if (strpos($post_content, 'ragnar_person_fredek')) {
                add_post_meta($post_id, 'ddp-css-ragnar', 'ragnar-person-fredek');
            }

            if (strpos($post_content, 'ragnar_blurbs_frans')) {
                add_post_meta($post_id, 'ddp-css-ragnar', 'ragnar-blurbs-frans');
            }

            if (strpos($post_content, 'ragnar_cta_felix')) {
                add_post_meta($post_id, 'ddp-css-ragnar', 'ragnar-cta-felix');
            }

            if (strpos($post_content, 'ragnar_post_v1')) {
                add_post_meta($post_id, 'ddp-css-ragnar', 'ragnar-post-v1');
            }


            //        For July 2021

            if (strpos($post_content, 'ragnar_post_v2')) {
                add_post_meta($post_id, 'ddp-css-ragnar', 'ragnar-post-v2');
            }

            if (strpos($post_content, 'ragnar_gallery_erik')) {
                add_post_meta($post_id, 'ddp-css-ragnar', 'ragnar-gallery-erik');
            }

            if (strpos($post_content, 'ragnar_gallery_esbjorn')) {
                add_post_meta($post_id, 'ddp-css-ragnar', 'ragnar-gallery-esbjorn');
            }

            if (strpos($post_content, 'ragnar_gallery_eskil')) {
                add_post_meta($post_id, 'ddp-css-ragnar', 'ragnar-gallery-eskil');
            }

            if (strpos($post_content, 'ragnar_gallery_eva')) {
                add_post_meta($post_id, 'ddp-css-ragnar', 'ragnar-gallery-eva');
            }

            if (strpos($post_content, 'ragnar_gallery_evelina')) {
                add_post_meta($post_id, 'ddp-css-ragnar', 'ragnar-gallery-evelina');
            }

            if (strpos($post_content, 'ragnar_gallery_evert')) {
                add_post_meta($post_id, 'ddp-css-ragnar', 'ragnar-gallery-evert');
            }

            if (strpos($post_content, 'ragnar_gallery_fabian')) {
                add_post_meta($post_id, 'ddp-css-ragnar', 'ragnar-gallery-fabian');
            }

            if (strpos($post_content, 'ragnar_blog_olympus')) {
                add_post_meta($post_id, 'ddp-css-ragnar', 'ragnar-blog-olympus');
            }

            if (strpos($post_content, 'ragnar_blurbs_oliver')) {
                add_post_meta($post_id, 'ddp-css-ragnar', 'ragnar-blurbs-oliver');
            }

            if (strpos($post_content, 'ragnar_header_gorm')) {
                add_post_meta($post_id, 'ddp-css-ragnar', 'ragnar-header-gorm');
            }

            if (strpos($post_content, 'ragnar_products_benta')) {
                add_post_meta($post_id, 'ddp-css-ragnar', 'ragnar-products-benta');
            }

            if (strpos($post_content, 'ragnar_content_gala')) {
                add_post_meta($post_id, 'ddp-css-ragnar', 'ragnar-content-gala');
            }

            if (strpos($post_content, 'ragnar_person_garth')) {
                add_post_meta($post_id, 'ddp-css-ragnar', 'ragnar-person-garth');
            }
        
            if (strpos($post_content, 'ragnar_content_malthe')) {
                add_post_meta($post_id, 'ddp-css-ragnar', 'ragnar-content-malthe');
            }
             
            if (strpos($post_content, 'ragnar_content_victor')) {
                add_post_meta($post_id, 'ddp-css-ragnar', 'ragnar-content-victor');
            }
        
            if (strpos($post_content, 'ragnar_blurbs_annali')) {
                add_post_meta($post_id, 'ddp-css-ragnar', 'ragnar-blurbs-annali');
            }
        
            if (strpos($post_content, 'ragnar_header_arvid')) {
                add_post_meta($post_id, 'ddp-css-ragnar', 'ragnar-header-arvid');
            }
        
            if (strpos($post_content, 'ragnar_blurbs_beck')) {
                add_post_meta($post_id, 'ddp-css-ragnar', 'ragnar-blurbs-beck');
            }
      
            if (strpos($post_content, 'ragnar_header_baltasar')) {
                add_post_meta($post_id, 'ddp-css-ragnar', 'ragnar-header-baltasar');
            }
        
            if (strpos($post_content, 'ragnar_blurbs_gerda')) {
                add_post_meta($post_id, 'ddp-css-ragnar', 'ragnar-blurbs-gerda');
            }
        
            if (strpos($post_content, 'ragnar_blurbs_gilla')) {
                add_post_meta($post_id, 'ddp-css-ragnar', 'ragnar-blurbs-gilla');
            }
        
            if (strpos($post_content, 'ragnar_content_goran')) {
                add_post_meta($post_id, 'ddp-css-ragnar', 'ragnar-content-goran');
            }
        
            if (strpos($post_content, 'ragnar_header_gota')) {
                add_post_meta($post_id, 'ddp-css-ragnar', 'ragnar-header-gota');
            }
        
            if (strpos($post_content, 'ragnar_person_greger')) {
                add_post_meta($post_id, 'ddp-css-ragnar', 'ragnar-person-greger');
            }
        
            if (strpos($post_content, 'ragnar_blog_hadrian')) {
                add_post_meta($post_id, 'ddp-css-ragnar', 'ragnar-blog-hadrian');
            }
        
            if (strpos($post_content, 'ragnar_content_gus')) {
                add_post_meta($post_id, 'ddp-css-ragnar', 'ragnar-content-gus');
            }
        
            if (strpos($post_content, 'ragnar_header_gudrun')) {
                add_post_meta($post_id, 'ddp-css-ragnar', 'ragnar-header-gudrun');
            }
        
            if (strpos($post_content, 'ragnar_person_gunnef')) {
                add_post_meta($post_id, 'ddp-css-ragnar', 'ragnar-person-gunnef');
            }
        
            if (strpos($post_content, 'ragnar_blurbs_jenny')) {
                add_post_meta($post_id, 'ddp-css-ragnar', 'ragnar-blurbs-jenny');
            }
        
            if (strpos($post_content, 'ragnar_content_berit')) {
                add_post_meta($post_id, 'ddp-css-ragnar', 'ragnar-content-berit');
            }
        
            if (strpos($post_content, 'ragnar_header_olof')) {
                add_post_meta($post_id, 'ddp-css-ragnar', 'ragnar-header-olof');
            }
        
            if (strpos($post_content, 'ragnar_tabs_gun')) {
                add_post_meta($post_id, 'ddp-css-ragnar', 'ragnar-tabs-gun');
            }
        
            if (strpos($post_content, 'ragnar_blurbs_maj')) {
                add_post_meta($post_id, 'ddp-css-ragnar', 'ragnar-blurbs-maj');
            }
        
            if (strpos($post_content, 'ragnar_content_plus')) {
                add_post_meta($post_id, 'ddp-css-ragnar', 'ragnar-content-plus');
            }
        
            if (strpos($post_content, 'ragnar_content_reidar')) {
                add_post_meta($post_id, 'ddp-css-ragnar', 'ragnar-content-reidar');
            }
        
            if (strpos($post_content, 'ragnar_person_rode')) {
                add_post_meta($post_id, 'ddp-css-ragnar', 'ragnar-person-rode');
            }
        
            if (strpos($post_content, 'ragnar_projects_ole')) {
                add_post_meta($post_id, 'ddp-css-ragnar', 'ragnar-projects-ole');
            }
        
            if (strpos($post_content, 'ragnar_blurbs_bure')) {
                add_post_meta($post_id, 'ddp-css-ragnar', 'ragnar-blurbs-bure');
            }

            if (strpos($post_content, 'ragnar_content_bigge')) {
                add_post_meta($post_id, 'ddp-css-ragnar', 'ragnar-content-bigge');
            }

            if (strpos($post_content, 'ragnar_header_jesaja')) {
                add_post_meta($post_id, 'ddp-css-ragnar', 'ragnar-header-jesaja');
            }
        
            if (strpos($post_content, 'ragnar_blog_isac')) {
                add_post_meta($post_id, 'ddp-css-ragnar', 'ragnar-blog-isac');
            }
        
            if (strpos($post_content, 'ragnar_blurbs_gullbrand')) {
                add_post_meta($post_id, 'ddp-css-ragnar', 'ragnar-blurbs-gullbrand');
            }
        
            if (strpos($post_content, 'ragnar_content_jean')) {
                add_post_meta($post_id, 'ddp-css-ragnar', 'ragnar-content-jean');
            }
        
            if (strpos($post_content, 'ragnar_header_lek')) {
                add_post_meta($post_id, 'ddp-css-ragnar', 'ragnar-header-lek');
            }
        
            if (strpos($post_content, 'ragnar_person_heimer')) {
                add_post_meta($post_id, 'ddp-css-ragnar', 'ragnar-person-heimer');
            }
        
            if (strpos($post_content, 'ragnar_content_aarhus')) {
                add_post_meta($post_id, 'ddp-css-ragnar', 'ragnar-content-aarhus');
            }
        
            //October
            if (strpos($post_content, 'ragnar_header_trustworthy')) {
                add_post_meta($post_id, 'ddp-css-ragnar', 'ragnar-header-trustworthy');
            }
            if (strpos($post_content, 'ragnar_content_trygve')) {
                add_post_meta($post_id, 'ddp-css-ragnar', 'ragnar-content-trygve');
            }
            if (strpos($post_content, 'ragnar_blurbs_torsten')) {
                add_post_meta($post_id, 'ddp-css-ragnar', 'ragnar-blurbs-torsten');
            }
            if (strpos($post_content, 'ragnar_content_nilsson')) {
                add_post_meta($post_id, 'ddp-css-ragnar', 'ragnar-content-nilsson');
            }
            if (strpos($post_content, 'ragnar_content_toke')) {
                add_post_meta($post_id, 'ddp-css-ragnar', 'ragnar-content-toke');
            }
            if (strpos($post_content, 'ragnar_testimonial_stone')) {
                add_post_meta($post_id, 'ddp-css-ragnar', 'ragnar-testimonial-stone');
            }
            if (strpos($post_content, 'ragnar_content_thors')) {
                add_post_meta($post_id, 'ddp-css-ragnar', 'ragnar-content-thors');
            }
            if (strpos($post_content, 'ragnar_footer_troels')) {
                add_post_meta($post_id, 'ddp-css-ragnar', 'ragnar-footer-troels');
            }
            if (strpos($post_content, 'ragnar_header_kurt')) {
                add_post_meta($post_id, 'ddp-css-ragnar', 'ragnar-header-kurt');
            }
            if (strpos($post_content, 'ragnar_content_casper')) {
                add_post_meta($post_id, 'ddp-css-ragnar', 'ragnar-content-casper');
            }
            if (strpos($post_content, 'ragnar_blurbs_rut')) {
                add_post_meta($post_id, 'ddp-css-ragnar', 'ragnar-blurbs-rut');
            }
            if (strpos($post_content, 'ragnar_content_ulf')) {
                add_post_meta($post_id, 'ddp-css-ragnar', 'ragnar-content-ulf');
            }
            if (strpos($post_content, 'ragnar_header_search')) {
                add_post_meta($post_id, 'ddp-css-ragnar', 'ragnar-header-search');
            }
            if (strpos($post_content, 'ragnar_blurbs_blix')) {
                add_post_meta($post_id, 'ddp-css-ragnar', 'ragnar-blurbs-blix');
            }
            if (strpos($post_content, 'ragnar_tabs_berit')) {
                add_post_meta($post_id, 'ddp-css-ragnar', 'ragnar-tabs-berit');
            }
            if (strpos($post_content, 'ragnar_header_bo')) {
                add_post_meta($post_id, 'ddp-css-ragnar', 'ragnar-header-bo');
            }
            if (strpos($post_content, 'ragnar_tabs_carine')) {
                add_post_meta($post_id, 'ddp-css-ragnar', 'ragnar-tabs-carine');
            }
            if (strpos($post_content, 'ragnar_blurbs_brigetta')) {
                add_post_meta($post_id, 'ddp-css-ragnar', 'ragnar-blurbs-brigetta');
            }
            // Ragnar ends

            //Grace starts

            if (strpos($post_content, 'grace_imeline_adhara')) {
                add_post_meta($post_id, 'ddp-css-grace', 'grace-timeline-adhara');
            }
            if (strpos($post_content, 'grace_timeline_alpha')) {
                add_post_meta($post_id, 'ddp-css-grace', 'grace-timeline-alpha');
            }
            if (strpos($post_content, 'grace_timeline_alula')) {
                add_post_meta($post_id, 'ddp-css-grace', 'grace-timeline-alula');
            }
            if (strpos($post_content, 'grace_timeline_slider_amalthea')) {
                add_post_meta($post_id, 'ddp-css-grace', 'grace-timeline-amalthea');
            }
            if (strpos($post_content, 'grace_timeline_andromeda')) {
                add_post_meta($post_id, 'ddp-css-grace', 'grace-timeline-andromeda');
            }
            if (strpos($post_content, 'grace_gallery_ascella')) {
                add_post_meta($post_id, 'ddp-css-grace', 'grace-gallery-ascella');
            }
            if (strpos($post_content, 'grace_gallery_asterope')) {
                add_post_meta($post_id, 'ddp-css-grace', 'grace-gallery-asterope');
            }
            if (strpos($post_content, 'grace_gallery_astra')) {
                add_post_meta($post_id, 'ddp-css-grace', 'grace-gallery-astra');
            }
            if (strpos($post_content, 'grace_gallery_aurora')) {
                add_post_meta($post_id, 'ddp-css-grace', 'grace-gallery-aurora');
            }
            if (strpos($post_content, 'grace_gallery_capella')) {
                add_post_meta($post_id, 'ddp-css-grace', 'grace-gallery-capella');
            }
            if (strpos($post_content, 'grace_gallery_cassiopea')) {
                add_post_meta($post_id, 'ddp-css-grace', 'grace-gallery-cassiopea');
            }
            if (strpos($post_content, 'grace_gallery_celestial')) {
                add_post_meta($post_id, 'ddp-css-grace', 'grace-gallery-celestial');
            }
            if (strpos($post_content, 'grace_gallery_halley')) {
                add_post_meta($post_id, 'ddp-css-grace', 'grace-gallery-halley');
            }
            if (strpos($post_content, 'grace_gallery_libra')) {
                add_post_meta($post_id, 'ddp-css-grace', 'grace-gallery-libra');
            }
            if (strpos($post_content, 'grace_gallery_luna')) {
                add_post_meta($post_id, 'ddp-css-grace', 'grace-gallery-luna');
            }
            if (strpos($post_content, 'grace_gallery_lyra')) {
                add_post_meta($post_id, 'ddp-css-grace', 'grace-gallery-lyra');
            }
            if (strpos($post_content, 'grace_gallery_nashira')) {
                add_post_meta($post_id, 'ddp-css-grace', 'grace-gallery-nashira');
            }
            if (strpos($post_content, 'grace_gallery_norma')) {
                add_post_meta($post_id, 'ddp-css-grace', 'grace-gallery-norma');
            }
            if (strpos($post_content, 'grace_gallery_polaris')) {
                add_post_meta($post_id, 'ddp-css-grace', 'grace-gallery-polaris');
            }

            if (strpos($post_content, 'grace_person_menkalinan')) {
                add_post_meta($post_id, 'ddp-css-grace', 'grace-person-menkalinan');
            }
            if (strpos($post_content, 'grace_person_parking')) {
                add_post_meta($post_id, 'ddp-css-grace', 'grace-person-parking');
            }
            if (strpos($post_content, 'grace_person_parking_v2')) {
                add_post_meta($post_id, 'ddp-css-grace', 'grace-person-parking-v2');
            }
            if (strpos($post_content, 'grace_person_miens')) {
                add_post_meta($post_id, 'ddp-css-grace', 'grace-person-miens');
            }
            if (strpos($post_content, 'grace_person_phoenix')) {
                add_post_meta($post_id, 'ddp-css-grace', 'grace-person-phoenix');
            }
            if (strpos($post_content, 'grace_person_pluto')) {
                add_post_meta($post_id, 'ddp-css-grace', 'grace-person-pluto');
            }
            if (strpos($post_content, 'grace_person_perseus')) {
                add_post_meta($post_id, 'ddp-css-grace', 'grace-person-perseus');
            }
            if (strpos($post_content, 'grace_person_cassini')) {
                add_post_meta($post_id, 'ddp-css-grace', 'grace-person-cassini');
            }
            if (strpos($post_content, 'grace_person_carina')) {
                add_post_meta($post_id, 'ddp-css-grace', 'grace-person-carina');
            }
            if (strpos($post_content, 'grace_person_belinda')) {
                add_post_meta($post_id, 'ddp-css-grace', 'grace-person-belinda');
            }
            if (strpos($post_content, 'grace_person_arpina')) {
                add_post_meta($post_id, 'ddp-css-grace', 'grace-person-arpina');
            }
            if (strpos($post_content, 'grace_person_taurus')) {
                add_post_meta($post_id, 'ddp-css-grace', 'grace-person-taurus');
            }
            if (strpos($post_content, 'grace_person_sirius')) {
                add_post_meta($post_id, 'ddp-css-grace', 'grace-person-sirius');
            }
            if (strpos($post_content, 'grace_person_orion')) {
                add_post_meta($post_id, 'ddp-css-grace', 'grace-person-orion');
            }
            if (strpos($post_content, 'grace_person_nova')) {
                add_post_meta($post_id, 'ddp-css-grace', 'grace-person-nova');
            }
            if (strpos($post_content, 'grace_persons_saturn')) {
                add_post_meta($post_id, 'ddp-css-grace', 'grace-person-saturn');
            }
            if (strpos($post_content, 'grace_person_apollo')) {
                add_post_meta($post_id, 'ddp-css-grace', 'grace-person-apollo');
            }

            if (strpos($post_content, 'grace_blurbs_straighten')) {
                add_post_meta($post_id, 'ddp-css-grace', 'grace-blurbs-straighten');
            }
            if (strpos($post_content, 'grace_blurbs_apollo')) {
                add_post_meta($post_id, 'ddp-css-grace', 'grace-blurbs-apollo');
            }
            if (strpos($post_content, 'grace_blurbs_archer')) {
                add_post_meta($post_id, 'ddp-css-grace', 'grace-blurbs-archer');
            }
            if (strpos($post_content, 'grace_blurbs_aries')) {
                add_post_meta($post_id, 'ddp-css-grace', 'grace-blurbs-aries');
            }
            if (strpos($post_content, 'grace_blurbs_aster')) {
                add_post_meta($post_id, 'ddp-css-grace', 'grace-blurbs-aster');
            }
            if (strpos($post_content, 'grace_blurbs_atlas')) {
                add_post_meta($post_id, 'ddp-css-grace', 'grace-blurbs-atlas');
            }
            if (strpos($post_content, 'grace_blurbs_columba')) {
                add_post_meta($post_id, 'ddp-css-grace', 'grace-blurbs-columba');
            }
            if (strpos($post_content, 'grace_blurbs_cosmos')) {
                add_post_meta($post_id, 'ddp-css-grace', 'grace-blurbs-cosmos');
            }
            if (strpos($post_content, 'grace_blurbs_danica')) {
                add_post_meta($post_id, 'ddp-css-grace', 'grace-blurbs-danica');
            }
            if (strpos($post_content, 'grace_blurbs_areglo')) {
                add_post_meta($post_id, 'ddp-css-grace', 'grace-blurbs-areglo');
            }
            if (strpos($post_content, 'grace_blurbs_stella')) {
                add_post_meta($post_id, 'ddp-css-grace', 'grace-blurbs-stella');
            }
            if (strpos($post_content, 'grace_blurbs_pherkad')) {
                add_post_meta($post_id, 'ddp-css-grace', 'grace-blurbs-pherkad');
            }
            if (strpos($post_content, 'grace_blurbs_marfak')) {
                add_post_meta($post_id, 'ddp-css-grace', 'grace-blurbs-marfak');
            }
            if (strpos($post_content, 'grace_blurbs_albaldah')) {
                add_post_meta($post_id, 'ddp-css-grace', 'grace-blurbs-albaldah');
            }
            if (strpos($post_content, 'grace_blurbs_furud')) {
                add_post_meta($post_id, 'ddp-css-grace', 'grace-blurbs-furud');
            }
            if (strpos($post_content, 'grace_blurbs_alfirk')) {
                add_post_meta($post_id, 'ddp-css-grace', 'grace-blurbs-alfirk');
            }
            if (strpos($post_content, 'grace_blurbs_phaet')) {
                add_post_meta($post_id, 'ddp-css-grace', 'grace-blurbs-phaet');
            }
            if (strpos($post_content, 'grace_blurbs_kitalpha')) {
                add_post_meta($post_id, 'ddp-css-grace', 'grace-blurbs-kitalpha');
            }
            if (strpos($post_content, 'grace_blurbs_diadem')) {
                add_post_meta($post_id, 'ddp-css-grace', 'grace-blurbs-diadem');
            }
            if (strpos($post_content, 'grace_blurbs_diadem_v2')) {
                add_post_meta($post_id, 'ddp-css-grace', 'grace-blurbs-diadem-v2');
            }
            if (strpos($post_content, 'grace_blurbs_yeux')) {
                add_post_meta($post_id, 'ddp-css-grace', 'grace-blurbs-yeux');
            }
            if (strpos($post_content, 'grace_blurbs_strange')) {
                add_post_meta($post_id, 'ddp-css-grace', 'grace-blurbs-strange');
            }
            if (strpos($post_content, 'grace_blurbs_bouche')) {
                add_post_meta($post_id, 'ddp-css-grace', 'grace-blurbs-bouche');
            }
            if (strpos($post_content, 'grace_blurbs_prends')) {
                add_post_meta($post_id, 'ddp-css-grace', 'grace-blurbs-prends');
            }
            if (strpos($post_content, 'grace_blurbs_bonheur')) {
                add_post_meta($post_id, 'ddp-css-grace', 'grace-blurbs-bonheur');
            }
            if (strpos($post_content, 'grace_blurbs_boulevard')) {
                add_post_meta($post_id, 'ddp-css-grace', 'grace-blurbs-boulevard');
            }
            if (strpos($post_content, 'grace_blurbs_castor')) {
                add_post_meta($post_id, 'ddp-css-grace', 'grace-blurbs-castor');
            }
            if (strpos($post_content, 'grace_blurb_blow')) {
                add_post_meta($post_id, 'ddp-css-grace', 'grace-blurbs-blow');
            }
            if (strpos($post_content, 'grace_blurbs_kamaria')) {
                add_post_meta($post_id, 'ddp-css-grace', 'grace-blurbs-kamaria');
            }
            if (strpos($post_content, 'grace_blurbs_adhafera')) {
                add_post_meta($post_id, 'ddp-css-grace', 'grace-blurbs-adhafera');
            }

            if (strpos($post_content, 'grace_blog_limousine')) {
                add_post_meta($post_id, 'ddp-css-grace', 'grace-blog-limousine');
            }
            if (strpos($post_content, 'grace_blog_hassaleh')) {
                add_post_meta($post_id, 'ddp-css-grace', 'grace-blog-hassaleh');
            }
            if (strpos($post_content, 'grace_blog_mon')) {
                add_post_meta($post_id, 'ddp-css-grace', 'grace-blog-mon');
            }
            if (strpos($post_content, 'grace_blog_mon-v2')) {
                add_post_meta($post_id, 'ddp-css-grace', 'grace-blog-mon-v2');
            }
            if (strpos($post_content, 'grace_blog_comet')) {
                add_post_meta($post_id, 'ddp-css-grace', 'grace-blog-comet');
            }
            if (strpos($post_content, 'grace_blog_draco')) {
                add_post_meta($post_id, 'ddp-css-grace', 'grace-blog-draco');
            }
            if (strpos($post_content, 'grace_blog_donati')) {
                add_post_meta($post_id, 'ddp-css-grace', 'grace-blog-donati');
            }
            if (strpos($post_content, 'grace_blog_cupid')) {
                add_post_meta($post_id, 'ddp-css-grace', 'grace-blog-cupid');
            }
            if (strpos($post_content, 'grace_blog_elio')) {
                add_post_meta($post_id, 'ddp-css-grace', 'grace-blog-elio');
            }
            if (strpos($post_content, 'grace_blog_finaly')) {
                add_post_meta($post_id, 'ddp-css-grace', 'grace-blog-finaly');
            }
            if (strpos($post_content, 'grace_blog_sol')) {
                add_post_meta($post_id, 'ddp-css-grace', 'grace-blog-sol');
            }
            if (strpos($post_content, 'grace_blog_luna')) {
                add_post_meta($post_id, 'ddp-css-grace', 'grace-blog-luna');
            }
            if (strpos($post_content, 'grace_blog_between')) {
                add_post_meta($post_id, 'ddp-css-grace', 'grace-blog-between');
            }
            if (strpos($post_content, 'grace_blog_sol')) {
                add_post_meta($post_id, 'ddp-css-grace', 'grace-blog-sol');
            }

            if (strpos($post_content, 'grace_slider_aladfar')) {
                add_post_meta($post_id, 'ddp-css-grace', 'grace-slider-aladfar');
            }
            if (strpos($post_content, 'grace_beid_slider')) {
                add_post_meta($post_id, 'ddp-css-grace', 'grace-slider-beid');
            }
            if (strpos($post_content, 'grace_beid_v2_slider')) {
                add_post_meta($post_id, 'ddp-css-grace', 'grace-slider-beid-v2');
            }
            if (strpos($post_content, 'grace_kraz_slider')) {
                add_post_meta($post_id, 'ddp-css-grace', 'grace-slider-kraz');
            }
            if (strpos($post_content, 'grace_merope_slider')) {
                add_post_meta($post_id, 'ddp-css-grace', 'grace-slider-merope');
            }
            if (strpos($post_content, 'grace_merga_slider')) {
                add_post_meta($post_id, 'ddp-css-grace', 'grace-slider-merga');
            }
            if (strpos($post_content, 'grace_merga_v2_slider')) {
                add_post_meta($post_id, 'ddp-css-grace', 'grace-slider-merga-v2');
            }
            if (strpos($post_content, 'grace_merga_v3_slider')) {
                add_post_meta($post_id, 'ddp-css-grace', 'grace-slider-merga-v3');
            }
            if (strpos($post_content, 'grace_merga_v4_slider')) {
                add_post_meta($post_id, 'ddp-css-grace', 'grace-slider-merga-v4');
            }
            if (strpos($post_content, 'grace_merga_v5_slider')) {
                add_post_meta($post_id, 'ddp-css-grace', 'grace-slider-merga-v5');
            }

            if (strpos($post_content, 'grace_header_elara')) {
                add_post_meta($post_id, 'ddp-css-grace', 'grace-header-elara');
            }
            if (strpos($post_content, 'grace_headers_hilda')) {
                add_post_meta($post_id, 'ddp-css-grace', 'grace-header-hilda');
            }
            if (strpos($post_content, 'grace_header_helena')) {
                add_post_meta($post_id, 'ddp-css-grace', 'grace-header-helena');
            }
            if (strpos($post_content, 'grace_header_gemini')) {
                add_post_meta($post_id, 'ddp-css-grace', 'grace-header-gemini');
            }
            if (strpos($post_content, 'grace_header_galatea')) {
                add_post_meta($post_id, 'ddp-css-grace', 'grace-header-galatea');
            }
            if (strpos($post_content, 'grace_header_flora')) {
                add_post_meta($post_id, 'ddp-css-grace', 'grace-header-flora');
            }
            if (strpos($post_content, 'grace_header_faye')) {
                add_post_meta($post_id, 'ddp-css-grace', 'grace-header-faye');
            }
            if (strpos($post_content, 'grace_header_electra')) {
                add_post_meta($post_id, 'ddp-css-grace', 'grace-header-electra');
            }
            if (strpos($post_content, 'grace_kuma_header')) {
                add_post_meta($post_id, 'ddp-css-grace', 'grace-header-kuma');
            }
            if (strpos($post_content, 'grace_maia_header')) {
                add_post_meta($post_id, 'ddp-css-grace', 'grace-header-maia');
            }
            if (strpos($post_content, 'grace_maia_header')) {
                add_post_meta($post_id, 'ddp-css-grace', 'grace-header-maia');
            }
            if (strpos($post_content, 'grace_yildun_header')) {
                add_post_meta($post_id, 'ddp-css-grace', 'grace-header-yildun');
            }
            if (strpos($post_content, 'grace_alterf_header')) {
                add_post_meta($post_id, 'ddp-css-grace', 'grace-header-alterf');
            }
            if (strpos($post_content, 'grace_header_ariel')) {
                add_post_meta($post_id, 'ddp-css-grace', 'grace-header-ariel');
            }
            if (strpos($post_content, 'grace_header_aquarius')) {
                add_post_meta($post_id, 'ddp-css-grace', 'grace-header-aquarius');
            }
            if (strpos($post_content, 'grace_header_kraz')) {
                add_post_meta($post_id, 'ddp-css-grace', 'grace-header-kraz');
            }
            if (strpos($post_content, 'grace_header_quand')) {
                add_post_meta($post_id, 'ddp-css-grace', 'grace-header-quand');
            }
            if (strpos($post_content, 'grace_header_zosma')) {
                add_post_meta($post_id, 'ddp-css-grace', 'grace-header-zosma');
            }
            if (strpos($post_content, 'grace_header_cressida')) {
                add_post_meta($post_id, 'ddp-css-grace', 'grace-header-cressida');
            }
            if (strpos($post_content, 'grace_header_zenith')) {
                add_post_meta($post_id, 'ddp-css-grace', 'grace-header-zenith');
            }
            if (strpos($post_content, 'grace_header_homam')) {
                add_post_meta($post_id, 'ddp-css-grace', 'grace-header-homam');
            }
            if (strpos($post_content, 'grace_header_bellatrix')) {
                add_post_meta($post_id, 'ddp-css-grace', 'grace-header-bellatrix');
            }
            if (strpos($post_content, 'grace_header_sabik')) {
                add_post_meta($post_id, 'ddp-css-grace', 'grace-header-sabik');
            }
            if (strpos($post_content, 'grace_header_hoshi')) {
                add_post_meta($post_id, 'ddp-css-grace', 'grace-header-hoshi');
            }
            if (strpos($post_content, 'grace_header_abraxas')) {
                add_post_meta($post_id, 'ddp-css-grace', 'grace-header-abraxas');
            }
            if (strpos($post_content, 'grace_header_atlas')) {
                add_post_meta($post_id, 'ddp-css-grace', 'grace-header-atlas');
            }
            if (strpos($post_content, 'grace_header_eryx')) {
                add_post_meta($post_id, 'ddp-css-grace', 'grace-header-eryx');
            }
            if (strpos($post_content, 'grace_header_griffin')) {
                add_post_meta($post_id, 'ddp-css-grace', 'grace-header-griffin');
            }
            if (strpos($post_content, 'grace_header_acamar')) {
                add_post_meta($post_id, 'ddp-css-grace', 'grace-header-acamar');
            }

            if (strpos($post_content, 'grace_price_lists_furud')) {
                add_post_meta($post_id, 'ddp-css-grace', 'grace-pricelist-furud');
            }
            if (strpos($post_content, 'grace_price_lists_kaitos')) {
                add_post_meta($post_id, 'ddp-css-grace', 'grace-pricelist-kaitos');
            }
            if (strpos($post_content, 'grace_price_lists_caph')) {
                add_post_meta($post_id, 'ddp-css-grace', 'grace-pricelist-caph');
            }
            if (strpos($post_content, 'grace_price_lists_electra')) {
                add_post_meta($post_id, 'ddp-css-grace', 'grace-pricelist-electra');
            }
            if (strpos($post_content, 'grace_price_lists_grafias')) {
                add_post_meta($post_id, 'ddp-css-grace', 'grace-pricelist-grafias');
            }
            if (strpos($post_content, 'grace_price_lists_ain')) {
                add_post_meta($post_id, 'ddp-css-grace', 'grace-pricelist-ain');
            }
            if (strpos($post_content, 'grace_price_lists_botein')) {
                add_post_meta($post_id, 'ddp-css-grace', 'grace-pricelist-botein');
            }
            if (strpos($post_content, 'grace_price_lists_beid')) {
                add_post_meta($post_id, 'ddp-css-grace', 'grace-pricelist-beid');
            }
            if (strpos($post_content, 'grace_price_lists_pollux')) {
                add_post_meta($post_id, 'ddp-css-grace', 'grace-pricelist-pollux');
            }
            if (strpos($post_content, 'grace_price_lists_qamar')) {
                add_post_meta($post_id, 'ddp-css-grace', 'grace-pricelist-qamar');
            }
            if (strpos($post_content, 'grace_price_lists_rasalas')) {
                add_post_meta($post_id, 'ddp-css-grace', 'grace-pricelist-rasalas');
            }
            if (strpos($post_content, 'grace_price_lists_becrux')) {
                add_post_meta($post_id, 'ddp-css-grace', 'grace-pricelist-becrux');
            }

            if (strpos($post_content, 'grace_testimonial_matar')) {
                add_post_meta($post_id, 'ddp-css-grace', 'grace-testimonial-matar');
            }
            if (strpos($post_content, 'grace_testimonial_race')) {
                add_post_meta($post_id, 'ddp-css-grace', 'grace-testimonial-race');
            }
            if (strpos($post_content, 'grace_testimonial_between')) {
                add_post_meta($post_id, 'ddp-css-grace', 'grace-testimonial-between');
            }
            if (strpos($post_content, 'grace_testimonial_dabih')) {
                add_post_meta($post_id, 'ddp-css-grace', 'grace-testimonial-dabih');
            }
            if (strpos($post_content, 'grace_testimonial_peacock')) {
                add_post_meta($post_id, 'ddp-css-grace', 'grace-testimonial-peacock');
            }
            if (strpos($post_content, 'grace_testimonial_regulus')) {
                add_post_meta($post_id, 'ddp-css-grace', 'grace-testimonial-regulus');
            }
            if (strpos($post_content, 'grace_testimonial_never_stop')) {
                add_post_meta($post_id, 'ddp-css-grace', 'grace-testimonial-neverstop');
            }
            if (strpos($post_content, 'grace_testimonial_nova')) {
                add_post_meta($post_id, 'ddp-css-grace', 'grace-testimonial-nova');
            }

            if (strpos($post_content, 'grace_portfolio_taurus')) {
                add_post_meta($post_id, 'ddp-css-grace', 'grace-portfolio-taurus');
            }
            
            if (strpos($post_content, 'grace_projects_cursa')) {
                add_post_meta($post_id, 'ddp-css-grace', 'grace-projects-cursa');
            }

            if (strpos($post_content, 'grace_projects_cursa')) {
                add_post_meta($post_id, 'ddp-css-grace', 'grace-projects-cursa');
            }

            if (strpos($post_content, 'grace_cta_ares')) {
                add_post_meta($post_id, 'ddp-css-grace', 'grace-cta-ares');
            }

            if (strpos($post_content, 'grace_footer_algol')) {
                add_post_meta($post_id, 'ddp-css-grace', 'grace-footers-algol');
            }
            if (strpos($post_content, 'grace_footers_alrai')) {
                add_post_meta($post_id, 'ddp-css-grace', 'grace-footers-alrai');
            }
            if (strpos($post_content, 'grace_footers_bottle')) {
                add_post_meta($post_id, 'ddp-css-grace', 'grace-footers-bottle');
            }
            if (strpos($post_content, 'grace_footers_gacrux')) {
                add_post_meta($post_id, 'ddp-css-grace', 'grace-footers-gacrux');
            }
            if (strpos($post_content, 'grace_footers_heze')) {
                add_post_meta($post_id, 'ddp-css-grace', 'grace-footers-heze');
            }
            if (strpos($post_content, 'grace_footer_mira')) {
                add_post_meta($post_id, 'ddp-css-grace', 'grace-footers-mira');
            }
            if (strpos($post_content, 'grace_footers_naos')) {
                add_post_meta($post_id, 'ddp-css-grace', 'grace-footers-naos');
            }
            if (strpos($post_content, 'grace_footers_drive')) {
                add_post_meta($post_id, 'ddp-css-grace', 'grace-footers-drive');
            }
            if (strpos($post_content, 'grace_footers_argo')) {
                add_post_meta($post_id, 'ddp-css-grace', 'grace-footers-argo');
            }
            if (strpos($post_content, 'grace_footer_cadmus')) {
                add_post_meta($post_id, 'ddp-css-grace', 'grace-footers-cadmus');
            }
            if (strpos($post_content, 'grace_footer_achrid')) {
                add_post_meta($post_id, 'ddp-css-grace', 'grace-footers-achrid');
            }
            if (strpos($post_content, 'grace_footer_driving')) {
                add_post_meta($post_id, 'ddp-css-grace', 'grace-footers-driving');
            }

            if (strpos($post_content, 'grace_content_julian')) {
                add_post_meta($post_id, 'ddp-css-grace', 'grace-content-julian');
            }
            if (strpos($post_content, 'grace_content_acubens')) {
                add_post_meta($post_id, 'ddp-css-grace', 'grace-content-acubens');
            }
            if (strpos($post_content, 'grace_content_ida')) {
                add_post_meta($post_id, 'ddp-css-grace', 'grace-content-ida');
            }
            if (strpos($post_content, 'grace_content_adhil')) {
                add_post_meta($post_id, 'ddp-css-grace', 'grace-content-adhil');
            }
            if (strpos($post_content, 'grace_content_baham')) {
                add_post_meta($post_id, 'ddp-css-grace', 'grace-content-baham');
            }
            if (strpos($post_content, 'grace_content_bumper')) {
                add_post_meta($post_id, 'ddp-css-grace', 'grace-content-bumper');
            }
            if (strpos($post_content, 'grace_content_down')) {
                add_post_meta($post_id, 'ddp-css-grace', 'grace-content-down');
            }
            if (strpos($post_content, 'grace_content_drive')) {
                add_post_meta($post_id, 'ddp-css-grace', 'grace-content-drive');
            }
            if (strpos($post_content, 'grace_content_dsiban')) {
                add_post_meta($post_id, 'ddp-css-grace', 'grace-content-dsiban');
            }
            if (strpos($post_content, 'grace_content_fornacis')) {
                add_post_meta($post_id, 'ddp-css-grace', 'grace-content-fornacis');
            }
            if (strpos($post_content, 'grace_content_give')) {
                add_post_meta($post_id, 'ddp-css-grace', 'grace-content-give');
            }
            if (strpos($post_content, 'grace_content_gomeisa')) {
                add_post_meta($post_id, 'ddp-css-grace', 'grace-content-gomeisa');
            }
            if (strpos($post_content, 'grace_content_jabbah')) {
                add_post_meta($post_id, 'ddp-css-grace', 'grace-content-jabbah');
            }
            if (strpos($post_content, 'grace_content_keep')) {
                add_post_meta($post_id, 'ddp-css-grace', 'grace-content-keep');
            }
            if (strpos($post_content, 'grace_content_lines')) {
                add_post_meta($post_id, 'ddp-css-grace', 'grace-content-lines');
            }
            if (strpos($post_content, 'grace_content_menkent')) {
                add_post_meta($post_id, 'ddp-css-grace', 'grace-content-menkent');
            }
            if (strpos($post_content, 'grace_content_naos')) {
                add_post_meta($post_id, 'ddp-css-grace', 'grace-content-naos');
            }
            if (strpos($post_content, 'grace_content_prend')) {
                add_post_meta($post_id, 'ddp-css-grace', 'grace-content-prend');
            }
            if (strpos($post_content, 'grace_content_somewhere')) {
                add_post_meta($post_id, 'ddp-css-grace', 'grace-content-somewhere');
            }
            if (strpos($post_content, 'grace_content_rigel')) {
                add_post_meta($post_id, 'ddp-css-grace', 'grace-content-rigel');
            }
            if (strpos($post_content, 'grace_content_indu')) {
                add_post_meta($post_id, 'ddp-css-grace', 'grace-content-indu');
            }
            if (strpos($post_content, 'grace_content_larissa')) {
                add_post_meta($post_id, 'ddp-css-grace', 'grace-content-larissa');
            }
            if (strpos($post_content, 'grace_content_adonis')) {
                add_post_meta($post_id, 'ddp-css-grace', 'grace-content-adonis');
            }
            
        
            if (strpos($post_content, 'grace_numbers_pallention')) {
                add_post_meta($post_id, 'ddp-css-grace', 'grace-numbers-pallention');
            }

            if (strpos($post_content, 'grace_optin_spa1')) {
                add_post_meta($post_id, 'ddp-css-grace', 'grace-optin-spa1');
            }
            if (strpos($post_content, 'grace_otpin_space')) {
                add_post_meta($post_id, 'ddp-css-grace', 'grace-optin-space');
            }
            
            if (strpos($post_content, 'grace_process_kepler')) {
                add_post_meta($post_id, 'ddp-css-grace', 'grace-process-kepler');
            }
            
            if (strpos($post_content, 'grace_contact_cadmus')) {
                add_post_meta($post_id, 'ddp-css-grace', 'grace-contact-forms-cadmus');
            }
            if (strpos($post_content, 'grace_contact_hades')) {
                add_post_meta($post_id, 'ddp-css-grace', 'grace-contact-forms-hades');
            }

            if (strpos($post_content, 'grace_testimonials_prey')) {
                add_post_meta($post_id, 'ddp-css-grace', 'grace-testimonials-prey');
            }
            if (strpos($post_content, 'grace_call_to_action_shiny')) {
                add_post_meta($post_id, 'ddp-css-grace', 'grace-call-to-action-shiny');
            }
            if (strpos($post_content, 'grace_blurbs_shadows')) {
                add_post_meta($post_id, 'ddp-css-grace', 'grace-blurbs-shadows');
            }
            if (strpos($post_content, 'grace_content_warmth')) {
                add_post_meta($post_id, 'ddp-css-grace', 'grace-content-warmth');
            }
            if (strpos($post_content, 'grace_footers_showed')) {
                add_post_meta($post_id, 'ddp-css-grace', 'grace-footers-showed');
            }
            if (strpos($post_content, 'grace_blurbs_garage')) {
                add_post_meta($post_id, 'ddp-css-grace', 'grace-blurbs-garage');
            }
            if (strpos($post_content, 'grace_content_parking')) {
                add_post_meta($post_id, 'ddp-css-grace', 'grace-content-parking');
            }
            if (strpos($post_content, 'grace_process_izar')) {
                add_post_meta($post_id, 'ddp-css-grace', 'grace-process-izar');
            }
            if (strpos($post_content, 'grace_price_lists_flip_it')) {
                add_post_meta($post_id, 'ddp-css-grace', 'grace-price-flipit');
            }
            if (strpos($post_content, 'grace_header_favorable')) {
                add_post_meta($post_id, 'ddp-css-grace', 'grace-header-favorable');
            }
            if (strpos($post_content, 'grace_process_meteor')) {
                add_post_meta($post_id, 'ddp-css-grace', 'grace-process-meteor');
            }
            if (strpos($post_content, 'grace_process_lintang')) {
                add_post_meta($post_id, 'ddp-css-grace', 'grace-process-lintang');
            }
            if (strpos($post_content, 'grace_process_kuiper')) {
                add_post_meta($post_id, 'ddp-css-grace', 'grace-process-kuiper');
            }
            if (strpos($post_content, 'grace_process_jupiter')) {
                add_post_meta($post_id, 'ddp-css-grace', 'grace-process-jupiter');
            }
            if (strpos($post_content, 'grace_process_janus')) {
                add_post_meta($post_id, 'ddp-css-grace', 'grace-process-janus');
            }
            if (strpos($post_content, 'grace_process_hoku')) {
                add_post_meta($post_id, 'ddp-css-grace', 'grace-process-hoku');
            }
            if (strpos($post_content, 'grace_process_hesperos')) {
                add_post_meta($post_id, 'ddp-css-grace', 'grace-process-hesperos');
            }
            if (strpos($post_content, 'grace_pricing_table_emma')) {
                add_post_meta($post_id, 'ddp-css-grace', 'grace-pricing-table-emma');
            }
            if (strpos($post_content, 'grace_content_lines_v2')) {
                add_post_meta($post_id, 'ddp-css-grace', 'grace-content-lines-v2');
            }
            if (strpos($post_content, 'grace_content_world')) {
                add_post_meta($post_id, 'ddp-css-grace', 'grace-content-world');
            }
            if (strpos($post_content, 'grace_content_spending')) {
                add_post_meta($post_id, 'ddp-css-grace', 'grace-content-spending');
            }
            if (strpos($post_content, 'grace_footers_gacrux_v2')) {
                add_post_meta($post_id, 'ddp-css-grace', 'grace-footers-grace_footers_gacrux_v2');
            }
            if (strpos($post_content, 'grace_content_aching')) {
                add_post_meta($post_id, 'ddp-css-grace', 'grace-content-aching');
            }
            if (strpos($post_content, 'grace_blurbs_albaldah_v2')) {
                add_post_meta($post_id, 'ddp-css-grace', 'grace-blurbs-albaldah-v2');
            }
            if (strpos($post_content, 'grace_content_power')) {
                add_post_meta($post_id, 'ddp-css-grace', 'grace-content-power');
            }
            if (strpos($post_content, 'grace_person_gunnef')) {
                add_post_meta($post_id, 'ddp-css-grace', 'grace-person-gunnef');
            }
            if (strpos($post_content, 'grace_portfolio_gomeisa')) {
                add_post_meta($post_id, 'ddp-css-grace', 'grace-portfolio-gomeisa');
            }
            if (strpos($post_content, 'grace_blurbs_pour')) {
                add_post_meta($post_id, 'ddp-css-grace', 'grace-blurbs-pour');
            }
            if (strpos($post_content, 'grace_content_wasat')) {
                add_post_meta($post_id, 'ddp-css-grace', 'grace-content-wasat');
            }
            if (strpos($post_content, 'grace_footer_alors')) {
                add_post_meta($post_id, 'ddp-css-grace', 'grace-footers-alors');
            }
            if (strpos($post_content, 'grace_otpin_your_kiss')) {
                add_post_meta($post_id, 'ddp-css-grace', 'grace-optin-your-kiss');
            }
            if (strpos($post_content, 'grace_content_may')) {
                add_post_meta($post_id, 'ddp-css-grace', 'grace-content-may');
            }
            if (strpos($post_content, 'grace_person_rode')) {
                add_post_meta($post_id, 'ddp-css-grace', 'grace-person-rode');
            }
            if (strpos($post_content, 'grace_content_sparks')) {
                add_post_meta($post_id, 'ddp-css-grace', 'grace-content-sparks');
            }
            if (strpos($post_content, 'grace_footers_grandfather')) {
                add_post_meta($post_id, 'ddp-css-grace', 'grace-footers-grandfather');
            }
            if (strpos($post_content, 'grace_footers_store')) {
                add_post_meta($post_id, 'ddp-css-grace', 'grace-footers-store');
            }
            if (strpos($post_content, 'grace_header_castor')) {
                add_post_meta($post_id, 'ddp-css-grace', 'grace-headers-castor');
            }
            if (strpos($post_content, 'grace_portfolio_cronus')) {
                add_post_meta($post_id, 'ddp-css-grace', 'grace-portfolio-cronus');
            }
            if (strpos($post_content, 'grace_logo_damon')) {
                add_post_meta($post_id, 'ddp-css-grace', 'grace-logos-damon');
            }
            if (strpos($post_content, 'grace_persons_damon')) {
                add_post_meta($post_id, 'ddp-css-grace', 'grace-persons-damon');
            }
            if (strpos($post_content, 'grace_blog_dionysius')) {
                add_post_meta($post_id, 'ddp-css-grace', 'grace-blog-dionysius');
            }
            if (strpos($post_content, 'grace_footer_eros')) {
                add_post_meta($post_id, 'ddp-css-grace', 'grace-footer-eros');
            }
            if (strpos($post_content, 'grace_gallery_polaris_v2')) {
                add_post_meta($post_id, 'ddp-css-grace', 'grace-gallery-polaris-v2');
            }
            if (strpos($post_content, 'grace_blog_beauty')) {
                add_post_meta($post_id, 'ddp-css-grace', 'grace-blog-beauty');
            }
            if (strpos($post_content, 'grace_blog_sten')) {
                add_post_meta($post_id, 'ddp-css-grace', 'grace-blog-sten');
            }
            if (strpos($post_content, 'grace_accordion_iconic')) {
                add_post_meta($post_id, 'ddp-css-grace', 'grace-accordion-iconic');
            }
            if (strpos($post_content, 'grace_testimonial_that_face')) {
                add_post_meta($post_id, 'ddp-css-grace', 'grace-testimonial-that-face');
            }
            if (strpos($post_content, 'grace_person_founding')) {
                add_post_meta($post_id, 'ddp-css-grace', 'grace-person-founding');
            }
            if (strpos($post_content, 'grace_blurbs_action')) {
                add_post_meta($post_id, 'ddp-css-grace', 'grace-blurbs-action');
            }
            if (strpos($post_content, 'grace_optin_gonna_be')) {
                add_post_meta($post_id, 'ddp-css-grace', 'grace-optin-gonna-be');
            }
            if (strpos($post_content, 'grace_footers_dignified')) {
                add_post_meta($post_id, 'ddp-css-grace', 'grace-footers-dignified');
            }
            if (strpos($post_content, 'grace_footers_ample')) {
                add_post_meta($post_id, 'ddp-css-grace', 'grace-footers-ample');
            }
            if (strpos($post_content, 'grace_footers_gacrux_v2')) {
                add_post_meta($post_id, 'ddp-css-grace', 'grace-footers-gacrux-v2');
            }
            if (strpos($post_content, 'grace_call_to_action_jhones')) {
                add_post_meta($post_id, 'ddp-css-grace', 'grace-cta-jhones');
            }
			if (strpos($post_content, 'grace_contact_wezen')) {
				add_post_meta($post_id, 'ddp-css-grace', 'grace-contact-wezen');
			}

            if (strpos($post_content, 'grace_about9_content_aching')) {
                add_post_meta($post_id, 'ddp-css-grace', 'grace-about9-content-aching');
            }
            if (strpos($post_content, 'grace_about9_cta')) {
                add_post_meta($post_id, 'ddp-css-grace', 'grace-about9-cta');
            }
            if (strpos($post_content, 'grace_content_pentecostal')) {
                add_post_meta($post_id, 'ddp-css-grace', 'grace-content-pentecostal');
            }
            if (strpos($post_content, 'grace_about11_logos')) {
                add_post_meta($post_id, 'ddp-css-grace', 'grace-about11-counter');
            }
            if (strpos($post_content, 'grace_about11_gallery')) {
                add_post_meta($post_id, 'ddp-css-grace', 'grace-about11-gallery');
            }
            if (strpos($post_content, 'grace_about11_testimonials')) {
                add_post_meta($post_id, 'ddp-css-grace', 'grace-about11-testimonials');
            }
            if (strpos($post_content, 'grace_person_artist')) {
                add_post_meta($post_id, 'ddp-css-grace', 'grace-person-artist');
            }
            if (strpos($post_content, 'grace_content_filmmaker')) {
                add_post_meta($post_id, 'ddp-css-grace', 'grace-content-filmmaker');
            }
            if (strpos($post_content, 'about12_gallery_halley')) {
                add_post_meta($post_id, 'ddp-css-grace', 'grace-about12-gallery-halley');
            }
            if (strpos($post_content, 'grace_about12_blog_mon')) {
                add_post_meta($post_id, 'ddp-css-grace', 'grace-about12-blog-mon');
            }
            if (strpos($post_content, 'grace_content_mendoza')) {
                add_post_meta($post_id, 'ddp-css-grace', 'grace-content-mendoza');
            }
            if (strpos($post_content, 'grace_content_stir')) {
                add_post_meta($post_id, 'ddp-css-grace', 'grace-content-stir');
            }
            if (strpos($post_content, 'grace_about13_content_world')) {
                add_post_meta($post_id, 'ddp-css-grace', 'grace-about13-content-world');
            }   
            if (strpos($post_content, 'grace_content_atila')) {
                add_post_meta($post_id, 'ddp-css-grace', 'grace-content-atila');
            }
            if (strpos($post_content, 'grace_about13_blog_isac')) {
                add_post_meta($post_id, 'ddp-css-grace', 'grace-about13-blog-isac');
            }
            if (strpos($post_content, 'grace_about13_footers_naos')) {
                add_post_meta($post_id, 'ddp-css-grace', 'grace-about13-footers-naos');
            }
            if (strpos($post_content, 'grace_about13_light_person_module')) {
                add_post_meta($post_id, 'ddp-css-grace', 'grace-about13-light-person-module');
            }
            if (strpos($post_content, 'grace_about14_testimonial_go_to')) {
                add_post_meta($post_id, 'ddp-css-grace', 'grace-about14-testimonial-go-to');
            }
            if (strpos($post_content, 'grace_about14_footers_drive')) {
                add_post_meta($post_id, 'ddp-css-grace', 'grace-about14-footers-drive');
            }             
            if (strpos($post_content, 'grace_person_california')) {
                add_post_meta($post_id, 'ddp-css-grace', 'grace-person-california');
            }
            if (strpos($post_content, 'grace_content_released')) {
                add_post_meta($post_id, 'ddp-css-grace', 'grace-content-released');
            }
            if (strpos($post_content, 'grace_service4_header')) {
                add_post_meta($post_id, 'ddp-css-grace', 'grace-header-service4');
            }
            if (strpos($post_content, 'grace_service4_blurbs')) {
                add_post_meta($post_id, 'ddp-css-grace', 'grace-blurbs-service4');
            }
            if (strpos($post_content, 'grace_content_action')) {
                add_post_meta($post_id, 'ddp-css-grace', 'grace-content-action');
            }
            if (strpos($post_content, 'grace_80s_blurbs')) {
                add_post_meta($post_id, 'ddp-css-grace', 'grace-blurbs-80s');
            }
            if (strpos($post_content, 'grace_service6_header')) {
                add_post_meta($post_id, 'ddp-css-grace', 'grace-header-service6');
            }
            if (strpos($post_content, 'grace_about9_content_aching')) {
                add_post_meta($post_id, 'ddp-css-grace', 'grace-about9-content-aching');
            }
            if (strpos($post_content, 'grace_about9_cta')) {
                add_post_meta($post_id, 'ddp-css-grace', 'grace-about9-cta');
            }
            if (strpos($post_content, 'grace_content_pentecostal')) {
                add_post_meta($post_id, 'ddp-css-grace', 'grace-content-pentecostal');
            }
            if (strpos($post_content, 'grace_about11_gallery')) {
                add_post_meta($post_id, 'ddp-css-grace', 'grace-about11-gallery');
            }
            if (strpos($post_content, 'grace_about11_testimonials')) {
                add_post_meta($post_id, 'ddp-css-grace', 'grace-about11-testimonials');
            }
            if (strpos($post_content, 'grace_person_artist')) {
                add_post_meta($post_id, 'ddp-css-grace', 'grace-person-artist');
            }
            if (strpos($post_content, 'grace_content_filmmaker')) {
                add_post_meta($post_id, 'ddp-css-grace', 'grace-content-filmmaker');
            }
            if (strpos($post_content, 'about12_gallery_halley')) {
                add_post_meta($post_id, 'ddp-css-grace', 'grace-about12-gallery-halley');
            }
            if (strpos($post_content, 'grace_about12_blog_mon')) {
                add_post_meta($post_id, 'ddp-css-grace', 'grace-about12-blog-mon');
            }
            if (strpos($post_content, 'grace_content_mendoza')) {
                add_post_meta($post_id, 'ddp-css-grace', 'grace-content-mendoza');
            }
            if (strpos($post_content, 'grace_content_stir')) {
                add_post_meta($post_id, 'ddp-css-grace', 'grace-content-stir');
            }
            if (strpos($post_content, 'grace_about13_content_world')) {
                add_post_meta($post_id, 'ddp-css-grace', 'grace-about13-content-world');
            }   
            if (strpos($post_content, 'grace_content_atila')) {
                add_post_meta($post_id, 'ddp-css-grace', 'grace-content-atila');
            }
            if (strpos($post_content, 'grace_about13_blog_isac')) {
                add_post_meta($post_id, 'ddp-css-grace', 'grace-about13-blog-isac');
            }
            if (strpos($post_content, 'grace_about13_footers_naos')) {
                add_post_meta($post_id, 'ddp-css-grace', 'grace-about13-footers-naos');
            }
            if (strpos($post_content, 'grace_about13_light_person_module')) {
                add_post_meta($post_id, 'ddp-css-grace', 'grace-about13-light-person-module');
            }
            if (strpos($post_content, 'grace_about14_testimonial_go_to')) {
                add_post_meta($post_id, 'ddp-css-grace', 'grace-about14-testimonial-go-to');
            }
            if (strpos($post_content, 'grace_about14_footers_drive')) {
                add_post_meta($post_id, 'ddp-css-grace', 'grace-about14-footers-drive');
            }             
            if (strpos($post_content, 'grace_person_california')) {
                add_post_meta($post_id, 'ddp-css-grace', 'grace-person-california');
            }
            if (strpos($post_content, 'grace_content_released')) {
                add_post_meta($post_id, 'ddp-css-grace', 'grace-content-released');
            }
            if (strpos($post_content, 'grace_service4_header')) {
                add_post_meta($post_id, 'ddp-css-grace', 'grace-header-service4');
            }
            if (strpos($post_content, 'grace_service4_blurbs')) {
                add_post_meta($post_id, 'ddp-css-grace', 'grace-blurbs-service4');
            }
            if (strpos($post_content, 'grace_content_action')) {
                add_post_meta($post_id, 'ddp-css-grace', 'grace-content-action');
            }
            if (strpos($post_content, 'grace_80s_blurbs')) {
                add_post_meta($post_id, 'ddp-css-grace', 'grace-blurbs-80s');
            }
            if (strpos($post_content, 'grace_service6_header')) {
                add_post_meta($post_id, 'ddp-css-grace', 'grace-header-service6');
            }
            if (strpos($post_content, 'grace_content_minister')) {
                add_post_meta($post_id, 'ddp-css-grace', 'grace-content-minister');
            }
            if (strpos($post_content, 'grace_person_pastor')) {
                add_post_meta($post_id, 'ddp-css-grace', 'grace-person-pastor');
            }
            if (strpos($post_content, 'grace_about11_logos')) {
                add_post_meta($post_id, 'ddp-css-grace', 'grace_about11_logos');
            }
            if (strpos($post_content, 'grace_content_gardena')) {
                add_post_meta($post_id, 'ddp-css-grace', 'grace-content-gardena');
            }
            if (strpos($post_content, 'grace_turkish_header')) {
                add_post_meta($post_id, 'ddp-css-grace', 'grace-header-turkish');
            }

            //Grace ends

              //Olena starts
        
        if (strpos($post_content, 'olena_header_v1')) {
            add_post_meta($post_id, 'ddp-css-olena', 'olena-header-v1');
        }
        if (strpos($post_content, 'olena_header_v2')) {
            add_post_meta($post_id, 'ddp-css-olena', 'olena-header-v2');
        }
        if (strpos($post_content, 'olena_header_v3')) {
            add_post_meta($post_id, 'ddp-css-olena', 'olena-header-v3');
        }
        if (strpos($post_content, 'olena_header_v4')) {
            add_post_meta($post_id, 'ddp-css-olena', 'olena-header-v4');
        }
        if (strpos($post_content, 'olena_header_v5')) {
            add_post_meta($post_id, 'ddp-css-olena', 'olena-header-v5');
        }
        if (strpos($post_content, 'olena_header_v6')) {
            add_post_meta($post_id, 'ddp-css-olena', 'olena-header-v6');
        }
        if (strpos($post_content, 'olena_header_v7')) {
            add_post_meta($post_id, 'ddp-css-olena', 'olena-header-v7');
        }
        if (strpos($post_content, 'olena_header_v8')) {
            add_post_meta($post_id, 'ddp-css-olena', 'olena-header-v8');
        }
        if (strpos($post_content, 'olena_header_v9')) {
            add_post_meta($post_id, 'ddp-css-olena', 'olena-header-v9');
        }
        if (strpos($post_content, 'olena_header_v10')) {
            add_post_meta($post_id, 'ddp-css-olena', 'olena-header-v10');
        }
        if (strpos($post_content, 'olena_header_v11')) {
            add_post_meta($post_id, 'ddp-css-olena', 'olena-header-v11');
        }
        if (strpos($post_content, 'olena_header_v12')) {
            add_post_meta($post_id, 'ddp-css-olena', 'olena-header-v12');
        }
        if (strpos($post_content, 'olena_content_1')) {
            add_post_meta($post_id, 'ddp-css-olena', 'olena-content-1');
        }
        if (strpos($post_content, 'olena_content_2')) {
            add_post_meta($post_id, 'ddp-css-olena', 'olena-content-2');
        }
        if (strpos($post_content, 'olena_content_3')) {
            add_post_meta($post_id, 'ddp-css-olena', 'olena-content-3');
        }
        if (strpos($post_content, 'olena_content_4')) {
            add_post_meta($post_id, 'ddp-css-olena', 'olena-content-4');
        }
        if (strpos($post_content, 'olena_content_5')) {
            add_post_meta($post_id, 'ddp-css-olena', 'olena-content-5');
        }
        if (strpos($post_content, 'olena_content_6')) {
            add_post_meta($post_id, 'ddp-css-olena', 'olena-content-6');
        }
        if (strpos($post_content, 'olena_content_7')) {
            add_post_meta($post_id, 'ddp-css-olena', 'olena-content-7');
        }
        if (strpos($post_content, 'olena_content_8')) {
            add_post_meta($post_id, 'ddp-css-olena', 'olena-content-8');
        }
        if (strpos($post_content, 'olena_content_9')) {
            add_post_meta($post_id, 'ddp-css-olena', 'olena-content-9');
        }
        if (strpos($post_content, 'olena_content_10')) {
            add_post_meta($post_id, 'ddp-css-olena', 'olena-content-10');
        }
        if (strpos($post_content, 'olena_content_11')) {
            add_post_meta($post_id, 'ddp-css-olena', 'olena-content-11');
        }
        if (strpos($post_content, 'olena_content_12')) {
            add_post_meta($post_id, 'ddp-css-olena', 'olena-content-12');
        }
        if (strpos($post_content, 'olena_content_15')) {
            add_post_meta($post_id, 'ddp-css-olena', 'olena-content-15');
        }
        if (strpos($post_content, 'olena_content_18')) {
            add_post_meta($post_id, 'ddp-css-olena', 'olena-content-18');
        }

        if (strpos($post_content, 'olena_person_v1')) {
            add_post_meta($post_id, 'ddp-css-olena', 'olena-person-v1');
        }
        if (strpos($post_content, 'olena_person_v2')) {
            add_post_meta($post_id, 'ddp-css-olena', 'olena-person-v2');
        }
        if (strpos($post_content, 'olena_person_v3')) {
            add_post_meta($post_id, 'ddp-css-olena', 'olena-person-v3');
        }
        if (strpos($post_content, 'olena_person_v4')) {
            add_post_meta($post_id, 'ddp-css-olena', 'olena-person-v4');
        }
        if (strpos($post_content, 'olena_person_v5')) {
            add_post_meta($post_id, 'ddp-css-olena', 'olena-person-v5');
        }
        if (strpos($post_content, 'olena_person_v6')) {
            add_post_meta($post_id, 'ddp-css-olena', 'olena-person-v6');
        }
        if (strpos($post_content, 'olena_person_v7')) {
            add_post_meta($post_id, 'ddp-css-olena', 'olena-person-v7');
        }
        if (strpos($post_content, 'olena_person_v8')) {
            add_post_meta($post_id, 'ddp-css-olena', 'olena-person-v8');
        }
        if (strpos($post_content, 'olena_person_v9')) {
            add_post_meta($post_id, 'ddp-css-olena', 'olena-person-v9');
        }
        if (strpos($post_content, 'olena_person_v10')) {
            add_post_meta($post_id, 'ddp-css-olena', 'olena-person-v10');
        }
        if (strpos($post_content, 'olena_person_v11')) {
            add_post_meta($post_id, 'ddp-css-olena', 'olena-person-v11');
        }
        if (strpos($post_content, 'olena_person_12')) {
            add_post_meta($post_id, 'ddp-css-olena', 'olena-person-v12');
        }
        if (strpos($post_content, 'olena_person_13')) {
            add_post_meta($post_id, 'ddp-css-olena', 'olena-person-v13');
        }
        if (strpos($post_content, 'olena_blog_v1')) {
            add_post_meta($post_id, 'ddp-css-olena', 'olena-blog-v1');
        }
        if (strpos($post_content, 'olena_blog_v2')) {
            add_post_meta($post_id, 'ddp-css-olena', 'olena-blog-v2');
        }
        if (strpos($post_content, 'olena_blog_v3')) {
            add_post_meta($post_id, 'ddp-css-olena', 'olena-blog-v3');
        }
        if (strpos($post_content, 'olena_blog_v4')) {
            add_post_meta($post_id, 'ddp-css-olena', 'olena-blog-v4');
        }
        if (strpos($post_content, 'olena_blog_v5')) {
            add_post_meta($post_id, 'ddp-css-olena', 'olena-blog-v5');
        }
        if (strpos($post_content, 'olena_blog_v6')) {
            add_post_meta($post_id, 'ddp-css-olena', 'olena-blog-v6');
        }
        if (strpos($post_content, 'olena_blog_v7')) {
            add_post_meta($post_id, 'ddp-css-olena', 'olena-blog-v7');
        }
        if (strpos($post_content, 'olena_blog_v8')) {
            add_post_meta($post_id, 'ddp-css-olena', 'olena-blog-v8');
        }
        if (strpos($post_content, 'olena_blog_v9')) {
            add_post_meta($post_id, 'ddp-css-olena', 'olena-blog-v9');
        }
        if (strpos($post_content, 'olena_blog_v10')) {
            add_post_meta($post_id, 'ddp-css-olena', 'olena-blog-v10');
        }
        if (strpos($post_content, 'olena_blog_v11')) {
            add_post_meta($post_id, 'ddp-css-olena', 'olena-blog-v11');
        }
        if (strpos($post_content, 'olena_blog_v12')) {
            add_post_meta($post_id, 'ddp-css-olena', 'olena-blog-v12');
        }

        if (strpos($post_content, 'olena_blurb_v1')) {
            add_post_meta($post_id, 'ddp-css-olena', 'olena-blurb-v1');
        }
        if (strpos($post_content, 'olena_blurb_v2')) {
            add_post_meta($post_id, 'ddp-css-olena', 'olena-blurb-v2');
        }
        if (strpos($post_content, 'olena_blurb_v3')) {
            add_post_meta($post_id, 'ddp-css-olena', 'olena-blurb-v3');
        }
        if (strpos($post_content, 'olena_blurb_v4')) {
            add_post_meta($post_id, 'ddp-css-olena', 'olena-blurb-v4');
        }
        if (strpos($post_content, 'olena_blurb_v5')) {
            add_post_meta($post_id, 'ddp-css-olena', 'olena-blurb-v5');
        }
        if (strpos($post_content, 'olena_blurb_v6')) {
            add_post_meta($post_id, 'ddp-css-olena', 'olena-blurb-v6');
        }
        if (strpos($post_content, 'olena_blurb_v7')) {
            add_post_meta($post_id, 'ddp-css-olena', 'olena-blurb-v7');
        }
        if (strpos($post_content, 'olena_blurb_v8')) {
            add_post_meta($post_id, 'ddp-css-olena', 'olena-blurb-v8');
        }
        if (strpos($post_content, 'olena_blurb_v9')) {
            add_post_meta($post_id, 'ddp-css-olena', 'olena-blurb-v9');
        }
        if (strpos($post_content, 'olena_blurb_v10')) {
            add_post_meta($post_id, 'ddp-css-olena', 'olena-blurb-v10');
        }
        if (strpos($post_content, 'olena_blurb_v11')) {
            add_post_meta($post_id, 'ddp-css-olena', 'olena-blurb-v11');
        }
        if (strpos($post_content, 'olena_blurb_v12')) {
            add_post_meta($post_id, 'ddp-css-olena', 'olena-blurb-v12');
        }
        if (strpos($post_content, 'olena_blurb_v13')) {
            add_post_meta($post_id, 'ddp-css-olena', 'olena-blurb-v13');
        }
        if (strpos($post_content, 'olena_blurb_v14')) {
            add_post_meta($post_id, 'ddp-css-olena', 'olena-blurb-v14');
        }
        if (strpos($post_content, 'olena_blurb_v15')) {
            add_post_meta($post_id, 'ddp-css-olena', 'olena-blurb-v15');
        }
        if (strpos($post_content, 'olena_blurb_v16')) {
            add_post_meta($post_id, 'ddp-css-olena', 'olena-blurb-v16');
        }
        if (strpos($post_content, 'olena_blurb_v17')) {
            add_post_meta($post_id, 'ddp-css-olena', 'olena-blurb-v17');
        }
        if (strpos($post_content, 'olena_blurb_v18')) {
            add_post_meta($post_id, 'ddp-css-olena', 'olena-blurb-v18');
        }
        if (strpos($post_content, 'olena_blurb_v19')) {
            add_post_meta($post_id, 'ddp-css-olena', 'olena-blurb-v19');
        }
        if (strpos($post_content, 'olena_blurb_v20')) {
            add_post_meta($post_id, 'ddp-css-olena', 'olena-blurb-v20');
        }
        if (strpos($post_content, 'olena_blurb_v21')) {
            add_post_meta($post_id, 'ddp-css-olena', 'olena-blurb-v21');
        }
        if (strpos($post_content, 'olena_blurb_v22')) {
            add_post_meta($post_id, 'ddp-css-olena', 'olena-blurb-v22');
        }
        if (strpos($post_content, 'olena_blurb_v24')) {
            add_post_meta($post_id, 'ddp-css-olena', 'olena-blurb-v24');
        }
        if (strpos($post_content, 'olena_blurb_v26')) {
            add_post_meta($post_id, 'ddp-css-olena', 'olena-blurb-v26');
        }
        if (strpos($post_content, 'olena_blurb_v27')) {
            add_post_meta($post_id, 'ddp-css-olena', 'olena-blurb-v27');
        }
        if (strpos($post_content, 'olena_blurb_v28')) {
            add_post_meta($post_id, 'ddp-css-olena', 'olena-blurb-v28');
        }
        if (strpos($post_content, 'olena_blurb_v29')) {
            add_post_meta($post_id, 'ddp-css-olena', 'olena-blurb-v29');
        }

        if (strpos($post_content, 'olena_woo_v1')) {
            add_post_meta($post_id, 'ddp-css-olena', 'olena-woo-v1');
        }
        if (strpos($post_content, 'olena_woo_v2')) {
            add_post_meta($post_id, 'ddp-css-olena', 'olena-woo-v2');
        }
        if (strpos($post_content, 'olena_woo_v3')) {
            add_post_meta($post_id, 'ddp-css-olena', 'olena-woo-v3');
        }
        if (strpos($post_content, 'olena_woo_v4')) {
            add_post_meta($post_id, 'ddp-css-olena', 'olena-woo-v4');
        }
        if (strpos($post_content, 'olena_woo_v5')) {
            add_post_meta($post_id, 'ddp-css-olena', 'olena-woo-v5');
        }
        if (strpos($post_content, 'olena_woo_v6')) {
            add_post_meta($post_id, 'ddp-css-olena', 'olena-woo-v6');
        }
        if (strpos($post_content, 'olena_woo_v7')) {
            add_post_meta($post_id, 'ddp-css-olena', 'olena-woo-v7');
        }
        if (strpos($post_content, 'olena_woo_v8')) {
            add_post_meta($post_id, 'ddp-css-olena', 'olena-woo-v8');
        }
        if (strpos($post_content, 'olena_woo_v9')) {
            add_post_meta($post_id, 'ddp-css-olena', 'olena-woo-v9');
        }
        if (strpos($post_content, 'olena_woo_v10')) {
            add_post_meta($post_id, 'ddp-css-olena', 'olena-woo-v10');
        }
        if (strpos($post_content, 'olena_woo_v11')) {
            add_post_meta($post_id, 'ddp-css-olena', 'olena-woo-v11');
        }
        if (strpos($post_content, 'olena_woo_v12')) {
            add_post_meta($post_id, 'ddp-css-olena', 'olena-woo-v12');
        }
        if (strpos($post_content, 'olena_woo_v13')) {
            add_post_meta($post_id, 'ddp-css-olena', 'olena-woo-v13');
        }
        if (strpos($post_content, 'olena_woo_v14')) {
            add_post_meta($post_id, 'ddp-css-olena', 'olena-woo-v14');
        }
        if (strpos($post_content, 'olena_number_v1')) {
            add_post_meta($post_id, 'ddp-css-olena', 'olena-numbers-v1');
        }
        if (strpos($post_content, 'olena_number_v3')) {
            add_post_meta($post_id, 'ddp-css-olena', 'olena-numbers-v3');
        }
        if (strpos($post_content, 'olena_number_v4')) {
            add_post_meta($post_id, 'ddp-css-olena', 'olena-numbers-v4');
        }
        if (strpos($post_content, 'olena_footer_v1')) {
            add_post_meta($post_id, 'ddp-css-olena', 'olena-footer-v1');
        }
        if (strpos($post_content, 'olena_footer_v2')) {
            add_post_meta($post_id, 'ddp-css-olena', 'olena-footer-v2');
        }
        if (strpos($post_content, 'olena_footer_v3')) {
            add_post_meta($post_id, 'ddp-css-olena', 'olena-footer-v3');
        }
        if (strpos($post_content, 'olena_footer_v4')) {
            add_post_meta($post_id, 'ddp-css-olena', 'olena-footer-v4');
        }
        if (strpos($post_content, 'olena_footer_v5')) {
            add_post_meta($post_id, 'ddp-css-olena', 'olena-footer-v5');
        }
        if (strpos($post_content, 'olena_footer_v7')) {
            add_post_meta($post_id, 'ddp-css-olena', 'olena-footer-v7');
        }
        if (strpos($post_content, 'olena_footer_v8')) {
            add_post_meta($post_id, 'ddp-css-olena', 'olena-footer-v8');
        }
        if (strpos($post_content, 'olena_footer_v9')) {
            add_post_meta($post_id, 'ddp-css-olena', 'olena-footer-v9');
        }
        if (strpos($post_content, 'olena_footer_v10')) {
            add_post_meta($post_id, 'ddp-css-olena', 'olena-footer-v10');
        }
        if (strpos($post_content, 'olena_footer_v11')) {
            add_post_meta($post_id, 'ddp-css-olena', 'olena-footer-v11');
        }
        if (strpos($post_content, 'olena_testimonial_v1')) {
            add_post_meta($post_id, 'ddp-css-olena', 'olena-testimonial-v1');
        }
        if (strpos($post_content, 'olena_testimonial_v2')) {
            add_post_meta($post_id, 'ddp-css-olena', 'olena-testimonial-v2');
        }
        if (strpos($post_content, 'olena_testimonial_v3')) {
            add_post_meta($post_id, 'ddp-css-olena', 'olena-testimonial-v3');
        }
        if (strpos($post_content, 'olena_testimonial_v4')) {
            add_post_meta($post_id, 'ddp-css-olena', 'olena-testimonial-v4');
        }
        if (strpos($post_content, 'olena_testimonial_v5')) {
            add_post_meta($post_id, 'ddp-css-olena', 'olena-testimonial-v5');
        }
        if (strpos($post_content, 'olena_testimonial_v6')) {
            add_post_meta($post_id, 'ddp-css-olena', 'olena-testimonial-v6');
        }
        if (strpos($post_content, 'olena_pt_v1')) {
            add_post_meta($post_id, 'ddp-css-olena', 'olena-pt-v1');
        }
        if (strpos($post_content, 'olena_architecture1_slide_text')) {
            add_post_meta($post_id, 'ddp-css-olena', 'olena-architecture1-slide-text');
        }
        if (strpos($post_content, 'olena_business1_slide_text')) {
            add_post_meta($post_id, 'ddp-css-olena', 'olena-business1-slide-text');
        }
        if (strpos($post_content, 'olena_creative1_slide_text')) {
            add_post_meta($post_id, 'ddp-css-olena', 'olena-creative1-slide-text');
        }


        //Olena ends


        } // function ddpdm_save_post_function($post_id, $post, $update)
    } // ddp enabled check ends

    //======================================================================
    // LOAD CSS BASED ON POST META
    //======================================================================


    function ddpdm_register_css($post_here)
    {
        // Fancybox
        wp_register_style('ddp-fancybox-css', plugins_url('build/fancybox/jquery.fancybox.css', __FILE__));
        wp_enqueue_style('ddp-fancybox-css');

        if (!$post_here) {
            $post = get_post();
        } else {
            $post = $post_here;
        }


        if ($post) {

        // Falkor
            foreach ((array) get_post_meta($post->ID, 'ddp-css-falkor') as $ddp_css_falkor) {
                if ($ddp_css_falkor == 'animated-lines') {
                    wp_enqueue_style('ddp-falkor-animated-lines', plugins_url('build/falkor/css/falkor-bg-color-for-animated-lines.css', __FILE__));
                }
                if ($ddp_css_falkor == 'falkor-blog') {
                    wp_enqueue_style('ddp-falkor-blog', plugins_url('build/falkor/css/falkor-blogs.css', __FILE__));
                }
                if ($ddp_css_falkor == 'falkor-blurb') {
                    wp_enqueue_style('ddp-falkor-blurb', plugins_url('build/falkor/css/falkor-blurb.css', __FILE__));
                }
                if ($ddp_css_falkor == 'falkor-cta') {
                    wp_enqueue_style('ddp-falkor-call-to-action', plugins_url('build/falkor/css/falkor-call-to-action.css', __FILE__));
                }
                if ($ddp_css_falkor == 'falkor-contact-forms') {
                    wp_enqueue_style('ddp-falkor-contact-forms', plugins_url('build/falkor/css/falkor-contact-forms.css', __FILE__));
                }
                if ($ddp_css_falkor == 'falkor-contact-page') {
                    wp_enqueue_style('ddp-falkor-contact-page', plugins_url('build/falkor/css/falkor-contact-page.css', __FILE__));
                }
                if ($ddp_css_falkor == 'falkor-content') {
                    wp_enqueue_style('ddp-falkor-content', plugins_url('build/falkor/css/falkor-content.css', __FILE__));
                }
                if ($ddp_css_falkor == 'falkor-footers') {
                    wp_enqueue_style('ddp-falkor-footers', plugins_url('build/falkor/css/falkor-footers.css', __FILE__));
                }
                if ($ddp_css_falkor == 'falkor-headers') {
                    wp_enqueue_style('ddp-falkor-headers', plugins_url('build/falkor/css/falkor-headers.css', __FILE__));
                }
                if ($ddp_css_falkor == 'falkor-home-pages') {
                    wp_enqueue_style('ddp-falkor-home-pages', plugins_url('build/falkor/css/falkor-home-pages.css', __FILE__));
                }
                if ($ddp_css_falkor == 'falkor-inside-pages') {
                    wp_enqueue_style('ddp-falkor-inside-pages', plugins_url('build/falkor/css/falkor-inside-pages.css', __FILE__));
                }
                if ($ddp_css_falkor == 'falkor-logos') {
                    wp_enqueue_style('ddp-falkor-logos', plugins_url('build/falkor/css/falkor-logos.css', __FILE__));
                }
                if ($ddp_css_falkor == 'falkor-numbers') {
                    wp_enqueue_style('ddp-falkor-numbers', plugins_url('build/falkor/css/falkor-numbers.css', __FILE__));
                }
                if ($ddp_css_falkor == 'falkor-person') {
                    wp_enqueue_style('ddp-falkor-person', plugins_url('build/falkor/css/falkor-person.css', __FILE__));
                }
                if ($ddp_css_falkor == 'falkor-pricing-table') {
                    wp_enqueue_style('ddp-falkor-pricing-table', plugins_url('build/falkor/css/falkor-pricing-table.css', __FILE__));
                }
                if ($ddp_css_falkor == 'falkor-slider') {
                    wp_enqueue_style('ddp-falkor-slider', plugins_url('build/falkor/css/falkor-slider.css', __FILE__));
                }
                if ($ddp_css_falkor == 'falkor-testimonials') {
                    wp_enqueue_style('ddp-falkor-testimonials', plugins_url('build/falkor/css/falkor-testimonials.css', __FILE__));
                }
            }

            //Jackson

            if (!empty(get_post_meta($post->ID, 'ddp-css-jackson'))) {
                wp_enqueue_style('ddp-jackson-home', plugins_url('build/jackson/css/jackson-home.css', __FILE__));
            }

            foreach ((array) get_post_meta($post->ID, 'ddp-css-jackson') as $ddp_css_jackson) {
                if ($ddp_css_jackson == 'jackson-404') {
                    wp_enqueue_style('ddp-jackson-404', plugins_url('build/jackson/css/jackson-404.css', __FILE__));
                    wp_enqueue_style('ddp-jackson-blog', plugins_url('build/jackson/css/jackson-blog.css', __FILE__));
                }
                if ($ddp_css_jackson == 'jackson-about') {
                    wp_enqueue_style('ddp-jackson-about', plugins_url('build/jackson/css/jackson-about.css', __FILE__));
                }
                if ($ddp_css_jackson == 'jackson-author') {
                    wp_enqueue_style('ddp-jackson-author', plugins_url('build/jackson/css/jackson-author.css', __FILE__));
                }
                if ($ddp_css_jackson == 'jackson-blog') {
                    wp_enqueue_style('ddp-jackson-blog', plugins_url('build/jackson/css/jackson-blog.css', __FILE__));
                }
                if ($ddp_css_jackson == 'jackson-case-study') {
                    wp_enqueue_style('ddp-jackson-case-study', plugins_url('build/jackson/css/jackson-case-study.css', __FILE__));
                }
                if ($ddp_css_jackson == 'jackson-category-page') {
                    wp_enqueue_style('ddp-jackson-blog', plugins_url('build/jackson/css/jackson-blog.css', __FILE__));
                    wp_enqueue_style('ddp-jackson-category-page', plugins_url('build/jackson/css/jackson-category-page.css', __FILE__));
                }
                if ($ddp_css_jackson == 'jackson-contact') {
                    wp_enqueue_style('ddp-jackson-contact', plugins_url('build/jackson/css/jackson-contact.css', __FILE__));
                    wp_enqueue_style('ddp-jackson-about', plugins_url('build/jackson/css/jackson-about.css', __FILE__));
                }
                if ($ddp_css_jackson == 'jackson-content') {
                    wp_enqueue_style('ddp-jackson-blog', plugins_url('build/jackson/css/jackson-blog.css', __FILE__));
                    wp_enqueue_style('ddp-jackson-content', plugins_url('build/jackson/css/jackson-content.css', __FILE__));
                }
                if ($ddp_css_jackson == 'jackson-footer') {
                    wp_enqueue_style('ddp-jackson-blog', plugins_url('build/jackson/css/jackson-blog.css', __FILE__));
                    wp_enqueue_style('ddp-jackson-footer', plugins_url('build/jackson/css/jackson-footer.css', __FILE__));
                }
                if ($ddp_css_jackson == 'jackson-how-we-work') {
                    wp_enqueue_style('ddp-jackson-how-we-work', plugins_url('build/jackson/css/jackson-how-we-work.css', __FILE__));
                }
                if ($ddp_css_jackson == 'jackson-search') {
                    wp_enqueue_style('ddp-jackson-search', plugins_url('build/jackson/css/jackson-search.css', __FILE__));
                }
                if ($ddp_css_jackson == 'jackson-services') {
                    wp_enqueue_style('ddp-jackson-services', plugins_url('build/jackson/css/jackson-services.css', __FILE__));
                }
                if ($ddp_css_jackson == 'jackson-single-post') {
                    wp_enqueue_style('ddp-jackson-single-post', plugins_url('build/jackson/css/jackson-single-post.css', __FILE__));
                }
                if ($ddp_css_jackson == 'jackson-team') {
                    wp_enqueue_style('ddp-jackson-team', plugins_url('build/jackson/css/jackson-team.css', __FILE__));
                }
                if ($ddp_css_jackson == 'jackson-transitions') {
                    wp_enqueue_style('ddp-jackson-transitions', plugins_url('build/jackson/css/jackson-transitions.css', __FILE__));
                }
            }

            // Mermaid

            foreach ((array) get_post_meta($post->ID, 'ddp-css-mermaid') as $ddp_css_mermaid) {
                if ($ddp_css_mermaid == 'mermaid-blog') {
                    wp_enqueue_style('ddp-mermaid-blog', plugins_url('build/mermaid/css/blog_mermaid_divi_kit.css', __FILE__));
                }
                if ($ddp_css_mermaid == 'mermaid-blurbs') {
                    wp_enqueue_style('ddp-mermaid-blurbs', plugins_url('build/mermaid/css/blurbs_mermaid_divi_kit.css', __FILE__));
                }
                if ($ddp_css_mermaid == 'mermaid-contact=form') {
                    wp_enqueue_style('ddp-mermaid-contact', plugins_url('build/mermaid/css/contact_mermaid_divi_kit.css', __FILE__));
                }
                if ($ddp_css_mermaid == 'mermaid-content') {
                    wp_enqueue_style('ddp-mermaid-content', plugins_url('build/mermaid/css/content_mermaid_divi_kit.css', __FILE__));
                }
                if ($ddp_css_mermaid == 'mermaid-footer') {
                    wp_enqueue_style('ddp-mermaid-footer', plugins_url('build/mermaid/css/footer_mermaid.css', __FILE__));
                }
                if ($ddp_css_mermaid == 'mermaid-lists') {
                    wp_enqueue_style('ddp-mermaid-lists', plugins_url('build/mermaid/css/lists_mermaid.css', __FILE__));
                }
                if ($ddp_css_mermaid == 'mermaid-masks') {
                    wp_enqueue_style('ddp-mermaid-masks', plugins_url('build/mermaid/css/masks_mermaid_divi_kit.css', __FILE__));
                }
                if ($ddp_css_mermaid == 'mermaid-buttons') {
                    wp_enqueue_style('ddp-mermaid-buttons', plugins_url('build/mermaid/css/mermaid_16_buttons_with_hover_effects_kit.css', __FILE__));
                }
                if ($ddp_css_mermaid == 'mermaid-pages') {
                    wp_enqueue_style('ddp-mermaid-pages', plugins_url('build/mermaid/css/pages_mermaid_divi_kit.css', __FILE__));
                }
                if ($ddp_css_mermaid == 'mermaid-persons') {
                    wp_enqueue_style('ddp-mermaid-persons', plugins_url('build/mermaid/css/persons_mermaid_divi_kit.css', __FILE__));
                }
                if ($ddp_css_mermaid == 'mermaid-slider') {
                    wp_enqueue_style('ddp-mermaid-slider', plugins_url('build/mermaid/css/slider_mermaid_divi_kit.css', __FILE__));
                }
                if ($ddp_css_mermaid == 'mermaid-about-page') {
                    wp_enqueue_style('ddp-mermaid-about-page', plugins_url('build/mermaid/css/mermaid-about-page-bonus.css', __FILE__));
                }
            }

            //Mozart
            foreach ((array) get_post_meta($post->ID, 'ddp-css-mozart') as $ddp_css_mozart) {
                if ($ddp_css_mozart == 'mozart-about') {
                    wp_enqueue_style('ddp-mozart-about', plugins_url('build/mozart/css/mozart-about.css', __FILE__));
                }
                if ($ddp_css_mozart == 'mozart-accountant') {
                    wp_enqueue_style('ddp-mozart-accountant', plugins_url('build/mozart/css/mozart-accountant.css', __FILE__));
                }
                if ($ddp_css_mozart == 'mozart-author') {
                    wp_enqueue_style('ddp-mozart-author', plugins_url('build/mozart/css/mozart-author-page.css', __FILE__));
                }
                if ($ddp_css_mozart == 'mozart-blog') {
                    wp_enqueue_style('ddp-mozart-blog', plugins_url('build/mozart/css/mozart-blog.css', __FILE__));
                    wp_enqueue_style('ddp-mozart-category-page', plugins_url('build/mozart/css/mozart-category-page.css', __FILE__));
                    wp_enqueue_style('ddp-mozart-single-post', plugins_url('build/mozart/css/mozart-single-post.css', __FILE__));
                }
                if ($ddp_css_mozart == 'mozart-category-page') {
                    wp_enqueue_style('ddp-mozart-blog', plugins_url('build/mozart/css/mozart-blog.css', __FILE__));
                    wp_enqueue_style('ddp-mozart-category-page', plugins_url('build/mozart/css/mozart-category-page.css', __FILE__));
                    wp_enqueue_style('ddp-mozart-single-post', plugins_url('build/mozart/css/mozart-single-post.css', __FILE__));
                }
                if ($ddp_css_mozart == 'mozart-coach') {
                    wp_enqueue_style('ddp-mozart-coach', plugins_url('build/mozart/css/mozart-coach.css', __FILE__));
                }
                if ($ddp_css_mozart == 'mozart-conference') {
                    wp_enqueue_style('ddp-mozart-conference', plugins_url('build/mozart/css/mozart-conference.css', __FILE__));
                }
                if ($ddp_css_mozart == 'mozart-consulting') {
                    wp_enqueue_style('ddp-mozart-consulting', plugins_url('build/mozart/css/mozart-consulting.css', __FILE__));
                }
                if ($ddp_css_mozart == 'mozart-contact') {
                    wp_enqueue_style('ddp-mozart-contact', plugins_url('build/mozart/css/mozart-contact.css', __FILE__));
                }
                if ($ddp_css_mozart == 'mozart-corporation') {
                    wp_enqueue_style('ddp-mozart-corporation', plugins_url('build/mozart/css/mozart-corporation.css', __FILE__));
                }
                if ($ddp_css_mozart == 'mozart-digital-business') {
                    wp_enqueue_style('ddp-mozart-digital-business', plugins_url('build/mozart/css/mozart-digital-business.css', __FILE__));
                }
                if ($ddp_css_mozart == 'mozart-faq') {
                    wp_enqueue_style('ddp-mozart-faq', plugins_url('build/mozart/css/mozart-faq.css', __FILE__));
                }
                if ($ddp_css_mozart == 'mozart-footer') {
                    wp_enqueue_style('ddp-mozart-footer', plugins_url('build/mozart/css/mozart-footer.css', __FILE__));
                }
                if ($ddp_css_mozart == 'mozart-header') {
                    wp_enqueue_style('ddp-mozart-header', plugins_url('build/mozart/css/mozart-header.css', __FILE__));
                }
                if ($ddp_css_mozart == 'mozart-inside') {
                    wp_enqueue_style('ddp-mozart-inside', plugins_url('build/mozart/css/mozart-inside.css', __FILE__));
                }
                if ($ddp_css_mozart == 'mozart-investment') {
                    wp_enqueue_style('ddp-mozart-investment', plugins_url('build/mozart/css/mozart-investment.css', __FILE__));
                }
                if ($ddp_css_mozart == 'mozart-law') {
                    wp_enqueue_style('ddp-mozart-law', plugins_url('build/mozart/css/mozart-law.css', __FILE__));
                }
                if ($ddp_css_mozart == 'mozart-search') {
                    wp_enqueue_style('ddp-mozart-search', plugins_url('build/mozart/css/mozart-search.css', __FILE__));
                }
                if ($ddp_css_mozart == 'mozart-single-post') {
                    wp_enqueue_style('ddp-mozart-single-post', plugins_url('build/mozart/css/mozart-single-post.css', __FILE__));
                }
                if ($ddp_css_mozart == 'mozart-start-up') {
                    wp_enqueue_style('ddp-mozart-start-up', plugins_url('build/mozart/css/mozart-start-up.css', __FILE__));
                }
                if ($ddp_css_mozart == 'mozart-team') {
                    wp_enqueue_style('ddp-mozart-team', plugins_url('build/mozart/css/mozart-team.css', __FILE__));
                }
                if ($ddp_css_mozart == 'mozart-transitions') {
                    wp_enqueue_style('ddp-mozart-transitions', plugins_url('build/mozart/css/mozart-transitions.css', __FILE__));
                }
            }

            // Pegasus
            foreach ((array) get_post_meta($post->ID, 'ddp-css-pegasus') as $ddp_css_pegasus) {
                if ($ddp_css_pegasus == 'pegasus-blog-pages') {
                    wp_enqueue_style('ddp-pegasus-blog-pages', plugins_url('build/pegasus/css/pegasus-blog-pages.css', __FILE__));
                }
                if ($ddp_css_pegasus == 'pegasus-blogs') {
                    wp_enqueue_style('ddp-pegasus-blogs', plugins_url('build/pegasus/css/pegasus-blogs.css', __FILE__));
                }
                if ($ddp_css_pegasus == 'pegasus-blurb') {
                    wp_enqueue_style('ddp-pegasus-blurbs', plugins_url('build/pegasus/css/pegasus-blurbs.css', __FILE__));
                }
                if ($ddp_css_pegasus == 'pegasus-cta') {
                    wp_enqueue_style('ddp-pegasus-cta', plugins_url('build/pegasus/css/pegasus-call-to-action.css', __FILE__));
                }
                if ($ddp_css_pegasus == 'pegasus-contact-page') {
                    wp_enqueue_style('ddp-pegasus-contact-page', plugins_url('build/pegasus/css/pegasus-contact-page.css', __FILE__));
                }
                if ($ddp_css_pegasus == 'pegasus-content') {
                    wp_enqueue_style('ddp-pegasus-content', plugins_url('build/pegasus/css/pegasus-content.css', __FILE__));
                }
                if ($ddp_css_pegasus == 'pegasus-footers' || $ddp_css_pegasus == 'pegasus-footer') {
                    wp_enqueue_style('ddp-pegasus-footers', plugins_url('build/pegasus/css/pegasus-footers.css', __FILE__));
                    wp_enqueue_style('ddp-pegasus-pages', plugins_url('build/pegasus/css/pegasus-pages.css', __FILE__));
                }
                if ($ddp_css_pegasus == 'pegasus-forms') {
                    wp_enqueue_style('ddp-pegasus-forms', plugins_url('build/pegasus/css/pegasus-forms.css', __FILE__));
                }
                if ($ddp_css_pegasus == 'pegasus-headers') {
                    wp_enqueue_style('ddp-pegasus-headers', plugins_url('build/pegasus/css/pegasus-headers.css', __FILE__));
                }
                if ($ddp_css_pegasus == 'pegasus-pages') {
                    wp_enqueue_style('ddp-pegasus-pages', plugins_url('build/pegasus/css/pegasus-pages.css', __FILE__));
                }
                if ($ddp_css_pegasus == 'pegasus-persons') {
                    wp_enqueue_style('ddp-pegasus-persons', plugins_url('build/pegasus/css/pegasus-persons.css', __FILE__));
                }
                if ($ddp_css_pegasus == 'pegasus-portfolio') {
                    wp_enqueue_style('ddp-pegasus-portfolio', plugins_url('build/pegasus/css/pegasus-portfolio.css', __FILE__));
                }
                if ($ddp_css_pegasus == 'pegasus-pricing-tables') {
                    wp_enqueue_style('ddp-pegasus-pricing-tables', plugins_url('build/pegasus/css/pegasus-pricing-tables.css', __FILE__));
                }
                if ($ddp_css_pegasus == 'pegasus-project-planner-page') {
                    wp_enqueue_style('ddp-pegasus-project-planner-page', plugins_url('build/pegasus/css/pegasus-project-planner-page.css', __FILE__));
                }
                if ($ddp_css_pegasus == 'pegasus-sliders') {
                    wp_enqueue_style('ddp-pegasus-sliders', plugins_url('build/pegasus/css/pegasus-sliders.css', __FILE__));
                }
                if ($ddp_css_pegasus == 'pegasus-tabs') {
                    wp_enqueue_style('ddp-pegasus-tabs', plugins_url('build/pegasus/css/pegasus-tabs.css', __FILE__));
                }
                if ($ddp_css_pegasus == 'pegasus-testimonials') {
                    wp_enqueue_style('ddp-pegasus-testimonials', plugins_url('build/pegasus/css/pegasus-testimonials.css', __FILE__));
                }
            }

            // Pixie
            foreach ((array) get_post_meta($post->ID, 'ddp-css-pixie') as $ddp_css_pixie) {
                if ($ddp_css_pixie == 'pixie-blog') {
                    wp_enqueue_style('ddp-pixie-blog', plugins_url('build/pixie/css/pixie-blog.css', __FILE__));
                }
                if ($ddp_css_pixie == 'pixie-blurbs') {
                    wp_enqueue_style('ddp-pixie-blurbs', plugins_url('build/pixie/css/pixie-blurbs.css', __FILE__));
                }
                if ($ddp_css_pixie == 'pixie-cta') {
                    wp_enqueue_style('ddp-pixie-cta', plugins_url('build/pixie/css/pixie-call-to-action.css', __FILE__));
                }
                if ($ddp_css_pixie == 'pixie-contact-basic-page') {
                    wp_enqueue_style('ddp-pixie-contact-basic-page', plugins_url('build/pixie/css/pixie-contact-basic-page.css', __FILE__));
                }
                if ($ddp_css_pixie == 'pixie-contact') {
                    wp_enqueue_style('ddp-pixie-contact', plugins_url('build/pixie/css/pixie-contact.css', __FILE__));
                    wp_enqueue_style('ddp-pixie-footer', plugins_url('build/pixie/css/pixie-footer.css', __FILE__));
                    wp_enqueue_style('ddp-pixie-content', plugins_url('build/pixie/css/pixie-content.css', __FILE__));
                }
                if ($ddp_css_pixie == 'pixie-content') {
                    wp_enqueue_style('ddp-pixie-content', plugins_url('build/pixie/css/pixie-content.css', __FILE__));
                }
                if ($ddp_css_pixie == 'pixie-footer') {
                    wp_enqueue_style('ddp-pixie-footer', plugins_url('build/pixie/css/pixie-footer.css', __FILE__));
                }
                if ($ddp_css_pixie == 'pixie-headers') {
                    wp_enqueue_style('ddp-pixie-headers', plugins_url('build/pixie/css/pixie-headers.css', __FILE__));
                }
                if ($ddp_css_pixie == 'pixie-master') {
                    wp_enqueue_style('ddp-pixie-master', plugins_url('build/pixie/css/pixie-master.css', __FILE__));
                }
                if ($ddp_css_pixie == 'pixie-numbers') {
                    wp_enqueue_style('ddp-pixie-numbers', plugins_url('build/pixie/css/pixie-numbers.css', __FILE__));
                }
                if ($ddp_css_pixie == 'pixie-person') {
                    wp_enqueue_style('ddp-pixie-person', plugins_url('build/pixie/css/pixie-person.css', __FILE__));
                }
                if ($ddp_css_pixie == 'pixie-personal-portfolio') {
                    wp_enqueue_style('ddp-personal-portfolio', plugins_url('build/pixie/css/pixie-personal-portfolio.css', __FILE__));
                }
                if ($ddp_css_pixie == 'pixie-portfolio') {
                    wp_enqueue_style('ddp-pixie-portfolio', plugins_url('build/pixie/css/pixie-portfolio.css', __FILE__));
                }
                if ($ddp_css_pixie == 'pixie-pricing-tables') {
                    wp_enqueue_style('ddp-pixie-pricing-tables', plugins_url('build/pixie/css/pixie-pricing-tables.css', __FILE__));
                }
                if ($ddp_css_pixie == 'pixie-project-page') {
                    wp_enqueue_style('ddp-pixie-project-page', plugins_url('build/pixie/css/pixie-project-page.css', __FILE__));
                }
                if ($ddp_css_pixie == 'pixie-tabs') {
                    wp_enqueue_style('ddp-pixie-tabs', plugins_url('build/pixie/css/pixie-tabs.css', __FILE__));
                }
                if ($ddp_css_pixie == 'pixie-testimonials') {
                    wp_enqueue_style('ddp-pixie-testimonials', plugins_url('build/pixie/css/pixie-testimonials.css', __FILE__));
                }
            }

            // Unicorn
            foreach ((array) get_post_meta($post->ID, 'ddp-css-unicorn') as $ddp_css_unicorn) {
                if ($ddp_css_unicorn == 'unicorn-blog') {
                    wp_register_style('ddp-fontawesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css');
                    wp_enqueue_style('ddp-fontawesome');
                    wp_enqueue_style('ddp-unicorn-blog', plugins_url('build/unicorn/css/blog-unicorn-divi-layout-kit.css', __FILE__));
                }
                if ($ddp_css_unicorn == 'unicorn-blurbs') {
                    wp_enqueue_style('ddp-unicorn-blurbs', plugins_url('build/unicorn/css/blurbs-unicorn-divi-layout-kit.css', __FILE__));
                }
                if ($ddp_css_unicorn == 'unicorn-contact-form') {
                    wp_enqueue_style('ddp-unicorn-contact-form', plugins_url('build/unicorn/css/contact-form-unicorn-divi-kit.css', __FILE__));
                }
                if ($ddp_css_unicorn == 'unicorn-contact-page') {
                    wp_enqueue_style('ddp-unicorn-contact-page', plugins_url('build/unicorn/css/contact-unicorn-divi-layout-kit.css', __FILE__));
                }
                if ($ddp_css_unicorn == 'unicorn-content') {
                    wp_register_style('ddp-fontawesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css');
                    wp_enqueue_style('ddp-fontawesome');
                    wp_enqueue_style('ddp-unicorn-content', plugins_url('build/unicorn/css/content-unicorn-divi-layout-kit.css', __FILE__));
                    // FontAwesome
                }
                if ($ddp_css_unicorn == 'unicorn-optin') {
                    wp_enqueue_style('ddp-unicorn-optin', plugins_url('build/unicorn/css/email-optin-unicorn-divi-kit.css', __FILE__));
                }
                if ($ddp_css_unicorn == 'unicorn-feature') {
                    wp_enqueue_style('ddp-unicorn-feature', plugins_url('build/unicorn/css/feature-unicorn-divi-layout-kit.css', __FILE__));
                }
                if ($ddp_css_unicorn == 'unicorn-footer') {
                    wp_enqueue_style('ddp-unicorn-footer', plugins_url('build/unicorn/css/footer-unicorn-divi-layout-kit.css', __FILE__));
                }
                if ($ddp_css_unicorn == 'unicorn-header') {
                    wp_enqueue_style('ddp-unicorn-header', plugins_url('build/unicorn/css/header-unicorn-divi-layout-kit.css', __FILE__));
                }
                if ($ddp_css_unicorn == 'unicorn-person') {
                    wp_enqueue_style('ddp-unicorn-person', plugins_url('build/unicorn/css/person-module-unicorn-divi-layout-kit.css', __FILE__));
                }
                if ($ddp_css_unicorn == 'unicorn-pricing-tables') {
                    wp_register_style('ddp-fontawesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css');
                    wp_enqueue_style('ddp-fontawesome');
                    wp_enqueue_style('ddp-unicorn-pricing-tables', plugins_url('build/unicorn/css/pricing-tables-unicorn-divi-layout-kit.css', __FILE__));
                }
                if ($ddp_css_unicorn == 'unicorn-testimonials') {
                    wp_enqueue_style('ddp-unicorn-testimonials', plugins_url('build/unicorn/css/testimonial-unicorn-divi-layout-kit.css', __FILE__));
                }
                if ($ddp_css_unicorn == 'unicorn-about-bonus') {
                    wp_enqueue_style('ddp-unicorn-about-bonus', plugins_url('build/unicorn/css/unicorn-about-bonus-layout.css', __FILE__));
                }
            }

            // Venus
            foreach ((array) get_post_meta($post->ID, 'ddp-css-venus') as $ddp_css_venus) {
                if ($ddp_css_venus == 'blog') {
                    wp_enqueue_style('ddp-venus-blog', plugins_url('build/venus/css/blog-venus.css', __FILE__));
                }
                if ($ddp_css_venus == 'blurbs') {
                    wp_enqueue_style('ddp-venus-blurbs', plugins_url('build/venus/css/blurbs-venus.css', __FILE__));
                }
                if ($ddp_css_venus == 'contact') {
                    wp_enqueue_style('ddp-venus-contact', plugins_url('build/venus/css/contact-venus.css', __FILE__));
                }
                if ($ddp_css_venus == 'cta') {
                    wp_enqueue_style('ddp-venus-cta', plugins_url('build/venus/css/cta-venus.css', __FILE__));
                }
                if ($ddp_css_venus == 'faq') {
                    wp_enqueue_style('ddp-venus-faq', plugins_url('build/venus/css/faq-venus.css', __FILE__));
                }
                if ($ddp_css_venus == 'features') {
                    wp_enqueue_style('ddp-venus-features', plugins_url('build/venus/css/features-venus.css', __FILE__));
                }
                if ($ddp_css_venus == 'header') {
                    wp_enqueue_style('ddp-venus-header', plugins_url('build/venus/css/header-venus.css', __FILE__));
                    wp_enqueue_style('ddp-venus-features', plugins_url('build/venus/css/features-venus.css', __FILE__));
                }
                if ($ddp_css_venus == 'person') {
                    wp_enqueue_style('ddp-venus-persons', plugins_url('build/venus/css/persons-venus.css', __FILE__));
                }
                if ($ddp_css_venus == 'pricing-tables') {
                    wp_enqueue_style('ddp-venus-pricing-tables', plugins_url('build/venus/css/pricing-tables-venus.css', __FILE__));
                }
                if ($ddp_css_venus == 'subscribe') {
                    wp_enqueue_style('ddp-venus-subscribe', plugins_url('build/venus/css/subscribe-venus.css', __FILE__));
                }
            }

            // Sigmund
            foreach ((array) get_post_meta($post->ID, 'ddp-css-sigmund') as $ddp_css_sigmund) {
                if ($ddp_css_sigmund == 'about-pages') {
                    wp_enqueue_style('ddp-sigmund-about-pages', plugins_url('build/sigmund/css/about_pages_sigmund.css', __FILE__));
                }
                if ($ddp_css_sigmund == 'blurbs') {
                    wp_enqueue_style('ddp-sigmunt-blurbs', plugins_url('build/sigmund/css/blurbs-sigmund.css', __FILE__));
                }
                if ($ddp_css_sigmund == 'contact-pages') {
                    wp_enqueue_style('ddp-sigmund-contact-pages', plugins_url('build/sigmund/css/contact_pages_sigmund.css', __FILE__));
                    wp_enqueue_style('ddp-sigmund-contact', plugins_url('build/sigmund/css/contact_sigmund.css', __FILE__));
                }
                if ($ddp_css_sigmund == 'contact') {
                    wp_enqueue_style('ddp-sigmund-contact', plugins_url('build/sigmund/css/contact_sigmund.css', __FILE__));
                    wp_enqueue_style('ddp-sigmund-contact-pages', plugins_url('build/sigmund/css/contact_pages_sigmund.css', __FILE__));
                }
                if ($ddp_css_sigmund == 'forms') {
                    wp_enqueue_style('ddp-sigmund-forms', plugins_url('build/sigmund/css/form-sigmund.css', __FILE__));
                }
                if ($ddp_css_sigmund == 'headers') {
                    wp_enqueue_style('ddp-sigmund-header', plugins_url('build/sigmund/css/headers-sigmund.css', __FILE__));
                    wp_enqueue_style('ddp-sigmund-contact-pages', plugins_url('build/sigmund/css/contact_pages_sigmund.css', __FILE__));
                }
                if ($ddp_css_sigmund == 'persons') {
                    wp_enqueue_style('ddp-sigmund-persons', plugins_url('build/sigmund/css/persons-sigmund.css', __FILE__));
                    wp_enqueue_style('ddp-sigmund-contact-pages', plugins_url('build/sigmund/css/contact_pages_sigmund.css', __FILE__));
                }
                if ($ddp_css_sigmund == 'portfolio') {
                    wp_enqueue_style('ddp-sigmund-portfolio', plugins_url('build/sigmund/css/portfolio-sigmund.css', __FILE__));
                }
                if ($ddp_css_sigmund == 'tabs') {
                    wp_enqueue_style('ddp-sigmund-tabs', plugins_url('build/sigmund/css/tabs-sigmund.css', __FILE__));
                }
                if ($ddp_css_sigmund == 'accordion') {
                    wp_enqueue_style('ddp-sigmund-contact-pages', plugins_url('build/sigmund/css/contact_pages_sigmund.css', __FILE__));
                }
                if ($ddp_css_sigmund == 'testimonials') {
                    wp_enqueue_style('ddp-sigmund-testimonials', plugins_url('build/sigmund/css/testimonials-sigmund.css', __FILE__));
                }
                if ($ddp_css_sigmund == 'footers') {
                    wp_enqueue_style('ddp-sigmund-footers', plugins_url('build/sigmund/css/footer-sigmund.css', __FILE__));
                }
                if ($ddp_css_sigmund == 'office') {
                    wp_enqueue_style('ddp-sigmund-office', plugins_url('build/sigmund/css/office_sigmund.css', __FILE__));
                }
                if ($ddp_css_sigmund == 'contents') {
                    wp_enqueue_style('ddp-sigmund-contents', plugins_url('build/sigmund/css/sigmund-contents.css', __FILE__));
                }
                if ($ddp_css_sigmund == 'cta') {
                    wp_enqueue_style('ddp-sigmund-cta', plugins_url('build/sigmund/css/sigmund-cta.css', __FILE__));
                }
                if ($ddp_css_sigmund == 'faq') {
                    wp_enqueue_style('ddp-sigmund-faq', plugins_url('build/sigmund/css/sigmund-faq.css', __FILE__));
                }
                if ($ddp_css_sigmund == 'table-page1') {
                    wp_enqueue_style('ddp-sigmund-table-page1', plugins_url('build/sigmund/css/sigmund-pricing-tabel-page1.css', __FILE__));
                }
                if ($ddp_css_sigmund == 'pricing-tables') {
                    wp_enqueue_style('ddp-sigmund-pricing-tables', plugins_url('build/sigmund/css/sigmund-pricing-tabels.css', __FILE__));
                }
                if ($ddp_css_sigmund == 'services-page1') {
                    wp_enqueue_style('ddp-sigmund-service-page1', plugins_url('build/sigmund/css/sigmund-services-page1.css', __FILE__));
                }
                if ($ddp_css_sigmund == 'team-page1') {
                    wp_enqueue_style('ddp-sigmund-team-page1', plugins_url('build/sigmund/css/sigmund-team-page1.css', __FILE__));
                }
                if ($ddp_css_sigmund == 'team-page2') {
                    wp_enqueue_style('ddp-sigmund-team-page2', plugins_url('build/sigmund/css/sigmund-team-page2.css', __FILE__));
                }
                if ($ddp_css_sigmund == 'testimonials') {
                    wp_enqueue_style('ddp-sigmund-testimonials', plugins_url('build/sigmund/css/testimonials-sigmund.css', __FILE__));
                }
            }

            // Impi
            foreach ((array) get_post_meta($post->ID, 'ddp-css-impi') as $ddp_css_impi) {
                if ($ddp_css_impi == 'headers') {
                    wp_enqueue_style('ddp-impi-headers', plugins_url('build/impi/css/impi-headers.css', __FILE__));
                }

                if ($ddp_css_impi == 'testimonials') {
                    wp_enqueue_style('ddp-impi-tesimonials', plugins_url('build/impi/css/impi-testimonials.css', __FILE__));
                }

                if ($ddp_css_impi == 'blurbs') {
                    wp_enqueue_style('ddp-impi-blurbs', plugins_url('build/impi/css/impi-blurbs.css', __FILE__));
                }

                if ($ddp_css_impi == 'persons') {
                    wp_enqueue_style('ddp-impi-persons', plugins_url('build/impi/css/impi-persons.css', __FILE__));
                }

                if ($ddp_css_impi == 'blogs') {
                    wp_enqueue_style('ddp-impi-blogs', plugins_url('build/impi/css/impi-blogs.css', __FILE__));
                }

                if ($ddp_css_impi == 'forms') {
                    wp_enqueue_style('ddp-impi-forms', plugins_url('build/impi/css/impi-forms.css', __FILE__));
                }

                if ($ddp_css_impi == 'pricing-tables') {
                    wp_enqueue_style('ddp-impi-pricing-tables', plugins_url('build/impi/css/impi-pricing-table.css', __FILE__));
                }

                if ($ddp_css_impi == 'sliders') {
                    wp_enqueue_style('ddp-impi-sliders', plugins_url('build/impi/css/impi-sliders.css', __FILE__));
                }

                if ($ddp_css_impi == 'footers') {
                    wp_enqueue_style('ddp-impi-footers', plugins_url('build/impi/css/impi_pages_footer.css', __FILE__));
                }

                if ($ddp_css_impi == 'home-pages') {
                    wp_enqueue_style('ddp-impi-home-page', plugins_url('build/impi/css/impi-home-page.css', __FILE__));
                }

                if ($ddp_css_impi == 'service-pages') {
                    wp_enqueue_style('ddp-impi-service-page', plugins_url('build/impi/css/impi-services-page.css', __FILE__));
                }

                if ($ddp_css_impi == 'about-page') {
                    wp_enqueue_style('ddp-impi-about-page', plugins_url('build/impi/css/impi-about-page.css', __FILE__));
                }

                if ($ddp_css_impi == 'team-page') {
                    wp_enqueue_style('ddp-impi-team-page', plugins_url('build/impi/css/impi-team-page.css', __FILE__));
                }

                if ($ddp_css_impi == 'contents') {
                    wp_enqueue_style('ddp-impi-contents', plugins_url('build/impi/css/impi-contents.css', __FILE__));
                }

                if ($ddp_css_impi == 'cta') {
                    wp_enqueue_style('ddp-impi-cta', plugins_url('build/impi/css/impi-cta.css', __FILE__));
                }

                if ($ddp_css_impi == 'logos') {
                    wp_enqueue_style('ddp-impi-logos', plugins_url('build/impi/css/impi-logos.css', __FILE__));
                }

                if ($ddp_css_impi == 'faq') {
                    wp_enqueue_style('ddp-impi-faq', plugins_url('build/impi/css/impi-faq.css', __FILE__));
                }

                if ($ddp_css_impi == 'portfolio') {
                    wp_enqueue_style('ddp-impi-portfolio', plugins_url('build/impi/css/impi-portfolio.css', __FILE__));
                }

                if ($ddp_css_impi == 'products') {
                    wp_enqueue_style('ddp-impi-product', plugins_url('build/impi/css/impi-product.css', __FILE__));
                }
            }

            // Coco
            foreach ((array) get_post_meta($post->ID, 'ddp-css-coco') as $ddp_css_coco) {
                if ($ddp_css_coco == 'blurbs') {
                    wp_enqueue_style('ddp-coco-blurbs', plugins_url('build/coco/css/coco-blurbs.css', __FILE__));
                }

                if ($ddp_css_coco == 'footers') {
                    wp_enqueue_style('ddp-coco-footers', plugins_url('build/coco/css/coco-footers.css', __FILE__));
                }

                if ($ddp_css_coco == 'headers') {
                    wp_enqueue_style('ddp-coco-headers', plugins_url('build/coco/css/coco-headers.css', __FILE__));
                    wp_enqueue_style('ddp-coco-sliders', plugins_url('build/coco/css/coco-sliders.css', __FILE__));
                }

                if ($ddp_css_coco == 'pricing-tables') {
                    wp_enqueue_style('ddp-coco-pricing-tables', plugins_url('build/coco/css/coco-pricing-tabels.css', __FILE__));
                }

                if ($ddp_css_coco == 'newsletter') {
                    wp_enqueue_style('ddp-coco-newsletter', plugins_url('build/coco/css/coco-signup-forms.css', __FILE__));
                }

                if ($ddp_css_coco == 'sliders') {
                    wp_enqueue_style('ddp-coco-sliders', plugins_url('build/coco/css/coco-sliders.css', __FILE__));
                }

                if ($ddp_css_coco == 'content') {
                    wp_enqueue_style('ddp-coco-content', plugins_url('build/coco/css/coco-contents.css', __FILE__));
                }

                if ($ddp_css_coco == 'testimonials') {
                    wp_enqueue_style('ddp-coco-testimonials', plugins_url('build/coco/css/coco-testimonials.css', __FILE__));
                }

                if ($ddp_css_coco == 'portfolio') {
                    wp_enqueue_style('ddp-coco-portfolio', plugins_url('build/coco/css/coco-portfolio.css', __FILE__));
                }

                if ($ddp_css_coco == 'cta') {
                    wp_enqueue_style('ddp-coco-cta', plugins_url('build/coco/css/coco-cta.css', __FILE__));
                }

                if ($ddp_css_coco == 'persons') {
                    wp_enqueue_style('ddp-coco-persons', plugins_url('build/coco/css/coco-persons.css', __FILE__));
                }

                if ($ddp_css_coco == 'image-loader') {
                    wp_enqueue_style('ddp-coco-image-loader', plugins_url('build/coco/css/coco-image-loader.css', __FILE__));
                }

                if ($ddp_css_coco == 'forms') {
                    wp_enqueue_style('ddp-coco-forms', plugins_url('build/coco/css/coco-forms.css', __FILE__));
                }

                if ($ddp_css_coco == 'contact-page') {
                    wp_enqueue_style('ddp-coco-contact-page', plugins_url('build/coco/css/coco-contact-page.css', __FILE__));
                }

                if ($ddp_css_coco == 'ecommerce-pages') {
                    wp_enqueue_style('ddp-coco-ecommerce-pages', plugins_url('build/coco/css/coco-ecommerce-pages.css', __FILE__));
                }

                if ($ddp_css_coco == 'products') {
                    wp_enqueue_style('ddp-coco-products', plugins_url('build/coco/css/coco-products.css', __FILE__));
                }
            }


            // Jamie
            if (!empty(get_post_meta($post->ID, 'ddp-css-jamie'))) {
                wp_enqueue_style('ddp-jamie-home', plugins_url('build/jamie/css/jamie-home.css', __FILE__));
                wp_enqueue_style('ddp-jamie-menu', plugins_url('build/jamie/css/jamie-menu.css', __FILE__));
                wp_enqueue_style('ddp-jamie-about', plugins_url('build/jamie/css/jamie-about.css', __FILE__));
                wp_enqueue_style('ddp-jamie-blog-landing', plugins_url('build/jamie/css/jamie-blog-landing1.css', __FILE__));
                wp_enqueue_style('ddp-jamie-blog', plugins_url('build/jamie/css/jamie-blog.css', __FILE__));
                wp_enqueue_style('ddp-jamie-contact', plugins_url('build/jamie/css/jamie-contact.css', __FILE__));
                wp_enqueue_style('ddp-jamie-content', plugins_url('build/jamie/css/jamie-content.css', __FILE__));
                wp_enqueue_style('ddp-jamie-events', plugins_url('build/jamie/css/jamie-event.css', __FILE__));
                wp_enqueue_style('ddp-jamie-services', plugins_url('build/jamie/css/jamie-services.css', __FILE__));
                wp_enqueue_style('ddp-jamie-team-detail', plugins_url('build/jamie/css/jamie-team-detail.css', __FILE__));
                wp_enqueue_style('ddp-jamie-team-page', plugins_url('build/jamie/css/jamie-team.css', __FILE__));
                wp_enqueue_style('ddp-jamie-home-bar-page', plugins_url('build/jamie/css/jamie-home-bar.css', __FILE__));
                wp_enqueue_style('ddp-jamie-home-hotel-page', plugins_url('build/jamie/css/jamie-home-hotel.css', __FILE__));
                wp_enqueue_style('ddp-jamie-footer', plugins_url('build/jamie/css/jamie-footer.css', __FILE__));
            }

            // Demo
            foreach ((array) get_post_meta($post->ID, 'ddp-css-demo') as $ddp_css_demo) {
                if ($ddp_css_demo == 'demo-personal-trainer-page') {
                    wp_enqueue_style('ddp-demo-personal-trainer-page', plugins_url('build/demo/css/demo-personal-trainer.css', __FILE__));
                }

                if ($ddp_css_demo == 'demo-dentist-page') {
                    wp_enqueue_style('ddp-demo-dentist-page', plugins_url('build/demo/css/demo-dentist.css', __FILE__));
                }

                if ($ddp_css_demo == 'demo-electrician-page') {
                    wp_enqueue_style('ddp-demo-electrician-page', plugins_url('build/demo/css/demo-electrician.css', __FILE__));
                }

                if ($ddp_css_demo == 'demo-driving-school-page') {
                    wp_enqueue_style('ddp-demo-driving-school-page', plugins_url('build/demo/css/demo-driving-school.css', __FILE__));
                }

                if ($ddp_css_demo == 'demo-vet-page') {
                    wp_enqueue_style('ddp-demo-vet-page', plugins_url('build/demo/css/demo-vet.css', __FILE__));
                }

                if ($ddp_css_demo == 'demo-plumber-page') {
                    wp_enqueue_style('ddp-demo-plumber-page', plugins_url('build/demo/css/demo-plumber.css', __FILE__));
                }

                if ($ddp_css_demo == 'demo-landscaping-page') {
                    wp_enqueue_style('ddp-demo-landscaping-page', plugins_url('build/demo/css/demo-landscaping.css', __FILE__));
                }

                if ($ddp_css_demo == 'demo-band-page') {
                    wp_enqueue_style('ddp-demo-band-page', plugins_url('build/demo/css/demo-band.css', __FILE__));
                }

                if ($ddp_css_demo == 'demo-hairdresser-page') {
                    wp_enqueue_style('ddp-demo-hairdresser-page', plugins_url('build/demo/css/demo-hairdresser.css', __FILE__));
                }

                if ($ddp_css_demo == 'demo-high-school-page') {
                    wp_enqueue_style('ddp-demo-high-school-page', plugins_url('build/demo/css/demo-high-school.css', __FILE__));
                }

                if ($ddp_css_demo == 'demo-ngo-page') {
                    wp_enqueue_style('ddp-demo-ngo-page', plugins_url('build/demo/css/demo-ngo.css', __FILE__));
                }

                if ($ddp_css_demo == 'demo-onlineapp') {
                    wp_enqueue_style('ddp-demo-onlineapp-page', plugins_url('build/demo/css/demo-onlineapp.css', __FILE__));
                }

                if ($ddp_css_demo == 'demo-catering') {
                    wp_enqueue_style('ddp-demo-catering-page', plugins_url('build/demo/css/demo-catering.css', __FILE__));
                }

                if ($ddp_css_demo == 'demo-real-estate') {
                    wp_enqueue_style('ddp-demo-real-estate-page', plugins_url('build/demo/css/demo-real-estate.css', __FILE__));
                }

                if ($ddp_css_demo == 'demo-handyman') {
                    wp_enqueue_style('ddp-demo-handyman-page', plugins_url('build/demo/css/demo-handyman.css', __FILE__));
                }

                if ($ddp_css_demo == 'demo-call-center') {
                    wp_enqueue_style('ddp-demo-callcenter-page', plugins_url('build/demo/css/demo-call-center.css', __FILE__));
                }

                if ($ddp_css_demo == 'demo-dance-studio') {
                    wp_enqueue_style('ddp-demo-dance-studior-page', plugins_url('build/demo/css/demo-dance-studio.css', __FILE__));
                }

                if ($ddp_css_demo == 'demo-clinic') {
                    wp_enqueue_style('ddp-demo-clinic-page', plugins_url('build/demo/css/demo-clinic.css', __FILE__));
                }

                if ($ddp_css_demo == 'demo-florist') {
                    wp_enqueue_style('ddp-demo-florist-page', plugins_url('build/demo/css/demo-florist.css', __FILE__));
                }

                if ($ddp_css_demo == 'demo-cleaner') {
                    wp_enqueue_style('ddp-demo-cleaner-page', plugins_url('build/demo/css/demo-cleaner.css', __FILE__));
                }

                if ($ddp_css_demo == 'demo-dietitian') {
                    wp_enqueue_style('ddp-demo-dietitian-page', plugins_url('build/demo/css/demo-dietitian.css', __FILE__));
                }

                if ($ddp_css_demo == 'demo-factory') {
                    wp_enqueue_style('ddp-demo-factory-page', plugins_url('build/demo/css/demo-factory.css', __FILE__));
                }

                if ($ddp_css_demo == 'demo-flooring') {
                    wp_enqueue_style('ddp-pegasus-persons', plugins_url('build/pegasus/css/pegasus-persons.css', __FILE__));
                    wp_enqueue_style('ddp-demo-flooring-page', plugins_url('build/demo/css/demo-flooring.css', __FILE__));
                }

                if ($ddp_css_demo == 'demo-movers') {
                    wp_enqueue_style('ddp-demo-movers-page', plugins_url('build/demo/css/demo-movers.css', __FILE__));
                }

                if ($ddp_css_demo == 'demo-logistics') {
                    wp_enqueue_style('ddp-demo-logistics-page', plugins_url('build/demo/css/demo-logistics.css', __FILE__));
                }

                if ($ddp_css_demo == 'demo-kindergarten') {
                    wp_enqueue_style('ddp-demo-kindergarten-page', plugins_url('build/demo/css/demo-kindergarten.css', __FILE__));
                }

                if ($ddp_css_demo == 'demo-massage') {
                    wp_enqueue_style('ddp-demo-massage-page', plugins_url('build/demo/css/demo-massage.css', __FILE__));
                }

                if ($ddp_css_demo == 'demo-model') {
                    wp_enqueue_style('ddp-demo-model-page', plugins_url('build/demo/css/demo-model.css', __FILE__));
                }

                if ($ddp_css_demo == 'demo-novelist') {
                    wp_enqueue_style('ddp-demo-novelist-page', plugins_url('build/demo/css/demo-novelist.css', __FILE__));
                }

                if ($ddp_css_demo == 'demo-psychologist') {
                    wp_enqueue_style('ddp-demo-psychologist-page', plugins_url('build/demo/css/demo-psychologist.css', __FILE__));
                }

                if ($ddp_css_demo == 'demo-ski') {
                    wp_enqueue_style('ddp-demo-ski-page', plugins_url('build/demo/css/demo-ski.css', __FILE__));
                }

                if ($ddp_css_demo == 'demo-wedding') {
                    wp_enqueue_style('ddp-demo-wedding-page', plugins_url('build/demo/css/demo-wedding.css', __FILE__));
                }

                if ($ddp_css_demo == 'demo-taxi') {
                    wp_enqueue_style('ddp-demo-taxi-page', plugins_url('build/demo/css/demo-taxi.css', __FILE__));
                }

                if ($ddp_css_demo == 'demo-tea') {
                    wp_enqueue_style('ddp-demo-tea-page', plugins_url('build/demo/css/demo-tea.css', __FILE__));
                }

                if ($ddp_css_demo == 'demo-summer-camp') {
                    wp_enqueue_style('ddp-demo-summer-camp', plugins_url('build/demo/css/demo-summer-camp.css', __FILE__));
                }

                if ($ddp_css_demo == 'demo-tailor') {
                    wp_enqueue_style('ddp-demo-tailor-page', plugins_url('build/demo/css/demo-tailor.css', __FILE__));
                }

                if ($ddp_css_demo == 'demo-surf-club') {
                    wp_enqueue_style('ddp-demo-surf-club-page', plugins_url('build/demo/css/demo-surf-club.css', __FILE__));
                }

                if ($ddp_css_demo == 'demo-beer') {
                    wp_enqueue_style('ddp-demo-beer-page', plugins_url('build/demo/css/demo-beer.css', __FILE__));
                }

                if ($ddp_css_demo == 'demo-translator') {
                    wp_enqueue_style('ddp-demo-translator-page', plugins_url('build/demo/css/demo-translator.css', __FILE__));
                }

                if ($ddp_css_demo == 'demo-vegetable') {
                    wp_enqueue_style('ddp-demo-vegetable-page', plugins_url('build/demo/css/demo-vegetable.css', __FILE__));
                }

                if ($ddp_css_demo == 'demo-photographer') {
                    wp_enqueue_style('ddp-demo-photographer-page', plugins_url('build/demo/css/demo-photographer.css', __FILE__));
                }

                if ($ddp_css_demo == 'demo-camp-ground') {
                    wp_enqueue_style('ddp-demo-camp-ground-page', plugins_url('build/demo/css/demo-camp-ground.css', __FILE__));
                }

                if ($ddp_css_demo == 'demo-wine') {
                    wp_enqueue_style('ddp-demo-wine-page', plugins_url('build/demo/css/demo-wine.css', __FILE__));
                }

                if ($ddp_css_demo == 'demo-upholsterer') {
                    wp_enqueue_style('ddp-demo-upholsterer-page', plugins_url('build/demo/css/demo-upholsterer.css', __FILE__));
                }

                if ($ddp_css_demo == 'demo-marina') {
                    wp_enqueue_style('ddp-demo-marina-page', plugins_url('build/demo/css/demo-marina.css', __FILE__));
                }

                if ($ddp_css_demo == 'demo-nail') {
                    wp_enqueue_style('ddp-demo-nail-page', plugins_url('build/demo/css/demo-nail.css', __FILE__));
                }

                if ($ddp_css_demo == 'demo-print') {
                    wp_enqueue_style('ddp-demo-print-page', plugins_url('build/demo/css/demo-print.css', __FILE__));
                }

                if ($ddp_css_demo == 'demo-security') {
                    wp_enqueue_style('ddp-demo-security-page', plugins_url('build/demo/css/demo-security.css', __FILE__));
                }

                if ($ddp_css_demo == 'demo-animalshelter') {
                    wp_enqueue_style('ddp-demo-animalshelter-page', plugins_url('build/demo/css/demo-animalshelter.css', __FILE__));
                }

                if ($ddp_css_demo == 'demo-horse') {
                    wp_enqueue_style('ddp-demo-horse-page', plugins_url('build/demo/css/demo-horse.css', __FILE__));
                }

                if ($ddp_css_demo == 'demo-icecream') {
                    wp_enqueue_style('ddp-demo-icecream-page', plugins_url('build/demo/css/demo-ice-cream.css', __FILE__));
                }

                if ($ddp_css_demo == 'demo-fight') {
                    wp_enqueue_style('ddp-demo-fight-page', plugins_url('build/demo/css/demo-fight.css', __FILE__));
                }

                if ($ddp_css_demo == 'demo-yoga-home') {
                    wp_enqueue_style('ddp-demo-yoga-home', plugins_url('build/demo/css/demo-yoga.css', __FILE__));
                }

                if ($ddp_css_demo == 'demo-business-home') {
                    wp_enqueue_style('ddp-demo-business-home', plugins_url('build/demo/css/demo-business.css', __FILE__));
                }

                if ($ddp_css_demo == 'demo-event-home') {
                    wp_enqueue_style('ddp-demo-event-home', plugins_url('build/demo/css/demo-event.css', __FILE__));
                }

                if ($ddp_css_demo == 'demo-spa-home') {
                    wp_enqueue_style('ddp-demo-spa-home', plugins_url('build/demo/css/demo-spa.css', __FILE__));
                }

                if ($ddp_css_demo == 'demo-hostel-home') {
                    wp_enqueue_style('ddp-demo-hostel-home', plugins_url('build/demo/css/demo-hostel.css', __FILE__));
                }

                if ($ddp_css_demo == 'life-coach-home') {
                    wp_enqueue_style('ddp-life-coach-home', plugins_url('build/demo/css/demo-life-coach.css', __FILE__));
                }

                if ($ddp_css_demo == 'carpet-cleaner-home') {
                    wp_enqueue_style('ddp-carpet-cleaner-home', plugins_url('build/demo/css/demo-carpet-cleaner.css', __FILE__));
                }

                if ($ddp_css_demo == 'styling-home') {
                    wp_enqueue_style('ddp-styling-home', plugins_url('build/demo/css/demo-styling.css', __FILE__));
                }
            
                if ($ddp_css_demo == 'demo-makeup-home') {
                    wp_enqueue_style('ddp-demo-makeup-home', plugins_url('build/demo/css/demo-makeup.css', __FILE__));
                }
            }

            // Diana
            foreach ((array) get_post_meta($post->ID, 'ddp-css-diana') as $ddp_css_diana) {
                if ($ddp_css_diana == 'diana-blogs') {
                    wp_enqueue_style('ddp-diana-blogs', plugins_url('build/diana/css/diana-blogs.css', __FILE__));
                }

                if ($ddp_css_diana == 'diana-blurbs') {
                    wp_enqueue_style('ddp-diana-blurbs', plugins_url('build/diana/css/diana-blurbs.css', __FILE__));
                }

                if ($ddp_css_diana == 'diana-contents') {
                    wp_enqueue_style('ddp-diana-contents', plugins_url('build/diana/css/diana-contents.css', __FILE__));
                }

                if ($ddp_css_diana == 'diana-footers') {
                    wp_enqueue_style('ddp-diana-footers', plugins_url('build/diana/css/diana-footers.css', __FILE__));
                }

                if ($ddp_css_diana == 'diana-headers') {
                    wp_enqueue_style('ddp-diana-headers', plugins_url('build/diana/css/diana-headers.css', __FILE__));
                }

                if ($ddp_css_diana == 'diana-persons') {
                    wp_enqueue_style('ddp-diana-persons', plugins_url('build/diana/css/diana-persons.css', __FILE__));
                }

                if ($ddp_css_diana == 'diana-cta') {
                    wp_enqueue_style('ddp-diana-cta', plugins_url('build/diana/css/diana-cta.css', __FILE__));
                }

                if ($ddp_css_diana == 'diana-sliders') {
                    wp_enqueue_style('ddp-diana-sliders', plugins_url('build/diana/css/diana-sliders.css', __FILE__));
                }

                if ($ddp_css_diana == 'diana-testimonials') {
                    wp_enqueue_style('ddp-diana-testimonials', plugins_url('build/diana/css/diana-testimonials.css', __FILE__));
                }
                if ($ddp_css_diana == 'diana-404') {
                    wp_enqueue_style('ddp-diana-404-page-1', plugins_url('build/diana/css/diana-404-page1.css', __FILE__));
                }
                if ($ddp_css_diana == 'diana-vetical-coming-soon') {
                    wp_enqueue_style('ddp-diana-coming-soon-page-1', plugins_url('build/diana/css/diana-coming-soon-page1.css', __FILE__));
                }
                if ($ddp_css_diana == 'diana-full-width-under-construction') {
                    wp_enqueue_style('ddp-diana-coming-soon-page-2', plugins_url('build/diana/css/diana-coming-soon-page2.css', __FILE__));
                }
                if ($ddp_css_diana == 'diana-single-post-v1') {
                    wp_enqueue_style('ddp-diana-single-post-v1', plugins_url('build/diana/css/diana-single-post-v1-divi.css', __FILE__));
                }
                if ($ddp_css_diana == 'diana-sticky-bars') {
                    wp_enqueue_style('ddp-diana-sticky-bar-css', plugins_url('build/diana/css/diana-sticky-header.css', __FILE__));

                    for ($i = 1; $i <= 11; $i++) {
                        wp_enqueue_style('ddp-diana-sticky-bar'.$i.'-css', plugins_url('build/diana/css/diana-sticky-header'.$i.'.css', __FILE__));
                    }
                }
                if ($ddp_css_diana == 'diana-pop-up') {
                    wp_enqueue_style('ddp-diana-pop-up-css', plugins_url('build/diana/css/diana-overlays-popups.css', __FILE__));
                    wp_enqueue_style('ddp-diana-pop-up6-css', plugins_url('build/diana/css/diana-overlays-popups6.css', __FILE__));
                    wp_enqueue_style('ddp-diana-pop-up8-css', plugins_url('build/diana/css/diana-overlays-popups8.css', __FILE__));
                    wp_enqueue_style('ddp-diana-pop-up7-css', plugins_url('build/diana/css/diana-overlays-popups7.css', __FILE__));
                    wp_enqueue_style('ddp-diana-pop-up5-css', plugins_url('build/diana/css/diana-overlays-popups5.css', __FILE__));
                    wp_enqueue_style('ddp-diana-pop-up4-css', plugins_url('build/diana/css/diana-overlays-popups4.css', __FILE__));
                    wp_enqueue_style('ddp-diana-pop-up3-css', plugins_url('build/diana/css/diana-overlays-popups3.css', __FILE__));
                    wp_enqueue_style('ddp-diana-pop-up2-css', plugins_url('build/diana/css/diana-overlays-popups2.css', __FILE__));
                }
                if ($ddp_css_diana == 'diana-pricing-tables') {
                    wp_enqueue_style('ddp-diana-pricing-tables', plugins_url('build/diana/css/diana-pt.css', __FILE__));
                }
                if ($ddp_css_diana == 'diana-ruling-header') {
                    wp_enqueue_script('ddp-social-icons-js', plugins_url('build/diana/js/diana-social-icons.js', __FILE__), array( 'wp-i18n' ));
                    wp_enqueue_style('ddp-diana-ruling-header', plugins_url('build/diana/css/diana-ruling-header.css', __FILE__));
                }
                if ($ddp_css_diana == 'diana-numbers') {
                    wp_enqueue_style('ddp-diana-numbers', plugins_url('build/diana/css/diana-numbers.css', __FILE__));
                }

                if ($ddp_css_diana == 'diana-fashion-header') {
                    wp_enqueue_style('ddp-diana-fashion-header', plugins_url('build/diana/css/diana-fashion-header.css', __FILE__));
                }

                if ($ddp_css_diana == 'diana-authoritative-products') {
                    wp_enqueue_style('ddp-diana-authoritative-products', plugins_url('build/diana/css/diana-authoritative-products.css', __FILE__));
                }

                if ($ddp_css_diana == 'diana-about-four') {
                    wp_enqueue_style('ddp-diana-about-page-4', plugins_url('build/diana/css/diana-about-4.css', __FILE__));
                }

                if ($ddp_css_diana == 'diana-never-knew-content') {
                    wp_enqueue_style('ddp-diana-never-knew-content', plugins_url('build/diana/css/diana-never-knew-content.css', __FILE__));
                }

                if ($ddp_css_diana == 'diana-no-sweat-v2-blurbs') {
                    wp_enqueue_style('ddp-diana-no-sweat-v2-blurbs', plugins_url('build/diana/css/diana-no-sweat-v2-blurbs.css', __FILE__));
                }

                if ($ddp_css_diana == 'diana-norma-jean-content') {
                    wp_enqueue_style('ddp-diana-norma-jean-content', plugins_url('build/diana/css/diana-norma-jean-content.css', __FILE__));
                }

                if ($ddp_css_diana == 'diana-you-change-content') {
                    wp_enqueue_style('ddp-diana-you-change-content', plugins_url('build/diana/css/diana-you-change-content.css', __FILE__));
                }

                if ($ddp_css_diana == 'diana-woodwork-header') {
                    wp_enqueue_style('ddp-diana-woodwork-header', plugins_url('build/diana/css/diana-woodwork-header.css', __FILE__));
                }

                if ($ddp_css_diana == 'diana-boxey-v2-content') {
                    wp_enqueue_style('ddp-diana-boxey-2-content', plugins_url('build/diana/css/diana-boxey-v2-content.css', __FILE__));
                }

                if ($ddp_css_diana == 'diana-cling-to-testimonial') {
                    wp_enqueue_style('ddp-diana-cling-to-testimonial', plugins_url('build/diana/css/diana-cling-to-testimonial.css', __FILE__));
                }

                if ($ddp_css_diana == 'diana-known-you-content') {
                    wp_enqueue_style('ddp-diana-know-you-content', plugins_url('build/diana/css/diana-known-you-content.css', __FILE__));
                }

                if ($ddp_css_diana == 'diana-seems-numbers') {
                    wp_enqueue_style('ddp-diana-seems-numbers', plugins_url('build/diana/css/diana-seems-numbers.css', __FILE__));
                }

                if ($ddp_css_diana == 'diana-set-in-call-to-action') {
                    wp_enqueue_style('ddp-diana-set-in-call-to-action', plugins_url('build/diana/css/diana-set-in-call-to-action.css', __FILE__));
                }

                if ($ddp_css_diana == 'diana-treadmill-content') {
                    wp_enqueue_style('ddp-diana-treadmill-content', plugins_url('build/diana/css/diana-treadmill-content.css', __FILE__));
                }

                if ($ddp_css_diana == 'diana-your-brain-call-to-action') {
                    wp_enqueue_style('ddp-diana-your-brain-call-to-action', plugins_url('build/diana/css/diana-your-brain-call-to-action.css', __FILE__));
                }

                if ($ddp_css_diana == 'diana-your-life-content') {
                    wp_enqueue_style('ddp-diana-your-life-content', plugins_url('build/diana/css/diana-your-life-content.css', __FILE__));
                }

                if ($ddp_css_diana == 'diana-your-name-content') {
                    wp_enqueue_style('ddp-diana-your-name-content', plugins_url('build/diana/css/diana-your-name-content.css', __FILE__));
                }

                if ($ddp_css_diana == 'diana-content-in-the-wind') {
                    wp_enqueue_style('ddp-diana-content-in-the-wind', plugins_url('build/diana/css/diana-services-1/diana-content-in-the-wind.css', __FILE__));
                }

                if ($ddp_css_diana == 'diana-services-button') {
                    wp_enqueue_style('ddp-diana-services-button', plugins_url('build/diana/css/diana-services-1/diana-services-1.css', __FILE__));
                }

                if ($ddp_css_diana == 'diana-blurbs-candle') {
                    wp_enqueue_style('ddp-diana-blurbs-candle', plugins_url('build/diana/css/diana-services-1/diana-blurbs-candle.css', __FILE__));
                }

                if ($ddp_css_diana == 'diana-content-cling-to') {
                    wp_enqueue_style('ddp-diana-content-cling-to', plugins_url('build/diana/css/diana-services-1/diana-content-cling-to.css', __FILE__));
                }

                if ($ddp_css_diana == 'diana-content-set-in') {
                    wp_enqueue_style('ddp-diana-content-set-in', plugins_url('build/diana/css/diana-services-1/diana-content-set-in.css', __FILE__));
                }

                if ($ddp_css_diana == 'diana-content-always-know') {
                    wp_enqueue_style('ddp-diana-content-always-know', plugins_url('build/diana/css/diana-services-1/diana-content-always-know.css', __FILE__));
                }

                if ($ddp_css_diana == 'diana-cta-big-dream') {
                    wp_enqueue_style('ddp-diana-cta-big-dream', plugins_url('build/diana/css/diana-services-1/diana-cta-big-dream.css', __FILE__));
                }

                if ($ddp_css_diana == 'diana-header-ever-did') {
                    wp_enqueue_style('ddp-diana-header-ever-did', plugins_url('build/diana/css/diana-services-2/diana-header-ever-did.css', __FILE__));
                }

                if ($ddp_css_diana == 'diana-blurbs-your-legend') {
                    wp_enqueue_style('ddp-diana-blurbs-your-legend', plugins_url('build/diana/css/diana-services-2/diana-blurbs-your-legend.css', __FILE__));
                }

                if ($ddp_css_diana == 'diana-content-who-sees') {
                    wp_enqueue_style('ddp-diana-conetnt-who-sees', plugins_url('build/diana/css/diana-services-2/diana-content-who-sees.css', __FILE__));
                }

                if ($ddp_css_diana == 'diana-blurbs-just-our') {
                    wp_enqueue_style('ddp-diana-blurbs-just-our', plugins_url('build/diana/css/diana-services-2/diana-blurbs-just-our.css', __FILE__));
                }

                if ($ddp_css_diana == 'diana-blurbs-goodbye') {
                    wp_enqueue_style('ddp-diana-blurbs-goodbye', plugins_url('build/diana/css/diana-services-2/diana-blurbs-goodbye.css', __FILE__));
                }

                if ($ddp_css_diana == 'diana-testimonial-just-a-kid') {
                    wp_enqueue_style('ddp-diana-testimonial-just-a-kid', plugins_url('build/diana/css/diana-services-2/diana-testimonial-just-a-kid.css', __FILE__));
                }



                // menus

                if ($ddp_css_diana == 'diana_menu_1') {
                    wp_enqueue_style('ddp-diana-menu1-css', plugins_url('build/diana/css/diana-menu1-styles.css', __FILE__));
                }
                if ($ddp_css_diana == 'diana_menu_2') {
                    wp_enqueue_style('ddp-diana-menu2-css', plugins_url('build/diana/css/diana-menu2-styles.css', __FILE__));
                }
                if ($ddp_css_diana == 'diana_menu_3') {
                    wp_enqueue_style('ddp-diana-menu3-css', plugins_url('build/diana/css/diana-menu3-styles.css', __FILE__));
                }
                if ($ddp_css_diana == 'diana_menu_4') {
                    wp_enqueue_style('ddp-diana-menu4-css', plugins_url('build/diana/css/diana-nav-menu-arch.css', __FILE__));
                }
                if ($ddp_css_diana == 'diana_menu_5') {
                    wp_enqueue_style('ddp-diana-menu5-css', plugins_url('build/diana/css/diana-nav-menu-first.css', __FILE__));
                }
                if ($ddp_css_diana == 'diana_menu_6') {
                    wp_enqueue_style('ddp-diana-menu6-css', plugins_url('build/diana/css/diana-nav-menu-champion.css', __FILE__));
                }
                if ($ddp_css_diana == 'diana_menu_7') {
                    wp_enqueue_style('ddp-diana-menu7-css', plugins_url('build/diana/css/diana-nav-menu-front.css', __FILE__));
                }
                if ($ddp_css_diana == 'diana_menu_8') {
                    wp_enqueue_style('ddp-diana-menu8-css', plugins_url('build/diana/css/diana-nav-menu-leading.css', __FILE__));
                }
                if ($ddp_css_diana == 'diana_menu_9') {
                    wp_enqueue_style('ddp-diana-menu9-css', plugins_url('build/diana/css/diana-nav-menu-main.css', __FILE__));
                }
                if ($ddp_css_diana == 'diana_menu_10') {
                    wp_enqueue_style('ddp-diana-menu10-css', plugins_url('build/diana/css/diana-nav-menu-pioneer.css', __FILE__));
                }
                if ($ddp_css_diana == 'diana_menu_11') {
                    wp_enqueue_style('ddp-diana-menu11-css', plugins_url('build/diana/css/diana-nav-menu-premier.css', __FILE__));
                }
                if ($ddp_css_diana == 'diana_menu_12') {
                    wp_enqueue_style('ddp-diana-menu12-css', plugins_url('build/diana/css/diana-nav-menu-prime.css', __FILE__));
                }
                if ($ddp_css_diana == 'diana_menu_13') {
                    wp_enqueue_style('ddp-diana-menu13-css', plugins_url('build/diana/css/diana-nav-menu-principal.css', __FILE__));
                }
                if ($ddp_css_diana == 'diana_menu_14') {
                    wp_enqueue_style('ddp-diana-menu14-css', plugins_url('build/diana/css/diana-nav-menu-stellar.css', __FILE__));
                }
            }
            // Freddie

            foreach ((array) get_post_meta($post->ID, 'ddp-css-freddie') as $ddp_css_freddie) {
                if ($ddp_css_freddie == 'freddie-transitions') {
                    wp_enqueue_style('ddp-freddie-transitions', plugins_url('build/freddie/css/freddie-transitions.css', __FILE__));
                }

                // menu templates
                if ($ddp_css_freddie == 'freddie-menu-attac-dragon') {
                    wp_enqueue_style('ddp-freddie-menu-attac-dragon', plugins_url('build/freddie/css/freddie-menu-dragon-attack.css', __FILE__));
                }
                if ($ddp_css_freddie == 'freddie-menu-prize') {
                    wp_enqueue_style('ddp-freddie-menu-prize', plugins_url('build/freddie/css/freddie-menu-prize-menu.css', __FILE__));
                }

                if ($ddp_css_freddie == 'freddie-menu-earth') {
                    wp_enqueue_style('ddp-freddie-menu-earth', plugins_url('build/freddie/css/freddie-menu-earth.css', __FILE__));
                }

                if ($ddp_css_freddie == 'freddie-menu-funny-love') {
                    wp_enqueue_style('ddp-freddie-menu-funny-love', plugins_url('build/freddie/css/freddie-menu-funny-how-love.css', __FILE__));
                }

                if ($ddp_css_freddie == 'freddie-menu-hang-on-in-there') {
                    wp_enqueue_style('ddp-freddie-menu-hang-on-in-there', plugins_url('build/freddie/css/freddie-menu-hang-on-in-there.css', __FILE__));
                }

                if ($ddp_css_freddie == 'freddie-menu-lover-boy') {
                    wp_enqueue_style('ddp-freddie-menu-lover-boy', plugins_url('build/freddie/css/freddie-menu-lover-boy.css', __FILE__));
                }

                if ($ddp_css_freddie == 'freddie-menu-hijack-my-heart') {
                    wp_enqueue_script('ddp-freddie-menu-hijack-my-heart-socials', plugins_url('build/freddie/js/socials-freddie.js', __FILE__));
                    wp_enqueue_style('ddp-freddie-menu-hijack-my-heart', plugins_url('build/freddie/css/freddie-hijack-my-heart.css', __FILE__));
                }

                // usual modules
                if ($ddp_css_freddie == 'freddie-headers' || $ddp_css_freddie == 'freddie-header-not-dead') {
                    wp_enqueue_style('ddp-freddie-headers', plugins_url('build/freddie/css/freddie-headers.css', __FILE__));
                }
                if ($ddp_css_freddie == 'freddie-blurbs') {
                    wp_enqueue_style('ddp-freddie-blurbs', plugins_url('build/freddie/css/freddie-blurbs.css', __FILE__));
                }
                if ($ddp_css_freddie == 'freddie-contents') {
                    wp_enqueue_style('ddp-freddie-contents', plugins_url('build/freddie/css/freddie-contents.css', __FILE__));
                }
                if ($ddp_css_freddie == 'freddie-footers') {
                    wp_enqueue_style('ddp-freddie-footers', plugins_url('build/freddie/css/freddie-footers.css', __FILE__));
                }
                if ($ddp_css_freddie == 'freddie-accordions') {
                    wp_enqueue_style('ddp-freddie-accordions', plugins_url('build/freddie/css/freddie-accordions.css', __FILE__));
                }
                if ($ddp_css_freddie == 'freddie-blogs') {
                    wp_enqueue_style('ddp-freddie-blogs', plugins_url('build/freddie/css/freddie-blogs.css', __FILE__));
                }
                if ($ddp_css_freddie == 'freddie-persons') {
                    wp_enqueue_style('ddp-freddie-persons', plugins_url('build/freddie/css/freddie-persons.css', __FILE__));
                }
                if ($ddp_css_freddie == 'freddie-pricing-tables') {
                    wp_enqueue_style('ddp-freddie-pricing-tables', plugins_url('build/freddie/css/freddie-pricing-tables.css', __FILE__));
                }
                if ($ddp_css_freddie == 'freddie-sliders') {
                    wp_enqueue_style('ddp-freddie-sliders', plugins_url('build/freddie/css/freddie-sliders.css', __FILE__));
                }
                if ($ddp_css_freddie == 'freddie-testimonials') {
                    wp_enqueue_style('ddp-freddie-testimonial', plugins_url('build/freddie/css/freddie-testimonials.css', __FILE__));
                }
                if ($ddp_css_freddie == 'freddie-more-info') {
                    wp_enqueue_style('ddp-freddie-more-info', plugins_url('build/freddie/css/freddie-more-info.css', __FILE__));
                }
                if ($ddp_css_freddie == 'freddie-album') {
                    wp_enqueue_style('ddp-freddie-album', plugins_url('build/freddie/css/freddie-album.css', __FILE__));
                }
                if ($ddp_css_freddie == 'freddie-song-slider') {
                    wp_enqueue_style('ddp-freddie-song-slider', plugins_url('build/freddie/css/freddie-song-slider.css', __FILE__));
                }
                if ($ddp_css_freddie == 'freddie-music') {
                    wp_enqueue_style('ddp-freddie-music', plugins_url('build/freddie/css/freddie-music.css', __FILE__));
                }
                if ($ddp_css_freddie == 'freddie-cta') {
                    wp_enqueue_style('ddp-freddie-cta', plugins_url('build/freddie/css/freddie-cta.css', __FILE__));
                }
                if ($ddp_css_freddie == 'freddie-process-circle') {
                    wp_enqueue_style('ddp-freddie-process-circle', plugins_url('build/freddie/css/freddie-process-circle.css', __FILE__));
                }
                if ($ddp_css_freddie == 'freddie-sidewalk-header') {
                    wp_enqueue_style('ddp-freddie-sidewalk-header', plugins_url('build/freddie/css/freddie-sidewalk-header.css', __FILE__));
                }
                if ($ddp_css_freddie == 'freddie-song-for-lennon-content') {
                    wp_enqueue_style('ddp-freddie-song-for-lennon-content', plugins_url('build/freddie/css/freddie-song-for-lennon-content.css', __FILE__));
                }
                if ($ddp_css_freddie == 'freddie-stealin-video-content') {
                    wp_enqueue_style('ddp-freddie-stealin-video-content', plugins_url('build/freddie/css/freddie-stealin-video-content.css', __FILE__));
                }
                if ($ddp_css_freddie == 'freddie-sweet-lady-slider') {
                    wp_enqueue_style('ddp-freddie-sweet-lady-slider', plugins_url('build/freddie/css/freddie-sweet-lady-slider.css', __FILE__));
                }
                if ($ddp_css_freddie == 'freddie-portfolio') {
                    wp_enqueue_style('ddp-freddie-portfolio', plugins_url('build/freddie/css/freddie-event.css', __FILE__));
                }
                if ($ddp_css_freddie == 'freddie-film-studio-header') {
                    wp_enqueue_style('ddp-freddie-film-studio-header', plugins_url('build/freddie/css/freddie-film-studio-header.css', __FILE__));
                }
                if ($ddp_css_freddie == 'freddie-bicycle-blurbs') {
                    wp_enqueue_style('ddp-freddie-bicycle-blurbs', plugins_url('build/freddie/css/freddie-bicycle-blurbs.css', __FILE__));
                }
                if ($ddp_css_freddie == 'freddie-our-films-content') {
                    wp_enqueue_style('ddp-freddie-our-films-content', plugins_url('build/freddie/css/freddie-our-films-content.css', __FILE__));
                }
                if ($ddp_css_freddie == 'freddie-race-content') {
                    wp_enqueue_style('ddp-freddie-race-content', plugins_url('build/freddie/css/freddie-race-content.css', __FILE__));
                }
                if ($ddp_css_freddie == 'freddie-film-studio-hitman-music-module') {
                    wp_enqueue_style('ddp-freddie-film-studio-hitman-music-module', plugins_url('build/freddie/css/freddie-film-studio-hitman_music_module.css', __FILE__));
                }
                if ($ddp_css_freddie == 'freddie-nevermore-person-module') {
                    wp_enqueue_style('ddp-freddie-nevermore-person-module', plugins_url('build/freddie/css/freddie-nevermore_person_module.css', __FILE__));
                }

                if ($ddp_css_freddie == 'freddie-my-heart-header') {
                    wp_enqueue_style('ddp-frreddie-my-heart-header', plugins_url('build/freddie/css/freddie-my-heart-header.css', __FILE__));
                }

                if ($ddp_css_freddie == 'freddie-blown-over-blurbs') {
                    wp_enqueue_style('ddp-freddie-blown-over-blurbs', plugins_url('build/freddie/css/freddie-blown-over-blurbs.css', __FILE__));
                }

                if ($ddp_css_freddie == 'freddie-by-the-way-content') {
                    wp_enqueue_style('ddp-freddie-by-the-way-content', plugins_url('build/freddie/css/freddie-by-the-way-content.css', __FILE__));
                }

                if ($ddp_css_freddie == 'freddie-desert-me-faq') {
                    wp_enqueue_style('ddp-freddie-desert-me-faq', plugins_url('build/freddie/css/freddie-desert-me-faq.css', __FILE__));
                }

                if ($ddp_css_freddie == 'freddie-other-day-testimonial') {
                    wp_enqueue_style('ddp-freddie-other-day-testimonial', plugins_url('build/freddie/css/freddie-other-day-testimonial.css', __FILE__));
                }

                if ($ddp_css_freddie == 'freddie-going-to-look-optin') {
                    wp_enqueue_style('ddp-freddie-going-to-look-optin', plugins_url('build/freddie/css/freddie-going-to-look-optin.css', __FILE__));
                }

                if ($ddp_css_freddie == 'freddie-be-better-footer') {
                    wp_enqueue_style('ddp-freddie-be-better-footer', plugins_url('build/freddie/css/freddie-be-better-footer.css', __FILE__));
                }

                if ($ddp_css_freddie == 'freddie-modern-times-blog') {
                    wp_enqueue_style('ddp-freddie-modern-times-blog', plugins_url('build/freddie/css/freddie-modern-times-blog.css', __FILE__));
                }

                if ($ddp_css_freddie == 'freddie-old-times-blog') {
                    wp_enqueue_style('ddp-freddie-old-times-blog', plugins_url('build/freddie/css/freddie-old-times-blog.css', __FILE__));
                }

                if ($ddp_css_freddie == 'freddie-let-me-header') {
                    wp_enqueue_style('ddp-freddie-let-me-header', plugins_url('build/freddie/css/freddie-let-me-header.css', __FILE__));
                }

                if ($ddp_css_freddie == 'freddie-open-windows-products') {
                    wp_enqueue_style('ddp-freddie-open-windows-products', plugins_url('build/freddie/css/freddie-open-windows-products.css', __FILE__));
                }

                if ($ddp_css_freddie == 'freddie-ga-ga-content') {
                    wp_enqueue_style('ddp-freddie-ga-ga-content', plugins_url('build/freddie/css/freddie-ga-ga-content.css', __FILE__));
                }

                if ($ddp_css_freddie == 'freddie-party-footer') {
                    wp_enqueue_style('ddp-freddie-party-footer', plugins_url('build/freddie/css/freddie-party-footer.css', __FILE__));
                }

                if ($ddp_css_freddie == 'freddie-pop-product') {
                    wp_enqueue_style('ddp-freddie-pop-product', plugins_url('build/freddie/css/freddie-pop-product.css', __FILE__));
                }

                if ($ddp_css_freddie == 'freddie-product-details-webdesign-package') {
                    wp_enqueue_style('ddp-freddie-product-details-webdesign-package', plugins_url('build/freddie/css/freddie-product-details-webdesign-package.css', __FILE__));
                }

                if ($ddp_css_freddie == 'freddie-cuff-me-archive') {
                    wp_enqueue_style('ddp-freddie-cuff-me-archive', plugins_url('build/freddie/css/freddie-cuff-me-archive.css', __FILE__));
                }

                if ($ddp_css_freddie == 'freddie-really-does-archive') {
                    wp_enqueue_style('ddp-freddie-really-does-archive', plugins_url('build/freddie/css/freddie-really-does-archive.css', __FILE__));
                }

                if ($ddp_css_freddie == 'freddie-misfire-search-results') {
                    wp_enqueue_style('ddp-freddie-misfire-search-results', plugins_url('build/freddie/css/freddie-misfire-search-results.css', __FILE__));
                }

                if ($ddp_css_freddie == 'freddie-baby-does-search-results') {
                    wp_enqueue_style('ddp-freddie-baby-does-search-results', plugins_url('build/freddie/css/freddie-baby-does-search-results.css', __FILE__));
                }

                if ($ddp_css_freddie == 'freddie-that-glitter-blog-post') {
                    wp_enqueue_style('ddp-freddie-that-glitter-blog-post', plugins_url('build/freddie/css/freddie-that-glitter-blog-post.css', __FILE__));
                }

                if ($ddp_css_freddie == 'freddie-thunderbolt-product') {
                    wp_enqueue_style('ddp-freddie-thunderbolt-product', plugins_url('build/freddie/css/freddie-thunderbolt-product.css', __FILE__));
                }

                if ($ddp_css_freddie == 'freddie-happy-man-testimonial') {
                    wp_enqueue_style('ddp-freddie-happy-man-testimonial', plugins_url('build/freddie/css/freddie-happy-man-tastimonial.css', __FILE__));
                }

                if ($ddp_css_freddie == 'freddie-we-will-rock-you-header') {
                    wp_enqueue_style('ddp-freddie-we-will-rock-you-header', plugins_url('build/freddie/css/freddie-we-will-rock-you-header.css', __FILE__));
                }

                if ($ddp_css_freddie == 'freddie-live-forever-content') {
                    wp_enqueue_style('ddp-freddie-live-forever-content', plugins_url('build/freddie/css/freddie-live-forever-content.css', __FILE__));
                }

                if ($ddp_css_freddie == 'freddie-best-friend-blurbs') {
                    wp_enqueue_style('ddp-freddie-best-friend-blurbs', plugins_url('build/freddie/css/freddie-best-friend-blurbs.css', __FILE__));
                }

                if ($ddp_css_freddie == 'freddie-dont-care-content') {
                    wp_enqueue_style('ddp-freddie-dont-care-content', plugins_url('build/freddie/css/freddie-dont-care-content.css', __FILE__));
                }

                if ($ddp_css_freddie == 'freddie-nevermore-person-module-about') {
                    wp_enqueue_style('ddp-freddie-nevermore-person-module-about', plugins_url('build/freddie/css/freddie_about_page_nevermore_person_module.css', __FILE__));
                }

                if ($ddp_css_freddie == 'freddie-winters-tale-footer') {
                    wp_enqueue_style('ddp-freddie-winters-tale-footer', plugins_url('build/freddie/css/freddie-winters-tale-footer.css', __FILE__));
                }

                if ($ddp_css_freddie == 'freddie-about-page-2') {
                    wp_enqueue_style('ddp-freddie-about-page-2', plugins_url('build/freddie/css/freddie-about2.css', __FILE__));
                }

                if ($ddp_css_freddie == 'freddie-crueladeville-slider') {
                    wp_enqueue_style('ddp-freddie-crueladeville-slider', plugins_url('build/freddie/css/freddie-crueladeville-slider.css', __FILE__));
                }

                if ($ddp_css_freddie == 'freddie-pleasure-chest-content') {
                    wp_enqueue_style('ddp-freddie-pleasure-chest-content', plugins_url('build/freddie/css/freddie-pleasure-chest-content.css', __FILE__));
                }

                if ($ddp_css_freddie == 'freddie-pull-you-testimonial') {
                    wp_enqueue_style('ddp-freddie-pull-you-testimonial', plugins_url('build/freddie/css/freddie-pull-you-testimonial.css', __FILE__));
                }

                if ($ddp_css_freddie == 'freddie-some-good-blurbs') {
                    wp_enqueue_style('ddp-freddie-some-good-blurbs', plugins_url('build/freddie/css/freddie-some-good-blurbs.css', __FILE__));
                }

                if ($ddp_css_freddie == 'freddie-about-page-3') {
                    wp_enqueue_style('ddp-freddie-about-page-3', plugins_url('build/freddie/css/freddie-about3.css', __FILE__));
                }

                if ($ddp_css_freddie == 'freddie-sell-you-testimonial') {
                    wp_enqueue_style('ddp-freddie-sell-you-testimonial', plugins_url('build/freddie/css/freddie-sell-you-testimonial.css', __FILE__));
                }

                if ($ddp_css_freddie == 'freddie-nothing-but-content') {
                    wp_enqueue_style('ddp-freddie-nothing-but-content', plugins_url('build/freddie/css/freddie-nothing-but-content.css', __FILE__));
                }

                if ($ddp_css_freddie == 'freddie-about-page-5') {
                    wp_enqueue_style('ddp-freddie-about-page-5', plugins_url('build/freddie/css/freddie-about5.css,', __FILE__));
                }

                if ($ddp_css_freddie == 'freddie-attraction-timeline') {
                    wp_enqueue_style('ddp-freddie-attraction-timeline', plugins_url('build/freddie/css/freddie-attraction-timeline.css', __FILE__));
                }

                if ($ddp_css_freddie == 'freddie-gonna-rock-footer') {
                    wp_enqueue_style('ddp-freddie-gonna-rock-footer', plugins_url('build/freddie/css/freddie-gonna-rock-footer.css', __FILE__));
                }

                if ($ddp_css_freddie == 'freddie-some-action-content') {
                    wp_enqueue_style('ddp-freddie-some-action-content', plugins_url('build/freddie/css/freddie-some-action-content.css', __FILE__));
                }

                if ($ddp_css_freddie == 'freddie-tonight-content') {
                    wp_enqueue_style('ddp-freddie-tonight-content', plugins_url('build/freddie/css/freddie-tonight-content.css', __FILE__));
                }

                if ($ddp_css_freddie == 'freddie-black-lips-content') {
                    wp_enqueue_style('ddp-freddie-black-lips-content', plugins_url('build/freddie/css/freddie-black-lips-content.css', __FILE__));
                }

                if ($ddp_css_freddie == 'freddie-youre-hot-contact-form') {
                    wp_enqueue_style('ddp-freddie-youre-hot-contact-form', plugins_url('build/freddie/css/freddie-youre-hot-contact-form.css', __FILE__));
                }

                if ($ddp_css_freddie == 'freddie-gonna-look-footer') {
                    wp_enqueue_style('ddp-freddie-gonna-look-footer', plugins_url('build/freddie/css/freddie-gonna-look-footer.css', __FILE__));
                }

                if ($ddp_css_freddie == 'freddie-step-on-testimonial') {
                    wp_enqueue_style('ddp-freddie-step-on-testimonial', plugins_url('build/freddie/css/freddie-step-on-testimonial.css', __FILE__));
                }

                if ($ddp_css_freddie == 'freddie-my-life-testimonial') {
                    wp_enqueue_style('ddp-freddie-my-life-testimonial', plugins_url('build/freddie/css/freddie-my-life-testimonial.css', __FILE__));
                }

                if ($ddp_css_freddie == 'freddie-needs-you-header') {
                    wp_enqueue_style('ddp-freddie-needs-you-header', plugins_url('build/freddie/css/freddie-needs-you-header.css', __FILE__));
                }

                if ($ddp_css_freddie == 'freddie-put-out-products') {
                    wp_enqueue_style('ddp-freddie-put-out-products', plugins_url('build/freddie/css/freddie-put-out-products.css', __FILE__));
                }

                if ($ddp_css_freddie == 'freddie-drummer-footer') {
                    wp_enqueue_style('ddp-freddie-drummer-footer', plugins_url('build/freddie/css/freddie-drummer-footer.css', __FILE__));
                }

                if ($ddp_css_freddie == 'freddie-galileo-header') {
                    wp_enqueue_style('ddp-freddie-galileo-header', plugins_url('build/freddie/css/freddie-galileo-header.css', __FILE__));
                }

                if ($ddp_css_freddie == 'freddie-really-matters-product-detail') {
                    wp_enqueue_style('ddp-freddie-really-matters-product-detail', plugins_url('build/freddie/css/freddie-really-matters-product-detail.css', __FILE__));
                }

                if ($ddp_css_freddie == 'freddie-my-time-recent-products') {
                    wp_enqueue_style('ddp-freddie-my-time-recent-products', plugins_url('build/freddie/css/freddie-my-time-recent-products.css', __FILE__));
                }

                if ($ddp_css_freddie == 'freddie-drummer-footer-white') {
                    wp_enqueue_style('ddp-freddie-drummer-footer-white', plugins_url('build/freddie/css/freddie-drummer-footer-white.css', __FILE__));
                }

                if ($ddp_css_freddie == 'freddie-hanging-gardens-pricing-tables') {
                    wp_enqueue_script('ddp-freddie-hanging-gardens-pricing-tables', plugins_url('build/freddie/js/freddiePricingTablesHangingGardens.js', __FILE__));
                    wp_enqueue_style('ddp-freddie-hanging-gardens-pricing-tables', plugins_url('build/freddie/css/freddie-pricing-tables-hanging-gardens.css', __FILE__));
                }

                if ($ddp_css_freddie == 'freddie-sahara-desert-pricing-tables') {
                    wp_enqueue_script('ddp-freddie-sahara-desert-pricing-tables', plugins_url('build/freddie/js/freddiePricingTablesSaharaDesert.js', __FILE__));
                    wp_enqueue_style('ddp-freddie-sahara-desert-pricing-tables', plugins_url('build/freddie/css/freddie-pricing-tables-sahara-desert.css', __FILE__));
                }

                if ($ddp_css_freddie == 'freddie-world-go-pricing-tables') {
                    wp_enqueue_script('ddp-freddie-world-go-pricing-tables', plugins_url('build/freddie/js/freddiePricingTablesWorldGo.js', __FILE__));
                    wp_enqueue_style('ddp-freddie-world-go-pricing-tables', plugins_url('build/freddie/css/freddie-pricing-tables-world-go.css', __FILE__));
                }

                if ($ddp_css_freddie == 'freddie-one-thing-pricing-tables') {
                    wp_enqueue_script('ddp-freddie-one-thing-pricing-tables', plugins_url('build/freddie/js/freddiePricingTablesOneThing.js', __FILE__));
                    wp_enqueue_style('ddp-freddie-one-thing-pricing-tables', plugins_url('build/freddie/css/freddie-pricing-tables-one-thing.css', __FILE__));
                }

                if ($ddp_css_freddie == 'freddie-creations-pricing-tables') {
                    wp_enqueue_style('ddp-freddie-creations-pricing-tables', plugins_url('build/freddie/css/freddie-pricing-tables-creations.css', __FILE__));
                }

                if ($ddp_css_freddie == 'freddie-on-earth-pricing-tables') {
                    wp_enqueue_style('ddp-freddie-on-earth-pricing-tables', plugins_url('build/freddie/css/freddie-on-earth-pricing-tables.css', __FILE__));
                }


                // features (featured  blurbs)

                if ($ddp_css_freddie == 'freddie-calling-me-blurb') {
                    wp_enqueue_style('ddp-freddie-calling-me-blurb', plugins_url('build/freddie/css/freddie-features/freddie-calling-me-blurb.css', __FILE__));
                }

                if ($ddp_css_freddie == 'freddie-entertain-you-blurb') {
                    wp_enqueue_style('ddp-freddie-entertain-you-blurb', plugins_url('build/freddie/css/freddie-features/freddie-entertain-you-blurb.css', __FILE__));
                }

                if ($ddp_css_freddie == 'freddie-get-better-blurb') {
                    wp_enqueue_style('ddp-freddie_get_better_blurb', plugins_url('build/freddie/css/freddie-features/freddie-get-better-blurb.css', __FILE__));
                }

                if ($ddp_css_freddie == 'freddie-i-have-blurb') {
                    wp_enqueue_style('ddp-freddie_i_have_blurb', plugins_url('build/freddie/css/freddie-features/freddie-i-have-blurb.css', __FILE__));
                }

                if ($ddp_css_freddie == 'freddie-main-thing-blurb') {
                    wp_enqueue_style('ddp-freddie-main-thing-blurb', plugins_url('build/freddie/css/freddie-features/freddie-main-thing-blurb.css', __FILE__));
                }

                if ($ddp_css_freddie == 'freddie-my-shoes-blurb') {
                    wp_enqueue_style('ddp-freddie-my-shoes-blurb', plugins_url('build/freddie/css/freddie-features/freddie-my-shoes-blurb.css', __FILE__));
                }

                if ($ddp_css_freddie == 'freddie-no-blame-blurb') {
                    wp_enqueue_style('ddp-freddie-no-blame-blurb', plugins_url('build/freddie/css/freddie-features/freddie-no-blame-blurb.css', __FILE__));
                }

                if ($ddp_css_freddie == 'freddie-on-my-way-blurb') {
                    wp_enqueue_style('ddp-freddie-on-my-way-blurb', plugins_url('build/freddie/css/freddie-features/freddie-on-my-way-blurb.css', __FILE__));
                }

                if ($ddp_css_freddie == 'freddie-only-way-blurb') {
                    wp_enqueue_style('ddp-freddie-only-way-blurb', plugins_url('build/freddie/css/freddie-features/freddie-only-way-blurb.css', __FILE__));
                }

                if ($ddp_css_freddie == 'freddie-satisfied-blurb') {
                    wp_enqueue_style('ddp-freddie-satisfied-blurb', plugins_url('build/freddie/css/freddie-features/freddie-satisfied-blurb.css', __FILE__));
                }

                if ($ddp_css_freddie == 'freddie-steps-nearer-blurb') {
                    wp_enqueue_style('ddp-freddie-steps-nearer-blurb', plugins_url('build/freddie/css/freddie-features/freddie-steps-nearer-blurb.css', __FILE__));
                }

                if ($ddp_css_freddie == 'freddie-the-line-blurb') {
                    wp_enqueue_style('ddp-freddie-the-line-blurb', plugins_url('build/freddie/css/freddie-features/freddie-the-line-blurb.css', __FILE__));
                }

                if ($ddp_css_freddie == 'freddie-your-time-blurb') {
                    wp_enqueue_style('ddp-freddie-your-time-blurb', plugins_url('build/freddie/css/freddie-features/freddie-your-time-blurb.css', __FILE__));
                }

                // gallery

                if ($ddp_css_freddie == 'freddie-gallery-a-hero') {
                    wp_enqueue_style('ddp-freddie-gallery-a-hero', plugins_url('build/freddie/css/freddie-gallery/freddie-gallery-a-hero.css', __FILE__));
                }

                if ($ddp_css_freddie == 'freddie-gallery-every-child') {
                    wp_enqueue_style('ddp-freddie-gallery-every-child', plugins_url('build/freddie/css/freddie-gallery/freddie-gallery-every-child.css', __FILE__));
                }

                if ($ddp_css_freddie == 'freddie-gallery-the-mighty') {
                    wp_enqueue_style('ddp-freddie-gallery-the-mighty', plugins_url('build/freddie/css/freddie-gallery/freddie-gallery-the-mighty.css', __FILE__));
                }

                if ($ddp_css_freddie == 'freddie-gallery-oooh-yeah') {
                    wp_enqueue_style('ddp-freddie-gallery-oooh-yeah', plugins_url('build/freddie/css/freddie-gallery/freddie-gallery-oooh-yeah.css', __FILE__));
                }

                if ($ddp_css_freddie == 'freddie-gallery-my-friend') {
                    wp_enqueue_style('ddp-freddie-gallery-my-friend', plugins_url('build/freddie/css/freddie-gallery/freddie-gallery-my-friend.css', __FILE__));
                }

                if ($ddp_css_freddie == 'freddie-gallery-every-one') {
                    wp_enqueue_style('ddp-freddie-gallery-every-one', plugins_url('build/freddie/css/freddie-gallery/freddie-gallery-every-one.css', __FILE__));
                }

                if ($ddp_css_freddie == 'freddie-gallery-be-somebody') {
                    wp_enqueue_style('ddp-freddie-gallery-be-somebody', plugins_url('build/freddie/css/freddie-gallery/freddie-gallery-be-somebody.css', __FILE__));
                }



                // buttons
                if ($ddp_css_freddie == 'freddie-button-jealousy') {
                    wp_enqueue_style('ddp-freddie-button-jealousy', plugins_url('build/freddie/css/freddie-buttons-jealousy.css', __FILE__));
                }
                if ($ddp_css_freddie == 'freddie-button-the-loser') {
                    wp_enqueue_style('ddp-freddie-button-the-loser', plugins_url('build/freddie/css/freddie-buttons-the-loser.css', __FILE__));
                }
                if ($ddp_css_freddie == 'freddie-button-lazing-on') {
                    wp_enqueue_style('ddp-freddie-button-lazing-on', plugins_url('build/freddie/css/freddie-buttons-lazing-on.css', __FILE__));
                }
                if ($ddp_css_freddie == 'freddie-button-liar') {
                    wp_enqueue_style('ddp-freddie-button-liar', plugins_url('build/freddie/css/freddie-buttons-liar.css', __FILE__));
                }
                if ($ddp_css_freddie == 'freddie-button-love-kills') {
                    wp_enqueue_style('ddp-freddie-button-love-kills', plugins_url('build/freddie/css/freddie-buttons-love-kills.css', __FILE__));
                }
                if ($ddp_css_freddie == 'freddie-button-misfire') {
                    wp_enqueue_style('ddp-freddie-button-misfire', plugins_url('build/freddie/css/freddie-buttons-misfire.css', __FILE__));
                }
                if ($ddp_css_freddie == 'freddie-button-been-saved') {
                    wp_enqueue_style('ddp-freddie-button-been-saved', plugins_url('build/freddie/css/freddie-buttons-been-saved.css', __FILE__));
                }
                if ($ddp_css_freddie == 'freddie-button-mother-love') {
                    wp_enqueue_style('ddp-freddie-button-mother-love', plugins_url('build/freddie/css/freddie-buttons-mother-love.css', __FILE__));
                }
                if ($ddp_css_freddie == 'freddie-button-ogre-battle') {
                    wp_enqueue_style('ddp-freddie-button-ogre-battle', plugins_url('build/freddie/css/freddie-buttons-ogre-battle.css', __FILE__));
                }
                if ($ddp_css_freddie == 'freddie-button-party') {
                    wp_enqueue_style('ddp-freddie-button-party', plugins_url('build/freddie/css/freddie-buttons-party.css', __FILE__));
                }
                if ($ddp_css_freddie == 'freddie-button-the-fire') {
                    wp_enqueue_style('ddp-freddie-button-the-fire', plugins_url('build/freddie/css/freddie-buttons-the-fire.css', __FILE__));
                }
                if ($ddp_css_freddie == 'freddie-button-wild-wind') {
                    wp_enqueue_style('ddp-freddie-button-wild-wind', plugins_url('build/freddie/css/freddie-buttons-wild-wind.css', __FILE__));
                }
                if ($ddp_css_freddie == 'freddie-button-seaside') {
                    wp_enqueue_style('ddp-freddie-button-seaside', plugins_url('build/freddie/css/freddie-buttons-seaside.css', __FILE__));
                }
                if ($ddp_css_freddie == 'freddie-button-rendezvous') {
                    wp_enqueue_style('ddp-freddie-button-rendezvous', plugins_url('build/freddie/css/freddie-buttons-rendezvous.css', __FILE__));
                }
                if ($ddp_css_freddie == 'freddie-button-some-day') {
                    wp_enqueue_style('ddp-freddie-button-some-day', plugins_url('build/freddie/css/freddie-buttons-some-day.css', __FILE__));
                }
                if ($ddp_css_freddie == 'freddie-button-one-day') {
                    wp_enqueue_style('ddp-freddie-button-one-day', plugins_url('build/freddie/css/freddie-buttons-one-day.css', __FILE__));
                }
                if ($ddp_css_freddie == 'freddie-button-soul-brother') {
                    wp_enqueue_style('ddp-freddie-button-soul-brother', plugins_url('build/freddie/css/freddie-buttons-soul-brother.css', __FILE__));
                }
                if ($ddp_css_freddie == 'freddie-button-step-on-me') {
                    wp_enqueue_style('ddp-freddie-button-step-on-me', plugins_url('build/freddie/css/freddie-buttons-step-on-me.css', __FILE__));
                }
                if ($ddp_css_freddie == 'freddie-button-tear-it-up') {
                    wp_enqueue_style('ddp-freddie-button-tear-it-up', plugins_url('build/freddie/css/freddie-buttons-tear-it-up.css', __FILE__));
                }
                if ($ddp_css_freddie == 'freddie-button-teo-torriate') {
                    wp_enqueue_style('ddp-freddie-button-teo-torriate', plugins_url('build/freddie/css/freddie-buttons-teo-torriate.css', __FILE__));
                }
                if ($ddp_css_freddie == 'freddie-button-fairy-feller') {
                    wp_enqueue_style('ddp-freddie-button-fairy-feller', plugins_url('build/freddie/css/freddie-buttons-fairy-feller.css', __FILE__));
                }
                if ($ddp_css_freddie == 'freddie-button-radio-ga-ga') {
                    wp_enqueue_style('ddp-freddie-button-radio-ga-ga', plugins_url('build/freddie/css/freddie-buttons-radio-ga-ga.css', __FILE__));
                }
                if ($ddp_css_freddie == 'freddie-button-under-pressure') {
                    wp_enqueue_style('ddp-freddie-button-under-pressure', plugins_url('build/freddie/css/freddie-buttons-under-pressure.css', __FILE__));
                }
                if ($ddp_css_freddie == 'freddie-button-you-andi') {
                    wp_enqueue_style('ddp-freddie-button-you-andi', plugins_url('build/freddie/css/freddie-buttons-you-andi.css', __FILE__));
                }
                if ($ddp_css_freddie == 'freddie-button-action-this-day') {
                    wp_enqueue_style('ddp-freddie-button-action-this-day', plugins_url('build/freddie/css/freddie-buttons-action-this-day.css', __FILE__));
                }
                if ($ddp_css_freddie == 'freddie-button-april-lady') {
                    wp_enqueue_style('ddp-freddie-button-april-lady', plugins_url('build/freddie/css/freddie-buttons-april-lady.css', __FILE__));
                }
                if ($ddp_css_freddie == 'freddie-button-bicycle-race') {
                    wp_enqueue_style('ddp-freddie-button-bicycle-race', plugins_url('build/freddie/css/freddie-buttons-bicycle-race.css', __FILE__));
                }
                if ($ddp_css_freddie == 'freddie-button-blag') {
                    wp_enqueue_style('ddp-freddie-button-blag', plugins_url('build/freddie/css/freddie-buttons-blag.css', __FILE__));
                }
                if ($ddp_css_freddie == 'freddie-button-bohemian') {
                    wp_enqueue_style('ddp-freddie-button-bohemian', plugins_url('build/freddie/css/freddie-buttons-bohemian.css', __FILE__));
                }
                if ($ddp_css_freddie == 'freddie-button-rhapsody') {
                    wp_enqueue_style('ddp-freddie-button-rhapsody', plugins_url('build/freddie/css/freddie-buttons-rhapsody.css', __FILE__));
                }
                if ($ddp_css_freddie == 'freddie-button-calling-all-girls') {
                    wp_enqueue_style('ddp-freddie-button-calling-all-girls', plugins_url('build/freddie/css/freddie-buttons-calling-all-girls.css', __FILE__));
                }
                if ($ddp_css_freddie == 'freddie-button-dancer') {
                    wp_enqueue_style('ddp-freddie-button-dancer', plugins_url('build/freddie/css/freddie-buttons-dancer.css', __FILE__));
                }
                if ($ddp_css_freddie == 'freddie-button-delilah') {
                    wp_enqueue_style('ddp-freddie-button-delilah', plugins_url('build/freddie/css/freddie-buttons-delilah.css', __FILE__));
                }
                if ($ddp_css_freddie == 'freddie-button-dont-stop-me') {
                    wp_enqueue_style('ddp-freddie-button-dont-stop-me', plugins_url('build/freddie/css/freddie-buttons-dont-stop-me.css', __FILE__));
                }
                if ($ddp_css_freddie == 'freddie-button-fat-bottomed') {
                    wp_enqueue_style('ddp-freddie-button-fat-bottomed', plugins_url('build/freddie/css/freddie-buttons-fat-bottomed.css', __FILE__));
                }
                if ($ddp_css_freddie == 'freddie-button-get-down') {
                    wp_enqueue_style('ddp-freddie-button-get-down', plugins_url('build/freddie/css/freddie-buttons-get-down.css', __FILE__));
                }
                if ($ddp_css_freddie == 'freddie-button-the-queen') {
                    wp_enqueue_style('ddp-freddie-button-the-queen', plugins_url('build/freddie/css/freddie-buttons-the-queen.css', __FILE__));
                }
                if ($ddp_css_freddie == 'freddie-button-good-old') {
                    wp_enqueue_style('ddp-freddie-button-good-old', plugins_url('build/freddie/css/freddie-buttons-good-old.css', __FILE__));
                }
                if ($ddp_css_freddie == 'freddie-button-headlong') {
                    wp_enqueue_style('ddp-freddie-button-headlong', plugins_url('build/freddie/css/freddie-buttons-headlong.css', __FILE__));
                }
                if ($ddp_css_freddie == 'freddie-button-break-free') {
                    wp_enqueue_style('ddp-freddie-button-break-free', plugins_url('build/freddie/css/freddie-buttons-break-free.css', __FILE__));
                }
                if ($ddp_css_freddie == 'freddie-button-beat-them') {
                    wp_enqueue_style('ddp-freddie-button-beat-them', plugins_url('build/freddie/css/freddie-buttons-beat-them.css', __FILE__));
                }
                if ($ddp_css_freddie == 'freddie-button-beautiful-day') {
                    wp_enqueue_style('ddp-freddie-button-beautiful-day', plugins_url('build/freddie/css/freddie-buttons-beautiful-day.css', __FILE__));
                }
                if ($ddp_css_freddie == 'freddie-button-killer-queen') {
                    wp_enqueue_style('ddp-freddie-button-killer-queen', plugins_url('build/freddie/css/freddie-buttons-killer-queen.css', __FILE__));
                }
                if ($ddp_css_freddie == 'freddie-button-life-is-real') {
                    wp_enqueue_style('ddp-freddie-button-life-is-real', plugins_url('build/freddie/css/freddie-buttons-life-is-real.css', __FILE__));
                }
                if ($ddp_css_freddie == 'freddie-button-love-of') {
                    wp_enqueue_style('ddp-freddie-button-love-of', plugins_url('build/freddie/css/freddie-buttons-love-of.css', __FILE__));
                }
                if ($ddp_css_freddie == 'freddie-button-made-in-heaven') {
                    wp_enqueue_style('ddp-freddie-button-made-in-heaven', plugins_url('build/freddie/css/freddie-buttons-made-in-heaven.css', __FILE__));
                }
                if ($ddp_css_freddie == 'freddie-button-melancholy-blues') {
                    wp_enqueue_style('ddp-freddie-button-melancholy-blues', plugins_url('build/freddie/css/freddie-buttons-melancholy-blues.css', __FILE__));
                }
                if ($ddp_css_freddie == 'freddie-button-no-violins') {
                    wp_enqueue_style('ddp-freddie-button-no-violins', plugins_url('build/freddie/css/freddie-buttons-no-violins.css', __FILE__));
                }
                if ($ddp_css_freddie == 'freddie-button-one-vision') {
                    wp_enqueue_style('ddp-freddie-button-one-vision', plugins_url('build/freddie/css/freddie-buttons-one-vision.css', __FILE__));
                }
                if ($ddp_css_freddie == 'freddie-button-play-the-game') {
                    wp_enqueue_style('ddp-freddie-button-play-the-game', plugins_url('build/freddie/css/freddie-buttons-play-the-game.css', __FILE__));
                }

                // Menus

                if ($ddp_css_freddie == 'freddie-menu-1') {
                    wp_enqueue_style('ddp-freddie-menu-prize', plugins_url('build/freddie/css/freddie-menu-prize-menu.css', __FILE__));
                }
                if ($ddp_css_freddie == 'freddie-menu-2') {
                    wp_enqueue_style('ddp-freddie-menu-dragon-attack', plugins_url('build/freddie/css/freddie-menu-dragon-attack.css', __FILE__));
                }
                if ($ddp_css_freddie == 'freddie-menu-3') {
                    wp_enqueue_style('ddp-freddie-menu-earth', plugins_url('build/freddie/css/freddie-menu-earth.css', __FILE__));
                }
                if ($ddp_css_freddie == 'freddie-menu-4') {
                    wp_enqueue_style('ddp-freddie-menu-funny-how-love', plugins_url('build/freddie/css/freddie-menu-funny-how-love.css', __FILE__));
                }
                if ($ddp_css_freddie == 'freddie-menu-5') {
                    wp_enqueue_style('ddp-freddie-menu-hang-on-in-there', plugins_url('build/freddie/css/freddie-menu-hang-on-in-there.css', __FILE__));
                }
                if ($ddp_css_freddie == 'freddie-menu-6') {
                    wp_enqueue_style('ddp-freddie-menu-lover-boy', plugins_url('build/freddie/css/freddie-menu-lover-boy.css', __FILE__));
                }
                if ($ddp_css_freddie == 'freddie-menu-7') {
                    wp_enqueue_style('ddp-freddie-hijack-my-heart', plugins_url('build/freddie/css/freddie-hijack-my-heart.css', __FILE__));
                }

                // Blogs

                if ($ddp_css_freddie == 'freddie-blog-post-to-son') {
                    wp_enqueue_style('ddp-freddie-blog-post-to-son', plugins_url('build/freddie/css/freddie-blog-post-to-son.css', __FILE__));
                }

                if ($ddp_css_freddie == 'freddie-blog-post-drowse') {
                    wp_enqueue_style('ddp-freddie-blog-post-drowse', plugins_url('build/freddie/css/freddie-blog-post-drowse.css', __FILE__));
                }

                if ($ddp_css_freddie == 'freddie-blog-post-all-girls') {
                    wp_enqueue_style('freddie-blog-post-all-girls', plugins_url('build/freddie/css/freddie-blog-post-all-girls.css', __FILE__));
                }

                if ($ddp_css_freddie == 'freddie-make-love-blog-post') {
                    wp_enqueue_style('ddp-freddie-make-love-blog-post', plugins_url('build/freddie/css/freddie-make-love-blog-post.css', __FILE__));
                }

                if ($ddp_css_freddie == 'freddie-blog-post-mother-love') {
                    wp_enqueue_style('ddp-freddie-blog-post-mother-love', plugins_url('build/freddie/css/freddie-blog-post-mother-love.css', __FILE__));
                }

                if ($ddp_css_freddie == 'freddie-blog-post-human-body') {
                    wp_enqueue_style('ddp-freddie-blog-post-human-body', plugins_url('build/freddie/css/freddie-blog-post-human-body.css', __FILE__));
                }



                if ($ddp_css_freddie == 'freddie-funster-testimonial') {
                    wp_enqueue_style('ddp-freddie-funster-testimonial', plugins_url('build/freddie/css/freddie-funster-testimonial.css', __FILE__));
                }

                if ($ddp_css_freddie == 'freddie-my-body-testimonial') {
                    wp_enqueue_style('ddp-freddie-my-body-testimonial', plugins_url('build/freddie/css/freddie-my-body-testimonial.css', __FILE__));
                }

                if ($ddp_css_freddie == 'freddie-pretty-lights-tabs') {
                    wp_enqueue_style('ddp-freddie-pretty-lights-tabs', plugins_url('build/freddie/css/freddie-pretty-lights-tabs.css', __FILE__));
                }

                // TB Navigation Menus

                if ($ddp_css_freddie == 'freddie-without-counting-header') {
                    wp_enqueue_style('ddp-freddie-without-counting-header', plugins_url('build/freddie/css/tb-navigation-menus/without-counting-header.css', __FILE__));
                }

                if ($ddp_css_freddie == 'freddie-bali-header') {
                    wp_enqueue_style('ddp-freddie-bali-header', plugins_url('build/freddie/css/tb-navigation-menus/bali-header.css', __FILE__));
                }

                if ($ddp_css_freddie == 'freddie-hungry-header') {
                    wp_enqueue_style('ddp-freddie-hungry-header', plugins_url('build/freddie/css/tb-navigation-menus/hungry-header.css', __FILE__));
                }

                if ($ddp_css_freddie == 'freddie-breaking-header') {
                    wp_enqueue_style('ddp-freddie-breaking-header', plugins_url('build/freddie/css/tb-navigation-menus/breaking-header.css', __FILE__));
                }

                if ($ddp_css_freddie == 'freddie-mona-lis-header') {
                    wp_enqueue_style('ddp-freddie-mona-lis-header', plugins_url('build/freddie/css/tb-navigation-menus/mona-lisa-header.css', __FILE__));
                }

                if ($ddp_css_freddie == 'freddie-private-affair-header') {
                    wp_enqueue_style('ddp-freddie-private-affair-header', plugins_url('build/freddie/css/tb-navigation-menus/private-affair.css', __FILE__));
                }

                if ($ddp_css_freddie == 'freddie-pleading-header') {
                    wp_enqueue_style('ddp-freddie-pleadingg-header', plugins_url('build/freddie/css/tb-navigation-menus/pleading-header.css', __FILE__));
                }

                if ($ddp_css_freddie == 'freddie-headline-header') {
                    wp_enqueue_style('ddp-freddie-headline-header', plugins_url('build/freddie/css/tb-navigation-menus/headline-header.css', __FILE__));
                }

                if ($ddp_css_freddie == 'freddie-twisted-header') {
                    wp_enqueue_style('ddp-freddie-twisted-header', plugins_url('build/freddie/css/tb-navigation-menus/twisted-header.css', __FILE__));
                }

                if ($ddp_css_freddie == 'freddie-get-started-header') {
                    wp_enqueue_style('ddp-freddie-get-started-header', plugins_url('build/freddie/css/tb-navigation-menus/get-started-header.css', __FILE__));
                }

                if ($ddp_css_freddie == 'freddie-jamming-header') {
                    wp_enqueue_style('ddp-freddie-jamming-header', plugins_url('build/freddie/css/tb-navigation-menus/jamming-header.css', __FILE__));
                }

                if ($ddp_css_freddie == 'freddie-day-next-header') {
                    wp_enqueue_style('ddp-freddie-day-next-header', plugins_url('build/freddie/css/tb-navigation-menus/day-next-header.css', __FILE__));
                }

                if ($ddp_css_freddie == 'freddie-come-back-header') {
                    wp_enqueue_style('ddp-freddie-come-back-header', plugins_url('build/freddie/css/tb-navigation-menus/come-back-header.css', __FILE__));
                }

                if ($ddp_css_freddie == 'freddie-got-all-header') {
                    wp_enqueue_style('ddp-freddie-got-all-header', plugins_url('build/freddie/css/tb-navigation-menus/got-all-header.css', __FILE__));
                }

                if ($ddp_css_freddie == 'freddie-i-know-header') {
                    wp_enqueue_style('ddp-freddie-i-know-header', plugins_url('build/freddie/css/tb-navigation-menus/i-know-header.css', __FILE__));
                }

                if ($ddp_css_freddie == 'freddie-just-like-header') {
                    wp_enqueue_style('ddp-freddie-just-like-header', plugins_url('build/freddie/css/tb-navigation-menus/freddie-just-like-header.css', __FILE__));
                }

                if ($ddp_css_freddie == 'freddie-he-pulled-header') {
                    wp_enqueue_style('ddp-freddie-he-pulled-header', plugins_url('build/freddie/css/tb-navigation-menus/freddie-he-pulled-header.css', __FILE__));
                }

                if ($ddp_css_freddie == 'freddie-no-one-header') {
                    wp_enqueue_style('ddp-freddie-no-one-header', plugins_url('build/freddie/css/tb-navigation-menus/freddie-no-one-header.css', __FILE__));
                }

                if ($ddp_css_freddie == 'freddie-on-earth-pricing-tables') {
                    wp_enqueue_style('ddp-freddie-on-earth-pricing-tables', plugins_url('build/freddie/css/freddie-on-earth-pricing-tables.css', __FILE__));
                }

                if ($ddp_css_freddie == 'freddie-person-module-my-band') {
                    wp_enqueue_script('ddp-freddie-person-module-my-band', plugins_url('build/freddie/js/freddiePersonMyBand.js', __FILE__));
                    wp_enqueue_style('ddp-freddie-person-module-my-band ', plugins_url('build/freddie/css/freddie-person-module-my-band.css', __FILE__));
                }

                if ($ddp_css_freddie == 'freddie-thank-you-person-module') {
                    wp_enqueue_script('ddp-freddie-thank-you-person-module', plugins_url('build/freddie/js/freddiePersonThankYou.js', __FILE__));
                    wp_enqueue_style('ddp-freddie-thank-you-person-module ', plugins_url('build/freddie/css/freddie-person-module-thank-you.css', __FILE__));
                }

                if ($ddp_css_freddie == 'freddie-greatest-treasure-person-module') {
                    wp_enqueue_style('ddp-freddie-greatest-treasure-person-module', plugins_url('build/freddie/css/freddie-person-module-greatest-treasure.css', __FILE__));
                }

                if ($ddp_css_freddie == 'freddie-rocking-world-person-module') {
                    wp_enqueue_script('ddp-freddie-rocking-world-person-module', plugins_url('build/freddie/js/freddiePersonRockingWorlde.js', __FILE__));
                    wp_enqueue_style('ddp-freddie-rocking-world-person-module', plugins_url('build/freddie/css/freddie-person-module-rocking-world.css', __FILE__));
                }

                if ($ddp_css_freddie == 'freddie-ride-em-person-module') {
                    wp_enqueue_script('ddp-freddie-ride-em-person-module', plugins_url('build/freddie/js/freddiePersonRideEm.js', __FILE__));
                    wp_enqueue_style('ddp-freddie-ride-em-person-module', plugins_url('build/freddie/css/freddie-person-module-ride-em.css', __FILE__));
                }

                if ($ddp_css_freddie == 'freddie-my-pleasure-person-module') {
                    wp_enqueue_script('ddp-freddie-my-pleasure-person-module', plugins_url('build/freddie/js/freddiePersonMyPleasure.js', __FILE__));
                    wp_enqueue_style('ddp-freddie-my-pleasure-person-module', plugins_url('build/freddie/css/freddie-person-module-my-pleasure.css', __FILE__));
                }

                if ($ddp_css_freddie == 'freddie-you-got-person-module') {
                    wp_enqueue_script('ddp-freddie-you-got-person-module', plugins_url('build/freddie/js/freddiePersonYouGot.js', __FILE__));
                    wp_enqueue_style('ddp-freddie-you-got-person-module', plugins_url('build/freddie/css/freddie-person-module-you-got.css', __FILE__));
                }


                if ($ddp_css_freddie == 'freddie-world-go-person-module') {
                    wp_enqueue_style('ddp-freddie-world-go-person-module', plugins_url('build/freddie/css/freddie-person-module-world-go.css', __FILE__));
                }


                if ($ddp_css_freddie == 'freddie-bikes-person-module') {
                    wp_enqueue_style('ddp-freddie-bikes-person-module', plugins_url('build/freddie/css/freddie-person-module-bikes.css', __FILE__));
                }

                if ($ddp_css_freddie == 'freddie-singing-person-module') {
                    wp_enqueue_script('ddp-freddie-singing-person-module', plugins_url('build/freddie/js/freddiePersonSinging.js', __FILE__));
                    wp_enqueue_style('ddp-freddie-singing-person-module', plugins_url('build/freddie/css/freddie-person-module-singing.css', __FILE__));
                }

                if ($ddp_css_freddie == 'freddie-the-bones-person-module') {
                    wp_enqueue_script('ddp-freddie-the-bones-person-module', plugins_url('build/freddie/js/freddiePersonTheBones.js', __FILE__));
                    wp_enqueue_style('ddp-freddie-the-bones-person-module', plugins_url('build/freddie/css/freddie-person-module-the-bones.css', __FILE__));
                }

                if ($ddp_css_freddie == 'freddie-blue-eyed-person-module') {
                    wp_enqueue_script('ddp-freddie-blue-eyed-person-module', plugins_url('build/freddie/js/freddiePersonBlueEyed.js', __FILE__));
                    wp_enqueue_style('ddp-freddie-blue-eyed-person-module', plugins_url('build/freddie/css/freddie-person-module-blue-eyed.css', __FILE__));
                }

                if ($ddp_css_freddie == 'freddie-nanny-person-module') {
                    wp_enqueue_script('ddp-freddie-nanny-person-module', plugins_url('build/freddie/js/freddiePersonNanny.js', __FILE__));
                    wp_enqueue_style('ddp-freddie-nanny-person-module', plugins_url('build/freddie/css/freddie-person-module-nanny.css', __FILE__));
                }

                if ($ddp_css_freddie == 'freddie-red-fire-person-module') {
                    wp_enqueue_script('ddp-freddie-red-fire-person-module', plugins_url('build/freddie/js/freddiePersonRedFire.js', __FILE__));
                    wp_enqueue_style('ddp-freddie-red-fire-person-module', plugins_url('build/freddie/css/freddie-person-module-red-fire.css', __FILE__));
                }

                if ($ddp_css_freddie == 'freddie-every-time-person-module') {
                    wp_enqueue_script('ddp-freddie-every-time-person-module', plugins_url('build/freddie/js/freddiePersonEveryTime.js', __FILE__));
                    wp_enqueue_style('ddp-freddie-every-time-person-module', plugins_url('build/freddie/css/freddie-person-module-every-time.css', __FILE__));
                }

                if ($ddp_css_freddie == 'freddie-person-module-skinny-lad') {
                    wp_enqueue_script('ddp-freddie-person-module-skinny-lad', plugins_url('build/freddie/js/freddiePersonSkinnyLad.js', __FILE__));
                    wp_enqueue_style('ddp-freddie-person-module-skinny-lad', plugins_url('build/freddie/css/freddie-person-module-skinny-lad.css', __FILE__));
                }

                if ($ddp_css_freddie == 'freddie-header-las-palabras-de-amor') {
                    wp_enqueue_script('ddp-freddie-header-las-palabras-de-amor', plugins_url('build/freddie/js/freddie-home9/freddieHeaderLasPalabrasDeAmor.js', __FILE__));
                    wp_enqueue_style('ddp-freddie-header-las-palabras-de-amor', plugins_url('build/freddie/css/freddie-home9/freddie-header-las-palabras-de-amor.css', __FILE__));
                }

                if ($ddp_css_freddie == 'freddie-content-let-me-live') {
                    wp_enqueue_style('ddp-freddie-content-let-me-live', plugins_url('build/freddie/css/freddie-home9/freddie-content-let-me-live.css', __FILE__));
                }

                if ($ddp_css_freddie == 'freddie-content-long-away') {
                    wp_enqueue_style('ddp-freddie-content-long-away', plugins_url('build/freddie/css/freddie-home9/freddie-content-long-away.css', __FILE__));
                }

                if ($ddp_css_freddie == 'freddie-footer-black-queen') {
                    wp_enqueue_style('ddp-freddie-footer-black-queen', plugins_url('build/freddie/css/freddie-home9/freddie-footer-black-queen.css', __FILE__));
                }

                if ($ddp_css_freddie == 'freddie-testimonial-back-to-humans') {
                    wp_enqueue_script('ddp-freddie-testimonial-back-to-humans', plugins_url('build/freddie/js/freddie-home9/freddieTestimonialBackToHumans.js', __FILE__));
                    wp_enqueue_style('ddp-freddie-testimonial-back-to-humans', plugins_url('build/freddie/css/freddie-home9/freddie-testimonial-back-to-humans.css', __FILE__));
                }

                if ($ddp_css_freddie == 'freddie-tabs-more-of-that-jazz') {
                    wp_enqueue_script('ddp-freddie-tabs-more-of-that-jazz', plugins_url('build/freddie/js/freddie-home9/freddieTabsMoreOfThatJazz.js', __FILE__));
                    wp_enqueue_style('ddp-freddie-tabs-more-of-that-jazz', plugins_url('build/freddie/css/freddie-home9/freddie-tabs-more-of-that-jazz.css', __FILE__));
                }

                if ($ddp_css_freddie == 'freddie-header-going-slightly-mad') {
                    wp_enqueue_script('ddp-freddie-header-going-slightly-mad', plugins_url('build/freddie/js/freddie-home10/freddieHeaderGoingSlightlyMad.js', __FILE__));
                    wp_enqueue_style('ddp-freddie-header-going-slightly-mad', plugins_url('build/freddie/css/freddie-home10/freddie-header-going-slightly-mad.css', __FILE__));
                }

                if ($ddp_css_freddie == 'freddie-content-lap-of-the-gods') {
                    wp_enqueue_style('ddp-freddie-content-lap-of-the-gods', plugins_url('build/freddie/css/freddie-home10/freddie-content-lap-of-the-gods.css', __FILE__));
                }

                if ($ddp_css_freddie == 'freddie-content-everybody-happy') {
                    wp_enqueue_script('ddp-freddie-content-everybody-happy', plugins_url('build/freddie/js/freddie-home10/freddieContentEverybodyHappy.js', __FILE__));
                    wp_enqueue_style('ddp-freddie-content-everybody-happy', plugins_url('build/freddie/css/freddie-home10/freddie-content-everybody-happy.css', __FILE__));
                }

                if ($ddp_css_freddie == 'freddie-person-module-its-late') {
                    wp_enqueue_script('ddp-freddie-person-module-its-late', plugins_url('build/freddie/js/freddie-home10/freddiePersonModuleItsLate.js', __FILE__));
                    wp_enqueue_style('ddp-freddie-person-module-its-late', plugins_url('build/freddie/css/freddie-home10/freddie-person-module-its-late.css', __FILE__));
                }

                if ($ddp_css_freddie == 'freddie-footer-keep-yourself-alive') {
                    wp_enqueue_style('ddp-freddie-footer-keep-yourself-alive', plugins_url('build/freddie/css/freddie-home10/freddie-footer-keep-yourself-alive.css', __FILE__));
                }

                if ($ddp_css_freddie == 'freddie-author-1') {
                    wp_enqueue_style('ddp-freddie-author-1', plugins_url('build/freddie/css/freddie-author-worthwhile/freddie-author-worthwhile.css', __FILE__));
                }


                if ($ddp_css_freddie == 'freddie-products-featured-mama-oooh') {
                    wp_enqueue_style('ddp-freddie-products-featured-mama-oooh', plugins_url('build/freddie/css/freddie-woo/freddie-products-featured-mama-oooh.css', __FILE__));
                }

                if ($ddp_css_freddie == 'freddie-products-featured-ha-haa') {
                    wp_enqueue_style('ddp-freddie-products-featured-ha-haa', plugins_url('build/freddie/css/freddie-woo/freddie-products-featured-ha-haa.css', __FILE__));
                }

                if ($ddp_css_freddie == 'freddie-products-featured-this-rage') {
                    wp_enqueue_style('ddp-freddie-products-featured-this-rage', plugins_url('build/freddie/css/freddie-woo/freddie-products-featured-this-rage.css', __FILE__));
                }

                if ($ddp_css_freddie == 'freddie-products-featured-wooh') {
                    wp_enqueue_style('ddp-freddie-products-featured-wooh', plugins_url('build/freddie/css/freddie-woo/freddie-products-featured-wooh.css', __FILE__));
                }


                if ($ddp_css_freddie == 'freddie-product-time-tomorrow') {
                    wp_enqueue_style('ddp-freddie-product-time-tomorrow', plugins_url('build/freddie/css/freddie-woo/freddie-product-time-tomorrow.css', __FILE__));
                }

                if ($ddp_css_freddie == 'freddie-product-thrown-it-all-away') {
                    wp_enqueue_style('ddp-freddie-product-thrown-it-all-away', plugins_url('build/freddie/css/freddie-woo/freddie-product-thrown-it-all-away.css', __FILE__));
                }

                if ($ddp_css_freddie == 'freddie-product-gimme-some') {
                    wp_enqueue_style('ddp-freddie-product-gimme-some', plugins_url('build/freddie/css/freddie-woo/freddie-product-gimme-some.css', __FILE__));
                }
            } // Freddie end

            // mobile menus

            if (get_option('ddp_menu_template') === 'disabled') {
                if (get_option('ddp_mobile_menu_template') === 'mobile_menu_1') {
                    wp_enqueue_style('ddp-responsive-menu-1', plugins_url('build/responsive-menus/css/responsive-menu-1.css', __FILE__));
                }

                if (get_option('ddp_mobile_menu_template') === 'mobile_menu_2') {
                    wp_enqueue_style('ddp-responsive-menu-2', plugins_url('build/responsive-menus/css/responsive-menu-2.css', __FILE__));
                }

                if (get_option('ddp_mobile_menu_template') === 'mobile_menu_3') {
                    wp_enqueue_style('ddp-responsive-menu-3', plugins_url('build/responsive-menus/css/responsive-menu-3.css', __FILE__));
                }
            }

            // Tina

            foreach ((array) get_post_meta($post->ID, 'ddp-css-tina') as $ddp_css_tina) {
                if ($ddp_css_tina == 'tina-header-the-girl') {
                    wp_enqueue_style('ddp-tina-header-the-girl', plugins_url('build/tina/css/home1/tina-header-the-girl.css', __FILE__));
                }

                if ($ddp_css_tina == 'tina-blurbs-easy-babe') {
                    wp_enqueue_style('ddp-tina-blurbs-easy-babe', plugins_url('build/tina/css/home1/tina-blurbs-easy-babe.css', __FILE__));
                }

                if ($ddp_css_tina == 'tina-tabs-the-change') {
                    wp_enqueue_style('ddp-tina-tabs-the-change', plugins_url('build/tina/css/home1/tina-tabs-the-change.css', __FILE__));
                }

                if ($ddp_css_tina == 'tina-person-module-she-talks') {
                    wp_enqueue_style('ddp-tina-person-module-she-talks', plugins_url('build/tina/css/home1/tina-person-module-she-talks.css', __FILE__));
                }

                if ($ddp_css_tina == 'tina-content-down-to-me') {
                    wp_enqueue_style('ddp-tina-content-down-to-me', plugins_url('build/tina/css/home1/tina-content-down-to-me.css', __FILE__));
                }

                if ($ddp_css_tina == 'tina-blog-its-alright') {
                    wp_enqueue_style('ddp-tina-blog-its-alright', plugins_url('build/tina/css/home1/tina-blog-its-alright.css', __FILE__));
                }

                if ($ddp_css_tina == 'tina-testimonial-siamese') {
                    wp_enqueue_style('ddp-tina-testimonial-siamese', plugins_url('build/tina/css/home1/tina-testimonial-siamese.css', __FILE__));
                }

                if ($ddp_css_tina == 'tina-footer-the-change') {
                    wp_enqueue_style('ddp-tina-footer-the-change', plugins_url('build/tina/css/home1/tina-footer-the-change.css', __FILE__));
                }

                if ($ddp_css_tina == 'tina-header-private-dancer') {
                    wp_enqueue_style('ddp-tina-header-private-dancer', plugins_url('build/tina/css/home2/tina-header-private-dancer.css', __FILE__));
                }

                if ($ddp_css_tina == 'tina-content-these-places') {
                    wp_enqueue_style('ddp-tina-content-these-places', plugins_url('build/tina/css/home2/tina-content-these-places.css', __FILE__));
                }

                if ($ddp_css_tina == 'tina-content-their-faces') {
                    wp_enqueue_style('ddp-tina-content-their-faces', plugins_url('build/tina/css/home2/tina-content-their-faces.css', __FILE__));
                }

                if ($ddp_css_tina == 'tina-content-a-dancer') {
                    wp_enqueue_style('ddp-tina-content-a-dancer', plugins_url('build/tina/css/home2/tina-content-a-dancer.css', __FILE__));
                }

                if ($ddp_css_tina == 'tina-person-module-my-thumb') {
                    wp_enqueue_style('ddp-tina-person-module-my-thumb', plugins_url('build/tina/css/home2/tina-person-module-my-thumb.css', __FILE__));
                }

                if ($ddp_css_tina == 'tina-content-a-diamond') {
                    wp_enqueue_style('ddp-tina-content-a-diamond', plugins_url('build/tina/css/home2/tina-content-a-diamond.css', __FILE__));
                }

                if ($ddp_css_tina == 'tina-blog-all-day') {
                    wp_enqueue_style('ddp-tina-blog-all-day', plugins_url('build/tina/css/home2/tina-blog-all-day.css', __FILE__));
                }

                if ($ddp_css_tina == 'tina-footer-dont-walk') {
                    wp_enqueue_style('ddp-tina-footer-dont-walk', plugins_url('build/tina/css/home2/tina-footer-dont-walk.css', __FILE__));
                }

                if ($ddp_css_tina == 'tina-header-see-this') {
                    wp_enqueue_style('ddp-tina-header-see-this', plugins_url('build/tina/css/home3/tina-header-see-this.css', __FILE__));
                }

                if ($ddp_css_tina == 'tina-blurbs-smile-to') {
                    wp_enqueue_style('ddp-tina-blurbs-smile-to', plugins_url('build/tina/css/home3/tina-blurbs-smile-to.css', __FILE__));
                }

                if ($ddp_css_tina == 'tina-blurbs-a-fire') {
                    wp_enqueue_style('ddp-tina-blurbs-a-fire', plugins_url('build/tina/css/home3/tina-blurbs-a-fire.css', __FILE__));
                }

                if ($ddp_css_tina == 'tina-blurbs-get-enough') {
                    wp_enqueue_style('ddp-tina-blurbs-get-enough', plugins_url('build/tina/css/home3/tina-blurbs-get-enough.css', __FILE__));
                }

                if ($ddp_css_tina == 'tina-numbers-goes-around') {
                    wp_enqueue_style('ddp-tina-numbers-goes-around', plugins_url('build/tina/css/home3/tina-numbers-goes-around.css', __FILE__));
                }

                if ($ddp_css_tina == 'tina-persons-flowing') {
                    wp_enqueue_style('ddp-tina-persons-flowing', plugins_url('build/tina/css/home3/tina-persons-flowing.css', __FILE__));
                }

                if ($ddp_css_tina == 'tina-call-to-action-seek') {
                    wp_enqueue_style('ddp-tina-call-to-action-seek', plugins_url('build/tina/css/home3/tina-call-to-action-seek.css', __FILE__));
                }

                if ($ddp_css_tina == 'tina-blog-the-flame') {
                    wp_enqueue_style('ddp-tina-blog-the-flame', plugins_url('build/tina/css/home3/tina-blog-the-flame.css', __FILE__));
                }

                if ($ddp_css_tina == 'tina-footer-still-play') {
                    wp_enqueue_style('ddp-tina-footer-still-play', plugins_url('build/tina/css/home3/tina-footer-still-play.css', __FILE__));
                }

                if ($ddp_css_tina == 'tina-header-he-belongs') {
                    wp_enqueue_style('ddp-tina-header-he-belongs', plugins_url('build/tina/css/home4/tina-header-he-belongs.css', __FILE__));
                }

                if ($ddp_css_tina == 'tina-blurbs-never-been') {
                    wp_enqueue_style('ddp-tina-blurbs-never-been', plugins_url('build/tina/css/home4/tina-blurbs-never-been.css', __FILE__));
                }

                if ($ddp_css_tina == 'tina-blurbs-buy-into') {
                    wp_enqueue_style('ddp-tina-blurbs-buy-into', plugins_url('build/tina/css/home4/tina-blurbs-buy-into.css', __FILE__));
                }

                if ($ddp_css_tina == 'tina-content-the-flame') {
                    wp_enqueue_style('ddp-tina-content-the-flame', plugins_url('build/tina/css/home4/tina-content-the-flame.css', __FILE__));
                }

                if ($ddp_css_tina == 'tina-blurbs-i-wanna-be') {
                    wp_enqueue_style('ddp-tina-blurbs-i-wanna-be', plugins_url('build/tina/css/home4/tina-blurbs-i-wanna-be.css', __FILE__));
                }

                if ($ddp_css_tina == 'tina-blurbs-you-lead-me') {
                    wp_enqueue_style('ddp-tina-blurbs-you-lead-me', plugins_url('build/tina/css/home4/tina-blurbs-you-lead-me.css', __FILE__));
                }

                if ($ddp_css_tina == 'tina-testimonial-who-did') {
                    wp_enqueue_style('ddp-tina-testimonial-who-did', plugins_url('build/tina/css/home4/tina-testimonial-who-did.css', __FILE__));
                }

                if ($ddp_css_tina == 'tina-time-footer-to') {
                    wp_enqueue_style('ddp-tina-time-footer-to', plugins_url('build/tina/css/home4/tina-time-footer-to.css', __FILE__));
                }

                // optins

                if ($ddp_css_tina == 'tina-optin-other-lives') {
                    wp_enqueue_style('ddp-tina-optin-other-lives', plugins_url('build/tina/css/email-optin/tina-optin-other-lives.css', __FILE__));
                }

                if ($ddp_css_tina == 'tina-optin-a-kind') {
                    wp_enqueue_style('ddp-tina-optin-a-kind', plugins_url('build/tina/css/email-optin/tina-optin-a-kind.css', __FILE__));
                }

                if ($ddp_css_tina == 'tina-optin-your-kiss') {
                    wp_enqueue_style('ddp-tina-optin-your-kiss', plugins_url('build/tina/css/email-optin/tina-optin-your-kiss.css', __FILE__));
                }

                if ($ddp_css_tina == 'tina-optin-right-here') {
                    wp_enqueue_style('ddp-tina-optin-right-here', plugins_url('build/tina/css/email-optin/tina-optin-right-here.css', __FILE__));
                }

                if ($ddp_css_tina == 'tina-optin-be-right') {
                    wp_enqueue_style('ddp-tina-optin-be-right', plugins_url('build/tina/css/email-optin/tina-optin-be-right.css', __FILE__));
                }

                if ($ddp_css_tina == 'tina-optin-gonna-be') {
                    wp_enqueue_style('ddp-tina-optin-gonna-be', plugins_url('build/tina/css/email-optin/tina-optin-gonna-be.css', __FILE__));
                }

                if ($ddp_css_tina == 'tina-optin-you-need') {
                    wp_enqueue_style('ddp-tina-optin-you-need', plugins_url('build/tina/css/email-optin/tina-optin-you-need.css', __FILE__));
                }

                if ($ddp_css_tina == 'tina-optin-so-familiar') {
                    wp_enqueue_style('ddp-tina-optin-so-familiar', plugins_url('build/tina/css/email-optin/tina-optin-so-familiar.css', __FILE__));
                }

                // Content Pages

                if ($ddp_css_tina == 'tina-content-page-1') {
                    wp_enqueue_style('ddp-tina-content-page-1', plugins_url('build/tina/css/content-page1/tina-contentpage1.css', __FILE__));
                }

                if ($ddp_css_tina == 'tina-content-page-2') {
                    wp_enqueue_style('ddp-tina-content-page-2', plugins_url('build/tina/css/content-page2/tina-content-page2.css', __FILE__));
                }

                if ($ddp_css_tina == 'tina-content-page-3') {
                    wp_enqueue_style('ddp-tina-content-page-3', plugins_url('build/tina/css/content-page3/tina-content-page3.css', __FILE__));
                }

                if ($ddp_css_tina == 'tina-content-page-4') {
                    wp_enqueue_style('ddp-tina-content-page-4', plugins_url('build/tina/css/content-page4/tina-content-page4.css', __FILE__));
                }

                if ($ddp_css_tina == 'tina-content-page-5') {
                    wp_enqueue_style('ddp-tina-content-page-5', plugins_url('build/tina/css/content-page5/tina-content-page5.css', __FILE__));
                }

                if ($ddp_css_tina == 'tina-content-page-6') {
                    wp_enqueue_style('ddp-tina-content-page-6', plugins_url('build/tina/css/content-page6/tina-content-page6.css', __FILE__));
                }

                if ($ddp_css_tina == 'tina-content-page-7') {
                    wp_enqueue_style('ddp-tina-content-page-7', plugins_url('build/tina/css/content-page7/tina-content-page7.css', __FILE__));
                }

                if ($ddp_css_tina == 'tina-content-page-8') {
                    wp_enqueue_style('ddp-tina-content-page-8', plugins_url('build/tina/css/content-page8/tina-content-page8.css', __FILE__));
                }

                if ($ddp_css_tina == 'tina-content-page-9') {
                    wp_enqueue_style('ddp-tina-content-page-9', plugins_url('build/tina/css/content-page9/tina-content-page9.css', __FILE__));
                }

                if ($ddp_css_tina == 'tina-content-page-10') {
                    wp_enqueue_style('ddp-tina-content-page-10', plugins_url('build/tina/css/content-page10/tina-content-page10.css', __FILE__));
                }

                if ($ddp_css_tina == 'tina-content-page-11') {
                    wp_enqueue_style('ddp-tina-content-page-11', plugins_url('build/tina/css/content-page11/tina-content-page11.css', __FILE__));
                }

                // Sidebars

                if ($ddp_css_tina == 'tina-my-lover-sidebar') {
                    wp_enqueue_style('ddp-tina-my-lover-sidebar', plugins_url('build/tina/css/content-page1/tina-my-lover-sidebar.css', __FILE__));
                }

                if ($ddp_css_tina == 'tina-my-end-sidebar') {
                    wp_enqueue_style('ddp-tina-my-end-sidebar', plugins_url('build/tina/css/content-page2/tina-sidebar-my-end.css', __FILE__));
                }

                if ($ddp_css_tina == 'tina-my-beggining-sidebar') {
                    wp_enqueue_style('ddp-tina-my-beggining-sidebar', plugins_url('build/tina/css/content-page3/tina-sidebar-my-beggining.css', __FILE__));
                }

                if ($ddp_css_tina == 'tina-feel-like-sidebar') {
                    wp_enqueue_style('ddp-tina-feel-like-sidebar', plugins_url('build/tina/css/content-page4/tina-sidebar-feel-like.css', __FILE__));
                }

                if ($ddp_css_tina == 'tina-this-time-sidebar') {
                    wp_enqueue_style('ddp-tina-this-time-sidebar', plugins_url('build/tina/css/content-page5/tina-sidebar-this-time.css', __FILE__));
                }

                if ($ddp_css_tina == 'tina-be-right-sidebar') {
                    wp_enqueue_style('ddp-tina-be-right-sidebar', plugins_url('build/tina/css/content-page6/tina-sidebar-be-right.css', __FILE__));
                }

                if ($ddp_css_tina == 'tina-waiting-baby-sidebar') {
                    wp_enqueue_style('ddp-tina-waiting-baby-sidebar', plugins_url('build/tina/css/content-page7/tina-sidebar-waiting-baby.css', __FILE__));
                }

                if ($ddp_css_tina == 'tina-will-be-sidebar') {
                    wp_enqueue_style('ddp-tina-twill-be-sidebar', plugins_url('build/tina/css/content-page8/tina-sidebar-will-be.css', __FILE__));
                }

                if ($ddp_css_tina == 'tina-this-life-sidebar') {
                    wp_enqueue_style('ddp-tina-this-life-sidebar', plugins_url('build/tina/css/content-page9/tina-sidebar-this-life.css', __FILE__));
                }

                if ($ddp_css_tina == 'tina-contentpage10-sidebar') {
                    wp_enqueue_style('ddp-tina-contentpage10-sidebar', plugins_url('build/tina/css/content-page10/tina-sidebar-contentpage10.css', __FILE__));
                }

                if ($ddp_css_tina == 'tina-the-sun-sidebar') {
                    wp_enqueue_style('ddp-tina-the-sun-sidebar', plugins_url('build/tina/css/content-page11/tina-sidebar-the-sun.css', __FILE__));
                }

                if ($ddp_css_tina == 'tina-sidewalk-contact-page') {
                    wp_enqueue_style('ddp-tina-sidewalk-contact-page', plugins_url('build/tina/css/contact-page1/tina-sidewalk-contact.css', __FILE__));
                }

                if ($ddp_css_tina == 'tina-here-waiting-blurbs') {
                    wp_enqueue_style('ddp-tina-here-waiting-blurbs', plugins_url('build/tina/css/services-page1/tina-blurbs-here-waiting.css', __FILE__));
                }

                if ($ddp_css_tina == 'tina-go-down-content') {
                    wp_enqueue_style('ddp-tina-go-down-content', plugins_url('build/tina/css/services-page1/tina-content-go-down.css', __FILE__));
                }

                if ($ddp_css_tina == 'tina-my-friend-content') {
                    wp_enqueue_style('ddp-tina-my-friend-content', plugins_url('build/tina/css/services-page1/tina-content-my-friend.css', __FILE__));
                    wp_enqueue_style('ddp-tina-services-page1', plugins_url('build/tina/css/services-page1/tina-services-page1.css', __FILE__));
                }

                if ($ddp_css_tina == 'tina-good-times-blurbs') {
                    wp_enqueue_style('ddp-tina-good-times-blurbs', plugins_url('build/tina/css/services-page2/tina-blurbs-good-times.css', __FILE__));
                }

                if ($ddp_css_tina == 'tina-way-down-blurbs') {
                    wp_enqueue_style('ddp-tina-way-down-blurbs', plugins_url('build/tina/css/services-page2/tina-blurbs-way-down.css', __FILE__));
                }

                if ($ddp_css_tina == 'tina-wanna-content') {
                    wp_enqueue_style('ddp-tina-wanna-content', plugins_url('build/tina/css/services-page2/tina-content-wanna.css', __FILE__));
                }

                if ($ddp_css_tina == 'tina-every-inch-testimonial') {
                    wp_enqueue_style('ddp-tina-every-inch-testimonial', plugins_url('build/tina/css/services-page2/tina-testimonial-every-inch.css', __FILE__));
                }

                if ($ddp_css_tina == 'tina-come-on-blurbs') {
                    wp_enqueue_style('ddp-tina-come-on-blurbs', plugins_url('build/tina/css/careers/tina-blurbs-come-on.css', __FILE__));
                }

                if ($ddp_css_tina == 'tina-finest-girl-content') {
                    wp_enqueue_style('ddp-tina-finest-girl-content', plugins_url('build/tina/css/careers/tina-content-finest-girl.css', __FILE__));
                }

                if ($ddp_css_tina == 'tina-know-girl-content') {
                    wp_enqueue_style('ddp-tina-know-girl-content', plugins_url('build/tina/css/careers/tina-content-know-girl.css', __FILE__));
                }

                if ($ddp_css_tina == 'tina-perks-content') {
                    wp_enqueue_style('ddp-tina-perks-content', plugins_url('build/tina/css/careers/tina-content-perks.css', __FILE__));
                }

                if ($ddp_css_tina == 'tina-your-decisions-header') {
                    wp_enqueue_style('ddp-tina-header-your-decisions', plugins_url('build/tina/css/home5/tina-header-your-decisions.css', __FILE__));
                }

                if ($ddp_css_tina == 'tina-sometimes-content') {
                    wp_enqueue_style('ddp-tina-sometimes-content', plugins_url('build/tina/css/home5/tina-content-sometimes.css', __FILE__));
                }

                if ($ddp_css_tina == 'tina-and-that-tabs') {
                    wp_enqueue_style('ddp-tina-and-that-tabs', plugins_url('build/tina/css/home5/tina-tabs-and-that.css', __FILE__));
                }

                if ($ddp_css_tina == 'tina-stronger-content') {
                    wp_enqueue_style('ddp-tina-stronger-content', plugins_url('build/tina/css/home5/tina-content-stronger.css', __FILE__));
                }

                if ($ddp_css_tina == 'tina-you-again-tabs') {
                    wp_enqueue_style('ddp-tina-you-again-tabs', plugins_url('build/tina/css/home5/tina-tabs-you-again.css', __FILE__));
                }

                if ($ddp_css_tina == 'tina-about-all-blog') {
                    wp_enqueue_style('ddp-tina-about-all-blog', plugins_url('build/tina/css/home5/tina-blog-about-all.css', __FILE__));
                }

                if ($ddp_css_tina == 'tina-I-can-footer') {
                    wp_enqueue_style('ddp-tina-I-can-footer', plugins_url('build/tina/css/home5/tina-footer-I-can.css', __FILE__));
                }

                if ($ddp_css_tina == 'tina-backdoor-man-content') {
                    wp_enqueue_style('ddp-tina-backdoor-man-content', plugins_url('build/tina/css/about1/tina-content-backdoor-man.css', __FILE__));
                }

                if ($ddp_css_tina == 'tina-coolin-content') {
                    wp_enqueue_style('ddp-tina-coolin-content', plugins_url('build/tina/css/about1/tina-content-coolin.css', __FILE__));
                }

                if ($ddp_css_tina == 'tina-schoolin-content') {
                    wp_enqueue_style('ddp-tina-schoolin-content', plugins_url('build/tina/css/about1/tina-content-schoolin.css', __FILE__));
                }

                if ($ddp_css_tina == 'tina-every-inch-blurbs') {
                    wp_enqueue_style('ddp-tina-every-inch-blurbs', plugins_url('build/tina/css/about1/tina-blurbs-every-inch.css', __FILE__));
                }

                if ($ddp_css_tina == 'tina-shake-content') {
                    wp_enqueue_style('ddp-tina-shake-content', plugins_url('build/tina/css/about1/tina-content-shake.css', __FILE__));
                }

                if ($ddp_css_tina == 'tina-girl-testimonial') {
                    wp_enqueue_style('ddp-tina-girl-testimonial', plugins_url('build/tina/css/about1/tina-testimonial-girl.css', __FILE__));
                }

                // Accordions

                if ($ddp_css_tina == 'tina-accordion-anybody') {
                    wp_enqueue_style('ddp-tina-accordion-anybody', plugins_url('build/tina/css/accordions/tina-accordion-anybody.css', __FILE__));
                }

                if ($ddp_css_tina == 'tina-accordion-charge-of') {
                    wp_enqueue_style('ddp-tina-accordion-charge-of', plugins_url('build/tina/css/accordions/tina-accordion-charge-of.css', __FILE__));
                }

                if ($ddp_css_tina == 'tina-accordion-common-sense') {
                    wp_enqueue_style('ddp-tina-accordion-common-sense', plugins_url('build/tina/css/accordions/tina-accordion-common-sense.css', __FILE__));
                }

                if ($ddp_css_tina == 'tina-accordion-da-dap') {
                    wp_enqueue_style('ddp-tina-accordion-da-dap', plugins_url('build/tina/css/accordions/tina-accordion-da-dap.css', __FILE__));
                }

                if ($ddp_css_tina == 'tina-accordion-i-grew') {
                    wp_enqueue_style('ddp-tina-accordion-i-grew', plugins_url('build/tina/css/accordions/tina-accordion-i-grew.css', __FILE__));
                }

                if ($ddp_css_tina == 'tina-accordion-key-to') {
                    wp_enqueue_style('ddp-tina-accordion-key-to', plugins_url('build/tina/css/accordions/tina-accordion-key-to.css', __FILE__));
                }

                if ($ddp_css_tina == 'tina-accordion-looked-down') {
                    wp_enqueue_style('ddp-tina-accordion-looked-down', plugins_url('build/tina/css/accordions/tina-accordion-looked-down.css', __FILE__));
                }

                if ($ddp_css_tina == 'tina-accordion-my-heart') {
                    wp_enqueue_style('ddp-tina-accordion-my-heart', plugins_url('build/tina/css/accordions/tina-accordion-my-heart.css', __FILE__));
                }

                if ($ddp_css_tina == 'tina-accordion-my-home') {
                    wp_enqueue_style('ddp-tina-accordion-my-home', plugins_url('build/tina/css/accordions/tina-accordion-my-home.css', __FILE__));
                }

                if ($ddp_css_tina == 'tina-accordion-the-start') {
                    wp_enqueue_style('ddp-tina-accordion-the-start', plugins_url('build/tina/css/accordions/tina-accordion-the-start.css', __FILE__));
                }

                if ($ddp_css_tina == 'tina-accordion-you-alone') {
                    wp_enqueue_style('ddp-tina-accordion-you-alone', plugins_url('build/tina/css/accordions/tina-accordion-you-alone.css', __FILE__));
                }

                // accordions end

                if ($ddp_css_tina == 'tina-thinking-about-header') {
                    wp_enqueue_style('ddp-tina-thinking-about-header', plugins_url('build/tina/css/home6/tina-header-thinking-about.css', __FILE__));
                }

                if ($ddp_css_tina == 'tina-the-past-content') {
                    wp_enqueue_style('ddp-tina-the-past-content', plugins_url('build/tina/css/home6/tina-content-the-past.css,', __FILE__));
                }

                if ($ddp_css_tina == 'tina-my-shoulder-blurbs') {
                    wp_enqueue_style('ddp-tina-my-shoulder-blurbs', plugins_url('build/tina/css/home6/tina-blurbs-my-shoulder.css', __FILE__));
                }

                if ($ddp_css_tina == 'tina-lifetime-blurbs') {
                    wp_enqueue_style('ddp-tina-lifetime-blurbs', plugins_url('build/tina/css/home6/tina-blurbs-lifetime.css', __FILE__));
                }

                if ($ddp_css_tina == 'tina-all-behind-blurbs') {
                    wp_enqueue_style('ddp-tina-all-behind-blurbs', plugins_url('build/tina/css/home6/tina-blurbs-all-behind.css', __FILE__));
                }

                if ($ddp_css_tina == 'tina-all-behind-button') {
                    wp_enqueue_style('ddp-tina-all-behind-button', plugins_url('build/tina/css/tina-all-behind-button.css', __FILE__));
                }

                if ($ddp_css_tina == 'tina-orgotten-moments-blurbs') {
                    wp_enqueue_style('ddp-tina-forgotten-moments-blurbs', plugins_url('build/tina/css/home6/tina-blurbs-orgotten-moments.css', __FILE__));
                }

                if ($ddp_css_tina == 'tina-other-lives-blurbs') {
                    wp_enqueue_style('ddp-tina-other-lives-blurbs', plugins_url('build/tina/css/home6/tina-blurbs-other-lives.css', __FILE__));
                }

                if ($ddp_css_tina == 'tina-my-lover-blog') {
                    wp_enqueue_style('ddp-tina-my-lover-blog', plugins_url('build/tina/css/home6/tina-blog-my-lover.css', __FILE__));
                }

                if ($ddp_css_tina == 'tina-I-breathe-footer') {
                    wp_enqueue_style('ddp-tina-I-breathe-footer', plugins_url('build/tina/css/home6/tina-footer-i-breathe.css', __FILE__));
                }

                if ($ddp_css_tina == 'tina-contact-form-talk-now') {
                    wp_enqueue_style('ddp-tina-contact-form-talk-now', plugins_url('build/tina/css/contact-page2/tina-contact-form-talk-now.css', __FILE__));
                }

                if ($ddp_css_tina == 'tina-content-second-try') {
                    wp_enqueue_style('ddp-tina-content-second-try', plugins_url('build/tina/css/contact-page3/tina-content-second-try.css', __FILE__));
                }

                if ($ddp_css_tina == 'tina-contact-3-page') {
                    wp_enqueue_style('ddp-tina-tina-contact-3-page', plugins_url('build/tina/css/contact-page3/tina-contact-3.css', __FILE__));
                }

                if ($ddp_css_tina == 'tina-blurbs-hear-my') {
                    wp_enqueue_style('ddp-tina-blurbs-hear-my', plugins_url('build/tina/css/services-page3/tina-blurbs-hear-my.css', __FILE__));
                }

                if ($ddp_css_tina == 'tina-content-eight-wheeler') {
                    wp_enqueue_style('ddp-tina-content-eight-wheeler', plugins_url('build/tina/css/services-page3/tina-content-eight-wheeler.css', __FILE__));
                }

                if ($ddp_css_tina == 'tina-cta-im-moving') {
                    wp_enqueue_style('ddp-tina-cta-im-moving', plugins_url('build/tina/css/services-page3/tina-cta-im-moving.css', __FILE__));
                }

                if ($ddp_css_tina == 'tina-testimonial-i-got') {
                    wp_enqueue_style('ddp-tina-testimonial-i-got', plugins_url('build/tina/css/services-page3/tina-testimonial-i-got.css', __FILE__));
                }

                if ($ddp_css_tina == 'tina-content-throttle') {
                    wp_enqueue_style('ddp-tina-content-throttle', plugins_url('build/tina/css/process-page1/tina-content-throttle.css', __FILE__));
                }

                if ($ddp_css_tina == 'tina-content-ease') {
                    wp_enqueue_style('ddp-tina-content-ease', plugins_url('build/tina/css/process-page1/tina-content-ease.css', __FILE__));
                }

                if ($ddp_css_tina == 'tina-testimonial-you-got') {
                    wp_enqueue_style('ddp-tina-testimonial-you-got', plugins_url('build/tina/css/process-page1/tina-testimonial-you-got.css', __FILE__));
                }

                if ($ddp_css_tina == 'tina-content-listen') {
                    wp_enqueue_style('ddp-tina-content-listen', plugins_url('build/tina/css/process-page2/tina-content-listen.css', __FILE__));
                }

                if ($ddp_css_tina == 'tina-content-mister') {
                    wp_enqueue_style('ddp-tina-content-mister', plugins_url('build/tina/css/process-page2/tina-content-mister.css', __FILE__));
                }

                if ($ddp_css_tina == 'tina-testimonial-told-you') {
                    wp_enqueue_style('ddp-tina-testimonial-told-you', plugins_url('build/tina/css/process-page2/tina-testimonial-told-you.css', __FILE__));
                }

                if ($ddp_css_tina == 'tina-come-on-projects') {
                    wp_enqueue_style('ddp-tina-come-on-projects', plugins_url('build/tina/css/careers/tina-come-on-projects.css', __FILE__));
                }

                if ($ddp_css_tina == 'tina-blurbs-second-try') {
                    wp_enqueue_style('ddp-tina-blurbs-second-try', plugins_url('build/tina/css/about2/tina-blurbs-second-try.css', __FILE__));
                }

                if ($ddp_css_tina == 'tina-content-back-baby') {
                    wp_enqueue_style('ddp-tina-content-back-baby', plugins_url('build/tina/css/about2/tina-content-back-baby.css ', __FILE__));
                }

                if ($ddp_css_tina == 'tina-content-wanna-hear') {
                    wp_enqueue_style('ddp-tina-content-wanna-hear', plugins_url('build/tina/css/about2/tina-content-wanna-hear.css', __FILE__));
                }

                if ($ddp_css_tina == 'tina-person-talk-now') {
                    wp_enqueue_style('ddp-tina-person-module-talk-now', plugins_url('build/tina/css/about2/tina-person-module-talk-now.css', __FILE__));
                }

                if ($ddp_css_tina == 'tina-slider-sail-away') {
                    wp_enqueue_style('ddp-tina-slider-sail-away', plugins_url('build/tina/css/tina-slider-sail-away.css', __FILE__));
                }

                if ($ddp_css_tina == 'tina-slider-you-take') {
                    wp_enqueue_style('ddp-tina-slider-you-take', plugins_url('build/tina/css/home7/tina-slider-you-take.css', __FILE__));
                }

                if ($ddp_css_tina == 'tina-slider-you-take-v2') {
                    wp_enqueue_style('ddp-tina-slider-you-take-v2', plugins_url('build/tina/css/home7/tina-slider-you-take-V2.css', __FILE__));
                }

                if ($ddp_css_tina == 'tina-portfolio-bayou') {
                    wp_enqueue_style('ddp-tina-portfolio-bayou', plugins_url('build/tina/css/portfolio-1/tina-portfolio-bayou.css', __FILE__));
                }

                if ($ddp_css_tina == 'tina-portfolio-ribbon') {
                    wp_enqueue_style('ddp-tina-portfolio-ribbon', plugins_url('build/tina/css/portfolio-2/tina-portfolio-ribbon.css', __FILE__));
                }

                if ($ddp_css_tina == 'tina-header-have-ridden') {
                    wp_enqueue_style('ddp-tina-header-have-ridden', plugins_url('build/tina/css/home8/tina-header-have-ridden.css', __FILE__));
                }

                if ($ddp_css_tina == 'tina-numbers-orignal') {
                    wp_enqueue_style('ddp-tina-numbers-orignal', plugins_url('build/tina/css/home8/tina-numbers-orignal.css', __FILE__));
                }

                if ($ddp_css_tina == 'tina-video-sage') {
                    wp_enqueue_style('ddp-tina-video-sage', plugins_url('build/tina/css/home8/tina-video-sage.css', __FILE__));
                }

                if ($ddp_css_tina == 'tina-case-studies-takes-two') {
                    wp_enqueue_style('ddp-tina-case-studies-takes-two', plugins_url('build/tina/css/home8/tina-case-studies-takes-two.css', __FILE__));
                }

                if ($ddp_css_tina == 'tina-blurbs-me-and-you') {
                    wp_enqueue_style('ddp-tina-blurbs-me-and-you', plugins_url('build/tina/css/home8/tina-blurbs-me-and-you.css', __FILE__));
                }

                if ($ddp_css_tina == 'tina-footer-proud') {
                    wp_enqueue_style('ddp-tina-footer-proud', plugins_url('build/tina/css/home8/tina-footer-proud.css', __FILE__));
                }

                if ($ddp_css_tina == 'tina-content-the-people') {
                    wp_enqueue_style('ddp-tina-content-the-people', plugins_url('build/tina/css/about3/tina-content-the-people.css', __FILE__));
                }

                if ($ddp_css_tina == 'tina-content-the-fields') {
                    wp_enqueue_style('ddp-tina-content-the-fields', plugins_url('build/tina/css/about3/tina-content-the-fields.css', __FILE__));
                }

                if ($ddp_css_tina == 'tina-blurbs-church-house') {
                    wp_enqueue_style('ddp-tina-blurbs-church-house.css', plugins_url('build/tina/css/about3/tina-blurbs-church-house.css', __FILE__));
                }

                if ($ddp_css_tina == 'tina-content-call-it') {
                    wp_enqueue_style('ddp-tina-tina-content-call-it', plugins_url('build/tina/css/about3/tina-content-call-it.css', __FILE__));
                }

                if ($ddp_css_tina == 'tina-testimonial-go-to') {
                    wp_enqueue_style('ddp-tina-testimonial-go-to', plugins_url('build/tina/css/about3/tina-testimonial-go-to.css', __FILE__));
                }

                if ($ddp_css_tina == 'tina-person-call-it') {
                    wp_enqueue_style('ddp-tina-person-module-call-it', plugins_url('build/tina/css/about3/tina-person-module-call-it.css', __FILE__));
                }

                if ($ddp_css_tina == 'tina-content-church-house') {
                    wp_enqueue_style('ddp-tina-content-church-house', plugins_url('build/tina/css/home9/tina-content-church-house.css', __FILE__));
                }

                if ($ddp_css_tina == 'tina-blurbs-speed-limit') {
                    wp_enqueue_style('ddp-tina-blurbs-speed-limit', plugins_url('build/tina/css/home9/tina-blurbs-speed-limit.css', __FILE__));
                }

                if ($ddp_css_tina == 'tina-tabs-highway') {
                    wp_enqueue_style('ddp-tina-tabs-highway', plugins_url('build/tina/css/home9/tina-tabs-highway.css', __FILE__));
                }

                if ($ddp_css_tina == 'tina-testimonial-city-limites') {
                    wp_enqueue_style('ddp-tina-testimonial-city-limites', plugins_url('build/tina/css/home9/tina-testimonial-city-limites.css', __FILE__));
                }

                if ($ddp_css_tina == 'tina-archive-1') {
                    wp_enqueue_style('ddp-tina-archive-1', plugins_url('build/tina/css/archive1/tina-archive1.css', __FILE__));
                }

                if ($ddp_css_tina == 'tina-footer-nutbush') {
                    wp_enqueue_style('ddp-tina-footer-nutbush', plugins_url('build/tina/css/home9/tina-footer-nutbush.css', __FILE__));
                }

                if ($ddp_css_tina == 'tina-header-switched') {
                    wp_enqueue_style('ddp-tina-header-switched', plugins_url('build/tina/css/magazine/tina-header-switched.css', __FILE__));
                }

                if ($ddp_css_tina == 'tina-blog-rain-falling') {
                    wp_enqueue_style('ddp-tina-blog-rain-falling', plugins_url('build/tina/css/magazine/tina-blog-rain-falling.css', __FILE__));
                }

                if ($ddp_css_tina == 'tina-blog-bad-enough') {
                    wp_enqueue_style('ddp-tina-blog-bad-enough', plugins_url('build/tina/css/magazine/tina-blog-bad-enough.css', __FILE__));
                }

                if ($ddp_css_tina == 'tina-products-working-for') {
                    wp_enqueue_style('ddp-tina-products-working-for', plugins_url('build/tina/css/magazine/tina-products-working-for.css', __FILE__));
                }

                if ($ddp_css_tina == 'tina-video-talk-much') {
                    wp_enqueue_style('ddp-tina-video-talk-much', plugins_url('build/tina/css/magazine/tina-video-talk-much.css', __FILE__));
                }

                if ($ddp_css_tina == 'tina-blog-this-town') {
                    wp_enqueue_style('ddp-tina-blog-this-town', plugins_url('build/tina/css/magazine/tina-blog-this-town.css', __FILE__));
                }

                if ($ddp_css_tina == 'tina-magazine-still-play-footer') {
                    wp_enqueue_style('ddp-tina-magazine-still-play-footer', plugins_url('build/tina/css/magazine/tina-footer-magazine-still-play.css', __FILE__));
                }

                if ($ddp_css_tina == 'tina-content-the-movies') {
                    wp_enqueue_style('ddp-tina-content-the-movies', plugins_url('build/tina/css/pricing-1/tina-content-the-movies.css', __FILE__));
                }

                if ($ddp_css_tina == 'tina-pricing-tables-pinch-of') {
                    wp_enqueue_style('ddp-tina-pricing-tables-pinch-of', plugins_url('build/tina/css/pricing-1/tina-pricing-tables-pinch-of.css', __FILE__));
                }

                if ($ddp_css_tina == 'tina-testimonial-one-can') {
                    wp_enqueue_style('ddp-tina-testimonial-one-can', plugins_url('build/tina/css/pricing-1/tina-testimonial-one-can.css', __FILE__));
                }

                if ($ddp_css_tina == 'tina-pricing-1-footer') {
                    wp_enqueue_style('ddp-tina-pricing-1-footer', plugins_url('build/tina/css/pricing-1/tina-pricing-1-footer.css', __FILE__));
                }

                if ($ddp_css_tina == 'tina-header-pale-moon') {
                    wp_enqueue_style('ddp-tina-header-pale-moon', plugins_url('build/tina/css/pricing-2/tina-header-pale-moon.css', __FILE__));
                }

                if ($ddp_css_tina == 'tina-pricing-table-pretending') {
                    wp_enqueue_style('ddp-tina-pricing-table-pretending', plugins_url('build/tina/css/pricing-2/tina-pricing-table-pretending.css', __FILE__));
                }

                if ($ddp_css_tina == 'tina-testimonial-two-can') {
                    wp_enqueue_style('ddp-tina-testimonial-two-can', plugins_url('build/tina/css/pricing-2/tina-testimonial-two-can.css', __FILE__));
                }

                if ($ddp_css_tina == 'tina-blog-1') {
                    wp_enqueue_style('ddp-tina-blog-1', plugins_url('build/tina/css/blogs/blog1/tina-blog-1.css', __FILE__));
                }

                if ($ddp_css_tina == 'tina-blog-2') {
                    wp_enqueue_style('ddp-tina-blog-2', plugins_url('build/tina/css/blogs/blog2/tina-blog-2.css', __FILE__));
                }

                if ($ddp_css_tina == 'tina-blog-3') {
                    wp_enqueue_style('ddp-tina-blog-3', plugins_url('build/tina/css/blogs/blog3/tina-blog-3.css', __FILE__));
                }

                if ($ddp_css_tina == 'tina-blog-4') {
                    wp_enqueue_style('ddp-tina-blog-4', plugins_url('build/tina/css/blogs/blog4/tina-blog-4.css', __FILE__));
                }

                if ($ddp_css_tina == 'tina-blog-5') {
                    wp_enqueue_style('ddp-tina-blog-5', plugins_url('build/tina/css/blogs/blog5/tina-blog-5.css', __FILE__));
                }

                if ($ddp_css_tina == 'tina-blog-6') {
                    wp_enqueue_style('ddp-tina-blog-6', plugins_url('build/tina/css/blogs/blog6/tina-blog-6.css', __FILE__));
                }

                if ($ddp_css_tina == 'tina-blog-7') {
                    wp_enqueue_style('ddp-tina-blog-7', plugins_url('build/tina/css/blogs/blog7/tina-blog-7.css', __FILE__));
                }

                // Landing Page 1

                if ($ddp_css_tina == 'tina-header-girls') {
                    wp_enqueue_style('ddp-tina-header-girls', plugins_url('build/tina/css/tina-lead-1/tina-header-girls.css', __FILE__));
                }

                if ($ddp_css_tina == 'tina-content-lets-dance') {
                    wp_enqueue_style('ddp-tina-content-lets-dance', plugins_url('build/tina/css/tina-lead-1/tina-content-lets-dance.css', __FILE__));
                }

                if ($ddp_css_tina == 'tina-content-broom') {
                    wp_enqueue_style('ddp-tina-content-broom', plugins_url('build/tina/css/tina-lead-1/tina-content-broom.css', __FILE__));
                }

                if ($ddp_css_tina == 'tina-testimonials-idolize-you') {
                    wp_enqueue_style('ddp-tina-testimonials-idolize-you', plugins_url('build/tina/css/tina-lead-1/tina-testimonials-idolize-you.css', __FILE__));
                }

                if ($ddp_css_tina == 'tina-numbers-acid') {
                    wp_enqueue_style('ddp-tina-numbers-acid', plugins_url('build/tina/css/tina-lead-1/tina-numbers-acid.css', __FILE__));
                }

                if ($ddp_css_tina == 'tina-pricing-table-tonight') {
                    wp_enqueue_style('ddp-tina-pricing-table-tonight', plugins_url('build/tina/css/tina-lead-1/tina-pricing-table-tonight.css', __FILE__));
                }

                if ($ddp_css_tina == 'tina-person-module-open-arms') {
                    wp_enqueue_style('ddp-tina-person-module-open-arms', plugins_url('build/tina/css/tina-lead-1/tina-person-module-open-arms.css', __FILE__));
                }

                if ($ddp_css_tina == 'tina-blurbs-i-see') {
                    wp_enqueue_style('ddp-tina-blurbs-i-see', plugins_url('build/tina/css/tina-lead-1/tina-blurbs-I-see.css', __FILE__));
                }

                // Landing Page 2

                if ($ddp_css_tina == 'tina-header-crazy') {
                    wp_enqueue_style('ddp-tina-header-crazy', plugins_url('build/tina/css/tina-lead-2/tina-header-crazy.css', __FILE__));
                }

                if ($ddp_css_tina == 'tina-content-way') {
                    wp_enqueue_style('ddp-tina-tina-content-way', plugins_url('build/tina/css/tina-lead-2/tina-content-way.css', __FILE__));
                }

                if ($ddp_css_tina == 'tina-blurb-white') {
                    wp_enqueue_style('ddp-tina-blurb-white', plugins_url('build/tina/css/tina-lead-2/tina-blurb-white.css', __FILE__));
                }

                if ($ddp_css_tina == 'tina-trusted-by-logo') {
                    wp_enqueue_style('ddp-tina-trusted-by-logo', plugins_url('build/tina/css/tina-lead-2/tina-trusted-by-logo.css', __FILE__));
                }

                if ($ddp_css_tina == 'tina-testimonial-finest-girl') {
                    wp_enqueue_style('ddp-tina-testimonial-finest-girl', plugins_url('build/tina/css/tina-lead-2/tina-testimonial-finest-girl.css', __FILE__));
                }

                if ($ddp_css_tina == 'tina-pricing-table-it-on') {
                    wp_enqueue_style('ddp-tina-pricing-table-it-on', plugins_url('build/tina/css/tina-lead-2/tina-pricing-table-it-on.css', __FILE__));
                }

                // Landing Page 3

                if ($ddp_css_tina == 'tina-header-steam') {
                    wp_enqueue_style('ddp-tina-header-steam', plugins_url('build/tina/css/tina-lead-3/tina-header-steam.css', __FILE__));
                }

                if ($ddp_css_tina == 'tina-content-universe') {
                    wp_enqueue_style('ddp-tina-content-universe', plugins_url('build/tina/css/tina-lead-3/tina-content-universe.css', __FILE__));
                }

                if ($ddp_css_tina == 'tina-content-liberty') {
                    wp_enqueue_style('ddp-tina-content-liberty', plugins_url('build/tina/css/tina-lead-3/tina-content-liberty.css', __FILE__));
                }

                if ($ddp_css_tina == 'tina-content-cause') {
                    wp_enqueue_style('ddp-tina-content-cause', plugins_url('build/tina/css/tina-lead-3/tina-content-cause.css', __FILE__));
                }

                if ($ddp_css_tina == 'tina-content-producers') {
                    wp_enqueue_style('ddp-tina-content-producers', plugins_url('build/tina/css/tina-lead-3/tina-content-producers.css', __FILE__));
                }

                if ($ddp_css_tina == 'tina-content-eternal') {
                    wp_enqueue_style('ddp-tina-content-eternal', plugins_url('build/tina/css/tina-lead-3/tina-content-eternal.css', __FILE__));
                }

                if ($ddp_css_tina == 'tina-testimonials-lead-3') {
                    wp_enqueue_style('ddp-tina-testimonials-lead-3', plugins_url('build/tina/css/tina-lead-3/tina-testimonials-lead-3.css', __FILE__));
                }
            } // Tina end

            // Ragnar

            if (!empty(get_post_meta($post->ID, 'ddp-css-ragnar'))) {
                foreach ((array) get_post_meta($post->ID, 'ddp-css-ragnar') as $ddpdm_css_ragnar) {
                    // for 25 Nov
                    if ($ddpdm_css_ragnar == 'ragnar-header-arne') {
                        wp_enqueue_style('ddp-ragnar-header-arne', plugins_url('build/ragnar/css/ragnar-home-1/ragnar-header-arne.css', __FILE__));
                    }
                    if ($ddpdm_css_ragnar == 'ragnar-content-eagle') {
                        wp_enqueue_style('ddp-ragnar-content-eagle', plugins_url('build/ragnar/css/ragnar-home-1/ragnar-content-eagle.css', __FILE__));
                    }
                    if ($ddpdm_css_ragnar == 'ragnar-blurbs-birger') {
                        wp_enqueue_style('ddp-ragnar-blurbs-birger', plugins_url('build/ragnar/css/ragnar-home-1/ragnar-blurbs-birger.css', __FILE__));
                    }
                    if ($ddpdm_css_ragnar == 'ragnar-blurbs-keeper') {
                        wp_enqueue_style('ddp-ragnar-blurbs-keeper', plugins_url('build/ragnar/css/ragnar-home-1/ragnar-blurbs-keeper.css', __FILE__));
                    }
                    if ($ddpdm_css_ragnar == 'ragnar-blog-bjorn') {
                        wp_enqueue_style('ddp-ragnar-blog-bjorn', plugins_url('build/ragnar/css/ragnar-home-1/ragnar-blog-bjorn.css', __FILE__));
                    }
                    if ($ddpdm_css_ragnar == 'ragnar-content-bear') {
                        wp_enqueue_style('ddp-ragnar-content-bear', plugins_url('build/ragnar/css/ragnar-home-1/ragnar-content-bear.css', __FILE__));
                    }
                    if ($ddpdm_css_ragnar == 'ragnar-footer-bo') {
                        wp_enqueue_style('ddp-ragnar-footer-bo', plugins_url('build/ragnar/css/ragnar-home-1/ragnar-footer-Bo.css', __FILE__));
                    }

                    if ($ddpdm_css_ragnar == 'ragnar-header-resident') {
                        wp_enqueue_style('ddp-ragnar-header-resident', plugins_url('build/ragnar/css/ragnar-home-2/ragnar-header-resident.css', __FILE__));
                    }
                    if ($ddpdm_css_ragnar == 'ragnar-content-erik') {
                        wp_enqueue_style('ddp-ragnar-content-erik', plugins_url('build/ragnar/css/ragnar-home-2/ragnar-content-erik.css', __FILE__));
                    }
                    if ($ddpdm_css_ragnar == 'ragnar-blurbs-ruler') {
                        wp_enqueue_style('ddp-ragnar-blurbs-ruler', plugins_url('build/ragnar/css/ragnar-home-2/ragnar-blurbs-ruler.css', __FILE__));
                    }
                    if ($ddpdm_css_ragnar == 'ragnar-content-frode') {
                        wp_enqueue_style('ddp-ragnar-content-frode', plugins_url('build/ragnar/css/ragnar-home-2/ragnar-content-frode.css', __FILE__));
                    }
                    if ($ddpdm_css_ragnar == 'ragnar-testimonails-gorm') {
                        wp_enqueue_style('ddp-ragnar-testimonails-gorm', plugins_url('build/ragnar/css/ragnar-home-2/ragnar-tesimonails-gorm.css', __FILE__));
                    }
                    if ($ddpdm_css_ragnar == 'ragnar-blog-halfdan') {
                        wp_enqueue_style('ddp-ragnar-blog-halfdan', plugins_url('build/ragnar/css/ragnar-home-2/ragnar-blog-halfdan.css', __FILE__));
                    }
                    if ($ddpdm_css_ragnar == 'ragnar-footer-danish') {
                        wp_enqueue_style('ddp-ragnar-footer-danish', plugins_url('build/ragnar/css/ragnar-home-2/ragnar-footer-danish.css', __FILE__));
                    }

                    if ($ddpdm_css_ragnar == 'ragnar-header-left') {
                        wp_enqueue_style('ddp-ragnar-header-left', plugins_url('build/ragnar/css/ragnar-home-3/ragnar-header-left.css', __FILE__));
                    }
                    if ($ddpdm_css_ragnar == 'ragnar-content-curly') {
                        wp_enqueue_style('ddp-ragnar-content-curly', plugins_url('build/ragnar/css/ragnar-home-3/ragnar-content-curly.css', __FILE__));
                    }
                    if ($ddpdm_css_ragnar == 'ragnar-content-kare') {
                        wp_enqueue_style('ddp-ragnar-content-kare', plugins_url('build/ragnar/css/ragnar-home-3/ragnar-content-kare.css', __FILE__));
                    }
                    if ($ddpdm_css_ragnar == 'ragnar-content-knot') {
                        wp_enqueue_style('ddp-ragnar-content-knot', plugins_url('build/ragnar/css/ragnar-home-3/ragnar-content-knot.css', __FILE__));
                    }
                    if ($ddpdm_css_ragnar == 'ragnar-blog-knud') {
                        wp_enqueue_style('ddp-ragnar-blog-knud', plugins_url('build/ragnar/css/ragnar-home-3/ragnar-blog-knud.css', __FILE__));
                    }


                    if ($ddpdm_css_ragnar == 'ragnar-header-descendant') {
                        wp_enqueue_style('ddp-ragnar-header-descendant', plugins_url('build/ragnar/css/ragnar-home-4/ragnar-header-descendant.css', __FILE__));
                    }
                    if ($ddpdm_css_ragnar == 'ragnar-content-njal') {
                        wp_enqueue_style('ddp-ragnar-content-njal', plugins_url('build/ragnar/css/ragnar-home-4/ragnar-content-njal.css', __FILE__));
                    }
                    if ($ddpdm_css_ragnar == 'ragnar-content-giant') {
                        wp_enqueue_style('ddp-ragnar-content-giant', plugins_url('build/ragnar/css/ragnar-home-4/ragnar-content-giant.css', __FILE__));
                    }
                    if ($ddpdm_css_ragnar == 'ragnar-content-roar') {
                        wp_enqueue_style('ddp-ragnar-content-roar', plugins_url('build/ragnar/css/ragnar-home-4/ragnar-content-roar.css', __FILE__));
                    }
                    if ($ddpdm_css_ragnar == 'ragnar-content-fame') {
                        wp_enqueue_style('ddp-ragnar-content-fame', plugins_url('build/ragnar/css/ragnar-home-4/ragnar-content-fame.css', __FILE__));
                    }
                    if ($ddpdm_css_ragnar == 'ragnar-blog-rune') {
                        wp_enqueue_style('ddp-ragnar-blog-rune', plugins_url('build/ragnar/css/ragnar-home-4/ragnar-blog-rune.css', __FILE__));
                    }


                    if ($ddpdm_css_ragnar == 'ragnar-content-movin-on') {
                        wp_enqueue_style('ddp-ragnar-content-movin-on', plugins_url('build/ragnar/css/ragnar-home-5/ragnar-content-movin-on.css', __FILE__));
                    }
                    if ($ddpdm_css_ragnar == 'ragnar-content-wheeler') {
                        wp_enqueue_style('ddp-ragnar-content-wheeler', plugins_url('build/ragnar/css/ragnar-home-5/ragnar-content-wheeler.css', __FILE__));
                    }
                    if ($ddpdm_css_ragnar == 'ragnar-testimonial-daddy') {
                        wp_enqueue_style('ddp-ragnar-testimonial-daddy', plugins_url('build/ragnar/css/ragnar-home-5/ragnar-testimonial-daddy.css', __FILE__));
                    }
                    if ($ddpdm_css_ragnar == 'ragnar-blog-loud-whistle') {
                        wp_enqueue_style('ddp-ragnar-blog-loud-whistle', plugins_url('build/ragnar/css/ragnar-home-5/ragnar-blog-loud-whistle.css', __FILE__));
                    }
                    if ($ddpdm_css_ragnar == 'ragnar-footer-my-mother') {
                        wp_enqueue_style('ddp-ragnar-footer-my-mother', plugins_url('build/ragnar/css/ragnar-home-5/ragnar-footer-my-mother.css', __FILE__));
                    }

                    // for 26 Nov
                    if ($ddpdm_css_ragnar == 'ragnar-contact-trygve') {
                        wp_enqueue_style('ddp-ragnar-contact-trygve', plugins_url('build/ragnar/css/ragnar-contact-1/ragnar-contact-trygve.css', __FILE__));
                    }
                    if ($ddpdm_css_ragnar == 'ragnar-footer-harald') {
                        wp_enqueue_style('ddp-ragnar-footer-harald', plugins_url('build/ragnar/css/ragnar-contact-1/ragnar-footer-harald.css', __FILE__));
                    }


                    if ($ddpdm_css_ragnar == 'ragnar-header-wolf') {
                        wp_enqueue_style('ddp-ragnar-header-wolf', plugins_url('build/ragnar/css/ragnar-contact-2/ragnar-header-wolf.css', __FILE__));
                    }
                    if ($ddpdm_css_ragnar == 'ragnar-contact-wealth') {
                        wp_enqueue_style('ddp-ragnar-contact-wealth', plugins_url('build/ragnar/css/ragnar-contact-2/ragnar-contact-wealth.css', __FILE__));
                    }


                    if ($ddpdm_css_ragnar == 'ragnar-header-age') {
                        wp_enqueue_style('ddp-ragnar-header-age', plugins_url('build/ragnar/css/ragnar-contact-3/ragnar-header-age.css', __FILE__));
                    }
                    if ($ddpdm_css_ragnar == 'ragnar-contact-ploughs') {
                        wp_enqueue_style('ddp-ragnar-contact-ploughs', plugins_url('build/ragnar/css/ragnar-contact-3/ragnar-contact-ploughs.css', __FILE__));
                    }
                    if ($ddpdm_css_ragnar == 'ragnar-person-ancestor') {
                        wp_enqueue_style('ddp-ragnar-person-ancestor', plugins_url('build/ragnar/css/ragnar-contact-3/ragnar-person-ancestor.css', __FILE__));
                    }


                    if ($ddpdm_css_ragnar == 'ragnar-contact-loved') {
                        wp_enqueue_style('ddp-ragnar-contact-loved', plugins_url('build/ragnar/css/ragnar-contact-4/ragnar-contact-loved.css', __FILE__));
                    }
                    if ($ddpdm_css_ragnar == 'ragnar-content-astrid') {
                        wp_enqueue_style('ddp-ragnar-content-astrid', plugins_url('build/ragnar/css/ragnar-contact-4/ragnar-content-astrid.css', __FILE__));
                    }


                    if ($ddpdm_css_ragnar == 'ragnar-content-bodil') {
                        wp_enqueue_style('ddp-ragnar-content-bodil', plugins_url('build/ragnar/css/ragnar-contact-5/ragnar-content-bodil.css', __FILE__));
                    }
                    if ($ddpdm_css_ragnar == 'ragnar-contact-penance') {
                        wp_enqueue_style('ddp-ragnar-contact-penance', plugins_url('build/ragnar/css/ragnar-contact-5/ragnar-contact-penance.css', __FILE__));
                    }


                    if ($ddpdm_css_ragnar == 'ragnar-content-tove') {
                        wp_enqueue_style('ddp-ragnar-content-tove', plugins_url('build/ragnar/css/ragnar-contact-6/ragnar-content-tove.css', __FILE__));
                    }
                    if ($ddpdm_css_ragnar == 'ragnar-contact-form-dove') {
                        wp_enqueue_style('ddp-ragnar-contact-form-dove', plugins_url('build/ragnar/css/ragnar-contact-6/ragnar-contact-form-dove.css', __FILE__));
                    }


                    if ($ddpdm_css_ragnar == 'ragnar-header-toke') {
                        wp_enqueue_style('ddp-ragnar-header-toke', plugins_url('build/ragnar/css/ragnar-case-study-1/ragnar-header-toke.css', __FILE__));
                    }
                    if ($ddpdm_css_ragnar == 'ragnar-slider-thor') {
                        wp_enqueue_style('ddp-ragnar-slider-thor', plugins_url('build/ragnar/css/ragnar-case-study-1/ragnar-slider-thor.css', __FILE__));
                    }
                    if ($ddpdm_css_ragnar == 'ragnar-content-helmet') {
                        wp_enqueue_style('ddp-ragnar-content-helmet', plugins_url('build/ragnar/css/ragnar-case-study-1/ragnar-content-helmet.css', __FILE__));
                    }
                    if ($ddpdm_css_ragnar == 'ragnar-content-torsten') {
                        wp_enqueue_style('ddp-ragnar-content-torsten', plugins_url('build/ragnar/css/ragnar-case-study-1/ragnar-content-torsten.css', __FILE__));
                    }


                    if ($ddpdm_css_ragnar == 'ragnar-slider-voice-id-sing') {
                        wp_enqueue_style('ddp-ragnar-slider-voice-id-sing', plugins_url('build/ragnar/css/ragnar-case-study-2/ragnar-slider-voice-id-sing.css', __FILE__));
                    }
                    if ($ddpdm_css_ragnar == 'ragnar-content-noble-barque') {
                        wp_enqueue_style('ddp-ragnar-content-noble-barque', plugins_url('build/ragnar/css/ragnar-case-study-2/ragnar-content-noble-barque.css', __FILE__));
                    }
                    if ($ddpdm_css_ragnar == 'ragnar-content-i-steer') {
                        wp_enqueue_style('ddp-ragnar-content-i-steer', plugins_url('build/ragnar/css/ragnar-case-study-2/ragnar-content-i-steer.css', __FILE__));
                    }
                    if ($ddpdm_css_ragnar == 'ragnar-projects-good-oars') {
                        wp_enqueue_style('ddp-ragnar-projects-good-oars', plugins_url('build/ragnar/css/ragnar-case-study-2/ragnar-projects-good-oars.css', __FILE__));
                    }


                    if ($ddpdm_css_ragnar == 'ragnar-person-module-roar') {
                        wp_enqueue_style('ddp-ragnar-person-module-roar', plugins_url('build/ragnar/css/ragnar-team-1/ragnar-person-module-roar.css', __FILE__));
                    }
                    if ($ddpdm_css_ragnar == 'ragnar-content-spear') {
                        wp_enqueue_style('ddp-ragnar-content-spear', plugins_url('build/ragnar/css/ragnar-team-1/ragnar-content-spear.css', __FILE__));
                    }
                    if ($ddpdm_css_ragnar == 'ragnar-person-module-roar') {
                        wp_enqueue_style('ddp-ragnar-person-module-roar', plugins_url('build/ragnar/css/ragnar-team-1/ragnar-person-module-roar.css', __FILE__));
                    }

                    if ($ddpdm_css_ragnar == 'ragnar-portfolio-good-oars') {
                        wp_enqueue_style('ddp-ragnar-portfolio-good-oars', plugins_url('build/ragnar/css/ragnar-our-work/ragnar-portfolio-good-oars.css', __FILE__));
                    }
                    if ($ddpdm_css_ragnar == 'ragnar-subscribe-galleys') {
                        wp_enqueue_style('ddp-ragnar-subscribe-galleys', plugins_url('build/ragnar/css/ragnar-our-work/ragnar-subscribe-galleys.css', __FILE__));
                    }

                    // for 27 Nov

                    if ($ddpdm_css_ragnar == 'ragnar-menu-farmer') {
                        wp_enqueue_style('ddp-ragnar-menu-farmer', plugins_url('build/ragnar/css/ragnar-menus/ragnar-menu-farmer.css', __FILE__));
                    }

                    if ($ddpdm_css_ragnar == 'ragnar-menu-hulks') {
                        wp_enqueue_style('ddp-ragnar-menu-hulks', plugins_url('build/ragnar/css/ragnar-menus/ragnar-menu-hulks.css', __FILE__));
                    }

                    if ($ddpdm_css_ragnar == 'ragnar-menu-idun') {
                        wp_enqueue_style('ddp-ragnar-menu-idun', plugins_url('build/ragnar/css/ragnar-menus/ragnar-menu-idun.css', __FILE__));
                    }

                    if ($ddpdm_css_ragnar == 'ragnar-menu-longhouse') {
                        wp_enqueue_style('ddp-ragnar-menu-longhouse', plugins_url('build/ragnar/css/ragnar-menus/ragnar-menu-longhouse.css', __FILE__));
                    }

                    if ($ddpdm_css_ragnar == 'ragnar-menu-pursuit') {
                        wp_enqueue_style('ddp-ragnar-menu-pursuit', plugins_url('build/ragnar/css/ragnar-menus/ragnar-menu-pursuit.css', __FILE__));
                    }

                    if ($ddpdm_css_ragnar == 'ragnar-menu-skalds') {
                        wp_enqueue_style('ddp-ragnar-menu-skalds', plugins_url('build/ragnar/css/ragnar-menus/ragnar-menu-skalds.css', __FILE__));
                    }

                    if ($ddpdm_css_ragnar == 'ragnar-menu-valhalla') {
                        wp_enqueue_style('ddp-ragnar-menu-valhalla', plugins_url('build/ragnar/css/ragnar-menus/ragnar-menu-valhalla.css', __FILE__));
                    }

                    if ($ddpdm_css_ragnar == 'ragnar-menu-odin') {
                        wp_enqueue_style('ddp-ragnar-menu-odin', plugins_url('build/ragnar/css/ragnar-menus/ragnar-menu-odin.css', __FILE__));
                    }

                    if ($ddpdm_css_ragnar == 'ragnar-menu-stolen') {
                        wp_enqueue_style('ddp-ragnar-menu-stolen', plugins_url('build/ragnar/css/ragnar-menus/ragnar-menu-stolen.css', __FILE__));
                    }

                    if ($ddpdm_css_ragnar == 'ragnar-menu-giants') {
                        wp_enqueue_style('ddp-ragnar-menu-giants', plugins_url('build/ragnar/css/ragnar-menus/ragnar-menu-giants.css', __FILE__));
                    }

                    if ($ddpdm_css_ragnar == 'ragnar-menu-titan') {
                        wp_enqueue_style('ddp-ragnar-menu-titan', plugins_url('build/ragnar/css/ragnar-menus/ragnar-menu-titan.css', __FILE__));
                    }


                    // for 30 Nov

                    if ($ddpdm_css_ragnar == 'ragnar-not-found-2') {
                        wp_enqueue_style('ddp-ragnar-not-found-2', plugins_url('build/ragnar/css/ragnar-not-found/ragnar-404-v2.css', __FILE__));
                    }

                    if ($ddpdm_css_ragnar == 'ragnar-not-found-4') {
                        wp_enqueue_style('ddp-ragnar-not-found-4', plugins_url('build/ragnar/css/ragnar-not-found/ragnar-404-v4.css', __FILE__));
                    }

                    if ($ddpdm_css_ragnar == 'ragnar-not-found-5') {
                        wp_enqueue_style('ddp-ragnar-not-found-5', plugins_url('build/ragnar/css/ragnar-not-found/ragnar-404-v5.css', __FILE__));
                    }

                    if ($ddpdm_css_ragnar == 'ragnar-not-found-6') {
                        wp_enqueue_style('ddp-ragnar-not-found-6', plugins_url('build/ragnar/css/ragnar-not-found/ragnar-404-v6.css', __FILE__));
                    }

                    if ($ddpdm_css_ragnar == 'ragnar-not-found-7') {
                        wp_enqueue_style('ddp-ragnar-not-found-7', plugins_url('build/ragnar/css/ragnar-not-found/ragnar-404-v7.css', __FILE__));
                    }

                    if ($ddpdm_css_ragnar == 'ragnar-not-found-8') {
                        wp_enqueue_style('ddp-ragnar-not-found-8', plugins_url('build/ragnar/css/ragnar-not-found/ragnar-404-v8.css', __FILE__));
                    }

                    if ($ddpdm_css_ragnar == 'ragnar-not-found-9') {
                        wp_enqueue_style('ddp-ragnar-not-found-9', plugins_url('build/ragnar/css/ragnar-not-found/ragnar-404-v9.css', __FILE__));
                    }

                    if ($ddpdm_css_ragnar == 'ragnar-not-found-10') {
                        wp_enqueue_style('ddp-ragnar-not-found-10', plugins_url('build/ragnar/css/ragnar-not-found/ragnar-404-v10.css', __FILE__));
                    }

                    if ($ddpdm_css_ragnar == 'ragnar-not-found-11') {
                        wp_enqueue_style('ddp-ragnar-not-found-11', plugins_url('build/ragnar/css/ragnar-not-found/ragnar-404-v11.css', __FILE__));
                    }

                    if ($ddpdm_css_ragnar == 'ragnar-not-found-13') {
                        wp_enqueue_style('ddp-ragnar-not-found-13', plugins_url('build/ragnar/css/ragnar-not-found/ragnar-404-v13.css', __FILE__));
                    }

                    if ($ddpdm_css_ragnar == 'ragnar-not-found-15') {
                        wp_enqueue_style('ddp-ragnar-not-found-15', plugins_url('build/ragnar/css/ragnar-not-found/ragnar-404-v15.css', __FILE__));
                    }

                    if ($ddpdm_css_ragnar == 'ragnar-not-found-16') {
                        wp_enqueue_style('ddp-ragnar-not-found-16', plugins_url('build/ragnar/css/ragnar-not-found/ragnar-404-v16.css', __FILE__));
                    }

                    if ($ddpdm_css_ragnar == 'ragnar-not-found-17') {
                        wp_enqueue_style('ddp-ragnar-not-found-17', plugins_url('build/ragnar/css/ragnar-not-found/ragnar-404-v17.css', __FILE__));
                    }

                    if ($ddpdm_css_ragnar == 'ragnar-not-found-18') {
                        wp_enqueue_style('ddp-ragnar-not-found-18', plugins_url('build/ragnar/css/ragnar-not-found/ragnar-404-v18.css', __FILE__));
                    }

                    if ($ddpdm_css_ragnar == 'ragnar-not-found-19') {
                        wp_enqueue_style('ddp-ragnar-not-found-19', plugins_url('build/ragnar/css/ragnar-not-found/ragnar-404-v19.css', __FILE__));
                    }

                    if ($ddpdm_css_ragnar == 'ragnar-not-found-21') {
                        wp_enqueue_style('ddp-ragnar-not-found-21', plugins_url('build/ragnar/css/ragnar-not-found/ragnar-404-v21.css', __FILE__));
                    }

                    // for 2 Dec

                    for ($i = 1; $i < 18; $i++) {
                        if ($ddpdm_css_ragnar == 'ragnar-popups-'.$i) {
                            wp_enqueue_style('ddpdm-ragnar-pop-up'.$i.'-css', plugins_url('/build/ragnar/css/ragnar-popups/ragnar-popups-v'.$i.'.css', __FILE__));
                        }
                    }

                    for ($i = 1; $i < 10; $i++) {
                        if ($ddpdm_css_ragnar == 'ragnar-coming-soon-'.$i) {
                            wp_enqueue_style('ddpdm-ragnar-coming-soon'.$i.'-css', plugins_url('/build/ragnar/css/ragnar-coming-soon/ragnar-coming-soon-'.$i.'.css', __FILE__));
                        }
                    }


                    // for 2 Feb

                    if ($ddpdm_css_ragnar == 'ragnar-tabs-the-track') {
                        wp_enqueue_style('ddp-ragnar-tabs-the-track', plugins_url('build/ragnar/css/ragnar-about-1/ragnar-tabs-the-track.css', __FILE__));
                    }

                    if ($ddpdm_css_ragnar == 'ragnar-content-little-old') {
                        wp_enqueue_style('ddp-ragnar-content-little-old', plugins_url('build/ragnar/css/ragnar-about-1/ragnar-content-little-old.css', __FILE__));
                    }

                    if ($ddpdm_css_ragnar == 'ragnar-cta-loud-whistle') {
                        wp_enqueue_style('ddp-ragnar-cta-loud-whistle', plugins_url('build/ragnar/css/ragnar-about-1/ragnar-cta-loud-whistle.css', __FILE__));
                    }

                    if ($ddpdm_css_ragnar == 'ragnar-content-descendant') {
                        wp_enqueue_style('ddp-ragnar-content-descendant', plugins_url('build/ragnar/css/ragnar-about-2/ragnar-content-descendant.css', __FILE__));
                    }

                    if ($ddpdm_css_ragnar == 'ragnar-content-njal-v2') {
                        wp_enqueue_style('ddp-ragnar-content-njal-v2', plugins_url('build/ragnar/css/ragnar-about-2/ragnar-content-njal-v2.css', __FILE__));
                    }

                    if ($ddpdm_css_ragnar == 'ragnar-person-leif') {
                        wp_enqueue_style('ddp-ragnar-person-leif', plugins_url('build/ragnar/css/ragnar-about-2/ragnar-person-leif.css', __FILE__));
                    }

                    if ($ddpdm_css_ragnar == 'ragnar-header-rune') {
                        wp_enqueue_style('ddp-ragnar-header-rune', plugins_url('build/ragnar/css/ragnar-about-3/ragnar-header-rune.css', __FILE__));
                    }

                    if ($ddpdm_css_ragnar == 'ragnar-content-secret') {
                        wp_enqueue_style('ddp-ragnar-content-secret', plugins_url('build/ragnar/css/ragnar-about-3/ragnar-content-secret.css', __FILE__));
                    }

                    if ($ddpdm_css_ragnar == 'ragnar-content-sten') {
                        wp_enqueue_style('ddp-ragnar-content-sten', plugins_url('build/ragnar/css/ragnar-about-3/ragnar-content-sten.css', __FILE__));
                    }

                    if ($ddpdm_css_ragnar == 'ragnar-blurbs-stone') {
                        wp_enqueue_style('ddp-ragnar-blurbs-stone', plugins_url('build/ragnar/css/ragnar-about-3/ragnar-blurbs-stone.css', __FILE__));
                    }

                    if ($ddpdm_css_ragnar == 'ragnar-content-skarde') {
                        wp_enqueue_style('ddp-ragnar-content-skarde', plugins_url('build/ragnar/css/ragnar-about-3/ragnar-content-skarde.css', __FILE__));
                    }

                    if ($ddpdm_css_ragnar == 'ragnar-accordion-stone') {
                        wp_enqueue_style('ddp-ragnar-accordion-stone', plugins_url('build/ragnar/css/ragnar-home-6/ragnar-accordion-stone.css', __FILE__));
                    }

                    if ($ddpdm_css_ragnar == 'ragnar-blog-skarde') {
                        wp_enqueue_style('ddp-ragnar-blog-skarde', plugins_url('build/ragnar/css/ragnar-home-6/ragnar-blog-skarde.css', __FILE__));
                    }

                    if ($ddpdm_css_ragnar == 'ragnar-blog-sten') {
                        wp_enqueue_style('ddp-ragnar-blog-sten', plugins_url('build/ragnar/css/ragnar-home-6/ragnar-blog-sten.css', __FILE__));
                    }

                    if ($ddpdm_css_ragnar == 'ragnar-blurbs-chin') {
                        wp_enqueue_style('ddp-ragnar-blurbs-chin', plugins_url('build/ragnar/css/ragnar-home-6/ragnar-blurbs-chin.css', __FILE__));
                    }

                    if ($ddpdm_css_ragnar == 'ragnar-blurbs-cleft') {
                        wp_enqueue_style('ddp-ragnar-blurbs-cleft', plugins_url('build/ragnar/css/ragnar-home-6/ragnar-blurbs-cleft.css', __FILE__));
                    }

                    if ($ddpdm_css_ragnar == 'ragnar-blurbs-cleft') {
                        wp_enqueue_style('ddp-ragnar-blurbs-cleft', plugins_url('build/ragnar/css/ragnar-home-6/ragnar-blurbs-cleft.css', __FILE__));
                    }

                    if ($ddpdm_css_ragnar == 'ragnar-blurbs-freeman') {
                        wp_enqueue_style('ddp-ragnar-blurbs-freeman', plugins_url('build/ragnar/css/ragnar-home-6/ragnar-blurbs-freeman.css', __FILE__));
                    }

                    if ($ddpdm_css_ragnar == 'ragnar-blurbs-svend') {
                        wp_enqueue_style('ddp-ragnar-blurbs-svend', plugins_url('build/ragnar/css/ragnar-home-6/ragnar-blurbs-svend.css', __FILE__));
                    }

                    if ($ddpdm_css_ragnar == 'ragnar-footer-secret') {
                        wp_enqueue_style('ddp-ragnar-footer-secret', plugins_url('build/ragnar/css/ragnar-home-6/ragnar-footer-secret.css', __FILE__));
                    }

                    if ($ddpdm_css_ragnar == 'ragnar-header-son') {
                        wp_enqueue_style('ddp-ragnar-header-son', plugins_url('build/ragnar/css/ragnar-home-6/ragnar-header-son.css', __FILE__));
                    }

                    for ($i = 1; $i < 14; $i++) {
                        if ($ddpdm_css_ragnar == 'ragnar-thank-you-'.$i) {
                            wp_enqueue_style('ddpdm-ragnar-thank-you'.$i.'-css', plugins_url('/build/ragnar/css/ragnar-thank-you/ragnar-thank-you-'.$i.'.css', __FILE__));
                        }
                    }



                    if ($ddpdm_css_ragnar == 'ragnar-portfolio-william') {
                        wp_enqueue_style('ddp-ragnar-portfolio-william', plugins_url('build/ragnar/css/ragnar-our-work-2/ragnar-portfolio-william.css', __FILE__));
                    }

                    if ($ddpdm_css_ragnar == 'ragnar-header-freja') {
                        wp_enqueue_style('ddp-ragnar-header-freja', plugins_url('build/ragnar/css/ragnar-shop-landing-v1/ragnar-header-freja.css', __FILE__));
                    }

                    if ($ddpdm_css_ragnar == 'ragnar-products-josefine') {
                        wp_enqueue_style('ddp-ragnar-products-josefine', plugins_url('build/ragnar/css/ragnar-shop-landing-v1/ragnar-products-josefine.css', __FILE__));
                    }

                    if ($ddpdm_css_ragnar == 'ragnar-content-karla') {
                        wp_enqueue_style('ddp-ragnar-content-karla', plugins_url('build/ragnar/css/ragnar-shop-landing-v1/ragnar-content-karla.css', __FILE__));
                    }

                    if ($ddpdm_css_ragnar == 'ragnar-products-clara') {
                        wp_enqueue_style('ddp-ragnar-products-clara', plugins_url('build/ragnar/css/ragnar-shop-landing-v1/ragnar-products-clara.css', __FILE__));
                    }

                    if ($ddpdm_css_ragnar == 'ragnar-content-anna') {
                        wp_enqueue_style('ddp-ragnar-content-anna', plugins_url('build/ragnar/css/ragnar-shop-landing-v1/ragnar-content-anna.css', __FILE__));
                    }

                    if ($ddpdm_css_ragnar == 'ragnar-content-laura') {
                        wp_enqueue_style('ddp-ragnar-content-laura', plugins_url('build/ragnar/css/ragnar-shop-landing-v1/ragnar-content-laura.css', __FILE__));
                    }

                    if ($ddpdm_css_ragnar == 'ragnar-header-my-thumb') {
                        wp_enqueue_style('ddp-ragnar-header-my-thumb', plugins_url('build/ragnar/css/ragnar-lead-1/ragnar-header-my-thumb.css', __FILE__));
                    }

                    if ($ddpdm_css_ragnar == 'ragnar-content-feels-alright') {
                        wp_enqueue_style('ddp-ragnar-content-feels-alright', plugins_url('build/ragnar/css/ragnar-lead-1/ragnar-content-feels-alright.css', __FILE__));
                    }

                    if ($ddpdm_css_ragnar == 'ragnar-lead-page-v1') {
                        wp_enqueue_style('ddp-ragnar-lead-page-v1', plugins_url('build/ragnar/css/ragnar-lead-1/ragnar-lead-page-v1.css', __FILE__));
                    }

                    if ($ddpdm_css_ragnar == 'ragnar-content-easy-babe') {
                        wp_enqueue_style('ddp-ragnar-content-easy-babe', plugins_url('build/ragnar/css/ragnar-lead-1/ragnar-content-easy-babe.css', __FILE__));
                    }

                    if ($ddpdm_css_ragnar == 'ragnar-content-the-change') {
                        wp_enqueue_style('ddp-ragnar-content-the-change', plugins_url('build/ragnar/css/ragnar-lead-1/ragnar-content-the-change.css', __FILE__));
                    }

                    if ($ddpdm_css_ragnar == 'ragnar-person-the-difference') {
                        wp_enqueue_style('ddp-ragnar-person-the-difference', plugins_url('build/ragnar/css/ragnar-lead-1/ragnar-person-the-difference.css', __FILE__));
                    }

                    if ($ddpdm_css_ragnar == 'ragnar-blog-adrian') {
                        wp_enqueue_style('ddp-ragnar-blog-adrian', plugins_url('build/ragnar/css/ragnar-blog-light/ragnar-blog-adrian.css', __FILE__));
                    }

                    if ($ddpdm_css_ragnar == 'ragnar-blog-agata') {
                        wp_enqueue_style('ddp-ragnar-blog-agata', plugins_url('build/ragnar/css/ragnar-blog-light/ragnar-blog-agata.css', __FILE__));
                    }

                    if ($ddpdm_css_ragnar == 'ragnar-blog-agneta') {
                        wp_enqueue_style('ddp-ragnar-blog-agneta', plugins_url('build/ragnar/css/ragnar-blog-light/ragnar-blog-agneta.css', __FILE__));
                    }

                    if ($ddpdm_css_ragnar == 'ragnar-blog-aina') {
                        wp_enqueue_style('ddp-ragnar-blog-aina', plugins_url('build/ragnar/css/ragnar-blog-light/ragnar-blog-aina.css', __FILE__));
                    }

                    if ($ddpdm_css_ragnar == 'ragnar-blog-ake') {
                        wp_enqueue_style('ddp-ragnar-blog-ake', plugins_url('build/ragnar/css/ragnar-blog-light/ragnar-blog-ake.css', __FILE__));
                    }

                    if ($ddpdm_css_ragnar == 'ragnar-blog-albert') {
                        wp_enqueue_style('ddp-ragnar-blog-albert', plugins_url('build/ragnar/css/ragnar-blog-light/ragnar-blog-albert.css', __FILE__));
                    }

                    if ($ddpdm_css_ragnar == 'ragnar-blog-albin') {
                        wp_enqueue_style('ddp-ragnar-blog-albin', plugins_url('build/ragnar/css/ragnar-blog-light/ragnar-blog-albin.css', __FILE__));
                    }

                    if ($ddpdm_css_ragnar == 'ragnar-blog-alexander') {
                        wp_enqueue_style('ddp-ragnar-blog-alexander', plugins_url('build/ragnar/css/ragnar-blog-light/ragnar-blog-alexander.css', __FILE__));
                    }

                    if ($ddpdm_css_ragnar == 'ragnar-blog-light-alfred') {
                        wp_enqueue_style('ddp-ragnar-blog-light-alfred', plugins_url('build/ragnar/css/ragnar-blog-light/ragnar-blog-light-alfred.css', __FILE__));
                    }

                    if ($ddpdm_css_ragnar == 'ragnar-blog-alma') {
                        wp_enqueue_style('ddp-ragnar-blog-alma', plugins_url('build/ragnar/css/ragnar-blog-light/ragnar-blog-alma.css', __FILE__));
                    }

                    if ($ddpdm_css_ragnar == 'ragnar-portfolio-noah') {
                        wp_enqueue_style('ddp-ragnar-portfolio-noah', plugins_url('build/ragnar/css/ragnar-our-work-3/ragnar-portfolio-noah.css', __FILE__));
                    }

                    if ($ddpdm_css_ragnar == 'ragnar-header-alberte') {
                        wp_enqueue_style('ddp-ragnar-header-alberte', plugins_url('build/ragnar/css/ragnar-shop-landing-v2/ragnar-header-alberte.css', __FILE__));
                    }

                    if ($ddpdm_css_ragnar == 'ragnar-products-olivia') {
                        wp_enqueue_style('ddp-ragnar-products-olivia', plugins_url('build/ragnar/css/ragnar-shop-landing-v2/ragnar-products-olivia.css', __FILE__));
                    }

                    if ($ddpdm_css_ragnar == 'ragnar-content-agnes') {
                        wp_enqueue_style('ddp-ragnar-content-agnes', plugins_url('build/ragnar/css/ragnar-shop-landing-v2/ragnar-content-agnes.css', __FILE__));
                    }

                    if ($ddpdm_css_ragnar == 'ragnar-products-nora') {
                        wp_enqueue_style('ddp-ragnar-products-nora', plugins_url('build/ragnar/css/ragnar-shop-landing-v2/ragnar-products-nora.css', __FILE__));
                    }

                    if ($ddpdm_css_ragnar == 'ragnar-content-luna') {
                        wp_enqueue_style('ddp-ragnar-content-luna', plugins_url('build/ragnar/css/ragnar-shop-landing-v2/ragnar-content-luna.css', __FILE__));
                    }
                    if ($ddpdm_css_ragnar == 'ragnar-content-luna') {
                        wp_enqueue_style('ddp-ragnar-content-luna', plugins_url('build/ragnar/css/ragnar-shop-landing-v2/ragnar-content-luna.css', __FILE__));
                    }

                    if ($ddpdm_css_ragnar == 'ragnar-footer-isabella') {
                        wp_enqueue_style('ddp-ragnar-footer-isabella', plugins_url('build/ragnar/css/ragnar-shop-landing-v2/ragnar-footer-isabella.css', __FILE__));
                    }

                    if ($ddpdm_css_ragnar == 'ragnar-pricing-table-cecilia') {
                        wp_enqueue_style('ddp-ragnar-pricing-table-cecilia', plugins_url('build/ragnar/css/ragnar-pricing-tables-light/ragnar-pricing-table-cecilia.css', __FILE__));
                    }

                    if ($ddpdm_css_ragnar == 'ragnar-pricing-table-dagmar') {
                        wp_enqueue_style('ddp-ragnar-pricing-table-dagmar', plugins_url('build/ragnar/css/ragnar-pricing-tables-light/ragnar-pricing-table-dagmar.css', __FILE__));
                    }

                    if ($ddpdm_css_ragnar == 'ragnar-pricing-table-eleonora') {
                        wp_enqueue_style('ddp-ragnar-pricing-table-eleonora', plugins_url('build/ragnar/css/ragnar-pricing-tables-light/ragnar-pricing-table-eleonora.css', __FILE__));
                    }

                    if ($ddpdm_css_ragnar == 'ragnar-pricing-table-elin') {
                        wp_enqueue_style('ddp-ragnar-pricing-table-elin', plugins_url('build/ragnar/css/ragnar-pricing-tables-light/ragnar-pricing-table-elin.css', __FILE__));
                    }

                    if ($ddpdm_css_ragnar == 'ragnar-pricing-table-ellinor') {
                        wp_enqueue_style('ddp-ragnar-pricing-table-ellinor', plugins_url('build/ragnar/css/ragnar-pricing-tables-light/ragnar-pricing-table-ellinor.css', __FILE__));
                    }

                    if ($ddpdm_css_ragnar == 'ragnar-pricing-table-emil') {
                        wp_enqueue_style('ddp-ragnar-pricing-table-emil', plugins_url('build/ragnar/css/ragnar-pricing-tables-light/ragnar-pricing-table-emil.css', __FILE__));
                    }

                    if ($ddpdm_css_ragnar == 'ragnar-pricing-table-emilia') {
                        wp_enqueue_style('ddp-ragnar-pricing-table-emilia', plugins_url('build/ragnar/css/ragnar-pricing-tables-light/ragnar-pricing-table-emilia.css', __FILE__));
                    }

                    if ($ddpdm_css_ragnar == 'ragnar-pricing-table-emma') {
                        wp_enqueue_style('ddp-ragnar-pricing-table-emma', plugins_url('build/ragnar/css/ragnar-pricing-tables-light/ragnar-pricing-table-emma.css', __FILE__));
                    }

                    if ($ddpdm_css_ragnar == 'ragnar-pricing-table-enar') {
                        wp_enqueue_style('ddp-ragnar-pricing-table-enar', plugins_url('build/ragnar/css/ragnar-pricing-tables-light/ragnar-pricing-table-enar.css', __FILE__));
                    }

                    if ($ddpdm_css_ragnar == 'ragnar-portfolio-valdemar') {
                        wp_enqueue_style('ddp-ragnar-portfolio-valdemar', plugins_url('build/ragnar/css/ragnar-our-work-4/ragnar-portfolio-valdemar.css', __FILE__));
                    }

                    if ($ddpdm_css_ragnar == 'ragnar-blog-ida') {
                        wp_enqueue_style('ddp-ragnar-blog-ida', plugins_url('build/ragnar/css/ragnar-blog-1/ragnar-blog-ida.css', __FILE__));
                    }

                    if ($ddpdm_css_ragnar == 'ragnar-blurbs-emma') {
                        wp_enqueue_style('ddp-ragnar-blurbs-emma', plugins_url('build/ragnar/css/ragnar-blog-1/ragnar-blurbs-emma.css', __FILE__));
                    }

                    if ($ddpdm_css_ragnar == 'ragnar-header-emil') {
                        wp_enqueue_style('ddp-ragnar-header-emil', plugins_url('build/ragnar/css/ragnar-shop-landing-v3/ragnar-header-emil.css', __FILE__));
                    }

                    if ($ddpdm_css_ragnar == 'ragnar-products-elias') {
                        wp_enqueue_style('ddp-ragnar-products-elias', plugins_url('build/ragnar/css/ragnar-shop-landing-v3/ragnar-products-elias.css', __FILE__));
                    }

                    if ($ddpdm_css_ragnar == 'ragnar-content-aksel') {
                        wp_enqueue_style('ddp-ragnar-content-aksel', plugins_url('build/ragnar/css/ragnar-shop-landing-v3/ragnar-content-aksel.css', __FILE__));
                    }

                    if ($ddpdm_css_ragnar == 'ragnar-blog-august') {
                        wp_enqueue_style('ddp-ragnar-blog-august', plugins_url('build/ragnar/css/ragnar-shop-landing-v3/ragnar-blog-august.css', __FILE__));
                    }

                    if ($ddpdm_css_ragnar == 'ragnar-header-gabriella') {
                        wp_enqueue_style('ddp-ragnar-header-gabriella', plugins_url('build/ragnar/css/ragnar-team-2/ragnar-header-gabriella.css', __FILE__));
                    }

                    if ($ddpdm_css_ragnar == 'ragnar-content-frideborg') {
                        wp_enqueue_style('ddp-ragnar-content-frideborg', plugins_url('build/ragnar/css/ragnar-team-2/ragnar-content-frideborg.css', __FILE__));
                    }

                    if ($ddpdm_css_ragnar == 'ragnar-person-fredek') {
                        wp_enqueue_style('ddp-ragnar-person-fredek', plugins_url('build/ragnar/css/ragnar-team-2/ragnar-person-fredek.css', __FILE__));
                    }

                    if ($ddpdm_css_ragnar == 'ragnar-blurbs-frans') {
                        wp_enqueue_style('ddp-ragnar-blurbs-frans', plugins_url('build/ragnar/css/ragnar-team-2/ragnar-blurbs-frans.css', __FILE__));
                    }

                    if ($ddpdm_css_ragnar == 'ragnar-cta-felix') {
                        wp_enqueue_style('ddp-ragnar-cta-felix', plugins_url('build/ragnar/css/ragnar-team-2/ragnar-cta-felix.css', __FILE__));
                    }

                    if ($ddpdm_css_ragnar == 'ragnar-post-v1') {
                        wp_enqueue_style('ddp-ragnar-post-v1', plugins_url('build/ragnar/css/ragnar-post-1/ragnar-post-v1.css', __FILE__));
                    }

                    if ($ddpdm_css_ragnar == 'ragnar-post-v2') {
                        wp_enqueue_style('ddp-ragnar-post-v2', plugins_url('build/ragnar/css/ragnar-post-2/ragnar-post-v2.css', __FILE__));
                    }

                    if ($ddpdm_css_ragnar == 'ragnar-gallery-erik') {
                        wp_enqueue_style('ddp-ragnar-gallery-erik', plugins_url('build/ragnar/css/ragnar-gallery-light/ragnar-gallery-erik.css', __FILE__));
                    }

                    if ($ddpdm_css_ragnar == 'ragnar-gallery-esbjorn') {
                        wp_enqueue_style('ddp-ragnar-gallery-esbjorn', plugins_url('build/ragnar/css/ragnar-gallery-light/ragnar-gallery-esbjorn.css', __FILE__));
                    }

                    if ($ddpdm_css_ragnar == 'ragnar-gallery-eskil') {
                        wp_enqueue_style('ddp-ragnar-gallery-eskil', plugins_url('build/ragnar/css/ragnar-gallery-light/ragnar-gallery-eskil.css', __FILE__));
                    }

                    if ($ddpdm_css_ragnar == 'ragnar-gallery-eva') {
                        wp_enqueue_style('ddp-ragnar-gallery-eva', plugins_url('build/ragnar/css/ragnar-gallery-light/ragnar-gallery-eva.css', __FILE__));
                    }

                    if ($ddpdm_css_ragnar == 'ragnar-gallery-evelina') {
                        wp_enqueue_style('ddp-ragnar-gallery-evelina', plugins_url('build/ragnar/css/ragnar-gallery-light/ragnar-gallery-evelina.css', __FILE__));
                    }

                    if ($ddpdm_css_ragnar == 'ragnar-gallery-evert') {
                        wp_enqueue_style('ddp-ragnar-gallery-evert', plugins_url('build/ragnar/css/ragnar-gallery-light/ragnar-gallery-evert.css', __FILE__));
                    }

                    if ($ddpdm_css_ragnar == 'ragnar-gallery-fabian') {
                        wp_enqueue_style('ddp-ragnar-gallery-fabian', plugins_url('build/ragnar/css/ragnar-gallery-light/ragnar-gallery-fabian.css', __FILE__));
                    }

                    if ($ddpdm_css_ragnar == 'ragnar-blog-olympus') {
                        wp_enqueue_style('ddp-ragnar-blog-olympus', plugins_url('build/ragnar/css/ragnar-blog-2/ragnar-blog-olympus.css', __FILE__));
                    }

                    if ($ddpdm_css_ragnar == 'ragnar-blurbs-oliver') {
                        wp_enqueue_style('ddp-ragnar-blurbs-oliver', plugins_url('build/ragnar/css/ragnar-blog-2/ragnar-blurbs-oliver.css', __FILE__));
                    }

                    if ($ddpdm_css_ragnar == 'ragnar-header-gorm') {
                        wp_enqueue_style('ddp-ragnar-header-gorm', plugins_url('build/ragnar/css/ragnar-shop-landing-v4/ragnar-header-gorm.css', __FILE__));
                    }

                    if ($ddpdm_css_ragnar == 'ragnar-products-benta') {
                        wp_enqueue_style('ddp-ragnar-products-benta', plugins_url('build/ragnar/css/ragnar-shop-landing-v4/ragnar-products-benta.css', __FILE__));
                    }

                    if ($ddpdm_css_ragnar == 'ragnar-content-gala') {
                        wp_enqueue_style('ddp-ragnar-content-gala', plugins_url('build/ragnar/css/ragnar-team-3/ragnar-content-gala.css', __FILE__));
                    }

                    if ($ddpdm_css_ragnar == 'ragnar-person-garth') {
                        wp_enqueue_style('ddp-ragnar-person-garth', plugins_url('build/ragnar/css/ragnar-team-3/ragnar-person-garth.css', __FILE__));
                    }
                
                    if ($ddpdm_css_ragnar == 'ragnar-content-malthe') {
                        wp_enqueue_style('ddp-ragnar-content-malthe', plugins_url('build/ragnar/css/ragnar-case-study-3/ragnar-content-malthe.css', __FILE__));
                    }
                   
                    if ($ddpdm_css_ragnar == 'ragnar-content-aarhus') {
                        wp_enqueue_style('ddp-ragnar-content-aarhus', plugins_url('build/ragnar/css/ragnar-case-study-3/ragnar-content-aarhus.css', __FILE__));
                    }
               
                    if ($ddpdm_css_ragnar == 'ragnar-content-victor') {
                        wp_enqueue_style('ddp-ragnar-content-victor', plugins_url('build/ragnar/css/ragnar-case-study-3/ragnar-content-victor.css', __FILE__));
                    }
               
                    if ($ddpdm_css_ragnar == 'ragnar-blurbs-annali') {
                        wp_enqueue_style('ddp-ragnar-blurbs-annali', plugins_url('build/ragnar/css/ragnar-faq-1/ragnar-blurbs-annali.css', __FILE__));
                    }
               
                    if ($ddpdm_css_ragnar == 'ragnar-header-arvid') {
                        wp_enqueue_style('ddp-ragnar-header-arvid', plugins_url('build/ragnar/css/ragnar-faq-1/ragnar-header-arvid.css', __FILE__));
                    }
               
                    if ($ddpdm_css_ragnar == 'ragnar-blurbs-beck') {
                        wp_enqueue_style('ddp-ragnar-blurbs-beck', plugins_url('build/ragnar/css/ragnar-faq-2/ragnar-blurbs-beck.css', __FILE__));
                    }
               
                    if ($ddpdm_css_ragnar == 'ragnar-header-baltasar') {
                        wp_enqueue_style('ddp-ragnar-header-baltasar', plugins_url('build/ragnar/css/ragnar-faq-2/ragnar-header-baltasar.css', __FILE__));
                    }
               
                    if ($ddpdm_css_ragnar == 'ragnar-blurbs-gerda') {
                        wp_enqueue_style('ddp-ragnar-blurbs-gerda', plugins_url('build/ragnar/css/ragnar-team-4/ragnar-blurbs-gerda.css', __FILE__));
                    }
               
                    if ($ddpdm_css_ragnar == 'ragnar-blurbs-gilla') {
                        wp_enqueue_style('ddp-ragnar-blurbs-gilla', plugins_url('build/ragnar/css/ragnar-team-4/ragnar-blurbs-gilla.css', __FILE__));
                    }
               
                    if ($ddpdm_css_ragnar == 'ragnar-content-goran') {
                        wp_enqueue_style('ddp-ragnar-content-goran', plugins_url('build/ragnar/css/ragnar-team-4/ragnar-content-goran.css', __FILE__));
                    }
               
                    if ($ddpdm_css_ragnar == 'ragnar-header-gota') {
                        wp_enqueue_style('ddp-ragnar-header-gota', plugins_url('build/ragnar/css/ragnar-team-4/ragnar-header-gota.css', __FILE__));
                    }
               
                    if ($ddpdm_css_ragnar == 'ragnar-header-gota') {
                        wp_enqueue_style('ddp-ragnar-header-gota', plugins_url('build/ragnar/css/ragnar-team-4/ragnar-header-gota.css', __FILE__));
                    }
               
                    if ($ddpdm_css_ragnar == 'ragnar-person-greger') {
                        wp_enqueue_style('ddp-ragnar-person-greger', plugins_url('build/ragnar/css/ragnar-team-4/ragnar-person-greger.css', __FILE__));
                    }
               
                    if ($ddpdm_css_ragnar == 'ragnar-blog-hadrian') {
                        wp_enqueue_style('ddp-ragnar-blog-hadrian', plugins_url('build/ragnar/css/ragnar-team-5/ragnar-blog-hadrian.css', __FILE__));
                    }
               
                    if ($ddpdm_css_ragnar == 'ragnar-content-gus') {
                        wp_enqueue_style('ddp-ragnar-content-gus', plugins_url('build/ragnar/css/ragnar-team-5/ragnar-content-gus.css', __FILE__));
                    }
               
                    if ($ddpdm_css_ragnar == 'ragnar-header-gudrun') {
                        wp_enqueue_style('ddp-ragnar-header-gudrun', plugins_url('build/ragnar/css/ragnar-team-5/ragnar-header-gudrun.css', __FILE__));
                    }
               
                    if ($ddpdm_css_ragnar == 'ragnar-person-gunnef') {
                        wp_enqueue_style('ddp-ragnar-person-gunnef', plugins_url('build/ragnar/css/ragnar-team-5/ragnar-person-gunnef.css', __FILE__));
                    }
               
                    if ($ddpdm_css_ragnar == 'ragnar-blurbs-jenny') {
                        wp_enqueue_style('ddp-ragnar-blurbs-jenny', plugins_url('build/ragnar/css/ragnar-service-1/ragnar-blurbs-jenny.css', __FILE__));
                    }
                    if ($ddpdm_css_ragnar == 'ragnar-content-berit') {
                        wp_enqueue_style('ddp-ragnar-content-berit', plugins_url('build/ragnar/css/ragnar-service-1/ragnar-content-berit.css', __FILE__));
                    }
                    if ($ddpdm_css_ragnar == 'ragnar-header-olof') {
                        wp_enqueue_style('ddp-ragnar-header-olof', plugins_url('build/ragnar/css/ragnar-service-1/ragnar-header-olof.css', __FILE__));
                    }
                    if ($ddpdm_css_ragnar == 'ragnar-tabs-gun') {
                        wp_enqueue_style('ddp-ragnar-tabs-gun', plugins_url('build/ragnar/css/ragnar-service-1/ragnar-tabs-gun.css', __FILE__));
                    }
               
                    if ($ddpdm_css_ragnar == 'ragnar-blurbs-maj') {
                        wp_enqueue_style('ddp-ragnar-blurbs-maj', plugins_url('build/ragnar/css/ragnar-service-2/ragnar-blurbs-maj.css', __FILE__));
                    }
                    if ($ddpdm_css_ragnar == 'ragnar-content-plus') {
                        wp_enqueue_style('ddp-ragnar-content-plus', plugins_url('build/ragnar/css/ragnar-service-2/ragnar-content-plus.css', __FILE__));
                    }
                    if ($ddpdm_css_ragnar == 'ragnar-content-reidar') {
                        wp_enqueue_style('ddp-ragnar-content-reidar', plugins_url('build/ragnar/css/ragnar-service-2/ragnar-content-reidar.css', __FILE__));
                    }
                    if ($ddpdm_css_ragnar == 'ragnar-person-rode') {
                        wp_enqueue_style('ddp-ragnar-person-rode', plugins_url('build/ragnar/css/ragnar-service-2/ragnar-person-rode.css', __FILE__));
                    }
                    if ($ddpdm_css_ragnar == 'ragnar-projects-ole') {
                        wp_enqueue_style('ddp-ragnar-projects-ole', plugins_url('build/ragnar/css/ragnar-service-2/ragnar-projects-ole.css', __FILE__));
                    }
               
                    if ($ddpdm_css_ragnar == 'ragnar-blurbs-bure') {
                        wp_enqueue_style('ddp-ragnar-blurbs-bure', plugins_url('build/ragnar/css/ragnar-service-3/ragnar-blurbs-bure.css', __FILE__));
                    }
                    if ($ddpdm_css_ragnar == 'ragnar-content-bigge') {
                        wp_enqueue_style('ddp-ragnar-content-bigge', plugins_url('build/ragnar/css/ragnar-service-3/ragnar-content-bigge.css', __FILE__));
                    }
                    if ($ddpdm_css_ragnar == 'ragnar-header-jesaja') {
                        wp_enqueue_style('ddp-ragnar-header-jesaja', plugins_url('build/ragnar/css/ragnar-service-3/ragnar-header-jesaja.css', __FILE__));
                    }
               
                    if ($ddpdm_css_ragnar == 'ragnar-blog-isac') {
                        wp_enqueue_style('ddp-ragnar-blog-isac', plugins_url('build/ragnar/css/ragnar-service-4/ragnar-blog-isac.css', __FILE__));
                    }
                    if ($ddpdm_css_ragnar == 'ragnar-blurbs-gullbrand') {
                        wp_enqueue_style('ddp-ragnar-blurbs-gullbrand', plugins_url('build/ragnar/css/ragnar-service-4/ragnar-blurbs-gullbrand.css', __FILE__));
                    }
                    if ($ddpdm_css_ragnar == 'ragnar-content-jean') {
                        wp_enqueue_style('ddp-ragnar-content-jean', plugins_url('build/ragnar/css/ragnar-service-4/ragnar-content-jean.css', __FILE__));
                    }
                    if ($ddpdm_css_ragnar == 'ragnar-header-lek') {
                        wp_enqueue_style('ddp-ragnar-header-lek', plugins_url('build/ragnar/css/ragnar-service-4/ragnar-header-lek.css', __FILE__));
                    }
                    if ($ddpdm_css_ragnar == 'ragnar-person-heimer') {
                        wp_enqueue_style('ddp-ragnar-person-heimer', plugins_url('build/ragnar/css/ragnar-service-4/ragnar-person-heimer.css', __FILE__));
                    }
               
                    //October
                    if ($ddpdm_css_ragnar == 'ragnar-header-trustworthy') {
                        wp_enqueue_style('ddp-ragnar-header-trustworthy', plugins_url('build/ragnar/css/ragnar-home-7/ragnar-header-trustworthy.css', __FILE__));
                    }
                    if ($ddpdm_css_ragnar == 'ragnar-content-trygve') {
                        wp_enqueue_style('ddp-ragnar-content-trygve', plugins_url('build/ragnar/css/ragnar-home-7/ragnar-content-trygve.css', __FILE__));
                    }
                    if ($ddpdm_css_ragnar == 'ragnar-blurbs-torsten') {
                        wp_enqueue_style('ddp-ragnar-blurbs-torsten', plugins_url('build/ragnar/css/ragnar-home-7/ragnar-blurbs-torsten.css', __FILE__));
                    }
                    if ($ddpdm_css_ragnar == 'ragnar-content-nilsson') {
                        wp_enqueue_style('ddp-ragnar-content-nilsson', plugins_url('build/ragnar/css/ragnar-home-7/ragnar-content-nilsson.css', __FILE__));
                    }
                    if ($ddpdm_css_ragnar == 'ragnar-content-toke') {
                        wp_enqueue_style('ddp-ragnar-content-toke', plugins_url('build/ragnar/css/ragnar-home-7/ragnar-content-toke.css', __FILE__));
                    }
                    if ($ddpdm_css_ragnar == 'ragnar-testimonial-stone') {
                        wp_enqueue_style('ddp-ragnar-testimonial-stone', plugins_url('build/ragnar/css/ragnar-home-7/ragnar-testimonial-stone.css', __FILE__));
                    }
                    if ($ddpdm_css_ragnar == 'ragnar-content-thors') {
                        wp_enqueue_style('ddp-ragnar-content-thors', plugins_url('build/ragnar/css/ragnar-home-7/ragnar-content-thors.css', __FILE__));
                    }
                    if ($ddpdm_css_ragnar == 'ragnar-footer-troels') {
                        wp_enqueue_style('ddp-ragnar-footer-troels', plugins_url('build/ragnar/css/ragnar-home-7/ragnar-footer-troels.css', __FILE__));
                    }
               
                    if ($ddpdm_css_ragnar == 'ragnar-header-kurt') {
                        wp_enqueue_style('ddp-ragnar-header-kurt', plugins_url('build/ragnar/css/ragnar-architecture/ragnar-header-kurt.css', __FILE__));
                    }
                    if ($ddpdm_css_ragnar == 'ragnar-content-caseper') {
                        wp_enqueue_style('ddp-ragnar-content-caseper', plugins_url('build/ragnar/css/ragnar-architecture/ragnar-content-caseper.css', __FILE__));
                    }
                    if ($ddpdm_css_ragnar == 'ragnar-blurbs-rut') {
                        wp_enqueue_style('ddp-ragnar-blurbs-rut', plugins_url('build/ragnar/css/ragnar-architecture/ragnar-blurbs-rut.css', __FILE__));
                    }
                    if ($ddpdm_css_ragnar == 'ragnar-content-ulf') {
                        wp_enqueue_style('ddp-ragnar-content-ulf', plugins_url('build/ragnar/css/ragnar-architecture/ragnar-content-ulf.css', __FILE__));
                    }
               
                    if ($ddpdm_css_ragnar == 'ragnar-header-search') {
                        wp_enqueue_style('ddp-ragnar-header-search', plugins_url('build/ragnar/css/ragnar-faq-3/ragnar-header-search.css', __FILE__));
                    }
                    if ($ddpdm_css_ragnar == 'ragnar-blurbs-blix') {
                        wp_enqueue_style('ddp-ragnar-blurbs-blix', plugins_url('build/ragnar/css/ragnar-faq-3/ragnar-blurbs-blix.css', __FILE__));
                    }
                    if ($ddpdm_css_ragnar == 'ragnar-tabs-berit') {
                        wp_enqueue_style('ddp-ragnar-tabs-berit', plugins_url('build/ragnar/css/ragnar-faq-3/ragnar-tabs-berit.css', __FILE__));
                    }
               
                    if ($ddpdm_css_ragnar == 'ragnar-header-bo') {
                        wp_enqueue_style('ddp-ragnar-header-bo', plugins_url('build/ragnar/css/ragnar-faq-4/ragnar-header-bo.css', __FILE__));
                    }
                    if ($ddpdm_css_ragnar == 'ragnar-tabs-carine') {
                        wp_enqueue_style('ddp-ragnar-tabs-carine', plugins_url('build/ragnar/css/ragnar-faq-4/ragnar-tabs-carine.css', __FILE__));
                    }
                    if ($ddpdm_css_ragnar == 'ragnar-blurbs-brigetta') {
                        wp_enqueue_style('ddp-ragnar-blurbs-brigetta', plugins_url('build/ragnar/css/ragnar-faq-4/ragnar-blurbs-brigetta.css', __FILE__));
                    }
                }
            }
            // Ragnar ends
            
            //Grace Starts
            foreach ((array) get_post_meta($post->ID, 'ddp-css-grace') as $ddp_css_grace) {
                   
                if ($ddp_css_grace == 'grace-timeline-adhara') {
                    wp_enqueue_style('grace-timeline-adhara', plugins_url('build/grace/css/timeline/grace-timeline-adhara.css', __FILE__));
                } 
                if ($ddp_css_grace == 'grace-timeline-alpha') {
                    wp_enqueue_style('grace-timeline-alpha', plugins_url('build/grace/css/timeline/grace-timeline-alpha.css', __FILE__));
                }
                if ($ddp_css_grace == 'grace-timeline-alula') {
                    wp_enqueue_style('grace-timeline-alula', plugins_url('build/grace/css/timeline/grace-timeline-alula.css', __FILE__));
                } 
                if ($ddp_css_grace == 'grace-timeline-amalthea') {
                    wp_enqueue_style('grace-timeline-slider-amalthea', plugins_url('build/grace/css/timeline/grace-timeline-amalthea.css', __FILE__));
                } 
                if ($ddp_css_grace == 'grace-timeline-andromeda') {
                    wp_enqueue_style('grace-timeline-andromeda', plugins_url('build/grace/css/timeline/grace-timeline-andromeda.css', __FILE__));
                } 

                if ($ddp_css_grace == 'grace-gallery-ascella') {
                    wp_enqueue_style('grace-gallery-ascella', plugins_url('build/grace/css/gallery/grace-gallery-ascella.css', __FILE__));
                } 
                if ($ddp_css_grace == 'grace-gallery-asterope') {
                    wp_enqueue_style('grace-gallery-asterope', plugins_url('build/grace/css/gallery/grace-gallery-asterope.css', __FILE__));
                } 
                if ($ddp_css_grace == 'grace-gallery-astra') {
                    wp_enqueue_style('grace-gallery-astra', plugins_url('build/grace/css/gallery/grace-gallery-astra.css', __FILE__));
                }
                if ($ddp_css_grace == 'grace-gallery-aurora') {
                    wp_enqueue_style('grace-gallery-aurora', plugins_url('build/grace/css/gallery/grace-gallery-aurora.css', __FILE__));
                } 
                if ($ddp_css_grace == 'grace-gallery-capella') {
                    wp_enqueue_style('grace-gallery-capella', plugins_url('build/grace/css/gallery/grace-gallery-capella.css', __FILE__));
                }
                if ($ddp_css_grace == 'grace-gallery-cassiopea') {
                    wp_enqueue_style('grace-gallery-cassiopea', plugins_url('build/grace/css/gallery/grace-gallery-cassiopea.css', __FILE__));
                } 
                if ($ddp_css_grace == 'grace-gallery-celestial') {
                    wp_enqueue_style('grace-gallery-celestial', plugins_url('build/grace/css/gallery/grace-gallery-celestial.css', __FILE__));
                } 
                if ($ddp_css_grace == 'grace-gallery-halley') {
                    wp_enqueue_style('grace-gallery-halley', plugins_url('build/grace/css/gallery/grace-gallery-halley.css', __FILE__));
                } 
                if ($ddp_css_grace == 'grace-gallery-libra') {
                    wp_enqueue_style('grace-gallery-libra', plugins_url('build/grace/css/gallery/grace-gallery-libra.css', __FILE__));
                } 
                if ($ddp_css_grace == 'grace-gallery-luna') {
                    wp_enqueue_style('grace-gallery-luna', plugins_url('build/grace/css/gallery/grace-gallery-luna.css', __FILE__));
                } 
                if ($ddp_css_grace == 'grace-gallery-lyra') {
                    wp_enqueue_style('grace-gallery-lyra', plugins_url('build/grace/css/gallery/grace-gallery-lyra.css', __FILE__));
                } 
                if ($ddp_css_grace == 'grace-gallery-nashira') {
                    wp_enqueue_style('grace-gallery-nashira', plugins_url('build/grace/css/gallery/grace-gallery-nashira.css', __FILE__));
                } 
                if ($ddp_css_grace == 'grace-gallery-norma') {
                    wp_enqueue_style('grace-gallery-norma', plugins_url('build/grace/css/gallery/grace-gallery-norma.css', __FILE__));
                } 
                if ($ddp_css_grace == 'grace-gallery-polaris') {
                    wp_enqueue_style('grace-gallery-polaris', plugins_url('build/grace/css/gallery/grace-gallery-polaris.css', __FILE__));
                } 

                if ($ddp_css_grace == 'grace-person-menkalinan') {
                    wp_enqueue_style('grace-person-menkalinan', plugins_url('build/grace/css/persons/grace-person-menkalinan.css', __FILE__));
                } 
                if ($ddp_css_grace == 'grace-person-parking') {
                    wp_enqueue_style('grace-person-parking', plugins_url('build/grace/css/persons/grace-person-parking.css', __FILE__));
                } 
                if ($ddp_css_grace == 'grace-person-parking-v2') {
                    wp_enqueue_style('grace-person-parking-v2', plugins_url('build/grace/css/persons/grace-person-parking-v2.css', __FILE__));
                } 
                if ($ddp_css_grace == 'grace-person-miens') {
                    wp_enqueue_style('grace-person-miens', plugins_url('build/grace/css/persons/grace-person-miens.css', __FILE__));
                } 
                if ($ddp_css_grace == 'grace-person-phoenix') {
                    wp_enqueue_style('grace-person-phoenix', plugins_url('build/grace/css/persons/grace-person-phoenix.css', __FILE__));
                } 
                if ($ddp_css_grace == 'grace-person-pluto') {
                    wp_enqueue_style('grace-person-pluto', plugins_url('build/grace/css/persons/grace-person-pluto.css', __FILE__));
                } 
                if ($ddp_css_grace == 'grace-person-perseus') {
                    wp_enqueue_style('grace-person-perseus', plugins_url('build/grace/css/persons/grace-person-perseus.css', __FILE__));
                } 
                if ($ddp_css_grace == 'grace-person-cassini') {
                    wp_enqueue_style('grace-person-cassini', plugins_url('build/grace/css/persons/grace-person-cassini.css', __FILE__));
                } 
                if ($ddp_css_grace == 'grace-person-carina') {
                    wp_enqueue_style('grace-person-carina', plugins_url('build/grace/css/persons/grace-person-carina.css', __FILE__));
                } 
                if ($ddp_css_grace == 'grace-person-belinda') {
                    wp_enqueue_style('grace-person-belinda', plugins_url('build/grace/css/persons/grace-person-belinda.css', __FILE__));
                } 
                if ($ddp_css_grace == 'grace-person-arpina') {
                    wp_enqueue_style('grace-person-arpina', plugins_url('build/grace/css/persons/grace-person-arpina.css', __FILE__));
                } 
                if ($ddp_css_grace == 'grace-person-taurus') {
                    wp_enqueue_style('grace-person-taurus', plugins_url('build/grace/css/persons/grace-person-taurus.css', __FILE__));
                } 
                if ($ddp_css_grace == 'grace-person-sirius') {
                    wp_enqueue_style('grace-person-sirius', plugins_url('build/grace/css/persons/grace-person-sirius.css', __FILE__));
                } 
                if ($ddp_css_grace == 'grace-person-orion') {
                    wp_enqueue_style('grace-person-orion', plugins_url('build/grace/css/persons/grace-person-orion.css', __FILE__));
                } 
                if ($ddp_css_grace == 'grace-person-nova') {
                    wp_enqueue_style('grace-person-nova', plugins_url('build/grace/css/persons/grace-person-nova.css', __FILE__));
                } 
                if ($ddp_css_grace == 'grace-person-saturn') {
                    wp_enqueue_style('grace-person-saturn', plugins_url('build/grace/css/persons/grace-person-saturn.css', __FILE__));
                } 
                if ($ddp_css_grace == 'grace-person-apollo') {
                    wp_enqueue_style('grace-person-apollo', plugins_url('build/grace/css/persons/grace-person-apollo.css', __FILE__));
                } 

                if ($ddp_css_grace == 'grace-blurbs-apollo') {
                    wp_enqueue_style('grace-blurbs-apollo', plugins_url('build/grace/css/blurbs/grace-blurbs-apollo.css', __FILE__));
                } 
                if ($ddp_css_grace == 'grace-blurbs-archer') {
                    wp_enqueue_style('grace-blurbs-archer', plugins_url('build/grace/css/blurbs/grace-blurbs-archer.css', __FILE__));
                } 
                if ($ddp_css_grace == 'grace-blurbs-aries') {
                    wp_enqueue_style('grace-blurbs-aries', plugins_url('build/grace/css/blurbs/grace-blurbs-aries.css', __FILE__));
                } 
                if ($ddp_css_grace == 'grace-blurbs-aster') {
                    wp_enqueue_style('grace-blurbs-aster', plugins_url('build/grace/css/blurbs/grace-blurbs-aster.css', __FILE__));
                } 
                if ($ddp_css_grace == 'grace-blurbs-atlas') {
                    wp_enqueue_style('grace-blurbs-atlas', plugins_url('build/grace/css/blurbs/grace-blurbs-atlas.css', __FILE__));
                } 
                if ($ddp_css_grace == 'grace-blurbs-columba') {
                    wp_enqueue_style('grace-blurbs-columba', plugins_url('build/grace/css/blurbs/grace-blurbs-columba.css', __FILE__));
                } 
                if ($ddp_css_grace == 'grace-blurbs-cosmos') {
                    wp_enqueue_style('grace-blurbs-cosmos', plugins_url('build/grace/css/blurbs/grace-blurbs-cosmos.css', __FILE__));
                } 
                if ($ddp_css_grace == 'grace-blurbs-danica') {
                    wp_enqueue_style('grace-blurbs-danica', plugins_url('build/grace/css/blurbs/grace-blurbs-danica.css', __FILE__));
                } 
                if ($ddp_css_grace == 'grace-blurbs-areglo') {
                    wp_enqueue_style('grace-blurbs-areglo', plugins_url('build/grace/css/blurbs/grace-blurbs-areglo.css', __FILE__));
                } 
                if ($ddp_css_grace == 'grace-blurbs-stella') {
                    wp_enqueue_style('grace-blurbs-stella', plugins_url('build/grace/css/blurbs/grace-blurbs-stella.css', __FILE__));
                } 
                if ($ddp_css_grace == 'grace-blurbs-pherkad') {
                    wp_enqueue_style('grace-blurbs-pherkad', plugins_url('build/grace/css/blurbs/grace-blurbs-pherkad.css', __FILE__));
                } 
                if ($ddp_css_grace == 'grace-blurbs-marfak') {
                    wp_enqueue_style('grace-blurbs-marfak', plugins_url('build/grace/css/blurbs/grace-blurbs-marfak.css', __FILE__));
                } 
                if ($ddp_css_grace == 'grace-blurbs-albaldah') {
                    wp_enqueue_style('grace-blurbs-albaldah', plugins_url('build/grace/css/blurbs/grace-blurbs-albaldah.css', __FILE__));
                } 
                if ($ddp_css_grace == 'grace-blurbs-furud') {
                    wp_enqueue_style('grace-blurbs-furud', plugins_url('build/grace/css/blurbs/grace-blurbs-furud.css', __FILE__));
                } 
                if ($ddp_css_grace == 'grace-blurbs-alfirk') {
                    wp_enqueue_style('grace-blurbs-alfirk', plugins_url('build/grace/css/blurbs/grace-blurbs-alfirk.css', __FILE__));
                } 
                if ($ddp_css_grace == 'grace-blurbs-phaet') {
                    wp_enqueue_style('grace-blurbs-phaet', plugins_url('build/grace/css/blurbs/grace-blurbs-phaet.css', __FILE__));
                } 
                if ($ddp_css_grace == 'grace-blurbs-kitalpha') {
                    wp_enqueue_style('grace-blurbs-kitalpha', plugins_url('build/grace/css/blurbs/grace-blurbs-kitalpha.css', __FILE__));
                } 
                if ($ddp_css_grace == 'grace-blurbs-diadem') {
                    wp_enqueue_style('grace-blurbs-diadem', plugins_url('build/grace/css/blurbs/grace-blurbs-diadem.css', __FILE__));
                } 
                if ($ddp_css_grace == 'grace-blurbs-diadem-v2') {
                    wp_enqueue_style('grace-blurbs-diadem-v2', plugins_url('build/grace/css/blurbs/grace-blurbs-diadem-v2.css', __FILE__));
                } 
                if ($ddp_css_grace == 'grace-blurbs-yeux') {
                    wp_enqueue_style('grace-blurbs-yeux', plugins_url('build/grace/css/blurbs/grace-blurbs-yeux.css', __FILE__));
                } 
                if ($ddp_css_grace == 'grace-blurbs-strange') {
                    wp_enqueue_style('grace-blurbs-strange', plugins_url('build/grace/css/blurbs/grace-blurbs-strange.css', __FILE__));
                } 
                if ($ddp_css_grace == 'grace-blurbs-bouche') {
                    wp_enqueue_style('grace-blurbs-bouche', plugins_url('build/grace/css/blurbs/grace-blurbs-bouche.css', __FILE__));
                } 
                if ($ddp_css_grace == 'grace-blurbs-prends') {
                    wp_enqueue_style('grace-blurbs-prends', plugins_url('build/grace/css/blurbs/grace-blurbs-prends.css', __FILE__));
                } 
                if ($ddp_css_grace == 'grace-blurbs-bonheur') {
                    wp_enqueue_style('grace-blurbs-bonheur', plugins_url('build/grace/css/blurbs/grace-blurbs-bonheur.css', __FILE__));
                } 
                if ($ddp_css_grace == 'grace-blurbs-boulevard') {
                    wp_enqueue_style('grace-blurbs-boulevard', plugins_url('build/grace/css/blurbs/grace-blurbs-boulevard.css', __FILE__));
                } 
                if ($ddp_css_grace == 'grace-blurbs-castor') {
                    wp_enqueue_style('grace-blurbs-castor', plugins_url('build/grace/css/blurbs/grace-blurbs-castor.css', __FILE__));
                } 
                if ($ddp_css_grace == 'grace-blurbs-blow') {
                    wp_enqueue_style('grace-blurbs-blow', plugins_url('build/grace/css/blurbs/grace-blurbs-blow.css', __FILE__));
                } 
                if ($ddp_css_grace == 'grace-blurbs-kamaria') {
                    wp_enqueue_style('grace-blurbs-kamaria', plugins_url('build/grace/css/blurbs/grace-blurbs-kamaria.css', __FILE__));
                } 
                if ($ddp_css_grace == 'grace-blurbs-straighten') {
                    wp_enqueue_style('grace-blurbs-straighten', plugins_url('build/grace/css/blurbs/grace-blurbs-straighten.css', __FILE__));
                } 
                if ($ddp_css_grace == 'grace-blurbs-adhafera') {
                    wp_enqueue_style('grace-blurbs-adhafera', plugins_url('build/grace/css/blurbs/grace-blurbs-adhafera.css', __FILE__));
                } 

                if ($ddp_css_grace == 'grace-blog-limousine') {
                    wp_enqueue_style('grace-blog-limousine', plugins_url('build/grace/css/blogs/grace-blog-limousine.css', __FILE__));
                } 
                if ($ddp_css_grace == 'grace-blog-hassaleh') {
                    wp_enqueue_style('grace-blog-hassaleh', plugins_url('build/grace/css/blogs/grace-blog-hassaleh.css', __FILE__));
                } 
                if ($ddp_css_grace == 'grace-blog-mon') {
                    wp_enqueue_style('grace-blog-mon', plugins_url('build/grace/css/blogs/grace-blog-mon.css', __FILE__));
                } 
                if ($ddp_css_grace == 'grace-blog-mon-v2') {
                    wp_enqueue_style('grace-blog-mon-v2', plugins_url('build/grace/css/blogs/grace-blog-mon-v2.css', __FILE__));
                } 
                if ($ddp_css_grace == 'grace-blog-comet') {
                    wp_enqueue_style('grace-blog-comet', plugins_url('build/grace/css/blogs/grace-blog-comet.css', __FILE__));
                } 
                if ($ddp_css_grace == 'grace-blog-draco') {
                    wp_enqueue_style('grace-blog-draco', plugins_url('build/grace/css/blogs/grace-blog-draco.css', __FILE__));
                } 
                if ($ddp_css_grace == 'grace-blog-donati') {
                    wp_enqueue_style('grace-blog-donati', plugins_url('build/grace/css/blogs/grace-blog-donati.css', __FILE__));
                } 
                if ($ddp_css_grace == 'grace-blog-cupid') {
                    wp_enqueue_style('grace-blog-cupid', plugins_url('build/grace/css/blogs/grace-blog-cupid.css', __FILE__));
                } 
                if ($ddp_css_grace == 'grace-blog-elio') {
                    wp_enqueue_style('grace-blog-elio', plugins_url('build/grace/css/blogs/grace-blog-elio.css', __FILE__));
                } 
                if ($ddp_css_grace == 'grace-blog-finaly') {
                    wp_enqueue_style('grace-blog-finaly', plugins_url('build/grace/css/blogs/grace-blog-finaly.css', __FILE__));
                } 
                if ($ddp_css_grace == 'grace-blog-sol') {
                    wp_enqueue_style('grace-blog-sol', plugins_url('build/grace/css/blogs/grace-blog-sol.css', __FILE__));
                }
                if ($ddp_css_grace == 'grace-blog-between') {
                    wp_enqueue_style('grace-blog-between', plugins_url('build/grace/css/blogs/grace-blog-between.css', __FILE__));
                } 
                if ($ddp_css_grace == 'grace-blog-sol') {
                    wp_enqueue_style('grace-blog-sol', plugins_url('build/grace/css/blogs/grace-blog-sol.css', __FILE__));
                } 
                if ($ddp_css_grace == 'grace-blog-luna') {
                    wp_enqueue_style('grace-blog-luna', plugins_url('build/grace/css/blogs/grace-blog-luna.css', __FILE__));
                } 

                if ($ddp_css_grace == 'grace-slider-aladfar') {
                    wp_enqueue_style('grace-slider-aladfar', plugins_url('build/grace/css/sliders/grace-slider-aladfar.css', __FILE__));
                } 
                if ($ddp_css_grace == 'grace-slider-beid') {
                    wp_enqueue_style('grace-slider-beid', plugins_url('build/grace/css/sliders/grace-slider-beid.css', __FILE__));
                } 
                if ($ddp_css_grace == 'grace-slider-beid-v2') {
                    wp_enqueue_style('grace-slider-beid-v2', plugins_url('build/grace/css/sliders/grace-slider-beid-v2.css', __FILE__));
                } 
                if ($ddp_css_grace == 'grace-slider-kraz') {
                    wp_enqueue_style('grace-slider-kraz', plugins_url('build/grace/css/sliders/grace-slider-kraz.css', __FILE__));
                } 
                if ($ddp_css_grace == 'grace-slider-merope') {
                    wp_enqueue_style('grace-slider-merope', plugins_url('build/grace/css/sliders/grace-slider-merope.css', __FILE__));
                } 
                if ($ddp_css_grace == 'grace-slider-merga') {
                    wp_enqueue_style('grace-slider-merga', plugins_url('build/grace/css/sliders/grace-slider-merga.css', __FILE__));
                } 
                if ($ddp_css_grace == 'grace-slider-merga-v2') {
                    wp_enqueue_style('grace-slider-merga-v2', plugins_url('build/grace/css/sliders/grace-slider-merga-v2.css', __FILE__));
                } 
                if ($ddp_css_grace == 'grace-slider-merga-v3') {
                    wp_enqueue_style('grace-slider-merga-v3', plugins_url('build/grace/css/sliders/grace-slider-merga-v3.css', __FILE__));
                } 
                if ($ddp_css_grace == 'grace-slider-merga-v4') {
                    wp_enqueue_style('grace-slider-merga-v4', plugins_url('build/grace/css/sliders/grace-slider-merga-v4.css', __FILE__));
                } 
                if ($ddp_css_grace == 'grace-slider-merga-v5') {
                    wp_enqueue_style('grace-slider-merga-v5', plugins_url('build/grace/css/sliders/grace-slider-merga-v5.css', __FILE__));
                } 

                if ($ddp_css_grace == 'grace-header-elara') {
                    wp_enqueue_style('grace-header-elara', plugins_url('build/grace/css/headers/grace-header-elara.css', __FILE__));
                } 
                if ($ddp_css_grace == 'grace-header-hilda') {
                    wp_enqueue_style('grace-header-hilda', plugins_url('build/grace/css/headers/grace-header-hilda.css', __FILE__));
                } 
                if ($ddp_css_grace == 'grace-header-helena') {
                    wp_enqueue_style('grace-header-helena', plugins_url('build/grace/css/headers/grace-header-helena.css', __FILE__));
                } 
                if ($ddp_css_grace == 'grace-header-gemini') {
                    wp_enqueue_style('grace-header-gemini', plugins_url('build/grace/css/headers/grace-header-gemini.css', __FILE__));
                } 
                if ($ddp_css_grace == 'grace-header-galatea') {
                    wp_enqueue_style('grace-header-galatea', plugins_url('build/grace/css/headers/grace-header-galatea.css', __FILE__));
                } 
                if ($ddp_css_grace == 'grace-header-flora') {
                    wp_enqueue_style('grace-header-flora', plugins_url('build/grace/css/headers/grace-header-flora.css', __FILE__));
                } 
                if ($ddp_css_grace == 'grace-header-faye') {
                    wp_enqueue_style('grace-header-faye', plugins_url('build/grace/css/headers/grace-header-faye.css', __FILE__));
                } 
                if ($ddp_css_grace == 'grace-header-electra') {
                    wp_enqueue_style('grace-header-electra', plugins_url('build/grace/css/headers/grace-header-electra.css', __FILE__));
                } 
                if ($ddp_css_grace == 'grace-header-kuma') {
                    wp_enqueue_style('grace-header-kuma', plugins_url('build/grace/css/headers/grace-header-kuma.css', __FILE__));
                } 
                if ($ddp_css_grace == 'grace-header-maia') {
                    wp_enqueue_style('grace-header-maia', plugins_url('build/grace/css/headers/grace-header-maia.css', __FILE__));
                } 
                if ($ddp_css_grace == 'grace-header-alathfar') {
                    wp_enqueue_style('grace-header-alathfar', plugins_url('build/grace/css/headers/grace-header-alathfar.css', __FILE__));
                } 
                if ($ddp_css_grace == 'grace-header-yildun') {
                    wp_enqueue_style('grace-header-yildun', plugins_url('build/grace/css/headers/grace-header-yildun.css', __FILE__));
                } 
                if ($ddp_css_grace == 'grace-header-alterf') {
                    wp_enqueue_style('grace-header-alterf', plugins_url('build/grace/css/headers/grace-header-alterf.css', __FILE__));
                } 
                if ($ddp_css_grace == 'grace-header-ariel') {
                    wp_enqueue_style('grace-header-ariel', plugins_url('build/grace/css/headers/grace-header-ariel.css', __FILE__));
                } 
                if ($ddp_css_grace == 'grace-header-aquarius') {
                    wp_enqueue_style('grace-header-aquarius', plugins_url('build/grace/css/headers/grace-header-aquarius.css', __FILE__));
                } 
                if ($ddp_css_grace == 'grace-header-capella') {
                    wp_enqueue_style('grace-header-capella', plugins_url('build/grace/css/headers/grace-header-capella.css', __FILE__));
                } 
                if ($ddp_css_grace == 'grace-header-quand') {
                    wp_enqueue_style('grace-header-quand', plugins_url('build/grace/css/headers/grace-header-quand.css', __FILE__));
                } 
                if ($ddp_css_grace == 'grace-header-zosma') {
                    wp_enqueue_style('grace-header-zosma', plugins_url('build/grace/css/headers/grace-header-zosma.css', __FILE__));
                } 
                if ($ddp_css_grace == 'grace-header-cressida') {
                    wp_enqueue_style('grace-header-cressida', plugins_url('build/grace/css/headers/grace-header-cressida.css', __FILE__));
                } 
                if ($ddp_css_grace == 'grace-header-zenith') {
                    wp_enqueue_style('grace-header-zenith', plugins_url('build/grace/css/headers/grace-header-zenith.css', __FILE__));
                } 
                if ($ddp_css_grace == 'grace-header-homam') {
                    wp_enqueue_style('grace-header-homam', plugins_url('build/grace/css/headers/grace-header-homam.css', __FILE__));
                } 
                if ($ddp_css_grace == 'grace-header-bellatrix') {
                    wp_enqueue_style('grace-header-bellatrix', plugins_url('build/grace/css/headers/grace-header-bellatrix.css', __FILE__));
                } 
                if ($ddp_css_grace == 'grace-header-sabik') {
                    wp_enqueue_style('grace-header-sabik', plugins_url('build/grace/css/headers/grace-header-sabik.css', __FILE__));
                } 
                if ($ddp_css_grace == 'grace-header-hoshi') {
                    wp_enqueue_style('grace-header-hoshi', plugins_url('build/grace/css/headers/grace-header-hoshi.css', __FILE__));
                } 
                if ($ddp_css_grace == 'grace-header-abraxas') {
                    wp_enqueue_style('grace-header-abraxas', plugins_url('build/grace/css/headers/grace-header-abraxas.css', __FILE__));
                } 
                if ($ddp_css_grace == 'grace-header-atlas') {
                    wp_enqueue_style('grace-header-atlas', plugins_url('build/grace/css/headers/grace-header-atlas.css', __FILE__));
                } 
                if ($ddp_css_grace == 'grace-header-eryx') {
                    wp_enqueue_style('grace-header-eryx', plugins_url('build/grace/css/headers/grace-header-eryx.css', __FILE__));
                } 
                if ($ddp_css_grace == 'grace-header-griffin') {
                    wp_enqueue_style('grace-header-griffin', plugins_url('build/grace/css/headers/grace-header-griffin.css', __FILE__));
                } 
                if ($ddp_css_grace == 'grace-header-acamar') {
                    wp_enqueue_style('grace-header-acamar', plugins_url('build/grace/css/headers/grace-header-acamar.css', __FILE__));
                } 

                if ($ddp_css_grace == 'grace-pricelist-furud') {
                    wp_enqueue_style('grace-pricelist-furud', plugins_url('build/grace/css/price-lists/grace-price-lists-furud.css', __FILE__));
                } 
                if ($ddp_css_grace == 'grace-pricelist-kaitos') {
                    wp_enqueue_style('grace-pricelist-kaitos', plugins_url('build/grace/css/price-lists/grace-price-lists-kaitos.css', __FILE__));
                } 
                if ($ddp_css_grace == 'grace-pricelist-electra') {
                    wp_enqueue_style('grace-pricelist-electra', plugins_url('build/grace/css/price-lists/grace-price-lists-electra.css', __FILE__));
                } 
                if ($ddp_css_grace == 'grace-pricelist-caph') {
                    wp_enqueue_style('grace-pricelist-caph', plugins_url('build/grace/css/price-lists/grace-price-lists-caph.css', __FILE__));
                } 
                if ($ddp_css_grace == 'grace-pricelist-grafias') {
                    wp_enqueue_style('grace-pricelist-grafias', plugins_url('build/grace/css/price-lists/grace-price-lists-grafias.css', __FILE__));
                } 
                if ($ddp_css_grace == 'grace-pricelist-ain') {
                    wp_enqueue_style('grace-pricelist-ain', plugins_url('build/grace/css/price-lists/grace-price-lists-ain.css', __FILE__));
                } 
                if ($ddp_css_grace == 'grace-pricelist-botein') {
                    wp_enqueue_style('grace-pricelist-botein', plugins_url('build/grace/css/price-lists/grace-price-lists-botein.css', __FILE__));
                } 
                if ($ddp_css_grace == 'grace-pricelist-beid') {
                    wp_enqueue_style('grace-pricelist-beid', plugins_url('build/grace/css/price-lists/grace-price-lists-beid.css', __FILE__));
                } 
                if ($ddp_css_grace == 'grace-pricelist-pollux') {
                    wp_enqueue_style('grace-pricelist-pollux', plugins_url('build/grace/css/price-lists/grace-price-lists-pollux.css', __FILE__));
                } 
                if ($ddp_css_grace == 'grace-pricelist-qamar') {
                    wp_enqueue_style('grace-pricelist-qamar', plugins_url('build/grace/css/price-lists/grace-price-lists-qamar.css', __FILE__));
                } 
                if ($ddp_css_grace == 'grace-pricelist-rasalas') {
                    wp_enqueue_style('grace-pricelist-rasalas', plugins_url('build/grace/css/price-lists/grace-price-lists-rasalas.css', __FILE__));
                } 
                if ($ddp_css_grace == 'grace-pricelist-becrux') {
                    wp_enqueue_style('grace-pricelist-becrux', plugins_url('build/grace/css/price-lists/grace-price-lists-becrux.css', __FILE__));
                } 

                if ($ddp_css_grace == 'grace-testimonial-between') {
                    wp_enqueue_style('grace-testimonial-between', plugins_url('build/grace/css/testimonials/grace-testimonials-between.css', __FILE__));
                } 
                if ($ddp_css_grace == 'grace-testimonial-dabih') {
                    wp_enqueue_style('grace-testimonial-dabih', plugins_url('build/grace/css/testimonials/grace-testimonials-dabih.css', __FILE__));
                } 
                if ($ddp_css_grace == 'grace-testimonial-matar') {
                    wp_enqueue_style('grace-testimonial-matar', plugins_url('build/grace/css/testimonials/grace-testimonials-matar.css', __FILE__));
                } 
                if ($ddp_css_grace == 'grace-testimonial-peacock') {
                    wp_enqueue_style('grace-testimonial-peacock', plugins_url('build/grace/css/testimonials/grace-testimonials-peacock.css', __FILE__));
                } 
                if ($ddp_css_grace == 'grace-testimonial-race') {
                    wp_enqueue_style('grace-testimonial-race', plugins_url('build/grace/css/testimonials/grace-testimonials-race.css', __FILE__));
                } 
                if ($ddp_css_grace == 'grace-testimonial-regulus') {
                    wp_enqueue_style('grace-testimonial-regulus', plugins_url('build/grace/css/testimonials/grace-testimonials-regulus.css', __FILE__));
                } 
                if ($ddp_css_grace == 'grace-testimonial-neverstop') {
                    wp_enqueue_style('grace-testimonial-neverstop', plugins_url('build/grace/css/testimonials/grace-testimonials-never-stop.css', __FILE__));
                } 
                if ($ddp_css_grace == 'grace-testimonial-nova') {
                    wp_enqueue_style('grace-testimonial-nova', plugins_url('build/grace/css/testimonials/grace-testimonials-nova.css', __FILE__));
                } 

                if ($ddp_css_grace == 'grace-portfolio-taurus') {
                    wp_enqueue_style('grace-portfolio-taurus', plugins_url('build/grace/css/portfolio/grace-portfolio-taurus.css', __FILE__));
                } 

                if ($ddp_css_grace == 'grace-projects-cursa') {
                    wp_enqueue_style('grace-projects-cursa', plugins_url('build/grace/css/projects/grace-projects-cursa.css', __FILE__));
                } 

                if ($ddp_css_grace == 'grace-cta-ares') {
                    wp_enqueue_style('grace-cta-ares', plugins_url('build/grace/css/cta/grace-cta-ares.css', __FILE__));
                }  
                if ($ddp_css_grace == 'grace-cta-wealth') {
                    wp_enqueue_style('grace-cta-wealth', plugins_url('build/grace/css/cta/grace-cta-wealth.css', __FILE__));
                } 

                if ($ddp_css_grace == 'grace-footers-algol') {
                    wp_enqueue_style('grace-footers-algol', plugins_url('build/grace/css/footers/grace-footers-algol.css', __FILE__));
                } 
                if ($ddp_css_grace == 'grace-footers-alrai') {
                    wp_enqueue_style('grace-footers-alrai', plugins_url('build/grace/css/footers/grace-footers-alrai.css', __FILE__));
                } 
                if ($ddp_css_grace == 'grace-footers-bottle') {
                    wp_enqueue_style('grace-footers-bottle', plugins_url('build/grace/css/footers/grace-footers-bottle.css', __FILE__));
                } 
                if ($ddp_css_grace == 'grace-footers-gacrux') {
                    wp_enqueue_style('grace-footers-gacrux', plugins_url('build/grace/css/footers/grace-footers-gacrux.css', __FILE__));
                } 
                if ($ddp_css_grace == 'grace-footers-heze') {
                    wp_enqueue_style('grace-footers-heze', plugins_url('build/grace/css/footers/grace-footers-heze.css', __FILE__));
                } 
                if ($ddp_css_grace == 'grace-footers-mira') {
                    wp_enqueue_style('grace-footers-mira', plugins_url('build/grace/css/footers/grace-footers-mira.css', __FILE__));
                } 
                if ($ddp_css_grace == 'grace-footers-naos') {
                    wp_enqueue_style('grace-footers-naos', plugins_url('build/grace/css/footers/grace-footers-naos.css', __FILE__));
                } 
                if ($ddp_css_grace == 'grace-footers-drive') {
                    wp_enqueue_style('grace-footers-drive', plugins_url('build/grace/css/footers/grace-footers-drive.css', __FILE__));
                } 
                if ($ddp_css_grace == 'grace-footers-argo') {
                    wp_enqueue_style('grace-footers-argo', plugins_url('build/grace/css/footers/grace-footers-argo.css', __FILE__));
                } 
                if ($ddp_css_grace == 'grace-footers-cadmus') {
                    wp_enqueue_style('grace-footers-cadmus', plugins_url('build/grace/css/footers/grace-footers-cadmus.css', __FILE__));
                } 
                if ($ddp_css_grace == 'grace-footers-achrid') {
                    wp_enqueue_style('grace-footers-achrid', plugins_url('build/grace/css/footers/grace-footers-achrid.css', __FILE__));
                } 
                if ($ddp_css_grace == 'grace-footers-driving') {
                    wp_enqueue_style('grace-footers-driving', plugins_url('build/grace/css/footers/grace-footers-driving.css', __FILE__));
                } 


                if ($ddp_css_grace == 'grace-content-julian') {
                    wp_enqueue_style('grace-content-julian', plugins_url('build/grace/css/content/grace-content-julian.css', __FILE__));
                } 
                if ($ddp_css_grace == 'grace-content-acubens') {
                    wp_enqueue_style('grace-content-acubens', plugins_url('build/grace/css/content/grace-content-acubens.css', __FILE__));
                } 
                if ($ddp_css_grace == 'grace-content-adhil') {
                    wp_enqueue_style('grace-content-adhil', plugins_url('build/grace/css/content/grace-content-adhil.css', __FILE__));
                } 
                if ($ddp_css_grace == 'grace-content-baham') {
                    wp_enqueue_style('grace-content-baham', plugins_url('build/grace/css/content/grace-content-baham.css', __FILE__));
                } 
                if ($ddp_css_grace == 'grace-content-bumper') {
                    wp_enqueue_style('grace-content-bumper', plugins_url('build/grace/css/content/grace-content-bumper.css', __FILE__));
                } 
                if ($ddp_css_grace == 'grace-content-down') {
                    wp_enqueue_style('grace-content-down', plugins_url('build/grace/css/content/grace-content-down.css', __FILE__));
                } 
                if ($ddp_css_grace == 'grace-content-drive') {
                    wp_enqueue_style('grace-content-drive', plugins_url('build/grace/css/content/grace-content-drive.css', __FILE__));
                } 
                if ($ddp_css_grace == 'grace-content-dsiban') {
                    wp_enqueue_style('grace-content-dsiban', plugins_url('build/grace/css/content/grace-content-dsiban.css', __FILE__));
                } 
                if ($ddp_css_grace == 'grace-content-fornacis') {
                    wp_enqueue_style('grace-content-fornacis', plugins_url('build/grace/css/content/grace-content-fornacis.css', __FILE__));
                } 
                if ($ddp_css_grace == 'grace-content-give') {
                    wp_enqueue_style('grace-content-give', plugins_url('build/grace/css/content/grace-content-give.css', __FILE__));
                } 
                if ($ddp_css_grace == 'grace-content-gomeisa') {
                    wp_enqueue_style('grace-content-gomeisa', plugins_url('build/grace/css/content/grace-content-gomeisa.css', __FILE__));
                } 
                if ($ddp_css_grace == 'grace-content-jabbah') {
                    wp_enqueue_style('grace-content-jabbah', plugins_url('build/grace/css/content/grace-content-jabbah.css', __FILE__));
                } 
                if ($ddp_css_grace == 'grace-content-keep') {
                    wp_enqueue_style('grace-content-keep', plugins_url('build/grace/css/content/grace-content-keep.css', __FILE__));
                } 
                if ($ddp_css_grace == 'grace-content-lines') {
                    wp_enqueue_style('grace-content-lines', plugins_url('build/grace/css/content/grace-content-lines.css', __FILE__));
                } 
                if ($ddp_css_grace == 'grace-content-menkent') {
                    wp_enqueue_style('grace-content-menkent', plugins_url('build/grace/css/content/grace-content-menkent.css', __FILE__));
                } 
                if ($ddp_css_grace == 'grace-content-naos') {
                    wp_enqueue_style('grace-content-naos', plugins_url('build/grace/css/content/grace-content-naos.css', __FILE__));
                } 
                if ($ddp_css_grace == 'grace-content-prend') {
                    wp_enqueue_style('grace-content-prend', plugins_url('build/grace/css/content/grace-content-prend.css', __FILE__));
                } 
                if ($ddp_css_grace == 'grace-content-somewhere') {
                    wp_enqueue_style('grace-content-somewhere', plugins_url('build/grace/css/content/grace-content-somewhere.css', __FILE__));
                } 
                if ($ddp_css_grace == 'grace-content-rigel') {
                    wp_enqueue_style('grace-content-rigel', plugins_url('build/grace/css/content/grace-content-rigel.css', __FILE__));
                } 
                if ($ddp_css_grace == 'grace-content-indu') {
                    wp_enqueue_style('grace-content-indu', plugins_url('build/grace/css/content/grace-content-indu.css', __FILE__));
                }
                if ($ddp_css_grace == 'grace-content-larissa') {
                    wp_enqueue_style('grace-content-larissa', plugins_url('build/grace/css/content/grace-content-larissa.css', __FILE__));
                }
                if ($ddp_css_grace == 'grace-content-adonis') {
                    wp_enqueue_style('grace-content-adonis', plugins_url('build/grace/css/content/grace-content-adonis.css', __FILE__));
                }
                if ($ddp_css_grace == 'grace-content-ida') {
                    wp_enqueue_style('grace-content-ida', plugins_url('build/grace/css/content/grace-content-ida.css', __FILE__));
                }

                if ($ddp_css_grace == 'grace-numbers-pallention') {
                    wp_enqueue_style('grace-numbers-pallention', plugins_url('build/grace/css/numbers/grace-numbers-pallention.css', __FILE__));
                } 

                if ($ddp_css_grace == 'grace-optin-spa1') {
                    wp_enqueue_style('grace-optin-spa1', plugins_url('build/grace/css/optin/grace-optin-spa1.css', __FILE__));
                } 
                if ($ddp_css_grace == 'grace-optin-space') {
                    wp_enqueue_style('grace-optin-space', plugins_url('build/grace/css/optin/grace-optin-space.css', __FILE__));
                } 

                if ($ddp_css_grace == 'grace-process-kepler') {
                    wp_enqueue_style('grace-process-kepler', plugins_url('build/grace/css/process/grace-process-kepler.css', __FILE__));
                } 

                
                if ($ddp_css_grace == 'grace-contact-forms-cadmus') {
                    wp_enqueue_style('grace-contact-forms-cadmus', plugins_url('build/grace/css/contact-forms/grace-contact-forms-cadmus.css', __FILE__));
                } 
                if ($ddp_css_grace == 'grace-contact-forms-hades') {
                    wp_enqueue_style('grace-contact-forms-hades', plugins_url('build/grace/css/contact-forms/grace-contact-forms-hades.css', __FILE__));
                } 

                if ($ddp_css_grace == 'grace-testimonials-prey') {
                    wp_enqueue_style('grace-testimonials-prey', plugins_url('build/grace/css/testimonials/grace-testimonials-prey.css', __FILE__));
                }
                if ($ddp_css_grace == 'grace-call-to-action-shiny') {
                    wp_enqueue_style('grace-call-to-action-shiny', plugins_url('build/grace/css/cta/grace-cta-shiny.css', __FILE__));
                } 
                if ($ddp_css_grace == 'grace-blurbs-shadows') {
                    wp_enqueue_style('grace-blurbs-shadows', plugins_url('build/grace/css/blurbs/grace-blurbs-shadows.css', __FILE__));
                }    
                if ($ddp_css_grace == 'grace-content-warmth') {
                    wp_enqueue_style('grace-content-warmth', plugins_url('build/grace/css/content/grace-content-warmth.css', __FILE__));
                } 
                if ($ddp_css_grace == 'grace-footers-showed') {
                    wp_enqueue_style('grace-footers-showed', plugins_url('build/grace/css/footers/grace-footers-showed.css', __FILE__));
                } 
                if ($ddp_css_grace == 'grace-blurbs-garage') {
                    wp_enqueue_style('grace-blurbs-garage', plugins_url('build/grace/css/blurbs/grace-blurbs-garage.css', __FILE__));
                } 
                if ($ddp_css_grace == 'grace-content-parking') {
                    wp_enqueue_style('grace-content-parking', plugins_url('build/grace/css/content/grace-content-parking.css', __FILE__));
                }
                if ($ddp_css_grace == 'grace-process-izar') {
                    wp_enqueue_style('grace-process-izar', plugins_url('build/grace/css/process/grace-process-izar.css', __FILE__));
                }
                if ($ddp_css_grace == 'grace-price-flipit') {
                    wp_enqueue_style('grace-price-flipit', plugins_url('build/grace/css/price-lists/grace-price-lists-flip-it.css', __FILE__));
                }
                if ($ddp_css_grace == 'grace-header-favorable') {
                    wp_enqueue_style('grace-header-favorable', plugins_url('build/grace/css/headers/grace-header-favorable.css', __FILE__));
                }
                if ($ddp_css_grace == 'grace-process-lintang') {
                    wp_enqueue_style('grace-process-lintang', plugins_url('build/grace/css/process/grace-process-lintang.css', __FILE__));
                }
                if ($ddp_css_grace == 'grace-process-kuiper') {
                    wp_enqueue_style('grace-process-kuiper', plugins_url('build/grace/css/process/grace-process-kuiper.css', __FILE__));
                }
                if ($ddp_css_grace == 'grace-process-jupiter') {
                    wp_enqueue_style('grace-process-jupiter', plugins_url('build/grace/css/process/grace-process-jupiter.css', __FILE__));
                }
                if ($ddp_css_grace == 'grace-process-janus') {
                    wp_enqueue_style('grace-process-janus', plugins_url('build/grace/css/process/grace-process-janus.css', __FILE__));
                }
                if ($ddp_css_grace == 'grace-process-hoku') {
                    wp_enqueue_style('grace-process-hoku', plugins_url('build/grace/css/process/grace-process-hoku.css', __FILE__));
                }
                if ($ddp_css_grace == 'grace-process-hesperos') {
                    wp_enqueue_style('grace-process-hesperos', plugins_url('build/grace/css/process/grace-process-hesperos.css', __FILE__));
                }
                if ($ddp_css_grace == 'grace-pricing-table-emma') {
                    wp_enqueue_style('grace-pricing-table-emma', plugins_url('build/grace/css/price-lists/grace-pricing-table-emma.css', __FILE__));
                }
                if ($ddp_css_grace == 'grace-content-world') {
                    wp_enqueue_style('grace-content-world', plugins_url('build/grace/css/content/grace-content-world.css', __FILE__));
                }
                if ($ddp_css_grace == 'grace-content-spending') {
                    wp_enqueue_style('grace-content-spending', plugins_url('build/grace/css/content/grace-content-spending.css', __FILE__));
                }
                if ($ddp_css_grace == 'grace-footers-grace_footers_gacrux_v2') {
                    wp_enqueue_style('grace-footers-grace_footers_gacrux_v2', plugins_url('build/grace/css/footers/grace-footers-grace_footers_gacrux_v2', __FILE__));
                }
                if ($ddp_css_grace == 'grace-content-aching') {
                    wp_enqueue_style('grace-content-aching', plugins_url('build/grace/css/content/grace-content-aching.css', __FILE__));
                }
                if ($ddp_css_grace == 'grace-blurbs-albaldah-v2') {
                    wp_enqueue_style('grace-blurbs-albaldah-v2', plugins_url('build/grace/css/blurbs/grace-blurbs-albaldah-v2.css', __FILE__));
                }
                if ($ddp_css_grace == 'grace-content-power') {
                    wp_enqueue_style('grace-content-power', plugins_url('build/grace/css/content/grace-content-power.css', __FILE__));
                }  
                if ($ddp_css_grace == 'grace-person-gunnef') {
                    wp_enqueue_style('grace-person-gunnef', plugins_url('build/grace/css/persons/grace-person-gunnef.css', __FILE__));
                } 
                if ($ddp_css_grace == 'grace-portfolio-gomeisa') {
                    wp_enqueue_style('grace-portfolio-gomeisa', plugins_url('build/grace/css/portfolio/grace-portfolio-gomeisa.css', __FILE__));
                } 
                if ($ddp_css_grace == 'grace-blurbs-pour') {
                    wp_enqueue_style('grace-blurbs-pour', plugins_url('build/grace/css/blurbs/grace-blurbs-pour.css', __FILE__));
                } 
                if ($ddp_css_grace == 'grace-content-wasat') {
                    wp_enqueue_style('grace-content-wasat', plugins_url('build/grace/css/content/grace-content-wasat.css', __FILE__));
                } 
                if ($ddp_css_grace == 'grace-footers-alors') {
                    wp_enqueue_style('grace-footers-alors', plugins_url('build/grace/css/footers/grace-footers-alors.css', __FILE__));
                } 
                if ($ddp_css_grace == 'grace-optin-your-kiss') {
                    wp_enqueue_style('grace-optin-your-kiss', plugins_url('build/grace/css/optin/grace-optin-your-kiss.css', __FILE__));
                } 
                if ($ddp_css_grace == 'grace-content-may') {
                    wp_enqueue_style('grace-content-may', plugins_url('build/grace/css/content/grace-content-may.css', __FILE__));
                }
                if ($ddp_css_grace == 'grace-person-rode') {
                    wp_enqueue_style('grace-person-rode', plugins_url('build/grace/css/persons/grace-person-rode.css', __FILE__));
                }
                if ($ddp_css_grace == 'grace-content-sparks') {
                    wp_enqueue_style('grace-content-sparks', plugins_url('build/grace/css/content/grace-content-sparks.css', __FILE__));
                }
                if ($ddp_css_grace == 'grace-footers-grandfather') {
                    wp_enqueue_style('grace-footers-grandfather', plugins_url('build/grace/css/footers/grace-footers-grandfather.css', __FILE__));
                }
                if ($ddp_css_grace == 'grace-footers-store') {
                    wp_enqueue_style('grace-footers-store', plugins_url('build/grace/css/footers/grace-footers-store.css', __FILE__));
                }
                if ($ddp_css_grace == 'grace-headers-castor') {
                    wp_enqueue_style('grace-headers-castor', plugins_url('build/grace/css/headers/grace-header-castor.css', __FILE__));
                }
                if ($ddp_css_grace == 'grace-portfolio-cronus') {
                    wp_enqueue_style('grace-portfolio-cronus', plugins_url('build/grace/css/portfolio/grace-portfolio-cronus.css', __FILE__));
                }
                if ($ddp_css_grace == 'grace-logos-damon') {
                    wp_enqueue_style('grace-logos-damon', plugins_url('build/grace/css/logos/grace-logos-damon.css', __FILE__));
                }
                if ($ddp_css_grace == 'grace-persons-damon') {
                    wp_enqueue_style('grace-persons-damon', plugins_url('build/grace/css/persons/grace-person-damon.css', __FILE__));
                }
                if ($ddp_css_grace == 'grace-blog-dionysius') {
                    wp_enqueue_style('grace-blog-dionysius', plugins_url('build/grace/css/blogs/grace-blog-dionysius.css', __FILE__));
                }
                if ($ddp_css_grace == 'grace-footer-eros') {
                    wp_enqueue_style('grace-footer-eros', plugins_url('build/grace/css/footers/grace-footers-eros.css', __FILE__));
                }
                if ($ddp_css_grace == 'grace-gallery-polaris-v2') {
                    wp_enqueue_style('grace-gallery-polaris-v2', plugins_url('build/grace/css/gallery/grace-gallery-polaris-v2.css', __FILE__));
                }
                if ($ddp_css_grace == 'grace-blog-beauty') {
                    wp_enqueue_style('grace-blog-beauty', plugins_url('build/grace/css/blogs/grace-blog-beauty.css', __FILE__));
                }
                if ($ddp_css_grace == 'grace-blog-sten') {
                    wp_enqueue_style('grace-blog-sten', plugins_url('build/grace/css/blogs/grace-blog-sten.css', __FILE__));
                }
                if ($ddp_css_grace == 'grace-accordion-iconic') {
                    wp_enqueue_style('grace-accordion-iconic', plugins_url('build/grace/css/accordions/grace-accordion-iconic.css', __FILE__));
                }
                if ($ddp_css_grace == 'grace-testimonial-that-face') {
                    wp_enqueue_style('grace-testimonial-that-face', plugins_url('build/grace/css/testimonials/grace-testimonials-that-face.css', __FILE__));
                }
                if ($ddp_css_grace == 'grace-person-founding') {
                    wp_enqueue_style('grace-person-founding', plugins_url('build/grace/css/persons/grace-person-founding.css', __FILE__));
                }
                if ($ddp_css_grace == 'grace-blurbs-action') {
                    wp_enqueue_style('grace-blurbs-action', plugins_url('build/grace/css/blurbs/grace-blurbs-action.css', __FILE__));
                }
                if ($ddp_css_grace == 'grace-optin-gonna-be') {
                    wp_enqueue_style('grace-optin-gonna-be', plugins_url('build/grace/css/optin/grace-optin-gonna-be.css', __FILE__));
                }
                if ($ddp_css_grace == 'grace-footers-dignified') {
                    wp_enqueue_style('grace-footers-dignified', plugins_url('build/grace/css/footers/grace-footers-dignified.css', __FILE__));
                }
                if ($ddp_css_grace == 'grace-footers-ample') {
                    wp_enqueue_style('grace-footers-ample', plugins_url('build/grace/css/footers/grace-footers-ample.css', __FILE__));
                } 
                if ($ddp_css_grace == 'grace-footers-gacrux-v2') {
                    wp_enqueue_style('grace-footers-gacrux-v2', plugins_url('build/grace/css/footers/grace-footers-gacrux-v2.css', __FILE__));
                }
                if ($ddp_css_grace == 'grace-content-lines-v2') {
                    wp_enqueue_style('grace-content-lines-v2', plugins_url('build/grace/css/content/grace-content-lines-v2.css', __FILE__));
                }
                if ($ddp_css_grace == 'grace-cta-jhones') {
                    wp_enqueue_style('grace-cta-jhones', plugins_url('build/grace/css/cta/grace-cta-jhones.css', __FILE__));
                }
                if ($ddp_css_grace == 'grace-process-meteor') {
                    wp_enqueue_style('grace-process-meteor', plugins_url('build/grace/css/process/grace-process-meteor.css', __FILE__));
                }
				if ($ddp_css_grace == 'grace-contact-wezen') {
                    wp_enqueue_style('grace-contact-wezen', plugins_url('build/grace/css/contact/grace-contact-wezen.css', __FILE__));
                }

                if ($ddp_css_grace == 'grace-about9-content-aching') {
                    wp_enqueue_style('grace-about9-content-aching', plugins_url('build/grace/css/content/grace-about9-content-aching.css', __FILE__));
                }
                if ($ddp_css_grace == 'grace-about9-cta') {
                    wp_enqueue_style('grace-about9-cta', plugins_url('build/grace/css/cta/grace-about9-cta.css', __FILE__));
                }
                if ($ddp_css_grace == 'grace-content-pentecostal') {
                    wp_enqueue_style('grace-content-pentecostal', plugins_url('build/grace/css/content/grace-content-pentecostal.css', __FILE__));
                }
                if ($ddp_css_grace == 'grace-about11-gallery') {
                    wp_enqueue_style('grace-about11-gallery', plugins_url('build/grace/css/gallery/grace-about11-gallery.css', __FILE__));
                }
                if ($ddp_css_grace == 'grace-about11-counter') {
                    wp_enqueue_style('grace-about11-counter', plugins_url('build/grace/css/numbers/grace-about11-counter.css', __FILE__));
                }
                if ($ddp_css_grace == 'grace-about11-testimonials') {
                    wp_enqueue_style('grace-about11-testimonials', plugins_url('build/grace/css/testimonials/grace-about11-testimonials.css', __FILE__));
                }
                if ($ddp_css_grace == 'grace-person-artist') {
                    wp_enqueue_style('grace-person-artist', plugins_url('build/grace/css/persons/grace-person-artist.css', __FILE__));
                }
                if ($ddp_css_grace == 'grace-content-filmmaker') {
                    wp_enqueue_style('grace-content-filmmaker', plugins_url('build/grace/css/video/grace-content-filmmaker.css', __FILE__));
                }   
                if ($ddp_css_grace == 'grace-about12-gallery-halley') {
                    wp_enqueue_style('grace-about12-gallery-halley', plugins_url('build/grace/css/gallery/grace-about12-gallery-halley.css', __FILE__));
                }
                if ($ddp_css_grace == 'grace-about12-blog-mon') {
                    wp_enqueue_style('grace-about12-blog-mon', plugins_url('build/grace/css/blogs/grace-about12-blog-mon.css', __FILE__));
                }   
                if ($ddp_css_grace == 'grace-content-mendoza') {
                    wp_enqueue_style('grace-content-mendoza', plugins_url('build/grace/css/content/grace-content-mendoza.css', __FILE__));
                }   
                if ($ddp_css_grace == 'grace-content-stir') {
                    wp_enqueue_style('grace-content-stir', plugins_url('build/grace/css/content/grace-content-stir.css', __FILE__));
                }                   
                if ($ddp_css_grace == 'grace-about13-content-world') {
                    wp_enqueue_style('grace-about13-content-world', plugins_url('build/grace/css/content/grace-content-world.css', __FILE__));
                }
                if ($ddp_css_grace == 'grace-content-atila') {
                    wp_enqueue_style('grace-content-atila', plugins_url('build/grace/css/content/grace-content-atila.css', __FILE__));
                }   
                if ($ddp_css_grace == 'grace-about13-blog-isac') {
                    wp_enqueue_style('grace-about13-blog-isac', plugins_url('build/grace/css/blogs/grace-about13-blog-isac.css', __FILE__));
                }   
                if ($ddp_css_grace == 'grace-about13-footers-naos') {
                    wp_enqueue_style('grace-content-stir', plugins_url('build/grace/css/content/grace-footers-naos.css', __FILE__));
                }   
                if ($ddp_css_grace == 'grace-about13-light-person-module') {
                    wp_enqueue_style('grace-about13-light-person-module', plugins_url('build/grace/css/persons/grace-about13-light-person.css', __FILE__));
                }   
                if ($ddp_css_grace == 'grace-about14-testimonial-go-to') {
                    wp_enqueue_style('grace-about14-testimonial-go-to', plugins_url('build/grace/css/testimonials/grace-about14-testimonial-go-to.css', __FILE__));
                }
                if ($ddp_css_grace == 'grace-about14-footers-drive') {
                    wp_enqueue_style('grace-about14-footers-drive', plugins_url('build/grace/css/testimonials/grace-about14-testimonial-go-to.css', __FILE__));
                }  
                if ($ddp_css_grace == 'grace-person-california') {
                    wp_enqueue_style('grace-person-california', plugins_url('build/grace/css/persons/grace-person-california.css', __FILE__));
                }
                if ($ddp_css_grace == 'grace-content-released') {
                    wp_enqueue_style('grace-content-released', plugins_url('build/grace/css/content/grace-content-released.css', __FILE__));
                }  
                if ($ddp_css_grace == 'grace-header-service4') {
                    wp_enqueue_style('grace-header-service4', plugins_url('build/grace/css/headers/grace-header-service4.css', __FILE__));
                }  
                if ($ddp_css_grace == 'grace-blurbs-service4') {
                    wp_enqueue_style('grace-blurbs-service4', plugins_url('build/grace/css/blurbs/grace-blurbs-service4.css', __FILE__));
                }   
                if ($ddp_css_grace == 'grace-content-action') {
                    wp_enqueue_style('grace-content-action', plugins_url('build/grace/css/content/grace-content-action.css', __FILE__));
                }  
                if ($ddp_css_grace == 'grace-blurbs-80s') {
                    wp_enqueue_style('grace-blurbs-80s', plugins_url('build/grace/css/blurbs/grace-blurbs-80s.css', __FILE__));
                }  
                if ($ddp_css_grace == 'grace-header-service6') {
                    wp_enqueue_style('grace-header-service6', plugins_url('build/grace/css/headers/grace-header-service6.css', __FILE__));
                }  
                if ($ddp_css_grace == 'grace-content-minister') {
                    wp_enqueue_style('grace-content-minister', plugins_url('build/grace/css/content/grace-content-minister.css', __FILE__));
                }  
                if ($ddp_css_grace == 'grace-person-pastor') {
                    wp_enqueue_style('grace-person-pastor', plugins_url('build/grace/css/persons/grace-person-pastor.css', __FILE__));
                }  
                if ($ddp_css_grace == 'grace_about11_logos') {
                    wp_enqueue_style('grace_about11_logos', plugins_url('build/grace/css/content/grace-content-logos.css', __FILE__));
                } 
                if ($ddp_css_grace == 'grace-content-gardena') {
                    wp_enqueue_style('grace-content-gardena', plugins_url('build/grace/css/content/grace-content-gardena.css', __FILE__));
                }  
                if ($ddp_css_grace == 'grace-header-turkish') {
                    wp_enqueue_style('grace-header-turkish', plugins_url('build/grace/css/headers/grace-header-turkish.css', __FILE__));
                }  

             }
            //Grace ends
            //Olena starts
            if (!empty(get_post_meta($post->ID, 'ddp-css-olena'))) {
                foreach ((array) get_post_meta($post->ID, 'ddp-css-olena') as $ddp_css_grace) {
                
                    if ($ddp_css_grace == 'olena-header-v1') {
                        wp_enqueue_style('olena-header-v1', plugins_url('build/olena/css/headers/olena-header-v1.css', __FILE__));
                    }  
                    if ($ddp_css_grace == 'olena-header-v2') {
                        wp_enqueue_style('olena-header-v2', plugins_url('build/olena/css/headers/olena-header-v2.css', __FILE__));
                    }  
                    if ($ddp_css_grace == 'olena-header-v3') {
                        wp_enqueue_style('olena-header-v3', plugins_url('build/olena/css/headers/olena-header-v3.css', __FILE__));
                    }  
                    if ($ddp_css_grace == 'olena-header-v4') {
                        wp_enqueue_style('olena-header-v4', plugins_url('build/olena/css/headers/olena-header-v4.css', __FILE__));
                    }  
                    if ($ddp_css_grace == 'olena-header-v5') {
                        wp_enqueue_style('olena-header-v5', plugins_url('build/olena/css/headers/olena-header-v5.css', __FILE__));
                    }  
                    if ($ddp_css_grace == 'olena-header-v6') {
                        wp_enqueue_style('olena-header-v6', plugins_url('build/olena/css/headers/olena-header-v6.css', __FILE__));
                    }  
                    if ($ddp_css_grace == 'olena-header-v7') {
                        wp_enqueue_style('olena-header-v7', plugins_url('build/olena/css/headers/olena-header-v7.css', __FILE__));
                    }  
                    if ($ddp_css_grace == 'olena-header-v8') {
                        wp_enqueue_style('olena-header-v8', plugins_url('build/olena/css/headers/olena-header-v8.css', __FILE__));
                    }  
                    if ($ddp_css_grace == 'olena-header-v9') {
                        wp_enqueue_style('olena-header-v9', plugins_url('build/olena/css/headers/olena-header-v9.css', __FILE__));
                    }  
                    if ($ddp_css_grace == 'olena-header-v10') {
                        wp_enqueue_style('olena-header-v10', plugins_url('build/olena/css/headers/olena-header-v10.css', __FILE__));
                    }  
                    if ($ddp_css_grace == 'olena-header-v11') {
                        wp_enqueue_style('olena-header-v11', plugins_url('build/olena/css/headers/olena-header-v11.css', __FILE__));
                    }  
                    if ($ddp_css_grace == 'olena-header-v12') {
                        wp_enqueue_style('olena-header-v11', plugins_url('build/olena/css/headers/olena-header-v12.css', __FILE__));
                    }  
                    if ($ddp_css_grace == 'olena-content-1') {
                        wp_enqueue_style('olena-header-1', plugins_url('build/olena/css/content/olena-content-1.css', __FILE__));
                    }  
                    if ($ddp_css_grace == 'olena-content-2') {
                        wp_enqueue_style('olena-header-2', plugins_url('build/olena/css/content/olena-content-2.css', __FILE__));
                    }  
                    if ($ddp_css_grace == 'olena-content-3') {
                        wp_enqueue_style('olena-header-3', plugins_url('build/olena/css/content/olena-content-3.css', __FILE__));
                    }  
                    if ($ddp_css_grace == 'olena-content-4') {
                        wp_enqueue_style('olena-header-4', plugins_url('build/olena/css/content/olena-content-4.css', __FILE__));
                    }  
                    if ($ddp_css_grace == 'olena-content-5') {
                        wp_enqueue_style('olena-header-5', plugins_url('build/olena/css/content/olena-content-5.css', __FILE__));
                    }  
                    if ($ddp_css_grace == 'olena-content-6') {
                        wp_enqueue_style('olena-header-6', plugins_url('build/olena/css/content/olena-content-6.css', __FILE__));
                    }  
                    if ($ddp_css_grace == 'olena-content-7') {
                        wp_enqueue_style('olena-header-7', plugins_url('build/olena/css/content/olena-content-7.css', __FILE__));
                    }  
                    if ($ddp_css_grace == 'olena-content-8') {
                        wp_enqueue_style('olena-header-8', plugins_url('build/olena/css/content/olena-content-8.css', __FILE__));
                    }  
                    if ($ddp_css_grace == 'olena-content-9') {
                        wp_enqueue_style('olena-header-9', plugins_url('build/olena/css/content/olena-content-9.css', __FILE__));
                    }  
                    if ($ddp_css_grace == 'olena-content-10') {
                        wp_enqueue_style('olena-header-10', plugins_url('build/olena/css/content/olena-content-10.css', __FILE__));
                    }  
                    if ($ddp_css_grace == 'olena-content-11') {
                        wp_enqueue_style('olena-header-11', plugins_url('build/olena/css/content/olena-content-11.css', __FILE__));
                    }  
                    if ($ddp_css_grace == 'olena-content-12') {
                        wp_enqueue_style('olena-header-12', plugins_url('build/olena/css/content/olena-content-12.css', __FILE__));
                    }  
                    if ($ddp_css_grace == 'olena-content-15') {
                        wp_enqueue_style('olena-header-15', plugins_url('build/olena/css/content/olena-content-15.css', __FILE__));
                    }  
                    if ($ddp_css_grace == 'olena-content-18') {
                        wp_enqueue_style('olena-header-18', plugins_url('build/olena/css/content/olena-content-18.css', __FILE__));
                    }  
                    if ($ddp_css_grace == 'olena-person-v1') {
                        wp_enqueue_style('olena-person-v1', plugins_url('build/olena/css/persons/olena-person-v1.css', __FILE__));
                    }  
                    if ($ddp_css_grace == 'olena-person-v2') {
                        wp_enqueue_style('olena-person-v2', plugins_url('build/olena/css/persons/olena-person-v2.css', __FILE__));
                    }  
                    if ($ddp_css_grace == 'olena-person-v3') {
                        wp_enqueue_style('olena-person-v3', plugins_url('build/olena/css/persons/olena-person-v3.css', __FILE__));
                    }  
                    if ($ddp_css_grace == 'olena-person-v4') {
                        wp_enqueue_style('olena-person-v4', plugins_url('build/olena/css/persons/olena-person-v4.css', __FILE__));
                    }  
                    if ($ddp_css_grace == 'olena-person-v5') {
                        wp_enqueue_style('olena-person-v5', plugins_url('build/olena/css/persons/olena-person-v5.css', __FILE__));
                    }  
                    if ($ddp_css_grace == 'olena-person-v6') {
                        wp_enqueue_style('olena-person-v6', plugins_url('build/olena/css/persons/olena-person-v6.css', __FILE__));
                    }  
                    if ($ddp_css_grace == 'olena-person-v7') {
                        wp_enqueue_style('olena-person-v7', plugins_url('build/olena/css/persons/olena-person-v7.css', __FILE__));
                    }  
                    if ($ddp_css_grace == 'olena-person-v8') {
                        wp_enqueue_style('olena-person-v8', plugins_url('build/olena/css/persons/olena-person-v8.css', __FILE__));
                    }  
                    if ($ddp_css_grace == 'olena-person-v9') {
                        wp_enqueue_style('olena-person-v9', plugins_url('build/olena/css/persons/olena-person-v9.css', __FILE__));
                    }  
                    if ($ddp_css_grace == 'olena-person-v10') {
                        wp_enqueue_style('olena-person-v10', plugins_url('build/olena/css/persons/olena-person-v10.css', __FILE__));
                    }  
                    if ($ddp_css_grace == 'olena-person-v11') {
                        wp_enqueue_style('olena-person-v11', plugins_url('build/olena/css/persons/olena-person-v11.css', __FILE__));
                    }  
                    if ($ddp_css_grace == 'olena-person-v12') {
                        wp_enqueue_style('olena-person-v12', plugins_url('build/olena/css/persons/olena-person-v12.css', __FILE__));
                    }  
                    if ($ddp_css_grace == 'olena-person-v13') {
                        wp_enqueue_style('olena-person-v13', plugins_url('build/olena/css/persons/olena-person-v13.css', __FILE__));
                    }  
                    if ($ddp_css_grace == 'olena-blog-v1') {
                        wp_enqueue_style('olena-blog-v1', plugins_url('build/olena/css/blog/olena-blog-v1.css', __FILE__));
                    }  
                    if ($ddp_css_grace == 'olena-blog-v2') {
                        wp_enqueue_style('olena-blog-v2', plugins_url('build/olena/css/blog/olena-blog-v2.css', __FILE__));
                    }  
                    if ($ddp_css_grace == 'olena-blog-v3') {
                        wp_enqueue_style('olena-blog-v3', plugins_url('build/olena/css/blog/olena-blog-v3.css', __FILE__));
                    }  
                    if ($ddp_css_grace == 'olena-blog-v4') {
                        wp_enqueue_style('olena-blog-v4', plugins_url('build/olena/css/blog/olena-blog-v4.css', __FILE__));
                    }  
                    if ($ddp_css_grace == 'olena-blog-v5') {
                        wp_enqueue_style('olena-blog-v5', plugins_url('build/olena/css/blog/olena-blog-v5.css', __FILE__));
                    }  
                    if ($ddp_css_grace == 'olena-blog-v6') {
                        wp_enqueue_style('olena-blog-v6', plugins_url('build/olena/css/blog/olena-blog-v6.css', __FILE__));
                    }  
                    if ($ddp_css_grace == 'olena-blog-v7') {
                        wp_enqueue_style('olena-blog-v7', plugins_url('build/olena/css/blog/olena-blog-v7.css', __FILE__));
                    }  
                    if ($ddp_css_grace == 'olena-blog-v8') {
                        wp_enqueue_style('olena-blog-v8', plugins_url('build/olena/css/blog/olena-blog-v8.css', __FILE__));
                    }  
                    if ($ddp_css_grace == 'olena-blog-v9') {
                        wp_enqueue_style('olena-blog-v9', plugins_url('build/olena/css/blog/olena-blog-v9.css', __FILE__));
                    }  
                    if ($ddp_css_grace == 'olena-blog-v10') {
                        wp_enqueue_style('olena-blog-v10', plugins_url('build/olena/css/blog/olena-blog-v10.css', __FILE__));
                    }  
                    if ($ddp_css_grace == 'olena-blog-v11') {
                        wp_enqueue_style('olena-blog-v11', plugins_url('build/olena/css/blog/olena-blog-v11.css', __FILE__));
                    }  
                    if ($ddp_css_grace == 'olena-blog-v12') {
                        wp_enqueue_style('olena-blog-v12', plugins_url('build/olena/css/blog/olena-blog-v12.css', __FILE__));
                    }  
                    if ($ddp_css_grace == 'olena-blurb-v1') {
                        wp_enqueue_style('olena-blurb-v1', plugins_url('build/olena/css/blurbs/olena-blurb-v1.css', __FILE__));
                    }  
                    if ($ddp_css_grace == 'olena-blurb-v2') {
                        wp_enqueue_style('olena-blurb-v2', plugins_url('build/olena/css/blurbs/olena-blurb-v2.css', __FILE__));
                    }  
                    if ($ddp_css_grace == 'olena-blurb-v3') {
                        wp_enqueue_style('olena-blurb-v3', plugins_url('build/olena/css/blurbs/olena-blurb-v3.css', __FILE__));
                    }  
                    if ($ddp_css_grace == 'olena-blurb-v4') {
                        wp_enqueue_style('olena-blurb-v4', plugins_url('build/olena/css/blurbs/olena-blurb-v4.css', __FILE__));
                    }  
                    if ($ddp_css_grace == 'olena-blurb-v5') {
                        wp_enqueue_style('olena-blurb-v5', plugins_url('build/olena/css/blurbs/olena-blurb-v5.css', __FILE__));
                    }  
                    if ($ddp_css_grace == 'olena-blurb-v6') {
                        wp_enqueue_style('olena-blurb-v6', plugins_url('build/olena/css/blurbs/olena-blurb-v6.css', __FILE__));
                    }  
                    if ($ddp_css_grace == 'olena-blurb-v7') {
                        wp_enqueue_style('olena-blurb-v7', plugins_url('build/olena/css/blurbs/olena-blurb-v7.css', __FILE__));
                    }  
                    if ($ddp_css_grace == 'olena-blurb-v8') {
                        wp_enqueue_style('olena-blurb-v8', plugins_url('build/olena/css/blurbs/olena-blurb-v8.css', __FILE__));
                    }  
                    if ($ddp_css_grace == 'olena-blurb-v9') {
                        wp_enqueue_style('olena-blurb-v9', plugins_url('build/olena/css/blurbs/olena-blurb-v9.css', __FILE__));
                    }  
                    if ($ddp_css_grace == 'olena-blurb-v10') {
                        wp_enqueue_style('olena-blurb-v10', plugins_url('build/olena/css/blurbs/olena-blurb-v10.css', __FILE__));
                    }  
                    if ($ddp_css_grace == 'olena-blurb-v11') {
                        wp_enqueue_style('olena-blurb-v11', plugins_url('build/olena/css/blurbs/olena-blurb-v11.css', __FILE__));
                    }  
                    if ($ddp_css_grace == 'olena-blurb-v12') {
                        wp_enqueue_style('olena-blurb-v12', plugins_url('build/olena/css/blurbs/olena-blurb-v12.css', __FILE__));
                    }  
                    if ($ddp_css_grace == 'olena-blurb-v13') {
                        wp_enqueue_style('olena-blurb-v13', plugins_url('build/olena/css/blurbs/olena-blurb-v13.css', __FILE__));
                    }  
                    if ($ddp_css_grace == 'olena-blurb-v14') {
                        wp_enqueue_style('olena-blurb-v14', plugins_url('build/olena/css/blurbs/olena-blurb-v14.css', __FILE__));
                    }  
                    if ($ddp_css_grace == 'olena-blurb-v15') {
                        wp_enqueue_style('olena-blurb-v15', plugins_url('build/olena/css/blurbs/olena-blurb-v15.css', __FILE__));
                    }  
                    if ($ddp_css_grace == 'olena-blurb-v16') {
                        wp_enqueue_style('olena-blurb-v16', plugins_url('build/olena/css/blurbs/olena-blurb-v16.css', __FILE__));
                    }  
                    if ($ddp_css_grace == 'olena-blurb-v17') {
                        wp_enqueue_style('olena-blurb-v17', plugins_url('build/olena/css/blurbs/olena-blurb-v17.css', __FILE__));
                    }  
                    if ($ddp_css_grace == 'olena-blurb-v18') {
                        wp_enqueue_style('olena-blurb-v18', plugins_url('build/olena/css/blurbs/olena-blurb-v18.css', __FILE__));
                    }  
                    if ($ddp_css_grace == 'olena-blurb-v19') {
                        wp_enqueue_style('olena-blurb-v19', plugins_url('build/olena/css/blurbs/olena-blurb-v19.css', __FILE__));
                    }  
                    if ($ddp_css_grace == 'olena-blurb-v20') {
                        wp_enqueue_style('olena-blurb-v20', plugins_url('build/olena/css/blurbs/olena-blurb-v20.css', __FILE__));
                    }  
                    if ($ddp_css_grace == 'olena-blurb-v21') {
                        wp_enqueue_style('olena-blurb-v21', plugins_url('build/olena/css/blurbs/olena-blurb-v21.css', __FILE__));
                    }  
                    if ($ddp_css_grace == 'olena-blurb-v22') {
                        wp_enqueue_style('olena-blurb-v22', plugins_url('build/olena/css/blurbs/olena-blurb-v22.css', __FILE__));
                    }  
                    if ($ddp_css_grace == 'olena-blurb-v24') {
                        wp_enqueue_style('olena-blurb-v24', plugins_url('build/olena/css/blurbs/olena-blurb-v24.css', __FILE__));
                    }  
                    if ($ddp_css_grace == 'olena-blurb-v26') {
                        wp_enqueue_style('olena-blurb-v26', plugins_url('build/olena/css/blurbs/olena-blurb-v26.css', __FILE__));
                    }  
                    if ($ddp_css_grace == 'olena-blurb-v27') {
                        wp_enqueue_style('olena-blurb-v27', plugins_url('build/olena/css/blurbs/olena-blurb-v27.css', __FILE__));
                    }  
                    if ($ddp_css_grace == 'olena-blurb-v28') {
                        wp_enqueue_style('olena-blurb-v28', plugins_url('build/olena/css/blurbs/olena-blurb-v28.css', __FILE__));
                    }  
                    if ($ddp_css_grace == 'olena-blurb-v29') {
                        wp_enqueue_style('olena-blurb-v29', plugins_url('build/olena/css/blurbs/olena-blurb-v29.css', __FILE__));
                    }  

                    if ($ddp_css_grace == 'olena-woo-v1') {
                        wp_enqueue_style('olena-woo-v1', plugins_url('build/olena/css/shop/olena-woo-v1.css', __FILE__));
                    }  
                    if ($ddp_css_grace == 'olena-woo-v2') {
                        wp_enqueue_style('olena-woo-v2', plugins_url('build/olena/css/shop/olena-woo-v2.css', __FILE__));
                    }  
                    if ($ddp_css_grace == 'olena-woo-v3') {
                        wp_enqueue_style('olena-woo-v3', plugins_url('build/olena/css/shop/olena-woo-v3.css', __FILE__));
                    }  
                    if ($ddp_css_grace == 'olena-woo-v4') {
                        wp_enqueue_style('olena-woo-v4', plugins_url('build/olena/css/shop/olena-woo-v4.css', __FILE__));
                    }  
                    if ($ddp_css_grace == 'olena-woo-v5') {
                        wp_enqueue_style('olena-woo-v5', plugins_url('build/olena/css/shop/olena-woo-v5.css', __FILE__));
                    }  
                    if ($ddp_css_grace == 'olena-woo-v6') {
                        wp_enqueue_style('olena-woo-v6', plugins_url('build/olena/css/shop/olena-woo-v6.css', __FILE__));
                    }  
                    if ($ddp_css_grace == 'olena-woo-v7') {
                        wp_enqueue_style('olena-woo-v7', plugins_url('build/olena/css/shop/olena-woo-v7.css', __FILE__));
                    }  
                    if ($ddp_css_grace == 'olena-woo-v8') {
                        wp_enqueue_style('olena-woo-v8', plugins_url('build/olena/css/shop/olena-woo-v8.css', __FILE__));
                    }  
                    if ($ddp_css_grace == 'olena-woo-v9') {
                        wp_enqueue_style('olena-woo-v9', plugins_url('build/olena/css/shop/olena-woo-v9.css', __FILE__));
                    }  
                    if ($ddp_css_grace == 'olena-woo-v10') {
                        wp_enqueue_style('olena-woo-v10', plugins_url('build/olena/css/shop/olena-woo-v10.css', __FILE__));
                    }  
                    if ($ddp_css_grace == 'olena-woo-v11') {
                        wp_enqueue_style('olena-woo-v11', plugins_url('build/olena/css/shop/olena-woo-v11.css', __FILE__));
                    }  
                    if ($ddp_css_grace == 'olena-woo-v12') {
                        wp_enqueue_style('olena-woo-v12', plugins_url('build/olena/css/shop/olena-woo-v12.css', __FILE__));
                    }  
                    if ($ddp_css_grace == 'olena-woo-v13') {
                        wp_enqueue_style('olena-woo-v13', plugins_url('build/olena/css/shop/olena-woo-v13.css', __FILE__));
                    }  
                    if ($ddp_css_grace == 'olena-woo-v14') {
                        wp_enqueue_style('olena-woo-v14', plugins_url('build/olena/css/shop/olena-woo-v14.css', __FILE__));
                    }  
                    if ($ddp_css_grace == 'olena-numbers-v1') {
                        wp_enqueue_style('olena-numbers-v1', plugins_url('build/olena/css/numbers/olena-numbers-v1.css', __FILE__));
                    }  
                    if ($ddp_css_grace == 'olena-numbers-v3') {
                        wp_enqueue_style('olena-numbers-v3', plugins_url('build/olena/css/numbers/olena-numbers-v3.css', __FILE__));
                    }  
                    if ($ddp_css_grace == 'olena-numbers-v4') {
                        wp_enqueue_style('olena-numbers-v4', plugins_url('build/olena/css/numbers/olena-numbers-v4.css', __FILE__));
                    }  
                    if ($ddp_css_grace == 'olena-footer-v1') {
                        wp_enqueue_style('olena-footer-v1', plugins_url('build/olena/css/footers/olena-footers-v1.css', __FILE__));
                    }  
                    if ($ddp_css_grace == 'olena-footer-v2') {
                        wp_enqueue_style('olena-footer-v2', plugins_url('build/olena/css/footers/olena-footers-v2.css', __FILE__));
                    }  
                    if ($ddp_css_grace == 'olena-footer-v3') {
                        wp_enqueue_style('olena-footer-v3', plugins_url('build/olena/css/footers/olena-footers-v3.css', __FILE__));
                    }  
                    if ($ddp_css_grace == 'olena-footer-v4') {
                        wp_enqueue_style('olena-footer-v4', plugins_url('build/olena/css/footers/olena-footers-v4.css', __FILE__));
                    }  
                    if ($ddp_css_grace == 'olena-footer-v5') {
                        wp_enqueue_style('olena-footer-v5', plugins_url('build/olena/css/footers/olena-footers-v5.css', __FILE__));
                    }  
                    if ($ddp_css_grace == 'olena-footer-v7') {
                        wp_enqueue_style('olena-footer-v7', plugins_url('build/olena/css/footers/olena-footers-v7.css', __FILE__));
                    }  
                    if ($ddp_css_grace == 'olena-footer-v8') {
                        wp_enqueue_style('olena-footer-v8', plugins_url('build/olena/css/footers/olena-footers-v8.css', __FILE__));
                    }  
                    if ($ddp_css_grace == 'olena-footer-v9') {
                        wp_enqueue_style('olena-footer-v9', plugins_url('build/olena/css/footers/olena-footers-v9.css', __FILE__));
                    }  
                    if ($ddp_css_grace == 'olena-footer-v10') {
                        wp_enqueue_style('olena-footer-v10', plugins_url('build/olena/css/footers/olena-footers-v10.css', __FILE__));
                    }  
                    if ($ddp_css_grace == 'olena-footer-v11') {
                        wp_enqueue_style('olena-footer-v11', plugins_url('build/olena/css/footers/olena-footers-v11.css', __FILE__));
                    }  
                    if ($ddp_css_grace == 'olena-testimonial-v1') {
                        wp_enqueue_style('olena-testimonial-v1', plugins_url('build/olena/css/testimonials/olena-testimonial-v1.css', __FILE__));
                    }  
                    if ($ddp_css_grace == 'olena-testimonial-v2') {
                        wp_enqueue_style('olena-testimonial-v2', plugins_url('build/olena/css/testimonials/olena-testimonial-v2.css', __FILE__));
                    }  
                    if ($ddp_css_grace == 'olena-testimonial-v3') {
                        wp_enqueue_style('olena-testimonial-v3', plugins_url('build/olena/css/testimonials/olena-testimonial-v3.css', __FILE__));
                    }  
                    if ($ddp_css_grace == 'olena-testimonial-v4') {
                        wp_enqueue_style('olena-testimonial-v4', plugins_url('build/olena/css/testimonials/olena-testimonial-v4.css', __FILE__));
                    }  
                    if ($ddp_css_grace == 'olena-testimonial-v5') {
                        wp_enqueue_style('olena-testimonial-v5', plugins_url('build/olena/css/testimonials/olena-testimonial-v5.css', __FILE__));
                    }  
                    if ($ddp_css_grace == 'olena-testimonial-v6') {
                        wp_enqueue_style('olena-testimonial-v6', plugins_url('build/olena/css/testimonials/olena-testimonial-v6.css', __FILE__));
                    }  
                    if ($ddp_css_grace == 'olena-pt-v1') {
                        wp_enqueue_style('olena-pt-v1', plugins_url('build/olena/css/pricing-tables/olena-pricing-table-v1.css', __FILE__));
                    }
                    if ($ddp_css_grace == 'olena-architecture1-slide-text') {
                        wp_enqueue_style('olena-architecture1-slide-text', plugins_url('build/olena/css/pages/olena-architecture-V1.css', __FILE__));
                    }
                    if ($ddp_css_grace == 'olena-business1-slide-text') {
                        wp_enqueue_style('olena-business1-slide-text', plugins_url('build/olena/css/pages/olena-business-V1.css', __FILE__));
                    }
                    if ($ddp_css_grace == 'olena-creative1-slide-text') {
                        wp_enqueue_style('olena-creative1-slide-text', plugins_url('build/olena/css/pages/olena-creative-V1.css', __FILE__));
                    }
                    
    
                 }
               
            }//Olena ends
        } // end if($post)
    }  // end ddpdm_register_css($post_here)


    add_action('wp_footer', 'ddpdm_register_css');
    add_action('et_fb_enqueue_assets', 'ddpdm_register_css', 1);

    //======================================================================
    // LOAD JS BASED ON POST META
    //======================================================================

    function ddpdm_register_js($post_here)
    {
        if (!$post_here) {
            $post = get_post();
        } else {
            $post = $post_here;
        }

        if ($post) {

        // Fancybox
            wp_enqueue_script('ddpdm-fancybox-js', plugins_url('build/fancybox/fancybox.js', __FILE__));
//        wp_enqueue_script('ddpdm-fancybox-pack-js', plugins_url('build/fancybox/jquery.fancybox.pack.js', __FILE__));

            if (!empty(get_post_meta($post->ID, 'ddp-css-falkor'))) {
                wp_enqueue_script('ddpdm-falkor-js', plugins_url('build/falkor/js/falkor_divi.js', __FILE__), array( 'wp-i18n' ));
            }
            if (!empty(get_post_meta($post->ID, 'ddp-css-jackson'))) {
                wp_enqueue_script('ddpdm-jackson-js', plugins_url('build/jackson/js/jackson_divi.js', __FILE__), array( 'wp-i18n' ));
            }
            if (!empty(get_post_meta($post->ID, 'ddp-css-mermaid'))) {
                wp_enqueue_script('ddpdm-mermaid-js', plugins_url('build/mermaid/js/mermaid_divi.js', __FILE__));
            }
            if (!empty(get_post_meta($post->ID, 'ddp-css-mozart'))) {
                wp_enqueue_script('ddpdm-mozart-js', plugins_url('build/mozart/js/mozart_divi.js', __FILE__), array( 'wp-i18n' ));
            }
            if (!empty(get_post_meta($post->ID, 'ddp-css-pegasus'))) {
                wp_enqueue_script('ddpdm-pegasus-hoverdir-js', plugins_url('build/pegasus/js/pegasus-library.js', __FILE__));
                wp_enqueue_script('ddpdm-pegasus-js', plugins_url('build/pegasus/js/pegasus_divi.js', __FILE__), array( 'wp-i18n' ));
            }
            if (!empty(get_post_meta($post->ID, 'ddp-css-pixie'))) {
                wp_enqueue_script('ddpdm-pixie-js', plugins_url('build/pixie/js/pixie_divi.js', __FILE__));
            }
            if (!empty(get_post_meta($post->ID, 'ddp-css-unicorn'))) {
                wp_enqueue_script('ddpdm-unicorn-js', plugins_url('build/unicorn/js/unicorn_divi.js', __FILE__), array( 'wp-i18n' ));
            }
            // Venus
            if (!empty(get_post_meta($post->ID, 'ddp-css-venus'))) {
                wp_enqueue_script('ddpdm-venus-charming-js', plugins_url('build/venus/js/venus-library.js', __FILE__));
                foreach ((array) get_post_meta($post->ID, 'ddp-css-venus') as $ddpdm_css_venus) {
                    if ($ddpdm_css_venus == 'blog') {
                        wp_enqueue_script('ddpdm-venus-blog-js', plugins_url('build/venus/js/venus-blog.js', __FILE__));
                    }
                    if ($ddpdm_css_venus == 'cta') {
                        wp_enqueue_script('ddpdm-venus-cta-js', plugins_url('build/venus/js/venus-cta.js', __FILE__));
                    }
                    if ($ddpdm_css_venus == 'faq') {
                        wp_enqueue_script('ddpdm-venus-faq-js', plugins_url('build/venus/js/venus-faq.js', __FILE__));
                    }
                    if ($ddpdm_css_venus == 'features') {
                        wp_enqueue_script('ddpdm-venus-features-js', plugins_url('build/venus/js/venus-features.js', __FILE__));
                    }
                    if ($ddpdm_css_venus == 'form' || $ddpdm_css_venus == 'contact') {
                        wp_enqueue_script('ddpdm-venus-form-js', plugins_url('build/venus/js/venus-form.js', __FILE__));
                    }
                    if ($ddpdm_css_venus == 'header') {
                        wp_enqueue_script('ddpdm-venus-header-js', plugins_url('build/venus/js/venus-header.js', __FILE__));
                        wp_enqueue_script('ddpdm-venus-features-js', plugins_url('build/venus/js/venus-features.js', __FILE__));
                    }
                    if ($ddpdm_css_venus == 'person') {
                        wp_enqueue_script('ddpdm-venus-person-js', plugins_url('build/venus/js/venus-person.js', __FILE__));
                    }
                    if ($ddpdm_css_venus == 'pricing-tables') {
                        wp_enqueue_script('ddpdm-venus-pricint-tables-js', plugins_url('build/venus/js/venus-pricing-tables.js', __FILE__));
                    }
                    if ($ddpdm_css_venus == 'subscribe') {
                        wp_enqueue_script('ddpdm-venus-subscribe-js', plugins_url('build/venus/js/venus-subscribe.js', __FILE__));
                    }
                }
            }
            // Sigmund

            if (!empty(get_post_meta($post->ID, 'ddp-css-sigmund'))) {
                foreach ((array) get_post_meta($post->ID, 'ddp-css-sigmund') as $ddpdm_css_sigmund) {
                    if ($ddpdm_css_sigmund == 'persons') {
                        wp_enqueue_script('ddpdm-sigmund-hoverdir-js', plugins_url('build/venus/js/venus-library.js', __FILE__));
                        wp_enqueue_script('ddpdm-sigmund-persons-js', plugins_url('build/sigmund/js/persons-sigmund.js', __FILE__));
                    }
                    if ($ddpdm_css_sigmund == 'portfolio') {
                        wp_enqueue_script('ddpdm-sigmund-masonry-js', plugins_url('build/venus/js/masonry.pkgd.min.js', __FILE__));
                        wp_enqueue_script('ddpdm-sigmund-portfolio-js', plugins_url('build/sigmund/js/portfolio-sigmund.js', __FILE__));
                    }
                    if ($ddpdm_css_sigmund == 'testimonials') {
                        wp_enqueue_script('ddpdm-sigmund-testimonials-js', plugins_url('build/sigmund/js/testimonial-sigmund.js', __FILE__));
                    }
                    if ($ddpdm_css_sigmund == 'tabs') {
                        wp_enqueue_script('ddpdm-sigmund-tabs-js', plugins_url('build/sigmund/js/tabs-sigmund.js', __FILE__));
                    }
                    if ($ddpdm_css_sigmund == 'accordion') {
                        wp_enqueue_script('ddpdm-sigmund-accordion-js', plugins_url('build/sigmund/js/accordion-sigmund.js', __FILE__));
                    }
                    if ($ddpdm_css_sigmund == 'contact' || $ddpdm_css_sigmund == 'forms' || $ddpdm_css_sigmund == 'contact-pages') {
                        wp_enqueue_script('ddpdm-sigmund-accordion-js', plugins_url('build/sigmund/js/accordion-sigmund.js', __FILE__));
                        wp_enqueue_script('ddpdm-sigmund-blog-js', plugins_url('build/sigmund/js/blog-sigmund.js', __FILE__));
                        wp_enqueue_script('ddpdm-sigmund-contact-js', plugins_url('build/sigmund/js/contact-forms-sigmund.js', __FILE__));
                        wp_enqueue_script('ddpdm-sigmund-newsletter-js', plugins_url('build/sigmund/js/newsletter-sigmund.js', __FILE__));
                        wp_enqueue_script('ddpdm-sigmund-typed-js', plugins_url('build/sigmund/js/typed-sigmund.js', __FILE__));
                        wp_enqueue_script('ddpdm-sigmund-typing-js', plugins_url('build/sigmund/js/typing-sigmund.js', __FILE__));
                        wp_enqueue_script('ddpdm-sigmund-slider-js', plugins_url('build/sigmund/js/slider-sigmund.js', __FILE__));
                    }
                    if ($ddpdm_css_sigmund == 'footers') {
                        wp_enqueue_script('ddpdm-sigmund-newsletter-js', plugins_url('build/sigmund/js/newsletter-sigmund.js', __FILE__));
                    }
                    if ($ddpdm_css_sigmund == 'headers') {
                        wp_enqueue_script('ddpdm-sigmund-typed-js', plugins_url('build/sigmund/js/typed-sigmund.js', __FILE__));
                        wp_enqueue_script('ddpdm-sigmund-typing-js', plugins_url('build/sigmund/js/typing-sigmund.js', __FILE__));
                        wp_enqueue_script('ddpdm-sigmund-service-page1-js', plugins_url('build/sigmund/js/sigmund-services-1.js', __FILE__));
                    }

                    if ($ddpdm_css_sigmund == 'office') {
                        wp_enqueue_script('ddpdm-sigmund-contact-js', plugins_url('build/sigmund/js/contact-forms-sigmund.js', __FILE__));
                        wp_enqueue_script('ddpdm-sigmund-newsletter-js', plugins_url('build/sigmund/js/newsletter-sigmund.js', __FILE__));
                    }

                    if ($ddpdm_css_sigmund == 'services-page1') {
                        wp_enqueue_script('ddpdm-sigmund-testimonials-js', plugins_url('build/sigmund/js/testimonial-sigmund.js', __FILE__));
                        wp_enqueue_script('ddpdm-sigmund-service-page1-js', plugins_url('build/sigmund/js/sigmund-services-1.js', __FILE__));
                        wp_enqueue_script('ddpdm-sigmund-pricing-tables-js', plugins_url('build/sigmund/js/sigmund-pricing-tables.js', __FILE__));
                    }

                    if ($ddpdm_css_sigmund == 'table-page1') {
                        wp_enqueue_script('ddpdm-sigmund-testimonials-js', plugins_url('build/sigmund/js/testimonial-sigmund.js', __FILE__));
                        wp_enqueue_script('ddpdm-sigmund-pricing-tables-js', plugins_url('build/sigmund/js/sigmund-pricing-tables.js', __FILE__));
                    }
                    if ($ddpdm_css_sigmund == 'pricing-tables') {
                        wp_enqueue_script('ddpdm-sigmund-pricing-tables-js', plugins_url('build/sigmund/js/sigmund-pricing-tables.js', __FILE__));
                    }
                }
            }

            // Jamie

            if (!empty(get_post_meta($post->ID, 'ddp-css-jamie'))) {
                wp_enqueue_script('ddpdm-jamie-masonry-js', plugins_url('build/pegasus/js/masonry.pkgd.min.js', __FILE__));
                wp_enqueue_script('ddpdm-jamie-js', plugins_url('build/jamie/js/jamie_divi.js', __FILE__));
            }

            // Impi
            if (!empty(get_post_meta($post->ID, 'ddp-css-impi'))) {
                wp_enqueue_script('ddpdm-impi-fancybox-js', plugins_url('build/impi/js/impi-fancybox.js', __FILE__));
                foreach ((array) get_post_meta($post->ID, 'ddp-css-impi') as $ddpdm_css_impi) {
                    if ($ddpdm_css_impi == 'testimonials') {
                        wp_enqueue_script('ddpdm-impi-tesimonials-js', plugins_url('build/impi/js/impi-testimonials.js', __FILE__));
                    }
                    if ($ddpdm_css_impi == 'persons') {
                        wp_enqueue_script('ddpdm-impi-persons-js', plugins_url('build/impi/js/impi-persons.js', __FILE__));
                    }

                    if ($ddpdm_css_impi == 'blogs') {
                        wp_enqueue_script('ddpdm-impi-blog-js', plugins_url('build/impi/js/impi-blog.js', __FILE__));
                    }

                    if ($ddpdm_css_impi == 'sliders' || $ddpdm_css_impi == 'headers') {
                        wp_enqueue_script('ddpdm-impi-sliders-js', plugins_url('build/impi/js/impi-sliders.js', __FILE__));
                    }

                    if ($ddpdm_css_impi == 'forms') {
                        wp_enqueue_script('ddpdm-impi-forms-js', plugins_url('build/impi/js/impi-contact-forms.js', __FILE__));
                    }

                    if ($ddpdm_css_impi == 'contents') {
                        wp_enqueue_script('ddpdm-impi-contents-js', plugins_url('build/impi/js/impi-contents.js', __FILE__));
                    }

                    if ($ddpdm_css_impi == 'faq') {
                        wp_enqueue_script('ddpdm-impi-faq-js', plugins_url('build/impi/js/impi-faq.js', __FILE__));
                    }

                    if ($ddpdm_css_impi == 'portfolio') {
                        wp_enqueue_script('ddpdm-impi-hoverdir-js', plugins_url('build/pegasus/js/pegasus-library.js', __FILE__));
                        wp_enqueue_script('ddpdm-impi-portfolio-js', plugins_url('build/impi/js/impi-portfolio.js', __FILE__));
                    }

                    if ($ddpdm_css_impi == 'pricing-tables') {
                        wp_enqueue_script('ddpdm-impi-pricing-tables-js', plugins_url('build/impi/js/impi-pricing.js', __FILE__));
                    }
                }
            }


            // Coco
            if (!empty(get_post_meta($post->ID, 'ddp-css-coco'))) {
                foreach ((array) get_post_meta($post->ID, 'ddp-css-coco') as $ddpdm_css_coco) {
                    if ($ddpdm_css_coco == 'newsletter' || $ddpdm_css_coco == 'footers') {
                        wp_enqueue_script('ddpdm-coco-newsletter-js', plugins_url('build/coco/js/newsletter-coco.js', __FILE__));
                    }

                    if ($ddpdm_css_coco == 'sliders' || $ddpdm_css_coco == 'headers' || $ddpdm_css_coco == 'persons') {
                        wp_enqueue_script('ddpdm-coco-sliders-js', plugins_url('build/coco/js/sliders-coco.js', __FILE__));
                        wp_enqueue_script('ddpdm-coco-socials-js', plugins_url('build/coco/js/socials-coco.js', __FILE__), array( 'wp-i18n' ));
                    }

                    if ($ddpdm_css_coco == 'image-loader') {
                        wp_enqueue_script('ddpdm-coco-image-loader-js', plugins_url('build/coco/js/image-load-coco.js', __FILE__));
                    }

                    if ($ddpdm_css_coco == 'testimonials') {
                        wp_enqueue_script('ddpdm-coco-testimonials-js', plugins_url('build/coco/js/testimonials-coco.js', __FILE__));
                    }

                    if ($ddpdm_css_coco == 'content') {
                        wp_enqueue_script('ddpdm-coco-contents-js', plugins_url('build/coco/js/contents-coco.js', __FILE__));
                        wp_enqueue_script('ddpdm-coco-animations-js', plugins_url('build/coco/js/sections-add-class-coco.js', __FILE__));
                    }

                    if ($ddpdm_css_coco == 'pricing-tables') {
                        wp_enqueue_script('ddpdm-coco-pricing-tables-js', plugins_url('build/coco/js/pricing-tables-coco.js', __FILE__));
                    }

                    if ($ddpdm_css_coco == 'persons') {
                        wp_enqueue_script('ddpdm-coco-persons-js', plugins_url('build/coco/js/persons-coco.js', __FILE__));
                    }

                    if ($ddpdm_css_coco == 'portfolio') {
                        wp_enqueue_script('ddpdm-coco-portfolio-js', plugins_url('build/coco/js/portfolio-coco.js', __FILE__));
                    }

                    if ($ddpdm_css_coco == 'forms') {
                        wp_enqueue_script('ddpdm-coco-forms-js', plugins_url('build/coco/js/contact-forms-coco.js', __FILE__));
                    }

                    if ($ddpdm_css_coco == 'products') {
                        wp_enqueue_script('ddpdm-coco-products-js', plugins_url('build/coco/js/single-product-woo-coco.js', __FILE__));
                    }
                }
            }

            // Demo

            if (!empty(get_post_meta($post->ID, 'ddp-css-demo'))) {
                foreach ((array) get_post_meta($post->ID, 'ddp-css-demo') as $ddpdm_css_demo) {
                    if ($ddpdm_css_demo == 'demo-band-page') {
                        wp_enqueue_script('ddpdm-demo-band-js', plugins_url('build/demo/js/demo-band.js', __FILE__));
                    }

                    if ($ddpdm_css_demo == 'demo-florist') {
                        wp_enqueue_script('ddpdm-demo-florist-page-js', plugins_url('build/demo/js/demo-florist.js', __FILE__));
                    }

                    if ($ddpdm_css_demo == 'demo-flooring') {
                        wp_enqueue_script('ddpdm-demo-flooring-page-js', plugins_url('build/demo/js/demo-flooring.js', __FILE__));
                    }

                    if ($ddpdm_css_demo == 'demo-eat-your-slider') {
                        wp_enqueue_script('ddpdm-demo-eat-your-slider-js', plugins_url('build/demo/js/demoEatYourSlider.js', __FILE__));
                    }

                    if ($ddpdm_css_demo == 'demo-marina') {
                        wp_enqueue_script('ddpdm-demo-marina-page-js', plugins_url('build/demo/js/demo-marina.js', __FILE__));
                    }

                    if ($ddpdm_css_demo == 'demo-fight') {
                        wp_enqueue_script('ddpdm-demo-fight-page-js', plugins_url('build/demo/js/demo-fight.js', __FILE__));
                    }

                    if ($ddpdm_css_demo == 'demo-spa-home') {
                        wp_enqueue_script('ddpdm-demo-spa-home-page-js', plugins_url('build/demo/js/demoSpaHome.js', __FILE__));
                    }

                    if ($ddpdm_css_demo == 'styling-home') {
                        wp_enqueue_script('ddpdm-styling-home-page-js', plugins_url('build/demo/js/demoStylingHome.js', __FILE__));
                    }
                }
            }

            // Diana

            if (!empty(get_post_meta($post->ID, 'ddp-css-diana'))) {
                foreach ((array) get_post_meta($post->ID, 'ddp-css-diana') as $ddpdm_css_diana) {
                    if ($ddpdm_css_diana == 'diana-blogs') {
                        wp_enqueue_script('ddpdm-blogs-js', plugins_url('build/diana/js/diana-blogs.js', __FILE__));
                    }

                    if ($ddpdm_css_diana == 'diana-blurbs') {
                        wp_enqueue_script('ddpdm-blurbs-js', plugins_url('build/diana/js/diana-blurbs.js', __FILE__));
                    }

                    if ($ddpdm_css_diana == 'diana-persons') {
                        wp_enqueue_script('ddpdm-persons-js', plugins_url('build/diana/js/diana-persons.js', __FILE__));
                    }

                    if ($ddpdm_css_diana == 'diana-sliders' || $ddpdm_css_diana == 'diana-headers') {
                        wp_enqueue_script('ddpdm-sliders-js', plugins_url('build/diana/js/diana-sliders.js', __FILE__));
                        wp_enqueue_script('ddpdm-social-icons-js', plugins_url('build/diana/js/diana-social-icons.js', __FILE__), array( 'wp-i18n' ));
                    }

                    if ($ddpdm_css_diana == 'diana-testimonials') {
                        wp_enqueue_script('ddpdm-testimonials-js', plugins_url('build/diana/js/diana-testimonials.js', __FILE__));
                    }

                    if ($ddpdm_css_diana == 'diana-footers') {
                        wp_enqueue_script('ddpdm-footers-js', plugins_url('build/diana/js/diana-footers.js', __FILE__));
                    }

                    if ($ddpdm_css_diana == 'diana-contents') {
                        wp_enqueue_script('ddpdm-contents-js', plugins_url('build/diana/js/diana-contents.js', __FILE__));
                    }

                    if ($ddpdm_css_diana == 'diana-vetical-coming-soon' || $ddpdm_css_diana == 'diana-full-width-under-construction') {
                        wp_enqueue_script('ddpdm-coming-soon-js', plugins_url('build/diana/js/dianaComingSoon.js', __FILE__));
                    }

                    if ($ddpdm_css_diana == 'diana-single-post-v1') {
                        wp_enqueue_script('ddpdm-diana-single-post-js', plugins_url('build/diana/js/dianaSinglePost.js', __FILE__));
                    }

                    if ($ddpdm_css_diana == 'diana-sticky-bars') {
                        wp_enqueue_script('ddpdm-diana-sticky-bars-cookies-js', plugins_url('build/diana/js/diana-jquery.cookie.js', __FILE__));
                        wp_enqueue_script('ddpdm-diana-sticky-bars-js', plugins_url('build/diana/js/dianaStickyHeaders.js', __FILE__));
                        $ddpdm_dataToBePassed = array(
                        'ddpdm_sticky_delay'  => get_option('ddpdm_sticky_bar_delay'),
                        'ddpdm_sticky_cookie_days'  => get_option('ddpdm_sticky_bar_cookie_days'),
                        'ddpdm_sticky_show_leave'  => get_theme_mod('ddpdm_sticky_show_leave', false),
                        'ddpdm_sticky_bar_position' => get_option('ddpdm_sticky_bar_sticky'),
                        'ddpdm_sticky_show_scroll'  => get_theme_mod('ddpdm_sticky_show_scroll', false),
                        'ddpdm_sticky_bar_scroll_per' => get_option('ddpdm_sticky_bar_scroll_per'),
                        'ddpdm_pop_template'  => get_option('ddpdm_pop_up_template'),
                        'ddpdm_pop_show_load' => get_theme_mod('ddpdm_pop_up_show_load', false),
                        'ddpdm_pop_delay'  => get_option('ddpdm_pop_up_delay'),
                        'ddpdm_pop_show_leave'  => get_theme_mod('ddpdm_pop_up_show_leave', false),
                        'ddpdm_pop_show_scroll'  => get_theme_mod('ddpdm_pop_up_show_scroll', false),
                        'ddpdm_pop_scroll_per' => get_option('ddpdm_pop_up_scroll_per'),
                    );
                        wp_localize_script('ddpdm-diana-sticky-bars-js', 'ddpdm_php_vars', $ddpdm_dataToBePassed);
                    }

                    if ($ddpdm_css_diana == 'diana-pop-up') {
                        wp_enqueue_script('ddpdm-diana-cookies-js', plugins_url('build/diana/js/diana-jquery.cookie.js', __FILE__));
                        wp_enqueue_script('ddpdm-diana-pop-up-js', plugins_url('build/diana/js/dianaPopups.js', __FILE__));
                        $ddpdm_dataToBePassed = array(
                            'ddpdm_pop_template'  => get_option('ddpdm_pop_up_template'),
                            'ddpdm_pop_show_load' => get_theme_mod('ddpdm_pop_up_show_load', false),
                            'ddpdm_pop_delay'  => get_option('ddpdm_pop_up_delay'),
                            'ddpdm_pop_show_leave'  => get_theme_mod('ddpdm_pop_up_show_leave', false),
                            'ddpdm_pop_show_scroll'  => get_theme_mod('ddpdm_pop_up_show_scroll', false),
                            'ddpdm_pop_scroll_per' => get_option('ddpdm_pop_up_scroll_per'),
                            'ddpdm_sticky_delay'  => get_option('ddpdm_sticky_bar_delay'),
                            'ddpdm_sticky_cookie_days'  => get_option('ddpdm_sticky_bar_cookie_days'),
                            'ddpdm_sticky_show_leave'  => get_theme_mod('ddpdm_sticky_show_leave', false),
                            'ddpdm_sticky_bar_position' => get_option('ddpdm_sticky_bar_sticky'),
                            'ddpdm_sticky_show_scroll'  => get_theme_mod('ddpdm_sticky_show_scroll', false),
                            'ddpdm_sticky_bar_scroll_per' => get_option('ddpdm_sticky_bar_scroll_per'),
                        );
                        wp_localize_script('ddpdm-diana-pop-up-js', 'ddpdm_php_vars', $ddpdm_dataToBePassed);
                    }
                    if ($ddpdm_css_diana == 'diana-pricing-tables') {
                        wp_enqueue_script('ddpdm-diana-pricing-tables-js', plugins_url('build/diana/js/diana-pt.js', __FILE__));
                    }
                    if ($ddpdm_css_diana == 'diana-ruling-header') {
                        wp_enqueue_script('ddpdm-diana-ruling-header-js', plugins_url('build/diana/js/dianaRulingHeader.js', __FILE__));
                    }
                    if ($ddpdm_css_diana == 'diana-fashion-header') {
                        wp_enqueue_script('ddpdm-diana-fashion-header-js', plugins_url('build/diana/js/dianaFashionHeader.js', __FILE__));
                    }

                    if ($ddpdm_css_diana == 'diana-authoritative-products') {
                        wp_enqueue_script('ddpdm-diana-tilt-js', plugins_url('build/diana/js/tilt.jquery.js', __FILE__));
                        wp_enqueue_script('ddpdm-diana-authoritative-products-js', plugins_url('build/diana/js/dianaAuthoritativeProducts.js', __FILE__));
                    }

                    if ($ddpdm_css_diana == 'diana-cling-to-testimonial') {
                        wp_enqueue_script('ddpdm-diana-cling-to-testimonial-js', plugins_url('build/diana/js/dianaClingToTestimonial.js', __FILE__));
                    }

                    if ($ddpdm_css_diana == 'diana-woodwork-header') {
                        wp_enqueue_script('ddpdm-diana-woodwork-header-js', plugins_url('build/diana/js/dianaWoodWorkHeader.js', __FILE__));
                    }

                    if ($ddpdm_css_diana == 'diana-content-always-know') {
                        wp_enqueue_script('ddpdm-diana-content-always-know-js', plugins_url('build/diana/js/diana-services-1/dianaContentAlwaysKnow.js', __FILE__));
                    }

                    if ($ddpdm_css_diana == 'diana-blurbs-just-our') {
                        wp_enqueue_script('ddpdm-diana-blurbs-just-our-js', plugins_url('build/diana/js/diana-services-2/dianaBlurbsJustOur.js', __FILE__));
                    }

                    if ($ddpdm_css_diana == 'diana-blurbs-goodbye') {
                        wp_enqueue_script('ddpdm-diana-blurbs-goodbye-js', plugins_url('build/diana/js/diana-services-2/dianaBlurbsGoodbye.js', __FILE__));
                    }


                    // menus
                    if ($ddpdm_css_diana == 'diana_menu_1') {
                        wp_enqueue_script('ddpdm-diana-menu1-js', plugins_url('build/diana/js/diana-menu.js', __FILE__));
                    }
                    if ($ddpdm_css_diana == 'diana_menu_2') {
                        wp_enqueue_script('ddpdm-diana-menu2-js', plugins_url('build/diana/js/diana-menu-2.js', __FILE__));
                    }
                    if ($ddpdm_css_diana == 'diana_menu_3') {
                        wp_enqueue_script('ddpdm-diana-menu3-js', plugins_url('build/diana/js/diana-menu-3.js', __FILE__));
                    }
                    if ($ddpdm_css_diana == 'diana_menu_4') {
                        wp_enqueue_script('ddpdm-diana-menu4-js', plugins_url('build/diana/js/dianaNavMenuArch.js', __FILE__));
                    }
                    if ($ddpdm_css_diana == 'diana_menu_5') {
                        wp_enqueue_script('ddpdm-diana-menu5-js', plugins_url('build/diana/js/dianaNavMenuFirst.js', __FILE__));
                    }
                    if ($ddpdm_css_diana == 'diana_menu_6') {
                        wp_enqueue_script('ddpdm-diana-menu6-js', plugins_url('build/diana/js/dianaNavMenuChampion.js', __FILE__));
                    }
                    if ($ddpdm_css_diana == 'diana_menu_7') {
                        wp_enqueue_script('ddpdm-diana-menu7-js', plugins_url('build/diana/js/dianaNavMenuFront.js', __FILE__));
                    }
                    if ($ddpdm_css_diana == 'diana_menu_8') {
                        wp_enqueue_script('ddpdm-diana-menu8-js', plugins_url('build/diana/js/dianaNavMenuLeading.js', __FILE__));
                    }
                    if ($ddpdm_css_diana == 'diana_menu_9') {
                        wp_enqueue_script('ddpdm-diana-menu9-js', plugins_url('build/diana/js/dianaNavMenuMain.js', __FILE__));
                    }
                    if ($ddpdm_css_diana == 'diana_menu_10') {
                        wp_enqueue_script('ddpdm-diana-menu10-js', plugins_url('build/diana/js/dianaNavMenuPioneer.js', __FILE__));
                    }
                    if ($ddpdm_css_diana == 'diana_menu_11') {
                        wp_enqueue_script('ddpdm-diana-menu11-js', plugins_url('build/diana/js/dianaNavMenuPremier.js', __FILE__));
                    }
                    if ($ddpdm_css_diana == 'diana_menu_12') {
                        wp_enqueue_script('ddpdm-diana-menu12-js', plugins_url('build/diana/js/dianaNavMenuPrime.js', __FILE__));
                    }
                    if ($ddpdm_css_diana == 'diana_menu_13') {
                        wp_enqueue_script('ddpdm-diana-menu13-js', plugins_url('build/diana/js/dianaNavMenuPrincipal.js', __FILE__));
                    }
                    if ($ddpdm_css_diana == 'diana_menu_14') {
                        wp_enqueue_script('ddpdm-diana-menu14-js', plugins_url('build/diana/js/dianaNavMenuStellar.js', __FILE__));
                    }
                }
            }

            // Freddie

            if (!empty(get_post_meta($post->ID, 'ddp-css-freddie'))) {
                foreach ((array) get_post_meta($post->ID, 'ddp-css-freddie') as $ddpdm_css_freddie) {
                    // gsap
                    if ($ddpdm_css_freddie == 'freddie-blue-eyed-person-module' || $ddpdm_css_freddie == 'freddie-the-bones-person-module' || $ddpdm_css_freddie == 'freddie-singing-person-module' || $ddpdm_css_freddie == 'freddie-thank-you-person-module' || $ddpdm_css_freddie == 'freddie-menu-prize' || $ddpdm_css_freddie == 'freddie-menu-attac-dragon' || $ddpdm_css_freddie == 'freddie-contents'  || $ddpdm_css_freddie == 'freddie-blurbs' || $ddpdm_css_freddie == 'freddie-buttons' || $ddpdm_css_freddie == 'freddie-headers' || $ddpdm_css_freddie == 'freddie-footers' || $ddpdm_css_freddie == 'freddie-testimonials' || $ddpdm_css_freddie == 'freddie-sliders' || $ddpdm_css_freddie == 'freddie-pricing-tables' || $ddpdm_css_freddie == 'freddie-menu-earth' || $ddpdm_css_freddie == 'freddie-menu-funny-love' || $ddpdm_css_freddie == 'freddie-menu-hang-on-in-there' || $ddpdm_css_freddie == 'freddie-menu-lover-boy' || $ddpdm_css_freddie == 'freddie-menu-hijack-my-heart' || $ddpdm_css_freddie == 'freddie-blogs' || $ddpdm_css_freddie == 'freddie-persons' ||  $ddpdm_css_freddie == 'freddie-more-info' ||  $ddpdm_css_freddie == 'freddie-song-slider' ||  $ddpdm_css_freddie == 'freddie-music' || $ddpdm_css_freddie == 'freddie-cta' || $ddpdm_css_freddie == 'freddie-footers' || $ddpdm_css_freddie == 'freddie-process-circle' || $ddpdm_css_freddie == 'freddie-header-not-dead'  || $ddpdm_css_freddie == 'freddie-sidewalk-header'  || $ddpdm_css_freddie == 'freddie-sweet-lady-slider' || $ddpdm_css_freddie == 'freddie-product-details-webdesign-package' || $ddpdm_css_freddie =='freddie-the-line-blurb' || $ddpdm_css_freddie =='freddie-satisfied-blurb' || $ddpdm_css_freddie =='freddie-steps-nearer-blurb' || $ddpdm_css_freddie =='freddie-your-time-blurb' || $ddpdm_css_freddie =='freddie-on-my-way-blurb' || $ddpdm_css_freddie =='freddie-person-module-skinny-lad' || $ddpdm_css_freddie =='freddie-bali-header' || $ddpdm_css_freddie =='freddie-gallery-oooh-yeah' || $ddpdm_css_freddie =='freddie-gallery-my-friend' || $ddpdm_css_freddie =='freddie-author-1' || $ddpdm_css_freddie ==' freddie-footer-keep-yourself-alive' || $ddpdm_css_freddie =='freddie-content-lap-of-the-gods') {
                        wp_enqueue_script('ddpdm-freddie-gsap-jquery-js', plugins_url('build/freddie/js/gsap/gsap.min.js', __FILE__));
                        wp_enqueue_script('ddpdm-freddie-load-draw-svg-js', plugins_url('build/freddie/js/gsap/LoadDrawSVGPlugin.js', __FILE__));
                    }
                    if ($ddpdm_css_freddie == 'freddie-transitions' || $ddpdm_css_freddie == 'freddie-contents') {
                        wp_enqueue_script('ddpdm-freddie-transitions-js', plugins_url('build/freddie/js/freddieScriptPageTransition.js', __FILE__));
                    }

                    // menu templates
                    if ($ddpdm_css_freddie == 'freddie-menu-prize') {
                        wp_enqueue_script('ddpdm-freddie-menu-prize-js', plugins_url('build/freddie/js/freddieScriptPrizeMenu.js', __FILE__));
                    }
                    if ($ddpdm_css_freddie == 'freddie-menu-attac-dragon') {
                        wp_enqueue_script('ddpdm-freddie-menu-attac-dragon-js', plugins_url('build/freddie/js/freddieScriptAttackDragonMenu.js', __FILE__));
                    }

                    if ($ddpdm_css_freddie == 'freddie-menu-earth') {
                        wp_enqueue_script('ddpdm-freddie-menu-earth-js', plugins_url('build/freddie/js/freddieScriptEarthMenu.js', __FILE__));
                    }

                    if ($ddpdm_css_freddie == 'freddie-menu-funny-love') {
                        wp_enqueue_script('ddpdm-freddie-menu-funny-love-js', plugins_url('build/freddie/js/freddieScriptFunnyHowLoveMenu.js', __FILE__));
                    }

                    if ($ddpdm_css_freddie == 'freddie-menu-hang-on-in-there') {
                        wp_enqueue_script('ddpdm-freddie-menu-hang-on-in-there-js', plugins_url('build/freddie/js/freddieScriptHangOnInThereMenu.js', __FILE__));
                    }

                    if ($ddpdm_css_freddie == 'freddie-menu-lover-boy') {
                        wp_enqueue_script('ddpdm-freddie-menu-lover-boy-js', plugins_url('build/freddie/js/freddieScriptLoverBoyMenu.js', __FILE__));
                    }

                    if ($ddpdm_css_freddie == 'freddie-menu-hijack-my-heart') {
                        wp_enqueue_script('ddpdm-freddie-menu-hijack-my-heart-js', plugins_url('build/freddie/js/freddieHijackMyHeart.js', __FILE__));
                    }

                    // usual modules
                    if ($ddpdm_css_freddie == 'freddie-headers') {
                        wp_enqueue_script('ddpdm-freddie-headers-socials', plugins_url('build/freddie/js/socials-freddie.js', __FILE__));
                        wp_enqueue_script('ddpdm-freddie-headers-three', plugins_url('build/freddie/js/freddie-library.js', __FILE__));
//                    wp_enqueue_script('ddpdm-freddie-headers-three', plugins_url('build/freddie/js/three.min.js', __FILE__));
//                    wp_enqueue_script('ddpdm-freddie-headers-hovers', plugins_url('build/freddie/js/hover-effect.umd.js', __FILE__));
                        wp_enqueue_script('ddpdm-freddie-headers-js', plugins_url('build/freddie/js/freddieScriptsHeaders.js', __FILE__));
                    }
                    if ($ddpdm_css_freddie == 'freddie-header-not-dead') {
                        wp_enqueue_script('ddpdm-freddie-headers-socials', plugins_url('build/freddie/js/socials-freddie.js', __FILE__));
                        wp_enqueue_script('ddpdm-freddie-headers-js', plugins_url('build/freddie/js/freddieScriptsHeaders.js', __FILE__));
                        wp_enqueue_script('ddpdm-freddie-header-not-dead-pixi-js', plugins_url('build/freddie/js/pixi.min.js', __FILE__));
                        wp_enqueue_script('ddpdm-freddie-header-not-dead-js', plugins_url('build/freddie/js/freddieNotDeadHeader.js', __FILE__));
                    }
                    if ($ddpdm_css_freddie == 'freddie-contents') {
                        wp_enqueue_script('ddpdm-freddie-contents-js', plugins_url('build/freddie/js/freddieScriptsContents.js', __FILE__));
                    }
                    if ($ddpdm_css_freddie == 'freddie-footers') {
                        wp_enqueue_script('ddpdm-freddie-newsletter-js', plugins_url('build/freddie/js/freddieNewsletter.js', __FILE__));
                        wp_enqueue_script('ddpdm-freddie-footers-js', plugins_url('build/freddie/js/freddieScriptsFooters.js', __FILE__));
                    }
                    if ($ddpdm_css_freddie == 'freddie-accordions') {
                        wp_enqueue_script('ddpdm-freddie-accordions-js', plugins_url('build/freddie/js/freddieScriptsAccordions.js', __FILE__));
                    }
                    if ($ddpdm_css_freddie == 'freddie-blogs') {
                        wp_enqueue_script('ddpdm-freddie-blogs-js', plugins_url('build/freddie/js/freddieScriptsBlogs.js', __FILE__));
                    }
                    if ($ddpdm_css_freddie == 'freddie-blurbs') {
                        wp_enqueue_script('ddpdm-freddie-blurbs-js', plugins_url('build/freddie/js/freddieScriptsBlurbs.js', __FILE__));
                    }
                    if ($ddpdm_css_freddie == 'freddie-persons') {
                        wp_enqueue_script('ddpdm-freddie-persons-js', plugins_url('build/freddie/js/freddieScriptsPersons.js', __FILE__));
                    }
                    if ($ddpdm_css_freddie == 'freddie-pricing-tables') {
                        wp_enqueue_script('ddpdm-freddie-pricing-tables-js', plugins_url('build/freddie/js/freddieScriptsPricingTables.js', __FILE__), array( 'wp-i18n' ));
                    }
                    if ($ddpdm_css_freddie == 'freddie-sliders') {
                        wp_enqueue_script('ddpdm-freddie-sliders-js', plugins_url('build/freddie/js/freddieScriptsSliders.js', __FILE__));
                    }
                    if ($ddpdm_css_freddie == 'freddie-testimonials') {
                        wp_enqueue_script('ddpdm-freddie-testimonial-js', plugins_url('build/freddie/js/freddieScriptsTestimonials.js', __FILE__));
                    }
                    if ($ddpdm_css_freddie == 'freddie-more-info') {
                        wp_enqueue_script('ddpdm-freddie-more-info-js', plugins_url('build/freddie/js/freddieMoreInfo.js', __FILE__));
                    }
                    if ($ddpdm_css_freddie == 'freddie-album') {
                        wp_enqueue_script('ddpdm-freddie-album-js', plugins_url('build/freddie/js/freddieScriptAlbum.js', __FILE__));
                    }
                    if ($ddpdm_css_freddie == 'freddie-song-slider') {
                        wp_enqueue_script('ddpdm-freddie-song-slider-js', plugins_url('build/freddie/js/freddieScriptSongSlider.js', __FILE__));
                    }
                    if ($ddpdm_css_freddie == 'freddie-music') {
                        wp_enqueue_script('ddpdm-freddie-music-js', plugins_url('build/freddie/js/freddieScriptMusic.js', __FILE__), array( 'wp-i18n' ));
                    }
                    if ($ddpdm_css_freddie == 'freddie-cta') {
                        wp_enqueue_script('ddpdm-freddie-cta-js', plugins_url('build/freddie/js/freddieScriptCta.js', __FILE__));
                    }
                    if ($ddpdm_css_freddie == 'freddie-process-circle') {
                        wp_enqueue_script('ddpdm-freddie-process-circle-js', plugins_url('build/freddie/js/freddieScriptProcessCircle.js', __FILE__));
                    }
                    if ($ddpdm_css_freddie == 'freddie-sidewalk-header') {
                        wp_enqueue_script('ddpdm-freddie-sidewalk-header-js', plugins_url('build/freddie/js/freddieSidewalkHeader.js', __FILE__));
                    }
                    if ($ddpdm_css_freddie == 'freddie-song-for-lennon-content') {
                        wp_enqueue_script('ddpdm-freddie-song-for-lennon-content-js', plugins_url('build/freddie/js/freddie-song-for-lennon-content.js', __FILE__));
                    }
                    if ($ddpdm_css_freddie == 'freddie-stealin-video-content') {
                        wp_enqueue_script('ddpdm-freddie-gsap-jquery-js', plugins_url('build/freddie/js/gsap/gsap.min.js', __FILE__));
                        wp_enqueue_script('ddpdm-freddie-load-draw-svg-js', plugins_url('build/freddie/js/gsap/LoadDrawSVGPlugin.js', __FILE__));
                        wp_enqueue_script('ddpdm-freddie-stealin-video-content-js', plugins_url('build/freddie/js/freddieStealinVideoContent.js', __FILE__));
                    }
                    if ($ddpdm_css_freddie == 'freddie-sweet-lady-slider') {
                        wp_enqueue_script('ddpdm-freddie-sweet-lady-slider-js', plugins_url('build/freddie/js/freddieSweetLadySlider.js', __FILE__));
                    }
                    if ($ddpdm_css_freddie == 'freddie-portfolio') {
                        wp_enqueue_script('ddpdm-freddie-portfolio-js', plugins_url('build/freddie/js/freddieScriptEvent.js', __FILE__));
                    }
                    if ($ddpdm_css_freddie == 'freddie-race-content') {
                        wp_enqueue_script('ddpdm-freddie-gsap-jquery-js', plugins_url('build/freddie/js/gsap/gsap.min.js', __FILE__));
                        wp_enqueue_script('ddpdm-freddie-load-draw-svg-js', plugins_url('build/freddie/js/gsap/LoadDrawSVGPlugin.js', __FILE__));
                        wp_enqueue_script('ddpdm-freddie-race-content-js', plugins_url('build/freddie/js/freddieScriptsRaceContent.js', __FILE__));
                    }
                    if ($ddpdm_css_freddie == 'freddie-our-films-content') {
                        wp_enqueue_script('ddpdm-freddie-gsap-jquery-js', plugins_url('build/freddie/js/gsap/gsap.min.js', __FILE__));
                        wp_enqueue_script('ddpdm-freddie-load-draw-svg-js', plugins_url('build/freddie/js/gsap/LoadDrawSVGPlugin.js', __FILE__));
                        wp_enqueue_script('ddpdm-freddie-our-films-content', plugins_url('build/freddie/js/freddieScriptOurFilmsContent.js', __FILE__));
                    }
                    if ($ddpdm_css_freddie == 'freddie-nevermore-person-module') {
                        wp_enqueue_script('ddpdm-freddie-nevermore-person-module-js', plugins_url('build/freddie/js/freddieScriptsNevermorePersonModule.js', __FILE__));
                    }

                    if ($ddpdm_css_freddie == 'freddie-my-heart-header') {
                        wp_enqueue_script('ddpdm-freddie-my-heart-header-js', plugins_url('build/freddie/js/freddieMyHeartHeader.js', __FILE__));
                    }

                    if ($ddpdm_css_freddie == 'freddie-other-day-testimonial') {
                        wp_enqueue_script('ddpdm-freddie-other-day-testimonial-js', plugins_url('build/freddie/js/freddieOtherDayTestimonial.js', __FILE__));
                    }

                    if ($ddpdm_css_freddie == 'freddie-product-gimme-some' || $ddpdm_css_freddie == 'freddie-going-to-look-optin' || $ddpdm_css_freddie == 'freddie-products-featured-this-rage') {
                        wp_enqueue_script('ddpdm-freddie-gsap-jquery-js', plugins_url('build/freddie/js/gsap/gsap.min.js', __FILE__));
                        wp_enqueue_script('ddpdm-freddie-load-draw-svg-js', plugins_url('build/freddie/js/gsap/LoadDrawSVGPlugin.js', __FILE__));
                        wp_enqueue_script('ddpdm-freddie-going-to-look-optin-js', plugins_url('build/freddie/js/freddieGoingToLookOptin.js', __FILE__));
                    }

                    if ($ddpdm_css_freddie == 'freddie-modern-times-blog') {
                        wp_enqueue_script('ddpdm-freddie-modern-times-blog-js', plugins_url('build/freddie/js/modernTimesBlog.js', __FILE__));
                    }

                    if ($ddpdm_css_freddie == 'freddie-old-times-blog') {
                        wp_enqueue_script('ddpdm-freddie-old-times-blog-tilt-js', plugins_url('build/freddie/js/tilt.jquery.js', __FILE__));
                        wp_enqueue_script('ddpdm-freddie-old-times-blog-js', plugins_url('build/freddie/js/oldTimesBlog.js', __FILE__));
                    }

                    if ($ddpdm_css_freddie == 'freddie-let-me-header') {
                        wp_enqueue_script('ddpdm-freddie-headers-socials', plugins_url('build/freddie/js/socials-freddie.js', __FILE__));
                        wp_enqueue_script('ddpdm-freddie-let-me-header-js', plugins_url('build/freddie/js/freddieLetMeHeader.js', __FILE__));
                    }

                    if ($ddpdm_css_freddie == 'freddie-open-windows-products') {
                        wp_enqueue_script('ddpdm-freddie-open-windows-products-js', plugins_url('build/freddie/js/freddieOpenWindowsProducts.js', __FILE__));
                    }

                    if ($ddpdm_css_freddie == 'freddie-pop-product') {
                        wp_enqueue_script('ddpdm-freddie-pop-product-js', plugins_url('build/freddie/js/freddieScriptPopProduct.js', __FILE__), array( 'wp-i18n' ));
                    }

                    if ($ddpdm_css_freddie == 'freddie-product-details-webdesign-package') {
                        wp_enqueue_script('ddpdm-freddie-product-details-webdesign-package-js', plugins_url('build/freddie/js/freddieProductDetailsWebdesignPackage.js', __FILE__));
                    }

                    if ($ddpdm_css_freddie == 'freddie-happy-man-testimonial') {
                        wp_enqueue_script('ddpdm-freddie-happy-man-testimonial-js', plugins_url('build/freddie/js/freddieScriptHappyManTestimonial.js', __FILE__));
                    }

                    if ($ddpdm_css_freddie == 'freddie-pretty-lights-tabs') {
                        wp_enqueue_script('ddpdm-freddie-pretty-lights-tabs-js', plugins_url('build/freddie/js/freddieScriptPrettyLightsTabs.js', __FILE__));
                    }

                    if ($ddpdm_css_freddie == 'freddie-my-body-testimonial') {
                        wp_enqueue_script('ddpdm-freddie-my-body-testimonial-js', plugins_url('build/freddie/js/freddieScriptMyBodyTestimonial.js', __FILE__));
                    }

                    if ($ddpdm_css_freddie == 'freddie-nevermore-person-module-about') {
                        wp_enqueue_script('ddpdm-freddie-nevermore-person-module-about', plugins_url('build/freddie/js/freddieAboutNevermorePerson.js', __FILE__));
                    }

                    if ($ddpdm_css_freddie == 'freddie-winters-tale-footer') {
                        wp_enqueue_script('ddpdm-freddie-winters-tale-footer-js', plugins_url('build/freddie/js/freddieScriptWintersTaleFooter.js', __FILE__));
                    }

                    if ($ddpdm_css_freddie == 'freddie-crueladeville-slider') {
                        wp_enqueue_script('ddpdm-freddie-crueladeville-slider-js', plugins_url('build/freddie/js/freddieCrueladevilleSlider.js', __FILE__));
                    }

                    if ($ddpdm_css_freddie == 'freddie-pull-you-testimonial') {
                        wp_enqueue_script('ddpdm-freddie-pull-you-testimonial-js', plugins_url('build/freddie/js/freddiePullYouTestimonial.js', __FILE__));
                    }

                    if ($ddpdm_css_freddie == 'freddie-nothing-but-content') {
                        wp_enqueue_script('ddpdm-freddie-nothing-but-content-js', plugins_url('build/freddie/js/freddieNothingButContent.js', __FILE__));
                    }

                    if ($ddpdm_css_freddie == 'freddie-attraction-timeline') {
                        wp_enqueue_script('ddpdm-freddie-attraction-timeline-js', plugins_url('build/freddie/js/freddieAttractionTimeline.js', __FILE__));
                    }

                    if ($ddpdm_css_freddie == 'freddie-some-action-content') {
                        wp_enqueue_script('ddpdm-freddie-some-action-content-js', plugins_url('build/freddie/js/freddieScriptSomeActionContent.js', __FILE__));
                    }

                    if ($ddpdm_css_freddie == 'freddie-some-action-content') {
                        wp_enqueue_script('ddpdm-freddie-some-action-content-js', plugins_url('build/freddie/js/freddieScriptSomeActionContent.js', __FILE__));
                    }

                    if ($ddpdm_css_freddie == 'freddie-youre-hot-contact-form') {
                        wp_enqueue_script('ddpdm-freddie-youre-hot-contact-form-js', plugins_url('build/freddie/js/freddieScriptYoureHotContactForm.js', __FILE__));
                    }

                    if ($ddpdm_css_freddie == 'freddie-black-lips-content') {
                        wp_enqueue_script('ddpdm-freddie-headers-socials', plugins_url('build/freddie/js/socials-freddie.js', __FILE__));
                    }

                    if ($ddpdm_css_freddie == 'freddie-funster-testimonial') {
                        wp_enqueue_script('ddpdm-freddie-funster-testimonial-js', plugins_url('build/freddie/js/freddie-funster-testimonial.js', __FILE__));
                    }

                    if ($ddpdm_css_freddie == 'freddie-my-life-testimonial') {
                        wp_enqueue_script('ddpdm-freddie-my-life-testimonial-js', plugins_url('build/freddie/js/freddieScriptMyLifeTestimonial.js', __FILE__));
                    }

                    if ($ddpdm_css_freddie == 'freddie-needs-you-header') {
                        wp_enqueue_script('ddpdm-freddie-needs-you-header-js', plugins_url('build/freddie/js/freddie-needs-you-header.js', __FILE__));
                    }

                    if ($ddpdm_css_freddie == 'freddie-put-out-products') {
                        wp_enqueue_script('ddpdm-freddie-put-out-products-js', plugins_url('build/freddie/js/freddiePutOutProducts.js', __FILE__));
                    }

                    if ($ddpdm_css_freddie == 'freddie-really-matters-product-detail') {
                        wp_enqueue_script('ddpdm-freddie-really-matters-product-detail-js', plugins_url('build/freddie/js/freddieReallyMattersProductDetail.js', __FILE__));
                    }

                    if ($ddpdm_css_freddie == 'freddie-my-time-recent-products') {
                        wp_enqueue_script('ddpdm-freddie-my-time-recent-products-js', plugins_url('build/freddie/js/freddieMyTimeRecentProducts.js', __FILE__));
                    }

                    // features

                    if ($ddpdm_css_freddie == 'freddie-the-line-blurb') {
                        wp_enqueue_script('ddpdm-freddie-the-line-blurb-js', plugins_url('build/freddie/js/freddie-features/freddieScriptTheLineBlurb.js', __FILE__));
                    }

                    if ($ddpdm_css_freddie == 'freddie-satisfied-blurb') {
                        wp_enqueue_script('ddpdm-freddie-satisfied-blurb', plugins_url('build/freddie/js/freddie-features/freddieScriptSatisfiedBlurb.js', __FILE__));
                    }

                    if ($ddpdm_css_freddie == 'freddie-steps-nearer-blurb') {
                        wp_enqueue_script('ddpdm-freddie-steps-nearer-blurb-js', plugins_url('build/freddie/js/freddie-features/freddieScriptStepsNearerBlurb.js', __FILE__));
                    }

                    if ($ddpdm_css_freddie == 'freddie-your-time-blurb') {
                        wp_enqueue_script('ddpdm-freddie-your-time-blurb-js', plugins_url('build/freddie/js/freddie-features/freddieScriptYourTimeBlurb.js', __FILE__));
                    }

                    if ($ddpdm_css_freddie == 'freddie-on-my-way-blurb') {
                        wp_enqueue_script('ddpdm-freddie-on-my-way-blurb-js', plugins_url('build/freddie/js/freddie-features/freddieScriptMyWayBlurb.js', __FILE__));
                    }

                    if ($ddpdm_css_freddie == 'freddie-no-blame-blurb') {
                        wp_enqueue_script('ddpdm-freddie-no-blame-blurb-js', plugins_url('build/freddie/js/freddie-features/freddieScriptNoBlameBlurb.js', __FILE__));
                    }

                    if ($ddpdm_css_freddie == 'freddie-i-have-blurb') {
                        wp_enqueue_script('ddpdm-freddie-i-have-blurb-js', plugins_url('build/freddie/js/freddie-features/freddieScriptHaveBlurb.js', __FILE__));
                    }

                    // gallery

                    if ($ddpdm_css_freddie == 'freddie-gallery-a-hero') {
                        wp_enqueue_script('ddpdm-freddie-gallery-a-hero-js', plugins_url('build/freddie/js/freddie-gallery/freddieGalleryHero.js', __FILE__));
                    }

                    if ($ddpdm_css_freddie == 'freddie-gallery-every-child') {
                        wp_enqueue_script('ddpdm-freddie-gallery-every-child-js', plugins_url('build/freddie/js/freddie-gallery/freddieGalleryEveryChild.js', __FILE__));
                    }

                    if ($ddpdm_css_freddie == 'freddie-gallery-the-mighty') {
                        wp_enqueue_script('ddpdm-freddie-gallery-the-mighty-js', plugins_url('build/freddie/js/freddie-gallery/freddieGalleryTheMighty.js', __FILE__));
                    }

                    if ($ddpdm_css_freddie == 'freddie-gallery-oooh-yeah') {
                        wp_enqueue_script('ddpdm-freddie-gallery-oooh-yeah-js', plugins_url('build/freddie/js/freddie-gallery/freddieGalleryOoohYeah.js', __FILE__));
                    }

                    if ($ddpdm_css_freddie == 'freddie-gallery-my-friend') {
                        wp_enqueue_script('ddpdm-freddie-gallery-my-friend-js', plugins_url('build/freddie/js/freddie-gallery/freddieGalleryMyFriend.js', __FILE__));
                    }

                    if ($ddpdm_css_freddie == 'freddie-gallery-every-one') {
                        wp_enqueue_script('ddpdm-pegasus-masonry-js', plugins_url('build/pegasus/js/masonry.pkgd.min.js', __FILE__));
                        wp_enqueue_script('ddpdm-venus-hoverdir-js', plugins_url('build/venus/js/venus-library.js', __FILE__));

                        wp_enqueue_script('ddpdm-freddie-gallery-every-one-js', plugins_url('build/freddie/js/freddie-gallery/freddieGalleryEveryOne.js', __FILE__));
                    }

                    if ($ddpdm_css_freddie == 'freddie-gallery-be-somebody') {
                        wp_enqueue_script('ddpdm-pegasus-masonry-js', plugins_url('build/pegasus/js/masonry.pkgd.min.js', __FILE__));
                        wp_enqueue_script('ddpdm-venus-hoverdir-js', plugins_url('build/venus/js/venus-library.js', __FILE__));
                        wp_enqueue_script('ddpdm-freddie-gallery-be-somebody-js', plugins_url('build/freddie/js/freddie-gallery/freddieGalleryBeSomebody.js', __FILE__));
                    }



                    // buttons
                    if ($ddpdm_css_freddie == 'freddie-button-jealousy') {
                        wp_enqueue_script('ddpdm-freddie-button-jealousy-js', plugins_url('build/freddie/js/freddie-button-jealousy.js', __FILE__));
                    }
                    if ($ddpdm_css_freddie == 'freddie-button-the-loser') {
                        wp_enqueue_script('ddpdm-freddie-button-the-loser-js', plugins_url('build/freddie/js/freddie-button-the-loser.js', __FILE__));
                    }
                    if ($ddpdm_css_freddie == 'freddie-button-lazing-on') {
                        wp_enqueue_script('ddpdm-freddie-button-lazing-on-js', plugins_url('build/freddie/js/freddie-button-lazing-on.js', __FILE__));
                    }
                    if ($ddpdm_css_freddie == 'freddie-button-liar') {
                        wp_enqueue_script('ddpdm-freddie-button-liar-js', plugins_url('build/freddie/js/freddie-button-liar.js', __FILE__));
                    }
                    if ($ddpdm_css_freddie == 'freddie-button-love-kills') {
                        wp_enqueue_script('ddpdm-freddie-button-love-kills-js', plugins_url('build/freddie/js/freddie-button-love-kills.js', __FILE__));
                    }
                    if ($ddpdm_css_freddie == 'freddie-button-misfire') {
                        wp_enqueue_script('ddpdm-freddie-button-misfire-js', plugins_url('build/freddie/js/freddie-button-misfire.js', __FILE__));
                    }
                    if ($ddpdm_css_freddie == 'freddie-button-been-saved') {
                        wp_enqueue_script('ddpdm-freddie-button-been-saved-js', plugins_url('build/freddie/js/freddie-button-been-saved.js', __FILE__));
                    }
                    if ($ddpdm_css_freddie == 'freddie-button-mother-love') {
                        wp_enqueue_script('ddpdm-freddie-button-mother-love-js', plugins_url('build/freddie/js/freddie-button-mother-love.js', __FILE__));
                    }
                    if ($ddpdm_css_freddie == 'freddie-button-ogre-battle') {
                        wp_enqueue_script('ddpdm-freddie-button-ogre-battle-js', plugins_url('build/freddie/js/freddie-button-ogre-battle.js', __FILE__));
                    }
                    if ($ddpdm_css_freddie == 'freddie-button-party') {
                        wp_enqueue_script('ddpdm-freddie-button-party-js', plugins_url('build/freddie/js/freddie-button-party.js', __FILE__));
                    }
                    if ($ddpdm_css_freddie == 'freddie-button-the-fire') {
                        wp_enqueue_script('ddpdm-freddie-button-the-fire-js', plugins_url('build/freddie/js/freddie-button-the-fire.js', __FILE__));
                    }
                    if ($ddpdm_css_freddie == 'freddie-button-wild-wind') {
                        wp_enqueue_script('ddpdm-freddie-button-wild-wind-js', plugins_url('build/freddie/js/freddie-button-wild-wind.js', __FILE__));
                    }
                    if ($ddpdm_css_freddie == 'freddie-button-seaside') {
                        wp_enqueue_script('ddpdm-freddie-button-seaside-js', plugins_url('build/freddie/js/freddie-button-seaside.js', __FILE__));
                    }
                    if ($ddpdm_css_freddie == 'freddie-button-rendezvous') {
                        wp_enqueue_script('ddpdm-freddie-button-rendezvous-js', plugins_url('build/freddie/js/freddie-button-rendezvous.js', __FILE__));
                    }
                    if ($ddpdm_css_freddie == 'freddie-button-some-day') {
                        wp_enqueue_script('ddpdm-freddie-button-some-day-js', plugins_url('build/freddie/js/freddie-button-some-day.js', __FILE__));
                    }
                    if ($ddpdm_css_freddie == 'freddie-button-one-day') {
                        wp_enqueue_script('ddpdm-freddie-button-one-day-js', plugins_url('build/freddie/js/freddie-button-one-day.js', __FILE__));
                    }
                    if ($ddpdm_css_freddie == 'freddie-button-soul-brother') {
                        wp_enqueue_script('ddpdm-freddie-button-soul-brother-js', plugins_url('build/freddie/js/freddie-button-soul-brother.js', __FILE__));
                    }
                    if ($ddpdm_css_freddie == 'freddie-button-step-on-me') {
                        wp_enqueue_script('ddpdm-freddie-button-step-on-me-js', plugins_url('build/freddie/js/freddie-button-step-on-me.js', __FILE__));
                    }
                    if ($ddpdm_css_freddie == 'freddie-button-tear-it-up') {
                        wp_enqueue_script('ddpdm-freddie-button-tear-it-up-js', plugins_url('build/freddie/js/freddie-button-tear-it-up.js', __FILE__));
                    }
                    if ($ddpdm_css_freddie == 'freddie-button-teo-torriate') {
                        wp_enqueue_script('ddpdm-freddie-button-teo-torriate-js', plugins_url('build/freddie/js/freddie-button-teo-torriate.js', __FILE__));
                    }
                    if ($ddpdm_css_freddie == 'freddie-button-fairy-feller') {
                        wp_enqueue_script('ddpdm-freddie-button-fairy-feller-js', plugins_url('build/freddie/js/freddie-button-fairy-feller.js', __FILE__));
                    }
                    if ($ddpdm_css_freddie == 'freddie-button-radio-ga-ga') {
                        wp_enqueue_script('ddpdm-freddie-button-radio-ga-ga-js', plugins_url('build/freddie/js/freddie-button-radio-ga-ga.js', __FILE__));
                    }
                    if ($ddpdm_css_freddie == 'freddie-button-under-pressure') {
                        wp_enqueue_script('ddpdm-freddie-button-under-pressure-js', plugins_url('build/freddie/js/freddie-button-under-pressure.js', __FILE__));
                    }
                    if ($ddpdm_css_freddie == 'freddie-button-you-andi') {
                        wp_enqueue_script('ddpdm-freddie-button-you-andi-js', plugins_url('build/freddie/js/freddie-button-you-andi.js', __FILE__));
                    }
                    if ($ddpdm_css_freddie == 'freddie-button-action-this-day') {
                        wp_enqueue_script('ddpdm-freddie-button-action-this-day-js', plugins_url('build/freddie/js/freddie-button-action-this-day.js', __FILE__));
                    }
                    if ($ddpdm_css_freddie == 'freddie-button-april-lady') {
                        wp_enqueue_script('ddpdm-freddie-button-april-lady-js', plugins_url('build/freddie/js/freddie-button-april-lady.js', __FILE__));
                    }
                    if ($ddpdm_css_freddie == 'freddie-button-bicycle-race') {
                        wp_enqueue_script('ddpdm-freddie-button-bicycle-race-js', plugins_url('build/freddie/js/freddie-button-bicycle-race.js', __FILE__));
                    }
                    if ($ddpdm_css_freddie == 'freddie-button-blag') {
                        wp_enqueue_script('ddpdm-freddie-button-blag-js', plugins_url('build/freddie/js/freddie-button-blag.js', __FILE__));
                    }
                    if ($ddpdm_css_freddie == 'freddie-button-bohemian') {
                        wp_enqueue_script('ddpdm-freddie-button-bohemian-js', plugins_url('build/freddie/js/freddie-button-bohemian.js', __FILE__));
                    }
                    if ($ddpdm_css_freddie == 'freddie-button-rhapsody') {
                        wp_enqueue_script('ddpdm-freddie-button-rhapsody-js', plugins_url('build/freddie/js/freddie-button-rhapsody.js', __FILE__));
                    }
                    if ($ddpdm_css_freddie == 'freddie-button-calling-all-girls') {
                        wp_enqueue_script('ddpdm-freddie-button-calling-all-girls-js', plugins_url('build/freddie/js/freddie-button-calling-all-girls.js', __FILE__));
                    }
                    if ($ddpdm_css_freddie == 'freddie-button-dancer') {
                        wp_enqueue_script('ddpdm-freddie-button-dancer-js', plugins_url('build/freddie/js/freddie-button-dancer.js', __FILE__));
                    }
                    if ($ddpdm_css_freddie == 'freddie-button-delilah') {
                        wp_enqueue_script('ddpdm-freddie-button-delilah-js', plugins_url('build/freddie/js/freddie-button-delilah.js', __FILE__));
                    }
                    if ($ddpdm_css_freddie == 'freddie-button-dont-stop-me') {
                        wp_enqueue_script('ddpdm-freddie-button-dont-stop-me-js', plugins_url('build/freddie/js/freddie-button-dont-stop-me.js', __FILE__));
                    }
                    if ($ddpdm_css_freddie == 'freddie-button-fat-bottomed') {
                        wp_enqueue_script('ddpdm-freddie-button-fat-bottomed-js', plugins_url('build/freddie/js/freddie-button-fat-bottomed.js', __FILE__));
                    }
                    if ($ddpdm_css_freddie == 'freddie-button-get-down') {
                        wp_enqueue_script('ddpdm-freddie-button-get-down-js', plugins_url('build/freddie/js/freddie-button-get-down.js', __FILE__));
                    }
                    if ($ddpdm_css_freddie == 'freddie-button-the-queen') {
                        wp_enqueue_script('ddpdm-freddie-button-the-queen-js', plugins_url('build/freddie/js/freddie-button-the-queen.js', __FILE__));
                    }
                    if ($ddpdm_css_freddie == 'freddie-button-good-old') {
                        wp_enqueue_script('ddpdm-freddie-button-good-old-js', plugins_url('build/freddie/js/freddie-button-good-old.js', __FILE__));
                    }
                    if ($ddpdm_css_freddie == 'freddie-button-headlong') {
                        wp_enqueue_script('ddpdm-freddie-button-headlong-js', plugins_url('build/freddie/js/freddie-button-headlong.js', __FILE__));
                    }
                    if ($ddpdm_css_freddie == 'freddie-button-break-free') {
                        wp_enqueue_script('ddpdm-freddie-button-break-free-js', plugins_url('build/freddie/js/freddie-button-break-free.js', __FILE__));
                    }
                    if ($ddpdm_css_freddie == 'freddie-button-beat-them') {
                        wp_enqueue_script('ddpdm-freddie-button-beat-them-js', plugins_url('build/freddie/js/freddie-button-beat-them.js', __FILE__));
                    }
                    if ($ddpdm_css_freddie == 'freddie-button-beautiful-day') {
                        wp_enqueue_script('ddpdm-freddie-button-beautiful-day-js', plugins_url('build/freddie/js/freddie-button-beautiful-day.js', __FILE__));
                    }
                    if ($ddpdm_css_freddie == 'freddie-button-killer-queen') {
                        wp_enqueue_script('ddpdm-freddie-button-killer-queen-js', plugins_url('build/freddie/js/freddie-button-killer-queen.js', __FILE__));
                    }
                    if ($ddpdm_css_freddie == 'freddie-button-life-is-real') {
                        wp_enqueue_script('ddpdm-freddie-button-life-is-real-js', plugins_url('build/freddie/js/freddie-button-life-is-real.js', __FILE__));
                    }
                    if ($ddpdm_css_freddie == 'freddie-button-love-of') {
                        wp_enqueue_script('ddpdm-freddie-button-love-of-js', plugins_url('build/freddie/js/freddie-button-love-of.js', __FILE__));
                    }
                    if ($ddpdm_css_freddie == 'freddie-button-made-in-heaven') {
                        wp_enqueue_script('ddpdm-freddie-button-made-in-heaven-js', plugins_url('build/freddie/js/freddie-button-made-in-heaven.js', __FILE__));
                    }
                    if ($ddpdm_css_freddie == 'freddie-button-melancholy-blues') {
                        wp_enqueue_script('ddpdm-freddie-button-melancholy-blues-js', plugins_url('build/freddie/js/freddie-button-melancholy-blues.js', __FILE__));
                    }
                    if ($ddpdm_css_freddie == 'freddie-button-no-violins') {
                        wp_enqueue_script('ddpdm-freddie-button-no-violins-js', plugins_url('build/freddie/js/freddie-button-no-violins.js', __FILE__));
                    }
                    if ($ddpdm_css_freddie == 'freddie-button-one-vision') {
                        wp_enqueue_script('ddpdm-freddie-button-one-vision-js', plugins_url('build/freddie/js/freddie-button-one-vision.js', __FILE__));
                    }
                    if ($ddpdm_css_freddie == 'freddie-button-play-the-game') {
                        wp_enqueue_script('ddpdm-freddie-button-play-the-game-js', plugins_url('build/freddie/js/freddie-button-play-the-game.js', __FILE__));
                    }

                    if ($ddpdm_css_freddie == 'freddie-blog-post-to-son') {
                        wp_enqueue_script('ddpdm-freddie-blog-post-to-son-js', plugins_url('build/freddie/js/freddie-blog-post-to-son.js', __FILE__));
                    }

                    if ($ddpdm_css_freddie == 'freddie-blog-post-drowse') {
                        wp_enqueue_script('ddpdm-freddie-blog-post-drowse-js', plugins_url('build/freddie/js/freddie-blog-post-drowse.js', __FILE__));
                    }

                    if ($ddpdm_css_freddie == 'freddie-blog-post-all-girls') {
                        wp_enqueue_script('ddpdm-freddie-blog-post-all-girls-js', plugins_url('build/freddie/js/freddie-blog-post-all-girls.js', __FILE__));
                    }

                    if ($ddpdm_css_freddie == 'freddie-blog-post-mother-love') {
                        wp_enqueue_script('ddpdm-freddie-blog-post-mother-love-js', plugins_url('build/freddie/js/freddie-blog-post-mother-love.js', __FILE__));
                    }

                    if ($ddpdm_css_freddie == 'freddie-make-love-blog-post') {
                        wp_enqueue_script('ddpdm-freddie-make-love-blog-post-js', plugins_url('build/freddie/js/freddie-make-love-blog-post.js', __FILE__));
                    }

                    if ($ddpdm_css_freddie == 'freddie-blog-post-human-body') {
                        wp_enqueue_script('ddpdm-freddie-blog-post-human-body-js', plugins_url('build/freddie/js/freddie-blog-post-human-body.js', __FILE__));
                    }

                    if ($ddpdm_css_freddie == 'freddie-misfire-search-results') {
                        wp_enqueue_script('ddpdm-freddie-misfire-search-results-js', plugins_url('build/freddie/js/freddie-misfire-search-results.js', __FILE__));
                    }

                    if ($ddpdm_css_freddie == 'freddie-baby-does-search-results') {
                        wp_enqueue_script('ddpdm-freddie-baby-does-search-results-js', plugins_url('build/freddie/js/freddie-baby-does-search-results.js', __FILE__));
                    }

                    if ($ddpdm_css_freddie == 'freddie-that-glitter-blog-post') {
                        wp_enqueue_script('ddpdm-freddie-that-glitter-blog-post-js', plugins_url('build/freddie/js/freddie-that-glitter-blog-post.js', __FILE__));
                    }

                    if ($ddpdm_css_freddie == 'freddie-thunderbolt-product') {
                        wp_enqueue_script('ddpdm-freddie-thunderbolt-product-js', plugins_url('build/freddie/js/freddie-thunderbolt-product.js', __FILE__));
                    }

                    // Menus
                    if ($ddpdm_css_freddie == 'freddie-menu-1') {
                        wp_enqueue_script('ddpdm-freddie-gsap-split-text-js', plugins_url('build/freddie/js/gsap/gsap.min.js', __FILE__));
                        wp_enqueue_script('ddpdm-freddie-load-draw-svg-js', plugins_url('build/freddie/js/gsap/LoadDrawSVGPlugin.js', __FILE__));
                        wp_enqueue_script('ddpdm-freddie-menu-prize-js', plugins_url('build/freddie/js/freddieScriptPrizeMenu.js', __FILE__));
                    }

                    if ($ddpdm_css_freddie == 'freddie-menu-2') {
                        wp_enqueue_script('ddpdm-freddie-gsap-split-text-js', plugins_url('build/freddie/js/gsap/gsap.min.js', __FILE__));
                        wp_enqueue_script('ddpdm-freddie-load-draw-svg-js', plugins_url('build/freddie/js/gsap/LoadDrawSVGPlugin.js', __FILE__));
                        wp_enqueue_script('ddpdm-freddie-menu-attac-dragon-js', plugins_url('build/freddie/js/freddieScriptAttackDragonMenu.js', __FILE__));
                    }

                    if ($ddpdm_css_freddie == 'freddie-menu-3') {
                        wp_enqueue_script('ddpdm-freddie-gsap-split-text-js', plugins_url('build/freddie/js/gsap/gsap.min.js', __FILE__));
                        wp_enqueue_script('ddpdm-freddie-load-draw-svg-js', plugins_url('build/freddie/js/gsap/LoadDrawSVGPlugin.js', __FILE__));
                        wp_enqueue_script('ddpdm-freddie-menu-earth-js', plugins_url('build/freddie/js/freddieScriptEarthMenu.js', __FILE__));
                    }

                    if ($ddpdm_css_freddie == 'freddie-menu-4') {
                        wp_enqueue_script('ddpdm-freddie-gsap-split-text-js', plugins_url('build/freddie/js/gsap/gsap.min.js', __FILE__));
                        wp_enqueue_script('ddpdm-freddie-load-draw-svg-js', plugins_url('build/freddie/js/gsap/LoadDrawSVGPlugin.js', __FILE__));
                        wp_enqueue_script('ddpdm-freddie-menu-funny-love-js', plugins_url('build/freddie/js/freddieScriptFunnyHowLoveMenu.js', __FILE__));
                    }

                    if ($ddpdm_css_freddie == 'freddie-menu-5') {
                        wp_enqueue_script('ddpdm-freddie-gsap-split-text-js', plugins_url('build/freddie/js/gsap/gsap.min.js', __FILE__));
                        wp_enqueue_script('ddpdm-freddie-load-draw-svg-js', plugins_url('build/freddie/js/gsap/LoadDrawSVGPlugin.js', __FILE__));
                        wp_enqueue_script('ddpdm-freddie-menu-hang-on-in-there-js', plugins_url('build/freddie/js/freddieScriptHangOnInThereMenu.js', __FILE__));
                    }

                    if ($ddpdm_css_freddie == 'freddie-menu-6') {
                        wp_enqueue_script('ddpdm-freddie-gsap-split-text-js', plugins_url('build/freddie/js/gsap/gsap.min.js', __FILE__));
                        wp_enqueue_script('ddpdm-freddie-load-draw-svg-js', plugins_url('build/freddie/js/gsap/LoadDrawSVGPlugin.js', __FILE__));
                        wp_enqueue_script('ddpdm-freddie-menu-lover-boy-js', plugins_url('build/freddie/js/freddieScriptLoverBoyMenu.js', __FILE__));
                    }

                    if ($ddpdm_css_freddie == 'freddie-menu-7') {
                        wp_enqueue_script('ddpdm-freddie-gsap-split-text-js', plugins_url('build/freddie/js/gsap/gsap.min.js', __FILE__));
                        wp_enqueue_script('ddpdm-freddie-load-draw-svg-js', plugins_url('build/freddie/js/gsap/LoadDrawSVGPlugin.js', __FILE__));
                        wp_enqueue_script('ddpdm-freddie-menu-hijack-my-heart-jsocials-s', plugins_url('build/freddie/js/socials-freddie.js', __FILE__));
                        wp_enqueue_script('ddpdm-freddie-menu-hijack-my-heart-js', plugins_url('build/freddie/js/freddieHijackMyHeart.js', __FILE__));
                        wp_enqueue_script('ddpdm-freddie-bali-header-js', plugins_url('build/freddie/js/tb-navigation-menus/freddieScriptBaliHeader.js', __FILE__));
                    }

                    // TB Navigation Menus

                    if ($ddpdm_css_freddie == 'freddie-bali-header') {
                        wp_enqueue_script('ddpdm-freddie-bali-header-js', plugins_url('build/freddie/js/tb-navigation-menus/freddieScriptBaliHeader.js', __FILE__));
                    }

                    if ($ddpdm_css_freddie == 'freddie-hungry-header') {
                        wp_enqueue_script('ddpdm-freddie-gsap-split-text-js', plugins_url('build/freddie/js/gsap/gsap.min.js', __FILE__));
                        wp_enqueue_script('ddpdm-freddie-load-draw-svg-js', plugins_url('build/freddie/js/gsap/LoadDrawSVGPlugin.js', __FILE__));
                        wp_enqueue_script('ddpdm-freddie-hungry-header-js', plugins_url('build/freddie/js/tb-navigation-menus/freddieScriptHungryHeader.js', __FILE__));
                    }

                    if ($ddpdm_css_freddie == 'freddie-breaking-header') {
                        wp_enqueue_script('ddpdm-freddie-breaking-header-js', plugins_url('build/freddie/js/tb-navigation-menus/freddieScriptBreakingHeader.js', __FILE__));
                    }

                    if ($ddpdm_css_freddie == 'freddie-private-affair-header') {
                        wp_enqueue_script('ddpdm-freddie-private-affair-header-js', plugins_url('build/freddie/js/tb-navigation-menus/freddieScriptPrivateAffairHeader.js', __FILE__));
                    }

                    if ($ddpdm_css_freddie == 'freddie-pleading-header') {
                        wp_enqueue_script('ddpdm-freddie-pleadingg-header-js', plugins_url('build/freddie/js/tb-navigation-menus/freddieScriptPleadingHeader.js', __FILE__));
                    }

                    if ($ddpdm_css_freddie == 'freddie-headline-header') {
                        wp_enqueue_script('ddpdm-freddie-gsap-split-text-js', plugins_url('build/freddie/js/gsap/gsap.min.js', __FILE__));
                        wp_enqueue_script('ddpdm-freddie-load-draw-svg-js', plugins_url('build/freddie/js/gsap/LoadDrawSVGPlugin.js', __FILE__));
                        wp_enqueue_script('ddpdm-freddie-headline-header-js', plugins_url('build/freddie/js/tb-navigation-menus/freddieScriptHeadlineHeader.js', __FILE__));
                    }

                    if ($ddpdm_css_freddie == 'freddie-twisted-header') {
                        wp_enqueue_script('ddpdm-freddie-twisted-header-js', plugins_url('build/freddie/js/tb-navigation-menus/freddieScriptTwistedHeader.js', __FILE__));
                    }

                    if ($ddpdm_css_freddie == 'freddie-get-started-header') {
                        wp_enqueue_script('ddpdm-freddie-get-started-header-js', plugins_url('build/freddie/js/tb-navigation-menus/freddieScriptGetStartedHeader.js', __FILE__));
                    }

                    if ($ddpdm_css_freddie == 'freddie-just-like-header') {
                        wp_enqueue_script('ddpdm-freddie-hoverdir-js', plugins_url('build/pegasus/js/pegasus-library.js', __FILE__));
                        wp_enqueue_script('ddpdm-freddie-just-like-header-js', plugins_url('build/freddie/js/tb-navigation-menus/freddieScriptJustLikeHeader.js', __FILE__));
                    }

                    if ($ddpdm_css_freddie == 'freddie-he-pulled-header') {
                        wp_enqueue_script('ddpdm-freddie-gsap-split-text-js', plugins_url('build/freddie/js/gsap/gsap.min.js', __FILE__));
                        wp_enqueue_script('ddpdm-freddie-load-draw-svg-js', plugins_url('build/freddie/js/gsap/LoadDrawSVGPlugin.js', __FILE__));
                        wp_enqueue_script('ddpdm-freddie-he-pulled-header-js', plugins_url('build/freddie/js/tb-navigation-menus/freddieScriptHePulledHeader.js', __FILE__));
                    }

                    if ($ddpdm_css_freddie == 'freddie-no-one-header') {
                        wp_enqueue_script('ddpdm-freddie-no-one-header-js', plugins_url('build/freddie/js/tb-navigation-menus/freddieScriptNoOneHeader.js', __FILE__));
                    }

                    if ($ddpdm_css_freddie == 'freddie-content-lap-of-the-gods') {
                        wp_enqueue_script('ddpdm-freddie-content-lap-of-the-gods-js', plugins_url('build/freddie/js/freddie-home10/freddieContentLapOfTheGods.js', __FILE__));
                    }

                    if ($ddpdm_css_freddie == 'freddie-footer-keep-yourself-alive') {
                        wp_enqueue_script('ddpdm-freddie-footer-keep-yourself-alive-js', plugins_url('build/freddie/js/freddie-home10/freddieFooterKeepYourselfAlive.js', __FILE__));
                    }

                    if ($ddpdm_css_freddie == 'freddie-author-1') {
                        wp_enqueue_script('ddpdm-freddie-author-1-js', plugins_url('build/freddie/js/freddie-author-worthwhile/freddieAuthorWorthwhile.js', __FILE__));
                    }

                    if ($ddpdm_css_freddie == 'freddie-products-featured-mama-oooh') {
                        wp_enqueue_script('ddpdm-freddie-products-featured-mama-oooh-js', plugins_url('build/freddie/js/freddie-woo/freddieProductsFeaturedMamaOooh.js', __FILE__));
                    }

                    if ($ddpdm_css_freddie == 'freddie-products-featured-ha-haa') {
                        wp_enqueue_script('ddpdm-freddie-products-featured-ha-haa-js', plugins_url('build/freddie/js/freddie-woo/freddieProductsFeaturedHaHaa.js', __FILE__));
                    }

                    if ($ddpdm_css_freddie == 'freddie-products-featured-this-rage') {
                        wp_enqueue_script('ddpdm-freddie-products-featured-this-rage-js', plugins_url('build/freddie/js/freddie-woo/freddieProductsFeaturedThisRage.js', __FILE__));
                    }

                    if ($ddpdm_css_freddie == 'freddie-products-featured-wooh') {
                        wp_enqueue_script('ddpdm-freddie-products-featured-wooh-js', plugins_url('build/freddie/js/freddie-woo/freddieProductsFeaturedWooh.js', __FILE__));
                    }

                    if ($ddpdm_css_freddie == 'freddie-product-time-tomorrow') {
                        wp_enqueue_script('ddpdm-freddie-product-time-tomorrow-js', plugins_url('build/freddie/js/freddie-woo/freddieProductTimeTomorrow.js', __FILE__));
                    }

                    if ($ddpdm_css_freddie == 'freddie-product-thrown-it-all-away') {
                        wp_enqueue_script('ddpdm-freddie-product-thrown-it-all-away-js', plugins_url('build/freddie/js/freddie-woo/freddieProductThrownItAllAway.js', __FILE__));
                    }

                    if ($ddpdm_css_freddie == 'freddie-product-gimme-some') {
                        wp_enqueue_script('ddpdm-freddie-product-gimme-some-js', plugins_url('build/freddie/js/freddie-woo/freddieProductGimmeSome.js', __FILE__));
                    }
                }
            }

            if (get_option('ddpdm_menu_template') === 'disabled') {
                if (get_option('ddpdm_mobile_menu_template') === 'mobile_menu_1') {
                    wp_enqueue_script('ddpdm-responsive-menu-1', plugins_url('build/responsive-menus/js/responsive-menu-1.js', __FILE__));
                }

                if (get_option('ddpdm_mobile_menu_template') === 'mobile_menu_2') {
                    wp_enqueue_script('ddpdm-responsive-menu-2', plugins_url('build/responsive-menus/js/responsive-menu-2.js', __FILE__));
                }

                if (get_option('ddpdm_mobile_menu_template') === 'mobile_menu_3') {
                    wp_enqueue_script('ddpdm-responsive-menu-3', plugins_url('build/responsive-menus/js/responsive-menu-3.js', __FILE__));
                }
            }

            // Tina starts

            if (!empty(get_post_meta($post->ID, 'ddp-css-tina'))) {
                foreach ((array) get_post_meta($post->ID, 'ddp-css-tina') as $ddpdm_css_tina) {
                    // gsap
                    if ($ddpdm_css_tina == 'tina-person-talk-now' || $ddpdm_css_tina == 'tina-my-lover-sidebar' || $ddpdm_css_tina == 'tina-tabs-the-change' || $ddpdm_css_tina == 'tina-header-he-belongs' || $ddpdm_css_tina == 'tina-testimonial-who-did' || $ddpdm_css_tina == 'tina-sometimes-content' || $ddpdm_css_tina == 'tina-content-eight-wheeler' || $ddpdm_css_tina == 'tina-content-throttle' || $ddpdm_css_tina == 'tina-content-ease' || $ddpdm_css_tina == 'tina-content-listen' || $ddpdm_css_tina == 'tina-content-wanna-hear' || $ddpdm_css_tina == 'tina-person-module-talk-now' || $ddpdm_css_tina == 'tina-slider-sail-away' || $ddpdm_css_tina == 'tina-portfolio-bayou' || $ddpdm_css_tina == 'tina-portfolio-ribbon' || $ddpdm_css_tina == 'tina-header-have-ridden') {
                        wp_enqueue_script('ddpdm-freddie-gsap-jquery-js', plugins_url('build/freddie/js/gsap/gsap.min.js', __FILE__));
                        wp_enqueue_script('ddpdm-freddie-load-draw-svg-js', plugins_url('build/freddie/js/gsap/LoadDrawSVGPlugin.js', __FILE__));
                    }

                    // MotionPlugin
                    if ($ddpdm_css_tina == 'tina-content-eight-wheeler' ||
                    $ddpdm_css_tina == 'tina-content-throttle' ||
                    $ddpdm_css_tina == 'tina-content-ease'
                ) {
                        wp_enqueue_script('ddpdm-tina-load-motion-plugin-js', plugins_url('build/tina/js/MotionPathPlugin.min.js', __FILE__));
                    }

                    //lake.js
                    if ($ddpdm_css_tina == 'tina-content-wanna-hear' || $ddpdm_css_tina == 'tina-person-module-talk-now') {
                        wp_enqueue_script('ddpdm-tina-lake-js', plugins_url('build/tina/js/about2/lake.js', __FILE__));
                    }

                    // plugins.js, sly.min.js, tilt.jquery.js
                    if ($ddpdm_css_tina == 'tina-slider-you-take' || $ddpdm_css_tina == 'tina-slider-you-take-v2') {
                        wp_enqueue_script('ddpdm-tina-plugins-js', plugins_url('build/tina/js/home7/tina-library.js', __FILE__));
                    }

                    // masonry.pkgd.min.js

                    if ($ddpdm_css_tina == 'tina-portfolio-bayou' || $ddpdm_css_tina == 'tina-portfolio-ribbon') {
                        wp_enqueue_script('ddpdm-pegasus-masonry-js', plugins_url('build/pegasus/js/masonry.pkgd.min.js', __FILE__));
                    }


                    if ($ddpdm_css_tina == 'tina-header-the-girl') {
                        wp_enqueue_script('ddpdm-tina-header-the-girl-js', plugins_url('build/tina/js/home1/tinaHeaderTheGirl.js', __FILE__));
                    }
                    if ($ddpdm_css_tina == 'tina-blurbs-easy-babe') {
                        wp_enqueue_script('ddpdm-tina-blurbs-easy-babe-js', plugins_url('build/tina/js/home1/tinaBlurbsEasyBabe.js', __FILE__));
                    }
                    if ($ddpdm_css_tina == 'tina-tabs-the-change') {
                        wp_enqueue_script('ddpdm-tina-tabs-the-change-js', plugins_url('build/tina/js/home1/tinaTabsTheChange.js', __FILE__));
                    }
                    if ($ddpdm_css_tina == 'tina-person-module-she-talks') {
                        wp_enqueue_script('ddpdm-tina-person-module-she-talks-js', plugins_url('build/tina/js/home1/tinaPersonModuleSheTalks.js', __FILE__));
                    }
                    if ($ddpdm_css_tina == 'tina-blog-its-alright') {
                        wp_enqueue_script('ddpdm-tina-blog-its-alright-js', plugins_url('build/tina/js/home1/tinaBlogItsAlright.js', __FILE__));
                    }
                    if ($ddpdm_css_tina == 'tina-header-private-dancer') {
                        wp_enqueue_script('ddpdm-tina-header-private-dancer-js', plugins_url('build/tina/js/home2/tinaHeaderPrivateDancer.js', __FILE__));
                    }
                    if ($ddpdm_css_tina == 'tina-content-these-places') {
                        wp_enqueue_script('ddpdm-tina-content-these-places-js', plugins_url('build/tina/js/home2/tinaContentThesePlaces.js', __FILE__));
                    }
                    if ($ddpdm_css_tina == 'tina-person-module-my-thumb') {
                        wp_enqueue_script('ddpdm-tina-person-module-my-thumb-js', plugins_url('build/tina/js/home2/tinaPersonModuleMyThumb.js', __FILE__));
                    }
                    if ($ddpdm_css_tina == 'tina-blog-all-day') {
                        wp_enqueue_script('ddpdm-tina-blog-all-day-js', plugins_url('build/tina/js/home2/tinaBlogAllday.js', __FILE__));
                    }
                    if ($ddpdm_css_tina == 'tina-header-see-this') {
                        wp_enqueue_script('ddpdm-tina-header-see-this-js', plugins_url('build/tina/js/home3/tinaHeaderSeeThis.js', __FILE__), array( 'wp-i18n' ));
                    }
                    if ($ddpdm_css_tina == 'tina-blurbs-smile-to') {
                        wp_enqueue_script('ddpdm-tina-blurbs-smile-to-js', plugins_url('build/tina/js/home3/tinaBlurbsSmileTo.js', __FILE__));
                    }
                    if ($ddpdm_css_tina == 'tina-blurbs-a-fire') {
                        wp_enqueue_script('ddpdm-tina-blurbs-a-fire-js', plugins_url('build/tina/js/home3/tinaBlurbsaFire.js', __FILE__));
                    }
                    if ($ddpdm_css_tina == 'tina-blurbs-get-enough') {
                        wp_enqueue_script('ddpdm-tina-blurbs-get-enough-js', plugins_url('build/tina/js/home3/tinaBlurbsGetEnough.js', __FILE__));
                    }
                    if ($ddpdm_css_tina == 'tina-persons-flowing') {
                        wp_enqueue_script('ddpdm-tina-persons-flowing-js', plugins_url('build/tina/js/home3/tinaPersonsFlowing.js', __FILE__));
                    }
                    if ($ddpdm_css_tina == 'tina-call-to-action-seek') {
                        wp_enqueue_script('ddpdm-tina-call-to-action-seek-js', plugins_url('build/tina/js/home3/tinaCallToActionSeek.js', __FILE__));
                    }
                    if ($ddpdm_css_tina == 'tina-blog-the-flame') {
                        wp_enqueue_script('ddpdm-tina-blog-the-flame-js', plugins_url('build/tina/js/home3/tinaBlogTheFlame.js', __FILE__));
                    }

                    if ($ddpdm_css_tina == 'tina-header-he-belongs') {
                        wp_enqueue_script('ddpdm-tina-header-he-belongs-js', plugins_url('build/tina/js/home4/tinaHeaderHeBelongs.js', __FILE__));
                    }
                    if ($ddpdm_css_tina == 'tina-blurbs-i-wanna-be') {
                        wp_enqueue_script('ddpdm-tina-blurbs-i-wanna-be-js', plugins_url('build/tina/js/home4/tinaBlurbsWannaBe.js', __FILE__));
                    }
                    if ($ddpdm_css_tina == 'tina-blurbs-you-lead-me') {
                        wp_enqueue_script('ddpdm-tina-blurbs-you-lead-me-js', plugins_url('build/tina/js/home4/tinaBlurbsYouLeadMe.js', __FILE__));
                    }
                    if ($ddpdm_css_tina == 'tina-testimonial-who-did') {
                        wp_enqueue_script('ddpdm-tina-testimonial-who-did-js', plugins_url('build/tina/js/home4/tinaTestimonialWhoDid.js', __FILE__));
                    }

                    // optins

                    if ($ddpdm_css_tina == 'tina-optin-so-familiar') {
                        wp_enqueue_script('ddpdm-tina-optin-so-familiar-js', plugins_url('build/tina/js/email-optin/tinaOptinSoFamiliar.js', __FILE__));
                    }

                    if ($ddpdm_css_tina == 'tina-optin-you-need') {
                        wp_enqueue_script('ddpdm-tina-optin-you-need-js', plugins_url('build/tina/js/email-optin/tinaOptinYouNeed.js', __FILE__));
                    }

                    if ($ddpdm_css_tina == 'tina-optin-gonna-be') {
                        wp_enqueue_script('ddpdm-tina-optin-gonna-be-js', plugins_url('build/tina/js/email-optin/tinaOptinGonnaBe.js', __FILE__));
                    }

                    if ($ddpdm_css_tina == 'tina-optin-be-right') {
                        wp_enqueue_script('ddpdm-tina-optin-be-right-js', plugins_url('build/tina/js/email-optin/tinaOptinBeRight.js', __FILE__));
                    }

                    if ($ddpdm_css_tina == 'tina-optin-right-here') {
                        wp_enqueue_script('ddpdm-tina-optin-right-here-js', plugins_url('build/tina/js/email-optin/tinaOptinRightHere.js', __FILE__));
                    }

                    if ($ddpdm_css_tina == 'tina-optin-a-kind') {
                        wp_enqueue_script('ddpdm-tina-optin-a-kind-js', plugins_url('build/tina/js/email-optin/tinaOptinAkind.js', __FILE__));
                    }

                    if ($ddpdm_css_tina == 'tina-optin-other-lives') {
                        wp_enqueue_script('ddpdm-tina-optin-other-lives-js', plugins_url('build/tina/js/email-optin/tinaOptinOtherLives.js', __FILE__));
                    }

                    if ($ddpdm_css_tina == 'tina-optin-your-kiss') {
                        wp_enqueue_script('ddpdm-tina-optin-your-kiss-js', plugins_url('build/tina/js/email-optin/tinaOptinYourKiss.js', __FILE__));
                    }

                    // Content Pages

                    if ($ddpdm_css_tina == 'tina-content-page3') {
                        wp_enqueue_script('ddpdm-tina-content-page-3-js', plugins_url('build/tina/js/content-page3/tinaContentPage3.js', __FILE__));
                    }

                    if ($ddpdm_css_tina == 'tina-content-page8') {
                        wp_enqueue_script('ddpdm-tina-content-page-8-js', plugins_url('build/tina/js/content-page8/tinaContentPage8.js', __FILE__));
                    }

                    // Sidebars

                    if ($ddpdm_css_tina == 'tina-my-lover-sidebar') {
                        wp_enqueue_script('ddpdm-tina-my-lover-sidebar-js', plugins_url('build/tina/js/content-page1/tinaSidebarMyLover.js', __FILE__));
                    }

                    if ($ddpdm_css_tina == 'tina-my-beggining-sidebar') {
                        wp_enqueue_script('ddpdm-tina-my-beggining-sidebar-js', plugins_url('build/tina/js/content-page3/tinaSidebarMyBeggining.js', __FILE__));
                    }

                    if ($ddpdm_css_tina == 'tina-feel-like-sidebar') {
                        wp_enqueue_script('ddpdm-tina-feel-like-sidebar-js', plugins_url('build/tina/js/content-page4/tinaSidebarFeelLike.js', __FILE__));
                    }

                    if ($ddpdm_css_tina == 'tina-waiting-baby-sidebar') {
                        wp_enqueue_script('ddpdm-tina-waiting-baby-sidebar-js', plugins_url('build/tina/js/content-page7/tinaSidebarWaitingBaby.js', __FILE__));
                    }

                    if ($ddpdm_css_tina == 'tina-this-life-sidebar') {
                        wp_enqueue_script('ddpdm-tina-this-life-sidebar-js', plugins_url('build/tina/js/content-page9/tinaSidebarThisLife.js', __FILE__));
                    }

                    if ($ddpdm_css_tina == 'tina-contentpage10-sidebar') {
                        wp_enqueue_script('ddpdm-tina-contentpage10-sidebar-js', plugins_url('build/tina/js/content-page10/tinaSidebarContentPage10.js', __FILE__));
                    }

                    if ($ddpdm_css_tina == 'tina-the-sun-sidebar') {
                        wp_enqueue_script('ddpdm-tina-the-sun-sidebar-js', plugins_url('build/tina/js/content-page11/tinaSidebarTheSun.js', __FILE__));
                    }

                    if ($ddpdm_css_tina == 'tina-sidewalk-contact-page') {
                        wp_enqueue_script('ddpdm-tina-sidewalk-contact-page-js', plugins_url('build/tina/js/contact-page1/tinaContactSidewalk.js', __FILE__), array( 'wp-i18n' ));
                    }

                    if ($ddpdm_css_tina == 'tina-my-friend-content') {
                        wp_enqueue_script('ddpdm-tina-my-friend-content-js', plugins_url('build/tina/js/services-page1/tinaContentMyFriend.js', __FILE__));
                    }

                    if ($ddpdm_css_tina == 'tina-way-down-blurbs') {
                        wp_enqueue_script('ddpdm-tina-way-down-blurbs-js', plugins_url('build/tina/js/services-page2/tinaBlurbsWayDown.js', __FILE__));
                    }

                    if ($ddpdm_css_tina == 'tina-wanna-content') {
                        wp_enqueue_script('ddpdm-tina-wanna-content-js', plugins_url('build/tina/js/services-page2/tinaContentWanna.js', __FILE__));
                    }

                    if ($ddpdm_css_tina == 'tina-every-inch-testimonial') {
                        wp_enqueue_script('ddpdm-tina-every-inch-testimonial-js', plugins_url('build/tina/js/services-page2/tinaTestimonialEveryInch.js', __FILE__));
                    }

                    if ($ddpdm_css_tina == 'tina-your-decisions-header') {
                        wp_enqueue_script('ddpdm-tina-header-your-decisions-js', plugins_url('build/tina/js/home5/tinaHeaderYourDecisions.js', __FILE__), array( 'wp-i18n' ));
                    }

                    if ($ddpdm_css_tina == 'tina-sometimes-content') {
                        wp_enqueue_script('ddpdm-tina-sometimes-content-js', plugins_url('build/tina/js/home5/tinaContentSometimes.js', __FILE__));
                    }

                    if ($ddpdm_css_tina == 'tina-you-again-tabs') {
                        wp_enqueue_script('ddpdm-tina-you-again-tabs-js', plugins_url('build/tina/js/home5/tinaTabsYouAgain.js', __FILE__));
                    }

                    if ($ddpdm_css_tina == 'tina-about-all-blog') {
                        wp_enqueue_script('ddpdm-tina-about-all-blog-js', plugins_url('build/tina/js/home5/tinaBlogAboutAll.js', __FILE__));
                    }

                    if ($ddpdm_css_tina == 'tina-I-can-footer') {
                        wp_enqueue_script('ddpdm-tina-I-can-footer-js', plugins_url('build/tina/js/home5/tinaFooterIcan.js', __FILE__), array( 'wp-i18n' ));
                    }

                    if ($ddpdm_css_tina == 'tina-girl-testimonial') {
                        wp_enqueue_script('ddpdm-tina-girl-testimonial-js', plugins_url('build/tina/js/about1/tinaTestimonialGirl.js', __FILE__));
                    }

                    // Accordion

                    if ($ddpdm_css_tina == 'tina-accordion-anybody') {
                        wp_enqueue_script('ddpdm-tina-accordion-anybody-js', plugins_url('build/tina/js/accordions/tinaAccordionAnybody.js', __FILE__));
                    }

                    if ($ddpdm_css_tina == 'tina-accordion-charge-of') {
                        wp_enqueue_script('ddpdm-tina-accordion-charge-of-js', plugins_url('build/tina/js/accordions/tinaAccordionChargeOf.js', __FILE__));
                    }

                    if ($ddpdm_css_tina == 'tina-accordion-you-alone') {
                        wp_enqueue_script('ddpdm-tina-accordion-you-alone-js', plugins_url('build/tina/js/accordions/tinaAccordionYouAlone.js', __FILE__));
                    }

                    if ($ddpdm_css_tina == 'tina-accordion-da-dap') {
                        wp_enqueue_script('ddpdm-tina-accordion-da-dap-js', plugins_url('build/tina/js/accordions/tinaAccordionDaDap.js', __FILE__));
                    }

                    if ($ddpdm_css_tina == 'tina-accordion-looked-down') {
                        wp_enqueue_script('ddpdm-tina-accordion-looked-down-js', plugins_url('build/tina/js/accordions/tinaAccordionLookedDown.js', __FILE__));
                    }

                    if ($ddpdm_css_tina == 'tina-accordion-the-start') {
                        wp_enqueue_script('ddpdm-tina-accordion-the-start-js', plugins_url('build/tina/js/accordions/tinaAccordionTheStart.js', __FILE__));
                    }

                    if ($ddpdm_css_tina == 'tina-accordion-my-heart') {
                        wp_enqueue_script('ddpdm-tina-accordion-my-heart-js', plugins_url('build/tina/js/accordions/tinaAccordionMyHeart.js', __FILE__));
                    }

                    if ($ddpdm_css_tina == 'tina-accordion-my-home') {
                        wp_enqueue_script('ddpdm-tina-accordion-my-home-js', plugins_url('build/tina/js/accordions/tinaAccordionMyHome.js', __FILE__));
                    }

                    if ($ddpdm_css_tina == 'tina-accordion-key-to') {
                        wp_enqueue_script('ddpdm-tina-accordion-key-to-js', plugins_url('build/tina/js/accordions/tinaAccordionKeyTo.js', __FILE__));
                    }

                    if ($ddpdm_css_tina == 'tina-accordion-common-sense') {
                        wp_enqueue_script('ddpdm-tina-accordion-common-sense-js', plugins_url('build/tina/js/accordions/tinaAccordionCommonSense.js', __FILE__));
                    }

                    if ($ddpdm_css_tina == 'tina-accordion-i-grew') {
                        wp_enqueue_script('ddpdm-tina-accordion-i-grew-js', plugins_url('build/tina/js/accordions/tinaAccordionIgrew.js', __FILE__));
                    }

                    // accordions end

                    if ($ddpdm_css_tina == 'tina-footer-time-to') {
                        wp_enqueue_script('ddpdm-tina-footer-time-to-js', plugins_url('build/tina/js/home4/tinaFooterTimeTo.js', __FILE__), array( 'wp-i18n' ));
                    }

                    if ($ddpdm_css_tina == 'tina-thinking-about-header') {
                        wp_enqueue_script('ddpdm-tina-thinking-about-header-js', plugins_url('build/tina/js/home6/tinaHeaderThinkingAbout.js', __FILE__));
                    }

                    if ($ddpdm_css_tina == 'tina-the-past-content') {
                        wp_enqueue_script('ddpdm-tina-the-past-content-js', plugins_url('build/tina/js/home6/tinaContentThePast.js', __FILE__));
                    }

                    if ($ddpdm_css_tina == 'tina-my-shoulder-blurbs') {
                        wp_enqueue_script('ddpdm-tina-my-shoulder-blurbs-js', plugins_url('build/tina/js/home6/tinaBlurbsMyShoulder.js', __FILE__));
                    }

                    if ($ddpdm_css_tina == 'tina-all-behind-blurbs') {
                        wp_enqueue_script('ddpdm-tina-all-behind-blurbs-js', plugins_url('build/tina/js/home6/tinaBlurbsAllBehind.js', __FILE__));
                    }

                    if ($ddpdm_css_tina == 'tina-all-behind-button') {
                        wp_enqueue_script('ddpdm-tina-all-behind-button-js', plugins_url('build/tina/js/tinaAllBehindButton.js', __FILE__));
                    }

                    if ($ddpdm_css_tina == 'tina-my-lover-blog') {
                        wp_enqueue_script('ddpdm-tina-my-lover-blog-js', plugins_url('build/tina/js/home6/tinaBlogMyLover.js', __FILE__));
                    }

                    if ($ddpdm_css_tina == 'tina-I-breathe-footer') {
                        wp_enqueue_script('ddpdm-tina-I-breathe-footer-js', plugins_url('build/tina/js/home6/tinaFooterBreathe.js', __FILE__));
                    }

                    if ($ddpdm_css_tina == 'tina-content-second-try') {
                        wp_enqueue_script('ddpdm-tina-content-second-try-js', plugins_url('build/tina/js/contact-page3/tinaContentSecondTry.js', __FILE__));
                    }

                    if ($ddpdm_css_tina == 'tina-contact-form-talk-now') {
                        wp_enqueue_script('ddpdm-tina-contact-form-talk-now-js', plugins_url('build/tina/js/contact-page2/tinaContactFormTalkNow.js', __FILE__), array( 'wp-i18n' ));
                    }

                    if ($ddpdm_css_tina == 'tina-content-eight-wheeler') {
                        wp_enqueue_script('ddpdm-tina-content-eight-wheeler-js', plugins_url('build/tina/js/services-page3/tinaContentEightWheeler.js', __FILE__));
                    }

                    if ($ddpdm_css_tina == 'tina-cta-im-moving') {
                        wp_enqueue_script('ddpdm-tina-cta-im-moving-js', plugins_url('build/tina/js/services-page3/tinaCtaImMoving.js', __FILE__));
                    }

                    if ($ddpdm_css_tina == 'tina-testimonial-i-got') {
                        wp_enqueue_script('ddpdm-tina-testimonial-i-got-js', plugins_url('build/tina/js/services-page3/tinaTestimonialIgot.js', __FILE__));
                    }

                    if ($ddpdm_css_tina == 'tina-content-throttle') {
                        wp_enqueue_script('ddpdm-tina-content-throttle-js', plugins_url('build/tina/js/process-page1/tinaContentThrottle.js', __FILE__));
                    }

                    if ($ddpdm_css_tina == 'tina-content-ease') {
                        wp_enqueue_script('ddpdm-tina-content-ease-js', plugins_url('build/tina/js/process-page1/tinaContentEase.js', __FILE__));
                    }

                    if ($ddpdm_css_tina == 'tina-testimonial-you-got') {
                        wp_enqueue_script('ddpdm-tina-testimonial-you-got-js', plugins_url('build/tina/js/process-page1/tinaTestimonialYouGot.js', __FILE__));
                    }

                    if ($ddpdm_css_tina == 'tina-content-listen') {
                        wp_enqueue_script('ddpdm-tina-content-listen-js', plugins_url('build/tina/js/process-page2/tinaContentLlisten.js', __FILE__));
                    }

                    if ($ddpdm_css_tina == 'tina-content-mister') {
                        wp_enqueue_script('ddpdm-tina-content-mister-js', plugins_url('build/tina/js/process-page2/tinaContentMister.js', __FILE__));
                    }

                    if ($ddpdm_css_tina == 'tina-testimonial-told-you') {
                        wp_enqueue_script('ddpdm-tina-testimonial-told-you-js', plugins_url('build/tina/js/process-page2/tinaTestimonialToldYou.js', __FILE__));
                    }

                    if ($ddpdm_css_tina == 'tina-come-on-projects') {
                        wp_enqueue_script('ddpdm-tina-come-on-projects-js', plugins_url('build/tina/js/careers/comeOnProjects.js', __FILE__));
                    }

                    if ($ddpdm_css_tina == 'tina-content-wanna-hear') {
                        wp_enqueue_script('ddpdm-tina-content-wanna-hear-js', plugins_url('build/tina/js/about2/tinaContentWannaHear.js', __FILE__));
                    }

                    if ($ddpdm_css_tina == 'tina-person-talk-now') {
                        wp_enqueue_script('ddpdm-tina-person-module-talk-now-js', plugins_url('build/tina/js/about2/tinaPersonTalkNow.js', __FILE__));
                    }

                    if ($ddpdm_css_tina == 'tina-slider-sail-away') {
                        wp_enqueue_script('ddpdm-tina-slider-sail-away-js', plugins_url('build/tina/js/tinaSliderSailAway.js', __FILE__));
                    }

                    if ($ddpdm_css_tina == 'tina-slider-you-take') {
                        wp_enqueue_script('ddpdm-tina-slider-you-take-js', plugins_url('build/tina/js/home7/tinaSliderYouTake.js', __FILE__));
                    }

                    if ($ddpdm_css_tina == 'tina-slider-you-take-v2') {
                        wp_enqueue_script('ddpdm-tina-slider-you-take-v2-js', plugins_url('build/tina/js/home7/tinaSliderYouTakeV2.js', __FILE__));
                    }

                    if ($ddpdm_css_tina == 'tina-portfolio-bayou') {
                        wp_enqueue_script('ddpdm-tina-portfolio-bayou-js', plugins_url('build/tina/js/portfolio-1/tinaPortfolioBayou.js', __FILE__));
                    }

                    if ($ddpdm_css_tina == 'tina-portfolio-ribbon') {
                        wp_enqueue_script('ddpdm-tina-portfolio-ribbon-js', plugins_url('build/tina/js/portfolio-2/tinaPortfolioRibbon.js', __FILE__));
                    }

                    if ($ddpdm_css_tina == 'tina-header-have-ridden') {
                        wp_enqueue_script('ddpdm-tina-header-have-ridden-js', plugins_url('build/tina/js/home8/tinaHeaderHaveRidden.js', __FILE__));
                    }

                    if ($ddpdm_css_tina == 'tina-numbers-orignal') {
                        wp_enqueue_script('ddpdm-tina-numbers-orignal-js', plugins_url('build/tina/js/home8/tinaNumbersOrignal.js', __FILE__));
                    }

                    if ($ddpdm_css_tina == 'tina-video-sage') {
                        wp_enqueue_script('ddpdm-tina-video-sage-js', plugins_url('build/tina/js/home8/tinaVideoSage.js', __FILE__));
                    }

                    if ($ddpdm_css_tina == 'tina-case-studies-takes-two') {
                        wp_enqueue_script('ddpdm-tina-case-studies-takes-two-js', plugins_url('build/tina/js/home8/tinaCaseStudiesTakesTwo.js', __FILE__));
                    }

                    if ($ddpdm_css_tina == 'tina-footer-proud') {
                        wp_enqueue_script('ddpdm-tina-footer-proud-js', plugins_url('build/tina/js/home8/tinaFooterProud.js', __FILE__));
                    }

                    if ($ddpdm_css_tina == 'tina-person-call-it') {
                        wp_enqueue_script('ddpdm-tina-person-module-call-it-js', plugins_url('build/tina/js/about3/tinaPersonModuleCallIt.js', __FILE__));
                    }

                    if ($ddpdm_css_tina == 'tina-content-church-house') {
                        wp_enqueue_script('ddpdm-tina-content-church-house-js', plugins_url('build/tina/js/home9/tinaContentChurchHouse.js', __FILE__));
                    }

                    if ($ddpdm_css_tina == 'tina-blurbs-speed-limit') {
                        wp_enqueue_script('ddpdm-tina-blurbs-speed-limit', plugins_url('build/tina/js/home9/tinaBlurbsSpeedLimit.js', __FILE__));
                    }

                    if ($ddpdm_css_tina == 'tina-tabs-highway') {
                        wp_enqueue_script('ddpdm-tina-tabs-highway-js', plugins_url('build/tina/js/home9/tinaTabsHighway.js', __FILE__));
                    }

                    if ($ddpdm_css_tina == 'tina-testimonial-city-limites') {
                        wp_enqueue_script('ddpdm-tina-testimonial-city-limites-js', plugins_url('build/tina/js/home9/tinaTestimonialCityLimites.js', __FILE__));
                    }

                    if ($ddpdm_css_tina == 'tina-archive-1') {
                        wp_enqueue_script('ddpdm-tina-archive-1-js', plugins_url('build/tina/js/archive1/tinaArchive1.js', __FILE__));
                    }

                    if ($ddpdm_css_tina == 'tina-blog-rain-falling') {
                        wp_enqueue_script('ddpdm-tina-blog-rain-falling-js', plugins_url('build/tina/js/magazine/tinaBlogRainFalling.js', __FILE__), array( 'wp-i18n' ));
                    }

                    if ($ddpdm_css_tina == 'tina-blog-bad-enough') {
                        wp_enqueue_script('ddpdm-tina-blog-bad-enough-js', plugins_url('build/tina/js/magazine/tinaBlogBadEnough.js', __FILE__));
                    }

                    if ($ddpdm_css_tina == 'tina-products-working-for') {
                        wp_enqueue_script('ddpdm-tina-products-working-for-js', plugins_url('build/tina/js/magazine/tinaProductsWorkingFor.js', __FILE__));
                    }

                    if ($ddpdm_css_tina == 'tina-video-talk-much') {
                        wp_enqueue_script('ddpdm-tina-video-talk-much-js', plugins_url('build/tina/js/magazine/tinaVideoTalkMuch.js', __FILE__));
                    }

                    if ($ddpdm_css_tina == 'tina-blog-this-town') {
                        wp_enqueue_script('ddpdm-tina-blog-this-town-js', plugins_url('build/tina/js/magazine/tinaBlogThisTown.js', __FILE__));
                    }

                    if ($ddpdm_css_tina == 'tina-pricing-tables-pinch-of') {
                        wp_enqueue_script('ddpdm-tina-pricing-tables-pinch-of-js', plugins_url('build/tina/js/pricing-1/tinaPricingTablesPinchOf.js', __FILE__));
                    }

                    if ($ddpdm_css_tina == 'tina-testimonial-one-can') {
                        wp_enqueue_script('ddpdm-tina-testimonial-one-can-js', plugins_url('build/tina/js/pricing-1/tinaTestimonialOneCan.js', __FILE__));
                    }

                    if ($ddpdm_css_tina == 'tina-pricing-table-pretending') {
                        wp_enqueue_script('ddpdm-tina-pricing-table-pretending-js', plugins_url('build/tina/js/pricing-2/tinaPricingTablePretending.js', __FILE__));
                    }

                    if ($ddpdm_css_tina == 'tina-blog-1') {
                        wp_enqueue_script('ddpdm-tina-blog-1-js', plugins_url('build/tina/js/blogs/blog1/tinaBlog1.js', __FILE__));
                    }

                    if ($ddpdm_css_tina == 'tina-blog-2') {
                        wp_enqueue_script('ddpdm-tina-blog-2-js', plugins_url('build/tina/js/blogs/blog2/tinaBlog2.js', __FILE__));
                    }

                    if ($ddpdm_css_tina == 'tina-blog-3') {
                        wp_enqueue_script('ddpdm-tina-blog-3-js', plugins_url('build/tina/js/blogs/blog3/tinaBlog3.js', __FILE__));
                    }

                    if ($ddpdm_css_tina == 'tina-blog-4') {
                        wp_enqueue_script('ddpdm-tina-blog-4-js', plugins_url('build/tina/js/blogs/blog4/tinaBlog4.js', __FILE__));
                    }

                    if ($ddpdm_css_tina == 'tina-blog-6') {
                        wp_enqueue_script('ddpdm-tina-blog-6-js', plugins_url('build/tina/js/blogs/blog6/tinaBlog6.js', __FILE__));
                    }

                    if ($ddpdm_css_tina == 'tina-blog-7') {
                        wp_enqueue_script('ddpdm-tina-blog-7-js', plugins_url('build/tina/js/blogs/blog7/tinaBlog7.js', __FILE__));
                    }

                    // Landing Page 1

                    if ($ddpdm_css_tina == 'tina-testimonials-idolize-you') {
                        wp_enqueue_script('ddpdm-tina-testimonials-idolize-you-js', plugins_url('build/tina/js/tina-lead-1/tinaTestimonialsIdolizeYou.js', __FILE__));
                    }

                    // Landing Page 2

                    if ($ddpdm_css_tina == 'tina-header-crazy') {
                        wp_enqueue_script('ddpdm-tina-header-crazy-js', plugins_url('build/tina/js/tina-lead-2/tinaHeaderCrazy.js', __FILE__));
                    }

                    if ($ddpdm_css_tina == 'tina-content-way') {
                        wp_enqueue_script('ddpdm-tina-content-way-js', plugins_url('build/tina/js/tina-lead-2/tinaContentWay.js', __FILE__));
                    }

                    if ($ddpdm_css_tina == 'tina-testimonial-finest-girl') {
                        wp_enqueue_script('ddpdm-tina-testimonial-finest-girl-js', plugins_url('build/tina/js/tina-lead-2/tinaTestimonialFinestGirl.js', __FILE__));
                    }

                    if ($ddpdm_css_tina == 'tina-pricing-table-it-on') {
                        wp_enqueue_script('ddpdm-tina-pricing-table-it-on-js', plugins_url('build/tina/js/tina-lead-2/tinaPricingTableItOn.js', __FILE__));
                    }

                    // Landing Page 3

                    if ($ddpdm_css_tina == 'tina-header-steam') {
                        wp_enqueue_script('ddpdm-tina-header-steam-js', plugins_url('build/tina/js/tina-lead-3/tinaHeaderSteam.js', __FILE__), array( 'wp-i18n' ));
                    }
                }
            }

            // Tina ends

            // Ragnar

            if (!empty(get_post_meta($post->ID, 'ddp-css-ragnar'))) {
                foreach ((array) get_post_meta($post->ID, 'ddp-css-ragnar') as $ddpdm_css_ragnar) {
                    //gsap

                    if ($ddpdm_css_ragnar == 'ragnar-menu-titan' || $ddpdm_css_ragnar == 'ragnar-menu-giants' || $ddpdm_css_ragnar == 'ragnar-menu-stolen' || $ddpdm_css_ragnar == 'ragnar-menu-odin' || $ddpdm_css_ragnar == 'ragnar-blurbs-freeman' || $ddpdm_css_ragnar == 'ragnar-blurbs-chin' || $ddpdm_css_ragnar == 'ragnar-blog-skarde' || $ddpdm_css_ragnar == 'ragnar-content-skarde' || $ddpdm_css_ragnar == 'ragnar-content-sten' || $ddpdm_css_ragnar == 'ragnar-content-secret' || $ddpdm_css_ragnar == 'ragnar-header-rune' || $ddpdm_css_ragnar == 'ragnar-content-curly' || $ddpdm_css_ragnar == 'ragnar-person-module-roar' || $ddpdm_css_ragnar == 'ragnar-menu-farmer'  || $ddpdm_css_ragnar == 'ragnar-menu-hulks'  || $ddpdm_css_ragnar == 'ragnar-menu-idun'  || $ddpdm_css_ragnar == 'ragnar-menu-longhouse'  || $ddpdm_css_ragnar == 'ragnar-menu-pursuit'  || $ddpdm_css_ragnar == 'ragnar-menu-skalds'  || $ddpdm_css_ragnar == 'ragnar-menu-valhalla') {
                        wp_enqueue_script('ddpdm-freddie-gsap-jquery-js', plugins_url('build/freddie/js/gsap/gsap.min.js', __FILE__));
                        wp_enqueue_script('ddpdm-freddie-load-draw-svg-js', plugins_url('build/freddie/js/gsap/LoadDrawSVGPlugin.js', __FILE__));
                    }


                    // for 25 Nov
                    if ($ddpdm_css_ragnar == 'ragnar-header-arne') {
                        wp_enqueue_script('ddpdm-ragnar-header-arne-js', plugins_url('build/ragnar/js/ragnar-home-1/ragnarHeaderArne.js', __FILE__));
                    }
                    if ($ddpdm_css_ragnar == 'ragnar-blurbs-keeper') {
                        wp_enqueue_script('ddpdm-ragnar-blurbs-keeper-js', plugins_url('build/ragnar/js/ragnar-home-1/ragnarBlurbsKeeper.js', __FILE__));
                    }
                    if ($ddpdm_css_ragnar == 'ragnar-blog-bjorn') {
                        wp_enqueue_script('ddpdm-ragnar-blog-bjorn-js', plugins_url('build/ragnar/js/ragnar-home-1/ragnarBlogBjorn.js', __FILE__));
                    }
                    if ($ddpdm_css_ragnar == 'ragnar-content-bear') {
                        wp_enqueue_script('ddpdm-ragnar-content-bear-js', plugins_url('build/ragnar/js/ragnar-home-1/ragnarContentBear.js', __FILE__));
                    }
                    if ($ddpdm_css_ragnar == 'ragnar-footer-bo') {
                        wp_enqueue_script('ddpdm-ragnar-footer-bo-js', plugins_url('build/ragnar/js/ragnar-home-1/ragnarFooterBo.js', __FILE__));
                    }


                    if ($ddpdm_css_ragnar == 'ragnar-blurbs-ruler') {
                        wp_enqueue_script('ddpdm-ragnar-blurbs-ruler-js', plugins_url('build/ragnar/js/ragnar-home-2/ragnarBlurbsRuler.js', __FILE__));
                    }
                    if ($ddpdm_css_ragnar == 'ragnar-testimonails-gorm') {
                        wp_enqueue_script('ddpdm-ragnar-testimonails-gorm-js', plugins_url('build/ragnar/js/ragnar-home-2/ragnarTesimonailsGorm.js', __FILE__));
                    }
                    if ($ddpdm_css_ragnar == 'ragnar-blog-halfdan') {
                        wp_enqueue_script('ddpdm-ragnar-blog-halfdan-js', plugins_url('build/ragnar/js/ragnar-home-2/ragnarBlogHalfdan.js', __FILE__));
                    }
                    if ($ddpdm_css_ragnar == 'ragnar-footer-danish') {
                        wp_enqueue_script('ddpdm-ragnar-footer-danish-js', plugins_url('build/ragnar/js/ragnar-home-2/ragnarFooterDanish.js', __FILE__));
                    }


                    if ($ddpdm_css_ragnar == 'ragnar-header-left') {
                        wp_enqueue_script('ddpdm-ragnar-header-left-js', plugins_url('build/ragnar/js/ragnar-home-3/ragnarHeaderLeft.js', __FILE__));
                    }
                    if ($ddpdm_css_ragnar == 'ragnar-content-curly') {
                        wp_enqueue_script('ddpdm-ragnar-content-curly-js', plugins_url('build/ragnar/js/ragnar-home-3/ragnarContentCurly.js', __FILE__));
                    }
                    if ($ddpdm_css_ragnar == 'ragnar-content-kare') {
                        wp_enqueue_script('ddpdm-ragnar-content-kare-js', plugins_url('build/ragnar/js/ragnar-home-3/ragnarContentKare.js', __FILE__));
                    }
                    if ($ddpdm_css_ragnar == 'ragnar-blog-knud') {
                        wp_enqueue_script('ddpdm-ragnar-blog-knud-js', plugins_url('build/ragnar/js/ragnar-home-3/ragnarBlogKnud.js', __FILE__));
                    }


                    if ($ddpdm_css_ragnar == 'ragnar-header-descendant') {
                        wp_enqueue_script('ddpdm-ragnar-header-descendant-js', plugins_url('build/ragnar/js/ragnar-home-4/ragnarHeaderDescendant.js', __FILE__));
                    }
                    if ($ddpdm_css_ragnar == 'ragnar-content-njal') {
                        wp_enqueue_script('ddpdm-ragnar-content-njal-js', plugins_url('build/ragnar/js/ragnar-home-4/ragnarContentNjal.js', __FILE__));
                    }
                    if ($ddpdm_css_ragnar == 'ragnar-blog-rune') {
                        wp_enqueue_script('ddpdm-ragnar-blog-rune-js', plugins_url('build/ragnar/js/ragnar-home-4/ragnarBlogRune.js', __FILE__));
                    }


                    if ($ddpdm_css_ragnar == 'ragnar-content-wheeler') {
                        wp_enqueue_script('ddpdm-ragnar-content-wheeler-js', plugins_url('build/ragnar/js/ragnar-home-5/ragnarContentWheeler.js', __FILE__));
                    }
                    if ($ddpdm_css_ragnar == 'ragnar-testimonial-daddy') {
                        wp_enqueue_script('ddpdm-ragnar-testimonial-daddy-js', plugins_url('build/ragnar/js/ragnar-home-5/ragnarTestimonialDaddy.js', __FILE__));
                    }
                    if ($ddpdm_css_ragnar == 'ragnar-blog-loud-whistle') {
                        wp_enqueue_script('ddpdm-ragnar-blog-loud-whistle-js', plugins_url('build/ragnar/js/ragnar-home-5/ragnarBlogLoudWhistle.js', __FILE__));
                    }

                    // for 26 Nov
                    if ($ddpdm_css_ragnar == 'ragnar-contact-trygve') {
                        wp_enqueue_script('ddpdm-ragnar-blog-loud-whistle-js', plugins_url('build/ragnar/js/ragnar-contact-1/ragnarContactTrygve.js', __FILE__));
                    }


                    if ($ddpdm_css_ragnar == 'ragnar-content-astrid') {
                        wp_enqueue_script('ddpdm-ragnar-content-astrid-js', plugins_url('build/ragnar/js/ragnar-contact-4/ragnarContactAstrid.js', __FILE__));
                    }


                    if ($ddpdm_css_ragnar == 'ragnar-content-tove') {
                        wp_enqueue_script('ddpdm-ragnar-content-tove-js', plugins_url('build/ragnar/js/ragnar-contact-6/ragnarContentTove.js', __FILE__));
                    }



                    if ($ddpdm_css_ragnar == 'ragnar-slider-thor') {
                        wp_enqueue_script('ddpdm-ragnar-slider-thor-js', plugins_url('build/ragnar/js/ragnar-case-study-1/ragnarSliderThor.js', __FILE__));
                    }


                    if ($ddpdm_css_ragnar == 'ragnar-content-i-steer') {
                        wp_enqueue_script('ddpdm-ragnar-content-i-steer-js', plugins_url('build/ragnar/js/ragnar-case-study-2/ragnarContentIsteer.js', __FILE__));
                    }

                    if ($ddpdm_css_ragnar == 'ragnar-projects-good-oars') {
                        wp_enqueue_script('ddpdm-ragnar-projects-good-oars-js', plugins_url('build/ragnar/js/ragnar-case-study-2/ragnarProjectsGoodOars.js', __FILE__));
                    }


                    if ($ddpdm_css_ragnar == 'ragnar-person-module-roar') {
                        wp_enqueue_script('ddpdm-ragnar-person-module-roar-js', plugins_url('build/ragnar/js/ragnar-team-1/ragnarPersonRoar.js', __FILE__));
                    }
                    if ($ddpdm_css_ragnar == 'ragnar-content-spear') {
                        wp_enqueue_script('ddpdm-ragnar-content-spear-js', plugins_url('build/ragnar/js/ragnar-team-1/ragnarContentSpear.js', __FILE__));
                    }
                    if ($ddpdm_css_ragnar == 'ragnar-portfolio-good-oars') {
                        wp_enqueue_script('ddpdm-ragnar-portfolio-good-oars-js', plugins_url('build/ragnar/js/ragnar-our-work/ragnarPortfolioGoodOars.js', __FILE__));
                    }

                    // for 27 Nov

                    if ($ddpdm_css_ragnar == 'ragnar-menu-farmer') {
                        wp_enqueue_script('ddpdm-ragnar-menu-farmer-js', plugins_url('build/ragnar/js/ragnar-menus/ragnarMenuFarmer.js', __FILE__));
                    }

                    if ($ddpdm_css_ragnar == 'ragnar-menu-hulks') {
                        wp_enqueue_script('ddpdm-ragnar-menu-hulks-js', plugins_url('build/ragnar/js/ragnar-menus/ragnarMenuHulks.js', __FILE__));
                    }

                    if ($ddpdm_css_ragnar == 'ragnar-menu-idun') {
                        wp_enqueue_script('ddpdm-ragnar-menu-idun-js', plugins_url('build/ragnar/js/ragnar-menus/ragnarMenuIdun.js', __FILE__));
                    }

                    if ($ddpdm_css_ragnar == 'ragnar-menu-longhouse') {
                        wp_enqueue_script('ddpdm-ragnar-menu-longhouse-js', plugins_url('build/ragnar/js/ragnar-menus/ragnarMenuLonghouse.js', __FILE__));
                    }

                    if ($ddpdm_css_ragnar == 'ragnar-menu-pursuit') {
                        wp_enqueue_script('ddpdm-ragnar-menu-pursuit-js', plugins_url('build/ragnar/js/ragnar-menus/ragnarMenuPursuit.js', __FILE__));
                    }

                    if ($ddpdm_css_ragnar == 'ragnar-menu-skalds') {
                        wp_enqueue_script('ddpdm-ragnar-menu-skalds-js', plugins_url('build/ragnar/js/ragnar-menus/ragnarMenuSkalds.js', __FILE__));
                    }

                    if ($ddpdm_css_ragnar == 'ragnar-menu-valhalla') {
                        wp_enqueue_script('ddpdm-ragnar-menu-valhalla-js', plugins_url('build/ragnar/js/ragnar-menus/ragnarMenuValhalla.js', __FILE__));
                    }

                    if ($ddpdm_css_ragnar == 'ragnar-menu-odin') {
                        wp_enqueue_script('ddpdm-ragnar-menu-odin-js', plugins_url('build/ragnar/js/ragnar-menus/ragnarMenuOdin.js', __FILE__));
                    }


                    if ($ddpdm_css_ragnar == 'ragnar-menu-stolen') {
                        wp_enqueue_script('ddpdm-ragnar-menu-stolen-js', plugins_url('build/ragnar/js/ragnar-menus/ragnarMenuStolen.js', __FILE__));
                    }


                    if ($ddpdm_css_ragnar == 'ragnar-menu-giants') {
                        wp_enqueue_script('ddpdm-ragnar-menu-giants-js', plugins_url('build/ragnar/js/ragnar-menus/ragnarMenuGiants.js', __FILE__));
                    }

                    if ($ddpdm_css_ragnar == 'ragnar-menu-titan') {
                        wp_enqueue_script('ddpdm-ragnar-menu-titan-js', plugins_url('build/ragnar/js/ragnar-menus/ragnarMenuTitan.js', __FILE__));
                    }


                    // for 30 Nov

                    if ($ddpdm_css_ragnar == 'ragnar-not-found-5') {
                        wp_enqueue_script('ddpdm-ragnar-not-found-5-js', plugins_url('build/ragnar/js/ragnar-not-found/ragnarNotFound5.js', __FILE__));
                    }

                    if ($ddpdm_css_ragnar == 'ragnar-not-found-6') {
                        wp_enqueue_script('ddpdm-ragnar-not-found-6-js', plugins_url('build/ragnar/js/ragnar-not-found/ragnarNotFound6.js', __FILE__));
                    }

                    if ($ddpdm_css_ragnar == 'ragnar-not-found-16') {
                        wp_enqueue_script('ddpdm-ragnar-not-found-16-js', plugins_url('build/ragnar/js/ragnar-not-found/ragnarNotFound16.js', __FILE__));
                    }

                    if ($ddpdm_css_ragnar == 'ragnar-not-found-17') {
                        wp_enqueue_script('ddpdm-ragnar-not-found-17-js', plugins_url('build/ragnar/js/ragnar-not-found/ragnarNotFound17.js', __FILE__));
                    }

                    // for 2 Dec

                    for ($i = 1; $i < 18; $i++) {
                        if ($ddpdm_css_ragnar == 'ragnar-popups-'.$i) {
                            wp_enqueue_script('ddpdm-diana-cookies-js', plugins_url('build/diana/js/diana-jquery.cookie.js', __FILE__));
                            wp_enqueue_script('ddpdm-diana-pop-up-js', plugins_url('build/diana/js/dianaPopups.js', __FILE__));
                            $ddpdm_dataToBePassed = array(
                                'ddpdm_pop_template'  => get_option('ddpdm_pop_up_template'),
                                'ddpdm_pop_show_load' => get_theme_mod('ddpdm_pop_up_show_load', false),
                                'ddpdm_pop_delay'  => get_option('ddpdm_pop_up_delay'),
                                'ddpdm_pop_show_leave'  => get_theme_mod('ddpdm_pop_up_show_leave', false),
                                'ddpdm_pop_show_scroll'  => get_theme_mod('ddpdm_pop_up_show_scroll', false),
                                'ddpdm_pop_scroll_per' => get_option('ddpdm_pop_up_scroll_per'),
                                'ddpdm_sticky_delay'  => get_option('ddpdm_sticky_bar_delay'),
                                'ddpdm_sticky_cookie_days'  => get_option('ddpdm_sticky_bar_cookie_days'),
                                'ddpdm_sticky_show_leave'  => get_theme_mod('ddpdm_sticky_show_leave', false),
                                'ddpdm_sticky_bar_position' => get_option('ddpdm_sticky_bar_sticky'),
                                'ddpdm_sticky_show_scroll'  => get_theme_mod('ddpdm_sticky_show_scroll', false),
                                'ddpdm_sticky_bar_scroll_per' => get_option('ddpdm_sticky_bar_scroll_per'),
                            );
                            wp_localize_script('ddpdm-diana-pop-up-js', 'ddpdm_php_vars', $ddpdm_dataToBePassed);
                            wp_enqueue_script('ddpdm-ragnar-pop-up'.$i.'-js', plugins_url('build/ragnar/js/ragnar-popups/ragnarPopupsV'.$i.'.js', __FILE__));
                        }
                    }


//                for 2 Feb



                    if ($ddpdm_css_ragnar == 'ragnar-tabs-the-track') {
                        wp_enqueue_script('ddpdm-ragnar-tabs-the-track-js', plugins_url('build/ragnar/js/ragnar-about-1/ragnarTabsTheTrack.js', __FILE__));
                    }

                    if ($ddpdm_css_ragnar == 'ragnar-content-descendant') {
                        wp_enqueue_script('ddpdm-ragnar-content-descendant-js', plugins_url('build/ragnar/js/ragnar-about-2/ragnarContentDescendant.js', __FILE__));
                    }

                    if ($ddpdm_css_ragnar == 'ragnar-content-njal-v2') {
                        wp_enqueue_script('ddpdm-ragnar-content-njal-v2-js', plugins_url('build/ragnar/js/ragnar-about-2/ragnarContentNjalV2.js', __FILE__));
                    }

                    if ($ddpdm_css_ragnar == 'ragnar-person-leif') {
                        wp_enqueue_script('ddpdm-ragnar-person-leif-js', plugins_url('build/ragnar/js/ragnar-about-2/ragnarPersonLeif.js', __FILE__));
                    }

                    if ($ddpdm_css_ragnar == 'ragnar-content-secret') {
                        wp_enqueue_script('ddpdm-ragnar-content-secret-js', plugins_url('build/ragnar/js/ragnar-about-3/ragnarContentSecret.js', __FILE__));
                    }

                    if ($ddpdm_css_ragnar == 'ragnar-content-skarde') {
                        wp_enqueue_script('ddpdm-ragnar-content-skarde-js', plugins_url('build/ragnar/js/ragnar-about-3/ragnarContentSkarde.js', __FILE__));
                    }

                    if ($ddpdm_css_ragnar == 'ragnar-content-sten') {
                        wp_enqueue_script('ddpdm-ragnar-content-sten-js', plugins_url('build/ragnar/js/ragnar-about-3/ragnarContentSten.js', __FILE__));
                    }

                    if ($ddpdm_css_ragnar == 'ragnar-header-rune') {
                        wp_enqueue_script('ddpdm-ragnar-header-rune-js', plugins_url('build/ragnar/js/ragnar-about-3/ragnarHeaderRune.js', __FILE__));
                    }

                    if ($ddpdm_css_ragnar == 'ragnar-accordion-stone') {
                        wp_enqueue_script('ddpdm-ragnar-accordion-stone-js', plugins_url('build/ragnar/js/ragnar-home-6/ragnarAccordionStone.js', __FILE__));
                    }

                    if ($ddpdm_css_ragnar == 'ragnar-blog-skarde') {
                        wp_enqueue_script('ddpdm-ragnar-blog-skarde-js', plugins_url('build/ragnar/js/ragnar-home-6/ragnarBlogSkarde.js', __FILE__));
                    }

                    if ($ddpdm_css_ragnar == 'ragnar-blog-sten') {
                        wp_enqueue_script('ddpdm-ragnar-blog-sten-js', plugins_url('build/ragnar/js/ragnar-home-6/ragnarBlogSten.js', __FILE__));
                    }

                    if ($ddpdm_css_ragnar == 'ragnar-blurbs-chin') {
                        wp_enqueue_script('ddpdm-ragnar-blurbs-chin-js', plugins_url('build/ragnar/js/ragnar-home-6/ragnarBlurbsChin.js', __FILE__));
                    }

                    if ($ddpdm_css_ragnar == 'ragnar-blurbs-freeman') {
                        wp_enqueue_script('ddpdm-ragnar-blurbs-freeman-js', plugins_url('build/ragnar/js/ragnar-home-6/ragnarBlurbsFreeman.js', __FILE__));
                    }

                    if ($ddpdm_css_ragnar == 'ragnar-header-son') {
                        wp_enqueue_script('ddpdm-ragnar-header-son-js', plugins_url('build/ragnar/js/ragnar-home-6/ragnarHeaderSon.js', __FILE__));
                    }


                    if ($ddpdm_css_ragnar == 'ragnar-portfolio-william') {
                        wp_enqueue_script('ddpdm-ragnar-portfolio-william-js', plugins_url('build/ragnar/js/ragnar-our-work-2/ragnarPortfolioWilliam.js', __FILE__));
                    }

                    if ($ddpdm_css_ragnar == 'ragnar-content-karla') {
                        wp_enqueue_script('ddpdm-ragnar-content-karla-js', plugins_url('build/ragnar/js/ragnar-shop-landing-v1/ragnarContentKarla.js', __FILE__));
                    }

                    if ($ddpdm_css_ragnar == 'ragnar-products-clara') {
                        wp_enqueue_script('ddpdm-ragnar-products-clara-js', plugins_url('build/ragnar/js/ragnar-shop-landing-v1/ragnarProductsClara.js', __FILE__));
                    }

                    if ($ddpdm_css_ragnar == 'ragnar-products-josefine') {
                        wp_enqueue_script('ddpdm-ragnar-products-josefine-js', plugins_url('build/ragnar/js/ragnar-shop-landing-v1/ragnarProductsJosefine.js', __FILE__));
                    }

                    if ($ddpdm_css_ragnar == 'ragnar-person-the-difference') {
                        wp_enqueue_script('ddpdm-ragnar-person-the-difference-js', plugins_url('build/ragnar/js/ragnar-lead-1/ragnarPersonTheDifference.js', __FILE__));
                    }

                    if ($ddpdm_css_ragnar == 'ragnar-blog-adrian') {
                        wp_enqueue_script('ddpdm-ragnar-blog-adrian-js', plugins_url('build/ragnar/js/ragnar-blog-light/ragnarBlogAdrian.js', __FILE__));
                    }

                    if ($ddpdm_css_ragnar == 'ragnar-blog-agata') {
                        wp_enqueue_script('ddpdm-ragnar-blog-agata-js', plugins_url('build/ragnar/js/ragnar-blog-light/ragnarBlogAgata.js', __FILE__));
                    }

                    if ($ddpdm_css_ragnar == 'ragnar-blog-agneta') {
                        wp_enqueue_script('ddpdm-ragnar-blog-agneta-js', plugins_url('build/ragnar/js/ragnar-blog-light/ragnarBlogAgneta.js', __FILE__));
                    }

                    if ($ddpdm_css_ragnar == 'ragnar-blog-aina') {
                        wp_enqueue_script('ddpdm-ragnar-blog-aina-js', plugins_url('build/ragnar/js/ragnar-blog-light/ragnarBlogAina.js', __FILE__));
                    }

                    if ($ddpdm_css_ragnar == 'ragnar-blog-ake') {
                        wp_enqueue_script('ddpdm-ragnar-blog-ake-js', plugins_url('build/ragnar/js/ragnar-blog-light/ragnarBlogAke.js', __FILE__));
                    }



                    if ($ddpdm_css_ragnar == 'ragnar-blog-albert') {
                        wp_enqueue_script('ddpdm-ragnar-blog-albert-js', plugins_url('build/ragnar/js/ragnar-blog-light/ragnarBlogAlbert.js', __FILE__));
                    }

                    if ($ddpdm_css_ragnar == 'ragnar-blog-albin') {
                        wp_enqueue_script('ddpdm-ragnar-blog-albin-js', plugins_url('build/ragnar/js/ragnar-blog-light/ragnarBlogAlbin.js', __FILE__));
                    }

                    if ($ddpdm_css_ragnar == 'ragnar-blog-alexander') {
                        wp_enqueue_script('ddpdm-ragnar-blog-alexander-js', plugins_url('build/ragnar/js/ragnar-blog-light/ragnarBlogAlexander.js', __FILE__));
                    }

                    if ($ddpdm_css_ragnar == 'ragnar-blog-light-alfred') {
                        wp_enqueue_script('ddpdm-ragnar-blog-light-alfred-js', plugins_url('build/ragnar/js/ragnar-blog-light/ragnarBlogLightAlfred.js', __FILE__));
                        wp_enqueue_script('ddp-pegasus-masonry-js', plugins_url('build/pegasus/js/pegasus-library.js', __FILE__));
                    }

                    if ($ddpdm_css_ragnar == 'ragnar-blog-alma') {
                        wp_enqueue_script('ddpdm-ragnar-blog-alma-js', plugins_url('build/ragnar/js/ragnar-blog-light/ragnarBlogAlma.js', __FILE__));
                    }

                    if ($ddpdm_css_ragnar == 'ragnar-portfolio-noah') {
                        wp_enqueue_script('ddpdm-ragnar-portfolio-noah-js', plugins_url('build/ragnar/js/ragnar-our-work-3/ragnarPortfolioNoah.js', __FILE__));
                    }

                    if ($ddpdm_css_ragnar == 'ragnar-header-alberte') {
                        wp_enqueue_script('ddpdm-ragnar-header-alberte-js', plugins_url('build/ragnar/js/ragnar-shop-landing-v2/ragnarHeaderAlberte.js', __FILE__));
                    }

                    if ($ddpdm_css_ragnar == 'ragnar-products-olivia') {
                        wp_enqueue_script('ddpdm-ragnar-products-olivia-js', plugins_url('build/ragnar/js/ragnar-shop-landing-v2/ragnarProductsOlivia.js', __FILE__));
                    }

                    if ($ddpdm_css_ragnar == 'ragnar-products-nora') {
                        wp_enqueue_script('ddpdm-ragnar-products-nora-js', plugins_url('build/ragnar/js/ragnar-shop-landing-v2/ragnarProductsNora.js', __FILE__));
                    }

                    if ($ddpdm_css_ragnar == 'ragnar-footer-isabella') {
                        wp_enqueue_script('ddpdm-ragnar-footer-isabella-js', plugins_url('build/ragnar/js/ragnar-shop-landing-v2/ragnarFooterIsabella.js', __FILE__));
                    }

                    if ($ddpdm_css_ragnar == 'ragnar-pricing-table-cecilia') {
                        wp_enqueue_script('ddpdm-ragnar-pricing-table-cecilia-js', plugins_url('build/ragnar/js/ragnar-pricing-tables-light/ragnarPricingTableCecilia.js', __FILE__));
                    }

                    if ($ddpdm_css_ragnar == 'ragnar-pricing-table-dagmar') {
                        wp_enqueue_script('ddpdm-ragnar-pricing-table-dagmar-js', plugins_url('build/ragnar/js/ragnar-pricing-tables-light/ragnarPricingTableDagmar.js', __FILE__));
                    }

                    if ($ddpdm_css_ragnar == 'ragnar-pricing-table-ellinor') {
                        wp_enqueue_script('ddpdm-ragnar-pricing-table-ellinor-js', plugins_url('build/ragnar/js/ragnar-pricing-tables-light/ragnarPricingTableEllinor.js', __FILE__));
                    }

                    if ($ddpdm_css_ragnar == 'ragnar-pricing-table-emil') {
                        wp_enqueue_script('ddpdm-ragnar-pricing-table-emil-js', plugins_url('build/ragnar/js/ragnar-pricing-tables-light/ragnarPricingTableEmil.js', __FILE__));
                    }

                    if ($ddpdm_css_ragnar == 'ragnar-pricing-table-emma') {
                        wp_enqueue_script('ddpdm-ragnar-pricing-table-emma-js', plugins_url('build/ragnar/js/ragnar-pricing-tables-light/ragnarPricingTableEmma.js', __FILE__));
                    }

                    if ($ddpdm_css_ragnar == 'ragnar-portfolio-valdemar') {
                        wp_enqueue_script('ddpdm-ragnar-portfolio-valdemar-js', plugins_url('build/ragnar/js/ragnar-our-work-4/ragnarPortfolioValdemar.js', __FILE__));
                    }

                    if ($ddpdm_css_ragnar == 'ragnar-blog-ida') {
                        wp_enqueue_script('ddpdm-ragnar-blog-ida-js', plugins_url('build/ragnar/js/ragnar-blog-1/ragnarBlogIda.js', __FILE__));
                    }

                    if ($ddpdm_css_ragnar == 'ragnar-header-emil') {
                        wp_enqueue_script('ddpdm-ragnar-header-emil-js', plugins_url('build/ragnar/js/ragnar-shop-landing-v3/ragnarHeaderEmil.js', __FILE__));
                    }

                    if ($ddpdm_css_ragnar == 'ragnar-products-elias') {
                        wp_enqueue_script('ddpdm-ragnar-products-elias-js', plugins_url('build/ragnar/js/ragnar-shop-landing-v3/ragnarProductsElias.js', __FILE__));
                    }

                    if ($ddpdm_css_ragnar == 'ragnar-blog-august') {
                        wp_enqueue_script('ddpdm-ragnar-blog-august-js', plugins_url('build/ragnar/js/ragnar-shop-landing-v3/ragnarBlogAugust.js', __FILE__));
                    }

                    if ($ddpdm_css_ragnar == 'ragnar-post-v1') {
                        wp_enqueue_script('ddpdm-ragnar-post-v1-js', plugins_url('build/ragnar/js/ragnar-post-1/ragnarPostV1.js', __FILE__));
                    }

                    if ($ddpdm_css_ragnar == 'ragnar-post-v2') {
                        wp_enqueue_script('ddpdm-ragnar-post-v2-js', plugins_url('build/ragnar/js/ragnar-post-2/ragnarPostV2.js', __FILE__));
                    }

                    if ($ddpdm_css_ragnar == 'ragnar-gallery-erik') {
                        wp_enqueue_script('ddpdm-ragnar-gallery-erik-js', plugins_url('build/ragnar/js/ragnar-gallery-light/ragnarGalleryErik.js', __FILE__));
                    }

                    if ($ddpdm_css_ragnar == 'ragnar-gallery-esbjorn') {
                        wp_enqueue_script('ddpdm-ragnar-gallery-esbjorn-js', plugins_url('build/ragnar/js/ragnar-gallery-light/ragnarGalleryEsbjorn.js', __FILE__));
                    }

                    if ($ddpdm_css_ragnar == 'ragnar-gallery-eskil') {
                        wp_enqueue_script('ddpdm-ragnar-gallery-eskil-js', plugins_url('build/ragnar/js/ragnar-gallery-light/ragnarGalleryEskil.js', __FILE__));
                    }

                    if ($ddpdm_css_ragnar == 'ragnar-gallery-eva') {
                        wp_enqueue_script('ddpdm-ragnar-gallery-eva-js', plugins_url('build/ragnar/js/ragnar-gallery-light/ragnarGalleryEva.js', __FILE__));
                    }

                    if ($ddpdm_css_ragnar == 'ragnar-gallery-evelina') {
                        wp_enqueue_script('ddpdm-ragnar-gallery-evelina-js', plugins_url('build/ragnar/js/ragnar-gallery-light/ragnarGalleryEvelina.js', __FILE__));
                    }

                    if ($ddpdm_css_ragnar == 'ragnar-gallery-evert') {
                        wp_enqueue_script('ddpdm-ragnar-gallery-evert-js', plugins_url('build/ragnar/js/ragnar-gallery-light/ragnarGalleryEvert.js', __FILE__));
                    }

                    if ($ddpdm_css_ragnar == 'ragnar-gallery-fabian') {
                        wp_enqueue_script('ddpdm-ragnar-gallery-fabian-js', plugins_url('build/ragnar/js/ragnar-gallery-light/ragnarGalleryFabian.js', __FILE__));
                    }

                    if ($ddpdm_css_ragnar == 'ragnar-blog-olympus') {
                        wp_enqueue_script('ddpdm-ragnar-blog-olympus-js', plugins_url('build/ragnar/js/ragnar-blog-2/ragnarBlogOlympus.js', __FILE__));
                    }

                    if ($ddpdm_css_ragnar == 'ragnar-header-gorm') {
                        wp_enqueue_script('ddpdm-ragnar-header-gorm-js', plugins_url('build/ragnar/js/ragnar-shop-landing-v4/ragnarHeaderGorm.js', __FILE__));
                    }

                    if ($ddpdm_css_ragnar == 'ragnar-products-benta') {
                        wp_enqueue_script('ddpdm-ragnar-products-benta-js', plugins_url('build/ragnar/js/ragnar-shop-landing-v4/ragnarProductsBenta.js', __FILE__));
                    }

                    if ($ddpdm_css_ragnar == 'ragnar-products-benta') {
                        wp_enqueue_script('ddpdm-ragnar-products-benta-js', plugins_url('build/ragnar/js/ragnar-shop-landing-v4/ragnarProductsBenta.js', __FILE__));
                    }

                    if ($ddpdm_css_ragnar == 'ragnar-content-malthe') {
                        wp_enqueue_script('ddpdm-ragnar-content-malthe-js', plugins_url('build/ragnar/js/ragnar-case-study-3/ragnarContentMalthe.js', __FILE__));
                    }

                    if ($ddpdm_css_ragnar == 'ragnar-content-victor') {
                        wp_enqueue_script('ddpdm-ragnar-content-victor-js', plugins_url('build/ragnar/js/ragnar-case-study-3/ragnarContentVictor.js', __FILE__));
                    }
                
                    if ($ddpdm_css_ragnar == 'ragnar-blurbs-jenny') {
                        wp_enqueue_script('ddpdm-ragnar-blurbs-jenny-js', plugins_url('build/ragnar/js/ragnar-service-1/ragnarBlurbsJenny.js', __FILE__));
                    }
                
                    if ($ddpdm_css_ragnar == 'ragnar-tabs-gun') {
                        wp_enqueue_script('ddpdm-ragnar-tabs-gun-js', plugins_url('build/ragnar/js/ragnar-service-1/ragnarTabsGun.js', __FILE__));
                    }
                    if ($ddpdm_css_ragnar == 'ragnar-content-jean') {
                        wp_enqueue_script('ddpdm-ragnar-content-jean-js', plugins_url('build/ragnar/js/ragnar-service-4/ragnar-content-jean.js', __FILE__));
                    }
                
                    //October
                    if ($ddpdm_css_ragnar == 'ragnar-tabs-berit') {
                        wp_enqueue_script('ddpdm-ragnar-tabs-berit-js', plugins_url('build/ragnar/js/ragnar-faq-3/ragnarTabsBerit.js', __FILE__));
                    }
                    if ($ddpdm_css_ragnar == 'ragnar-tabs-carine') {
                        wp_enqueue_script('ddpdm-ragnar-tabs-carine-js', plugins_url('build/ragnar/js/ragnar-faq-4/ragnarTabsCarine.js', __FILE__));
                    }
                    if ($ddpdm_css_ragnar == 'ragnar-header-kurt') {
                        wp_enqueue_script('ddpdm-ragnar-header-kurt-js', plugins_url('build/ragnar/js/ragnar-architecture/ragnarHeaderKurt.js', __FILE__));
                    }
                }
            }



            // Ragnar ends

                        //Grace starts
                        if (!empty(get_post_meta($post->ID, 'ddp-css-grace'))) {
                            foreach ((array) get_post_meta($post->ID, 'ddp-css-grace') as $ddp_css_grace) {
            
                                if ($ddp_css_grace == 'grace-timeline-alpha') {
                                    wp_enqueue_script('ddp-grace-timeline-alpha-js', plugins_url('build/grace/js/timeline/grace-timeline-alpha.js', __FILE__));
                                }
                                if ($ddp_css_grace == 'grace-timeline-amalthea') {
                                    wp_enqueue_script('ddp-grace-timeline-amalthea-js', plugins_url('build/grace/js/timeline/grace-timeline-amalthea.js', __FILE__));
                                }
            
                                if ($ddp_css_grace == 'grace-gallery-ascella') {
                                    wp_enqueue_script('ddp-grace-gallery-ascella-js', plugins_url('build/grace/js/gallery/grace-gallery-ascella.js', __FILE__));
                                }
                                if ($ddp_css_grace == 'grace-gallery-asterope') {
                                    wp_enqueue_script('ddp-grace-gallery-asterope-js', plugins_url('build/grace/js/gallery/grace-gallery-asterope.js', __FILE__));
                                }
                                if ($ddp_css_grace == 'grace-gallery-astra') {
                                    wp_enqueue_script('ddp-grace-gallery-astra-js', plugins_url('build/grace/js/gallery/grace-gallery-astra.js', __FILE__));
                                }
                                if ($ddp_css_grace == 'grace-gallery-aurora') {
                                    wp_enqueue_script('ddp-grace-gallery-aurora-js', plugins_url('build/grace/js/gallery/grace-gallery-aurora.js', __FILE__));
                                }
                                if ($ddp_css_grace == 'grace-gallery-capella') {
                                    wp_enqueue_script('ddp-grace-gallery-capella-js', plugins_url('build/grace/js/gallery/grace-gallery-capella.js', __FILE__));
                                }
                                if ($ddp_css_grace == 'grace-gallery-cassiopea') {
                                    wp_enqueue_script('ddp-grace-gallery-cassiopea-js', plugins_url('build/grace/js/gallery/grace-gallery-cassiopea.js', __FILE__));
                                }
                                if ($ddp_css_grace == 'grace-gallery-celestial') {
                                    wp_enqueue_script('ddp-grace-gallery-celestial-js', plugins_url('build/grace/js/gallery/grace-gallery-celestial.js', __FILE__));
                                }
                                if ($ddp_css_grace == 'grace-gallery-halley') {
                                    wp_enqueue_script('ddp-grace-gallery-halley-js', plugins_url('build/grace/js/gallery/grace-gallery-halley.js', __FILE__));
                                }
                                if ($ddp_css_grace == 'grace-gallery-nashira') {
                                    wp_enqueue_script('ddp-grace-gallery-nashira-js', plugins_url('build/grace/js/gallery/grace-gallery-nashira.js', __FILE__));
                                }
                                if ($ddp_css_grace == 'grace-gallery-norma') {
                                    wp_enqueue_script('ddp-grace-gallery-norma-js', plugins_url('build/grace/js/gallery/grace-gallery-norma.js', __FILE__));
                                }
                                if ($ddp_css_grace == 'grace-gallery-polaris') {
                                    wp_enqueue_script('ddp-grace-gallery-polaris-js', plugins_url('build/grace/js/gallery/grace-gallery-polaris.js', __FILE__));
                                }
            
                                if ($ddp_css_grace == 'grace-person-carina') {
                                    wp_enqueue_script('ddp-grace-person-carina-js', plugins_url('build/grace/js/persons/gracePersonCarina.js', __FILE__));
                                }
                                if ($ddp_css_grace == 'grace-person-phoenix') {
                                    wp_enqueue_script('ddp-grace-person-phoenix-js', plugins_url('build/grace/js/persons/gracePersonPhoenix.js', __FILE__));
                                }
                                if ($ddp_css_grace == 'grace-person-sirius') {
                                    wp_enqueue_script('ddp-grace-person-sirius-js', plugins_url('build/grace/js/persons/gracePersonSirius.js', __FILE__));
                                }
            
                                if ($ddp_css_grace == 'grace-blurbs-albaldah') {
                                    wp_enqueue_script('ddp-grace-blurbs-albaldah-js', plugins_url('build/grace/js/blurbs/graceBlurbsAlbaldah.js', __FILE__));
                                }
                                if ($ddp_css_grace == 'grace-blurbs-archer') {
                                    wp_enqueue_script('ddp-grace-blurbs-archer-js', plugins_url('build/grace/js/blurbs/graceBlurbsArcher.js', __FILE__));
                                }
                                if ($ddp_css_grace == 'grace-blurbs-aries') {
                                    wp_enqueue_script('ddp-grace-blurbs-aries-js', plugins_url('build/grace/js/blurbs/graceBlurbsAries.js', __FILE__));
                                }
                                if ($ddp_css_grace == 'grace-blurbs-diadem') {
                                    wp_enqueue_script('ddp-grace-blurbs-diadem-js', plugins_url('build/grace/js/blurbs/graceBlurbsDiadem.js', __FILE__));
                                }
                                if ($ddp_css_grace == 'grace-blurbs-furud') {
                                    wp_enqueue_script('ddp-grace-blurbs-furud-js', plugins_url('build/grace/js/blurbs/graceBlurbsFurud.js', __FILE__));
                                }
                                if ($ddp_css_grace == 'grace-blurbs-pherkad') {
                                    wp_enqueue_script('ddp-grace-blurbs-hoverdir-js', plugins_url('build/grace/js/jquery.hoverdir.js', __FILE__));
                                    wp_enqueue_script('ddp-grace-blurbs-pherkad-js', plugins_url('build/grace/js/blurbs/graceBlurbsPherkad.js', __FILE__));
                                }
                                if ($ddp_css_grace == 'grace-blurbs-prends') {
                                    wp_enqueue_script('ddp-grace-blurbs-prends-js', plugins_url('build/grace/js/blurbs/graceBlurbsPrends.js', __FILE__));
                                }
            
                                if ($ddp_css_grace == 'grace-blog-between') {
                                    wp_enqueue_script('ddp-grace-blog-between-js', plugins_url('build/grace/js/blogs/graceBlogBetween.js', __FILE__));
                                }
                                if ($ddp_css_grace == 'grace-blog-comet') {
                                    wp_enqueue_script('ddp-grace-blog-comet-js', plugins_url('build/grace/js/blogs/graceBlogComet.js', __FILE__));
                                }
                                if ($ddp_css_grace == 'grace-blog-cupid') {
                                    wp_enqueue_script('ddp-grace-blog-cupid-js', plugins_url('build/grace/js/blogs/graceBlogCupid.js', __FILE__));
                                }
                                if ($ddp_css_grace == 'grace-blog-donati') {
                                    wp_enqueue_script('ddp-grace-blog-donati-js', plugins_url('build/grace/js/blogs/graceBlogDonati.js', __FILE__));
                                }
                                if ($ddp_css_grace == 'grace-blog-draco') {
                                    wp_enqueue_script('ddp-grace-blog-draco-js', plugins_url('build/grace/js/blogs/graceBlogDraco.js', __FILE__));
                                }
                                if ($ddp_css_grace == 'grace-blog-elio') {
                                    wp_enqueue_script('ddp-grace-blog-elio-js', plugins_url('build/grace/js/blogs/graceBlogElio.js', __FILE__));
                                }
                                if ($ddp_css_grace == 'grace-blog-finaly') {
                                    wp_enqueue_script('ddp-grace-blog-finaly-js', plugins_url('build/grace/js/blogs/graceBlogFinaly.js', __FILE__));
                                }
                                if ($ddp_css_grace == 'grace-blog-hassaleh') {
                                    wp_enqueue_script('ddp-grace-blog-hassaleh-js', plugins_url('build/grace/js/blogs/graceBlogHassaleh.js', __FILE__));
                                }
                                if ($ddp_css_grace == 'grace-blog-limousine') {
                                    wp_enqueue_script('ddp-grace-blog-limousine-js', plugins_url('build/grace/js/blogs/graceBlogLimousine.js', __FILE__));
                                }
                                if ($ddp_css_grace == 'grace-blog-mon') {
                                    wp_enqueue_script('ddp-grace-blog-mon-js', plugins_url('build/grace/js/blogs/graceBlogMon.js', __FILE__));
                                }
            
                                if ($ddp_css_grace == 'grace-slider-aladfar') {
                                    wp_enqueue_script('ddp-grace-slider-aladfar-js', plugins_url('build/grace/js/sliders/graceSliderAladfar.js', __FILE__));
                                }
                                if ($ddp_css_grace == 'grace-slider-beid') {
                                    wp_enqueue_script('ddp-grace-slider-beid-js', plugins_url('build/grace/js/sliders/graceSliderBeid.js', __FILE__));
                                }
                                if ($ddp_css_grace == 'grace-slider-kraz') {
                                    wp_enqueue_script('ddp-grace-slider-kraz-js', plugins_url('build/grace/js/sliders/graceSliderKraz.js', __FILE__));
                                    wp_enqueue_script('ddp-grace-tilt-jquery-js', plugins_url('build/grace/js/tilt.jquery.js', __FILE__));
                                    wp_enqueue_script('ddp-grace-sly-jquery-js', plugins_url('build/grace/js/sly.min.js', __FILE__));
                                }
                                if ($ddp_css_grace == 'grace-slider-merga') {
                                    wp_enqueue_script('ddp-grace-slider-merga-js', plugins_url('build/grace/js/sliders/graceSliderMerga.js', __FILE__));
                                }
                                if ($ddp_css_grace == 'grace-slider-merope') {
                                    wp_enqueue_script('ddp-grace-slider-merope-js', plugins_url('build/grace/js/sliders/graceSliderMerope.js', __FILE__));
                                }
            
                                if ($ddp_css_grace == 'grace-header-alterf') {
                                    wp_enqueue_script('ddp-grace-header-alterf-js', plugins_url('build/grace/js/headers/graceHeaderAlterf.js', __FILE__));
                                }
                                if ($ddp_css_grace == 'grace-header-quand') {
                                    wp_enqueue_script('ddp-grace-header-quand-js', plugins_url('build/grace/js/headers/graceHeaderQuand.js', __FILE__));
                                }
                                if ($ddp_css_grace == 'grace-header-helena') {
                                    wp_enqueue_script('ddp-grace-header-helena-js', plugins_url('build/grace/js/headers/graceHeaderHelena.js', __FILE__));
                                }
                                if ($ddp_css_grace == 'grace-header-kuma') {
                                    wp_enqueue_script('ddp-grace-header-kuma-js', plugins_url('build/grace/js/headers/graceHeaderKuma.js', __FILE__));
                                }
                                if ($ddp_css_grace == 'grace-header-maia') {
                                    wp_enqueue_script('ddp-grace-header-maia-js', plugins_url('build/grace/js/headers/graceHeaderMaia.js', __FILE__));
                                }
                                if ($ddp_css_grace == 'grace-header-yildun') {
                                    wp_enqueue_script('ddp-grace-header-yildun-js', plugins_url('build/grace/js/headers/graceHeaderYildun.js', __FILE__));
                                }
                                if ($ddp_css_grace == 'grace-header-zosma') {
                                    wp_enqueue_script('ddp-grace-header-zosma-js', plugins_url('build/grace/js/headers/graceHeaderZosma.js', __FILE__));
                                }
            
                                if ($ddp_css_grace == 'grace-pricelist-ain') {
                                    wp_enqueue_script('ddp-grace-pricelist-ain-js', plugins_url('build/grace/js/price-lists/gracePriceListsAin.js', __FILE__));
                                }
                                if ($ddp_css_grace == 'grace-pricelist-becrux') {
                                    wp_enqueue_script('ddp-grace-pricelist-becrux-js', plugins_url('build/grace/js/price-lists/gracePriceListsBecrux.js', __FILE__));
                                }
                                if ($ddp_css_grace == 'grace-pricelist-botein') {
                                    wp_enqueue_script('ddp-grace-pricelist-botein-js', plugins_url('build/grace/js/price-lists/gracePriceListsBotein.js', __FILE__));
                                }
                                if ($ddp_css_grace == 'grace-pricelist-electra') {
                                    wp_enqueue_script('ddp-grace-pricelist-electra-js', plugins_url('build/grace/js/price-lists/gracePriceListsElectra.js', __FILE__));
                                }
                                if ($ddp_css_grace == 'grace-pricelist-furud') {
                                    wp_enqueue_script('ddp-grace-pricelist-furud-js', plugins_url('build/grace/js/price-lists/gracePriceListsFurud.js', __FILE__));
                                }
            
                                if ($ddp_css_grace == 'grace-testimonial-between') {
                                    wp_enqueue_script('ddp-grace-testimonial-between-js', plugins_url('build/grace/js/testimonials/graceTestimonialsBetween.js', __FILE__));
                                }
                                if ($ddp_css_grace == 'grace-testimonial-dabih') {
                                    wp_enqueue_script('ddp-grace-testimonial-dabih-js', plugins_url('build/grace/js/testimonials/graceTestimonialsDabih.js', __FILE__));
                                }
                                if ($ddp_css_grace == 'grace-testimonial-regulus') {
                                    wp_enqueue_script('ddp-grace-testimonial-regulus-js', plugins_url('build/grace/js/testimonials/graceTestimonialsRegulus.js', __FILE__));
                                }
            
                                if ($ddp_css_grace == 'grace-footers-alrai') {
                                    wp_enqueue_script('ddp-grace-footers-alrai-js', plugins_url('build/grace/js/footers/graceFootersAlrai.js', __FILE__));
                                }
                                if ($ddp_css_grace == 'grace-footers-naos') {
                                    wp_enqueue_script('ddp-grace-footers-naos-js', plugins_url('build/grace/js/footers/graceFootersNaos.js', __FILE__));
                                }

                                if ($ddp_css_grace == 'grace-content-somewhere') {
                                    wp_enqueue_script('ddp-grace-content-somewhere-js', plugins_url('build/grace/js/content/graceContentSomewhere.js', __FILE__));
                                }
            
            
                                if ($ddp_css_grace == 'grace-footers-drive') {
                                    wp_enqueue_script('ddp-grace-footers-drive-js', plugins_url('build/grace/js/footers/graceFootersDrive.js', __FILE__));
                                }
            
                                if ($ddp_css_grace == 'grace-optin-space') {
                                    wp_enqueue_script('ddp-grace-optins-space-js', plugins_url('build/grace/js/optin/graceOptinSpace.js', __FILE__));
                                }

                                if ($ddp_css_grace == 'grace-price-flipit') {
                                    wp_enqueue_script('ddp-grace-price-flipit-js', plugins_url('build/grace/js/price-lists/gracePriceListsFlipIt.js', __FILE__));
                                }
                                if ($ddp_css_grace == 'grace-pricing-table-emma') {
                                    wp_enqueue_script('ddp-grace-pricing-table-emma-js', plugins_url('build/grace/js/price-lists/gracePricingTableEmma.js', __FILE__));
                                }
                                if ($ddp_css_grace == 'grace-portfolio-gomeisa') {
                                    wp_enqueue_script('ddp-grace-portfolio-gomeisa-js', plugins_url('build/grace/js/portfolio/gracePortfolioGomeisa.js', __FILE__));
                                }
                                if ($ddp_css_grace == 'grace-content-wasat') {
                                    wp_enqueue_script('ddp-grace-content-wasat-js', plugins_url('build/grace/js/content/graceContentWasat.js', __FILE__));
                                }
                                if ($ddp_css_grace == 'grace-optin-your-kiss') {
                                    wp_enqueue_script('ddp-grace-optin-your-kiss-js', plugins_url('build/grace/js/optin/graceOptinYourKiss.js', __FILE__));
                                }
                                if ($ddp_css_grace == 'grace-footers-store') {
                                    wp_enqueue_script('ddp-grace-footers-store-js', plugins_url('build/grace/js/footers/graceFootersStore.js', __FILE__));
                                }
                                if ($ddp_css_grace == 'grace-gallery-polaris-v2') {
                                    wp_enqueue_script('ddp-grace-gallery-polaris-v2-js', plugins_url('build/grace/js/gallery/grace-gallery-polaris-v2.js', __FILE__));
                                }
                                if ($ddp_css_grace == 'grace-blog-beauty') {
                                    wp_enqueue_script('ddp-grace-blog-beauty-js', plugins_url('build/grace/js/blogs/graceBlogBeauty.js', __FILE__));
                                }
                                if ($ddp_css_grace == 'grace-blog-sten') {
                                    wp_enqueue_script('ddp-grace-blog-sten-js', plugins_url('build/grace/js/blogs/graceBlogSten.js', __FILE__));
                                }
                                if ($ddp_css_grace == 'grace-testimonial-that-face') {
                                    wp_enqueue_script('ddp-testimonial-that-face-js', plugins_url('build/grace/js/testimonials/graceTestimonialThatFace.js', __FILE__));
                                }
                                if ($ddp_css_grace == 'grace-person-founding') {
                                    wp_enqueue_script('ddp-person-founding-js', plugins_url('build/grace/js/persons/gracePersonFounding.js', __FILE__));
                                }
                                if ($ddp_css_grace == 'grace-accordion-iconic') {
                                    wp_enqueue_script('ddp-accordion-iconic-js', plugins_url('build/grace/js/accordions/graceAccordionIconic.js', __FILE__));
                                }
                                if ($ddp_css_grace == 'grace-optin-gonna-be') {
                                    wp_enqueue_script('ddp-grace-optin-gonna-be-js', plugins_url('build/grace/js/optin/graceOptinGonnaBe.js', __FILE__));
                                }
                                if ($ddp_css_grace == 'grace-blurbs-albaldah-v2') {
                                    wp_enqueue_script('ddp-grace-blurbs-albaldah-v2-js', plugins_url('build/grace/js/blurbs/graceBlurbsAlbaldahV2.js', __FILE__));
                                }
                                if ($ddp_css_grace == 'grace-content-jabbah') {
                                    wp_enqueue_script('ddp-grace-content-jabbah-js', plugins_url('build/grace/js/content/graceContentJabbah.js', __FILE__));
                                }
                                if ($ddp_css_grace == 'grace-content-drive') {
                                    wp_enqueue_script('ddp-grace-content-drive-js', plugins_url('build/grace/js/content/graceContentDrive.js', __FILE__));
                                }

                                if ($ddp_css_grace == 'grace-about11-counter') {
                                    wp_enqueue_script('ddp-grace-about11-counter-js', plugins_url('build/grace/js/number-counter/graceAbout11counter.js', __FILE__));
                                }
                                if ($ddp_css_grace == 'grace-about11-gallery') {
                                    wp_enqueue_script('ddp-grace-about11-gallery-js', plugins_url('build/grace/js/gallery/graceAbout11Gallery.js', __FILE__));
                                }
                                if ($ddp_css_grace == 'grace-content-filmmaker') {
                                    wp_enqueue_script('ddp-grace-content-filmmaker-js', plugins_url('build/grace/js/video/graceFilmmaker.js', __FILE__));
                                }
                                if ($ddp_css_grace == 'grace-person-artist') {
                                    wp_enqueue_script('ddp-grace-person-artist-js', plugins_url('build/grace/js/persons/gracePersonArtist.js', __FILE__));
                                }
                                if ($ddp_css_grace == 'grace-person-california') {
                                    wp_enqueue_script('ddp-grace-person-california-js', plugins_url('build/grace/js/persons/gracePersonCalifornia.js', __FILE__));
                                }

                            }
                        }
                        //Grace ends
                         //Olena starts
            if (!empty(get_post_meta($post->ID, 'ddp-css-olena'))) {
                foreach ((array) get_post_meta($post->ID, 'ddp-css-olena') as $ddp_css_olena) {
                    if ($ddp_css_olena == 'olena-header-v8') {
                        wp_enqueue_script('ddp-olena-header-v8-js', plugins_url('build/olena/js/headers/olenaHeaderV8.js', __FILE__));
                    }
                    if ($ddp_css_olena == 'olena-header-v11') {
                        wp_enqueue_script('ddp-olena-header-v11-js', plugins_url('build/olena/js/headers/olenaHeaderV11.js', __FILE__));
                    }  
                    if ($ddp_css_olena == 'olena-content-5') {
                        wp_enqueue_script('ddp-olena-content-5-js', plugins_url('build/olena/js/content/olenaContent5.js', __FILE__));
                    }  
                    if ($ddp_css_olena == 'olena-blog-v1') {
                        wp_enqueue_script('ddp-olena-blog-v1-js', plugins_url('build/olena/js/blog/olenaBlogV1.js', __FILE__));
                    }  
                    if ($ddp_css_olena == 'olena-blog-v2') {
                        wp_enqueue_script('ddp-olena-blog-v2-js', plugins_url('build/olena/js/blog/olenaBlogV2.js', __FILE__));
                    }  
                    if ($ddp_css_olena == 'olena-blog-v3') {
                        wp_enqueue_script('ddp-olena-blog-v3-js', plugins_url('build/olena/js/blog/olenaBlogV3.js', __FILE__));
                    }  
                    if ($ddp_css_olena == 'olena-blog-v4') {
                        wp_enqueue_script('ddp-olena-blog-v4-js', plugins_url('build/olena/js/blog/olenaBlogV4.js', __FILE__));
                    }  
                    if ($ddp_css_olena == 'olena-blog-v5') {
                        wp_enqueue_script('ddp-olena-blog-v5-js', plugins_url('build/olena/js/blog/olenaBlogV5.js', __FILE__));
                    }  
                    if ($ddp_css_olena == 'olena-blog-v6') {
                        wp_enqueue_script('ddp-olena-blog-v6-js', plugins_url('build/olena/js/blog/olenaBlogV6.js', __FILE__));
                    }  
                    if ($ddp_css_olena == 'olena-blog-v7') {
                        wp_enqueue_script('ddp-olena-blog-v7-js', plugins_url('build/olena/js/blog/olenaBlogV7.js', __FILE__));
                    }  
                    if ($ddp_css_olena == 'olena-blog-v8') {
                        wp_enqueue_script('ddp-olena-blog-v8-js', plugins_url('build/olena/js/blog/olenaBlogV8.js', __FILE__));
                    }  
                    if ($ddp_css_olena == 'olena-blog-v9') {
                        wp_enqueue_script('ddp-olena-blog-v9-js', plugins_url('build/olena/js/blog/olenaBlogV9.js', __FILE__));
                    }  
                    if ($ddp_css_olena == 'olena-blog-v10') {
                        wp_enqueue_script('ddp-olena-blog-v10-js', plugins_url('build/olena/js/blog/olenaBlogV10.js', __FILE__));
                    }  
                    if ($ddp_css_olena == 'olena-blog-v11') {
                        wp_enqueue_script('ddp-olena-blog-v11-js', plugins_url('build/olena/js/blog/olenaBlogV11.js', __FILE__));
                    }  
                    if ($ddp_css_olena == 'olena-blog-v12') {
                        wp_enqueue_script('ddp-olena-blog-v12-js', plugins_url('build/olena/js/blog/olenaBlogV11.js', __FILE__));
                    }  
                    if ($ddp_css_olena == 'olena-blurb-v1') {
                        wp_enqueue_script('ddp-olena-blurb-v1-js', plugins_url('build/olena/js/blurbs/olenaBlurbV1.js', __FILE__));
                    }  
                    if ($ddp_css_olena == 'olena-blurb-v5') {
                        wp_enqueue_script('ddp-olena-blurb-v5-js', plugins_url('build/olena/js/blurbs/olenaBlurbV5.js', __FILE__));
                    }  

                    if ($ddp_css_olena == 'olena-woo-v1') {
                        wp_enqueue_script('ddp-olena-woo-v1-js', plugins_url('build/olena/js/shop/olenaWooV1.js', __FILE__));
                    }
                    if ($ddp_css_olena == 'olena-woo-v2') {
                        wp_enqueue_script('ddp-olena-woo-v2-js', plugins_url('build/olena/js/shop/olenaWooV2.js', __FILE__));
                    }
                    if ($ddp_css_olena == 'olena-woo-v4') {
                        wp_enqueue_script('ddp-olena-woo-v4-js', plugins_url('build/olena/js/shop/olenaWooV4.js', __FILE__));
                    }
                    if ($ddp_css_olena == 'olena-woo-v5') {
                        wp_enqueue_script('ddp-olena-woo-v5-js', plugins_url('build/olena/js/shop/olenaWooV5.js', __FILE__));
                    }
                    if ($ddp_css_olena == 'olena-woo-v6') {
                        wp_enqueue_script('ddp-olena-woo-v6-js', plugins_url('build/olena/js/shop/olenaWooV6.js', __FILE__));
                    }
                    if ($ddp_css_olena == 'olena-woo-v7') {
                        wp_enqueue_script('ddp-olena-woo-v7-js', plugins_url('build/olena/js/shop/olenaWooV7.js', __FILE__));
                    }
                    if ($ddp_css_olena == 'olena-woo-v8') {
                        wp_enqueue_script('ddp-olena-woo-v8-js', plugins_url('build/olena/js/shop/olenaWooV8.js', __FILE__));
                    }
                    if ($ddp_css_olena == 'olena-woo-v9') {
                        wp_enqueue_script('ddp-olena-woo-v9-js', plugins_url('build/olena/js/shop/olenaWooV9.js', __FILE__));
                    }
                    if ($ddp_css_olena == 'olena-woo-v10') {
                        wp_enqueue_script('ddp-olena-woo-v10-js', plugins_url('build/olena/js/shop/olenaWooV10.js', __FILE__));
                    }
                    if ($ddp_css_olena == 'olena-woo-v11') {
                        wp_enqueue_script('ddp-olena-woo-v11-js', plugins_url('build/olena/js/shop/olenaWooV11.js', __FILE__));
                    }
                    if ($ddp_css_olena == 'olena-woo-v12') {
                        wp_enqueue_script('ddp-olena-woo-v12-js', plugins_url('build/olena/js/shop/olenaWooV12.js', __FILE__));
                    }
                    if ($ddp_css_olena == 'olena-woo-v13') {
                        wp_enqueue_script('ddp-olena-woo-v13-js', plugins_url('build/olena/js/shop/olenaWooV13.js', __FILE__));
                    }
                    if ($ddp_css_olena == 'olena-woo-v14') {
                        wp_enqueue_script('ddp-olena-woo-v14-js', plugins_url('build/olena/js/shop/olenaWooV14.js', __FILE__));
                    }
                    if ($ddp_css_olena == 'olena-testimonial-v1') {
                        wp_enqueue_script('ddp-olena-testimonial-v1-js', plugins_url('build/olena/js/testimonials/olenaTestimonialV1.js', __FILE__));
                    }
                    if ($ddp_css_olena == 'olena-content-2' || $ddp_css_olena == 'olena-content-6') {
                        wp_enqueue_script('ddp-olena-fancybox-js', plugins_url('build/olena/js/fancybox/olenaFancybox.js', __FILE__));
                    }
                }
            }
            //Olena ends

        } //end if($post)
    }

    add_action('wp_footer', 'ddpdm_register_js');
    add_action('et_fb_enqueue_assets', 'ddpdm_register_js');

    //======================================================================
    // LOAD AVATART FOR BLOG MODULES
    //======================================================================

    function load_ddpdm_avatars($title)
    {
        global $post;
        if (is_object($post) && $post->post_type == 'post') {
            if ($post->post_author) {
                $authorId = $post->post_author;

                $dataAvatar = '<dataavatar hidden data-avatar-url=';

                if (function_exists('get_wp_user_avatar_src')) {
                    $dataAvatarUrl = get_wp_user_avatar_src($authorId, 'original');
                } else {
                    $dataAvatarUrl = get_avatar_url($authorId);
                }

                $dataAvatar = $dataAvatar . $dataAvatarUrl;
                $dataAvatar = $dataAvatar . '></dataavatar>';
                return $title . $dataAvatar;
            } else {
                return $title;
            }
        } else {
            return $title;
        }
    }

    if (!is_admin()) {
        add_action('wp', 'for_ddpdm_avatars');
    }

    function for_ddpdm_avatars()
    {
        global $post;
        if (!is_object($post)) {
            return;
        }
        if ((is_array( get_post_meta($post->ID, 'ddp-css-olena') ) && in_array("olena-blog-v10", get_post_meta($post->ID, 'ddp-css-olena'))) ||(is_array( get_post_meta($post->ID, 'ddp-css-olena') ) && in_array("olena-blog-v4", get_post_meta($post->ID, 'ddp-css-olena'))) || get_post_meta($post->ID, 'ddp-css-tina') === 'tina-blog-all-day' || (is_array(get_post_meta($post->ID, 'ddp-css-tina')) && in_array("tina-blog-all-day", get_post_meta($post->ID, 'ddp-css-tina'))) ||
        get_post_meta($post->ID, 'ddp-css-tina') === 'tina-blog-the-flame' || (is_array(get_post_meta($post->ID, 'ddp-css-tina')) && in_array("tina-blog-the-flame", get_post_meta($post->ID, 'ddp-css-tina'))) ||
        get_post_meta($post->ID, 'ddp-css-tina') === 'tina-my-lover-blog' || (is_array(get_post_meta($post->ID, 'ddp-css-tina')) && in_array("tina-my-lover-blog", get_post_meta($post->ID, 'ddp-css-tina')))) {
            add_filter('the_title', 'load_ddpdm_avatars', 10, 2);
        }
    }


    function ddprodm_alpha_customize_register($wp_customize)
    {

    // Inlcude the Alpha Color Picker control file.
        require_once plugin_dir_path(__FILE__).'/include/alpha-color-picker.php';
    }

    //======================================================================
    // CUSTOM ICONS FRONTEND
    //======================================================================
    function ddpdm_custom_icons_js()
    {
        if (get_theme_mod('ddpdm_icons_fa', false) == 1 || get_theme_mod('ddpdm_icons_md', false) == 1) {
            wp_enqueue_script('ddpdm-custom-icons-js', plugins_url('js/ddpdm-frontend-custom-icons.js', __FILE__));
        }
    }
    add_action('wp_footer', 'ddpdm_custom_icons_js');

    function ddpdm_custom_icons_css()
    {
        if (get_theme_mod('ddpdm_icons_fa', false) == 1) {
            wp_register_style('ddpdm-icons-font-awesome', plugins_url('fonts/font-awesome/all.min.css', __FILE__));
            wp_enqueue_style('ddpdm-icons-font-awesome');
        }

        if (get_theme_mod('ddpdm_icons_md', false) == 1) {
            wp_register_style('ddpdm-icons-material-design', plugins_url('fonts/material-design/iconfont/material-icons.css', __FILE__));
            wp_enqueue_style('ddpdm-icons-material-design');
        }

        if (get_theme_mod('ddpdm_icons_fa', false) == 1 || get_theme_mod('ddpdm_icons_md', false) == 1) {
            wp_register_style('ddpdm-icons-frontend', plugins_url('fonts/ddpdm-icons-frontend.css', __FILE__));
            wp_enqueue_style('ddpdm-icons-frontend');
        }
    }
    add_action('wp_head', 'ddpdm_custom_icons_css');

    //======================================================================
    // CUSTOM ICONS FRONTEND BUILDER
    //======================================================================

    function ddpdm_vb_custom_icons_js()
    {
        if (get_theme_mod('ddpdm_icons_fa', false) == 1 || get_theme_mod('ddpdm_icons_md', false) == 1) {
            wp_enqueue_script('ddpdm-vb-custom-icons-js', plugins_url('js/ddpdm-vb-admin-custom-icons.js', __FILE__), array( 'wp-i18n' ));
        }
    }

    add_action('et_fb_enqueue_assets', 'ddpdm_vb_custom_icons_js');
    add_action('admin_footer', 'ddpdm_vb_custom_icons_js');


    //======================================================================
    // CALL UP THE CUSTOM FILTERABLE PORTFOLIO WITH EXCERPT FILE
    //======================================================================


    // remove style-cpt.dev.css

    function ddpdm_disable_cptdivi()
    {
        remove_action('wp_enqueue_scripts', 'et_divi_replace_stylesheet', 99999998);
    }
    add_action('init', 'ddpdm_disable_cptdivi');

    function ddpdm_create_nonce()
    {
        wp_create_nonce('ddpdm-backend-nonce');
    }

    add_action('init', 'ddpdm_create_nonce');


    //======================================================================
    // Antispam email shortcode [email]name@website.com[/email]- https://codex.wordpress.org/Function_Reference/antispambot
    //======================================================================

    if (!shortcode_exists('email')) {
        function wpcodex_hide_email_pegasus_shortcode($atts, $content = null)
        {
            if (!is_email($content)) {
                return;
            }

            return '<a href="mailto:' . antispambot($content) . '">' . antispambot($content) . '</a>';
        }

        add_shortcode('email', 'wpcodex_hide_email_pegasus_shortcode');
    }

    //======================================================================
    // Antispam email shortcode [email]name@website.com[/email]- https://codex.wordpress.org/Function_Reference/antispambot
    //======================================================================

    if (!shortcode_exists('phone')) {
        function ddpdm_phone_shortcode($atts, $content = null)
        {
            return '<a href="tel:' . $content . '">' . $content . '</a>';
        }

        add_shortcode('phone', 'ddpdm_phone_shortcode');
    }


    //======================================================================
    // ADD FOOTER DATE SHORTCODE
    //======================================================================
    function ddprodm_footer_date($atts)
    {
        return gmdate('Y');
    }
    if (!shortcode_exists('footer_date_')) {
        add_shortcode('footer_date_', 'ddprodm_footer_date');
    }



    //======================================================================
    // Create an option with ids and original titles for renaming
    //======================================================================

    function ddpdm_original_layouts_names()
    {
        $ddpdm_original_layouts_names = array();
        // works one time after update / installing the plugin
        if (!get_option('ddpdm_original_layouts_names')) {
            $divi_layouts = get_posts(
                array(
        'post_type'   => 'et_pb_layout',
        'post_status' => 'publish',
        'posts_per_page' => -1,
    //    'category' => 'PHP Template',
       // 'fields' => 'ids'
        )
            );

            foreach ($divi_layouts as $divi_layout) {
                $divi_id = $divi_layout -> ID;
                $divi_title = $divi_layout -> post_title;
                // print_r($divi_layout);
                if (has_term("php-template", 'layout_category', $divi_id) && has_term("divi-den", 'layout_category', $divi_id)) {
                    $ddpdm_original_layouts_names[$divi_id] = $divi_title;
                }


                if (strpos(get_the_title($divi_id), 'Footer') !== false && has_term("divi-den", 'layout_category', $divi_id)) {
                    $ddpdm_original_layouts_names[$divi_id] = $divi_title;
                }

                if (strpos(get_the_title($divi_id), 'footer') !== false && has_term("divi-den", 'layout_category', $divi_id)) {
                    $ddpdm_original_layouts_names[$divi_id] = $divi_title;
                }
            }

            if (!empty($ddpdm_original_layouts_names)) {
                add_option('ddpdm_original_layouts_names', $ddpdm_original_layouts_names);
            }
        } else { // option ddpdm_original_layouts_names already exists
        }
    }


    add_filter('wp_head', 'ddpdm_original_layouts_names') ;

    //======================================================================
    // Check if item is in category
    //======================================================================

    function ddpdm_get_all_category_items($category)
    {
        $return_array = array();
        wp_reset_query();  // Restore global post data stomped by the_post()

        $args = array(
    'post_type' => 'et_pb_layout',
    'post_status' => 'publish',
    'posts_per_page'         => '-1',
    'tax_query' => array(
        array(
            'taxonomy' => 'layout_category',
            'field'    => 'slug',
            'terms'    => 'php-template',
        ),
    ),
    'orderby' => 'date',
    'order'   => 'ASC',
    );

        $ddpdm_query = null;
        $ddpdm_query = new WP_Query($args);

        $i=0;

        if ($ddpdm_query->have_posts()) {
            while ($ddpdm_query->have_posts()) : $ddpdm_query->the_post();
            if (has_term($category, 'layout_category', get_the_ID()) && !has_term('Divi Den', 'layout_category', get_the_ID())) {
                $return_array['custom_'.$i] = get_the_title();
                //  echo str_replace('–', '-',get_the_title());
                $i++;
            }
            endwhile;
        }
        return $return_array;
    }


    // check if item in divi library

    function ddpdm_is_divi_item_exists($item_title)
    {
        wp_reset_query();  // Restore global post data stomped by the_post()

        $args = array(
    'post_type' => 'et_pb_layout',
    'title' => $item_title,
    'post_status' => 'publish');

        $ddpdm_query = null;
        $ddpdm_query = new WP_Query($args);

        if ($ddpdm_query ->have_posts()) {
            return true;
        } else {
            wp_reset_query();  // Restore global post data stomped by the_post()
            $ddpdm_original_layouts_names = get_option('ddpdm_original_layouts_names');
            if (is_array($ddpdm_original_layouts_names) && in_array($item_title, $ddpdm_original_layouts_names)) {
                $args = array(
            'post_type' => 'et_pb_layout',
            'p' => array_search($item_title, $ddpdm_original_layouts_names),
            'post_status' => 'publish');

                $ddpdm_query = null;
                $ddpdm_query = new WP_Query($args);

                if ($ddpdm_query ->have_posts()) {
                    return true;
                }
            }
        }
        return false;
    }


    //======================================================================
    // ON POST SAVE
    //======================================================================

    add_action('save_post', 'ddpdm_save_divi_library_item', 10, 3);

    function ddpdm_save_divi_library_item($post_id, $post, $update)
    {
        if ($update === false) {
            if (get_post_type($post_id) === 'et_pb_layout' && has_term("php-template", 'layout_category', $post_id)) {
                $ddpdm_original_layouts_names = get_option('ddpdm_original_layouts_names');
                $ddpdm_original_layouts_names[$post_id] = get_the_title($post_id);
                update_option('ddpdm_original_layouts_names', $ddpdm_original_layouts_names);
                // echo 'et_pb_layout';
            }
        }
        // echo 'NOPE, SORRY';
    }

    // return new item name

    function ddpdm_return_new_name($item_title)
    {
        $ddpdm_original_layouts_names = get_option('ddpdm_original_layouts_names');
        if (in_array($item_title, $ddpdm_original_layouts_names)) {
            $item_id = array_search($item_title, $ddpdm_original_layouts_names);
            //echo '$item_id '.$item_id;
            $post = get_post($item_id);
            // echo '<pre>';
            // print_r($post);
            // echo '</pre>';
            // echo '$post -> post_title ';
            // echo $post -> post_title;
            if ($post) {
                return $post -> post_title;
            } else {
                return $item_title;
            }
        } else {
            return $item_title;
        }
    }

    // check if item in divi library

    function ddpdm_is_divi_category_exists($category)
    {
        wp_reset_query();  // Restore global post data stomped by the_post()

        $args = array(
    'post_type' => 'et_pb_layout',
    'category' => $category,
    'post_status' => 'publish');

        $ddpdm_query = null;
        $ddpdm_query = new WP_Query($args);

        $term = get_term_by('name', $category, 'category');
        if ($term != false) {
            if ($term->count > 0) {
                echo 'posts';
            }
        }


        if ($ddpdm_query ->have_posts()) {
            return true;
        } else {
            return false;
        }
    }

    $ddpdm_custom_templates_dir = plugin_dir_path(__FILE__).'main/custom-templates/*.php';
    foreach (glob($ddpdm_custom_templates_dir) as $filename) {
        include_once($filename);
    }



    // fonts

    function ddpdm_font_scripts()
    {
        // search
        if (get_option('ddpdm_search_results_page_template') !== 'disabled') {
            $ddpdm_search_header_font = esc_html(get_theme_mod('ddpdm_search_results_header_font'));

            if ($ddpdm_search_header_font) {
                wp_enqueue_style('ddpdm-google-font-search-header', '//fonts.googleapis.com/css?family='. $ddpdm_search_header_font);
            }

            $ddpdm_search_body_font = esc_html(get_theme_mod('ddpdm_search_results_body_font'));

            if ($ddpdm_search_body_font) {
                wp_enqueue_style('ddpdm-google-font-search-body', '//fonts.googleapis.com/css?family='. $ddpdm_search_body_font);
            }
        }

        // global archive
        if (get_option('ddpdm_global_page_template') !== 'disabled') {
            $ddpdm_global_archive_header_font = esc_html(get_theme_mod('ddpdm_global_archive_header_font'));

            if ($ddpdm_global_archive_header_font) {
                wp_enqueue_style('ddpdm-google-font-global-archive-header', '//fonts.googleapis.com/css?family='. $ddpdm_global_archive_header_font);
            }

            $ddpdm_global_archive_body_font = esc_html(get_theme_mod('ddpdm_global_archive_body_font'));

            if ($ddpdm_global_archive_body_font) {
                wp_enqueue_style('ddpdm-google-font-global-archive-body', '//fonts.googleapis.com/css?family='. $ddpdm_global_archive_body_font);
            }

            $ddpdm_global_archive_header_font_col = esc_html(get_theme_mod('ddpdm_global_archive_header_font_col'));

            if ($ddpdm_global_archive_header_font_col) {
                wp_enqueue_style('ddpdm-google-font-global-archive-header-col', '//fonts.googleapis.com/css?family='. $ddpdm_global_archive_header_font_col);
            }

            $ddpdm_global_archive_mdcr_font_col = esc_html(get_theme_mod('ddpdm_global_archive_mdcr_font_col'));

            if ($ddpdm_global_archive_mdcr_font_col) {
                wp_enqueue_style('ddpdm-google-font-global-archive-mdcr-col', '//fonts.googleapis.com/css?family='. $ddpdm_global_archive_mdcr_font_col);
            }
        }

        // category
        if (get_option('ddpdm_category_page_template') !== 'disabled') {
            $ddpdm_category_header_font = esc_html(get_theme_mod('ddpdm_category_header_font'));

            if ($ddpdm_category_header_font) {
                wp_enqueue_style('ddpdm-google-font-category-header', '//fonts.googleapis.com/css?family='. $ddpdm_category_header_font);
            }

            $ddpdm_category_body_font = esc_html(get_theme_mod('ddpdm_category_body_font'));

            if ($ddpdm_category_body_font) {
                wp_enqueue_style('ddpdm-google-font-category-body', '//fonts.googleapis.com/css?family='. $ddpdm_category_body_font);
            }

            $ddpdm_category_header_font_col = esc_html(get_theme_mod('ddpdm_category_header_font_col'));

            if ($ddpdm_category_header_font_col) {
                wp_enqueue_style('ddpdm-google-font-category-header-col', '//fonts.googleapis.com/css?family='. $ddpdm_category_header_font_col);
            }

            $ddpdm_category_mdcr_font_col = esc_html(get_theme_mod('ddpdm_category_mdcr_font_col'));

            if ($ddpdm_category_mdcr_font_col) {
                wp_enqueue_style('ddpdm-google-font-global-category-mdcr-col', '//fonts.googleapis.com/css?family='. $ddpdm_category_mdcr_font_col);
            }
        }

        // tag
        if (get_option('ddpdm_tag_page_template') !== 'disabled') {
            $ddpdm_tag_header_font = esc_html(get_theme_mod('ddpdm_tag_header_font'));

            if ($ddpdm_tag_header_font) {
                wp_enqueue_style('ddpdm-google-font-tag-header', '//fonts.googleapis.com/css?family='. $ddpdm_tag_header_font);
            }

            $ddpdm_tag_body_font = esc_html(get_theme_mod('ddpdm_tag_body_font'));

            if ($ddpdm_tag_body_font) {
                wp_enqueue_style('ddpdm-google-font-tag-body', '//fonts.googleapis.com/css?family='. $ddpdm_tag_body_font);
            }

            $ddpdm_tag_header_font_col = esc_html(get_theme_mod('ddpdm_tag_header_font_col'));

            if ($ddpdm_tag_header_font_col) {
                wp_enqueue_style('ddpdm-google-font-tag-header-col', '//fonts.googleapis.com/css?family='. $ddpdm_tag_header_font_col);
            }

            $ddpdm_tag_mdcr_font_col = esc_html(get_theme_mod('ddpdm_tag_mdcr_font_col'));

            if ($ddpdm_tag_mdcr_font_col) {
                wp_enqueue_style('ddpdm-google-font-tag-mdcr-col', '//fonts.googleapis.com/css?family='. $ddpdm_tag_mdcr_font_col);
            }
        }

        // author
        if (get_option('ddpdm_author_page_template') !== 'disabled') {
            $ddpdm_author_header_font = esc_html(get_theme_mod('ddpdm_author_header_font'));

            if ($ddpdm_author_header_font) {
                wp_enqueue_style('ddpdm-google-font-author-header', '//fonts.googleapis.com/css?family='. $ddpdm_author_header_font);
            }

            $ddpdm_author_body_font = esc_html(get_theme_mod('ddpdm_author_body_font'));

            if ($ddpdm_author_body_font) {
                wp_enqueue_style('ddpdm-google-font-author-body', '//fonts.googleapis.com/css?family='. $ddpdm_author_body_font);
            }

            $ddpdm_author_header_font_col = esc_html(get_theme_mod('ddpdm_author_header_font_col'));

            if ($ddpdm_author_header_font_col) {
                wp_enqueue_style('ddpdm-google-font-author-header-col', '//fonts.googleapis.com/css?family='. $ddpdm_author_header_font_col);
            }

            $ddpdm_author_mdcr_font_col = esc_html(get_theme_mod('ddpdm_author_mdcr_font_col'));

            if ($ddpdm_author_mdcr_font_col) {
                wp_enqueue_style('ddpdm-google-font-author-mdcr-col', '//fonts.googleapis.com/css?family='. $ddpdm_author_mdcr_font_col);
            }
        }

        // single post

        if (get_option('ddpdm_single_post_template') !== 'disabled') {
            $ddpdm_single_header_font = esc_html(get_theme_mod('ddpdm_single_header_font'));

            if ($ddpdm_single_header_font) {
                wp_enqueue_style('ddpdm-google-font-single-header', '//fonts.googleapis.com/css?family='. $ddpdm_single_header_font);
            }

            $ddpdm_single_body_font = esc_html(get_theme_mod('ddpdm_single_body_font'));

            if ($ddpdm_single_body_font) {
                wp_enqueue_style('ddpdm-google-font-single-body', '//fonts.googleapis.com/css?family='. $ddpdm_single_body_font);
            }

            $ddpdm_single_h1_h6_font = esc_html(get_theme_mod('ddpdm_single_h1_h6_font'));

            if ($ddpdm_single_h1_h6_font) {
                wp_enqueue_style('ddpdm-google-font-single-h1_h6', '//fonts.googleapis.com/css?family='. $ddpdm_single_h1_h6_font);
            }
        }

        // global h1 h6

        if (get_option('ddpdm_global_h1_h6') !== 'disabled') {
            if (get_option('ddpdm_global_h1_h6') === 'global') {
                $ddpdm_global_h1_h6_font = esc_html(get_theme_mod('ddpdm_global_h1_h6_font'));

                if ($ddpdm_global_h1_h6_font) {
                    wp_enqueue_style('ddpdm-google-font-global-h1_h6', '//fonts.googleapis.com/css?family='. $ddpdm_global_h1_h6_font);
                }
            }

            if (get_option('ddpdm_global_h1_h6') === 'individually') {
                $ddpdm_global_h1_font = esc_html(get_theme_mod('ddpdm_global_h1_font'));

                if ($ddpdm_global_h1_font) {
                    wp_enqueue_style('ddpdm-google-font-global-h1', '//fonts.googleapis.com/css?family='. $ddpdm_global_h1_font);
                }

                $ddpdm_global_h2_font = esc_html(get_theme_mod('ddpdm_global_h2_font'));

                if ($ddpdm_global_h2_font) {
                    wp_enqueue_style('ddpdm-google-font-global-h2', '//fonts.googleapis.com/css?family='. $ddpdm_global_h2_font);
                }

                $ddpdm_global_h3_font = esc_html(get_theme_mod('ddpdm_global_h3_font'));

                if ($ddpdm_global_h3_font) {
                    wp_enqueue_style('ddpdm-google-font-global-h3', '//fonts.googleapis.com/css?family='. $ddpdm_global_h3_font);
                }

                $ddpdm_global_h4_font = esc_html(get_theme_mod('ddpdm_global_h4_font'));

                if ($ddpdm_global_h4_font) {
                    wp_enqueue_style('ddpdm-google-font-global-h4', '//fonts.googleapis.com/css?family='. $ddpdm_global_h4_font);
                }

                $ddpdm_global_h5_font = esc_html(get_theme_mod('ddpdm_global_h5_font'));

                if ($ddpdm_global_h5_font) {
                    wp_enqueue_style('ddpdm-google-font-global-h5', '//fonts.googleapis.com/css?family='. $ddpdm_global_h5_font);
                }

                $ddpdm_global_h6_font = esc_html(get_theme_mod('ddpdm_global_h6_font'));

                if ($ddpdm_global_h6_font) {
                    wp_enqueue_style('ddpdm-google-font-global-h6', '//fonts.googleapis.com/css?family='. $ddpdm_global_h6_font);
                }
            }
        }

        // mobile menu

        if (get_option('ddpdm_mobile_menu_template') !== 'disabled' && get_option('ddpdm_menu_template') === 'disabled') {
            if (get_option('ddpdm_mobile_menu_template') === 'mobile_menu_1') {
                $ddpdm_mobile_menu_1_font = esc_html(get_theme_mod('ddpdm_mobile_menu_1_font'));

                if ($ddpdm_mobile_menu_1_font) {
                    wp_enqueue_style('ddpdm-google-font-menu-1', '//fonts.googleapis.com/css?family='. $ddpdm_mobile_menu_1_font);
                }

                $ddpdm_mobile_menu_1_sub_font = esc_html(get_theme_mod('ddpdm_mobile_menu_1_sub_font'));

                if ($ddpdm_mobile_menu_1_sub_font) {
                    wp_enqueue_style('ddpdm-google-sub-font-menu-1', '//fonts.googleapis.com/css?family='. $ddpdm_mobile_menu_1_sub_font);
                }
            }
            if (get_option('ddpdm_mobile_menu_template') === 'mobile_menu_2') {
                $ddpdm_mobile_menu_2_font = esc_html(get_theme_mod('ddpdm_mobile_menu_2_font'));

                if ($ddpdm_mobile_menu_2_font) {
                    wp_enqueue_style('ddpdm-google-font-menu-2', '//fonts.googleapis.com/css?family='. $ddpdm_mobile_menu_2_font);
                }

                $ddpdm_mobile_menu_2_sub_font = esc_html(get_theme_mod('ddpdm_mobile_menu_2_sub_font'));

                if ($ddpdm_mobile_menu_2_sub_font) {
                    wp_enqueue_style('ddpdm-google-sub-font-menu-2', '//fonts.googleapis.com/css?family='. $ddpdm_mobile_menu_2_sub_font);
                }
            }
            if (get_option('ddpdm_mobile_menu_template') === 'mobile_menu_3') {
                $ddpdm_mobile_menu_3_font = esc_html(get_theme_mod('ddpdm_mobile_menu_3_font'));

                if ($ddpdm_mobile_menu_3_font) {
                    wp_enqueue_style('ddpdm-google-font-menu-3', '//fonts.googleapis.com/css?family='. $ddpdm_mobile_menu_3_font);
                }

                $ddpdm_mobile_menu_3_sub_font = esc_html(get_theme_mod('ddpdm_mobile_menu_3_sub_font'));

                if ($ddpdm_mobile_menu_3_sub_font) {
                    wp_enqueue_style('ddpdm-google-sub-font-menu-3', '//fonts.googleapis.com/css?family='. $ddpdm_mobile_menu_3_sub_font);
                }

                $ddpdm_mobile_menu_3_address_font = esc_html(get_theme_mod('ddpdm_mobile_menu_3_address_font'));

                if ($ddpdm_mobile_menu_3_address_font) {
                    wp_enqueue_style('ddpdm-google-address-font-menu-3', '//fonts.googleapis.com/css?family='. $ddpdm_mobile_menu_3_address_font);
                }
            }
            if (get_option('ddpdm_mobile_menu_template') === 'mobile_menu_custom') {
                $ddpdm_mobile_menu_custom_font = esc_html(get_theme_mod('ddpdm_mobile_menu_custom_font'));

                if ($ddpdm_mobile_menu_custom_font) {
                    wp_enqueue_style('ddpdm-google-font-menu-custom', '//fonts.googleapis.com/css?family='. $ddpdm_mobile_menu_custom_font);
                }

                $ddpdm_mobile_menu_custom_sub_font = esc_html(get_theme_mod('ddpdm_mobile_menu_custom_sub_font'));

                if ($ddpdm_mobile_menu_custom_sub_font) {
                    wp_enqueue_style('ddpdm-google-sub-font-menu-custom', '//fonts.googleapis.com/css?family='. $ddpdm_mobile_menu_custom_sub_font);
                }
            }
        }

        // back to top button
        if (get_theme_mod('ddpdm_back_to_top', false) == 1) {
            $ddpdm_back_to_top_font_value = esc_html(get_theme_mod('ddpdm_back_to_top_font_value'));

            if ($ddpdm_back_to_top_font_value) {
                wp_enqueue_style('ddpdm-google-font-back-to-top-text', '//fonts.googleapis.com/css?family='. $ddpdm_back_to_top_font_value);
            }
        }
    }
    add_action('wp_enqueue_scripts', 'ddpdm_font_scripts');

    function ddpdm_login_font_scripts()
    {

// login

        if (get_option('ddpdm_login_template') === 'diana_1') {
            $ddpdm_login_diana_1_font_value = esc_html(get_theme_mod('ddpdm_login_diana_1_font_value'));

            if ($ddpdm_login_diana_1_font_value) {
                wp_enqueue_style('ddpdm-google-font-login-diana_1', '//fonts.googleapis.com/css?family='. $ddpdm_login_diana_1_font_value);
            }
        }

        if (get_option('ddpdm_login_template') === 'diana_2') {
            $ddpdm_login_diana_2_font_value = esc_html(get_theme_mod('ddpdm_login_diana_2_font_value'));

            if ($ddpdm_login_diana_2_font_value) {
                wp_enqueue_style('ddpdm-google-font-login-diana_2', '//fonts.googleapis.com/css?family='. $ddpdm_login_diana_2_font_value);
            }
        }

        if (get_option('ddpdm_login_template') === 'diana_3') {
            $ddpdm_login_diana_3_font_value = esc_html(get_theme_mod('ddpdm_login_diana_3_font_value'));

            if ($ddpdm_login_diana_3_font_value) {
                wp_enqueue_style('ddpdm-google-font-login-diana_3', '//fonts.googleapis.com/css?family='. $ddpdm_login_diana_3_font_value);
            }
        }
    }


    add_action('login_enqueue_scripts', 'ddpdm_login_font_scripts');




    //Sanitizes Fonts
    function ddpdm_sanitize_fonts($input)
    {
        $valid = array(
        'Source Sans Pro:400,700,400italic,700italic' => 'Source Sans Pro',
        'Open Sans:400italic,700italic,400,700' => 'Open Sans',
        'Oswald:400,700' => 'Oswald',
        'Playfair Display:400,700,400italic' => 'Playfair Display',
        'Montserrat:400,700' => 'Montserrat',
        'Raleway:400,700' => 'Raleway',
        'Droid Sans:400,700' => 'Droid Sans',
        'Lato:400,700,400italic,700italic' => 'Lato',
        'Arvo:400,700,400italic,700italic' => 'Arvo',
        'Lora:400,700,400italic,700italic' => 'Lora',
        'Merriweather:400,300italic,300,400italic,700,700italic' => 'Merriweather',
        'Oxygen:400,300,700' => 'Oxygen',
        'PT Serif:400,700' => 'PT Serif',
        'PT Sans:400,700,400italic,700italic' => 'PT Sans',
        'PT Sans Narrow:400,700' => 'PT Sans Narrow',
        'Cabin:400,700,400italic' => 'Cabin',
        'Fjalla One:400' => 'Fjalla One',
        'Francois One:400' => 'Francois One',
        'Josefin Sans:400,300,600,700' => 'Josefin Sans',
        'Libre Baskerville:400,400italic,700' => 'Libre Baskerville',
        'Arimo:400,700,400italic,700italic' => 'Arimo',
        'Ubuntu:400,700,400italic,700italic' => 'Ubuntu',
        'Bitter:400,700,400italic' => 'Bitter',
        'Droid Serif:400,700,400italic,700italic' => 'Droid Serif',
        'Roboto:400,400italic,700,700italic' => 'Roboto',
        'Open Sans Condensed:700,300italic,300' => 'Open Sans Condensed',
        'Roboto Condensed:400italic,700italic,400,700' => 'Roboto Condensed',
        'Roboto Slab:400,700' => 'Roboto Slab',
        'Yanone Kaffeesatz:400,700' => 'Yanone Kaffeesatz',
        'Rokkitt:400' => 'Rokkitt',
        'Poppins:400' => 'Poppins',
        'Poiret One:400' => 'Poiret One',
    );


        if (array_key_exists($input, $valid)) {
            return $input;
        } else {
            return '';
        }
    }

    /*
     * Add Customizer content
     */

    add_action('customize_register', 'ddprodm_alpha_customize_register');


    $ddpdm_customizer_dir = plugin_dir_path(__FILE__).'main/wp-customizer/*.php';
    foreach (glob($ddpdm_customizer_dir) as $filename) {
        include_once($filename);
    }


    function ddpdm_customizer_css_and_js()
    {
        wp_enqueue_script('ddpdm_customizer_js', plugin_dir_url(__FILE__) . 'js/ddpdm-wp-customizer.js', array('jquery'));
    }

    add_action('customize_controls_enqueue_scripts', 'ddpdm_customizer_css_and_js', 100);

    // process font styles

    function ddpdm_process_font_styles($styles)
    {
        $return_text = '';
        $font_styles = explode("|", $styles);
        foreach ($font_styles as $font_style) {
            switch ($font_style) {
                case 'bold':
                    $return_text = $return_text.'font-weight: 700 !important; ';
                    break;

                case 'italic':
                    $return_text = $return_text.'font-style: italic !important; ';
                    break;

                case 'uppercase':
                    $return_text = $return_text.'text-transform: uppercase !important; ';
                    break;

                case 'underline':
                    $return_text = $return_text.'text-decoration: underline !important; ';
                    break;

                default:
                    $return_text = $return_text;
                    break;
            }
        }
        return $return_text;
    }
} // activated check ends