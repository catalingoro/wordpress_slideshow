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
        'label' => 'CataSlideshow',
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
add_image_size('cs_widget', 180, 100, true);
add_image_size('cs_function', 940, 529, true);
add_theme_support( 'post-thumbnails' );

function cs_function($type='cs_function') {
    $args = array(
        'post_type' => 'cs_slideshow',
        'posts_per_page' => 5
    );
    $result = '<div class="slideshow-wrapper theme-default">';
    $result .= '<div id="slideshow" class="CataSlideshow">';
 
    //the loop
    $loop = new WP_Query($args);
    while ($loop->have_posts()) {
        $loop->the_post();
 
        $the_url = wp_get_attachment_slideshow_src(get_post_thumbnail_id($post->ID), $type);
        $result .='<img title="'.get_the_title().'" src="' . $the_url[0] . '" data-thumb="' . $the_url[0] . '" alt=""/>';
    }
    $result .= '</div>';
    $result .='<div id = "htmlcaption" class = "cata-html-caption">';
    $result .='<strong>This</strong> is an example of a <em>HTML</em> caption with <a href = "#">a link</a>.';
    $result .='</div>';
    $result .='</div>';
    return $result;
}


?>

