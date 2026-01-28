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
     */
    window.ElementorWidgetsPDA = window.ElementorWidgetsPDA || {};

    /**
     * Utility functions
     */
    ElementorWidgetsPDA.Utils = {
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
            data.nonce = elementorWidgetsPDA.nonce;

            $.ajax({
                url: elementorWidgetsPDA.ajaxurl,
                type: 'POST',
                data: data,
                success: function(response) {
                    if (typeof callback === 'function') {
                        callback(response);
                    }
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error:', error);
                }
            });
        }
    };

    /**
     * Widget Handlers
     * Add your widget-specific handlers here
     */
    ElementorWidgetsPDA.Widgets = {};

    /**
     * FAQ Widget Handler
     */
    ElementorWidgetsPDA.Widgets.FAQ = {
        init: function() {
            this.bindEvents();
        },
        
        bindEvents: function() {
            // FAQ simple toggle
            $(document).on('click', '.pda-faq-question', function(e) {
                e.preventDefault();
                var $item = $(this).closest('.pda-faq-item');
                var $wrapper = $item.closest('.pda-faq-wrapper');
                var type = $wrapper.data('type') || 'accordion';
                
                if (type === 'accordion') {
                    // Close other items
                    $wrapper.find('.pda-faq-item').not($item).removeClass('active');
                    $wrapper.find('.pda-faq-answer').not($item.find('.pda-faq-answer')).slideUp(300);
                }
                
                // Toggle current item
                $item.toggleClass('active');
                $item.find('.pda-faq-answer').slideToggle(300);
            });
            
            // FAQ Page - Category navigation
            $(document).on('click', '.pda-faq-page-nav-item', function(e) {
                e.preventDefault();
                var $this = $(this);
                var category = $this.data('category');
                var $wrapper = $this.closest('.pda-faq-page-wrapper');
                
                // Update nav active state
                $wrapper.find('.pda-faq-page-nav-item').removeClass('active');
                $this.addClass('active');
                
                // Show corresponding category
                $wrapper.find('.pda-faq-page-category').removeClass('active');
                $wrapper.find('.pda-faq-page-category[data-category="' + category + '"]').addClass('active');
            });
            
            // FAQ Page - Question toggle
            $(document).on('click', '.pda-faq-page-question', function(e) {
                e.preventDefault();
                var $item = $(this).closest('.pda-faq-page-item');
                
                // Toggle current item
                $item.toggleClass('active');
                $item.find('.pda-faq-page-answer').slideToggle(300);
            });
            
            // FAQ Page - Search
            $(document).on('input', '.pda-faq-page-search-input', ElementorWidgetsPDA.Utils.debounce(function() {
                var searchTerm = $(this).val().toLowerCase().trim();
                var $wrapper = $(this).closest('.pda-faq-page-wrapper');
                
                if (searchTerm === '') {
                    // Reset to show first category
                    $wrapper.find('.pda-faq-page-nav-item').first().trigger('click');
                    $wrapper.find('.pda-faq-page-item').show();
                    return;
                }
                
                // Show all categories and filter items
                $wrapper.find('.pda-faq-page-category').addClass('active');
                $wrapper.find('.pda-faq-page-nav-item').removeClass('active');
                
                $wrapper.find('.pda-faq-page-item').each(function() {
                    var $item = $(this);
                    var questionText = $item.find('.pda-faq-page-question-text').text().toLowerCase();
                    var answerText = $item.find('.pda-faq-page-answer').text().toLowerCase();
                    
                    if (questionText.indexOf(searchTerm) > -1 || answerText.indexOf(searchTerm) > -1) {
                        $item.show();
                    } else {
                        $item.hide();
                    }
                });
                
                // Hide categories with no visible items
                $wrapper.find('.pda-faq-page-category').each(function() {
                    var $category = $(this);
                    var hasVisibleItems = $category.find('.pda-faq-page-item:visible').length > 0;
                    
                    if (!hasVisibleItems) {
                        $category.removeClass('active');
                    }
                });
            }, 300));
        }
    };

    /**
     * Initialize all widgets
     */
    ElementorWidgetsPDA.init = function() {
        // Initialize registered widgets
        $.each(ElementorWidgetsPDA.Widgets, function(name, handler) {
            if (typeof handler.init === 'function') {
                handler.init();
            }
        });
    };

    /**
     * Register a new widget handler
     */
    ElementorWidgetsPDA.registerWidget = function(name, handler) {
        ElementorWidgetsPDA.Widgets[name] = handler;
    };

    /**
     * Document ready
     */
    $(document).ready(function() {
        ElementorWidgetsPDA.init();
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
