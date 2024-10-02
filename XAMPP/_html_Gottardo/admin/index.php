<?php
session_start();
include '../config.php';
include '../utils/connectdb.php';
require '../model/admin.php';

createDefaultAdmin(DEFAULT_ADMIN_USER, DEFAULT_ADMIN_PASS);

if (isset($_POST['password']) && isset( $_POST['username']) ){
    if(checkAdmin($_POST['username'], $_POST['password'])) {
        $_SESSION["login"] = true;
    }
}
if(isset($_SESSION["login"])){
    if($_SESSION["login"]) {
        header("Location: /admin/group.php");
    }
}

require 'vue/login.php';
?>
