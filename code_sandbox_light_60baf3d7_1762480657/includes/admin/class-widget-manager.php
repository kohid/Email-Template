<?php
/**
 * Widget Manager Class
 * Manages available widgets and their properties
 */

if (!defined('ABSPATH')) {
    exit;
}

class TDT_Email_Template_Widget_Manager {
    
    /**
     * Available widgets
     */
    private static $widgets = array();
    
    /**
     * Initialize the widget manager
     */
    public static function init() {
        self::register_default_widgets();
        add_filter('tdt_email_template_widget_types', array(__CLASS__, 'get_widgets'));
    }
    
    /**
     * Register default widgets
     */
    private static function register_default_widgets() {
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
            
            'heading' => array(
                'name' => __('Heading', 'tdt-email-template'),
                'icon' => 'fa-solid fa-heading',
                'description' => __('Add heading text', 'tdt-email-template'),
                'category' => 'content',
                'properties' => array(
                    'content' => array(
                        'text' => array(
                            'type' => 'text',
                            'label' => __('Text', 'tdt-email-template'),
                            'default' => __('Your Heading Here', 'tdt-email-template')
                        ),
                        'html_tag' => array(
                            'type' => 'select',
                            'label' => __('HTML Tag', 'tdt-email-template'),
                            'options' => array(
                                'h1' => 'H1',
                                'h2' => 'H2',
                                'h3' => 'H3',
                                'h4' => 'H4',
                                'h5' => 'H5',
                                'h6' => 'H6'
                            ),
                            'default' => 'h2'
                        )
                    ),
                    'style' => array(
                        'color' => array(
                            'type' => 'color',
                            'label' => __('Color', 'tdt-email-template'),
                            'default' => '#333333'
                        ),
                        'font_size' => array(
                            'type' => 'text',
                            'label' => __('Font Size', 'tdt-email-template'),
                            'default' => '24px'
                        ),
                        'font_weight' => array(
                            'type' => 'select',
                            'label' => __('Font Weight', 'tdt-email-template'),
                            'options' => array(
                                'normal' => __('Normal', 'tdt-email-template'),
                                'bold' => __('Bold', 'tdt-email-template'),
                                '100' => '100',
                                '200' => '200',
                                '300' => '300',
                                '400' => '400',
                                '500' => '500',
                                '600' => '600',
                                '700' => '700',
                                '800' => '800',
                                '900' => '900'
                            ),
                            'default' => 'bold'
                        )
                    )
                )
            ),
            
            'text' => array(
                'name' => __('Text', 'tdt-email-template'),
                'icon' => 'fa-solid fa-font',
                'description' => __('Add paragraph text', 'tdt-email-template'),
                'category' => 'content',
                'properties' => array(
                    'content' => array(
                        'text' => array(
                            'type' => 'textarea',
                            'label' => __('Text', 'tdt-email-template'),
                            'default' => __('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', 'tdt-email-template')
                        )
                    ),
                    'style' => array(
                        'color' => array(
                            'type' => 'color',
                            'label' => __('Color', 'tdt-email-template'),
                            'default' => '#666666'
                        ),
                        'font_size' => array(
                            'type' => 'text',
                            'label' => __('Font Size', 'tdt-email-template'),
                            'default' => '14px'
                        ),
                        'line_height' => array(
                            'type' => 'text',
                            'label' => __('Line Height', 'tdt-email-template'),
                            'default' => '1.6'
                        )
                    )
                )
            ),
            
            'button' => array(
                'name' => __('Button', 'tdt-email-template'),
                'icon' => 'fa-solid fa-toggle-off',
                'description' => __('Add button', 'tdt-email-template'),
                'category' => 'content',
                'properties' => array(
                    'content' => array(
                        'text' => array(
                            'type' => 'text',
                            'label' => __('Button Text', 'tdt-email-template'),
                            'default' => __('Click Here', 'tdt-email-template')
                        ),
                        'link' => array(
                            'type' => 'url',
                            'label' => __('Button Link', 'tdt-email-template'),
                            'default' => '#'
                        ),
                        'target' => array(
                            'type' => 'select',
                            'label' => __('Link Target', 'tdt-email-template'),
                            'options' => array(
                                '_self' => __('Same Window', 'tdt-email-template'),
                                '_blank' => __('New Window', 'tdt-email-template')
                            ),
                            'default' => '_self'
                        )
                    ),
                    'style' => array(
                        'background_color' => array(
                            'type' => 'color',
                            'label' => __('Background Color', 'tdt-email-template'),
                            'default' => '#63748e'
                        ),
                        'text_color' => array(
                            'type' => 'color',
                            'label' => __('Text Color', 'tdt-email-template'),
                            'default' => '#ffffff'
                        ),
                        'border_radius' => array(
                            'type' => 'text',
                            'label' => __('Border Radius', 'tdt-email-template'),
                            'default' => '50px'
                        ),
                        'padding' => array(
                            'type' => 'text',
                            'label' => __('Padding', 'tdt-email-template'),
                            'default' => '12px 24px'
                        )
                    ),
                    'advanced' => array(
                        'hover_background' => array(
                            'type' => 'color',
                            'label' => __('Hover Background', 'tdt-email-template'),
                            'default' => '#314158'
                        )
                    )
                )
            ),
            
            'image' => array(
                'name' => __('Image', 'tdt-email-template'),
                'icon' => 'fa-regular fa-image',
                'description' => __('Add image', 'tdt-email-template'),
                'category' => 'media',
                'properties' => array(
                    'content' => array(
                        'image' => array(
                            'type' => 'image',
                            'label' => __('Image', 'tdt-email-template'),
                            'default' => ''
                        ),
                        'alt_text' => array(
                            'type' => 'text',
                            'label' => __('Alt Text', 'tdt-email-template'),
                            'default' => ''
                        ),
                        'link' => array(
                            'type' => 'url',
                            'label' => __('Image Link', 'tdt-email-template'),
                            'default' => ''
                        ),
                        'caption' => array(
                            'type' => 'text',
                            'label' => __('Caption', 'tdt-email-template'),
                            'default' => ''
                        )
                    ),
                    'style' => array(
                        'width' => array(
                            'type' => 'text',
                            'label' => __('Width', 'tdt-email-template'),
                            'default' => '100%'
                        ),
                        'height' => array(
                            'type' => 'text',
                            'label' => __('Height', 'tdt-email-template'),
                            'default' => 'auto'
                        ),
                        'border_radius' => array(
                            'type' => 'text',
                            'label' => __('Border Radius', 'tdt-email-template'),
                            'default' => '0'
                        )
                    )
                )
            ),
            
            'divider' => array(
                'name' => __('Divider', 'tdt-email-template'),
                'icon' => 'fa-solid fa-divide',
                'description' => __('Add divider line', 'tdt-email-template'),
                'category' => 'layout',
                'properties' => array(
                    'style' => array(
                        'style' => array(
                            'type' => 'select',
                            'label' => __('Style', 'tdt-email-template'),
                            'options' => array(
                                'solid' => __('Solid', 'tdt-email-template'),
                                'dashed' => __('Dashed', 'tdt-email-template'),
                                'dotted' => __('Dotted', 'tdt-email-template')
                            ),
                            'default' => 'solid'
                        ),
                        'width' => array(
                            'type' => 'text',
                            'label' => __('Width', 'tdt-email-template'),
                            'default' => '100%'
                        ),
                        'color' => array(
                            'type' => 'color',
                            'label' => __('Color', 'tdt-email-template'),
                            'default' => '#eeeeee'
                        )
                    )
                )
            ),
            
            'spacer' => array(
                'name' => __('Spacer', 'tdt-email-template'),
                'icon' => 'fa-solid fa-grip-lines',
                'description' => __('Add spacing', 'tdt-email-template'),
                'category' => 'layout',
                'properties' => array(
                    'style' => array(
                        'height' => array(
                            'type' => 'text',
                            'label' => __('Height', 'tdt-email-template'),
                            'default' => '30px'
                        )
                    )
                )
            )
        );
        
        // Allow third-party widgets
        self::$widgets = apply_filters('tdt_email_template_widget_types', self::$widgets);
    }
    
    /**
     * Get all widgets
     */
    public static function get_widgets() {
        return self::$widgets;
    }
    
    /**
     * Get widget by type
     */
    public static function get_widget($type) {
        return self::$widgets[$type] ?? null;
    }
    
    /**
     * Register a new widget
     */
    public static function register_widget($type, $config) {
        self::$widgets[$type] = $config;
    }
    
    /**
     * Unregister a widget
     */
    public static function unregister_widget($type) {
        unset(self::$widgets[$type]);
    }
    
    /**
     * Get widget categories
     */
    public static function get_categories() {
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
    public static function get_widget_html($type, $properties = array()) {
        $widget = self::get_widget($type);
        
        if (!$widget) {
            return '';
        }
        
        $html = '';
        
        switch ($type) {
            case 'container':
                $style = '';
                if (isset($properties['background'])) {
                    $style .= 'background-color: ' . esc_attr($properties['background']) . '; ';
                }
                if (isset($properties['border'])) {
                    $border = $properties['border'];
                    $style .= sprintf(
                        'border: %s %s %s; ',
                        esc_attr($border['width'] ?? '1px'),
                        esc_attr($border['style'] ?? 'solid'),
                        esc_attr($border['color'] ?? '#dddddd')
                    );
                }
                
                $html = sprintf(
                    '<div class="tdt-widget-container" style="%s"%s>
                        <div style="text-align: center; color: #999;">Container - Drag widgets here</div>
                    </div>',
                    esc_attr($style),
                    isset($properties['min_height']) ? ' style="min-height: ' . esc_attr($properties['min_height']) . '"' : ''
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