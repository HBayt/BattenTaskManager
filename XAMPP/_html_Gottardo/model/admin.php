<?php 

function createAdmin ($name, $password) {
    $admin = R::dispense( 'admin' );
    $admin->name = $name;
    $admin->password = password_hash($password, PASSWORD_BCRYPT);
    return R::store( $admin );
}

function updateAdmin($id, $name, $password) {
    $admin = R::load( 'admin', $id );
    $admin->name = $name;
    $admin->password = password_hash($password, PASSWORD_BCRYPT);
    R::store( $admin );
}

function checkAdmin ($name, $password) {

    $admin  = R::find( 'admin', "name = '" . $name . "'");

    if($admin != []) {
        return password_verify($password, reset($admin)->password);  
    } else {
        return false;
    }
}

function getAdmin() {
    $admin = R::findAll( 'admin' );
    return $admin;
}

function deleteAdmin($id) {
    $admin = R::load( 'admin', $id ); 
    R::trash( $admin );
}

function createDefaultAdmin ($username, $password) {
    $admins = R::findAll( 'admin' );
    if($admins == []) {
        createAdmin($username, $password);
    }
}