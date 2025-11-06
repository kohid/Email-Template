<?php

/**
 * Frontend Class
 * Handles frontend functionality
 */

if (!defined('ABSPATH')) {
    exit;
}

class TDT_Email_Template_Frontend
{

    /**
     * Initialize the frontend class
     */
    public static function init()
    {
        add_shortcode('tdt_email_template', array(__CLASS__, 'render_shortcode'));
        add_action('wp_enqueue_scripts', array(__CLASS__, 'enqueue_scripts'));
    }

    /**
     * Enqueue frontend scripts and styles
     */
    public static function enqueue_scripts()
    {
        // Frontend assets are loaded conditionally when templates are displayed
        wp_register_style(
            'tdt-email-template-frontend',
            TDT_EMAIL_TEMPLATE_PLUGIN_URL . 'assets/css/frontend.css',
            array(),
            TDT_EMAIL_TEMPLATE_VERSION
        );

        wp_register_script(
            'tdt-email-template-frontend',
            TDT_EMAIL_TEMPLATE_PLUGIN_URL . 'assets/js/frontend.js',
            array('jquery'),
            TDT_EMAIL_TEMPLATE_VERSION,
            true
        );
    }

    /**
     * Render template shortcode
     */
    public static function render_shortcode($atts)
    {
        $atts = shortcode_atts(array(
            'id' => 0,
            'align' => 'center',
            'width' => '100%',
            'class' => ''
        ), $atts, 'tdt_email_template');

        if (empty($atts['id'])) {
            return '<p>Template ID is required</p>';
        }

        // Enqueue assets
        wp_enqueue_style('tdt-email-template-frontend');
        wp_enqueue_script('tdt-email-template-frontend');

        // Get template
        $template = TDT_Email_Template_Renderer::get_template($atts['id']);

        if (!$template) {
            return '<p>Template not found</p>';
        }

        // Render template
        $output = TDT_Email_Template_Renderer::render_template($atts['id']);

        // Wrap in container
        $classes = array('tdt-email-template-wrapper');
        if (!empty($atts['class'])) {
            $classes[] = $atts['class'];
        }

        $style = sprintf(
            'text-align: %s; width: %s;',
            esc_attr($atts['align']),
            esc_attr($atts['width'])
        );

        return sprintf(
            '<div class="%s" style="%s">%s</div>',
            esc_attr(implode(' ', $classes)),
            esc_attr($style),
            $output
        );
    }

    /**
     * Render template by ID
     */
    public static function render_template($template_id, $args = array())
    {
        return TDT_Email_Template_Renderer::render_template($template_id, $args);
    }
}
