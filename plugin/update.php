<?php
/**
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 *
 * @category GroupPress 
 * @package GroupPress
 * @author James Lemieux
 * @license http://www.apache.org/licenses/LICENSE-2.0
 */

namespace GroupPress\plugin;


/*
 * GroupPress plugin update utility.
 *
 * @category GroupPress
 * @package GroupPress\plugin
 * @author James Lemieux
 */

function GroupPress_update() {
	// no PHP timeout for running updates
	set_time_limit( 0 );

	global $GroupPress;

	// this is the current database schema version number
	$current_db_ver = get_option( 'GroupPress_db_ver' );

	// this is the target version that we need to reach
	$target_db_ver = GroupPress::DB_VER;

	// run update routines one by one until the current version number
	// reaches the target version number
	while ( $current_db_ver < $target_db_ver ) {
		// increment the current db_ver by one
		$current_db_ver ++;

		// each db version will require a separate update function
		// for example, for db_ver 3, the function name should be solis_update_routine_3
		$func = "GroupPress_update_routine_{$current_db_ver}";
			if ( function_exists( $func ) ) {
				call_user_func( $func );
			}

		//update the option in the database, so that this process can always
		// pick up where it left off
		update_option( 'GroupPress_db_ver', $current_db_ver );
	}
}
