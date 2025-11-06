<?php

/**
 * Plugin Name: TDT Email Template Builder
 * Plugin URI: https://yourwebsite.com
 * Description: A powerful drag-and-drop email template builder for WordPress with customizable widgets and responsive design.
 * Version: 1.0.0
 * Author: Your Name
 * Author URI: https://yourwebsite.com
 * License: GPL v2 or later
 * Text Domain: tdt-email-template
 * Domain Path: /languages
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

// Define plugin constants
define('TDT_EMAIL_TEMPLATE_VERSION', '1.0.0');
define('TDT_EMAIL_TEMPLATE_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('TDT_EMAIL_TEMPLATE_PLUGIN_URL', plugin_dir_url(__FILE__));
define('TDT_EMAIL_TEMPLATE_PLUGIN_FILE', __FILE__);

/**
 * Main plugin class
 */
class TDT_Email_Template_Builder
{

    /**
     * Instance of this class
     */
    private static $instance = null;

    /**
     * Initialize the plugin
     */
    public static function init()
    {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Constructor
     */
    private function __construct()
    {
        // Load plugin files
        $this->includes();

        // Setup hooks
        $this->setup_hooks();
    }

    /**
     * Include required files
     */
    private function includes()
    {
        // Admin functionality
        if (is_admin()) {
            require_once TDT_EMAIL_TEMPLATE_PLUGIN_DIR . 'includes/admin/class-admin.php';
            require_once TDT_EMAIL_TEMPLATE_PLUGIN_DIR . 'includes/admin/class-templates.php';
            require_once TDT_EMAIL_TEMPLATE_PLUGIN_DIR . 'includes/admin/class-widget-manager.php';
        }

        // Frontend functionality
        require_once TDT_EMAIL_TEMPLATE_PLUGIN_DIR . 'includes/class-frontend.php';
        require_once TDT_EMAIL_TEMPLATE_PLUGIN_DIR . 'includes/class-ajax-handler.php';
        require_once TDT_EMAIL_TEMPLATE_PLUGIN_DIR . 'includes/class-template-renderer.php';
    }

    /**
     * Setup WordPress hooks
     */
    private function setup_hooks()
    {
        // Plugin activation/deactivation
        register_activation_hook(__FILE__, array($this, 'activate'));
        register_deactivation_hook(__FILE__, array($this, 'deactivate'));

        // Load plugin text domain
        add_action('plugins_loaded', array($this, 'load_textdomain'));

        // Enqueue scripts and styles
        add_action('admin_enqueue_scripts', array($this, 'enqueue_admin_assets'));
        add_action('wp_enqueue_scripts', array($this, 'enqueue_frontend_assets'));
    }

    /**
     * Plugin activation
     */
    public function activate()
    {
        // Create database tables
        $this->create_tables();

        // Set default options
        $this->set_default_options();

        // Create default templates
        $this->create_default_templates();
    }

    /**
     * Plugin deactivation
     */
    public function deactivate()
    {
        // Cleanup if needed
    }

    /**
     * Create database tables
     */
    private function create_tables()
    {
        global $wpdb;

        $charset_collate = $wpdb->get_charset_collate();

        $sql = "CREATE TABLE IF NOT EXISTS {$wpdb->prefix}tdt_email_templates (
            id bigint(20) NOT NULL AUTO_INCREMENT,
            name varchar(255) NOT NULL,
            slug varchar(255) NOT NULL,
            description text,
            content longtext,
            settings longtext,
            created_at datetime DEFAULT CURRENT_TIMESTAMP,
            updated_at datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            status varchar(20) DEFAULT 'draft',
            PRIMARY KEY (id),
            UNIQUE KEY slug (slug)
        ) $charset_collate;";

        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
    }

    /**
     * Set default options
     */
    private function set_default_options()
    {
        $default_settings = array(
            'body_width' => '800px',
            'body_background' => '#f1f4f9',
            'canvas_width' => '800px',
            'canvas_background' => '#ffffff',
            'canvas_padding' => '20px',
            'canvas_margin' => '0 auto',
            'global_typography' => array(
                'headings' => array(
                    'font_family' => 'Arial, sans-serif',
                    'font_size' => '24px',
                    'font_weight' => 'bold',
                    'color' => '#333333'
                ),
                'paragraph' => array(
                    'font_family' => 'Arial, sans-serif',
                    'font_size' => '14px',
                    'color' => '#666666'
                ),
                'link' => array(
                    'color' => '#0073aa',
                    'hover_color' => '#00a0d2'
                ),
                'button' => array(
                    'background' => '#63748e',
                    'color' => '#ffffff',
                    'hover_background' => '#314158'
                )
            )
        );

        update_option('tdt_email_template_settings', $default_settings);
    }

    /**
     * Create default templates
     */
    private function create_default_templates()
    {
        // This will be implemented in the templates class
    }

    /**
     * Load plugin text domain
     */
    public function load_textdomain()
    {
        load_plugin_textdomain(
            'tdt-email-template',
            false,
            dirname(plugin_basename(__FILE__)) . '/languages'
        );
    }

    /**
     * Enqueue admin assets
     */
    public function enqueue_admin_assets($hook)
    {
        // Only load on plugin pages
        if (!isset($_GET['page']) || strpos($_GET['page'], 'tdt-email-template') === false) {
            return;
        }

        // CSS
        wp_enqueue_style(
            'tdt-email-template-admin',
            TDT_EMAIL_TEMPLATE_PLUGIN_URL . 'assets/css/admin.css',
            array(),
            TDT_EMAIL_TEMPLATE_VERSION
        );

        // JavaScript
        wp_enqueue_script(
            'tdt-email-template-admin',
            TDT_EMAIL_TEMPLATE_PLUGIN_URL . 'assets/js/admin.js',
            array('jquery', 'jquery-ui-sortable', 'jquery-ui-draggable', 'jquery-ui-droppable'),
            TDT_EMAIL_TEMPLATE_VERSION,
            true
        );

        // Localize script
        wp_localize_script('tdt-email-template-admin', 'tdtEmailTemplate', array(
            'ajax_url' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('tdt_email_template_nonce'),
            'plugin_url' => TDT_EMAIL_TEMPLATE_PLUGIN_URL,
            'media_library_title' => __('Choose Image', 'tdt-email-template'),
            'media_library_button' => __('Use This Image', 'tdt-email-template')
        ));
    }

    /**
     * Enqueue frontend assets
     */
    public function enqueue_frontend_assets()
    {
        // Frontend assets will be loaded conditionally
    }
}

// Initialize the plugin
add_action('plugins_loaded', array('TDT_Email_Template_Builder', 'init'));
