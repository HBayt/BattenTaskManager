<?php


session_start();

if($_SESSION["login"]) {

    require '../config.php';
    require 'vue/partials/header.php';
    include '../utils/connectdb.php';
    include '../model/user.php';
    include '../model/group.php';
    include 'vue/partials/nav.php';

    if(isset($_GET['group_id'])) {
        $user = getUserByGroup($_GET['group_id']);
        $group = loadGroup($_GET['group_id']);
    } else {
        $user = getUser();
    }

    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        if(isset($_POST['action'])){

            if ($_POST['action'] == 'alterUser') {

                updateUser($_POST['id'], $_POST['name'], $_POST['email'],  $_POST['weekdays']);

            } elseif ($_POST['action'] == 'deleteUser') {

                deleteUser($_POST['id']);

            } elseif ($_POST['action'] == 'createUser') {
                
                $u = createUser($_POST['name'], $_POST['email'], $_POST['weekdays']);

                if(isset($_GET['group_id'])) { 
                    addUserToGroup($_GET['group_id'], $u);
                }
            }

        }
        header("Refresh:0");
    }

    require 'vue/user.php';

    require 'vue/partials/footer.php';
} else {
    header("Location: /admin/");
} 