<?php

/**
 * Templates List View
 */

if (!defined('ABSPATH')) {
    exit;
}

// Get templates
$templates = TDT_Email_Template_Renderer::get_templates(array(
    'limit' => 20,
    'offset' => 0
));

?>

<div class="wrap tdt-email-templates-list">
    <h1 class="wp-heading-inline"><?php _e('Email Templates', 'tdt-email-template'); ?></h1>
    <a href="<?php echo esc_url(admin_url('admin.php?page=tdt-email-template-builder')); ?>" class="page-title-action"><?php _e('Add New Template', 'tdt-email-template'); ?></a>

    <?php if (isset($_GET['message'])): ?>
        <div class="notice notice-success is-dismissible">
            <p><?php echo esc_html($_GET['message']); ?></p>
        </div>
    <?php endif; ?>

    <div class="tdt-templates-grid">
        <?php if (!empty($templates)): ?>
            <?php foreach ($templates as $template): ?>
                <div class="tdt-template-card">
                    <div class="tdt-template-preview">
                        <i class="fa-solid fa-envelope"></i>
                        <div class="tdt-template-meta">
                            <h3><?php echo esc_html($template->name); ?></h3>
                            <p><?php echo esc_html('Created: ' . date('M j, Y', strtotime($template->created_at))); ?></p>
                        </div>
                    </div>

                    <div class="tdt-template-actions">
                        <a href="<?php echo esc_url(admin_url('admin.php?page=tdt-email-template-builder&template_id=' . $template->id)); ?>" class="button button-primary">
                            <i class="fa-solid fa-edit"></i> <?php _e('Edit', 'tdt-email-template'); ?>
                        </a>
                        <a href="#" class="button button-secondary tdt-preview-template" data-template-id="<?php echo esc_attr($template->id); ?>">
                            <i class="fa-solid fa-eye"></i> <?php _e('Preview', 'tdt-email-template'); ?>
                        </a>
                        <a href="#" class="button button-secondary tdt-duplicate-template" data-template-id="<?php echo esc_attr($template->id); ?>">
                            <i class="fa-solid fa-copy"></i> <?php _e('Duplicate', 'tdt-email-template'); ?>
                        </a>
                        <a href="#" class="button button-link-delete tdt-delete-template" data-template-id="<?php echo esc_attr($template->id); ?>">
                            <i class="fa-solid fa-trash"></i> <?php _e('Delete', 'tdt-email-template'); ?>
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="tdt-no-templates">
                <i class="fa-solid fa-inbox"></i>
                <h3><?php _e('No templates found', 'tdt-email-template'); ?></h3>
                <p><?php _e('Create your first email template to get started.', 'tdt-email-template'); ?></p>
                <a href="<?php echo esc_url(admin_url('admin.php?page=tdt-email-template-builder')); ?>" class="button button-primary button-large">
                    <i class="fa-solid fa-plus"></i> <?php _e('Create Template', 'tdt-email-template'); ?>
                </a>
            </div>
        <?php endif; ?>
    </div>
</div>

<style>
    .tdt-templates-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 20px;
        margin-top: 20px;
    }

    .tdt-template-card {
        background: #fff;
        border: 1px solid #ddd;
        border-radius: 8px;
        padding: 20px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
    }

    .tdt-template-card:hover {
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
        transform: translateY(-2px);
    }

    .tdt-template-preview {
        display: flex;
        align-items: center;
        gap: 15px;
        margin-bottom: 15px;
        padding-bottom: 15px;
        border-bottom: 1px solid #eee;
    }

    .tdt-template-preview i {
        font-size: 32px;
        color: #00a5f4;
    }

    .tdt-template-meta h3 {
        margin: 0 0 5px 0;
        font-size: 16px;
        color: #333;
    }

    .tdt-template-meta p {
        margin: 0;
        font-size: 12px;
        color: #666;
    }

    .tdt-template-actions {
        display: flex;
        gap: 8px;
        flex-wrap: wrap;
    }

    .tdt-template-actions .button {
        display: flex;
        align-items: center;
        gap: 5px;
        padding: 6px 12px;
        font-size: 12px;
        text-decoration: none;
    }

    .tdt-no-templates {
        text-align: center;
        padding: 60px 20px;
        background: #f8f9fa;
        border-radius: 8px;
        border: 2px dashed #ddd;
    }

    .tdt-no-templates i {
        font-size: 48px;
        color: #ccc;
        margin-bottom: 20px;
    }

    .tdt-no-templates h3 {
        margin: 0 0 10px 0;
        color: #666;
    }

    .tdt-no-templates p {
        color: #999;
        margin-bottom: 20px;
    }

    .button-link-delete {
        color: #dc3545;
        border-color: #dc3545;
    }

    .button-link-delete:hover {
        background: #dc3545;
        color: #fff;
    }

    @media (max-width: 768px) {
        .tdt-templates-grid {
            grid-template-columns: 1fr;
        }

        .tdt-template-actions {
            flex-direction: column;
        }
    }
</style>