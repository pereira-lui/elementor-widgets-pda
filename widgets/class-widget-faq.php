<?php
/**
 * FAQ Widget
 * 
 * Widget de FAQ (Perguntas Frequentes)
 *
 * @package Elementor_Widgets_PDA
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * FAQ Widget Class
 */
class Elementor_Widgets_PDA_FAQ extends \Elementor\Widget_Base {

    /**
     * Get widget name
     */
    public function get_name() {
        return 'pda_faq';
    }

    /**
     * Get widget title
     */
    public function get_title() {
        return __('FAQ PDA', 'elementor-widgets-pda');
    }

    /**
     * Get widget icon
     */
    public function get_icon() {
        return 'eicon-help-o';
    }

    /**
     * Get widget categories
     */
    public function get_categories() {
        return ['pda-faq'];
    }

    /**
     * Get widget keywords
     */
    public function get_keywords() {
        return ['faq', 'perguntas', 'accordion', 'toggle', 'pda'];
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
        // Content Tab - FAQ Items
        // ==============================
        
        $this->start_controls_section(
            'faq_section',
            [
                'label' => __('Perguntas e Respostas', 'elementor-widgets-pda'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $repeater = new \Elementor\Repeater();

        $repeater->add_control(
            'faq_question',
            [
                'label' => __('Pergunta', 'elementor-widgets-pda'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('Pergunta do FAQ', 'elementor-widgets-pda'),
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'faq_answer',
            [
                'label' => __('Resposta', 'elementor-widgets-pda'),
                'type' => \Elementor\Controls_Manager::WYSIWYG,
                'default' => __('Resposta da pergunta do FAQ.', 'elementor-widgets-pda'),
            ]
        );

        $repeater->add_control(
            'is_active',
            [
                'label' => __('Aberto por Padrão', 'elementor-widgets-pda'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'return_value' => 'yes',
                'default' => '',
            ]
        );

        $this->add_control(
            'faq_items',
            [
                'label' => __('Itens do FAQ', 'elementor-widgets-pda'),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'faq_question' => __('O que é este plugin?', 'elementor-widgets-pda'),
                        'faq_answer' => __('Este é um plugin de widgets customizados para o Elementor.', 'elementor-widgets-pda'),
                    ],
                    [
                        'faq_question' => __('Como usar os widgets?', 'elementor-widgets-pda'),
                        'faq_answer' => __('Basta arrastar o widget desejado para a página e configurar as opções.', 'elementor-widgets-pda'),
                    ],
                ],
                'title_field' => '{{{ faq_question }}}',
            ]
        );

        $this->add_control(
            'faq_schema',
            [
                'label' => __('Adicionar Schema FAQ', 'elementor-widgets-pda'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __('Sim', 'elementor-widgets-pda'),
                'label_off' => __('Não', 'elementor-widgets-pda'),
                'return_value' => 'yes',
                'default' => 'yes',
                'description' => __('Adiciona marcação Schema.org para SEO', 'elementor-widgets-pda'),
            ]
        );

        $this->end_controls_section();

        // ==============================
        // Content Tab - Settings
        // ==============================
        
        $this->start_controls_section(
            'settings_section',
            [
                'label' => __('Configurações', 'elementor-widgets-pda'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'accordion_type',
            [
                'label' => __('Comportamento', 'elementor-widgets-pda'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'accordion',
                'options' => [
                    'accordion' => __('Accordion (um por vez)', 'elementor-widgets-pda'),
                    'toggle' => __('Toggle (múltiplos abertos)', 'elementor-widgets-pda'),
                ],
            ]
        );

        $this->add_control(
            'icon_open',
            [
                'label' => __('Ícone (Fechado)', 'elementor-widgets-pda'),
                'type' => \Elementor\Controls_Manager::ICONS,
                'default' => [
                    'value' => 'fas fa-plus',
                    'library' => 'fa-solid',
                ],
            ]
        );

        $this->add_control(
            'icon_close',
            [
                'label' => __('Ícone (Aberto)', 'elementor-widgets-pda'),
                'type' => \Elementor\Controls_Manager::ICONS,
                'default' => [
                    'value' => 'fas fa-minus',
                    'library' => 'fa-solid',
                ],
            ]
        );

        $this->add_control(
            'icon_position',
            [
                'label' => __('Posição do Ícone', 'elementor-widgets-pda'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'right',
                'options' => [
                    'left' => __('Esquerda', 'elementor-widgets-pda'),
                    'right' => __('Direita', 'elementor-widgets-pda'),
                ],
            ]
        );

        $this->end_controls_section();

        // ==============================
        // Style Tab - Item
        // ==============================
        
        $this->start_controls_section(
            'style_item_section',
            [
                'label' => __('Item', 'elementor-widgets-pda'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'item_background',
            [
                'label' => __('Cor de Fundo', 'elementor-widgets-pda'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .pda-faq-item' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'item_border',
                'selector' => '{{WRAPPER}} .pda-faq-item',
            ]
        );

        $this->add_control(
            'item_border_radius',
            [
                'label' => __('Raio da Borda', 'elementor-widgets-pda'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .pda-faq-item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'item_margin',
            [
                'label' => __('Margem', 'elementor-widgets-pda'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .pda-faq-item' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'item_box_shadow',
                'selector' => '{{WRAPPER}} .pda-faq-item',
            ]
        );

        $this->end_controls_section();

        // ==============================
        // Style Tab - Question
        // ==============================
        
        $this->start_controls_section(
            'style_question_section',
            [
                'label' => __('Pergunta', 'elementor-widgets-pda'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'question_background',
            [
                'label' => __('Cor de Fundo', 'elementor-widgets-pda'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .pda-faq-question' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'question_color',
            [
                'label' => __('Cor do Texto', 'elementor-widgets-pda'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .pda-faq-question' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'question_color_active',
            [
                'label' => __('Cor do Texto (Ativo)', 'elementor-widgets-pda'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .pda-faq-item.active .pda-faq-question' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'question_typography',
                'selector' => '{{WRAPPER}} .pda-faq-question',
            ]
        );

        $this->add_responsive_control(
            'question_padding',
            [
                'label' => __('Espaçamento Interno', 'elementor-widgets-pda'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .pda-faq-question' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        // ==============================
        // Style Tab - Answer
        // ==============================
        
        $this->start_controls_section(
            'style_answer_section',
            [
                'label' => __('Resposta', 'elementor-widgets-pda'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'answer_background',
            [
                'label' => __('Cor de Fundo', 'elementor-widgets-pda'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .pda-faq-answer' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'answer_color',
            [
                'label' => __('Cor do Texto', 'elementor-widgets-pda'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .pda-faq-answer' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'answer_typography',
                'selector' => '{{WRAPPER}} .pda-faq-answer',
            ]
        );

        $this->add_responsive_control(
            'answer_padding',
            [
                'label' => __('Espaçamento Interno', 'elementor-widgets-pda'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .pda-faq-answer' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
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
            ]
        );

        $this->add_control(
            'icon_color',
            [
                'label' => __('Cor do Ícone', 'elementor-widgets-pda'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .pda-faq-icon' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .pda-faq-icon svg' => 'fill: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'icon_color_active',
            [
                'label' => __('Cor do Ícone (Ativo)', 'elementor-widgets-pda'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .pda-faq-item.active .pda-faq-icon' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .pda-faq-item.active .pda-faq-icon svg' => 'fill: {{VALUE}};',
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
                        'max' => 50,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .pda-faq-icon' => 'font-size: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .pda-faq-icon svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
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
        
        $this->add_render_attribute('wrapper', 'class', 'pda-faq-wrapper');
        $this->add_render_attribute('wrapper', 'data-type', $settings['accordion_type']);
        
        // Schema markup
        $schema_items = [];
        ?>
        <div <?php echo $this->get_render_attribute_string('wrapper'); ?>>
            <?php foreach ($settings['faq_items'] as $index => $item) : 
                $item_key = 'item_' . $index;
                $is_active = $item['is_active'] === 'yes';
                
                $this->add_render_attribute($item_key, 'class', 'pda-faq-item');
                if ($is_active) {
                    $this->add_render_attribute($item_key, 'class', 'active');
                }
                
                // Add to schema
                if ($settings['faq_schema'] === 'yes') {
                    $schema_items[] = [
                        '@type' => 'Question',
                        'name' => $item['faq_question'],
                        'acceptedAnswer' => [
                            '@type' => 'Answer',
                            'text' => wp_strip_all_tags($item['faq_answer']),
                        ],
                    ];
                }
            ?>
                <div <?php echo $this->get_render_attribute_string($item_key); ?>>
                    <div class="pda-faq-question pda-faq-icon-<?php echo esc_attr($settings['icon_position']); ?>">
                        <?php if ($settings['icon_position'] === 'left') : ?>
                            <span class="pda-faq-icon pda-faq-icon-open">
                                <?php \Elementor\Icons_Manager::render_icon($settings['icon_open'], ['aria-hidden' => 'true']); ?>
                            </span>
                            <span class="pda-faq-icon pda-faq-icon-close">
                                <?php \Elementor\Icons_Manager::render_icon($settings['icon_close'], ['aria-hidden' => 'true']); ?>
                            </span>
                        <?php endif; ?>
                        
                        <span class="pda-faq-question-text"><?php echo esc_html($item['faq_question']); ?></span>
                        
                        <?php if ($settings['icon_position'] === 'right') : ?>
                            <span class="pda-faq-icon pda-faq-icon-open">
                                <?php \Elementor\Icons_Manager::render_icon($settings['icon_open'], ['aria-hidden' => 'true']); ?>
                            </span>
                            <span class="pda-faq-icon pda-faq-icon-close">
                                <?php \Elementor\Icons_Manager::render_icon($settings['icon_close'], ['aria-hidden' => 'true']); ?>
                            </span>
                        <?php endif; ?>
                    </div>
                    <div class="pda-faq-answer" <?php echo $is_active ? '' : 'style="display: none;"'; ?>>
                        <?php echo wp_kses_post($item['faq_answer']); ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        
        <?php if ($settings['faq_schema'] === 'yes' && !empty($schema_items)) : ?>
            <script type="application/ld+json">
            <?php echo json_encode([
                '@context' => 'https://schema.org',
                '@type' => 'FAQPage',
                'mainEntity' => $schema_items,
            ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES); ?>
            </script>
        <?php endif;
    }

    /**
     * Render widget output in editor
     */
    protected function content_template() {
        ?>
        <#
        view.addRenderAttribute('wrapper', 'class', 'pda-faq-wrapper');
        view.addRenderAttribute('wrapper', 'data-type', settings.accordion_type);
        #>
        <div {{{ view.getRenderAttributeString('wrapper') }}}>
            <# _.each(settings.faq_items, function(item, index) {
                var isActive = item.is_active === 'yes';
                var itemClass = 'pda-faq-item' + (isActive ? ' active' : '');
            #>
                <div class="{{ itemClass }}">
                    <div class="pda-faq-question pda-faq-icon-{{ settings.icon_position }}">
                        <# if (settings.icon_position === 'left') { #>
                            <span class="pda-faq-icon pda-faq-icon-open">
                                <# var iconOpenHTML = elementor.helpers.renderIcon(view, settings.icon_open, { 'aria-hidden': true }, 'i', 'object'); #>
                                {{{ iconOpenHTML.value }}}
                            </span>
                            <span class="pda-faq-icon pda-faq-icon-close">
                                <# var iconCloseHTML = elementor.helpers.renderIcon(view, settings.icon_close, { 'aria-hidden': true }, 'i', 'object'); #>
                                {{{ iconCloseHTML.value }}}
                            </span>
                        <# } #>
                        
                        <span class="pda-faq-question-text">{{{ item.faq_question }}}</span>
                        
                        <# if (settings.icon_position === 'right') { #>
                            <span class="pda-faq-icon pda-faq-icon-open">
                                <# var iconOpenHTML = elementor.helpers.renderIcon(view, settings.icon_open, { 'aria-hidden': true }, 'i', 'object'); #>
                                {{{ iconOpenHTML.value }}}
                            </span>
                            <span class="pda-faq-icon pda-faq-icon-close">
                                <# var iconCloseHTML = elementor.helpers.renderIcon(view, settings.icon_close, { 'aria-hidden': true }, 'i', 'object'); #>
                                {{{ iconCloseHTML.value }}}
                            </span>
                        <# } #>
                    </div>
                    <div class="pda-faq-answer" <# if (!isActive) { #>style="display: none;"<# } #>>
                        {{{ item.faq_answer }}}
                    </div>
                </div>
            <# }); #>
        </div>
        <?php
    }
}
