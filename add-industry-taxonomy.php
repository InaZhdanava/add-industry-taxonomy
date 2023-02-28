<?php
/*
* Plugin Name: Add Custom Industry Taxonomy
* Description: Add custom Industry taxonomy with custom fields.
* Version: 1.0.0
* Author: Inna Zhdanova
*/

/**
 * Register taxonomy
 */

require_once plugin_dir_path( __FILE__ ) . 'register-taxonomy.php';


/**
 * Add image field
 */

require_once plugin_dir_path( __FILE__ ) . 'add-image-field.php';


/**
 * Add order field
 */

require_once plugin_dir_path( __FILE__ ) . 'add-order-field.php';
