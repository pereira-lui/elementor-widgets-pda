<?php
/**
 * Plugin Name: Elementor Widgets PDA
 * Plugin URI: https://github.com/pereira-lui/elementor-widgets-pda
 * Description: Plugin de Widgets personalizados para Elementor. Coleção de widgets customizados para diversos usos com atualização automática via GitHub.
 * Version: 1.0.0
 * Author: Lui
 * Author URI: https://github.com/pereira-lui
 * Text Domain: elementor-widgets-pda
 * Domain Path: /languages
 * Requires at least: 5.0
 * Requires PHP: 7.4
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * GitHub Plugin URI: https://github.com/pereira-lui/elementor-widgets-pda
 * GitHub Branch: main
 * Update URI: https://github.com/pereira-lui/elementor-widgets-pda
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

// Define plugin constants
define('ELEMENTOR_WIDGETS_PDA_VERSION', '1.0.0');
define('ELEMENTOR_WIDGETS_PDA_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('ELEMENTOR_WIDGETS_PDA_PLUGIN_URL', plugin_dir_url(__FILE__));
define('ELEMENTOR_WIDGETS_PDA_PLUGIN_FILE', __FILE__);

/**
 * Main Elementor Widgets PDA Class
 */
final class Elementor_Widgets_PDA {

    /**
     * Minimum Elementor Version
     */
    const MINIMUM_ELEMENTOR_VERSION = '3.0.0';

    /**
     * Minimum PHP Version
     */
    const MINIMUM_PHP_VERSION = '7.4';

    /**
     * Instance
     */
    private static $_instance = null;

    /**
     * Singleton Instance
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
        // Load translation
        add_action('init', [$this, 'load_textdomain']);

        // Check for Elementor
        if ($this->is_compatible()) {
            add_action('elementor/init', [$this, 'init']);
        }

        // Include GitHub updater
        $this->includes();

        // Activation/Deactivation hooks
        register_activation_hook(__FILE__, [$this, 'activate']);
        register_deactivation_hook(__FILE__, [$this, 'deactivate']);

        // Enqueue frontend assets
        add_action('wp_enqueue_scripts', [$this, 'enqueue_frontend_assets']);

        // Enqueue editor assets
        add_action('elementor/editor/before_enqueue_scripts', [$this, 'enqueue_editor_assets']);
    }

    /**
     * Load plugin text domain
     */
    public function load_textdomain() {
        load_plugin_textdomain('elementor-widgets-pda', false, dirname(plugin_basename(__FILE__)) . '/languages');
    }

    /**
     * Check if the plugin is compatible
     */
    public function is_compatible() {
        // Check if Elementor is installed and activated
        if (!did_action('elementor/loaded')) {
            add_action('admin_notices', [$this, 'admin_notice_missing_elementor']);
            return false;
        }

        // Check for required Elementor version
        if (!version_compare(ELEMENTOR_VERSION, self::MINIMUM_ELEMENTOR_VERSION, '>=')) {
            add_action('admin_notices', [$this, 'admin_notice_minimum_elementor_version']);
            return false;
        }

        // Check for required PHP version
        if (version_compare(PHP_VERSION, self::MINIMUM_PHP_VERSION, '<')) {
            add_action('admin_notices', [$this, 'admin_notice_minimum_php_version']);
            return false;
        }

        return true;
    }

    /**
     * Include required files
     */
    public function includes() {
        // GitHub Updater
        require_once ELEMENTOR_WIDGETS_PDA_PLUGIN_DIR . 'includes/class-github-updater.php';
        new Elementor_Widgets_PDA_GitHub_Updater(ELEMENTOR_WIDGETS_PDA_PLUGIN_FILE);
    }

    /**
     * Initialize the plugin
     */
    public function init() {
        // Register widget category
        add_action('elementor/elements/categories_registered', [$this, 'register_widget_category']);

        // Register widgets
        add_action('elementor/widgets/register', [$this, 'register_widgets']);
    }

    /**
     * Register custom widget categories
     */
    public function register_widget_category($elements_manager) {
        // Categoria geral de widgets PDA
        $elements_manager->add_category(
            'pda-widgets',
            [
                'title' => __('PDA Widgets', 'elementor-widgets-pda'),
                'icon' => 'fa fa-plug',
            ]
        );
        
        // Categoria de Search
        $elements_manager->add_category(
            'pda-search',
            [
                'title' => __('Search Widget PDA', 'elementor-widgets-pda'),
                'icon' => 'fa fa-search',
            ]
        );
        
        // Categoria de FAQ
        $elements_manager->add_category(
            'pda-faq',
            [
                'title' => __('FAQ PDA', 'elementor-widgets-pda'),
                'icon' => 'fa fa-question-circle',
            ]
        );
    }

    /**
     * Register all widgets
     */
    public function register_widgets($widgets_manager) {
        // Include widget files
        $widget_files = glob(ELEMENTOR_WIDGETS_PDA_PLUGIN_DIR . 'widgets/*.php');
        
        foreach ($widget_files as $widget_file) {
            require_once $widget_file;
        }

        // Get all widget classes and register them
        // Widgets should be named like: class-widget-example.php -> Elementor_Widgets_PDA_Example
        foreach ($widget_files as $widget_file) {
            $file_name = basename($widget_file, '.php');
            
            // Convert file name to class name
            // class-widget-example -> Elementor_Widgets_PDA_Example
            $class_name = str_replace('class-widget-', '', $file_name);
            $class_name = str_replace('-', '_', $class_name);
            $class_name = 'Elementor_Widgets_PDA_' . ucwords($class_name, '_');
            $class_name = str_replace('_', '', $class_name);
            $class_name = 'Elementor_Widgets_PDA_' . str_replace('Elementor_Widgets_PDA_', '', $class_name);
            
            // Alternative: widgets can define their own class name
            // Check if class exists before registering
            $possible_classes = [
                $class_name,
                str_replace('class-widget-', 'Elementor_Widgets_PDA_', str_replace('-', '_', $file_name)),
            ];
            
            foreach ($possible_classes as $class) {
                if (class_exists($class)) {
                    $widgets_manager->register(new $class());
                    break;
                }
            }
        }
    }

    /**
     * Enqueue frontend styles and scripts
     */
    public function enqueue_frontend_assets() {
        // Main CSS
        wp_enqueue_style(
            'elementor-widgets-pda-style',
            ELEMENTOR_WIDGETS_PDA_PLUGIN_URL . 'assets/css/widgets-style.css',
            [],
            ELEMENTOR_WIDGETS_PDA_VERSION
        );

        // Main JS
        wp_enqueue_script(
            'elementor-widgets-pda-script',
            ELEMENTOR_WIDGETS_PDA_PLUGIN_URL . 'assets/js/widgets-script.js',
            ['jquery'],
            ELEMENTOR_WIDGETS_PDA_VERSION,
            true
        );

        // Localize script
        wp_localize_script('elementor-widgets-pda-script', 'elementorWidgetsPDA', [
            'ajaxurl' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('elementor_widgets_pda_nonce'),
        ]);
    }

    /**
     * Enqueue editor assets
     */
    public function enqueue_editor_assets() {
        wp_enqueue_style(
            'elementor-widgets-pda-editor',
            ELEMENTOR_WIDGETS_PDA_PLUGIN_URL . 'assets/css/editor-style.css',
            [],
            ELEMENTOR_WIDGETS_PDA_VERSION
        );
    }

    /**
     * Admin notice for missing Elementor
     */
    public function admin_notice_missing_elementor() {
        if (isset($_GET['activate'])) {
            unset($_GET['activate']);
        }

        $message = sprintf(
            /* translators: 1: Plugin name 2: Elementor */
            esc_html__('"%1$s" requer que o "%2$s" esteja instalado e ativado.', 'elementor-widgets-pda'),
            '<strong>' . esc_html__('Elementor Widgets PDA', 'elementor-widgets-pda') . '</strong>',
            '<strong>' . esc_html__('Elementor', 'elementor-widgets-pda') . '</strong>'
        );

        printf('<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message);
    }

    /**
     * Admin notice for minimum Elementor version
     */
    public function admin_notice_minimum_elementor_version() {
        if (isset($_GET['activate'])) {
            unset($_GET['activate']);
        }

        $message = sprintf(
            /* translators: 1: Plugin name 2: Elementor 3: Required Elementor version */
            esc_html__('"%1$s" requer o "%2$s" versão %3$s ou superior.', 'elementor-widgets-pda'),
            '<strong>' . esc_html__('Elementor Widgets PDA', 'elementor-widgets-pda') . '</strong>',
            '<strong>' . esc_html__('Elementor', 'elementor-widgets-pda') . '</strong>',
            self::MINIMUM_ELEMENTOR_VERSION
        );

        printf('<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message);
    }

    /**
     * Admin notice for minimum PHP version
     */
    public function admin_notice_minimum_php_version() {
        if (isset($_GET['activate'])) {
            unset($_GET['activate']);
        }

        $message = sprintf(
            /* translators: 1: Plugin name 2: PHP 3: Required PHP version */
            esc_html__('"%1$s" requer o "%2$s" versão %3$s ou superior.', 'elementor-widgets-pda'),
            '<strong>' . esc_html__('Elementor Widgets PDA', 'elementor-widgets-pda') . '</strong>',
            '<strong>' . esc_html__('PHP', 'elementor-widgets-pda') . '</strong>',
            self::MINIMUM_PHP_VERSION
        );

        printf('<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message);
    }

    /**
     * Plugin activation
     */
    public function activate() {
        // Create necessary directories
        $dirs = [
            ELEMENTOR_WIDGETS_PDA_PLUGIN_DIR . 'assets/css',
            ELEMENTOR_WIDGETS_PDA_PLUGIN_DIR . 'assets/js',
            ELEMENTOR_WIDGETS_PDA_PLUGIN_DIR . 'assets/imgs',
            ELEMENTOR_WIDGETS_PDA_PLUGIN_DIR . 'widgets',
            ELEMENTOR_WIDGETS_PDA_PLUGIN_DIR . 'includes',
        ];

        foreach ($dirs as $dir) {
            if (!file_exists($dir)) {
                wp_mkdir_p($dir);
            }
        }

        // Set activation flag
        set_transient('elementor_widgets_pda_activated', true, 30);
    }

    /**
     * Plugin deactivation
     */
    public function deactivate() {
        // Clean up transients
        delete_transient('elementor_widgets_pda_github_response');
    }
}

/**
 * Initialize the plugin
 */
function elementor_widgets_pda_init() {
    return Elementor_Widgets_PDA::instance();
}

// Start the plugin
elementor_widgets_pda_init();
