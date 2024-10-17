<?php
function create_slider_post_type() {
  register_post_type( 'slider',
    array(
      'labels' => array(
        'name' => __( 'Slider' ),
        'singular_name' => __( 'slider' )
      ),
      'public' => true,
      'has_archive' => true,
			'menu_icon'           => 'dashicons-images-alt2',
    )
  );
}
add_action( 'init', 'create_slider_post_type' );

add_action( 'add_meta_boxes', 'slider_meta_box_add' );
function slider_meta_box_add()
{
  add_meta_box( 'slider_post_url', 'Url slider', 'slider_meta_box_url', 'slider', 'side', 'high' );
	add_meta_box( 'slider_post_background', 'Fondo', 'slider_meta_box_background', 'slider', 'side', 'high' );
}
function slider_meta_box_url( $post ){
  $values = get_post_custom( $post->ID );
  $url = isset( $values['slider_box_url'] ) ? esc_attr( $values['slider_box_url'][0] ) : "";
  ?>
  <p>
  <label for="slider_box_url">URL</label>
  <input type="text" name="slider_box_url" id="slider_box_url" value="<?php echo $url; ?>" />
  </p>
  <?php
}
function slider_meta_box_background( $post ){
	$values = get_post_custom( $post->ID );
	$text = isset( $values['slider_box_background'] ) ? esc_attr( $values['slider_box_background'][0] ) : "";
	wp_enqueue_media();
	$url='';
	$order='0';
	if ( $text != '' ) {
			$order = $text;
			$url = wp_get_attachment_image_url( $order );
	} else {
			$order = '0';
	}
	?>
	<div class="form-field term-thumbnail-wrap">
			<label>Fondo</label>
			<div id="background_slider_thumbnail" style="float: left; margin-right: 10px;">
				<?php
				if($order!='0'){
					?>
					<img src="<?php echo $url;?>" width="60px" height="60px">
					<?php
				}
				else{
					?>
					<img src="<?php echo plugins_url();?>/woocommerce/assets/images/placeholder.png" width="60px" height="60px">
					<?php
				}
				?>
			</div>
			<div style="line-height: 60px;">
				<input type="hidden" value="<?php echo $order;?>" id="background_slider_thumbnail_id" name="background_slider_thumbnail_id">
				<button type="button" class="upload_image_button button">Subir/Añadir imagen</button>
				<button type="button" class="remove_image_button button" style="display: none;">Quitar imagen</button>
			</div>
			<script type="text/javascript">

				// Only show the "remove image" button when needed
				if ( ! jQuery( '#background_slider_thumbnail_id' ).val() ) {
					jQuery( '.remove_image_button' ).hide();
				}

				// Uploading files
				var file_frame;

				jQuery( document ).on( 'click', '.upload_image_button', function( event ) {

					event.preventDefault();

					// If the media frame already exists, reopen it.
					if ( file_frame ) {
						file_frame.open();
						return;
					}

					// Create the media frame.
					file_frame = wp.media.frames.downloadable_file = wp.media({
						title: 'Elige una imagen',
						button: {
							text: 'Usar imagen'
						},
						multiple: false
					});

					// When an image is selected, run a callback.
					file_frame.on( 'select', function() {
						var attachment           = file_frame.state().get( 'selection' ).first().toJSON();
						var attachment_thumbnail = attachment.sizes.thumbnail || attachment.sizes.full;
						jQuery( '#background_slider_thumbnail_id' ).val( attachment.id );
						jQuery( '#background_slider_thumbnail' ).find( 'img' ).attr( 'src', attachment_thumbnail.url );
						jQuery( '.remove_image_button' ).show();
					});

					// Finally, open the modal.
					file_frame.open();
				});

				jQuery( document ).on( 'click', '.remove_image_button', function() {
					jQuery( '#background_slider_thumbnail' ).find( 'img' ).attr( 'src', '<?php echo plugins_url();?>/woocommerce/assets/images/placeholder.png' );
					jQuery( '#background_slider_thumbnail_id' ).val( '' );
					jQuery( '.remove_image_button' ).hide();
					return false;
				});

				jQuery( document ).ajaxComplete( function( event, request, options ) {
					if ( request && 4 === request.readyState && 200 === request.status
						&& options.data && 0 <= options.data.indexOf( 'action=add-tag' ) ) {

						var res = wpAjax.parseAjaxResponse( request.responseXML, 'ajax-response' );
						if ( ! res || res.errors ) {
							return;
						}
						// Clear Thumbnail fields on submit
						jQuery( '#background_slider_thumbnail' ).find( 'img' ).attr( 'src', '<?php echo plugins_url();?>/woocommerce/assets/images/placeholder.png' );
						jQuery( '#background_slider_thumbnail_id' ).val( '' );
						jQuery( '.remove_image_button' ).hide();
						// Clear Display type field on submit
						jQuery( '#display_type' ).val( '' );
						return;
					}
				} );

			</script>
			<div class="clear"></div>
		</div>
	    <?php
}


function slider_save_meta($post_id){
  if ( !current_user_can( 'edit_post', $post_id ))
    return;
  if ( isset($_POST['slider_box_url']) ) {
    update_post_meta($post_id, 'slider_box_url', sanitize_text_field($_POST['slider_box_url']));
  }
  if ( isset($_POST['background_slider_thumbnail_id']) ) {
    update_post_meta($post_id, 'slider_box_background', sanitize_text_field($_POST['background_slider_thumbnail_id']));
  }

}

add_action('save_post', 'slider_save_meta');
