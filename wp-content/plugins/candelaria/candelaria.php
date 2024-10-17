<?php

/**
 * Plugin Name: Candelaria Plugin
 * Plugin URI: https://candelaria.cl/
 * Description: Plugin Candelaria
 * Version: 1.0.0
 * Author: Jesus Marcano
 * Author URI: https://ferozdigital.cl
 * Text Domain: Candelaria
 *
 * @package Candelaria
 */


//require(plugin_dir_path(__FILE__).'inc/shipping_santiago.php');
//require(plugin_dir_path(__FILE__).'inc/shipping_other_regions.php');

add_filter( 'woocommerce_cart_no_shipping_available_html', 'change_noship_message' );
add_filter( 'woocommerce_no_shipping_available_html', 'change_noship_message' );
function change_noship_message() {
    print "Envio sera realizado cobro a destino";
}

add_action('template_redirect', 'my_custom_message');
function my_custom_message() {
	global $post,$wp_query;
    if ( $post->post_type == 'product' ) {
		$term_list = wp_get_post_terms($post->ID,'product_cat',array('fields'=>'ids'));
		$cat_id = (int)$term_list[0];
		$term = get_term_by( 'id', $cat_id, 'product_cat' );
		if($term->slug=='sale' && $wp_query->found_posts==1){
			//wc_add_notice('Los modelos del catálogo SALE que no están en stock pueden fabricarse por encargo previa confirmación de disponibilidad de materiales. Todos los pedidos que recibimos son fabricados especialmente para cada una de nuestras clientas. El tiempo de fabricación máximo es de 15 días y el envío se realiza al día siguiente de que lo tengamos listo. Si quieres encargar alguno, escríbenos a info@candelariaperez.cl','notice');
			//wc_add_notice(  'Los pedidos de modelos fuera del catálogo actual pueden fabricarse previa confirmación (dependerá de que tengamos disponibles los materiales para poder hacerlo). Todos los pedidos que recibimos son fabricados especialmente para cada clienta. El tiempo de fabricación es de 5 días hábiles y el envío se realiza al día siguiente de que lo tengamos listo. No manejamos stock, todos nuestros zapatos están en nuestros puntos de venta.' , 'notice' );
		}
		if($term->slug=='pre-order' && $wp_query->found_posts==1){
			//wc_add_notice('Venta en Verde','notice');
			//wc_add_notice(  'Los pedidos de modelos fuera del catálogo actual pueden fabricarse previa confirmación (dependerá de que tengamos disponibles los materiales para poder hacerlo). Todos los pedidos que recibimos son fabricados especialmente para cada clienta. El tiempo de fabricación es de 5 días hábiles y el envío se realiza al día siguiente de que lo tengamos listo. No manejamos stock, todos nuestros zapatos están en nuestros puntos de venta.' , 'notice' );
		}
	}
}

/*
add_action( 'woocommerce_admin_order_data_after_billing_address', 'my_custom_checkout_field_display_admin_order_meta', 10, 1 );
function my_custom_checkout_field_display_admin_order_meta($order){
    $my_custom_field = get_post_meta( $order->id, '_billing_candelaria', true );
    if ( ! empty( $my_custom_field ) ) {
        echo '<p><strong>'. __("RUT", "woocommerce").':</strong> ' . get_post_meta( $order->id, '_billing_candelaria', true ) . '</p>';
    }
}


add_filter('woocommerce_billing_fields', 'comuna_woocommerce_billing_fields');

function comuna_woocommerce_billing_fields($fields)
{

    $fields['comuna_address_field'] = array(
        'label' => __('Comuna', 'woocommerce'), // Add custom field label
        'placeholder' => _x('Comuna', 'placeholder', 'woocommerce'), // Add custom field placeholder
        'required' => true, // if field is required or not
        'clear' => false, // add clear or not
        'type' => 'text', // add field type
		'readonly' => true,
        'class' => array('my-css')    // add class name
    );

    return $fields;
}
add_filter('woocommerce_shipping_fields', 'comuna_woocommerce_shipping_fields');

function comuna_woocommerce_shipping_fields($fields)
{

    $fields['comuna_address_field'] = array(
        'label' => __('Comuna', 'woocommerce'), // Add custom field label
        'placeholder' => _x('Comuna', 'placeholder', 'woocommerce'), // Add custom field placeholder
        'required' => true, // if field is required or not
        'clear' => false, // add clear or not
        'type' => 'text', // add field type
		'readonly' => true,
        'class' => array('my-css')    // add class name
    );
    return $fields;
}


add_action('woocommerce_checkout_process', 'customise_checkout_field_process');
function customise_checkout_field_process()
{
  // if the field is set, if not then show an error message.
  if (!$_POST['comuna_address_field']) wc_add_notice(__('Por favor ingresa una comuna.') , 'error');
}


add_action('woocommerce_checkout_update_order_meta', 'customise_checkout_field_update_order_meta');
function customise_checkout_field_update_order_meta($order_id)
{
  if (!empty($_POST['comuna_address_field'])) {
    update_post_meta($order_id, 'comuna_address_field', sanitize_text_field($_POST['comuna_address_field']));
  }
}


add_action( 'woocommerce_admin_order_data_after_shipping_address','edit_woocommerce_checkout_page', 10, 1 );

function edit_woocommerce_checkout_page($order){
    global $post_id;
    $order = new WC_Order( $post_id );
    echo '<p><strong>'.__('Comuna').':</strong> ' .get_post_meta($order->get_id(),'comuna_address_field',true). '</p>';
}









function change_backorder_message_alt( $text, $product ){
    if ( $product->managing_stock() && $product->is_on_backorder( 1 ) ) {
        $text = __( 'A pedido', 'candelaria' );
    }
    return $text;
}
add_filter( 'woocommerce_get_availability_text', 'change_backorder_message_alt', 10, 2 );
*/

add_filter( 'woocommerce_billing_fields' , 'RUT_custom_override_checkout_fields' );
function RUT_custom_override_checkout_fields( $fields ) {
     $fields['billing_rut'] = array(
        'label' => __('RUT', 'woocommerce'), // Add custom field label
        'placeholder' => _x('RUT', 'placeholder', 'woocommerce'), // Add custom field placeholder
        'required' => true, // if field is required or not
        'clear' => false, // add clear or not
        'type' => 'text', // add field type
        'class' => array('my-css')    // add class name
    );

     return $fields;
}
add_action( 'woocommerce_admin_order_data_after_shipping_address', 'RUT_checkout_field_display_admin_order_meta', 10, 1 );
function RUT_checkout_field_display_admin_order_meta($order){
    echo '<p><strong>'.__('RUT').':</strong> ' . get_post_meta( $order->get_id(), '_billing_rut', true ) . '</p>';
	echo '<h1>Etiqueta de envio</h1>';
	echo '<div style="border:1px solid black;text-align:center;font-size:20px">';
	echo '<div style="text-transform:capitalize">'.$order->get_billing_first_name().' '.$order->get_billing_last_name().'</div>';
	echo '<div>RUT:'.get_post_meta( $order->get_id(), '_billing_rut', true ).'</div>';
	echo '<div style="text-transform:capitalize">'.$order->get_billing_address_1().'</div>';
	echo '<div style="text-transform:capitalize">'.$order->get_billing_address_2().'</div>';
	echo '<div style="text-transform:capitalize">'.$order->get_billing_state().'</div>';
	echo '<div style="text-transform:capitalize">'.$order->get_billing_city().'</div>';
	echo '<div>'.get_post_meta( $order->get_id(), '_billing_phone', true ).'</div>';
	echo '</div>';	
}

add_action('woocommerce_checkout_process', 'RUT_checkout_field_process');

function RUT_checkout_field_process() {
    // Check if set, if its not set add an error.
    if ( ! $_POST['billing_rut'] )
        wc_add_notice( __( 'Por favor ingresa tu RUT' ), 'error' );
}


add_filter('woocommerce_default_address_fields', 'wc_override_address_fields',9999);
function wc_override_address_fields( $fields ) {
$fields['city']['placeholder'] = 'Comuna';
$fields['city']['label'] = 'Comuna';
$fields['state']['label'] = 'Ciudad';
$fields['state']['label'] = 'Ciudad';
return $fields;
}

add_filter('woocommerce_get_country_locale', 'wpse_120741_wc_change_state_label_locale');
function wpse_120741_wc_change_state_label_locale($locale){
    $locale['CL']['state']['label'] = "Ciudad";
    return $locale;
}

add_filter( 'woocommerce_checkout_fields' , 'remove_company_name' );

function remove_company_name( $fields ) {
     unset($fields['billing']['billing_company']);
     return $fields;
}

/*

 function candelaria_other_regions_shipping_method_init() {
   if ( ! class_exists( 'Candelaria_Other_Regions_Shipping_Method' ) ) {
     class Candelaria_Other_Regions_Shipping_Method extends WC_Shipping_Method {

       public function __construct() {
         $this->id                 = 'candelaria_other_regions_shipping_method'; // Id for your shipping method. Should be uunique.
         $this->method_title       = __( 'Candelaria Otras regiones Shipping' );  // Title shown in admin
         $this->method_description = __( 'Candelaria Otras regiones Activado' ); // Description shown in admin
         $this->enabled            = "yes"; // This can be added as an setting but for this example its forced enabled
         $this->title              = "Despacho por pagar a otros destinos"; // This can be added as an setting but for this example its forced.
         $this->countries = array("CL");
         $this->init();
       }
       function init() {
         // Load the settings API
         $this->init_form_fields(); // This is part of the settings API. Override the method to add your own settings
         $this->init_settings(); // This is part of the settings API. Loads settings you previously init.
         // Save settings in admin if you have any defined
         add_action( 'woocommerce_update_options_shipping_' . $this->id, array( $this, 'process_admin_options' ) );
       }
       public function calculate_shipping( $package = array() ) {
         $cost = 0;
         $state = "";
         $rate = array(
           'id' => $this->id,
           'label' => $this->title.$state,
           'cost' => $cost,
           'calc_tax' => 'per_item'
         );
         // Register the rate
         $this->add_rate( $rate );
       }
     }
   }
 }

 add_action( 'woocommerce_shipping_init', 'candelaria_other_regions_shipping_method_init' );
 function add_candelaria_other_regions_shipping_method( $methods ) {
   $methods['candelaria_other_regions_shipping_method'] = 'Candelaria_Other_Regions_Shipping_Method';
   return $methods;
 }
 add_filter( 'woocommerce_shipping_methods', 'add_candelaria_other_regions_shipping_method' );

 function candelaria_other_regions_validate_order( $posted )   {
   if( WC()->session->get('chosen_shipping_methods')[0] == 'candelaria_other_regions_shipping_method') {
     if(false){
       $message = sprintf( __( 'Sorry, debes especificar el envio %s', 'candelaria' ), '');
       $messageType = "error";
       if( ! wc_has_notice( $message, $messageType ) ) {
         wc_add_notice( $message, $messageType );
       }
     }
   }
 }

 add_action( 'woocommerce_review_order_before_cart_contents', 'candelaria_other_regions_validate_order' , 10 );
 add_action( 'woocommerce_after_checkout_validation', 'candelaria_other_regions_validate_order' , 10 );
 
 function candelaria_other_regions_shipping_calculator_field_process() {
   $area = isset( $_POST['calc_shipping_location'] ) ? $_POST['calc_shipping_location'] : '';
   if ( $area!='' ) {
     WC()->session->set( 'shipping_location', $area );
     WC()->customer->set_shipping_postcode( $area );
   }
 }
 add_action( 'woocommerce_calculated_shipping', 'candelaria_other_regions_shipping_calculator_field_process' );
	
*/
function woocommerce_rename_coupon_message_on_checkout() {

	return 'Tienes un cupón?' . ' <a href="#" class="showcoupon">' . __( 'Click here to enter your code', 'woocommerce' ) . '</a>';
}
add_filter( 'woocommerce_checkout_coupon_message', 'woocommerce_rename_coupon_message_on_checkout' );




 ?>
