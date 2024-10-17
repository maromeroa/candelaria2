<?php


if ( ! defined( 'WPINC' ) ) {
    die;
}
/**
* Check if WooCommerce is active
*/
if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
 function candelaria_other_regions_shipping_method_init() {
   if ( ! class_exists( 'Candelaria_Other_Regions_Shipping_Method' ) ) {
     class Candelaria_Other_Regions_Shipping_Method extends WC_Shipping_Method {
       /**
        * Constructor for your shipping class
        *
        * @access public
        * @return void
        */
       public function __construct() {
         $this->id                 = 'candelaria_other_regions_shipping_method'; // Id for your shipping method. Should be uunique.
         $this->method_title       = __( 'Candelaria Otras regiones Shipping' );  // Title shown in admin
         $this->method_description = __( 'Candelaria Otras regiones Activado' ); // Description shown in admin
         $this->enabled            = "yes"; // This can be added as an setting but for this example its forced enabled
         $this->title              = "Despacho por pagar a otros destinos"; // This can be added as an setting but for this example its forced.
         $this->countries = array("CL");
         $this->init();
       }
       /**
        * Init your settings
        *
        * @access public
        * @return void
        */
       function init() {
         // Load the settings API
         $this->init_form_fields(); // This is part of the settings API. Override the method to add your own settings
         $this->init_settings(); // This is part of the settings API. Loads settings you previously init.
         // Save settings in admin if you have any defined
         add_action( 'woocommerce_update_options_shipping_' . $this->id, array( $this, 'process_admin_options' ) );
       }
       /**
        * calculate_shipping function.
        *
        * @access public
        * @param mixed $package
        * @return void
        */
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
 /**
  * Save the custom field at shipping calculator.
  */
 function candelaria_other_regions_shipping_calculator_field_process() {
   $area = isset( $_POST['calc_shipping_location'] ) ? $_POST['calc_shipping_location'] : '';
   if ( $area!='' ) {
     WC()->session->set( 'shipping_location', $area );
     WC()->customer->set_shipping_postcode( $area );
   }
 }
 add_action( 'woocommerce_calculated_shipping', 'candelaria_other_regions_shipping_calculator_field_process' );
	
	
	
	
	
	
	
	

	
	
	
 function candelaria_free_shipping_method_category_init() {
   if ( ! class_exists( 'Candelaria_Free_Shipping_Category_Method' ) ) {
     class Candelaria_Free_Shipping_Category_Method extends WC_Shipping_Method {
       /**
        * Constructor for your shipping class
        *
        * @access public
        * @return void
        */
       public function __construct() {
         $this->id                 = 'candelaria_free_shipping_category_method'; // Id for your shipping method. Should be uunique.
         $this->method_title       = __( 'Candelaria Free Shipping' );  // Title shown in admin
         $this->method_description = __( 'Candelaria Free Activado' ); // Description shown in admin
         $this->enabled            = "yes"; // This can be added as an setting but for this example its forced enabled
         $this->title              = "Envio Gratis"; // This can be added as an setting but for this example its forced.
         $this->countries = array("CL");
         $this->init();
       }
       /**
        * Init your settings
        *
        * @access public
        * @return void
        */
       function init() {
         // Load the settings API
         $this->init_form_fields(); // This is part of the settings API. Override the method to add your own settings
         $this->init_settings(); // This is part of the settings API. Loads settings you previously init.
         // Save settings in admin if you have any defined
         add_action( 'woocommerce_update_options_shipping_' . $this->id, array( $this, 'process_admin_options' ) );
       }
       /**
        * calculate_shipping function.
        *
        * @access public
        * @param mixed $package
        * @return void
        */
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
// add_action( 'woocommerce_shipping_init', 'candelaria_free_shipping_method_category_init' );
 function add_candelaria_free_shipping_category_method( $methods ) {
   $methods['add_candelaria_free_shipping_category_method'] = 'Candelaria_Free_Shipping_Category_Method';
   return $methods;
 }
// add_filter( 'woocommerce_shipping_methods', 'add_candelaria_free_shipping_category_method' );
	
function candelaria_free_shipping_for_category( $rates, $package ) {
	$cat_ids = array( 63 );
	$enabled = false;
   foreach ( WC()->cart->get_cart_contents() as $key=>$cart_item ) {
	   $the_product = wc_get_product( $cart_item['product_id'] );
		$array_cat = $the_product->get_category_ids();
	if ( in_array(64,$array_cat) ) {
       $enabled = true;
		break;
    }
   }
   $free = array();
	foreach ( $rates as $rate_id => $rate ) {
		if ( 'candelaria_free_shipping_category_method' === $rate->method_id) {
			$free[ $rate_id ] = $rate;
			break;
		}
	}
	if(!$enabled){
		unset($rates['candelaria_free_shipping_category_method']);
	}	
	return $enabled ? $free : $rates;
   return $rates;
}
//	add_filter( 'woocommerce_package_rates', 'candelaria_free_shipping_for_category', 10, 2 );

}


function candelaria_other_regions_calculate_form(){
 // Ensure to get the correct value here. This __get( 'shipping_area' ) is based on how the Advanced Checkout Fields plugin would work
 $current_area=0;
 if(WC()->session->get( 'shipping_location' )!==null){
   $current_area = WC()->session->get( 'shipping_location' );
 }

 ?>
   <p class="form-row form-row-wide" id="calc_shipping_location_field">
     <br>
     <select name="calc_shipping_location" id="calc_shipping_location" rel="calc_shipping_location">
       <option value=""  <?php selected( $current_area, '' ); ?>>Selecciona una region</option>
       <option value="1" <?php selected( $current_area, 1 ); ?>>Santiago</option>
       <option value="0" <?php selected( $current_area, 0 ); ?>>Otras regiones</option>
     </select>
     <span><i>Santiago NO INCLUYE CHICUREO/CHAMICERO/COLINA</i></span>
   </p>
   <?php
}

add_action('woocommerce_candelaria_other_regions_form','candelaria_other_regions_calculate_form');


add_filter( 'woocommerce_order_button_html', 'replace_order_button_html', 10, 2 );


add_action('woocommerce_thankyou', 'candelaria_other_regions_request', 10, 1);
function candelaria_other_regions_request( $order_id ) {
 if(WC()->session->get('chosen_shipping_methods')[0]=='candelaria_other_regions_shipping_method'){

 }
}


function candelaria_other_regions_locate_template( $template, $template_name, $template_path ) {
$basename = basename( $template );
if( $basename == 'cart-shipping.php' ) {
  $template = trailingslashit( plugin_dir_path( __FILE__ ) ) . 'woocommerce/cart/cart-shipping.php';
}
if( $basename == 'shipping-calculator.php' ) {
  $template = trailingslashit( plugin_dir_path( __FILE__ ) ) . 'woocommerce/cart/shipping-calculator.php';
}
if( $basename == 'cart.php' ) {
  //$template = trailingslashit( plugin_dir_path( __FILE__ ) ) . 'woocommerce/cart/cart.php';
}
if( $basename == 'product-image.php' ) {
  $template = trailingslashit( plugin_dir_path( __FILE__ ) ) . 'woocommerce/single-product/product-image.php';
}
return $template;
}
add_filter( 'woocommerce_locate_template', 'candelaria_other_regions_locate_template', 10, 3 );


add_filter( 'woocommerce_shipping_calculator_enable_candelaria', 'enable_fields' );

add_filter( 'woocommerce_shipping_calculator_enable_state', 'disable_fields' );
add_filter( 'woocommerce_shipping_calculator_enable_city', 'disable_fields' );
add_filter( 'woocommerce_shipping_calculator_enable_postcode', 'disable_fields' );
//add_filter( 'woocommerce_shipping_calculator_enable_country', 'disable_fields' );


// Hook in
add_filter( 'woocommerce_checkout_fields' , 'candelaria_other_regions_override_checkout_fields' );

// Our hooked in function - $fields is passed via the filter!
function candelaria_other_regions_override_checkout_fields( $fields ) {
    unset($fields['billing']['billing_city']);
    unset($fields['billing']['billing_state']);
    unset($fields['billing']['billing_postcode']);
    //unset($fields['billing']['billing_company']);
    return $fields;
}

add_action( 'woocommerce_after_checkout_billing_form', 'candelaria_other_regions_checkout_field' );

function candelaria_other_regions_checkout_field( ) {
 $checkout = WC()->checkout;

 if(WC()->session->get('chosen_shipping_methods')[0]=='candelaria_other_regions_shipping_method'){
   //echo '<div id="my_custom_checkout_field"><h2>' . __('Candelaria - Comuna para el envio') . '</h2>';
   /*$candelaria = new Candelaria();
   $communes = $candelaria->communes();
   $f = [];
   foreach($communes as $commune){
     $f[$commune->id] = $commune->name;
   }
   $fields['shipping_options']=woocommerce_form_field( 'candelaria_other_regions_commune', array(
      'type' => 'select',
      'label'     => 'Comuna',
      'placeholder'   => 'Comuna',
      'required'  => true,
      'class' => array('delivery_method form-row-wide'),
      'input_class'=> array('country_select'),
      'clear'     => true,
      'options' => $f
    ), $checkout->get_value( 'candelaria_other_regions_commune' ));
    */

   //echo '</div>';
 }
}


add_filter('woocommerce_billing_fields', 'custom_woocommerce_billing_fields');



add_action( 'wp_footer', 'custom_checkout_script' );




add_action('wp_ajax_nopriv_candelaria_other_regions_update_field', 'candelaria_other_regions_update_field');
// Hook para usuarios logueados
add_action('wp_ajax_candelaria_other_regions_update_field', 'candelaria_other_regions_update_field');
// Función que procesa la llamada AJAX
function candelaria_other_regions_update_field(){
   // Check parameters
   WC()->session->set( 'shipping_location', $_POST['calc_shipping_location'] );
   WC()->customer->set_shipping_postcode( $_POST['calc_shipping_location'] );
}

add_filter('woocommerce_before_checkout_form', 'custom_message_checkout',10, 1 );
