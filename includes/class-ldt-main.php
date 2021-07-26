<?php

defined( 'ABSPATH' ) or die;

class LDT_Main {
    private $language_detector;
    protected $version;

    public function __construct() {
        $this->version = LDT_VERSION;
        $this->load_dependencies();
        $this->set_locale();

        if ( !is_admin() ) {
            $this->add_public_hooks();
        }
    }

    private function load_dependencies() {
        require_once LDT_DIR . 'includes/class-language-detector.php';
        $this->language_detector = new Language_Detector();
    }

    private function set_locale() {
        add_action( 'init', array( $this, 'load_textdomain' ) );
    }

    public function load_textdomain() {
        load_plugin_textdomain( 'language-detection-translatepress', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' ); 
    }

    private function add_public_hooks() {
        add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_styles' ) );
        add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
        add_action( 'init', array( $this->language_detector, 'detect_language' ) );
        add_action( 'wp_body_open', array( $this->language_detector, 'generate_language_switcher' ) );
    }

    public function enqueue_styles() {
        wp_enqueue_style( 'language-detection-translatepress-style', plugins_url( 'public/css/ldt-styles.css', __DIR__ ), array(), $this->get_version() );
    }

    public function enqueue_scripts() {
        wp_enqueue_script( 'language-detection-translatepress-script', plugins_url( 'public/js/ldt-scripts.js', __DIR__ ), array(), $this->get_version(), true );
    }

    public function get_version() {
        return $this->version;
    }
}
