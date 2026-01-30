<?php
/**
 * Container Hover Animations Extension
 * 
 * Adiciona animações de hover (Float, Sink, Bob, etc.) aos Containers do Elementor
 *
 * @package Elementor_Widgets_PDA
 * @since 1.2.0
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Class Elementor_Widgets_PDA_Container_Hover_Animations
 */
class Elementor_Widgets_PDA_Container_Hover_Animations {

    /**
     * Instance
     */
    private static $_instance = null;

    /**
     * Get Instance
     */
    public static function instance() {
        if (is_null(self::$_instance)) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    /**
     * Constructor
     */
    public function __construct() {
        // Adicionar controles ao Container
        add_action('elementor/element/container/section_layout/after_section_end', [$this, 'add_hover_animation_controls'], 10, 2);
        
        // Adicionar controles às Sections (para versões antigas)
        add_action('elementor/element/section/section_layout/after_section_end', [$this, 'add_hover_animation_controls'], 10, 2);
        
        // Adicionar controles às Columns
        add_action('elementor/element/column/section_advanced/after_section_end', [$this, 'add_hover_animation_controls'], 10, 2);
        
        // Renderizar atributos antes do elemento
        add_action('elementor/frontend/container/before_render', [$this, 'before_render'], 10, 1);
        add_action('elementor/frontend/section/before_render', [$this, 'before_render'], 10, 1);
        add_action('elementor/frontend/column/before_render', [$this, 'before_render'], 10, 1);
    }

    /**
     * Lista de animações disponíveis
     */
    private function get_hover_animations() {
        return [
            '' => __('Nenhuma', 'elementor-widgets-pda'),
            
            // 2D Transitions
            'grow' => __('Grow', 'elementor-widgets-pda'),
            'shrink' => __('Shrink', 'elementor-widgets-pda'),
            'pulse' => __('Pulse', 'elementor-widgets-pda'),
            'pulse-grow' => __('Pulse Grow', 'elementor-widgets-pda'),
            'pulse-shrink' => __('Pulse Shrink', 'elementor-widgets-pda'),
            'push' => __('Push', 'elementor-widgets-pda'),
            'pop' => __('Pop', 'elementor-widgets-pda'),
            'bounce-in' => __('Bounce In', 'elementor-widgets-pda'),
            'bounce-out' => __('Bounce Out', 'elementor-widgets-pda'),
            'rotate' => __('Rotate', 'elementor-widgets-pda'),
            'grow-rotate' => __('Grow Rotate', 'elementor-widgets-pda'),
            'float' => __('Float', 'elementor-widgets-pda'),
            'sink' => __('Sink', 'elementor-widgets-pda'),
            'bob' => __('Bob', 'elementor-widgets-pda'),
            'hang' => __('Hang', 'elementor-widgets-pda'),
            'skew' => __('Skew', 'elementor-widgets-pda'),
            'skew-forward' => __('Skew Forward', 'elementor-widgets-pda'),
            'skew-backward' => __('Skew Backward', 'elementor-widgets-pda'),
            'wobble-vertical' => __('Wobble Vertical', 'elementor-widgets-pda'),
            'wobble-horizontal' => __('Wobble Horizontal', 'elementor-widgets-pda'),
            'wobble-to-bottom-right' => __('Wobble Bottom Right', 'elementor-widgets-pda'),
            'wobble-to-top-right' => __('Wobble Top Right', 'elementor-widgets-pda'),
            'wobble-top' => __('Wobble Top', 'elementor-widgets-pda'),
            'wobble-bottom' => __('Wobble Bottom', 'elementor-widgets-pda'),
            'wobble-skew' => __('Wobble Skew', 'elementor-widgets-pda'),
            'buzz' => __('Buzz', 'elementor-widgets-pda'),
            'buzz-out' => __('Buzz Out', 'elementor-widgets-pda'),
            'forward' => __('Forward', 'elementor-widgets-pda'),
            'backward' => __('Backward', 'elementor-widgets-pda'),
            
            // Background Transitions
            'fade' => __('Fade', 'elementor-widgets-pda'),
            'back-pulse' => __('Back Pulse', 'elementor-widgets-pda'),
            'sweep-to-right' => __('Sweep To Right', 'elementor-widgets-pda'),
            'sweep-to-left' => __('Sweep To Left', 'elementor-widgets-pda'),
            'sweep-to-bottom' => __('Sweep To Bottom', 'elementor-widgets-pda'),
            'sweep-to-top' => __('Sweep To Top', 'elementor-widgets-pda'),
            'bounce-to-right' => __('Bounce To Right', 'elementor-widgets-pda'),
            'bounce-to-left' => __('Bounce To Left', 'elementor-widgets-pda'),
            'bounce-to-bottom' => __('Bounce To Bottom', 'elementor-widgets-pda'),
            'bounce-to-top' => __('Bounce To Top', 'elementor-widgets-pda'),
            'radial-out' => __('Radial Out', 'elementor-widgets-pda'),
            'radial-in' => __('Radial In', 'elementor-widgets-pda'),
            'rectangle-in' => __('Rectangle In', 'elementor-widgets-pda'),
            'rectangle-out' => __('Rectangle Out', 'elementor-widgets-pda'),
            'shutter-in-horizontal' => __('Shutter In Horizontal', 'elementor-widgets-pda'),
            'shutter-out-horizontal' => __('Shutter Out Horizontal', 'elementor-widgets-pda'),
            'shutter-in-vertical' => __('Shutter In Vertical', 'elementor-widgets-pda'),
            'shutter-out-vertical' => __('Shutter Out Vertical', 'elementor-widgets-pda'),
        ];
    }

    /**
     * Adicionar controles de animação hover
     */
    public function add_hover_animation_controls($element, $args) {
        $element->start_controls_section(
            'ewpda_hover_animation_section',
            [
                'label' => __('🎬 Animação Hover', 'elementor-widgets-pda'),
                'tab' => \Elementor\Controls_Manager::TAB_ADVANCED,
            ]
        );

        $element->add_control(
            'ewpda_hover_animation',
            [
                'label' => __('Animação ao passar o mouse', 'elementor-widgets-pda'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => '',
                'options' => $this->get_hover_animations(),
                'prefix_class' => 'ewpda-hover-',
            ]
        );

        $element->add_control(
            'ewpda_hover_animation_duration',
            [
                'label' => __('Duração da transição', 'elementor-widgets-pda'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 3,
                        'step' => 0.1,
                    ],
                ],
                'default' => [
                    'size' => 0.3,
                ],
                'selectors' => [
                    '{{WRAPPER}}' => '--ewpda-hover-duration: {{SIZE}}s;',
                ],
                'condition' => [
                    'ewpda_hover_animation!' => '',
                ],
            ]
        );

        $element->add_control(
            'ewpda_hover_animation_delay',
            [
                'label' => __('Atraso', 'elementor-widgets-pda'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 2,
                        'step' => 0.1,
                    ],
                ],
                'default' => [
                    'size' => 0,
                ],
                'selectors' => [
                    '{{WRAPPER}}' => '--ewpda-hover-delay: {{SIZE}}s;',
                ],
                'condition' => [
                    'ewpda_hover_animation!' => '',
                ],
            ]
        );

        $element->end_controls_section();
    }

    /**
     * Antes de renderizar o elemento
     */
    public function before_render($element) {
        $settings = $element->get_settings_for_display();
        
        if (!empty($settings['ewpda_hover_animation'])) {
            $element->add_render_attribute('_wrapper', 'class', 'ewpda-hover-animated');
        }
    }
}

// Inicializar
Elementor_Widgets_PDA_Container_Hover_Animations::instance();
