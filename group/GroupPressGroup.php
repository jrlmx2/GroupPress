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

Class GroupPressGroup
{
/*
 *  Register post types for groups
 *
 *
 *
 *  @return void
 */

	public static register_post_types(){}

/*
 * Register group taxonomies
 *
 *
 * @return void
 */

	public static register_tax_types(){}

/*
 * Register valid group status for workflow
 * 
 *
 *
 * @return void
 */

	public static register_status_types(){}

/*
 * Returns all current members of group
 *
 * @param int $group_id ID of the group to retrieve members
 *
 * @return array of group member ids
 */
	public static get_group_members( $group_id ){}

/*
 * Add a member to a group
 *
 * @param int $group_id ID of the group to retrieve members
 * @param int $member_id ID of the group to retrieve members
 *
 * @return bool was the addition successful
 */
	public static add_group_member( $group_id, $member_id ){}

/*
 * Remove a member to a group
 *
 * @param int $group_id ID of the group to retrieve members
 * @param int $member_id ID of the group to retrieve members
 *
 * @return bool was the removal successful
 */
	public static remove_group_member( $group_id, $member_id ){}

/*
 * List the most newly created groups limited on $limit. If limit is not set
 * the default value of the GroupPress option GroupPress_groups_per_page
 *
 * @param int $limit Upper limit of amount of groups retrieved
 *
 * @return mixed The value false is returned on failure. An array of group_ids is returned otherwise
 */
	public static list_latest_groups( $limit ){}

/*
 * The current active group information returned in an array based on wordpress post_table
 * TODO add an example response
 *
 *
 * @return mixed The value false is returned on failure. An array of group information is returned otherwise
 */
	public group_to_array(){}

/*
 * Return the current active group member IDs
 *
 *
 * @return array The list of the current active group memeber IDs the active group
 */
	public get_group_cur_group_members(){}

/*
 * Uses the current group active group ID to retrieve the group meta data. 
 *
 *
 * @return array List of meta data about the group.
 */
	public get_group_meta(){}

/*
 * Add meta information to a group
 *
 * @param string $meta_label the databse label for the post_meta table. The value GroupPress_$this->ID is prepended to protect other meta with the same key
 * @param string $meta_value the meta information for the post_meta table. The value GroupPress_$this->ID is prepended to protect other meta with the same key
 *
 * @return bool false on failure, true on success
 */
	public add_group_meta( $meta_label, $meta_value ){}

/*
 * Add member to current group
 *
 * @param int $member_id ID of the Member to add to the group. This action places the member in the "requested" status
 * @param bool $active Whether the intended member should go strait to active and bypass "requested" status. Default value is false. True bypass "requested" status.  
 *
 * @return bool false on failure, true on success
 */
	public add_group_member( $member_id, $active=false ){}

/*
 * Remove member to current group
 *
 * @param int $member_id ID of the Member to remove from the current group. This action removes a member. The members status in the database is marked as removed.
 *
 * @return bool false on failure, true on success
 */
	public remove_group_member( $member_id ){}

/*
 * List the members of the current active group in the "requested" status.
 *
 *
 * @return array The array of member IDs of pending members.
 */
	public list_pending_members(){}

/*
 * Mark a member as inactive in the group
 *
 * @param int $member_id ID of the Member to remove from the current group. This action removes a member. The members status in the database is marked as removed.
 *
 * @return bool true on success, false on failure
 */
	public mark_member_inactive( $member_id )){}

/*
 * Mark a member as active in the group
 *
 * @param int $member_id ID of the Member to remove from the current group. This action removes a member. The members status in the database is marked as removed.
 *
 * @return bool true on success, false on failure
 */
	public activate_member( $member_id ){}

}
?>
