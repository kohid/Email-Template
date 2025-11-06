<?php

/**
 * Syntax Test Script
 * Run this file directly to test for PHP syntax errors
 */

error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h1>TDT Email Template Plugin - Syntax Test</h1>";

$files_to_test = array(
    'tdt-email-template.php',
    'includes/admin/class-admin.php',
    'includes/admin/class-templates.php',
    'includes/admin/class-widget-manager.php',
    'includes/class-ajax-handler.php',
    'includes/class-frontend.php',
    'includes/class-template-renderer.php',
);

$errors = array();
$success = array();

foreach ($files_to_test as $file) {
    $full_path = __DIR__ . '/' . $file;

    if (!file_exists($full_path)) {
        $errors[] = "❌ File not found: {$file}";
        continue;
    }

    // Try to parse the file
    $output = array();
    $return_var = 0;
    exec("php -l " . escapeshellarg($full_path), $output, $return_var);

    if ($return_var === 0) {
        $success[] = "✅ {$file}";
    } else {
        $errors[] = "❌ {$file}: " . implode("\n", $output);
    }
}

echo "<h2>Test Results:</h2>";

if (!empty($success)) {
    echo "<h3 style='color: green;'>Passed:</h3>";
    echo "<ul>";
    foreach ($success as $msg) {
        echo "<li>{$msg}</li>";
    }
    echo "</ul>";
}

if (!empty($errors)) {
    echo "<h3 style='color: red;'>Failed:</h3>";
    echo "<ul>";
    foreach ($errors as $msg) {
        echo "<li>" . nl2br(htmlspecialchars($msg)) . "</li>";
    }
    echo "</ul>";
} else {
    echo "<h3 style='color: green;'>✅ All files passed syntax check!</h3>";
    echo "<p><strong>Next steps:</strong></p>";
    echo "<ol>";
    echo "<li>Delete this test file (test-syntax.php)</li>";
    echo "<li>Activate the plugin in WordPress</li>";
    echo "<li>Check WordPress admin for 'Email Templates' menu</li>";
    echo "</ol>";
}

echo "<hr>";
echo "<h3>System Information:</h3>";
echo "<ul>";
echo "<li><strong>PHP Version:</strong> " . PHP_VERSION . "</li>";
echo "<li><strong>Required:</strong> 7.0 or higher</li>";
echo "<li><strong>Status:</strong> " . (version_compare(PHP_VERSION, '7.0.0', '>=') ? '<span style="color:green;">✓ OK</span>' : '<span style="color:red;">✗ Upgrade needed</span>') . "</li>";
echo "</ul>";
