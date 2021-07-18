<?php

defined( 'ABSPATH' ) or die;

add_action( 'wp_enqueue_scripts', 'ldt_add_scripts' );
function ldt_add_scripts() {
    wp_enqueue_script( 'language-detection-translatepress-script', plugins_url( 'public/js/scripts.js', __DIR__ ), '', '0.1' );
    wp_enqueue_style( 'language-detection-translatepress-style', plugins_url( 'public/css/styles.css', __DIR__ ), '', '0.1' );
}

add_action( 'init', 'ldt_add_shortcodes' );
function ldt_add_shortcodes() {
    add_shortcode( 'language-detection-translatepress', 'ldt_generate_shortcode' );
}

function ldt_generate_shortcode( $atts = [], $content = null) {
    $o = '';
    
    return $o;
}
