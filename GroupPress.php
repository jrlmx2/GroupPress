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
require_once ( 'plugin.php' );
require_once ( 'plugin/GroupPressPlugin.php' );
use GroupPress\plugin as plugin;

global $GroupPress;
$GroupPress = new plugin\GroupPress();
$GroupPress->bootstrap();
