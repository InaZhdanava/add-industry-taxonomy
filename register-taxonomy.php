<?php
/**
 * Register taxonomy
 */
 
function register_custom_taxonomy() {
    $labels = array(
        'name'              => _x( 'Industries', 'taxonomy general name' ),
        'singular_name'     => _x( 'Industry', 'taxonomy singular name' ),
        'search_items'      => __( 'Search Industries' ),
        'all_items'         => __( 'All Industries' ),
        'parent_item'       => __( 'Parent Industry' ),
        'parent_item_colon' => __( 'Parent Industry:' ),
        'edit_item'         => __( 'Edit Industry' ),
        'update_item'       => __( 'Update Industry' ),
        'add_new_item'      => __( 'Add New Industry' ),
        'new_item_name'     => __( 'New Industry Name' ),
        'menu_name'         => __( 'Industry' ),
    );
    $args   = array(
        'hierarchical'      => true,
        'labels'            => $labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => [ 'slug' => 'industry' ],
    );
    register_taxonomy( 'industry', [ 'post' ], $args );
}
add_action( 'init', 'register_custom_taxonomy' );