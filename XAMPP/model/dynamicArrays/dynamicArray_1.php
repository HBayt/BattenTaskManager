<?php

$arr = array();

$loc_arr = array(
   'item' => array(
           'abc',
           'www',
           'ccc'),
   'other item' => array(
           'other index'
   )
);


foreach($loc_arr as $item => $scndLevel){
    foreach ( $scndLevel as $level) {
        $arr[$item][$level] = array(
           'name'=>'somename',
           'other'=>'...'
        );
    }
}


// Print result 
print_r($arr);


/* 
// RESULT 

Array 
( 
    [item] => Array ( 
        [abc] => Array ( 
            [name] => somename 
            [other] => ... 
        ) 
        [www] => Array ( 
            [name] => somename 
            [other] => ... 
        ) 
        [ccc] => Array ( 
            [name] => somename 
            [other] => ... 
        ) 
    ) 
    [other item] => Array ( 
        [other index] => Array ( 
            [name] => somename 
            [other] => ... 
        ) 
    ) 
) 

*/ 




// _____________________________________________________________________________________
// get users of a group by group_id for a given day 
// _____________________________________________________________________________________
function getUsersByGroups2($group_id, $dayD){

    global $dbGroups; 
    global $dbUsers;    
    $groups = $dbGroups; 
    $users = $dbUsers; 
     // array_push( $globalUsers, $user);

     $dayL = $dayD->format('l'); 

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
                            array_push( $GLOBALS['globalUsers'], $user);
                        } 

                    }// END $userWeekdays control 

                }// END user->group_id = group->id 
            }
		}
	}

    // To remove duplicate user(s)
    $GLOBALS['globalUsers']  = createUniqueArray($GLOBALS['globalUsers'] , 'name'); 
    shuffle($GLOBALS['globalUsers']); 

    // ECHO user's name for test : 
    // foreach($GLOBALS['globalUsers'] as $u){ echo $u['name']."<br>"; }

}// END getUsersByGroups() 



