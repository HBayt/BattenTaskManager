<?php 

//________________________________________________________
// INSERT INT TABLE ADMIN A NEW ADMIN (ROW)
//________________________________________________________
function createAdmin ($name, $password) {
    $admin = R::dispense( 'admin' );
    $admin->name = $name;
    $admin->password = password_hash($password, PASSWORD_BCRYPT);
    return R::store( $admin );
}

//________________________________________________________
// UPDATE A ADMIN (TABLE ADMIN ROW)
//________________________________________________________

function updateAdmin($id, $name, $password) {
    $admin = R::load( 'admin', $id );
    $admin->name = $name;
    $admin->password = password_hash($password, PASSWORD_BCRYPT);
    R::store( $admin );
}

//________________________________________________________
// LOOK FOR AN ADMIN IN THE DATABASE TABLE ADMIN 
//________________________________________________________
function checkAdmin ($name, $password) {

    // FIND ADMIN (ROW)
    $admin  = R::find( 'admin', "name = '" . $name . "'");

    // IF ADMIN FOUND 
    if($admin != []) {

        // VERIFY HIS PASSWORD 
        return password_verify($password, reset($admin)->password);  
    } else {

        // ADMIN NOT FOUND 
        return false;
    }
}

//________________________________________________________
// GET / SELECT ALL ADMIN LIST 
//________________________________________________________
function getAdmin() {
    $admin = R::findAll( 'admin' );
    return $admin;
}

//________________________________________________________
// DELETE AN ADMIN BY USING HIS ID 
//________________________________________________________
function deleteAdmin($id) {
    $admin = R::load( 'admin', $id ); 
    R::trash( $admin );
}

//________________________________________________________
// CREATE A DEFAULT ADMIN USER 
//________________________________________________________
function createDefaultAdmin ($username, $password) {
    $admins = R::findAll( 'admin' );
    if($admins == []) {
        createAdmin($username, $password);
    }
}