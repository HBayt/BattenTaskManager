<?php
// H. BAYTAR 


// MYSQL Requests 
$dbTasks = getTasks() ; 

$dbGroups = getGroups(); 
$dbUsers = getUsers(); 

// Processing users & tasks lists 
$globalUsersByGroups = array(); 
$globalTasks = array(); 

$tab_freeUsers = array(); // INSERTION ---> $data[$key] = $value; / array_push( $data, $value);   
$tab_affectedUsers = array(); 
$tab_recordableUsers = array();  

$globalManyGroupsOneTask_users = array(); 
$globalOneGroupOneTask_users = array(); 


// _____________________________________________________________________________________
// FIND ALL 'TASKS / GROUPS / USERS' AND RETURN AN ARRAY OF REDBEANPHP OBJECTS 
// _____________________________________________________________________________________
function getTasks() {
    return R::findAll( 'task' );
}


function getGroups() {
    return R::findAll( 'group' );
}


function getUsers() {
    return R::findAll( 'user' );
}

// _____________________________________________________________________________________
// Get user Vacation by user_id 
// _____________________________________________________________________________________
function getUserVacation($user_id){
    return R::getAll("SELECT * FROM vacation  WHERE user_id = ?",  [$user_id, ]);
} // $user = getUserVacation($user_id); 


// _____________________________________________________________________________________
// COUNTING NUMBER OF TASKS IN THE DATABASE   
// _____________________________________________________________________________________
function countTasks() {
    return R::count( 'task');
}//  $numOfTasks = countTasks(); 


// _____________________________________________________________________________________
// GET all tasks from mysql db table by the given group_id  
// _____________________________________________________________________________________
function getTasksByGroupId($group_id) {
    $listTasks = R::getAll("SELECT 
        `task`.`id` AS task_id, `task`.`weekdays` AS task_weekdays, `task`.`name` AS task_name, `task`.`libelle` AS task_libelle,
        `group_task`.`id` AS groupTask_id, `group_task`.`group_id` AS groupTask_groupId, `group_task`.`task_id` AS groupTask_taskId,        
        `group`.`id` AS group_id, `group`.`name` AS group_name, `group`.`libelle` AS group_libelle 
            FROM `task`  
            INNER JOIN  `group_task` ON `group_task`.`task_id` =   `task`.`id`
            INNER JOIN  `group` ON `group`.`id` =  `group_task`.`group_id` 
            WHERE `group`.`id` =?",[$group_id]); 
    return $listTasks;
}//  $listTasks = getTasksByGroupId($group_id) 


// _____________________________________________________________________________________
// GET all tasks from mysql db table by the given group_id  
// _____________________________________________________________________________________
function getGroupssByTaskId($task_id) {
    $listTasks= R::getAll("SELECT 
        `group`.`id` AS group_id, `group`.`name` AS group_name, `group`.`libelle` AS group_libelle, 
        `group_task`.`id` AS groupTask_id, `group_task`.`group_id` AS groupTask_groupId, `group_task`.`task_id` AS groupTask_taskId,             
        `task`.`id` AS task_id, `task`.`weekdays` AS task_weekdays, `task`.`name` AS task_name, `task`.`libelle` AS task_libelle
    FROM `group`  
    INNER JOIN  `group_task` ON `group_task`.`group_id` =   `group`.`id`
    INNER JOIN  `task` ON `task`.`id` =  `group_task`.`task_id` 
    WHERE `task`.`id` =?",[$task_id]); 
    return $listTasks;
}

// _____________________________________________________________________________________
// GET GROUP BY ITS ID   
// _____________________________________________________________________________________
function getGroupById($id) {
    return R::load( 'group', $id); 
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


// _____________________________________________________________________________________
// 
// _____________________________________________________________________________________
function CalculateGroupTasks($task_id){
    // R::count("company", "country like ?", ["United States"]); 
    // R::count("company", "country like :name OR city like :name", [":name" => "United States"]);

    $numOfGroupsInTask = R::count( "group_task", "task_id like ?", [$task_id]);
    return $numOfGroupsInTask;
}


// _____________________________________________________________________________________
// 
// _____________________________________________________________________________________
// Removes duplicate values from an array
function createUniqueArray($array, $unique_sValue) {
    $unique_array = [];
    foreach($array as $element) {
        $hash = $element[$unique_sValue];
        $unique_array[$hash] = $element;
    }

     $result  = array_values($unique_array);// Unique values 
    // foreach($result as $t){ echo $t['task_libelle']."<br>"; }
    return $result;    

} // createUniqueArray($GLOBALS['globalTasks'])




// _____________________________________________________________________________________
// CREATE AN GLOBAL ARRAY FOR REGISTERED USERS --> RETURN $tab_affectedUsers 
// _____________________________________________________________________________________
function createArrayForAffectedUsers(){

    global $dbUsers;    
    $users = $dbUsers;   

    global $dbGroups;  
    $groups = $dbGroups; 

    global $tab_recordableUsers; 
    global $tab_affectedUsers;

    global $num_users; 

    foreach($groups as $group){

        $today = new DateTime(); // $today = $from->format("Y-m-d");  
        $lastDay =  new DateTime();  // $lastDay = $to->format("Y-m-d"); 
        date_add($lastDay, date_interval_create_from_date_string('6 days'));   // echo "Jour J + 6d ---> ".$lastDay->format('l, d. M , G.i'). "<br><br>";           

		if(!empty($group)){
            // echo "Id: ".$group->id."<br>"; 

            while($today <=  $lastDay){
                $todayL = $today->format('l'); // PROCESSING WEEKDAYS [Monday, Thursday, Wednesday, Tuesday, Friday, Saturday, Sunday]  

                $tab_recordableUsers = array(); // INSERTION ---> $data[$key] = $value; / array_push( $data, $value);   
 
                $tab_recordableUsers["group_label"] = $group->libelle;     
                // $tab_recordableUsers["group_id"] = $group->id;

                $tab_recordableUsers["work_day"] = $todayL;  
                $tab_recordableUsers["task_label"] = "";   

                $users = array(); 
                $tab_recordableUsers["group_users"] = $users ; 

                $num_users = 0; 
                $tab_recordableUsers["num_users"] = $num_users;  // $GLOBALS['tab_affectedUsers']["num_users"]         

                array_push( $GLOBALS['tab_affectedUsers'], $tab_recordableUsers);      
      
                // echo "jourJ ---> ".$today->format('l, d. M , G.i'). "<br>";   // jourJ ---> Wednesday, 18. Sep , 11.35
                date_add($today, date_interval_create_from_date_string('1 day')); // CREATE NEXT DAY 
            }

        }

    }// FOR EACH GROUP 
    return $GLOBALS['tab_affectedUsers']; 

}

// _____________________________________________________________________________________
// CREATE A GLOBAL ARRAY OF FREE USERS --> RETURN $tab_freeUsers 
// _____________________________________________________________________________________
function getFreeUsersArray(){

    global $dbUsers;    
    $users = $dbUsers;   

    global $dbGroups;  
    $groups = $dbGroups; 

    global $tab_recordableUsers; 
    global $tab_freeUsers;

    foreach($groups as $group){

        $today = new DateTime(); // $today = $from->format("Y-m-d");  
        $lastDay =  new DateTime();  // $lastDay = $to->format("Y-m-d"); 
        date_add($lastDay, date_interval_create_from_date_string('6 days'));   // echo "Jour J + 6d ---> ".$lastDay->format('l, d. M , G.i'). "<br><br>";           

		if(!empty($group)){
            // echo "Id: ".$group->id."<br>"; 

            while($today <=  $lastDay){

                // PROCESSING WEEKDAYS [Monday, Thursday, Wednesday, Tuesday, Friday, Saturday, Sunday] 
                $todayL = $today->format('l'); // PROCESSING DAY [Monday, Thursday, Wednesday, Tuesday, Friday]      

                $group_users = getUsersByGroups($group->id, $today); 
                if(!empty($group_users)){
                    $tab_recordableUsers = array(); // INSERTION ---> $data[$key] = $value; / array_push( $data, $value);   

                    $tab_recordableUsers["work_day"] = $todayL;   
                    $tab_recordableUsers["group_label"] = $group->libelle;     
                    $tab_recordableUsers["group_id"] = $group->id; 
                    $tab_recordableUsers["num_users"] = count($group_users); 
                    $tab_recordableUsers["group_users"] = $group_users; 

                    array_push( $GLOBALS['tab_freeUsers'], $tab_recordableUsers);      
                }

                // echo "jourJ ---> ".$today->format('l, d. M , G.i'). "<br>";   // jourJ ---> Wednesday, 18. Sep , 11.35
                date_add($today, date_interval_create_from_date_string('1 day')); // CREATE NEXT DAY 
            }

        }
    }// FOR EACH GROUP 
    return $GLOBALS['tab_freeUsers']; 

}

// _____________________________________________________________________________________
// get users of a group by group_id for a given day 
// _____________________________________________________________________________________
function getUsersByGroups($group_id, $dayD){
         
    $dayL = $dayD->format('l'); 

    global $dbGroups; 
    global $dbUsers;    
    $groups = $dbGroups; 
    $users = $dbUsers; 
    $group_users = array(); 

	foreach($groups as $group){
		if(!empty($group)){
			foreach($users as $user){
				if (!empty($user) && $user->group_id == $group->id && $user->group_id == $group_id) { 
                    // echo "".$user['name']."<br>"; 

                    $userWeekdays = null; 
                    $user_iscompatible = true; 
                    $userWeekdays = json_decode($user->weekdays); 

                    // if(!empty($userWeekdays) && in_array('Monday', $userWeekdays) ){ 
					if(!empty($userWeekdays) && in_array($dayL, $userWeekdays) ){

                        $vacations = getUserVacation($user->id); // USER CAN HAVE MANY VACATIONS ! 
						foreach($vacations as $vacation){

                            // IF VACATION EXISTS (START & END DATE NOT NULL )
							if(!empty($vacation)){
                    
                                $start_date = (new DateTime($vacation['start']))->format("Y-m-d"); 
                                $end_date = (new DateTime($vacation['end']))->format("Y-m-d"); 
                    
                                $user_hasvaction = (($start_date < $dayD->format("Y-m-d")) && ($end_date > $dayD->format("Y-m-d") )) ; // BOOLEAN  
                                if($user_hasvaction == true){
									$user_iscompatible = false ; 
								}
							}
						}// END $vacations control 

                        // user has no vacation & is working on this day 
						if($user_iscompatible == true){
                            array_push( $GLOBALS['globalUsersByGroups'], $user);
                            array_push( $group_users, $user);
							}
						}// END $userWeekdays control 
				}// END user->group_id = group->id 
			}// FOREACH $users 
		}// $group NOT EMPTY 
	}// FOREACH $groups 

    $GLOBALS['globalUsersByGroups']  = createUniqueArray($GLOBALS['globalUsersByGroups'] , 'name'); // To remove duplicate user(s)
    shuffle($GLOBALS['globalUsersByGroups']); 

    // ECHO user's name for test : 
    // foreach($GLOBALS['globalUsersByGroups'] as $u){ echo $u['name']."<br>"; }
	return  $group_users; 
	
}// END getUsersByGroups() 






// _____________________________________________________________________________________
// GET all tasks from mysql db table AND added them to a GLOBAL ARRAY 
// _____________________________________________________________________________________
function getTasksByGroups($dbGroups, $dDay){ 
    $dayL = $dDay->format('l'); 
    foreach($dbGroups as $group){
        $group_id = $group->id; 
        $listTaks = getTasksByGroupId($group_id); 

        foreach($listTaks as $task){
            // control compatible day L 
            $task_weekdays = $task['task_weekdays']; // GET CURRENT TASK WEEKDAYS     
            $task_weekdays = json_decode($task_weekdays);   

            // week is compatible 
            if(!empty($task_weekdays) && in_array($dayL, $task_weekdays)){
                array_push( $GLOBALS['globalTasks'], $task);
            }
        }        
    }
    
    $GLOBALS['globalTasks']  = createUniqueArray($GLOBALS['globalTasks'] , 'task_libelle'); 
    // foreach($GLOBALS['globalTasks'] as $t){ echo $t['task_libelle']."<br>"; }
    // shuffle($GLOBALS['globalTasks']); 
}




// _______________________________________________
// INSERT tasked row INTO TABLE tasked   
// _______________________________________________  
function saveTasked($today, $task, $anUser, $numOfGroupsInTask){
    $saved = false; 
    global $globalOneGroupOneTask_users; 

    try {
        $tasked = R::dispense( 'tasked' ); // Load table occurence 
        $tasked->title = $anUser['name']; 
        $tasked->start = $today;                        
        $tasked->user_id =  $anUser['id'];
        $tasked->task_id = $task['task_id'];
        $tasked->contacted = "NO"; 
        R::store($tasked);  // Insert tasked row into DB 
        $saved = true; 
        // echo "Tasked saved <br>"; 

        if($numOfGroupsInTask == 1){
            // INSERTION ---> $data[$key] = $value; / array_push( $data, $value);   
            array_push($GLOBALS['globalOneGroupOneTask_users'], $anUser); // Add user to the affected array      

        }elseif($numOfGroupsInTask > 1){
            // Add user to the affected array  
            array_push($GLOBALS['globalOneGroupOneTask_users'], $anUser);    
            array_push($GLOBALS['globalManyGroupsOneTask_users'], $anUser); 
        }

    }catch (Exception $e) {
        echo 'Tasked could not be inserted into DB MySQL <br>'; 
        echo $e->getMessage();
    }

    return  $saved;
}


// _____________________________________________________________________________________
// Generate / affect tasks to users 
// _____________________________________________________________________________________
function generateUsersTasks($today, $lastDay){

    global $globalOneGroupOneTask_users; 
    global $globalManyGroupsOneTask_users; 

    // get datas from MySql DB 
    global $dbGroups; 
    $groups = $dbGroups; 


    // to save user on tab_affectedUsers 
    global $aUser; 
    global $num_users;

    // echo '<span style="color:blue;">'."xxx"." valeurs <br>".'</span>';  

    // DELETE ALL ROWS FROM THE TABLE 'TASKED'(REMOVE ALL OCCURENCES)
    $tasked = R::findAll( 'tasked' ); 
    foreach ($tasked as $t) { R::trash($t); }
    R::exec( "ALTER TABLE `tasked` AUTO_INCREMENT=1" );  // RESET AUTO INCREMENT PRIMYARY KEY VALUE 



    // CREATE AN ARRAY OF REGISTERED USERS SORTED INTO GROUPS AND TASK WEEKDAYS  
     $GLOBALS['tab_affectedUsers'] = createArrayForAffectedUsers(); 

    // CREATE AN ARRAY OF AVAILABLE USERS SORTED INTO GROUPS AND THEIR WEEKDAYS  
    $GLOBALS['tab_freeUsers'] = getFreeUsersArray(); 

    while($today <=  $lastDay){

        // Formats date $today  
        $dDay = $today->format('Y.m.d'); // 2024.12.31 
        $todayC =  new DateTime($today->format('c')); // ISO 8601 date | Ex. returned values : 2004-02-12T15:19:21+00:00 
        $todayL = $today->format('l'); // PROCESSING DAY [Monday, Thursday, Wednesday, Tuesday, Friday]     
 
        getTasksByGroups($dbGroups, $todayC); // $GLOBALS['globalTasks'] 

        foreach($GLOBALS['globalTasks'] as $aTask){

            $weekdays_task = $aTask['task_weekdays'];  // GET CURRENT TASK WEEKDAYS     
            $task_weekdays = json_decode($weekdays_task);      

            $numOfGroupsInTask = CalculateGroupTasks($aTask['task_id']); 

            //_______________________________________________________________________________        
            // MANY GROUPS FOR ONE TASK
            //_______________________________________________________________________________
            if($numOfGroupsInTask > 1){
                // do something else 
                // echo "task_label : ".$aTask['task_libelle'].", howMany groups >= ".$numOfGroupsInTask ."<br>"; 

                $listGroups = getGroupssByTaskId($aTask['task_id']); 
                // $GLOBALS['globalUsersByGroups'] = array(); // ou unset($GLOBALS['globalUsersByGroups']);   
                foreach($listGroups as $lg){
                    // echo "group : ".$lg['group_libelle']."<br>"; 
                    getUsersByGroups($lg['group_id'], $todayC);  // $GLOBALS['globalUsersByGroups'] 
                }
        
                $generated = false; 
                shuffle($GLOBALS['globalUsersByGroups']); 
                shuffle($GLOBALS['globalUsersByGroups']);  // foreach($GLOBALS['globalUsersByGroups'] as $aUser){
                while($generated == false){

                    $randomKey = array_rand($GLOBALS['globalUsersByGroups']);// Utiliser array_rand pour obtenir une clé aléatoire
                    $aUser = $GLOBALS['globalUsersByGroups'][$randomKey];
                    // echo '<span style="color:blue;">'."--- rand : ".$aUser['name']."/ task : ".$aTask["task_libelle"]." / day : ".$dDay."<br>".'</span>';   

                    if(
                        (empty($GLOBALS['globalManyGroupsOneTask_users'])|| !in_array($aUser, $GLOBALS['globalManyGroupsOneTask_users']) )
                         && !in_array($aUser, $GLOBALS['globalOneGroupOneTask_users'])
                        ){   
                
                        $generated = saveTasked($dDay, $aTask, $aUser, $numOfGroupsInTask );  
                        $generated = true; 
                        // echo '<span style="color:brown;">'."Tasked generated ---> task : ".$aTask["task_libelle"]." / user : ".$aUser['name']." / day : ".$dDay."<br>".'</span>';
                    }
                } 
            }

            //_______________________________________________________________________________
            // ONE GROUP FOR ONE TASK 
            //_______________________________________________________________________________  
            if($numOfGroupsInTask == 1){
                // $index = 0; 
                $group = getGroupById($aTask['groupTask_groupId']); 
                $group_libelle = $group['libelle']; 
                $group_id = $group['id']; 
    
                // for each available users array of current group 
                foreach ($GLOBALS['tab_freeUsers'] as $freeUsersTab){

                    $num_freeUsers = $freeUsersTab['num_users']; 
                    if($group_libelle == $freeUsersTab["group_label"] &&  $todayL == $freeUsersTab["work_day"]){

                        // __________________________________________________________________________________________
                        // WHILE LOOP                             
                        // while task/user not created and inserted into DB 
                        // __________________________________________________________________________________________      
                        $generated = false;   
                                
                        while($generated == false){

                            $randomKey = array_rand($freeUsersTab["group_users"]);// Utiliser array_rand pour obtenir une clé aléatoire
                            $aUser = $freeUsersTab["group_users"][$randomKey];

                            // Utiliser une boucle `for` pour manipuler directement les éléments
                            for ($i = 0; $i < count($GLOBALS['tab_affectedUsers']); $i++) {

                                if ($GLOBALS['tab_affectedUsers'][$i]["num_users"] == $num_freeUsers) {
                                    $GLOBALS['tab_affectedUsers'][$i]["group_users"] = array();
                                    $GLOBALS['tab_affectedUsers'][$i]["num_users"] = 0;   
                                    // $index = 0;                                        
                                }
                                
                                if (
                                    $group_libelle == $GLOBALS['tab_affectedUsers'][$i]["group_label"]
                                    && $todayL == $GLOBALS['tab_affectedUsers'][$i]["work_day"]
                                    && !in_array($aUser, $GLOBALS['tab_affectedUsers'][$i]['group_users'])
                                    && !in_array($aUser, $GLOBALS['globalOneGroupOneTask_users'])
                                ) {

                                    

                                    // On génére l'affectation task/user
                                    $generated = saveTasked($dDay, $aTask, $aUser, $numOfGroupsInTask); 
                                    // echo '<span style="color:blue;">'."Tasked generated: ".$aUser['name']."/ task : ".$aTask["task_libelle"]." / day : ".$dDay."<br>".'</span>';

                                    $GLOBALS['tab_affectedUsers'][$i]["task_label"] = $aTask["task_libelle"];
                                    array_push($GLOBALS['tab_affectedUsers'][$i]["group_users"], $aUser); // Ajouter user dans tableau
                                    $GLOBALS['tab_affectedUsers'][$i]["num_users"]++;  // Incrémenter le nombre d'utilisateurs 

                                    // echo "Number of affected users : ".$GLOBALS['tab_affectedUsers'][$i]["num_users"] ." / Number of free users : ".$num_freeUsers ."<br>"; 
                                    $generated = true;   
                                    // $index = $index++;                                             
                                }
                            }    
                                    
                                    

                        }// WHILE()  

                    } // IF() 
                }// FOREACH 

            } // END IF($numOfGroupsInTask == 1)
 
            // Empty the array 
            $GLOBALS['globalUsersByGroups'] = array(); // ou unset($GLOBALS['globalUsersByGroups']);  
        }// FOREACH tasks AS task


        // Vider le tableau global
        $GLOBALS['globalTasks'] = array(); // ou unset($GLOBALS['globalTasks']); 
        $GLOBALS['globalOneGroupOneTask_users'] = array(); // ou unset($GLOBALS['globalUsersByGroups']);
        

        // echo "jourJ ---> ".$today->format('l, d. M , G.i'). "<br>";   // jourJ ---> Wednesday, 18. Sep , 11.35
        date_add($today, date_interval_create_from_date_string('1 day')); // CREATE NEXT DAY 
     }// END WHILE 
} // END FUNCTION 






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



?> 


