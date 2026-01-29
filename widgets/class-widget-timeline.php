<?php
/**
 * Timeline Widget
 * 
 * Widget de história/linha do tempo com animações de scroll
 *
 * @package Elementor_Widgets_PDA
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Timeline Widget Class
 */
class Elementor_Widgets_PDA_Timeline extends \Elementor\Widget_Base {

    /**
     * Get widget name
     */
    public function get_name() {
        return 'pda_timeline';
    }

    /**
     * Get widget title
     */
    public function get_title() {
        return __('PDA - Timeline História', 'elementor-widgets-pda');
    }

    /**
     * Get widget icon
     */
    public function get_icon() {
        return 'eicon-time-line';
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
        return ['timeline', 'história', 'history', 'tempo', 'linha', 'pda', 'scroll', 'animação'];
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
        // Content Tab - Itens da Timeline
        // ==============================
        
        $this->start_controls_section(
            'timeline_items_section',
            [
                'label' => __('Itens da Timeline', 'elementor-widgets-pda'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $repeater = new \Elementor\Repeater();

        $repeater->add_control(
            'date',
            [
                'label' => __('Data/Período', 'elementor-widgets-pda'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('Década de 1970', 'elementor-widgets-pda'),
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'title',
            [
                'label' => __('Título', 'elementor-widgets-pda'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('Um encontro', 'elementor-widgets-pda'),
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'description',
            [
                'label' => __('Descrição', 'elementor-widgets-pda'),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'default' => __('Descrição do evento na linha do tempo.', 'elementor-widgets-pda'),
                'rows' => 5,
            ]
        );

        $repeater->add_control(
            'image',
            [
                'label' => __('Imagem', 'elementor-widgets-pda'),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'default' => [
                    'url' => \Elementor\Utils::get_placeholder_image_src(),
                ],
            ]
        );

        $repeater->add_group_control(
            \Elementor\Group_Control_Image_Size::get_type(),
            [
                'name' => 'image_size',
                'default' => 'medium_large',
            ]
        );

        $this->add_control(
            'timeline_items',
            [
                'label' => __('Itens', 'elementor-widgets-pda'),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'date' => __('Década de 1970', 'elementor-widgets-pda'),
                        'title' => __('Um encontro', 'elementor-widgets-pda'),
                        'description' => __('Em 1976, a veterinária Anna-Sophie Helene se mudou da Alemanha para a Namíbia, na África, onde conheceu Dennis Croukamp.', 'elementor-widgets-pda'),
                    ],
                    [
                        'date' => __('Década de 1980', 'elementor-widgets-pda'),
                        'title' => __('Uma paixão', 'elementor-widgets-pda'),
                        'description' => __('O casal ganhou um filhote de papagaio-do-congo, Pumuckl, que se tornou um membro da família.', 'elementor-widgets-pda'),
                    ],
                    [
                        'date' => __('Início dos anos 1990', 'elementor-widgets-pda'),
                        'title' => __('Uma aventura', 'elementor-widgets-pda'),
                        'description' => __('A família se mudou para a Ilha de Man, no Reino Unido. Um amigo sugeriu que abrissem um parque.', 'elementor-widgets-pda'),
                    ],
                ],
                'title_field' => '{{{ date }}} - {{{ title }}}',
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
            'layout_style',
            [
                'label' => __('Estilo do Layout', 'elementor-widgets-pda'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'alternating',
                'options' => [
                    'alternating' => __('Alternado', 'elementor-widgets-pda'),
                    'left' => __('Conteúdo à Esquerda', 'elementor-widgets-pda'),
                    'right' => __('Conteúdo à Direita', 'elementor-widgets-pda'),
                ],
            ]
        );

        $this->add_control(
            'first_item_position',
            [
                'label' => __('Primeiro Item', 'elementor-widgets-pda'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'left',
                'options' => [
                    'left' => __('Conteúdo à Esquerda', 'elementor-widgets-pda'),
                    'right' => __('Conteúdo à Direita', 'elementor-widgets-pda'),
                ],
                'condition' => [
                    'layout_style' => 'alternating',
                ],
            ]
        );

        $this->add_control(
            'show_line',
            [
                'label' => __('Mostrar Linha Central', 'elementor-widgets-pda'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __('Sim', 'elementor-widgets-pda'),
                'label_off' => __('Não', 'elementor-widgets-pda'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'show_dots',
            [
                'label' => __('Mostrar Marcadores', 'elementor-widgets-pda'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __('Sim', 'elementor-widgets-pda'),
                'label_off' => __('Não', 'elementor-widgets-pda'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->end_controls_section();

        // ==============================
        // Content Tab - Animações
        // ==============================
        
        $this->start_controls_section(
            'animation_section',
            [
                'label' => __('Animações de Scroll', 'elementor-widgets-pda'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'enable_animation',
            [
                'label' => __('Ativar Animações', 'elementor-widgets-pda'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __('Sim', 'elementor-widgets-pda'),
                'label_off' => __('Não', 'elementor-widgets-pda'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'animation_type',
            [
                'label' => __('Tipo de Animação', 'elementor-widgets-pda'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'fade-slide',
                'options' => [
                    'fade' => __('Fade In', 'elementor-widgets-pda'),
                    'fade-slide' => __('Fade + Slide', 'elementor-widgets-pda'),
                    'fade-scale' => __('Fade + Scale', 'elementor-widgets-pda'),
                    'slide-only' => __('Slide Only', 'elementor-widgets-pda'),
                    'blur-in' => __('Blur In', 'elementor-widgets-pda'),
                    'rotate-in' => __('Rotate In', 'elementor-widgets-pda'),
                ],
                'condition' => [
                    'enable_animation' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'animation_duration',
            [
                'label' => __('Duração (ms)', 'elementor-widgets-pda'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 200,
                        'max' => 2000,
                        'step' => 100,
                    ],
                ],
                'default' => [
                    'size' => 800,
                ],
                'condition' => [
                    'enable_animation' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'animation_delay',
            [
                'label' => __('Delay entre Itens (ms)', 'elementor-widgets-pda'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 500,
                        'step' => 50,
                    ],
                ],
                'default' => [
                    'size' => 150,
                ],
                'condition' => [
                    'enable_animation' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'animation_offset',
            [
                'label' => __('Offset de Trigger (%)', 'elementor-widgets-pda'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 50,
                        'step' => 5,
                    ],
                ],
                'default' => [
                    'size' => 20,
                ],
                'condition' => [
                    'enable_animation' => 'yes',
                ],
                'description' => __('Porcentagem da viewport para iniciar a animação', 'elementor-widgets-pda'),
            ]
        );

        $this->add_control(
            'stagger_animation',
            [
                'label' => __('Animar Texto e Imagem Separados', 'elementor-widgets-pda'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __('Sim', 'elementor-widgets-pda'),
                'label_off' => __('Não', 'elementor-widgets-pda'),
                'return_value' => 'yes',
                'default' => 'yes',
                'condition' => [
                    'enable_animation' => 'yes',
                ],
            ]
        );

        $this->end_controls_section();

        // ==============================
        // Style Tab - Linha Central
        // ==============================
        
        $this->start_controls_section(
            'style_line_section',
            [
                'label' => __('Linha Central', 'elementor-widgets-pda'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
                'condition' => [
                    'show_line' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'line_color',
            [
                'label' => __('Cor da Linha', 'elementor-widgets-pda'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#1B4F72',
                'selectors' => [
                    '{{WRAPPER}} .ewpda-tl__line' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'line_width',
            [
                'label' => __('Largura da Linha', 'elementor-widgets-pda'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 1,
                        'max' => 10,
                    ],
                ],
                'default' => [
                    'size' => 3,
                ],
                'selectors' => [
                    '{{WRAPPER}} .ewpda-tl__line' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        // ==============================
        // Style Tab - Marcadores
        // ==============================
        
        $this->start_controls_section(
            'style_dots_section',
            [
                'label' => __('Marcadores', 'elementor-widgets-pda'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
                'condition' => [
                    'show_dots' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'dot_color',
            [
                'label' => __('Cor do Marcador', 'elementor-widgets-pda'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#1B4F72',
                'selectors' => [
                    '{{WRAPPER}} .ewpda-tl__dot' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'dot_border_color',
            [
                'label' => __('Cor da Borda', 'elementor-widgets-pda'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#FFFFFF',
                'selectors' => [
                    '{{WRAPPER}} .ewpda-tl__dot' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'dot_size',
            [
                'label' => __('Tamanho', 'elementor-widgets-pda'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 10,
                        'max' => 40,
                    ],
                ],
                'default' => [
                    'size' => 16,
                ],
                'selectors' => [
                    '{{WRAPPER}} .ewpda-tl__dot' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'dot_border_width',
            [
                'label' => __('Largura da Borda', 'elementor-widgets-pda'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 6,
                    ],
                ],
                'default' => [
                    'size' => 3,
                ],
                'selectors' => [
                    '{{WRAPPER}} .ewpda-tl__dot' => 'border-width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        // ==============================
        // Style Tab - Data
        // ==============================
        
        $this->start_controls_section(
            'style_date_section',
            [
                'label' => __('Data/Período', 'elementor-widgets-pda'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'date_color',
            [
                'label' => __('Cor', 'elementor-widgets-pda'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#1B4F72',
                'selectors' => [
                    '{{WRAPPER}} .ewpda-tl__date' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'date_typography',
                'label' => __('Tipografia', 'elementor-widgets-pda'),
                'selector' => '{{WRAPPER}} .ewpda-tl__date',
            ]
        );

        $this->add_responsive_control(
            'date_spacing',
            [
                'label' => __('Espaçamento Inferior', 'elementor-widgets-pda'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 30,
                    ],
                ],
                'default' => [
                    'size' => 5,
                ],
                'selectors' => [
                    '{{WRAPPER}} .ewpda-tl__date' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        // ==============================
        // Style Tab - Título
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
                'default' => '#1B4F72',
                'selectors' => [
                    '{{WRAPPER}} .ewpda-tl__title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'title_typography',
                'label' => __('Tipografia', 'elementor-widgets-pda'),
                'selector' => '{{WRAPPER}} .ewpda-tl__title',
            ]
        );

        $this->add_responsive_control(
            'title_spacing',
            [
                'label' => __('Espaçamento Inferior', 'elementor-widgets-pda'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 40,
                    ],
                ],
                'default' => [
                    'size' => 15,
                ],
                'selectors' => [
                    '{{WRAPPER}} .ewpda-tl__title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        // ==============================
        // Style Tab - Descrição
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
                'default' => '#333333',
                'selectors' => [
                    '{{WRAPPER}} .ewpda-tl__description' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'description_typography',
                'label' => __('Tipografia', 'elementor-widgets-pda'),
                'selector' => '{{WRAPPER}} .ewpda-tl__description',
            ]
        );

        $this->end_controls_section();

        // ==============================
        // Style Tab - Imagem
        // ==============================
        
        $this->start_controls_section(
            'style_image_section',
            [
                'label' => __('Imagem', 'elementor-widgets-pda'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'image_border_radius',
            [
                'label' => __('Borda Arredondada', 'elementor-widgets-pda'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'default' => [
                    'top' => '10',
                    'right' => '10',
                    'bottom' => '10',
                    'left' => '10',
                    'unit' => 'px',
                    'isLinked' => true,
                ],
                'selectors' => [
                    '{{WRAPPER}} .ewpda-tl__image img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'image_box_shadow',
                'label' => __('Sombra', 'elementor-widgets-pda'),
                'selector' => '{{WRAPPER}} .ewpda-tl__image img',
            ]
        );

        $this->add_responsive_control(
            'image_max_width',
            [
                'label' => __('Largura Máxima', 'elementor-widgets-pda'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range' => [
                    'px' => [
                        'min' => 100,
                        'max' => 600,
                    ],
                    '%' => [
                        'min' => 20,
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'size' => 100,
                    'unit' => '%',
                ],
                'selectors' => [
                    '{{WRAPPER}} .ewpda-tl__image img' => 'max-width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        // ==============================
        // Style Tab - Espaçamentos
        // ==============================
        
        $this->start_controls_section(
            'style_spacing_section',
            [
                'label' => __('Espaçamentos', 'elementor-widgets-pda'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'item_spacing',
            [
                'label' => __('Espaço entre Itens', 'elementor-widgets-pda'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 20,
                        'max' => 150,
                    ],
                ],
                'default' => [
                    'size' => 60,
                ],
                'selectors' => [
                    '{{WRAPPER}} .ewpda-tl__item' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'content_padding',
            [
                'label' => __('Padding do Conteúdo', 'elementor-widgets-pda'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .ewpda-tl__content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'columns_gap',
            [
                'label' => __('Espaço entre Colunas', 'elementor-widgets-pda'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range' => [
                    'px' => [
                        'min' => 20,
                        'max' => 100,
                    ],
                    '%' => [
                        'min' => 2,
                        'max' => 15,
                    ],
                ],
                'default' => [
                    'size' => 40,
                    'unit' => 'px',
                ],
                'selectors' => [
                    '{{WRAPPER}} .ewpda-tl__item' => 'gap: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    /**
     * Render widget output on the frontend
     */
    protected function render() {
        $settings = $this->get_settings_for_display();
        
        $layout = $settings['layout_style'];
        $first_position = $settings['first_item_position'];
        $show_line = $settings['show_line'] === 'yes';
        $show_dots = $settings['show_dots'] === 'yes';
        
        // Animation settings
        $enable_animation = $settings['enable_animation'] === 'yes';
        $animation_type = $settings['animation_type'];
        $animation_duration = $settings['animation_duration']['size'];
        $animation_delay = $settings['animation_delay']['size'];
        $animation_offset = $settings['animation_offset']['size'];
        $stagger = $settings['stagger_animation'] === 'yes';

        $timeline_classes = ['ewpda-tl'];
        $timeline_classes[] = 'ewpda-tl--' . $layout;
        
        if ($enable_animation) {
            $timeline_classes[] = 'ewpda-tl--animated';
        }

        $data_attrs = '';
        if ($enable_animation) {
            $data_attrs = sprintf(
                'data-animation="%s" data-duration="%d" data-delay="%d" data-offset="%d" data-stagger="%s"',
                esc_attr($animation_type),
                $animation_duration,
                $animation_delay,
                $animation_offset,
                $stagger ? 'true' : 'false'
            );
        }
        ?>
        
        <div class="<?php echo esc_attr(implode(' ', $timeline_classes)); ?>" <?php echo $data_attrs; ?>>
            
            <?php if ($show_line) : ?>
                <div class="ewpda-tl__line"></div>
            <?php endif; ?>
            
            <?php foreach ($settings['timeline_items'] as $index => $item) : 
                // Determine position
                if ($layout === 'alternating') {
                    $is_left = ($first_position === 'left') ? ($index % 2 === 0) : ($index % 2 !== 0);
                } else {
                    $is_left = ($layout === 'left');
                }
                
                $item_classes = ['ewpda-tl__item'];
                $item_classes[] = $is_left ? 'ewpda-tl__item--left' : 'ewpda-tl__item--right';
                
                if ($enable_animation) {
                    $item_classes[] = 'ewpda-tl__item--hidden';
                }

                // Image
                $image_html = '';
                if (!empty($item['image']['id'])) {
                    $image_html = \Elementor\Group_Control_Image_Size::get_attachment_image_html($item, 'image_size', 'image');
                } elseif (!empty($item['image']['url'])) {
                    $image_html = '<img src="' . esc_url($item['image']['url']) . '" alt="' . esc_attr($item['title']) . '">';
                }
            ?>
                
                <div class="<?php echo esc_attr(implode(' ', $item_classes)); ?>" data-index="<?php echo $index; ?>">
                    
                    <?php if ($show_dots) : ?>
                        <div class="ewpda-tl__dot"></div>
                    <?php endif; ?>
                    
                    <div class="ewpda-tl__content">
                        <?php if (!empty($item['date'])) : ?>
                            <div class="ewpda-tl__date"><?php echo esc_html($item['date']); ?></div>
                        <?php endif; ?>
                        
                        <?php if (!empty($item['title'])) : ?>
                            <h3 class="ewpda-tl__title"><?php echo esc_html($item['title']); ?></h3>
                        <?php endif; ?>
                        
                        <?php if (!empty($item['description'])) : ?>
                            <div class="ewpda-tl__description"><?php echo wp_kses_post($item['description']); ?></div>
                        <?php endif; ?>
                    </div>
                    
                    <?php if (!empty($image_html)) : ?>
                        <div class="ewpda-tl__image">
                            <?php echo $image_html; ?>
                        </div>
                    <?php endif; ?>
                    
                </div>
                
            <?php endforeach; ?>
            
        </div>
        
        <?php
    }

    /**
     * Render widget output in the editor
     */
    protected function content_template() {
        ?>
        <#
        var layout = settings.layout_style;
        var firstPosition = settings.first_item_position;
        var showLine = settings.show_line === 'yes';
        var showDots = settings.show_dots === 'yes';
        var enableAnimation = settings.enable_animation === 'yes';
        
        var timelineClasses = ['ewpda-tl', 'ewpda-tl--' + layout];
        #>
        
        <div class="{{{ timelineClasses.join(' ') }}}">
            
            <# if (showLine) { #>
                <div class="ewpda-tl__line"></div>
            <# } #>
            
            <# _.each(settings.timeline_items, function(item, index) {
                var isLeft;
                if (layout === 'alternating') {
                    isLeft = (firstPosition === 'left') ? (index % 2 === 0) : (index % 2 !== 0);
                } else {
                    isLeft = (layout === 'left');
                }
                
                var itemClasses = ['ewpda-tl__item'];
                itemClasses.push(isLeft ? 'ewpda-tl__item--left' : 'ewpda-tl__item--right');
            #>
                
                <div class="{{{ itemClasses.join(' ') }}}">
                    
                    <# if (showDots) { #>
                        <div class="ewpda-tl__dot"></div>
                    <# } #>
                    
                    <div class="ewpda-tl__content">
                        <# if (item.date) { #>
                            <div class="ewpda-tl__date">{{{ item.date }}}</div>
                        <# } #>
                        
                        <# if (item.title) { #>
                            <h3 class="ewpda-tl__title">{{{ item.title }}}</h3>
                        <# } #>
                        
                        <# if (item.description) { #>
                            <div class="ewpda-tl__description">{{{ item.description }}}</div>
                        <# } #>
                    </div>
                    
                    <# if (item.image.url) { #>
                        <div class="ewpda-tl__image">
                            <img src="{{{ item.image.url }}}" alt="">
                        </div>
                    <# } #>
                    
                </div>
                
            <# }); #>
            
        </div>
        <?php
    }
}
