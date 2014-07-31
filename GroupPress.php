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
require ( 'install.php' );
require ( 'install/Install.php' );
use GroupPress\install as GP_Install;

function create_post_type($text = null)
{

	do_action( 'GroupPress_before_install' );

	GP_Install\Install::establish_post_type();
	GP_Install\Install::establish_post_status();

	do_action( 'GroupPress_after_install' );
}
register_activation_hook(__FILE__, 'create_post_type');
