<?php

/**
 * Admin Class
 * Handles all admin functionality
 */

if (!defined('ABSPATH')) {
    exit;
}

class TDT_Email_Template_Admin
{

    /**
     * Initialize the admin class
     */
    public static function init()
    {
        add_action('admin_menu', array(__CLASS__, 'add_admin_menu'));
        add_action('admin_init', array(__CLASS__, 'admin_init'));
    }

    /**
     * Add admin menu items
     */
    public static function add_admin_menu()
    {
        add_menu_page(
            __('Email Templates', 'tdt-email-template'),
            __('Email Templates', 'tdt-email-template'),
            'manage_options',
            'tdt-email-templates',
            array(__CLASS__, 'templates_page'),
            'dashicons-email',
            30
        );

        add_submenu_page(
            'tdt-email-templates',
            __('All Templates', 'tdt-email-template'),
            __('All Templates', 'tdt-email-template'),
            'manage_options',
            'tdt-email-templates',
            array(__CLASS__, 'templates_page')
        );

        add_submenu_page(
            'tdt-email-templates',
            __('Add New Template', 'tdt-email-template'),
            __('Add New Template', 'tdt-email-template'),
            'manage_options',
            'tdt-email-template-builder',
            array(__CLASS__, 'builder_page')
        );

        add_submenu_page(
            'tdt-email-templates',
            __('Settings', 'tdt-email-template'),
            __('Settings', 'tdt-email-template'),
            'manage_options',
            'tdt-email-template-settings',
            array(__CLASS__, 'settings_page')
        );
    }

    /**
     * Admin init
     */
    public static function admin_init()
    {
        // Register settings
        register_setting(
            'tdt_email_template_settings',
            'tdt_email_template_settings',
            array('sanitize_callback' => array(__CLASS__, 'sanitize_settings'))
        );
    }

    /**
     * Templates list page
     */
    public static function templates_page()
    {
        include_once TDT_EMAIL_TEMPLATE_PLUGIN_DIR . 'includes/admin/views/templates-list.php';
    }

    /**
     * Template builder page
     */
    public static function builder_page()
    {
        include_once TDT_EMAIL_TEMPLATE_PLUGIN_DIR . 'includes/admin/views/email-builder.php';
    }

    /**
     * Settings page
     */
    public static function settings_page()
    {
        include_once TDT_EMAIL_TEMPLATE_PLUGIN_DIR . 'includes/admin/views/settings.php';
    }

    /**
     * Sanitize settings
     */
    public static function sanitize_settings($input)
    {
        $sanitized = array();

        if (isset($input['body_width'])) {
            $sanitized['body_width'] = sanitize_text_field($input['body_width']);
        }

        if (isset($input['body_background'])) {
            $sanitized['body_background'] = sanitize_hex_color($input['body_background']);
        }

        if (isset($input['canvas_width'])) {
            $sanitized['canvas_width'] = sanitize_text_field($input['canvas_width']);
        }

        if (isset($input['canvas_background'])) {
            $sanitized['canvas_background'] = sanitize_hex_color($input['canvas_background']);
        }

        if (isset($input['canvas_padding'])) {
            $sanitized['canvas_padding'] = sanitize_text_field($input['canvas_padding']);
        }

        if (isset($input['canvas_margin'])) {
            $sanitized['canvas_margin'] = sanitize_text_field($input['canvas_margin']);
        }

        return $sanitized;
    }
}

// Initialize admin class
add_action('init', array('TDT_Email_Template_Admin', 'init'));
