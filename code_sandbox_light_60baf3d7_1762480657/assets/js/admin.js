(function($) {
    'use strict';

    // Email Template Builder Class
    window.TDTEmailTemplateBuilder = function() {
        this.widgets = [];
        this.selectedWidget = null;
        this.templateSettings = {};
        this.isDragging = false;
        this.draggedWidget = null;
        
        this.init();
    };

    TDTEmailTemplateBuilder.prototype = {
        
        /**
         * Initialize the builder
         */
        init: function() {
            this.bindEvents();
            this.loadTemplateSettings();
            this.initializeCanvas();
            this.loadWidgets();
        },

        /**
         * Bind all event handlers
         */
        bindEvents: function() {
            var self = this;

            // Header controls
            $(document).on('click', '#template-settings', function() {
                self.openSettingsModal();
            });

            $(document).on('click', '#save-template', function() {
                self.saveTemplate();
            });

            $(document).on('click', '#preview-template', function() {
                self.previewTemplate();
            });

            // Device toggle
            $(document).on('click', '.tdt-email-template-header-toggle-btn', function() {
                var device = $(this).data('device');
                self.switchDevice(device);
            });

            // Menu dropdown
            $(document).on('click', '.tdt-email-template-header-menu-icon', function() {
                $(this).siblings('.tdt-email-template-header-menu').toggleClass('hidden');
            });

            // Close menu when clicking outside
            $(document).on('click', function(e) {
                if (!$(e.target).closest('.tdt-email-template-header-menu-container').length) {
                    $('.tdt-email-template-header-menu').addClass('hidden');
                }
            });

            // Tab switching
            $(document).on('click', '.tdt-email-template-panel-component-tab', function() {
                var tab = $(this).data('tab');
                self.switchPanelTab(tab);
            });

            $(document).on('click', '.tdt-email-template-property-panel-tab', function() {
                var tab = $(this).attr('id').replace('property_', '').replace('_tab', '');
                self.switchPropertyTab(tab);
            });

            // Widget dragging
            $(document).on('mousedown', '.tdt-email-template-widget-card', function(e) {
                self.startDrag(e, $(this));
            });

            $(document).on('mousemove', function(e) {
                if (self.isDragging) {
                    self.updateDrag(e);
                }
            });

            $(document).on('mouseup', function(e) {
                if (self.isDragging) {
                    self.endDrag(e);
                }
            });

            // Canvas drop zone
            $(document).on('dragover', '#email-canvas', function(e) {
                e.preventDefault();
                $(this).addClass('drag-over');
            });

            $(document).on('dragleave', '#email-canvas', function(e) {
                if (!$(this).has(e.relatedTarget).length) {
                    $(this).removeClass('drag-over');
                }
            });

            $(document).on('drop', '#email-canvas', function(e) {
                e.preventDefault();
                $(this).removeClass('drag-over');
                self.handleDrop(e);
            });

            // Widget selection
            $(document).on('click', '.canvas-widget', function(e) {
                e.stopPropagation();
                self.selectWidget($(this));
            });

            // Widget controls
            $(document).on('click', '.widget-control-btn', function(e) {
                e.stopPropagation();
                var action = $(this).data('action');
                var widgetId = $(this).closest('.canvas-widget').data('widget-id');
                self.handleWidgetAction(widgetId, action);
            });

            // Settings modal
            $(document).on('click', '.tdt-settings-tab', function() {
                var tab = $(this).data('tab');
                self.switchSettingsTab(tab);
            });

            $(document).on('click', '#save-settings', function() {
                self.saveSettings();
            });

            $(document).on('click', '#reset-settings', function() {
                self.resetSettings();
            });

            $(document).on('click', '#cancel-settings', function() {
                self.closeSettingsModal();
            });

            $(document).on('click', '.tdt-modal-close', function() {
                self.closeSettingsModal();
            });

            // Color picker sync
            $(document).on('change', 'input[type="color"]', function() {
                var hexInput = $(this).siblings('input[type="text"]');
                if (hexInput.length) {
                    hexInput.val($(this).val());
                }
            });

            $(document).on('input', 'input[type="text"][id$="-hex"]', function() {
                var colorInput = $(this).siblings('input[type="color"]');
                if (colorInput.length && /^#[0-9A-F]{6}$/i.test($(this).val())) {
                    colorInput.val($(this).val());
                }
            });

            // Menu actions
            $(document).on('click', '.tdt-email-template-header-menu li', function() {
                var action = $(this).data('action');
                self.handleMenuAction(action);
            });
        },

        /**
         * Load template settings from WordPress
         */
        loadTemplateSettings: function() {
            var self = this;
            
            $.ajax({
                url: tdtEmailTemplate.ajax_url,
                type: 'POST',
                data: {
                    action: 'tdt_get_template_settings',
                    nonce: tdtEmailTemplate.nonce
                },
                success: function(response) {
                    if (response.success) {
                        self.templateSettings = response.data;
                        self.applySettings();
                    }
                }
            });
        },

        /**
         * Apply settings to the canvas
         */
        applySettings: function() {
            var settings = this.templateSettings;
            
            // Apply body settings
            if (settings.body_width) {
                $('#email-canvas').css('max-width', settings.body_width);
            }
            
            if (settings.body_background) {
                $('.tdt-email-template-canvas-container').css('background-color', settings.body_background);
            }
            
            // Apply canvas settings
            if (settings.canvas_width) {
                $('#email-canvas').css('width', settings.canvas_width);
            }
            
            if (settings.canvas_background) {
                $('#email-canvas').css('background-color', settings.canvas_background);
            }
            
            if (settings.canvas_padding) {
                $('#email-canvas').css('padding', settings.canvas_padding);
            }
            
            if (settings.canvas_margin) {
                $('#email-canvas').css('margin', settings.canvas_margin);
            }
        },

        /**
         * Initialize the canvas
         */
        initializeCanvas: function() {
            // Make canvas droppable
            var self = this;
            
            $('#email-canvas').sortable({
                placeholder: 'drop-zone',
                tolerance: 'pointer',
                start: function(e, ui) {
                    ui.placeholder.height(ui.item.height());
                },
                update: function() {
                    self.updateWidgetOrder();
                }
            });
        },

        /**
         * Load available widgets
         */
        loadWidgets: function() {
            var self = this;
            
            $.ajax({
                url: tdtEmailTemplate.ajax_url,
                type: 'POST',
                data: {
                    action: 'tdt_get_widgets',
                    nonce: tdtEmailTemplate.nonce
                },
                success: function(response) {
                    if (response.success) {
                        self.widgets = response.data;
                    }
                }
            });
        },

        /**
         * Start dragging a widget
         */
        startDrag: function(e, $widget) {
            this.isDragging = true;
            this.draggedWidget = $widget;
            
            $widget.addClass('dragging');
            
            // Create drag ghost
            var ghost = $widget.clone()
                .addClass('drag-ghost')
                .css({
                    position: 'fixed',
                    zIndex: 9999,
                    pointerEvents: 'none',
                    transform: 'rotate(5deg)',
                    opacity: 0.8
                })
                .appendTo('body');
            
            this.updateDrag(e);
        },

        /**
         * Update drag position
         */
        updateDrag: function(e) {
            if (!this.isDragging) return;
            
            $('.drag-ghost').css({
                left: e.clientX - 60,
                top: e.clientY - 40
            });
        },

        /**
         * End dragging
         */
        endDrag: function(e) {
            if (!this.isDragging) return;
            
            this.isDragging = false;
            
            if (this.draggedWidget) {
                this.draggedWidget.removeClass('dragging');
            }
            
            $('.drag-ghost').remove();
            
            // Check if dropped on canvas
            var $canvas = $('#email-canvas');
            var canvasRect = $canvas[0].getBoundingClientRect();
            
            if (e.clientX >= canvasRect.left && e.clientX <= canvasRect.right &&
                e.clientY >= canvasRect.top && e.clientY <= canvasRect.bottom) {
                
                var widgetType = this.draggedWidget.data('widget');
                this.addWidgetToCanvas(widgetType, e);
            }
            
            this.draggedWidget = null;
        },

        /**
         * Handle widget drop
         */
        handleDrop: function(e) {
            // Handled in endDrag
        },

        /**
         * Add widget to canvas
         */
        addWidgetToCanvas: function(widgetType, e) {
            var self = this;
            
            $.ajax({
                url: tdtEmailTemplate.ajax_url,
                type: 'POST',
                data: {
                    action: 'tdt_get_widget_html',
                    widget_type: widgetType,
                    nonce: tdtEmailTemplate.nonce
                },
                success: function(response) {
                    if (response.success) {
                        var $newWidget = $(response.data.html);
                        var widgetId = 'widget_' + Date.now();
                        
                        $newWidget.attr('data-widget-id', widgetId);
                        $newWidget.addClass('canvas-widget');
                        
                        // Remove placeholder if exists
                        $('#email-canvas .canvas-placeholder').remove();
                        
                        // Add to canvas
                        $('#email-canvas').append($newWidget);
                        
                        // Select the new widget
                        self.selectWidget($newWidget);
                    }
                }
            });
        },

        /**
         * Select a widget
         */
        selectWidget: function($widget) {
            // Remove previous selection
            $('.canvas-widget').removeClass('selected');
            
            // Select new widget
            $widget.addClass('selected');
            this.selectedWidget = $widget;
            
            // Update properties panel
            this.updatePropertiesPanel($widget);
        },

        /**
         * Update properties panel
         */
        updatePropertiesPanel: function($widget) {
            var widgetType = $widget.data('widget-type');
            var widgetName = $widget.data('widget-name') || widgetType;
            
            $('#property_widget_name').text(widgetName);
            
            // Load widget properties
            this.loadWidgetProperties(widgetType);
        },

        /**
         * Load widget properties
         */
        loadWidgetProperties: function(widgetType) {
            var self = this;
            
            $.ajax({
                url: tdtEmailTemplate.ajax_url,
                type: 'POST',
                data: {
                    action: 'tdt_get_widget_properties',
                    widget_type: widgetType,
                    nonce: tdtEmailTemplate.nonce
                },
                success: function(response) {
                    if (response.success) {
                        $('.tdt-email-template-property-content-setting').html(response.data.content);
                        $('.tdt-email-template-property-style-setting').html(response.data.style);
                        $('.tdt-email-template-property-advanced-setting').html(response.data.advanced);
                    }
                }
            });
        },

        /**
         * Handle widget actions
         */
        handleWidgetAction: function(widgetId, action) {
            var $widget = $('[data-widget-id="' + widgetId + '"]');
            
            switch(action) {
                case 'delete':
                    if (confirm('Are you sure you want to delete this widget?')) {
                        $widget.remove();
                        if (this.selectedWidget && this.selectedWidget[0] === $widget[0]) {
                            this.selectedWidget = null;
                            $('#property_widget_name').text('No widget selected');
                        }
                    }
                    break;
                    
                case 'duplicate':
                    var $clone = $widget.clone();
                    var newId = 'widget_' + Date.now();
                    $clone.attr('data-widget-id', newId);
                    $widget.after($clone);
                    break;
            }
        },

        /**
         * Switch panel tabs
         */
        switchPanelTab: function(tab) {
            $('.tdt-email-template-panel-component-tab').removeClass('active');
            $('[data-tab="' + tab + '"]').addClass('active');
            
            $('.tdt-email-template-widgets, .tdt-email-template-library').removeClass('active');
            $('.tdt-email-template-' + tab).addClass('active');
        },

        /**
         * Switch property tabs
         */
        switchPropertyTab: function(tab) {
            $('.tdt-email-template-property-panel-tab').removeClass('property-tab-active');
            $('#property_' + tab + '_tab').addClass('property-tab-active');
            
            $('.tdt-email-template-property-content-setting, .tdt-email-template-property-style-setting, .tdt-email-template-property-advanced-setting').removeClass('active');
            $('.tdt-email-template-property-' + tab + '-setting').addClass('active');
        },

        /**
         * Switch device view
         */
        switchDevice: function(device) {
            $('.tdt-email-template-header-toggle-btn').removeClass('active');
            $('[data-device="' + device + '"]').addClass('active');
            
            var $canvas = $('#email-canvas');
            
            if (device === 'mobile') {
                $canvas.addClass('mobile-mode');
            } else {
                $canvas.removeClass('mobile-mode');
            }
        },

        /**
         * Open settings modal
         */
        openSettingsModal: function() {
            $('#template-settings-modal').removeClass('hidden');
            this.loadCurrentSettings();
        },

        /**
         * Close settings modal
         */
        closeSettingsModal: function() {
            $('#template-settings-modal').addClass('hidden');
        },

        /**
         * Switch settings tabs
         */
        switchSettingsTab: function(tab) {
            $('.tdt-settings-tab').removeClass('active');
            $('[data-tab="' + tab + '"]').addClass('active');
            
            $('.tdt-settings-panel').removeClass('active');
            $('#' + tab + '-settings-panel').addClass('active');
        },

        /**
         * Load current settings
         */
        loadCurrentSettings: function() {
            var settings = this.templateSettings;
            
            // Template settings
            if (settings.body_width) $('#body-width').val(settings.body_width);
            if (settings.body_background) {
                $('#body-background').val(settings.body_background);
                $('#body-background-hex').val(settings.body_background);
            }
            
            // Canvas settings
            if (settings.canvas_width) $('#canvas-width').val(settings.canvas_width);
            if (settings.canvas_background) {
                $('#canvas-background').val(settings.canvas_background);
                $('#canvas-background-hex').val(settings.canvas_background);
            }
            if (settings.canvas_padding) $('#canvas-padding').val(settings.canvas_padding);
            if (settings.canvas_margin) $('#canvas-margin').val(settings.canvas_margin);
            if (settings.canvas_border_radius) $('#canvas-border-radius').val(settings.canvas_border_radius);
            if (settings.canvas_box_shadow) $('#canvas-box-shadow').val(settings.canvas_box_shadow);
            
            // Typography settings
            if (settings.global_typography) {
                var typo = settings.global_typography;
                
                // Headings
                if (typo.headings) {
                    if (typo.headings.font_family) $('.typography-heading-font-family').val(typo.headings.font_family);
                    if (typo.headings.font_size) $('.typography-heading-font-size').val(typo.headings.font_size);
                    if (typo.headings.font_weight) $('.typography-heading-font-weight').val(typo.headings.font_weight);
                    if (typo.headings.color) $('.typography-heading-color').val(typo.headings.color);
                }
                
                // Paragraph
                if (typo.paragraph) {
                    if (typo.paragraph.font_family) $('.typography-paragraph-font-family').val(typo.paragraph.font_family);
                    if (typo.paragraph.font_size) $('.typography-paragraph-font-size').val(typo.paragraph.font_size);
                    if (typo.paragraph.color) $('.typography-paragraph-color').val(typo.paragraph.color);
                }
                
                // Links
                if (typo.link) {
                    if (typo.link.color) $('.typography-link-color').val(typo.link.color);
                    if (typo.link.hover_color) $('.typography-link-hover-color').val(typo.link.hover_color);
                }
                
                // Buttons
                if (typo.button) {
                    if (typo.button.background) $('.typography-button-background').val(typo.button.background);
                    if (typo.button.color) $('.typography-button-color').val(typo.button.color);
                    if (typo.button.hover_background) $('.typography-button-hover-background').val(typo.button.hover_background);
                }
            }
        },

        /**
         * Save settings
         */
        saveSettings: function() {
            var self = this;
            var settings = {
                body_width: $('#body-width').val(),
                body_background: $('#body-background').val(),
                canvas_width: $('#canvas-width').val(),
                canvas_background: $('#canvas-background').val(),
                canvas_padding: $('#canvas-padding').val(),
                canvas_margin: $('#canvas-margin').val(),
                canvas_border_radius: $('#canvas-border-radius').val(),
                canvas_box_shadow: $('#canvas-box-shadow').val(),
                global_typography: {
                    headings: {
                        font_family: $('.typography-heading-font-family').val(),
                        font_size: $('.typography-heading-font-size').val(),
                        font_weight: $('.typography-heading-font-weight').val(),
                        color: $('.typography-heading-color').val()
                    },
                    paragraph: {
                        font_family: $('.typography-paragraph-font-family').val(),
                        font_size: $('.typography-paragraph-font-size').val(),
                        color: $('.typography-paragraph-color').val()
                    },
                    link: {
                        color: $('.typography-link-color').val(),
                        hover_color: $('.typography-link-hover-color').val()
                    },
                    button: {
                        background: $('.typography-button-background').val(),
                        color: $('.typography-button-color').val(),
                        hover_background: $('.typography-button-hover-background').val()
                    }
                }
            };
            
            $.ajax({
                url: tdtEmailTemplate.ajax_url,
                type: 'POST',
                data: {
                    action: 'tdt_save_template_settings',
                    settings: settings,
                    nonce: tdtEmailTemplate.nonce
                },
                success: function(response) {
                    if (response.success) {
                        self.templateSettings = settings;
                        self.applySettings();
                        self.closeSettingsModal();
                        
                    // Show success message
                    self.showNotification('Settings saved successfully!', 'success');
                    } else {
                        self.showNotification('Error saving settings', 'error');
                    }
                },
                error: function() {
                    self.showNotification('Error saving settings', 'error');
                }
            });
        },

        /**
         * Reset settings to defaults
         */
        resetSettings: function() {
            if (confirm('Are you sure you want to reset all settings to defaults?')) {
                var self = this;
                
                $.ajax({
                    url: tdtEmailTemplate.ajax_url,
                    type: 'POST',
                    data: {
                        action: 'tdt_reset_template_settings',
                        nonce: tdtEmailTemplate.nonce
                    },
                    success: function(response) {
                        if (response.success) {
                            self.templateSettings = response.data;
                            self.loadCurrentSettings();
                            self.applySettings();
                            self.showNotification('Settings reset to defaults', 'success');
                        }
                    }
                });
            }
        },

        /**
         * Save template
         */
        saveTemplate: function() {
            var self = this;
            var templateName = $('#template-name').val();
            
            if (!templateName.trim()) {
                this.showNotification('Please enter a template name', 'error');
                return;
            }
            
            var templateData = {
                name: templateName,
                content: this.serializeCanvas(),
                settings: this.templateSettings
            };
            
            $.ajax({
                url: tdtEmailTemplate.ajax_url,
                type: 'POST',
                data: {
                    action: 'tdt_save_template',
                    template_data: templateData,
                    nonce: tdtEmailTemplate.nonce
                },
                success: function(response) {
                    if (response.success) {
                        self.showNotification('Template saved successfully!', 'success');
                    } else {
                        self.showNotification('Error saving template', 'error');
                    }
                },
                error: function() {
                    self.showNotification('Error saving template', 'error');
                }
            });
        },

        /**
         * Preview template
         */
        previewTemplate: function() {
            var content = this.serializeCanvas();
            
            // Open preview in new window
            var previewWindow = window.open('', 'preview', 'width=800,height=600');
            
            $.ajax({
                url: tdtEmailTemplate.ajax_url,
                type: 'POST',
                data: {
                    action: 'tdt_preview_template',
                    content: content,
                    settings: this.templateSettings,
                    nonce: tdtEmailTemplate.nonce
                },
                success: function(response) {
                    if (response.success) {
                        previewWindow.document.write(response.data.html);
                        previewWindow.document.close();
                    }
                }
            });
        },

        /**
         * Serialize canvas content
         */
        serializeCanvas: function() {
            var widgets = [];
            
            $('#email-canvas .canvas-widget').each(function() {
                var $widget = $(this);
                widgets.push({
                    id: $widget.data('widget-id'),
                    type: $widget.data('widget-type'),
                    content: $widget.html(),
                    settings: $widget.data('widget-settings') || {}
                });
            });
            
            return {
                widgets: widgets,
                settings: this.templateSettings
            };
        },

        /**
         * Update widget order
         */
        updateWidgetOrder: function() {
            // Save order to backend if needed
            console.log('Widget order updated');
        },

        /**
         * Handle menu actions
         */
        handleMenuAction: function(action) {
            switch(action) {
                case 'history':
                    this.showHistory();
                    break;
                case 'export':
                    this.exportTemplate();
                    break;
                case 'duplicate':
                    this.duplicateTemplate();
                    break;
                case 'delete':
                    this.deleteTemplate();
                    break;
            }
            
            // Close menu
            $('.tdt-email-template-header-menu').addClass('hidden');
        },

        /**
         * Show notification
         */
        showNotification: function(message, type) {
            var $notification = $('<div class="tdt-notification tdt-notification-' + type + '">' + message + '</div>');
            
            $('body').append($notification);
            
            $notification.fadeIn(300).delay(3000).fadeOut(300, function() {
                $(this).remove();
            });
        },

        /**
         * Show history
         */
        showHistory: function() {
            alert('History feature coming soon!');
        },

        /**
         * Export template
         */
        exportTemplate: function() {
            var content = this.serializeCanvas();
            
            $.ajax({
                url: tdtEmailTemplate.ajax_url,
                type: 'POST',
                data: {
                    action: 'tdt_export_template',
                    content: content,
                    nonce: tdtEmailTemplate.nonce
                },
                success: function(response) {
                    if (response.success) {
                        // Create download link
                        var link = document.createElement('a');
                        link.href = response.data.download_url;
                        link.download = response.data.filename;
                        link.click();
                    }
                }
            });
        },

        /**
         * Duplicate template
         */
        duplicateTemplate: function() {
            var templateName = $('#template-name').val() + ' (Copy)';
            $('#template-name').val(templateName);
            this.saveTemplate();
        },

        /**
         * Delete template
         */
        deleteTemplate: function() {
            if (confirm('Are you sure you want to delete this template?')) {
                // Implementation for template deletion
                alert('Template deletion coming soon!');
            }
        }
    };

    // Initialize when DOM is ready
    $(document).ready(function() {
        window.tdtEmailBuilder = new TDTEmailTemplateBuilder();
    });

})(jQuery);