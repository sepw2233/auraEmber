<?php
/**
 * Functions and definitions
 * 
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 * 
 * @package no-code-theme
 * @since 1.0.0
 */
 function enqueue_custom_woocommerce_styles() {
    wp_enqueue_style('custom-woocommerce', get_stylesheet_directory_uri() . '/wooCommerce.css');
    wp_enqueue_style('custom-css', get_stylesheet_directory_uri() . '/custom-css.css');
}
add_action('wp_enqueue_scripts', 'enqueue_custom_woocommerce_styles');

//  Hooks
require_once get_theme_file_path('inc/hooks.php');

// Hooks
require_once get_theme_file_path('inc/woocommerce.php');