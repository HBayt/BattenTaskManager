<?php
session_start();

if($_SESSION["login"]) {
require '../config.php';
require 'vue/partials/header.php';
include '../utils/connectdb.php';
require '../model/task.php';
require 'vue/partials/nav.php';

$tasks = getTasks();

?>



<!-- ------------------------------------------------- -->    
<!-- Page title & Button Create (Insert into db.table ) -->     
<!-- ------------------------------------------------- -->     
 
<section class="container mt-5">
    <div class="container">
        <!-- Title -->    
        <h2>Index</h2>
        
        <br>
        <hr>
        <br>

        <!-- ------------------------------------------------- -->    
        <!-- Button to open Modal Window -->     
        <!-- ------------------------------------------------- --> 



        <?php
            $date=date_create("2013-03-15");
            date_add($date,date_interval_create_from_date_string("40 days"));
            echo "<h1> Date: ".date_format($date,"Y-m-d")."</h1>";
            echo "<br><br>";
        ?> 


<?php 
    $tasks = getAllTasksWithGroupsAndUsers(); 
 
    $task_counter = 0; 
    foreach($tasks as $task){   




       // var_dump($task);
        /* 
        array(9) {
            [
                "id_task"
            ]=> string(2) "16"[
                "name_task"
            ]=> string(10) "Cafeterias"[
                "weekdays_task"
            ]=> string(52) "["Monday","Tuesday","Wednesday","Thursday","Friday"]"[
                "color_task"
            ]=> string(9) "#1015e3ff"[
                "id_grouptask"
            ]=> string(3) "120"[
                "group_grouptask"
            ]=> string(1) "4"[
                "task_grouptask"
            ]=> string(2) "16"[
                "id_group"
            ]=> string(1) "4"[
                "name_group"
            ]=> string(10) "Informatik"
        }
        */ 


        $task_name = $task['name_task'];         
        echo " Task name : ".$task_name." ";
        echo " Group name : ".$task['name_group']." ";
        echo "<br>";
        /* 

        $task_name = $task['name_task'];         
        echo " Task name : ".$task_name." ";
        echo "<br>";


        Name : Cafeterias
        Name : Staubsauger / Aspirateur INF
        Name : Müll / Déchets INF
        Name : Cafeterias
        Name : Müll / Déchets MDE
        Name : Staubsauger / Aspirateur MDE
        Name : Cafeterias
        Name : Müll, Shredder, Altpapier / Déchets, Déchiqueteuse, Vieux papier VER
        Name : Staubsauger / Aspirateur VER 
        */ 



        // FOREACH TASK GET Group Users 
        $group_id = $task['id_group']; 
        $users = getUsersByGroup($group_id); 

        // var_dump($users ); 
        foreach($users as $user){
            $user_weekdays = json_decode($user['weekdays']);   
            // print_r($user_weekdays); 

             $user_name = $user['name'];               
            // echo " User  : ".$user_name."<br>"; 

            /* 
            Task name : Cafeterias Group name : Informatik
            User : Ramon Odermatt
            User : Jean gaetan
            User : Grace Rudolph
            User : Dejan Simonovski
            User : Thibault Blaser
            User : Nora Räber
            User : Jannik Filardo
            User : Janick Baumann
            User : Kevin Locher
            User : Amin Arslani
            User : Aaron Bless
            User : Andrija Draca
            User : Kim Feyer
            User : Nevio Romano
            User : Victor Gashi
            User : Grittideth Watanakula
            User : Halide Baytar
            User : HB2018
            */ 

        }


        // GET TASKS WEEKDAYS 
        $weekdays_task = $task['weekdays_task'];     
        $task_weekdays = json_decode($weekdays_task);   
        // print_r($task_weekdays); // Print ARRAY 

            /* 
            echo $task_day."<br>";            
                Task days :
                Monday
                Tuesday
                Wednesday
                Thursday
                Friday
            */ 

        // var_dump($users ); 
        foreach($users as $user){
            $user_name = $user['name'];    
            $user_weekdays = json_decode($user['weekdays']);   


            // echo " <br>User ".$user_name ." work days : ";
            // print_r($user_weekdays ); 

            foreach($user_weekdays as $user_workday){

                // echo "<br>Task ".$task['name_task'] ." days : ";
                // print_r($task_weekdays ); 
                foreach($task_weekdays as $task_day){
        

                    // echo $day_user." ";
                    // echo "<br>";
                    /* 
                        User name : Thibault Blaser
                        Array ( [0] => Monday [1] => Tuesday [2] => Friday )
                        User work day(s) :
                        Monday
                        Tuesday
                        Friday 

                        User name : Nora Räber
                        Array ( [0] => Monday [1] => Tuesday )
                        User work day(s) :
                        Monday
                        Tuesday 
                    */ 



                    // Verifier si user_day == task_day
                    if($user_workday == $task_day){
                        // echo "<br>User : ".$user['name']." , Work day : ". $user_workday." , Task day : ". $task_day." <br> "; 

                        // Verifier si USER PAS EN CONGE 
                        $list_vacations = getUserVacations($user['id']); 
                        foreach($list_vacations as $vacation){
                            echo "<br>".$user['name']." , vaction start : ".$vacation['start'].", vaction end: ".$vacation['end']."<br>"; 
                        }
                        
                        // echo "<br>".$user['name']." , workday : ".$user_workday." vactions : <br>"; 
                        // print_r($list_vacations ); 
                        echo "<br><br>"; 

                    }
        
                }



                /* 

                // ___________________________________________________
                $task_name = $task['name_task'];         
                $name_group = $task['name_group'];         
                echo " Group name : ".$name_group. "<br> Task name : ".$task_name." ";;
                echo "<br><br>";
                // print_r($user_weekdays); 

                echo "<br>";
                $user_name = $user['name'];   
                echo " User name : ".$user_name." ";
                echo "<br>";

                // ___________________________________________________


                Task name : Cafeterias
                Group name : MediaDesign 

                User name : Alex Salesse
                User name : Noé Serravezza
                User name : Nicolas Savoy
                User name : Keenan Thurnes
                User name : Rafael Marques
                User name : Gabriel Fasel
                User name : Lionel Hofer
                User name : Diogo Da Silva
                User name : Gabriel Duarte
                User name : Sam Mpendubundi
                User name : Bruno Zucchetti
                User name : Cindy Dos Santos
                User name : Killian Vallat
                User name : Immanuel Studer
                User name : Jessy Jacot 
                ------------------------------------------------
                Task name : Cafeterias
                Group name : Verwaltung

                User name : Julian Schwaar
                User name : Livio Vogt
                User name : Darlyn Hernandez
                User name : Mara Meier
                User name : Lisa Blumenthal
                User name : Aaron Soltermann
                User name : Ariana Grzyb
                User name : Gracia Kamwanya Kamunga
                User name : Leonora Trena
                User name : Pereira Jessica
                ------------------------------------------------
                Task name : Staubsauger / Aspirateur VER
                Group name : Verwaltung

                User name : Julian Schwaar
                User name : Livio Vogt
                User name : Darlyn Hernandez
                User name : Mara Meier
                User name : Lisa Blumenthal
                User name : Aaron Soltermann
                User name : Ariana Grzyb
                User name : Gracia Kamwanya Kamunga
                User name : Leonora Trena
                User name : Pereira Jessica 
                ------------------------------------------------

                */ 

                // Verifier disponibilité de USER 
                // VACATION & WEEKDAYS 

        }



      

        }

        $task_counter = $task_counter + 1;         

    }// FOREACH TASK ...   
    echo "<br>Task counter :". $task_counter."  <br>";
?> 



</div>
</div>

</section>



<?php
}
require 'vue/partials/footer.php';


