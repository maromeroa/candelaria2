<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/archive-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.4.0
 */
defined('ABSPATH') || exit;

get_header('shop');

/**
 * Hook: woocommerce_before_main_content.
 *
 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
 * @hooked woocommerce_breadcrumb - 20
 * @hooked WC_Structured_Data::generate_website_data() - 30
 */
do_action('woocommerce_before_main_content');
?>
<header class="woocommerce-products-header">
    <?php if (apply_filters('woocommerce_show_page_title', true)) : ?>
        <?php
        /*$state = false;
        $cat = get_queried_object();
        if (isset($cat->term_id)) {
            $state = $cat->slug != 'sale' && $cat->slug != 'shop' && $cat->slug != 'accesorios' && $cat->slug != 'pre-order' && $cat->slug != 'babuchas' && $cat->slug != 'elige-tu-color' && $cat->slug != 'venta-en-verde';
            $thumbnail_id = get_woocommerce_term_meta($cat->term_id, 'thumbnail_id', true);
            $image = wp_get_attachment_url($thumbnail_id);
            ?>
            <?php if ($cat != null && $cat->slug != 'sale' && $cat->slug != 'shop' && $cat->slug != 'accesorios' && $cat->slug != 'pre-order' && $cat->slug != 'babuchas' && $cat->slug != 'elige-tu-color' && $cat->slug != 'venta-en-verde'): ?>
                <div style="height:100vh;background-image:url(<?php echo $image; ?>);background-size:cover;background-position:center center;background-repeat:no-repeat">
                    <h1 class="candelaria-season-title"><?php woocommerce_page_title(); ?></h1>
                </div>
            <?php else: ?>
                                    <!--<h1><?php woocommerce_page_title(); ?> </h1>-->
            <?php endif; ?>
            <?
            }
            else{
            ?>
            <!--<h1><?php woocommerce_page_title(); ?> </h1>-->
            <?php
        }*/
        ?>
    <?php endif; ?>

    <?php
    /**
     * Hook: woocommerce_archive_description.
     *
     * @hooked woocommerce_taxonomy_archive_description - 10
     * @hooked woocommerce_product_archive_description - 10
     */
    //do_action( 'woocommerce_archive_description' );
    ?>
</header>
<?php
if (woocommerce_product_loop()) {

    /**
     * Hook: woocommerce_before_shop_loop.
     *
     * @hooked woocommerce_output_all_notices - 10
     * @hooked woocommerce_result_count - 20
     * @hooked woocommerce_catalog_ordering - 30
     */
    //do_action( 'woocommerce_before_shop_loop' );

    woocommerce_product_loop_start();
    ?>
    <div class="container<?php
    if ($state) {
        echo '-fluid';
    } else {
        echo ' container-product-shop';
    }
    ?>">
        <div class="row">
            <?php
            $i = 0;
            if ($state) {
                if (wc_get_loop_prop('total')) {
                    while (have_posts()) {
                        the_post();

                        /**
                         * Hook: woocommerce_shop_loop.
                         *
                         * @hooked WC_Structured_Data::generate_product_data() - 10
                         */
                        do_action('woocommerce_shop_loop');
                        if ($state) {
                            if ($i != 2) {
                                wc_get_template_part('content', 'product-full');
                                $j = 0;
                                $i++;
                            } else {
                                wc_get_template_part('content', 'product-half');
                                $j++;
                                if ($j == 3) {
                                    $i = 0;
                                }
                            }
                        } else {
                            wc_get_template_part('content', 'product-small');
                        }
                    }
                }
            } else {
                if (!is_search()) {
                    $term = (get_queried_object());
                    $args = array(
                        'post_type' => 'product',
                        'posts_per_page' => -1,
                        'product_cat' => $term->slug,
                        'orderby' => 'title',
                        'order' => 'ASC'
                    );
                    $loop = new WP_Query($args);
                    while ($loop->have_posts()) : $loop->the_post();
                        global $product;
                        wc_get_template_part('content', 'product-small');
                    endwhile;
                    wp_reset_query();
                } else {while ( have_posts() ) {
			the_post();

			/**
			 * Hook: woocommerce_shop_loop.
			 */
			do_action( 'woocommerce_shop_loop' );

			wc_get_template_part('content', 'product-small');
		}
                }
            }
            ?>
        </div>
        <?php
        if (isset($cat->term_id) && $cat->slug == 'pre-order') {
            ?>
             <div style="padding-top:30px;padding-bottom:30px;">
                <p>Ante situaciones excepcionales, medidas excepcionales.</p>
                <p>Nuestras Jacinta caimán negro y caimán rojo son las únicas muestras de los modelos de la nueva colección FW20 que alcanzamos a fabricar y que pudimos fotografiar.</p>
                <p>Las estamos vendiendo en verde, antes de poder fabricarlas con un descuento del 20% y con entrega 15 días post re apertura de nuestros talleres</p>

            </div>
            <?php
        }
        ?>
    </div>
    <?php
    woocommerce_product_loop_end();

    /**
     * Hook: woocommerce_after_shop_loop.
     *
     * @hooked woocommerce_pagination - 10
     */
    //do_action( 'woocommerce_after_shop_loop' );
} else {
    /**
     * Hook: woocommerce_no_products_found.
     *
     * @hooked wc_no_products_found - 10
     */
    do_action('woocommerce_no_products_found');
}

/**
 * Hook: woocommerce_after_main_content.
 *
 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
 */
do_action('woocommerce_after_main_content');

/**
 * Hook: woocommerce_sidebar.
 *
 * @hooked woocommerce_get_sidebar - 10
 */
do_action('woocommerce_sidebar');

get_footer('shop');
?>