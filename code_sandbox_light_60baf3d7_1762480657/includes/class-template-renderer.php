<?php
/**
 * Template Renderer Class
 * Handles template rendering and output
 */

if (!defined('ABSPATH')) {
    exit;
}

class TDT_Email_Template_Renderer {
    
    /**
     * Render a template
     */
    public static function render_template($template_id, $args = array()) {
        global $wpdb;
        
        $template = $wpdb->get_row($wpdb->prepare(
            "SELECT * FROM {$wpdb->prefix}tdt_email_templates WHERE id = %d",
            $template_id
        ));
        
        if (!$template) {
            return 'Template not found';
        }
        
        $content = maybe_unserialize($template->content);
        $settings = maybe_unserialize($template->settings);
        
        return self::render_html($content, $settings, $args);
    }
    
    /**
     * Render template HTML
     */
    public static function render_html($content, $settings = array(), $args = array()) {
        $defaults = array(
            'body_width' => '800px',
            'body_background' => '#f1f4f9',
            'canvas_width' => '800px',
            'canvas_background' => '#ffffff',
            'canvas_padding' => '20px',
            'canvas_margin' => '0 auto',
        );
        
        $settings = wp_parse_args($settings, $defaults);
        $args = wp_parse_args($args, array());
        
        ob_start();
        ?>
        <!DOCTYPE html>
        <html >
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Email Template</title>
            <style>
                body {
                    margin: 0 !important;
                    padding: 20px !important;
                    background-color: <?php echo esc_attr($settings['body_background']); ?> !important;
                    font-family: Arial, sans-serif !important;
                    line-height: 1.6 !important;
                }
                .email-container {
                    max-width: <?php echo esc_attr($settings['canvas_width']); ?> !important;
                    margin: <?php echo esc_attr($settings['canvas_margin']); ?> !important;
                    background-color: <?php echo esc_attr($settings['canvas_background']); ?> !important;
                    padding: <?php echo esc_attr($settings['canvas_padding']); ?> !important;
                    border-radius: <?php echo esc_attr($settings['canvas_border_radius'] ?? '3px'); ?> !important;
                    <?php if (isset($settings['canvas_box_shadow'])): ?>
                    box-shadow: <?php echo esc_attr($settings['canvas_box_shadow']); ?> !important;
                    <?php endif; ?>
                }
                <?php if (isset($settings['global_typography'])): ?>
                    <?php if (isset($settings['global_typography']['headings'])): ?>
                        h1, h2, h3, h4, h5, h6 {
                            font-family: <?php echo esc_attr($settings['global_typography']['headings']['font_family']); ?> !important;
                            font-size: <?php echo esc_attr($settings['global_typography']['headings']['font_size']); ?> !important;
                            font-weight: <?php echo esc_attr($settings['global_typography']['headings']['font_weight']); ?> !important;
                            color: <?php echo esc_attr($settings['global_typography']['headings']['color']); ?> !important;
                        }
                    <?php endif; ?>
                    
                    <?php if (isset($settings['global_typography']['paragraph'])): ?>
                        p {
                            font-family: <?php echo esc_attr($settings['global_typography']['paragraph']['font_family']); ?> !important;
                            font-size: <?php echo esc_attr($settings['global_typography']['paragraph']['font_size']); ?> !important;
                            color: <?php echo esc_attr($settings['global_typography']['paragraph']['color']); ?> !important;
                            <?php if (isset($settings['global_typography']['paragraph']['line_height'])): ?>
                                line-height: <?php echo esc_attr($settings['global_typography']['paragraph']['line_height']); ?> !important;
                            <?php endif; ?>
                        }
                    <?php endif; ?>
                    
                    <?php if (isset($settings['global_typography']['link'])): ?>
                        a {
                            color: <?php echo esc_attr($settings['global_typography']['link']['color']); ?> !important;
                        }
                        a:hover {
                            color: <?php echo esc_attr($settings['global_typography']['link']['hover_color']); ?> !important;
                        }
                    <?php endif; ?>
                    
                    <?php if (isset($settings['global_typography']['button'])): ?>
                        .tdt-button {
                            background-color: <?php echo esc_attr($settings['global_typography']['button']['background']); ?> !important;
                            color: <?php echo esc_attr($settings['global_typography']['button']['color']); ?> !important;
                            border-radius: <?php echo esc_attr($settings['global_typography']['button']['border_radius'] ?? '50px'); ?> !important;
                        }
                        .tdt-button:hover {
                            background-color: <?php echo esc_attr($settings['global_typography']['button']['hover_background']); ?> !important;
                        }
                    <?php endif; ?>
                <?php endif; ?>
            </style>
        </head>
        <body>
            <div class="email-container">
                <?php echo $content; ?>
            </div>
        </body>
        </html>
        <?php
        
        return ob_get_clean();
    }
    
    /**
     * Render a specific widget
     */
    public static function render_widget($widget_data, $settings = array()) {
        $widget_type = $widget_data['type'] ?? '';
        $widget_content = $widget_data['content'] ?? '';
        $widget_settings = $widget_data['settings'] ?? array();
        
        // Apply widget-specific styling
        $style = '';
        if (isset($widget_settings['alignment'])) {
            $style .= 'text-align: ' . esc_attr($widget_settings['alignment']) . '; ';
        }
        if (isset($widget_settings['color'])) {
            $style .= 'color: ' . esc_attr($widget_settings['color']) . '; ';
        }
        if (isset($widget_settings['font_size'])) {
            $style .= 'font-size: ' . esc_attr($widget_settings['font_size']) . '; ';
        }
        
        $output = '<div class="tdt-widget tdt-widget-' . esc_attr($widget_type) . '" style="' . esc_attr($style) . '">';
        $output .= $widget_content;
        $output .= '</div>';
        
        return $output;
    }
    
    /**
     * Get template by ID
     */
    public static function get_template($template_id) {
        global $wpdb;
        
        return $wpdb->get_row($wpdb->prepare(
            "SELECT * FROM {$wpdb->prefix}tdt_email_templates WHERE id = %d",
            $template_id
        ));
    }
    
    /**
     * Get all templates
     */
    public static function get_templates($args = array()) {
        global $wpdb;
        
        $defaults = array(
            'limit' => 10,
            'offset' => 0,
            'orderby' => 'created_at',
            'order' => 'DESC',
            'status' => 'publish'
        );
        
        $args = wp_parse_args($args, $defaults);
        
        $query = "SELECT * FROM {$wpdb->prefix}tdt_email_templates WHERE 1=1";
        
        if (!empty($args['status'])) {
            $query .= $wpdb->prepare(" AND status = %s", $args['status']);
        }
        
        $query .= " ORDER BY " . esc_sql($args['orderby']) . " " . esc_sql($args['order']);
        $query .= $wpdb->prepare(" LIMIT %d OFFSET %d", $args['limit'], $args['offset']);
        
        return $wpdb->get_results($query);
    }
}