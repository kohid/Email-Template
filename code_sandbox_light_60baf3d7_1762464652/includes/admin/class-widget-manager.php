<?php

/**
 * Widget Manager Class
 * Manages available widgets and their properties
 */

if (!defined('ABSPATH')) {
    exit;
}

class TDT_Email_Template_Widget_Manager
{

    /**
     * Available widgets
     */
    private static $widgets = array();

    /**
     * Initialize the widget manager
     */
    public static function init()
    {
        self::register_default_widgets();
        add_filter('tdt_email_template_widget_types', array(__CLASS__, 'get_widgets'));
    }

    /**
     * Register default widgets
     */
    private static function register_default_widgets()
    {
        self::$widgets = array(
            'container' => array(
                'name' => __('Container', 'tdt-email-template'),
                'icon' => 'fa-regular fa-object-group',
                'description' => __('Flexible container for organizing content', 'tdt-email-template'),
                'category' => 'layout',
                'properties' => array(
                    'content' => array(
                        'layout' => array(
                            'type' => 'select',
                            'label' => __('Layout', 'tdt-email-template'),
                            'options' => array(
                                'boxed' => __('Boxed', 'tdt-email-template'),
                                'full_width' => __('Full Width', 'tdt-email-template')
                            ),
                            'default' => 'boxed'
                        ),
                        'min_height' => array(
                            'type' => 'text',
                            'label' => __('Minimum Height', 'tdt-email-template'),
                            'default' => ''
                        )
                    ),
                    'style' => array(
                        'background' => array(
                            'type' => 'color',
                            'label' => __('Background Color', 'tdt-email-template'),
                            'default' => '#ffffff'
                        ),
                        'border' => array(
                            'type' => 'border',
                            'label' => __('Border', 'tdt-email-template'),
                            'default' => array(
                                'style' => 'solid',
                                'width' => '1px',
                                'color' => '#dddddd'
                            )
                        )
                    )
                )
            ),

            // ... other widgets unchanged ...
        );

        // Allow third-party widgets
        self::$widgets = apply_filters('tdt_email_template_widget_types', self::$widgets);
    }

    /**
     * Get all widgets
     */
    public static function get_widgets()
    {
        return self::$widgets;
    }

    /**
     * Get widget by type
     */
    public static function get_widget($type)
    {
        return self::$widgets[$type] ?? null;
    }

    /**
     * Register a new widget
     */
    public static function register_widget($type, $config)
    {
        self::$widgets[$type] = $config;
    }

    /**
     * Unregister a widget
     */
    public static function unregister_widget($type)
    {
        unset(self::$widgets[$type]);
    }

    /**
     * Get widget categories
     */
    public static function get_categories()
    {
        $categories = array(
            'layout' => __('Layout', 'tdt-email-template'),
            'content' => __('Content', 'tdt-email-template'),
            'media' => __('Media', 'tdt-email-template'),
            'social' => __('Social', 'tdt-email-template'),
            'woocommerce' => __('WooCommerce', 'tdt-email-template')
        );

        return apply_filters('tdt_email_template_widget_categories', $categories);
    }

    /**
     * Get widget HTML
     */
    public static function get_widget_html($type, $properties = array())
    {
        $widget = self::get_widget($type);

        if (!$widget) {
            return '';
        }

        $html = '';

        switch ($type) {
            case 'container':
                // Build style string
                $style_parts = array();
                if (isset($properties['background'])) {
                    $style_parts[] = 'background-color: ' . esc_attr($properties['background']) . ';';
                }
                if (isset($properties['border'])) {
                    $border = $properties['border'];
                    $style_parts[] = sprintf(
                        'border: %s %s %s;',
                        esc_attr($border['width'] ?? '1px'),
                        esc_attr($border['style'] ?? 'solid'),
                        esc_attr($border['color'] ?? '#dddddd')
                    );
                }
                if (isset($properties['min_height']) && $properties['min_height']) {
                    $style_parts[] = 'min-height: ' . esc_attr($properties['min_height']) . ';';
                }
                $style_attr = implode(' ', $style_parts);

                // Output container with an inner content area the JS expects
                $html = sprintf(
                    '<div class="tdt-widget-container canvas-widget" data-widget-type="container" style="%s">
                        <div class="tdt-widget-container-header" style="text-align:center; color:#999;">Container</div>
                        <div class="tdt-widget-container-content">
                            <div class="tdt-widget-container-placeholder" style="padding:20px; text-align:center; color:#bbb;">Drag widgets here</div>
                        </div>
                    </div>',
                    esc_attr($style_attr)
                );
                break;

            case 'heading':
                $tag = $properties['html_tag'] ?? 'h2';
                $style = '';
                if (isset($properties['color'])) {
                    $style .= 'color: ' . esc_attr($properties['color']) . '; ';
                }
                if (isset($properties['font_size'])) {
                    $style .= 'font-size: ' . esc_attr($properties['font_size']) . '; ';
                }
                if (isset($properties['font_weight'])) {
                    $style .= 'font-weight: ' . esc_attr($properties['font_weight']) . '; ';
                }

                $html = sprintf(
                    '<%s class="tdt-widget-heading" style="%s">%s</%s>',
                    esc_html($tag),
                    esc_attr($style),
                    esc_html($properties['text'] ?? __('Your Heading Here', 'tdt-email-template')),
                    esc_html($tag)
                );
                break;

            case 'text':
                $style = '';
                if (isset($properties['color'])) {
                    $style .= 'color: ' . esc_attr($properties['color']) . '; ';
                }
                if (isset($properties['font_size'])) {
                    $style .= 'font-size: ' . esc_attr($properties['font_size']) . '; ';
                }
                if (isset($properties['line_height'])) {
                    $style .= 'line-height: ' . esc_attr($properties['line_height']) . '; ';
                }

                $html = sprintf(
                    '<p class="tdt-widget-text" style="%s">%s</p>',
                    esc_attr($style),
                    esc_html($properties['text'] ?? __('Lorem ipsum dolor sit amet, consectetur adipiscing elit.', 'tdt-email-template'))
                );
                break;

            case 'button':
                $style = 'display: inline-block; text-decoration: none; ';
                if (isset($properties['background_color'])) {
                    $style .= 'background-color: ' . esc_attr($properties['background_color']) . '; ';
                }
                if (isset($properties['text_color'])) {
                    $style .= 'color: ' . esc_attr($properties['text_color']) . '; ';
                }
                if (isset($properties['border_radius'])) {
                    $style .= 'border-radius: ' . esc_attr($properties['border_radius']) . '; ';
                }
                if (isset($properties['padding'])) {
                    $style .= 'padding: ' . esc_attr($properties['padding']) . '; ';
                }

                $html = sprintf(
                    '<a href="%s" target="%s" class="tdt-widget-button" style="%s">%s</a>',
                    esc_url($properties['link'] ?? '#'),
                    esc_attr($properties['target'] ?? '_self'),
                    esc_attr($style),
                    esc_html($properties['text'] ?? __('Click Here', 'tdt-email-template'))
                );
                break;

            case 'image':
                $style = 'max-width: 100%; height: auto; ';
                if (isset($properties['width'])) {
                    $style .= 'width: ' . esc_attr($properties['width']) . '; ';
                }
                if (isset($properties['height'])) {
                    $style .= 'height: ' . esc_attr($properties['height']) . '; ';
                }
                if (isset($properties['border_radius'])) {
                    $style .= 'border-radius: ' . esc_attr($properties['border_radius']) . '; ';
                }

                $image_url = $properties['image'] ?? TDT_EMAIL_TEMPLATE_PLUGIN_URL . 'assets/images/placeholder.png';
                $alt_text = $properties['alt_text'] ?? '';
                $link = $properties['link'] ?? '';
                $caption = $properties['caption'] ?? '';

                $html = sprintf(
                    '<img src="%s" alt="%s" class="tdt-widget-image" style="%s" />',
                    esc_url($image_url),
                    esc_attr($alt_text),
                    esc_attr($style)
                );

                if ($caption) {
                    $html .= sprintf(
                        '<div class="tdt-widget-image-caption" style="text-align: center; margin-top: 10px; color: #666;">%s</div>',
                        esc_html($caption)
                    );
                }

                if ($link) {
                    $html = sprintf(
                        '<a href="%s" target="_blank">%s</a>',
                        esc_url($link),
                        $html
                    );
                }
                break;

            case 'divider':
                $style = 'border: none; ';
                if (isset($properties['style'])) {
                    $style .= sprintf('border-top: 1px %s; ', esc_attr($properties['style']));
                }
                if (isset($properties['color'])) {
                    $style .= 'border-top-color: ' . esc_attr($properties['color']) . '; ';
                }
                if (isset($properties['width'])) {
                    $style .= 'width: ' . esc_attr($properties['width']) . '; ';
                }

                $html = sprintf(
                    '<hr class="tdt-widget-divider" style="%s" />',
                    esc_attr($style)
                );
                break;

            case 'spacer':
                $height = $properties['height'] ?? '30px';
                $html = sprintf(
                    '<div class="tdt-widget-spacer" style="height: %s;"></div>',
                    esc_attr($height)
                );
                break;

            default:
                $html = sprintf(
                    '<div class="tdt-widget tdt-widget-%s">Widget: %s</div>',
                    esc_attr($type),
                    esc_html($type)
                );
                break;
        }

        return apply_filters('tdt_email_template_widget_html', $html, $type, $properties);
    }
}

// Initialize widget manager
add_action('init', array('TDT_Email_Template_Widget_Manager', 'init'));
