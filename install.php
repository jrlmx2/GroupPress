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

namespace GroupPress;


/**
	* GroupPress plugin activation setup  
	*
	* @category GroupPress
	* @package GroupPress\install
	* @author James Lemieux
	*/

interface install
{

/*
 * Generate a new post type named GroupPress
 *
 *
 * @return void
 */
	public static function establish_post_type();

/*
 * Generate a new status types for the group post type
 *
 *
 * @return void
 */
	public static function establish_post_status();

}
?>
