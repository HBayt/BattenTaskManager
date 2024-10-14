<?php

/**
 * Creates an group row with the given name
 * @param    string  $name is a string that describes a group
 */
function createGroup ($label, $name) {
    $group = R::dispense( 'group' );
    $group->name = $name;
    $group->libelle = $label;
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
    return R::load( 'group', $id); 
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

// _____________________________________________________________________________________
// CASCADING DELETE OF GROUP (IDENTIFIED BY ID) 
// _____________________________________________________________________________________
/**
 * Deletes the group at the given id
 * @param integer $id of the group to delete 
 */
function deleteGroup($id) {
    $group = R::load( 'group', $id ); 
    $notAssignedGroup  = R::findOne( 'group', ' libelle=?', ["NONE"] ); // Not assigned group / Libelle = NONE 

    // R::exec('DELETE FROM child_table WHERE parent_id = :pid', array('pid' => $parent->id));
    R::exec('UPDATE group_task SET group_id = :group_id WHERE group_id = :parent_id', array('group_id' => $notAssignedGroup->id,'parent_id' => $id));
    R::exec('UPDATE user SET group_id = :group_id WHERE group_id = :parent_id', array('group_id' => $notAssignedGroup->id,'parent_id' => $id));


    // die(); 
    R::trash($group);
}





// _____________________________________________________________________________________
// COUNTING NUMBER OF GROUPS IN THE DATABASE   
// _____________________________________________________________________________________
function countGroups() {
    $numOfGroups = R::count( 'group');
    return $numOfGroups; 
}// numGroups = countGroups() ; 


// _____________________________________________________________________________________
// GET GROUPS ROWS BY THE GIVEN GROUP ID 
// _____________________________________________________________________________________
function getGroupListById($id) {
    $groups = R::getAll("SELECT * FROM `group` WHERE `id` =?",[$id]); 
    return $groups;
}
// $groups = getGroupListById($group_id); 


// ____________________________________________________________________________________________
// GET GROUP BY ITS ID 
// _____________________________________________________________________________________________
function getGroupIdById($id) {
    $group  = R::findOne( 'group', ' id=?', [$id] ); 
    return $group; 
}

