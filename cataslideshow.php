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

add_action('widgets_init', 'cs_widgets_init');
add_action('init', 'cs_init');
add_action('wp_print_scripts', 'cs_register_scripts');
add_action('wp_print_styles', 'cs_register_styles');

add_image_size('cs_widget', 300, 169, true);
add_image_size('cs_function', 940, 529, true);
add_theme_support( 'post-thumbnails' );

function cs_widgets_init() {
    register_widget('cs_Widget');
}

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
    wp_register_style('cs_styles_style', plugins_url('standard/css/style.css', __FILE__));
    wp_register_style('cs_styles_theme', plugins_url('standard/css/example.css', __FILE__));
 
    // enqueue
    wp_enqueue_style('cs_styles');
    wp_enqueue_style('cs_styles_style');
    wp_enqueue_style('cs_styles_theme');
}


/* SHORTCODE START */

function cs_function($type='cs_function') {
    $args = array(
        'post_type' => 'cs_slideshow',
        'posts_per_page' => 5
    );

    if($type == 'cs_widget'){

        $result = '<div class="container">';
        $result .= '<div id="slides_widget">';
     
        //the loop
        $loop = new WP_Query($args);
        while ($loop->have_posts()) {
            $loop->the_post();
     
            
            $result .='<img title="'.get_the_title().'" src="'.get_the_post_thumbnail_url($post->ID, cs_widget).'" />';
        }


        $result .= '<a href="#" class="slidesjs-previous slidesjs-navigation"><i class="icon-chevron-left icon-large"></i></a>';
        $result .= '<a href="#" class="slidesjs-next slidesjs-navigation"><i class="icon-chevron-right icon-large"></i></a>';

        $result .='</div>';
        $result .='</div>';
 
    } else {
       
        $result = '<div class="container">';
        $result .= '<div id="slides_shortcode">';
     
        //the loop
        $loop = new WP_Query($args);
        while ($loop->have_posts()) {
            $loop->the_post();
     
            
            $result .='<img title="'.get_the_title().'" src="'.get_the_post_thumbnail_url($post->ID, cs_function).'" />';
        }


        $result .= '<a href="#" class="slidesjs-previous slidesjs-navigation"><i class="icon-chevron-left icon-large"></i></a>';
        $result .= '<a href="#" class="slidesjs-next slidesjs-navigation"><i class="icon-chevron-right icon-large"></i></a>';

        $result .='</div>';
        $result .='</div>';

    
    }

    return $result;
}

add_shortcode('cs-shortcode', 'cs_function');



/* WIDGET START */


class cs_Widget extends WP_Widget {

    public function __construct() {
        parent::__construct('cs_Widget', 'Cata Slideshow', array('description' => __('A Cata Slideshow Widget', 'text_domain')));
    }

    public function widget( $args, $instance ) {
        extract($args);
        // the title
        $title = apply_filters('widget_title', $instance['title']);
        echo $before_widget;
        if (!empty($title))
            echo $before_title . $title . $after_title;
        echo cs_function('cs_widget');
        echo $after_widget;
    }

    public function form( $instance ) {
        if (isset($instance['title'])) {
            $title = $instance['title'];
        }
        else {
            $title = __('Widget Slideshow', 'text_domain');
        }
        ?>
            <p>
                <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label>
                <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
            </p>
        <?php       
    }

    public function update( $new_instance, $old_instance ) {
        $instance = array();
        $instance['title'] = strip_tags($new_instance['title']);
     
        return $instance;
    }
}