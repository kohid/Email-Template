# Installation Guide

## Quick Start

### 1. Upload the Plugin

**Method 1: Via WordPress Admin**

1. Go to WordPress admin → Plugins → Add New
2. Click "Upload Plugin"
3. Choose the zip file of this plugin
4. Click "Install Now"
5. Activate the plugin

**Method 2: Via FTP/File Manager**

1. Upload the `tdt-email-template` folder to `/wp-content/plugins/`
2. Go to WordPress admin → Plugins
3. Find "TDT Email Template Builder" and click "Activate"

### 2. First-Time Setup

After activation, the plugin will automatically:

- Create necessary database tables
- Set up default settings
- Create the admin menu

### 3. Access the Builder

1. In WordPress admin, look for "Email Templates" in the sidebar menu
2. Click "Add New Template" to start building your first email template

## Troubleshooting Common Errors

### Critical Error After Activation

If you see a critical error, check the following:

1. **PHP Version**: Ensure you're running PHP 7.0 or higher
2. **WordPress Version**: Ensure WordPress 5.0 or higher
3. **Check Error Log**: Enable WordPress debugging to see specific errors

#### Enable WordPress Debugging

Add these lines to your `wp-config.php`:

```php
define('WP_DEBUG', true);
define('WP_DEBUG_LOG', true);
define('WP_DEBUG_DISPLAY', false);
```

Then check `/wp-content/debug.log` for specific errors.

### Common Issues & Fixes

#### Issue: Missing FontAwesome Icons

**Fix**: The plugin uses your FontAwesome Kit. To use a different one:

1. Edit `includes/admin/views/email-builder.php`
2. Replace the FontAwesome kit URL on line 1 with your own kit

#### Issue: Database Table Not Created

**Fix**: Manually run the table creation:

1. Go to phpMyAdmin or your database manager
2. Run this SQL query:

```sql
CREATE TABLE IF NOT EXISTS `wp_tdt_email_templates` (
    `id` bigint(20) NOT NULL AUTO_INCREMENT,
    `name` varchar(255) NOT NULL,
    `slug` varchar(255) NOT NULL,
    `description` text,
    `content` longtext,
    `settings` longtext,
    `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
    `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    `status` varchar(20) DEFAULT 'draft',
    PRIMARY KEY (`id`),
    UNIQUE KEY `slug` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

(Replace `wp_` with your database prefix if different)

#### Issue: Blank Page After Clicking "Add New Template"

**Fix**: This usually means a JavaScript error. Check:

1. Browser console for errors (F12 → Console tab)
2. Ensure jQuery and jQuery UI are loaded
3. Clear browser cache

#### Issue: Cannot Save Templates

**Fix**: Check these:

1. Database connection is working
2. User has proper permissions (administrator role)
3. Check AJAX endpoint in browser Network tab (F12 → Network)

### Missing Images

The plugin references these images:

- `assets/images/logo.png` - Plugin logo (60x60px)
- `assets/images/placeholder.png` - Default placeholder image (800x600px)

**Temporary Fix**: The plugin will work without these images, but you should add them:

1. Create simple images with these dimensions
2. Or update the references in the code to use your own images
3. Or use WordPress default placeholders

## File Permissions

Ensure these directories are writable:

- `/wp-content/plugins/tdt-email-template/`
- `/wp-content/uploads/` (for exported templates)

Set permissions to `755` for directories and `644` for files.

## Server Requirements

- **PHP**: 7.0 or higher (7.4+ recommended)
- **WordPress**: 5.0 or higher (latest version recommended)
- **MySQL**: 5.6 or higher
- **Memory Limit**: 64MB minimum (128MB recommended)
- **Max Execution Time**: 30 seconds minimum

## Support

If you continue to have issues:

1. Check the `debug.log` file
2. Disable other plugins to check for conflicts
3. Switch to a default WordPress theme temporarily
4. Check server error logs

## Next Steps

After successful installation:

1. Go to Email Templates → Settings to configure defaults
2. Create your first template
3. Test the template with preview
4. Export and use in your email campaigns
