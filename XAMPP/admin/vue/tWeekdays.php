
<?php 
// Définir le code HTML comme une chaîne de caractères
?> 



<!-- ------------------------------------------------- -->    
<!-- Page title & Button Create (Insert into db.table ) -->     
<!-- ------------------------------------------------- -->      
<div class="container">
    <table style="width:100%">
    <tr>
        <td> 
            <h2>Users workdays & Tasks weekdays </h2>
            <h3>(<?php echo $numOfUsers;  ?> users found)</h3> 
        </td>
        <td>
            
        </td>
        <td></td>
    </tr>
    </table> 
    <br>
    <hr>
</div>
<!-- ------------------------------------------------- -->    
<!-- TASKS WEEKDAYS  -->     
<!-- ------------------------------------------------- -->      
<div class="container mt-5">
  <table class="table">

        <thead>
            <tr>
            <th scope="col">Weekday / Wochentag / Jour de la semaine </th>
            <th scope="col">Task /Aufgabe / Tâche</th>
            </tr>
        </thead>

        <tbody> 
        <?php  
            // var_dump($groups); 



        // For the Monday column | Für die Spalte am Montag | Pour la colonne Lundi   
        echo " <tr>";
        echo " <td>Monday </td>";                    
        echo " <td>"; 
        foreach($tasks as $task){
            if(!empty($task)){
                $taskWeekdays = json_decode($task->weekdays); 

                if(!empty($taskWeekdays) && in_array('Monday', $taskWeekdays) ){
                    echo $task->libelle."</br>";
                } 

                $taskWeekdays = null; 
            }
        }
        echo "</td>";
        echo " </tr>"; 

        // For the Tuesday column | Für die Spalte am Dienstag | Pour la colonne Mardi  
        echo " <tr>";
        echo " <td>Tuesday </td>";                    
        echo " <td>"; 
        foreach($tasks as $task){
            if(!empty($task)){
                $taskWeekdays = json_decode($task->weekdays); 

                if(!empty($taskWeekdays) && in_array('Tuesday', $taskWeekdays) ){
                    echo $task->libelle."</br>";
                } 

                $taskWeekdays = null; 
            }
        }
        echo "</td>";
        echo " </tr>";  

        // For the Wednesday column | Für die Spalte am Mittwoch | Pour la colonne Mercredi  
        echo " <tr>";
        echo " <td>Wednesday </td>";                    
        echo " <td>"; 
        foreach($tasks as $task){
            if(!empty($task)){
                $taskWeekdays = json_decode($task->weekdays); 

                if(!empty($taskWeekdays) && in_array('Wednesday', $taskWeekdays) ){
                    echo $task->libelle."</br>";
                } 

                $taskWeekdays = null; 
            }
        }
        echo "</td>";
        echo " </tr>";  

        // For the Thursday column | Für die Spalte am Donnerstag | Pour la colonne Jeudi  
        echo " <tr>";
        echo " <td>Thursday </td>";                    
        echo " <td>"; 
        foreach($tasks as $task){
            if(!empty($task)){
                $taskWeekdays = json_decode($task->weekdays); 

                if(!empty($taskWeekdays) && in_array('Thursday', $taskWeekdays) ){
                    echo $task->libelle."</br>";
                } 

                $taskWeekdays = null; 
            }
        }
        echo "</td>";
        echo " </tr>";      

        // For the Friday column | Für die Spalte am Freitag | Pour la colonne Vendredi   
        echo " <tr>";
        echo " <td>Friday </td>";                    
        echo " <td>"; 
        foreach($tasks as $task){
            if(!empty($task)){
                $taskWeekdays = json_decode($task->weekdays); 

                if(!empty($taskWeekdays) && in_array('Friday', $taskWeekdays) ){
                    echo $task->libelle."</br>";
                } 

                $taskWeekdays = null; 
            }
        }
        echo "</td>";
        echo " </tr>";         
        ?> 
    </tbody> 
    </tr>
    </table> 
</div>


<!-- ------------------------------------------------- -->    
<!-- UUSER WEEKDAYS -->     
<!-- ------------------------------------------------- -->    
<div class="container mt-5">
  <table class="table">

        <thead>
            <tr>
            <th scope="col">Atelier / Workshop / Werkstatt</th>
            <th scope="col">Monday (Lun)</th>
            <th scope="col">Tuesday (Mar)</th>
            <th scope="col">Wednesday (Mer)</th>
            <th scope="col">Thursday (Jeu) </th>
            <th scope="col">Friday (Ven)</th>
            </tr>
        </thead>

        <tbody> 
        <?php  
            // var_dump($groups); 
        
        foreach($groups as $group){
            if(!empty($group)){
                    echo " <tr>";
                    echo " <td>".$group->name."</td>";

                    // For the Monday column | Für die Spalte am Montag | Pour la colonne Lundi 
                    echo " <td>"; 
                    foreach($users as $user){
                        $userWeekdays = json_decode($user->weekdays); 

                        if(!empty($userWeekdays) && in_array('Monday', $userWeekdays) ){
                            if ($user-> group_id == $group-> id) { 
                                echo $user->name."</br>";
                            } 

                        }
                        $userWeekdays = null; 
                    }
                    //________________



                    // For the Tuesday column | Für die Spalte am Dienstag | Pour la colonne Mardi  
                    echo " <td>"; 
                    foreach($users as $user){
                        $userWeekdays = json_decode($user->weekdays); 

                        if(!empty($userWeekdays) && in_array('Tuesday', $userWeekdays) ){
                            if ($user-> group_id == $group-> id) { 
                                echo $user->name."</br>";
                            } 
                        }
                        $userWeekdays = null; 
                    }
                    echo "</td>";



                    // For the Wednesday column | Für die Spalte am Mittwoch | Pour la colonne Mercredi  
                    echo " <td>"; 
                    foreach($users as $user){
                        $userWeekdays = json_decode($user->weekdays); 

                        if(!empty($userWeekdays) && in_array('Wednesday', $userWeekdays) ){
                            if ($user-> group_id == $group-> id) { 
                                echo $user->name."</br>";
                            } 
                        }
                        $userWeekdays = null; 
                    }
                    echo "</td>";


                    // For the Thursday column | Für die Spalte am Donnerstag | Pour la colonne Jeudi  
                    echo " <td>"; 
                    foreach($users as $user){
                        $userWeekdays = json_decode($user->weekdays); 

                        if(!empty($userWeekdays) && in_array('Thursday', $userWeekdays) ){
                            if ($user-> group_id == $group-> id) { 
                                echo $user->name."</br>";
                            } 
                        }
                        $userWeekdays = null; 
                    }
                    echo "</td>";



                    // For the Friday column | Für die Spalte am Freitag | Pour la colonne Vendredi  
                    echo " <td>"; 
                    foreach($users as $user){
                        $userWeekdays = json_decode($user->weekdays); 

                        if(!empty($userWeekdays) && in_array('Friday', $userWeekdays) ){
                            if ($user-> group_id == $group-> id) { 
                                echo $user->name."</br>";
                            } 
                        }
                        $userWeekdays = null; 
                    }
                    echo "</td>";


                    echo " </tr>";
                }else{
                    echo "<tr><td>NON </td><tr>";  
                }
            }
        ?> 
    </tbody> 
    </tr>
    </table> 
    <br>
    <br>
</div>


