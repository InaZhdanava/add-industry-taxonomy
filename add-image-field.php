<?php
/**
 * Add image field
 */
 
function add_industry_image( $taxonomy ) {
?>
    <div class="form-field term-group">

        <label for="image_id"><?php _e( 'Image' ); ?></label>
        <input type="hidden" id="image_id" name="image_id" class="custom_media_url" value="">

        <div id="image_wrapper"></div>

        <p>
            <input type="button" class="button button-secondary taxonomy_media_button" id="taxonomy_media_button" name="taxonomy_media_button" value="<?php _e( 'Add Image' ); ?>">
            <input type="button" class="button button-secondary taxonomy_media_remove" id="taxonomy_media_remove" name="taxonomy_media_remove" value="<?php _e( 'Remove Image' ); ?>">
        </p>

    </div>
<?php
}
add_action( 'industry_add_form_fields', 'add_industry_image', 10, 2 );


/**
 * Save Image Field
 */

function save_industry_image( $term_id, $tt_id ){
    if( isset( $_POST[ 'image_id' ] ) && '' !== $_POST['image_id'] ){
        
        $image = $_POST[ 'image_id' ];
        add_term_meta( $term_id, 'image_id', $image, true );

    }
}
add_action( 'created_industry', 'save_industry_image', 10, 2 );



/**
 * Add Image Field in Edit Form
 */

function update_industry_image( $term, $taxonomy ) { ?>
    <tr class="form-field term-group-wrap">
        <th scope="row">
            <label for="image_id"><?php _e( 'Image' ); ?></label>
        </th>
        <td>

            <?php $image_id = get_term_meta( $term -> term_id, 'image_id', true ); ?>
            <input type="hidden" id="image_id" name="image_id" value="<?php echo $image_id; ?>">

            <div id="image_wrapper">
            <?php if( $image_id ) { ?>
               <?php echo wp_get_attachment_image( $image_id, 'thumbnail' ); ?>
            <?php } ?>

            </div>

            <p>
                <input type="button" class="button button-secondary taxonomy_media_button" id="taxonomy_media_button" name="taxonomy_media_button" value="<?php _e( 'Add Image' ); ?>">
                <input type="button" class="button button-secondary taxonomy_media_remove" id="taxonomy_media_remove" name="taxonomy_media_remove" value="<?php _e( 'Remove Image' ); ?>">
            </p>

        </td>
    </tr>
<?php
}
add_action( 'industry_edit_form_fields', 'update_industry_image', 10, 2 );


/**
 * Update Image Field
 */

function updated_industry_image( $term_id, $tt_id ) {
    if( isset( $_POST['image_id'] ) && '' !== $_POST['image_id'] ){
        $image = $_POST['image_id'];
        update_term_meta( $term_id, 'image_id', $image );
    } else {
        update_term_meta( $term_id, 'image_id', '' );
    }
}
add_action( 'edited_industry', 'updated_industry_image', 10, 2 );


/**
 * Display Image in Column
 */

function display_image_column_heading( $columns ) {
    $columns['industry_image'] = __( 'Image' );
    return $columns;
}
add_filter( 'manage_edit-industry_columns', 'display_image_column_heading' ); 


function display_image_column_value( $columns, $column, $id ) {
    if ( 'industry_image' == $column ) {
    	$image_id = esc_html( get_term_meta($id, 'image_id', true) );
    	
        $columns = wp_get_attachment_image( $image_id, array('50', '50') );
    }
    return $columns;
}
add_action( 'manage_industry_custom_column', 'display_image_column_value' , 10, 3); 


/**
 * Enqueue the wp_media library
 */

function custom_taxonomy_load_media() {
    if( ! isset( $_GET['taxonomy'] ) || $_GET['taxonomy'] != 'industry' ) {
       return;
    }
    wp_enqueue_media();
}
add_action( 'admin_enqueue_scripts', 'custom_taxonomy_load_media' );


/**
 * Custom script
 */

function add_custom_taxonomy_script() {
    if( ! isset( $_GET['taxonomy'] ) || $_GET['taxonomy'] != 'industry' ) {
       return;
    }
    ?>
    <script>
        jQuery(document).ready( function($) {
            function taxonomy_media_upload(button_class) {
                var custom_media = true,
                original_attachment = wp.media.editor.send.attachment;
                $('body').on('click', button_class, function(e) {
                    var button_id = '#'+$(this).attr('id');
                    var send_attachment = wp.media.editor.send.attachment;
                    var button = $(button_id);
                    custom_media = true;
                    wp.media.editor.send.attachment = function(props, attachment){
                        if ( custom_media ) {
                            $('#image_id').val(attachment.id);
                            $('#image_wrapper').html('<img class="custom_media_image" src="" style="margin:0;padding:0;max-height:100px;float:none;" />');
                            $('#image_wrapper .custom_media_image').attr('src',attachment.url).css('display','block');
                        } else {
                            return original_attachment.apply( button_id, [props, attachment] );
                        }
                    }
                    wp.media.editor.open(button);
                    return false;
                });
            }
            taxonomy_media_upload('.taxonomy_media_button.button'); 
            $('body').on('click','.taxonomy_media_remove',function(){
                $('#image_id').val('');
                $('#image_wrapper').html('<img class="custom_media_image" src="" style="margin:0;padding:0;max-height:100px;float:none;" />');
            });

            $(document).ajaxComplete(function(event, xhr, settings) {
                var queryStringArr = settings.data.split('&');
                if( $.inArray('action=add-tag', queryStringArr) !== -1 ){
                    var xml = xhr.responseXML;
                    $response = $(xml).find('term_id').text();
                    if($response!=""){
                        $('#image_wrapper').html('');
                    }
                }
            });
        });
    </script>
    <?php
}
add_action( 'admin_footer', 'add_custom_taxonomy_script' );