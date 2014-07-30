<?php 
/*
 * Plugin Name: GroupPress
 * Plugin URI: www.theinternetmoster.com or https://github.com/jrlmx2/GroupPress/
 * Description: Creates a group management interface through wordpress which allows for user grouping. 
 * Version: 0.01
 * Author: James Lemieux
 * Author URI: www.theinternetmonster.com
 */

namespace GroupPress;


/* Is this plugin active? Check a Post. */
add_filter( 'the_content' , create_function( '', 'var_dump( current_filter() );' ) );

