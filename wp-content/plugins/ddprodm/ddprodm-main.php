<?php

/**
 * Main plugin's class and functions
 * API code is based on  WooCommerce API Manager plugin and theme library
 * by Todd Lahman LLC https://www.toddlahman.com/
 * GNU General Public License v3.0 http://www.gnu.org/licenses/gpl-3.0.html
 *
 * @package     Divi Den Pro DM
 * @author      WP Den
 * @since       5.0.0
 * @license     GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
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
// Main class
//======================================================================


if (!class_exists('ddpdm_Main_Class')) {
    class ddpdm_Main_Class
    {

        /**
         * Class args.
         *
         * @var string
         */
        public $file = '';
        public $software_title = '';
        public $software_version = '';
        public $api_url = '';
        public $data_prefix = '';
        public $slug = '';
        public $plugin_name = '';
        public $text_domain = '';
        public $extra = '';

        /**
         * Class properties.
         *
         * @var string
         */
        public $ddpdm_software_product_id;
        public $ddpdm_data_key;
        public $ddpdm_instance_key;
        public $ddpdm_activated_key;
        public $ddpdm_activation_tab_key;
        public $ddpdm_settings_menu_title;
        public $ddpdm_options;
        public $ddpdm_plugin_name;
        public $ddpdm_product_id;
        public $ddpdm_instance_id;
        public $ddpdm_domain;
        public $ddpdm_software_version;

        /**
         * @var null
         */
        protected static $_instance = null;

        public static function instance($file, $software_title, $software_version)
        {
            if (is_null(self::$_instance)) {
                self::$_instance = new self($file, $software_title, $software_version);
            }

            return self::$_instance;
        }


        public function ddpdm_allowed_html()
        {
            if (!function_exists('ddpdm_allowed_html')) {
                require_once(plugin_dir_path(__FILE__) . 'include/ddpdm-allowed-html-tags.php');
            }

            $allowed_tags = ddpdm_allowed_html();

            return $allowed_tags;
        }

        //======================================================================
        // CONSTANTS FOR WL
        //======================================================================

        public function ddpdm_set_wl()
        {
            $ddpdm_plugin_name       = 'Divi Den Pro DM';
            $ddpdm_plugin_url        = 'https://seku.re/dm-divi-den-pro';
            $ddpdm_plugin_author     = 'Divi Den';
            $ddpdm_plugin_author_url = 'https://seku.re/divi-den-author-divi-marketplace';
            $ddpdm_plugin_desc       = __('Huge layout library made for Elegant Themes’ Divi Marketplace. Search the cloud library for page layouts, sections and modules. Build beautiful websites at twice the speed.', 'ddprodm');
            $ddpdm_plugin_icon       = plugins_url('ddprodm/include/ddpdm-icon.png');
            $ddpdm_wp_content        = '<img class="alignnone size-full" src="';
            $ddpdm_wp_content       .= plugins_url('ddprodm/include/ddpdm-your-logo.png');
            $ddpdm_wp_content       .= '" alt="Your Logo" width="437" height="97" />

                                        <hr />

                                        <h1>ABC Studio</h1>

                                        <hr />

                                        <strong>Theme Name:</strong> Your Clients Name

                                        <strong>Theme URI:</strong> <a href="https://clientsname.com/">https://clientsname.com/</a>

                                        <strong>Description:</strong> Smart. Flexible. Beautiful. ABC Studio - Design at its best.

                                        <strong>Author:</strong> Your Name

                                        <strong>Author URI</strong>: <a href="http://www.yourname.com">http://www.yourname.com</a>

                                        <hr />

                                        <h2>Contact us</h2>

                                        <hr />

                                        <h3>Call us<strong>
                                        </strong></h3>
                                        <a href="tel:1123456789">1 (123) 456 789</a>
                                        <a href="tel:1123456788">1 (123) 456 788</a>

                                        <hr />

                                        <h3>Email us</h3>

                                        <hr />

                                        <a href="mailto:name@website.com">name@website.com</a>
                                        <a href="mailto:sales@website.com">sales@website.com</a>

                                        <hr />

                                        <h3>Visit us</h3>

                                        <hr />

                                        105 Street Name
                                        City Name, CD 12345

                                        <hr />

                                        <h3>When we work</h3>
                                        8.00-18.00 Mon-Fri
                                        8.00-12.00 Sat';

            if (!get_option('ddpdm_wl')) {
                add_option('ddpdm_wl', 'disabled');
            }
            if (!get_option('ddpdm_plugin_name')) {
                add_option('ddpdm_plugin_name', $ddpdm_plugin_name);
            }
            if (!get_option('ddpdm_wp_content')) {
                add_option('ddpdm_wp_content', $ddpdm_wp_content);
            }

            if (get_option('ddpdm_wl') == 'enabled') {
                if (get_option('ddpdm_plugin_name')) {
                    if (!defined('DDPDM_NAME')) {
                        define('DDPDM_NAME', get_option('ddpdm_plugin_name'));
                    }
                    if (!defined('DDPDM_LINK')) {
                        define('DDPDM_LINK', str_replace(" ", "_", strtolower(get_option('ddpdm_plugin_name'))));
                    }
                } else {
                    if (!defined('DDPDM_NAME')) {
                        define('DDPDM_NAME', $ddpdm_plugin_name);
                    }
                    if (!defined('DDPDM_LINK')) {
                        define('DDPDM_LINK', str_replace(' ', '_', strtolower(DDPDM_NAME)));
                    }
                }

                if (get_option('ddpdm_plugin_icon') != '') {
                    if (!defined('DDPDM_ICON')) {
                        define('DDPDM_ICON', get_option('ddpdm_plugin_icon'));
                    }
                } else {
                    if (!defined('DDPDM_ICON')) {
                        define('DDPDM_ICON', plugin_dir_url(__FILE__) . '/include/ddpdm-wl-default-icon.png');
                    }
                }

                if (get_option('ddpdm_plugin_url')) {
                    if (!defined('DDPDM_URL')) {
                        define('DDPDM_URL', get_option('ddpdm_plugin_url'));
                    }
                } else {
                    if (!defined('DDPDM_URL')) {
                        define('DDPDM_URL', $ddpdm_plugin_url);
                    }
                }

                if (get_option('ddpdm_plugin_desc')) {
                    if (!defined('DDPDM_DESC')) {
                        define('DDPDM_DESC', get_option('ddpdm_plugin_desc'));
                    }
                } else {
                    if (!defined('DDPDM_DESC')) {
                        define('DDPDM_DESC', $ddpdm_plugin_desc);
                    }
                }

                if (get_option('ddpdm_plugin_author')) {
                    if (!defined('DDPDM_AUTHOR')) {
                        define('DDPDM_AUTHOR', get_option('ddpdm_plugin_author'));
                    }
                } else {
                    if (!defined('DDPDM_AUTHOR')) {
                        define('DDPDM_AUTHOR', $ddpdm_plugin_author);
                    }
                }

                if (get_option('ddpdm_plugin_author_url')) {
                    if (!defined('DDPDM_AUTHOR_URL')) {
                        define('DDPDM_AUTHOR_URL', get_option('ddpdm_plugin_author_url'));
                    }
                } else {
                    if (!defined('DDPDM_AUTHOR_URL')) {
                        define('DDPDM_AUTHOR_URL', $ddpdm_plugin_author_url);
                    }
                }
            } //if (get_option('ddpdm_wl') == 'enabled')
            else {
                if (!defined('DDPDM_NAME')) {
                    define('DDPDM_NAME', $ddpdm_plugin_name);
                }
                if (!defined('DDPDM_LINK')) {
                    define('DDPDM_LINK', str_replace(' ', '_', strtolower(DDPDM_NAME)));
                }
                if (!defined('DDPDM_ICON')) {
                    define('DDPDM_ICON', $ddpdm_plugin_icon);
                }
                if (!defined('DDPDM_URL')) {
                    define('DDPDM_URL', $ddpdm_plugin_url);
                }
                if (!defined('DDPDM_DESC')) {
                    define('DDPDM_DESC', $ddpdm_plugin_desc);
                }
                if (!defined('DDPDM_AUTHOR')) {
                    define('DDPDM_AUTHOR', $ddpdm_plugin_author);
                }
                if (!defined('DDPDM_AUTHOR_URL')) {
                    define('DDPDM_AUTHOR_URL', $ddpdm_plugin_author_url);
                }
            }
            //echo 'DDPDM_LINK ' . DDPDM_LINK;
        }


        //======================================================================
        // RENAME WHITE LABEL PLUGIN
        //======================================================================

        public function ddpdm_all_plugins($plugins)
        {
            $plugins['ddprodm/ddprodm.php']['Name']      = DDPDM_NAME;
            $plugins['ddprodm/ddprodm.php']['Title']     = DDPDM_NAME;
            $plugins['ddprodm/ddprodm.php']['Author']    = DDPDM_AUTHOR;
            $plugins['ddprodm/ddprodm.php']['AuthorURI'] = DDPDM_AUTHOR_URL;
            $plugins['ddprodm/ddprodm.php']['PluginURI'] = DDPDM_URL;

            if (DDPDM_DESC) {
                $plugins['ddprodm/ddprodm.php']['Description'] = DDPDM_DESC;
            }

            return $plugins;
        }

        public function ddpdm_translate_all($translated, $original, $domain)
        {
            switch ($translated) {
                case 'Divi Den Pro DM' :
                    $translated_text =  DDPDM_NAME;
                    break;
                default: $translated_text = $translated;
            }
            return $translated_text;
        }


        //======================================================================
        // CUSTOM ADMIN MENU ICON
        //======================================================================

        public function ddpdm_custom_wl_scripts_and_styles()
        {
            echo '<style>
    	    .toplevel_page_' . wp_kses(DDPDM_LINK, ddpdm_allowed_html()) . '_dashboard .wp-menu-image img {
    			max-width: 24px;
    			padding: 5px 0 0 !important;
    		}
    		a.open-plugin-details-modal[aria-label*="View '. esc_html(DDPDM_NAME).'"], tr#ddprodm-update a.open-plugin-details-modal {display: none !important;}
    		tr#ddprodm-update a.update-link {text-transform: capitalize; margin-left: -15px; background: #fff8e5;}
    		  </style>';
            echo '<script>jQuery(document).ready(function($) {
                $("tr[data-slug=ddprodm] .plugin-version-author-uri a.open-plugin-details-modal").attr("href", "'.esc_url(DDPDM_URL).'").removeClass("thickbox").attr("target", "_blank");
                }); //jQuery(document).ready(function($)</script>';
        }


        //======================================================================
        // CUNSTRUCT FUNCTION
        //======================================================================

        public function __construct($file, $software_title, $software_version)
        {
            $this->file            = $file;
            $this->software_title  = $software_title;
            $this->version         = $software_version;
            $this->api_url         = 'https://www.elegantthemes.com/marketplace/wp-json/api/v1/check_subscription/';
            $this->data_prefix     = str_ireplace(array(
                ' ',
                '_',
                '&',
                '?'
            ), '_', strtolower($this->software_title));


            if (is_admin()) {
                add_action('plugins_loaded', array(
                    $this,
                    'ddpdm_set_wl'
                ));

                if (get_option('ddpdm_wl') === 'enabled') {
                    add_action('admin_head', array(
                        $this,
                        'ddpdm_custom_wl_scripts_and_styles'
                    ));

                    add_filter('gettext', array(
                        $this,
                        'ddpdm_translate_all'
                    ), 13, 3);
                }

                add_filter('all_plugins', array(
                    $this,
                    'ddpdm_all_plugins'
                ), 10, 4);

                add_action('admin_menu', array(
                    $this,
                    'ddpdm_register_menu'
                ));

                // Check for external connection blocking
                add_action('admin_notices', array(
                    $this,
                    'ddpdm_check_external_blocking'
                ));


                /**
                 * Software Product ID is the product title string
                 * This value must be unique, and it must match the API tab for the product in WooCommerce
                 */
                $this->ddpdm_software_product_id = $this->software_title;

                /**
                 * Set all data defaults here
                 */
                $this->ddpdm_data_key                = $this->data_prefix . '_data';
                $this->ddpdm_product_id_key          = $this->data_prefix . '_product_id';
                $this->ddpdm_instance_key            = $this->data_prefix . '_instance';
                $this->ddpdm_activated_key           = $this->data_prefix . '_activated';

                /**
                 * Set all admin menu data
                 */

                $this->ddpdm_set_wl();
                $this->ddpdm_settings_menu_title = DDPDM_NAME;
                $this->ddpdm_deactivate_checkbox = DDPDM_LINK . '_deactivate_checkbox';

                $this->ddpdm_activation_tab_key          = DDPDM_LINK . '_dashboard';
                $this->ddpdm_activation_tab_key_wl       = DDPDM_LINK . '_dashboard_wl';
                $this->ddpdm_deactivation_tab_key        = DDPDM_LINK . '_deactivation';

                /**
                 * Set all software update data here
                 */
                $this->ddpdm_options           = get_option($this->ddpdm_data_key);
                $this->ddpdm_plugin_name       = untrailingslashit(plugin_basename($this->file)); // same as plugin slug.
                $this->ddpdm_product_id        = '3640'; // Software ID in ET Marketplace - 3640
                $this->ddpdm_instance_id       = get_option($this->ddpdm_instance_key); // Instance ID (unique to each blog activation)

                $this->ddpdm_domain            = str_ireplace(array(
                    'http://',
                    'https://'
                ), '', home_url()); // blog domain name
                $this->ddpdm_software_version  = $this->version; // The software version
                $options                     = get_option($this->ddpdm_data_key);
            } //if (is_admin())
        } //public function __construct

        /**
         * Register submenu specific to this product.
         */
        public function ddpdm_register_menu()
        {
            if (get_option('ddpdm_wl') == 'enabled') {
                // for agency, hidden
                add_submenu_page(null, __(DDPDM_NAME, 'ddprodm'), 'submenu', 'manage_options', $this->ddpdm_activation_tab_key . '_wl', array(
                    $this,
                    'ddpdm_config_page'
                ), DDPDM_ICON);
                if (get_option('ddpdm_hide_menu') != 'enabled') {
                    // for clients, visible
                    add_menu_page(__(DDPDM_NAME, 'ddprodm'), __(DDPDM_NAME, 'ddprodm'), 'manage_options', $this->ddpdm_activation_tab_key, array(
                        $this,
                        'ddpdm_wl_config_page'
                    ), DDPDM_ICON);
                }
            } //if(get_option('ddpdm_wl') == 'enabled')
            else {
                add_menu_page(__(DDPDM_NAME, 'ddprodm'), __(DDPDM_NAME, 'ddprodm'), 'manage_options', $this->ddpdm_activation_tab_key, array(
                    $this,
                    'ddpdm_config_page'
                ), DDPDM_ICON, null);
                add_submenu_page($this->ddpdm_activation_tab_key, __(DDPDM_NAME, 'ddprodm'), __('Layout Finder', 'ddprodm'), 'manage_options', $this->ddpdm_activation_tab_key, '', null);
                add_submenu_page($this->ddpdm_activation_tab_key, __('Latest', 'ddprodm'), __('Latest', 'ddprodm'), 'manage_options', 'admin.php?page='.$this->ddpdm_activation_tab_key.'&tab=ddpdm_latest_feed', '', null);
                add_submenu_page($this->ddpdm_activation_tab_key, __('Tutorials', 'ddprodm'), __('Tutorials', 'ddprodm'), 'manage_options', 'admin.php?page='.$this->ddpdm_activation_tab_key.'&tab=ddpdm_start_here', '', null);
                if (get_option($this->ddpdm_activated_key) == 'Activated') {
                    add_submenu_page($this->ddpdm_activation_tab_key, __('Divi Theme Builder', 'ddprodm'), __('Divi Theme Builder', 'ddprodm'), 'manage_options', 'admin.php?page='.$this->ddpdm_activation_tab_key.'&tab=ddpdm_divi_theme_builder', '', null);
                    add_submenu_page($this->ddpdm_activation_tab_key, __('Plugin Theme Builder', 'ddprodm'), __('Plugin Theme Builder', 'ddprodm'), 'manage_options', 'admin.php?page='.$this->ddpdm_activation_tab_key.'&tab=ddpdm_settings', '', null);
                    add_submenu_page($this->ddpdm_activation_tab_key, __('Custom CSS Files', 'ddprodm'), __('Custom CSS Files', 'ddprodm'), 'manage_options', 'admin.php?page='.$this->ddpdm_activation_tab_key.'&tab=ddpdm_css', '', null);
                }
                add_submenu_page($this->ddpdm_activation_tab_key, __('Support', 'ddprodm'), __('Support', 'ddprodm'), 'manage_options', 'admin.php?page='.$this->ddpdm_activation_tab_key.'&tab=ddpdm_assistant_help_faq', '', null);
                add_submenu_page($this->ddpdm_activation_tab_key, __('System Status', 'ddprodm'), __('System Status', 'ddprodm'), 'manage_options', 'admin.php?page='.$this->ddpdm_activation_tab_key.'&tab=ddpdm_assistant_system_status', '', null);
                if (get_option($this->ddpdm_activated_key) == 'Activated') {
                    add_submenu_page($this->ddpdm_activation_tab_key, __('White Label', 'ddprodm'), __('White Label', 'ddprodm'), 'manage_options', 'admin.php?page='.$this->ddpdm_activation_tab_key.'&tab=ddpdm_wl', '', null);
                    add_submenu_page($this->ddpdm_activation_tab_key, __('More Options', 'ddprodm'), __('More Options', 'ddprodm'), 'manage_options', 'admin.php?page='.$this->ddpdm_activation_tab_key.'&tab=ddpdm_options', '', null);
                }
            }
        }


        /**
         * Check for external blocking contstant.
         */
        public function ddpdm_check_external_blocking()
        {
            // show notice if external requests are blocked through the WP_HTTP_BLOCK_EXTERNAL constant
            if (defined('WP_HTTP_BLOCK_EXTERNAL') && WP_HTTP_BLOCK_EXTERNAL === true) {
                // check if our API endpoint is in the allowed hosts
                $host = parse_url($this->api_url, PHP_URL_HOST);

                if (!defined('WP_ACCESSIBLE_HOSTS') || stristr(WP_ACCESSIBLE_HOSTS, $host) === false) { ?>
                    <div class="notice notice-error">
                        <p><?php
                    printf(esc_html__('<strong>Warning!</strong> You\'re blocking external requests which means you won\'t be able to get %s updates. Please add %s to %s.', 'ddprodm'), esc_html($this->ddpdm_software_product_id), '<strong>' . esc_url($host) . '</strong>', '<code>WP_ACCESSIBLE_HOSTS</code>'); ?></p>
                    </div>
                    <?php
                }
            }
        }

        /**
         * Generate report
         */

        /**
         * helper function for number conversions
         *
         * @access public
         * @param mixed $v
         * @return void
         */
        public function num_convt($v)
        {
            $l   = substr($v, -1);
            $ret = substr($v, 0, -1);

            switch (strtoupper($l)) {
                case 'P': // fall-through
                case 'T': // fall-through
                case 'G': // fall-through
                case 'M': // fall-through
                case 'K': // fall-through
                    $ret *= 1024;
                    break;
                default:
                    break;
            }

            return $ret;
        }

        public function ddpdm_report_data($warning_flag)
        {

            // data checks for later

            $mu_plugins = get_mu_plugins();
            $plugins    = get_plugins();
            $active     = get_option('active_plugins', array());

            $theme_data         = wp_get_theme();
            $theme              = $theme_data->Name . ' ' . $theme_data->Version;
            $style_parent_theme = wp_get_theme(get_template());
            $parent_theme       = $style_parent_theme->get('Name') . " " . $style_parent_theme->get('Version');
            //print_r($theme_data);

            // multisite details
            $nt_plugins = is_multisite() ? wp_get_active_network_plugins() : array();
            $nt_active  = is_multisite() ? get_site_option('active_sitewide_plugins', array()) : array();
            $ms_sites   = is_multisite() ? wp_get_sites() : null;

            // yes / no specifics
            $ismulti  = is_multisite() ? __('Yes', 'ddpdm-report') : __('No', 'ddpdm-report');
            $safemode = ini_get('safe_mode') ? __('Yes', 'ddpdm-report') : __('No', 'ddpdm-report');
            $wpdebug  = defined('WP_DEBUG') ? WP_DEBUG ? __('Enabled', 'ddpdm-report') : __('Disabled', 'ddpdm-report') : __('Not Set', 'ddpdm-report');
            $errdisp  = ini_get('display_errors') != false ? __('On', 'ddpdm-report') : __('Off', 'ddpdm-report');

            $jquchk = wp_script_is('jquery', 'registered') ? $GLOBALS['wp_scripts']->registered['jquery']->ver : __('n/a', 'ddpdm-report');

            $sessenb = isset($_SESSION) ? __('Enabled', 'ddpdm-report') : __('Disabled', 'ddpdm-report');
            $usecck  = ini_get('session.use_cookies') ? __('On', 'ddpdm-report') : __('Off', 'ddpdm-report');
            $hascurl = function_exists('curl_init') ? __('Supports cURL.', 'ddpdm-report') : __('Does not support cURL.', 'ddpdm-report');
            $openssl = extension_loaded('openssl') ? __('OpenSSL installed.', 'ddpdm-report') : __('OpenSSL not installed.', 'ddpdm-report');

            // language

            $site_lang = get_bloginfo('language');
            $site_char = get_bloginfo('charset');
            if (is_rtl()) {
                $site_text_dir = 'rtl';
            } else {
                $site_text_dir = 'ltr';
            }

            // start generating report

            $ddpdm_report = '<div class="ddpdm-system-report-dash">';
            $ddpdm_report .= '<div class="ddpdm-columns">';
            $ddpdm_report .= '<div class="ddpdm-first-column">';
            $ddpdm_report .= '<div id="ddpdm-report">';
            $ddpdm_report .= '<h2>'.__('System Status', 'ddprodm').'</h2><p>'.__('Recommended values ensure compatibility with Divi Theme.', 'ddprodm').'</p>';
            $ddpdm_report .= '<ul><li>'.__('For best results, an amber "warning" notice requires attention.', 'ddprodm').'</li>';
            $ddpdm_report .= '<li>'.__('Ask your hosting company to update the settings for you.', 'ddprodm').'</li></ul>';
            $ddpdm_report .= '<input data-clipboard-action="copy" data-clipboard-target="#ddpdm-report-textarea" id="ddpdm-copy-report" type="button" value="'.__('Copy Report to Clipboard', 'ddprodm').'" class="button button-primary">';
            $ddpdm_report .= '<p id="ddpdm-success-report" class="notice notice-success" style="max-width: 235px; margin-top: 10px; margin-bottom: 0;">'.__('Done: Copied to clipboard', 'ddprodm').'</p>';

            $ddpdm_report .= '<textarea readonly="readonly" id="ddpdm-report-textarea" name="ddpdm-report-textarea" style="width:0; height: 0; margin 0; padding: 0 !important; margin-top: -15px; position: absolute; z-index: -1; ">';
            $ddpdm_report .= '====== BEGIN REPORT ======' . "|";

            $ddpdm_report .= "|" . '--- PLUGIN: ET MARKETPLACE VERSION ---' . "|";
            $ddpdm_report .= "|" . '--- WORDPRESS DATA ---' . "|";
            $ddpdm_report .= 'Multisite:' . " " . $ismulti . "|";
            $ddpdm_report .= 'SITE_URL:' . " " . site_url() . "|";
            $ddpdm_report .= 'HOME_URL:' . " " . home_url() . "|";
            $ddpdm_report .= 'WP Version:' . " " . get_bloginfo('version') . "|";
            $ddpdm_report .= 'Permalink:' . " " . get_option('permalink_structure') . "|";
            $ddpdm_report .= 'Current Theme:' . " " . $theme . "|";
            $ddpdm_report .= 'Parent Theme:' . " " . $parent_theme . "|";

            $ddpdm_report .= "|" . '--- WORDPRESS CONFIG ---' . "|";
            $ddpdm_report .= 'WP_DEBUG:' . " " . $wpdebug . "|";
            $ddpdm_report .= 'WP Memory Limit:' . " " . $this->num_convt(WP_MEMORY_LIMIT) / (1024) . 'MB' . "|";
            $ddpdm_report .= 'jQuery Version:' . " " . $jquchk . "|";
            $ddpdm_report .= 'Site Language:' . " " . $site_lang . "|";
            $ddpdm_report .= 'Site Charset:' . " " . $site_char . "|";
            $ddpdm_report .= 'Site Text Direction:' . " " . $site_text_dir . "|";

            if (is_multisite()):
                $ddpdm_report .= "|" . '--- MULTISITE INFORMATION ---' . "|";
            $ddpdm_report .= 'Total Sites:' . " " . get_blog_count() . "|";
            $ddpdm_report .= 'Base Site:' . " " . $ms_sites[0]['domain'] . "|";
            $ddpdm_report .= 'All Sites:' . "|";
            foreach ($ms_sites as $site):
                    if ($site['path'] != '/') {
                        $ddpdm_report .= " " . '- ' . $site['domain'] . $site['path'] . "|";
                    }
            endforeach;
            $ddpdm_report .= "|";
            endif;

            $ddpdm_report .= "|" . '--- SERVER DATA ---' . "|";
            $ddpdm_report .= 'PHP Version:' . " " . PHP_VERSION . "|";
            if (isset($_SERVER['SERVER_SOFTWARE'])) {
                $ddpdm_report .= 'Server Software:' . " " . sanitize_text_field($_SERVER['SERVER_SOFTWARE']) . "|";
            }

            $ddpdm_report .= "|" . '--- PHP CONFIGURATION ---' . "|";
            $ddpdm_report .= 'Safe Mode:' . " " . $safemode . "|";
            $ddpdm_report .= 'memory_limit:' . " " . ini_get('memory_limit') . "|";
            $ddpdm_report .= 'upload_max_filesize:' . " " . ini_get('upload_max_filesize') . "|";
            $ddpdm_report .= 'post_max_size:' . " " . ini_get('post_max_size') . "|";
            $ddpdm_report .= 'max_execution_time:' . " " . ini_get('max_execution_time') . "|";
            $ddpdm_report .= 'max_input_vars:' . " " . ini_get('max_input_vars') . "|";
            $ddpdm_report .= 'max_input_time:' . " " . ini_get('max_input_time') . "|";
            $ddpdm_report .= 'Display Errors:' . " " . $errdisp . "|";
            $ddpdm_report .= 'Cookie Path:' . " " . esc_html(ini_get('session.cookie_path')) . "|";
            $ddpdm_report .= 'Save Path:' . " " . esc_html(ini_get('session.save_path')) . "|";
            $ddpdm_report .= 'Use Cookies:' . " " . $usecck . "|";
            $ddpdm_report .= 'cURL:' . " " . $hascurl . "|";
            $ddpdm_report .= 'OpenSSL:' . " " . $openssl . "|";

            $ddpdm_report .= "|" . '--- PLUGIN INFORMATION ---' . "|";
            if ($plugins && $mu_plugins):
                $ddpdm_report .= 'Total Plugins:' . " " . (count($plugins) + count($mu_plugins) + count($nt_plugins)) . "|";
            endif;

            // output must-use plugins
            if ($mu_plugins):
                $ddpdm_report .= 'Must-Use Plugins: (' . count($mu_plugins) . ')' . "|";
            foreach ($mu_plugins as $mu_path => $mu_plugin):
                    $ddpdm_report .= "\t" . '- ' . $mu_plugin['Name'] . ' ' . $mu_plugin['Version'] . "|";
            endforeach;
            $ddpdm_report .= "|";
            endif;

            // output active plugins
            if ($plugins):
                $ddpdm_report .= 'Active Plugins: (' . count($active) . ')' . "|";
            foreach ($plugins as $plugin_path => $plugin):
                    if (!in_array($plugin_path, $active)) {
                        continue;
                    }
            $ddpdm_report .= "\t" . '- ' . $plugin['Name'] . ' ' . $plugin['Version'] . "|";
            endforeach;
            $ddpdm_report .= "|";
            endif;

            // output inactive plugins
            if ($plugins):
                $ddpdm_report .= 'Inactive Plugins: (' . (count($plugins) - count($active)) . ')' . "|";
            foreach ($plugins as $plugin_path => $plugin):
                    if (in_array($plugin_path, $active)) {
                        continue;
                    }
            $ddpdm_report .= "\t" . '- ' . $plugin['Name'] . ' ' . $plugin['Version'] . "|";
            endforeach;
            $ddpdm_report .= "|";
            endif;

            // end it all
            $ddpdm_report .= "|" . '====== END REPORT ======';


            $ddpdm_report_for_email = strstr($ddpdm_report, '====== BEGIN REPORT ======');
            //echo  $ddpdm_report_for_email;
            $GLOBALS[ 'ddpdm_report_for_email'] = $ddpdm_report_for_email;
            $ddpdm_report .= '</textarea>';

            $ddpdm_warning_status = '<td class="ddpdm_warning"><span>'.__('Warning', 'ddprodm').'</span></td>';
            $ddpdm_ok_status      = '<td class="ddpdm_ok"><span>'.__('OK', 'ddprodm').'</span></td>';

            $ddpdm_report_table = '';

            $ddpdm_report_table .= '<table class="ddpdm-report-table"><tr><th colspan="4">'.__('Server Environment', 'ddprodm').'</th><tr class="ddpdm-header-row"><td>'.__('Config Option', 'ddprodm').'</td><td>'.__('Recommended Value', 'ddprodm').'</td><td>'.__('Actual Value', 'ddprodm').'</td><td>'.__('Status', 'ddprodm').'</td></tr>';

            $ddpdm_report_table .= '<tr><td>'.__('PHP Version', 'ddprodm').'</td><td>7.4+</td><td>' . PHP_VERSION . '</td>';
            if ((int) substr(str_replace(".", "", PHP_VERSION), 0, 2) >= 74) {
                $ddpdm_php_status = $ddpdm_ok_status;
            } else {
                $ddpdm_php_status = $ddpdm_warning_status;
            }
            $ddpdm_report_table .= $ddpdm_php_status . '</tr>';

            if (isset($_SERVER['SERVER_SOFTWARE'])) {
                $ddpdm_report_table .= '<tr><td>'.__('Server Software', 'ddprodm').'</td><td>-</td><td>' . sanitize_text_field($_SERVER['SERVER_SOFTWARE']) . '</td>' . $ddpdm_ok_status . '</tr>';
            }

            $ddpdm_report_table .= '<tr><td>'.__('Safe Mode', 'ddprodm').'</td><td>'.__('No', 'ddprodm').'</td><td>' . $safemode . '</td>';
            if ($safemode == 'No') {
                $ddpdm_safe_mode_status = $ddpdm_ok_status;
            } else {
                $ddpdm_safe_mode_status = $ddpdm_warning_status;
            }
            $ddpdm_report_table .= $ddpdm_safe_mode_status . '</tr>';

            $ddpdm_report_table .= '<tr><td>'.__('memory_limit', 'ddprodm').'</td><td>256+ MB</td><td>' . ini_get('memory_limit') . 'B</td>';
            if ((int) str_replace("M", "", ini_get('memory_limit')) >= 256) {
                $ddpdm_memory_limit_status = $ddpdm_ok_status;
            } else {
                $ddpdm_memory_limit_status = $ddpdm_warning_status;
            }
            $ddpdm_report_table .= $ddpdm_memory_limit_status . '</tr>';

            $ddpdm_report_table .= '<tr><td>'.__('post_max_size', 'ddprodm').'</td><td>128+ MB</td><td>' . ini_get('post_max_size') . 'B</td>';
            if ((int) str_replace("M", "", ini_get('post_max_size')) >= 128) {
                $ddpdm_post_max_size_status = $ddpdm_ok_status;
            } else {
                $ddpdm_post_max_size_status = $ddpdm_warning_status;
            }
            $ddpdm_report_table .= $ddpdm_post_max_size_status . '</tr>';

            $ddpdm_report_table .= '<tr><td>'.__('max_execution_time', 'ddprodm').'</td><td>180+</td><td>' . ini_get('max_execution_time') . '</td>';
            if ((int) ini_get('max_execution_time') >= 180) {
                $ddpdm_max_execution_time_status = $ddpdm_ok_status;
            } else {
                $ddpdm_max_execution_time_status = $ddpdm_warning_status;
            }
            $ddpdm_report_table .= $ddpdm_max_execution_time_status . '</tr>';

            $ddpdm_report_table .= '<tr><td>'.__('upload_max_filesize', 'ddprodm').'</td><td>64+ MB</td><td>' . ini_get('upload_max_filesize') . 'B</td>';
            if ((int) str_replace("M", "", ini_get('upload_max_filesize')) >= 64) {
                $ddpdm_upload_max_status = $ddpdm_ok_status;
            } else {
                $ddpdm_upload_max_status = $ddpdm_warning_status;
            }
            $ddpdm_report_table .= $ddpdm_upload_max_status . '</tr>';

            $ddpdm_report_table .= '<tr><td>'.__('max_input_time', 'ddprodm').'</td><td>180+</td><td>' . ini_get('max_input_time') . '</td>';
            if ((int) ini_get('max_input_time') >= 180) {
                $ddpdm_max_input_time_status = $ddpdm_ok_status;
            } else {
                $ddpdm_max_input_time_status = $ddpdm_warning_status;
            }
            $ddpdm_report_table .= $ddpdm_max_input_time_status . '</tr>';

            $ddpdm_report_table .= '<tr><td>max_input_vars</td><td>3000+</td><td>' . ini_get('max_input_vars') . '</td>';
            if ((int) ini_get('max_input_vars') >= 3000) {
                $ddpdm_max_input_vars_status = $ddpdm_ok_status;
            } else {
                $ddpdm_max_input_vars_status = $ddpdm_warning_status;
            }
            $ddpdm_report_table .= $ddpdm_max_input_vars_status . '</tr>';

            $ddpdm_report_table .= '<tr><td>'.__('Display Errors', 'ddprodm').'</td><td>'.__('Off', 'ddprodm').'</td><td>' . $errdisp . '</td>';
            if ($errdisp == 'Off') {
                $ddpdm_display_errors_status = $ddpdm_ok_status;
            } else {
                $ddpdm_display_errors_status = $ddpdm_warning_status;
            }
            $ddpdm_report_table .= $ddpdm_display_errors_status . '</tr>';

            $ddpdm_report_table .= '<tr><td>'.__('Cookie Path', 'ddprodm').'</td><td>-</td>' . '<td>' . esc_html(ini_get('session.cookie_path')) . '</td>' . $ddpdm_ok_status . '</tr>';

            $ddpdm_report_table .= '<tr><td>'.__('Save Path', 'ddprodm').'</td><td>-</td>' . '<td>' . esc_html(ini_get('session.save_path')) . '</td>' . $ddpdm_ok_status . '</tr>';

            $ddpdm_report_table .= '<tr><td>'.__('Use Cookies', 'ddprodm').'</td><td>On</td><td>' . $usecck . '</td>';
            if ($usecck == 'On') {
                $ddpdm_use_cookies_status = $ddpdm_ok_status;
            } else {
                $ddpdm_use_cookies_status = $ddpdm_warning_status;
            }
            $ddpdm_report_table .= $ddpdm_use_cookies_status . '</tr>';

            $ddpdm_report_table .= '<tr><td>cURL</td><td>'.__('Supports cURL', 'ddprodm').'</td><td>' . $hascurl . '</td>';
            if ($hascurl == 'Supports cURL.') {
                $ddpdm_curl_status = $ddpdm_ok_status;
            } else {
                $ddpdm_curl_status = $ddpdm_warning_status;
            }
            $ddpdm_report_table .= $ddpdm_curl_status . '</tr>';

            $ddpdm_report_table .= '<th colspan="4">'.__('WordPress Environment', 'ddprodm').'</th></tr><tr class="ddpdm-header-row"><td>'.__('Config Option', 'ddprodm').'</td><td>'.__('Recommended Value', 'ddprodm').'</td><td>'.__('Actual Value', 'ddprodm').'</td><td>'.__('Status', 'ddprodm').'</td></tr>';
            $ddpdm_report_table .= '<tr><td>'.__('Multisite', 'ddprodm').'</td><td>-</td>';
            $ddpdm_report_table .= '<td>' . $ismulti . '</td>' . $ddpdm_ok_status . '</tr>';
            $ddpdm_report_table .= '<td>'.__('Site url', 'ddprodm').'</td><td>-</td>' . '<td>' . site_url() . '</td>' . $ddpdm_ok_status . '</tr>';
            $ddpdm_report_table .= '<td>'.__('Home url', 'ddprodm').'</td><td>-</td>' . '<td>' . home_url() . '</td>' . $ddpdm_ok_status . '</tr>';
            $ddpdm_report_table .= '<td>'.__('WP Version', 'ddprodm').'</td><td>4.2+</td><td>' . get_bloginfo('version') . '</td>';
            if ((int) str_replace(".", "", get_bloginfo('version')) < 42) {
                $wp_version_status = $ddpdm_warning_status;
            } else {
                $wp_version_status = $ddpdm_ok_status;
            }
            $ddpdm_report_table .= $wp_version_status . '</tr>';

            $ddpdm_report_table .= '<td>'.__('Permalink', 'ddprodm').'</td><td>-</td>' . '<td>' . get_option('permalink_structure') . '</td>' . $ddpdm_ok_status . '</tr><tr>';
            $ddpdm_report_table .= '<td>'.__('Current Theme', 'ddprodm').'</td><td>-</td>' . '<td>' . $theme . '</td>' . $ddpdm_ok_status . '</tr><tr>';

            $ddpdm_report_table .= '<td>'.__('Parent Theme', 'ddprodm').'</td><td>Divi 3.7+</td>' . '<td>' . $parent_theme . '</td>';
            if ($style_parent_theme->get('Name') != 'Divi' || (int) str_replace(".", "", $style_parent_theme->get('Version')) < 37) {
                $wp_parent_theme_status = $ddpdm_warning_status;
            } else {
                $wp_parent_theme_status = $ddpdm_ok_status;
            }
            $ddpdm_report_table .= $wp_parent_theme_status . '</tr>';

            $ddpdm_report_table .= '<tr><td>'.__('WP debug', 'ddprodm').'</td><td>'.__('Disabled', 'ddprodm').'</td><td>' . $wpdebug . '</td>';
            if ($wpdebug == 'Disabled') {
                $ddpdm_wpdebug_status = $ddpdm_ok_status;
            } else {
                $ddpdm_wpdebug_status = $ddpdm_warning_status;
            }
            $ddpdm_report_table .= $ddpdm_wpdebug_status . '</tr>';

            $ddpdm_report_table .= '<tr><td>'.__('WP Memory Limit', 'ddprodm').'</td><td>30+ MB</td><td>' . $this->num_convt(WP_MEMORY_LIMIT) / (1024) . ' MB</td>';
            if ($this->num_convt(WP_MEMORY_LIMIT) / (1024) > 30) {
                $ddpdm_wp_memory_status = $ddpdm_ok_status;
            } else {
                $ddpdm_wp_memory_status = $ddpdm_warning_status;
            }
            $ddpdm_report_table .= $ddpdm_wp_memory_status . '</tr>';

            $ddpdm_report_table .= '<tr><td>'.'jQuery Version'.'</td><td>1.1.0+</td><td>' . $jquchk . '</td>';
            if ((int) str_replace(".", "", $jquchk) >= 110) {
                $ddpdm_jquery_status = $ddpdm_ok_status;
            } else {
                $ddpdm_jquery_status = $ddpdm_warning_status;
            }
            $ddpdm_report_table .= $ddpdm_jquery_status . '</tr>';

            $ddpdm_report_table .= '<td>'.__('Site Language', 'ddprodm').'</td><td>-</td>' . '<td>' . $site_lang . '</td>' . $ddpdm_ok_status . '</tr><tr>';

            $ddpdm_report_table .= '<td>'.__('Site Charset', 'ddprodm').'</td><td>-</td>' . '<td>' . $site_char . '</td>' . $ddpdm_ok_status . '</tr><tr>';

            $ddpdm_report_table .= '<td>'.__('Site Text Direction', 'ddprodm').'</td><td>ltr (left-to-right)</td>' . '<td>' . $site_text_dir . '</td>';

            if ($site_text_dir == 'ltr') {
                $ddpdm_mtd_status = $ddpdm_ok_status;
            } else {
                $ddpdm_mtd_status = $ddpdm_warning_status;
            }
            $ddpdm_report_table .= $ddpdm_mtd_status . '</tr>';


            // multisite info
            if (is_multisite()):
                $ddpdm_report_table .= '<th colspan="4">'.__('Multisite', 'ddprodm').'</th></tr><tr class="ddpdm-header-row"><td>'.__('Config Option', 'ddprodm').'</td><td>'.__('Recommended Value', 'ddprodm').'</td><td>'.__('Actual Value', 'ddprodm').'</td><td>'.__('Status', 'ddprodm').'</td></tr>';
            $ddpdm_report_table .= '<tr><td>'.__('Total Sites', 'ddprodm').'</td><td>-</td>';
            $ddpdm_report_table .= '<td>' . get_blog_count() . '</td>' . $ddpdm_ok_status . '</tr>';
            $ddpdm_report_table .= '<td>'.__('Base Site', 'ddprodm').'</td><td>-</td>' . '<td>' . $ms_sites[0]['domain'] . '</td>' . $ddpdm_ok_status . '</tr>';
            $ddpdm_report_table .= '<td colspan="2">'.__('All Sites', 'ddprodm').'</td>' . '<td colspan="2">';
            foreach ($ms_sites as $site):
                    if ($site['path'] != '/') {
                        $ddpdm_report_table .= $site['domain'];
                        $ddpdm_report_table .= $site['path'];
                        $ddpdm_report_table .= "<br/>";
                    }
            endforeach;
            $ddpdm_report_table .= '</td></tr>';
            endif; // is_multisite()

            // output active plugins
            if ($plugins):
                $ddpdm_report_table .= '<th colspan="4">'.__('Active plugins', 'ddprodm').'</th>';

            $ddpdm_report_table .= '<tr><td colspan="2">';
            $ddpdm_report_table .= count($active);
            $ddpdm_report_table .= __(' active plugins', 'ddprodm').'</td><td colspan="2">';
            foreach ($plugins as $plugin_path => $plugin):
                    if (!in_array($plugin_path, $active)) {
                        continue;
                    }
            $ddpdm_report_table .= $plugin['Name'];
            $ddpdm_report_table .= ' ';
            $ddpdm_report_table .= $plugin['Version'];
            $ddpdm_report_table .= "<br>";
            endforeach;
            $ddpdm_report_table .= '</td></tr>';
            endif;

            // output inctive plugins
            if ($plugins):
                $ddpdm_report_table .= '<th colspan="4">'.__('Inactive Plugins', 'ddprodm').'</th>';

            $ddpdm_report_table .= '<tr><td colspan="2">';
            $ddpdm_report_table .= count($plugins) - count($active);
            $ddpdm_report_table .= __(' inactive plugins', 'ddprodm').'</td><td colspan="2">';
            foreach ($plugins as $plugin_path => $plugin):
                    if (in_array($plugin_path, $active)) {
                        continue;
                    }
            $ddpdm_report_table .= $plugin['Name'];
            $ddpdm_report_table .= ' ';
            $ddpdm_report_table .= $plugin['Version'];
            $ddpdm_report_table .= "<br>";
            endforeach;
            $ddpdm_report_table .= '</td></tr></table>';
            endif;

            if (strpos($ddpdm_report_table, $ddpdm_warning_status) !== false) {
                $class   = 'notice notice-warning is-dismissible';
                $message = '<strong>'.__('Action Required:', 'ddprodm').'</strong> '.__('Please review', 'ddprodm').' ';
                $message .= DDPDM_NAME;
                $message .= ' '.__('Plugin system status report. A settings update may be required for best results.', 'ddprodm').' <a href=?page=' . $this->ddpdm_activation_tab_key . '&tab=ddpdm_assistant_system_status>'.__('Go to system status tab', 'ddprodm').'</a>.';

                if ($warning_flag == 1 && PAnD::is_admin_notice_active('disable-ddpdm-system-status-notice-forever') &&  get_option('ddpdm_wl') !== 'enabled') {
                    printf('<div data-dismissible="disable-ddpdm-system-status-notice-forever" class="%1$s"><p>%2$s</p></div>', esc_attr($class), wp_kses($message, $this->ddpdm_allowed_html()));
                }
            }
            $ddpdm_report_end = '</div>'; // ddpdm-column-first
            $ddpdm_report_end = '</div>'; // ddpdm-columns
            $ddpdm_report_end .= '</div>'; // ddpdm-system-status-dash

            return $ddpdm_report . $ddpdm_report_table . $ddpdm_report_end;
        }

        public function ddpdm_getting_started()
        {
            $ddpdm_starting = '';
            $ddpdm_status = get_option('ddpdm_enable');
            if ($ddpdm_status === 'enabled') {
                $ddpdm_starting .= '<iframe id="ondemanIframe" name="ondemandIframe" class="settingsIframe" src="https://ondemand.divi-den.com/search-everything-api-yjdwe3/"></iframe><div class="saving_message"><h3 class="sectionSaved"><div class="lds-roller"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div><span style="display: block !important;">'.__('Taking too long? Try downloading the layout instead, and upload it using Divi Library.', 'ddprodm').'</span></h3><span class="close">&#x2715;</span></div><div class="loaded_message"><h3 class="sectionSaved">'.__('Success! Saved to Divi Library', 'ddprodm').'<br>'.__('The layout or section has been saved to your Divi Library.', 'ddprodm').'<br>'.__('Use the "Add From Library" tab in Divi Builder to load it onto a new page.', 'ddprodm').'</h3><span class="close">&#x2715;</span></div>';
            } else {
                $ddpdm_starting .= '<iframe id="ondemanIframe" name="ondemandIframe" class="settingsIframe" src="https://ondemand.divi-den.com/search-everything-no-api-ewqr5423/"></iframe><div class="saving_message"><h3 class="sectionSaved"><div class="lds-roller"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div></h3><span class="close">&#x2715;</span></div><div class="loaded_message"><h3 class="sectionSaved">'.__('Success! Saved to Divi Library<br>The layout or section has been saved to your Divi Library.<br>Use the "Add From Library" tab in Divi Builder to load it onto a new page.', 'ddprodm').'</h3><span class="close">&#x2715;</span></div>';
            }
            return $ddpdm_starting;
        }

        public function ddpdm_css_changer_files()
        {
            echo '<div class="ddpdm-custom-css-dash">';
            echo '<div class="ddpdm-columns">';
            echo '<div class="ddpdm-first-column">';
            echo '<h2>'.esc_html__('What Are Custom CSS Files?', 'ddprodm').'</h2>';
            echo '<p>'.esc_html__('Some Divi Den Pro DM modules use custom CSS coding for advanced animations and hover effects. With Divi, it’s the only way to make our unique designs. Watch the video for full details.', 'ddprodm').'<p>';
            echo '<iframe width="560" height="315" src="https://seku.re/dm-ddp-advanced-updates" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen class="ddpdm-youtube"></iframe>';
            echo '<p>'.esc_html__('To find specific CSS rules, search for the module name like “Square Reveal Blog”. Next copy the CSS rule > change the rule/code as required > paste the code into the Custom CSS box on the “page” or under Divi theme settings Custom CSS box.', 'ddprodm').'</p>';
            echo '</div>';
            echo '<div class="ddpdm-second-column">';
            echo '<h2>'.esc_html__('Open File In Browser Window', 'ddprodm').'</h2>';
            echo '<div class="ddpdm-custom-css-files">';
            echo '<div class="ddpdm-custom-css-files-col-1">';
			echo '<img class="ddpdm-open-css-img" src="'.esc_url(plugin_dir_url(__FILE__)).'/include/ddpdm-open.png" alt="'.esc_html__('Open CSS File', 'ddpro').'"/>';
            echo '<a class="ddpdm-css-link" target="_blank"  href="https://seku.re/grace-master-css">Grace</a><br>';
            echo '<div class="clearfix"></div>';
            echo '<img class="ddpdm-open-css-img" src="'.esc_url(plugin_dir_url(__FILE__)).'/include/ddpdm-open.png" alt="'.esc_html__('Open CSS File', 'ddprodm').'"/>';
            echo '<a class="ddpdm-css-link" target="_blank"  href="https://seku.re/ragnar-master-css">Ragnar</a><br>';
            echo '<div class="clearfix"></div>';
            echo '<img class="ddpdm-open-css-img" src="'.esc_url(plugin_dir_url(__FILE__)).'/include/ddpdm-open.png" alt="'.esc_html__('Open CSS File', 'ddprodm').'"/>';
            echo '<a class="ddpdm-css-link" target="_blank"  href="https://seku.re/freddie-master-css">Freddie</a><br>';
            echo '<div class="clearfix"></div>';
            echo '<img class="ddpdm-open-css-img" src="'.esc_url(plugin_dir_url(__FILE__)).'/include/ddpdm-open.png" alt="'.esc_html__('Open CSS File', 'ddprodm').'"/>';
            echo '<a class="ddpdm-css-link" target="_blank"  href="https://seku.re/diana-master-css">Diana</a><br>';
            echo '<div class="clearfix"></div>';
            echo '<img class="ddpdm-open-css-img" src="'.esc_url(plugin_dir_url(__FILE__)).'/include/ddpdm-open.png" alt="'.esc_html__('Open CSS File', 'ddprodm').'"/>';
            echo '<a class="ddpdm-css-link" target="_blank"  href="https://seku.re/coco-master-css">Coco</a><br>';
            echo '<div class="clearfix"></div>';
            echo '<img class="ddpdm-open-css-img" src="'.esc_url(plugin_dir_url(__FILE__)).'/include/ddpdm-open.png" alt="'.esc_html__('Open CSS File', 'ddprodm').'"/>';
            echo '<a class="ddpdm-css-link" target="_blank"  href="https://seku.re/pegasus-master-css">Pegasus</a><br>';
            echo '<div class="clearfix"></div>';
            echo '<img class="ddpdm-open-css-img" src="'.esc_url(plugin_dir_url(__FILE__)).'/include/ddpdm-open.png" alt="'.esc_html__('Open CSS File', 'ddprodm').'"/>';
            echo '<a class="ddpdm-css-link" target="_blank"  href="https://seku.re/pixie-master-css">Pixie</a><br>';
            echo '<div class="clearfix"></div>';
            echo '<img class="ddpdm-open-css-img" src="'.esc_url(plugin_dir_url(__FILE__)).'/include/ddpdm-open.png" alt="'.esc_html__('Open CSS File', 'ddprodm').'"/>';
            echo '<a class="ddpdm-css-link" target="_blank"  href="https://seku.re/jamie-master-css">Jamie</a><br>';
            echo '<div class="clearfix"></div>';
            echo '<img class="ddpdm-open-css-img" src="'.esc_url(plugin_dir_url(__FILE__)).'/include/ddpdm-open.png" alt="'.esc_html__('Open CSS File', 'ddprodm').'"/>';
            echo '<a class="ddpdm-css-link" target="_blank"  href="https://seku.re/impi-master-css">Impi</a><br>';
            echo '<div class="clearfix"></div>';
            echo '</div>';
            echo '<div class="ddpdm-custom-css-files-col-2">';
            echo '<img class="ddpdm-open-css-img" src="'.esc_url(plugin_dir_url(__FILE__)).'/include/ddpdm-open.png" alt="'.esc_html__('Open CSS File', 'ddprodm').'"/>';
            echo '<a class="ddpdm-css-link" target="_blank"  href="https://seku.re/tina-master-css">Tina</a><br>';
            echo '<div class="clearfix"></div>';
            echo '<img class="ddpdm-open-css-img" src="'.esc_url(plugin_dir_url(__FILE__)).'/include/ddpdm-open.png" alt="'.esc_html__('Open CSS File', 'ddprodm').'"/>';
            echo '<a class="ddpdm-css-link" target="_blank"  href="https://seku.re/falkor-master-css">Falkor</a><br>';
            echo '<div class="clearfix"></div>';
            echo '<img class="ddpdm-open-css-img" src="'.esc_url(plugin_dir_url(__FILE__)).'/include/ddpdm-open.png" alt="'.esc_html__('Open CSS File', 'ddprodm').'"/>';
            echo '<a class="ddpdm-css-link" target="_blank"  href="https://seku.re/sigmund-master-css">Sigmund</a><br>';
            echo '<div class="clearfix"></div>';
            echo '<img class="ddpdm-open-css-img" src="'.esc_url(plugin_dir_url(__FILE__)).'/include/ddpdm-open.png" alt="'.esc_html__('Open CSS File', 'ddprodm').'"/>';
            echo '<a class="ddpdm-css-link" target="_blank"  href="https://seku.re/mermaid-master-css">Mermaid</a><br>';
            echo '<div class="clearfix"></div>';
            echo '<img class="ddpdm-open-css-img" src="'.esc_url(plugin_dir_url(__FILE__)).'/include/ddpdm-open.png" alt="'.esc_html__('Open CSS File', 'ddprodm').'"/>';
            echo '<a class="ddpdm-css-link" target="_blank"  href="https://seku.re/unicorn-master-css">Unicorn</a><br>';
            echo '<div class="clearfix"></div>';
            echo '<img class="ddpdm-open-css-img" src="'.esc_url(plugin_dir_url(__FILE__)).'/include/ddpdm-open.png" alt="'.esc_html__('Open CSS File', 'ddprodm').'"/>';
            echo '<a class="ddpdm-css-link" target="_blank"  href="https://seku.re/mozart-master-css">Mozart</a><br>';
            echo '<div class="clearfix"></div>';
            echo '<img class="ddpdm-open-css-img" src="'.esc_url(plugin_dir_url(__FILE__)).'/include/ddpdm-open.png" alt="'.esc_html__('Open CSS File', 'ddprodm').'"/>';
            echo '<a class="ddpdm-css-link" target="_blank"  href="https://seku.re/jackson-master-css">Jackson</a><br>';
            echo '<div class="clearfix"></div>';
            echo '<img class="ddpdm-open-css-img" src="'.esc_url(plugin_dir_url(__FILE__)).'/include/ddpdm-open.png" alt="'.esc_html__('Open CSS File', 'ddprodm').'"/>';
            echo '<a class="ddpdm-css-link" target="_blank"  href="https://seku.re/venus-master-css">Venus</a><br>';
            echo '<div class="clearfix"></div>';
            echo '</div>'; //ddpdm-custom-css-files-col-2
            echo '</div>'; //ddpdm-custom-css-files
            echo '</div>'; //ddpdm-second-column
            echo '</div>'; //ddpdm-columns
            echo '</div>'; //ddpdm-custom-css-dash
            return true;
        }

        public function ddpdm_settings_function()
        {

            // determinate the state of each option
            function ddpdm_get_option_state($option)
            {
                $ddpdm_option_template = get_option($option);
                $return_value = '<script>(function ($) {
                    $(".ddpdm-archive-settings .et-epanel-box select#';
                $return_value .= $option;
                $return_value .= ' option[value=';
                $return_value .= $ddpdm_option_template;
                $return_value .= ']").prop("selected", true);';
                $return_value .=  '})(jQuery);</script>';
                return $return_value;
            }

            $ddpdm_settings_content = '<div class="divi-button ddpdm-php-templates ddpdm-sub-tab-dash">';
            $ddpdm_settings_content .=  '<div class="ddpdm-columns">';
            $ddpdm_settings_content .=  '<div class="ddpdm-first-column">';
            $ddpdm_settings_content .= '<p>'.__('Divi Den Pro DM comes with built-in theme builder functionality. It uses the native WordPress customizer to add premade templates like blog archive pages (category, tag, author), navigation menus, sticky bars, pop-ups and more. Get started by first saving the templates you want. Then launch the WordPress customizer to edit and publish.', 'ddprodm').' <a href="';
            if (get_option('ddpdm_wl') == 'enabled') {
                $ddpdm_settings_content .= admin_url('admin.php?page='.DDPDM_LINK.'_dashboard_wl&tab=ddpdm_start_here#ddpdm-theme-builder');
            } else {
                $ddpdm_settings_content .= admin_url('admin.php?page=divi_den_pro_dm_dashboard&tab=ddpdm_start_here#ddpdm-theme-builder');
            }
            $ddpdm_settings_content .=  '">'.__('View tutorial', 'ddprodm').'</a></p>';

            $ddpdm_settings_content .= '<div class="clearfix"></div><a class="button button-primary" href="';

            $ddpdm_settings_content .= get_admin_url();
            $ddpdm_settings_content .='customize.php">'.__('Launch WordPress Customizer', 'ddprodm').'</a><div class="clearfix"></div>';

            $ddpdm_status = get_option('ddpdm_enable');


            if ($ddpdm_status === 'enabled') {
                $ddpdm_settings_content .= '<iframe id="ondemanIframe" name="ondemandIframe" class="settingsIframe" src="https://ondemand.divi-den.com/new-api-search-php-templates-ewr2343/" style="margin-top: 20px; border: 1px solid #bbb;"></iframe><div class="saving_message"><h3 class="sectionSaved"><div class="lds-roller"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div></h3><span class="close">&#x2715;</span></div><div class="loaded_message"><h3 class="sectionSaved">'.__('Success! Saved to Divi Library<br>The layout or section has been saved to your Divi Library.<br>Use the "Add From Library" tab in Divi Builder to load it onto a new page.', 'ddprodm').'</h3><span class="close">&#x2715;</span></div><div class="clearfix"></div></div></div>';
            } else {
                $ddpdm_settings_content .= '<iframe id="ondemanIframe" name="ondemandIframe" class="settingsIframe" src="https://ondemand.divi-den.com/new-no-api-search-php-templates-perb904/" style="margin-top: 20px; border: 1px solid #bbb;"></iframe><div class="clearfix"></div>';
            }

            $ddpdm_settings_content .= '</div></div>';
            return $ddpdm_settings_content;
        } // ddpdm_settings_function

        public function ddpdm_divi_theme_builder_function()
        {
            // determinate the state of each option
            function ddpdm_get_option_state($option)
            {
                $ddpdm_option_template = get_option($option);
                $return_value = '<script>(function ($) {
                    $(".ddpdm-archive-settings .et-epanel-box select#';
                $return_value .= $option;
                $return_value .= ' option[value=';
                $return_value .= $ddpdm_option_template;
                $return_value .= ']").prop("selected", true);';
                $return_value .=  '})(jQuery);</script>';
                return $return_value;
            }

            $ddpdm_divi_theme_builder_content = '<div class="divi-button ddpdm_divi_theme_builder ddpdm-php-templates ddpdm-sub-tab-dash">';
            $ddpdm_divi_theme_builder_content .=  '<div class="ddpdm-columns">';
            $ddpdm_divi_theme_builder_content .=  '<div class="ddpdm-first-column">';
            $ddpdm_divi_theme_builder_content .= '<p>'.__('Divi Theme Builder takes the power of the Divi builder and extends it to all areas of the Divi Theme. Build custom headers, footers, category pages, product templates, blog post templates, 404 pages and more. The Divi Den Pro DM library contains many premade templates for Divi Theme Builder. Get started by first downloading the templates you want. Then launch the Divi > Theme Builder to import, edit and assign.', 'ddprodm').' <a href="';
            if (get_option('ddpdm_wl') == 'enabled') {
                $ddpdm_divi_theme_builder_content .= admin_url('admin.php?page='.DDPDM_LINK.'_dashboard_wl&tab=ddpdm_start_here#ddpdm-divi-theme-builder');
            } else {
                $ddpdm_divi_theme_builder_content .= admin_url('admin.php?page=divi_den_pro_dm_dashboard&tab=ddpdm_start_here#ddpdm-divi-theme-builder');
            }
            $ddpdm_divi_theme_builder_content .=  '">'.__('View tutorial', 'ddprodm').'</a></p>';

            $ddpdm_divi_theme_builder_content .= '<div class="clearfix"></div><a class="button button-primary" href="';

            $ddpdm_divi_theme_builder_content .= get_admin_url();
            $ddpdm_divi_theme_builder_content .='admin.php?page=et_theme_builder">'.__('Launch Divi Theme Builder', 'ddprodm').'</a><div class="clearfix"></div>';

            $ddpdm_status = get_option('ddpdm_enable');


            if ($ddpdm_status === 'enabled') {
                $ddpdm_divi_theme_builder_content .= '<iframe id="ondemanIframe" name="ondemandIframe" class="settingsIframe" src="https://ondemand.divi-den.com/new-download-divi-theme-builder-templates-search-44rdfhfghw/" style="margin-top: 20px; border: 1px solid #bbb;"></iframe><div class="saving_message"><h3 class="sectionSaved"><div class="lds-roller"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div></h3><span class="close">&#x2715;</span></div><div class="loaded_message"><h3 class="sectionSaved">'.__('Success! Saved to Divi Library<br>The layout or section has been saved to your Divi Library.', 'ddprodm').'<br>'.__('Use the "Add From Library" tab in Divi Builder to load it onto a new page.', 'ddprodm').'</h3><span class="close">&#x2715;</span></div><div class="clearfix"></div></div></div>';
            } else {
                $ddpdm_divi_theme_builder_content .= '<iframe id="ondemanIframe" name="ondemandIframe" class="settingsIframe" src="https://ondemand.divi-den.com/new-no-api-search-php-templates-perb904/" style="margin-top: 20px; border: 1px solid #bbb;"></iframe><div class="clearfix"></div>';
            }

            $ddpdm_divi_theme_builder_content .= '</div></div>';

            return $ddpdm_divi_theme_builder_content;
        }

        public function ddpdm_latest_feed_function()
        {
            include_once(ABSPATH . WPINC . '/feed.php');
            if (function_exists('fetch_feed')) {
                $rss_feed = fetch_feed('https://wp-den.com/category/blog/feed/'); // this is the external website's RSS feed URL
                if (!is_wp_error($rss_feed)) : $rss_feed->init();
                $rss_feed->set_output_encoding('UTF-8'); // this is the encoding parameter, and can be left unchanged in almost every case
                $rss_feed->handle_content_type(); // this double-checks the encoding type
               // $rss_feed->enable_cache(false);
                $rss_feed->set_cache_duration(21600); // 21,600 seconds is six hours
                $limit = $rss_feed->get_item_quantity(12); // fetches the 18 most recent RSS feed stories
                $items = $rss_feed->get_items(0, $limit); // this sets the limit and array for parsing the feed
                endif;
            }
            $ddpdm_latest_feed_content = '<div class="divi-button ddpdm_divi_latest_feed">';
            $ddpdm_latest_feed_content .=  '<div class="ddpdm-columns">';
            $ddpdm_latest_feed_content .=  '<div class="ddpdm-first-column">';
            $blocks = $items;
            foreach ($blocks as $block) {
                $ddpdm_feed_link = $block->get_link();
                $ddpdm_latest_feed_content .= '<div class="ddpdm-latest-feed-item"><a href="';
                $ddpdm_latest_feed_content .= $ddpdm_feed_link;
                $ddpdm_latest_feed_content .= '" target="_blank" title="'.__('Open in a new tab', 'ddprodm').'">';
                $ddpdm_latest_feed_content .= '<h3>';
                $ddpdm_latest_feed_content .=  $block->get_title();
                $ddpdm_latest_feed_content .= '</h3>';
                $ddpdm_latest_feed_content .= '<div class="feed-description">';
                $ddpdm_latest_feed_content .=  $block->get_description();
                $ddpdm_latest_feed_content .= '</div></a></div>';
            }

            $ddpdm_latest_feed_content .= '</div></div></div>';
            return $ddpdm_latest_feed_content;
        }

        public function ddpdm_options_function()
        {
            $ddpdm_options_content  =  '<div class="ddpdm-options-dash ddpdm-sub-tab-dash">';
            $ddpdm_options_content .=  '<div class="ddpdm-columns">';
            $ddpdm_options_content .=  '<div class="ddpdm-first-column">';
            $ddpdm_options_content .= '<div class="divi-button ddpdm-php-templates">';
            $ddpdm_options_content .= '<div class="ddpdm-plugin-setting"><p>'.__('Change the order in which the Divi Den Pro DM Library tab is displayed in the Divi Builder interface.', 'ddprodm').'</p><p class="ddpdm_setting_description">'.__('This option gives priority to saved library items. This display order may be more convenient for some users.', 'ddprodm').'</p>';
            $ddpdm_options_content .= '<input type="checkbox" id="ddpdm_plugin_setting_tab_position" name="ddpdm_plugin_setting_tab_position" value="';
            $ddpdm_options_content .=  get_option('ddpdm_plugin_setting_tab_position');
            $ddpdm_options_content .= '"/><label for="ddpdm_plugin_setting_tab_position" id="ddpdm_plugin_setting_tab_position_label">'.__('Move the Divi Den Pro DM tab into the last position.', 'ddprodm').' <em>'.__('Default: Yes', 'ddprodm').'</em></label><br/>';
            $ddpdm_options_content = $ddpdm_options_content.'<img class="ddpdm_setting_image" src="'.plugin_dir_url(__FILE__) . '/img/move-divi-den-pro-dm-version-tab-last.jpg'.'" alt="move-divi-den-pro-tab-into-last-position">';
            $ddpdm_options_content .= '</div>';
            $ddpdm_options_content .= '</div>';  //ddpdm-first-column
            $ddpdm_options_content .= '</div>'; //ddpdm-columns
            $ddpdm_options_content .= '</div>'; //ddpdm-options-dash

            return $ddpdm_options_content;
        }

        public function ddpdm_assistant_help_faq()
        {
            $ddpdm_help_faq  =  '<div class="ddpdm-support-dash">';
            $ddpdm_help_faq .=  '<div class="ddpdm-columns">';
            $ddpdm_help_faq .=  '<div class="ddpdm-first-column">';
            $ddpdm_help_faq .=  '<h2>'.__('Product Support', 'ddprodm').'</h2>';
            $ddpdm_help_faq .= '<a class="ddpdm-support-link" target="_blank" href="https://seku.re/ddprodm-plugin-kb">';
            $ddpdm_help_faq .= '<span class="ddpdm-support-icon"><img src="';
            $ddpdm_help_faq .= plugin_dir_url(__FILE__);
            $ddpdm_help_faq .= 'img/support-icons/ddpdm-online-doc.png" alt="'.__('Online Documentation Icon', 'ddprodm').'"/></span>';
            $ddpdm_help_faq .= '<h3>'.__('Online Documentation', 'ddprodm').'</h3><p>'.__('Knowledge Base Articles', 'ddprodm').'</p></a>';
            $ddpdm_help_faq .= '<div class="clearfix"></div>';

            $ddpdm_help_faq .= '<a class="ddpdm-support-link" target="_blank" href="https://seku.re/yt-tuts-divi-den-pro ">';
            $ddpdm_help_faq .= '<span class="ddpdm-support-icon"><img src="';
            $ddpdm_help_faq .= plugin_dir_url(__FILE__);
            $ddpdm_help_faq .= 'img/support-icons/ddpdm-video.png" alt="'.__('Video Icon', 'ddprodm').'"/></span>';
            $ddpdm_help_faq .= '<h3>'.__('Support Videos', 'ddprodm').'</h3><p>'.__('Browse Our Youtube Channel', 'ddprodm').'</p></a>';
            $ddpdm_help_faq .= '<div class="clearfix"></div>';

            $ddpdm_help_faq .= '<a class="ddpdm-support-link" target="_blank" href="https://seku.re/never-miss-freebie">';
            $ddpdm_help_faq .= '<span class="ddpdm-support-icon"><img src="';
            $ddpdm_help_faq .= plugin_dir_url(__FILE__);
            $ddpdm_help_faq .= 'img/support-icons/ddpdm-newsletter.png" alt="'.__('Newsletter Icon', 'ddprodm').'"/></span>';
            $ddpdm_help_faq .= '<h3>'.__('Never Miss a Freebie or Update', 'ddprodm').'</h3><p>'.__('Newsletter Signup', 'ddprodm').'</p></a>';
            $ddpdm_help_faq .= '<div class="clearfix"></div>';

            $ddpdm_help_faq .= '<a class="ddpdm-support-link" target="_blank" href="https://seku.re/fb-divi-den-pro">';
            $ddpdm_help_faq .= '<span class="ddpdm-support-icon"><img src="';
            $ddpdm_help_faq .= plugin_dir_url(__FILE__);
            $ddpdm_help_faq .= 'img/support-icons/ddpdm-social.png" alt="'.__('Like Icon', 'ddprodm').'"/></span>';
            $ddpdm_help_faq .= '<h3>'.__('Let’s Get Social', 'ddprodm').'</h3><p>'.__('Like our Facebook Page', 'ddprodm').'</p></a>';
            $ddpdm_help_faq .= '<div class="clearfix"></div>';

            $ddpdm_help_faq .= '<a class="ddpdm-support-link" target="_blank" href="https://seku.re/wp-org-divi-den-free">';
            $ddpdm_help_faq .= '<span class="ddpdm-support-icon"><img src="';
            $ddpdm_help_faq .= plugin_dir_url(__FILE__);
            $ddpdm_help_faq .= 'img/support-icons/dd-free.svg" alt="'.__('Like Icon', 'ddprodm').'"/></span>';
            $ddpdm_help_faq .= '<h3>'.__('Free Divi Layouts'.'</h3><p>', 'ddprodm').__('Download the Divi Den Free Plugin from WordPress.org', 'ddprodm').'</p></a>';
            $ddpdm_help_faq .= '<div class="clearfix"></div>';

            $ddpdm_help_faq .= '</div>'; //ddpdm-first-column
            $ddpdm_help_faq .=  '<div class="ddpdm-second-column">';
            $ddpdm_help_faq .= '<h2>'.__('Get Pro Support', 'ddprodm').'</h2><h6 class="ddpdm-note">'.__('Tip: For CSS style issues like changing colors, font size, padding & margins etc. See ', 'ddprodm').'<a href="/wp-admin/admin.php?page=divi_den_pro_dm_dashboard&tab=ddpdm_css">'.__('Custom CSS', 'ddprodm').'</a></h6><iframe id="supportIframe" class="ddpdm-support-frame" src="https://wp-den.com/plugin-dash-support-form-divi-den-pro/?systemreport=' . $GLOBALS['ddpdm_report_for_email'] . '"/></iframe>';
            $ddpdm_help_faq .= '</div>'; //ddpdm-second-column
            $ddpdm_help_faq .= '</div>'; //ddpdm-columns
            $ddpdm_help_faq .= '</div>'; //ddpdm-support-dash
            return $ddpdm_help_faq;
        }

        public function ddpdm_advanced()
        {
            return true;
        }

        public function ddpdm_theme_builder_function()
        {
            return true;
        }

        public function ddpdm_wl()
        {
            $ddpdm_wl =  '<div class="ddpdm-wl-dash ddpdm-sub-tab-dash">';
            $ddpdm_wl .=  '<div class="ddpdm-columns">';
            $ddpdm_wl .=  '<div class="ddpdm-first-column">';
            $ddpdm_wl .= '<h2>'.__('Advanced White Label Settings', 'ddprodm').'</h2>';
            $ddpdm_wl .= '<iframe width="560" height="315" src="https://seku.re/dm-ddp-white-label" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen class="ddpdm-youtube"></iframe>';

            $ddpdm_wl .= '<div class="clear"></div><div class="ddpdm-accordion closed">';
            $ddpdm_wl .= '<div class="ddpdm-accordion-header">';
            $ddpdm_wl .= '<div class="et-epanel-box divi-button"><div class="et-box-title"><h3>'.__('Hide Plugin Name From Left-side Menu', 'ddprodm').' <span>+</span></h3></div><div class="et-epanel-box divi-button"><div class="et-box-content"><input type="checkbox" class="et-checkbox yes_no_button" name="ddpdm_hide_menu" id="ddpdm_hide_menu" style="display: none;" ';
            $ddpdm_option_wl = get_option('ddpdm_hide_menu');
            if ($ddpdm_option_wl == 'enabled') {
                $ddpdm_wl .= 'checked="checked"';
            }
            $ddpdm_wl .= '><div class="et_pb_yes_no_button ';
            if ($ddpdm_option_wl == 'enabled') {
                $ddpdm_wl .= 'et_pb_on_state';
            } else {
                $ddpdm_wl .= 'et_pb_off_state';
            }
            $ddpdm_wl .= '"><!-- .et_pb_on_state || .et_pb_off_state -->
                <span class="et_pb_value_text et_pb_on_value">'.__('Yes', 'ddprodm').'</span>
                <span class="et_pb_button_slider"></span>
                <span class="et_pb_value_text et_pb_off_value">'.__('No', 'ddprodm').'</span>
            </div></div><span class="ddpdm_default">'.__('Default: No', 'ddprodm').'</span>';
            $ddpdm_wl .= '</div><div class="ddpdm-accordion-content"><p class="et-box-subtitle">'.__('Use this option to make your plugin discoverable only from the plugins list.', 'ddprodm').' </p><img src="';
            $ddpdm_wl .= plugin_dir_url(__FILE__);
            $ddpdm_wl .= 'img/hide-plugin-name-left-menu-thumbnail-ddpro.jpg" alt="'.__('Hide Plugin Name From Left-side Menu', 'ddprodm').'"></div></div></div>';

            $ddpdm_wl .= '</div><div class="clear"></div><div class="ddpdm-accordion closed">';
            $ddpdm_wl .= '<div class="ddpdm-accordion-header">';
            $ddpdm_wl .= '<div class="et-epanel-box divi-button"><div class="et-box-title"><h3>'.__('Hide Plugin Panels from Customizer', 'ddprodm').' <span>+</span></h3></div><div class="et-box-content"><input type="checkbox" class="et-checkbox yes_no_button" name="ddpdm_hide_customizer" id="ddpdm_hide_customizer" style="display: none;" ';
            $ddpdm_option_wl = get_option('ddpdm_hide_customizer');
            if ($ddpdm_option_wl == 'enabled') {
                $ddpdm_wl .= 'checked="checked"';
            }
            $ddpdm_wl .= '><div class="et_pb_yes_no_button ';
            if ($ddpdm_option_wl == 'enabled') {
                $ddpdm_wl .= 'et_pb_on_state';
            } else {
                $ddpdm_wl .= 'et_pb_off_state';
            }
            $ddpdm_wl .= '"><!-- .et_pb_on_state || .et_pb_off_state -->
                <span class="et_pb_value_text et_pb_on_value">'.__('Yes', 'ddprodm').'</span>
                <span class="et_pb_button_slider"></span>
                <span class="et_pb_value_text et_pb_off_value">'.__('No', 'ddprodm').'</span>
            </div></div><span class="ddpdm_default">'.__('Default: No', 'ddprodm').'</span></div><div class="ddpdm-accordion-content"><p class="et-box-subtitle">'.__('Use this option to hide plugin\'s panel from WordPress Customizer', 'ddprodm').'</p><img src="';
            $ddpdm_wl .= plugin_dir_url(__FILE__);
            $ddpdm_wl .= 'img/hide-plugin-name-customizer-thumbnail-ddpro.jpg" alt="'.__('Hide Plugin Name From Left-side Menu', 'ddprodm').'"></div>';

            $ddpdm_wl .= '</div></div><div class="clear"></div><div class="ddpdm-accordion closed">';
            $ddpdm_wl .= '<div class="ddpdm-accordion-header">';
            $ddpdm_wl .= '<div class="et-epanel-box divi-button"><div class="et-box-title"><h3>'.__('Hide Elegant Themes Divi Premade Layouts Tab', 'ddprodm').' <span>+</span></h3></div><div class="et-box-content"><input type="checkbox" class="et-checkbox yes_no_button" name="ddpdm_hide_premade" id="ddpdm_hide_premade" style="display: none;" ';
            $ddpdm_option_wl = get_option('ddpdm_hide_premade');
            if ($ddpdm_option_wl == 'enabled') {
                $ddpdm_wl .= 'checked="checked"';
            }
            $ddpdm_wl .= '><div class="et_pb_yes_no_button ';
            if ($ddpdm_option_wl == 'enabled') {
                $ddpdm_wl .= 'et_pb_on_state';
            } else {
                $ddpdm_wl .= 'et_pb_off_state';
            }
            $ddpdm_wl .= '"><!-- .et_pb_on_state || .et_pb_off_state -->
                <span class="et_pb_value_text et_pb_on_value">'.__('Yes', 'ddprodm').'</span>
                <span class="et_pb_button_slider"></span>
                <span class="et_pb_value_text et_pb_off_value">'.__('No', 'ddprodm').'</span>
            </div></div><span class="ddpdm_default">'.__('Default: No', 'ddprodm').'</span></div><div class="ddpdm-accordion-content"><p class="et-box-subtitle">'.__('Don\'t show Elegant Themes free Premade layouts to WordPress admin users.', 'ddprodm').'</p><img src="';
            $ddpdm_wl .= plugin_dir_url(__FILE__);
            $ddpdm_wl .= 'img/hide-divi-premade-layouts-tab-thumb-ddpro.jpg" alt="'.__('Hide Elegant Themes Divi Premade Layouts Tab', 'ddprodm').'"></div><div class="clear"></div></div></div>';
            $ddpdm_wl .= '<p class="submit ddpdm_wl save_settings"><input type="submit" name="submit" id="submit" class="button button-primary" value="'.__('Save Settings Only', 'ddprodm').'"><span class="fields_empty">'.__('One or more required fields are empty', 'ddprodm').'</span></p>';
            $ddpdm_wl .= '<div class="clear"></div></div>'; // ddpdm-first-column

            $ddpdm_wl .= '<div class="ddpdm-second-column">';
            $ddpdm_wl .= '<div class="ddpdm_wl_settings"><h2>'.__('Branding and Naming', 'ddprodm').'</h2>';
            $ddpdm_wl .= '<p>'.__('Use the white label options here to customise the Divi Den Pro DM plugin to match your brand. Create a good first impression with your customers.', 'ddprodm').'</p>';
            $ddpdm_wl .= '<table class="form-table ddpdm_wl"><colgroup><col width="25%" /></colgroup><tr>
                            <th>'.__('Plugin Name (required)', 'ddprodm').'<div class="ddpdm-info-icon"><span class="dashicons dashicons-info"></span></div><span>'.__('Choose a plugin name that matches your company or brand. Short names look better when displayed in the left-side WordPress menu.', 'ddprodm').'</span><span style="font-weight: 500 !important;">'.__('Special characters (@#$%"&*\') are not allowed.', 'ddprodm').'</span></th>
                            <td><label>
                    <input style="padding: 6px;" placeholder="';
            $ddpdm_wl .= DDPDM_NAME;
            $ddpdm_wl .= '" type="text" name="ddpdm_plugin_name" value="';
            $ddpdm_wl .= get_option('ddpdm_plugin_name');
            $ddpdm_wl .= '" />
                    </label></td>
                        </tr>
                        <tr>
                            <th>'.__('Plugin URL (required)', 'ddprodm').'<div class="ddpdm-info-icon"><span class="dashicons dashicons-info"></span></div><span>'.__('WordPress requires all plugins to list an active link. You can link to your contact page for example or another page on your website.', 'ddprodm').' <strong>'.__('This link must be different from the author url listed below.', 'ddprodm').'</strong></span></th>
                            <td><label>
                    <input style="padding: 6px;" placeholder="https://plugin-url.com/" type="text" name="ddpdm_plugin_url" value="';
            $ddpdm_wl .= get_option('ddpdm_plugin_url');
            $ddpdm_wl .= '" />
                    </label></td>
                        </tr>
                        <tr>
                            <th>'.__('Plugin Icon (optional)', 'ddprodm').'<div class="ddpdm-info-icon"><span class="dashicons dashicons-info"></span></div><span>'.__('This icon is displayed in the left-side menu.', 'ddprodm').' <strong>'.'It must be 36px by 36px and a .png file with a transparent background.'.'</strong> '.__('You can use the default icon we made for you. Or upload your own.', 'ddprodm').' </span></th>
                            <td><label>
                    <input style="padding: 6px;" placeholder="/wp-content/plugins/ddprodm/include/ddpdm-icon.png" type="text" name="ddpdm_plugin_icon" value="';
            $ddpdm_wl .= get_option('ddpdm_plugin_icon');
            $ddpdm_wl .= '" />
                    </label></td>
                        </tr>
                        <tr>
                            <th>'.__('Plugin Author Name(required)', 'ddprodm').'<div class="ddpdm-info-icon"><span class="dashicons dashicons-info"></span></div><span>'.__('Choose an author name that matches your company or brand. Short names generally look better. This name is displayed in the plugins list.', 'ddprodm').'</span></th>
                            <td><label>
                    <input style="padding: 6px;" placeholder="Divi Den" type="text" name="ddpdm_plugin_author" value="';
            $ddpdm_wl .= get_option('ddpdm_plugin_author');
            $ddpdm_wl .= '" />
                    </label></td>
                        </tr>
                        <tr>
                            <th>'.__('Author URL (required)', 'ddprodm').'<div class="ddpdm-info-icon"><span class="dashicons dashicons-info"></span></div><span>'.__('WordPress requires all plugins to list an active author link. Here you can link to your website homepage another page on your website.', 'ddprodm').' <strong>'.__('This link must be different from the plugin url listed above.', 'ddprodm').'</strong></span></th>
                            <td><label>
                    <input style="padding: 6px;" placeholder="https://author-url.com/" type="text" name="ddpdm_plugin_author_url" value="';
            $ddpdm_wl .= get_option('ddpdm_plugin_author_url');
            $ddpdm_wl .= '" />
                    </label></td>
                        </tr>
                        <tr>
                            <th>'.__('Write a Helpful Plugin Description (required)', 'ddprodm').'<div class="ddpdm-info-icon"><span class="dashicons dashicons-info"></span></div><span>'.__('Here you can justify the purpose of this plugin. The description is displayed in the plugins list. Write the description in such a way that people understand what the plugin is for. And why they should not deactivate or delete the plugin. You can use the default description if you like. <strong>Maximum characters recommended: 400. Please do not use special characters like @#$%^&*', 'ddprodm').'</strong></span></th>
                            <td><label>
                    <textarea style="padding: 6px; height: 130px;" placeholder="'.__('Huge layout library made for Elegant Themes’ Divi Marketplace. Search the cloud library for page layouts, sections and modules. Build beautiful websites at twice the speed', 'ddprodm').'" name="ddpdm_plugin_desc">';
            $ddpdm_wl .= (stripslashes(html_entity_decode(get_option('ddpdm_plugin_desc'))));


            $ddpdm_wl .= '</textarea></label></td></tr><tr><td>';
            $ddpdm_wl .= '<p class="submit ddpdm_wl save_settings"><input type="submit" name="submit" id="submit" class="button button-primary" value="Save Settings Only"><span class="fields_empty">'.__('One or more required fields are empty', 'ddprodm').'</span></p></td></tr>';
            $ddpdm_wl .= '</table>';
            $ddpdm_wl .= '<table class="form-table ddpdm_wl ddpdm_wl_home_screen"><colgroup><col width="25%" /></colgroup><tr><th><h2 style="margin-bottom: 0;">'.__('Customer Contact Page', 'ddprodm').' </h2></th><td></td></tr>
            <tr id="wp-ddpdm-column"><th>'.__('Design Your White Label Plugin Homescreen', 'ddprodm').' <span class="ddpdm-span-always-show">'.__('This is the home screen your customers will see when white label mode is activated. Only this page will be visible to them and nothing else. Use this page to add your logo, name, instructions or whatever you want to say.', 'ddprodm').'</span></th><td>';
            $settings = array(
                'textarea_rows' => 10,
                'quicktags' => true
            );
            $ddpdm_wl .= wp_editor(stripslashes(html_entity_decode(get_option('ddpdm_wp_content'))), 'ddpdm_wp_content', $settings);
            $ddpdm_wl .= '</td><td class="ddpdm-save-buttons">';
            $ddpdm_wl .= '<p class="submit ddpdm_wl save_settings"><input type="submit" name="submit" id="submit" class="button button-primary" value="'.__('Save Settings Only', 'ddprodm').'"><span class="fields_empty">'.__('One or more required fields are empty', 'ddprodm').'</span></p>';
            $ddpdm_wl .='<input type="button" name="ddpdm-preview" id="ddpdm-preview" class="button button-primary" value="'.__('Preview the Homescreen', 'ddprodm').'"/></td></tr></table>';
            $ddpdm_wl .= '</div>'; // ddpdm_wl_settings
            $ddpdm_wl .= '</div>'; // ddpdm-second-column


            $ddpdm_wl .= '<div class="ddpdm-third-column">';
            $ddpdm_option_wl = get_option('ddpdm_wl');
            $ddpdm_wl .= '<hr style="clear: both;"><div class="ddpdm_wl_text_2"><h2>'.__('Control White Label Mode', 'ddprodm').'</h2><p><strong><i>'.__('What happens when I activate white label mode?', 'ddprodm').'</i></strong></p><ul><li>'.__('All features, functions & layouts become hidden.', 'ddprodm').'</li><li>'.__('Only the white label plugin homescreen is visible to website admins.', 'ddprodm').'</li></ul><p><strong><i>'.__('How do I deactivate white label mode?', 'ddprodm').'</i></strong></p><ul><li>'.__('Note that deactivating the Divi Den Pro DM plugin, does not deactivate white label mode. You must first use the secret admin url.', 'ddprodm').'</li><li>'.__('The secret admin url is automatically generated by combining your chosen plugin name and a suffix "_wl".', 'ddprodm').'</li><li>'.__('It looks like this (note the <strong>“_wl”</strong> at the end):', 'ddprodm').'</li></ul></strong><p class="secret_url"><i><span class="new_admin_url"></span></i></p></div><br>';
            $ddpdm_wl .= '<p class="submit ddpdm_wl"><input id="submit_wl_pop_up" name="submit_wl" type="submit" class="button button-primary submit_wl ';
            if ($ddpdm_option_wl == 'enabled') {
                $ddpdm_wl .= 'submit_wl_enabled" value="'.__('(ON) Deactivate White Label Mode', 'ddprodm').'">';
            } else {
                $ddpdm_wl .= 'submit_wl_disabled" value="'.__('(OFF) Activate White Label Mode', 'ddprodm').'">';
            }
            $ddpdm_wl .= '<span class="fields_empty">'.__('One or more required fields are empty', 'ddprodm').'</span></p>';
            $ddpdm_wl .= '<div class="ddpdm_wl_hidden"><div class="et-box-title"><h3>'.__('Activate White Label Mode', 'ddprodm').'</h3></div><div class="et-epanel-box divi-button"><div class="et-box-content"><input type="checkbox" class="et-checkbox yes_no_button" name="ddpdm_wl" id="ddpdm_wl" style="display: none;"';
            if ($ddpdm_option_wl == 'enabled') {
                $ddpdm_wl .= 'checked="checked"';
            }
            $ddpdm_wl .= '><div class="et_pb_yes_no_button ';

            if ($ddpdm_option_wl == 'enabled') {
                $ddpdm_wl .= 'et_pb_on_state';
            } else {
                $ddpdm_wl .= 'et_pb_off_state';
            }
            $ddpdm_wl .= '"><!-- .et_pb_on_state || .et_pb_off_state -->
                <span class="et_pb_value_text et_pb_on_value">'.__('Yes', 'ddprodm').'</span>
                <span class="et_pb_button_slider"></span>
                <span class="et_pb_value_text et_pb_off_value">'.__('No', 'ddprodm').'</span>
            </div></div><span class="ddpdm_default">'.__('Default: No', 'ddprodm').'</span></div></div>';

            // Submit pop-up
            $ddpdm_wl .= '<div id="ddpdm-wl-pop-up" class="ddpdm-preview-window"><div class="ddpdm_wl_contact_page">';
            $ddpdm_wl .= '<div id="ddpdm-wl-pop-up-close">&times;</div>';

            if ($ddpdm_option_wl !== 'enabled') {
                $ddpdm_wl .= '<h2>'.__('Confirm White Label Activation', 'ddprodm').'</h2>';
                $ddpdm_wl .= '<h3>'.__('Step 1', 'ddprodm').'</h3><p>'.__('Copy and save your secret admin url. You will need it later.', 'ddprodm').'</p>';
                $ddpdm_wl .= '<p class="secret_url"><strong><span class="new_admin_url" id="new_admin_url"></span></strong></p>';
                $ddpdm_wl .= '<input data-clipboard-action="copy" data-clipboard-target="#new_admin_url" id="ddpdm-copy-url" type="button" value="'.__('Copy Url to Clipboard', 'ddprodm').'" class="button button-primary">';
                $ddpdm_wl .= '<p id="ddpdm-success-url" class="notice notice-success" style="max-width: 235px; margin-top: 10px; margin-bottom: 0;">'.__('Done: Copied to clipboard', 'ddprodm').'</p>';
                $ddpdm_wl .= '<br/><br/><br/><br/><h3>'.__('Step 2', 'ddprodm').'</h3>';
            } else {
                $ddpdm_wl .= '<h2>'.__('Deactivate White Label Mode', 'ddprodm').'</h2>';
                $ddpdm_wl .= '<p>'.__('Return the Divi Den Pro DM interface to its non-white-labelled state. All menus, features and layouts will become visible again to admin users.', 'ddprodm').' </p>';
            }

            $ddpdm_wl .= '<p class="submit ddpdm_wl"><input type="submit" name="submit_wl" id="submit_wl" class="button button-primary submit_wl ';
            if ($ddpdm_option_wl == 'enabled') {
                $ddpdm_wl .= 'submit_wl_enabled" value="'.__('Deactivate now', 'ddprodm').'">';
            } else {
                $ddpdm_wl .= 'submit_wl_disabled" value="'.__('Activate now', 'ddprodm').'">';
            }
            $ddpdm_wl .= '<input type="button" id="ddpdm-wl-pop-up-close-cancel" class="button button-primary" value="'.__('Cancel', 'ddprodm').'"/>';
            // Home Page Preview
            $ddpdm_wl .= '<div id="ddpdm-preview-window" class="ddpdm-preview-window"><div class="ddpdm_wl_contact_page"><div id="ddpdm-preview-close">&times;</div>';

            $ddpdm_wl .=  stripslashes(html_entity_decode(get_option('ddpdm_wp_content')));

            $ddpdm_wl .= '</div>'; //ddpdm-third-column
            $ddpdm_wl .= '</div>'; //ddpdm-columns
            $ddpdm_wl .= '</div>'; //ddpdm-support-dash
            $ddpdm_wl .=  '</div></div>';
            return $ddpdm_wl;
        } // public function ddpdm_wl()


        // Draw wl feedback/contact page
        public function ddpdm_wl_config_page()
        {
            echo '<div class="ddpdm_wl_contact_page">';
            echo wp_kses(stripslashes(html_entity_decode(get_option('ddpdm_wp_content'))), $this->ddpdm_allowed_html());
            echo '</div>';
            return true;
        }


        // Draw option page
        public function ddpdm_config_page()
        {
            $this->ddpdm_report_data($warning_flag = 1);

            $ddpdm_current_sub_status = $this->ddpdm_return_subscription_status();

            if (get_option('ddpdm_wl') == 'enabled') {
                $ddpdm_wl_tab_title = __('White Label Mode <span style="color: #76F546">(ON)</span>', 'ddprodm');
            } else {
                $ddpdm_wl_tab_title = __('White Label Mode <span style="color: #FF2E72">(OFF)</span>', 'ddprodm');
            }

            $settings_tabs = array(
                'ddpdm_assistant_getting_started' => __('Layout Finder', 'ddprodm'),
                'ddpdm_latest_feed' => __('Latest', 'ddprodm'),
                'ddpdm_start_here' => __('Tutorials', 'ddprodm'),
                'ddpdm_theme_builder' => __('Theme Builder', 'ddprodm'),
                'ddpdm_css' => __('Custom CSS Files', 'ddprodm'),
                'ddpdm_assistant_help_faq' => 'Support',
                'ddpdm_assistant_system_status' => __('System Status', 'ddprodm'),
                'ddpdm_advanced' => __('Advanced', 'ddprodm'),
                'ddpdm_divi_theme_builder' => __('Divi Theme Builder', 'ddprodm'),
                'ddpdm_settings' => __('Plugin Theme Builder', 'ddprodm'),
                'ddpdm_wl' => $ddpdm_wl_tab_title,
                'ddpdm_options' => __('More Options', 'ddprodm'),
            );

            switch ($ddpdm_current_sub_status) {
                case 100: // sub expired
                    $settings_tabs_first = array('ddpdm_subscription_expired' => __('Access Expired', 'ddprodm'));
                    $settings_tabs = $settings_tabs_first  + $settings_tabs;
                    if (isset($_GET['tab'])) { // phpcs:ignore
                        $current_tab = $tab = sanitize_text_field($_GET['tab']); // phpcs:ignore
                    } else {
                        $current_tab = $tab = 'ddpdm_subscription_expired';
                    }
                    break;
                case 200: // sub active
                    if (isset($_GET['tab'])) { // phpcs:ignore
                        $current_tab = $tab = sanitize_text_field($_GET['tab']); // phpcs:ignore
                    } else {
                        $current_tab = $tab = 'ddpdm_assistant_getting_started';
                    }
                    break;
                case 300: // no billing record
                    $settings_tabs_first = array('ddpdm_missing_order' => __('Missing Order', 'ddprodm'));
                    $settings_tabs = $settings_tabs_first  + $settings_tabs;
                    if (isset($_GET['tab'])) { // phpcs:ignore
                        $current_tab = $tab = sanitize_text_field($_GET['tab']); // phpcs:ignore
                    } else {
                        $current_tab = $tab = 'ddpdm_missing_order';
                    }
                    break;
                case 400: // api key not found
                    $settings_tabs_first = array('ddpdm_key_not_found' => __('API Key Not Valid', 'ddprodm'));
                    $settings_tabs = $settings_tabs_first  + $settings_tabs;
                    if (isset($_GET['tab'])) { // phpcs:ignore
                        $current_tab = $tab = sanitize_text_field($_GET['tab']); // phpcs:ignore
                    } else {
                        $current_tab = $tab = 'ddpdm_key_not_found';
                    }
                    break;
                case 500: // api key disabled
                    $settings_tabs_first = array('ddpdm_key_disabled' => __('API Key Disabled', 'ddprodm'));
                    $settings_tabs = $settings_tabs_first  + $settings_tabs;
                    if (isset($_GET['tab'])) { // phpcs:ignore
                        $current_tab = $tab = sanitize_text_field($_GET['tab']); // phpcs:ignore
                    } else {
                        $current_tab = $tab = 'ddpdm_key_disabled';
                    }
                    break;
                case 600: // api key is empty
                    $settings_tabs_first = array('ddpdm_empty_key' => __('Missing API Key', 'ddprodm'));
                    $settings_tabs = $settings_tabs_first  + $settings_tabs;
                    if (isset($_GET['tab'])) { // phpcs:ignore
                        $current_tab = $tab = sanitize_text_field($_GET['tab']); // phpcs:ignore
                    } else {
                        $current_tab = $tab = 'ddpdm_empty_key';
                    }
                    break;
                case 0: // default error
                    $settings_tabs_first = array('ddpdm_general_api_error' => __('General Error', 'ddprodm'));
                    $settings_tabs = $settings_tabs_first  + $settings_tabs;
                    if (isset($_GET['tab'])) { // phpcs:ignore
                        $current_tab = $tab = sanitize_text_field($_GET['tab']); // phpcs:ignore
                    } else {
                        $current_tab = $tab = 'ddpdm_general_api_error';
                    }
                    break;
            } ?>
            <div class='wrap ddpdm-assistant <?php
            echo esc_html(strtolower(get_option($this->ddpdm_activated_key)));
            if (get_option('ddpdm_subscription_expired') === 'yes') {
                echo ' expired';
            }

            if (!empty($license_status['status_check']) && $license_status['status_check'] === 'inactive') {
                echo ' inactive_expired';
            } ?>'>
            <h1><img class="ddpdm-logo" src="<?php echo esc_url(plugin_dir_url(__FILE__)) . 'include/ddpdm-logo.svg'?>" alt="<?php echo esc_html__('Divi Den Pro DM Logo'); ?>"><span>Divi Den Pro DM</span><a href="https://seku.re/dm-divi-den-pro" target="_blank" title="<?php echo esc_html__('Go to Marketplace Product Page'); ?>"><img class="marketplace-logo" src="<?php echo esc_url(plugin_dir_url(__FILE__)) . 'include/marketplace-logo.jpg'?>" alt="<?php echo esc_html__('Marketplace Logo'); ?>"></a>
                    <?php  if (get_option('ddpdm_wl') == 'enabled') {
                echo '<span class="notice notice-success ddpdm-wl-mode-active">'.esc_html__('STATUS: White label mode is active.', 'ddprodm').' <a class="ddpdm-wl-mode-active-url" href=?page=' . esc_attr($this->ddpdm_activation_tab_key_wl) . '&tab=ddpdm_wl>'.esc_html__('Change', 'ddprodm').'</a></span>';
            } ?></h1>
            <h2 class="nav-tab-wrapper">
                <?php
                foreach ($settings_tabs as $tab_page => $tab_name) {
                    $active_tab = $current_tab == $tab_page ? 'nav-tab-active' : '';
                    if (get_option('ddpdm_wl') == 'enabled') {
                        echo '<a class="nav-tab ' . esc_attr($tab_page) . ' ' . esc_attr($active_tab) . '" href="?page=' . esc_attr($this->ddpdm_activation_tab_key_wl) . '&tab=' . esc_attr($tab_page) . '">' . wp_kses($tab_name, $this->ddpdm_allowed_html()) . '</a>';
                    } else {
                        echo '<a class="nav-tab ' . esc_attr($tab_page) . ' ' . esc_attr($active_tab) . '" href="?page=' . esc_attr($this->ddpdm_activation_tab_key) . '&tab=' . esc_attr($tab_page) . '">' . wp_kses($tab_name, $this->ddpdm_allowed_html()) . '</a>';
                    }
                } ?>
            </h2>
            <form action='options.php' method='post'>
            <div class="main">
            <?php
            if (isset($tab)) {
                if ($tab == 'ddpdm_assistant_system_status') {
                    echo $this->ddpdm_report_data($warning_flag = 0); // phpcs:ignore
                } elseif ($tab == 'ddpdm_assistant_getting_started' && get_option($this->ddpdm_activated_key) == 'Activated') {
                    echo wp_kses($this->ddpdm_getting_started(), $this->ddpdm_allowed_html());
                } elseif ($tab == 'ddpdm_assistant_help_faq') {
                    echo wp_kses($this->ddpdm_assistant_help_faq(), $this->ddpdm_allowed_html());
                } elseif ($tab == 'ddpdm_wl' && get_option($this->ddpdm_activated_key) == 'Activated') {
                    echo $this->ddpdm_wl(); // phpcs:ignore
                } elseif ($tab == 'ddpdm_css' && get_option($this->ddpdm_activated_key) == 'Activated') {
                    $this->ddpdm_css_changer_files();
                } elseif ($tab == 'ddpdm_subscription_expired') {
                    echo wp_kses($this->ddpdm_subscription_expired(), $this->ddpdm_allowed_html());
                } elseif ($tab == 'ddpdm_missing_order') {
                    echo wp_kses($this->ddpdm_missing_order(), $this->ddpdm_allowed_html());
                } elseif ($tab == 'ddpdm_empty_key') {
                    echo wp_kses($this->ddpdm_empty_key(), $this->ddpdm_allowed_html());
                } elseif ($tab == 'ddpdm_key_not_found') {
                    echo wp_kses($this->ddpdm_key_not_found(), $this->ddpdm_allowed_html());
                } elseif ($tab == 'ddpdm_key_disabled') {
                    echo wp_kses($this->ddpdm_key_disabled(), $this->ddpdm_allowed_html());
                } elseif ($tab == 'ddpdm_general_api_error') {
                    echo wp_kses($this->ddpdm_general_api_error(), $this->ddpdm_allowed_html());
                } elseif ($tab == 'ddpdm_start_here') {
                    echo wp_kses($this->ddpdm_start_here_function(), $this->ddpdm_allowed_html());
                } elseif ($tab == 'ddpdm_divi_theme_builder') {
                    echo wp_kses($this->ddpdm_divi_theme_builder_function(), $this->ddpdm_allowed_html());
                } elseif ($tab == 'ddpdm_settings') {
                    echo wp_kses($this->ddpdm_settings_function(), $this->ddpdm_allowed_html());
                } elseif ($tab == 'ddpdm_options') {
                    echo $this->ddpdm_options_function(); // phpcs:ignore
                    //wp_kses($this->ddpdm_options_function(), ddpdm_allowed_html());
                } elseif ($tab == 'ddpdm_advanced') {
                } elseif ($tab == 'ddpdm_theme_builder') {
                } elseif ($tab == 'ddpdm_latest_feed') {
                    echo wp_kses($this->ddpdm_latest_feed_function(), $this->ddpdm_allowed_html());
                }
            }//if(isset($tab)) {?>
            </div>
            </form>
            </div>
            <?php
        }

        public function ddpdm_subscription_expired()
        {
            $ddpdm_sp = '';
            $ddpdm_sp .= '<div class="ddpdm_subscription_expired_page"><div class="ddpdm-columns"><div class="ddpdm-first-column"><h2>'.__('Your', 'ddprodm').' '.esc_html(DDPDM_NAME).' '.__('access has expired', 'ddprodm').'</h2>';

            $ddpdm_sp = $ddpdm_sp.'<img src="'.plugin_dir_url(__FILE__) . '/include/ddpdm-paused.png'.'" alt="">';
            $ddpdm_sp .= '<h3>'.__('We miss you like crazy', 'ddprodm').'</h3>';
            $ddpdm_sp .= '<p>'.__('To get access to all new layouts, support and updates, please renew your', 'ddprodm').' '. esc_html(DDPDM_NAME).' '.__('access at the  Elegant Themes Divi Marketplace.', 'ddprodm').'</p>';
            $ddpdm_sp .= '<p>'.__('Note: A', 'ddprodm').' '. esc_html(DDPDM_NAME).' '.__('purchase is automatically linked to your Elegant Themes API key. Use an API key from the same Elegant Themes account in which', 'ddprodm').' '. esc_html(DDPDM_NAME).' '.'was purchased'.'.</p>';
            $ddpdm_sp .= '<a href="https://seku.re/dm-divi-den-pro" target="_blank" class="button button-primary">'.__('Renew Access', 'ddprodm').'</a></div></div></div>';

            return $ddpdm_sp;
        }

        public function ddpdm_missing_order()
        {
            $ddpdm_sp = '';
            $ddpdm_sp .= '<div class="ddpdm_subscription_expired_page"><div class="ddpdm-columns"><div class="ddpdm-first-column"><h2>'.__('Oh dear. We could not verify your', 'ddprodm').' '.esc_html(DDPDM_NAME).' '.__('purchase', 'ddprodm').'</h2>';

            $ddpdm_sp .='<img src="'.plugin_dir_url(__FILE__) . '/include/ddpdm-paused.png'.'" alt="">';
            $ddpdm_sp .= '<h3>'.__('An active', 'ddprodm').' '.esc_html(DDPDM_NAME).' '.__('order is required', 'ddprodm').'</h3>';

            $ddpdm_sp .= '<p>'.__('To get access to all new layouts, support and updates, please buy/renew access to', 'ddprodm').' '. esc_html(DDPDM_NAME).' '.__('at the Elegant Themes Divi Marketplace', 'ddprodm').'.</p>';
            $ddpdm_sp .= '<p>'.__('Note: A', 'ddprodm').' '. esc_html(DDPDM_NAME).' '.__('purchase is automatically linked to your Elegant Themes API key. Use an API key from the same Elegant Themes account in which', 'ddprodm').' '. esc_html(DDPDM_NAME).' '.'was purchased'.'.</p>';
            $ddpdm_sp .= '<a href="https://seku.re/dm-divi-den-pro" target="_blank" class="button button-primary">'.__('Buy/renew', 'ddprodm').' '. esc_html(DDPDM_NAME).'</a></div></div></div>';

            return $ddpdm_sp;
        }

        public function ddpdm_empty_key()
        {
            $ddpdm_sp = '';
            $ddpdm_sp .= '<div class="ddpdm_subscription_expired_page"><div class="ddpdm-columns"><div class="ddpdm-first-column"><h2>'.__('Dang. No Elegant Themes API key was found', 'ddprodm').'</h2>';

            $ddpdm_sp .='<img src="'.plugin_dir_url(__FILE__) . '/include/ddpdm-paused.png'.'" alt="">';
            $ddpdm_sp .= '<h3>'.__('An API key is required for', 'ddprodm').' '.esc_html(DDPDM_NAME).' '.__('to function correctly', 'ddprodm').'</h3>';

            $ddpdm_sp .= '<p>'.__('To get access to all new layouts, support and updates, please enter a valid Elegant Themes API key on the ', 'ddprodm').'<a href="'.esc_url($this->ddpdm_return_divi_api_link()).'">'.__('"Updates" tab in Divi theme', 'ddprodm').'</a>.</p>';
            $ddpdm_sp .= '<p>'.__('Note: A', 'ddprodm').' '. esc_html(DDPDM_NAME).' '.__('purchase is automatically linked to your Elegant Themes API key. Use an API key from the same Elegant Themes account in which', 'ddprodm').' '. esc_html(DDPDM_NAME).' '.'was purchased'.'.</p>';
            $ddpdm_sp .= '<p><strong>'.__('Where do I get an API key?', 'ddprodm').'</strong></p><p><a href="https://seku.re/elegant-themes-members-login" target="_blank">'.__('Please login to your Elegant Themes account', 'ddprodm').'</a> to find/create an API key. Alternatively contact '.'<a href="https://seku.re/elegant-themes-support" target="_blank">'.__('Elegant Themes support', 'ddprodm').'</a> '.__('for assistance.', 'ddprodm').'</p>';
            $ddpdm_sp .= '<a href="https://seku.re/elegant-themes-members-login" target="_blank" class="button button-primary">'.__('Login to Elegant Themes', 'ddprodm').'</a></div></div></div>';

            return $ddpdm_sp;
        }

        public function ddpdm_key_not_found()
        {
            $ddpdm_sp = '';
            $ddpdm_sp .= '<div class="ddpdm_subscription_expired_page"><div class="ddpdm-columns"><div class="ddpdm-first-column"><h2>'.__('Dang. The Elegant Themes API key which was entered is not valid', 'ddprodm').'</h2>';

            $ddpdm_sp .='<img src="'.plugin_dir_url(__FILE__) . '/include/ddpdm-paused.png'.'" alt="">';
            $ddpdm_sp .= '<h3>'.__('A valid API key is required for', 'ddprodm').' '.esc_html(DDPDM_NAME).' '.__('to function correctly', 'ddprodm').'</h3>';

            $ddpdm_sp .= '<p>'.__('To get access to all new layouts, support and updates, please enter a valid Elegant Themes API key on the ', 'ddprodm').'<a href="'.esc_url($this->ddpdm_return_divi_api_link()).'">'.__('"Updates" tab in Divi theme', 'ddprodm').'</a>.</p>';
            $ddpdm_sp .= '<p>'.__('Note: A', 'ddprodm').' '. esc_html(DDPDM_NAME).' '.__('purchase is automatically linked to your Elegant Themes API key. Use an API key from the same Elegant Themes account in which', 'ddprodm').' '. esc_html(DDPDM_NAME).' '.'was purchased'.'.</p>';
            $ddpdm_sp .= '<p><strong>'.__('Where do I get an API key?', 'ddprodm').'</strong></p><p><a href="https://seku.re/elegant-themes-members-login" target="_blank">'.__('Please login to your Elegant Themes account', 'ddprodm').'</a> to find/create an API key. Alternatively contact '.'<a href="https://seku.re/elegant-themes-support" target="_blank">'.__('Elegant Themes support', 'ddprodm').'</a> '.__('for assistance.', 'ddprodm').'</p>';
            $ddpdm_sp .= '<a href="https://seku.re/elegant-themes-members-login" target="_blank" class="button button-primary">'.__('Login to Elegant Themes', 'ddprodm').'</a></div></div></div>';

            return $ddpdm_sp;
        }

        public function ddpdm_key_disabled()
        {
            $ddpdm_sp = '';
            $ddpdm_sp .= '<div class="ddpdm_subscription_expired_page"><div class="ddpdm-columns"><div class="ddpdm-first-column"><h2>'.__('Oh dear. The Elegant Themes API key has been disabled', 'ddprodm').'</h2>';

            $ddpdm_sp .='<img src="'.plugin_dir_url(__FILE__) . '/include/ddpdm-paused.png'.'" alt="">';
            $ddpdm_sp .= '<h3>'.__('A valid API key is required for', 'ddprodm').' '.esc_html(DDPDM_NAME).' '.__('to function correctly', 'ddprodm').'</h3>';

            $ddpdm_sp .= '<p>'.__('To get access to all new layouts, support and updates, please enter a valid Elegant Themes API key on the ', 'ddprodm').'<a href="'.esc_url($this->ddpdm_return_divi_api_link()).'">'.__('"Updates" tab in Divi theme', 'ddprodm').'</a>.</p>';
            $ddpdm_sp .= '<p><strong>'.__('How can I fix it?', 'ddprodm').'</strong></p><p>'.__('API keys are managed from your Elegant Themes account. Try a different API key, ', 'ddprodm').'<a href="https://seku.re/elegant-themes-members-login" target="_blank">'.__(' login to your account', 'ddprodm').'</a> or '.'<a href="https://seku.re/elegant-themes-support" target="_blank">'.__('contact Elegant Themes support', 'ddprodm').'</a> '.__('for assistance.', 'ddprodm').'</p>';
            $ddpdm_sp .= '<p>'.__('Note: A', 'ddprodm').' '. esc_html(DDPDM_NAME).' '.__('purchase is automatically linked to your Elegant Themes API key. Use an API key from the same Elegant Themes account in which', 'ddprodm').' '. esc_html(DDPDM_NAME).' '.'was purchased'.'.</p>';
            $ddpdm_sp .= '<a href="https://seku.re/elegant-themes-members-login" target="_blank" class="button button-primary">'.__('Login to Elegant Themes', 'ddprodm').'</a></div></div></div>';

            return $ddpdm_sp;
        }

        public function ddpdm_general_api_error()
        {
            $ddpdm_sp = '';
            $ddpdm_sp .= '<div class="ddpdm_subscription_expired_page"><div class="ddpdm-columns"><div class="ddpdm-first-column"><h2>'.__('Oh dear. There was a problem with your Elegant Themes API key input', 'ddprodm').'</h2>';

            $ddpdm_sp .='<img src="'.plugin_dir_url(__FILE__) . '/include/ddpdm-paused.png'.'" alt="">';
            $ddpdm_sp .= '<h3>'.__('Double check to make sure the API key was entered correctly', 'ddprodm').'</h3>';

            $ddpdm_sp .= '<p>'.__('Check your API key input for:', 'ddprodm').'</p>';
            $ddpdm_sp .= '<ul><li>'.__('typing mistakes', 'ddprodm').'</li>';
            $ddpdm_sp .= '<li>'.__('copy-and-paste errors', 'ddprodm').'</li>';
            $ddpdm_sp .= '<li>'.__('empty spaces before or after the API key', 'ddprodm').'</li></ul>';

            $ddpdm_sp .= '<a href="'.esc_url($this->ddpdm_return_divi_api_link()).'" target="_blank" class="button button-primary">'.__('Go to divi api input tab', 'ddprodm').'</a></div></div></div>';

            return $ddpdm_sp;
        }



        public function ddpdm_start_here_function()
        {
            $ddpdm_start_here_content = '<div class="ddpdm-tutorials-dash">';
            $ddpdm_start_here_content .= '<div class="clear"></div><div class="ddpdm-columns"><div class="ddpdm-first-column"><h2>'.__('First steps…', 'ddprodm').'</h2>';

            $ddpdm_start_here_content .= '<div class="clear"></div><div class="ddpdm-accordion closed">';
            $ddpdm_start_here_content .= '<div class="ddpdm-accordion-header"><div class="ddpdm-accordion-img"><img src="';
            $ddpdm_start_here_content .= plugin_dir_url(__FILE__);
            $ddpdm_start_here_content .= 'img/tutorials-icons/gear.png" alt="'.__('Gear Icon', 'ddprodm').'"/></div>';
            $ddpdm_start_here_content .= '<h3>'.__('Quick setup - Important things you should do', 'ddprodm').' <span>+</span></h3><p>'.__('5 steps to save time and get the best results', 'ddprodm').'</p></div>';
            $ddpdm_start_here_content .= '<div class="ddpdm-accordion-content"><p>'.__('Activate API keys, check system status report, deactivate caching, search & save in the layout finder, using sections, modules & layouts.', 'ddprodm').'</p><iframe width="560" height="315" src="https://seku.re/dm-ddp-before-you-begin" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen class="ddpdm-youtube"></iframe></div></div>';

            $ddpdm_start_here_content .= '<div class="clear"></div><div class="ddpdm-accordion closed">';
            $ddpdm_start_here_content .= '<div class="ddpdm-accordion-header"><div class="ddpdm-accordion-img"><img src="';
            $ddpdm_start_here_content .= plugin_dir_url(__FILE__);
            $ddpdm_start_here_content .= 'img/tutorials-icons/save.png" alt="'.__('Save Icon', 'ddprodm').'"/></div>';
            $ddpdm_start_here_content .= '<h3>'.__('The "Save" button does not work', 'ddprodm').' <span>+</span></h3><p>'.__('What to do when save isn\'t working', 'ddprodm').'</p></div>';
            $ddpdm_start_here_content .= '<div class="ddpdm-accordion-content"><p>'.__('Just activated the API Key but unable to load/save layouts? Try this', 'ddprodm').'</p><iframe width="560" height="315" src="https://seku.re/dm-ddp-button-does-not-work" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen class="ddpdm-youtube"></iframe></div></div>';

            $ddpdm_start_here_content .= '<div class="clear"></div><div class="ddpdm-accordion closed">';
            $ddpdm_start_here_content .= '<div class="ddpdm-accordion-header"><div class="ddpdm-accordion-img"><img src="';
            $ddpdm_start_here_content .= plugin_dir_url(__FILE__);
            $ddpdm_start_here_content .= 'img/tutorials-icons/find.png" alt="'.__('Find Icon', 'ddprodm').'"/></div>';
            $ddpdm_start_here_content .= '<h3>'.__('Finding & loading layouts', 'ddprodm').' <span>+</span></h3><p>'.__('Tips for finding relevant layouts fast', 'ddprodm').'</p></div>';
            $ddpdm_start_here_content .= '<div class="ddpdm-accordion-content"><p>'.__('How to search by keyword. Using filter options, collections, bundles, page types and topics. Saving to the library or loading direct to a page.', 'ddprodm').'</p><iframe width="560" height="315" src="https://seku.re/dm-ddp-finding-layouts" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen class="ddpdm-youtube"></iframe></div></div>';

            $ddpdm_start_here_content .= '<div class="clear"></div><div class="ddpdm-accordion closed">';
            $ddpdm_start_here_content .= '<div class="ddpdm-accordion-header"><div class="ddpdm-accordion-img"><img src="';
            $ddpdm_start_here_content .= plugin_dir_url(__FILE__);
            $ddpdm_start_here_content .= 'img/tutorials-icons/find2.png" alt="'.__('Find Icon', 'ddprodm').'"/></div>';
            $ddpdm_start_here_content .= '<h3>'.__('Finding & loading sections', 'ddprodm').' <span>+</span></h3><p>'.__('Load the right section from the right place', 'ddprodm').'</p></div>';
            $ddpdm_start_here_content .= '<div class="ddpdm-accordion-content"><p>'.__('How to filter by sections and save to library. Adding sections to a page.', 'ddprodm').'</p><iframe width="560" height="315" src="https://seku.re/dm-ddp-finding-loading-modules" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen class="ddpdm-youtube"></iframe></div></div>';

            $ddpdm_start_here_content .= '<div class="clear"></div><div class="ddpdm-accordion closed">';
            $ddpdm_start_here_content .= '<div class="ddpdm-accordion-header"><div class="ddpdm-accordion-img"><img src="';
            $ddpdm_start_here_content .= plugin_dir_url(__FILE__);
            $ddpdm_start_here_content .= 'img/tutorials-icons/updates.png" alt="'.__('Updates Icon', 'ddprodm').'"/></div>';
            $ddpdm_start_here_content .= '<h3>'.__('Making content & style updates', 'ddprodm').' <span>+</span></h3><p>'.__('Modify content and design to suit your needs', 'ddprodm').'</p></div>';
            $ddpdm_start_here_content .= '<div class="ddpdm-accordion-content"><p>'.__('How to make updates using Divi module settings. Content, design and custom tab options.', 'ddprodm').'</p><iframe width="560" height="315" src="https://seku.re/dm-ddp-style-updates" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen class="ddpdm-youtube"></iframe></div></div>';

            $ddpdm_start_here_content .='</div><div class="ddpdm-second-column"><h2>Next steps…</h2>';

            $ddpdm_start_here_content .= '<div class="clear"></div><div class="ddpdm-accordion closed">';
            $ddpdm_start_here_content .= '<div class="ddpdm-accordion-header"><div class="ddpdm-accordion-img"><img src="';
            $ddpdm_start_here_content .= plugin_dir_url(__FILE__);
            $ddpdm_start_here_content .= 'img/tutorials-icons/devtools.png" alt="'.__('DevTools Icon', 'ddprodm').'"/></div>';
            $ddpdm_start_here_content .= '<h3>'.__('Using developer tools', 'ddprodm').' <span>+</span></h3><p>'.__('How to customize ANYTHING easily using developer tools', 'ddprodm').'</p></div>';
            $ddpdm_start_here_content .= '<div class="ddpdm-accordion-content"><iframe width="560" height="315" src="https://seku.re/dm-ddp-developer-tools" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen class="ddpdm-youtube"></iframe></div></div>';

            $ddpdm_start_here_content .= '<div class="clear"></div><div class="ddpdm-accordion closed">';
            $ddpdm_start_here_content .= '<div class="ddpdm-accordion-header"><div class="ddpdm-accordion-img"><img src="';
            $ddpdm_start_here_content .= plugin_dir_url(__FILE__);
            $ddpdm_start_here_content .= 'img/tutorials-icons/problems.png" alt="'.__('Problems Icon', 'ddprodm').'"/></div>';
            $ddpdm_start_here_content .= '<h3>'.__('Common problems and troubleshooting tips', 'ddprodm').' <span>+</span></h3><p>'.__('Missing options or not able to save/load layouts?', 'ddprodm').'</p></div>';
            $ddpdm_start_here_content .= '<div class="ddpdm-accordion-content"><p>'.__('Some tips for troubleshooting...', 'ddprodm').'</p><iframe width="560" height="315" src="https://seku.re/dm-ddp-troubleshooting-tips" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen class="ddpdm-youtube"></iframe></div></div>';

            $ddpdm_start_here_content .= '<div class="clear"></div><div class="ddpdm-accordion closed">';
            $ddpdm_start_here_content .= '<div class="ddpdm-accordion-header"><div class="ddpdm-accordion-img"><img src="';
            $ddpdm_start_here_content .= plugin_dir_url(__FILE__);
            $ddpdm_start_here_content .= 'img/tutorials-icons/advanced.png" alt="'.__('Advanced Icon', 'ddprodm').'"/></div>';
            $ddpdm_start_here_content .= '<h3>'.__('Advanced updates - custom CSS', 'ddprodm').' <span>+</span></h3><p>'.__('Where to find additional CSS or write your own', 'ddprodm').'</p></div>';
            $ddpdm_start_here_content .= '<div class="ddpdm-accordion-content"><p>'.__('Finding and using custom CSS files.', 'ddprodm').'</p><iframe width="560" height="315" src="https://seku.re/dm-ddp-advanced-updates" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen class="ddpdm-youtube"></iframe></div></div>';

            $ddpdm_start_here_content .= '<div class="clear"></div><div class="ddpdm-accordion closed">';
            $ddpdm_start_here_content .= '<div class="ddpdm-accordion-header"><div class="ddpdm-accordion-img"><img src="';
            $ddpdm_start_here_content .= plugin_dir_url(__FILE__);
            $ddpdm_start_here_content .= 'img/tutorials-icons/blog.png" alt="'.__('Blog Icon', 'ddprodm').'"/></div>';
            $ddpdm_start_here_content .= '<h3>'.__('Setting up blog layouts & blog modules', 'ddprodm').' <span>+</span></h3><p>'.__('Assign posts, categories, featured images and more', 'ddprodm').'</p></div>';
            $ddpdm_start_here_content .= '<div class="ddpdm-accordion-content"><p>'.__('Tips for setting up posts, image sizes, image optimization, tick which categories to display on page & dummy posts if needed.', 'ddprodm').'</p><iframe width="560" height="315" src="https://seku.re/dm-ddp-setting-up-blog" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen class="ddpdm-youtube"></iframe></div></div>';

            $ddpdm_start_here_content .= '<div class="clear"></div><div class="ddpdm-accordion closed">';
            $ddpdm_start_here_content .= '<div class="ddpdm-accordion-header"><div class="ddpdm-accordion-img"><img src="';
            $ddpdm_start_here_content .= plugin_dir_url(__FILE__);
            $ddpdm_start_here_content .= 'img/tutorials-icons/wl.png" alt="'.__('White Label Icon', 'ddprodm').'"/></div>';
            $ddpdm_start_here_content .= '<h3>'.__('White label mode - setup, test, activate', 'ddprodm').' <span>+</span></h3><p>'.__('How to brand the Pro plugin as your own', 'ddprodm').'</p></div>';
            $ddpdm_start_here_content .= '<div class="ddpdm-accordion-content"><p>'.__('Options & settings to get the most out of white labelling', 'ddprodm').'</p><iframe width="560" height="315" src="https://seku.re/dm-ddp-white-label" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen class="ddpdm-youtube"></iframe></div></div>';

            $ddpdm_start_here_content .= '<div class="clear"></div><div class="ddpdm-accordion closed">';
            $ddpdm_start_here_content .= '<div class="ddpdm-accordion-header"><div class="ddpdm-accordion-img"><img src="';
            $ddpdm_start_here_content .= plugin_dir_url(__FILE__);
            $ddpdm_start_here_content .= 'img/tutorials-icons/lock.png" alt="'.__('Lock Icon', 'ddprodm').'"/></div>';
            $ddpdm_start_here_content .= '<h3>'.__('Can\'t get back to the pro plugin dashboard?', 'ddprodm').' <span>+</span></h3><p>'.__('Here\'s how to do it', 'ddprodm').'</p></div>';
            $ddpdm_start_here_content .= '<div class="ddpdm-accordion-content"><p>'.__('White label mode - using the secret link to access the Pro dashboard.', 'ddprodm').'</p><iframe width="560" height="315" src="https://seku.re/dm-ddp-cant-get-back" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen class="ddpdm-youtube"></iframe></div></div></div></div><div class="clear"></div>';

            $ddpdm_start_here_content .= '<div class="clear"></div><div class="ddpdm-columns"><div class="ddpdm-first-column"><h2 id="ddpdm-divi-theme-builder">'.__('Divi Theme Builder', 'ddprodm').'</h2>';

            $ddpdm_start_here_content .= '<div class="clear"></div><div class="ddpdm-accordion ddpdm-accordion-no-text closed">';
            $ddpdm_start_here_content .= '<div class="ddpdm-accordion-header"><div class="ddpdm-accordion-img"><img src="';
            $ddpdm_start_here_content .= plugin_dir_url(__FILE__);
            $ddpdm_start_here_content .= 'img/tutorials-icons/divi-builder-layouts.png" alt="'.__('Builder Icon', 'ddprodm').'"/></div>';
            $ddpdm_start_here_content .= '<h3>'.__('How to use premade Divi theme builder layouts ', 'ddprodm').'<span>+</span></h3></div>';
            $ddpdm_start_here_content .= '<div class="ddpdm-accordion-content"><iframe width="560" height="315" src="https://seku.re/dm-ddp-premade-layouts" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen class="ddpdm-youtube"></iframe></div></div>';

            $ddpdm_start_here_content .= '<div class="clear"></div><div class="ddpdm-accordion ddpdm-accordion-no-text closed">';
            $ddpdm_start_here_content .= '<div class="ddpdm-accordion-header"><div class="ddpdm-accordion-img"><img src="';
            $ddpdm_start_here_content .= plugin_dir_url(__FILE__);
            $ddpdm_start_here_content .= 'img/tutorials-icons/header-footer.png" alt="'.__('Headers and Footers Icon', 'ddprodm').'"/></div>';
            $ddpdm_start_here_content .= '<h3>'.__('How to add headers and footers', 'ddprodm').' <span>+</span></h3></div>';
            $ddpdm_start_here_content .= '<div class="ddpdm-accordion-content"><iframe width="560" height="315" src="https://seku.re/dm-ddp-headers-footers" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen class="ddpdm-youtube"></iframe></div></div>';

            $ddpdm_start_here_content .= '<div class="clear"></div><div class="ddpdm-accordion ddpdm-accordion-no-text closed">';
            $ddpdm_start_here_content .= '<div class="ddpdm-accordion-header"><div class="ddpdm-accordion-img"><img src="';
            $ddpdm_start_here_content .= plugin_dir_url(__FILE__);
            $ddpdm_start_here_content .= 'img/tutorials-icons/custom-navigation-menus.png" alt="'.__('Menus Icon', 'ddprodm').'"/></div>';
            $ddpdm_start_here_content .= '<h3>'.__('How to add custom navigation menus ', 'ddprodm').' <span>+</span></h3></div>';
            $ddpdm_start_here_content .= '<div class="ddpdm-accordion-content"><iframe width="560" height="315" src="https://seku.re/dm-ddp-navigation-menus" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen class="ddpdm-youtube"></iframe></div></div>';

            $ddpdm_start_here_content .= '<div class="clear"></div><div class="ddpdm-accordion ddpdm-accordion-no-text closed">';
            $ddpdm_start_here_content .= '<div class="ddpdm-accordion-header"><div class="ddpdm-accordion-img"><img src="';
            $ddpdm_start_here_content .= plugin_dir_url(__FILE__);
            $ddpdm_start_here_content .= 'img/tutorials-icons/404.png" alt="'.__('404 Icon', 'ddprodm').'"/></div>';
            $ddpdm_start_here_content .= '<h3>'.__('How to add a 404 page template', 'ddprodm').' <span>+</span></h3></div>';
            $ddpdm_start_here_content .= '<div class="ddpdm-accordion-content"><iframe width="560" height="315" src="https://seku.re/dm-ddp-404" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen class="ddpdm-youtube"></iframe></div></div>';

            $ddpdm_start_here_content .='</div><div class="ddpdm-second-column"><h2 id="ddpdm-theme-builder">Plugin Theme Builder</h2>';

            $ddpdm_start_here_content .= '<div class="clear"></div><div class="ddpdm-accordion ddpdm-accordion-no-text closed">';
            $ddpdm_start_here_content .= '<div class="ddpdm-accordion-header"><div class="ddpdm-accordion-img"><img src="';
            $ddpdm_start_here_content .= plugin_dir_url(__FILE__);
            $ddpdm_start_here_content .= 'img/tutorials-icons/theme-builder.png" alt="'.__('DevTools Icon', 'ddprodm').'"/></div>';
            $ddpdm_start_here_content .= '<h3>'.__('Quick overview of the Divi Den Pro DM theme builder', 'ddprodm').' <span>+</span></h3></div>';
            $ddpdm_start_here_content .= '<div class="ddpdm-accordion-content"><iframe width="560" height="315" src="https://seku.re/dm-ddp-quick-preview" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen class="ddpdm-youtube"></iframe></div></div>';

            $ddpdm_start_here_content .= '<div class="clear"></div><div class="ddpdm-accordion ddpdm-accordion-no-text closed">';
            $ddpdm_start_here_content .= '<div class="ddpdm-accordion-header"><div class="ddpdm-accordion-img"><img src="';
            $ddpdm_start_here_content .= plugin_dir_url(__FILE__);
            $ddpdm_start_here_content .= 'img/tutorials-icons/login-page.png" alt="'.__('Login Icon', 'ddprodm').'"/></div>';
            $ddpdm_start_here_content .= '<h3>'.__('How to set up a custom Divi login page', 'ddprodm').' <span>+</span></h3></div>';
            $ddpdm_start_here_content .= '<div class="ddpdm-accordion-content"><iframe width="560" height="315" src="https://seku.re/dm-ddp-custom-login" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen class="ddpdm-youtube"></iframe></div></div>';

            $ddpdm_start_here_content .= '<div class="clear"></div><div class="ddpdm-accordion ddpdm-accordion-no-text closed">';
            $ddpdm_start_here_content .= '<div class="ddpdm-accordion-header"><div class="ddpdm-accordion-img"><img src="';
            $ddpdm_start_here_content .= plugin_dir_url(__FILE__);
            $ddpdm_start_here_content .= 'img/tutorials-icons/coming-soon.png" alt="'.__('Coming Soon Icon', 'ddprodm').'"/></div>';
            $ddpdm_start_here_content .= '<h3>'.__('Create a custom coming soon page template', 'ddprodm').' <span>+</span></h3></div>';
            $ddpdm_start_here_content .= '<div class="ddpdm-accordion-content"><iframe width="560" height="315" src="https://seku.re/dm-ddp-custom-coming-soon" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen class="ddpdm-youtube"></iframe></div></div>';

            $ddpdm_start_here_content .= '<div class="clear"></div><div class="ddpdm-accordion ddpdm-accordion-no-text closed">';
            $ddpdm_start_here_content .= '<div class="ddpdm-accordion-header"><div class="ddpdm-accordion-img"><img src="';
            $ddpdm_start_here_content .= plugin_dir_url(__FILE__);
            $ddpdm_start_here_content .= 'img/tutorials-icons/pop-up.png" alt="'.__('Pop Up Icon', 'ddprodm').'"/></div>';
            $ddpdm_start_here_content .= '<h3>'.__('How to trigger a Divi pop-up by adding a CSS class', 'ddprodm').' <span>+</span></h3></div>';
            $ddpdm_start_here_content .= '<div class="ddpdm-accordion-content"><iframe width="560" height="315" src="https://seku.re/dm-ddp-trigger-pop-up" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen class="ddpdm-youtube"></iframe></div></div></div></div><div class="clear"></div></div>';

            return $ddpdm_start_here_content;
        }

        /*
        * Checks the API request, adds a notification
        * @return int
        * 100 = Sub expired
        * 200 = Sub active
        * 300 = No billing records
        * 400 = API key not found
        * 500 = API key disabled
        *   0 = an error without a code
        *   1 = success  without a code
        */

        public function ddpdm_return_subscription_status()
        {
            $license_status       = $this->ddpdm_api_key_request();

            if ($license_status === 0) { // empty key
                add_action('admin_notices', $this->ddpdm_subscription_key_is_empty_in_db_notice());
                update_option('ddpdm_enable', 'disabled');
                update_option($this->ddpdm_activated_key, 'Deactivated');
                update_option('ddpdm_subscription_expired', 'no');
                update_option('ddpdm_subscription_stopped', 'yes');
                return 600;
            }

            $license_status_array = json_decode($license_status, true);

            if (isset($license_status_array['error']) && esc_attr($license_status_array['error']) == true) { // wrong API key
                update_option('ddpdm_enable', 'disabled');
                update_option($this->ddpdm_activated_key, 'Deactivated');
                update_option('ddpdm_subscription_expired', 'no');
                update_option('ddpdm_subscription_stopped', 'yes');

                if (isset($license_status_array['code'])) {
                    switch (esc_attr($license_status_array['code'])) {
                        case 'no_billing_records':
                            add_action('admin_notices', $this->ddpdm_subscription_no_billing_records_notice());
                            return 300;
                        case 'api_key_not_found':
                            return 400;
                        case 'api_key_disabled':
                            add_action('admin_notices', $this->ddpdm_subscription_key_disabled_notice());
                            return 500;
                        default:
                            add_action('admin_notices', $this->ddpdm_subscription_key_default_error_notice());
                    } //switch(esc_attr($license_status_array['code']))
                } //  if(isset($license_status_array['code']))
                else {
                    add_action('admin_notices', $this->ddpdm_subscription_key_default_error());
                    return 0;
                }
            } // if(isset($license_status_array['error']) && esc_attr($license_status_array['error']) == true)
            elseif (isset($license_status_array['success']) && esc_attr($license_status_array['success'] == true)) { // right API key
                update_option('ddpdm_subscription_stopped', 'no');
                update_option($this->ddpdm_activated_key, 'Activated');
                if (isset($license_status_array['code'])) {
                    switch (esc_attr($license_status_array['code'])) {
                        case 'subscription_expired':
                            update_option('ddpdm_enable', 'disabled');
                            update_option('ddpdm_subscription_expired', 'yes');
                            add_action('admin_notices', $this->ddpdm_subscription_expired_notice());
                            return 100;
                        case 'subscription_active':
                            update_option('ddpdm_enable', 'enabled');
                            update_option('ddpdm_subscription_expired', 'no');
                            add_action('admin_notices', $this->ddpdm_subscription_active_notice());
                            return 200;
                    } //switch(esc_attr($license_status_array['success']))
                } //  if(isset($license_status_array['code']))
                else {
                    return 1;
                }
            } // else if (isset($license_status_array['success']) && esc_attr($license_status_array['success'] == true)
        } //public function ddpdm_return_subscription_status()

        public function ddpdm_generate_random($length = 7)
        {
            return substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyz', ceil($length/strlen($x)))), 1, $length);
        }

        /**
         * Builds the URL containing the API query string status requests.
         *
         * @param array $args
         *
         * @return string
         */
        public function ddpdm_create_api_url($args)
        {
            //return add_query_arg('wc-api', 'am-software-api', $this->api_url) . '&' . http_build_query($args);
            //   echo $this->api_url.'product_id/'.$args['product_id'].'/api_key/'.$args['api_key'].'?v='.$this->ddpdm_generate_random(7);
            return $this->api_url.'product_id/'.$args['product_id'].'/api_key/'.$args['api_key'].'?v='.$this->ddpdm_generate_random(7);
        }

        /**
        * Gets the ET api key from the site DB
        *
        * @return bool|string
        */
        public function ddpdm_get_api_key_from_db()
        {
            $key_array = get_option('et_automatic_updates_options');
            if (!isset($key_array) || empty($key_array)) {
                if (is_multisite()) {
                    $key_array = get_site_option('et_automatic_updates_options');
                }
            }

            if (isset($key_array)) {
                if (isset($key_array['api_key'])) {
                    $key = str_replace(' ', '', esc_attr($key_array['api_key']));
                    if ($key != '') {
                        return $key;
                    } else {
                        return 0;
                    } // empty key
                } else {
                    return 0;
                } // no api key
            } else {
                return 0;
            } // no DB option
        }

        /**
         * Sends the status check request to the Marketplace.
         *
         * @return bool|string
         */
        public function ddpdm_api_key_request()
        {
            if ($this->ddpdm_get_api_key_from_db() === 0) {
                return 0;
            } // no API key

            $args = array(
                'product_id' => $this->ddpdm_product_id,
                'api_key'    => $this->ddpdm_get_api_key_from_db(),
            );

            $target_url = esc_url_raw($this->ddpdm_create_api_url($args));
            $request    = wp_safe_remote_get($target_url);


            if (is_wp_error($request) || wp_remote_retrieve_response_code($request) != 200) {
                // Request failed
                return false;
            }

            $response = wp_remote_retrieve_body($request);
            return $response;
        }

        public function ddpdm_return_divi_api_link()
        {
            $link = get_admin_url().esc_url('admin.php?page=et_divi_options');
            return $link;
        }

        public function ddpdm_return_ddpdm_dashboard_link()
        {
            $link = get_admin_url().esc_url('admin.php?page=').esc_attr(DDPDM_LINK).'_dashboard';
            return $link;
        }


        /**
        * Subscription notices
        */

        public function ddpdm_subscription_active_notice()
        {
            if (PAnD::is_admin_notice_active('disable-ddpdm-active-notice-forever')) {
                echo '<div data-dismissible="disable-ddpdm-active-notice-forever" class="notice notice-success ddpdm-notice-activated is-dismissible"><p><strong>' . esc_html__('Success', 'ddprodm').':</strong> '. esc_html__('Your ', 'ddprodm'). esc_html(DDPDM_NAME).' '.esc_html__('purchase is verified. Good luck with your project!', 'ddprodm').' <a href="'.esc_url($this->ddpdm_return_ddpdm_dashboard_link()).'" target="_blank">'.esc_html__('Go to the plugin dashboard', 'ddprodm').'</a>' . '</p></div>';
            }
            return true;
        }

        public function ddpdm_subscription_expired_notice()
        {
            echo '<div class="notice notice-error"><p><strong>' . esc_html__('Action Required', 'ddprodm').':</strong> '.esc_html(DDPDM_NAME).' -  '.esc_html__('Your Elegant Themes or ', 'ddprodm').esc_html(DDPDM_NAME).esc_html__('access has expired', 'ddprodm').'. <a href="https://seku.re/get-divi" target="_blank">'.esc_html__('Please renew for full access, updates and support', 'ddprodm').'</a>.</p></div>';
            return true;
        }

        public function ddpdm_subscription_key_not_found_notice()
        {
            echo '<div class="notice notice-error"><p><strong>' . esc_html__('Action required', 'ddprodm').':</strong> '.esc_html(DDPDM_NAME).' '.esc_html__('requires a valid API key. ', 'ddprodm').' <a href="'.esc_url($this->ddpdm_return_divi_api_link()).'">'.esc_html__('Add an API key on the "Updates" tab in Divi theme', 'ddprodm').'</a>.' . '</p></div>';
            return true;
        }

        public function ddpdm_subscription_key_is_empty_in_db_notice()
        {
            echo '<div class="notice notice-error"><p><strong>' . esc_html__('Error', 'ddprodm').':</strong> '.esc_html(DDPDM_NAME).' -  '.esc_html__('No Elegant Themes API Key is found. ', 'ddprodm').' <a href="'.esc_url($this->ddpdm_return_divi_api_link()).'">'.esc_html__('Please check the “Updates” tab', 'ddprodm').'</a>. Make sure the key is added correctly or try a different API key. ' . ' <a href="https://seku.re/elegant-themes-members-login" target="_blank">'.esc_html__('Login to your account', 'ddprodm').'</a>'.' or '. '<a href="https://seku.re/elegant-themes-support" target="_blank">'.esc_html__('contact Elegant Themes support', 'ddprodm').'</a>.</p></div>';
            return true;
        }

        public function ddpdm_subscription_key_disabled_notice()
        {
            echo '<div class="notice notice-error"><p><strong>' . esc_html__('Action Required', 'ddprodm').':</strong> '.esc_html(DDPDM_NAME).' -  '.esc_html__('Sorry, this API key has been disabled. Try a different API key, ', 'ddprodm').' <a href="https://seku.re/elegant-themes-members-login" target="_blank">'.esc_html__('login to your account', 'ddprodm').'</a>'.' or '. '<a href="https://seku.re/elegant-themes-support" target="_blank">'.esc_html__('contact Elegant Themes support', 'ddprodm').'</a>.</p></div>';
            return true;
        }

        public function ddpdm_subscription_no_billing_records_notice()
        {
            echo '<div class="notice notice-error"><p><strong>' . esc_html__('Action Required', 'ddprodm').':</strong>  Oh dear. No valid '.esc_html(DDPDM_NAME).' '.esc_html__('purchase was found. Please ', 'ddprodm').' <a href="https://seku.re/dm-divi-den-pro" target="_blank">'.esc_html__('buy/renew ', 'ddprodm').esc_html(DDPDM_NAME).'</a>'.' from the Divi Marketplace.'.'</p></div>';
            return true;
        }

        public function ddpdm_subscription_key_default_error_notice()
        {
            echo '<div class="notice notice-error"><p><strong>' . esc_html__('Error', 'ddprodm').':</strong> '.esc_html(DDPDM_NAME).' -  '.esc_html__('There was a problem with your Elegant Themes API Key. Make sure it was entered correctly. Try a different API key, ', 'ddprodm').' <a href="https://seku.re/elegant-themes-members-login" target="_blank">'.esc_html__('login to your account', 'ddprodm').'</a>'.' or '. '<a href="https://seku.re/elegant-themes-support" target="_blank">'.esc_html__('contact Elegant Themes support', 'ddprodm').'</a>.</p></div>';
            return true;
        }
    } //class ddpdm_Main_Class
} //if (!class_exists('ddpdm_Main_Class'))



function ddpdm_description_in_shop_loop_item()
{
    global $product;

    $limit = 3;

    $description = $product->get_short_description(); // Product short description

    if ($product->get_short_description()) {
        // Limit the words length
        if (str_word_count($description, 0) > $limit) {
            $words = str_word_count($description, 2);
            $pos = array_keys($words);
            $excerpt = substr($description, 0, $pos[$limit]) . '...';
        } else {
            $excerpt = $description;
        }


        $clean_description = '<div class="description">' . preg_replace("/\r|\n/", "", wp_kses($excerpt, ddpdm_allowed_html())) . '</div>';
        $id = $product->get_id();

        echo "<script>
                jQuery(document).ready(function( $ ) {
                    $('" . wp_kses($clean_description, ddpdm_allowed_html()) . "').insertAfter($('#page-container .et_pb_section.ragnar_products_josefine .et_pb_shop li.product.post-" . esc_attr($id) . " .woocommerce-loop-product__title'));
                     $('" . wp_kses($clean_description, ddpdm_allowed_html()) . "').insertAfter($('#page-container .et_pb_section.ragnar_products_nora .et_pb_shop li.product.post-" . esc_attr($id) . " .woocommerce-loop-product__title'));
                     $('" . wp_kses($clean_description, ddpdm_allowed_html()) . "').insertAfter($('#page-container .et_pb_section.ragnar_products_benta .et_pb_shop li.product.post-" . esc_attr($id) . " .woocommerce-loop-product__title'));
                });

            </script>";
    }
}
add_action('woocommerce_shop_loop_item_title', 'ddpdm_description_in_shop_loop_item', 10);