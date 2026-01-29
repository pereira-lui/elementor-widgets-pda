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
                var $widget = $(this).closest('.elementor-widget');
                if (!$widget.length) {
                    $widget = $(this).parent();
                }
                self.initElement($widget);
            });
        },

        initElement: function($scope) {
            var $timeline = $scope.find('.ewpda-tl--animated');
            if (!$timeline.length) {
                $timeline = $scope.filter('.ewpda-tl--animated');
            }
            if (!$timeline.length) return;

            // Prevent double initialization
            if ($timeline.data('ewpda-initialized')) return;
            $timeline.data('ewpda-initialized', true);

            var settings = {
                animation: $timeline.attr('data-animation') || 'fade-slide',
                duration: parseInt($timeline.attr('data-duration')) || 800,
                delay: parseInt($timeline.attr('data-delay')) || 150,
                offset: parseInt($timeline.attr('data-offset')) || 20,
                stagger: $timeline.attr('data-stagger') === 'true'
            };

            console.log('Timeline settings:', settings);

            var $items = $timeline.find('.ewpda-tl__item--hidden');
            
            // Apply initial styles based on animation type
            $items.each(function() {
                var $item = $(this);
                var $content = $item.find('.ewpda-tl__content');
                var $image = $item.find('.ewpda-tl__image');
                var isLeft = $item.hasClass('ewpda-tl__item--left');
                
                // Set transition
                var transitionValue = 'all ' + settings.duration + 'ms cubic-bezier(0.25, 0.46, 0.45, 0.94)';
                $content.css('transition', transitionValue);
                $image.css('transition', transitionValue);
                
                // Apply initial state based on animation type
                var contentInitial = { opacity: 0 };
                var imageInitial = { opacity: 0 };
                
                switch(settings.animation) {
                    case 'fade':
                        // Just opacity
                        break;
                    case 'fade-slide':
                        contentInitial.transform = isLeft ? 'translateX(-50px)' : 'translateX(50px)';
                        imageInitial.transform = isLeft ? 'translateX(50px)' : 'translateX(-50px)';
                        break;
                    case 'fade-scale':
                        contentInitial.transform = 'scale(0.8)';
                        imageInitial.transform = 'scale(0.8)';
                        break;
                    case 'slide-only':
                        contentInitial.opacity = 1;
                        imageInitial.opacity = 1;
                        contentInitial.transform = isLeft ? 'translateX(-80px)' : 'translateX(80px)';
                        imageInitial.transform = isLeft ? 'translateX(80px)' : 'translateX(-80px)';
                        break;
                    case 'blur-in':
                        contentInitial.filter = 'blur(10px)';
                        contentInitial.transform = 'scale(1.05)';
                        imageInitial.filter = 'blur(10px)';
                        imageInitial.transform = 'scale(1.05)';
                        break;
                    case 'rotate-in':
                        contentInitial.transform = isLeft ? 'translateX(-30px) rotate(-5deg)' : 'translateX(30px) rotate(5deg)';
                        imageInitial.transform = isLeft ? 'translateX(30px) rotate(5deg)' : 'translateX(-30px) rotate(-5deg)';
                        break;
                }
                
                $content.css(contentInitial);
                $image.css(imageInitial);
            });

            // Intersection Observer - trigger when element enters bottom of viewport
            if ('IntersectionObserver' in window) {
                var rootMarginBottom = 100 - settings.offset; // Convert offset to trigger earlier
                var observerOptions = {
                    root: null,
                    rootMargin: '0px 0px ' + rootMarginBottom + '% 0px',
                    threshold: 0
                };

                var observer = new IntersectionObserver(function(entries) {
                    entries.forEach(function(entry) {
                        if (entry.isIntersecting) {
                            var $item = $(entry.target);
                            var $content = $item.find('.ewpda-tl__content');
                            var $image = $item.find('.ewpda-tl__image');
                            
                            // Final state
                            var finalState = {
                                opacity: 1,
                                transform: 'translateX(0) scale(1) rotate(0)',
                                filter: 'blur(0)'
                            };
                            
                            if (settings.stagger) {
                                // Animate content first
                                $content.css(finalState);
                                
                                // Then image after delay
                                setTimeout(function() {
                                    $image.css(finalState);
                                }, settings.delay);
                                
                                setTimeout(function() {
                                    $item.removeClass('ewpda-tl__item--hidden').addClass('ewpda-tl__item--visible');
                                }, settings.delay + 100);
                            } else {
                                // Animate both together
                                $content.css(finalState);
                                $image.css(finalState);
                                $item.removeClass('ewpda-tl__item--hidden').addClass('ewpda-tl__item--visible');
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
                $items.each(function() {
                    var $item = $(this);
                    $item.find('.ewpda-tl__content, .ewpda-tl__image').css({
                        opacity: 1,
                        transform: 'none',
                        filter: 'none'
                    });
                    $item.removeClass('ewpda-tl__item--hidden').addClass('ewpda-tl__item--visible');
                });
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
