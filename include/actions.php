<?php

add_action('admin_menu', 'woo_product_table_menu_pages'); 

/**
 * Place all the add_menu_page functions in here
 */
function woo_product_table_menu_pages(){
	$admin_page_name = 'WooCommerce Product Table';
	add_menu_page( $admin_page_name, $admin_page_name, 'manage_options', 'woo_product_table', 'woo_product_table_admin_menu' );

}

/**
 * Admin page function
 */
function woo_product_table_admin_menu(){

	$message = NULL;

	if ( !current_user_can( 'manage_options' ) )  {
	
		wp_die( __( 'You do not have sufficient permissions to access this page.' ) );	
	}

	if( isset( $_POST['publish'] ) ){

		update_option( 'woo_product_table_options', $_POST );
	}

	$options = get_option('woo_product_table_options');

	ob_start(); include dirname(__DIR__) . '/partial/admin.php'; $template = ob_get_clean();

	echo $template;
}

function woocommerce_product_table_scripts(){

	wp_enqueue_style( 'woo-product-table-style', plugin_dir_url( __DIR__ ) . 'assets/style.css', array(), false, 'all' );

	wp_register_script( 'woo-product-table-script', plugin_dir_url( __DIR__ ) . 'assets/script.js', array('jquery'), false, true );
	
	$translation_array = array(
		'checkout_url' =>  wc_get_checkout_url(),
		'admin_ajax' => admin_url( 'admin-ajax.php' )
	);
	
	wp_localize_script( 'woo-product-table-script', 'woo_product_table', $translation_array );

	wp_enqueue_script( 'woo-product-table-script' );
}

add_action( 'wp_enqueue_scripts', 'woocommerce_product_table_scripts');

function woo_product_table_func( $atts = array(), $content = '' ) {
	
	$return = '';

	$atts = shortcode_atts( array(
		'id' => 'value',
	), $atts, 'woo_product_table' );

	$manufacturers = get_categories( array(
	'hide_empty'=> 1,
	'taxonomy' => 'manufacturers'
	) );

	?>
	<!-- PRODUCT TABLE -->
	<style> <?php $options = get_option('woo_product_table_options'); echo $options ? stripslashes($options['woo_product_table_css']) : ''?> </style>
	<div class="product-table-row"> <div class="product-table-column"> 

	<?php

	global $wpdb;

	$args = array(			
		'post_status' => 'publish',
		'post_type' => array('product'),
		'posts_per_page' => -1,
		/*'tax_query' => array(
			array(
				'taxonomy' => 'product_type',
				'field'    => 'slug',
				'terms'    => 'composite',
			),
		),*/
		'orderby' => 'menu_order',
		'order'   => 'ASC'
	);

	$query = new WP_Query( $args );
	wp_reset_query();


	global $woocommerce;

	$cart_contents = $woocommerce->cart->get_cart_contents();

	$totals = $woocommerce->cart->get_totals();

	ob_start();
		include dirname(__DIR__).'/partials/table.php';
		$return .= ob_get_clean();

	ob_start();
	include dirname(__DIR__).'/partials/totals.php';
	$return .= ob_get_clean();

	return $return;
}

add_shortcode( 'woo_product_table', 'woo_product_table_func' );

function product_table_update_function(){
	
	global $woocommerce;
	
	$qty = $_POST['qty'];

	$product_id = $_POST['product_id'];

	$product_type = wp_get_post_terms( $product_id, 'product_type' );

	$data = get_post_meta( $product_id, '_bto_data', true );

	$args = array();

	foreach($data as $key => $component){

		$args[$key] = array(
			'product_id' => $component['assigned_ids'][0],
			'quantity' => $component['quantity_max']
		);

	}

	if( isset( $_POST['cart_key'] ) ){

		if( $qty == 0 ){
			$woocommerce->cart->remove_cart_item( $_POST['cart_key'] );
		} else {
			$woocommerce->cart->set_quantity( $_POST['cart_key'], $qty, true  );
		}

	} else {

		$product_id = $_POST['product_id'];

		switch ($product_type) {
			case 'composite':
				$cart_key = WC_CP()->cart->add_composite_to_cart( $product_id, $qty, $args );
				break;
			case 'simple':			
			default:
				$cart_key = $woocommerce->cart->add_to_cart( $product_id, $qty );
				break;
		}


	}

	$return = $woocommerce->cart->get_totals();

	$return['key'] = $cart_key;

	die(json_encode($return));
}

add_action('wp_ajax_product_table_update', 'product_table_update_function');
add_action('wp_ajax_nopriv_product_table_update', 'product_table_update_function');

function has_cart_item($cart_contents, $product_id){

	$cart_item = NULL;

	foreach( $cart_contents as $item){

		if( $item['product_id'] == $product_id ){

			$cart_item = $item;
			break;
		}

	}

	return $cart_item;
}