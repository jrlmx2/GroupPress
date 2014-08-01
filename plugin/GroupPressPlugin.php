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
 * GroupPress plugin install Class Implementation. This defines the implementation
 * of intial activation procedures.
 *
 * @category GroupPress
 * @package GroupPress\plugin
 * @author James Lemieux
 */

Class GroupPress
	implements \GroupPress\wordpress_plugin
{

	const VER = '0.1-dev';
	const DB_VER = 1;
/*
 * Activate the plugin and setup post_types
 *
 *
 * @return void
 */
	public function activate(){

		$this->init_options();
		$this->register_post_types();
		$this->maybe_update();
		\flush_rewrite_rules();
	}
	public function maybe_update() {
		//bail if this plugin data doesn't need updating
		if ( get_option( 'GroupPress_db_ver' ) >= self::DB_VER ) {
			return;
		}

		require_once( __DIR__ . '/update.php' );
		GroupPress_update();
	}


/*
 * Init Plugin Options
 *
 *
 * @return void
 */
	public function init_options(){

		update_option( 'GroupPress_ver', self::VER );
		add_option( 'GroupPress_db_ver', self::DB_VER );

		add_option( 'GroupPress_prev_ver', 0 );
		add_option( 'GroupPress_posts_per_page', 5 );
		add_option( 'GroupPress_show_welcome_page', true );
	}

/*
 * Force Plugin Update function
 *
 *
 * @return void
 */
	public static function update(){
		require_once( __DIR__ . '/update.php' );
		GroupPress_update();
	}

/*
 * register post types
 *
 *
 * @return void
 */
	public function register_post_types(){
		//TODO add static references to the member and group post_type declaration functions
	}
	
/*
 * Add wordpress actions
 *
 *
 * @return void
 */
	public function bootstrap(){
		\register_activation_hook( __FILE__, array( $this, 'activate' ) );

		\add_action( 'init', array( $this, 'register_post_types' ) );
	}
	/*
	public static function establish_post_type()
	{
		\register_post_type( 
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
	}

	public static function establish_post_status()
	{
		\register_post_status( 
			'active', 
			array(
				'label'       => _x( 'Active', 'GroupPress: Active group' ),
				'public'      => true,
				'label_count' => _n_noop( 'Established <span class="count">(%s)</span>', 'Established <span class="count">(%s)</span>' ),
			)
		);

		\register_post_status( 
			'inactive', 
			array(
				'label'       => _x( 'Inactive', 'GroupPress: Inactive group' ),
				'public'      => true,
				'label_count' => _n_noop( 'Inactive <span class="count">(%s)</span>', 'Inactive <span class="count">(%s)</span>' ),
			) 
		);

	}
	 */
}
?>
