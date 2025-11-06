<script src="https://kit.fontawesome.com/cdfe678bfc.js" crossorigin="anonymous"></script>

<div class="wrap tdt-email-template-builder" id="tdt-email-template-builder">
    <div class="tdt-email-template-header">
        <div class="tdt-email-template-header-left">
            <img src="<?php echo esc_url(TDT_EMAIL_TEMPLATE_PLUGIN_URL . 'assets/images/logo.png'); ?>" alt="Logo" />
            <input type="text" placeholder="<?php esc_attr_e('Template Name', 'tdt-email-template'); ?>" id="template-name" value="" />
        </div>

        <div class="tdt-email-template-header-right">
            <div class="tdt-email-template-header-toggle-button">
                <div class="tdt-email-template-header-toggle-btn tdt-email-template-header-toggle-desktop active" data-device="desktop">
                    <i class="fa-solid fa-display"></i>
                </div>
                <div class="tdt-email-template-header-toggle-btn tdt-email-template-header-toggle-mobile" data-device="mobile">
                    <i class="fa-solid fa-mobile-screen-button"></i>
                </div>
            </div>

            <div class="tdt-email-template-header-control">
                <div class="tdt-email-template-header-button tdt-email-template-header-settings" id="template-settings">
                    <i class="fa-solid fa-gear"></i> Settings
                </div>
                <div class="tdt-email-template-header-button tdt-email-template-header-preview" id="preview-template">
                    <i class="fa-solid fa-eye"></i> Preview
                </div>
                <div class="tdt-email-template-header-button tdt-email-template-header-save" id="save-template">
                    <i class="fa-solid fa-save"></i> Save
                </div>
                <div class="tdt-email-template-header-menu-container">
                    <div class="tdt-email-template-header-menu-icon">
                        <i class="fa-solid fa-ellipsis-vertical"></i>
                    </div>
                    <ul class="tdt-email-template-header-menu hidden">
                        <li data-action="history"><i class="fa-solid fa-history"></i> History</li>
                        <li data-action="export"><i class="fa-solid fa-download"></i> Export HTML</li>
                        <li data-action="duplicate"><i class="fa-solid fa-copy"></i> Duplicate</li>
                        <li data-action="delete"><i class="fa-solid fa-trash"></i> Delete</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="tdt-email-template-body">
        <div class="tdt-email-template-panel-component">
            <div class="tdt-email-template-panel-component-tab-container">
                <div class="tdt-email-template-panel-component-tab tdt-email-template-panel-component-tab-widget active" data-tab="widgets">
                    <i class="fa-solid fa-puzzle-piece"></i> Widgets
                </div>
                <div class="tdt-email-template-panel-component-tab tdt-email-template-panel-component-tab-library" data-tab="library">
                    <i class="fa-solid fa-folder-open"></i> Library
                </div>
            </div>

            <div class="tdt-email-template-widgets active">
                <div class="tdt-email-template-widget-card" data-widget="container">
                    <i class="fa-regular fa-object-group"></i>
                    <div>Container</div>
                </div>
                <div class="tdt-email-template-widget-card" data-widget="heading">
                    <i class="fa-solid fa-heading"></i>
                    <div>Heading</div>
                </div>
                <div class="tdt-email-template-widget-card" data-widget="text">
                    <i class="fa-solid fa-font"></i>
                    <div>Text</div>
                </div>
                <div class="tdt-email-template-widget-card" data-widget="image-box">
                    <i class="fa-solid fa-images"></i>
                    <div>Image Box</div>
                </div>
                <div class="tdt-email-template-widget-card" data-widget="list-icon-text">
                    <i class="fa-solid fa-list-ul"></i>
                    <div>List Icon Text</div>
                </div>
                <div class="tdt-email-template-widget-card" data-widget="call-to-action">
                    <i class="fa-regular fa-comment-dots"></i>
                    <div>Call to Action</div>
                </div>
                <div class="tdt-email-template-widget-card" data-widget="navigation">
                    <i class="fa-solid fa-ellipsis"></i>
                    <div>Navigation</div>
                </div>
                <div class="tdt-email-template-widget-card" data-widget="button">
                    <i class="fa-solid fa-toggle-off"></i>
                    <div>Button</div>
                </div>
                <div class="tdt-email-template-widget-card" data-widget="image">
                    <i class="fa-regular fa-image"></i>
                    <div>Image</div>
                </div>
                <div class="tdt-email-template-widget-card" data-widget="video">
                    <i class="fa-regular fa-circle-play"></i>
                    <div>Video</div>
                </div>
                <div class="tdt-email-template-widget-card" data-widget="social">
                    <i class="fa-regular fa-thumbs-up"></i>
                    <div>Social</div>
                </div>
                <div class="tdt-email-template-widget-card" data-widget="html">
                    <i class="fa-solid fa-code"></i>
                    <div>HTML</div>
                </div>
                <div class="tdt-email-template-widget-card" data-widget="spacer">
                    <i class="fa-solid fa-grip-lines"></i>
                    <div>Spacer</div>
                </div>
                <div class="tdt-email-template-widget-card" data-widget="divider">
                    <i class="fa-solid fa-divide"></i>
                    <div>Divider</div>
                </div>
                <div class="tdt-email-template-widget-card" data-widget="product">
                    <i class="fa-solid fa-cart-shopping"></i>
                    <div>Product</div>
                </div>
                <div class="tdt-email-template-widget-card" data-widget="payment-link">
                    <i class="fa-solid fa-credit-card"></i>
                    <div>Payment Link</div>
                </div>
            </div>

            <div class="tdt-email-template-library hidden">
                <div class="library-header">
                    <input type="text" placeholder="<?php esc_attr_e('Search templates...', 'tdt-email-template'); ?>" id="library-search" />
                    <div class="library-categories">
                        <button class="category-filter active" data-category="all">All</button>
                        <button class="category-filter" data-category="newsletter">Newsletter</button>
                        <button class="category-filter" data-category="marketing">Marketing</button>
                        <button class="category-filter" data-category="ecommerce">E-commerce</button>
                        <button class="category-filter" data-category="blog">Blog</button>
                    </div>
                </div>
                <div class="library-templates">
                    <!-- Templates will be loaded here -->
                </div>
            </div>
        </div>

        <div class="tdt-email-template-canvas-container">
            <div class="tdt-email-template-canvas" id="email-canvas">
                <div class="canvas-placeholder">
                    <i class="fa-solid fa-envelope"></i>
                    <p><?php _e('Drag widgets here to start building your email template', 'tdt-email-template'); ?></p>
                </div>
            </div>
        </div>

        <div class="tdt-email-template-properties">
            <div class="tdt-email-template-property-panel">
                <div class="tdt-email-template-widget-property-panel">
                    <h4><?php _e('Properties', 'tdt-email-template'); ?></h4>
                    <p id="property_widget_name"><?php _e('No widget selected', 'tdt-email-template'); ?></p>
                </div>
                <div class="tdt-email-template-property-panel-tab-container">
                    <div>
                        <button id="property_content_tab" class="tdt-email-template-property-panel-tab property-tab-active">
                            <i class="fa-solid fa-align-left"></i> <?php _e('Content', 'tdt-email-template'); ?>
                        </button>
                        <button id="property_style_tab" class="tdt-email-template-property-panel-tab">
                            <i class="fa-solid fa-palette"></i> <?php _e('Style', 'tdt-email-template'); ?>
                        </button>
                        <button id="property_advanced_tab" class="tdt-email-template-property-panel-tab">
                            <i class="fa-solid fa-cogs"></i> <?php _e('Advanced', 'tdt-email-template'); ?>
                        </button>
                    </div>
                </div>
            </div>

            <div class="tdt-email-template-property">
                <div class="tdt-email-template-property-content-setting active">
                    <!-- Content settings will be loaded here -->
                </div>
                <div class="tdt-email-template-property-style-setting">
                    <!-- Style settings will be loaded here -->
                </div>
                <div class="tdt-email-template-property-advanced-setting">
                    <!-- Advanced settings will be loaded here -->
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Settings Modal -->
<div id="template-settings-modal" class="tdt-modal hidden">
    <div class="tdt-modal-content">
        <div class="tdt-modal-header">
            <h2><?php _e('Template Settings', 'tdt-email-template'); ?></h2>
            <button class="tdt-modal-close">&times;</button>
        </div>

        <div class="tdt-modal-body">
            <div class="tdt-settings-tabs">
                <button class="tdt-settings-tab active" data-tab="template">
                    <i class="fa-solid fa-file"></i> <?php _e('Template', 'tdt-email-template'); ?>
                </button>
                <button class="tdt-settings-tab" data-tab="canvas">
                    <i class="fa-solid fa-paintbrush"></i> <?php _e('Canvas', 'tdt-email-template'); ?>
                </button>
                <button class="tdt-settings-tab" data-tab="typography">
                    <i class="fa-solid fa-font"></i> <?php _e('Typography', 'tdt-email-template'); ?>
                </button>
            </div>

            <div class="tdt-settings-content">
                <!-- Template Settings -->
                <div class="tdt-settings-panel active" id="template-settings-panel">
                    <div class="setting-group">
                        <label for="body-width"><?php _e('Body Width', 'tdt-email-template'); ?></label>
                        <input type="text" id="body-width" value="800px" />
                    </div>

                    <div class="setting-group">
                        <label for="body-background"><?php _e('Body Background', 'tdt-email-template'); ?></label>
                        <input type="color" id="body-background" value="#f1f4f9" />
                        <input type="text" id="body-background-hex" value="#f1f4f9" />
                    </div>

                    <div class="setting-group">
                        <label for="template-direction"><?php _e('Text Direction', 'tdt-email-template'); ?></label>
                        <select id="template-direction">
                            <option value="ltr">Left to Right</option>
                            <option value="rtl">Right to Left</option>
                        </select>
                    </div>
                </div>

                <!-- Canvas Settings -->
                <div class="tdt-settings-panel" id="canvas-settings-panel">
                    <div class="setting-group">
                        <label for="canvas-width"><?php _e('Canvas Width', 'tdt-email-template'); ?></label>
                        <input type="text" id="canvas-width" value="800px" />
                    </div>

                    <div class="setting-group">
                        <label for="canvas-background"><?php _e('Canvas Background', 'tdt-email-template'); ?></label>
                        <input type="color" id="canvas-background" value="#ffffff" />
                        <input type="text" id="canvas-background-hex" value="#ffffff" />
                    </div>

                    <div class="setting-group">
                        <label for="canvas-padding"><?php _e('Canvas Padding', 'tdt-email-template'); ?></label>
                        <input type="text" id="canvas-padding" value="20px" />
                    </div>

                    <div class="setting-group">
                        <label for="canvas-margin"><?php _e('Canvas Margin', 'tdt-email-template'); ?></label>
                        <input type="text" id="canvas-margin" value="0 auto" />
                    </div>

                    <div class="setting-group">
                        <label for="canvas-border-radius"><?php _e('Border Radius', 'tdt-email-template'); ?></label>
                        <input type="text" id="canvas-border-radius" value="3px" />
                    </div>

                    <div class="setting-group">
                        <label for="canvas-box-shadow"><?php _e('Box Shadow', 'tdt-email-template'); ?></label>
                        <input type="text" id="canvas-box-shadow" value="0 3px 10px rgba(0,0,0,0.15)" />
                    </div>
                </div>

                <!-- Typography Settings -->
                <div class="tdt-settings-panel" id="typography-settings-panel">
                    <div class="typography-section">
                        <h4><?php _e('Headings', 'tdt-email-template'); ?></h4>
                        <div class="setting-group">
                            <label><?php _e('Font Family', 'tdt-email-template'); ?></label>
                            <input type="text" class="typography-heading-font-family" value="Arial, sans-serif" />
                        </div>
                        <div class="setting-group">
                            <label><?php _e('Font Size', 'tdt-email-template'); ?></label>
                            <input type="text" class="typography-heading-font-size" value="24px" />
                        </div>
                        <div class="setting-group">
                            <label><?php _e('Font Weight', 'tdt-email-template'); ?></label>
                            <select class="typography-heading-font-weight">
                                <option value="normal">Normal</option>
                                <option value="bold" selected>Bold</option>
                                <option value="100">100</option>
                                <option value="200">200</option>
                                <option value="300">300</option>
                                <option value="400">400</option>
                                <option value="500">500</option>
                                <option value="600">600</option>
                                <option value="700">700</option>
                                <option value="800">800</option>
                                <option value="900">900</option>
                            </select>
                        </div>
                        <div class="setting-group">
                            <label><?php _e('Color', 'tdt-email-template'); ?></label>
                            <input type="color" class="typography-heading-color" value="#333333" />
                        </div>
                    </div>

                    <div class="typography-section">
                        <h4><?php _e('Paragraph', 'tdt-email-template'); ?></h4>
                        <div class="setting-group">
                            <label><?php _e('Font Family', 'tdt-email-template'); ?></label>
                            <input type="text" class="typography-paragraph-font-family" value="Arial, sans-serif" />
                        </div>
                        <div class="setting-group">
                            <label><?php _e('Font Size', 'tdt-email-template'); ?></label>
                            <input type="text" class="typography-paragraph-font-size" value="14px" />
                        </div>
                        <div class="setting-group">
                            <label><?php _e('Line Height', 'tdt-email-template'); ?></label>
                            <input type="text" class="typography-paragraph-line-height" value="1.4" />
                        </div>
                        <div class="setting-group">
                            <label><?php _e('Color', 'tdt-email-template'); ?></label>
                            <input type="color" class="typography-paragraph-color" value="#666666" />
                        </div>
                    </div>

                    <div class="typography-section">
                        <h4><?php _e('Links', 'tdt-email-template'); ?></h4>
                        <div class="setting-group">
                            <label><?php _e('Color', 'tdt-email-template'); ?></label>
                            <input type="color" class="typography-link-color" value="#0073aa" />
                        </div>
                        <div class="setting-group">
                            <label><?php _e('Hover Color', 'tdt-email-template'); ?></label>
                            <input type="color" class="typography-link-hover-color" value="#00a0d2" />
                        </div>
                        <div class="setting-group">
                            <label><?php _e('Text Decoration', 'tdt-email-template'); ?></label>
                            <select class="typography-link-decoration">
                                <option value="none">None</option>
                                <option value="underline" selected>Underline</option>
                                <option value="overline">Overline</option>
                                <option value="line-through">Line Through</option>
                            </select>
                        </div>
                    </div>

                    <div class="typography-section">
                        <h4><?php _e('Buttons', 'tdt-email-template'); ?></h4>
                        <div class="setting-group">
                            <label><?php _e('Background Color', 'tdt-email-template'); ?></label>
                            <input type="color" class="typography-button-background" value="#63748e" />
                        </div>
                        <div class="setting-group">
                            <label><?php _e('Text Color', 'tdt-email-template'); ?></label>
                            <input type="color" class="typography-button-color" value="#ffffff" />
                        </div>
                        <div class="setting-group">
                            <label><?php _e('Hover Background', 'tdt-email-template'); ?></label>
                            <input type="color" class="typography-button-hover-background" value="#314158" />
                        </div>
                        <div class="setting-group">
                            <label><?php _e('Border Radius', 'tdt-email-template'); ?></label>
                            <input type="text" class="typography-button-border-radius" value="50px" />
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="tdt-modal-footer">
            <button class="button button-primary" id="save-settings">
                <i class="fa-solid fa-check"></i> <?php _e('Save Settings', 'tdt-email-template'); ?>
            </button>
            <button class="button button-secondary" id="reset-settings">
                <i class="fa-solid fa-undo"></i> <?php _e('Reset to Default', 'tdt-email-template'); ?>
            </button>
            <button class="button button-secondary" id="cancel-settings">
                <i class="fa-solid fa-times"></i> <?php _e('Cancel', 'tdt-email-template'); ?>
            </button>
        </div>
    </div>
</div>