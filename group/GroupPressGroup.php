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

namespace GroupPress\group;


/**
	* GroupPressGroup Implementation.
	*
	* @category GroupPress
	* @package GroupPress\group
	* @author James Lemieux
	*/

final class GroupPressGroup
	implements group
{

/*
 * Array of member IDs.
 *
 * @array string
 */
	public $members = '';

/*
 * Post Type String for object checking
 *
 *
 * @var string
 */
	public static const $post_type = 'GroupPress-group';


/*
 * Group Wordpress Post Information
 *
 *
 * @var WP_Post
 */
	public $group = '';

/*
 * ID of the post
 *
 *
 * @var int
 */
	public $ID = '';

/*
 * Defualt arguments of group Post type for group creation
 *
 *
 * @var array
 */
	public static $group_creation_defaults = array(
		'post_status'           => 'draft',  // Status is not considered for groups. If you want to use this, you can update via $arg key 'post_status'
		'post_type'             => GroupPressGroup::$post_type,   // Use class defined constant to retain consistancy
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
 * Instantiate a group object
 *
 *
 *
 * @return obejct GroupPressGroup
 */
	public function __construct( $id ){
		$this->group = \WP_Post::get_instance( $id );

		$this->ID = (int) $id;
		
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
	public static register_post_type( $slug = 'grouppress-group') {
		$args = array(
			'label' => 'GroupPress Group',
			'public' => true,
			'show_ui' => true,
			'capability_type' => 'post',
			'hierarchical' => false,
			'rewrite' => array('slug' => $slug),
			'query_var' => true,
			'menu_icon' => 'dashicons-images-alt2',
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
		register_post_type( GroupPressGroup::$post_type , $args );
	}

/*
 * Register valid group status for workflow
 * 
 *
 *
 * @return void
 */

	public get_group_admin(){

		return new \GroupPress\member\GroupPressMember( $this->get_group_meta( $group_id, "group_admin" ) );
	}


	public static create_group( $args, $requires_login = true ){


		//Get Class standard arguments for group creation.
		$my_group = GroupPressGroup::$group_creation_defaults;

		//if user is required to be logged in and user is not logged in, return false;
		if ( 0 === (int) ( $user_id = \get_current_user_id() ) and $requires_login ) {
			return false;	

		//if the user is logged in and require login is true, 
		} else if ( $requires_login ) {
			$my_group[ 'post_author' ] = $user_id;

		//if the user is set in the args. One idea for this usage is implmenting theme functionallity to support group creation on behalf of another.
		} else if ( array_key_exists( 'post_author', $my_group ) ) {
			$my_group[ 'post_author' ] = $args[ 'post_author' ];
		}

		//Defines the minimum required content for post creation. Title and description required. Return false otherwise
		if ( empty( $args[ 'post_title' ] ) or empty( $args[ 'post_content' ] ) ) {
			return false;
		}

		//Update post creation args based on whats passed in.
		foreach ( $args as $key_to_update => $value_to_update ) {
			if ( 'post_type' != $key_to_update and array_key_exists( $key_to_update, $defualts ) ) {
				$my_group[ $key_to_update ] = $value_to_update;
			}
		}

		return \wp_insert_post( $my_group );
	}

/*
 * Returns all current members of group
 *
 * @param int $group_id ID of the group to retrieve members
 * @param bool $active Toggle for returning only active members
 *
 * @return array of group member ids
 */
	public static get_group_members( $group_id = false, $active = true ){
		if !empty( $group_id )
		{
			/*
			 * If the current post type is equal to the post type of the group, find the members.
			 */
			if ( GroupPressGroup::$post_type == \get_post_type( \get_the_ID() ) ) {
				if ( $active ) {
					return \explode( ',', \get_post_meta( \get_the_ID(), "members", true ));
				} else {

					$members = array();
					$members[ 'active' ] = \explode( ',', \get_post_meta( \get_the_ID(), "members", true ));
					$members[ 'inactive' ] = \explode( ',', \get_post_meta( \get_the_ID(), "inactive_members", true ));
					$members[ 'new' ] = \explode( ',', \get_post_meta( \get_the_ID(), "new_members", true ));

					return $members;
				}
			}
			
			//TODO CREATE EXCEPTION HANDLING CLASS AND IMPLMENT THIS EXCPETION HANDLING
			return false;
		}

		$members = array();
		$members[ 'active' ] = \explode( ',', \get_post_meta( $group_id, "members", true ));
		$members[ 'inactive' ] = \explode( ',', \get_post_meta( $group_id, "inactive_members", true ));D
		$members[ 'new' ] = \explode( ',', \get_post_meta( $group_id, "new_members", true ));

		if( $active ) {
			return $members[ 'active' ];
		} else {
			return $members;
		}
	}

/*
 * Add a member to a group
 *
 * @param int $group_id ID of the group to retrieve members
 * @param int $member_id ID of the group to retrieve members
 *
 * @return bool was the addition successful
 */
	public static add_group_member( $group_id, $member_id ){
		$group_id = (int) $group_id;
		$member_id = (int) $member_id;

		/*
		 * //TODO Check if I need to force cache updates after adding a member
		 */ 
		
		$current_members = \explode( ',', \get_post_meta( $group_id, "members", true ) );
		$current_members[] = $member_id;
		$updated_members = \implode( ',' $current_member );

		if ( !\update_post_meta( $group_id, "members", $updated_members ) ) {
			//TODO Implement exception handling class here as well. For the short term, themes can handle false"
			return false;
		}		

		return true;
	}

/*
 * Remove a member to a group
 *
 * @param int $group_id ID of the group to retrieve members
 * @param int $member_id ID of the group to retrieve members
 *
 * @return bool was the removal successful
 */
	public static remove_group_member( $group_id, $member_id ){
		$group_id = (int) $group_id;¬
		$member_id = (int) $member_id;¬

		/*¬
		* //TODO Check if I need to force cache updates after adding a member¬
		*/·¬

		$current_members = \explode( ',', \get_post_meta( $group_id, "members", true ) );¬

		if( ($key = \array_search($member_id, $current_members) ) !== false) {
			    unset($current_members[$key]);
		} else {
			//TODO Implement exception handling class here as well"¬
			return false;
		}

		return true;

	}

/*
 * List the most newly created groups limited on $limit. If limit is not set
 * the default value of the GroupPress option GroupPress_groups_per_page
 *
 * @param int $limit Upper limit of amount of groups retrieved
 *
 * @return mixed The value false is returned on failure. An array of group_ids is returned otherwise
 */
	public static list_latest_groups( $limit ) {
		/*
		 *	//TODO review these options more in depth for use in themes.
		 */
		if ( !isset( $limit ) ) {
				$limit = \get_option( 'GroupPress_posts_per_page' );
		}
		$args = array(
			'posts_per_page'   => $limit,
			'offset'           => 0,
			'category'         => '',
			'orderby'          => 'post_date',
			'order'            => 'DESC',
			'include'          => '',
			'exclude'          => '',
			'meta_key'         => '',
			'meta_value'       => '',
			'post_type'        => GroupPressGroup::$post_type,
			'post_mime_type'   => '',
			'post_parent'      => '',
			'post_status'      => 'publish',
			'suppress_filters' => true
		)
		return \get_posts( $args );
		//TODO failure condition
	}


/*
 * Return the current active group member IDs
 *
 *
 * @return array The list of the current group memeber IDs the active group
 */
	public get_group_cur_group_members( $active = true ){
		if ( $active ) {
			return $this->members['active'];
		} else {
			return $this->members;
		}
		
	}

/*
 * Uses the current group active group ID to retrieve the group meta data. 
 *
 * @param string of meta keys to return
 *
 * @return mixed List of meta data about the group.
 */
	public get_group_meta( $meta_labl = null ){
		if ( !$this->group ) {
			return false;
		}

		if ( null == $meta_label ) {
			return \get_post_meta( $this->ID );
		} elseif { is_string( $meta_label ) ) {
			return \get_post_meta( $this->ID, $meta_label, true );
		} else {
			//TODO exception handling....
			return false
		}
	}

/*
 * Add meta information to a group
 *
 * @param string $meta_label the databse label for the post_meta table. The value GroupPress_$this->ID is prepended to protect other meta with the same key
 * @param string $meta_value the meta information for the post_meta table. The value GroupPress_$this->ID is prepended to protect other meta with the same key
 * @param bool is the meta key intended to be unique
 *
 * @return bool false on failure, true on success
 */
	public add_group_meta( $meta_label, $meta_value, $unique ){
		return \add_post_meta( $this->ID, $meta_label, $meta_value, $unique );
	}

/*
 * List the members of the current active group in the "new" status.
 *
 *
 * @return array The array of member IDs of pending members.
 */
	public list_pending_members(){
		return $this->members[ 'new' ];
	}

/*
 * Mark a member as inactive in the group
 *
 * @param int $member_id ID of the Member to remove from the current group. This action removes a member. The members status in the database is marked as removed.
 * @param string $status status of the member update. expected values are as follows:
 *     "new" (default) => add member to the new members list
 *     "active" => add member to the active list.
 *     "inactive" => add member to the inactive list.
 *     "remove" => remove member from group
 *
 *     *note In all situations, the member is first removed from all current lists, and then reassigned accordingly
 *
 * @return bool true on success, false on failure
 */
	public update_group_member( $member_id, $status='new' ) {

		if ( !$key = \array_search( $status, array( 'new', 'active', 'inactive', 'remove' ) ) or !is_string( $status ) ) {
			return false;
		}

		$member_id = (int) $member_id;

		if ( !isset( $member_id ) ) {
			return false;
		}

		if ( is_array( $this->members ) ) {
			foreach( $this->members as $member_status => $member_list ) {

				if( $key = array_search( $member_id, $member_list ) ) {
					unset( $this->members[ $member_status ][ $key ] );
				}

				if( $status == $member_status ) {
					$this->members[ $member_status ][] = $member_id;
				}

				if ( 'active' != $member_stataus ) {
					\update_post_meta( $this->ID, $member_status.'_members', \implode( ',', $this->members[ $member_status ] ) );
				} else {
					\update_post_meta( $this->ID, 'members', \implode( ',', $this->members[ 'active' ] ) );
				}
			}
			return true;
		} else {
			return false;
		}
	}

}
?>
