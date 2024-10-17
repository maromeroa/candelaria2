<?php

require(get_template_directory().'/inc/candelaria/nav/class-nav-walker.php');
require(get_template_directory().'/inc/candelaria/taxonomy/slider.php');



add_action( 'customize_register', 'cd_customizer_settings' );
function cd_customizer_settings( $wp_customize ) {
  $wp_customize->add_section( 'cd_colors' , array(
      'title'      => 'Candelaria',
      'priority'   => 30,
  ) );
  $wp_customize->add_setting( 'background_color' , array(
      'default'     => '#43C6E4',
      'transport'   => 'refresh',
  ) );
  $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'background_color', array(
  	'label'        => 'Slider',
  	'section'    => 'cd_colors',
  	'settings'   => 'background_color',
  ) ) );


  $wp_customize->get_setting( 'blogname' )->transport = 'postMessage';
  $wp_customize->get_setting( 'blogdescription' )->transport = 'postMessage';
}

add_action( 'wp_head', 'cd_customizer_css');
function cd_customizer_css()
{
    ?>
         <style type="text/css">
             body { background: #<?php echo get_theme_mod('background_color', '#43C6E4'); ?>; }
         </style>
    <?php
}

add_action( 'customize_preview_init', 'cd_customizer' );
function cd_customizer() {
	wp_enqueue_script(
		  'cd_customizer',
		  get_template_directory_uri() . '/assets/js/candelaria/customizer.js',
		  array( 'jquery','customize-preview' ),
		  '',
		  true
	);
}



add_action( 'after_setup_theme', 'register_candelaria_menu' );
function register_candelaria_menu() {
  register_nav_menus( array(
  	'footer' => __( 'Footer Menu', 'candelaria-storefront' ),
  ) );
}




function candelaria_customize_homepage()
{
    remove_action('homepage','storefront_homepage_content', 10);
    remove_action('homepage','storefront_product_categories', 20);
    remove_action('homepage','storefront_recent_products', 30);
    remove_action('homepage','storefront_featured_products', 40);
    remove_action('homepage','storefront_popular_products', 50);
    remove_action('homepage','storefront_on_sale_products', 60);
    remove_action('homepage','storefront_best_selling_products', 70);
    add_action('homepage','candelaria_homepage_header',0);


    remove_action('storefront_page','storefront_page_header', 10);
    remove_action('storefront_page','storefront_page_content', 20);
    add_action('storefront_page','candelaria_page',20);

    remove_action('storefront_before_content','storefront_header_widget_region', 10);
    remove_action('storefront_before_content','woocommerce_breadcrumb', 10);
    add_action('storefront_before_content','candelaria_header_page',10);


    remove_action('woocommerce_after_single_product_summary','woocommerce_output_product_data_tabs',10);
    remove_action('woocommerce_after_single_product_summary','woocommerce_upsell_display',15);
    remove_action('woocommerce_after_single_product_summary','woocommerce_output_related_products',20);




    //remove_action('woocommerce_single_product_summary','woocommerce_template_single_title',5);
    remove_action('woocommerce_single_product_summary','woocommerce_template_single_rating',10);
    //remove_action('woocommerce_single_product_summary','woocommerce_template_single_price',10);
    remove_action('woocommerce_single_product_summary','woocommerce_template_single_excerpt',20);
    //remove_action('woocommerce_single_product_summary','woocommerce_template_single_add_to_cart',30);
    remove_action('woocommerce_single_product_summary','woocommerce_template_single_meta',40);
    remove_action('woocommerce_single_product_summary','woocommerce_template_single_sharing',50);


    remove_action('woocommerce_before_single_product_summary','woocommerce_show_product_sale_flash',10);
    //remove_action('woocommerce_before_single_product_summary','woocommerce_show_product_images',20);

}
add_action('template_redirect','candelaria_customize_homepage');


function candelaria_header_page(){

}

function candelaria_page(){
  global $post;
  the_content();
}

function candelaria_homepage_header(){
  while(have_posts()){
    the_post();
    the_content();
  }
}

add_action( 'get_header', 'remove_storefront_sidebar' );
function remove_storefront_sidebar() {
	if ( true ) {
		remove_action( 'storefront_sidebar', 'storefront_get_sidebar', 10 );
	}
}

function candelaria_customize_header()
{
    remove_action('storefront_header','storefront_header_container', 0);
    remove_action('storefront_header', 'storefront_skip_links', 5);
    remove_action('storefront_header', 'storefront_social_icons', 10);
    remove_action('storefront_header', 'storefront_site_branding', 20);
    remove_action('storefront_header', 'storefront_secondary_navigation', 30);
    remove_action('storefront_header', 'storefront_product_search', 40);
    remove_action('storefront_header', 'storefront_header_container_close', 41);
    remove_action('storefront_header', 'storefront_primary_navigation_wrapper', 42);
    remove_action('storefront_header', 'storefront_primary_navigation', 50);
    remove_action('storefront_header', 'storefront_header_cart', 60);
    remove_action('storefront_header', 'storefront_primary_navigation_wrapper_close', 68);
    add_action('storefront_header','candelaria_header',0);

}
add_action('template_redirect','candelaria_customize_header');

function candelaria_customize_footer()
{
    remove_action('storefront_footer','storefront_footer_widgets', 10);
    remove_action('storefront_footer', 'storefront_credit', 20);
    add_action('storefront_footer','candelaria_footer', 10);
}
add_action('template_redirect','candelaria_customize_footer');

function candelaria_footer(){
  ?>
  <?php
  wp_nav_menu( array(
    'theme_location'  => 'footer',
    'container'       => 'div',
    'container_class' => '',
    'container_id'    => 'container-footer-menu',
    'menu_class'      => 'footer-menu',
    'menu_id'         => 'footer-menu',
    'echo'            => true,
    'depth'           => 0,
    'fallback_cb'     => 'WP_Candelaria_Navwalker::fallback',
     'walker'          => new WP_Candelaria_Navwalker(),
  ) );
  ?>
  <?php
}


function candelaria_header(){
  $cart_url = wc_get_cart_url();
  ?>

    <div class="container-fluid header-mobile-version">
      <div class="row">
        <div class="col-2">
          <a href="#" id="submenu-mobile-version"><img width=24 style="margin-top:5px;" src="<?php echo get_template_directory_uri().'/assets/images/candelaria/icons/menu.svg';?>" alt=""></a>
        </div>
        <div class="col-8">
          <a href="<?php echo home_url()?>" style="display:block;text-align:center;">
            <?php
            $custom_logo_id = get_theme_mod( 'custom_logo' );
            $custom_logo_url = wp_get_attachment_image_url( $custom_logo_id , 'full' );
            echo '<img style="display:block;margin:5px auto;" width=200 src="' . esc_url( $custom_logo_url ) . '" alt="">';
            ?>
          </a>
        </div>
        <div class="col-2">
          <?php storefront_header_cart();?>
        </div>
      </div>
      <div class="row">
        <div class="col-12">
          <div class="mobile-version-sidemenu" id="mobile-version-sidemenu" show="false">
            <?php
            wp_nav_menu( array(
            	'theme_location'  => 'primary',
              'container'       => 'div',
              'container_class' => '',
              'container_id'    => 'container-header-menu',
              'menu_class'      => 'header-menu',
              'menu_id'         => 'header-menu',
              'echo'            => true,
              'fallback_cb'     => 'wp_page_menu',
              'depth'           => 0,
            ) );
            ?>
          </div>
        </div>
      </div>
        <?php get_product_search_form() ?>
    </div>
    <div class="container-fluid header-desktop-version" id="header-main">
      <div class="row">
          <div class="col-4"><?php get_product_search_form() ?></div>
        <div class="header-logo col-4" style="text-align:center;">
          <a href="<?php echo home_url()?>" style="display:block;text-align:center;">
            <?php
            $custom_logo_id = get_theme_mod( 'custom_logo' );
            $custom_logo_url = wp_get_attachment_image_url( $custom_logo_id , 'full' );
            echo '<img style="display:block;margin:0 auto;" width=300 height=32 src="' . esc_url( $custom_logo_url ) . '" alt="">';
            ?>
          </a>
        </div>
        <div class="col-4 storefront-primary-navigation">
        <?php storefront_header_cart();?>
          <ul class="header-buttons">
            <li><a href="<?php echo home_url( '/contacto/' );?>"><img src="<?php echo get_template_directory_uri().'/assets/images/candelaria/icons/email.png';?>" alt=""></a></li>
            <li><a target="_blank" href="https://www.instagram.com/candelariaperezcuero/"><img src="<?php echo get_template_directory_uri().'/assets/images/candelaria/icons/instagram.png';?>" alt=""></a></li>
          </ul>
        </div>
        <div class="col-md-12">
          <?php
          wp_nav_menu( array(
          	'theme_location'  => 'primary',
            'container'       => 'div',
            'container_class' => '',
            'container_id'    => 'container-header-menu',
            'menu_class'      => 'header-menu',
            'menu_id'         => 'header-menu',
            'echo'            => true,
            'fallback_cb'     => 'wp_page_menu',
            'depth'           => 0,
          ) );
          ?>
        </div>
      </div>
    </div>
  <?php
}

add_filter('add_to_cart_fragments', 'woocommerce_header_add_to_cart_fragment');

function woocommerce_header_add_to_cart_fragment( $fragments ) {
    global $woocommerce;
    ob_start();
    ?>
    <a class="cart-candelaria" href="<?php echo esc_url( wc_get_cart_url() ); ?>" title="<?php esc_attr_e( 'View your shopping cart', 'storefront' ); ?>">
      <img src="<?php echo get_template_directory_uri().'/assets/images/candelaria/icons/cart.png';?>"><span class="count"><?php echo wp_kses_data( sprintf( _n( '%d', '%d', WC()->cart->get_cart_contents_count(), 'storefront' ), WC()->cart->get_cart_contents_count() ) ); ?></span>
    </a>
    <?php
    $fragments['a.cart-candelaria'] = ob_get_clean();
    return $fragments;

}

add_action( 'widgets_init', 'theme_slug_widgets_init' );
function theme_slug_widgets_init() {
    /*register_sidebar( array(
        'name' => __( 'Header right sidebar', 'candelaria-storefront' ),
        'id' => 'header-right-sidebar',
        'description' => __( 'Widgets in this area will be shown on all posts and pages.', 'candelaria-storefront' ),
        'before_widget' => '<div id="right-sidebar-header">',
      	'after_widget'  => '</div>'
    ) );*/
}


function wpdocs_theme_name_scripts() {
  wp_enqueue_style( 'style-candelaria-bootstrap', get_template_directory_uri().'/assets/css/candelaria/bootstrap/bootstrap.min.css' );
  wp_enqueue_style( 'style-candelaria-theme', get_template_directory_uri().'/assets/css/candelaria/candelaria.css' );
  wp_enqueue_style( 'style-candelaria-slider', get_template_directory_uri().'/assets/css/candelaria/candelaria.slider.css' );
  wp_enqueue_script( 'script-candelaria-slider', get_template_directory_uri().'/assets/js/candelaria/candelaria.slider.js', array('jquery'), '1.0.0', true );
  wp_enqueue_script( 'script-candelaria', get_template_directory_uri().'/assets/js/candelaria/candelaria.js', array('jquery'), '1.0.0', true );
  //wp_enqueue_script( 'script-candelaria', get_template_directory_uri() . '/js/example.js', array(), '1.0.0', true );
}
add_action( 'wp_enqueue_scripts', 'wpdocs_theme_name_scripts' );



function candelaria_slider( $atts ){
  $html = '<div class="slideshow-container">';
  $args = array(
      'post_type' => 'slider',
      'post_status' => 'publish',
      'orderby' => 'rand',
      'posts_per_page' => -1,

  );
  $slides = new WP_Query( $args );
  foreach($slides->posts as $slide){
    $image_background = wp_get_attachment_image_url(get_post_meta( $slide->ID, 'slider_box_background',  true ),'full',false);
    $url = get_post_meta( $slide->ID, 'slider_box_url',  true );
    $html.='
    <div class="mySlides">
      <a href="'.$url.'"><div class="slide" style="background-image:url('.$image_background.');"></div></a>
    </div>';
  }
  $html.='</div>';
	return $html;
}
function candelaria_season( $atts ){
    $html = "<div class='container-fluid'><div class='row justify-content-center'><div class='col-md-12'><div class='row'>";
    $taxonomy     = 'product_cat';
    $orderby      = 'id';
    $show_count   = 0;      // 1 for yes, 0 for no
    $pad_counts   = 0;      // 1 for yes, 0 for no
    $hierarchical = 1;      // 1 for yes, 0 for no
    $title        = '';
    $empty        = 0;

    $args = array(
           'taxonomy'     => $taxonomy,
           'orderby'      => $orderby,
           'order'   => 'DESC',
           'show_count'   => $show_count,
           'pad_counts'   => $pad_counts,
           'hierarchical' => $hierarchical,
           'title_li'     => $title,
           'hide_empty'   => $empty
    );
   $all_categories = get_categories( $args );
   $exclude_cats = array('sin-categoria', 'sale', 'accesorios', 'shop', 'pre-order', 'babuchas', 'elige-tu-color', 'gift-card', 'venta-en-verde', 'roberta', 'lucia', 'teodora', 'jacinta', 'mary-jane-perez', 'manuela', 'bruna', 'ines');
   foreach ($all_categories as $cat) {
      if($cat->category_parent == 0) {
          $category_id = $cat->term_id;
          if(!in_array($cat->slug, $exclude_cats) ){
            $thumbnail_id = get_woocommerce_term_meta( $cat->term_id, 'thumbnail_id', true );
            $image = wp_get_attachment_url( $thumbnail_id );
            $html.="<div class='col-md-4' style='padding:0px;margin:0px;'>";
            $html.= '<a class="season-shorcut" href="'. get_permalink( get_page_by_path( $cat->slug ) ) .'">';
            $html.= "<div style=\"background-image:url('".$image."');\">";
            //$html.= '<img src="'.$image.'" class="image-fluid">';
            $html.="<span class='candelaria-season-span'>".$cat->name."</span>";
            $html.='</div>';
            $html.='</a>';
            $html.='</div>';
          }

          $args2 = array(
                  'taxonomy'     => $taxonomy,
                  'child_of'     => 0,
                  'parent'       => $category_id,
                  'orderby'      => $orderby,
                  'show_count'   => $show_count,
                  'pad_counts'   => $pad_counts,
                  'hierarchical' => $hierarchical,
                  'title_li'     => $title,
                  'hide_empty'   => $empty
          );
          $sub_cats = get_categories( $args2 );
          if($sub_cats) {
              foreach($sub_cats as $sub_category) {
                  //echo  $sub_category->name ;
              }
          }
      }
  }
  $html.='</div></div></div></div>';
	return $html;
}
add_shortcode( 'candelaria-slider', 'candelaria_slider' );
add_shortcode( 'candelaria-season', 'candelaria_season' );


add_filter('woocommerce_sale_flash', 'woocommerce_custom_sale_text', 10, 3);
function woocommerce_custom_sale_text($text, $post, $_product)
{
    return '<span class="onsale">SALE <br> _</span>';
}


add_action('woocommerce_single_product_summary','candelaria_add_meta_values',40,2);
function candelaria_add_meta_values(){
  global $product;
  ?>
  <table class="table" style="max-width:400px;">
  <tbody>
    <?php if(get_post_meta(get_the_ID(), 'capellada', true  )!=''):?>
    <tr>
      <td style="background:black;color:white;">Capellada</td>
      <td><?php echo get_post_meta(get_the_ID(), 'capellada', true  );?></td>
    </tr>
    <?php endif;?>
    <?php if(get_post_meta(get_the_ID(), 'forro', true  )!=''):?>
    <tr>
      <td style="background:black;color:white;">Forro</td>
      <td><?php echo get_post_meta(get_the_ID(), 'forro', true  );?></td>
    </tr>
    <?php endif;?>
    <?php if(get_post_meta(get_the_ID(), 'taco', true  )!=''):?>
    <tr>
      <td style="background:black;color:white;">Taco</td>
      <td><?php echo get_post_meta(get_the_ID(), 'taco', true  );?></td>
    </tr>
    <?php endif;?>
    <?php if(get_post_meta(get_the_ID(), 'suela', true  )!=''):?>
    <tr>
      <td style="background:black;color:white;">Suela</td>
      <td><?php echo get_post_meta(get_the_ID(), 'suela', true  );?></td>
    </tr>
    <?php endif;?>
	<?php if(get_post_meta(get_the_ID(), 'planta', true  )!=''):?>
    <tr>
      <td style="background:black;color:white;">Planta</td>
      <td><?php echo get_post_meta(get_the_ID(), 'planta', true  );?></td>
    </tr>
    <?php endif;?>
	  <?php if(get_post_meta(get_the_ID(), 'material', true  )!=''):?>
    <tr>
      <td style="background:black;color:white;">Material</td>
      <td><?php echo get_post_meta(get_the_ID(), 'material', true  );?></td>
    </tr>
    <?php endif;?>
	  <?php if(get_post_meta(get_the_ID(), 'largo', true  )!=''):?>
    <tr>
      <td style="background:black;color:white;">Largo</td>
      <td><?php echo get_post_meta(get_the_ID(), 'largo', true  );?></td>
    </tr>
    <?php endif;?>
  </tbody>
</table>
  <?php
}

function change_backorder_message( $text, $product ){
	$text = __( 'Disponible', 'candelaria' );
    if ( $product->managing_stock() ) {
        //$text = __( 'Disponible para encargo', 'candelaria' );
    }
   /* $cats = get_the_terms($product->ID, 'product_cat');
    $shop_cat = false;
    foreach($cats as $cat) {
      if($cat->term_id == 64) {
        $shop_cat = true;
        break;
      }
    }*/
if ( $product->is_on_backorder( 1 ) /*&& !$shop_cat*/) {
  $text = '';
        $text = __( 'Disponible para encargo, Antes de hacer tu compra por favor confirma el tiempo de fabricacion a nuestro correo <a href="mailto:info@candelariaperez.cl">info@candelariaperez.cl</a>', 'candelaria' );
    } elseif($product->is_on_backorder(1) && $shop_cat) {
      //$text = '<p class="delivery-time">entrega a partir de la segunda semana de septiembre</p>';
    }
    return $text;

}
add_filter( 'woocommerce_get_availability_text', 'change_backorder_message', 10, 2 );


add_action('woocommerce_single_product_summary', 'production_time_msg', 25);

function production_time_msg(){
  global $product;
  $cats = get_the_terms($product->ID, 'product_cat');
  foreach($cats as $cat) {
    if($cat->term_id == 132) {
      echo '<p><strong>Tus botas estarán listas en 10 días más!</strong></p>';
      break;
    }
  }

}

add_action('woocommerce_single_product_summary', 'candelaria_product_content', 20);

function candelaria_product_content(){
  echo '<p class="delivery-time">' . get_the_content() . '</p>';
}