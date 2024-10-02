<?php 

// _____________________________________________________________________________________
// COUNTING NUMBER OF USERS IN THE DATABASE   
// _____________________________________________________________________________________
function countUsers() {
    $numOfUsers = R::count( 'user');
    return $numOfUsers; 
}

// _____________________________________________________________________________________
// COUNTING NUMBER OF USERS OF A GROUP IN THE DATABASE   
// _____________________________________________________________________________________
function countUsersByGroup($group_id) {
    $numOfUsers = R::count( 'user', 'group_id LIKE ?', [$group_id]);
    // $numOfBooks = R::count( 'book', ' pages > ? ', [ 250 ] );
    return $numOfUsers; 
}




// ____________________________________________________________________________________________
// INSERT USER OCCURENCE INTO DATABASE TABLE USER 
// _____________________________________________________________________________________________
function createUser ($name, $email, $weekdays, $group_id) {
    $user = R::dispense( 'user' );
    $user->name = $name;
    $user->email = $email;
    $user->weekdays = json_encode($weekdays);
    $user->doneTask = 0;
    $user->group_id = $group_id;
    return R::store( $user );
}

// ____________________________________________________________________________________________
// UPDATE A USER OCCURENCE FROM THE DATABASE TABLE USER 
// _____________________________________________________________________________________________
function updateUser($id, $name, $email, $weekdays, $group_id) {
    $user = R::load( 'user', $id );
    $user->name = $name;
    $user->email = $email;
    $user->weekdays = json_encode($weekdays); 
    $user->group_id = $group_id;
    R::store( $user );
}

// ____________________________________________________________________________________________
// SELET ALL USERS
// _____________________________________________________________________________________________
function getUser() {
    $users = R::findAll('user' , 'WHERE email IS NOT NULL AND name IS NOT NULL ORDER BY name ASC');
    return $users;
}

// ____________________________________________________________________________________________
// SELECT A USR BY HIS ID GIVEN IN PARAMS 
// _____________________________________________________________________________________________
function getUserIdById($id) {
    $user  = R::findOne( 'user', ' id=?', [$id] ); 
    return $user; 
}

// ____________________________________________________________________________________________
// SELECT AND RETURN A USER BY HIS EMAIL GIVEN IN PARAMS 
// _____________________________________________________________________________________________
function getUserIdByEmail($email) {
    $user  = R::findOne( 'user', ' email=?', [$email] ); // $user = R::findOne('user', 'email = ? ', array($email));

    // var_dump( $user ); 
    return $user; 

    
}

// ____________________________________________________________________________________________
// DELETE A USER FROM TABLE "USER" BY HIS ID GIVEN IN PARAMETER  
// _____________________________________________________________________________________________
function deleteUser($id) {
    $user = R::load( 'user', $id ); 
    R::trash( $user );
}

// ____________________________________________________________________________________________
// SELECT A USER FROM TABLE "USER" BY HIS GROUP_ID GIVEN IN PARAMETER  
// _____________________________________________________________________________________________
function getUserByGroup($group_id) {

    // R::getAll( 'select * from book where id= :id AND active = :act',array(':id'=>$id,':act' => 1) );
    return R::find('user', 'group_id = '. $group_id);

}

