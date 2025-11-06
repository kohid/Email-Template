(function($) {
    'use strict';

    /**
     * Frontend JavaScript for Email Templates
     */
    window.TDTEmailTemplateFrontend = {
        
        /**
         * Initialize frontend functionality
         */
        init: function() {
            this.bindEvents();
            this.handleResponsive();
            this.trackLinks();
        },

        /**
         * Bind events
         */
        bindEvents: function() {
            var self = this;
            
            // Handle button clicks
            $(document).on('click', '.tdt-widget-button', function(e) {
                e.preventDefault();
                var $button = $(this);
                var href = $button.attr('href');
                var target = $button.attr('target');
                
                if (href && href !== '#') {
                    if (target === '_blank') {
                        window.open(href, '_blank');
                    } else {
                        window.location.href = href;
                    }
                }
            });

            // Handle image clicks
            $(document).on('click', '.tdt-widget-image', function() {
                var $img = $(this);
                var link = $img.data('link');
                
                if (link) {
                    window.open(link, $img.data('target') || '_self');
                }
            });
        },

        /**
         * Handle responsive behavior
         */
        handleResponsive: function() {
            var self = this;
            
            $(window).on('resize', function() {
                self.adjustForMobile();
            });
            
            // Initial check
            self.adjustForMobile();
        },

        /**
         * Adjust for mobile devices
         */
        adjustForMobile: function() {
            var isMobile = $(window).width() <= 600;
            
            $('.tdt-email-template-wrapper').each(function() {
                var $wrapper = $(this);
                
                if (isMobile) {
                    $wrapper.addClass('mobile-view');
                } else {
                    $wrapper.removeClass('mobile-view');
                }
            });
        },

        /**
         * Track link clicks for analytics
         */
        trackLinks: function() {
            $(document).on('click', 'a', function(e) {
                var $link = $(this);
                var href = $link.attr('href');
                
                // Track external links
                if (href && href.indexOf('http') === 0 && href.indexOf(window.location.hostname) === -1) {
                    // Send tracking data (implement based on your analytics)
                    console.log('External link clicked:', href);
                }
            });
        },

        /**
         * Handle email client specific behavior
         */
        handleEmailClients: function() {
            // Detect email clients
            var userAgent = navigator.userAgent.toLowerCase();
            
            // Outlook specific fixes
            if (userAgent.indexOf('outlook') !== -1) {
                $('.tdt-widget-button').each(function() {
                    var $button = $(this);
                    // Add inline styles for Outlook
                    $button.css({
                        'display': 'inline-block',
                        'padding': '12px 24px',
                        'background-color': $button.css('background-color'),
                        'color': $button.css('color'),
                        'text-decoration': 'none',
                        'border-radius': '50px'
                    });
                });
            }
        }
    };

    // Initialize when DOM is ready
    $(document).ready(function() {
        window.TDTEmailTemplateFrontend.init();
    });

})(jQuery);