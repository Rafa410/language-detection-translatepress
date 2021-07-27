<?php

defined( 'ABSPATH' ) or die;

class LDT_Main {
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
        add_action( 'wp_body_open', array( $this, 'generate_language_switcher' ) );
    }

    public function enqueue_styles() {
        wp_enqueue_style( 'language-detection-translatepress-style', plugins_url( 'public/css/ldt-styles.css', __DIR__ ), array(), $this->get_version() );
    }

    public function enqueue_scripts() {
        wp_enqueue_script( 'language-detection-translatepress-script', plugins_url( 'public/js/ldt-scripts.js', __DIR__ ), array(), $this->get_version() );
    }

    public function get_version() {
        return $this->version;
    }

    public function generate_language_switcher() {
        ?>

        <aside id="language-switcher">
            <div class="grid-container">
                <i id="switch-icon"></i>
                <span id="switch-msg"></span>
                <svg id="switch-language" fill="#00b100" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"><path d="M0 12.116l2.053-1.897c2.401 1.162 3.924 2.045 6.622 3.969 5.073-5.757 8.426-8.678 14.657-12.555l.668 1.536c-5.139 4.484-8.902 9.479-14.321 19.198-3.343-3.936-5.574-6.446-9.679-10.251z"></path></svg>
                <svg id="close-language-switcher" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100" width="20" height="20"><path fill="#f15b6c" d="M82 25.275L74.726 18.001 50 42.727 25.276 17.996 18.003 25.268 42.727 50 18 74.727 25.274 82.001 50 57.275 74.722 82.003 81.996 74.732 57.273 50.002z"></path><path fill="#1f212b" d="M74.722,83.003L74.722,83.003c-0.265,0-0.52-0.105-0.707-0.293L50,58.689l-24.02,24.019c-0.391,0.391-1.023,0.391-1.414,0l-7.274-7.274c-0.391-0.391-0.391-1.023,0-1.414L41.313,50L17.296,25.975c-0.391-0.391-0.391-1.024,0-1.414l7.273-7.271c0.188-0.188,0.442-0.293,0.707-0.293l0,0c0.265,0,0.52,0.105,0.707,0.293L50,41.312l24.019-24.019c0.391-0.391,1.023-0.391,1.414,0l7.274,7.274c0.391,0.391,0.391,1.023,0,1.414l-24.02,24.02l24.016,24.023c0.391,0.391,0.391,1.024,0,1.414l-7.273,7.271C75.242,82.898,74.987,83.003,74.722,83.003z M50,56.275L50,56.275c0.265,0,0.52,0.105,0.707,0.293l24.015,24.021l5.859-5.857L56.566,50.709c-0.391-0.391-0.391-1.023,0-1.414l24.02-24.02l-5.86-5.86L50.707,43.434c-0.188,0.188-0.442,0.293-0.707,0.293l0,0c-0.265,0-0.52-0.105-0.707-0.293L25.276,19.411l-5.859,5.857l24.018,24.024c0.391,0.391,0.391,1.023,0,1.414L19.414,74.727l5.86,5.86l24.02-24.019C49.481,56.38,49.735,56.275,50,56.275z"></path><path fill="#1f212b" d="M74.5 75c-.128 0-.256-.049-.354-.146l-1-1c-.195-.195-.195-.512 0-.707s.512-.195.707 0l1 1c.195.195.195.512 0 .707C74.756 74.951 74.628 75 74.5 75zM71.5 72c-.128 0-.256-.049-.354-.146l-2-2c-.195-.195-.195-.512 0-.707s.512-.195.707 0l2 2c.195.195.195.512 0 .707C71.756 71.951 71.628 72 71.5 72zM67.5 68c-.128 0-.256-.049-.354-.146l-17.5-17.5c-.195-.195-.195-.512 0-.707l21.5-21.5c.195-.195.512-.195.707 0s.195.512 0 .707L50.707 50l17.146 17.146c.195.195.195.512 0 .707C67.756 67.951 67.628 68 67.5 68zM73.5 27c-.128 0-.256-.049-.354-.146-.195-.195-.195-.512 0-.707l1-1c.195-.195.512-.195.707 0s.195.512 0 .707l-1 1C73.756 26.951 73.628 27 73.5 27zM26.5 27c-.128 0-.256-.049-.354-.146l-1-1c-.195-.195-.195-.512 0-.707s.512-.195.707 0l1 1c.195.195.195.512 0 .707C26.756 26.951 26.628 27 26.5 27zM30.5 31c-.128 0-.256-.049-.354-.146l-2-2c-.195-.195-.195-.512 0-.707s.512-.195.707 0l2 2c.195.195.195.512 0 .707C30.756 30.951 30.628 31 30.5 31z"></path><path fill="#1f212b" d="M28.5 72c-.128 0-.256-.049-.354-.146-.195-.195-.195-.512 0-.707L49.293 50 32.146 32.854c-.195-.195-.195-.512 0-.707s.512-.195.707 0l17.5 17.5c.195.195.195.512 0 .707l-21.5 21.5C28.756 71.951 28.628 72 28.5 72zM25.5 75c-.128 0-.256-.049-.354-.146-.195-.195-.195-.512 0-.707l1-1c.195-.195.512-.195.707 0s.195.512 0 .707l-1 1C25.756 74.951 25.628 75 25.5 75z"></path></svg>
            </div>
        </aside>

        <?php
    }
}
