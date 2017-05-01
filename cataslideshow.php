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




?>

