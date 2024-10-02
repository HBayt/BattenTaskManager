<?php
// H. BAYTAR 

// MYSQL Requests 
$dbTasks = getTasks() ; 
$dbGroups = getGroup(); 
$dbUsers = getUser(); 

// Processing users & tasks lists 
$globalUsersByGroups = array(); 
$globalTasks = array(); 

$globalUsersByGoupAndWeekdays = array();
$tab_usersbyweekday = array();  

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
// get users of a group by group_id for a given day 
// _____________________________________________________________________________________
function createDynamicsTabsForGroupUsers(){

    $count = 1; 

    global $dbUsers;    
    $users = $dbUsers;   

    global $dbGroups;  
    $groups = $dbGroups; 

    global $tab_usersbyweekday; 
    global $globalUsersByGoupAndWeekdays;

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
                    // print_r($group_users);  echo "<br>"; 

                    $tab_usersbyweekday = array(); // INSERTION ---> $data[$key] = $value; / array_push( $data, $value);   

                    $tab_usersbyweekday["work_day"] = $todayL;   
                    $tab_usersbyweekday["group_label"] = $group->libelle;     
                    $tab_usersbyweekday["group_id"] = $group->id; 
                    $tab_usersbyweekday["group_users"] = $group_users; 

                    // echo "Weekday : ". $tab_usersByWeekday["weekday"] ."<br>"; 
                    // echo "group_label : ". $tab_usersByWeekday["group_label"] ."<br>"; 
                    // $tab_utilisateurs = $tab_usersByWeekday["users"]; 
                    array_push( $GLOBALS['globalUsersByGoupAndWeekdays'], $tab_usersbyweekday);      
                }

                // echo "jourJ ---> ".$today->format('l, d. M , G.i'). "<br>";   // jourJ ---> Wednesday, 18. Sep , 11.35
                date_add($today, date_interval_create_from_date_string('1 day')); // CREATE NEXT DAY 
            }

        }
    }// FOR EACH GROUP 


    /* 

    // foreach ($websites as $key => $value){echo "<p>$key: $value <p>";}
    foreach ($GLOBALS['globalUsersByGoupAndWeekdays'] as $tab){

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

    return $GLOBALS['globalUsersByGoupAndWeekdays']; 

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
                                if($user_hasvaction == true){$user_iscompatible = false ; }
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
function generateUsersTasks1($today, $lastDay){


    global $globalOneGroupOneTask_users; 
    global $globalManyGroupsOneTask_users; 
    // User arrays 
    $usersListByGroup = [];


    /* 
    // echo '<span style="color:blue;">'."xxx"." valeurs <br>".'</span>';  
    */ 


    // DELETE ALL ROWS FROM THE TABLE 'TASKED'(REMOVE ALL OCCURENCES)
    $tasked = R::findAll( 'tasked' ); 
    foreach ($tasked as $t) { R::trash($t); }
    R::exec( "ALTER TABLE `tasked` AUTO_INCREMENT=1" );  // RESET AUTO INCREMENT PRIMYARY KEY VALUE 


    // get datas from MySql DB 
    global $dbGroups; 
    $groups = $dbGroups; 



    while($today <=  $lastDay){

        // Formats date $today  
        $dDay = $today->format('Y.m.d'); // 2024.12.31 
        $todayC =  new DateTime($today->format('c')); // ISO 8601 date | Ex. returned values : 2004-02-12T15:19:21+00:00 
        $todayL = $today->format('l'); // PROCESSING DAY [Monday, Thursday, Wednesday, Tuesday, Friday]     

 
        getTasksByGroups($dbGroups, $todayC); // $GLOBALS['globalTasks'] 
        

        echo "________________________________________<br>Today is : ".$today->format('Y.m.d')." , ".$todayL ."<br>________________________________________<br>"; 

        // getTasksByGroups($dbGroups, $todayC); // $GLOBALS['globalTasks'] 
        foreach($GLOBALS['globalTasks'] as $aTask){


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
                        echo '<span style="color:brown;">'."- Tasked saved ---> task : ".$aTask["task_libelle"]." / user : ".$aUser['name']."<br>".'</span>';  
                    }

                } // while() 

                // echo "<br>"; 
                echo '<span style="color:green;">'."(many groups/ 1 task) : le tableau globalUsersByGroups contient : ".count($GLOBALS['globalUsersByGroups'])." valeurs <br>".'</span>';
                // echo '<span style="color:red;">'."(many groups/ 1 task) : le tableau globalOneGroupOneTask_users contient : ".count($GLOBALS['globalUsersByGroups'])." valeurs <br>".'</span>';
            }
            echo "<br>"; 

            //_______________________________________________________________________________
            // ONE GROUP FOR ONE TASK 
            //_______________________________________________________________________________  
            if($numOfGroupsInTask == 1){
                    
                    $group = getGroupById($aTask['groupTask_groupId']); 
                    $group_libelle = $group['libelle']; 
                    // count($GLOBALS['global_groups'][$group_libelle] ); 


                    // echo "Group : ".$group['libelle']." / Group_id : ".$group['id']." / Task : ".$aTask['task_libelle']."<br>";  // echo "".."<br>"; 

                    getUsersByGroups($group['id'], $todayC); 
                    foreach($GLOBALS['globalUsersByGroups'] as $aUser){echo "--- : ".$aUser['name']."<br>"; }
                    /* 
                    // RESULT 
                    --- : Joel RUBIN LENNY / INF
                    --- : Amin ARSLANI / INF
                    --- : Grittideth WATANAKULA / INF
                    */ 


                    shuffle($GLOBALS['globalUsersByGroups']); // foreach($GLOBALS['globalUsersByGroups'] as $aUser){
                    $generated = false;                     
                    while($generated == false){

                        $randomKey = array_rand($GLOBALS['globalUsersByGroups']);// Utiliser array_rand pour obtenir une clé aléatoire
                        $aUser = $GLOBALS['globalUsersByGroups'][$randomKey];
                        // echo '<span style="color:blue;">'."--- rand : ".$aUser['name']."/ task : ".$aTask["task_libelle"]." / day : ".$dDay."<br>".'</span>';   

                        if((empty($GLOBALS['globalOneGroupOneTask_users']) || !in_array($aUser, $GLOBALS['globalOneGroupOneTask_users']))){   
                            $generated = saveTasked($dDay, $aTask, $aUser, $numOfGroupsInTask); 

                            // - (group == 1) Tasked saved ---> task : STAUB_INF / user : Grittideth WATANAKULA / INF
                            echo '<span style="color:purple;">'."- (group == 1) Tasked saved ---> task : ".$aTask["task_libelle"]." / user : ".$aUser['name']."<br>".'</span>';  
                        }

                    } // while() 


                    // echo '<span style="color:red;">'."(1 group / 1 task) : le tableau global_groups : ".count($GLOBALS['global_groups'][$group_libelle] )." valeurs <br>".'</span>';  
                    // echo '<span style="color:red;">'."(1 group / 1 task) : le tableau globalUsersByGroups contient : ".count($GLOBALS['globalUsersByGroups'])." valeurs <br>".'</span>';     
                    // echo '<span style="color:red;">'."(1 group / 1 task) : le tableau globalOneGroupOneTask_users contient : ".count($GLOBALS['globalOneGroupOneTask_users'])." valeurs <br>".'</span>';
            }
            


            // Empty the array 
            $GLOBALS['globalUsersByGroups'] = array(); // ou unset($GLOBALS['globalUsersByGroups']);  

        }// FOREACH task


        // Vider le tableau global
        $GLOBALS['globalTasks'] = array(); // ou unset($GLOBALS['globalTasks']); 
        $GLOBALS['globalOneGroupOneTask_users'] = array(); // ou unset($GLOBALS['globalUsersByGroups']);  

        // echo "jourJ ---> ".$today->format('l, d. M , G.i'). "<br>";   // jourJ ---> Wednesday, 18. Sep , 11.35
        date_add($today, date_interval_create_from_date_string('1 day')); // CREATE NEXT DAY 
    } // WHILE() 
    



} // END FUNCTION 





// _____________________________________________________________________________________
// Generate / affect tasks to users 
// _____________________________________________________________________________________
function generateUsersTasks($today, $lastDay){

    global $globalOneGroupOneTask_users; 
    global $globalManyGroupsOneTask_users; 

    // get datas from MySql DB 
    global $dbGroups; 
    $groups = $dbGroups; 

    // echo '<span style="color:blue;">'."xxx"." valeurs <br>".'</span>';  

    // DELETE ALL ROWS FROM THE TABLE 'TASKED'(REMOVE ALL OCCURENCES)
    $tasked = R::findAll( 'tasked' ); 
    foreach ($tasked as $t) { R::trash($t); }
    R::exec( "ALTER TABLE `tasked` AUTO_INCREMENT=1" );  // RESET AUTO INCREMENT PRIMYARY KEY VALUE 

    while($today <=  $lastDay){

        // Formats date $today  
        $dDay = $today->format('Y.m.d'); // 2024.12.31 
        $todayC =  new DateTime($today->format('c')); // ISO 8601 date | Ex. returned values : 2004-02-12T15:19:21+00:00 
        $todayL = $today->format('l'); // PROCESSING DAY [Monday, Thursday, Wednesday, Tuesday, Friday]     
 
        getTasksByGroups($dbGroups, $todayC); // $GLOBALS['globalTasks'] 

        echo "________________________________________<br>Today is : ".$today->format('Y.m.d')." , ".$todayL ."<br>________________________________________<br>"; 

        // getTasksByGroups($dbGroups, $todayC); // $GLOBALS['globalTasks'] 
        foreach($GLOBALS['globalTasks'] as $aTask){

            $numOfGroupsInTask = CalculateGroupTasks($aTask['task_id']); 
            // echo "Task : ".$aTask["task_libelle"]." ---> ".$numOfGroupsInTask." group(s) <br>";  

            //_______________________________________________________________________________        
            // MANY GROUPS FOR ONE TASK
            //_______________________________________________________________________________
            if($numOfGroupsInTask > 1){
                // echo "task_label : ".$aTask['task_libelle'].", Num of groups (> 1) :  ".$numOfGroupsInTask ."<br>"; 

                $listGroups = getGroupssByTaskId($aTask['task_id']); 
                foreach($listGroups as $gr){
                    // echo "group : ".$lg['group_libelle']."<br>"; 
                    getUsersByGroups($gr['group_id'], $todayC);  // $GLOBALS['globalUsersByGroups'] 
                }
        
                $generated = false; 
                shuffle($GLOBALS['globalUsersByGroups']); 
                shuffle($GLOBALS['globalUsersByGroups']);  
                while($generated == false){

                    $randomKey = array_rand($GLOBALS['globalUsersByGroups']);// Utiliser array_rand pour obtenir une clé aléatoire

                    $aUser = $GLOBALS['globalUsersByGroups'][$randomKey]; // GET array value from RANDOM KEY 
                    // echo '<span style="color:blue;">'."--- rand : ".$aUser['name']."/ task : ".$aTask["task_libelle"]." / day : ".$dDay."<br>".'</span>';   

                    if((empty($GLOBALS['globalManyGroupsOneTask_users'])) || (!in_array($aUser, $GLOBALS['globalManyGroupsOneTask_users']) && !in_array($aUser, $GLOBALS['globalOneGroupOneTask_users']))){   
                
                        $generated = saveTasked($dDay, $aTask, $aUser, $numOfGroupsInTask );  
                        echo '<span style="color:brown;">'."- Tasked saved ---> task : ".$aTask["task_libelle"]." / user : ".$aUser['name']."<br>".'</span>';  
                    }

                } // while() 

                // echo "<br>"; 
                echo '<span style="color:green;">'."(many groups/ 1 task) : le tableau globalUsersByGroups contient : ".count($GLOBALS['globalUsersByGroups'])." valeurs <br>".'</span>';
            }
            echo "<br>"; 

            //_______________________________________________________________________________
            // ONE GROUP FOR ONE TASK 
            //_______________________________________________________________________________  
            if($numOfGroupsInTask == 1){
                    
                    $group = getGroupById($aTask['groupTask_groupId']); 
                    $group_libelle = $group['libelle']; 
                    // echo "Group : ".$group['libelle']." / Group_id : ".$group['id']." / Task : ".$aTask['task_libelle']."<br>";  // echo "".."<br>"; 

                    getUsersByGroups($group['id'], $todayC); 

                    shuffle($GLOBALS['globalUsersByGroups']);  
                    shuffle($GLOBALS['globalUsersByGroups']); 
                    /* 
                    // RESULT 
                    --- : Amin ARSLANI / INF
                    --- : Joel RUBIN LENNY / INF
                    --- : Aaron BLESS / INF
                    --- : Grittideth WATANAKULA / INF
                    */ 

                    $generated = false;                     
                    while($generated == false){

                        $randomKey = array_rand($GLOBALS['globalUsersByGroups']);// Utiliser array_rand pour obtenir une clé aléatoire
                        $aUser = $GLOBALS['globalUsersByGroups'][$randomKey];
                        // echo '<span style="color:blue;">'."--- rand : ".$aUser['name']."/ task : ".$aTask["task_libelle"]." / day : ".$dDay."<br>".'</span>';   

                        if( (empty($GLOBALS['globalOneGroupOneTask_users']) || !in_array($aUser, $GLOBALS['globalOneGroupOneTask_users']) )){   
                            $generated = saveTasked($dDay, $aTask, $aUser, $numOfGroupsInTask); 
                            // - (Num of group = 1) Tasked saved ---> task : STAUB_INF / user : Grittideth WATANAKULA / INF
                            echo '<span style="color:purple;">'."- (group == 1) Tasked saved ---> task : ".$aTask["task_libelle"]." / user : ".$aUser['name']."<br>".'</span>';  
                        }

                    } // while() 

                    // echo '<span style="color:red;">'."(1 group / 1 task) : le tableau globalUsersByGroups contient : ".count($GLOBALS['globalUsersByGroups'])." valeurs <br>".'</span>';     
                    // echo '<span style="color:red;">'."(1 group / 1 task) : le tableau globalOneGroupOneTask_users contient : ".count($GLOBALS['globalOneGroupOneTask_users'])." valeurs <br>".'</span>';
            }


            // Empty the array 
            $GLOBALS['globalUsersByGroups'] = array(); // ou unset($GLOBALS['globalUsersByGroups']);  
        }// FOREACH tasks AS task


        // Vider le tableau global
        $GLOBALS['globalTasks'] = array(); // ou unset($GLOBALS['globalTasks']); 
        $GLOBALS['globalOneGroupOneTask_users'] = array(); // ou unset($GLOBALS['globalUsersByGroups']);
        

        // echo "jourJ ---> ".$today->format('l, d. M , G.i'). "<br>";   // jourJ ---> Wednesday, 18. Sep , 11.35
        date_add($today, date_interval_create_from_date_string('1 day')); // CREATE NEXT DAY 
    } // WHILE() 
    



} // END FUNCTION 








?> 


