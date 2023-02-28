<?php
/**
 * Add order field
 */

function add_industry_order( $taxonomy ) {
?>
    <div class="form-field term-order">

        <label for="industry_order"><?php _e( 'Order' ); ?></label>
        <input type="number" id="industry_order" name="industry_order">

    </div>
<?php
}
add_action( 'industry_add_form_fields', 'add_industry_order' );


/**
 * Save Order Field
 */

function save_industry_order( $term_id ) {

    if( isset( $_POST['industry_order'] ) && '' !== $_POST['industry_order'] ){
     $order = $_POST['industry_order'];
     add_term_meta( $term_id, 'industry_order', $order );
    }

}
add_action( 'created_industry', 'save_industry_order' );


/**
 * Add Order Field in Edit Form
 */

function update_industry_order( $term, $taxonomy ) { ?>
    <tr class="form-field term-group-wrap">
        <th scope="row">
            <label for="industry_order"><?php _e( 'Order' ); ?></label>
        </th>
        <td>

            <?php $order = get_term_meta( $term -> term_id, 'industry_order', true ); ?>
                     
            <input type="number" id="industry_order" name="industry_order" value="<?php _e( $order ); ?>">

        </td>
    </tr>
<?php
}
add_action( 'industry_edit_form_fields', 'update_industry_order', 10, 2 );


/**
 * Update Order Field
 */

function updated_industry_order( $term_id ) {
    if( isset( $_POST['industry_order'] ) && '' !== $_POST['industry_order'] ){
        $order = $_POST['industry_order'];
        update_term_meta( $term_id, 'industry_order', $order );
    } else {
        update_term_meta( $term_id, 'industry_order', '' );
    }
}
add_action( 'edited_industry', 'updated_industry_order', 10, 2 );


/**
 * Display Order in Column
 */

function display_order_column_heading( $columns ) {
    $columns['industry_order'] = __( 'Order' );
    return $columns;
}
add_filter( 'manage_edit-industry_columns', 'display_order_column_heading' ); 

function display_order_column_value( $columns, $column, $id ) {
    if ( 'industry_order' == $column ) {
    
        _e( get_term_meta( $id, 'industry_order', true ) );

    }
    return $columns;
}
add_action( 'manage_industry_custom_column', 'display_order_column_value' , 10, 3);