<?php
/*-------------------------------------------------------------------------*/
/*                        REGISTER CUSTOM NAVIGATION WALKER                */
/*-------------------------------------------------------------------------*/

if ( ! file_exists( get_template_directory() . '/inc/class-bootstrap-5-navwalker.php' ) ) {
    // File does not exist... return an error.
    return new WP_Error( 'class-bootstrap-5-navwalker-missing', __( 'It appears the class-bootstrap-5-navwalker.php file may be missing.', 'wp-bootstrap-navwalker' ) );
} else {
    // File exists... require it.
    require_once get_template_directory() . '/inc/class-bootstrap-5-navwalker.php';
}

/*-------------------------------------------------------------------------*/
/*                        REGISTER ADD TO CART                             */
/*-------------------------------------------------------------------------*/

// if ( ! file_exists( get_template_directory() . '/inc/wp-shopping-cart.php' ) ) {
//     // File does not exist... return an error.
//     return new WP_Error( 'wp-shopping-cart-missing', __( 'It appears the wp-shopping-cart.php file may be missing.', 'wp-shopping-cart' ) );
// } else {
//     // File exists... require it.
//     require_once get_template_directory() . '/inc/wp-shopping-cart.php';
// }

/*-------------------------------------------------------------------------*/
/*                        ENQUEUE ALL THE THINGS                           */
/*-------------------------------------------------------------------------*/

function wp_custom_styles(){
    wp_register_style('bootstrap5', get_template_directory_uri().'/assets/css/bootstrap.css', array(), '5.3.0', 'all');
    wp_enqueue_style('bootstrap5');
	wp_register_style('customcss', get_template_directory_uri().'/assets/css/custom.css', array(), '1.0.0', 'all');
    wp_enqueue_style('customcss');
}
add_action('wp_enqueue_scripts', 'wp_custom_styles');

function wp_custom_scripts(){
    wp_register_script('bootstrap-js', get_template_directory_uri(). '/assets/js/bootstrap.js', array(), '5.3.0', true);
    wp_enqueue_script('bootstrap-js');
	wp_register_script('custom-js', get_template_directory_uri(). '/assets/js/custom.js', array(), '1.0.0', true);
    wp_enqueue_script('custom-js');
}
add_action('wp_enqueue_scripts', 'wp_custom_scripts');
/*-------------------------------------------------------------------------*/
/*                        REGISTER WIDGETS AND MENUS                       */
/*-------------------------------------------------------------------------*/

function wp_custom_menus(){
    add_theme_support('menus');

    register_nav_menus(array(
        'primary' => 'Main Menu',
        'secondary' => 'Footer Menu'
    ));
}
add_action('after_setup_theme', 'wp_custom_menus');



function wp_register_sidebar(){
    add_theme_support('widgets');

    register_sidebar( array(
		'name'          => __( 'Primary Sidebar', 'theme_name' ),
		'id'            => 'sidebar-1',
        'description'   => __( 'A short description of the sidebar.' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );
	register_sidebar( array(
		'name'          => __( 'Secondary Sidebar', 'theme_name' ),
		'id'            => 'sidebar-2',
        'description'   => __( 'A short description of the sidebar.' ),
		'before_widget' => '<ul><li id="%1$s" class="widget %2$s">',
		'after_widget'  => '</li></ul>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );
}
add_action('widgets_init', 'wp_register_sidebar');

/*-------------------------------------------------------------------------*/
/*                        ADD THEME SUPPORT                                */
/*-------------------------------------------------------------------------*/
function custom_theme_setup() {
    add_theme_support( 'html5', array( 'comment-list' ) );
	
	add_theme_support('post-thumbnails');

	add_theme_support( 'title-tag' );

	add_theme_support('custom-header');

	add_theme_support('custom-background');

	add_theme_support('post-formats', array('aside', 'image', 'video'));
}
add_action( 'after_setup_theme', 'custom_theme_setup' );

/*------------------------------------------------------------------------*/
/*                        ADD WOOCOMMERCE SUPPORT                         */
/*------------------------------------------------------------------------*/
function mytheme_add_woocommerce_support() {
    add_theme_support( 'woocommerce');
}

add_action( 'after_setup_theme', 'mytheme_add_woocommerce_support' );