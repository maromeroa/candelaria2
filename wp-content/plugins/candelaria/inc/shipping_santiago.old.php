<?php


if ( ! defined( 'WPINC' ) ) {
    die;
}
/**
* Check if WooCommerce is active
*/
if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
 function candelaria_santiago_shipping_method_init() {
   if ( ! class_exists( 'Candelaria_Santiago_Shipping_Method' ) ) {
     class Candelaria_Santiago_Shipping_Method extends WC_Shipping_Method {
       /**
        * Constructor for your shipping class
        *
        * @access public
        * @return void
        */
       public function __construct() {
         $this->id                 = 'candelaria_santiago_shipping_method'; // Id for your shipping method. Should be uunique.
         $this->method_title       = __( 'Candelaria Santiago Shipping' );  // Title shown in admin
         $this->method_description = __( 'Candelaria Santiago Activado' ); // Description shown in admin
         $this->enabled            = "yes"; // This can be added as an setting but for this example its forced enabled
         $this->title              = "Despacho en Santiago"; // This can be added as an setting but for this example its forced.
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
         $cart_items = $package['contents'];
         $items_array = array();
         foreach($cart_items as $item){
             $items += $item['quantity'];
         }
         /*$cost = 4000;
         switch($items){
            case '1':
              $cost = 4000;
              break;
            case '2':
             $cost = 6000;
             break;
            default:
             $cost = 8000;
         }*/
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
 add_action( 'woocommerce_shipping_init', 'candelaria_santiago_shipping_method_init' );
 function add_candelaria_santiago_shipping_method( $methods ) {
   $methods['candelaria_santiago_shipping_method'] = 'Candelaria_Santiago_Shipping_Method';
   return $methods;
 }
 add_filter( 'woocommerce_shipping_methods', 'add_candelaria_santiago_shipping_method' );

 function candelaria_santiago_validate_order( $posted )   {
   if( WC()->session->get('chosen_shipping_methods')[0] == 'candelaria_santiago_shipping_method') {
     if(false){
       $message = sprintf( __( 'Sorry, debes especificar el envio %s', 'candelaria' ), '');
       $messageType = "error";
       if( ! wc_has_notice( $message, $messageType ) ) {
         wc_add_notice( $message, $messageType );
       }
     }
   }
 }

 add_action( 'woocommerce_review_order_before_cart_contents', 'candelaria_santiago_validate_order' , 10 );
 add_action( 'woocommerce_after_checkout_validation', 'candelaria_santiago_validate_order' , 10 );
 /**
  * Save the custom field at shipping calculator.
  */
 function candelaria_santiago_shipping_calculator_field_process() {
   $area = isset( $_POST['calc_shipping_location'] ) ? $_POST['calc_shipping_location'] : '';
   if ( $area!='' ) {
     WC()->session->set( 'shipping_location', $area );
     WC()->customer->set_shipping_postcode( $area );
   }
 }
 add_action( 'woocommerce_calculated_shipping', 'candelaria_santiago_shipping_calculator_field_process' );
}


function candelaria_santiago_calculate_form(){
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

add_action('woocommerce_candelaria_santiago_form','candelaria_santiago_calculate_form');

// Utility function to disable add to cart when volume exceeds 68m3
function get_total_volume(){
   $total_volume = 0;

    // Loop through cart items and calculate total volume
   foreach( WC()->cart->get_cart() as $cart_item ){
       $product_volume = (float) get_post_meta( $cart_item['product_id'], '_item_volume', true );
       $total_volume  += $product_volume * $cart_item['quantity'];
   }
   return $total_volume;
}

// Replacing the Place order button when total volume exceed 68 m3
add_filter( 'woocommerce_order_button_html', 'replace_order_button_html', 10, 2 );
function replace_order_button_html( $order_button ) {

   if( WC()->session->get('chosen_shipping_methods')[0]!=null ) return $order_button;

   $order_button_text = __( "Select candelaria method", "woocommerce" );

   $style = ' style="color:#fff;cursor:not-allowed;background-color:#999;"';
   return '<a class="button alt"'.$style.' name="woocommerce_checkout_place_order" id="place_order" >A' . esc_html( $order_button_text ) . '</a>';
}

add_action('woocommerce_thankyou', 'candelaria_santiago_request', 10, 1);
function candelaria_santiago_request( $order_id ) {
 if(WC()->session->get('chosen_shipping_methods')[0]=='candelaria_santiago_shipping_method'){

 }
}


function candelaria_santiago_locate_template( $template, $template_name, $template_path ) {
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
add_filter( 'woocommerce_locate_template', 'candelaria_santiago_locate_template', 10, 3 );


add_filter( 'woocommerce_shipping_calculator_enable_candelaria', 'enable_fields' );

add_filter( 'woocommerce_shipping_calculator_enable_state', 'disable_fields' );
add_filter( 'woocommerce_shipping_calculator_enable_city', 'disable_fields' );
add_filter( 'woocommerce_shipping_calculator_enable_postcode', 'disable_fields' );
//add_filter( 'woocommerce_shipping_calculator_enable_country', 'disable_fields' );
function disable_fields( $true ){
 if(WC()->session->get('chosen_shipping_methods')[0]=='candelaria_santiago_shipping_method'){
   return false;
 }
 return true;
}

function enable_fields( $true ){
 if(WC()->session->get('chosen_shipping_methods')[0]=='candelaria_santiago_shipping_method'){
   return true;
 }
 return false;
}

// Hook in
add_filter( 'woocommerce_checkout_fields' , 'candelaria_santiago_override_checkout_fields' );

// Our hooked in function - $fields is passed via the filter!
function candelaria_santiago_override_checkout_fields( $fields ) {
    unset($fields['billing']['billing_city']);
    unset($fields['billing']['billing_state']);
    unset($fields['billing']['billing_postcode']);
    //unset($fields['billing']['billing_company']);
    return $fields;
}

add_action( 'woocommerce_after_checkout_billing_form', 'candelaria_santiago_checkout_field' );

function candelaria_santiago_checkout_field( ) {
 $checkout = WC()->checkout;

 if(WC()->session->get('chosen_shipping_methods')[0]=='candelaria_santiago_shipping_method'){
   //echo '<div id="my_custom_checkout_field"><h2>' . __('Candelaria - Comuna para el envio') . '</h2>';
   /*$candelaria = new Candelaria();
   $communes = $candelaria->communes();
   $f = [];
   foreach($communes as $commune){
     $f[$commune->id] = $commune->name;
   }
   $fields['shipping_options']=woocommerce_form_field( 'candelaria_santiago_commune', array(
      'type' => 'select',
      'label'     => 'Comuna',
      'placeholder'   => 'Comuna',
      'required'  => true,
      'class' => array('delivery_method form-row-wide'),
      'input_class'=> array('country_select'),
      'clear'     => true,
      'options' => $f
    ), $checkout->get_value( 'candelaria_santiago_commune' ));*/


   //echo '</div>';
 }
}


add_filter('woocommerce_billing_fields', 'custom_woocommerce_billing_fields');

function custom_woocommerce_billing_fields($fields){

   $fields['billing_candelaria'] = array(
       'label' => __('RUT', 'woocommerce'), // Add custom field label
       'placeholder' => _x('', 'placeholder', 'woocommerce'), // Add custom field placeholder
       'required' => true, // if field is required or not
       'clear' => false, // add clear or not
       'type' => 'text', // add field type
       'priority' => 1,
       'class' => array('my-css')    // add class name
   );

   return $fields;
}

add_action( 'wp_footer', 'custom_checkout_script' );
function custom_checkout_script() {
   // Only on checkout page
   if( ! is_checkout() && is_wc_endpoint_url( 'order-received' ) )
       return;
   wp_register_script( 'candelaria_santiago_ajax', plugins_url( '../assets/js/candelaria.js', __FILE__ ), array('jquery'), '1.0', true );
   wp_localize_script('candelaria_santiago_ajax', 'wp_candelaria_santiago_vars', array(
       'ajaxurl' => admin_url( 'admin-ajax.php' )
   ));
   wp_enqueue_script( 'candelaria_santiago_ajax' );
}



add_action('wp_ajax_nopriv_candelaria_santiago_update_field', 'candelaria_santiago_update_field');
// Hook para usuarios logueados
add_action('wp_ajax_candelaria_santiago_update_field', 'candelaria_santiago_update_field');
// Funci¨®n que procesa la llamada AJAX
function candelaria_santiago_update_field(){
   // Check parameters
   WC()->session->set( 'shipping_location', $_POST['calc_shipping_location'] );
   WC()->customer->set_shipping_postcode( $_POST['calc_shipping_location'] );
}

add_filter('woocommerce_before_checkout_form', 'custom_message_checkout',10, 1 );

function custom_message_checkout($wccm_autocreate_account){
 $state = false;
 foreach ( WC()->cart->get_cart() as $cart_item ){
   $product = $cart_item['data'];
   $shipclass=$product->get_shipping_class();
   if($shipclass=='retirotienda' && WC()->session->get('chosen_shipping_methods')[0]=='candelaria_santiago_shipping_method'){
     $state=true;
     break;
   }
 }
 if($state):
 ?>
 <style>
 .candelaria-items-checkout{
   list-style-type:none;
   padding:0px;
   margin:0px;
   overflow:auto;
 }
 .candelaria-items-checkout li{
   float:left;
   display:block;
   border:1px solid silver;
   margin:10px;
   padding:10px;
   border-radius:5px;
   background:#ddd;
   color:#333;
 }
 .candelaria-items-checkout li img{
   margin:0 auto;
   display:block;
 }
 </style>
 <div class="woocommerce-message" role="alert">
   Recuerda estos items tienen que ser retirados en tienda
   <ul class="candelaria-items-checkout">
     <?php foreach ( WC()->cart->get_cart() as $cart_item ):?>
       <?php $product = $cart_item['data'];
       if(!empty($product)){
         $shipclass=$product->get_shipping_class();
         if($shipclass=='retirotienda'){
         ?>
         <li>
           <?php echo $product->get_image([100,100],[],true);?>
           <br>
           <?php echo $product->get_title();?>
         </li>
         <?php
         }
       }
       ?>
     <?php endforeach;?>
   </ul>
 </div>
 <?php
 endif;
}
