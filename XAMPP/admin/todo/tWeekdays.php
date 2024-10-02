<?php

// A DATE + 1 DAY
$date = new DateTime('2000-12-31');
$date->modify('+1 day');
echo $date->format('Y-m-d') . "<br>";


// TODAY 
$next_due_date = date('d/m/Y', strtotime("+30 days"));// today + 30 Days 
echo "1. Date -> today (d/m/Y) + 30 days is : ".$next_due_date."<br>";
echo "<br>"; 

// A SPECIFIC DATE 
$oldDate = new DateTime('2016-06-30'); 
echo "2. a specific date ('2016-06-30') given as a string and displayed in format Y/m/d is : ".$oldDate->format('Y/m/d') ."<br>";
echo "<br>"; 
$due_oldDate = $oldDate->add(new DateInterval('P30D')); // date + 30 Days 
echo "3. The specific date ('2016-06-30')  + P30D displayed in format Y-m-d : ".$due_oldDate->format('Y-m-d') ."<br>";
echo "<br>"; 


// TODAY 
$dateTime_format = new DateTime(); 
echo "4. today (var = new DateTime()) -> in format d.m.Y is : ".$dateTime_format ->format('d.m.Y') ."<br>";
echo "5. today (var = new DateTime()) -> in format d/m/Y is : ".$dateTime_format ->format('d/m/Y') ."<br>"; 
echo "6. today (var = new DateTime()) -> in format 'l, d. M , G.i' : ".$dateTime_format->format('l, d. M , G.i')."<br>"; 
echo "<br>"; 
?>

<?php
    // _________________________________________________
    // WHILE START_DATE < CURRENT_DATE < END_DATE 
    // _________________________________________________
    $today = new DateTime(); // $today = $from->format("Y-m-d");
    $jourJ =  new DateTime($today->format('c')); // ISO 8601 date | Example returned values : 2004-02-12T15:19:21+00:00 
    // echo "Jour J : ".$jourJ->format('l, d. M , G.i'). "<br>";   
    
    $lastDay =  new DateTime();  // $lastDay = $to->format("Y-m-d");
    date_add($lastDay, date_interval_create_from_date_string('30 days')); // GENERATOR for X days / X months PARAM = ('1 month')

    $lastDay =  new DateTime($lastDay->format('c')); // ISO 8601 date | Example returned values : 2004-02-12T15:19:21+00:00 
    echo "today (var = new DateTime()) + 30 days is : ".$lastDay->format('l, d. M , G.i'). "<br><br>";

    
    while($jourJ <= $lastDay){

        // Jourdays of the week  
        $week_jourdays = $jourJ->format('l'); // PROCESSING DAY 
        if( $week_jourdays == "Monday"){// Monday is the processing day 
            // echo $jourJ->format('l, d. M , G.i'). "<br>";
        }
        if( $week_jourdays == "Tuesday"){// Tuesday is the processing day 
            // echo $jourJ->format('l, d. M , G.i'). "<br>";
        }

        if( $week_jourdays == "Wednesday"){// Wednesday is the processing day 
            // echo $jourJ->format('l, d. M , G.i'). "<br>";
        }

        if( $week_jourdays == "Thursday"){// Thursday is the processing day 
           // echo $jourJ->format('l, d. M , G.i'). "<br>";
        }

        if( $week_jourdays == "Friday"){// Friday is the processing day 
            // echo $jourJ->format('l, d. M , G.i'). "<br>";
        }

        // in_array($today->format('l'), $task_weekdays) 
        // CHECK IF CURRENT_ DAY IS IN THE "TASK WEEKDAYS" ARRAY -> [Wednesday | Friday, Tuesday, Monday, Thursday]

        $jourJ = $jourJ->add(new DateInterval('P1D')); // GET THE NEXT DAY (TODAY + 1 )
    } // WHILE()



