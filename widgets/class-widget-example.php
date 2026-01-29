<?php
/**
 * Example Widget
 * 
 * Widget de exemplo para servir como template para novos widgets
 *
 * @package Elementor_Widgets_PDA
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Example Widget Class
 */
class Elementor_Widgets_PDA_Example extends \Elementor\Widget_Base {

    /**
     * Get widget name
     */
    public function get_name() {
        return 'pda_example';
    }

    /**
     * Get widget title
     */
    public function get_title() {
        return __('PDA - Exemplo', 'elementor-widgets-pda');
    }

    /**
     * Get widget icon
     */
    public function get_icon() {
        return 'eicon-code';
    }

    /**
     * Get widget categories
     */
    public function get_categories() {
        return ['pda-widgets'];
    }

    /**
     * Get widget keywords
     */
    public function get_keywords() {
        return ['exemplo', 'example', 'pda', 'demo'];
    }

    /**
     * Get script dependencies
     */
    public function get_script_depends() {
        return ['elementor-widgets-pda-script'];
    }

    /**
     * Get style dependencies
     */
    public function get_style_depends() {
        return ['elementor-widgets-pda-style'];
    }

    /**
     * Register widget controls
     */
    protected function register_controls() {
        
        // ==============================
        // Content Tab
        // ==============================
        
        $this->start_controls_section(
            'content_section',
            [
                'label' => __('Conteúdo', 'elementor-widgets-pda'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'title',
            [
                'label' => __('Título', 'elementor-widgets-pda'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('Título do Widget', 'elementor-widgets-pda'),
                'placeholder' => __('Digite o título', 'elementor-widgets-pda'),
                'label_block' => true,
            ]
        );

        $this->add_control(
            'description',
            [
                'label' => __('Descrição', 'elementor-widgets-pda'),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'default' => __('Esta é a descrição do widget de exemplo.', 'elementor-widgets-pda'),
                'placeholder' => __('Digite a descrição', 'elementor-widgets-pda'),
                'rows' => 4,
            ]
        );

        $this->add_control(
            'show_icon',
            [
                'label' => __('Mostrar Ícone', 'elementor-widgets-pda'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __('Sim', 'elementor-widgets-pda'),
                'label_off' => __('Não', 'elementor-widgets-pda'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'icon',
            [
                'label' => __('Ícone', 'elementor-widgets-pda'),
                'type' => \Elementor\Controls_Manager::ICONS,
                'default' => [
                    'value' => 'fas fa-star',
                    'library' => 'fa-solid',
                ],
                'condition' => [
                    'show_icon' => 'yes',
                ],
            ]
        );

        $this->end_controls_section();

        // ==============================
        // Style Tab - Box
        // ==============================
        
        $this->start_controls_section(
            'style_box_section',
            [
                'label' => __('Box', 'elementor-widgets-pda'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'box_background',
            [
                'label' => __('Cor de Fundo', 'elementor-widgets-pda'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .ewpda-ex-widget' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'box_padding',
            [
                'label' => __('Padding', 'elementor-widgets-pda'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'default' => [
                    'top' => '20',
                    'right' => '20',
                    'bottom' => '20',
                    'left' => '20',
                    'unit' => 'px',
                    'isLinked' => true,
                ],
                'selectors' => [
                    '{{WRAPPER}} .ewpda-ex-widget' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'box_border',
                'label' => __('Borda', 'elementor-widgets-pda'),
                'selector' => '{{WRAPPER}} .ewpda-ex-widget',
            ]
        );

        $this->add_responsive_control(
            'box_border_radius',
            [
                'label' => __('Border Radius', 'elementor-widgets-pda'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .ewpda-ex-widget' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'box_shadow',
                'label' => __('Sombra', 'elementor-widgets-pda'),
                'selector' => '{{WRAPPER}} .ewpda-ex-widget',
            ]
        );

        $this->end_controls_section();

        // ==============================
        // Style Tab - Title
        // ==============================
        
        $this->start_controls_section(
            'style_title_section',
            [
                'label' => __('Título', 'elementor-widgets-pda'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label' => __('Cor', 'elementor-widgets-pda'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#1a1a1a',
                'selectors' => [
                    '{{WRAPPER}} .ewpda-ex-title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'title_typography',
                'label' => __('Tipografia', 'elementor-widgets-pda'),
                'selector' => '{{WRAPPER}} .ewpda-ex-title',
            ]
        );

        $this->add_responsive_control(
            'title_spacing',
            [
                'label' => __('Espaçamento', 'elementor-widgets-pda'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 50,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 10,
                ],
                'selectors' => [
                    '{{WRAPPER}} .ewpda-ex-title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        // ==============================
        // Style Tab - Description
        // ==============================
        
        $this->start_controls_section(
            'style_description_section',
            [
                'label' => __('Descrição', 'elementor-widgets-pda'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'description_color',
            [
                'label' => __('Cor', 'elementor-widgets-pda'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#666666',
                'selectors' => [
                    '{{WRAPPER}} .ewpda-ex-description' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'description_typography',
                'label' => __('Tipografia', 'elementor-widgets-pda'),
                'selector' => '{{WRAPPER}} .ewpda-ex-description',
            ]
        );

        $this->end_controls_section();

        // ==============================
        // Style Tab - Icon
        // ==============================
        
        $this->start_controls_section(
            'style_icon_section',
            [
                'label' => __('Ícone', 'elementor-widgets-pda'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
                'condition' => [
                    'show_icon' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'icon_color',
            [
                'label' => __('Cor', 'elementor-widgets-pda'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#667eea',
                'selectors' => [
                    '{{WRAPPER}} .ewpda-ex-icon i' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .ewpda-ex-icon svg' => 'fill: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'icon_size',
            [
                'label' => __('Tamanho', 'elementor-widgets-pda'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 10,
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 40,
                ],
                'selectors' => [
                    '{{WRAPPER}} .ewpda-ex-icon i' => 'font-size: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .ewpda-ex-icon svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'icon_spacing',
            [
                'label' => __('Espaçamento', 'elementor-widgets-pda'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 50,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 15,
                ],
                'selectors' => [
                    '{{WRAPPER}} .ewpda-ex-icon' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    /**
     * Render widget output
     */
    protected function render() {
        $settings = $this->get_settings_for_display();
        
        $this->add_render_attribute('wrapper', 'class', 'ewpda-ex-widget');
        ?>
        <div <?php echo $this->get_render_attribute_string('wrapper'); ?>>
            <?php if ($settings['show_icon'] === 'yes' && !empty($settings['icon']['value'])) : ?>
                <div class="ewpda-ex-icon">
                    <?php \Elementor\Icons_Manager::render_icon($settings['icon'], ['aria-hidden' => 'true']); ?>
                </div>
            <?php endif; ?>
            
            <?php if (!empty($settings['title'])) : ?>
                <h3 class="ewpda-ex-title"><?php echo esc_html($settings['title']); ?></h3>
            <?php endif; ?>
            
            <?php if (!empty($settings['description'])) : ?>
                <p class="ewpda-ex-description"><?php echo esc_html($settings['description']); ?></p>
            <?php endif; ?>
        </div>
        <?php
    }

    /**
     * Render widget output in the editor
     */
    protected function content_template() {
        ?>
        <#
        view.addRenderAttribute('wrapper', 'class', 'ewpda-ex-widget');
        #>
        <div {{{ view.getRenderAttributeString('wrapper') }}}>
            <# if (settings.show_icon === 'yes' && settings.icon.value) { #>
                <div class="ewpda-ex-icon">
                    <i class="{{ settings.icon.value }}" aria-hidden="true"></i>
                </div>
            <# } #>
            
            <# if (settings.title) { #>
                <h3 class="ewpda-ex-title">{{{ settings.title }}}</h3>
            <# } #>
            
            <# if (settings.description) { #>
                <p class="ewpda-ex-description">{{{ settings.description }}}</p>
            <# } #>
        </div>
        <?php
    }
}
