<?php
/**
 * Templates Management Class
 * Handles template CRUD operations
 */

if (!defined('ABSPATH')) {
    exit;
}

class TDT_Email_Template_Templates {
    
    /**
     * Initialize the templates class
     */
    public static function init() {
        // Initialize templates functionality
    }
    
    /**
     * Get template by ID
     */
    public static function get($template_id) {
        return TDT_Email_Template_Renderer::get_template($template_id);
    }
    
    /**
     * Get all templates
     */
    public static function get_all($args = array()) {
        return TDT_Email_Template_Renderer::get_templates($args);
    }
    
    /**
     * Create template
     */
    public static function create($data) {
        global $wpdb;
        
        $result = $wpdb->insert(
            $wpdb->prefix . 'tdt_email_templates',
            array(
                'name' => sanitize_text_field($data['name']),
                'slug' => sanitize_title($data['name']),
                'description' => sanitize_textarea_field($data['description'] ?? ''),
                'content' => maybe_serialize($data['content'] ?? ''),
                'settings' => maybe_serialize($data['settings'] ?? array()),
                'status' => sanitize_text_field($data['status'] ?? 'draft')
            ),
            array('%s', '%s', '%s', '%s', '%s', '%s')
        );
        
        if ($result) {
            return $wpdb->insert_id;
        }
        
        return false;
    }
    
    /**
     * Update template
     */
    public static function update($template_id, $data) {
        global $wpdb;
        
        $update_data = array();
        
        if (isset($data['name'])) {
            $update_data['name'] = sanitize_text_field($data['name']);
            $update_data['slug'] = sanitize_title($data['name']);
        }
        
        if (isset($data['description'])) {
            $update_data['description'] = sanitize_textarea_field($data['description']);
        }
        
        if (isset($data['content'])) {
            $update_data['content'] = maybe_serialize($data['content']);
        }
        
        if (isset($data['settings'])) {
            $update_data['settings'] = maybe_serialize($data['settings']);
        }
        
        if (isset($data['status'])) {
            $update_data['status'] = sanitize_text_field($data['status']);
        }
        
        if (empty($update_data)) {
            return false;
        }
        
        $result = $wpdb->update(
            $wpdb->prefix . 'tdt_email_templates',
            $update_data,
            array('id' => $template_id),
            array_fill(0, count($update_data), '%s'),
            array('%d')
        );
        
        return $result !== false;
    }
    
    /**
     * Delete template
     */
    public static function delete($template_id) {
        global $wpdb;
        
        return $wpdb->delete(
            $wpdb->prefix . 'tdt_email_templates',
            array('id' => $template_id),
            array('%d')
        );
    }
    
    /**
     * Duplicate template
     */
    public static function duplicate($template_id) {
        $template = self::get($template_id);
        
        if (!$template) {
            return false;
        }
        
        $data = array(
            'name' => $template->name . ' (Copy)',
            'description' => $template->description,
            'content' => maybe_unserialize($template->content),
            'settings' => maybe_unserialize($template->settings),
            'status' => 'draft'
        );
        
        return self::create($data);
    }
}

// Initialize templates class
add_action('init', array('TDT_Email_Template_Templates', 'init'));