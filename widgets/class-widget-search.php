<?php
/**
 * Search Widget
 * 
 * Widget de pesquisa customizado
 *
 * @package Elementor_Widgets_PDA
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Search Widget Class
 */
class Elementor_Widgets_PDA_Search extends \Elementor\Widget_Base {

    /**
     * Get widget name
     */
    public function get_name() {
        return 'pda_search';
    }

    /**
     * Get widget title
     */
    public function get_title() {
        return __('Pesquisa PDA', 'elementor-widgets-pda');
    }

    /**
     * Get widget icon
     */
    public function get_icon() {
        return 'eicon-search';
    }

    /**
     * Get widget categories
     */
    public function get_categories() {
        return ['pda-search'];
    }

    /**
     * Get widget keywords
     */
    public function get_keywords() {
        return ['search', 'pesquisa', 'busca', 'pda'];
    }

    /**
     * Get style dependencies
     */
    public function get_style_depends() {
        return ['elementor-widgets-pda-style'];
    }

    /**
     * Get script dependencies
     */
    public function get_script_depends() {
        return ['elementor-widgets-pda-script'];
    }

    /**
     * Register widget controls
     */
    protected function register_controls() {
        
        // ==============================
        // Content Tab - Pesquisa
        // ==============================
        
        $this->start_controls_section(
            'search_section',
            [
                'label' => __('Configurações da Pesquisa', 'elementor-widgets-pda'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'placeholder_text',
            [
                'label' => __('Texto do Placeholder', 'elementor-widgets-pda'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('Pesquisar...', 'elementor-widgets-pda'),
                'placeholder' => __('Digite o placeholder', 'elementor-widgets-pda'),
                'label_block' => true,
            ]
        );

        $this->add_control(
            'button_text',
            [
                'label' => __('Texto do Botão', 'elementor-widgets-pda'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('Buscar', 'elementor-widgets-pda'),
                'placeholder' => __('Digite o texto do botão', 'elementor-widgets-pda'),
            ]
        );

        $this->add_control(
            'show_button',
            [
                'label' => __('Mostrar Botão', 'elementor-widgets-pda'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __('Sim', 'elementor-widgets-pda'),
                'label_off' => __('Não', 'elementor-widgets-pda'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'button_type',
            [
                'label' => __('Tipo do Botão', 'elementor-widgets-pda'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'icon',
                'options' => [
                    'text' => __('Texto', 'elementor-widgets-pda'),
                    'icon' => __('Ícone', 'elementor-widgets-pda'),
                    'both' => __('Ambos', 'elementor-widgets-pda'),
                ],
                'condition' => [
                    'show_button' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'button_icon',
            [
                'label' => __('Ícone do Botão', 'elementor-widgets-pda'),
                'type' => \Elementor\Controls_Manager::ICONS,
                'default' => [
                    'value' => 'fas fa-search',
                    'library' => 'fa-solid',
                ],
                'condition' => [
                    'show_button' => 'yes',
                    'button_type!' => 'text',
                ],
            ]
        );

        $this->end_controls_section();

        // ==============================
        // Style Tab - Input
        // ==============================
        
        $this->start_controls_section(
            'style_input_section',
            [
                'label' => __('Campo de Busca', 'elementor-widgets-pda'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'input_background',
            [
                'label' => __('Cor de Fundo', 'elementor-widgets-pda'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .pda-search-input' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'input_text_color',
            [
                'label' => __('Cor do Texto', 'elementor-widgets-pda'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .pda-search-input' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .pda-search-input::placeholder' => 'color: {{VALUE}}; opacity: 0.7;',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'input_typography',
                'selector' => '{{WRAPPER}} .pda-search-input',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'input_border',
                'selector' => '{{WRAPPER}} .pda-search-input',
            ]
        );

        $this->add_control(
            'input_border_radius',
            [
                'label' => __('Raio da Borda', 'elementor-widgets-pda'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .pda-search-input' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'input_padding',
            [
                'label' => __('Espaçamento Interno', 'elementor-widgets-pda'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .pda-search-input' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        // ==============================
        // Style Tab - Button
        // ==============================
        
        $this->start_controls_section(
            'style_button_section',
            [
                'label' => __('Botão', 'elementor-widgets-pda'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
                'condition' => [
                    'show_button' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'button_background',
            [
                'label' => __('Cor de Fundo', 'elementor-widgets-pda'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .pda-search-button' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'button_text_color',
            [
                'label' => __('Cor do Texto/Ícone', 'elementor-widgets-pda'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .pda-search-button' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .pda-search-button svg' => 'fill: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'button_background_hover',
            [
                'label' => __('Cor de Fundo (Hover)', 'elementor-widgets-pda'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .pda-search-button:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'button_border',
                'selector' => '{{WRAPPER}} .pda-search-button',
            ]
        );

        $this->add_control(
            'button_border_radius',
            [
                'label' => __('Raio da Borda', 'elementor-widgets-pda'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .pda-search-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'button_padding',
            [
                'label' => __('Espaçamento Interno', 'elementor-widgets-pda'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .pda-search-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        // ==============================
        // Style Tab - Container
        // ==============================
        
        $this->start_controls_section(
            'style_container_section',
            [
                'label' => __('Container', 'elementor-widgets-pda'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'container_background',
            [
                'label' => __('Cor de Fundo', 'elementor-widgets-pda'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .pda-search-wrapper' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'container_box_shadow',
                'selector' => '{{WRAPPER}} .pda-search-wrapper',
            ]
        );

        $this->add_control(
            'container_border_radius',
            [
                'label' => __('Raio da Borda', 'elementor-widgets-pda'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .pda-search-wrapper' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'container_padding',
            [
                'label' => __('Espaçamento Interno', 'elementor-widgets-pda'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .pda-search-wrapper' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
        
        $this->add_render_attribute('wrapper', 'class', 'pda-search-wrapper');
        $this->add_render_attribute('form', 'class', 'pda-search-form');
        $this->add_render_attribute('form', 'role', 'search');
        $this->add_render_attribute('form', 'method', 'get');
        $this->add_render_attribute('form', 'action', home_url('/'));
        
        $this->add_render_attribute('input', [
            'class' => 'pda-search-input',
            'type' => 'search',
            'name' => 's',
            'placeholder' => $settings['placeholder_text'],
        ]);
        ?>
        <div <?php echo $this->get_render_attribute_string('wrapper'); ?>>
            <form <?php echo $this->get_render_attribute_string('form'); ?>>
                <div class="pda-search-inner">
                    <input <?php echo $this->get_render_attribute_string('input'); ?>>
                    <?php if ($settings['show_button'] === 'yes') : ?>
                        <button type="submit" class="pda-search-button">
                            <?php if ($settings['button_type'] === 'text' || $settings['button_type'] === 'both') : ?>
                                <span class="pda-search-button-text"><?php echo esc_html($settings['button_text']); ?></span>
                            <?php endif; ?>
                            <?php if ($settings['button_type'] === 'icon' || $settings['button_type'] === 'both') : ?>
                                <?php \Elementor\Icons_Manager::render_icon($settings['button_icon'], ['aria-hidden' => 'true']); ?>
                            <?php endif; ?>
                        </button>
                    <?php endif; ?>
                </div>
            </form>
        </div>
        <?php
    }

    /**
     * Render widget output in editor
     */
    protected function content_template() {
        ?>
        <#
        view.addRenderAttribute('wrapper', 'class', 'pda-search-wrapper');
        #>
        <div {{{ view.getRenderAttributeString('wrapper') }}}>
            <form class="pda-search-form" role="search">
                <div class="pda-search-inner">
                    <input class="pda-search-input" type="search" placeholder="{{ settings.placeholder_text }}">
                    <# if (settings.show_button === 'yes') { #>
                        <button type="submit" class="pda-search-button">
                            <# if (settings.button_type === 'text' || settings.button_type === 'both') { #>
                                <span class="pda-search-button-text">{{{ settings.button_text }}}</span>
                            <# } #>
                            <# if (settings.button_type === 'icon' || settings.button_type === 'both') { #>
                                <# var iconHTML = elementor.helpers.renderIcon(view, settings.button_icon, { 'aria-hidden': true }, 'i', 'object'); #>
                                {{{ iconHTML.value }}}
                            <# } #>
                        </button>
                    <# } #>
                </div>
            </form>
        </div>
        <?php
    }
}
