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
            // Timeline Widget Handler
            elementorFrontend.hooks.addAction('frontend/element_ready/pda_timeline.default', function($scope) {
                EWPDA.Widgets.Timeline.initElement($scope);
            });
        }
    });

    /**
     * Timeline Widget
     */
    EWPDA.Widgets.Timeline = {
        init: function() {
            this.initAllTimelines();
        },

        initAllTimelines: function() {
            var self = this;
            $('.ewpda-tl--animated').each(function() {
                self.initElement($(this).closest('.elementor-widget'));
            });
        },

        initElement: function($scope) {
            var $timeline = $scope.find('.ewpda-tl--animated');
            if (!$timeline.length) return;

            var settings = {
                animation: $timeline.data('animation') || 'fade-slide',
                duration: $timeline.data('duration') || 800,
                delay: $timeline.data('delay') || 150,
                offset: $timeline.data('offset') || 20,
                stagger: $timeline.data('stagger') === true || $timeline.data('stagger') === 'true'
            };

            var $items = $timeline.find('.ewpda-tl__item--hidden');
            
            // Set transition styles
            $items.each(function() {
                var $content = $(this).find('.ewpda-tl__content');
                var $image = $(this).find('.ewpda-tl__image');
                
                var transitionValue = 'opacity ' + settings.duration + 'ms cubic-bezier(0.4, 0, 0.2, 1), ' +
                                     'transform ' + settings.duration + 'ms cubic-bezier(0.4, 0, 0.2, 1), ' +
                                     'filter ' + settings.duration + 'ms cubic-bezier(0.4, 0, 0.2, 1)';
                
                $content.css('transition', transitionValue);
                $image.css('transition', transitionValue);
                $(this).css('transition', 'opacity ' + settings.duration + 'ms ease');
            });

            // Intersection Observer
            if ('IntersectionObserver' in window) {
                var observerOptions = {
                    root: null,
                    rootMargin: '-' + settings.offset + '% 0px',
                    threshold: 0.1
                };

                var observer = new IntersectionObserver(function(entries) {
                    entries.forEach(function(entry) {
                        if (entry.isIntersecting) {
                            var $item = $(entry.target);
                            var index = $item.data('index') || 0;
                            var baseDelay = settings.stagger ? 0 : (index * settings.delay);
                            
                            if (settings.stagger) {
                                // Animate content first, then image
                                var $content = $item.find('.ewpda-tl__content');
                                var $image = $item.find('.ewpda-tl__image');
                                
                                setTimeout(function() {
                                    $content.css({
                                        'opacity': '1',
                                        'transform': 'translateX(0) scale(1) rotate(0)',
                                        'filter': 'blur(0)'
                                    });
                                }, baseDelay);
                                
                                setTimeout(function() {
                                    $image.css({
                                        'opacity': '1',
                                        'transform': 'translateX(0) scale(1) rotate(0)',
                                        'filter': 'blur(0)'
                                    });
                                }, baseDelay + settings.delay);
                                
                                setTimeout(function() {
                                    $item.removeClass('ewpda-tl__item--hidden').addClass('ewpda-tl__item--visible');
                                }, baseDelay + settings.delay + settings.duration);
                            } else {
                                setTimeout(function() {
                                    $item.removeClass('ewpda-tl__item--hidden').addClass('ewpda-tl__item--visible');
                                }, baseDelay);
                            }
                            
                            observer.unobserve(entry.target);
                        }
                    });
                }, observerOptions);

                $items.each(function() {
                    observer.observe(this);
                });
            } else {
                // Fallback for older browsers
                $items.removeClass('ewpda-tl__item--hidden').addClass('ewpda-tl__item--visible');
            }
        }
    };

    // Auto-init timelines on page load (for non-Elementor contexts)
    $(document).ready(function() {
        // Small delay to ensure styles are applied
        setTimeout(function() {
            EWPDA.Widgets.Timeline.initAllTimelines();
        }, 100);
    });

})(jQuery);
