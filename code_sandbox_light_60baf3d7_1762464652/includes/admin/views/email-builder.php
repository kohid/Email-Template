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
                <div class="tdt-email-template-header-toggle-btn tdt-email-template-header-toggle-tablet" data-device="tablet">
                    <i class="fa-solid fa-tablet-screen-button"></i>
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

    <!-- rest of builder unchanged -->
