<?php
/**
 * Image Card Widget
 * 
 * Card com imagem e texto com fundo colorido
 *
 * @package Elementor_Widgets_PDA
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Image Card Widget Class
 */
class Elementor_Widgets_PDA_Image_Card extends \Elementor\Widget_Base {

    /**
     * Get widget name
     */
    public function get_name() {
        return 'pda_image_card';
    }

    /**
     * Get widget title
     */
    public function get_title() {
        return __('PDA - Image Card', 'elementor-widgets-pda');
    }

    /**
     * Get widget icon
     */
    public function get_icon() {
        return 'eicon-image-box';
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
        return ['card', 'image', 'imagem', 'box', 'pda', 'texto'];
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
        // Content Tab - Imagem
        // ==============================
        
        $this->start_controls_section(
            'image_section',
            [
                'label' => __('Imagem', 'elementor-widgets-pda'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'image',
            [
                'label' => __('Escolher Imagem', 'elementor-widgets-pda'),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'default' => [
                    'url' => \Elementor\Utils::get_placeholder_image_src(),
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Image_Size::get_type(),
            [
                'name' => 'image_size',
                'default' => 'large',
                'separator' => 'none',
            ]
        );

        $this->end_controls_section();

        // ==============================
        // Content Tab - Texto
        // ==============================
        
        $this->start_controls_section(
            'text_section',
            [
                'label' => __('Texto', 'elementor-widgets-pda'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'card_text',
            [
                'label' => __('Texto do Card', 'elementor-widgets-pda'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('Texto do Card', 'elementor-widgets-pda'),
                'placeholder' => __('Digite o texto', 'elementor-widgets-pda'),
                'label_block' => true,
            ]
        );

        $this->add_control(
            'link',
            [
                'label' => __('Link', 'elementor-widgets-pda'),
                'type' => \Elementor\Controls_Manager::URL,
                'placeholder' => __('https://seu-link.com', 'elementor-widgets-pda'),
                'default' => [
                    'url' => '',
                    'is_external' => false,
                    'nofollow' => false,
                ],
                'label_block' => true,
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
            'image_height',
            [
                'label' => __('Altura da Imagem', 'elementor-widgets-pda'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', 'vh', '%'],
                'range' => [
                    'px' => [
                        'min' => 100,
                        'max' => 800,
                        'step' => 10,
                    ],
                    'vh' => [
                        'min' => 10,
                        'max' => 100,
                    ],
                    '%' => [
                        'min' => 10,
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 280,
                ],
                'selectors' => [
                    '{{WRAPPER}} .pda-image-card__image' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'image_fit',
            [
                'label' => __('Ajuste da Imagem', 'elementor-widgets-pda'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'cover',
                'options' => [
                    'cover' => __('Cover', 'elementor-widgets-pda'),
                    'contain' => __('Contain', 'elementor-widgets-pda'),
                    'fill' => __('Fill', 'elementor-widgets-pda'),
                    'none' => __('None', 'elementor-widgets-pda'),
                ],
                'selectors' => [
                    '{{WRAPPER}} .pda-image-card__image img' => 'object-fit: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'image_position',
            [
                'label' => __('Posição da Imagem', 'elementor-widgets-pda'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'center center',
                'options' => [
                    'top left' => __('Top Left', 'elementor-widgets-pda'),
                    'top center' => __('Top Center', 'elementor-widgets-pda'),
                    'top right' => __('Top Right', 'elementor-widgets-pda'),
                    'center left' => __('Center Left', 'elementor-widgets-pda'),
                    'center center' => __('Center Center', 'elementor-widgets-pda'),
                    'center right' => __('Center Right', 'elementor-widgets-pda'),
                    'bottom left' => __('Bottom Left', 'elementor-widgets-pda'),
                    'bottom center' => __('Bottom Center', 'elementor-widgets-pda'),
                    'bottom right' => __('Bottom Right', 'elementor-widgets-pda'),
                ],
                'selectors' => [
                    '{{WRAPPER}} .pda-image-card__image img' => 'object-position: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'image_border_radius',
            [
                'label' => __('Borda Arredondada', 'elementor-widgets-pda'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'default' => [
                    'top' => '15',
                    'right' => '15',
                    'bottom' => '0',
                    'left' => '0',
                    'unit' => 'px',
                    'isLinked' => false,
                ],
                'selectors' => [
                    '{{WRAPPER}} .pda-image-card__image' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        // ==============================
        // Style Tab - Texto
        // ==============================
        
        $this->start_controls_section(
            'style_text_section',
            [
                'label' => __('Texto', 'elementor-widgets-pda'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'text_background_color',
            [
                'label' => __('Cor de Fundo', 'elementor-widgets-pda'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#8B5CF6',
                'selectors' => [
                    '{{WRAPPER}} .pda-image-card__text' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'text_color',
            [
                'label' => __('Cor do Texto', 'elementor-widgets-pda'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#FFFFFF',
                'selectors' => [
                    '{{WRAPPER}} .pda-image-card__text' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'text_typography',
                'label' => __('Tipografia', 'elementor-widgets-pda'),
                'selector' => '{{WRAPPER}} .pda-image-card__text',
            ]
        );

        $this->add_responsive_control(
            'text_align',
            [
                'label' => __('Alinhamento', 'elementor-widgets-pda'),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => __('Esquerda', 'elementor-widgets-pda'),
                        'icon' => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => __('Centro', 'elementor-widgets-pda'),
                        'icon' => 'eicon-text-align-center',
                    ],
                    'right' => [
                        'title' => __('Direita', 'elementor-widgets-pda'),
                        'icon' => 'eicon-text-align-right',
                    ],
                ],
                'default' => 'center',
                'selectors' => [
                    '{{WRAPPER}} .pda-image-card__text' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'text_padding',
            [
                'label' => __('Padding', 'elementor-widgets-pda'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'default' => [
                    'top' => '15',
                    'right' => '20',
                    'bottom' => '15',
                    'left' => '20',
                    'unit' => 'px',
                    'isLinked' => false,
                ],
                'selectors' => [
                    '{{WRAPPER}} .pda-image-card__text' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'text_border_radius',
            [
                'label' => __('Borda Arredondada', 'elementor-widgets-pda'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'default' => [
                    'top' => '0',
                    'right' => '0',
                    'bottom' => '10',
                    'left' => '10',
                    'unit' => 'px',
                    'isLinked' => false,
                ],
                'selectors' => [
                    '{{WRAPPER}} .pda-image-card__text' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        // ==============================
        // Style Tab - Hover
        // ==============================
        
        $this->start_controls_section(
            'style_hover_section',
            [
                'label' => __('Hover', 'elementor-widgets-pda'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'hover_animation',
            [
                'label' => __('Animação', 'elementor-widgets-pda'),
                'type' => \Elementor\Controls_Manager::HOVER_ANIMATION,
            ]
        );

        $this->add_control(
            'image_hover_zoom',
            [
                'label' => __('Zoom na Imagem', 'elementor-widgets-pda'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __('Sim', 'elementor-widgets-pda'),
                'label_off' => __('Não', 'elementor-widgets-pda'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'image_hover_zoom_scale',
            [
                'label' => __('Escala do Zoom', 'elementor-widgets-pda'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 1,
                        'max' => 2,
                        'step' => 0.05,
                    ],
                ],
                'default' => [
                    'size' => 1.1,
                ],
                'condition' => [
                    'image_hover_zoom' => 'yes',
                ],
                'selectors' => [
                    '{{WRAPPER}} .pda-image-card:hover .pda-image-card__image img' => 'transform: scale({{SIZE}});',
                ],
            ]
        );

        $this->add_control(
            'text_hover_background_color',
            [
                'label' => __('Cor de Fundo do Texto (Hover)', 'elementor-widgets-pda'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .pda-image-card:hover .pda-image-card__text' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'card_hover_box_shadow',
                'label' => __('Sombra (Hover)', 'elementor-widgets-pda'),
                'selector' => '{{WRAPPER}} .pda-image-card:hover',
            ]
        );

        $this->end_controls_section();
    }

    /**
     * Render widget output on the frontend
     */
    protected function render() {
        $settings = $this->get_settings_for_display();

        // Classes do card
        $card_classes = ['pda-image-card'];

        if ($settings['hover_animation']) {
            $card_classes[] = 'elementor-animation-' . $settings['hover_animation'];
        }

        // Link
        $has_link = !empty($settings['link']['url']);
        $link_attributes = '';
        
        if ($has_link) {
            $this->add_link_attributes('card_link', $settings['link']);
            $link_attributes = $this->get_render_attribute_string('card_link');
        }

        // Imagem
        $image_html = \Elementor\Group_Control_Image_Size::get_attachment_image_html($settings, 'image_size', 'image');

        // Wrapper tag
        $wrapper_tag = $has_link ? 'a' : 'div';
        ?>
        
        <<?php echo esc_attr($wrapper_tag); ?> class="<?php echo esc_attr(implode(' ', $card_classes)); ?>" <?php echo $link_attributes; ?>>
            <div class="pda-image-card__image">
                <?php echo $image_html; ?>
            </div>
            <div class="pda-image-card__text">
                <?php echo esc_html($settings['card_text']); ?>
            </div>
        </<?php echo esc_attr($wrapper_tag); ?>>

        <?php
    }

    /**
     * Render widget output in the editor
     */
    protected function content_template() {
        ?>
        <#
        var imageUrl = settings.image.url;
        var hasLink = settings.link.url;
        var wrapperTag = hasLink ? 'a' : 'div';
        
        var cardClasses = ['pda-image-card'];
        if (settings.hover_animation) {
            cardClasses.push('elementor-animation-' + settings.hover_animation);
        }
        #>
        
        <{{{ wrapperTag }}} class="{{{ cardClasses.join(' ') }}}" <# if (hasLink) { #>href="{{{ settings.link.url }}}"<# } #>>
            <div class="pda-image-card__image">
                <img src="{{{ imageUrl }}}" alt="">
            </div>
            <div class="pda-image-card__text">
                {{{ settings.card_text }}}
            </div>
        </{{{ wrapperTag }}}>
        <?php
    }
}
