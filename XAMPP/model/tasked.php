<?php 


// _____________________________________________________________________________________
// COUNTING ASSIGNED TASKEDS  
// _____________________________________________________________________________________
function countTaskeds () {
    $numOfTaskeds = R::count( 'tasked' );
    return $numOfTaskeds; 
}


// ___________________________________________________________________________________________________
//GET ALL ASSIGNED TASKS, USERS AND GROUPS 
// ___________________________________________________________________________________________________
function getTaskeds() {
    // $taskeds = R::findAll('tasked' , 'WHERE user_id IS NOT NULL ORDER BY title ASC'); // ASC | DESC
    $vacations = R::getAll("SELECT `tasked`.`id`, `tasked`.`start`, `tasked`.`user_id` AS tasked_user, `tasked`.`task_id`, 
    `user`.`name` AS user_name, email, `user`.`weekdays` AS user_weekdays, `group`.`name` AS group_name ,`group`.`libelle` AS group_liebelle, `tasked`.`contacted`  
    FROM `tasked` 
    INNER JOIN `user` ON `tasked`.`user_id` = `user`.`id` 
    INNER JOIN `group` ON  `user`.`group_id` = `group`.`id` 
    WHERE `tasked`.`user_id` IS NOT NULL 
    ORDER BY `tasked`.`id` ASC"); // ASC | DESC
    return $vacations;
}


// ___________________________________________________________________________________________________
//GET TASK NAME BY TASK ID GIVEN IN PARAMETER
// ___________________________________________________________________________________________________
function getTaskName($task_id) {
    $task  = R::findOne( 'task', 'id=?', [$task_id] ); 
    return $task; 
}
    
// ___________________________________________________________________________________________________
// DELETE TASKED BY TASKED_ID GIVEN IN PARAMETER
// ___________________________________________________________________________________________________
function deleteTasked($id) {
    $tasked = R::load( 'tasked', $id ); 
    R::trash( $tasked );
}

/* 
function deleteTasked($id) {
    $tasked = R::load('taskeds', $id); 
    if ($tasked->id == 0) {
        echo "Task not found!";
        return;
    }
    R::trash($tasked);
}

*/ 
//________________________________________________________
// INSERT INTO TABLE ADMIN A NEW ADMIN (ROW)
//________________________________________________________
function createTasked ($start_date, $task_id, $user_id) {
    $tasked = R::dispense( 'tasked' );
    $tasked->user = R::load( 'user', $user_id );
    $tasked->start = $start_date;
    $tasked->task_id = $task_id;
    $tasked->user_id = $tasked->user->id;
    $tasked->title = $tasked->user->name; 
    $tasked->contacted = "NO";

    return R::store( $tasked );
}



// ____________________________________________________________________________________________
// UPDATE TASKED 
// _____________________________________________________________________________________________
function updateTasked ($id, $start, $user_id, $task_id, $contacted) {
    $tasked = R::load( 'tasked', $id );
    $tasked->task_id = $task_id;
    $tasked->start = $start;
    $tasked->contacted = $contacted;

    $tasked->user_id = $user_id;
    $user = R::load( 'user', $user_id );
    $tasked->title = $user->name;
 
    // echo "<h1> Ttasked: ".$id.", task: ".$tasked->task_id.", user: ".$tasked->user_id."</h1>"; die(); 
    R::store( $tasked );
}

