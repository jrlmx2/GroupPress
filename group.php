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
	* GroupPress plugin group aggregator
	*
	* @category GroupPress
	* @package GroupPress\group
	* @author James Lemieux
	*/

interface group
{
/*
 *  Register post types for groups
 *
 *
 *
 *  @return void
 */

	public static register_post_types();

/*
 * Register valid group status for workflow
 * 
 *
 *
 * @return void
 */

	public static get_group_members( $group_id );

/*
 * Return the current active group member IDs
 *
 *
 * @return array The list of the current active group memeber IDs the active group
 */
	public get_group_cur_group_members();

/*
 * Uses the current group active group ID to retrieve the group meta data. 
 *
 *
 * @return array List of meta data about the group.
 */
	public get_group_meta();

/*
 * Add meta information to a group
 *
 * @param string $meta_label the databse label for the post_meta table. The value GroupPress_$this->ID is prepended to protect other meta with the same key
 * @param string $meta_value the meta information for the post_meta table. The value GroupPress_$this->ID is prepended to protect other meta with the same key
 *
 * @return bool false on failure, true on success
 */
	public add_group_meta( $meta_label, $meta_value );


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
	public update_group_member( $member_id, $status='new' );
}
?>
