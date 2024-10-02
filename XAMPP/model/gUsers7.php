<?php
// H. BAYTAR 

// MYSQL Requests 
$dbTasks = getTasks() ; 
$dbGroups = getGroup(); 
$dbUsers = getUser(); 

// Processing users & tasks lists 
$globalUsersByGroups = array(); 
$globalTasks = array(); 

$tab_freeUsers = array(); // INSERTION ---> $data[$key] = $value; / array_push( $data, $value);   
$tab_affectedUsers = array(); 
$tab_recordableUsers = array();  

$globalManyGroupsOneTask_users = array(); 
$globalOneGroupOneTask_users = array(); 


// _____________________________________________________________________________________
// How define and use global variables with Superglobal array $GLOBALS[] 
// _____________________________________________________________________________________
$x = 'Hyvor';
$y = 'Developer';

function websiteName() {
	echo "websiteName : ".$GLOBALS['x'], $GLOBALS['y']."<br>";
}
// Call the method in an other function 
// websiteName(); // outputs Hyvor Developer


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
// Get user Vacation by user_id 
// _____________________________________________________________________________________
function getUserVacation($user_id){
    $user = R::getAll("SELECT * FROM vacation  WHERE user_id = ?",  [$user_id, ]);
    return $user; 
}


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

        /*
        echo "-----------------------------------------------------------------<br>"; 
        echo "GROUP: ".$group->libelle."<br>"; 
        echo "Date: ".$today->format('d.m.Y')."<br>"; 
        echo "Weekday: ".$today->format('l'); 
        echo "<br>-----------------------------------------------------------------<br>"; 
        */ 

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

    // foreach ($websites as $key => $value){echo "<p>$key: $value <p>";}
    /* 
    echo "createAffectedUsersArray() / (tab_affectedUsers)<br>"; 
    foreach ($GLOBALS['tab_affectedUsers'] as $tab){

        echo "-----------------------------------------------------------------<br>"; 
        echo "GROUP : ".$tab["group_label"]."<br>"; 
        echo "num_users :".$tab["num_users"]."<br>"; 
        echo "Weekday: ".$tab["work_day"]."<br>"; 

        // echo  "Group : ". $tab["group_label"].", weekday ".$tab["work_day"]."<br>"; 
        foreach ($tab["group_users"] as $user){
            if(!empty($user)){ echo $user->name."<br>"; }
        }

        echo "<br>-----------------------------------------------------------------<br>"; 
    } 
 
    */ 
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

        /*
        echo "-----------------------------------------------------------------<br>"; 
        echo "GROUP: ".$group->libelle."<br>"; 
        echo "Date: ".$today->format('d.m.Y')."<br>"; 
        echo "Weekday: ".$today->format('l'); 
        echo "<br>-----------------------------------------------------------------<br>"; 
        */ 

		if(!empty($group)){
            // echo "Id: ".$group->id."<br>"; 

            while($today <=  $lastDay){

                // PROCESSING WEEKDAYS [Monday, Thursday, Wednesday, Tuesday, Friday, Saturday, Sunday] 
                $todayL = $today->format('l'); // PROCESSING DAY [Monday, Thursday, Wednesday, Tuesday, Friday]    
                // echo "week ".$todayL ."<br>";  

                $group_users = getUsersByGroups($group->id, $today); 
                if(!empty($group_users)){
                    $tab_recordableUsers = array(); // INSERTION ---> $data[$key] = $value; / array_push( $data, $value);   

                    $tab_recordableUsers["work_day"] = $todayL;   
                    $tab_recordableUsers["group_label"] = $group->libelle;     
                    $tab_recordableUsers["group_id"] = $group->id; 
                    $tab_recordableUsers["num_users"] = count($group_users); 
                    $tab_recordableUsers["group_users"] = $group_users; 

                    // echo "group_label : ". $tab_recordableUsers["group_label"] ."<br>"; 
                    array_push( $GLOBALS['tab_freeUsers'], $tab_recordableUsers);      
                }

                // echo "jourJ ---> ".$today->format('l, d. M , G.i'). "<br>";   // jourJ ---> Wednesday, 18. Sep , 11.35
                date_add($today, date_interval_create_from_date_string('1 day')); // CREATE NEXT DAY 
            }

        }
    }// FOR EACH GROUP 


    /* 
    // foreach ($websites as $key => $value){echo "<p>$key: $value <p>";}
    foreach ($GLOBALS['tab_freeUsers'] as $tab){

        echo "-----------------------------------------------------------------<br>"; 
        echo "GROUP: ".$tab["group_label"]."<br>"; 
        echo "Weekday: ".$tab["work_day"]."<br>"; 
        echo "Num_Users: ".$tab["num_users"]."<br>"; 

        // echo  "Group : ". $tab["group_label"].", weekday ".$tab["work_day"]."<br>"; 
        foreach ($tab["group_users"] as $user){
            echo "--".$user->name."<br>"; ; 
        }
            echo "<br>-----------------------------------------------------------------<br>"; 
    } 
    */ 


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
// get tasks executed by the given group_id and for the given day 
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


// GET group by group_id
function getGroupById($id) {
    return R::load( 'group', $id); 
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


    // __________________________________________________________________________________________
    // CREATE AN ARRAY OF REGISTERED USERS SORTED INTO GROUPS AND TASK WEEKDAYS  
    // __________________________________________________________________________________________
     $GLOBALS['tab_affectedUsers'] = createArrayForAffectedUsers(); 

    // __________________________________________________________________________________________
    // CREATE AN ARRAY OF AVAILABLE USERS SORTED INTO GROUPS AND THEIR WEEKDAYS  
    // __________________________________________________________________________________________
    $GLOBALS['tab_freeUsers'] = getFreeUsersArray(); 

    // TEST 
    // foreach ($websites as $key => $value){echo "<p>$key: $value <p>";}
    /* 
    foreach ($GLOBALS['tab_freeUsers'] as $tab){

        echo "-----------------------------------------------------------------<br>"; 
        echo "GROUP: ".$tab["group_label"]."<br>"; 
        echo "Weekday: ".$tab["work_day"]; 
        echo "<br>"; 


        // echo  "Group : ". $tab["group_label"].", weekday ".$tab["work_day"]."<br>"; 
        foreach ($tab["group_users"] as $user){
            echo $user->name."<br>"; ; 
        }
            echo "<br>-----------------------------------------------------------------<br>"; 
    } 
    */ 
    // __________________________________________________________________________________________



    while($today <=  $lastDay){

        // Formats date $today  
        $dDay = $today->format('Y.m.d'); // 2024.12.31 
        $todayC =  new DateTime($today->format('c')); // ISO 8601 date | Ex. returned values : 2004-02-12T15:19:21+00:00 
        $todayL = $today->format('l'); // PROCESSING DAY [Monday, Thursday, Wednesday, Tuesday, Friday]     
 
        getTasksByGroups($dbGroups, $todayC); // $GLOBALS['globalTasks'] 

        echo "________________________________________<br>"; 
        echo "Today we are on : ".$today->format('Y.m.d')." , ".$todayL ."<br>"; 
        echo "________________________________________<br>"; 

        // getTasksByGroups($dbGroups, $todayC); // $GLOBALS['globalTasks'] 
        foreach($GLOBALS['globalTasks'] as $aTask){

            $weekdays_task = $aTask['task_weekdays'];  // GET CURRENT TASK WEEKDAYS     
            $task_weekdays = json_decode($weekdays_task);      

            $numOfGroupsInTask = CalculateGroupTasks($aTask['task_id']); 
            // echo "Task : ".$aTask["task_libelle"]." ---> ".$numOfGroupsInTask." group(s) <br>";  

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

                    if((empty($GLOBALS['globalManyGroupsOneTask_users'])) || (!in_array($aUser, $GLOBALS['globalManyGroupsOneTask_users']) && !in_array($aUser, $GLOBALS['globalOneGroupOneTask_users']))){   
                
                        $generated = saveTasked($dDay, $aTask, $aUser, $numOfGroupsInTask );  
                        echo '<span style="color:brown;">'."Tasked generated ---> task : ".$aTask["task_libelle"]." / user : ".$aUser['name']." / day : ".$dDay."<br>".'</span>';
                    }

                } // while() 

                // echo "<br>"; 
                echo '<span style="color:green;">'."(many groups/ 1 task) : le tableau globalUsersByGroups contient : ".count($GLOBALS['globalUsersByGroups'])." valeurs <br>".'</span>';
                // echo '<span style="color:red;">'."(many groups/ 1 task) : le tableau globalOneGroupOneTask_users contient : ".count($GLOBALS['globalUsersByGroups'])." valeurs <br>".'</span>';
            }


            //_______________________________________________________________________________
            // ONE GROUP FOR ONE TASK 
            //_______________________________________________________________________________  
            if($numOfGroupsInTask == 1){
                    
                    $group = getGroupById($aTask['groupTask_groupId']); 
                    $group_libelle = $group['libelle']; 
                    $group_id = $group['id']; 
                    // echo "Group : ".$group['libelle']." / Group_id : ".$group['id']." / Task : ".$aTask['task_libelle']."<br>";  // echo "".."<br>"; 

                    // __________________________________________________________________________________________
                    // for each available users array of current group 
                    // __________________________________________________________________________________________
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
  
                                // echo "Number of free users : ".$num_freeUsers ."<br>"; 

                                // Utiliser une boucle `for` pour manipuler directement les éléments
                                for ($i = 0; $i < count($GLOBALS['tab_affectedUsers']); $i++) {
                                    if ($GLOBALS['tab_affectedUsers'][$i]["num_users"] == $num_freeUsers) {
                                        $GLOBALS['tab_affectedUsers'][$i]["group_users"] = array();
                                        $GLOBALS['tab_affectedUsers'][$i]["num_users"] = 0;                                          
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
                                    }
                                }    
                                        
                                        

                            }// WHILE()  

                        } // IF() 
                    }// FOREACH 

                } // IF($numOfGroupsInTask == 1)
                    // __________________________________________________________________________________________


                    // RESULT                     
                    /* 
                    --- : Amin ARSLANI / INF
                    --- : Joel RUBIN LENNY / INF
                    --- : Aaron BLESS / INF
                    --- : Grittideth WATANAKULA / INF
                    */ 



                    // echo '<span style="color:red;">'."(1 group / 1 task) : le tableau globalUsersByGroups contient : ".count($GLOBALS['globalUsersByGroups'])." valeurs <br>".'</span>';     
                    // echo '<span style="color:red;">'."(1 group / 1 task) : le tableau globalOneGroupOneTask_users contient : ".count($GLOBALS['globalOneGroupOneTask_users'])." valeurs <br>".'</span>';
           


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


?> 


