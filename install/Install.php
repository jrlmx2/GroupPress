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

namespace GroupPress\install;


/*
 * GroupPress plugin install Class Implementation. This defines the implementation
 * of intial activation procedures.
 *
 * @category GroupPress
 * @package GroupPress\install
 * @author James Lemieux
 */

Class Install
	implements \GroupPress\install
{
	public static function establish_post_type()
	{
		global $wp_post_types;
		if ( isset( $wp_post_types[ 'GroupPress' ] ) ) {
			return true; /* Do no re-establish the post_type */
		}

		register_post_type( 
			'post', array(
				'labels' => array(
					'name_admin_bar' => _x( 'Group', 'add new on admin bar' ),
				),
				'public'  => true,
				'capability_type' => 'post',
				'map_meta_cap' => true,
				'hierarchical' => false,
				'rewrite' => false,
				'query_var' => false,
				'delete_with_user' => true,
				'supports' => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'trackbacks', 'custom-fields', 'comments', 'revisions', 'post-formats' ),
			) 
		);
		return true;
	}

	public static function establish_post_status()
	{
		global $wp_post_statuses;
		if ( !isset( $wp_post_statuses[ 'active' ] ) )
		{
			register_post_status( 
				'active', 
				array(
					'label'       => _x( 'Active', 'GroupPress: Active group' ),
					'public'      => true,
					'label_count' => _n_noop( 'Established <span class="count">(%s)</span>', 'Established <span class="count">(%s)</span>' ),
				)
			);
		}

		if ( !isset( $wp_post_statuses[ 'inactive' ] ) )
		{
			register_post_status( 
				'inactive', 
				array(
					'label'       => _x( 'Inactive', 'GroupPress: Inactive group' ),
					'public'      => true,
					'label_count' => _n_noop( 'Inactive <span class="count">(%s)</span>', 'Inactive <span class="count">(%s)</span>' ),
				) 
			);
		}
	}
}
?>
