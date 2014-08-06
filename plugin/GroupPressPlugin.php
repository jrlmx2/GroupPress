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

	public $top_level_category_id = "";
	public $group_category_id = "";
	public $member_category_id = "";

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
		$this->register_categories();
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


	public function register_categories( $args = null ){
		if ( empty( $args ) ) {
			$GroupPress_args = array(
				'cat_name' => "GroupPress",
				'category_description' => "Powered by GroupPress.",
				'category_nicename' => "grouppress",
				'taxonomy' => 'category' );
			$this->top_level_category_id = \wp_insert_category( $GroupPress_args, $additional_child_categorty );

			$group_args = array(
				'cat_name' => "Group",
				'category_description' => "Series of members organized together along with additional meta for recording achievement tracking.",
				'category_nicename' => "member-group",
				'category_parent' => $top_level_id,
				'taxonomy' => 'category' );
			$this->group_category_id = \wp_insert_category( $group_args );

			$member_args = array(
				'cat_name' => "Member",
				'category_description' => "Wordpress User",
				'category_nicename' => "member",
				'category_parent' => $top_level_id,
				'taxonomy' => 'category' );
			$this->member_category_id = \wp_insert_category( $member_args );
		} else {
			if ( !empty( $args[ 'top' ] ) ) {
				$GroupPress_args = $args['top'];
			} else {
				$GroupPress_args = array(
					'cat_name' => "GroupPress",
					'category_description' => "Powered by GroupPress.",
					'category_nicename' => "grouppress",
					'taxonomy' => 'category' );
			}
			$this->top_level_category_id = \wp_insert_category( $GroupPress_args );


			if ( !empty( $args[ 'group' ] ) ) {
				$group_args = $args[ 'group' ];
			} else {
				$group_args = array(
					'cat_name' => "Group",
					'category_description' => "Series of members organized together along with additional meta for recording achievement tracking.",
					'category_nicename' => "member-group",
					'category_parent' => $top_level_id,
					'taxonomy' => 'category' );
			}
			$this->group_category_id = \wp_insert_category( $group_args );


			if ( !empty( $args[ 'member' ] ) ) {
				$member_args = $args[ 'member' ];
			} else {
				$member_args = array(
					'cat_name' => "Member",
					'category_description' => "Wordpress User",
					'category_nicename' => "member",
					'category_parent' => $top_level_id,
					'taxonomy' => 'category' );
			}
			$this->member_category_id = \wp_insert_category( $member_args );
		}
	}

	public function get_category_types() {

		$this->top_level_category_id = get_cat_ID( 'GroupPress' ); 
		$this->group_category_id = get_cat_ID( 'Group' );
		$this->member_category_id = get_cat_ID( 'Member' );
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
		GroupPressGroup::register_post_type();
		GroupPressMember::register_post_type();
	}
	
/*
 * Add wordpress actions
 *
 *
 * @return void
 */

	public function bootstrap(){
		\register_activation_hook( __FILE__, array( $this, 'activate' ) );

		if ( empty($this->top_level_category_id) ) {
			$this->get_category_types();
		}
	}
}
?>
