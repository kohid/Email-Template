<?php

/**
 * Settings View
 */

if (!defined('ABSPATH')) {
    exit;
}

$settings = get_option('tdt_email_template_settings', array());

?>

<div class="wrap tdt-email-template-settings">
    <h1 class="wp-heading-inline"><?php _e('Email Template Settings', 'tdt-email-template'); ?></h1>

    <form method="post" action="options.php">
        <?php settings_fields('tdt_email_template_settings'); ?>

        <div class="tdt-settings-container">
            <div class="tdt-settings-main">
                <div class="tdt-settings-section">
                    <h2><?php _e('General Settings', 'tdt-email-template'); ?></h2>

                    <div class="tdt-setting-field">
                        <label for="body_width"><?php _e('Default Body Width', 'tdt-email-template'); ?></label>
                        <input type="text" id="body_width" name="tdt_email_template_settings[body_width]"
                            value="<?php echo esc_attr($settings['body_width'] ?? '800px'); ?>" />
                        <p class="description"><?php _e('Default width for email templates', 'tdt-email-template'); ?></p>
                    </div>

                    <div class="tdt-setting-field">
                        <label for="body_background"><?php _e('Default Body Background', 'tdt-email-template'); ?></label>
                        <input type="color" id="body_background" name="tdt_email_template_settings[body_background]"
                            value="<?php echo esc_attr($settings['body_background'] ?? '#f1f4f9'); ?>" />
                        <p class="description"><?php _e('Default background color for email body', 'tdt-email-template'); ?></p>
                    </div>

                    <div class="tdt-setting-field">
                        <label for="canvas_width"><?php _e('Default Canvas Width', 'tdt-email-template'); ?></label>
                        <input type="text" id="canvas_width" name="tdt_email_template_settings[canvas_width]"
                            value="<?php echo esc_attr($settings['canvas_width'] ?? '800px'); ?>" />
                        <p class="description"><?php _e('Default width for template canvas', 'tdt-email-template'); ?></p>
                    </div>

                    <div class="tdt-setting-field">
                        <label for="canvas_background"><?php _e('Default Canvas Background', 'tdt-email-template'); ?></label>
                        <input type="color" id="canvas_background" name="tdt_email_template_settings[canvas_background]"
                            value="<?php echo esc_attr($settings['canvas_background'] ?? '#ffffff'); ?>" />
                        <p class="description"><?php _e('Default background color for template canvas', 'tdt-email-template'); ?></p>
                    </div>
                </div>

                <div class="tdt-settings-section">
                    <h2><?php _e('Typography Settings', 'tdt-email-template'); ?></h2>

                    <div class="tdt-setting-field">
                        <label for="heading_font_family"><?php _e('Heading Font Family', 'tdt-email-template'); ?></label>
                        <input type="text" id="heading_font_family" name="tdt_email_template_settings[heading_font_family]"
                            value="<?php echo esc_attr($settings['heading_font_family'] ?? 'Arial, sans-serif'); ?>" />
                        <p class="description"><?php _e('Default font family for headings', 'tdt-email-template'); ?></p>
                    </div>

                    <div class="tdt-setting-field">
                        <label for="paragraph_font_family"><?php _e('Paragraph Font Family', 'tdt-email-template'); ?></label>
                        <input type="text" id="paragraph_font_family" name="tdt_email_template_settings[paragraph_font_family]"
                            value="<?php echo esc_attr($settings['paragraph_font_family'] ?? 'Arial, sans-serif'); ?>" />
                        <p class="description"><?php _e('Default font family for paragraphs', 'tdt-email-template'); ?></p>
                    </div>
                </div>
            </div>

            <div class="tdt-settings-sidebar">
                <div class="tdt-settings-info-box">
                    <h3><?php _e('Template Information', 'tdt-email-template'); ?></h3>
                    <p><?php _e('Configure default settings for your email templates. These settings will be applied to all new templates.', 'tdt-email-template'); ?></p>

                    <h4><?php _e('Tips', 'tdt-email-template'); ?></h4>
                    <ul>
                        <li><?php _e('Use 600-800px width for better email client compatibility', 'tdt-email-template'); ?></li>
                        <li><?php _e('Light backgrounds work best for readability', 'tdt-email-template'); ?></li>
                        <li><?php _e('Test your templates across different email clients', 'tdt-email-template'); ?></li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="tdt-settings-footer">
            <?php submit_button(__('Save Settings', 'tdt-email-template')); ?>
        </div>
    </form>
</div>

<style>
    .tdt-email-template-settings {
        max-width: 1200px;
    }

    .tdt-settings-container {
        display: grid;
        grid-template-columns: 1fr 300px;
        gap: 30px;
        margin-top: 20px;
    }

    .tdt-settings-main {
        background: #fff;
        border: 1px solid #ddd;
        border-radius: 8px;
        padding: 30px;
    }

    .tdt-settings-section {
        margin-bottom: 30px;
    }

    .tdt-settings-section:last-child {
        margin-bottom: 0;
    }

    .tdt-settings-section h2 {
        margin: 0 0 20px 0;
        font-size: 18px;
        color: #333;
        border-bottom: 2px solid #00a5f4;
        padding-bottom: 10px;
    }

    .tdt-setting-field {
        margin-bottom: 20px;
    }

    .tdt-setting-field label {
        display: block;
        margin-bottom: 5px;
        font-weight: 500;
        color: #333;
    }

    .tdt-setting-field input[type="text"],
    .tdt-setting-field input[type="color"],
    .tdt-setting-field select {
        width: 100%;
        max-width: 300px;
        padding: 8px 12px;
        border: 1px solid #ddd;
        border-radius: 4px;
        font-size: 14px;
    }

    .tdt-setting-field input[type="color"] {
        width: 60px;
        height: 35px;
        padding: 2px;
    }

    .tdt-setting-field .description {
        margin-top: 5px;
        font-size: 12px;
        color: #666;
    }

    .tdt-settings-sidebar {
        background: #f8f9fa;
        border: 1px solid #ddd;
        border-radius: 8px;
        padding: 20px;
    }

    .tdt-settings-info-box h3 {
        margin: 0 0 15px 0;
        font-size: 16px;
        color: #333;
    }

    .tdt-settings-info-box p {
        margin: 0 0 15px 0;
        color: #666;
        line-height: 1.5;
    }

    .tdt-settings-info-box h4 {
        margin: 20px 0 10px 0;
        font-size: 14px;
        color: #333;
    }

    .tdt-settings-info-box ul {
        margin: 0;
        padding-left: 20px;
    }

    .tdt-settings-info-box li {
        margin-bottom: 5px;
        color: #666;
    }

    .tdt-settings-footer {
        margin-top: 20px;
        padding-top: 20px;
        border-top: 1px solid #ddd;
    }

    @media (max-width: 768px) {
        .tdt-settings-container {
            grid-template-columns: 1fr;
        }

        .tdt-settings-sidebar {
            order: -1;
        }
    }
</style>