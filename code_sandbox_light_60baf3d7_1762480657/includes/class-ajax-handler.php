<?php
/**
 * AJAX Handler
 * Handles all AJAX requests for the email template builder
 */

if (!defined('ABSPATH')) {
    exit;
}

class TDT_Email_Template_AJAX_Handler {
    
    /**
     * Initialize the AJAX handler
     */
    public static function init() {
        add_action('wp_ajax_tdt_get_template_settings', array(__CLASS__, 'get_template_settings'));
        add_action('wp_ajax_tdt_save_template_settings', array(__CLASS__, 'save_template_settings'));
        add_action('wp_ajax_tdt_reset_template_settings', array(__CLASS__, 'reset_template_settings'));
        add_action('wp_ajax_tdt_get_widgets', array(__CLASS__, 'get_widgets'));
        add_action('wp_ajax_tdt_get_widget_html', array(__CLASS__, 'get_widget_html'));
        add_action('wp_ajax_tdt_get_widget_properties', array(__CLASS__, 'get_widget_properties'));
        add_action('wp_ajax_tdt_save_template', array(__CLASS__, 'save_template'));
        add_action('wp_ajax_tdt_preview_template', array(__CLASS__, 'preview_template'));
        add_action('wp_ajax_tdt_export_template', array(__CLASS__, 'export_template'));
    }
    
    /**
     * Verify AJAX nonce
     */
    private static function verify_nonce() {
        if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'tdt_email_template_nonce')) {
            wp_send_json_error('Invalid nonce');
            exit;
        }
    }
    
    /**
     * Get template settings
     */
    public static function get_template_settings() {
        self::verify_nonce();
        
        $settings = get_option('tdt_email_template_settings', array());
        
        wp_send_json_success($settings);
    }
    
    /**
     * Save template settings
     */
    public static function save_template_settings() {
        self::verify_nonce();
        
        if (!isset($_POST['settings'])) {
            wp_send_json_error('No settings provided');
        }
        
        $settings = array_map('sanitize_text_field', $_POST['settings']);
        
        // Sanitize nested arrays
        if (isset($settings['global_typography'])) {
            $settings['global_typography'] = self::sanitize_typography_settings($settings['global_typography']);
        }
        
        update_option('tdt_email_template_settings', $settings);
        
        wp_send_json_success($settings);
    }
    
    /**
     * Reset template settings to defaults
     */
    public static function reset_template_settings() {
        self::verify_nonce();
        
        $default_settings = array(
            'body_width' => '800px',
            'body_background' => '#f1f4f9',
            'canvas_width' => '800px',
            'canvas_background' => '#ffffff',
            'canvas_padding' => '20px',
            'canvas_margin' => '0 auto',
            'canvas_border_radius' => '3px',
            'canvas_box_shadow' => '0 3px 10px rgba(0,0,0,0.15)',
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
        
        wp_send_json_success($default_settings);
    }
    
    /**
     * Get available widgets
     */
    public static function get_widgets() {
        self::verify_nonce();
        
        $widgets = array(
            'container' => array(
                'name' => __('Container', 'tdt-email-template'),
                'icon' => 'fa-regular fa-object-group',
                'description' => __('Flexible container for organizing content', 'tdt-email-template')
            ),
            'heading' => array(
                'name' => __('Heading', 'tdt-email-template'),
                'icon' => 'fa-solid fa-heading',
                'description' => __('Add heading text', 'tdt-email-template')
            ),
            'text' => array(
                'name' => __('Text', 'tdt-email-template'),
                'icon' => 'fa-solid fa-font',
                'description' => __('Add paragraph text', 'tdt-email-template')
            ),
            'image-box' => array(
                'name' => __('Image Box', 'tdt-email-template'),
                'icon' => 'fa-solid fa-images',
                'description' => __('Add image with caption', 'tdt-email-template')
            ),
            'list-icon-text' => array(
                'name' => __('List Icon Text', 'tdt-email-template'),
                'icon' => 'fa-solid fa-list-ul',
                'description' => __('List with icons', 'tdt-email-template')
            ),
            'call-to-action' => array(
                'name' => __('Call to Action', 'tdt-email-template'),
                'icon' => 'fa-regular fa-comment-dots',
                'description' => __('Call to action section', 'tdt-email-template')
            ),
            'navigation' => array(
                'name' => __('Navigation', 'tdt-email-template'),
                'icon' => 'fa-solid fa-ellipsis',
                'description' => __('Navigation menu', 'tdt-email-template')
            ),
            'button' => array(
                'name' => __('Button', 'tdt-email-template'),
                'icon' => 'fa-solid fa-toggle-off',
                'description' => __('Add button', 'tdt-email-template')
            ),
            'image' => array(
                'name' => __('Image', 'tdt-email-template'),
                'icon' => 'fa-regular fa-image',
                'description' => __('Add image', 'tdt-email-template')
            ),
            'video' => array(
                'name' => __('Video', 'tdt-email-template'),
                'icon' => 'fa-regular fa-circle-play',
                'description' => __('Add video', 'tdt-email-template')
            ),
            'social' => array(
                'name' => __('Social', 'tdt-email-template'),
                'icon' => 'fa-regular fa-thumbs-up',
                'description' => __('Social media links', 'tdt-email-template')
            ),
            'html' => array(
                'name' => __('HTML', 'tdt-email-template'),
                'icon' => 'fa-solid fa-code',
                'description' => __('Custom HTML', 'tdt-email-template')
            ),
            'spacer' => array(
                'name' => __('Spacer', 'tdt-email-template'),
                'icon' => 'fa-solid fa-grip-lines',
                'description' => __('Add spacing', 'tdt-email-template')
            ),
            'divider' => array(
                'name' => __('Divider', 'tdt-email-template'),
                'icon' => 'fa-solid fa-divide',
                'description' => __('Add divider line', 'tdt-email-template')
            ),
            'product' => array(
                'name' => __('Product', 'tdt-email-template'),
                'icon' => 'fa-solid fa-cart-shopping',
                'description' => __('Product showcase', 'tdt-email-template')
            ),
            'payment-link' => array(
                'name' => __('Payment Link', 'tdt-email-template'),
                'icon' => 'fa-solid fa-credit-card',
                'description' => __('Payment button', 'tdt-email-template')
            )
        );
        
        wp_send_json_success($widgets);
    }
    
    /**
     * Get widget HTML
     */
    public static function get_widget_html() {
        self::verify_nonce();
        
        if (!isset($_POST['widget_type'])) {
            wp_send_json_error('No widget type provided');
        }
        
        $widget_type = sanitize_text_field($_POST['widget_type']);
        
        // Generate widget HTML based on type
        $html = self::generate_widget_html($widget_type);
        
        wp_send_json_success(array(
            'html' => $html,
            'type' => $widget_type
        ));
    }
    
    /**
     * Get widget properties
     */
    public static function get_widget_properties() {
        self::verify_nonce();
        
        if (!isset($_POST['widget_type'])) {
            wp_send_json_error('No widget type provided');
        }
        
        $widget_type = sanitize_text_field($_POST['widget_type']);
        
        // Get properties for the widget
        $properties = self::get_widget_properties_config($widget_type);
        
        wp_send_json_success(array(
            'content' => $properties['content'] ?? '',
            'style' => $properties['style'] ?? '',
            'advanced' => $properties['advanced'] ?? ''
        ));
    }
    
    /**
     * Save template
     */
    public static function save_template() {
        self::verify_nonce();
        
        if (!isset($_POST['template_data'])) {
            wp_send_json_error('No template data provided');
        }
        
        $template_data = $_POST['template_data'];
        
        // Sanitize data
        $template_data['name'] = sanitize_text_field($template_data['name']);
        $template_data['content'] = wp_kses_post($template_data['content']);
        
        global $wpdb;
        
        $result = $wpdb->insert(
            $wpdb->prefix . 'tdt_email_templates',
            array(
                'name' => $template_data['name'],
                'slug' => sanitize_title($template_data['name']),
                'content' => maybe_serialize($template_data['content']),
                'settings' => maybe_serialize($template_data['settings'] ?? array()),
                'status' => 'publish'
            ),
            array('%s', '%s', '%s', '%s', '%s')
        );
        
        if ($result) {
            wp_send_json_success(array(
                'id' => $wpdb->insert_id,
                'message' => __('Template saved successfully', 'tdt-email-template')
            ));
        } else {
            wp_send_json_error(__('Failed to save template', 'tdt-email-template'));
        }
    }
    
    /**
     * Preview template
     */
    public static function preview_template() {
        self::verify_nonce();
        
        if (!isset($_POST['content']) || !isset($_POST['settings'])) {
            wp_send_json_error('Missing content or settings');
        }
        
        $content = $_POST['content'];
        $settings = $_POST['settings'];
        
        // Generate preview HTML
        $html = self::generate_preview_html($content, $settings);
        
        wp_send_json_success(array(
            'html' => $html
        ));
    }
    
    /**
     * Export template
     */
    public static function export_template() {
        self::verify_nonce();
        
        if (!isset($_POST['content'])) {
            wp_send_json_error('No content provided');
        }
        
        $content = $_POST['content'];
        
        // Generate export file
        $export_data = self::generate_export_data($content);
        
        // Create temporary file
        $upload_dir = wp_upload_dir();
        $filename = 'email-template-' . time() . '.html';
        $filepath = $upload_dir['path'] . '/' . $filename;
        
        file_put_contents($filepath, $export_data);
        
        $download_url = $upload_dir['url'] . '/' . $filename;
        
        wp_send_json_success(array(
            'download_url' => $download_url,
            'filename' => $filename
        ));
    }
    
    /**
     * Generate widget HTML
     */
    private static function generate_widget_html($widget_type) {
        $html = '';
        
        switch ($widget_type) {
            case 'container':
                $html = '<div class="tdt-widget-container" style="padding: 20px; margin: 10px 0; border: 1px dashed #ccc; border-radius: 4px;">
                    <div style="text-align: center; color: #999;">Container - Drag widgets here</div>
                </div>';
                break;
                
            case 'heading':
                $html = '<h2 style="margin: 10px 0; padding: 0; color: #333;">Your Heading Here</h2>';
                break;
                
            case 'text':
                $html = '<p style="margin: 10px 0; color: #666; line-height: 1.6;">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>';
                break;
                
            case 'button':
                $html = '<a href="#" style="display: inline-block; padding: 12px 24px; background: #63748e; color: #fff; text-decoration: none; border-radius: 50px; margin: 10px 0;">Click Here</a>';
                break;
                
            case 'image':
                $html = '<img src="' . TDT_EMAIL_TEMPLATE_PLUGIN_URL . 'assets/images/placeholder.png" style="max-width: 100%; height: auto; margin: 10px 0; border-radius: 4px;">';
                break;
                
            case 'divider':
                $html = '<hr style="border: none; border-top: 1px solid #eee; margin: 20px 0;">';
                break;
                
            case 'spacer':
                $html = '<div style="height: 30px;"></div>';
                break;
                
            default:
                $html = '<div style="padding: 20px; margin: 10px 0; border: 1px solid #ddd; border-radius: 4px;">Widget: ' . esc_html($widget_type) . '</div>';
                break;
        }
        
        return $html;
    }
    
    /**
     * Get widget properties configuration
     */
    private static function get_widget_properties_config($widget_type) {
        $properties = array();
        
        // Content properties
        $properties['content'] = '<div class="widget-properties">';
        
        switch ($widget_type) {
            case 'heading':
                $properties['content'] .= '
                    <div class="property-group">
                        <label>Text</label>
                        <input type="text" class="widget-property-text" value="Your Heading Here" />
                    </div>
                    <div class="property-group">
                        <label>HTML Tag</label>
                        <select class="widget-property-tag">
                            <option value="h1">H1</option>
                            <option value="h2" selected>H2</option>
                            <option value="h3">H3</option>
                            <option value="h4">H4</option>
                            <option value="h5">H5</option>
                            <option value="h6">H6</option>
                        </select>
                    </div>
                ';
                break;
                
            case 'text':
                $properties['content'] .= '
                    <div class="property-group">
                        <label>Text</label>
                        <textarea class="widget-property-text" rows="4">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</textarea>
                    </div>
                ';
                break;
                
            case 'button':
                $properties['content'] .= '
                    <div class="property-group">
                        <label>Button Text</label>
                        <input type="text" class="widget-property-text" value="Click Here" />
                    </div>
                    <div class="property-group">
                        <label>Button Link</label>
                        <input type="url" class="widget-property-link" value="#" />
                    </div>
                ';
                break;
                
            case 'image':
                $properties['content'] .= '
                    <div class="property-group">
                        <label>Image</label>
                        <div class="image-selector">
                            <img src="' . TDT_EMAIL_TEMPLATE_PLUGIN_URL . 'assets/images/placeholder.png" class="selected-image" />
                            <button type="button" class="select-image-button">Select Image</button>
                        </div>
                    </div>
                    <div class="property-group">
                        <label>Alt Text</label>
                        <input type="text" class="widget-property-alt" value="" />
                    </div>
                ';
                break;
                
            default:
                $properties['content'] .= '
                    <div class="property-group">
                        <p>Content properties for ' . esc_html($widget_type) . '</p>
                    </div>
                ';
                break;
        }
        
        $properties['content'] .= '</div>';
        
        // Style properties
        $properties['style'] = '
            <div class="widget-properties">
                <div class="property-group">
                    <label>Alignment</label>
                    <select class="widget-property-alignment">
                        <option value="left">Left</option>
                        <option value="center">Center</option>
                        <option value="right">Right</option>
                        <option value="justify">Justify</option>
                    </select>
                </div>
                <div class="property-group">
                    <label>Color</label>
                    <input type="color" class="widget-property-color" value="#333333" />
                </div>
                <div class="property-group">
                    <label>Font Size</label>
                    <input type="text" class="widget-property-font-size" value="16px" />
                </div>
            </div>
        ';
        
        // Advanced properties
        $properties['advanced'] = '
            <div class="widget-properties">
                <div class="property-group">
                    <label>CSS Classes</label>
                    <input type="text" class="widget-property-css-classes" value="" />
                </div>
                <div class="property-group">
                    <label>CSS ID</label>
                    <input type="text" class="widget-property-css-id" value="" />
                </div>
                <div class="property-group">
                    <label>Margin</label>
                    <input type="text" class="widget-property-margin" value="10px 0" />
                </div>
                <div class="property-group">
                    <label>Padding</label>
                    <input type="text" class="widget-property-padding" value="0" />
                </div>
            </div>
        ';
        
        return $properties;
    }
    
    /**
     * Generate preview HTML
     */
    private static function generate_preview_html($content, $settings) {
        $html = '<!DOCTYPE html>
<html >
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Template Preview</title>
    <style>
        body { margin: 0; padding: 20px; background: ' . esc_attr($settings['body_background'] ?? '#f1f4f9') . '; font-family: Arial, sans-serif; }
        .email-container { max-width: ' . esc_attr($settings['canvas_width'] ?? '800px') . '; margin: 0 auto; background: ' . esc_attr($settings['canvas_background'] ?? '#ffffff') . '; padding: ' . esc_attr($settings['canvas_padding'] ?? '20px') . '; border-radius: ' . esc_attr($settings['canvas_border_radius'] ?? '3px') . '; }
    </style>
</head>
<body>
    <div class="email-container">
        ' . $content . '
    </div>
</body>
</html>';
        
        return $html;
    }
    
    /**
     * Generate export data
     */
    private static function generate_export_data($content) {
        $html = self::generate_preview_html($content['content'] ?? '', $content['settings'] ?? array());
        return $html;
    }
    
    /**
     * Sanitize typography settings
     */
    private static function sanitize_typography_settings($typography) {
        $sanitized = array();
        
        foreach ($typography as $key => $value) {
            if (is_array($value)) {
                $sanitized[$key] = array_map('sanitize_text_field', $value);
            } else {
                $sanitized[$key] = sanitize_text_field($value);
            }
        }
        
        return $sanitized;
    }
}

// Initialize AJAX handler
add_action('init', array('TDT_Email_Template_AJAX_Handler', 'init'));