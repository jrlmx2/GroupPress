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

namespace GroupPress\member;


/*
 * GroupPress plugin install Class Implementation. This defines the implementation
 * of intial activation procedures.
 *
 * @category GroupPress
 * @package GroupPress\member
 * @author James Lemieux
 */

Class GroupPressMember
	implements member
{
/*
 * Post Type String for object checking
 *
 *
 * @var string
 */
	public const $post_type = 'GroupPress-member';


/*
 * Group Wordpress User Information
 *
 *
 * @var WP_User
 */
	private $user = '';

/*
 * Group Wordpress Post Information
 *
 *
 * @var WP_Post
 */
	public $member = '';

/*
 * ID of the wordpress post for the member
 *
 *
 * @var int
 */
	public $ID = '';

/*
 * ID of the wordpress post for the member
 *
 *
 * @var mixed false upon empty member_of post_meta value for the member details post. Array of group IDs otherwise.
 */
	public $is_member = '';

/*
 * Defualt arguments of group Post type for group creation
 *
 *
 * @var array
 */
	public static $member_creation_defaults = array(
		'post_status'           => 'draft',  // Status is not considered for groups. If you want to use this, you can update via $arg key 'post_status'
		'post_type'             => GroupPressMember::$post_type,   // Use class defined constant to retain consistancy
		'ping_status'           => \get_option('default_ping_status'),  //not considered.
		'post_parent'           => 0,  //Not considered for 1.0
		'menu_order'            => 0,  //Not considered for 1.0
		'to_ping'               =>  '', // N/A
		'pinged'                => '',  // N/A
		'post_password'         => '',  // Not considered for 1.0 although can be updated via input $args.
		'guid'                  => '',  // guid
		'post_content_filtered' => '',  // Not considered for 1.0 although can be updated via input $args
		'post_excerpt'          => '',  // update via $args
		'import_id'             => 0    // N/A
	);

/*
 * Instantiate a member object
 *
 *
 *
 * @return obejct GroupPressMember
 */
	public function __construct( $id, $require_login ){
		$this->member = \WP_Post::get_instance( $id );
		$this->ID = (int) $id;


		//if the inserted post type is not a GroupPress member, make a new post that is a GroupPress Member
		if( $this->member['post_type'] != GroupPressMember::$post_type ) {
			$this->ID = GroupPressMember::create_member( $this->member, $require_login );
			$this->member = \WP_Post::get_instance( $this->ID );
		}


		//find wordpress user
		if( isset( $user_id = \get_post_meta( $id, "member_id", true ) ) ){
			$this->user = new \WP_User( $user_id );
		} else {
			$this->user = null; //TODO
		}

		//find groups member is a group of
		if( isset( $group_ids = \get_post_meta( $id, "group_ids", true ) ) ){
			$this->member_of = explode( ',', $group_ids ); 
		} else {
			$this->member_of = false;
		}
		
		if ( $this->group ) {
			$this->members = GroupPressGroup::get_group_members( $this->group->ID, false );
		}

	}

/*
 *  Register post types for groups
 *
 *
 *
 *  @return void
 */
	public static function register_post_type( $slug = 'grouppress-member') {
		$args = array(
			'label' => 'GroupPress Member',
			'public' => true,
			'show_ui' => true,
			'capability_type' => 'post',
			'hierarchical' => false,
			'rewrite' => array('slug' => $slug),
			'query_var' => true,
			'menu_icon' => 'dashicons-universal-access',
			'supports' => array(
				'title',
				'editor',
				'excerpt',
				'trackbacks',
				'custom-fields',
				'comments',
				'revisions',
				'thumbnail',
				'author',
				'page-attributes'
			)
		);
		register_post_type( GroupPressMember::$post_type , $args );

	public static function update_member_status( $member_id, $group_id ){
	}
}
?>
