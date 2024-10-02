<?php
/**
 * Creates an group row with the given name
 * @param    string  $name is a string that describes a group
 */
function createGroup ($name) {
    $group = R::dispense( 'group' );
    $group->name = $name;
    $id = R::store( $group );
}

/**
 * Updates the group at the given id with a new given name
 * @param    integer  $id of the row to update
 * @param    string   $name new name for the given row
 */
function updateGroup($id, $name) {
    $group = R::load( 'group', $id );
    $group->name = $name;
    R::store( $group );
}

/**
 * Return all the groups
 * @return array of redbean objects
 */
function getGroup() {
    $group = R::findAll( 'group' );
    return $group;
}

/**
 * Return a group by the given id
 * @param  integer $id to be researched
 * @return array of redbean objects
 */
function loadGroup($id) {
    return R::load( 'group', $id ); 
}

/**
 * Deletes the group at the given id
 * @param integer $id of the group to delete 
 */
function deleteGroup($id) {
    $group = R::load( 'group', $id ); 
    R::trash($group);
}

/**
 * Links a user to a group
 * @param integer $idGroup of the group  
 * @param integer $idUser of the user 
 */
function addUserToGroup($idGroup, $idUser) {
    $group = R::load( 'group', $idGroup );
    $user = R::load( 'user', $idUser );
    $group->ownUserList[] = $user;
    R::store( $group );
}
