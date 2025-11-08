# Quick Fix for Critical Errors

## If you're seeing: "There has been a critical error on this website"

Follow these steps in order:

### Step 1: Check PHP Errors
1. Enable WordPress debugging by adding to `wp-config.php`:
```php
define('WP_DEBUG', true);
define('WP_DEBUG_LOG', true);
define('WP_DEBUG_DISPLAY', false);
```

2. Try activating the plugin again
3. Check `/wp-content/debug.log` for the exact error

### Step 2: Common Syntax Errors Fixed
The following files had syntax errors that have been corrected:
- ✅ `includes/admin/views/templates-list.php` - Line 41 (URL concatenation)
- ✅ `includes/class-template-renderer.php` - Line 185, 191 (SQL query quotes)
- ✅ `includes/admin/views/email-builder.php` - Line 277 (HTML attribute)
- ✅ `includes/class-ajax-handler.php` - Line 367, 443 (Missing quotes)

### Step 3: Verify Files Are Updated
Make sure you have the latest versions of these files with all corrections applied.

### Step 4: Clear All Caches
1. WordPress cache (if using caching plugin)
2. Browser cache (Ctrl+F5)
3. Server cache (if applicable)
4. OpCache (if enabled on server)

### Step 5: Re-upload Plugin
1. Deactivate the plugin
2. Delete the plugin folder via FTP or File Manager
3. Re-upload the corrected plugin files
4. Activate the plugin

### Step 6: Check File Structure
Ensure these files exist:
```
tdt-email-template/
├── tdt-email-template.php ✓
├── includes/
│   ├── admin/
│   │   ├── class-admin.php ✓
│   │   ├── class-templates.php ✓
│   │   ├── class-widget-manager.php ✓
│   │   └── views/
│   │       ├── email-builder.php ✓
│   │       ├── templates-list.php ✓
│   │       └── settings.php ✓
│   ├── class-ajax-handler.php ✓
│   ├── class-frontend.php ✓
│   └── class-template-renderer.php ✓
└── assets/
    ├── css/
    │   ├── admin.css ✓
    │   └── frontend.css ✓
    └── js/
        ├── admin.js ✓
        └── frontend.js ✓
```

### Step 7: Manual Database Table Creation
If the plugin activates but doesn't work, create the table manually:

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

### Step 8: Check PHP Version
Run this test file to check compatibility:

Create `test-plugin.php` in plugin directory:
```php
<?php
echo 'PHP Version: ' . PHP_VERSION . '<br>';
echo 'WordPress Version: ' . get_bloginfo('version') . '<br>';
echo 'Memory Limit: ' . ini_get('memory_limit') . '<br>';

if (version_compare(PHP_VERSION, '7.0.0', '<')) {
    echo '<strong style="color:red;">Error: PHP 7.0 or higher required!</strong>';
} else {
    echo '<strong style="color:green;">PHP version OK!</strong>';
}
?>
```

### Step 9: Test in Isolation
1. Deactivate ALL other plugins
2. Switch to a default WordPress theme (Twenty Twenty-Three)
3. Try activating this plugin
4. If it works, reactivate other plugins one by one to find conflicts

### Step 10: Still Not Working?

**Option A: Safe Mode Activation**
Create a minimal version by commenting out includes in `tdt-email-template.php`:

```php
private function includes() {
    if (is_admin()) {
        require_once TDT_EMAIL_TEMPLATE_PLUGIN_DIR . 'includes/admin/class-admin.php';
        // Comment out others temporarily
        // require_once TDT_EMAIL_TEMPLATE_PLUGIN_DIR . 'includes/admin/class-templates.php';
        // require_once TDT_EMAIL_TEMPLATE_PLUGIN_DIR . 'includes/admin/class-widget-manager.php';
    }
    
    // require_once TDT_EMAIL_TEMPLATE_PLUGIN_DIR . 'includes/class-frontend.php';
    // require_once TDT_EMAIL_TEMPLATE_PLUGIN_DIR . 'includes/class-ajax-handler.php';
    // require_once TDT_EMAIL_TEMPLATE_PLUGIN_DIR . 'includes/class-template-renderer.php';
}
```

Then uncomment them one by one to find which file is causing issues.

**Option B: Get Detailed Error**
Instead of using wp-config.php debugging, add this to the top of `tdt-email-template.php`:

```php
error_reporting(E_ALL);
ini_set('display_errors', 1);
```

This will show errors directly on the page.

## Prevention Checklist

Before activating, verify:
- [ ] PHP 7.0+
- [ ] WordPress 5.0+
- [ ] All files uploaded correctly
- [ ] File permissions correct (755/644)
- [ ] No conflicting plugins active
- [ ] Enough memory (64MB+)

## Emergency Deactivation

If you can't access WordPress admin:

**Method 1: Via Database**
```sql
UPDATE wp_options 
SET option_value = '' 
WHERE option_name = 'active_plugins';
```

**Method 2: Via FTP**
Rename the plugin folder from `tdt-email-template` to `tdt-email-template-disabled`

## Contact for Support
After trying all these steps, if issues persist, gather:
1. PHP version
2. WordPress version
3. Error from debug.log
4. Server environment (Apache/Nginx)
5. Other active plugins list