/**
 * Elementor Widgets PDA - Frontend Scripts
 *
 * @package Elementor_Widgets_PDA
 * @version 1.0.0
 */

(function($) {
    'use strict';

    /**
     * Elementor Widgets PDA Namespace
     * Using unique namespace to avoid conflicts
     */
    window.EWPDA = window.EWPDA || {};

    /**
     * Utility functions
     */
    EWPDA.Utils = {
        /**
         * Debounce function
         */
        debounce: function(func, wait, immediate) {
            var timeout;
            return function() {
                var context = this, args = arguments;
                var later = function() {
                    timeout = null;
                    if (!immediate) func.apply(context, args);
                };
                var callNow = immediate && !timeout;
                clearTimeout(timeout);
                timeout = setTimeout(later, wait);
                if (callNow) func.apply(context, args);
            };
        },

        /**
         * Throttle function
         */
        throttle: function(func, limit) {
            var inThrottle;
            return function() {
                var args = arguments;
                var context = this;
                if (!inThrottle) {
                    func.apply(context, args);
                    inThrottle = true;
                    setTimeout(function() {
                        inThrottle = false;
                    }, limit);
                }
            };
        },

        /**
         * Check if element is in viewport
         */
        isInViewport: function(element) {
            var rect = element.getBoundingClientRect();
            return (
                rect.top >= 0 &&
                rect.left >= 0 &&
                rect.bottom <= (window.innerHeight || document.documentElement.clientHeight) &&
                rect.right <= (window.innerWidth || document.documentElement.clientWidth)
            );
        },

        /**
         * AJAX request helper
         */
        ajax: function(action, data, callback) {
            data = data || {};
            data.action = action;
            data.nonce = ewpdaFrontend.nonce;

            $.ajax({
                url: ewpdaFrontend.ajaxurl,
                type: 'POST',
                data: data,
                success: function(response) {
                    if (typeof callback === 'function') {
                        callback(response);
                    }
                },
                error: function(xhr, status, error) {
                    console.error('EWPDA AJAX Error:', error);
                }
            });
        }
    };

    /**
     * Widget Handlers
     * Add your widget-specific handlers here
     */
    EWPDA.Widgets = {};

    /**
     * Initialize all widgets
     */
    EWPDA.init = function() {
        // Initialize registered widgets
        $.each(EWPDA.Widgets, function(name, handler) {
            if (typeof handler.init === 'function') {
                handler.init();
            }
        });
    };

    /**
     * Register a new widget handler
     */
    EWPDA.registerWidget = function(name, handler) {
        EWPDA.Widgets[name] = handler;
    };

    /**
     * Document ready
     */
    $(document).ready(function() {
        EWPDA.init();
    });

    /**
     * Elementor Frontend Init
     */
    $(window).on('elementor/frontend/init', function() {
        // Register widget handlers with Elementor
        if (typeof elementorFrontend !== 'undefined') {
            // Example: Register a widget handler
            // elementorFrontend.hooks.addAction('frontend/element_ready/widget-name.default', function($scope) {
            //     // Widget initialization code
            // });
        }
    });

})(jQuery);
