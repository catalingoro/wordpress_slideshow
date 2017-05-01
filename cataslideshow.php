<?php 
/*
 * Plugin Name: Cata Slideshow
 * Plugin URI: 
 * Description: This plugin displays an Slideshow gallery.
 * Version: 0.1
 * Author: Catalin G
 * Author URI: http://
 * License: GPL v2+
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: Cata Slideshow
 * Domain Path: 
 */

function cs_init() {
    $args = array(
        'public' => true,
        'label' => 'Cata Slideshow',
        'supports' => array(
            'title',
            'thumbnail'
        )
    );
    register_post_type('cs_slideshow', $args);
}
add_action('init', 'cs_init');
add_action('wp_print_scripts', 'cs_register_scripts');
add_action('wp_print_styles', 'cs_register_styles');

function cs_register_scripts() {
    if (!is_admin()) {
        // register
        wp_register_script('cs_cata-script', plugins_url('standard/js/jquery.slides.min.js', __FILE__), array( 'jquery' ));
        wp_register_script('cs_script', plugins_url('standard/js/script.js', __FILE__));
 
        // enqueue
        wp_enqueue_script('cs_cata-script');
        wp_enqueue_script('cs_script');
    }
}
 
function cs_register_styles() {
    // register
    wp_register_style('cs_styles', plugins_url('standard/css/font-awesome.min.css', __FILE__));
    wp_register_style('cs_styles_theme', plugins_url('standard/css/example.css', __FILE__));
 
    // enqueue
    wp_enqueue_style('cs_styles');
    wp_enqueue_style('cs_styles_theme');
}


?>

