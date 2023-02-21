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
/*                        ENQUEUE ALL THE THINGS                           */
/*-------------------------------------------------------------------------*/

function wp_custom_styles(){
    wp_register_style('bootstrap_5', get_template_directory_uri().'/assets/css/bootstrap.css', array(), '5.3.0', 'all');
    wp_enqueue_style('bootstrap_5');
    wp_register_style('playfair_cdn', 'https://fonts.googleapis.com/css2?family=Playfair+Display:ital@0,400;1,700&display=swap', false, '1.0.0');
    wp_enqueue_style('playfair_cdn');
	wp_register_style('bootstrap_icons', get_template_directory_uri().'/assets/icons/bootstrap-icons.css', array(), '5.3.0', 'all');
    wp_enqueue_style('bootstrap_icons');
	wp_register_style('box_icons', get_template_directory_uri().'/assets/boxicons/css/boxicons.min.css', array(), '5.3.0', 'all');
    wp_enqueue_style('box_icons');
	wp_register_style('custom_css', get_template_directory_uri().'/assets/css/custom.css', array(), '1.0.0', 'all');
    wp_enqueue_style('custom_css');
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
if(class_exists('WooCommerce')){
function mytheme_add_woocommerce_support() {
	add_theme_support('wc-product-gallery-zoom');
  	add_theme_support('wc-product-gallery-lightbox');
  	add_theme_support('wc-product-gallery-slider');
    add_theme_support( 'woocommerce', array(
		'thumbnail_image_width'  	=>  100,
		'single_image_width'		=> 	100,
		'gallery_thumbnail_image_width' => 100,
		'product_grid'				=>	array(
			'default_rows'    => 3,
            'min_rows'        => 2,
            'max_rows'        => 5,
            'default_columns' => 4,
            'min_columns'     => 2,
            'max_columns'     => 5,
		)
	));
}

add_action( 'after_setup_theme', 'mytheme_add_woocommerce_support' );

//Remove WooCommerce Styles
// add_filter('woocommerce_enqueue_styles', '__return_false');

//Remove Shop Title
add_filter('woocommerce_show_page_title', '__return_false');


/**
 * Show cart contents / total Ajax
 */
add_filter( 'woocommerce_add_to_cart_fragments', 'woocommerce_header_add_to_cart_fragment' );

function woocommerce_header_add_to_cart_fragment( $fragments ) {
	global $woocommerce;

	ob_start();

	?>
	<a class="cart-customlocation" href="<?php echo esc_url(wc_get_cart_url()); ?>" title="<?php _e('View your shopping cart', 'woothemes'); ?>"><?php echo sprintf(_n('%d item', '%d items', $woocommerce->cart->cart_contents_count, 'woothemes'), $woocommerce->cart->cart_contents_count);?> - <?php echo $woocommerce->cart->get_cart_total(); ?></a>
	<?php
	$fragments['a.cart-customlocation'] = ob_get_clean();
	return $fragments;
}
}


/*-------------------------------------------------------------------------*/
/*                        FETCHING DATA FROM DB                            */
/*-------------------------------------------------------------------------*/
class ContactForm{
	public $table;
function __construct(){
	global $wpdb;
	$this->table = 'wp_contact';
	if($this->table==true){
	    //echo "Table Exists already";
	}else{
	    $this->create_table_contact();
	}
	$this->pass_data_to_contact();
}

function create_table_contact(){
	global $wpdb;
	$table = 'wp_contact';
	$charset_collate = $wpdb->get_charset_collate();

	$new_contact_details = "CREATE TABLE $table(
		ID bigint unsigned NOT NULL auto_increment,
		event_date timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
		name text NOT NULL,
		email varchar(35) NOT NULL,
		subject varchar(35) NOT NULL,
		message text NOT NULL,
		PRIMARY KEY (ID)
	) $charset_collate;";

	require_once(ABSPATH.'wp-admin/includes/upgrade.php');
	dbDelta($new_contact_details);
}

function pass_data_to_contact(){
	if(isset($_POST['submitcontactform'])){
		$data = array(
			'name' => $_POST['name'],
			'email'  =>  $_POST['email'],
			'subject'  =>  $_POST['subject'],
			'message'     =>  $_POST['message'],

		);
		global $wpdb;
		$table = 'wp_contact';
		$result = $wpdb->insert($table, $data, $format=NULL);
		
		if($result==true){
			echo '<script>alert("Admin Form Submitted Successfully");</script>' ;
		}else{
			echo '<script>alert("Admin Form Not Submitted");</script>' ;
		}
	}
}
}

if(class_exists('ContactForm')){
    $contactFormInstance = new ContactForm();
}
