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
	* WordPress Plugin aggregator
	*
	* @category GroupPress
	* @package GroupPress\plugin
	* @author James Lemieux
	*/

interface wordpress_plugin
{
/*
 * Activate the plugin and setup post_types
 *
 *
 * @return void
 */
	public function activate();

/*
 * Init Plugin Options
 *
 *
 * @return void
 */
	public function init_options();

/*
 * Function for implementing plugin update routine 
 *
 *
 * @return void
 */
	public static function update();

/*
 * register post types
 *
 *
 * @return void
 */
	public function register_post_types();
	
/*
 * Add wordpress actions
 *
 *
 * @return void
 */
	public function bootstrap();

}
?>
