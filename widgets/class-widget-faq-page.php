<?php
/**
 * FAQ Page Widget
 * 
 * Widget de FAQ Página Completa
 *
 * @package Elementor_Widgets_PDA
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * FAQ Page Widget Class
 */
class Elementor_Widgets_PDA_FAQ_Page extends \Elementor\Widget_Base {

    /**
     * Get widget name
     */
    public function get_name() {
        return 'pda_faq_page';
    }

    /**
     * Get widget title
     */
    public function get_title() {
        return __('FAQ Página Completa', 'elementor-widgets-pda');
    }

    /**
     * Get widget icon
     */
    public function get_icon() {
        return 'eicon-single-page';
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
        return ['faq', 'perguntas', 'pagina', 'completa', 'categorias', 'pda'];
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
        // Content Tab - Categories
        // ==============================
        
        $this->start_controls_section(
            'categories_section',
            [
                'label' => __('Categorias', 'elementor-widgets-pda'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $category_repeater = new \Elementor\Repeater();

        $category_repeater->add_control(
            'category_title',
            [
                'label' => __('Título da Categoria', 'elementor-widgets-pda'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('Categoria', 'elementor-widgets-pda'),
                'label_block' => true,
            ]
        );

        $category_repeater->add_control(
            'category_icon',
            [
                'label' => __('Ícone da Categoria', 'elementor-widgets-pda'),
                'type' => \Elementor\Controls_Manager::ICONS,
                'default' => [
                    'value' => 'fas fa-folder',
                    'library' => 'fa-solid',
                ],
            ]
        );

        $category_repeater->add_control(
            'category_description',
            [
                'label' => __('Descrição', 'elementor-widgets-pda'),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'default' => '',
            ]
        );

        $this->add_control(
            'categories',
            [
                'label' => __('Categorias', 'elementor-widgets-pda'),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $category_repeater->get_controls(),
                'default' => [
                    [
                        'category_title' => __('Geral', 'elementor-widgets-pda'),
                        'category_icon' => ['value' => 'fas fa-info-circle', 'library' => 'fa-solid'],
                    ],
                    [
                        'category_title' => __('Pagamentos', 'elementor-widgets-pda'),
                        'category_icon' => ['value' => 'fas fa-credit-card', 'library' => 'fa-solid'],
                    ],
                    [
                        'category_title' => __('Suporte', 'elementor-widgets-pda'),
                        'category_icon' => ['value' => 'fas fa-headset', 'library' => 'fa-solid'],
                    ],
                ],
                'title_field' => '{{{ category_title }}}',
            ]
        );

        $this->end_controls_section();

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

        $faq_repeater = new \Elementor\Repeater();

        $faq_repeater->add_control(
            'faq_category',
            [
                'label' => __('Categoria', 'elementor-widgets-pda'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('Geral', 'elementor-widgets-pda'),
                'description' => __('Digite o nome exato da categoria', 'elementor-widgets-pda'),
            ]
        );

        $faq_repeater->add_control(
            'faq_question',
            [
                'label' => __('Pergunta', 'elementor-widgets-pda'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('Pergunta do FAQ', 'elementor-widgets-pda'),
                'label_block' => true,
            ]
        );

        $faq_repeater->add_control(
            'faq_answer',
            [
                'label' => __('Resposta', 'elementor-widgets-pda'),
                'type' => \Elementor\Controls_Manager::WYSIWYG,
                'default' => __('Resposta da pergunta do FAQ.', 'elementor-widgets-pda'),
            ]
        );

        $this->add_control(
            'faq_items',
            [
                'label' => __('Itens do FAQ', 'elementor-widgets-pda'),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $faq_repeater->get_controls(),
                'default' => [
                    [
                        'faq_category' => __('Geral', 'elementor-widgets-pda'),
                        'faq_question' => __('O que é este serviço?', 'elementor-widgets-pda'),
                        'faq_answer' => __('Este é um serviço de exemplo para demonstrar o widget.', 'elementor-widgets-pda'),
                    ],
                    [
                        'faq_category' => __('Geral', 'elementor-widgets-pda'),
                        'faq_question' => __('Como começar?', 'elementor-widgets-pda'),
                        'faq_answer' => __('Basta se cadastrar e seguir as instruções.', 'elementor-widgets-pda'),
                    ],
                    [
                        'faq_category' => __('Pagamentos', 'elementor-widgets-pda'),
                        'faq_question' => __('Quais formas de pagamento?', 'elementor-widgets-pda'),
                        'faq_answer' => __('Aceitamos cartão de crédito, boleto e PIX.', 'elementor-widgets-pda'),
                    ],
                    [
                        'faq_category' => __('Suporte', 'elementor-widgets-pda'),
                        'faq_question' => __('Como entrar em contato?', 'elementor-widgets-pda'),
                        'faq_answer' => __('Você pode nos contatar pelo chat ou email.', 'elementor-widgets-pda'),
                    ],
                ],
                'title_field' => '[{{{ faq_category }}}] {{{ faq_question }}}',
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
            ]
        );

        $this->end_controls_section();

        // ==============================
        // Content Tab - Layout
        // ==============================
        
        $this->start_controls_section(
            'layout_section',
            [
                'label' => __('Layout', 'elementor-widgets-pda'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'show_search',
            [
                'label' => __('Mostrar Busca', 'elementor-widgets-pda'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __('Sim', 'elementor-widgets-pda'),
                'label_off' => __('Não', 'elementor-widgets-pda'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'search_placeholder',
            [
                'label' => __('Placeholder da Busca', 'elementor-widgets-pda'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('Buscar pergunta...', 'elementor-widgets-pda'),
                'condition' => [
                    'show_search' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'show_category_nav',
            [
                'label' => __('Mostrar Navegação por Categoria', 'elementor-widgets-pda'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __('Sim', 'elementor-widgets-pda'),
                'label_off' => __('Não', 'elementor-widgets-pda'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->add_responsive_control(
            'category_nav_columns',
            [
                'label' => __('Colunas da Navegação', 'elementor-widgets-pda'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => '3',
                'options' => [
                    '1' => '1',
                    '2' => '2',
                    '3' => '3',
                    '4' => '4',
                ],
                'selectors' => [
                    '{{WRAPPER}} .pda-faq-page-nav' => 'grid-template-columns: repeat({{VALUE}}, 1fr);',
                ],
                'condition' => [
                    'show_category_nav' => 'yes',
                ],
            ]
        );

        $this->end_controls_section();

        // ==============================
        // Style Tab - Search
        // ==============================
        
        $this->start_controls_section(
            'style_search_section',
            [
                'label' => __('Busca', 'elementor-widgets-pda'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
                'condition' => [
                    'show_search' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'search_background',
            [
                'label' => __('Cor de Fundo', 'elementor-widgets-pda'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .pda-faq-page-search input' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'search_text_color',
            [
                'label' => __('Cor do Texto', 'elementor-widgets-pda'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .pda-faq-page-search input' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'search_border',
                'selector' => '{{WRAPPER}} .pda-faq-page-search input',
            ]
        );

        $this->add_control(
            'search_border_radius',
            [
                'label' => __('Raio da Borda', 'elementor-widgets-pda'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .pda-faq-page-search input' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'search_padding',
            [
                'label' => __('Espaçamento Interno', 'elementor-widgets-pda'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .pda-faq-page-search input' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        // ==============================
        // Style Tab - Category Nav
        // ==============================
        
        $this->start_controls_section(
            'style_nav_section',
            [
                'label' => __('Navegação por Categoria', 'elementor-widgets-pda'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
                'condition' => [
                    'show_category_nav' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'nav_item_background',
            [
                'label' => __('Cor de Fundo', 'elementor-widgets-pda'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .pda-faq-page-nav-item' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'nav_item_background_hover',
            [
                'label' => __('Cor de Fundo (Hover)', 'elementor-widgets-pda'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .pda-faq-page-nav-item:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'nav_item_background_active',
            [
                'label' => __('Cor de Fundo (Ativo)', 'elementor-widgets-pda'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .pda-faq-page-nav-item.active' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'nav_item_text_color',
            [
                'label' => __('Cor do Texto', 'elementor-widgets-pda'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .pda-faq-page-nav-item' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'nav_item_border',
                'selector' => '{{WRAPPER}} .pda-faq-page-nav-item',
            ]
        );

        $this->add_control(
            'nav_item_border_radius',
            [
                'label' => __('Raio da Borda', 'elementor-widgets-pda'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .pda-faq-page-nav-item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'nav_item_padding',
            [
                'label' => __('Espaçamento Interno', 'elementor-widgets-pda'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .pda-faq-page-nav-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'nav_item_box_shadow',
                'selector' => '{{WRAPPER}} .pda-faq-page-nav-item',
            ]
        );

        $this->end_controls_section();

        // ==============================
        // Style Tab - Category Title
        // ==============================
        
        $this->start_controls_section(
            'style_category_title_section',
            [
                'label' => __('Título da Categoria', 'elementor-widgets-pda'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'category_title_color',
            [
                'label' => __('Cor', 'elementor-widgets-pda'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .pda-faq-page-category-title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'category_title_typography',
                'selector' => '{{WRAPPER}} .pda-faq-page-category-title',
            ]
        );

        $this->add_responsive_control(
            'category_title_margin',
            [
                'label' => __('Margem', 'elementor-widgets-pda'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .pda-faq-page-category-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        // ==============================
        // Style Tab - FAQ Items
        // ==============================
        
        $this->start_controls_section(
            'style_faq_item_section',
            [
                'label' => __('Itens do FAQ', 'elementor-widgets-pda'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'faq_item_background',
            [
                'label' => __('Cor de Fundo', 'elementor-widgets-pda'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .pda-faq-page-item' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'faq_question_color',
            [
                'label' => __('Cor da Pergunta', 'elementor-widgets-pda'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .pda-faq-page-question' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'faq_answer_color',
            [
                'label' => __('Cor da Resposta', 'elementor-widgets-pda'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .pda-faq-page-answer' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'faq_question_typography',
                'label' => __('Tipografia da Pergunta', 'elementor-widgets-pda'),
                'selector' => '{{WRAPPER}} .pda-faq-page-question',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'faq_answer_typography',
                'label' => __('Tipografia da Resposta', 'elementor-widgets-pda'),
                'selector' => '{{WRAPPER}} .pda-faq-page-answer',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'faq_item_border',
                'selector' => '{{WRAPPER}} .pda-faq-page-item',
            ]
        );

        $this->add_control(
            'faq_item_border_radius',
            [
                'label' => __('Raio da Borda', 'elementor-widgets-pda'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .pda-faq-page-item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'faq_item_padding',
            [
                'label' => __('Espaçamento Interno', 'elementor-widgets-pda'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .pda-faq-page-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'faq_item_margin',
            [
                'label' => __('Margem', 'elementor-widgets-pda'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .pda-faq-page-item' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
        
        // Group FAQs by category
        $faqs_by_category = [];
        foreach ($settings['faq_items'] as $item) {
            $category = $item['faq_category'];
            if (!isset($faqs_by_category[$category])) {
                $faqs_by_category[$category] = [];
            }
            $faqs_by_category[$category][] = $item;
        }
        
        // Schema items
        $schema_items = [];
        if ($settings['faq_schema'] === 'yes') {
            foreach ($settings['faq_items'] as $item) {
                $schema_items[] = [
                    '@type' => 'Question',
                    'name' => $item['faq_question'],
                    'acceptedAnswer' => [
                        '@type' => 'Answer',
                        'text' => wp_strip_all_tags($item['faq_answer']),
                    ],
                ];
            }
        }
        
        $widget_id = $this->get_id();
        ?>
        <div class="pda-faq-page-wrapper" data-widget-id="<?php echo esc_attr($widget_id); ?>">
            
            <?php if ($settings['show_search'] === 'yes') : ?>
                <div class="pda-faq-page-search">
                    <input type="text" placeholder="<?php echo esc_attr($settings['search_placeholder']); ?>" class="pda-faq-page-search-input">
                </div>
            <?php endif; ?>
            
            <?php if ($settings['show_category_nav'] === 'yes') : ?>
                <div class="pda-faq-page-nav">
                    <?php foreach ($settings['categories'] as $index => $category) : ?>
                        <div class="pda-faq-page-nav-item<?php echo $index === 0 ? ' active' : ''; ?>" data-category="<?php echo esc_attr(sanitize_title($category['category_title'])); ?>">
                            <span class="pda-faq-page-nav-icon">
                                <?php \Elementor\Icons_Manager::render_icon($category['category_icon'], ['aria-hidden' => 'true']); ?>
                            </span>
                            <span class="pda-faq-page-nav-title"><?php echo esc_html($category['category_title']); ?></span>
                            <?php if (!empty($category['category_description'])) : ?>
                                <span class="pda-faq-page-nav-desc"><?php echo esc_html($category['category_description']); ?></span>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
            
            <div class="pda-faq-page-content">
                <?php foreach ($settings['categories'] as $index => $category) : 
                    $category_slug = sanitize_title($category['category_title']);
                    $category_faqs = $faqs_by_category[$category['category_title']] ?? [];
                ?>
                    <div class="pda-faq-page-category<?php echo $index === 0 ? ' active' : ''; ?>" data-category="<?php echo esc_attr($category_slug); ?>">
                        <h3 class="pda-faq-page-category-title">
                            <?php \Elementor\Icons_Manager::render_icon($category['category_icon'], ['aria-hidden' => 'true']); ?>
                            <?php echo esc_html($category['category_title']); ?>
                        </h3>
                        
                        <div class="pda-faq-page-items">
                            <?php foreach ($category_faqs as $faq) : ?>
                                <div class="pda-faq-page-item">
                                    <div class="pda-faq-page-question">
                                        <span class="pda-faq-page-question-text"><?php echo esc_html($faq['faq_question']); ?></span>
                                        <span class="pda-faq-page-toggle">
                                            <i class="fas fa-chevron-down"></i>
                                        </span>
                                    </div>
                                    <div class="pda-faq-page-answer" style="display: none;">
                                        <?php echo wp_kses_post($faq['faq_answer']); ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
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
}
