<?php

$global_users = array(); 
$indice = 0; 

// _____________________________________________________________________________________
// COUNTING NUMBER OF TASKS IN THE DATABASE   
// _____________________________________________________________________________________
function countTasks() {
    $numOfTasks= R::count( 'task');
    return $numOfTasks; 
}

// _____________________________________________________________________________________
// COUNTING NUMBER OF USERS IN THE DATABASE   
// _____________________________________________________________________________________
function countAllUsers() {
    $numOfUsers= R::count( 'user');
    return $numOfUsers; 
}

// _____________________________________________________________________________________
// INSERT  an task INTO TABLE "task" (DATABASE)  
// _____________________________________________________________________________________
function createTask ($name, $color, $weekdays, $group_ids, $label) {
    $task = R::dispense( 'task' );

    $task->name = $name;
    $task->libelle = $label; 
    $task->weekdays = json_encode($weekdays);
    $task->color = $color;

    foreach ($group_ids as $id) {
        $group = R::load('group', $id);
        $task->sharedGroupList[] = $group;
    }

    R::store($task);
}

// _____________________________________________________________________________________
// UPDATES an task FROM TABLE "task" (DATABASE)  
// _____________________________________________________________________________________
function updateTask ($id, $name, $color, $weekdays, $group_ids, $label) {
    $task = R::load('task', $id);

    $task->name = $name;
    $task->libelle = $label;
    $task->weekdays = json_encode($weekdays);
    $task->color = $color;

    $tasks = R::find('group_task', 'task_id = ' . $id);
    foreach($tasks as $t) {
        R::trash($t);
    }

    foreach ($group_ids as $id) {
        $group = R::load('group', $id);
        $task->sharedGroupList[] = $group;
    }

    R::store($task);
}

// _____________________________________________________________________________________
// DELETE an task BY ITS ID (FROM THE "task" DATABASE TABLE) 

// _____________________________________________________________________________________
function deleteTask($id) {
    $task = R::load( 'task', $id ); 
    foreach($task->ownTaskedList as $tasked){
        R::trash($tasked);
    }
    R::trash($task);
}


// H. BAYTAR 

// _____________________________________________________________________________________
// GET ALL GROUP_TASK ROWS BY THE GIVEN TASK ID 
// _____________________________________________________________________________________
function getGroupTasksByTaskId($task_id) {
    $groupTasks = R::getAll("SELECT * FROM `group_task` WHERE `task_id` =?",[$task_id]); 
    return $groupTasks;
}


// _____________________________________________________________________________________
// FIND COMPATIBLE USERS LIST 
// _____________________________________________________________________________________
function findCompatibleUsers($users, $weekday) {

    $i = 0; 
    $compatible_users = array();

    // var_dump($users ); die() ; 
	if(!empty($users)) {

		foreach ($users as $user) { // FOR EACH USER 

            $work_day = false; // USER'S WORKDAY (BOOLEAN)
			$user_id = $user['user_id']; // GET USER ID 
			$user_weekdays = json_decode($user['weekdays']);  // GET USER WEEKDAYS  

			if(!empty($user_weekdays) && in_array($weekday, $user_weekdays)) {
				$work_day = true; // USER IS AVAILIBLE  
			}else{
				$work_day = false; // USER IS NOT AVAILIBLE  
			}

            if($work_day == true){
                $compatible_users += [$i  => $user]; // ADD USER TO ARRAY    
                $i ++; 
            }

        }// FOREACH 1


        foreach ($compatible_users as $key_user => $val_user) {// FOR EACH USER 

			$user_id = $val_user['user_id']; // GET USER ID 
            $user_available = false; // USER HAS NO VACATION (USER FOUNDED)  
        
			$vacations = getUserVacations($user_id); // USER CAN HAVE MANY VACATIONS !     

			foreach($vacations as $vacation){

				// IF VACATION EXISTS (START & END DATE NOT NULL )
				if(!empty($vacation)){

                    $start_date = (new DateTime($vacation['start']))->format("Y-m-d"); 
                    $end_date = (new DateTime($vacation['end']))->format("Y-m-d"); 
                    $today = date('Y-m-d'); // echo $currentDate."<br>";

                    $checkdate = (($start_date < $today )  && ($end_date > $today )) ; // BOOLEAN                  
                    if($checkdate == true){
                        unset($compatible_users[$key_user]);// REMOVE USER 
                    }                    
				}

            }// FOREACH USERS AS USER 

        }// FOREACH 2 

	}// USERS ARRAY NOT EMPTY  

    //________________________________________
    // RETURN USERS LIST 
    //________________________________________               
    // echo "Users : <br>"; var_dump($compatible_users ); echo "<br><br>";    // die(); 
	return $compatible_users; 
}// END FUNCTION 


// ___________________________________________________________________________________________________
// Attributes tasks to users between the given dates ($from, $to)
// ___________________________________________________________________________________________________
function generateTasks($from, $to){
     global $global_users;    
    global $indice ; 
    $indice = 0;     

    $tasked = R::findAll( 'tasked' ); 
    foreach ($tasked as $t) { R::trash($t); }// RESET TABLE "Tasked" (REMOVE ALL OCCURENCES)
    R::exec( "ALTER TABLE `tasked` AUTO_INCREMENT=1" );  // RESET AUTO INCREMENT PRIMYARY KEY VALUE 

    $tasks = getTasks() ; // GET ALL TASKS WITH THEIR GROUP AND USERS
    $today =  new DateTime($from->format('c')); // ISO 8601 date | Example returned values : 2004-02-12T15:19:21+00:00 

    while($today <=  $to){
        $weekday = $today->format('l'); // PROCESSING DAY 

        // FOR ALL TASKS IN THE DATABSE "TASK" TABLE 
        foreach ($tasks as $task) {

            $compatible_users = (array) null;
            $users  = (array) null;
            // _________________________________________________
            // IF TASK EXISTT 
            // _________________________________________________
            if(!empty($task)){ 

                $task_name = $task['name']; // GET TASK NAME   
                $task_id = $task['id']; // GET TASK ID     
                $group_tasks = getGroupTasksByTaskId($task_id); // GET GROUP OF TASK (RANDOM ) 
                $weekdays_task = $task['weekdays'];  // GET CURRENT TASK WEEKDAYS     
                $task_weekdays = json_decode($weekdays_task);      

                // __________________________________________________________________________________________________
                // IF CURRENT_ DAY IS IN THE "TASK WEEKDAYS" ARRAY -> [Wednesday | Friday, Tuesday, Monday, Thursday]
                // __________________________________________________________________________________________________
                if (in_array($today->format('l'), $task_weekdays)) { 

                    // _______________________________________________________
                    // IF TASK IS CAFETERIA 
                    // ALL USERS ALL RESPONSIBLE EXCEPT NON AFFECTED USERS (group_id = 1) 
                    // _______________________________________________________
                    if(strcmp($task['libelle'], "Cafe/ALL") < 1){            
                         $groupe_id = 1; 
                         $users = getAllUsers($groupe_id); // GET ALL USER OF ALL GROUP EXCEPT NO AFECTED USERS GROUP   
                    } else{
                        // _____________________________________________________
                        // TASK IS NOT CAFETERIA 
                        // ALL GROUP ARE NOT RESPONSIBLE FOR THE TASK
                        // _______________________________________________________
                        if (!empty($group_tasks)) {
                            $random_groupkey = array_rand($group_tasks); // RADOM KEY 
                            $val_randomGroupTask = $group_tasks[$random_groupkey]; // VALUE OF RADOM KEY 
                            $group_id = $val_randomGroupTask['group_id'];    
                            $users = getUsersByGroup($group_id, $task_id); // FOREACH TASK GET USERS OF THE GIVEN GROUP GET USER_LIST                                                        
                        }
                    }

                    // ____________________________________________
                    // USERS PROCESSING/TREATMENT 
                    // USER WEEKDAYS SHOULD BE TRUE && USER VACATIONS SHOULD BE FALSE 
                    // ____________________________________________
                    $compatible_users = findCompatibleUsers($users, $weekday); 

                    // _____________________________________________________________________
                    // INSERT INTO TABLE TASKED (DATABASE) --> ASSIGN USER TO TASK 
                    // _____________________________________________________________________
                    if (!empty($compatible_users)) {

                        // Vérifier si $global_users est vide
                        if (empty($global_users)) {
                            $selected_user = $compatible_users[array_rand($compatible_users)]; // Si $global_users est vide, sélectionner au hasard un élément de $compatible_users
                        } else {
                            // Filtrer $compatible_users pour exclure les utilisateurs présents dans $global_users
                            $filtered_users = array_filter($compatible_users, function($user) use ($global_users) {
                                foreach ($global_users as $global_user) {
                                    if ($user['user_id'] == $global_user['user_id']) {
                                        return false; // Exclure cet utilisateur
                                    }
                                }
                                return true; // Garder cet utilisateur
                            });

                            // Sélectionner un élément au hasard parmi les utilisateurs filtrés
                            if (!empty($filtered_users)) {
                                $selected_user = $filtered_users[array_rand($filtered_users)];
                            } else {
                                // Si aucun utilisateur compatible, définir $selected_user au hasard
                                $selected_user = $compatible_users[array_rand($compatible_users)];
                            }
                        }

                        /* 
                            // Afficher l'utilisateur sélectionné ou un message si aucun n'a été trouvé
                            if ($selected_user) {
                                echo "User ID: " . $selected_user["user_id"] . "<br>";
                                echo "Name: " . $selected_user["name"] . "<br>";
                                echo "Email: " . $selected_user["email"] . "<br>";

                            } else { echo "Aucun utilisateur compatible n'a été trouvé.";}
                        */ 

                        if ($selected_user && !in_array($selected_user, $global_users)) {
                            // _______________________________________________
                            // CREATE TASKED  
                            // _______________________________________________  
                            $tasked = R::dispense( 'tasked' ); // LOAD TABLE OCCURENCE
                            $tasked->title = $selected_user['name']; 
                            $tasked->start = $today;                        
                            $tasked->user_id =  $selected_user['user_id'];
                            $tasked->task_id = $task['id'];
                            $tasked->contacted = "NO"; 
                            R::store($tasked);  // INSERT TASKED INTO DATABASE 

                            $global_users[] = $selected_user;  // ADD USER TO GLOBAL ARRAY          

                        } else {
                            echo "Aucun utilisateur compatible n'a été trouvé.";
                        }
                    }
                }// IF $today (CURRENT DAY BEING PROCESSING/TREATMENT) 
            }// TASK NOT EMPTY  

           if(count($global_users) > 26){ $global_users = (array) null;}
            $compatible_users  = (array) null;
            $users  = (array) null;          

        }// FOREACH TASK 
              
        date_add($today, date_interval_create_from_date_string('1 day')); // SELECET DAY IS CURRENT DAY + 1 

    } // WHILE() 

} // END FUNCTION 


// ___________________________________________________________________________________________________
//GET ALL USER VACATIONS
// ___________________________________________________________________________________________________
function getUserVacations($user_id){
    $user = R::getAll("SELECT * FROM vacation  WHERE user_id = ?",  [$user_id, ]);
    return $user; 
}


// _____________________________________________________________________________________
// FIND ALL TASKS AND RETURN AN ARRAY OF REDBEANPHP OBJECTS 
// _____________________________________________________________________________________
function getTasks() {
    return R::findAll( 'task' );
}

// ___________________________________________________________________________________________________
// RETURN AN AVAILABLE USER 
// TAKES A LIST OF USERS AND THE DAY (OF THE TASK) AS PARAMETERS 
// ___________________________________________________________________________________________________
function getAvailableUser($users, $weekday) {
    $AvailableUser = [];
    foreach ($users as $user) {
        if(! empty($user->weekdays)){
            $weekdays = json_decode($user->weekdays);
        }
      
        //  if(! empty($weekdays)) {
        if(! empty($weekdays)) {
            if(in_array($weekday, $weekdays)) {
                $AvailableUser[] = $user;
            }
        }
    }
    return $AvailableUser;
}

// ___________________________________________________________________________________________________
// RETURN AN USER WITHOUT VACATION 
// TAKES A LIST OF USERS AND THE DAY (OF THE TASK) AS PARAMETERS 
// ___________________________________________________________________________________________________
function getUserWithoutVacation ($users, $date) {
    $AvailableUser = [];
    for($i = 0; $i < count($users); $i++){

        $add = true;
        foreach($users[$i]->ownVacationList as $vacation){
            $checkdate = (new DateTime($vacation->start)) < $date && (new DateTime($vacation->end)) > $date; // true OR false 
            
            if($checkdate) { $add = false;}// VACATION == true THEN USER NOT AVAILABLE 
        }
        // $add == true 
        if($add) {
            $AvailableUser[] = $users[$i];
        }
    }
    return $AvailableUser ;
}

// ___________________________________________________________________________________________________
// GET ALL USERS BY THE GIVEN GROUP ID AND TASK ID
// ___________________________________________________________________________________________________

function getUsersByGroup($group_id, $task_id){
    $group = R::getAll("SELECT `user`.`id` AS user_id, `name`, `email`, `user`.`group_id` AS user_groupId, `weekdays`, `group_task`.`id` AS groupTask_id, 
    `group_task`.group_id AS groupTask_groupId, `group_task`.`task_id` AS groupTask_taskId 
    FROM user 
    INNER JOIN  `group_task` ON `group_task`.`group_id` =  `user`.`group_id` 
    WHERE `user`.`group_id`= ? AND   `group_task`.`task_id` = ?
    ORDER BY `user`.`id`  ASC",  [$group_id,  $task_id,]); 
    return $group; 
}


// ___________________________________________________________________________________________________
// RETURN AN USER WITHOUT VACATION 
// TAKES A LIST OF USERS AND THE DAY (OF THE TASK) AS PARAMETERS 
// ___________________________________________________________________________________________________
function getAllUsers($task_group) {

    $users = R::getAll("SELECT `user`.`id` AS user_id, `name`, `email`, `user`.`group_id` AS user_groupId, `weekdays` 
    FROM user 
    WHERE `user`.`group_id` != ?
    ORDER BY `user`.`id`  ASC" ,  [$task_group, ]);

    return $users;
}


// ___________________________________________________________________________________________________
// CHANGES THE CURRENT HOLDER/USER OF A TASK 
// TAKES THE ASSIGNEMENT "ID" TO BE CHANGED AS PARAMETERS 
// ___________________________________________________________________________________________________
function randomPersonForTask ($tasked_id) {
    $tasked = R::load('tasked', $tasked_id);
    $users = [];
    foreach ($tasked->task->sharedGroup as $group) {
        $users = array_merge($users, $group->ownUserList);
    }
    $users = getAvailableUser($users, (new DateTime($tasked->date))->format('l'));
    $users = getUserWithoutVacation($users, $tasked->date);

	$random_userkey = array_rand($users); // RADOM KEY 
	$val_randomUser = $users[$random_userkey]; // VALUE OF RADOM KEY 
    $user = $val_randomUser; 
    $tasked->title = $user->name; 
    $tasked->user =  $user;
    R::store($tasked);
    return $tasked;
}

// ___________________________________________________________________________________________________
// CHANGES THE CURRENT HOLDER/USER OF A TASK 
// TAKES THE ASSIGNEMENT "ID" TO BE CHANGED AND THE NEW USER AS PARAMETERS 
// ___________________________________________________________________________________________________
function changePersonForTask ($tasked_id, $user) {
    $tasked = R::load('tasked', $tasked_id);
    $user = R::load('user', $user);
    $tasked->title = $user->name; 
    $tasked->user =  $user;
    R::store($tasked);
    return $tasked;
}

// ___________________________________________________________________________________________________
// FORMAT THE TASKEDS TO BE DISPLAY IN FULL CALLENDAR  
// ALL TASKEDS WILL BE DISPLAY WITH AN URL TO MANAGE THE SICK SITUATION (WITH INVALID SITUATION) 
// RETURN ALL ASSIGNED TASKS (REDBEANPHP OBJECTS) 
// ___________________________________________________________________________________________________
function getTaskedAdmin() {
    $taskeds = R::findAll( 'tasked' );
    $array = [];

    foreach ($taskeds as $tasked) {

        $group_name = $tasked->user->group->name;
        $task['group_label'] = substr($group_name, 0, 3);
        // $task['title'] = $tasked->title." ".strtoupper($task['group_label']);
        $task['title'] = $tasked->title;        

        $task['start'] = $tasked->start;
        $task['backgroundColor'] = $tasked->task->color;
        $task['borderColor'] = $tasked->task->color;
        $task['allDay'] = true;
        $task['url'] = '/admin/sick.php?tasked_id=' . $tasked->id; 

        $array[] = $task;
    }
    return $array;
}

// ___________________________________________________________________________________________________
// FORMAT THE TASKEDS TO BE DISPLAY FOR EVERYONE (WITHOUT URL TO MANAGE SICK SITUATION)
// RETURN ALL ASSIGNED TASKS (REDBEANPHP OBJECTS) 
// ___________________________________________________________________________________________________
function getTasked() {
    $taskeds = R::findAll( 'tasked' );
    $array = [];

    foreach ($taskeds as $tasked) {

        $task['start'] = $tasked->start;
        $task['backgroundColor'] = $tasked->task->color;
        $task['borderColor'] = $tasked->task->color;
        $task['allDay'] = true;

        $group_name = $tasked->user->group->name;
        $task['group_label'] = substr($group_name, 0, 3);
        // $task['title'] = $tasked->title." ".strtoupper($task['group_label']);
        $task['title'] = $tasked->title;

        $array[] = $task;
    }
    return $array;
}



// ___________________________________________________________________________________________________
// // USED IN FILe ModalTask (Button Update in http://localhost/html/admin/task.php)
// TO DISPLAY HTML CHECKED LIST 
// ___________________________________________________________________________________________________

function checkRelation ($group, $groupList){
    $result = false;

    foreach ($groupList as $g) {
        if($group->id == $g->id) {
            $result = true;
        }
    }

    return $result;
}


